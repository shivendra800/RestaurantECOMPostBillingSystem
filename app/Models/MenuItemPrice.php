<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class MenuItemPrice extends Model
{
    use HasFactory,HasApiTokens;

    public function menuCategory()
    {
         return $this->belongsTo(MenuCategory:: class,'menu_cat_id','id');
    }

    public function menusubCategory()
    {
         return $this->belongsTo(MenuSubCategory:: class,'menu_subcat_id','id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\MenuItemMultiImg','id','menu_item_id');
    }
    
     public function totalorder($id)
    {
          $orderitemdata=  Orderitem::where('item_id',$id)->count();
               $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->count();

               return $total = $orderitemdata+$takeorderitemdata;

         
    }
    
     public function totalordertoday($id)
    {
          $todayDate = Carbon::now()->format('Y-m-d');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereDate('created_at', $todayDate)->count();
               $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereDate('created_at', $todayDate)->count();

               return $total = $orderitemdata+$takeorderitemdata;

         
    }
    
      public function totalordermonth($id)
    {
          $thisMonth = Carbon::now()->format('m');
          $thisYear = Carbon::now()->format('Y');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();
          $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();

               return $total = $orderitemdata+$takeorderitemdata;

         
    }
    public function totalorderyear($id)
    {
         
          $thisYear = Carbon::now()->format('Y');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereYear('created_at', $thisYear)->count();
          $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereYear('created_at', $thisYear)->count();

               return $total = $orderitemdata+$takeorderitemdata;

         
    }

    public function totalordersumtoday($id)
    {
     $todayDate = Carbon::now()->format('Y-m-d');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereDate('created_at', $todayDate)->sum('amount');
               $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereDate('created_at', $todayDate)->sum('amount');

               return $total = $orderitemdata+$takeorderitemdata;

         
    }
    public function totalordersummonth($id)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->sum('amount');
               $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->sum('amount');

               return $total = $orderitemdata+$takeorderitemdata;

         
    }
    public function totalordersumyear($id)
    {
     $thisYear = Carbon::now()->format('Y');
          $orderitemdata=  Orderitem::where('item_id',$id)->whereYear('created_at', $thisYear)->sum('amount');
               $takeorderitemdata=  TakeWayOrderitem::where('item_id',$id)->whereYear('created_at', $thisYear)->sum('amount');

               return $total = $orderitemdata+$takeorderitemdata;

         
    }

  
}
