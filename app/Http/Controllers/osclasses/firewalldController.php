<?php

namespace App\Http\Controllers\osclasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\osclasses\IPcalc;
use App\Models\FirewallModel;
use App\Models\FirewallSDModel;
use App\Models\InterfaceModel;
use App\Models\HardwareInterfaceModel;
use App\Models\DefinitionModel;
use App\Models\FirewallPoliciesModel;


class firewalldController extends Controller
{

    public function ReloadFirewalld() {
      $command = 'sudo firewall-cmd --reload';
      $status = $this->ExecuteCommand($command);

      if($status["result"] == 0) {
        return true;
      }
      else {
        return false;
      }
    }

    //Gibt ein FirewallSD Model aufbereitet und Escaped zurück, fertig um auf die Shell gegeben zu werden.
    private function GetArgumentEscaped($model_query) {
      $is_interface = false;
      if($this->IsModelInterfaceOrDefinition($model_query, 1)) {
        $model_query_db = InterfaceModel::findOrFail($model_query["interface_id"]);
        $is_interface = true;
      }
      elseif($this->IsModelInterfaceOrDefinition($model_query, 0)) {
        $model_query_db = DefinitionModel::findOrFail($model_query["definition_id"]);
      }

      $cidr = $model_query_db->ipblock1 . '.' . $model_query_db->ipblock2 . '.' . $model_query_db->ipblock3 . '.' . $model_query_db->ipblock4 . '/' . $model_query_db->subnetmask;
      //Netzadresse für Interface berechnen
      if($model_query_db->subnetmask != '32' && $is_interface == true) {
        $ipcalc = new IPcalc($cidr);
        $to_escape = $ipcalc->getNetwork() . '/' . $model_query_db->subnetmask;
      }
      else {
        $to_escape = $cidr;
      }
      return escapeshellarg($to_escape);
    }

    //Prüft ob FirewallSD Model Interface oder Definition ist.
    private function IsModelInterfaceOrDefinition($model_query, $mode) {
      //$mode = 1 -> isInterface?
      //$mode = 0 -> isDefinition?
      $model_query = $model_query->toArray();
      if($mode == 0) {
        if(is_null($model_query['interface_id']) && is_null($model_query['definition_id']) == FALSE) {
          return true;
        }
        else {
          return false;
        }
      }
      if($mode == 1) {
        if(is_null($model_query['definition_id']) && is_null($model_query['interface_id']) == FALSE) {
          return true;
        }
        else {
          return false;
        }
      }
    }

    private function ExecuteCommand($command) {
      $output = array();
      $result = 0;
      $command = $command . ' 2>&1';

      exec($command, $output, $result);

      return array('output' => $output, 'result' => $result);
    }

