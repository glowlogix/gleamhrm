<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'time_in', 'time_out', 'break_start', 'break_end', 'date', 'status',
    ];
}
