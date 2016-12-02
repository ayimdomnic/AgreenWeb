<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlesessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('blesessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idUser');
            $table->string('mac');
            $table->string('startDate');
            $table->string('endDate');
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
        Schema::dropIfExists('blesessions');
    }
}

