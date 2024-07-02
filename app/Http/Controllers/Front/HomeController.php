<?php

namespace App\Http\Controllers\Front;

use App\Models\Slide;
use App\Models\Staff;
use App\Models\Slider;
use App\Models\SiteSetting;
use App\Models\TableBooking;
use Illuminate\Http\Request;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Http\Controllers\Controller;
use App\Models\MenuItemMultiImg;

class HomeController extends Controller
{
    
     public function MenuList()
    {

        return view('frontend.one_page_menu.index');
    }
    public function restype()
    {
        $getmenu =MenuSubCategory::where('status','1')->where('rest_type','restaurant-menu')->get();

        return view('frontend.one_page_menu.restype',compact('getmenu'));
    }
    public function bartype()
    {
        $getmenu =MenuSubCategory::where('status','1')->where('rest_type','!=','restaurant-menu')->get();
     
        return view('frontend.one_page_menu.bartype',compact('getmenu'));
    }
    public function index()
    {
        
        $menu = MenuSubCategory::where('status','1')->get();
        $sitesetting = SiteSetting::first();
        $getstaff = Staff::get();
        $slider = Slider::all();
        $menuitem = MenuItemPrice::with('menusubCategory')->where('status','1')->get();
        return view('frontend.index')->with(compact('menu','sitesetting','getstaff','slider','menuitem'));
    }

    public function About()
    {
        $sitesetting = SiteSetting::first();
        return view('frontend.pages.about',compact('sitesetting'));
    }
    public function PrivacyPolicy()
    {
        $sitesetting = SiteSetting::first();
        return view('frontend.pages.PrivacyPolicy',compact('sitesetting'));
    }
    public function Termcondition()
    {
        $sitesetting = SiteSetting::first();
        return view('frontend.pages.term_condition',compact('sitesetting'));
    }
    public function Service()
    {
        return view('frontend.pages.service');
    }
    public function Menu()
    {
        $getmenu = MenuSubCategory::where('status','1')->get();
        return view('frontend.pages.menu',compact('getmenu'));
    }
    public function Contact()
    {
        $sitesetting = SiteSetting::first();
        return view('frontend.pages.contact',compact('sitesetting'));
    }
    public function menuitem($id)
    {

         $menuitem = MenuItemPrice::with('menusubCategory')->where('id',$id)->where('status','1')->first();
         $getmutiimgitem = MenuItemMultiImg::where('menu_item_id',$id)->get();
         $getall = MenuItemPrice::with('menusubCategory')->where('status','1')->get();
         
        return view('frontend.pages.menu_item')->with(compact('menuitem','getmutiimgitem','getall'));
    }

    public function TableBooking()
    {
        $getmenu = MenuSubCategory::where('status','1')->get();
        return view('frontend.pages.table_booking',compact('getmenu'));
    }

    public function TableBookingPay(Request $request)
    {

        $currentDateTime = $request->input('table_booking_time');
        $outitme = $request->input('table_booking_timeout');

        $cust_name = $request->input('cust_name');
        $cust_email = $request->input('cust_email');
        $cust_phone = $request->input('cust_phone');

        $table_booking_date = $request->input('table_booking_date');
        $table_booking_time = date('h:i A', strtotime($currentDateTime));
        $table_booking_timeout = date('h:i A', strtotime($outitme));
        $table_type = $request->input('table_type');
        $payment_amount = $request->input('payment_amount');
        $no_person = $request->input('no_person');
        $message = $request->input('message');

      
         
        return response()->json([
            'cust_name' =>  $cust_name,
            'cust_email' =>  $cust_email,
            'cust_phone' =>  $cust_phone,
            'table_booking_date' =>  $table_booking_date,
            'table_booking_time' =>  $table_booking_time,
            'table_booking_timeout' =>  $table_booking_timeout,
            'table_type' =>  $table_type,
            'payment_amount' =>  $payment_amount,
            'no_person' =>  $no_person,
            'message' =>  $message,
     


            
        ]);
    }

    public function StoreTableBooking(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           
            // $validated = $request->validate([

            //     'unit_name' => 'required|unique:units|regex:/[a-zA-Z\s]+/|max:255'

            // ]);
            $booktable = new TableBooking;
             $currentDateTime = $data['table_booking_time'];
             $outitme = $data['table_booking_timeout'];
            $booktable->cust_name = $data['cust_name'];
            $booktable->cust_email = $data['cust_email'];
            $booktable->cust_phone = $data['cust_phone'];
            $booktable->table_booking_date = $data['table_booking_date'];
            $booktable->table_booking_time = date('h:i A', strtotime($currentDateTime));
            $booktable->table_booking_timeout = date('h:i A', strtotime($outitme));
            $booktable->no_person = $data['no_person'];
            $booktable->table_type = $data['table_type'];
            $booktable->payment_amount = $data['payment_amount'];
            $booktable->payment_mode = $data['payment_mode'];
            $booktable->payment_id = $data['payment_id'];
            $booktable->message = $data['message'];
            $booktable->table_booking_status = "Request For Table Booking";

            $booktable->save();

            // $email = $booktable['email'];
            // $name= $booktable['name'];
            // $table_booking_status = $data['table_booking_status'];
            
            // $table_type =  $data['table_type'];
            // $table_booking_date = $booktable['table_booking_date'];
            // $table_booking_time = $booktable['table_booking_time'];
            // $table_booking_timeout = $booktable['table_booking_timeout'];
            
            // $subject = "Table Booking Status";
                
            //     $from = "info@albfoodproducts.in";
                
            //     $message = "
                   
            //             <tr><td>&nbsp;</td></tr><br></br>
            //             <tr><td>&nbsp;</td></tr>
            //             <tr><td>Hello $name</td></tr>
            //             <tr><td>&nbsp;</td></tr>
            //             <tr><td>Your Table Booking  # $table_booking_status   status Has Been Updated  Successfully</td></tr>
            //             <tr><td>&nbsp;</td></tr>
                        
            //             <td>Table Booking Date : $table_booking_date </td>   
            //             <td>Table Type : $table_type </td> 
            //             <td>Table Booking In Time : $table_booking_time </td>            
            //             <td>Table Booking Out Time : $table_booking_timeout </td> 
                               
                             
            //     ";
    
    
            
                
            //     $headers = "From: $from \r\n";
                
            //     $headers .= "Content-type: text/html\r\n";
                
                
            //     mail($email,$subject,$message,$headers);

           

            return response()->json(['status'=>"Table Booking Request Has Sent Successfully!"]);

        }
    }
    
   


}
