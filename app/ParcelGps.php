<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelGps extends Model
{
    protected $table = 'parcel_gps';

	protected $fillable = [
	'id', 'idparcel', 'number', 'lat','long' 
	];
}