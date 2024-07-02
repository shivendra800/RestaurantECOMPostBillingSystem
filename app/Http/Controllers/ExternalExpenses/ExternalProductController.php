<?php

namespace App\Http\Controllers\ExternalExpenses;

use Illuminate\Http\Request;
use App\Models\ExternalProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\ExternalProductUseLogMang;

class ExternalProductController extends Controller
{

    public function ExternalProduct()
    {
        $getextProduct = ExternalProduct::latest()->get()->toArray();
        return view('admin.expense.ext_product_list',compact('getextProduct'));
    }

    public function AddEditExternalProduct(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $AddeditExtProd = new ExternalProduct;
            $message = "External Product Added Successfully!";
        }
        else{
            $title= "Edit";
            $AddeditExtProd = ExternalProduct::find($id);
            $message = "External Product Updated Successfully!";
        }


       
       
        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([

                'ext_product_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:external_products,ext_product_name,'.$id,
                'ext_product_type' => 'required|regex:/[a-zA-Z\s]+/|max:255',
              
            

              

            ]);
            $AddeditExtProd->ext_product_name = $data['ext_product_name'];
            $AddeditExtProd->ext_product_type = $data['ext_product_type'];
            $AddeditExtProd->save();
            return redirect()->back()->with('success_message',$message);
        }
        return view('admin.expense.add_edit_ExternalProduct',compact('AddeditExtProd','title'));

    }

    public function ExternalProductDelete($id)
    {
        $AddeditExtProd = ExternalProduct::findOrFail($id);
        try {
            $AddeditExtProd->delete();
            $message= "Your External Product  (".$AddeditExtProd['ext_product_name'].") is Delete Successfully!";
            return redirect('/admin/expense-TypeProduct')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/expense-TypeProduct')->with('error_message',$message);
        }}   
    }

    public function ExternalProductStatusChange(Request $request)
    {
        $status_id=$request->get('status_id');

        $statuschange=DB::table('external_products')
            ->where('id',$status_id)
            ->first();

        DB::table('external_products')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/expense-TypeProduct')->with('success_message',"Status updated Successfully!");
    }

    public function CapitalCurentStockList()
    {
        $getextProduct = ExternalProduct::latest()->get()->toArray();
        return view('admin.expense.ext_product_stock_list',compact('getextProduct'));
    }

    public function CapitalUseStock(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($data['use_qty'] == null) {

                $notification = array(
                'message' => 'Sorry you do not have any item', 
                'alert-type' => 'error'
            );
            return redirect()->back( )->with($notification);

            } else {

                foreach ($data['use_qty'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $update_vendor_tbl = ExternalProduct::where('id',$data['product_id'][$key])->where('ext_purchase_stock','>=',$attribute)->first();

                        if ($update_vendor_tbl) {
                            $update_vendor_tbl->ext_purchase_stock =$data['ext_consumption_stock'][$key];
                          
                            $update_vendor_tbl->ext_consumption_stock = $update_vendor_tbl->ext_consumption_stock + $data['use_qty'][$key];
                            $update_vendor_tbl->update();

                            $stockrevicehistrkt = new ExternalProductUseLogMang;
                            $stockrevicehistrkt->transfer_qty = $data['use_qty'][$key];
                            $stockrevicehistrkt->product_id = $data['product_id'][$key];
                            $stockrevicehistrkt->before_transfer_qty = $update_vendor_tbl['ext_purchase_stock'] + $data['use_qty'][$key];
                            $stockrevicehistrkt->after_transfer_qty = $update_vendor_tbl['ext_purchase_stock'];
                            $stockrevicehistrkt->remark = $data['remark'][$key];
                            $stockrevicehistrkt->save();

                        }else{
                            $message = "Plz Enter Valid Value!";
                            return redirect()->back()->with('error_message', $message); 
                        }


                      



                    }
                }
            
                $message = "Your Qty Has Been Updated!";
                return redirect()->back()->with('success_message', $message);  
           

            }
    
      }
      $getextProduct = ExternalProduct::latest()->get()->where('ext_purchase_stock','>','0')->toArray();
        return view('admin.expense.capital_use_stock_managemet')->with(compact('getextProduct'));
    }

    public function CapitalUseStockLog()
    {
        $getextProductLog = ExternalProductUseLogMang::with('extproduct')->latest()->get()->toArray();
        return view('admin.expense.ext_product_stock_log_history',compact('getextProductLog'));
    }


    
}
