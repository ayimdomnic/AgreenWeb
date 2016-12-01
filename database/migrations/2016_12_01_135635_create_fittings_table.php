<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFittingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fittings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Mac');
            $table->string('idUser');
            $table->string('type');
            $table->string('timesFitting');
            $table->timestampTz('timeSync');
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
        Schema::dropIfExists('fittings');
    }
}

