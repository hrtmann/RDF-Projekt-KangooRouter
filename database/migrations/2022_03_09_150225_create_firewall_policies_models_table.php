<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirewallPoliciesModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall_policies_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingress')->nullable();
            $table->unsignedBigInteger('egress')->nullable();
            $table->boolean('to_public')->nullable();
            $table->foreign('ingress')->references('id')->on('interface_models')->onDelete('set null');
            $table->foreign('egress')->references('id')->on('interface_models')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firewall_policies_models');
    }
}
