<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slider';
    protected $primaryKey = 'id';
    protected $fillable = ['heading','short_description', 'btn_name', 'url', 'photo','status'];
    use HasFactory;
}
