<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignExtVendorProduct extends Model
{
    use HasFactory;

    public function getproduct()
    {
        return $this->belongsTo(ExternalProduct:: class,'ext_product_id','id');
    }
}
