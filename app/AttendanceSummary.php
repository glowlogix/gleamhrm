<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    protected $fillable = [
        'employee_id', 'total_time', 'date',
    ];

}
