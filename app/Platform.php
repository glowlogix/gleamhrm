<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'website', 'logo', 'email', 'hr_email', 'mobile_no', 'phone_no',
    ];
}
