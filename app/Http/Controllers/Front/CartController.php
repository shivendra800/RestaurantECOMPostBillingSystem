<?php

namespace App\Http\Controllers\Front;

use App\Models\Tax;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderWiseTax;
use Illuminate\Http\Request;
use App\Models\CouponOnPrice;
use App\Models\MenuItemPrice;
use App\Models\OrdersProduct;
use App\Models\DeliveryAddres;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function AddToCart(Request $request)
    {
        if (Auth::check()) {


            $MenuItemCart = Cart::where('user_id', Auth::user()->id)->where(['menu_item_id' => $request->menu_item_id])->count();
            if ($MenuItemCart > 0) {
                $notification = array(
                    'error' => "This Item is already exists in cart!",
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }


            $MenuItemCart = new Cart;
            $MenuItemCart->user_id = Auth::user()->id;
            $MenuItemCart->menu_item_id = $request->menu_item_id;
            $MenuItemCart->menu_item_price = $request->menu_item_price;
            $MenuItemCart->menu_item_qty = $request->menu_item_qty;
            $MenuItemCart->save();

            $notification = array(
                'message' => "Menu Item Is Added to Cart Successfully!",
                'alert-type' => 'success'
            );

            return redirect('view-cart')->with($notification);
        } else {
            $notification = array(
                'error' => "You Are Not Login!.Plz Login First!",
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function AddToCartWithId(Request $request,$id)
    {
        if (Auth::check()) {


            $MenuItemCart = Cart::where('user_id', Auth::user()->id)->where(['menu_item_id' => $id])->count();
            if ($MenuItemCart > 0) {
                $notification = array(
                    'error' => "This Item is already exists in cart!",
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }


            $MenuItemCart = new Cart;
            $MenuItemCart->user_id = Auth::user()->id;
            $MenuItemCart->menu_item_id = $id;
            $MenuItemCart->menu_item_price = $request->menu_item_price;
            $MenuItemCart->menu_item_qty = $request->menu_item_qty;
            $MenuItemCart->save();

            $notification = array(
                'message' => "Menu Item Is Added to Cart Successfully!",
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'error' => "You Are Not Login!.Plz Login First!",
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function ViewCart()
    {
        $MenuItemCart = Cart::with('Usermenuitem')->where('user_id', Auth::user()->id)->get();
        $gettaxList = Tax::where('status', 1)->get();
        return  view('frontend.pages.view_cart', compact('MenuItemCart', 'gettaxList'));
    }


    public function cartUpdate(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>",print_r($data); die;

            // Get Cart Details
            $cartDetails = Cart::find($data['cartid']);
            //Update the Qty
            Cart::where('id', $data['cartid'])->update(['menu_item_qty' => $data['qty']]);

            return response()->json(['status' => "Quantity Updated"]);
        }
    }

    public function deleteUpdate(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //  echo "<pre>",print_r($data); die;
            Cart::where('id', $data['cartid'])->delete();

            return response()->json(['status' => "Menu Item Delete From Your Cart Updated"]);
        }
    }

    public function Checkout(Request $request)
    {
        $deliveryAddresses = DeliveryAddres::deliveryAddresses();
        $MenuItemCart = Cart::with('Usermenuitem')->where('user_id', Auth::user()->id)->get();
        $gettaxList = Tax::where('status', 1)->get();
        $getCartItems=Cart::getCartItems();
        //   dd($getCartItems);
        if(count($getCartItems)==0){
        //   $message= "Shopping Cart Is Empty! Please Add Products For Shopping";
          $notification = array(
            'error' => "Shopping Cart Is Empty! Please Add Menu Item For Shopping",
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Delivery addresss Validation
            if (empty($data['address_id'])) {
                $message = "Please Select Delivery Address!";
                return redirect()->back()->with('error_message', $message);
            }
            if (empty($data['payment_gateway'])) {
                $message = "Please Select Any Payment Method!";
                return redirect()->back()->with('error_message', $message);
            }
            if (empty($data['accept'])) {
                $message = "Please Accept T&C!";
                return redirect()->back()->with('error_message', $message);
            }

            // Get Delivery Address from address_id
            $deliveryAddresses = DeliveryAddres::where('id', $data['address_id'])->first()->toArray();
            //dd($deliveryAddresses);

            // set Payment Method as COD if COD is selected from user otherwise set as Prepaid
            if ($data['payment_gateway'] == "COD") {
                $payment_method = "COD";
                $order_status = "New-Order";
            } else {
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }
            DB::beginTransaction();
            // Featch Order Total price
            $total_price = 0;
            foreach ($MenuItemCart as $item) {

                $total_price = $total_price + ($item['menu_item_price'] * $item['menu_item_qty']);
  
                   
            }
            // Tax
            $tax_price = 0;
            foreach ($gettaxList as $tax) {
                $tax_price = $tax_price + ($total_price * $tax['tax_percentage'] / 100);
            }
            // calculate Shipping Charges
            $shipping_charges = 0;
            // Calaculate Grand Total
            // $grand_total = $total_price + $tax_price + $shipping_charges;
            //Insert Grand Total  in Session Varaible
            Session::put('grand_total', $data['grand_total']);
            // Insert Order Details
              #Store Unique Order/Product Number
              $unique_no = Order::orderBy('id', 'DESC')->pluck('id')->first();
              if($unique_no == null or $unique_no == ""){
              #If Table is Empty
              $unique_no = 1;
              }
              else{
              #If Table has Already some Data
              $unique_no = $unique_no + 1;
             }
            $order = new Order();
            $order->order_no ='WPROD'.$unique_no;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddresses['name'];
            $order->address = $deliveryAddresses['address'];
            $order->city = $deliveryAddresses['city'];
            $order->area = $deliveryAddresses['area'];
            $order->state = $deliveryAddresses['state'];
            $order->pincode = $deliveryAddresses['pincode'];
            $order->mobile = $deliveryAddresses['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->subtotal = $data['subtotal'];
            $order->coupon_per = $data['coupon_per'];
            $order->coupon_avail_amount = $data['coupon_avail_amount'];
            $order->coupon_code = $data['coupon_code'];
            $order->subtotalwithoffer = $data['subtotalwithoffer'];
            $order->total_tax = $data['total_tax'];
            $order->grand_total = $data['grand_total'];
            $order->save();
            $order_id = DB::getPdo()->lastInsertId();
            foreach ($data['tax_name'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $ordertax = new OrderWiseTax();
                    $ordertax->order_no ='WPROD'.$unique_no;
                    $ordertax->tax_name = $data['tax_name'][$key];
                    $ordertax->tax_percentage = $data['tax_percentage'][$key];
                    $ordertax->tax_amount = $data['tax_amount'][$key];            
                    $ordertax->save();
                }
            }
            foreach ($MenuItemCart as $key =>  $item) {
                $cartItem = new OrdersProduct();
                $cartItem->order_id ='WPROD'.$unique_no;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = MenuItemPrice::select('menu_item_code', 'menu_item_name', 'id')->where('id', $item['menu_item_id'])->first()->toArray();
                // dd(  $getProductDetails);
                $cartItem->product_id = $item['menu_item_id'];
                $cartItem->product_code = $getProductDetails['menu_item_code'];
                $cartItem->product_name = $getProductDetails['menu_item_name'];
                $cartItem->product_price = $item['menu_item_price'];
                $cartItem->product_price = $item['menu_item_price'];
                $cartItem->product_qty = $item['menu_item_qty'];
                $cartItem->no_of_qty_buy = $data['no_of_qty_buy'][$key];
                $cartItem->no_qty_buy_to_free = $data['no_qty_buy_to_free'][$key];
                $cartItem->save();
               
            }
             //Insert Order Id in Session varabile
             Session::put('order_id', $order_id);
             DB::commit();
            $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
            if($data['payment_gateway']=="COD"){
               // Send Order Email
            //    $email = Auth::user()->email;
            //    $messageData =[
            //        'email' =>$email,
            //        'name' =>Auth::user()->name,
            //        'order_id' => $order_id,
            //        'orderDetails' => $orderDetails
            //    ];
            //    Mail::send('emails.order',$messageData,function($message)use($email){
            //        $message->to($email)->subject('Order Place Successfully!- Shivendra Developers.com');
            //    });
               
            }else if($data['payment_gateway']=="Razorpay"){
                 // Razorpay - Redirect User TO Razorpay page after saving Order
                    return redirect('razorpay');
             }else{
               echo "Other Prepaid payment method is coming soon";
            }
            return redirect('thanks');
        }
        return  view('frontend.pages.checkout', compact('deliveryAddresses', 'MenuItemCart', 'gettaxList'));
    }

    public function thanks()
    {
        if (Session::has('order_id')) {
            //Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('frontend.pages.thanks');
        } else {
            return redirect('view-cart');
        }
    }

    public function getDeliveryAddress(Request $request)
    {
        if ($request->ajax()) {
               $data = $request->all();
            $deliveryAddress = DeliveryAddres::where('id', $data['addressid'])->first()->toArray();
            return response()->json(['address' => $deliveryAddress]);
        }
        return view('frontend.pages.delivery_address');
    }

    public function SaveDeliveryAddress(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'delivery_name' => 'required|string|max:100',
                'delivery_address' => 'required',
                'delivery_city' => 'required|string|max:100',
                'delivery_state' => 'required|string|max:100',
                'delivery_area' => 'required|string|max:100',
                'delivery_pincode' => 'required|numeric|digits:6',
                'delivery_mobile' => 'required|numeric|digits:10',
                'delivery_email' => 'required|string|max:150',

            ]);
            if ($validator->passes()) {
                $data = $request->all();

                $address = array();
                $address['user_id'] = Auth::user()->id;
                $address['name'] = $data['delivery_name'];
                $address['address'] = $data['delivery_address'];
                $address['area'] = $data['delivery_area'];
                $address['state'] = $data['delivery_state'];
                $address['city'] = $data['delivery_city'];
                $address['email'] = $data['delivery_email'];
                $address['pincode'] = $data['delivery_pincode'];
                $address['mobile'] = $data['delivery_mobile'];

                if (!empty($data['delivery_id'])) {
                    //Edit Delivery Address
                    DeliveryAddres::where('id', $data['delivery_id'])->update($address);
                } else {
                    //Add Delivery Address
                    // $address['status']==1;
                
                          DeliveryAddres::create($address);
                }
                $deliveryAddresses = DeliveryAddres::deliveryAddresses();
                //    echo"<pre>"; print_r($deliveryAddresses); die;

                return response()->json([
                    'status' => "Delivery Address Has Been Add Successfully!", 'view' => (string)View::make('frontend.pages.delivery_address')->with(compact('deliveryAddresses'))
                ]);
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        }
    }

    public function removeDeliveryAddress(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            DeliveryAddres::where('id', $data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddres::deliveryAddresses();
            return response()->json([
                'status' => "Delivery Address Has Been Remove Successfully!", 'view' => (string)View::make('frontend.pages.delivery_address')->with(compact('deliveryAddresses'))
            ]);
        }
    }

    public function MyOrderList()
    {
        $myorders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.pages.my_order',compact('myorders'));
    }

    public function MyOrderDetails($order_no)
    {
             $order = Order::with('orders_products')->where('user_id',Auth::user()->id)->where('order_no',$order_no)->first();
        if($order)
        {
            return view('frontend.pages.my_order_details',compact('order'));
        }
        else
        {
            return redirect()->back()->with('message',' NO Order Found');
        }

    }
    public function CancleMyOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->order_status = "Cancelled";
        $order->canceled_date = DB::raw('CURRENT_DATE');
        $order->save();
        return redirect()->back()->with('message','Order has Been Cancled');
    }

}
