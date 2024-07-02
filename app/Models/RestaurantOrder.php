<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantOrder extends Model
{
    use HasFactory,HasApiTokens;

    public function tables()
    {
         return $this->belongsTo(Table:: class,'table_id','id');
    }
    public function staffs()
    {
         return $this->belongsTo(Staff:: class,'staff_id','id');
    }
}
