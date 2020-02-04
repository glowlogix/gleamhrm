<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSkill extends Model
{
    protected $fillable = [
        'sub_skill_name', 'skill_id',
    ];
}
