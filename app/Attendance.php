<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id', 'time_in', 'time_out', 'comment', 'date', 'status', 'timestamp_in', 'timestamp_out',
    ];
}
