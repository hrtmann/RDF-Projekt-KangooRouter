<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDhcpModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcp_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interface_id')->nullable();
            $table->string('bezeichnung');
            $table->foreign('interface_id')->references('id')->on('interface_models')->onDelete('set null');
            $table->integer('ipblock1Start');
            $table->integer('ipblock2Start');
            $table->integer('ipblock3Start');
            $table->integer('ipblock4Start');
            $table->integer('ipblock1End');
            $table->integer('ipblock2End');
            $table->integer('ipblock3End');
            $table->integer('ipblock4End');
            $table->string('dns1');
            $table->string('dns2');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('dhcp_models');
    }
}
