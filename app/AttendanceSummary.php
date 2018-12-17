<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    protected $fillable = [
        'employee_id', 'first_time_in', 'last_time_out', 'total_time', 'date', 'status' , 'is_delay','first_timestamp_in','last_timestamp_out'
    ];

}
