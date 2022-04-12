<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirewallModel extends Model
{
    use HasFactory;

    protected $fillable = ['bezeichnung', 'port', 'port_end', 'status', 'end_status'];
}
