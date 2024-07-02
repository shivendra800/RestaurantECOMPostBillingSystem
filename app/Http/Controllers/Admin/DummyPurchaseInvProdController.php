<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\VendorType;
use App\Models\SiteSetting;
use App\Models\CategoryType;
use App\Models\PruchaseItem;
use Illuminate\Http\Request;
use App\Models\PruchaseBillLog;
use App\Models\PurchaseInvProd;
use App\Models\DummyPruchaseItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DummyPurchaseInvProd;
use Illuminate\Database\QueryException;

class DummyPurchaseInvProdController extends Controller
{
    public function DummyPurchaseInvProdIndex()
    {
       $dummypurchaseInvProd = DummyPurchaseInvProd::with('categorytype','category','vendortype','vendor')->latest()->get()->toArray();
       return view('admin.dummypurchases.dummypurchaseInvProd_list',compact('dummypurchaseInvProd'));
    }

     // search-------------------

     public function DummyPurchaseInvProdIndexearch(Request $request)
     {
         $Vendortype = VendorType::where('status',1)->get()->toArray();
         $Vendor = Vendor::where('status',1)->get()->toArray();
         $Product = DB::table('assign_vendor_products')
         ->join('ingredients','ingredients.id','assign_vendor_products.product_id')
         ->join('units','units.id','assign_vendor_products.unit_id')
         ->where('ingredients.status',1)
         ->where('assign_vendor_products.vendor_type_id',$request->v_type_id)
         ->where('assign_vendor_products.vendor_id',$request->v_tye_wise_id)
         ->get()->toArray();
         // return $Product;
         $vendor_pre_value = Vendor::where('id',$request->v_tye_wise_id)->first();
         return view('admin.dummypurchases.add_edit_dummypurchaseInvProd_list',compact('Product', 'Vendor','Vendortype','vendor_pre_value'));
 
     }
     // -----------------------
    public function AddEditDummyPurchaseInvProdIndex(Request $request, $id=null)
    {
       
        if($request->isMethod('post')){
             $data = $request->all();
            // $validated = $request->validate([

            //     'paid_amount'=>'required',
            //     'payment_mode'=>'required',
                

            // ]);
       
            $rand_no = rand('00000',99999);
            $order_no = "NOTEPID_".$rand_no;
            $purchase = new DummyPurchaseInvProd();
            $purchase->v_type_id = $data['v_type_id'];
            $purchase->v_wise_type_id = $data['v_tye_wise_id'];
            $purchase->order_no = $order_no;
            $purchase->save();
            $getlastinsertedId = DB::getPdo()->lastInsertId();
         
            foreach ($data['qty'] as $key => $value) {
                if (!empty($value)) {
                    $purchaseInvProd = new DummyPruchaseItem;
                    $purchaseInvProd->prod_id = $data['product_id'][$key];
                    $purchaseInvProd->purchase_inv_prods_id = $getlastinsertedId;
                    $purchaseInvProd->invoice_id = $order_no;
                    $purchaseInvProd->vendor_id = $data['v_tye_wise_id'];
                    $purchaseInvProd->unit = $data['unit_id'][$key];
                    $purchaseInvProd->qty = $data['qty'][$key];
                    $purchaseInvProd->save();   
                }
            }
            
        return redirect('admin/Dummypurchase-inv-product')->with('success_message',"Prdouct Purchase List Has Been Created Successfully!");        
        }
        $unit = Unit::where('status',1)->get()->toArray();
        $Vendortype = VendorType::where('status',1)->get()->toArray();
        $Vendor = Vendor::where('status',1)->get()->toArray();
        $Category = Category::where('status',1)->get()->toArray();
        $CategoryType = CategoryType::where('status',1)->get()->toArray();
        $Product = Ingredient::with('unit')->where('status',1)->limit(0)->get()->toArray();
        return view('admin.dummypurchases.add_edit_dummypurchaseInvProd_list',compact('unit','Vendor','Category','Vendortype','CategoryType','Product'));

    }

    public function ViewDummyPurchaseDetails($id)
    {
        $data['dummyprodpurch'] = DummyPurchaseInvProd::with('categorytype','category','vendortype','vendor')->where('id',$id)->first()->toArray();
        $data['dummyprodpurchitem'] = DummyPruchaseItem::with('product','unit')->where('purchase_inv_prods_id',$id)->get()->toArray();
        $data['getsiteSetting'] = SiteSetting::first();
     
        $pdf = PDF::loadView('admin.dummypurchases.view_dummypurchase_products', $data);
        $todayDate = Carbon::now()->format('d-m-Y');
        return $pdf->stream('PurchaseList-'.$data['dummyprodpurch']['vendor']['vendor_name'].'-'.$todayDate.'.pdf');

	
        // return view('admin.dummypurchases.view_dummypurchase_products',compact('ViewPurchaseProd','viewPurchaseitem'));
    }

    public function DummyPurchaseInvProdIndexDelete($id)
    {
        $purchaseInvProd = DummyPurchaseInvProd::findOrFail($id);
     

        try {
            $purchaseInvProd->delete();
            $deltedummyPurchaseitem = DummyPruchaseItem::with('product','unit')->where('purchase_inv_prods_id',$id)->delete();
            $message= "Your Purchase Prdouct Note List is Delete Successfully!";
            return redirect('/Dummypurchase-inv-product')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/Dummypurchase-inv-product')->with('error_message',$message);
        }}   
    }
}
