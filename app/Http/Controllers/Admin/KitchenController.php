<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Orderitem;
use App\Models\TakeWayOrder;
use Illuminate\Http\Request;
use App\Models\MenuItemPrice;
use App\Models\RestaurantOrder;
use App\Models\TakeWayOrderitem;
use App\Models\KitchenUseStocklog;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenProReceStock;
use App\Http\Controllers\Controller;
use App\Models\MenuItemConfiguration;
use Illuminate\Database\QueryException;

class KitchenController extends Controller
{

    public function MenuItemList()
    {
        $title = "Menu Item List";
        $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','restaurant-menu')->get()->toArray();
        return view('admin.kichens.menu_item_list',compact('menuitemPrice','title'));
    }

    public function TableOrder()
    {
      $todayDate = Carbon::now()->format('Y-m-d');
      //  $data['tableorder'] = RestaurantOrder::with('tables')->where('order_status', 'Order-Taken')->latest()->get()->toArray();
        //  $data['orderNoWiseItem'] = Orderitem::with('menuitem','orderwise')->where('order_item_status','!=','Order-Collected')->where('order_type','restaurant-menu')->latest('id')->get();
                 $data['orderNoWiseItem'] = Orderitem::with('menuitem','orderwise')->where('order_item_status','!=','Order-Collected')->where('order_type','restaurant-menu')->groupBy('group_item')->latest('id')->get();

        return view('admin.kichens.table_order', $data);
    }

    public function AcceptOrderKichStatus(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('orderitems')
            ->where('id',$status_id)
            ->first();
            
              DB::table('orderitems')
        ->where('order_type','restaurant-menu')
        ->where('group_item',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'order_item_status'=>"Order-Accepted"
        ));

        // DB::table('orderitems')
        // ->where('id',$status_id)
        // ->update(array(
        //     'updated_at'=>date('Y-m-d H:i:s'),
        //     'kitchen_order_status'=>$request->get('status')
        // ));
        

