<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationHierarchy extends Model
{
    protected $fillable = [
        'employee_id', 'line_manager_id', 'parent_id',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function lineManager()
    {
        return $this->belongsTo('App\Employee', 'line_manager_id');
    }

    public function parentEmployee()
    {
        return $this->belongsTo('App\Employee', 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany('App\OrganizationHierarchy', 'parent_id', 'employee_id');
    }
}
