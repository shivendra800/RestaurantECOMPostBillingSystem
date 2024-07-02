<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZomtaoAddToCart extends Model
{
    use HasFactory;

    public function menuitem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'item_id','id');
    }
}
