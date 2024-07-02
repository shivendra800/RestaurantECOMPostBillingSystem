<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orderitem;
use App\Models\RestaurantOrder;
use Illuminate\Http\Request;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\ProductWiseCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TakeWayOrder;
use App\Models\TakeWayOrderitem;
use Illuminate\Database\QueryException;
use Ramsey\Uuid\Codec\OrderedTimeCodec;

class CouponController extends Controller
{
    public function CouponList()
    {
        $productWiseCoupon = ProductWiseCoupon::get();
        return view('admin.coupon.coupon_list')->with(compact('productWiseCoupon'));
    }

    public function AddCoupon(Request $request, $id = null)
    {

        if ($id == "") {
            $title = "Add";
            $productoffer = new ProductWiseCoupon;
            $notification = array(
                'message' =>"Product Wise Coupon Added Successfully!",
                'alert-type' =>'success'
            );
        } else {
            $title = "Edit";
            $productoffer = ProductWiseCoupon::find($id);
            $notification = array(
                'message' =>"Product Wise Coupon Has Been Updated Successfully!",
                'alert-type' =>'success'
            );
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validated = $request->validate([

                'promocode' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:product_wise_coupons,promocode,'.$id,
                'remark' => 'required',
               
                'product_id' => 'required',
                'start_date' => 'required',
                'expiry_date' => 'required',
                'no_of_qty_buy' => 'required',
                'no_qty_buy_to_free' => 'required',

            ]);
            $productoffer->product_id = $data['product_id'];
            $productoffer->promocode = $data['promocode'];
            $productoffer->offer_type = "Offer-In-Qty";
            $productoffer->offer_per = "0";
            $productoffer->no_of_qty_buy = $data['no_of_qty_buy'];
            $productoffer->no_qty_buy_to_free = $data['no_qty_buy_to_free'];
            $productoffer->start_date = $data['start_date'];
            $productoffer->expiry_date = $data['expiry_date'];
            $productoffer->remark = $data['remark'];
            $productoffer->save();
            return redirect('admin/Coupon-List')->with($notification);
        }
        $menuitems = MenuItemPrice::where('status', 1)->get();
        return view('admin.coupon.add_coupon', compact('title', 'menuitems','productoffer'));
    }

   public function DeleteProductWiseCoupon($id)
    {
        $prdwisecoupon = ProductWiseCoupon::findOrFail($id);
        $getOderItem = Orderitem::where('item_id',$prdwisecoupon->product_id)->where('no_qty_buy_to_free','!=',0)->exists();
        $getTakeWayOrderItem = TakeWayOrderitem::where('item_id',$prdwisecoupon->product_id)->where('no_qty_buy_to_free','!=',0)->exists();
        try {
            if($getOderItem || $getTakeWayOrderItem )
            {
                $message= "This  coupon  (".$prdwisecoupon['promocode'].") is used in another table   so can't delete it!";
            return redirect('/admin/Coupon-List')->with('error_message',$message);
 
            }else{
            $prdwisecoupon->delete();
            $message= "Your Product Wise Coupon is Delete Successfully!";
            return redirect('/admin/Coupon-List')->with('success_message',$message);
            }
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/Coupon-List')->with('error_message',$message);
        }}   
    }

    public function CouponOnpricelist()
    {
        $coupononprice = CouponOnPrice::get();
        return view('admin.coupon.coupon_onprice_list')->with(compact('coupononprice'));
    }
    public function AddCouponOnprice(Request $request, $id = null)
    {

        if ($id == "") {
            $title = "Add";
            $productoffer = new CouponOnPrice;
            $notification = array(
                'message' =>" Coupon Added Successfully!",
                'alert-type' =>'success'
            );
        } else {
            $title = "Edit";
            $productoffer = CouponOnPrice::find($id);
            $notification = array(
                'message' =>" Coupon Has Been Updated Successfully!",
                'alert-type' =>'success'
            );
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validated = $request->validate([

                'promocode' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:product_wise_coupons,promocode,'.$id,
                'remark' => 'required',
                'order_amount' => 'required',
                'offer_per' => 'required',
               
                'start_date' => 'required',
                'expiry_date' => 'required',

            ]);
            $productoffer->order_amount = $data['order_amount'];
            $productoffer->promocode = $data['promocode'];
         
            $productoffer->offer_per = $data['offer_per'];
           
            $productoffer->start_date = $data['start_date'];
            $productoffer->expiry_date = $data['expiry_date'];
            $productoffer->remark = $data['remark'];
            $productoffer->save();
            return redirect('admin/Coupon-On-price')->with($notification);
        }
        
        return view('admin.coupon.add_edit_coupon_on_price', compact('title','productoffer'));
    }
    
    public function DeleteCouponOnprice($id)
    {
        $prdwisecoupon = CouponOnPrice::findOrFail($id);
        try {
            $prdwisecoupon->delete();
            $message= " Coupon is Delete Successfully!";
            return redirect('/admin/Coupon-On-price')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/Coupon-On-price')->with('error_message',$message);
        }}   
    }
    public function TotalLoss()
    {
        $itemfreelist = Orderitem::where('no_qty_buy_to_free','>','0')->get();
       $tableitemfreelose = DB::table('orderitems')->where('no_qty_buy_to_free','>','0')->sum(DB::raw('price * no_qty_buy_to_free'));
       $tableitemSalewithoutfree = DB::table('orderitems')->where('no_qty_buy_to_free','>','0')->sum('amount');
        $tableoverallsale = $tableitemfreelose + $tableitemSalewithoutfree;

        $takeawayoderitemfreelist = TakeWayOrderitem::where('no_qty_buy_to_free','>','0')->get();
        $Takewayitemfreelose = DB::table('take_way_orderitems')->where('no_qty_buy_to_free','>','0')->sum(DB::raw('price * no_qty_buy_to_free'));
        $takewayitemSalewithoutfree = DB::table('take_way_orderitems')->where('no_qty_buy_to_free','>','0')->sum('amount');
         $takewayoverallsale = $Takewayitemfreelose + $takewayitemSalewithoutfree;

         $itemfreelose = $tableitemfreelose + $Takewayitemfreelose;
       $itemSalewithoutfree = $tableitemSalewithoutfree+ $takewayitemSalewithoutfree;
        $overallsale = $tableoverallsale + $takewayoverallsale;


        return view('admin.coupon.total_loss',compact('itemfreelist','itemfreelose','overallsale','itemSalewithoutfree','takeawayoderitemfreelist'));
    }

    public function TotalDisPerCouponLoss()
    {
        $tableOderSale = RestaurantOrder::where('coupon_per','>','0')->get();
        $takeOderSale = TakeWayOrder::where('coupon_per','>','0')->get();

        $tableOderSaledis = DB::table('restaurant_orders')->where('coupon_per','>','0')->sum(DB::raw('sub_total - subtotalwithoffer'));
        $takeOderSaledis = DB::table('take_way_orders')->where('coupon_per','>','0')->sum(DB::raw('sub_total - subtotalwithoffer'));

        $overallsaledis = $tableOderSaledis +$takeOderSaledis;

    
        return view('admin.coupon.total_disper_Couponloss',compact('tableOderSale','takeOderSale','overallsaledis'));
    }

}
