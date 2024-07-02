<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orderitem extends Model
{
    use HasFactory,HasApiTokens;
    public function menuitem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'item_id','id');
    }

    public function extraitemadd()
    {
         return $this->belongsTo(ExtraMenu:: class,'extra_menu_item_id','id');
    }

    public function orderwise()
    {
         return $this->belongsTo(RestaurantOrder:: class,'order_no','order_no');
    }
     public function takeaway()
    {
         return $this->belongsTo(TakeWayOrderitem:: class,'item_id','item_id');
    }
}
