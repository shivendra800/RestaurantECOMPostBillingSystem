<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvProd extends Model
{
    use HasFactory;
    public function categorytype()
    {
        return $this->belongsTo('App\Models\CategoryType','c_type_id','id');
    }
    public function category()
    {
         return $this->belongsTo(Category:: class,'c_wise_type_id','id');
    }
    public function vendortype()
    {
        return $this->belongsTo('App\Models\VendorType','v_type_id','id');
    }
    public function vendor()
    {
         return $this->belongsTo(Vendor:: class,'v_wise_type_id','id');
         
    }
  
    
}
