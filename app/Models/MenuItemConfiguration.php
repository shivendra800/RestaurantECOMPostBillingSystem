<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemConfiguration extends Model
{
    use HasFactory;

    public function getproduct()
    {
        return $this->belongsTo(Ingredient:: class,'ingredient_id','id')->with('unit');
    }
    
}
