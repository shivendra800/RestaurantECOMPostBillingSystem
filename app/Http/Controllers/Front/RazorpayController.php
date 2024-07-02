<?php

namespace App\Http\Controllers\Front;

use Session;
use Exception;
use App\Models\Order;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class RazorpayController extends Controller
{
    /**
     * Write code on Method
     *
     * 
     */
    public function index()
    {     
        if(Session::has('order_id')){
            $order = Order::FindOrFail(Session()->get('order_id'));
            return view('razorpayView',compact('order'));
        }else{
            return redirect('view-cart');
        }
    }
  
    /**
     * Write code on Method
     *
     * 
     */
    public function store(Request $request)
    {
        $input = $request->all();

    //  return   $request->order_id;
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                $payment = Order::where('id',$request->order_id)->update([
                    'r_payment_id' => $response['id'],
                    'method' => $response['method'],
                    'currency' => $response['currency'],
                     'order_status' =>"New-Order",
                    'json_response' => json_encode((array)$response)
                ]);
  
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
          
        Session::put('success', 'Payment successful');
        return redirect('thanks');
    }
}
