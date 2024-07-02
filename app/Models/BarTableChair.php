<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarTableChair extends Model
{
    use HasFactory;

    public function bartablename()
    {
        return $this->belongsTo(BarTable:: class,'table_id','id');
    }
}
