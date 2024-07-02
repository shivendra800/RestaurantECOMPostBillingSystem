<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCapitalPurchaseInvItem extends Model
{
    use HasFactory;

    public function Extproduct()
    {
        return $this->belongsTo(ExternalProduct:: class,'prod_id','id');
    }
}
