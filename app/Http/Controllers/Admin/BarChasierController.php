<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Order;
use App\Models\BarTable;
use App\Models\Orderitem;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\BarTableChair;
use App\Models\BarTableOrder;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\BarUseStocklog;
use App\Models\BarProReceStock;
use App\Models\RestaurantOrder;
use App\Models\BarTableOrderTax;
use App\Models\BarTableOrderItem;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItemConfiguration;
use Illuminate\Database\QueryException;

class BarChasierController extends Controller
{

    public function BarMenuItemList()
    {
        $title = "Menu Item List";
        $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','bar-menu')->get()->toArray();
        return view('admin.kichens.menu_item_list',compact('menuitemPrice','title'));
    }
    // public function RestaurantBarOrder()
    // {
    //     $restbaroreder= RestaurantOrder::with('tables','staffs')->where('order_status','!=','Order Completed')->get();
    //     return view('admin.bars.restaurant_bar_order',compact('restbaroreder'));
    // }

    // public function AccepRestBartOrderStatus(Request $request)
    // {
        
    //     $status_id=$request->get('status_id');

    //     $statuschange=DB::table('restaurant_orders')
    //         ->where('id',$status_id)
    //         ->first();

    //     DB::table('restaurant_orders')
    //     ->where('id',$status_id)
    //     ->update(array(
    //         'updated_at'=>date('Y-m-d H:i:s'),
    //         'bar_order_status'=>$request->get('status')
    //     ));

    //     // DB::table('orderitems')
    //     // ->where('order_type','bar-menu')
    //     // ->where('order_no',$statuschange->order_no)
    //     // ->update(array(
    //     //     'updated_at'=>date('Y-m-d H:i:s'),
    //     //     'order_item_status'=>$request->get('status')
    //     // ));
    //     return redirect('admin/restaurant-barorder')->with('success_message',"Status updated Successfully!");
    // }

    // public function PrintKOTRestBarOrderSummary($order_no)
    // {
    //     $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
    //     $data['getorderitemList'] = Orderitem::with('menuitem')->where('order_type','bar-menu')->where('order_no', $order_no)->get();
    //     return view('admin.bars.print_restbarorderKot_summary', $data);
    // }

    // public function ViewRestBarOrderitem($order_no)
    // {

    //     $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
    //     $data['orderNoWiseItem'] = Orderitem::with('menuitem')->where('order_type','bar-menu')->where('order_no', $order_no)->get();
    //     return view('admin.bars.view_restbar_orderitem', $data);
    // }
    
        public function RestaurantBarOrder()
    {
      //  $restbaroreder= RestaurantOrder::with('tables','staffs')->where('order_status','!=','Order Completed')->get();
      $data['orderNoWiseItem'] = Orderitem::with('menuitem','orderwise')->where('order_item_status','!=','Order-Collected')->where('order_type','bar-menu')->groupBy('group_item')->latest('id')->get();
        return view('admin.bars.restaurant_bar_order',$data);
    }

    public function AccepRestBartOrderStatus(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('orderitems')
            ->where('id',$status_id)
            ->first();

        DB::table('orderitems')
        ->where('order_type','bar-menu')
        ->where('group_item',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'order_item_status'=>$request->get('status')
        ));

