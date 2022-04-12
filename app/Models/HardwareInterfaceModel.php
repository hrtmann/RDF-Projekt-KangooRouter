<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareInterfaceModel extends Model
{
    use HasFactory;

    protected $fillable = ['macaddr', 'bezeichnung'];

    public function InterfacesModel() {
      return $this->hasMany('\App\Model\InterfaceModel');
    }
}
