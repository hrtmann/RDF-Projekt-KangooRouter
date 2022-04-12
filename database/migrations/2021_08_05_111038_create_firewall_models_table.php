<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirewallModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall_models', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung');
            $table->integer('port');
            $table->integer('port_end')->nullable()->default(0);
            $table->boolean('tcp')->default(1);
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
        Schema::dropIfExists('firewall_models');
    }
}
