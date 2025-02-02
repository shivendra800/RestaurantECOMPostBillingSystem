<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function categorytype()
    {
        return $this->belongsTo('App\Models\CategoryType','c_type_id');
    }
}
