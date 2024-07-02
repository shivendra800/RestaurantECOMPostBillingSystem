<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignVendorProduct extends Model
{
    use HasFactory;

    public function getproduct()
    {
        return $this->belongsTo(Ingredient:: class,'product_id','id')->with('Prodtype');
    }
    public function getunit()
    {
         return $this->belongsTo(Unit:: class,'unit_id','id');
    }
    
}
