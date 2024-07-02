<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarTableOrderItem extends Model
{
    use HasFactory;

    public function menuitem()
    {
         return $this->belongsTo(MenuItemPrice:: class,'item_id','id');
    }

    public function barchairname()
    {
        return $this->belongsTo(BarTableChair:: class,'chairs_id','id');
    }
}
