<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\TableBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableBookingController extends Controller
{

    public function tablerequest()
    {
  
        $tablerequest = TableBooking::where('table_booking_status','Request For Table Booking')->latest()->get();
        return view('admin.table_request.index',compact('tablerequest'));
    }

    public function AddEditTableBooking(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $tablebook = new TableBooking;
           
            $notification = array(
                'message' =>" Table Booking Successfully!",
                'alert-type' =>'success'
            );
            if($request->isMethod('post')){
                $data = $request->all();
                $validated = $request->validate([
    
                    'cust_name' => 'required|regex:/[a-zA-Z\s]+/|max:255',
                    'cust_email' => 'required',
                    'cust_phone' => 'required',
                    'table_booking_date' => 'required',
                    'no_person' => 'required',
                    'table_booking_status' => 'required',
    
                ]);
                $currentDateTime = $data['table_booking_time'];
                $tablebook->cust_name = $data['cust_name'];
                $tablebook->cust_email = $data['cust_email'];
                $tablebook->cust_phone = $data['cust_phone'];
                $tablebook->table_booking_date = $data['table_booking_date'];
                $tablebook->table_booking_time = date('h:i A', strtotime($currentDateTime));
                $tablebook->no_person = $data['no_person'];
                $tablebook->message = $data['message'];
                $tablebook->table_type = $data['table_type'];
                $tablebook->table_booking_status = $data['table_booking_status'];
                $tablebook->save();
                return redirect('admin/table-booking-request')->with($notification);
            }
        }
        else{
            $title= "Edit";
            $tablebook = TableBooking::find($id);
           
            $notification = array(
                'message' =>" Table Booking Request Has Updated Successfully!",
                'alert-type' =>'success'
            );
            if($request->isMethod('post')){
                 $data = $request->all();
                    $tablebook->table_type = $data['table_type'];
                $tablebook->table_booking_status = $data['table_booking_status'];
                $tablebook->save();

                    //php mailer core on spam        
                $email = $tablebook['email'];
        $name= $tablebook['name'];
        $table_booking_status = $data['table_booking_status'];
        
        $table_type =  $data['table_type'];
        $table_booking_date = $tablebook['table_booking_date'];
        $table_booking_time = $tablebook['table_booking_time'];
        $table_booking_timeout = $tablebook['table_booking_timeout'];
        
        $subject = "Table Booking Status";
        	
            $from = "infodunkel@dunkelbeverage.com";
            
            $message = "
               
                    <tr><td>&nbsp;</td></tr><br></br>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>Hello $name</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>Your Table Booking  # $table_booking_status   status Has Been Updated  Successfully</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    
                    <td>Table Booking Date : $table_booking_date </td>   
                    <td>Table Type : $table_type </td> 
                    <td>Table Booking In Time : $table_booking_time </td>            
                    <td>Table Booking Out Time : $table_booking_timeout </td> 
                           
                         
            ";


        
            
            $headers = "From: $from \r\n";
            
            $headers .= "Content-type: text/html\r\n";
            
            
            mail($email,$subject,$message,$headers);
           
                return redirect('admin/table-booking-request')->with($notification);
            }
        }
      
        return view('admin.table_request.add_edit_tablebooking',compact('tablebook','title'));

    }

    public function TableBooked()
    {
  
        $tablerequest = TableBooking::where('table_booking_status','Table Booking Confirm')->latest()->get();
        return view('admin.table_request.conifrm_booking',compact('tablerequest'));
    }

    
}
