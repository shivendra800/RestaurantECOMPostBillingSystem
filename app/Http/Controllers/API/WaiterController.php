<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Table;
use Razorpay\Api\Api;
use App\Models\ExtraMenu;
use App\Models\Orderitem;
use App\Models\SiteSetting;
use App\Models\OrderWiseTax;
use Illuminate\Http\Request;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Models\RestaurantOrder;
use Illuminate\Validation\Rule;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WaiterController extends Controller
{
    // get all table list
    public function SelectTable()
    {
        $tables = Table::where('status', 1)->get();
        $forunderstaningonly = "booking_status = 0 means Table is Not Book Yet!Click Here!, if--> booking_status = 1 Table Is Already Booked!";
        $productWiseCoupon = ProductWiseCoupon::with('menuitem')->where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return response([
            'forunderstaningonly' => $forunderstaningonly,
            'tables' => $tables,
            'productWiseCoupon' => $productWiseCoupon,
            'coupononprice' => $coupononprice,


            'message' => 'Get Data Successfully',
            'status' => 'success'
        ], 200);
    }
    // get table order data
    public function TakeTableOrder(Request $request)
    {
        $table_id = $request->table_id;
        if (!empty($table_id)) {
            $gettableselect = Table::where('id', $request->table_id)->first();
            $menuitems = MenuItemPrice::where('status', 1)->get();
            $productWiseCoupon = ProductWiseCoupon::with('menuitem')->where('expiry_date', '>=', Carbon::now())->get();
            $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
            $getExtraitem = ExtraMenu::get();
            return response([

                'gettableselect' => $gettableselect,
                'menuitems' => $menuitems,
                'productWiseCoupon' => $productWiseCoupon,
                'coupononprice' => $coupononprice,
                'getExtraitem' => $getExtraitem,


                'message' => 'Get Data Successfully',
                'status' => 'success'
            ], 200);
        }

        return response([


            'message' => 'table_id is required!',
            'status' => 'success'
        ], 201);
    }
    // post table take order save
    public function TakeTableOrderSave(Request $request)
    {
        $data = $request->all();
        $ExtraItemData =  $request->input();


        $ruless =[
            "extraitem.*.itemtype" =>"required",
            "extraitem.*.menu_subcat_id" =>"required",
            "extraitem.*.item_id" =>"required",
            "extraitem.*.price" =>"required",
            "extraitem.*.item_qty" =>"required",


        ];

        $validator = Validator::make($data,$ruless);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $rules = [
            "extraitem"=>$ruless,
            "table_id" => "required",
            "total_no_person_intable" => "required",
            "payableamt" => "required",

        ];
        $customMessage = [
            "table_id.required" => "table_id Is Required",
            "total_no_person_intable.required" => "total_no_person_intable Is Required",
            "payableamt.required" => "payableamt Is Required select one of then General or NC",


        ];
        $validator = Validator::make($data, $rules, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $item_id = $request->item_id;



        $restorder = new RestaurantOrder();
        $restorder->table_id = $data['table_id'];
        $restorder->total_no_person_intable = $data['total_no_person_intable'];
        $restorder->payableamt = $data['payableamt'];
        $restorder->nc_remark = $data['nc_remark'];
        $restorder->staff_id = auth()->user()->staff_id;
        $restorder->grand_total = 0;
        $restorder->order_no = 0;
         date_default_timezone_set("Asia/Calcutta");
                     $restorder->order_time = date('d-m-Y H:i:s');
        $restorder->save();


        $unique_no = RestaurantOrder::orderBy('id', 'DESC')->pluck('id')->first();
        if ($unique_no == null or $unique_no == "") {

            $unique_no = 1;
        } else {

            $unique_no = $unique_no + 1;
        }
        $restorder->order_no = 'PROD' . $unique_no;
        $restorder->save();

        $uniqueitemid = Orderitem::orderBy('id', 'DESC')->pluck('id')->first();
        if($uniqueitemid == null or $uniqueitemid == "") {
            #If Table is Empty
            $uniqueitemid = 1;
        } else {
            #If Table has Already some Data
            $uniqueitemid = $uniqueitemid + 1;
        }





                foreach($ExtraItemData['extraitem'] as $key=>$value){
                    $orderitem = new Orderitem();
                $orderitem->order_no = 'PROD' . $unique_no;
                $orderitem->group_item = 'GroupItem-' . $uniqueitemid;
                $orderitem->order_type = $value['itemtype'];
                $orderitem->subcategory_id = $value['menu_subcat_id'];
                $orderitem->item_id = $value['item_id'];
                $orderitem->price = $value['price'];
                $orderitem->item_qty = $value['item_qty'];
                $orderitem->item_serve_time = $value['item_serve_time'];
                // offer
                $orderitem->no_of_qty_buy = $value['no_of_qty_buy'];
                 if( $value['no_qty_buy_to_free'] == NULL)
                    {
                         $orderitem->no_qty_buy_to_free = 0;
                    }else{
                         $orderitem->no_qty_buy_to_free = $value['no_qty_buy_to_free'];
                    }

                $orderitem->remark = $value['remark'];
                $orderitem->extra_menu_item_id = $value['extra_menu_item_id'];
                $orderitem->extraItemPrice = $value['extraItemPrice'];
                $getamount = $value['price'] * $value['item_qty'];
                $orderitem->amount = $getamount + $value['extraItemPrice'];
                // offer end
                $orderitem->save();
                }



            $tablestatus = Table::where('id', $data['table_id'])->first();
            $tablestatus->booking_status = 1;
            $tablestatus->table_order_no='PROD' . $unique_no;
            $tablestatus->save();
        return response([

            'restorder' => $restorder,
            'orderitem' => $orderitem ,
            'tablestatus'=> $tablestatus,
            'message' => 'Data save  Successfully',
            'status' => 'success'
        ], 200);







    }
    // get today order list
    public function WaiterTodayOrderList()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayorderlist = RestaurantOrder::with('tables', 'staffs')->where('order_status', '!=', 'Order Completed')->where('created_at', $todayDate)->where('staff_id', auth()->user()->staff_id)->get();
        return response([

            'todayorderlist' => $todayorderlist,
            'message' => 'Data Get  Successfully',
            'status' => 'success'
        ], 200);
    }
    // get edit order page
    public function WaiterEditOrder(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {


            $todayDate = Carbon::now()->format('Y-m-d');
            $orderlist= RestaurantOrder::with('tables','staffs')->where('order_no',$order_no)->first();

            $OrdersItemListOFCurrentTable= Orderitem::with('menuitem','extraitemadd')->where('order_no',$order_no)->get();
            $menuitems=MenuItemPrice::where('status',1)->get();
            $OrderWisetaxdet = OrderWiseTax::where('order_no', $order_no)->get();
            $tables = Table::where('status',1)->where('booking_status',0)->get();
            $getExtraitem = ExtraMenu::get();
                  $getBookedTablelistToTransferItem= RestaurantOrder::with('tables')->where('order_status','!=','Order Completed')->where('created_at',$todayDate)->where('table_id','!=',$orderlist['table_id'])->get();
            return response([

                'orderlist' => $orderlist,
                'getBookedTablelistToTransferItem' => $getBookedTablelistToTransferItem,
                'OrdersItemListOFCurrentTable' => $OrdersItemListOFCurrentTable,
                'menuitems' => $menuitems,
                'OrderWisetaxdet' => $OrderWisetaxdet,
                'tables' => $tables,
                'getExtraitem' => $getExtraitem,
                'message' => 'Data Get  Successfully',
                'status' => 'success'
            ], 200);
        }
        return response([

            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }
    // post table trasnfer data
    public function WaiterTransferTable(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {
            $validated = $request->validate([
                'table_id' => 'required',
            ]);

            $restorder=  RestaurantOrder::where('order_no',$order_no)->first();
            $get = Table::where('id', $request->table_id)->first();
            $tablestatus =Table::where('id',$restorder['table_id'])->first();
            $tablestatus->booking_status=0;
            $tablestatus->table_order_no=0;
            $tablestatus->save();
            $restorder->table_id=$request->table_id;
            $restorder->tran_table_remark="This ".$tablestatus['table_name']." trasnfered to ".$get['table_name'];
            $restorder->save();

            $tablestatu =Table::where('id',$request->table_id)->first();
            $tablestatu->booking_status=1;
              $tablestatu->table_order_no=$order_no;
            $tablestatu->save();

            $tablestatu->save();
            return response([
                'tablestatus'=> $tablestatus,
                'restorder'=> $restorder,
                'tablestatu' => $tablestatu,
                'message' => 'Data Save  Successfully',
                'status' => 'success'
            ], 200);
        }
        return response([


            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }
   // post more item data
    public function WaiterTakeMoreItem(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {

            $data =  $request->input();
            $ruless =[
                "extraitem.*.itemtype" =>"required",
                "extraitem.*.menu_subcat_id" =>"required",
                "extraitem.*.item_id" =>"required",
                "extraitem.*.price" =>"required",
                "extraitem.*.item_qty" =>"required",


            ];

        $validator = Validator::make($data,$ruless);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $rules = [
            "extraitem"=>$ruless,


        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $updateorder_time = RestaurantOrder::where('order_no',$order_no)->first();
        date_default_timezone_set("Asia/Calcutta");
        $updateorder_time->order_time = date('d-m-Y H:i:s');
       $updateorder_time->save();
       $uniqueitemid = Orderitem::orderBy('id', 'DESC')->pluck('id')->first();
        if($uniqueitemid == null or $uniqueitemid == "") {
            #If Table is Empty
            $uniqueitemid = 1;
        } else {
            #If Table has Already some Data
            $uniqueitemid = $uniqueitemid + 1;
        }
            foreach($data['extraitem'] as $key=>$value){
                $orderitem = new Orderitem();
            $orderitem->order_no = $order_no;
            $orderitem->group_item = 'GroupItem-' . $uniqueitemid;
            $orderitem->order_type = $value['itemtype'];
            $orderitem->subcategory_id = $value['menu_subcat_id'];
            $orderitem->item_id = $value['item_id'];
            $orderitem->price = $value['price'];
            $orderitem->item_qty = $value['item_qty'];
            // offer
            $orderitem->no_of_qty_buy = $value['no_of_qty_buy'];
          if( $value['no_qty_buy_to_free'] == NULL)
                    {
                         $orderitem->no_qty_buy_to_free = 0;
                    }else{
                         $orderitem->no_qty_buy_to_free = $value['no_qty_buy_to_free'];
                    }
            $orderitem->remark = $value['remark'];
            $orderitem->extra_menu_item_id = $value['extra_menu_item_id'];
            $orderitem->extraItemPrice = $value['extraItemPrice'];
            $getamount = $value['price'] * $value['item_qty'];
            $orderitem->amount = $getamount + $value['extraItemPrice'];
            // offer end
            $orderitem->save();

            }

            return response([

                'message' => 'Data Save  Successfully',
                'status' => 'success'
            ], 200);



        }
        return response([


            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);

    }
    // get tax tem data
    public function WaiterReviewOrderwithTax(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {

            $ordereitemlist = Orderitem::with('menuitem', 'extraitemadd')->where('order_no', $order_no)->get();
            $orderes = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
            $gettax = Tax::where('status', '1')->get();
            $gettaxinst = OrderWiseTax::where('order_no', $order_no)->first();

            return response([


                'ordereitemlist' => $ordereitemlist,
                'orderes' => $orderes,
                'gettax' => $gettax,
                'gettaxinst' => $gettaxinst,

                'message' => 'Data Get  Successfully',
                'status' => 'success'
            ], 200);
        }
        return response([
            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }

    // post tax temp data
    public function WaiterSavetaxtempdata(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {

            $validated = $request->validate([
                'discount' => 'required|min:0|max:20',
                'sub_total' => 'required|gt:0',
                'tax_check_box' => 'required',


            ]);

            // if ($request->discount <= 20) {
            //     $discountvalue = $request->sub_total * $request->discount / 100;
            //     $subtotalwithoffer = $request->sub_total - round($discountvalue, 1);

            //     foreach ($request->tax_check_box as $key => $attribute) {
            //         if (!empty($attribute)) {
            //             $datagettax = Tax::where('id', $attribute)->first();
            //             $get = $subtotalwithoffer * $datagettax['tax_percentage'] / 100;
            //             $ordertax = new OrderWiseTax();
            //             $ordertax->order_no = $order_no;
            //             $ordertax->tax_name = $datagettax['tax_name'];
            //             $ordertax->tax_percentage = $datagettax['tax_percentage'];
            //             $ordertax->tax_amount = $get;
            //             $ordertax->save();
            //         }
            //     }

            //     $total_bartax = OrderWiseTax::where('order_no', $order_no)->sum('tax_amount');
            //     $getGrndTotal = round($subtotalwithoffer, 1) + round($total_bartax, 1);
            //     $ff = $getGrndTotal * 100;


            //     $SaveBarTableOrder = RestaurantOrder::where('order_no', $order_no)->first();
            //     $SaveBarTableOrder->sub_total = $request->sub_total;
            //     $SaveBarTableOrder->subtotalwithoffer = $subtotalwithoffer;
            //     $SaveBarTableOrder->coupon_per = $request->discount;
            //     $SaveBarTableOrder->coupon_avail_amount = $discountvalue;
            //     $SaveBarTableOrder->total_tax = $total_bartax;
            //     $SaveBarTableOrder->grand_total = $getGrndTotal;
            //     $SaveBarTableOrder->save();

            //     // This is for generate dynamic QR Code For  Payment on Bill of Rozpay Start
            //     // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            //     // $getff = $api->qrCode->create(array(
            //     //     "type" => "upi_qr", "name" => "$order_no", "usage" => "single_use", "fixed_amount" => 1,
            //     //     "payment_amount" => round($ff, 1), "description" => "$order_no",
            //     //     "notes" => array("purpose" => "Test UPI QR code notes")
            //     // ));

            //     // This is save QrCode Url in YourDatabase start
            //     // $tableorderQR = RestaurantOrder::where('order_no', $order_no)->first();
            //     // $tableorderQR->image_url = $getff['image_url'];
            //     // $tableorderQR->save();

            //     DB::table('orderitems')
            //         ->where('order_no', $order_no)
            //         ->update(array(
            //             'updated_at' => date('Y-m-d H:i:s'),
            //             'order_item_status' => 'Order-Collected'
            //         ));
            //     // This is save QrCode Url in YourDatabase End



            //     // This is for generate dynamic QR Code For  Payment on Bill of Rozpay End


            //     $tablestatus = Table::where('id', $SaveBarTableOrder['table_id'])->first();
            //     $tablestatus->booking_status = 0;
            //     $tablestatus->save();
            //     return response([

            //         'message' => 'Data Save  Successfully',
            //         'status' => 'success'
            //     ], 200);


            // }

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





                return response([

                'message' => 'Data Updated  Successfully',
                'status' => 'success'
                ], 200);
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

                return response([

                'message' => 'Data Save  Successfully',
                'status' => 'success'
                ], 200);
            }
        }
        }
        return response([
            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);

    }




   // get  TablePaymentupdated data
    public function TblPaymentUpdatedCheckoutPage(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {


            // $subcategory = MenuSubCategory::get();
            // $menuitem = MenuItemPrice::get();
            $ordereitemlist = Orderitem::with('menuitem', 'extraitemadd')->where('order_no', $order_no)->get();
            $orderes = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
            $gettax = Tax::where('status', '1')->get();
            $gettaxinst = OrderWiseTax::where('order_no', $order_no)->get();


            return response([


                'ordereitemlist' => $ordereitemlist,
                // 'subcategory' => $subcategory,
                // 'menuitem' => $menuitem,
                'orderes' => $orderes,
                'gettax' => $gettax,

                'gettaxinst' => $gettaxinst,
                'message' => 'Data Get  Successfully',
                'status' => 'success'
            ], 200);

        }
        return response([
            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }

    // post TableOrderCheckout page
       public function TblPaymentUpdatedCheckoutsave(Request $request)
    {
        $order_no = $request->order_no;
         $payableamt = $request->payableamt;
         $payment_mode = $request->payment_mode;
        if (!empty($order_no) && !empty($payableamt) && !empty($payment_mode) ) {

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


                            return response([
                                'message' => 'Order Completed  Successfully!',
                                'takeoutorder' => $takeoutorder,
                                'status' => 'success'
                            ], 201);

                    } else {

                        return response([
                            'message' => 'Plz Enter Valid Amount data!',

                            'status' => 'success'
                        ], 201);
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


                            return response([
                                'message' => 'Order Completed  Successfully Of QR-Cash!',
                                'takeoutorder' => $takeoutorder,
                                'status' => 'success'
                            ], 201);


                    } else {

                        return response([
                            'message' => 'Plz Enter Valid Amount data!',

                            'status' => 'success'
                        ], 201);


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


                            return response([
                                'message' => 'Order Completed  Successfully Of QR-Card!',
                                'takeoutorder' => $takeoutorder,
                                'status' => 'success'
                            ], 201);

                    } else {

                        return response([
                            'message' => 'Plz Enter Valid Amount data!',
                            'status' => 'success'
                        ], 201);
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


                            return response([
                                'message' => 'Order Completed  Successfully Of Cash-Card!',
                                'takeoutorder' => $takeoutorder,
                                'status' => 'success'
                            ], 201);

                    } else {



                        return response([
                            'message' => 'Plz Enter Valid Amount data!',
                            'status' => 'success'
                        ], 201);
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


                            return response([
                                'message' => 'Order Completed  Successfully !'.$request->payment_mode,
                                'takeoutorder' => $takeoutorder,
                                'status' => 'success'
                            ], 201);





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

                return response([
                    'message' => 'Order Completed  Successfully NC!',
                    'tableordercheck' => $tableordercheck,
                    'status' => 'success'
                ], 201);

            }
        }
        return response([
            'message' => 'order_no  and payableamt  ,payment_mode is required!',
            'status' => 'success'
        ], 201);

    }

    // get table order slip data
   public function TableOrderSlip(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {

            $takeoutorderslip = RestaurantOrder::where('order_no', $order_no)->first();
            $takewayorderitemslip  = Orderitem::where('order_no', $order_no)->get();
            $getsiteSetting = SiteSetting::first();
            $orderwisetax = OrderWiseTax::where('order_no', $order_no)->get();

            return response([

                'takeoutorderslip' => $takeoutorderslip,
                'takewayorderitemslip' => $takewayorderitemslip,
                'getsiteSetting' => $getsiteSetting,
                'orderwisetax' => $orderwisetax,

                'message' => 'Data Get  Successfully',
                'status' => 'success'
            ], 200);
        }
        return response([

            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }
    // get todat order complete data
    public function WaiterTodayOrderCompleteList()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayordercompletelist = RestaurantOrder::with('tables', 'staffs')->where('order_status', 'Order Completed')->where('created_at', $todayDate)->where('staff_id', auth()->user()->staff_id)->get();
        return response([

            'todayorderlist' => $todayordercompletelist,
            'message' => 'Data Get  Successfully',
            'status' => 'success'
        ], 200);
    }


    public function TransferTableOrderitemToOtherTable(Request $request)
    {

          $order_no = $request->order_no;
        if (!empty($order_no)) {
            $validated = $request->validate([

                'current_order_id'=>'required',
                'trans_table_order_no'=>'required',
            ]);


             $restorder=  Orderitem::where('id',$request->current_order_id)->first();
            $restorder->order_no = $request->trans_table_order_no;
            $restorder->save();


            return response([

                'message' => 'Table Item Transfer  Successfully To Other Table',
                'status' => 'success'
            ], 200);
        }
        return response([


            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }

        public function DeleteOrderItem(Request $request)
        {
             $order_no = $request->order_no;
               if (!empty($order_no)) {

                    $validated = $request->validate([

                    'delete_order_item_id'=>'required',
                ]);

                     $deleteOrderItem = Orderitem::where('order_item_status','New-Order')->where('order_no', $order_no)->get();

            if (!$deleteOrderItem->isEmpty()) {
                Orderitem::where('id', $request->delete_order_item_id)->delete();
                return response([

                    'message' => 'Your Order Item  is Delete Successfully!',
                    'status' => 'success'
                ], 200);
            } else {
                return response([

                    'message' => 'data cant be deleted',
                    'status' => 'error'
                ], 200);
            }
               }
            return response([


                'message' => 'order_no is required!',
                'status' => 'error'
            ], 201);

        }

     public function OrderItemReplace(Request $request)
    {

          $order_no = $request->order_no;
        if (!empty($order_no)) {
            $validated = $request->validate([

                'current_order_id'=>'required',
                'order_waste_remark'=>'required',
            ]);


              $restorder=  Orderitem::where('order_item_status','Order-Collected')->where('order_no',$order_no)->where('id',$request->current_order_id)->get();



                if (!$restorder->isEmpty()) {


            $updateOrderItem=  Orderitem::where('order_item_status','Order-Collected')->where('order_no',$order_no)->where('id',$request->current_order_id)->first();
              $updateOrderItem->order_item_status = 'Replace-Item';
               $updateOrderItem->order_waste_remark = $request->input('order_waste_remark');
            $updateOrderItem->save();
            return response([

                'message' => 'Replace Order Item Request Has Been Sent To The Kitchen!',
                'status' => 'success'
            ], 200);
        } else {
            return response([

                'message' => 'Item Can Not Replace!',
                'status' => 'error'
            ], 200);
        }

        }
        return response([


            'message' => 'order_no is required!',
            'status' => 'error'
        ], 201);
    }
    
     public function orderedItemList(Request $request)
    {
        $order_no = $request->order_no;
        if (!empty($order_no)) {


            $orderedItemList= Orderitem::with('menuitem','extraitemadd')->where('order_no',$order_no)->get();
            return response([


                'orderedItemList' => $orderedItemList,
                'message' => 'Data Get  Successfully',
                'status' => 'success'
            ], 200);
        }
        return response([

            'message' => 'order_no is required!',
            'status' => 'success'
        ], 201);
    }
     public function searchmenuitem(Request $request) {
        $menu_item_name = request('menu_item_name'); // this return 22

        if (!empty($menu_item_name)) {
            $search = MenuItemPrice::where('menu_item_name', 'like', "%{$menu_item_name}%")

            ->get();

            return response([
                'searchdata' => $search,
                'message' => 'data fetch Successfully!',
                'status' => 'success'
            ], 200);


        }
        return response([


            'message' => 'menu_item_name is required!',
            'status' => 'error'
        ], 201);


    }


}
