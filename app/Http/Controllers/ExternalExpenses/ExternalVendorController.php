<?php

namespace App\Http\Controllers\ExternalExpenses;

use Exception;
use Illuminate\Http\Request;
use App\Models\ExternalVendor;
use App\Models\ExternalProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AssignExtVendorProduct;
use Illuminate\Database\QueryException;
use App\Models\ExternalVendorReturnItem;
use App\Models\ExternalCapitalPurchasePaymentLog;

class ExternalVendorController extends Controller
{

    public function ExternalVendor()
    {
        $getextVendor = ExternalVendor::latest()->get()->toArray();
        return view('admin.expense.ext_vendor_list',compact('getextVendor'));
    }

    public function AddEditExternalVendor(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $AddeditExtVend = new ExternalVendor;
            $message = "External Vendor Added Successfully!";
        }
        else{
            $title= "Edit";
            $AddeditExtVend = ExternalVendor::find($id);
            $message = "External Vendor Updated Successfully!";
        }


       
       
        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([

                'v_firm_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:external_vendors,v_firm_name,'.$id,
                'vendor_type' => 'required|regex:/[a-zA-Z\s]+/|max:255',
                'vendor_name' => 'required|regex:/[a-zA-Z\s]+/|max:255',
                'v_email' => 'required',
                'v_address' => 'required',
                'v_city' => 'required',
                'v_state' => 'required',
                'v_pincode' => 'required|digits:6',
                'v_phone_no' => 'required|numeric|digits:10',
                'bank_name' => 'required',
                'bank_branch_name' => 'required',
                'bank_ifse_code' => 'required',
                'bank_account_no' => 'required',
                'bank_link_upi_id' => 'required',
            

              

            ]);
            $AddeditExtVend->v_firm_name = $data['v_firm_name'];
            $AddeditExtVend->vendor_type = $data['vendor_type'];
            $AddeditExtVend->vendor_name = $data['vendor_name'];
            $AddeditExtVend->v_email = $data['v_email'];
            $AddeditExtVend->v_address = $data['v_address'];
            $AddeditExtVend->v_city = $data['v_city'];
            $AddeditExtVend->v_state = $data['v_state'];
            $AddeditExtVend->v_pincode = $data['v_pincode'];
            $AddeditExtVend->v_phone_no = $data['v_phone_no'];
            $AddeditExtVend->v_gstnin_no = $data['v_gstnin_no'];
            $AddeditExtVend->bank_name = $data['bank_name'];
            $AddeditExtVend->bank_branch_name = $data['bank_branch_name'];
            $AddeditExtVend->bank_ifse_code = $data['bank_ifse_code'];
            $AddeditExtVend->bank_account_no = $data['bank_account_no'];
            $AddeditExtVend->save();
            return redirect()->back()->with('success_message',$message);
        }
        return view('admin.expense.add_edit_ExternalVendor',compact('AddeditExtVend','title'));

    }

    public function ExternalVendorDelete($id)
    {
        $AddeditExtVend = ExternalVendor::findOrFail($id);
        try {
            $AddeditExtVend->delete();
            $message= "Your External Vendor  (".$AddeditExtVend['v_firm_name'].") is Delete Successfully!";
            return redirect('/admin/expense-vendor')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/expense-vendor')->with('error_message',$message);
        }}   
    }

    public function ExternalVendorStatusChange(Request $request)
    {
        $status_id=$request->get('status_id');

        $statuschange=DB::table('external_vendors')
            ->where('id',$status_id)
            ->first();

        DB::table('external_vendors')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/expense-vendor')->with('success_message',"Status updated Successfully!");
    }

    public function AssignExternalVendorExtBuyProduct(Request $request,$id)
     {

         $getEXtrvendor = ExternalVendor::findOrFail($id);

     
        if($request->isMethod('post')){

            $request->validate([
             
                'product_type_id' => 'required|',    
                'product_id' => 'required|',          
                
            ]);
            foreach ($request['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                  
                          $assignproduct = new AssignExtVendorProduct();
                          $assignproduct->ext_vendor_id = $id;
                          $assignproduct->ext_product_id = $request['product_id'][$key];
                          $assignproduct->save();
                    }
                }
    
            $notification = array(
                'message' =>" Product Has Been  Assign To Vendor  Successfully!",
                'alert-type' =>'success'
            );
    
            return redirect()->back()->with($notification);

        }
        $getEXtprodt = ExternalProduct::groupBy('ext_product_type')->get()->toArray();
        $getassignlist = AssignExtVendorProduct::with('getproduct')->where('ext_vendor_id',$id)->get()->toArray();
        return view('admin.expense.assign_ext_vend_product',compact('getEXtrvendor','getEXtprodt','getassignlist'));
     }

     public function DeleteAssignExtProduct($id)
     {
         $vendor = AssignExtVendorProduct::findOrFail($id);
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

     public function CapitalPurchaseHistroy($id)
    {
        $purchaseHist= ExternalCapitalPurchasePaymentLog::where('vendor_id',$id)->get()->toArray();
        return view('admin.expense.vendor_externalpurchase_histroy_list')->with(compact('purchaseHist'));
    }

    public function UpdateCapitalExternalVendorPayment(Request $request,$id)
    {
        $purchase_history= ExternalVendor::find($id);
       
        if($request->isMethod('post')) 
        {
            $request->validate([
             
                'paid_amount' => 'required|numeric|gt:0',          
                
            ]);
            $getvendor = ExternalVendor::where('id',$id)->first();
            if($getvendor['v_wallet'] >= $request->input('paid_amount') )
            {
                $Vendorupdate = DB::table('external_vendors')->where('id',$id)
                ->update(array(
                    'v_wallet'=>$request->get('remaining_amount')
                ));
             
                // insert new records in purchase bill log
                $rand_no = rand('00000',99999);
                $invoice_id = "REMPID-".$rand_no;
                $bill_log_insert_data = new ExternalCapitalPurchasePaymentLog();
                $bill_log_insert_data->invoice_id = $invoice_id;
                $bill_log_insert_data->vendor_id = $id;
                $bill_log_insert_data->total_billing = 0;
                $bill_log_insert_data->grand_total = 0;
                $bill_log_insert_data->previous_balance = $request->input('v_wallet');
                $bill_log_insert_data->paid_amount = $request->input('paid_amount');
                $bill_log_insert_data->remaining_amount = $request->input('remaining_amount');
                $bill_log_insert_data->save();
    
                return redirect('admin/expense-vendor')->with('success_message',"Capital Vendor Payment Has  Update Successfully!");

            }else{
                return redirect()->back()->with('error_message',"Enter Amount is Not Valid!");

            }
           
         
        }
        return view ('admin.expense.update_extvendor_payment')->with(compact('purchase_history'));
    }

    public function ExChangeExternalPurchaseProductList(Request $request,$id)
    {
      
       if ($request->isMethod('post')) {

           $request->validate([

               'return_product_id' => 'required|',
               'return_price' => 'required|numeric|gt:0',
               'return_qty' => 'required|numeric|min:1',
               'return_total_amt' => 'required|numeric|gt:0',
             

           ]);

           DB::beginTransaction();

            try {
                $getIngredients = ExternalProduct::where('id', $request->input('return_product_id'))->first();
                $getIngredients->ext_purchase_stock = $getIngredients->ext_purchase_stock - $request->input('return_qty');
                $getIngredients->update();
     
                $retunItem = new ExternalVendorReturnItem;
                $retunItem->vendor_id = $id;
                 $retunItem->return_product_id = $request->input('return_product_id');
                 $retunItem->return_price = $request->input('return_price');
                 $retunItem->return_qty = $request->input('return_qty');
                 $retunItem->return_total_amt = $request->input('return_total_amt');
                 $retunItem->save();
     
                 $getvendor = ExternalVendor::where('id',$id)->first();
                 $getupdat = $getvendor['v_wallet']-$request->input('return_total_amt');
     
                 $Vendorupdate = DB::table('external_vendors')->where('id',$id)
                 ->update(array(
                     'v_wallet'=>$getupdat
                 ));
                 $rand_no = rand('00000',99999);
                 $invoice_id = "ReturnTransID_".$rand_no;
                 $bill_log_insert_data = new ExternalCapitalPurchasePaymentLog();
                 $bill_log_insert_data->invoice_id = $invoice_id;
                 $bill_log_insert_data->vendor_id = $id;
                 $bill_log_insert_data->total_billing = 0;
                 $bill_log_insert_data->grand_total = 0;
                 $bill_log_insert_data->previous_balance = $request->input('v_wallet')-$request->input('return_total_amt');
                 $bill_log_insert_data->paid_amount = $request->input('return_total_amt');
                 $bill_log_insert_data->remaining_amount = $getupdat;
                 $bill_log_insert_data->save();
                 DB::commit();
                 return redirect()->back()->with('success_message',"Return Has Been Complete Successfully!");
            
               
            }catch (Exception $exception) {
                                DB::rollback();
                                    return redirect()->back()->with('error_message', $exception->getMessage());
                            
                            }

        
       }
      
       $getassignlist = AssignExtVendorProduct::with('getproduct')->where('ext_vendor_id',$id)->get()->toArray();
         $getvendor = ExternalVendor::findOrFail($id);
               $getreturnItemList = ExternalVendorReturnItem::with('getproduct')->where('vendor_id',$id)->get()->toArray();
    return view('admin.expense.exchange_purchase_product_list',compact('getassignlist','getvendor','getreturnItemList'));
    }



    
}
