<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department_name','status'
    ];


    public function employee(){
        return $this->hasMany('App\Employee');
    }
    public function team(){
        return $this->hasMany('App\Team');
    }
    public function job(){
        return $this->hasMany('App\Job');
    }
}
