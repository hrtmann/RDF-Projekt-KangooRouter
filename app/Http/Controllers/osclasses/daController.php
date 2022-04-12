<?php

namespace App\Http\Controllers\osclasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class daController extends Controller
{
	//Führt Befehl auf der Shell aus
  private function ExecuteCommand($command) {
      $output = array();
      $result = 0;
      exec($command, $output, $result);

      return array('output' => $output, 'result' => $result);
  }

  /*function getCpuUsage()
  {
    $result = $this->ExecuteCommand("mpstat | awk '{print $12}' | tail -n 1");
    $output = $result['output'];
    $firstOutput = 100 - floatval($output[0]);
    if($result['output'] != 0 ){
      return [$firstOutput];
    }

  }*/

  /*
  function getRamUsage()
  {
      $result = $this->ExecuteCommand("free -t | awk 'NR == 2 {print $3/$2*100}'");
      $test = $result['output'];
      $returnValue = floatval($test[0]);
      //$output = $result['output'];
      //$firstOutput = 100 - floatval($output[0]);
      if($result['output'] != 0 ){
        return [$returnValue];
      }
  }
  */

  function getAjaxData()
  {
    //CPU
    $resultCpu = $this->ExecuteCommand("mpstat | awk '{print $12}' | tail -n 1");
    $outputCpu = $resultCpu['output'];
    $valCpu = 100 - floatval($outputCpu[0]);

    //RAM
    $resultRam = $this->ExecuteCommand("free -t | awk 'NR == 2 {print $3/$2*100}'");
    $outputRam = $resultRam['output'];
    $valRam = floatval($outputRam[0]);

    //Netzwerkschnittstellen
    $resultNet = $this->ExecuteCommand("nmcli --field NAME,DEVICE connection | tail -n +2");
    $outputNet = $resultNet['output'];
    $netArray = array();
    foreach($outputNet as $net)
    {
      $netArray[] = preg_split('/\s+/', $net);
    }

    $y = 0;
    //Durchsatz
    foreach($netArray as $net)
    {
      if($net[1] != "--")
      {
        $resultDurchsatz = $this->ExecuteCommand("sudo ifconfig -a " . $net[1] . " |awk '{print $6 \" \" $7}' | grep B | head -2");
        $outDurchsatz = $resultDurchsatz['output'];
        $netArray[$y][2] = $outDurchsatz[0];
        $netArray[$y][3] = $outDurchsatz[1];

      }
      else {
        $netArray[$y][2] = "";
        $netArray[$y][3] = "";
      }
      $y = $y + 1;
    }

    //Dienste
    $resultServices =  $this->ExecuteCommand("systemctl --type=service | awk '{ print $1, $3, $4}' | tail -n +2 | head -n -7");
    $outputServices = $resultServices['output'];
    $i = 0;
    $valServices;
    foreach ($outputServices as $service) {
      $valServices[$i] = explode(" ", $service);
      $i = $i + 1;
    }

    //Pakete
    $resultPackets = $this->ExecuteCommand("dmesg | grep 'DROP\|REJECT' | tail -n 50");
    $outPackets = $resultPackets['output'];
    if(empty($outPackets))
    {
      $valPackets = false;
    }
    else {
      $i = 0;
      foreach ($outPackets as $packets) {
        $valPackets[$i] = preg_split('/\r\n|\r|\n/', $packets);
        //$valPackets[$i] = explode("PHP_EOL", $packets);
        $i = $i + 1;
      }
    }

    //Zeit
    $resultTime = $this->ExecuteCommand("uptime -s");
    $outTime = $resultTime['output'];
    //$valPackets = $outPackets[0];
    //$valPackets = count($outPackets);
    //$valPackets = gettype($outPackets);
    //$valServices = $outputServices['output'];
    //$valServices = $outputServices[0];


    //ÜbergabeArray
    $returnData = array($valCpu, $valRam, $netArray, $valServices, $outPackets, $outTime);

    if($resultCpu['output'] != 0 ){
      return $returnData;
    }

  }


}
