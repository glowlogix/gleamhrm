<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function jobs(){
    	return $this->hasMany('App\Job');
    }

    public function applicant(){
    	return $this->belongsTo('App\Applicant');
    }
}