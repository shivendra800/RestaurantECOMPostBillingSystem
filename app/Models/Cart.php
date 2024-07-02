<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems()
    {
       if(Auth::check())
       {
        // If user Logged In/pick auth id of user
        $getCartItems=Cart::orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
       }else{
        // if user not logged in
            $getCartItems = 0;

       }
       return $getCartItems;
    }

    public function Usermenuitem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'menu_item_id','id');
    }
}
