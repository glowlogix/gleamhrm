<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = [
        'category_name',
    ];

    public function vendor()
    {
        return $this->hasMany('App\Vendor');
    }
}
