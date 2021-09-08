<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'company_name', 'contact_name', 'contact_title', 'email', 'vendor_type', 'tax_payer', 'tax_no', 'branch_id', 'address', 'city', 'postal_code', 'country', 'mobile', 'fax', 'vendor_category_id',
    ];
}
