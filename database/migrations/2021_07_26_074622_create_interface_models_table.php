<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interface_models', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung');
            $table->unsignedtinyInteger('ipblock1');
            $table->unsignedtinyInteger('ipblock2');
            $table->unsignedtinyInteger('ipblock3');
            $table->unsignedtinyInteger('ipblock4');
            $table->unsignedtinyInteger('subnetmask');
            $table->unsignedtinyInteger('vlan');
            $table->string('macaddr');
            $table->unsignedBigInteger('hardwareinterface_id')->nullable();
            $table->foreign('hardwareinterface_id')->references('id')->on('hardware_interface_models')->onDelete('set null');
            $table->boolean('status')->default(0);
            $table->integer('end_status')->default(-1);
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
        Schema::dropIfExists('interface_models');
    }
}
