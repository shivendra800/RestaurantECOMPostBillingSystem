<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\RestaurantOrder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function WaiterDashboard()
    {
        $countorder = RestaurantOrder::select(DB::raw("COUNT(staff_id) as staff_id"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->where('staff_id', auth()->user()->id)
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("MONTHNAME(created_at)"))
        ->pluck('staff_id', 'month_name');

        $labels = $countorder->keys();
        $data = $countorder->values();

       

        return response([
            'labels' => $labels,
            'data' => $data,
            
            'message'=>'Get Data Successfully',
            'status'=> 'success'
        ],200);
    }
}
