<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefinitionModel extends Model
{
    protected $fillable = ['bezeichnung', 'ipblock1', 'ipblock2', 'ipblock3', 'ipblock4', 'subnetmask'];

    public function Definition(){
        return $this->belongsTo('App\Models\DefintionModel');
    }
}
