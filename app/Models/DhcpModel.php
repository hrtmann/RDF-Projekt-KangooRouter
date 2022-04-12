<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhcpModel extends Model
{
    use HasFactory;

    protected $fillable = ['bezeichnung', 'ipblock1Start', 'ipblock2Start', 'ipblock3Start', 'ipblock4Start', 'ipblock1End', 'ipblock2End', 'ipblock3End', 'ipblock4End', 'dns1', 'dns2', 'interface_id', 'status'];
}