    public function AddRule($id, $mode) {
      //$mode = 0 -> Add Rules
      //$mode = 1 -> Remove Rule
      //Get Rule and networks for rule
      if($mode == 0) {
        $action = '--add-rich-rule=';
      }
      else if($mode == 1) {
        $action = '--remove-rich-rule=';
      }
      else {
        return false;
      }

      $ruledb = FirewallModel::findOrFail($id);
      $firewallSDdb = FirewallSDModel::where('firewallrule_id', $ruledb->id)->get();

      //Source und Destination getrennt laden
      $SD_source = FirewallSDModel::where('firewallrule_id', $ruledb->id)->where('source', 1)->first();
      $SD_source = $SD_source->toArray();
      $SD_destination = FirewallSDModel::where('firewallrule_id', $ruledb->id)->where('source', 1)->first();
      $SD_destination = $SD_destination->toArray();
      //Protokoll setzen
      if($ruledb->tcp == 1) {
        $protokoll = 'tcp';
      }
      else if($ruledb->tcp == 0) {
        $protokoll = 'udp';
      }

      //Prüfen ob SD verfügbar
      if(is_null($SD_destination) == false && is_null($SD_source) == false) {
        //Schleife für alle source Networks
        foreach($firewallSDdb->where('source', 1) as $source) {

          //Shell Escape für Netzwerk ausführen
          $source_escaped = $this->GetArgumentEscaped($source);
          //Schleife für destination Networks

          foreach($firewallSDdb->where('source', 0) as $destination) {
            //Shell Escape für Netzwerk ausführen
            $destination_escaped = $this->GetArgumentEscaped($destination);
            //Befehl zusammensetzen
            $target = $this->CalcTarget($source, $destination);

            //Prüfen ob ANY Konstante vorhanden ist
            $anyVorhanden = false;
            if($source_escaped == "'0.0.0.0/0'") {
              $anyVorhanden = 'source';
            }
            elseif($destination_escaped == "'0.0.0.0/0'") {
              $anyVorhanden = 'destination';
            }

            if(is_numeric($ruledb->port)) {
              if(is_numeric($ruledb->port_end) && $ruledb->port_end > 0) {
                $port = $ruledb->port . '-' . $ruledb->port_end;
              }
              else {
                $port = $ruledb->port;
              }
            }
            else {
              return false;
            }

            if($anyVorhanden == false && $target != false) {
              $command = "sudo firewall-cmd " . $target . " " . $action . "'rule family=ipv4 destination address=". $destination_escaped ." source address=". $source_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }
            elseif($anyVorhanden == 'destination' && $target != false) {
              $command = "sudo firewall-cmd " . $target . " " . $action . "'rule family=ipv4 source address=". $source_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }
            elseif($anyVorhanden == 'source' && $target != false) {
              $command = "sudo firewall-cmd ". $target . " " . $action . "'rule family=ipv4 destination address=". $destination_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }

            elseif($anyVorhanden == false && $target == 'default') {
              $command = "sudo firewall-cmd ". $action . "'rule family=ipv4 destination address=". $destination_escaped ." source address=". $source_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }
            elseif($anyVorhanden == 'destination' && $target == 'default') {
              $command = "sudo firewall-cmd ". $action . "'rule family=ipv4 source address=". $source_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }
            elseif($anyVorhanden == 'source' && $target == 'default') {
              $command = "sudo firewall-cmd ". $action . "'rule family=ipv4 destination address=". $destination_escaped ." port port=".$port." protocol=".$protokoll." accept' --permanent";
            }

            //Befehl ausführen und abbrechen wenn Ergebnis nicht gleich 0
            $result = $this->ExecuteCommand($command);
            $ruledb->end_status = $result['result'];
            $ruledb->save();

            if($result['result'] != 0) {
              return false;
            }
          }
        }
      }
    }


      //Löscht alle Regeln
      public function FlushRuleSet() {
        $rules = FirewallModel::where('status', 1)->get();
        $del_failure = false;

        //Regeln entfernen
        foreach($rules as $rule) {
          if($this->AddRule($rule->id, 1) == false) {
            $del_failure = true;
          }
        }
        //Firewalld neu laden
        if($this->ReloadFirewalld() == false) {
          return false;
        }
        if($del_failure == true) {
          return false;
        }
        else {
          return true;
        }
      }


      //Löscht alle Regeln
      public function CreateRuleSet() {
        $rules = FirewallModel::where('status', 1)->get();
        $add_failure = false;

        //Regeln hinzufügen
        foreach($rules as $rule) {
          if($this->AddRule($rule->id, 0) == false) {
            $add_failure = true;
          }
        }
        //Firewalld neu laden
        if($this->ReloadFirewalld() == false) {
          return false;
        }
        if($add_failure == true) {
          return false;
        }
        else {
          return true;
        }
      }


