<?php

namespace App\Models;

use App\Models\MenuItemPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function orders_products()
    {
         return  $this->hasMany('App\Models\OrdersProduct','order_id','order_no')->with('menuItem');
    }
   
   

}
