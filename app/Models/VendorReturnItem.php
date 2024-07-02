<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorReturnItem extends Model
{
    use HasFactory;

    public function getproduct()
    {
        return $this->belongsTo(Ingredient:: class,'return_product_id','id')->with('unit');
    }
}
