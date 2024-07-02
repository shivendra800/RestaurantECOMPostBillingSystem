<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\ExtraMenu;
use App\Models\Orderitem;
use App\Models\MenuCategory;
use App\Models\OrderWiseTax;
use App\Models\TakeWayOrder;
use Illuminate\Http\Request;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Models\RestaurantOrder;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class RestaurantOrderController extends Controller
{

    public function SelectTable()
    {
        $tables = Table::where('status', 1)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.restaurantorders.select_table')->with(compact('tables', 'coupononprice', 'productWiseCoupon'));
    }
    public function TakeOrderSave(Request $request, $id)
    {


        if ($request->isMethod('post')) {
            $data = $request->all();


            if ($request->item_id == null) {

                $notification = array(
                    'message' => 'Sorry you do not select any item',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);

            } else {
                DB::beginTransaction();
                $restorder = new RestaurantOrder();
                $restorder->table_id = $data['table_id'];
                $restorder->total_no_person_intable = $data['total_no_person_intable'];
                $restorder->payableamt = $data['payableamt'];
                $restorder->nc_remark = $data['nc_remark'];
                $restorder->staff_id = Auth::guard('admin')->user()->staff_id;
                $restorder->grand_total = 0;
                date_default_timezone_set("Asia/Calcutta");
                $restorder->order_time = date('d-m-Y H:i:s');

                $restorder->save();

                #Store Unique Order/Product Number
                $unique_no = RestaurantOrder::orderBy('id', 'DESC')->pluck('id')->first();
                if ($unique_no == null or $unique_no == "") {
                    #If Table is Empty
                    $unique_no = 1;
                } else {
                    #If Table has Already some Data
                    $unique_no = $unique_no + 1;
                }
                $restorder->order_no = 'PROD' . $unique_no;
                $restorder->save();
                #Store Unique Order/Product Number
                $uniqueitemid = Orderitem::orderBy('id', 'DESC')->pluck('id')->first();
                if ($uniqueitemid == null or $uniqueitemid == "") {
                    #If Table is Empty
                    $uniqueitemid = 1;
                } else {
                    #If Table has Already some Data
                    $uniqueitemid = $uniqueitemid + 1;
                }

                foreach ($data['item_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $update_vendor_tbl = MenuItemPrice::where('id', $data['item_id'])->first();
                        $orderitem = new Orderitem();
                        $orderitem->order_no = 'PROD' . $unique_no;
                        $orderitem->group_item = 'GroupItem-' . $uniqueitemid;
                        $orderitem->order_type = $data['itemtype'][$key];
                        $orderitem->subcategory_id = $data['menu_subcat_id'][$key];
                        $orderitem->item_id = $data['item_id'][$key];
                        $orderitem->price = $data['price'][$key];
                        $orderitem->item_qty = $data['item_qty'][$key];
                        $orderitem->item_serve_time = $data['item_serve_time'][$key];
                        $orderitem->remark = $data['remark'][$key];
                        $orderitem->extra_menu_item_id = $data['extra_menu_item_id'][$key];
                        $orderitem->extraItemPrice = $data['extraItemPrice'][$key];
                        // offer
                        $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                        if ($data['no_qty_buy_to_free'][$key] == NULL) {
                            $orderitem->no_qty_buy_to_free = 0;
                        } else {
                            $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                        }
                        // offer end
                        $getamount = $data['price'][$key] * $data['item_qty'][$key];
                        $orderitem->amount = $getamount + $data['extraItemPrice'][$key];

                        //  $restorder->order_no = 0;

                        //  date_default_timezone_set("Asia/Calcutta");
                        //  $restorder->created_at = date('d-m-Y H:i:s');
                        $orderitem->save();
                    }
                }

                $tablestatus = Table::where('id', $data['table_id'])->first();
                $tablestatus->booking_status = 1;
                $tablestatus->table_order_no = 'PROD' . $unique_no;
                $tablestatus->save();
                DB::commit();

                return redirect('admin/today-orders');
            }
        }
        $tables = Table::where('status', 1)->where('booking_status', 0)->get();
        $gettableselect = Table::where('id', $id)->first();
        $menuitems = MenuItemPrice::where('status', 1)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        $getExtraitem = ExtraMenu::get();
        return view('admin.restaurantorders.take_order')->with(compact('tables', 'getExtraitem', 'menuitems', 'coupononprice', 'productWiseCoupon', 'gettableselect'));
    }
    public function TodayOrdersList()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        if (Auth::guard('admin')->user()->type == "Admin") {
            $todayorderlist = RestaurantOrder::with('tables', 'staffs')->where('created_at', $todayDate)->latest('order_no')->get();

        } else {

            $todayorderlist = RestaurantOrder::with('tables', 'staffs')->where('order_status', '!=', 'Order Completed')->where('created_at', $todayDate)->where('staff_id', Auth::guard('admin')->user()->staff_id)->latest('order_no')->get();
        }


        return view('admin.restaurantorders.today_order_list')->with(compact('todayorderlist'));
    }
    public function DeleteTableOrder($orderno)
    {

        $getorderId = RestaurantOrder::where('order_no',$orderno)->first();
        try {

             Orderitem::where('order_no',$orderno)->delete();
            $tablestatus = Table::where('id', $getorderId['table_id'])->first();
            $tablestatus->booking_status = 0;
            $tablestatus->table_order_no = 0;
            $tablestatus->save();
            RestaurantOrder::where('order_no',$orderno)->delete();
            $message = "Data is Delete Successfully!";
            return redirect()->back()->with('success_message', $message);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                $message = "data cant be deleted";
                return redirect()->back()->with('error_message', $message);
            }
        }
    }

    public function TodayCompleteOrdersList()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayorderlist = RestaurantOrder::with('tables', 'staffs')->where('order_status', '=', 'Order Completed')->where('created_at', $todayDate)->where('staff_id', Auth::guard('admin')->user()->staff_id)->latest('order_no')->get();
        return view('admin.restaurantorders.today_complete_order_list')->with(compact('todayorderlist'));
    }
    public function TableOrdersList()
    {
        $totalorderlist = RestaurantOrder::with('tables', 'staffs')->latest('order_no')->get();
        $overallcollectionwithGSt = RestaurantOrder::sum('grand_total');
        $overallcollectionwithoutGSt = RestaurantOrder::sum('total_tax');

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $data['totalTableOrdersale'] = RestaurantOrder::sum('grand_total');
        $data['todayTablesale'] = RestaurantOrder::whereDate('created_at', $todayDate)->sum('grand_total');
        $data['MonthsTablesale'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesale'] = RestaurantOrder::whereYear('created_at', $thisYear)->sum('grand_total');

        $data['totalTableOrdersaleCash'] = RestaurantOrder::where('payment_mode', 'Cash')->sum('grand_total');
        $data['todayTablesaleCash'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Cash')->sum('grand_total');
        $data['MonthsTablesaleCash'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Cash')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleCash'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Cash')->sum('grand_total');

        $data['totalTableOrdersaleCashCount'] = RestaurantOrder::where('payment_mode', 'Cash')->count();
        $data['todayTablesaleCashCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Cash')->count();
        $data['MonthsTablesaleCashCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Cash')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleCashCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Cash')->count();

        $data['totalTableOrdersaleQRCodeWithSlip'] = RestaurantOrder::where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');
        $data['todayTablesaleQRCodeWithSlip'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');
        $data['MonthsTablesaleQRCodeWithSlip'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'QRCodeWithSlip')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleQRCodeWithSlip'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');

        $data['totalTableOrdersaleQRCodeWithSlipCount'] = RestaurantOrder::where('payment_mode', 'QRCodeWithSlip')->count();
        $data['todayTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'QRCodeWithSlip')->count();
        $data['MonthsTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'QRCodeWithSlip')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'QRCodeWithSlip')->count();

        $data['totalTableOrdersaleCardSwip'] = RestaurantOrder::where('payment_mode', 'Card Swip')->sum('grand_total');
        $data['todayTablesaleCardSwip'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Card Swip')->sum('grand_total');
        $data['MonthsTablesaleCardSwip'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Card Swip')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleCardSwip'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Card Swip')->sum('grand_total');

        $data['totalTableOrdersaleCardSwipCount'] = RestaurantOrder::where('payment_mode', 'Card Swip')->count();
        $data['todayTablesaleCardSwipCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Card Swip')->count();
        $data['MonthsTablesaleCardSwipCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Card Swip')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleCardSwipCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Card Swip')->count();

        $data['totalTableOrdersalePaidRazorpay'] = RestaurantOrder::where('payment_mode', 'Paid by Razorpay')->sum('grand_total');
        $data['todayTablesalePaidRazorpay'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Paid by Razorpay')->sum('grand_total');
        $data['MonthsTablesalePaidRazorpay'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Paid by Razorpay')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesalePaidRazorpay'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Paid by Razorpay')->sum('grand_total');

        $data['totalTableOrdersalePaidRazorpayCount'] = RestaurantOrder::where('payment_mode', 'Paid by Razorpay')->count();
        $data['todayTablesalePaidRazorpayCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Paid by Razorpay')->count();
        $data['MonthsTablesalePaidRazorpayCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Paid by Razorpay')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesalePaidRazorpayCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Paid by Razorpay')->count();



        return view('admin.restaurantorders.total_order_list', $data)->with(compact('totalorderlist', 'overallcollectionwithGSt', 'overallcollectionwithoutGSt'));
    }

    public function TableOrdersSearchDateWsie(Request $request)
    {
        $totalorderlist = RestaurantOrder::with('tables', 'staffs')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get()->toArray();
        $overallcollectionwithGSt = RestaurantOrder::whereBetween('created_at', [$request->start_date, $request->end_date])
            ->sum('grand_total');
        $overallcollectionwithoutGSt = RestaurantOrder::whereBetween('created_at', [$request->start_date, $request->end_date])
            ->sum('total_tax');
        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $data['totalTableOrdersale'] = RestaurantOrder::sum('grand_total');
        $data['todayTablesale'] = RestaurantOrder::whereDate('created_at', $todayDate)->sum('grand_total');
        $data['MonthsTablesale'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesale'] = RestaurantOrder::whereYear('created_at', $thisYear)->sum('grand_total');

        $data['totalTableOrdersaleCash'] = RestaurantOrder::where('payment_mode', 'Cash')->sum('grand_total');
        $data['todayTablesaleCash'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Cash')->sum('grand_total');
        $data['MonthsTablesaleCash'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Cash')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleCash'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Cash')->sum('grand_total');

        $data['totalTableOrdersaleCashCount'] = RestaurantOrder::where('payment_mode', 'Cash')->count();
        $data['todayTablesaleCashCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Cash')->count();
        $data['MonthsTablesaleCashCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Cash')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleCashCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Cash')->count();

        $data['totalTableOrdersaleQRCodeWithSlip'] = RestaurantOrder::where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');
        $data['todayTablesaleQRCodeWithSlip'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');
        $data['MonthsTablesaleQRCodeWithSlip'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'QRCodeWithSlip')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleQRCodeWithSlip'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'QRCodeWithSlip')->sum('grand_total');

        $data['totalTableOrdersaleQRCodeWithSlipCount'] = RestaurantOrder::where('payment_mode', 'QRCodeWithSlip')->count();
        $data['todayTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'QRCodeWithSlip')->count();
        $data['MonthsTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'QRCodeWithSlip')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleQRCodeWithSlipCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'QRCodeWithSlip')->count();

        $data['totalTableOrdersaleCardSwip'] = RestaurantOrder::where('payment_mode', 'Card Swip')->sum('grand_total');
        $data['todayTablesaleCardSwip'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Card Swip')->sum('grand_total');
        $data['MonthsTablesaleCardSwip'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Card Swip')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesaleCardSwip'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Card Swip')->sum('grand_total');

        $data['totalTableOrdersaleCardSwipCount'] = RestaurantOrder::where('payment_mode', 'Card Swip')->count();
        $data['todayTablesaleCardSwipCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Card Swip')->count();
        $data['MonthsTablesaleCardSwipCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Card Swip')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesaleCardSwipCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Card Swip')->count();

        $data['totalTableOrdersalePaidRazorpay'] = RestaurantOrder::where('payment_mode', 'Paid by Razorpay')->sum('grand_total');
        $data['todayTablesalePaidRazorpay'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Paid by Razorpay')->sum('grand_total');
        $data['MonthsTablesalePaidRazorpay'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Paid by Razorpay')->whereYear('created_at', $thisYear)->sum('grand_total');
        $data['YearTablesalePaidRazorpay'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Paid by Razorpay')->sum('grand_total');

        $data['totalTableOrdersalePaidRazorpayCount'] = RestaurantOrder::where('payment_mode', 'Paid by Razorpay')->count();
        $data['todayTablesalePaidRazorpayCount'] = RestaurantOrder::whereDate('created_at', $todayDate)->where('payment_mode', 'Paid by Razorpay')->count();
        $data['MonthsTablesalePaidRazorpayCount'] = RestaurantOrder::whereMonth('created_at', $thisMonth)->where('payment_mode', 'Paid by Razorpay')->whereYear('created_at', $thisYear)->count();
        $data['YearTablesalePaidRazorpayCount'] = RestaurantOrder::whereYear('created_at', $thisYear)->where('payment_mode', 'Paid by Razorpay')->count();
        return view('admin.restaurantorders.total_order_list', $data)->with(compact('totalorderlist', 'overallcollectionwithGSt', 'overallcollectionwithoutGSt'));
    }

    public function ViewOrdersDetails($order_no)
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $orderlist = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        $ViewOrdersDetails = Orderitem::with('menuitem', 'extraitemadd')->where('order_no', $order_no)->get();
        $menuitems = MenuItemPrice::where('status', 1)->get();
        $OrderWisetaxdet = OrderWiseTax::where('order_no', $order_no)->get();
        $tables = Table::where('status', 1)->where('booking_status', 0)->get();
        $getExtraitem = ExtraMenu::get();
        $getorderTablelist = RestaurantOrder::with('tables')->where('order_status', '!=', 'Order Completed')->where('created_at', $todayDate)->where('table_id', '!=', $orderlist['table_id'])->get();
        return view('admin.restaurantorders.view_today_order_item')->with(compact('getorderTablelist', 'tables', 'getExtraitem', 'orderlist', 'ViewOrdersDetails', 'menuitems', 'OrderWisetaxdet'));
    }

    public function TranserOrederitemToOtherTable(Request $request, $order_no)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            $restorder = Orderitem::where('id', $data['current_order_id'])->first();
            $restorder->order_no = $data['table_wise_order_no'];
            $restorder->save();


            $notification = array(
                'message' => " Table Wise Order Item  Transfer   Successfully!",
                'alert-type' => 'success'
            );


            return redirect('admin/view-order-details/' . $order_no)->with($notification);
        }
    }

    public function TranserCustTable(Request $request, $order_no)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            DB::beginTransaction();
            $restorder = RestaurantOrder::where('order_no', $order_no)->first();
            $get = Table::where('id', $data['table_id'])->first();
            $tablestatus = Table::where('id', $restorder['table_id'])->first();
            $tablestatus->booking_status = 0;
            $tablestatus->table_order_no = 0;
            $tablestatus->save();
            $restorder->table_id = $data['table_id'];
            $restorder->tran_table_remark = "This " . $tablestatus['table_name'] . " trasnfered to " . $get['table_name'];
            $restorder->save();

            $tablestatu = Table::where('id', $data['table_id'])->first();
            $tablestatu->booking_status = 1;
            $tablestatu->table_order_no = $order_no;
            $tablestatu->save();
            DB::commit();
            $notification = array(
                'message' => " Table Transfer   Successfully!",
                'alert-type' => 'success'
            );


            return redirect('admin/view-order-details/' . $order_no)->with($notification);
        }
    }

    public function DeleteOrderItem($id)
    {
        $orderitemdel = Orderitem::findOrFail($id);
        try {
            $orderitemdel->delete();
            $message = "Your Order Item  is Delete Successfully!";
            return redirect()->back()->with('success_message', $message);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                $message = "data cant be deleted";
                return redirect()->back()->with('error_message', $message);
            }
        }
    }

    public function TodayTakwWayOrder()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayTakeAwayorderlist = TakeWayOrder::where('created_at', $todayDate)->where('order_status', 'Order Completed')->get();
        $overallcollectionwithGSt = TakeWayOrder::where('created_at', $todayDate)->sum('grand_total');
        $overallcollectionwithoutGSt = TakeWayOrder::where('created_at', $todayDate)->sum('total_tax');
        return view('admin.cashier.today_take_way_order')->with(compact('todayTakeAwayorderlist', 'overallcollectionwithoutGSt', 'overallcollectionwithGSt'));
    }



    public function TakeMoreItem(Request $request, $order_no)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            DB::beginTransaction();
            $updateorder_time = RestaurantOrder::where('order_no', $order_no)->first();
            date_default_timezone_set("Asia/Calcutta");
            $updateorder_time->order_time = date('d-m-Y H:i:s');
            $updateorder_time->save();
            $uniqueitemid = Orderitem::orderBy('id', 'DESC')->pluck('id')->first();
            if ($uniqueitemid == null or $uniqueitemid == "") {
                #If Table is Empty
                $uniqueitemid = 1;
            } else {
                #If Table has Already some Data
                $uniqueitemid = $uniqueitemid + 1;
            }
            foreach ($data['item_id'] as $key => $attribute) {
                if (!empty($attribute)) {

                    $orderitem = new Orderitem();
                    $orderitem->order_no = $order_no;
                    $orderitem->group_item = 'GroupItem-' . $uniqueitemid;
                    $orderitem->order_type = $data['itemtype'][$key];
                    $orderitem->subcategory_id = $data['menu_subcat_id'][$key];

                    $orderitem->item_id = $data['item_id'][$key];
                    $orderitem->price = $data['price'][$key];
                    $orderitem->item_qty = $data['item_qty'][$key];
                    // offer
                    $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                    if ($data['no_qty_buy_to_free'][$key] == NULL) {
                        $orderitem->no_qty_buy_to_free = 0;
                    } else {
                        $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                    }

                    $orderitem->remark = $data['remark'][$key];
                    $orderitem->extra_menu_item_id = $data['extra_menu_item_id'][$key];
                    $orderitem->extraItemPrice = $data['extraItemPrice'][$key];
                    $getamount = $data['price'][$key] * $data['item_qty'][$key];
                    $orderitem->amount = $getamount + $data['extraItemPrice'][$key];
                    // offer end
                    $orderitem->save();
                }
            }

            DB::commit();

            $notification = array(
                'message' => " More Item Added  Successfully!",
                'alert-type' => 'success'
            );


            return redirect('admin/view-order-details/' . $order_no)->with($notification);
        }
    }
    public function OrderReplace(Request $request, $order_id)
    {
        DB::beginTransaction();
        $get = DB::table('orderitems')
            ->where('id', $order_id)
            ->update(
                array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'order_item_status' => 'Replace-Item',
                    'order_waste_remark' => $request->input('order_waste_remark')
                )
            );
            DB::commit();
        $notification = array(
            'message' => "Replace Order Item Request Has Been Sent To The Kitchen!",
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function RequestForDeleteItemKichen(Request $request, $id)
    {
        $status_id = $request->get('status_id');
        DB::beginTransaction();
        $statuschange = DB::table('orderitems')
            ->where('id', $status_id)
            ->first();

        DB::table('orderitems')
            ->where('id', $status_id)
            ->update(
                array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'reqTodelete' => 'Delete Request Has Been Sent To The Kitchen!'
                )
            );

            DB::commit();
        $notification = array(
            'message' => "Delete Request Has Been Sent To The Kitchen!",
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
