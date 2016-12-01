<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idApp');
            $table->string('idUser');
            $table->string('name');
            $table->double('lon');
            $table->double('lat');
            $table->datetime('dateGps');
            $table->timestampTz('timeDate');
            $table->integer('isInside');
            $table->integer('idParcelle');
            $table->float('altitude');
            $table->integer('isSync');
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
        Schema::dropIfExists('events');
        //
    }
}