        // DB::table('orderitems')
        // ->where('order_type','restaurant-menu')
        // ->where('order_no',$statuschange->order_no)
        // ->update(array(
        //     'updated_at'=>date('Y-m-d H:i:s'),
        //     'order_item_status'=>$request->get('status')
        // ));
        return redirect('admin/table-orderList')->with('success_message',"Status updated Successfully!");
    }

    public function PrintKOTSummary($group_item)
    {
        // $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
      //  $data['getorderitemList'] = Orderitem::with('menuitem')->where('id', $id)->where('order_type','restaurant-menu')->first();
        $orderNoWise= Orderitem::where('group_item', $group_item)->where('order_type','restaurant-menu')->first();
              $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $orderNoWise['order_no'])->first();
        $data['getorderitemList'] = Orderitem::with('menuitem','orderwise','extraitemadd')->where('group_item', $group_item)->where('order_type','restaurant-menu')->get();
        return view('admin.kichens.print_kot_summary', $data);
    }
    public function TableOrderitemView($group_item)
    {

        // $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        // $data['orderNoWiseItem'] = Orderitem::with('menuitem')->where('order_no', $order_no)->where('order_type','restaurant-menu')->get();
         $orderNoWise= Orderitem::where('group_item', $group_item)->where('order_type','restaurant-menu')->first();
              $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $orderNoWise['order_no'])->first();
        $data['orderNoWiseItem'] = Orderitem::with('menuitem','orderwise','extraitemadd')->where('group_item', $group_item)->where('order_type','restaurant-menu')->get();
        return view('admin.kichens.view_table_orderitem', $data);
    }


    public function ChangeOrderItemStatus(Request $request)
    {

        $status_id = $request->get('status_id');

        $statuschange = DB::table('orderitems')
            ->where('id', $status_id)
            ->first();

            $get = DB::table('orderitems')
            ->where('id', $status_id)
            ->update(array(
                'updated_at' => date('Y-m-d H:i:s'),
                'order_item_status' => $request->get('status')
            ));
                            $notification = array(
                    'message' =>" Order Item Status Change Successfully!",
                    'alert-type' =>'success'
                );
                return redirect()->back()->with($notification);

        // $getMenuItemPriceId = MenuItemPrice::where('id', $statuschange->item_id)->first();

        // $checkIngrdCountExist = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->count();
        // if ($request->get('status') == 'Order-Accepted') {

        //     if ($checkIngrdCountExist > 0) {
               
        //         $get = DB::table('orderitems')
        //         ->where('id', $status_id)
        //         ->update(array(
        //             'updated_at' => date('Y-m-d H:i:s'),
        //             'order_item_status' => $request->get('status')
        //         ));

        //         //  Order  collected and stoc item will be less  without replacement order

        //         if ($request->get('status') == 'Order-Collected') {
        //             $data = $request->all();
        //             $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //             $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //             foreach ($getAssignIngredients as $item) {

        //                 $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //                 } else {

        //                     // pices Stock 
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //                 }

        //                 $getKitchenStock->update();

        //                 $updateUseStocklog = new KitchenUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //                 }

        //                 $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //                 $updateUseStocklog->product_id = $item->ingredient_id;
        //                 $updateUseStocklog->unit_id = $item->unit_id;
        //                 $updateUseStocklog->save();
        //             }
        //         }

        //         //  Order  collected and stoc item will be less  with replacement order 

        //         if ($request->get('status') == 'Replace-Order-Collected') {
        //             $data = $request->all();
        //             $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //             $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //             foreach ($getAssignIngredients as $item) {

        //                 $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //                 } else {

        //                     // pices Stock 
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //                 }

        //                 $getKitchenStock->update();

        //                 $updateUseStocklog = new KitchenUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //                 }

        //                 $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //                 $updateUseStocklog->product_id = $item->ingredient_id;
        //                 $updateUseStocklog->unit_id = $item->unit_id;
        //                 $updateUseStocklog->save();
        //             }
        //         }

        //         $notification = array(
        //             'message' =>" Order Item Status Change Successfully!",
        //             'alert-type' =>'success'
        //         );
        //         return redirect()->back()->with($notification);
          
        //     } else {
        //         $notification = array(
        //             'message' => " No Ingredients is Added In Your Menu Item!.Plz Add Ingredients",
        //             'alert-type' => 'success'
        //         );
        //         return redirect('admin/menu-configuraton/' . $getMenuItemPriceId->id)->with($notification);
        //     }
        // }else{
        //     $get = DB::table('orderitems')
        //     ->where('id', $status_id)
        //     ->update(array(
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'order_item_status' => $request->get('status')
        //     ));

        //       //  Order  collected and stoc item will be less  without replacement order

        //       if ($request->get('status') == 'Order-Collected') {
        //         $data = $request->all();
        //         $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //         $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //         foreach ($getAssignIngredients as $item) {

        //             $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //             } else {

        //                 // pices Stock 
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //             }

        //             $getKitchenStock->update();

        //             $updateUseStocklog = new KitchenUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //             }

        //             $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //             $updateUseStocklog->product_id = $item->ingredient_id;
        //             $updateUseStocklog->unit_id = $item->unit_id;
        //             $updateUseStocklog->save();
        //         }
        //     }

        //     //  Order  collected and stoc item will be less  with replacement order 

        //     if ($request->get('status') == 'Replace-Order-Collected') {
        //         $data = $request->all();
        //         $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //         $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //         foreach ($getAssignIngredients as $item) {

        //             $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //             } else {

        //                 // pices Stock 
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //             }

        //             $getKitchenStock->update();

        //             $updateUseStocklog = new KitchenUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //             }

        //             $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //             $updateUseStocklog->product_id = $item->ingredient_id;
        //             $updateUseStocklog->unit_id = $item->unit_id;
        //             $updateUseStocklog->save();
        //         }
        //     }


        //     $notification = array(
        //         'message' =>" Order Item Status Change To " .$request->get('status'). "Successfully!",
        //         'alert-type' =>'success'
        //     );
        //     return redirect()->back()->with($notification);
        // }
       
    }


    public function takewayOrder()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $data['takeWayorder'] = TakeWayOrder::where('created_at', $todayDate)->where('type','Take-Away-Order')->latest()->get()->toArray();
        $data['zomatoorder'] = TakeWayOrder::where('created_at', $todayDate)->where('type','Zomato-Oder')->latest()->get()->toArray();
        return view('admin.kichens.takeWay_order', $data);
    }
    public function AcceptTakeWayOrderKichStatus(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('take_way_orderitems')
            ->where('id',$status_id)
            ->first();
            
              DB::table('take_way_orderitems')
                ->where('order_no',$status_id)
                ->update(array(
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'order_item_status'=>"Order-Accepted"
                 ));
                 DB::table('take_way_orders')
                 ->where('order_no',$status_id)
                 ->update(array(
                     'updated_at'=>date('Y-m-d H:i:s'),
                     'updated_kitchen_order_status'=>"Order-Accepted"
                  ));

       
        return redirect('admin/takeway-orderList')->with('success_message',"Status updated Successfully!");
    }

    public function PrintTakeWayKOTSummary($order_no)
    {
        $data['getorderNo'] = TakeWayOrder::where('order_no', $order_no)->first();
        $data['getorderitemList'] = TakeWayOrderitem::with('menuitem')->where('order_no', $order_no)->get();
        return view('admin.kichens.print_takekot_summary', $data);
    }
    public function takewayOrderitemView($order_no)
    {

        $data['takeWayorder'] = TakeWayOrder::where('order_no', $order_no)->first();
        $data['orderNoWiseItem'] = TakeWayOrderitem::with('menuitem')->where('order_no', $order_no)->get();
        return view('admin.kichens.view_takeWay_orderitem', $data);
    }


    public function ChangeTakeWayOrderItemStatus(Request $request)
    {

        $status_id = $request->get('status_id');

        $statuschange = DB::table('take_way_orderitems')
            ->where('id', $status_id)
            ->first();

            $get = DB::table('take_way_orderitems')
            ->where('id', $status_id)
            ->update(array(
                'updated_at' => date('Y-m-d H:i:s'),
                'order_item_status' => $request->get('status')
            ));

            $notification = array(
                'message' =>" Order Item Status Change Successfully!",
                'alert-type' =>'success'
            );
            return redirect()->back()->with($notification);

        // $getMenuItemPriceId = MenuItemPrice::where('id', $statuschange->item_id)->first();
        // $checkIngrdCountExist = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->count();
        // if ($request->get('status') == 'Order-Accepted') {

        //     if ($checkIngrdCountExist > 0) {
               
        //         $get = DB::table('take_way_orderitems')
        //         ->where('id', $status_id)
        //         ->update(array(
        //             'updated_at' => date('Y-m-d H:i:s'),
        //             'order_item_status' => $request->get('status')
        //         ));

        //         //  Order  collected and stoc item will be less  without replacement order

        //         if ($request->get('status') == 'Order-Collected') {
        //             $data = $request->all();
        //             $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //             $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //             foreach ($getAssignIngredients as $item) {

        //                 $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //                 } else {

        //                     // pices Stock 
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //                 }

        //                 $getKitchenStock->update();

        //                 $updateUseStocklog = new KitchenUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //                 }

        //                 $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //                 $updateUseStocklog->product_id = $item->ingredient_id;
        //                 $updateUseStocklog->unit_id = $item->unit_id;
        //                 $updateUseStocklog->save();
        //             }
        //         }

        //         //  Order  collected and stoc item will be less  with replacement order 

        //         if ($request->get('status') == 'Replace-Order-Collected') {
        //             $data = $request->all();
        //             $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //             $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //             foreach ($getAssignIngredients as $item) {

        //                 $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //                 } else {

        //                     // pices Stock 
        //                     $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //                 }

        //                 $getKitchenStock->update();

        //                 $updateUseStocklog = new KitchenUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //                 }

        //                 $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //                 $updateUseStocklog->product_id = $item->ingredient_id;
        //                 $updateUseStocklog->unit_id = $item->unit_id;
        //                 $updateUseStocklog->save();
        //             }
        //         }

        //         $notification = array(
        //             'message' =>" Order Item Status Change Successfully!",
        //             'alert-type' =>'success'
        //         );
        //         return redirect()->back()->with($notification);
          
        //     } else {
        //         $notification = array(
        //             'message' => " No Ingredients is Added In Your Menu Item!.Plz Add Ingredients",
        //             'alert-type' => 'success'
        //         );
        //         return redirect('admin/menu-configuraton/' . $getMenuItemPriceId->id)->with($notification);
        //     }
        // }else{
        //     $get = DB::table('take_way_orderitems')
        //     ->where('id', $status_id)
        //     ->update(array(
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'order_item_status' => $request->get('status')
        //     ));

        //       //  Order  collected and stoc item will be less  without replacement order

        //       if ($request->get('status') == 'Order-Collected') {
        //         $data = $request->all();
        //         $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //         $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //         foreach ($getAssignIngredients as $item) {

        //             $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //             } else {

        //                 // pices Stock 
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //             }

        //             $getKitchenStock->update();

        //             $updateUseStocklog = new KitchenUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //             }

        //             $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //             $updateUseStocklog->product_id = $item->ingredient_id;
        //             $updateUseStocklog->unit_id = $item->unit_id;
        //             $updateUseStocklog->save();
        //         }
        //     }

        //     //  Order  collected and stoc item will be less  with replacement order 

        //     if ($request->get('status') == 'Replace-Order-Collected') {
        //         $data = $request->all();
        //         $gettotalqty = $statuschange->item_qty + $statuschange->no_qty_buy_to_free;


        //         $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //         foreach ($getAssignIngredients as $item) {

        //             $getKitchenStock = KitchenProReceStock::where('product_id', $item->ingredient_id)->first();
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->outputLiters * $gettotalqty;
        //             } else {

        //                 // pices Stock 
        //                 $getKitchenStock->consumption_qty = $getKitchenStock->consumption_qty - $item->use_weight * $gettotalqty;
        //             }

        //             $getKitchenStock->update();

        //             $updateUseStocklog = new KitchenUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->kitchen_current_stock = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->use_weight * $gettotalqty;
        //             }

        //             $updateUseStocklog->after_use_stock = $getKitchenStock->consumption_qty;
        //             $updateUseStocklog->product_id = $item->ingredient_id;
        //             $updateUseStocklog->unit_id = $item->unit_id;
        //             $updateUseStocklog->save();
        //         }
        //     }


        //     $notification = array(
        //         'message' =>" Order Item Status Change To " .$request->get('status'). "Successfully!",
        //         'alert-type' =>'success'
        //     );
        //     return redirect()->back()->with($notification);
        // }
       
    }

    public function DeleteKitchenApprovel(Request $request,$id)
    {
        if($request->get('reqTodelete')=="Accept-Delete-Request")
        {
            $orderitemdel = Orderitem::findOrFail($id);
            try {
                $orderitemdel->delete();
                $message= "Your Order Item  is Delete Successfully!";
                return redirect()->back()->with('success_message',$message);
            } catch (QueryException $e){
            if($e->getCode() == "23000"){
                $message= "data cant be deleted";
                return redirect()->back()->with('error_message',$message);
            }}   

        }else{

            $get = Orderitem::where('id', $id)->first();
            $get->reqTodelete = "This Item Can't Delete";
            $get->save();
                  $message= "This Item Can't Delete";
                return redirect()->back()->with('success_message',$message);

        }
    }


}
