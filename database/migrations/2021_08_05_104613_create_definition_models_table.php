<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefinitionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('definition_models', function (Blueprint $table) {
          $table->id();
          $table->string('bezeichnung');
          $table->unsignedtinyInteger('ipblock1');
          $table->unsignedtinyInteger('ipblock2');
          $table->unsignedtinyInteger('ipblock3');
          $table->unsignedtinyInteger('ipblock4');
          $table->unsignedtinyInteger('subnetmask');
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
        Schema::dropIfExists('definition_models');
    }
}
