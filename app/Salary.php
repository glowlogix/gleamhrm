<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'gross_salary', 'basic_salary', 'home_allowance', 'medical_allowance', 'special_allowance', 'meal_allowance', 'conveyance_allowance', 'pf_deduction', 'employee_id',
    ];
}
