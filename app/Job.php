<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title', 'description', 'branch_id', 'designation_id', 'department_id', 'skill',
    ];

    public function applicant()
    {
        return $this->hasMany('App\Applicant');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Designation', 'designation_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }
}
