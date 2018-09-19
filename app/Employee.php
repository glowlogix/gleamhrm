<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
     protected $fillable = [
        'firstname', 'lastname', 'fullname','zuid','account_id', 'org_email','email','emergency_contact','emergency_contact_relationship', 'contact', 'password', 'role','inviteToZoho','inviteToSlack','inviteToAsana','status'
    ];
}
