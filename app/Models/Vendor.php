<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendortype()
    {
        return $this->belongsTo('App\Models\VendorType','vendor_type');
    }
}
