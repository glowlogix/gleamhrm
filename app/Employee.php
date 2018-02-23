<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     protected $fillable = [
        'fname', 'lname',  'fullname', 'email', 'contact', 'password', 'admin','inviteToZoho','inviteToSlack','inviteToAsana','disabled'
    ];
}
