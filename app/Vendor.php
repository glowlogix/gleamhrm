<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'company_name', 'contact_name', 'contact_title',	'email', 'address', 'city', 'postal_code', 'country', 'mobile', 'fax', 'vendor_category_id',
    ];
}
