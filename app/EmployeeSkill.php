<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    protected $fillable = [
        'employee_id', 'skill_id',
    ];

    public function employee()
    {
        return $this->belongsto('App\Employee');
    }
}