        public function AddZoneForInterface($id) {
          $interface = InterfaceModel::findOrFail($id);
          $hardwareinterfacedb = HardwareInterfaceModel::findOrFail($interface->hardwareinterface_id);

          $command = "sudo firewall-cmd --new-zone=hw". $interface->id ." --permanent";
          $command_add = "sudo firewall-cmd --zone=hw". $interface->id ." --change-interface=" . $hardwareinterfacedb->bezeichnung . "-" . $interface->id;

          $status = $this->ExecuteCommand($command);
          $status_reload = $this->ReloadFirewalld();
          $status_add = $this->ExecuteCommand($command_add);

          if($status == true && $status_reload == true && $status_add == true) {
            return true;
          }
          else {
            return false;
          }
        }

        public function DeleteZoneForInterface($id) {
          $interface = InterfaceModel::findOrFail($id);
          if(is_numeric($id)) {
            $id_escaped = "hw".$id;
          }
          else {
            return false;
          }
          $command = "sudo firewall-cmd --permanent --delete-zone=".$id_escaped;

          $status = $this->ExecuteCommand($command);
          if($status["result"] == 0) {
            return true;
          }
          else {
            return false;
          }
        }

        private function CalcTarget($source, $destination) {

          $zoneid = false;
          $policy = false;
          $return_value = false;

          $interfaces = InterfaceModel::all();

          //Bestimme ob Source Interface oder Defintion
          $is_source_interface = $this->IsModelInterfaceOrDefinition($source, 1);
          //Bestimme ob Destination Interface oder Defintion
          $is_destination_interface = $this->IsModelInterfaceOrDefinition($destination, 1);

          $source_escaped = $this->GetArgumentEscaped($source);
          $destination_escaped = $this->GetArgumentEscaped($destination);
          $source_escaped = str_replace("'", '', $source_escaped);
          $destination_escaped = str_replace("'", '', $destination_escaped);

          //Fall unterscheidung:

          //1. Source und Destination = Interface --> Policy
          if($is_source_interface && $is_destination_interface) {
            $policy = $this->GetPolicy($source->interface_id, $destination->interface_id);
          }
          //2. Source = Interface, Destination = Definition
          else if($is_source_interface && $is_destination_interface == false) {
            //--> Prüfe ob Defintion in Interface Range
            $in_interface = $this->CheckDefinitionInInterfaces($interfaces, $destination_escaped);

            //nicht in Interfaces --> Policy
            if($in_interface == false) {
              $policy = $this->GetPolicy($source->interface_id, 'public');
            }
            //in Interfaces --> Policy
            if(is_numeric($in_interface) && $in_interface > 0) {
              $policy = $this->GetPolicy($source->interface_id, $in_interface);
            }
          }
          //3. Source = Definition, Destination = Interface
          else if($is_source_interface == false && $is_destination_interface) {
            $in_interface = $this->CheckDefinitionInInterfaces($interfaces, $source_escaped);
            //in Interfaces --> Policy
            if(is_numeric($in_interface) && $in_interface > 0) {
              if($in_interface == $destination->interface_id) {
                $zoneid = $destination->interface_id;
              }
              else {
                $policy = $this->GetPolicy($in_interface, $destination->interface_id);
              }
            }
            if($in_interface == false) {
              $zoneid = $destination->interface_id;
            }
          }
          //4. Source = Defintion, Destination = Definition
          else if($is_source_interface == false && $is_destination_interface == false) {
            //Prüfe ob Source und oder Destination in Interfaces vorkommen
            $source_in_interface = $this->CheckDefinitionInInterfaces($interfaces, $source_escaped);
            $destination_in_interface = $this->CheckDefinitionInInterfaces($interfaces, $destination_escaped);

            //Source in Interface, Destination in interface --> Policy
            if(is_numeric($source_in_interface) && is_numeric($destination_in_interface)) {
              $policy = $this->GetPolicy($source_in_interface, $destination_in_interface);
            }
            //Source in Interface, Destination nicht
            elseif(is_numeric($source_in_interface) && is_numeric($destination_in_interface) == false) {
              $policy = $this->GetPolicy($source_in_interface, 'public');
            }
            //Source nicht, Destination in interface
            elseif(is_numeric($source_in_interface) == false && is_numeric($destination_in_interface)) {
              $in_interface = InterfaceModel::findOrFail($destination_in_interface);
              $zoneid = $in_interface->id;
            }
            //Destination nicht, Source nicht
            elseif(is_numeric($source_in_interface) == false && is_numeric($destination_in_interface) == false) {
              $zoneid = 'default';
            }
          }

          //Zuordnung -->Zone oder Policy?
          if($policy == true && $zoneid == false) {
            if(isset($policy->to_public) && $policy->to_public != 0) {
              $return_value = '--policy=hw'.$policy->ingress.'ZUpublic';
            }
            else {
              $return_value = '--policy=hw'.$policy->ingress.'ZUhw'.$policy->egress;
            }
          }
          else if($policy == false && $zoneid == true) {
            $return_value = '--zone=hw'.$zoneid;
          }
          else if($policy == false && $zoneid == 'default') {
            $return_value = 'default';
          }
          return $return_value;
        }

