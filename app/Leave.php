<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'employee_id', 'leave_type',  'datefrom', 'dateto','hourslogged','reason','status'
    ];

}
