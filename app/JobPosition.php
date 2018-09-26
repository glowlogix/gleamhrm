<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    public function jobs(){
    	return $this->hasMany('App\Job');
    }

    public function applicant(){
    	return $this->belongsTo('App\Applicant');
    }
}