<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
	use SoftDeletes;
    protected $fillable=[
		'name','fname','avatar','city','cv','job_status','job_id','job_position_id','recruited','email'
	];
    protected $dates = ['deleted_at'];
    
    public function job()
    {
    	$this->belongsTo('App\Job');
    }

    public function job_position()
    {
    	$this->hasOne('App\JobPosition');
    }
}
