<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'employee_id', 'team_id',
    ];

    public function employee()
    {
        return $this->belongsto('App\Employee');
    }
}
