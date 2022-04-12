<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutingModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routing_models', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung');
            $table->unsignedBigInteger('next_hop')->nullable();
            $table->unsignedBigInteger('target')->nullable();
            $table->foreign('next_hop')->references('id')->on('definition_models')->onDelete('set null');
            $table->foreign('target')->references('id')->on('definition_models')->onDelete('set null');
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
        Schema::dropIfExists('routing_models');
    }
}
