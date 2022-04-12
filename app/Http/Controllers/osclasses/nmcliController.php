<?php

namespace App\Http\Controllers\osclasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InterfaceModel;
use App\Models\HardwareInterfaceModel;

class nmcliController extends Controller
{
  	//Führt Befehl auf der Shell aus
    private function ExecuteCommand($command) {
      $output = array();
      $result = 0;
      $command = $command . ' 2>&1';
      exec($command, $output, $result);

      return array('output' => $output, 'result' => $result);
    }

    //Bereit Befehl zum hinzufügen einer Schnittstelle vor
    public function AddNetworkInterface($id) {
      $interfacedb = InterfaceModel::findOrFail($id);
      $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interfacedb->hardwareinterface_id);

      $ipaddr = $interfacedb->ipblock1 . '.' . $interfacedb->ipblock2 . '.' . $interfacedb->ipblock3 . '.' . $interfacedb->ipblock4;
      //$command = 'sudo nmcli con add con-name ' . escapeshellarg($hardwareinterfacedb->bezeichnung) . '-' . escapeshellarg($interfacedb->id) . ' type ethernet ifname ' . escapeshellarg($hardwareinterfacedb->bezeichnung) . ' ipv4.method manual ipv4.address ' . escapeshellarg($ipaddr) . '/' . escapeshellarg($interfacedb->subnetmask);
      $command = 'sudo nmcli con add type vlan con-name ' . escapeshellarg($hardwareinterfacedb->bezeichnung) . '-' . escapeshellarg($interfacedb->id) . ' dev ' . escapeshellarg($hardwareinterfacedb->bezeichnung) . ' id ' . $interfacedb->vlan .' ipv4.method manual ipv4.address ' . escapeshellarg($ipaddr) . '/' . escapeshellarg($interfacedb->subnetmask);

      $status = $this->ExecuteCommand($command);

      if($interfacedb->status == 0) {
        $this->DisableNetworkInterface($interfacedb->id);
      }

      return $status;
    }

    //Bereitet Befehl zum löschen einer Schnittstelle vor
    public function DeleteNetworkInterface($id) {
      $interfacedb = InterfaceModel::findOrFail($id);
      $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interfacedb->hardwareinterface_id);

      $argument = escapeshellarg($hardwareinterfacedb->bezeichnung) . '-' . escapeshellarg($interfacedb->id);
      $command = 'sudo nmcli con delete ' . $argument;

      return $this->ExecuteCommand($command);
    }

    //Funktion zum ändern einer Schnittstelle -> entfernen und wieder hinzufügen
    public function ChangeNetworkInterface($id) {
      $status = $this->DeleteNetworkInterface($id);
      if($status['result'] == 0) {
        return $this->AddNetworkInterface($id);
      }
      else {
        return $status;
      }
    }

    public function DisableNetworkInterface($id) {
      $interfacedb = InterfaceModel::findOrFail($id);
      $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interfacedb->hardwareinterface_id);

      $argument = escapeshellarg($hardwareinterfacedb->bezeichnung) . '-' . escapeshellarg($interfacedb->id);
      $command = 'sudo nmcli con down ' . $argument;

      $result = $this->ExecuteCommand($command);
      $interfacedb->end_status = $result['result'];
      $interfacedb->save();

      if($result['result'] != 0) {
        session(['error_kr' => $result['output']]);
        return false;
      }
      else {
        return true;
      }
    }

    public function EnableNetworkInterface($id) {
      $interfacedb = InterfaceModel::findOrFail($id);
      $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interfacedb->hardwareinterface_id);

      $argument = escapeshellarg($hardwareinterfacedb->bezeichnung) . '-' . escapeshellarg($interfacedb->id);
      $command = 'sudo nmcli con up ' . $argument;

      $result = $this->ExecuteCommand($command);
      $interfacedb->end_status = $result['result'];
      $interfacedb->save();

      if($result['result'] != 0) {
        session(['error_kr' => $result['output']]);
        return false;
      }
      else {
        return true;
      }
    }

    public function SetInterfaceZone($id) {
      $interfacedb = InterfaceModel::findOrFail($id);
      $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interfacedb->hardwareinterface_id);
      if(is_numeric($id)) {
        $id_escaped = "hw".$id;
      }
      else {
        return false;
      }

      $conname = $hardwareinterfacedb->bezeichnung . '-' . $interfacedb->id;
      $command = 'sudo nmcli connection modify '. $conname .' connection.zone ' . $id_escaped;

      return $this->ExecuteCommand($command);
    }

}
