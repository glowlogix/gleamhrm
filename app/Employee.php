<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $appends = ['full_name'];
    
    protected $fillable = [
    	'firstname', 'lastname', 'contact_no', 'emergency_contact_relationship', 'emergency_contact', 'password', 'zuid', 'account_id', 'official_email', 'personal_email', 'role', 'status', 'total_salary', 'bonus', 'basic_salary', 'invite_to_zoho', 'invite_to_slack', 'invite_to_asana', 'cnic', 'date_of_birth', 'current_address', 'permanent_address', 'city', 'office_location_id', 'deleted_at', 'created_at', 'updated_at'
    ];

	public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->lastname}";
	}

    public function officeLocation(){
        return $this->belongsTo('App\OfficeLocation');
    }

}
