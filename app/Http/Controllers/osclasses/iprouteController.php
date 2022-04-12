<?php

namespace App\Http\Controllers\osclasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DefinitionModel;
use App\Models\RoutingModel;

class iprouteController extends Controller
{
  private function ExecuteCommand($command) {
    $output = array();
    $result = 0;
    $command = $command . ' 2>&1';
    exec($command, $output, $result);

    return array('output' => $output, 'result' => $result);
  }

  public function CreateRoute($id) {
    $route = RoutingModel::findOrFail($id);
    $target = DefinitionModel::findOrFail($route->target);
    $next_hop = DefinitionModel::findOrFail($route->next_hop);

    $target_net = $target->ipblock1 . '.' . $target->ipblock2 . '.' . $target->ipblock3 . '.' . $target->ipblock4 . '/' . $target->subnetmask;
    $next_hop_addr = $next_hop->ipblock1 . '.' . $next_hop->ipblock2 . '.' . $next_hop->ipblock3 . '.' . $next_hop->ipblock4;

    $command = 'sudo ip route add ' . $target_net . ' via ' . $next_hop_addr;

    $result = $this->ExecuteCommand($command);
    $route->end_status = $result['result'];
    $route->save();

    if($result['result'] != 0) {
      session(['error_kr' => $result['output']]);
      return false;
    }
    else {
      return true;
    }
  }


  public function DelRoute($id) {
    $route = RoutingModel::findOrFail($id);
    $target = DefinitionModel::findOrFail($route->target);
    $next_hop = DefinitionModel::findOrFail($route->next_hop);

    $target_net = $target->ipblock1 . '.' . $target->ipblock2 . '.' . $target->ipblock3 . '.' . $target->ipblock4 . '/' . $target->subnetmask;
    $next_hop_addr = $next_hop->ipblock1 . '.' . $next_hop->ipblock2 . '.' . $next_hop->ipblock3 . '.' . $next_hop->ipblock4;

    $command = 'sudo ip route del ' . $target_net . ' via ' . $next_hop_addr;

    $result = $this->ExecuteCommand($command);
    $route->end_status = $result['result'];
    $route->save();

    if($result['result'] != 0) {
      session(['error_kr' => $result['output']]);
      return false;
    }
    else {
      return true;
    }
  }



}
