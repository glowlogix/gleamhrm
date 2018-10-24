<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveType extends Model
{
	protected $primaryKey = ['user_id', 'stock_id'];
	public $incrementing = false;

	protected $table = 'employee_leave_type';

    protected $fillable = [
        'employee_id', 'leave_type_id', 'count', 'status',
    ];
}
