<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    use HasFactory;

    public function menuItem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'product_id','id');
    }
}
