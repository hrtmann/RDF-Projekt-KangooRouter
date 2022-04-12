<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutingModel extends Model
{
    use HasFactory;

    protected $fillable = ['bezeichnung', 'next_hop', 'target', 'status', 'end_status'];

    public function Definition() {
      return $this->belongsTo('App\Models\DefinitionModel');
    }
}
