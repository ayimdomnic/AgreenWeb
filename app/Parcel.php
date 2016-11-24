<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
	protected $table = 'parcels';

	protected $fillable = [
	'name', 'type', 'desc','area', 'statut'
	];

}
