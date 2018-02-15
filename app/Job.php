<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $fillable=[
		'title','description','category_id','featured'
	];
    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function applicant(){
    	return $this->hasOne('App\Applicant');
    }
}
