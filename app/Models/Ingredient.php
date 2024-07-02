<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    public function unit()
    {
         return $this->belongsTo(Unit:: class,'unit_id','id');
    }
    public function category()
    {
         return $this->belongsTo(Category:: class,'c_tye_wise_id','id');
    }
    public function Prodtype()
    {
         return $this->belongsTo(CategoryType:: class,'product_type_id','id');
    }
    public function vendor()
    {
         return $this->belongsTo(Vendor:: class,'v_tye_wise_id','id');
         
    }
}
