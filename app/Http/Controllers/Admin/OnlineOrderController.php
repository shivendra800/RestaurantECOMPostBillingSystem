<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Staff;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\MenuItemPrice;
use App\Models\OrdersProduct;
use App\Models\OrderItemStatus;
use App\Models\KitchenUseStocklog;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenProReceStock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItemConfiguration;

class OnlineOrderController extends Controller
{
    public function OnlineOrderList()
    {
        $getonlineList = Order::where('order_status','!=','Cancelled')->where('order_status','!=','Pending')->where('order_status','!=','Order-Delivered')->get()->toArray();
        return view('admin.onlineorders.get_list_onlineorder',compact('getonlineList'));
    }
    public function OnlineOrdersDetails($id)
    {
      
        
         $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
         $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
         $orderItemStatuses = OrderItemStatus::where('status',1)->get()->toArray();
         $getdeliveryBoy = Staff::where('type','DeliveryBoy')->where('status',1)->get()->toArray();
       return view('admin.onlineorders.online_order_details')->with(compact('getdeliveryBoy','orderDetails','userDetails','orderItemStatuses','orderStatuses'));
    }

    public function UpdateOrderStatus(Request $request)
    {
       
        if($request->isMethod('post')){
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
             // Updated DeliveryBoy Name and DeliveryBoy Phone Number
            
             if(!empty($data['assign_id'])){
                $getdeliveryBoy = Staff::where('id',$request->assign_id)->first()->toArray();

                $datas = array(

                    'assign_id' => $data['assign_id'],
                    'delivery_boy_name'   => $getdeliveryBoy['name'],
                    'delivery_boy_phone_no'     =>$getdeliveryBoy['mobile'],
                );
                Order::where('id', $data['order_id'])->update($datas);
               
                // Order::where('id',$data['order_id'])->update([
                //     ['assign_id'=>$data['assign_id']],
                //     ['delivery_boy_name'=>$getdeliveryBoy['name']],
                //     ['delivery_boy_phone_no'=>$getdeliveryBoy['mobile']],
                // ]);

            
             }
            $message = "Order Status Has Been Updated Successfully!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function UpdateOrderItemStatus(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            OrdersProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);
            $message = "Order Item Status Has Been Updated Successfully!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function ViewOnlineOrderItem($order_no)
    {

        $data['onlineOrder'] = Order::with('orders_products')->where('order_status', 'Order-Accepted')->where('id', $order_no)->latest()->first()->toArray();
        return view('admin.kichens.view_online_orderitem', $data);
    
    }

    public function ChangeOnlineOrderItemStatus(Request $request)
    {

        $status_id = $request->get('status_id');

            $statuschange = DB::table('orders_products')
            ->where('id', $status_id)
            ->first();

              $getMenuItemPriceId = MenuItemPrice::where('id', $statuschange->product_id)->first();

       

                  $checkIngrdCountExist = MenuItemConfiguration::where('menu_item_id', $statuschange->product_id)->count();
        if ($request->get('status') == 'Order-Accepted') {

            if ($checkIngrdCountExist > 0) {
               
                $get = DB::table('orders_products')
                ->where('id', $status_id)
                ->update(array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'item_status' => $request->get('status')
                ));

                //  Order  collected and stoc item will be less  without replacement order

                if ($request->get('status') == 'Order-Collected') {
                    $data = $request->all();
                    $gettotalqty = $statuschange->product_qty + $statuschange->no_qty_buy_to_free;


                    $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->product_id)->get();

                    foreach ($getAssignIngredients as $item) {

                        $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
                        if ($item->outputKilograms > 0) {
                            // Kilogram Stock
                            $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
                        } else if ($item->outputLiters > 0) {
                            // Liter Stock
                            $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
                        } else {

                            // pices Stock 
                            $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
                        }

                        $getKitchenStock->update();

                        $updateUseStocklog = new KitchenUseStocklog;
                        if ($item->outputKilograms > 0) {
                            // Kilogram Stock
                            $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
                            $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
                        } else if ($item->outputLiters > 0) {
                            // Liter Stock
                            $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
                            $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
                        } else {
                            // pices Stock 
                            $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
                            $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
                        }

                        $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
                        $updateUseStocklog->product_id = $item->ingredient_id;
                        $updateUseStocklog->unit_id = $item->unit_id;
                        $updateUseStocklog->save();
                    }
                }
                $notification = array(
                    'message' =>" Order Item Status Change Has Change Successfully!",
                    'alert-type' =>'success'
                );
                return redirect()->back()->with($notification);
                
          
            } else {
                $notification = array(
                    'message' => " No Ingredients is Added In Your Menu Item!.Plz Add Ingredients",
                    'alert-type' => 'success'
                );
                return redirect('admin/menu-configuraton/' . $getMenuItemPriceId->id)->with($notification);
            }
        }else{
            $get = DB::table('orders_products')
            ->where('id', $status_id)
            ->update(array(
                'updated_at' => date('Y-m-d H:i:s'),
                'item_status' => $request->get('status')
            ));


              if ($request->get('status') == 'Order-Collected') {
                $data = $request->all();
                $gettotalqty = $statuschange->product_qty + $statuschange->no_qty_buy_to_free;


                $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->product_id)->get();

                foreach ($getAssignIngredients as $item) {

                    $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
                    if ($item->outputKilograms > 0) {
                        // Kilogram Stock
                        $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
                    } else if ($item->outputLiters > 0) {
                        // Liter Stock
                        $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
                    } else {

                        // pices Stock 
                        $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
                    }

                    $getKitchenStock->update();

                    $updateUseStocklog = new KitchenUseStocklog;
                    if ($item->outputKilograms > 0) {
                        // Kilogram Stock
                        $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
                        $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
                    } else if ($item->outputLiters > 0) {
                        // Liter Stock
                        $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
                        $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
                    } else {
                        // pices Stock 
                        $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
                        $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
                    }

                    $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
                    $updateUseStocklog->product_id = $item->ingredient_id;
                    $updateUseStocklog->unit_id = $item->unit_id;
                    $updateUseStocklog->save();
                }
            }

            $notification = array(
                'message' =>" Order Item Status Change Has Change Successfully!",
                'alert-type' =>'success'
            );
            return redirect()->back()->with($notification);
        }
       
    }

    public function AssignOnlineOrderList()
    {
        $getonlineList = Order::where('assign_id',Auth::guard('admin')->user()->staff_id)->where('order_status','!=','Order-Delivered')->get()->toArray();
        $orderStatuses = OrderStatus::where('deliveryboy_status',1)->get()->toArray();
        return view('admin.deliveryboy.assign_order',compact('getonlineList','orderStatuses'));
    }

    public function DeliveryOnlineOrderList()
    {
        $getonlineList = Order::where('assign_id',Auth::guard('admin')->user()->staff_id)->where('order_status','Order-Delivered')->get()->toArray();
        return view('admin.deliveryboy.delivery_order',compact('getonlineList'));
    }

    public function OverallOnlineOrderList()
    {
        $getonlineList = Order::where('order_status','Order-Delivered')->get()->toArray();
         $overallcollectionwithGSt= Order::sum('grand_total');
        $overallcollectionwithoutGSt= Order::sum('total_tax');

        return view('admin.onlineorders.overall_online_order',compact('getonlineList','overallcollectionwithGSt','overallcollectionwithoutGSt'));
    }
    

    public function AssignViewOnlineOrder($order_no)
    {
        $orderDetails = Order::with('orders_products')->where('id',$order_no)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
         $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
       return view('admin.onlineorders.assgin_order_details')->with(compact('orderDetails','userDetails','orderStatuses'));
    }

    public function DeliveryboyChangeOrderStatus(Request $request)
    {

       
                    if ($request->isMethod('post')) {
                        $data = $request->all();

                            foreach ($data['order_status'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $changeorderStatusByDeliveryBoy = Order::where('id',$data['order_id'][$key])->first();
                                   

                                        $changeorderStatusByDeliveryBoy->order_status =$data['order_status'][$key];
                                        $changeorderStatusByDeliveryBoy->update();
                                  
                                  
                                }

                            }
                            $message = "Order Status has been Change Successfully!";
                            return redirect()->back()->with('success_message', $message);  
                    }
    }
}