        // DB::table('orderitems')
        // ->where('order_type','bar-menu')
        // ->where('order_no',$statuschange->order_no)
        // ->update(array(
        //     'updated_at'=>date('Y-m-d H:i:s'),
        //     'order_item_status'=>$request->get('status')
        // ));
        return redirect('admin/restaurant-barorder')->with('success_message',"Status updated Successfully!");
    }

    public function PrintKOTRestBarOrderSummary($group_item)
    {
        // $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        // $data['getorderitemList'] = Orderitem::with('menuitem')->where('order_type','bar-menu')->where('order_no', $order_no)->get();

        $orderNoWise= Orderitem::where('group_item', $group_item)->where('order_type','bar-menu')->first();
        $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $orderNoWise['order_no'])->first();
  $data['getorderitemList'] = Orderitem::with('menuitem','orderwise','extraitemadd')->where('group_item', $group_item)->where('order_type','bar-menu')->get();
        return view('admin.bars.print_restbarorderKot_summary', $data);
    }

    public function ViewRestBarOrderitem($group_item)
    {

        // $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $order_no)->first();
        // $data['orderNoWiseItem'] = Orderitem::with('menuitem')->where('order_type','bar-menu')->where('order_no', $order_no)->get();

        $orderNoWise= Orderitem::where('group_item', $group_item)->where('order_type','bar-menu')->first();
        $data['getorderNo'] = RestaurantOrder::with('tables', 'staffs')->where('order_no', $orderNoWise['order_no'])->first();
  $data['orderNoWiseItem'] = Orderitem::with('menuitem','orderwise','extraitemadd')->where('group_item', $group_item)->where('order_type','bar-menu')->get();
        return view('admin.bars.view_restbar_orderitem', $data);
    }

    public function ChangeBarOrderItemStatus(Request $request)
    {

        // $status_id = $request->get('status_id');

        // $statuschange = DB::table('orderitems')
        //     ->where('id', $status_id)
        //     ->first();

        //     $notification = array(
        //         'message' =>" Order Item Status Change Successfully!",
        //         'alert-type' =>'success'
        //     );
        //     return redirect()->back()->with($notification);
        
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


        //                  $getAssignIngredients = MenuItemConfiguration::where('menu_item_id', $statuschange->item_id)->get();

        //             foreach ($getAssignIngredients as $item) {

        //                     $getKitchenStock = BarProReceStock::where('product_id', $item->ingredient_id)->first();
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

        //                 $updateUseStocklog = new BarUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
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

        //                 $getKitchenStock = BarProReceStock::where('product_id', $item->ingredient_id)->first();
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

        //                 $updateUseStocklog = new BarUseStocklog;
        //                 if ($item->outputKilograms > 0) {
        //                     // Kilogram Stock
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //                 } else if ($item->outputLiters > 0) {
        //                     // Liter Stock
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                     $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //                 } else {
        //                     // pices Stock 
        //                     $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
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

        //             $getKitchenStock = BarProReceStock::where('product_id', $item->ingredient_id)->first();
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

        //             $updateUseStocklog = new BarUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
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

        //             $getKitchenStock = BarProReceStock::where('product_id', $item->ingredient_id)->first();
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

        //             $updateUseStocklog = new BarUseStocklog;
        //             if ($item->outputKilograms > 0) {
        //                 // Kilogram Stock
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputKilograms * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputKilograms * $gettotalqty;
        //             } else if ($item->outputLiters > 0) {
        //                 // Liter Stock
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->outputLiters * $gettotalqty;
        //                 $updateUseStocklog->usestock_stock = $item->outputLiters * $gettotalqty;
        //             } else {
        //                 // pices Stock 
        //                 $updateUseStocklog->bar_current_stock	 = $getKitchenStock->consumption_qty + $item->use_weight * $gettotalqty;
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

    
    public function BarUseStockLog()
    {
        $Usestocklog = BarUseStocklog::with('unit','product')->get()->toArray();
        $getingredient = Ingredient::get()->toArray();  
        return view('admin.bars.bar_usestock_log')->with(compact('Usestocklog','getingredient'));
    }


    public function TakeBarCustOrder()
    {
          $getbartable = BarTable::get()->toArray();
        return view('admin.bars.taken_bar_order',compact('getbartable'));
    }
    public function BarTableorder(Request $request,$id)
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
                    #Store Unique Order/Product Number
                    $unique_no = BarTableOrder::orderBy('id', 'DESC')->pluck('id')->first();
                    if ($unique_no == null or $unique_no == "") {
                        #If Table is Empty
                        $unique_no = 1;
                    } else {
                        #If Table has Already some Data
                        $unique_no = $unique_no + 1;
                    }
                $restorder = new BarTableOrder();
                $restorder->bar_order_type = "Table-Order";
                $restorder->bar_table_id = $data['table_id'];
                $restorder->total_no_person_intable = $data['total_no_person_intable'];
                $restorder->staff_id = Auth::guard('admin')->user()->staff_id;
                $restorder->grand_total = 0;
                $restorder->order_no = 'DUNKBAR' . $unique_no;
                $restorder->save();

                foreach ($data['item_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $update_vendor_tbl = MenuItemPrice::where('id', $data['item_id'])->first();
                        $gettotal = ($data['price'][$key] * $data['item_qty'][$key]+($data['price'][$key] * $data['item_qty'][$key]*$data['bar_tax_percentage'][$key]/100));
                        $orderitem = new BarTableOrderItem();
                        $orderitem->order_no = 'DUNKBAR' . $unique_no;
                        $orderitem->order_type = $data['itemtype'][$key];
                        $orderitem->subcategory_id = $data['menu_subcat_id'][$key];
                        $orderitem->item_id = $data['item_id'][$key];
                        $orderitem->price = $data['price'][$key];
                        $orderitem->item_qty = $data['item_qty'][$key];
                        $orderitem->bar_tax_percentage = $data['bar_tax_percentage'][$key];
                        $orderitem->item_serve_time = $data['item_serve_time'][$key];
                        // offer
                        $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                        $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                        // offer end
                        $orderitem->amount = $gettotal;
                        $orderitem->save();
                    }
                }
                $tablestatus = BarTable::where('id', $data['table_id'])->first();
                $tablestatus->table_status = 1;
                $tablestatus->order_no = 'DUNKBAR' . $unique_no;
                $tablestatus->save();


                return redirect('admin/take-tableWiseOrder');
            }
        }
        $tables = BarTable::where('status', 1)->where('table_status', 0)->get();
        $gettableselect = BarTable::where('id', $id)->first();
        $menuitems = MenuItemPrice::where('status', 1)->where('type','bar-menu')->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.barOrders.take_bar_table_order')->with(compact('tables', 'menuitems', 'coupononprice', 'productWiseCoupon', 'gettableselect'));
    }

    public function ViewBarTableOrder(Request $request, $orderNo)
    {
        $orderlist= BarTableOrder::with('tables','staffs')->where('order_no',$orderNo)->first();
        $ViewOrdersDetails= BarTableOrderItem::with('menuitem')->where('order_no',$orderNo)->get();
        $menuitems=MenuItemPrice::where('status',1)->where('type','bar-menu')->get();
        $OrderWisetaxdet = BarTableOrderTax::where('order_no', $orderNo)->get();
        $tables = BarTable::where('status',1)->where('table_status',0)->get();
        return view('admin.bars.view_barTable_order')->with(compact('tables','orderlist','ViewOrdersDetails','menuitems','OrderWisetaxdet'));  
    }
    public function AddBarTableMoreItem(Request $request,$order_no)
    {
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['item_id'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $gettotal = ($data['price'][$key] * $data['item_qty'][$key]+($data['price'][$key] * $data['item_qty'][$key]*$data['bar_tax_percentage'][$key]/100));
                 
                    $orderitem = new BarTableOrderItem();
                    $orderitem->order_no = $order_no;
                    $orderitem->order_type = $data['itemtype'][$key];
                    $orderitem->subcategory_id = $data['menu_subcat_id'][$key];
                    
                    $orderitem->item_id = $data['item_id'][$key];
                    $orderitem->price = $data['price'][$key];
                    $orderitem->item_qty = $data['item_qty'][$key];
                    $orderitem->bar_tax_percentage = $data['bar_tax_percentage'][$key];
                    $orderitem->amount = $gettotal;
                     // offer
                     $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                     $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                     // offer end
                    $orderitem->save();
                }
            }

            $notification = array(
                'message' =>" More Item Added  Successfully!",
                'alert-type' =>'success'
            );
          

            return redirect('admin/bar-table-order-view/'.$order_no)->with($notification);
        }
    }

    public function ViewBarTableTransferOrder(Request $request,$order_no)
    {
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            $restorder=  BarTableOrder::where('order_no',$order_no)->first();
            $get = BarTable::where('id', $data['table_id'])->first();
            $tablestatus =BarTable::where('id',$restorder['bar_table_id'])->first();
            $tablestatus->table_status=0;
            $tablestatus->order_no =0;
            $tablestatus->save();

            $restorder->bar_table_id=$data['table_id'];
            $restorder->tran_table_remark="This ".$tablestatus['table_name']." trasnfered to ".$get['table_name'];
            $restorder->save();

            $tablestatu =BarTable::where('id',$data['table_id'])->first();
            $tablestatu->table_status=1;
            $tablestatu->order_no = $order_no;
            $tablestatu->save();

            $notification = array(
                'message' =>" Bar Table Transfer   Successfully!",
                'alert-type' =>'success'
            );
          

            return redirect('admin/bar-table-order-view/'.$order_no)->with($notification);
        }
    }

    public function DeleteBarTableOrderItem($id)
    {
        $orderitemdel = BarTableOrderItem::findOrFail($id);
        try {
            $orderitemdel->delete();
            $message= "Your Bar Table Order Item  is Delete Successfully!";
            return redirect()->back()->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect()->back()->with('error_message',$message);
        }}   
    }

    public function SelectTableWiseChair()
    {
        $getbartable = BarTable::get()->toArray();
        return view('admin.bars.select_table_wise_chair',compact('getbartable'));
    }
    public function TakeBarTableWiseChairOrder(Request $request,$tableid)
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
                    #Store Unique Order/Product Number
                    $unique_no = BarTableOrder::orderBy('id', 'DESC')->pluck('id')->first();
                    if ($unique_no == null or $unique_no == "") {
                        #If Table is Empty
                        $unique_no = 1;
                    } else {
                        #If Table has Already some Data
                        $unique_no = $unique_no + 1;
                    }
                $restorder = new BarTableOrder();
                $restorder->bar_order_type = "Chair-Order";
                $restorder->bar_table_id = $data['table_id'];
                $restorder->total_no_person_intable = $data['total_no_person_intable'];
                $restorder->staff_id = Auth::guard('admin')->user()->staff_id;
                $restorder->grand_total = 0;
                $restorder->order_no = 'DUNKBAR' . $unique_no;
                $restorder->save();

                foreach ($data['item_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $update_vendor_tbl = MenuItemPrice::where('id', $data['item_id'])->first();
                        $gettotal = ($data['price'][$key] * $data['item_qty'][$key]+($data['price'][$key] * $data['item_qty'][$key]*$data['bar_tax_percentage'][$key]/100));
                        $orderitem = new BarTableOrderItem();
                        $orderitem->order_no = 'DUNKBAR' . $unique_no;
                        $orderitem->chairs_id = $data['chairs_id'][$key];
                        $orderitem->order_type = $data['itemtype'][$key];
                        $orderitem->subcategory_id = $data['menu_subcat_id'][$key];
                        $orderitem->item_id = $data['item_id'][$key];
                        $orderitem->price = $data['price'][$key];
                        $orderitem->item_qty = $data['item_qty'][$key];
                        $orderitem->bar_tax_percentage = $data['bar_tax_percentage'][$key];
                        $orderitem->item_serve_time = $data['item_serve_time'][$key];
                        // offer
                        $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                        $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                        // offer end
                        $orderitem->amount = $gettotal;
                        $orderitem->save();
                    }
                }
                $tablestatus = BarTable::where('id', $data['table_id'])->first();
                $tablestatus->table_status = 1;
                $tablestatus->order_no = 'DUNKBAR' . $unique_no;
                $tablestatus->save();
                $notification = array(
                    'message' =>"Chair Wise Order Place  Successfully!",
                    'alert-type' =>'success'
                );

                return redirect('admin/take-chairWiseOrder')->with($notification);
            }
        }
        $tables = BarTable::where('status', 1)->where('table_status', 0)->get();
        $gettableselect = BarTable::where('id', $tableid)->first();
        $gtChairTablwWise = BarTableChair::where('table_id', $tableid)->get();
        $menuitems = MenuItemPrice::where('status', 1)->where('type','bar-menu')->get();
        $productWiseCoupon = ProductWiseCoupon::where('expiry_date', '>=', Carbon::now())->get();
        $coupononprice = CouponOnPrice::where('expiry_date', '>=', Carbon::now())->get();
        return view('admin.barOrders.take_bar_tablewiseChair_order_multiple')->with(compact('tables','gtChairTablwWise', 'menuitems', 'coupononprice', 'productWiseCoupon', 'gettableselect'));
    }

    public function ViewBarTableWiseChairOrder(Request $request, $orderNo)
    {
        $orderlist= BarTableOrder::with('tables','staffs')->where('order_no',$orderNo)->first();
        $ViewOrdersDetails= BarTableOrderItem::with('menuitem','barchairname')->where('order_no',$orderNo)->get();
          $gtChairTablwWise = BarTableChair::where('table_id', $orderlist['bar_table_id'])->get();
        $menuitems=MenuItemPrice::where('status',1)->where('type','bar-menu')->get();
        $OrderWisetaxdet = BarTableOrderTax::where('order_no', $orderNo)->get();
        $tables = BarTable::where('status',1)->where('table_status',0)->get();
        return view('admin.bars.view_barTableWiseChair_order')->with(compact('tables','gtChairTablwWise','orderlist','ViewOrdersDetails','menuitems','OrderWisetaxdet'));  
    }

    public function AddBarTableWiseChairMoreItem(Request $request,$order_no)
    {
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['item_id'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $gettotal = ($data['price'][$key] * $data['item_qty'][$key]+($data['price'][$key] * $data['item_qty'][$key]*$data['bar_tax_percentage'][$key]/100));
                    $orderitem = new BarTableOrderItem();
                    $orderitem->order_no = $order_no;
                    $orderitem->chairs_id = $data['chairs_id'][$key];
                    $orderitem->order_type = $data['itemtype'][$key];
                    $orderitem->subcategory_id = $data['menu_subcat_id'][$key];
                    
                    $orderitem->item_id = $data['item_id'][$key];
                    $orderitem->price = $data['price'][$key];
                    $orderitem->item_qty = $data['item_qty'][$key];
                    $orderitem->bar_tax_percentage = $data['bar_tax_percentage'][$key];
                    $orderitem->amount = $gettotal;
                     // offer
                     $orderitem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                     $orderitem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                     // offer end
                    $orderitem->save();
                }
            }

            $notification = array(
                'message' =>" More Item Added  Successfully!",
                'alert-type' =>'success'
            );
          

            return redirect('admin/take-bar-tableWiseChair-OrderView/'.$order_no)->with($notification);
        }
    }

    
   
    
}
