<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryAddres extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name','	address','city','state','area','pincode','mobile','email'
];

    public static function deliveryAddresses()
    {
        $deliveryAddresses = DeliveryAddres::where('user_id',Auth::user()->id)->get()->toArray();
        return $deliveryAddresses;
    }
}
