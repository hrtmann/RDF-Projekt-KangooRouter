<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirewallModel;
use App\Models\FirewallSDModel;
use App\Models\DefinitionModel;
use App\Models\InterfaceModel;

use App\Http\Controllers\osclasses\firewalldController;

class FirewallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fwrules = FirewallModel::all();
        $definitions = DefinitionModel::all();
        $interfaces =  InterfaceModel::all();
        $setobjectssource = FirewallSDModel::where('source', '1')->get();
        $setobjectsdest = FirewallSDModel::where('source', '0')->get();

      // $f = new firewalldController();
      //  $f->AddRule(30,0);

        return view('firewalls.index', compact('fwrules', 'setobjectssource', 'setobjectsdest', 'definitions', 'interfaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $definitions = DefinitionModel::all();
      $interfaces =  InterfaceModel::all();

      return view('firewalls.create', compact('definitions', 'interfaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'port' => 'required|string|max:255',
          'tcp' => 'required|boolean',
        ]);

        try{
          if(str_contains($data['port'], '-'))
          {
            $portexplode = explode('-', $data['port']);
            //unset($data['port']);
            if($portexplode[0]<$portexplode[1])
            {
              $data['port'] = (int)$portexplode[0];
              $data['port_end'] = (int)$portexplode[1];
            }
            else {
              $data['port'] = (int)$portexplode[1];
              $data['port_end'] = (int)$portexplode[0];
            }
          }
          else {
              $data['port'] = (int)$data['port'];
              $data['port_end'] = NULL;
          }
        }
        catch(Exception $e)
        {
          return redirect('/firewallrules')->withErrors(['msg' => 'Ung??ltige Port Range']);
        }

        $fwrule = new FirewallModel($data);
        $fwrule->save();

        $id = $fwrule->id;

        FirewallModel::whereId($id)->update($data);

        //Firewall SD Model bef??llen
        $allSD = FirewallSDModel::where('firewallrule_id', $id)->get();
        //Durchgang f??r Source und Destination
        for($i = 0; $i < 2; $i++) {
          $recordInUse = array();
          switch ($i) {
            case 0:
              $artmain = 'destination';
              break;
            case 1:
              $artmain = 'source';
              break;
            }
          //Pr??fen ob ??berhaupt eintr??ge ??bergeben werden
          if(is_null($request->$artmain) == false) {
            foreach($request->$artmain as $forart) {
              //Pr??fen ob Defintion oder Schnitstelle
              $art = $forart[0];
              $forart = substr($forart, 1);
              if($art == 'd') {
                $column = 'definition_id';
              }
              elseif($art == 'i') {
                $column = 'interface_id';
              }
              //Pr??fen ob Datensatz existiert, falls nicht anlegen
              if($allSD->where($column, $forart)->where('source', $i)->count() == 0) {
                $data = array(
                  'firewallrule_id' => $id,
                  $column => $forart,
                  'source' => $i,
                );
                $sddata = new FirewallSDModel($data);
                $sddata->save();
              }
              //Array mit genutzen ID's bef??llen
              if($allSD->where($column, $forart)->where('source', $i)->count() > 0) {
                $recordInUse[] = $allSD->where($column, $forart)->where('source', $i)->first()->id;
              }
            }
          }
          //FirewallSD Model alte Eintr??ge entfernen
          //Dazu Array mit genutzen ID's pr??fen
          foreach($allSD->where('source', $i) as $sd) {
            if(in_array($sd->id, $recordInUse) == false) {
              $sdquery = FirewallSDModel::findOrFail($sd->id);
              $sdquery->delete();
            }
          }
        }

        return redirect('/firewallrules')->with('success', 'Regel erfolgreich angelegt!');
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
        $fwrule = FirewallModel::findOrFail($id);
        $definitions = DefinitionModel::all();
        $interfaces =  InterfaceModel::all();
        $setobjectssource = FirewallSDModel::where('firewallrule_id', $id)->where('source', '1')->get();
        $setobjectsdest = FirewallSDModel::where('firewallrule_id', $id)->where('source', '0')->get();

        return view('firewalls.edit', compact('fwrule', 'definitions', 'interfaces', 'setobjectssource', 'setobjectsdest'));
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

        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'port' => 'required|string|max:255',
          'tcp' => 'required|boolean'
        ]);

        try{
          if(str_contains($data['port'], '-'))
          {
            $portexplode = explode('-', $data['port']);
            //unset($data['port']);
            if($portexplode[0]<$portexplode[1])
            {
              $data['port'] = (int)$portexplode[0];
              $data['port_end'] = (int)$portexplode[1];
            }
            else {
              $data['port'] = (int)$portexplode[1];
              $data['port_end'] = (int)$portexplode[0];
            }
          }
          else {
              $data['port'] = (int)$data['port'];
              $data['port_end'] = NULL;
          }
        }
        catch(Exception $e)
        {
          return redirect('/firewallrules')->withErrors(['msg' => 'Ung??ltige Port Range']);
        }

        //Firewall Regeln entfernen
        $firewalld = new firewalldController();
        $firewalld->FlushRuleSet();

        FirewallModel::whereId($id)->update($data);

        //Firewall SD Model bef??llen
        $allSD = FirewallSDModel::where('firewallrule_id', $id)->get();
        //Durchgang f??r Source und Destination
        for($i = 0; $i < 2; $i++) {
          $recordInUse = array();
          switch ($i) {
            case 0:
              $artmain = 'destination';
              break;
            case 1:
              $artmain = 'source';
              break;
            }
          //Pr??fen ob ??berhaupt eintr??ge ??bergeben werden
          if(is_null($request->$artmain) == false) {
            foreach($request->$artmain as $forart) {
              //Pr??fen ob Defintion oder Schnitstelle
              $art = $forart[0];
              $forart = substr($forart, 1);
              if($art == 'd') {
                $column = 'definition_id';
              }
              elseif($art == 'i') {
                $column = 'interface_id';
              }
              //Pr??fen ob Datensatz existiert, falls nicht anlegen
              if($allSD->where($column, $forart)->where('source', $i)->count() == 0) {
                $data = array(
                  'firewallrule_id' => $id,
                  $column => $forart,
                  'source' => $i,
                );

                $sddata = new FirewallSDModel($data);
                $sddata->save();
              }
              //Array mit genutzen ID's bef??llen
              if($allSD->where($column, $forart)->where('source', $i)->count() > 0) {
                //Pr??ft ob anlegen erfolgreich war und schreibt ID in Array
                $recordInUse[] = $allSD->where($column, $forart)->where('source', $i)->first()->id;
              }
            }
          }
          //FirewallSD Model alte Eintr??ge entfernen
          //Dazu Array mit genutzen ID's pr??fen
          foreach($allSD->where('source', $i) as $sd) {
            if(in_array($sd->id, $recordInUse) == false) {
              $sdquery = FirewallSDModel::findOrFail($sd->id);
              $sdquery->delete();
            }
          }
        }

        $firewalld->CreateRuleSet();

        return redirect('/firewallrules')->with('success', 'Regel erfolgreich ge??ndert!');
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


        $firewallSD = FirewallSDModel::where('firewallrule_id', $id)->get();

        $firewalld = new firewalldController();
        $firewalld->FlushRuleSet();

        foreach($firewallSD as $SD) {
          $SD->delete();
        }

        $firewall = FirewallModel::findOrFail($id);
        $firewall->delete();

        $firewalld->CreateRuleSet();

        return redirect('/firewallrules')->with('success', 'Regel erfolgreich gel??scht!');
    }


    public function changeStatus(Request $request){
      $fwrules = FirewallModel::find($request->firewall_id);
      $fwrules->status = $request->status;
      $fwrules->save();

      $fw = FirewallModel::findOrFail($fwrules->id);
      if($fw->status == 0) {
        $firewalld = new firewalldController();
        $firewalld->AddRule($fw->id, 1);
        $firewalld->ReloadFirewalld();
      }
      else if($fw->status == 1) {
        $firewalld = new firewalldController();
        $firewalld->AddRule($fw->id, 0);
        $firewalld->ReloadFirewalld();
      }

    }
}
