<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $fillable=[
		'title','description','city'
	];
    public function applicant(){
        return $this->hasMany('App\Applicant');
    }
	
    /*public function applicant(){
    	return $this->hasOne('App\Applicant');
    }*/
}
