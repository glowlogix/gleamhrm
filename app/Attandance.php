<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attandance extends Model
{
    protected $fillable = [
        'employee_id', 'delay',  'checkouttime', 'checkintime','hourslogged'
    ];

}
