<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
     protected $fillable = [
        'fname', 'lname',  'fullname', 'org_email','email', 'contact', 'password', 'role','inviteToZoho','inviteToSlack','inviteToAsana','status'
    ];

    
}
