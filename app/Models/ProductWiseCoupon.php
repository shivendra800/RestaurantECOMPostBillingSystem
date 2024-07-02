<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductWiseCoupon extends Model
{
    use HasFactory,HasApiTokens;

    public function menuitem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'product_id','id');
    }
}
