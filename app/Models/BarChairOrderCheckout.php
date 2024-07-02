<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarChairOrderCheckout extends Model
{
    use HasFactory;

    public function barchairname()
    {
        return $this->belongsTo(BarTableChair:: class,'chair_id','id');
    }
}
