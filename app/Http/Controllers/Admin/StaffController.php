<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use App\Models\TakeWayOrder;
use App\Models\RestaurantOrder;

class StaffController extends Controller
{
    public function StaffsIndex()
    {
        $staffList = Staff::get()->toArray();
        return view('admin.staffs.staff_list',compact('staffList'));
    }

    public function AddEditstaffs(Request $request,$id=null)
    {
        DB::beginTransaction();
       if($id== "")
       {
        $title = "Add";
        $staffList = new Staff;
        $admin  = new Admin;
        $message = "Staff is added Successfully! ";
        if($request->isMethod('post'))
        {
         $data = $request->all();
        
         $validated = $request->validate([
             'name' =>'required|regex:/[a-zA-Z\s]+/|max:255',
             'email'=>'required|unique:staff||unique:admins',
             'mobile'=>'required|unique:staff||unique:admins|digits:10',
             'address'=>'required',
             'aadhar'=>'required',
             'type'=>'required',
         ]);

         if ($files = $request->file('aadhar')) {
            $destinationPath = 'admin_assets/uploads/aadhar/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $post['aadhar'] = "$profileImage";
            $staffList->aadhar = $profileImage;
        }
 
         $staffList->name = $data['name'];
         $staffList->email = $data['email'];
         $staffList->mobile = $data['mobile'];
         $staffList->address = $data['address'];
         $staffList->type = $data['type'];
         $staffList->save();
          $lastinster_id = DB::getPdo()->lastInsertId();
         $admin->name = $data['name'];
         $admin->staff_id = $lastinster_id;
         $admin->email = $data['email'];
         $admin->password = bcrypt($data['password']);
         $admin->mobile = $data['mobile'];
         $admin->type = $data['type'];
         $admin->status= 1;
         $admin->save();
         DB::commit();

         //Send Conifirmation Email
         $email= $data['email'];
         $messageData=[
             'email' =>$data['email'],
             'password' =>$data['password'],
             'name' =>$data['name'],
             'mobile' =>$data['mobile'],
         ];
         Mail::send('emails.account_opening',$messageData,function($message)use($email){
             $message->to($email)->subject('Account Created Mail Of Dunkel Beverage ');
         });
        
         return redirect('admin/staffs')->with('success_message',$message);
        

 
        }
        
       }else{
        $title = "Edit";
        $staffList= Staff::find($id);
        $admin = Admin::where('staff_id',$id)->first();
        $message = "Staff is updated successfully!";
        if($request->isMethod('post'))
        {
         $data = $request->all();
        
         $validated = $request->validate([
             'name' =>'required|regex:/[a-zA-Z\s]+/|max:255',
             'mobile'=>'required|unique:staff,mobile,'.$id,
             'address'=>'required',
             'type'=>'required',
         ]);
 
         $staffList->name = $data['name'];
         $staffList->mobile = $data['mobile'];
         $staffList->address = $data['address'];
         $staffList->type = $data['type'];
         $staffList->save();
 
         $admin->name = $data['name'];
         $admin->mobile = $data['mobile'];
         $admin->type = $data['type'];
         $admin->save();
         DB::commit();
        
         return redirect('admin/staffs')->with('success_message',$message);
 
        }

       }
       return view('admin.staffs.add_edit_staff',compact('title','staffList'));
    }

    public function staffsDelete($id)
    {
        $vType = Staff::findOrFail($id);
        $admin = Admin::where('staff_id',$id)->exists();
        $getOderItem = RestaurantOrder::where('staff_id',$id)->exists();
        $getTakeWayOrderItem = TakeWayOrder::where('staff_id',$id)->exists();
        try {
            if($getOderItem || $getTakeWayOrderItem ||$admin)
            {
                $message= "This  staff  (".$vType['name'].") is used in another table   so can't delete it!";
            return redirect('/admin/staffs')->with('error_message',$message);
 
            }else{
                $vType->delete();
               
                $message= "Your Staff (".$vType['name'].") is Delete Successfully!";
                return redirect('/admin/staffs')->with('success_message',$message);
            }

            
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/staffs')->with('error_message',$message);
        }}   
    }
    public function StaffStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('staff')
            ->where('id',$status_id)
            ->first();

        DB::table('staff')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/staffs')->with('success_message',"Status updated Successfully!");
    }

    public function staffsdeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("staff")->whereIn('id',explode(",",$ids))->delete();
        DB::table("admins")->whereIn('staff_id',explode(",",$ids))->delete();
        return response()->json(['success'=>"staffs  Deleted successfully."]);
    }
      public function UpdateStaffWisePassword(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $request->validate([
                'password'         =>'required|',
                'confirm_pasword' =>'required|same:password'
            ]);
                //Check if New Password is matching with conifrm Password
                if ($data['confirm_pasword'] == $data['password']) {
                    
                    $admin = Admin::where('staff_id',$id)->first();
                    $admin->password = bcrypt($data['password']);
                    $admin->save();
                    return redirect()->back()->with('success_message', 'Your  Password Is Updated Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Your New Password is Not Match With Confirm Password');
                }
           
        }
        $adminDetails = Admin::where('staff_id', $id)->first()->toArray();
        return view('admin.update_staff_wise_password',compact('adminDetails'));
    }
}
