<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use App\Models\Ingredient;
use App\Models\VendorType;
use App\Models\CategoryType;
use App\Models\PruchaseItem;
use Illuminate\Http\Request;
use App\Models\PruchaseBillLog;
use App\Models\VendorReturnItem;
use Illuminate\Support\Facades\DB;
use App\Models\AssignVendorProduct;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class VendorController extends Controller
{
    public function vendortypeIndex()
    {
        $VType= VendorType::get()->toArray();
        return view('admin.vendors.vendor_type_list')->with(compact('VType'));
    }

     public function AddEditVType(Request $request, $id=null)
    {
        if($id == ""){
            $title = "ADD";
            $VType = new VendorType;
            $message = "Vendor Type Add Successfully!";
        }else{
            $title = "Edit";
            $VType =  VendorType::find($id);
            $message = "Vendor Type Updated Successfully!";
        }
          if($request->isMethod('post')){
           
            $data = $request->all();
            $validated = $request->validate([
                'vendor_type' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:vendor_types,vendor_type,'.$id,
                
            ]);
            $VType->vendor_type = $data['vendor_type'];
            $VType->status=1;
            $VType->save();

            return redirect('admin/vendor-type')->with('success_message',$message);
          }
        return view('admin.vendors.add_edit_vendor_type')->with(compact('title','VType'));
    }
    public function vendortypeDelete($id)
    {
        $vType = VendorType::findOrFail($id);
        try {
            $vType->delete();
            $message= "Your Vendor Type (".$vType['vendor_type'].") is Delete Successfully!";
            return redirect('/admin/vendor-type')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/vendor-type')->with('error_message',$message);
        }}   
    }

    public function VTypeStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('vendor_types')
            ->where('id',$status_id)
            ->first();

        DB::table('vendor_types')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/vendor-type')->with('success_message',"Status updated Successfully!");
    }

    public function deleteAllvendortype(Request $request)
    {
        $ids = $request->ids;
        DB::table("vendor_types")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Vendors Type Deleted successfully."]);
    }

 // vendor section start here---------------------------------------------------------------
    public function vendorIndex()
    {
        $vendor= Vendor::with('vendortype')->get()->toArray();
        return view('admin.vendors.vendor_list')->with(compact('vendor'));
    }

    public function PurchaseHistroy($id)
    {
        $purchaseHist= PruchaseBillLog::where('vendor_id',$id)->get()->toArray();
        return view('admin.vendors.vendor_purchase_histroy_list')->with(compact('purchaseHist'));
    }

     public function AddEditVendor(Request $request, $id=null)
      {
        DB::beginTransaction();
        if($id == ""){
            $title = "ADD";
            $vendor = new Vendor;
            $admin  = new Admin;
            $message = "Vendor Add Successfully!";
            if($request->isMethod('post')){
           
                $data = $request->all();
                $validated = $request->validate([
                    'vendor_type'=>'required',
                    'v_firm_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:vendors',
                    'vendor_name'=>'required',
                    'v_email'=>'required|unique:vendors|unique:admins,email',
                    'password'=>'required',
                    'v_address'=>'required',
                   
                    'v_city'=>'required',
                    'v_state'=>'required',
                    'v_pincode'=>'required|digits:6',
                    'v_phone_no'=>'required|digits:10',
                    'bank_name'=>'required',
                    'bank_branch_name'=>'required',
                    'bank_ifse_code'=>'required',                        
                    'bank_account_no'=>'required',
                    'bank_link_upi_id'=>'required',                          
                ]);
                $vendor->vendor_type = $data['vendor_type'];
                $vendor->v_firm_name = $data['v_firm_name'];
                $vendor->vendor_name = $data['vendor_name'];
                $vendor->v_email = $data['v_email'];
                $vendor->v_address = $data['v_address'];
                $vendor->v_city = $data['v_city'];
                $vendor->v_state = $data['v_state'];
                $vendor->v_pincode = $data['v_pincode'];
                $vendor->v_phone_no = $data['v_phone_no'];
                $vendor->v_gstnin_no = $data['v_gstnin_no'];
                $vendor->bank_name = $data['bank_name'];
                $vendor->bank_branch_name = $data['bank_branch_name'];
                $vendor->bank_ifse_code = $data['bank_ifse_code'];
                $vendor->bank_account_no = $data['bank_account_no'];
                $vendor->bank_link_upi_id = $data['bank_link_upi_id'];
                $vendor->status=1;
              
                $vendor->save();

                $lastinster_id = DB::getPdo()->lastInsertId();
                $admin->name = $data['vendor_name'];
                $admin->vendor_id = $lastinster_id;
                $admin->email = $data['v_email'];
                $admin->password = bcrypt($data['password']);
                $admin->mobile = $data['v_phone_no'];
                $admin->type = "Vendor";
                $admin->status= 1;
                $admin->save();
                DB::commit();
                return redirect('admin/vendor')->with('success_message',$message);
              }
        }else{
            $title = "Edit";
            $vendor =  Vendor::find($id);
            $admin = Admin::where('vendor_id',$id)->first();
            $message = "Vendor Updated Successfully!";
            if($request->isMethod('post')){
           
                $data = $request->all();
                $validated = $request->validate([
                    'vendor_type'=>'required',
                    'vendor_name'=>'required',
                 
                    'v_address'=>'required',
                    'v_city'=>'required',
                    'v_state'=>'required',
                    'v_pincode'=>'required|digits:6',
                    'v_phone_no'=>'required|digits:10',  
                    'bank_name'=>'required',
                    'bank_branch_name'=>'required',
                    'bank_ifse_code'=>'required',                        
                    'bank_account_no'=>'required',
                  
                ]);
                $vendor->vendor_type = $data['vendor_type'];
                $vendor->vendor_name = $data['vendor_name'];
               
                $vendor->v_address = $data['v_address'];
                $vendor->v_city = $data['v_city'];
                $vendor->v_state = $data['v_state'];
                $vendor->v_pincode = $data['v_pincode'];
                $vendor->v_phone_no = $data['v_phone_no'];
                $vendor->v_gstnin_no = $data['v_gstnin_no'];

                $vendor->bank_name = $data['bank_name'];
                $vendor->bank_branch_name = $data['bank_branch_name'];
                $vendor->bank_ifse_code = $data['bank_ifse_code'];
                $vendor->bank_account_no = $data['bank_account_no'];
                $vendor->bank_link_upi_id = $data['bank_link_upi_id'];
               

                $vendor->status=1;
              
                $vendor->save();

                    $admin->name = $data['vendor_name'];
                   
                    $admin->mobile = $data['v_phone_no'];
                    $admin->save();
                    DB::commit();
                return redirect('admin/vendor')->with('success_message',$message);
              }
        }
         
          $VType= VendorType::where('status',1)->get()->toArray();
        return view('admin.vendors.add_edit_vendor')->with(compact('title','vendor','VType'));
    }
    public function vendorDelete($id)
    {
        $vendor = Vendor::findOrFail($id);
        try {
            $vendor->delete();
            $message= "Your Vendor  (".$vendor['vendor_name'].") is Delete Successfully!";
            return redirect('/admin/vendor')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/vendor')->with('error_message',$message);
        }}   
    }

    public function VendorStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('vendors')
            ->where('id',$status_id)
            ->first();

        DB::table('vendors')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/vendor')->with('success_message',"Status updated Successfully!");
    }

    public function deleteAllvendor(Request $request)
    {
        $ids = $request->ids;
        DB::table("vendors")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Vendor Deleted successfully."]);
    }

    public function UpdateVendorPayment(Request $request,$id)
    {
        $purchase_history= Vendor::find($id);
       
        if($request->isMethod('post')) 
        {
            $request->validate([
             
                'paid_amount' => 'required|numeric|gt:0',          
                
            ]);
            $getvendor = Vendor::where('id',$id)->first();
            if($getvendor['v_wallet'] >= $request->input('paid_amount') )
            {
                $Vendorupdate = DB::table('vendors')->where('id',$id)
                ->update(array(
                    'v_wallet'=>$request->get('remaining_amount')
                ));
                // insert new records in purchase bill log
                $rand_no = rand('00000',99999);
                $invoice_id = "PID_".$rand_no;
                $bill_log_insert_data = new PruchaseBillLog();
                $bill_log_insert_data->invoice_id = $invoice_id;
                $bill_log_insert_data->vendor_id = $id;
                $bill_log_insert_data->total_billing = 0;
                $bill_log_insert_data->grand_total = 0;
                $bill_log_insert_data->previous_balance = $request->input('v_wallet');
                $bill_log_insert_data->paid_amount = $request->input('paid_amount');
                $bill_log_insert_data->remaining_amount = $request->input('remaining_amount');
                $bill_log_insert_data->save();
    
                return redirect('admin/vendor')->with('success_message',"Vendor Payment Has  Update Successfully!");

            }else{
                return redirect()->back()->with('error_message',"Enter Amount is Not Valid!");

            }
           
         
        }

         
       
        return view ('admin.vendors.update_vendor_payment')->with(compact('purchase_history'));
    }

   public function AssignVendorBuyProduct(Request $request,$id)
     {

        $getvendor = Vendor::findOrFail($id);
           $getindirt = Ingredient::where('id',$request->product_id)->first();
       
        if($request->isMethod('post')){

            $request->validate([
             
                'product_type_id' => 'required|',    
                'product_id' => 'required|',          
                
            ]);

            foreach ($request['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                          $assignproduct = new AssignVendorProduct();
                          $assignproduct->product_type_id = $request->product_type_id;
                          $assignproduct->vendor_type_id = $getvendor['vendor_type'];
                          $assignproduct->vendor_id = $id;
                          $assignproduct->unit_id = $getindirt['unit_id'];
                          $assignproduct->product_id = $request['product_id'][$key];
                          $assignproduct->save();
                    }
                }
    
            $notification = array(
                'message' =>" Product Has Been  Assign To Vendor  Successfully!",
                'alert-type' =>'success'
            );
    
            return redirect()->back()->with($notification);

        }
        $getprodt = Ingredient::get()->toArray();
        $prodType = CategoryType::get()->toArray();
         $getassignlist = AssignVendorProduct::with('getproduct','getunit')->where('vendor_id',$id)->get()->toArray();
        return view('admin.vendors.assign_vend_product',compact('getvendor','getprodt','getassignlist','prodType'));
     }


     public function DeleteAssignProduct($id)
     {
         $vendor = AssignVendorProduct::findOrFail($id);
         try {
             $vendor->delete();
             $notification = array(
                'message' =>" Your Assign Vendor Product  is Delete Successfully!",
                'alert-type' =>'success'
            );
    
            return redirect()->back()->with($notification);
        } catch (QueryException $e){
         if($e->getCode() == "23000"){
             $message= "data cant be deleted";
             $notification = array(
                'message' =>"data cant be deleted",
                'alert-type' =>'success'
            );
    
            return redirect()->back()->with($notification);
         }}   
     }

        public function ExChangePurchaseProductList(Request $request,$id)
     {
        // DB::beginTransaction();
        if ($request->isMethod('post')) {

            $request->validate([

                'return_product_id' => 'required|',
                'return_price' => 'required|numeric|gt:0',
                'return_qty' => 'required|numeric|min:1',
                'return_weight' => 'required|numeric',
                'return_total_weight' => 'required|numeric',
                'return_total_amt' => 'required|numeric|gt:0',
              

            ]);
            $getIngredients = Ingredient::where('id', $request->input('return_product_id'))->first();
            $getIngredients->purchase_stock = $getIngredients->purchase_stock - $request->input('return_qty');
            $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock - $request->input('return_total_weight');
            $getIngredients->update();
         
            $retunItem = new VendorReturnItem;
            $retunItem->vendor_id = $id;
             $retunItem->return_product_id = $request->input('return_product_id');
             $retunItem->return_price = $request->input('return_price');
             $retunItem->return_qty = $request->input('return_qty');
             $retunItem->return_weight = $request->input('return_weight');
             $retunItem->return_total_weight = $request->input('return_total_weight');
             $retunItem->return_total_amt = $request->input('return_total_amt');
             $retunItem->save();

             $getvendor = Vendor::where('id',$id)->first();
             $getupdat = $getvendor['v_wallet']-$request->input('return_total_amt');

             $Vendorupdate = DB::table('vendors')->where('id',$id)
             ->update(array(
                 'v_wallet'=>$getupdat
             ));
             $rand_no = rand('00000',99999);
             $invoice_id = "ReturnTransID_".$rand_no;
             $bill_log_insert_data = new PruchaseBillLog();
             $bill_log_insert_data->invoice_id = $invoice_id;
             $bill_log_insert_data->vendor_id = $id;
             $bill_log_insert_data->total_billing = 0;
             $bill_log_insert_data->grand_total = 0;
             $bill_log_insert_data->previous_balance = $request->input('v_wallet')-$request->input('return_total_amt');
             $bill_log_insert_data->paid_amount = $request->input('return_total_amt');
             $bill_log_insert_data->remaining_amount = $getupdat;
             $bill_log_insert_data->save();

             return redirect()->back()->with('success_message',"Return Has Been Complete Successfully!");
        }
        // DB::commit();
        $getassignlist = Ingredient::get()->toArray();
          $getvendor = Vendor::findOrFail($id);
         $getreturnItemList = VendorReturnItem::with('getproduct')->where('vendor_id',$id)->get()->toArray();
     return view('admin.vendors.exchange_purchase_product_list',compact('getassignlist','getvendor','getreturnItemList'));
     }

}
