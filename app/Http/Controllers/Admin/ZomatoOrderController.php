<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tax;
use Razorpay\Api\Api;
use App\Models\SiteSetting;
use App\Models\OrderWiseTax;
use App\Models\ZomtaoAddToCart;
use App\Models\TakeWayOrder;
use Illuminate\Http\Request;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Models\TakeWayOrderitem;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ZomatoOrderController extends Controller
{

    public function TakeZomatoOrder (Request $request)
    {

        if($request->meniitem_id != "")
        {
            $menuitemList = MenuItemPrice::where('type', 'restaurant-menu')->get();
            $menuitem = MenuItemPrice::where('id',$request->meniitem_id)->get();
            $subcategory = MenuSubCategory::where('rest_type', 'restaurant-menu')->get();

            $takewarycartitem = ZomtaoAddToCart::with('menuitem')->where('Staff_id', Auth::guard('admin')->user()->id)->get();
            $gettax = Tax::where('status', 1)->get();
        }else{
            $subcategory = MenuSubCategory::where('rest_type', 'restaurant-menu')->get();
            $menuitem = MenuItemPrice::where('type', 'restaurant-menu')->get();
            $takewarycartitem = ZomtaoAddToCart::with('menuitem')->where('Staff_id', Auth::guard('admin')->user()->id)->get();
            $gettax = Tax::where('status', 1)->get();
            $menuitemList = MenuItemPrice::where('type', 'restaurant-menu')->get();
        }






        return view('admin.zomato.view_take_zomato_order',compact('menuitem','menuitemList','subcategory','takewarycartitem','gettax'));
    }

    public function TodayTakeZomatoOrder()
    {
        $todayDate = Carbon::now()->format('Y-m-d');

            $todayZomatoorderlist = TakeWayOrder::where('created_at', $todayDate)->where('staff_id', Auth::guard('admin')->user()->staff_id)->where('type','Zomato-Oder')->get()->sortDesc();
            $overallcollectionwithGSt = TakeWayOrder::where('type','Zomato-Oder')->where('created_at', $todayDate)->sum('grand_total');
            $overallcollectionwithoutGSt = TakeWayOrder::where('type','Zomato-Oder')->where('created_at', $todayDate)->sum('total_tax');

        return view('admin.zomato.today_take_zomato_order')->with(compact('todayZomatoorderlist', 'overallcollectionwithGSt', 'overallcollectionwithoutGSt'));
    }




    public function ZomatoAddtocart(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_qty = $request->input('item_qty');
        $price = $request->input('price'); {
            $prod_check = MenuItemPrice::where('id', $item_id)->first(); {

                if (ZomtaoAddToCart::where('item_id', $item_id)->where('staff_id', Auth::guard('admin')->user()->id)->exists()) {
                    // return response()->json(['status' => $prod_check->menu_item_name . "Zomato Already Added to cart "]);
                    $cartItem =  ZomtaoAddToCart::where('item_id', $item_id)->where('staff_id', Auth::guard('admin')->user()->id)->first();
                    $get = $cartItem['item_qty']+1;
                    $cartItem->staff_id = Auth::guard('admin')->user()->id;
                    $cartItem->item_qty = $get;
                    $cartItem->amount = $get*$price;


                    $cartItem->save();
                    return response()->json(['status' => $prod_check->menu_item_name . "Zomato Item QTY Increment Successfully! "]);
                } else {
                    $cartItem = new ZomtaoAddToCart();
                    $cartItem->staff_id = Auth::guard('admin')->user()->id;
                    $cartItem->item_id = $item_id;
                    $cartItem->item_qty = $item_qty;
                    $cartItem->subcategory_id = 0;
                    $cartItem->price = $price;
                    $cartItem->amount = $item_qty*$price;


                    $cartItem->save();
                    return response()->json(['status' => $prod_check->menu_item_name . "Zomato Added to cart "]);
                }
            }
        }
    }


    public function updateZomatocart(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //  echo "<pre>",print_r($data); die;

            // Get Cart Details
            $cartDetails = ZomtaoAddToCart::find($data['cartid']);

            //Update the Qty
            ZomtaoAddToCart::where('id', $data['cartid'])->update(['item_qty' => $data['qty']]);
            return response()->json(['status' => "Quantity Updated"]);
        }
    }


    public function deletecartZomato($id)
    {
        $zomatitemcart = ZomtaoAddToCart::findOrFail($id);
        try {
            $zomatitemcart->delete();
            $message = "Your Cart item   is Delete Successfully!";
            return redirect()->back()->with('success_message', $message);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                $message = "data cant be deleted";
                return redirect('')->back()->with('error_message', $message);
            }
        }
    }




    public function CheckoutZomatoOrder(Request $request)
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

            $getid = 'ZOMATO' . $unique_no;

                if ($request->discount <= 20) {
                    $discountvalue = $request->sub_total * $request->discount / 100;
                    $subtotalwithoffer = $request->sub_total - round($discountvalue, 1);
                    if($request->tax_check_box != "")
                    {
                    foreach ($request->tax_check_box as $key => $attribute) {
                        if (!empty($attribute)) {
                            $datagettax = Tax::where('id', $attribute)->first();
                            $get = $subtotalwithoffer * $datagettax['tax_percentage'] / 100;
                            $ordertax = new OrderWiseTax();
                            $ordertax->order_no = $getid;
                            $ordertax->tax_name = $datagettax['tax_name'];
                            $ordertax->tax_percentage = $datagettax['tax_percentage'];
                            $ordertax->tax_amount = $get;
                            $ordertax->save();
                        }
                    }
                }

                    $total_bartax = OrderWiseTax::where('order_no', $getid)->sum('tax_amount');
                    $getGrndTotal = round($subtotalwithoffer, 1) + round($total_bartax, 1);


                }


            $takewayorder = new TakeWayOrder();
            $takewayorder->type = 'Zomato-Oder';
            $takewayorder->order_no = $getid;
            $takewayorder->staff_id = Auth::guard('admin')->user()->id;
            $takewayorder->sub_total = $data['sub_total'];
            $takewayorder->cust_name = $data['cust_name'];
            $takewayorder->zomtao_order_id = $data['zomtao_order_id'];
            $takewayorder->payment_mode = $data['payment_mode'];
            $takewayorder->coupon_per = $data['discount'];
            $takewayorder->coupon_avail_amount = $discountvalue;
            $takewayorder->subtotalwithoffer = round($subtotalwithoffer, 1);
            $takewayorder->grand_total = $getGrndTotal;
            $takewayorder->total_tax = round($total_bartax, 1);

            $takewayorder->order_status = 'Order-Processing';
            date_default_timezone_set("Asia/Calcutta");
                     $takewayorder->order_time = date('d-m-Y H:i:s');
            // dd($takewayorder);
            $takewayorder->save();
            $id = DB::getPdo()->lastInsertId();



            foreach ($data['item_id'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $orderitem = new TakeWayOrderitem();
                    $orderitem->order_no = $getid;
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




            $cartItem = ZomtaoAddToCart::where('staff_id', Auth::guard('admin')->user()->id)->get();
            ZomtaoAddToCart::destroy($cartItem);


            $notification = array(
                'message' => "Zomato Order Place Successfully !",
                'alert-type' => 'success'
            );


            return redirect('admin/Take-zomato-order/')->with($notification);
        }

    }

    public function ViewZomatoOrderStatus($order_no)
    {

        $vieworder = TakeWayOrder::where('order_no', $order_no)->where('type','Zomato-Oder')->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $viewOrderitem = TakeWayOrderitem::where('order_no', $order_no)->get();
        return view('admin.zomato.view_zomato_orderStatus', compact('vieworder', 'viewOrderitem'));
    }

    public function UpdateZomataoKitchOrder(Request $request, $order_no)
    {

        $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('type','Zomato-Oder')->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $takeoutorder->updated_kitchen_order_status = $request->updated_kitchen_order_status;
        $takeoutorder->save();

        DB::table('take_way_orderitems')
        ->where('order_no', $order_no)
        ->update(
            array(
                'updated_at' => date('Y-m-d H:i:s'),
                'order_item_status' => 'Order-Collected'
            )
        );


        $notification = array(
            'message' => " Zomato Kitchen Order Status Updated  Successfully!",
            'alert-type' => 'success'
        );

        return redirect('admin/Today-Take-zomato-order')->with($notification);
    }

    public function UpdateZomataoDeliveryBoySt(Request $request, $order_no)
    {

        $takeoutorder = TakeWayOrder::where('order_no', $order_no)->where('type','Zomato-Oder')->where('staff_id', Auth::guard('admin')->user()->staff_id)->first();
        $takeoutorder->delivery_status = $request->delivery_status;
        $takeoutorder->order_status = "Order Completed";
        $takeoutorder->save();

        $notification = array(
            'message' => " Zomato Delivery Boy  Order Hand Over   Successfully!",
            'alert-type' => 'success'
        );

        return redirect('admin/Today-Take-zomato-order')->with($notification);
    }

    public function ZomataoOrderSlip($order_no)
    {

            $takeoutorderslip = TakeWayOrder::where('order_no', $order_no)->first();
            $takewayorderitemslip = TakeWayOrderitem::where('order_no', $order_no)->get();
            $getsiteSetting = SiteSetting::first();
            $orderwisetax = OrderWiseTax::where('order_no', $order_no)->get();

            return view('admin.zomato.zomato_order_slip', compact('takeoutorderslip', 'takewayorderitemslip', 'getsiteSetting', 'orderwisetax'));

    }



}
