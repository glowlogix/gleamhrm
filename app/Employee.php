<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;
    
    protected $guard_name = 'web'; 

    protected $dates = ['deleted_at'];
    protected $appends = ['full_name'];
    
    protected $fillable = [
    	'firstname', 'lastname', 'contact_no', 'emergency_contact_relationship', 'emergency_contact', 'password', 'zuid', 'account_id', 'official_email', 'personal_email', 'designation', 'status', 'picture', 'exit_date', 'total_salary', 'bonus', 'basic_salary', 'allowed_leaves','invite_to_zoho', 'invite_to_slack', 'invite_to_asana', 'cnic', 'date_of_birth', 'current_address', 'permanent_address', 'city', 'branch_id', 'deleted_at', 'created_at', 'updated_at'
    ];

	public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->lastname}";
	}

    public function branch(){
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function attendanceSummary(){
        return $this->hasMany('App\AttendanceSummary')->latest();
    }

}
