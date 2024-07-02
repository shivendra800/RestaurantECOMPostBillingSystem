<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DummyPruchaseItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Ingredient:: class,'prod_id','id');
    }
    public function unit()
    {
         return $this->belongsTo(Unit:: class,'unit','id');
    }
}
