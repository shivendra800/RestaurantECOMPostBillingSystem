<?php

namespace App\Http\Controllers\ExternalExpenses;

use Exception;
use Illuminate\Http\Request;
use App\Models\ExternalVendor;
use App\Models\ExternalProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\ExternalCapitalPurchaseInv;
use App\Models\ExternalCapitalPurchaseInvItem;
use App\Models\ExternalCapitalPurchasePaymentLog;

class CapitalPurchaseInvController extends Controller
{
    public function CapitalPurchaseInvProdIndex()
    {
         $CapitalpurchaseInvProd = ExternalCapitalPurchaseInv::with('Extvendor')->latest()->get()->toArray();
       return view('admin.expense.purchaseinvPrdoucts.purchaseInvProd_list',compact('CapitalpurchaseInvProd'));
    }

     // search-------------------

     public function CapitalPurchaseInvProdIndexearch(Request $request)
     {
        $getExternalVendor = ExternalVendor::where('status',1)->groupBy('vendor_type')->get()->toArray();
       
         $Product = DB::table('assign_ext_vendor_products')
         ->join('external_products','external_products.id','assign_ext_vendor_products.ext_product_id')
         ->where('external_products.status',1)
         ->where('assign_ext_vendor_products.ext_vendor_id',$request->v_tye_wise_id)
         ->get()->toArray();
         // return $Product;
         $vendor_pre_value = ExternalVendor::where('id',$request->v_tye_wise_id)->first();
         return view('admin.expense.purchaseinvPrdoucts.add_edit_purchaseInvProd_list',compact( 'getExternalVendor','Product','vendor_pre_value'));
 
     }
     // -----------------------
    public function AddEditCapitalPurchaseInvProdIndex(Request $request, $id=null)
    {
       
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($request->qty == null) {

                $notification = array(
                    'message' => 'Sorry you do not select any item',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);

            } else {

                $validated = $request->validate([

                    'paid_amount' => 'required',
                    'payment_mode' => 'required',
                 


                ]);
                DB::beginTransaction();
                try {
                    $rand_no = rand('00000', 99999);
                    $invoice_id = "CAPITALPID-" . $rand_no;
                    $purchase = new ExternalCapitalPurchaseInv();
                    $purchase->v_type_id = $data['vendor_id'];
                    $purchase->previous_amount = $data['previous_amount'];
                    $purchase->total_bill = $data['total_bill'];
                    $purchase->grand_total = $data['grand_total'];
                    $purchase->paid_amount = $data['paid_amount'];
                    $purchase->remaining_amount = $data['remaining_amount'];
                    $purchase->invoice_id = $invoice_id;
                    $purchase->payment_mode = $data['payment_mode'];
                    $purchase->save();
                    $getlastinsertedId = DB::getPdo()->lastInsertId();

                    foreach ($data['qty'] as $key => $value) {
                        if (!empty($value)) {
                            $purchaseInvProd = new ExternalCapitalPurchaseInvItem;

                            $purchaseInvProd->prod_id = $data['product_id'][$key];
                            $purchaseInvProd->purchase_inv_prods_id = $getlastinsertedId;
                            $purchaseInvProd->invoice_id = $invoice_id;
                            $purchaseInvProd->vendor_id = $data['vendor_id'];
                            $purchaseInvProd->price = $data['price'][$key];
                            $purchaseInvProd->qty = $data['qty'][$key];
                            $purchaseInvProd->total_price = $data['amount'][$key];
                            $purchaseInvProd->save();
                            // update qty originalqty and price rate in product table
                            $getIngredients = ExternalProduct::where('id', $data['product_id'][$key])->first();

                            $getIngredients->ext_purchase_stock = $getIngredients->ext_purchase_stock + $data['qty'][$key];
                            $getIngredients->update();
                        }



                    }
                    // insert all price in purchase billing log table for all record of payemnts
                    $pruchase_bill_log = new ExternalCapitalPurchasePaymentLog();
                    $pruchase_bill_log->invoice_id = $invoice_id;
                    $pruchase_bill_log->vendor_id = $data['vendor_id'];
                    $pruchase_bill_log->previous_balance = $data['previous_amount'];
                    $pruchase_bill_log->total_billing = $data['total_bill'];
                    $pruchase_bill_log->grand_total = $data['grand_total'];
                    $pruchase_bill_log->paid_amount = $data['paid_amount'];
                    $pruchase_bill_log->remaining_amount = $data['remaining_amount'];
                    $pruchase_bill_log->save();
                    // update remaining amount to vendor table 
                    $update_vendor_tbl = ExternalVendor::where('id', $request->vendor_id)->first();
                    $update_vendor_tbl->v_wallet = $request->remaining_amount;
                    $update_vendor_tbl->update();

                    DB::commit();
                    return redirect('admin/capital-purchaseInvList')->with('success_message', "Prdouct has been Purchase!");
                   
                }
                catch (Exception $exception) {
                    DB::rollback();
                        return redirect()->back()->with('error_message', $exception->getMessage());
                
                }
                }
           
          
        }
     

        $getExternalVendor = ExternalVendor::where('status',1)->groupBy('vendor_type')->get()->toArray();
        $Product = ExternalProduct::where('status',1)->limit(0)->get()->toArray();
        return view('admin.expense.purchaseinvPrdoucts.add_edit_purchaseInvProd_list',compact('getExternalVendor','Product'));

    }

    public function CapitalViewPurchaseDetails ($id)
    {
        $ViewPurchaseProd = ExternalCapitalPurchaseInv::with('Extvendor')->where('id',$id)->first()->toArray();
        $viewPurchaseitem = ExternalCapitalPurchaseInvItem::with('Extproduct')->where('purchase_inv_prods_id',$id)->get()->toArray();
      
        return view('admin.expense.purchaseinvPrdoucts.view_purchase_products',compact('ViewPurchaseProd','viewPurchaseitem'));
    }

    public function CapitalPurchaseInvProdIndexDelete($id)
    {
        $purchaseInvProd = ExternalCapitalPurchaseInv::findOrFail($id);
        try {
        
            $update_vendor_tbl = ExternalVendor::where('id',$purchaseInvProd['v_type_id'])->first();
            $update_vendor_tbl->v_wallet = $update_vendor_tbl['v_wallet']-($purchaseInvProd['grand_total']-$purchaseInvProd['paid_amount']);
            $update_vendor_tbl->update();
            $Purchaseitem = ExternalCapitalPurchaseInvItem::where('purchase_inv_prods_id',$id)->delete();
            $Purchaseitem = ExternalCapitalPurchasePaymentLog::where('invoice_id',$purchaseInvProd['invoice_id'])->delete();
            $purchaseInvProd->delete();
            $message= "Your  Capital Purchase Inv   is Delete Successfully!";
            return redirect('admin/capital-purchaseInvList')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('admin/capital-purchaseInvList')->with('error_message',$message);
        }}   
    }
}
