<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirewallPoliciesModel extends Model
{
    use HasFactory;

    protected $fillable = ['ingress', 'egress', 'to_public'];
}
