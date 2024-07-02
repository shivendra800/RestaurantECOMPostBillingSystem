<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalProductUseLogMang extends Model
{
    use HasFactory;

    public function extproduct()
    {
        return $this->belongsTo(ExternalProduct:: class,'product_id','id');
    }
}
