<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $fillable=[
		'title','description','city'
	];
    public function job_position(){
    	return $this->belongsTo('App\JobPosition');
    }

    public function applicant(){
    	return $this->hasOne('App\Applicant');
    }
}
