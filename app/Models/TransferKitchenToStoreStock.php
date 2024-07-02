<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferKitchenToStoreStock extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Ingredient:: class,'product_id','id')->with('unit');
    }
}
