<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('idGie');
            $table->Integer('idGaec');
            $table->string('name');
            $table->string('type');
            $table->string('desc');
            $table->string('area');
            $table->string('lat');
            $table->string('lon');
            $table->BigInteger('sau');
            $table->string('statut');
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
        Schema::dropIfExists('parcels');
    }
}
