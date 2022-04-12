<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceModel;
use App\Models\HardwareInterfaceModel;
use App\Models\FirewallSDModel;

use App\Http\Controllers\osclasses\nmcliController;
use App\Http\Controllers\osclasses\firewalldController;

class InterfaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interfaces = InterfaceModel::all();
        //Beschreiben falls leer
        $hardwareinterfaces = array();

        foreach($interfaces as $interface) {
          $hardwareinterfaces[$interface->id] = HardwareInterfaceModel::findOrFail($interface->hardwareinterface_id)->toArray();
        }

        return view('interfaces.index', compact('interfaces', 'hardwareinterfaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hardwareinterfaces = HardwareInterfaceModel::all();

        return view('interfaces.create', compact('hardwareinterfaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Request validieren
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'IP' => 'required|ip',
          'subnetmask' => 'required|integer|between:8,32',
          'vlan' => 'required|integer|between:1,255',
          'hardwareinterface_id' => 'required|integer',
        ]);

        $mac = '';

        //IP Adresse in Blöcke zerlegen
        $ipexplode = explode('.', $data['IP']);

        unset($data['IP']);
        $data['ipblock1'] = $ipexplode[0];
        $data['ipblock2'] = $ipexplode[1];
        $data['ipblock3'] = $ipexplode[2];
        $data['ipblock4'] = $ipexplode[3];
        $data['macaddr'] = $mac;

        //Interface speichern
        $interface = new InterfaceModel($data);
        $interface->save();

        $nmcliController = new nmcliController();
        $nmcliController->AddNetworkInterface($interface->id);

        $firewalld = new firewalldController();
        $firewalld->AddZoneForInterface($interface->id);

        $nmcliController->SetInterfaceZone($interface->id);

        //Weiterleiten und Erfolgsmeldung ausgeben
        return redirect('/interfaces')->with('success', 'Schnittstelle erfolgreich angelegt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $interface = InterfaceModel::findOrFail($id);
        $hardwareinterfaces = HardwareInterfaceModel::all()->toArray();

        return view('interfaces.edit', compact('interface', 'hardwareinterfaces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'IP' => 'required|ip',
          'subnetmask' => 'required|integer|between:8,32',
          'vlan' => 'required|integer|between:1,255',
          'hardwareinterface_id' => 'required|integer',
        ]);

        $firewalld = new firewalldController();
        $firewalld->FlushRuleSet();

        $ipexplode = explode('.', $data['IP']);
        unset($data['IP']);
        $data['ipblock1'] = $ipexplode[0];
        $data['ipblock2'] = $ipexplode[1];
        $data['ipblock3'] = $ipexplode[2];
        $data['ipblock4'] = $ipexplode[3];
        $data['macaddr'] = 'placeholder';

        InterfaceModel::whereId($id)->update($data);

        $nmcliController = new nmcliController();
        $nmcliController->ChangeNetworkInterface($id);
        $nmcliController->SetInterfaceZone($id);

        $firewalld->CreateRuleSet();

        return redirect('/interfaces')->with('success', 'Schnittstelle erfolgreich geändert!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $firewalld = new firewalldController();
        $firewalld->FlushRuleSet();

        $nmcliController = new nmcliController();
        $deletestatus = $nmcliController->DeleteNetworkInterface($id);

        $firewallSD = FirewallSDModel::where('interface_id', $id);
        foreach($firewallSD as $SD) {
          $SD->delete();
        }

        $nmcliController = new nmcliController();
        $nmcliController->DeleteNetworkInterface($id);

        $firewalld = new firewalldController();
        $firewalld->DeleteZoneForInterface($id);

        $interface = InterfaceModel::findOrFail($id);
        $interface->delete();

        $firewalld->CreateRuleSet();


        return redirect('/interfaces')->with('success', 'Schnittstelle erfolgreich gelöscht!');
    }

    public function changeStatus(Request $request){
      $interfaces = InterfaceModel::find($request->interface_id);
      $interfaces->status = $request->status;
      $interfaces->save();

      $interface = InterfaceModel::findOrFail($interfaces->id);
      if($interface->status == 0) {
        $nmcliController = new nmcliController();
        $nmcliController->DisableNetworkInterface($interface->id);
      }
      else if($interface->status == 1) {
        $nmcliController = new nmcliController();
        $nmcliController->EnableNetworkInterface($interface->id);
      }

    }
}
