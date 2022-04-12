<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterfaceModel extends Model
{
    use HasFactory;

    protected $fillable = ['bezeichnung', 'ipblock1', 'ipblock2', 'ipblock3', 'ipblock4', 'subnetmask', 'vlan', 'macaddr', 'hardwareinterface_id', 'status', 'end_status'];

    public function HardwareInterface() {
      return $this->belongsTo('App\Models\HardwareInterfaceModel');
    }

}
