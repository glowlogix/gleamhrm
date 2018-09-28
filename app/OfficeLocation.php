<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    protected $fillable=[
		'name','address','phone_number'
	];
}