      private function CheckDefinitionInInterfaces($interfaces, $to_check) {
        $found = false;
        //Definition normalisieren:
        $to_check_normalized = substr($to_check, 0, strpos($to_check, "/"));
        $to_check_normalized_long = ip2long($to_check_normalized);

        //Durch Interfaces Iterieren:
        foreach($interfaces as $interface) {
          $interface_cidr = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . '/' . $interface->subnetmask;
          $interface_cidr = new IPcalc($interface_cidr);
          $max_long = ip2long($interface_cidr->getHostMax());
          $min_long = ip2long($interface_cidr->getHostMin());

          if($to_check_normalized_long <= $max_long && $to_check_normalized_long >= $min_long) {
            $found = $interface->id;
            break;
          }
        }
        return $found;
      }

      private function GetPolicy($ingress, $egress) {
        $search = false;
        if(is_numeric($ingress) && is_numeric($egress)) {
          $search = FirewallPoliciesModel::where('ingress', $ingress)->where('egress', $egress)->first();
        }
        else if(is_numeric($ingress) && $egress == 'public') {
          $search = FirewallPoliciesModel::where('ingress', $ingress)->where('to_public', 1)->first();
        }
        if(isset($search->id) == false) {
          $id = $this->CreatePolicy($ingress, $egress);
          $search = FirewallPoliciesModel::findOrFail($id);
        }
        return $search;
      }

      private function CreatePolicy($ingress, $egress) {
        if(is_numeric($ingress) && is_numeric($egress) || is_numeric($ingress) && $egress == 'public') {
          if(is_numeric($ingress) && is_numeric($egress)) {
            $policyname = escapeshellarg('hw'.$ingress.'ZUhw'.$egress);
            $egressname = 'hw' . $egress;
            $data = array(
              'ingress' => $ingress,
              'egress' => $egress,
              'to_public' => 0,
            );
          }
          else if(is_numeric($ingress) && $egress == 'public') {
            $policyname = escapeshellarg('hw'.$ingress.'ZUpublic');
            $egressname = 'public';
            $data = array(
              'ingress' => $ingress,
              'to_public' => 1,
            );
          }


          $command = 'sudo firewall-cmd --permanent --new-policy ' . $policyname;
          $status = $this->ExecuteCommand($command);

          $command = 'sudo firewall-cmd --permanent --policy ' . $policyname . ' --add-ingress-zone hw' . $ingress;
          $status = $this->ExecuteCommand($command);

          $command = 'sudo firewall-cmd --permanent --policy ' . $policyname . ' --add-egress-zone ' . $egressname;
          $status = $this->ExecuteCommand($command);

          $command = "sudo firewall-cmd --permanent --policy=" . $policyname . " --add-rich-rule='rule family=ipv4 icmp-type name=echo-request accept'";
          $status = $this->ExecuteCommand($command);


          $id = new FirewallPoliciesModel($data);
          $id->save();

          return $id->id;
        }
      }





}
