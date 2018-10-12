<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable=[
		'name', 'status','address','phone_number', 'timing_start', 'timing_off'
	];

	public function employee(){
        return $this->hasMany('App\Employee');
    }
}
