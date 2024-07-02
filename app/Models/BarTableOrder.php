<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarTableOrder extends Model
{
    use HasFactory;

    public function tables()
    {
         return $this->belongsTo(BarTable:: class,'bar_table_id','id');
    }
    public function staffs()
    {
         return $this->belongsTo(Staff:: class,'staff_id','id');
    }
    public function bartablename()
    {
        return $this->belongsTo(BarTableChair:: class,'bar_table_id','id');
    }
}
