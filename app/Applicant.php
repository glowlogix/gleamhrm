<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'fname', 'avatar', 'city', 'cv', 'job_status', 'job_id', 'recruited', 'email',
    ];
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
