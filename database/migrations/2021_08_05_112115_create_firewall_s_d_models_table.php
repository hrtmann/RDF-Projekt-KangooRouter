<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirewallSDModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall_s_d_models', function (Blueprint $table) {
            $table->id();
            $table->boolean('source');
            $table->unsignedBigInteger('firewallrule_id')->nullable();
            $table->unsignedBigInteger('definition_id')->nullable();
            $table->unsignedBigInteger('interface_id')->nullable();
            $table->foreign('firewallrule_id')->references('id')->on('firewall_models')->onDelete('set null');
            $table->foreign('definition_id')->references('id')->on('definition_models')->onDelete('set null');
            $table->foreign('interface_id')->references('id')->on('interface_models')->onDelete('set null');
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
        Schema::dropIfExists('firewall_s_d_models');
    }
}
