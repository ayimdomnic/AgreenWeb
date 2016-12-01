<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUser');
            $table->string('firstname');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('fixphone');
            $table->string('street');
            $table->integer('codePostal');
            $table->string('town');
            $table->string('country');
            $table->date('birthday');
            $table->string('statut');
            $table->integer('idGie');
            $table->integer('idGaec');
            $table->float('tauxHoraire');
            $table->string('type');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
