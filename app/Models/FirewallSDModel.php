<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirewallSDModel extends Model
{
    use HasFactory;

    protected $fillable = ['source', 'firewallrule_id', 'definition_id', 'interface_id'];

    public function FirewallRule() {
      return $this->belongsTo('App\Models\FirewallModel');
    }

    public function Definition() {
      return $this->belongsTo('App\Models\DefinitionModel');
    }

    public function Interface() {
      return $this->belongsTo('App\Models\InterfaceModel');
    }
}
