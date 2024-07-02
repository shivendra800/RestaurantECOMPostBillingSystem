<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Table;
use App\Models\Orderitem;
use App\Models\Ingredient;
use App\Models\OrderWiseTax;
use App\Models\PruchaseItem;
use App\Models\TableBooking;
use App\Models\TakeWayOrder;
use Illuminate\Http\Request;
use App\Models\MenuItemPrice;
use App\Models\KitchenWastelog;
use App\Models\PurchaseInvProd;
use App\Models\RestaurantOrder;
use App\Models\TakeWayOrderitem;
use App\Models\KitchenUseStocklog;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenProReceStock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BarTableOrder;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('admin')->user()->type == 'Waiter') {
            return redirect('admin/Waiter-Dashboard');
        }
        if (Auth::guard('admin')->user()->type == 'Kitchen-Manager') {
            return redirect('admin/Kitchen-Manager-dashboard');
        }
        if (Auth::guard('admin')->user()->type == 'store-manager') {
            return redirect('admin/store-manager-dashboard');
        }
        if (Auth::guard('admin')->user()->type == 'Cashier') {
            return redirect('admin/Cashier-dashboard');
        } 
        if (Auth::guard('admin')->user()->type == 'BarChasier') {
            return redirect('admin/BarChasier-dashboard');
        } 
        if (Auth::guard('admin')->user()->type == 'DeliveryBoy') {
            return redirect('admin/DeliveryBoy-dashboard');
        }
           if (Auth::guard('admin')->user()->type == 'Vendor') {
            return redirect('admin/Vendor-dashboard');
        }
        
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        //    Take Way Order Sale   start -----------------------------------------------------------------------------------------------------

        $data['totalTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->sum('grand_total');
         $data['YesterdayTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todaytakewaysale'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['Monthstakewaysale'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['Yeartakewaysale'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


        $data['totalTableOrdersale'] = RestaurantOrder::where('order_status', 'Order Completed')->sum('grand_total');
        $data['YesterdayTablesale'] = RestaurantOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayTablesale'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsTablesale'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesale'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


         $data['totalBartableOrdersale'] = BarTableOrder::where('order_status', 'Order Completed')->sum('grand_total');
        $data['YesterdayBartablesale'] = BarTableOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayBartablesale'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsBartablesale'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearBartablesale'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');

        //    Overall Sale   start -----------------------------------------------------------------------------------------------------

        $data['overallsale'] = $data['totalTakeWayOrdersale'] + $data['totalTableOrdersale']+$data['totalBartableOrdersale'];
        $data['overallYesterdaysale'] = $data['YesterdayTakeWayOrdersale'] + $data['YesterdayTablesale']+$data['YesterdayBartablesale'];
        $data['overalltodaysale'] = $data['todaytakewaysale'] + $data['todayTablesale']+$data['todayBartablesale'];
        $data['overallMonthsale'] = $data['Monthstakewaysale'] + $data['MonthsTablesale']+$data['MonthsBartablesale'];
        $data['overallYearsale'] = $data['Yeartakewaysale'] + $data['YearTablesale']+$data['YearBartablesale'];

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       
        // today all collection
        $data['TodayTablesaleCash'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodayTablesaleCard'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodayTablesaleQR'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodayTablesaleRazorpay'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodaytakewaysaleCash'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodaytakewaysaleCard'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodaytakewaysaleQR'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodaytakewaysaleRazorpay'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodayBartablesaleCash'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodayBartablesaleCard'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodayBartablesaleQR'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodayBartablesaleRazorpay'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodayCash'] =  $data['TodayTablesaleCash'] +$data['TodaytakewaysaleCash']+$data['TodayBartablesaleCash'];
        $data['TodayCard'] =  $data['TodayTablesaleCard'] +$data['TodaytakewaysaleCard']+$data['TodayBartablesaleCard'];
        $data['TodayQR'] =  $data['TodayTablesaleQR'] +$data['TodaytakewaysaleQR']+$data['TodayBartablesaleQR'];
        $data['TodayRazorpay'] =  $data['TodayTablesaleRazorpay'] +$data['TodaytakewaysaleRazorpay']+$data['TodayBartablesaleRazorpay'];
        // end//////////////////////////////////////////

         // Yesterday all collection
         $data['YesterdayTablesaleCash'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdayTablesaleCard'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdayTablesaleQR'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdayTablesaleRazorpay'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdaytakewaysaleCash'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdaytakewaysaleCard'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdaytakewaysaleQR'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdaytakewaysaleRazorpay'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdayBartablesaleCash'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdayBartablesaleCard'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdayBartablesaleQR'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdayBartablesaleRazorpay'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdayCash'] =  $data['YesterdayTablesaleCash'] +$data['YesterdaytakewaysaleCash']+$data['YesterdayBartablesaleCash'];
         $data['YesterdayCard'] =  $data['YesterdayTablesaleCard'] +$data['YesterdaytakewaysaleCard']+$data['YesterdayBartablesaleCard'];
         $data['YesterdayQR'] =  $data['YesterdayTablesaleQR'] +$data['YesterdaytakewaysaleQR']+$data['YesterdayBartablesaleQR'];
         $data['YesterdayRazorpay'] =  $data['YesterdayTablesaleRazorpay'] +$data['YesterdaytakewaysaleRazorpay']+$data['YesterdayBartablesaleRazorpay'];
         // end//////////////////////////////////////////

        // monthly all collection
        $data['MonthsTablesaleCash'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthsTablesaleCard'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthsTablesaleQR'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthsTablesaleRazorpay'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthstakewaysaleCash'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthstakewaysaleCard'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthstakewaysaleQR'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthstakewaysaleRazorpay'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthsBartablesaleCash'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthsBartablesaleCard'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthsBartablesaleQR'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthsBartablesaleRazorpay'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthsCash'] =  $data['MonthsTablesaleCash'] +$data['MonthstakewaysaleCash']+$data['MonthsBartablesaleCash'];
        $data['MonthsCard'] =  $data['MonthsTablesaleCard'] +$data['MonthstakewaysaleCard']+$data['MonthsBartablesaleCard'];
        $data['MonthsQR'] =  $data['MonthsTablesaleQR'] +$data['MonthstakewaysaleQR']+$data['MonthsBartablesaleQR'];
        $data['MonthsRazorpay'] =  $data['MonthsTablesaleRazorpay'] +$data['MonthstakewaysaleRazorpay']+$data['MonthsBartablesaleRazorpay'];
        // end//////////////////////////////////////////

         // year all collection
         $data['YearTablesaleCash'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YearTablesaleCard'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YearTablesaleQR'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YearTablesaleRazorpay'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YeartakewaysaleCash'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YeartakewaysaleCard'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YeartakewaysaleQR'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YeartakewaysaleRazorpay'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YearBartablesaleCash'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YearBartablesaleCard'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YearBartablesaleQR'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YearBartablesaleRazorpay'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YearCash'] =  $data['YearTablesaleCash'] +$data['YeartakewaysaleCash']+$data['YearBartablesaleCash'];
         $data['YearCard'] =  $data['YearTablesaleCard'] +$data['YeartakewaysaleCard']+$data['YearBartablesaleCard'];
         $data['YearQR'] =  $data['YearTablesaleQR'] +$data['YeartakewaysaleQR']+$data['YearBartablesaleQR'];
         $data['YearRazorpay'] =  $data['YearTablesaleRazorpay'] +$data['YeartakewaysaleRazorpay']+$data['YearBartablesaleRazorpay'];
         // end//////////////////////////////////////////
       

      
        return view('/admin/dashboard', $data);
    }
     public function overallreportCollection()
    {
          $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        //    Take Way Order Sale   start -----------------------------------------------------------------------------------------------------

        $data['totalTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->sum('grand_total');
         $data['YesterdayTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todaytakewaysale'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['Monthstakewaysale'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['Yeartakewaysale'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


        $data['totalTableOrdersale'] = RestaurantOrder::where('order_status', 'Order Completed')->sum('grand_total');
        $data['YesterdayTablesale'] = RestaurantOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayTablesale'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsTablesale'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesale'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


         $data['totalBartableOrdersale'] = BarTableOrder::where('order_status', 'Order Completed')->sum('grand_total');
        $data['YesterdayBartablesale'] = BarTableOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayBartablesale'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsBartablesale'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearBartablesale'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');

        //    Overall Sale   start -----------------------------------------------------------------------------------------------------

        $data['overallsale'] = $data['totalTakeWayOrdersale'] + $data['totalTableOrdersale']+$data['totalBartableOrdersale'];
        $data['overallYesterdaysale'] = $data['YesterdayTakeWayOrdersale'] + $data['YesterdayTablesale']+$data['YesterdayBartablesale'];
        $data['overalltodaysale'] = $data['todaytakewaysale'] + $data['todayTablesale']+$data['todayBartablesale'];
        $data['overallMonthsale'] = $data['Monthstakewaysale'] + $data['MonthsTablesale']+$data['MonthsBartablesale'];
        $data['overallYearsale'] = $data['Yeartakewaysale'] + $data['YearTablesale']+$data['YearBartablesale'];

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       
        // today all collection
        $data['TodayTablesaleCash'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodayTablesaleCard'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodayTablesaleQR'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodayTablesaleRazorpay'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodaytakewaysaleCash'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodaytakewaysaleCard'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodaytakewaysaleQR'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodaytakewaysaleRazorpay'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodayBartablesaleCash'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
        $data['TodayBartablesaleCard'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['TodayBartablesaleQR'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['TodayBartablesaleRazorpay'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['TodayCash'] =  $data['TodayTablesaleCash'] +$data['TodaytakewaysaleCash']+$data['TodayBartablesaleCash'];
        $data['TodayCard'] =  $data['TodayTablesaleCard'] +$data['TodaytakewaysaleCard']+$data['TodayBartablesaleCard'];
        $data['TodayQR'] =  $data['TodayTablesaleQR'] +$data['TodaytakewaysaleQR']+$data['TodayBartablesaleQR'];
        $data['TodayRazorpay'] =  $data['TodayTablesaleRazorpay'] +$data['TodaytakewaysaleRazorpay']+$data['TodayBartablesaleRazorpay'];
        // end//////////////////////////////////////////

         // Yesterday all collection
         $data['YesterdayTablesaleCash'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdayTablesaleCard'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdayTablesaleQR'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdayTablesaleRazorpay'] = RestaurantOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdaytakewaysaleCash'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdaytakewaysaleCard'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdaytakewaysaleQR'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdaytakewaysaleRazorpay'] = TakeWayOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdayBartablesaleCash'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YesterdayBartablesaleCard'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YesterdayBartablesaleQR'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YesterdayBartablesaleRazorpay'] = BarTableOrder::whereDate('created_at', Carbon::now()->subDays(1))->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YesterdayCash'] =  $data['YesterdayTablesaleCash'] +$data['YesterdaytakewaysaleCash']+$data['YesterdayBartablesaleCash'];
         $data['YesterdayCard'] =  $data['YesterdayTablesaleCard'] +$data['YesterdaytakewaysaleCard']+$data['YesterdayBartablesaleCard'];
         $data['YesterdayQR'] =  $data['YesterdayTablesaleQR'] +$data['YesterdaytakewaysaleQR']+$data['YesterdayBartablesaleQR'];
         $data['YesterdayRazorpay'] =  $data['YesterdayTablesaleRazorpay'] +$data['YesterdaytakewaysaleRazorpay']+$data['YesterdayBartablesaleRazorpay'];
         // end//////////////////////////////////////////

        // monthly all collection
        $data['MonthsTablesaleCash'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthsTablesaleCard'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthsTablesaleQR'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthsTablesaleRazorpay'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthstakewaysaleCash'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthstakewaysaleCard'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthstakewaysaleQR'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthstakewaysaleRazorpay'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthsBartablesaleCash'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Cash')->sum('grand_total');
        $data['MonthsBartablesaleCard'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Card Swip')->sum('grand_total');
        $data['MonthsBartablesaleQR'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
        $data['MonthsBartablesaleRazorpay'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');

        $data['MonthsCash'] =  $data['MonthsTablesaleCash'] +$data['MonthstakewaysaleCash']+$data['MonthsBartablesaleCash'];
        $data['MonthsCard'] =  $data['MonthsTablesaleCard'] +$data['MonthstakewaysaleCard']+$data['MonthsBartablesaleCard'];
        $data['MonthsQR'] =  $data['MonthsTablesaleQR'] +$data['MonthstakewaysaleQR']+$data['MonthsBartablesaleQR'];
        $data['MonthsRazorpay'] =  $data['MonthsTablesaleRazorpay'] +$data['MonthstakewaysaleRazorpay']+$data['MonthsBartablesaleRazorpay'];
        // end//////////////////////////////////////////

         // year all collection
         $data['YearTablesaleCash'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YearTablesaleCard'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YearTablesaleQR'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YearTablesaleRazorpay'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YeartakewaysaleCash'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YeartakewaysaleCard'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YeartakewaysaleQR'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YeartakewaysaleRazorpay'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YearBartablesaleCash'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Cash')->sum('grand_total');
         $data['YearBartablesaleCard'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Card Swip')->sum('grand_total');
         $data['YearBartablesaleQR'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','QRCodeWithSlip')->sum('grand_total');
         $data['YearBartablesaleRazorpay'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->where('payment_mode','=','Paid by Razorpay')->sum('grand_total');
 
         $data['YearCash'] =  $data['YearTablesaleCash'] +$data['YeartakewaysaleCash']+$data['YearBartablesaleCash'];
         $data['YearCard'] =  $data['YearTablesaleCard'] +$data['YeartakewaysaleCard']+$data['YearBartablesaleCard'];
         $data['YearQR'] =  $data['YearTablesaleQR'] +$data['YeartakewaysaleQR']+$data['YearBartablesaleQR'];
         $data['YearRazorpay'] =  $data['YearTablesaleRazorpay'] +$data['YeartakewaysaleRazorpay']+$data['YearBartablesaleRazorpay'];
         // end//////////////////////////////////////////
        return view('admin.dashboards.overallreport',$data);
    }
    
    public function BarChasierDashboard()
    {
        return view('admin.dashboards.barchasier_dashboard');
    }
    public function WaiterDashboard()
    {

        $countorder = RestaurantOrder::select(DB::raw("COUNT(staff_id) as staff_id"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('staff_id', Auth::guard('admin')->user()->id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('staff_id', 'month_name');

        $labels = $countorder->keys();
        $data = $countorder->values();
        return view('admin.dashboards.waiter_dashboard', compact('labels', 'data'));
    }
    public function KitchenManagerdashboard()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $data['tableorder'] = RestaurantOrder::with('tables')->where('order_status', 'Order-Taken')->where('created_at', $todayDate)->latest()->get()->toArray();
        $data['takeWayorder'] = TakeWayOrder::where('created_at', $todayDate)->where('updated_kitchen_order_status', 'Order-Transfer-Kichen')->where('created_at', $todayDate)->latest()->get()->toArray();

        $data['onlineOrder'] = Order::with('orders_products')->where('order_status', 'Order-Accepted')->where('created_at', $todayDate)->latest()->get()->toArray();
        return view('admin.dashboards.kitchen_dashboard', $data);
    }


    public function storemanagerdashboard()
    {

        $purchaseinv = PurchaseInvProd::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(product_purchase_date) as month_name"))
            ->whereYear('product_purchase_date', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(product_purchase_date)"))
            ->pluck('grand_total', 'month_name');

        $labels = $purchaseinv->keys();
        $data = $purchaseinv->values();

        $getKitchenStock = KitchenProReceStock::with('unit', 'product')->where('consumption_qty', '>', '0')->get()->toArray();
        $getinvtstk = Ingredient::with('unit', 'category', 'vendor')->get()->toArray();
        return view('admin.dashboards.storemanager_dashboard', compact('labels', 'data', 'getKitchenStock', 'getinvtstk'));
    }



    public function Cashierdashboard()
    {
        
        

        $notbooked = Table::where('booking_status', 0)->get()->toArray();


        $booked = Table::join('restaurant_orders', 'restaurant_orders.table_id', 'tables.id')
            ->join('staff', 'staff.id', 'restaurant_orders.staff_id')
            ->select('tables.*', 'restaurant_orders.order_no', 'staff.name')
            ->where('tables.booking_status', 1)
            ->where('restaurant_orders.order_status', '!=', 'Order Completed')
            ->get()->toArray();


        $AllTable = Table::where('booking_status', 1)->get()->toArray();

        $tableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))

            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $labels = $tableorderSum->keys();
        $data = $tableorderSum->values();

        $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $takeWayOrderlabels = $takeWayorderSum->keys();
        $takeWayOrderdata = $takeWayorderSum->values();

        return view('admin.dashboards.cashier_dashboard', compact(
            'notbooked',
            'booked',
            'AllTable',
            'labels',
            'data',
            'takeWayOrderlabels',
            'takeWayOrderdata'
        ));
    }


    public function cashpaymentdetails()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $tableOderSale = RestaurantOrder::where('payment_mode', '=', 'Cash')->get();
        $takeOderSale = TakeWayOrder::where('payment_mode', '=', 'Cash')->get();

        $tableOderSaledis = DB::table('restaurant_orders')->where('payment_mode', '=', 'Cash')->sum(DB::raw('grand_total'));
        $takeOderSaledis = DB::table('take_way_orders')->where('payment_mode', '=', 'Cash')->sum(DB::raw('grand_total'));

        $overallsaledis = $tableOderSaledis + $takeOderSaledis;

        $daywisetables = RestaurantOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payment_mode', '=', 'Cash')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payment_mode', '=', 'Cash')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payment_mode', '=', 'Cash')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payment_mode', '=', 'Cash')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payment_mode', '=', 'Cash')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payment_mode', '=', 'Cash')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();

        return view('admin.dashboards.cashpaymentdetails', $data, compact('tableOderSale', 'takeOderSale', 'overallsaledis'));
    }

    public function onlinepaymentdetails()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $tableOderSale = RestaurantOrder::where('payment_mode', '!=', 'Cash')->get();
        $takeOderSale = TakeWayOrder::where('payment_mode', '!=', 'Cash')->get();

        $tableOderSaledis = DB::table('restaurant_orders')->where('payment_mode', '!=', 'Cash')->sum(DB::raw('grand_total'));
        $takeOderSaledis = DB::table('take_way_orders')->where('payment_mode', '!=', 'Cash')->sum(DB::raw('grand_total'));

        $overallsaledis = $tableOderSaledis + $takeOderSaledis;

        $daywisetables = RestaurantOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payment_mode', '!=', 'Cash')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payment_mode', '!=', 'Cash')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payment_mode', '!=', 'Cash')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payment_mode', '!=', 'Cash')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payment_mode', '!=', 'Cash')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payment_mode', '!=', 'Cash')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();


        return view('admin.dashboards.onlinepaymentdetails', $data, compact('tableOderSale', 'takeOderSale', 'overallsaledis'));
    }

    public function totalpaymentdetails()
    {

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        //    Take Way Order Sale   start -----------------------------------------------------------------------------------------------------

        $data['totalTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->sum('grand_total');
         $data['YesterdayTakeWayOrdersale'] = TakeWayOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todaytakewaysale'] = TakeWayOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['Monthstakewaysale'] = TakeWayOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['Yeartakewaysale'] = TakeWayOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


        $data['totalTableOrdersale'] = RestaurantOrder::where('order_status', 'Order Completed')->sum('grand_total');
             $data['YesterdayTablesale'] = RestaurantOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayTablesale'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsTablesale'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesale'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');


         $data['totalBartableOrdersale'] = BarTableOrder::where('order_status', 'Order Completed')->sum('grand_total');
        $data['YesterdayBartablesale'] = BarTableOrder::where('order_status', 'Order Completed')->whereDate('created_at', Carbon::now()->subDays(1))->sum('grand_total');
        $data['todayBartablesale'] = BarTableOrder::whereDate('created_at', $todayDate)->where('order_status', 'Order Completed')->sum('grand_total');
        $data['MonthsBartablesale'] = BarTableOrder::whereMonth('created_at', $thisMonth)->where('order_status', 'Order Completed')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearBartablesale'] = BarTableOrder::whereYear('created_at', $thisYear)->where('order_status', 'Order Completed')->sum('grand_total');

        //    Overall Sale   start -----------------------------------------------------------------------------------------------------

        $data['overallsale'] = $data['totalTakeWayOrdersale'] + $data['totalTableOrdersale']+$data['totalBartableOrdersale'];
        $data['overallYesterdaysale'] = $data['YesterdayTakeWayOrdersale'] + $data['YesterdayTablesale']+$data['YesterdayBartablesale'];
        $data['overalltodaysale'] = $data['todaytakewaysale'] + $data['todayTablesale']+$data['todayBartablesale'];
        $data['overallMonthsale'] = $data['Monthstakewaysale'] + $data['MonthsTablesale']+$data['MonthsBartablesale'];
        $data['overallYearsale'] = $data['Yeartakewaysale'] + $data['YearTablesale']+$data['YearBartablesale'];



        $tableOderSale = RestaurantOrder::where('order_status', 'Order Completed')->get();
        $takeOderSale = TakeWayOrder::where('order_status', 'Order Completed')->get();

   //  Search wise Graph According To Year  Wise  Start ---------------------------------------------------

        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
       
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->pluck('grand_total', 'year');
        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();

        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->pluck('grand_total', 'year');
        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();
        $data['year'] = TakeWayOrder::select(DB::raw("YEAR(created_at) as year"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get();  

         //  Search wise Graph According To Year  Wise  END ---------------------------------------------------


         $daywisetables = RestaurantOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date"))
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date"))
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();

 
        return view('admin.dashboards.totalpaymentdetails', $data, compact('tableOderSale', 'takeOderSale'));
    }

    public function getyearwisedatatakeawayorder($year)
    {
        // return $year;
        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
       ->where(DB::raw("YEAR(created_at)"),'=',$year)
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
        ->where(DB::raw("YEAR(created_at)"),'=',$year)
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();

        // $data['year'] = TakeWayOrder::select(DB::raw("YEAR(created_at) as year"))
       
        // ->groupBy(DB::raw("YEAR(created_at)"))
        // ->get();  

        return response()->json(['data'=> $data]);

    }


    public function takeawaydashboard()
    {
        // Graph Start-----------------------------------------------------------------------

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');


        $takeWayorderSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['takeWayOrderlabels']  = $takeWayorderSums->keys();
        $data['takeWayOrderdata']  = $takeWayorderSums->values();

        $TakeWayorderYearSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWayYearSalelabels'] = $TakeWayorderYearSum->keys();
        $data['TakeWayYearSaledata'] = $TakeWayorderYearSum->values();

        $daywisetakeaway = TakeWayOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');


        $data['daywisetakeawaylabels'] = $daywisetakeaway->keys();
        $data['daywisetakeawaydata'] = $daywisetakeaway->values();

        $data['TakeWayItemSale'] = TakeWayOrderitem::get();




        $topsalesTak = DB::table('take_way_orderitems')
            ->leftJoin('menu_item_prices', 'menu_item_prices.id', '=', 'take_way_orderitems.item_id')
            ->select(
                'menu_item_prices.id',
                'menu_item_prices.menu_item_name',
                'take_way_orderitems.item_id',
                DB::raw('SUM(take_way_orderitems.item_qty) as total_qty_sale'),
                DB::raw('SUM(take_way_orderitems.amount) as total_amount_sale'),
                DB::raw('SUM(take_way_orderitems.no_qty_buy_to_free*take_way_orderitems.price) as total_feeitem_amount'),
                DB::raw('SUM(take_way_orderitems.no_qty_buy_to_free) as total_feeitem_given')
            )
            ->groupBy('menu_item_prices.id', 'take_way_orderitems.item_id', 'menu_item_prices.menu_item_name')
            ->orderBy('total_qty_sale', 'desc')
            ->get();
        $resitemtk[] = ['Item Name', 'Total Sale Qty', 'Total Sale Amount', 'Total Freeitem Amount', 'Total Freeitem Given'];
        foreach ($topsalesTak as $key => $val) {
            $resitemtk[++$key] = [
                $val->menu_item_name, (int)$val->total_qty_sale, (int)$val->total_amount_sale,
                (int)$val->total_feeitem_amount, (int)$val->total_feeitem_given
            ];
        }

        //    Take Way Order Sale  End --------------------
        return view('admin.dashboards.takeawaydashboard', $data)->with('topsalesTak', json_encode($resitemtk));
    }

    public function tabledashboard()
    {


        // Graph Start-----------------------------------------------------------------------

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $daywisetable = RestaurantOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');


        $data['daywisetablelabels'] = $daywisetable->keys();
        $data['daywisetabledata'] = $daywisetable->values();

        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))

            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['labels'] = $stableorderSum->keys();
        $data['data'] = $stableorderSum->values();



        $stableorderYearSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TableYearSalelabels'] = $stableorderYearSum->keys();
        $data['TableYearSaledata'] = $stableorderYearSum->values();



        $topsales = DB::table('orderitems')
            ->leftJoin('menu_item_prices', 'menu_item_prices.id', '=', 'orderitems.item_id')
            ->select(
                'menu_item_prices.id',
                'menu_item_prices.menu_item_name',
                'orderitems.item_id',
                DB::raw('SUM(orderitems.item_qty) as total_qty_sale'),
                DB::raw('SUM(orderitems.amount) as total_amount_sale'),
                DB::raw('SUM(orderitems.no_qty_buy_to_free*orderitems.price) as total_feeitem_amount'),
                DB::raw('SUM(orderitems.no_qty_buy_to_free) as total_feeitem_given')
            )
            ->groupBy('menu_item_prices.id', 'orderitems.item_id', 'menu_item_prices.menu_item_name')
            ->orderBy('total_qty_sale', 'desc')
            ->get();
        $resitem[] = ['Item Name', 'Total Sale Qty', 'Total Sale Amount', 'Total Freeitem Amount', 'Total Freeitem Given'];
        foreach ($topsales as $key => $val) {
            $resitem[++$key] = [
                $val->menu_item_name, (int)$val->total_qty_sale, (int)$val->total_amount_sale,
                (int)$val->total_feeitem_amount, (int)$val->total_feeitem_given
            ];
        }

        //    Table Order Sale  End -----------------------------------------------------------------------------------------------------

        return view('admin.dashboards.tabledashboard', $data)->with('topsales', json_encode($resitem));
    }

    public function MenuItemOrderDashoard()
    {

        $orderitemsaleTable = DB::table('orderitems')
        ->leftJoin('menu_item_prices', 'menu_item_prices.id', '=', 'orderitems.item_id')
        ->select(
            'menu_item_prices.id',
            'menu_item_prices.menu_item_name',
            'orderitems.item_id',
            DB::raw('SUM(orderitems.item_qty) as total_qty_sale'),
            DB::raw('SUM(orderitems.amount) as total_amount_sale'),
            DB::raw('SUM(orderitems.no_qty_buy_to_free*orderitems.price) as total_feeitem_amount'),
            DB::raw('SUM(orderitems.no_qty_buy_to_free) as total_feeitem_given')
        )
        ->groupBy('menu_item_prices.id', 'orderitems.item_id', 'menu_item_prices.menu_item_name')
        ->orderBy('total_qty_sale', 'desc')
        ->get();
    $resitem[] = ['Item Name', 'Total Sale Qty', 'Total Sale Amount', 'Total Freeitem Amount', 'Total Freeitem Given'];
    foreach ($orderitemsaleTable as $key => $val) {
        $resitem[++$key] = [
            $val->menu_item_name, (int)$val->total_qty_sale, (int)$val->total_amount_sale,
            (int)$val->total_feeitem_amount, (int)$val->total_feeitem_given
        ];
    }
        return view('admin.dashboards.menu_item_order')->with('orderitemsaleTable', json_encode($resitem));
    }


    public function PurchaseInvGraph()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $data['todayTotalBill'] = PurchaseInvProd::whereDate('product_purchase_date', $todayDate)->sum('total_bill');
        $data['MonthsTotalBill'] = PurchaseInvProd::whereMonth('product_purchase_date', $thisMonth)->whereYear('product_purchase_date', $thisYear)->sum('total_bill');
        $data['YearTotalBill'] = PurchaseInvProd::whereYear('product_purchase_date', $thisYear)->sum('total_bill');


        $data['todayPaidAtm'] = PurchaseInvProd::whereDate('product_purchase_date', $todayDate)->sum('paid_amount');
        $data['MonthsPaidAtm'] = PurchaseInvProd::whereMonth('product_purchase_date', $thisMonth)->whereYear('product_purchase_date', $thisYear)->sum('paid_amount');
        $data['YearPaidAtm'] = PurchaseInvProd::whereYear('product_purchase_date', $thisYear)->sum('paid_amount');


        $data['todayReamingAtm'] = PurchaseInvProd::whereDate('product_purchase_date', $todayDate)->sum('remaining_amount');
        $data['MonthsReamingAtm'] = PurchaseInvProd::whereMonth('product_purchase_date', $thisMonth)->whereYear('product_purchase_date', $thisYear)->sum('remaining_amount');
        $data['YearReamingAtm'] = PurchaseInvProd::whereYear('product_purchase_date', $thisYear)->sum('remaining_amount');

        $data['todayPreviousAtm'] = PurchaseInvProd::whereDate('product_purchase_date', $todayDate)->sum('previous_amount');
        $data['MonthsPreviousAtm'] = PurchaseInvProd::whereMonth('product_purchase_date', $thisMonth)->whereYear('product_purchase_date', $thisYear)->sum('previous_amount');
        $data['YearPreviousAtm'] = PurchaseInvProd::whereYear('product_purchase_date', $thisYear)->sum('previous_amount');
         //    Purchase Product Inver   start -----------------------------------------------------------------------------------------------------
         $PurchaseInvProd = PurchaseInvProd::select(
            DB::raw("year(product_purchase_date) as year"),
            DB::raw("SUM(total_bill) as total_bill"),
            DB::raw("SUM(paid_amount) as paid_amount"),
            DB::raw("SUM(remaining_amount) as remaining_amount"),
            DB::raw("SUM(grand_total) as grand_total")
        )
            ->orderBy(DB::raw("YEAR(product_purchase_date)"))
            ->groupBy(DB::raw("YEAR(product_purchase_date)"))
            ->get();

        $res[] = ['Year', 'Total Bill', 'Grand Total', 'Paid Amount', 'Remaining Amount'];
        foreach ($PurchaseInvProd as $key => $val) {
            $res[++$key] = [$val->year, (int)$val->total_bill, (int)$val->paid_amount, (int)$val->remaining_amount, (int)$val->grand_total];
        }

        $PurchaseInvProdMonth = PurchaseInvProd::select(
            DB::raw("MONTHNAME(product_purchase_date) as MONTHNAME"),
            DB::raw("SUM(total_bill) as total_bill"),
            DB::raw("SUM(paid_amount) as paid_amount"),
            DB::raw("SUM(remaining_amount) as remaining_amount"),
            DB::raw("SUM(grand_total) as grand_total")
        )
            ->whereYear('product_purchase_date', date('Y'))
            ->orderBy(DB::raw("MONTHNAME(product_purchase_date)"))
            ->groupBy(DB::raw("MONTHNAME(product_purchase_date)"))
            ->get();

        $ress[] = ['MONTHNAME', 'Total Bill', 'Grand Total', 'Paid Amount', 'Remaining Amount'];
        foreach ($PurchaseInvProdMonth as $key => $val) {
            $ress[++$key] = [$val->MONTHNAME, (int)$val->total_bill, (int)$val->paid_amount, (int)$val->remaining_amount, (int)$val->grand_total];
        }

        $PurchaseInvProdDayWise = PurchaseInvProd::select(
            DB::raw("DATE(product_purchase_date) as DATE"),
            DB::raw("SUM(total_bill) as total_bill"),
            DB::raw("SUM(paid_amount) as paid_amount"),
            DB::raw("SUM(remaining_amount) as remaining_amount"),
            DB::raw("SUM(grand_total) as grand_total")
        )
            ->whereMonth('product_purchase_date', $thisMonth)
            ->whereYear('product_purchase_date', $thisYear)
            ->orderBy(DB::raw("DATE(product_purchase_date)"))
            ->groupBy(DB::raw("DATE(product_purchase_date)"))
            ->get();

        $resday[] = ['DATE', 'Total Bill', 'Grand Total', 'Paid Amount', 'Remaining Amount'];
        foreach ($PurchaseInvProdDayWise as $key => $val) {
            $resday[++$key] = [$val->DATE, (int)$val->total_bill, (int)$val->paid_amount, (int)$val->remaining_amount, (int)$val->grand_total];
        }

        //    Purchase Product Inver   End -----------------------------------------------------------------------------------------------------

        $PurchaseInvitem = PruchaseItem::join('ingredients','ingredients.id','pruchase_items.prod_id')->select(
            DB::raw("ingredients.ingredient_name as item"),
            DB::raw("SUM(pruchase_items.total_price) as total_price"),
            DB::raw("SUM(pruchase_items.qty) as qty"),
            DB::raw("SUM(pruchase_items.total_weight) as total_weight"))
        ->groupBy('ingredients.ingredient_name',DB::raw("YEAR(pruchase_items.created_at)"))
        ->get();

        $PurchaseInvitemres[] = ['Item','Total Price', 'TotalQty','T-Weight'];
        foreach ($PurchaseInvitem as $key => $val) {
        $PurchaseInvitemres[++$key] = [$val->item, (int)$val->total_price, (int)$val->qty, (int)$val->total_weight];
        }


        return view('admin.dashboards.purchase_inv_graph',$data)->with('PurchaseInvProd', json_encode($res))
                                                        ->with('PurchaseInvProdMonth', json_encode($ress))
                                                        ->with('PurchaseInvProdDayWise', json_encode($resday))
                                                        ->with('PurchaseInvitem', json_encode($PurchaseInvitemres));
    }


     public function KitchenStockGraph()
     {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');


           //-------------- Kitchen  Waste Log  Start  -------------------->


           $visitors = KitchenWastelog::select(
            DB::raw('SUM(kitchen_cuurent_stock) as total_kitchen_cuurent_stock'),
            DB::raw('SUM(waste_stock) as total_waste_stock'),
        )
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $result[] = ['Kitchen Current Stock', 'Kitchen Waste Stock'];
        foreach ($visitors as $key => $value) {
            $result[++$key] = ["Kitchen Current Stock", (int)$value->total_kitchen_cuurent_stock];
            $result[++$key] = ["Kitchen Waste Stock", (int)$value->total_waste_stock];
        }

        $kitchenwastelogmonth = KitchenWastelog::select(
            DB::raw('SUM(kitchen_cuurent_stock) as total_kitchen_cuurent_stock'),
            DB::raw('SUM(waste_stock) as total_waste_stock'),
        )
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $resultmonthkitwastelog[] = ['total_kitchen_cuurent_stock', 'total_waste_stock'];
        foreach ($kitchenwastelogmonth as $key => $value) {
            $resultmonthkitwastelog[++$key] = ["Kitchen Current Stock", (int)$value->total_kitchen_cuurent_stock];
            $resultmonthkitwastelog[++$key] = ["Kitchen Waste Stock", (int)$value->total_waste_stock];
        }



        //-------------- Kitchen  Waste Log  End  -------------------->

        //-------------- Kitchen  UseStock Log  Start  -------------------->

        $KitchenUseStockyear = KitchenUseStocklog::select(
            DB::raw('SUM(kitchen_current_stock) as total_kitchen_current_stock'),
            DB::raw('SUM(usestock_stock) as total_usestock_stock'),
        )
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $YearStockKit[] = ['Kitchen Current Stock', 'Kitchen Use Stock'];
        foreach ($KitchenUseStockyear as $key => $value) {
            $YearStockKit[++$key] = ["Kitchen Current Stock", (int)$value->total_kitchen_current_stock];
            $YearStockKit[++$key] = ["Kitchen Use Stock", (int)$value->total_usestock_stock];
        }


        $kitchenuselogmonth = KitchenUseStocklog::select(
            DB::raw('SUM(kitchen_current_stock) as total_kitchen_current_stock'),
            DB::raw('SUM(usestock_stock) as total_usestock_stock'),
        )
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $resultmonthkuselog[] = ['total_kitchen_current_stock', 'total_usestock_stock'];
        foreach ($kitchenuselogmonth as $key => $value) {
            $resultmonthkuselog[++$key] = ["Total Kitchen Current Stock", (int)$value->total_kitchen_current_stock];
            $resultmonthkuselog[++$key] = ["Total Kitchen Use Stock", (int)$value->total_usestock_stock];
        }
        //-------------- Kitchen  UseStock Log  End  -------------------->


   

        return view('admin.dashboards.kitchen_stock_graph')->with(compact('result','resultmonthkitwastelog','YearStockKit',
        'resultmonthkuselog'
        ));
     }


    public function TableBookingGraph()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');


           //    Table Booking amount   start -----------------------------------------------------------------------------------------------------

           $data['totalTableBookingAmt'] = TableBooking::where('table_booking_status', 'Table Booking Confirm')->sum('payment_amount');
           $data['todayTableBookingAmt'] = TableBooking::whereDate('created_at', $todayDate)->where('table_booking_status', 'Table Booking Confirm')->sum('payment_amount');
           $data['MonthsTableBookingAmt'] = TableBooking::whereMonth('created_at', $thisMonth)->where('table_booking_status', 'Table Booking Confirm')->whereYear('created_at', $thisYear)->sum('payment_amount');
           $data['YearTableBookingAmt'] = TableBooking::whereYear('created_at', $thisYear)->where('table_booking_status', 'Table Booking Confirm')->sum('payment_amount');
   

           $daywisetableBooking = TableBooking::select(
            DB::raw("SUM(payment_amount) as payment_amount"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
             ->where('table_booking_status', 'Table Booking Confirm')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('payment_amount', 'date');


        $data['daywisetableBookinglabels'] = $daywisetableBooking->keys();
        $data['daywisetableBookingdata'] = $daywisetableBooking->values();

        $stablebookorderSum = TableBooking::select(DB::raw("SUM(payment_amount) as payment_amount"), DB::raw("MONTHNAME(created_at) as month_name"))
             ->where('table_booking_status', 'Table Booking Confirm')
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('payment_amount', 'month_name');

        $data['stablebookorderSumlabels'] = $stablebookorderSum->keys();
        $data['stablebookorderSumdata'] = $stablebookorderSum->values();



        $stablebookYearSum = TableBooking::select(DB::raw("SUM(payment_amount) as payment_amount"), DB::raw("YEAR(created_at) as year"))
        ->where('table_booking_status', 'Table Booking Confirm')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('payment_amount', 'year');

        $data['stablebookYearSumlabels'] = $stablebookYearSum->keys();
        $data['stablebookYearSumdata'] = $stablebookYearSum->values();
   
   
           //    Table  Booking amount   End ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


        return view('admin.dashboards.table_booking_graph', $data);

    }


    public function FreeItemDetails()
    {
        $title = "Menu Item List";
        $menuitemPrice = MenuItemPrice::get()->toArray();
        return view('admin.dashboards.menu_item',compact('menuitemPrice','title'));
    }

    public function FreeItemIdDetails($item_id)
    {

         $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');


            $data['menuitemlt'] = MenuItemPrice::where('id', $item_id)->first('menu_item_name')->toArray();

        $data['tableitemfreeDay'] = DB::table('orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum('no_qty_buy_to_free');
        $data['takeweyitemfreeDay'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum('no_qty_buy_to_free');
        $data['totalitemfreeDay']=  $data['tableitemfreeDay'] + $data['takeweyitemfreeDay'];

         $data['tableitemfreeMonth'] = DB::table('orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum('no_qty_buy_to_free');
         $data['takeweyitemfreeMonth'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum('no_qty_buy_to_free');
         $data['totalitemfreeMonth']=  $data['tableitemfreeMonth'] + $data['takeweyitemfreeMonth'];

         $data['tableitemfreeYear'] = DB::table('orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum('no_qty_buy_to_free');
         $data['takeweyitemfreeYear'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum('no_qty_buy_to_free');
         $data['totalitemfreeYear']=  $data['tableitemfreeYear'] + $data['takeweyitemfreeYear'];

     ///   Free Item  Qty Sum  End------------------------------

     /// 
     $data['TotaltableitemfreeDay'] = DB::table('orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('price * no_qty_buy_to_free'));
     $data['TotaltakeweyitemfreeDay'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('price * no_qty_buy_to_free'));
     $data['totalitemfreeAmtDay']=  $data['TotaltableitemfreeDay'] + $data['TotaltakeweyitemfreeDay'];

      $data['TotaltableitemfreeMonth'] = DB::table('orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('price * no_qty_buy_to_free'));
      $data['TotaltakeweyitemfreeMonth'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('price * no_qty_buy_to_free'));
      $data['totalitemfreeAmtMonth']=  $data['TotaltableitemfreeMonth'] + $data['TotaltakeweyitemfreeMonth'];

      $data['TotaltableitemfreeYear'] = DB::table('orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('price * no_qty_buy_to_free'));
      $data['TotaltakeweyitemfreeYear'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('price * no_qty_buy_to_free'));
      $data['totalitemfreeAmtYear']=  $data['TotaltableitemfreeYear'] + $data['TotaltakeweyitemfreeYear'];

   
        return view('admin.dashboards.free_item_order_graph',$data);
    }

    public function DiscountOrderGraph()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');



     ///   Free Item  Total Loss Sum  End------------------------------

     /// 
     $data['TotaltableitemfreeDay'] = DB::table('restaurant_orders')->where('coupon_per','>','0')->whereDate('created_at', $todayDate)->sum(DB::raw('sub_total - subtotalwithoffer'));
     $data['TotaltakeweyitemfreeDay'] = DB::table('take_way_orders')->where('coupon_per','>','0')->whereDate('created_at', $todayDate)->sum(DB::raw('sub_total - subtotalwithoffer'));
     $data['totalitemfreeAmtDay']=  $data['TotaltableitemfreeDay'] + $data['TotaltakeweyitemfreeDay'];

      $data['TotaltableitemfreeMonth'] = DB::table('restaurant_orders')->where('coupon_per','>','0')->whereMonth('created_at', $thisMonth)->sum(DB::raw('sub_total - subtotalwithoffer'));
      $data['TotaltakeweyitemfreeMonth'] = DB::table('take_way_orders')->where('coupon_per','>','0')->whereMonth('created_at', $thisMonth)->sum(DB::raw('sub_total - subtotalwithoffer'));
      $data['totalitemfreeAmtMonth']=  $data['TotaltableitemfreeMonth'] + $data['TotaltakeweyitemfreeMonth'];

      $data['TotaltableitemfreeYear'] = DB::table('restaurant_orders')->where('coupon_per','>','0')->whereYear('created_at', $thisYear)->sum(DB::raw('sub_total - subtotalwithoffer'));
      $data['TotaltakeweyitemfreeYear'] = DB::table('take_way_orders')->where('coupon_per','>','0')->whereYear('created_at', $thisYear)->sum(DB::raw('sub_total - subtotalwithoffer'));
      $data['totalitemfreeAmtYear']=  $data['TotaltableitemfreeYear'] + $data['TotaltakeweyitemfreeYear'];


     
 $daywisetables = RestaurantOrder::select(
            DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('coupon_per','>','0')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('total_discount', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('coupon_per','>','0')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('total_discount', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


            $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"), DB::raw("MONTHNAME(created_at) as month_name"))
             ->where('coupon_per','>','0')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('total_discount', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"), DB::raw("MONTHNAME(created_at) as month_name"))
             ->where('coupon_per','>','0')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('total_discount', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"), DB::raw("YEAR(created_at) as year"))
             ->where('coupon_per','>','0')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('total_discount', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(sub_total - subtotalwithoffer) as total_discount"), DB::raw("YEAR(created_at) as year"))
             ->where('coupon_per','>','0')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('total_discount', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();


        return view('admin.dashboards.discount_order_graph', $data);

    }


    public function DefectMenuItem()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');


         
           $data['totalTableBookingAmt'] = Orderitem::where('order_waste_remark','!=','NULL')->sum('item_qty');
           $data['todayOrderitemAmt'] = Orderitem::whereDate('created_at', $todayDate)->where('order_waste_remark','!=','NULL')->sum('item_qty');
           $data['MonthsOrderitemAmt'] = Orderitem::whereMonth('created_at', $thisMonth)->where('order_waste_remark','!=','NULL')->whereYear('created_at', $thisYear)->sum('item_qty');
           $data['YearOrderitemAmt'] = Orderitem::whereYear('created_at', $thisYear)->where('order_waste_remark','!=','NULL')->sum('item_qty');

           $data['totalTabdefectAmt'] = Orderitem::where('order_waste_remark','!=','NULL')->sum('amount');
           $data['todaydefectAmt'] = Orderitem::whereDate('created_at', $todayDate)->where('order_waste_remark','!=','NULL')->sum('amount');
           $data['MonthsdefectAmt'] = Orderitem::whereMonth('created_at', $thisMonth)->where('order_waste_remark','!=','NULL')->whereYear('created_at', $thisYear)->sum('amount');
           $data['YeardefectAmt'] = Orderitem::whereYear('created_at', $thisYear)->where('order_waste_remark','!=','NULL')->sum('amount');


        $data['itemfreelist'] = Orderitem::where('order_waste_remark','!=','NULL')->get();
        return view('admin.dashboards.defect_menu_item', $data);
    }

    public function SellingMenuItem()
    {
        $title = "Menu Item List";
        // $menuitemPrice = MenuItemPrice::get()->toArray();
        try {
         $orderitems = Orderitem::with('menuitem','takeaway')->groupBy('item_id')->get();

   
 }catch (Exception $exception) {
                    DB::rollback();
                        return redirect()->back()->with('error_message', $exception->getMessage());
                
                }
       
        return view('admin.dashboards.selling_menu_item_list',compact('title','orderitems'));
    }

    public function SellingMenuItemWiseList($item_id)
    {

         $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

            $data['menuitemlt'] = MenuItemPrice::where('id', $item_id)->first('menu_item_name')->toArray();

        $data['tableitemfreeDay'] = DB::table('orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('no_qty_buy_to_free + item_qty'));
        $data['takeweyitemfreeDay'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('no_qty_buy_to_free + item_qty'));
        $data['totalitemfreeDay']=  $data['tableitemfreeDay'] + $data['takeweyitemfreeDay'];

         $data['tableitemfreeMonth'] = DB::table('orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('no_qty_buy_to_free + item_qty'));
         $data['takeweyitemfreeMonth'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('no_qty_buy_to_free + item_qty'));
         $data['totalitemfreeMonth']=  $data['tableitemfreeMonth'] + $data['takeweyitemfreeMonth'];

         $data['tableitemfreeYear'] = DB::table('orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('item_qty+no_qty_buy_to_free'));
        
         $data['takeweyitemfreeYear'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('item_qty+no_qty_buy_to_free'));
         $data['totalitemfreeYear']=  $data['tableitemfreeYear'] + $data['takeweyitemfreeYear'];

     ///   Free Item  Qty Sum  End------------------------------

     /// 
     $data['TotaltableitemfreeDay'] = DB::table('orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('price *(no_qty_buy_to_free + item_qty)'));
        $data['TotaltakeweyitemfreeDay'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereDate('created_at', $todayDate)->sum(DB::raw('price * (no_qty_buy_to_free + item_qty) '));
     $data['totalitemfreeAmtDay']=  $data['TotaltableitemfreeDay'] + $data['TotaltakeweyitemfreeDay'];

      $data['TotaltableitemfreeMonth'] = DB::table('orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('price * (no_qty_buy_to_free + item_qty) '));
      $data['TotaltakeweyitemfreeMonth'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereMonth('created_at', $thisMonth)->sum(DB::raw('price * (no_qty_buy_to_free + item_qty) '));
      $data['totalitemfreeAmtMonth']=  $data['TotaltableitemfreeMonth'] + $data['TotaltakeweyitemfreeMonth'];

      $data['TotaltableitemfreeYear'] = DB::table('orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('price * (no_qty_buy_to_free + item_qty) '));
      $data['TotaltakeweyitemfreeYear'] = DB::table('take_way_orderitems')->where('item_id', $item_id)->whereYear('created_at', $thisYear)->sum(DB::raw('price * (no_qty_buy_to_free + item_qty) '));
      $data['totalitemfreeAmtYear']=  $data['TotaltableitemfreeYear'] + $data['TotaltakeweyitemfreeYear'];

   
        return view('admin.dashboards.selling_menu_itemWsie_details',$data);
    }


    public function DeliveryBoyDashboard()
    {
        return view('admin.dashboards.delivery_boy_dashboard');
    }  
    
      public function NCReport()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $tableOderSale = RestaurantOrder::where('payableamt', '=', "NC")->get();
        $takeOderSale = TakeWayOrder::where('payableamt', '=', 'NC')->get();

        $tableOderSaledis = DB::table('restaurant_orders')->where('payableamt', '=', "NC")->sum(DB::raw('grand_total'));
        $takeOderSaledis = DB::table('take_way_orders')->where('payableamt', '=', "NC")->sum(DB::raw('grand_total'));

        $overallsaledis = $tableOderSaledis + $takeOderSaledis;

        $daywisetables = RestaurantOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payableamt', '=', 'NC')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("SUM(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('payableamt', '=', 'NC')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payableamt', '=', 'NC')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('payableamt', '=', 'NC')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payableamt', '=', 'NC')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("SUM(grand_total) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('payableamt', '=', 'NC')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();


        return view('admin.dashboards.nc_report', $data, compact('tableOderSale', 'takeOderSale', 'overallsaledis'));
    }
       public function NumbersBillReport()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        
        $tableOderSaledis = DB::table('restaurant_orders')->count(DB::raw('id'));
        $takeOderSaledis = DB::table('take_way_orders')->count(DB::raw('id'));

        $overallsaledis = $tableOderSaledis + $takeOderSaledis;

        $daywisetables = RestaurantOrder::select(
            DB::raw("count(id) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
           
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("count(grand_total) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
             
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("count(id) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("count(id) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
             
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("count(id) as grand_total"), DB::raw("YEAR(created_at) as year"))
           
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("count(id) as grand_total"), DB::raw("YEAR(created_at) as year"))
 
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();


        return view('admin.dashboards.no_bill_generated_report', $data, compact('overallsaledis'));
    }
    public function UsedCouponReport()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
       
        $tableOderSaledis = DB::table('restaurant_orders')->where('coupon_per','>','0')->count(DB::raw('id'));
        $takeOderSaledis = DB::table('take_way_orders')->where('payableamt', '=', "NC")->count(DB::raw('id'));

        $overallsaledis = $tableOderSaledis + $takeOderSaledis;

        $daywisetables = RestaurantOrder::select(
            DB::raw("count(id) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('coupon_per','>','0')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetablelabelsCash'] = $daywisetables->keys();
        $data['daywisetabledataCash'] = $daywisetables->values();
        $daywisetakeaways = TakeWayOrder::select(
            DB::raw("count(id) as grand_total"),
            DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as date")
        )
            ->where('coupon_per','>','0')
            ->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)
            ->groupBy('created_at')
            ->pluck('grand_total', 'date');
        $data['daywisetakeawaylabelsCash'] = $daywisetakeaways->keys();
        $data['daywisetakeawaydataCash'] = $daywisetakeaways->values();


        $takeWayorderSum = TakeWayOrder::select(DB::raw("count(id) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('coupon_per','>','0')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $data['takeWayOrderlabelsCash']  = $takeWayorderSum->keys();
        $data['takeWayOrderdataCash']  = $takeWayorderSum->values();
        $stableorderSum = RestaurantOrder::select(DB::raw("count(id) as grand_total"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('coupon_per','>','0')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');

        $data['stableorderSumlabelsCash'] = $stableorderSum->keys();
        $data['stableorderSumdataCash'] = $stableorderSum->values();


        $stableorderYearSums = RestaurantOrder::select(DB::raw("count(id) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('coupon_per','>','0')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TablesYearSalelabels'] = $stableorderYearSums->keys();
        $data['TablesYearSaledata'] = $stableorderYearSums->values();


        $TakeWayorderYearSums = TakeWayOrder::select(DB::raw("count(id) as grand_total"), DB::raw("YEAR(created_at) as year"))
            ->where('coupon_per','>','0')
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->pluck('grand_total', 'year');

        $data['TakeWaysYearSalelabels'] = $TakeWayorderYearSums->keys();
        $data['TakeWaysYearSaledata'] = $TakeWayorderYearSums->values();


        return view('admin.dashboards.usedcouponorder_report', $data, compact('overallsaledis'));
    }
    
      public function FoodSellReport()
    {

        $todayDate = Carbon::now()->format('Y-m-d');
       $thisMonth = Carbon::now()->format('m');
       $thisYear = Carbon::now()->format('Y');


           
       $data['tableitemfreeDay'] = DB::table('orderitems')->where('order_type', "restaurant-menu")->whereDate('created_at', $todayDate)->sum('amount');
       $data['takeweyitemfreeDay'] = DB::table('bar_table_order_items')->where('order_type', "restaurant-menu")->whereDate('created_at', $todayDate)->sum('amount');
       $data['totalitemfreeDay']=  $data['tableitemfreeDay'] + $data['takeweyitemfreeDay'];

        $data['tableitemfreeMonth'] = DB::table('orderitems')->where('order_type', "restaurant-menu")->whereMonth('created_at', $thisMonth)->sum('amount');
        $data['takeweyitemfreeMonth'] = DB::table('bar_table_order_items')->where('order_type', "restaurant-menu")->whereMonth('created_at', $thisMonth)->sum('amount');
        $data['totalitemfreeMonth']=  $data['tableitemfreeMonth'] + $data['takeweyitemfreeMonth'];

        $data['tableitemfreeYear'] = DB::table('orderitems')->where('order_type', "restaurant-menu")->whereYear('created_at', $thisYear)->sum('amount');
        $data['takeweyitemfreeYear'] = DB::table('bar_table_order_items')->where('order_type', "restaurant-menu")->whereYear('created_at', $thisYear)->sum('amount');
        $data['totalitemfreeYear']=  $data['tableitemfreeYear'] + $data['takeweyitemfreeYear'];

    
       return view('admin.dashboards.foodsell_report',$data);
   }
     
   public function BarSellReport()
   {

       $todayDate = Carbon::now()->format('Y-m-d');
      $thisMonth = Carbon::now()->format('m');
      $thisYear = Carbon::now()->format('Y');


          
      $data['tableitemfreeDay'] = DB::table('orderitems')->where('order_type', "bar-menu")->whereDate('created_at', $todayDate)->sum('amount');
      $data['takeweyitemfreeDay'] = DB::table('bar_table_order_items')->where('order_type', "bar-menu")->whereDate('created_at', $todayDate)->sum('amount');
      $data['totalitemfreeDay']=  $data['tableitemfreeDay'] + $data['takeweyitemfreeDay'];

       $data['tableitemfreeMonth'] = DB::table('orderitems')->where('order_type', "bar-menu")->whereMonth('created_at', $thisMonth)->sum('amount');
       $data['takeweyitemfreeMonth'] = DB::table('bar_table_order_items')->where('order_type', "bar-menu")->whereMonth('created_at', $thisMonth)->sum('amount');
       $data['totalitemfreeMonth']=  $data['tableitemfreeMonth'] + $data['takeweyitemfreeMonth'];

       $data['tableitemfreeYear'] = DB::table('orderitems')->where('order_type', "bar-menu")->whereYear('created_at', $thisYear)->sum('amount');
       $data['takeweyitemfreeYear'] = DB::table('bar_table_order_items')->where('order_type', "bar-menu")->whereYear('created_at', $thisYear)->sum('amount');
       $data['totalitemfreeYear']=  $data['tableitemfreeYear'] + $data['takeweyitemfreeYear'];


      
   
      return view('admin.dashboards.barsell_report',$data);
  }
  
   public function VendorDashboard()
  {
    return view('admin.dashboards.vendor_dashboard');
  }
  
    public function TopSellingMenuReport()
    {
        $title = "Menu Item List";
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        // $menuitemPrice = MenuItemPrice::get()->toArray();
        try {
        
         $orderitemstoday = Orderitem::with('menuitem','takeaway')->whereDate('created_at', $todayDate)->groupBy('item_id')->paginate(10);
         $orderitemsmonth = Orderitem::with('menuitem','takeaway')->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->groupBy('item_id')->paginate(10);
         $orderitemsyear = Orderitem::with('menuitem','takeaway')->whereYear('created_at', $thisYear)->groupBy('item_id')->paginate(10);

   
            }catch (Exception $exception) {
                    DB::rollback();
                        return redirect()->back()->with('error_message', $exception->getMessage());
                
                }
       
        return view('admin.dashboards.topselling_menu_report',compact('title','orderitemstoday','orderitemsmonth','orderitemsyear'));
    }

   
}
