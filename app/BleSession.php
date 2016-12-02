<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BleSession extends Model
{
	protected $table = 'blesessions';

	protected $fillable = [
	'idUser', 'startdate', 'endDate', 'Mac','isSync' 
	];
}

