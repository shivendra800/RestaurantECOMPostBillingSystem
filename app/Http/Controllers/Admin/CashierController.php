<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Tax;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Table;
use Razorpay\Api\Api;
use App\Models\BarTable;
use App\Models\ExtraMenu;
use App\Models\Orderitem;
use App\Models\SiteSetting;
use App\Models\OrderWiseTax;
use App\Models\TakeAwayCart;
use App\Models\TakeWayOrder;
use Illuminate\Http\Request;
use App\Models\BarTableChair;
use App\Models\BarTableOrder;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Models\RestaurantOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BarTableOrderTax;
use App\Models\TakeWayOrderitem;
use App\Models\BarTableOrderItem;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BarChairOrderCheckout;
use Illuminate\Database\QueryException;

class CashierController extends Controller
{


    public function TakeTableOrderSave(Request $request, $id)
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
                $restorder = new RestaurantOrder();
                $restorder->table_id = $data['table_id'];
                $restorder->total_no_person_intable = $data['total_no_person_intable'];
                $restorder->staff_id = $data['staff_id'];
                $restorder->payableamt = $data['payableamt'];
                $restorder->nc_remark = $data['nc_remark'];
                $restorder->grand_total = 0;
                $restorder->order_no = 0;
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

                        $orderitem->save();
                    }
                }

                $tablestatus = Table::where('id', $data['table_id'])->first();
                $tablestatus->booking_status = 1;
                $tablestatus->table_order_no = 'PROD' . $unique_no;
                $tablestatus->save();


                return redirect('admin/today-table-order');
            }
        }
        $tables = Table::where('status', 1)->where('booking_status', 0)->get();
        $gettableselect = Table::where('id', $id)->first();
        $menuitems = MenuItemPrice::where('status', 1)->get();
        $getstaff = Admin::where('type', 'Waiter')->orWhere('type', 'Cashier')->where('status', 1)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        $getExtraitem = ExtraMenu::get();
        return view('admin.cashier.take_table_order')->with(compact('getstaff', 'tables', 'getExtraitem', 'menuitems', 'coupononprice', 'productWiseCoupon', 'gettableselect'));
    }

    public function tableOrderToday()
    {
        $todayDate = Carbon::now()->format('Y-m-d');

        $tableordertb = RestaurantOrder::where('order_status', '!=', "Order Completed")->where('created_at', $todayDate)->get();
        return view('admin.cashier.table_order')->with(compact('tableordertb'));
    }
    public function tableOrderTodaycompl()
    {
        $todayDate = Carbon::now()->format('Y-m-d');

        $tableordertb = RestaurantOrder::where('order_status', "Order Completed")->where('created_at', $todayDate)->get();
        return view('admin.cashier.table_order')->with(compact('tableordertb'));
    }
    public function ViewOrderDetails($order_no)
    {

        $subcategory = MenuSubCategory::get();
        $menuitem = MenuItemPrice::get();
        $ordereitemlist = Orderitem::with('menuitem', 'extraitemadd')->where('order_no', $order_no)->get();
        $orderes = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        $gettax = Tax::where('status', '1')->get();
        $gettaxinst = OrderWiseTax::where('order_no', $order_no)->first();

        return view('admin.cashier.view_order_details', compact('subcategory', 'menuitem', 'orderes', 'ordereitemlist', 'gettax', 'gettaxinst'));
    }

    public function TablePaymentupdated($order_no)
    {

        $subcategory = MenuSubCategory::get();
        $menuitem = MenuItemPrice::get();
        $ordereitemlist = Orderitem::with('menuitem', 'extraitemadd')->where('order_no', $order_no)->get();
        $orderes = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        $gettax = Tax::where('status', '1')->get();
        $gettaxinst = OrderWiseTax::where('order_no', $order_no)->get();

        return view('admin.cashier.update_table_payment', compact('subcategory', 'menuitem', 'orderes', 'ordereitemlist', 'gettax', 'gettaxinst'));
    }
     public function TableOrderCheckout(Request $request, $order_no)
    {

        if ($request->payableamt == "General") {

            if ($request->payment_mode == "Cash") {

                $rules = [
                    'taken_cash_amount'=>'required|numeric|gt:0',
                    'given_change_amount'=>'required|numeric',
                ];


                $this->validate($request, $rules);


                if ($request->grand_total <= $request->taken_cash_amount) {
                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                    $takeoutorder->payment_mode = $request->payment_mode;
                    $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
                    $takeoutorder->given_change_amount = $request->given_change_amount;
                    $takeoutorder->order_status = "Order Completed";
                    $takeoutorder->save();
                    $notification = array(
                            'message' => " Order Completed  Successfully!",
                            'alert-type' => 'success'
                        );

                    return redirect('admin/today-complete-orders/')->with($notification);

                } else {

                    $notification = array(
                        'message' => " Plz Enter Valid Amount!",
                        'alert-type' => 'error'
                    );
                   return redirect()->back()->with($notification);
                }
            }
            if ($request->payment_mode == "QR-Cash") {

                $rules = [
                    'cash_amt_qcash'=>'required|numeric|gt:0',
                    'qr_amt_qcash'=>'required|numeric|gt:0',
                ];


                $this->validate($request, $rules);



                if ($request->grand_total = $request->cash_amt_qcash+$request->qr_amt_qcash) {
                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                    $takeoutorder->payment_mode = $request->payment_mode;
                    $takeoutorder->cash_amountparitial = $request->cash_amt_qcash;
                    $takeoutorder->partial_other_value = $request->qr_amt_qcash;
                    $takeoutorder->order_status = "Order Completed";
                    $takeoutorder->save();
                    $notification = array(
                            'message' => " Order Completed  Successfully Of QR-Cash!",
                            'alert-type' => 'success'
                        );

                    return redirect('admin/today-complete-orders/')->with($notification);

                } else {

                    $notification = array(
                        'message' => " Plz Enter Valid Amount data!",
                        'alert-type' => 'error'
                    );
                   return redirect()->back()->with($notification);
                }
            }
            if ($request->payment_mode == "QR-Card") {

                $rules = [
                    'card_amt_qc'=>'required|numeric|gt:0',
                    'qr_amt_qc'=>'required|numeric|gt:0',
                ];


                $this->validate($request, $rules);



                if ($request->grand_total = $request->card_amt_qc+$request->qr_amt_qc) {
                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                    $takeoutorder->payment_mode = $request->payment_mode;
                    $takeoutorder->cash_amountparitial = $request->card_amt_qc;
                    $takeoutorder->partial_other_value = $request->qr_amt_qc;
                    $takeoutorder->order_status = "Order Completed";
                    $takeoutorder->save();
                    $notification = array(
                            'message' => " Order Completed  Successfully Of QR-Card!",
                            'alert-type' => 'success'
                        );

                    return redirect('admin/today-complete-orders/')->with($notification);

                } else {

                    $notification = array(
                        'message' => " Plz Enter Valid Amount data!",
                        'alert-type' => 'error'
                    );
                   return redirect()->back()->with($notification);
                }
            }
            if ($request->payment_mode == "Cash-Card") {

                $rules = [
                    'cash_amt_cc'=>'required|numeric|gt:0',
                    'card_amt_cc'=>'required|numeric|gt:0',
                ];


                $this->validate($request, $rules);

                 $getcahcartotal= $request->cash_amt_cc+$request->card_amt_cc;


                if ($request->grand_total == $getcahcartotal ) {
                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                    $takeoutorder->payment_mode = $request->payment_mode;
                    $takeoutorder->cash_amountparitial = $request->cash_amt_cc;
                    $takeoutorder->partial_other_value = $request->card_amt_cc;
                    $takeoutorder->order_status = "Order Completed";
                    $takeoutorder->save();
                    $notification = array(
                            'message' => " Order Completed  Successfully Of Cash-Card!",
                            'alert-type' => 'success'
                        );

                    return redirect('admin/today-complete-orders/')->with($notification);

                } else {

                    $notification = array(
                        'message' => " Plz Enter Valid Amount data!",
                        'alert-type' => 'error'
                    );
                   return redirect()->back()->with($notification);
                }
            }
            if ($request->payment_mode == "QRCodeWithSlip" || $request->payment_mode == "Card-Swip") {



                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                     if($request->payment_mode == "Card-Swip"){
                        $takeoutorder->payment_mode = "Card Swip";
                     }else{
                        $takeoutorder->payment_mode = $request->payment_mode;
                     }
                    $takeoutorder->order_status = "Order Completed";
                    $takeoutorder->save();
                    $notification = array(
                            'message' => " Order Completed  Successfully !".$request->payment_mode,
                            'alert-type' => 'success'
                        );

                    return redirect('admin/today-complete-orders/')->with($notification);


            }





        } else {

            $validated = $request->validate([
                'mobile_no' => 'required|digits:10',

            ]);
            $tableordercheck = RestaurantOrder::where('order_no', $order_no)->first();
            $tableordercheck->order_status = "Order Completed";
            $tableordercheck->mobile_no = $request->mobile_no;
            $tableordercheck->payableamt = $request->payableamt;
            $tableordercheck->nc_remark = $request->nc_remark;
            $tableordercheck->save();
            $notification = array(
                'message' => " Order Completed  Successfully NC!",
                'alert-type' => 'success'
            );
            return redirect('admin/today-complete-orders/')->with($notification);

        }
    }


    // public function TableOrderCheckout(Request $request, $order_no)
    // {
    //     // $validated = $request->validate([

    //     //     'payment_mode' => 'required',
    //     //     'mobile_no' => 'required|digits:10',
    //     //     // 'payment_mode' => 'required_if:payment_mode,Cash',



    //     // ]);
    //     if ($request->payableamt == "General") {

    //         if ($request->payment_mode == "Cash") {
    //             if ($request->grand_total <= $request->taken_cash_amount) {
    //                 $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
    //                 $takeoutorder->mobile_no = $request->mobile_no;
    //                 $takeoutorder->payment_mode = $request->payment_mode;
    //                 $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
    //                 $takeoutorder->given_change_amount = $request->given_change_amount;
    //                 if ($request->payment_mode == "Paid by Razorpay") {
    //                     $takeoutorder->payment_id = $request->input('payment_id');
    //                 }
    //                 $takeoutorder->order_status = "Order Completed";
    //                 $takeoutorder->save();



    //                 if ($request->payment_mode == "Paid by Razorpay") {

    //                     return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
    //                 } else {

    //                     $notification = array(
    //                         'message' => " Order Completed  Successfully!",
    //                         'alert-type' => 'success'
    //                     );

    //                     return redirect('admin/today-complete-orders/')->with($notification);
    //                 }
    //             } else {

    //                 $notification = array(
    //                     'message' => " Plz Enter Valid Amount!",
    //                     'alert-type' => 'error'
    //                 );



    //                 return redirect()->back()->with($notification);
    //             }
    //         } else if ($request->payment_mode == "Partial-Payment") {
    //             if ($request->grand_total >= $request->cash_amountparitial) {
    //                 $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
    //                 $takeoutorder->mobile_no = $request->mobile_no;
    //                 $takeoutorder->payableamt = $request->payableamt;
    //                 $takeoutorder->payment_mode = $request->payment_mode;
    //                 $takeoutorder->payment_modepartial = $request->payment_modepartial;
    //                 $takeoutorder->cash_amountparitial = $request->cash_amountparitial;
    //                 $takeoutorder->partial_other_value = $request->partial_other_value;

    //                 $takeoutorder->order_status = "Order Completed";
    //                 $takeoutorder->save();





    //                     $notification = array(
    //                         'message' => " Order Completed  Successfully!",
    //                         'alert-type' => 'success'
    //                     );

    //                     return redirect('admin/today-complete-orders/')->with($notification);

    //             } else {

    //                 $notification = array(
    //                     'message' => " Plz Enter Valid Amount!",
    //                     'alert-type' => 'error'
    //                 );



    //                 return redirect()->back()->with($notification);
    //             }
    //         } else {
    //             $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
    //             $takeoutorder->mobile_no = $request->mobile_no;
    //             $takeoutorder->payment_mode = $request->payment_mode;
    //             $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
    //             $takeoutorder->given_change_amount = $request->given_change_amount;
    //             if ($request->payment_mode == "Paid by Razorpay") {
    //                 $takeoutorder->payment_id = $request->input('payment_id');
    //             }
    //             $takeoutorder->order_status = "Order Completed";
    //             $takeoutorder->save();


    //             if ($request->payment_mode == "Paid by Razorpay") {

    //                 return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
    //             } else {

    //                 $notification = array(
    //                     'message' => " Order Completed  Successfully!",
    //                     'alert-type' => 'success'
    //                 );

    //                 return redirect('admin/today-complete-orders/')->with($notification);
    //             }
    //         }
    //     } else {
    //         $tableordercheck = RestaurantOrder::where('order_no', $order_no)->first();
    //         $tableordercheck->order_status = "Order Completed";
    //         $tableordercheck->mobile_no = $request->mobile_no;
    //         $tableordercheck->payableamt = $request->payableamt;
    //         $tableordercheck->nc_remark = $request->nc_remark;
    //         $tableordercheck->save();
    //         $notification = array(
    //             'message' => " Order Completed  Successfully!",
    //             'alert-type' => 'success'
    //         );
    //         return redirect('admin/today-complete-orders/')->with($notification);

    //     }
    // }
    //partial online with cash payment

     public function razorpaycheckTablepartial(Request $request)
    {


        $partial_other_value = $request->input('partial_other_value');
        $cash_amountparitial = $request->input('cash_amountparitial');
        $payableamt = $request->input('payableamt');
        $payment_modepartial = $request->input('payment_modepartial');
        $payment_mode = $request->input('payment_mode');
        $grand_total = $request->input('grand_total');

        $order_id = $request->input('order_id');
        $mobile_no = $request->input('mobile_no');

        return response()->json([
            'partial_other_value' => $partial_other_value,
            'cash_amountparitial' => $cash_amountparitial,
            'payableamt' => $payableamt,
            'payment_modepartial' => $payment_modepartial,
            'payment_mode' => $payment_mode,
            'grand_total' => $grand_total,

            'order_id' => $order_id,
            'mobile_no' => $mobile_no,

        ]);
    }

     public function TableOrderCheckoutpartial(Request $request, $order_no)
    {

        if ($request->payableamt == "General") {


                if ($request->grand_total >= $request->cash_amountparitial) {

                    $takeoutorder = RestaurantOrder::where('order_no', $order_no)->first();
                    $takeoutorder->mobile_no = $request->mobile_no;
                    $takeoutorder->payableamt = $request->payableamt;
                    $takeoutorder->payment_mode = $request->payment_mode;
                    $takeoutorder->payment_modepartial = $request->payment_modepartial;
                    $takeoutorder->cash_amountparitial = $request->cash_amountparitial;
                    $takeoutorder->partial_other_value = $request->partial_other_value;
                   $takeoutorder->payment_id = $request->input('payment_idpartial');
                   $takeoutorder->order_status = "Order Completed";
                //    return $takeoutorder;
                   $takeoutorder->save();

                    return response()->json(['status' => "Order Completed Of Partialy Online Payment Sucessfully!"]);
                } else {

                    $notification = array(
                        'message' => " Plz Enter Valid Amount!",
                        'alert-type' => 'error'
                    );

                //   return redirect()->back()->with($notification);
                }


        } else {
            $tableordercheck = RestaurantOrder::where('order_no', $order_no)->first();
            $tableordercheck->order_status = "Order Completed";
            $tableordercheck->mobile_no = $request->mobile_no;
            $tableordercheck->payableamt = $request->payableamt;
            $tableordercheck->nc_remark = $request->nc_remark;
            $tableordercheck->save();
            $notification = array(
                'message' => " Order Completed  Successfully With NC!",
                'alert-type' => 'success'
            );
            return redirect('admin/today-complete-orders/')->with($notification);

        }
    }

    //partial online with cash payment

    public function TableOrderSlip($order_no)
    {

        $takeoutorderslip = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        $takewayorderitemslip = Orderitem::where('order_no', $order_no)->get();
        $getsiteSetting = SiteSetting::first();
        $orderwisetax = OrderWiseTax::where('order_no', $order_no)->get();

        return view('admin.cashier.takeway_order_slip', compact('takeoutorderslip', 'takewayorderitemslip', 'getsiteSetting', 'orderwisetax'));
    }

    public function razorpaycheckTable(Request $request)
    {

        $grand_total = $request->input('grand_total');
        $order_id = $request->input('order_id');
        $mobile_no = $request->input('mobile_no');

        return response()->json([
            'grand_total' => $grand_total,
            'order_id' => $order_id,
            'mobile_no' => $mobile_no,

        ]);
    }
    // public function razorpaycheck(Request $request)
    // {

    //     $grand_total = $request->input('grand_total');
    //     $sub_total = $request->input('sub_total');
    //     $total_tax = $request->input('total_tax');
    //     $order_id = $request->input('order_id');
    //     $coupon_per = $request->coupon_per;
    //     $coupon_avail_amount = $request->coupon_avail_amount;
    //     $coupon_code = $request->coupon_code;
    //     $subtotalwithoffer = $request->subtotalwithoffer;
    //     $mobile_no = $request->mobile_no;
    //     return response()->json([
    //         'grand_total' =>  $grand_total,
    //         'order_id' =>  $order_id,
    //         'sub_total' => $sub_total,
    //         'total_tax' => $total_tax,
    //         'coupon_per' => $coupon_per,
    //         'coupon_avail_amount' => $coupon_avail_amount,
    //         'coupon_code' => $coupon_code,
    //         'subtotalwithoffer' => $subtotalwithoffer,
    //         'mobile_no' => $mobile_no,

    //     ]);
    // }

    public function savetaxtemprazordata(Request $request, $order_no)
    {
        DB::beginTransaction();

        $ordertax = OrderWiseTax::where('order_no', $order_no)->exists();
        if ($ordertax) {

            $ordertax = OrderWiseTax::where('order_no', $order_no)->delete();
            if ($request->discount <= 20) {

                $discountvalue = $request->sub_total * $request->discount / 100;
                $subtotalwithoffer = $request->sub_total - round($discountvalue, 1);

                foreach ($request->tax_check_box as $key => $attribute) {
                    if (!empty($attribute)) {
                        $datagettax = Tax::where('id', $attribute)->first();
                        $get = $subtotalwithoffer * $datagettax['tax_percentage'] / 100;
                        $ordertax = new OrderWiseTax();
                        $ordertax->order_no = $order_no;
                        $ordertax->tax_name = $datagettax['tax_name'];
                        $ordertax->tax_percentage = $datagettax['tax_percentage'];
                        $ordertax->tax_amount = $get;
                        $ordertax->save();
                    }
                }

                $total_bartax = OrderWiseTax::where('order_no', $order_no)->sum('tax_amount');
                $getGrndTotal = round($subtotalwithoffer, 1) + round($total_bartax, 1);
                $ff = $getGrndTotal * 100;


                $SaveBarTableOrder = RestaurantOrder::where('order_no', $order_no)->first();
                $SaveBarTableOrder->sub_total = $request->sub_total;
                $SaveBarTableOrder->subtotalwithoffer = $subtotalwithoffer;
                $SaveBarTableOrder->coupon_per = $request->discount;
                $SaveBarTableOrder->coupon_avail_amount = $discountvalue;
                $SaveBarTableOrder->total_tax = $total_bartax;
                $SaveBarTableOrder->grand_total = $getGrndTotal;
                $SaveBarTableOrder->save();

                // This is for generate dynamic QR Code For  Payment on Bill of Rozpay Start
                // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                // $getff = $api->qrCode->create(array(
                //     "type" => "upi_qr", "name" => "$order_no", "usage" => "single_use", "fixed_amount" => 1,
                //     "payment_amount" => round($ff,1), "description" => "$order_no",
                //     "notes" => array("purpose" => "Test UPI QR code notes")
                // ));

                // This is save QrCode Url in YourDatabase start
                // $tableorderQR = RestaurantOrder::where('order_no', $order_no)->first();
                // $tableorderQR->image_url = $getff['image_url'];
                // $tableorderQR->save();



                // This is save QrCode Url in YourDatabase End

                // This is for generate dynamic QR Code For  Payment on Bill of Rozpay End

                DB::commit();

                $notification = array(
                    'message' => " Table Order Bill Created Successfully!",
                    'alert-type' => 'success'
                );


                return redirect('admin/table-paymentupdated/' . $order_no)->with($notification);
            }

        } else {
            if ($request->discount <= 20) {
                $discountvalue = $request->sub_total * $request->discount / 100;
                $subtotalwithoffer = $request->sub_total - round($discountvalue, 1);

                foreach ($request->tax_check_box as $key => $attribute) {
                    if (!empty($attribute)) {
                        $datagettax = Tax::where('id', $attribute)->first();
                        $get = $subtotalwithoffer * $datagettax['tax_percentage'] / 100;
                        $ordertax = new OrderWiseTax();
                        $ordertax->order_no = $order_no;
                        $ordertax->tax_name = $datagettax['tax_name'];
                        $ordertax->tax_percentage = $datagettax['tax_percentage'];
                        $ordertax->tax_amount = $get;
                        $ordertax->save();
                    }
                }

                $total_bartax = OrderWiseTax::where('order_no', $order_no)->sum('tax_amount');
                $getGrndTotal = round($subtotalwithoffer, 1) + round($total_bartax, 1);
                $ff = $getGrndTotal * 100;


                $SaveBarTableOrder = RestaurantOrder::where('order_no', $order_no)->first();
                $SaveBarTableOrder->sub_total = $request->sub_total;
                $SaveBarTableOrder->subtotalwithoffer = $subtotalwithoffer;
                $SaveBarTableOrder->coupon_per = $request->discount;
                $SaveBarTableOrder->coupon_avail_amount = $discountvalue;
                $SaveBarTableOrder->total_tax = $total_bartax;
                $SaveBarTableOrder->grand_total = $getGrndTotal;
                $SaveBarTableOrder->save();

                // This is for generate dynamic QR Code For  Payment on Bill of Rozpay Start
                // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                // $getff = $api->qrCode->create(array(
                //     "type" => "upi_qr", "name" => "$order_no", "usage" => "single_use", "fixed_amount" => 1,
                //     "payment_amount" => round($ff,1), "description" => "$order_no",
                //     "notes" => array("purpose" => "Test UPI QR code notes")
                // ));

                // This is save QrCode Url in YourDatabase start
                // $tableorderQR = RestaurantOrder::where('order_no', $order_no)->first();
                // $tableorderQR->image_url = $getff['image_url'];
                // $tableorderQR->save();


                DB::table('orderitems')
                    ->where('order_no', $order_no)
                    ->update(
                        array(
                            'updated_at' => date('Y-m-d H:i:s'),
                            'order_item_status' => 'Order-Collected'
                        )
                    );

                $tablestatus = Table::where('id', $SaveBarTableOrder['table_id'])->first();
                $tablestatus->booking_status = 0;
                $tablestatus->table_order_no = 0;
                $tablestatus->save();
                DB::commit();
                $notification = array(
                    'message' => " Table Order Bill Created Successfully!",
                    'alert-type' => 'success'
                );


                return redirect('admin/table-paymentupdated/' . $order_no)->with($notification);
            }
        }





    }

    //   Take Away order  and add to card------------------------------------------------------------------------


    public function SearchMenuItem(Request $request)
    {
        $keyword = $request->get('keyword');


        $menuitem = DB::table('menu_item_prices')

            ->where(function ($query) use ($keyword) {
                $query->where('menu_item_prices.menu_item_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('menu_item_prices.menu_item_code', 'LIKE', '%' . $keyword . '%');
            })
            ->where('type', 'restaurant-menu')
            ->orderby('menu_item_prices.id', 'DESC')
            ->paginate(50);
        $subcategory = MenuSubCategory::where('rest_type', 'restaurant-menu')->get();
        $gettax = Tax::where('status', 1)->get();
        $takewarycartitem = TakeAwayCart::with('menuitem')->where('created_by', Auth::guard('admin')->user()->id)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.cashier.view_take_away_order', compact('subcategory', 'menuitem', 'takewarycartitem', 'gettax', 'productWiseCoupon', 'coupononprice'));
    }
    public function TakeAwayOrder()
    {
        $subcategory = MenuSubCategory::where('rest_type', 'restaurant-menu')->get();
        $menuitem = MenuItemPrice::where('type', 'restaurant-menu')->paginate(10);
        $takewarycartitem = TakeAwayCart::with('menuitem')->where('created_by', Auth::guard('admin')->user()->id)->get();
        $gettax = Tax::where('status', 1)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.cashier.view_take_away_order', compact('subcategory', 'menuitem', 'takewarycartitem', 'gettax', 'productWiseCoupon', 'coupononprice'));
    }

    public function PrdouctgetSub($id)
    {
        $subcategory = MenuSubCategory::get();

        $menuitem = MenuItemPrice::with('menuCategory')->where('menu_subcat_id', $id)->paginate(10);
        $takewarycartitem = TakeAwayCart::with('menuitem')->get();
        $gettax = Tax::where('status', 1)->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.cashier.view_take_away_order', compact('subcategory', 'menuitem', 'takewarycartitem', 'gettax', 'productWiseCoupon', 'coupononprice'));
    }

    public function TakeAwayOrderAddtocart(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_qty = $request->input('item_qty');
        $price = $request->input('price'); {
            $prod_check = MenuItemPrice::where('id', $item_id)->first(); {

                if (TakeAwayCart::where('item_id', $item_id)->where('created_by', Auth::guard('admin')->user()->id)->exists()) {
                    return response()->json(['status' => $prod_check->menu_item_name . "Already Added to cart "]);
                } else {
                    $cartItem = new TakeAwayCart();
                    $cartItem->staff_id = Auth::guard('admin')->user()->staff_id;
                    $cartItem->item_id = $item_id;
                    $cartItem->item_qty = $item_qty;
                    $cartItem->subcategory_id = 0;
                    $cartItem->category_id = 0;
                    $cartItem->price = $price;
                    $cartItem->amount = $price;
                    $cartItem->created_by = Auth::guard('admin')->user()->id;

                    $cartItem->save();
                    return response()->json(['status' => $prod_check->menu_item_name . " Added to cart "]);
                }
            }
        }
    }


    public function updatecart(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //  echo "<pre>",print_r($data); die;

            // Get Cart Details
            $cartDetails = TakeAwayCart::find($data['cartid']);

            //Update the Qty
            TakeAwayCart::where('id', $data['cartid'])->update(['item_qty' => $data['qty']]);
            return response()->json(['status' => "Quantity Updated"]);
        }
    }


    public function deletecart($id)
    {
        $unit = TakeAwayCart::findOrFail($id);
        try {
            $unit->delete();
            $message = "Your unit   is Delete Successfully!";
            return redirect()->back()->with('success_message', $message);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                $message = "data cant be deleted";
                return redirect('')->back()->with('error_message', $message);
            }
        }
    }


    public function ProcessNextTakeorder(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            #Store Unique Order/Product Number
            $unique_no = TakeWayOrder::orderBy('id', 'DESC')->pluck('id')->first();
            if ($unique_no == null or $unique_no == "") {
                #If Table is Empty
                $unique_no = 1;
            } else {
                #If Table has Already some Data
                $unique_no = $unique_no + 1;
            }

            $getid = 'TPROD' . $unique_no;
            $takewayorder = new TakeWayOrder();
            $takewayorder->order_no = 'TPROD' . $unique_no;
            $takewayorder->staff_id = Auth::guard('admin')->user()->staff_id;
            $takewayorder->sub_total = $data['sub_total'];
            // $takewayorder->service_tax=$data['service_tax'];
            $takewayorder->total_tax = $data['total_tax'];
            $takewayorder->grand_total = $data['grand_total'];
            // offer start
            $takewayorder->coupon_per = $data['coupon_per'];
            $takewayorder->coupon_avail_amount = $data['coupon_avail_amount'];
            $takewayorder->coupon_code = $data['coupon_code'];
            $takewayorder->subtotalwithoffer = $data['subtotalwithoffer'];
            // offer end
            $takewayorder->order_status = 'Order-Processing';
            // dd($takewayorder);
            $takewayorder->save();
            $id = DB::getPdo()->lastInsertId();

            foreach ($data['tax_name'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $ordertax = new OrderWiseTax();
                    $ordertax->order_no = 'TPROD' . $unique_no;
                    $ordertax->tax_name = $data['tax_name'][$key];
                    $ordertax->tax_percentage = $data['tax_percentage'][$key];
                    $ordertax->tax_amount = $data['tax_amt'][$key];
                    $ordertax->save();
                }
            }

            foreach ($data['item_id'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $orderitem = new TakeWayOrderitem();
                    $orderitem->order_no = 'TPROD' . $unique_no;
                    $orderitem->item_id = $data['item_id'][$key];
                    $orderitem->price = $data['price'][$key];
                    $orderitem->item_qty = $data['item_qty'][$key];
                    $orderitem->amount = $data['amount'][$key];
                    // offer
                    $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                    if ($data['no_qty_buy_to_free'][$key] == NULL) {
                        $orderitem->no_qty_buy_to_free = 0;
                    } else {
                        $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                    }

                    $orderitem->save();
                }
            }


            // // This is for generate dynamic QR Code For  Payment on Bill of Rozpay Start
            // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            // $getff = $api->qrCode->create(array(
            //     "type" => "upi_qr", "name" => "$getid", "usage" => "single_use", "fixed_amount" => 1,
            //     "payment_amount" => $data['grand_total'] * 100, "description" => "$getid",
            //     "notes" => array("purpose" => "Test UPI QR code notes")
            // ));

            // // This is save QrCode Url in YourDatabase start
            // $takewayorders = TakeWayOrder::where('id', $id)->first();
            // $takewayorders->image_url = $getff['image_url'];
            // $takewayorders->save();
            // This is save QrCode Url in YourDatabase End

            // This is for generate dynamic QR Code For  Payment on Bill of Rozpay End

            $cartItem = TakeAwayCart::where('created_by', Auth::guard('admin')->user()->id)->get();
            TakeAwayCart::destroy($cartItem);


            $notification = array(
                'message' => " Order Place Successfully! And Moving For Checkout Page !",
                'alert-type' => 'success'
            );


            return redirect('admin/takeorder-checkout/' . $getid)->with($notification);
        }
    }

    public function takeordercheckout($order_no)
    {
        $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $takewayorderitem = TakeWayOrderitem::where('order_no', $order_no)->get();

        return view('admin.cashier.takeway_checkout', compact('takeoutorder', 'takewayorderitem'));
    }

    public function razorpaycheckTakeway(Request $request)
    {

        $grand_total = $request->input('grand_total');
        $order_id = $request->input('order_id');
        $mobile_no = $request->input('mobile_no');

        return response()->json([
            'grand_total' => $grand_total,
            'order_id' => $order_id,
            'mobile_no' => $mobile_no,

        ]);
    }


    public function takeordercheckoutSave(Request $request, $order_no)
    {
        $validated = $request->validate([

            'payment_mode' => 'required',
            'mobile_no' => 'required|digits:10',
            // 'payment_mode' => 'required_if:payment_mode,Cash',



        ]);

        if ($request->payment_mode == "Cash") {
            if ($request->grand_total <= $request->taken_cash_amount) {
                $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
                $takeoutorder->mobile_no = $request->mobile_no;
                $takeoutorder->payment_mode = $request->payment_mode;
                $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
                $takeoutorder->given_change_amount = $request->given_change_amount;
                if ($request->payment_mode == "Paid by Razorpay") {
                    $takeoutorder->payment_id = $request->input('payment_id');
                }
                $takeoutorder->order_status = "Order Completed";
                $takeoutorder->save();


                //   Send  Login Sms
                // $username = 'HELLOINDIA';
                // $apiKey = 'AAED2-350A8';
                // $apiRequest = 'Text';
                // $numbers = $request->mobile_no; // Multiple numbers separated by comma
                // $sender = 'HILCPL';



                // $templateid = "1507165891884014078";
                // $apiRoute = 'TRANS';
                // $message =  'Your order of this amount Rs.'.$takeoutorder->grand_total.'from helloindialifecare.com was delivered Successfully.HILCPL';


                // $datas = 'username='.$username.'&apikey='.$apiKey.'&apirequest='.$apiRequest.'&route='.$apiRoute.'&mobile='.$numbers.'&sender='.$sender."&TemplateID=".$templateid."&message=".$message;
                // $url = 'http://tagsolutions.in/sms-panel/api/http/index.php?'.$datas;
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);


                if ($request->payment_mode == "Paid by Razorpay") {

                    return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
                } else {

                    $notification = array(
                        'message' => " Order Completed  Successfully!",
                        'alert-type' => 'success'
                    );

                    return redirect('admin/today-Take-away-orderSlip/' . $order_no)->with($notification);
                }
            } else {

                $notification = array(
                    'message' => " Plz Enter Valid Amount!",
                    'alert-type' => 'error'
                );



                return redirect()->back()->with($notification);
            }
        } else {
            $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
            $takeoutorder->mobile_no = $request->mobile_no;
            $takeoutorder->payment_mode = $request->payment_mode;
            $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
            $takeoutorder->given_change_amount = $request->given_change_amount;
            if ($request->payment_mode == "Paid by Razorpay") {
                $takeoutorder->payment_id = $request->input('payment_id');
            }
            $takeoutorder->order_status = "Order Completed";
            $takeoutorder->save();


            //   Send  Login Sms
            // $username = 'HELLOINDIA';
            // $apiKey = 'AAED2-350A8';
            // $apiRequest = 'Text';
            // $numbers = $request->mobile_no; // Multiple numbers separated by comma
            // $sender = 'HILCPL';



            // $templateid = "1507165891884014078";
            // $apiRoute = 'TRANS';
            // $message =  'Your order of this amount Rs.'.$takeoutorder->grand_total.'from helloindialifecare.com was delivered Successfully.HILCPL';


            // $datas = 'username='.$username.'&apikey='.$apiKey.'&apirequest='.$apiRequest.'&route='.$apiRoute.'&mobile='.$numbers.'&sender='.$sender."&TemplateID=".$templateid."&message=".$message;
            // $url = 'http://tagsolutions.in/sms-panel/api/http/index.php?'.$datas;
            // $url = preg_replace("/ /", "%20", $url);
            // $response = file_get_contents($url);


            if ($request->payment_mode == "Paid by Razorpay") {

                return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
            } else {

                $notification = array(
                    'message' => " Order Completed  Successfully!",
                    'alert-type' => 'success'
                );

                return redirect('admin/today-Take-away-orderSlip/' . $order_no)->with($notification);
            }
        }
    }


    public function TodayTakeAwayOrder()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        if (Auth::guard('admin')->user()->type == "Admin") {
            $todayTakeAwayorderlist = TakeWayOrder::where('order_status', 'Order Completed')->get()->sortDesc();
            $overallcollectionwithGSt = TakeWayOrder::sum('grand_total');
            $overallcollectionwithoutGSt = TakeWayOrder::sum('total_tax');
        } else {
            $todayTakeAwayorderlist = TakeWayOrder::where('created_at', $todayDate)->where('type','Take-Away-Order')->where('staff_id', Auth::guard('admin')->user()->staff_id)->get()->sortDesc();
            $overallcollectionwithGSt = TakeWayOrder::where('created_at', $todayDate)->where('type','Take-Away-Order')->sum('grand_total');
            $overallcollectionwithoutGSt = TakeWayOrder::where('created_at', $todayDate)->where('type','Take-Away-Order')->sum('total_tax');
        }
        return view('admin.cashier.today_take_way_order')->with(compact('todayTakeAwayorderlist', 'overallcollectionwithGSt', 'overallcollectionwithoutGSt'));
    }


    public function TakewayOrdersSearchDateWsie(Request $request)
    {

        $todayTakeAwayorderlist = TakeWayOrder::where('order_status', 'Order Completed')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get()->toArray();

        $overallcollectionwithGSt = TakeWayOrder::whereBetween('created_at', [$request->start_date, $request->end_date])
            ->sum('grand_total');
        $overallcollectionwithoutGSt = TakeWayOrder::whereBetween('created_at', [$request->start_date, $request->end_date])
            ->sum('total_tax');
        return view('admin.cashier.today_take_way_order')->with(compact('todayTakeAwayorderlist', 'overallcollectionwithGSt', 'overallcollectionwithoutGSt'));
    }



    public function TodayTakeAwayOrderSlip($order_no)
    {
        if (Auth::guard('admin')->user()->type == "Admin") {
            $takeoutorderslip = TakeWayOrder::where('order_no', $order_no)->first();
            $takewayorderitemslip = TakeWayOrderitem::where('order_no', $order_no)->get();
            $OrderWisetaxdet = OrderWiseTax::where('order_no', $order_no)->get();
            return view('admin.cashier.takeway_order_details', compact('takeoutorderslip', 'takewayorderitemslip', 'OrderWisetaxdet'));
        } else {




            $takeoutorderslip = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
            $takewayorderitemslip = TakeWayOrderitem::where('order_no', $order_no)->get();
            $getsiteSetting = SiteSetting::first();
            $orderwisetax = OrderWiseTax::where('order_no', $order_no)->get();


            return view('admin.zomato.zomato_order_slip', compact('takeoutorderslip', 'takewayorderitemslip', 'getsiteSetting', 'orderwisetax'));
        }
    }



    public function TakeWayOrderStatus($order_no)
    {

        $vieworder = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $viewOrderitem = TakeWayOrderitem::where('order_no', $order_no)->get();
        return view('admin.cashier.view_takeway_orderStatus', compact('vieworder', 'viewOrderitem'));
    }

    public function UpdateKitechenOrderStatus(Request $request, $order_no)
    {
        $validated = $request->validate([

            'updated_kitchen_order_status' => 'required'
        ]);
        $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $takeoutorder->updated_kitchen_order_status = $request->updated_kitchen_order_status;
        $takeoutorder->save();

        $notification = array(
            'message' => " Kitchen Order Status Updated  Successfully!",
            'alert-type' => 'success'
        );

        return redirect('admin/today-Take-away-order')->with($notification);
    }

    public function CheckCouponcode(Request $request)
    {

        $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // die;
        $date = date('Y-m-d');
        $getdata = ProductWiseCoupon::where('promocode', $data['check_coupon'])->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->first();

        if (!empty($getdata)) {
            return response()->json([
                'data' => $getdata,
                'mesg' => 'true'
            ]);
        } else {
            return response()->json([
                'data' => 'Abigail',
                'mesg' => 'false'
            ]);
        }
    }

    /// Bar Table Order Checkout start -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function BarTableOrderCheckoutList()
    {
        $data['getbarTableCheckout'] = BarTableOrder::with('tables', 'staffs')->where('order_status', 'Order-Taken')->where('bar_order_type', 'Table-Order')->get()->toArray();
        return view('admin.cashier.barCheckouts.bar_table_checkout_list', $data);
    }
    public function ViewBarTableOrderCheckout($BarTableOrderNo)
    {
        $data['getbarTableOrder'] = BarTableOrder::with('tables', 'staffs')->where('order_no', $BarTableOrderNo)->first()->toArray();
        $data['getbarTableOrderItem'] = BarTableOrderItem::with('menuitem')->where('order_no', $BarTableOrderNo)->get()->toArray();
        $data['getsiteSetting'] = SiteSetting::first();
        $data['gettax'] = Tax::where('status', '1')->get();
        return view('admin.cashier.barCheckouts.view_bar_tableOrder_checkout', $data);
    }

    public function SaveBarTableOrderCheckout(Request $request, $BarTableOrderNo)
    {
        DB::beginTransaction();
        foreach ($request->tax_check_box as $key => $attribute) {
            if (!empty($attribute)) {
                $datagettax = Tax::where('id', $attribute)->first();
                $get = $request->sub_total * $datagettax['tax_percentage'] / 100;
                $ordertax = new BarTableOrderTax();
                $ordertax->order_no = $BarTableOrderNo;
                $ordertax->tax_name = $datagettax['tax_name'];
                $ordertax->tax_percentage = $datagettax['tax_percentage'];
                $ordertax->tax_amount = $get;
                $ordertax->save();
            }
        }


        $total_bartax = BarTableOrderTax::where('order_no', $BarTableOrderNo)->sum('tax_amount');

        $getGrndTotal = round($request->sub_total, 1) + round($total_bartax, 1);
        $ff = $getGrndTotal * 100;


        $SaveBarTableOrder = BarTableOrder::where('order_no', $BarTableOrderNo)->first();
        $SaveBarTableOrder->sub_total = $request->sub_total;
        $SaveBarTableOrder->total_tax = $total_bartax;
        $SaveBarTableOrder->grand_total = $getGrndTotal;
        $SaveBarTableOrder->save();

        //      // This is for generate dynamic QR Code For  Payment on Bill of Rozpay Start
        // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // $getff = $api->qrCode->create(array(
        //     "type" => "upi_qr", "name" => "$BarTableOrderNo", "usage" => "single_use", "fixed_amount" => 1,
        //     "payment_amount" =>round($ff,1) , "description" => "$BarTableOrderNo",
        //     "notes" => array("purpose" => "Test UPI QR code notes")
        // ));

        // // This is save QrCode Url in YourDatabase start
        // $tableorderQR = BarTableOrder::where('order_no', $BarTableOrderNo)->first();
        // $tableorderQR->image_url = $getff['image_url'];
        // $tableorderQR->save();
        // // This is save QrCode Url in YourDatabase End

        // This is for generate dynamic QR Code For  Payment on Bill of Rozpay End
        $restorder = BarTableOrder::where('order_no', $BarTableOrderNo)->first();
        $tablestatus = BarTable::where('id', $restorder['bar_table_id'])->first();
        $tablestatus->table_status = 0;
        $tablestatus->order_no = 0;
        $tablestatus->save();


        DB::commit();

        return redirect('admin/finallybarTableCheckoutOrder/' . $BarTableOrderNo);
    }

    public function finallyBarTableOrderCheckout($BarTableOrderNo)
    {

        $data['getbarTableOrder'] = BarTableOrder::with('tables', 'staffs')->where('order_no', $BarTableOrderNo)->first()->toArray();
        $data['getbarTableOrderItem'] = BarTableOrderItem::with('menuitem')->where('order_no', $BarTableOrderNo)->get()->toArray();
        $data['getsiteSetting'] = SiteSetting::first();
        $data['gettax'] = Tax::where('status', '1')->get();
        return view('admin.cashier.barCheckouts.finally_bar_tableOrder_checkout', $data);
    }

    public function completeBarTableOrderCheckout(Request $request, $BarTableOrderNo)
    {
        $validated = $request->validate([

            'payment_mode' => 'required',
            // 'mobile_no' => 'required|digits:10',
        ]);
        if ($request->payment_mode == "Cash") {
            if ($request->grand_total <= $request->taken_cash_amount) {
                $takeoutorder = BarTableOrder::where('order_no', $BarTableOrderNo)->first();
                $takeoutorder->mobile_no = $request->mobile_no;
                $takeoutorder->payment_mode = $request->payment_mode;
                $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
                $takeoutorder->given_change_amount = $request->given_change_amount;
                if ($request->payment_mode == "Paid by Razorpay") {
                    $takeoutorder->payment_id = $request->input('payment_id');
                }
                $takeoutorder->order_status = "Order Completed";
                $takeoutorder->save();



                if ($request->payment_mode == "Paid by Razorpay") {

                    return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
                } else {

                    $notification = array(
                        'message' => " Order Completed  Successfully!",
                        'alert-type' => 'success'
                    );

                    return redirect('admin/bar-tableOrderCheckout-list/')->with($notification);
                }
            } else {

                $notification = array(
                    'message' => " Plz Enter Valid Amount!",
                    'alert-type' => 'error'
                );



                return redirect()->back()->with($notification);
            }
        } else {
            $takeoutorder = BarTableOrder::where('order_no', $BarTableOrderNo)->first();
            $takeoutorder->mobile_no = $request->mobile_no;
            $takeoutorder->payment_mode = $request->payment_mode;
            $takeoutorder->taken_cash_amount = $request->taken_cash_amount;
            $takeoutorder->given_change_amount = $request->given_change_amount;
            if ($request->payment_mode == "Paid by Razorpay") {
                $takeoutorder->payment_id = $request->input('payment_id');
            }
            $takeoutorder->order_status = "Order Completed";
            $takeoutorder->save();

            if ($request->payment_mode == "Paid by Razorpay") {

                return response()->json(['status' => "Order Completed Of Online Payment Sucessfully!"]);
            } else {

                $notification = array(
                    'message' => " Order Completed  Successfully!",
                    'alert-type' => 'success'
                );

                return redirect('admin/bar-tableOrderCheckout-list/')->with($notification);
            }
        }

    }

    public function PrintBarOrderReceipt($BarTableOrderNo)
    {
        $data['getbarTableOrder'] = BarTableOrder::with('tables', 'staffs')->where('order_no', $BarTableOrderNo)->first()->toArray();
        $data['getbarTableOrderItem'] = BarTableOrderItem::with('menuitem')->where('order_no', $BarTableOrderNo)->get()->toArray();
        $data['getsiteSetting'] = SiteSetting::first();
        $data['barOrderTax'] = BarTableOrderTax::where('order_no', $BarTableOrderNo)->get();
        return view('admin.cashier.barCheckouts.print_barOrder_reciept', $data);
    }


    public function BarTableWiseChairOrderCheckoutList()
    {
        $data['getbarTableCheckout'] = BarTableOrder::with('tables', 'staffs')->where('order_status', 'Order-Taken')->where('bar_order_type', 'Chair-Order')->get()->toArray();
        return view('admin.cashier.barCheckouts.bar_tableWiseChair_checkout_list', $data);
    }
    public function ViewBarTableOrderWiseChaiCheckout($BarTableOrderNo)
    {
        $data['getbarTableOrder'] = BarTableOrder::with('tables', 'staffs')->where('order_no', $BarTableOrderNo)->first()->toArray();
        $data['getbarTableOrderItem'] = BarTableOrderItem::with('menuitem', 'barchairname')->where('order_no', $BarTableOrderNo)->where('order_item_status', '!=', 'Chair-OrderClose')->groupby('chairs_id')->get()->toArray();
        $data['getbarchairOrderItem'] = BarTableOrderItem::with('menuitem')->where('order_item_status', '!=', 'Chair-OrderClose')->where('order_no', $BarTableOrderNo)->get()->toArray();

        $data['getsiteSetting'] = SiteSetting::first();
        $data['gettaxServiceCharge'] = Tax::where('tax_name', 'Service Charge')->first();
        return view('admin.cashier.barCheckouts.view_bar_tableWiseChairOrder_checkout', $data);
    }
    public function CheckoutChairwiseorder(Request $request, $BarChairNo)
    {
        DB::beginTransaction();




        foreach ($request->id as $key => $attribute) {
            if (!empty($attribute)) {
                $ordertax = BarTableOrderItem::where('order_no', $request->order_no)->where('chairs_id', $BarChairNo)->where('id', $attribute)->first();
                $ordertax->order_item_status = "Chair-OrderClose";
                $ordertax->save();

            }
        }

        $insertchairtrans = new BarChairOrderCheckout;
        $insertchairtrans->order_no = $request->order_no;
        $insertchairtrans->chair_id = $BarChairNo;
        $insertchairtrans->sub_total = $request->sub_total;
        $insertchairtrans->total_tax = $request->servchrg;
        $insertchairtrans->grand_total = $request->grand_total;
        $insertchairtrans->order_status = "Payment Completed";
        $insertchairtrans->save();

        $overallsubTotal = BarChairOrderCheckout::where('order_no', $request->order_no)->sum('sub_total');
        $overalltotal_tax = BarChairOrderCheckout::where('order_no', $request->order_no)->sum('total_tax');
        $overallgrand_total = BarChairOrderCheckout::where('order_no', $request->order_no)->sum('grand_total');

        $checkChairOrderCloseStatus = BarTableOrderItem::where('order_no', $request->order_no)->where('order_item_status', 'Chair-OrderClose')->count();
        if ($checkChairOrderCloseStatus == 0) {
            $SaveBarTableOrder = BarTableOrder::where('order_no', $request->order_no)->first();
            $SaveBarTableOrder->sub_total = $overallsubTotal;
            $SaveBarTableOrder->total_tax = $overalltotal_tax;
            $SaveBarTableOrder->grand_total = $overallgrand_total;
            $SaveBarTableOrder->order_status = "Order Completed";
            $SaveBarTableOrder->save();
        } else {
            $SaveBarTableOrder = BarTableOrder::where('order_no', $request->order_no)->first();
            $SaveBarTableOrder->sub_total = $overallsubTotal;
            $SaveBarTableOrder->total_tax = $overalltotal_tax;
            $SaveBarTableOrder->grand_total = $overallgrand_total;
            $SaveBarTableOrder->save();
        }

        DB::commit();

        $notification = array(
            'message' => " Bar Order Completed  Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function Chirwisebill()
    {
        $getBarChairCheckouthist = BarChairOrderCheckout::with('barchairname')->get()->toArray();
        return view('admin.cashier.barCheckouts.chair_bill_histroy', compact('getBarChairCheckouthist'));
    }

    public function PrintBarChairOrderReceipt($BarTableOrderNo)
    {

        $data['getbarchairOrderche'] = BarChairOrderCheckout::where('id', $BarTableOrderNo)->first()->toArray();

        $data['getbarTableOrder'] = BarTableOrder::where(
            'order_no',
            $data['getbarchairOrderche']['order_no']
        )->first()->toArray();

        $data['getbarTableOrderItem'] = BarTableOrderItem::with('menuitem')->where('order_no', $data['getbarchairOrderche']['order_no'])->where('chairs_id', $data['getbarchairOrderche']['chair_id'])->get()->toArray();
        $data['getsiteSetting'] = SiteSetting::first();
        $data['barOrderTax'] = BarTableOrderTax::where('order_no', $BarTableOrderNo)->get();
        return view('admin.cashier.barCheckouts.print_barOrder_reciept', $data);
    }

    public function UpdatePayableMode(Request $request, $orderNo)
    {
        $updatePayablemodeGn = RestaurantOrder::where('order_no', $orderNo)->first();
        $updatePayablemodeNC = RestaurantOrder::where('order_no', $orderNo)->where('payableamt','NC')->first();



            if(!empty($updatePayablemodeGn['payableamt']=="General"))
            {

                $updatePayablemodeGn->payableamt = "NC";

                $updatePayablemodeGn->save();
                $notification = array(
                    'message' => " payable mode updated Successfully!",
                    'alert-type' => 'success'
                );


                return redirect('admin/table-paymentupdated/' . $orderNo)->with($notification);

            }
            if(!empty($updatePayablemodeNC['payableamt']=="NC")){


                $updatePayablemodeNC->payableamt = "General";

                $updatePayablemodeNC->save();
                $notification = array(
                    'message' => " payable mode updated Successfully!",
                    'alert-type' => 'success'
                );


                return redirect('admin/table-paymentupdated/' . $orderNo)->with($notification);
            }




    }


}
