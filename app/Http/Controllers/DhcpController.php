<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DhcpModel;
use App\Models\InterfaceModel;

use App\Http\Controllers\osclasses\IPcalc;


class DhcpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $dhcp = DhcpModel::all();
      $interfaces = InterfaceModel::all()->toArray();

      return view('dhcp.index', compact('dhcp', 'interfaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dhcp = DhcpModel::all();
        $interfaces =  InterfaceModel::all();

        return view('dhcp.create', compact('dhcp', 'interfaces'));
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
          'startRange' => 'required|integer|between:0,254',
          'endRange' => 'required|integer|between:0,254',
          'dns1' => 'required|string|max:255',
          'dns2' => 'required|string|max:255',
          'interface_id' => 'required|integer'
        ]);

        $interface = InterfaceModel::findOrFail($data['interface_id']);

        //Check IP
        $ip = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4 . '/' . $interface->subnetmask;
        $ipWithoutCidr = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4;

        $sub= new Ipcalc(
          $ip
        );

        //IpRangeStart from view
        $IpDhcpMin =  $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $data['startRange'];
        $IpDhcpMax =  $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $data['endRange'];

        $IpDhcpMinInt = ip2long($IpDhcpMin);
        $IpDhcpMaxInt = ip2long($IpDhcpMax);

        $network = $sub->getNetwork();
        $broadcast = $sub->getBroadcast();

        $ipBroadcastInt = ip2long($broadcast);
        $ipNetworkInt = ip2long($network);

        //Check if InterfaceID in Range
        if($IpDhcpMinInt > $ipNetworkInt && $IpDhcpMaxInt < $ipBroadcastInt){
          $dhcp = new DhcpModel($data);
          $dhcp->save();

          return redirect('/dhcp')->with('success', 'DHCP erfolgreich angelegt!');
        }else {
          return redirect('/dhcp')->withErrors(['msg' => 'DHCP Ungültig']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
        $dhcp = DhcpModel::findOrFail($id);
        $interface_id = $dhcp['interface_id'];
        $interfaces = InterfaceModel::all()->toArray();
        $interface = InterfaceModel::findOrFail($interface_id);

        $ip = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4 . '/' . $interface->subnetmask;
        $ipWithoutCidr = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4;
        $cidr = $interface->subnetmask;

        $sub= new Ipcalc(
          $ip
        );

      //  $startRange = $sub->getHostMin();
      //  $endRange = $sub->getHostMax();
        $network = $sub->getNetwork();
        $broadcast = $sub->getBroadcast();

        $ipexplodeStartRange = explode('.', $startRange = $sub->getHostMin());
        $ipexplodeEndRange = explode('.', $endRange = $sub->getHostMax());

        //Convert IP addresses to int
        $ipInterfaceInt = ip2long($ipWithoutCidr);
        $ipStartRangeInt = ip2long($startRange);
        $ipEndRangeInt = ip2long($endRange);


        //Getting Last Number of IP
        $ipexplodeMin = explode('.', $startRange);
        $addStart = $ipexplodeMin['3'];
        $ipexplodeMax = explode('.', $endRange);
        $addEnd = $ipexplodeMax['3'];
        $availableAddresses = $addEnd - $addStart - 2;

        $addressInformation = array(
            "startRange" => $addStart,
            "endRange" => $addEnd,
            "netAddress" => $network,
            "broadcastAddress" => $broadcast,
            "availableAddresses" => $availableAddresses,
            "cidr" => $cidr
          );

          //dd($ipexplodeStartRange, $ipexplodeEndRange, $ip);

        return view( 'dhcp.edit', compact('dhcp', 'interfaces', 'addressInformation', 'interface', 'ipexplodeStartRange', 'ipexplodeEndRange'));
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
    //  dd($id);
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'ipblock1Start' => 'required|integer|between:0,254',
          'ipblock2Start' => 'required|integer|between:0,254',
          'ipblock3Start' => 'required|integer|between:0,254',
          'ipblock4Start' => 'required|integer|between:0,254',
          'ipblock1End' => 'required|integer|between:0,254',
          'ipblock2End' => 'required|integer|between:0,254',
          'ipblock3End' => 'required|integer|between:0,254',
          'ipblock4End' => 'required|integer|between:0,254',
          'dns1' => 'required|string|max:255',
          'dns2' => 'required|string|max:255',
          'interface_id' => 'required|integer'
        ]);

      //  dd($data);


        $interface = InterfaceModel::findOrFail($data['interface_id']);

        //Check IP
        $ipInterface = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4 . '/' . $interface->subnetmask;
        $ipWithoutCidrInterface = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3. '.' . $interface->ipblock4;

        $sub = new Ipcalc(
          $ipInterface
        );

        //IpRangeStart from view
        $IpDhcpMin =  $data['ipblock1Start'] . '.' . $data['ipblock2Start'] . '.' . $data['ipblock3Start'] . '.' . $data['ipblock4Start'];
        $IpDhcpMax =  $data['ipblock1End'] . '.' . $data['ipblock2End'] . '.' . $data['ipblock3End'] . '.' . $data['ipblock4End'];

        $IpDhcpMinInterface = $sub -> getHostMin();
        $IpDhcpMaxInterface = $sub -> getHostMax();

        //dd($sub);

        $IpDhcpInterfaceInt = ip2long($ipWithoutCidrInterface);
        $IpDhcpMinInterfaceInt = ip2long($IpDhcpMinInterface);
        $IpDhcpMaxInterfaceInt = ip2long($IpDhcpMaxInterface);

    //    dd($IpDhcpInterfaceInt, $IpDhcpMinInterfaceInt, $IpDhcpMaxInterfaceInt);

        $IpDhcpMinInt = ip2long($IpDhcpMin);
        $IpDhcpMaxInt = ip2long($IpDhcpMax);

      //  dd($IpDhcpMinIntInterface, $IpDhcpMaxIntInterface);

        $network = $sub->getNetwork();
        $broadcast = $sub->getBroadcast();

        $ipBroadcastInt = ip2long($broadcast);
        $ipNetworkInt = ip2long($network);

          if($IpDhcpMinInt > $IpDhcpMinInterfaceInt && $IpDhcpMaxInt < $IpDhcpMaxInterfaceInt){
           DhcpModel::whereId($id)->update($data);

          return redirect('/dhcp')->with('success', 'DHCP erfolgreich angelegt!');
          }else {
           return redirect('/dhcp')->withErrors(['msg' => 'DHCP Ungültig']);
          }


        //Check if InterfaceID in Range

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
        $dhcp = DhcpModel::findOrFail($id);
        $dhcp->delete();

        return redirect('/dhcp')->with('success', 'DHCP erfolgreich gelöscht!');
    }
    public function changeStatus(Request $request){
      $dhcp = DhcpModel::find($request->dhcp_id);
      $dhcp->status = $request->status;
      $dhcp->save();
    }
}
