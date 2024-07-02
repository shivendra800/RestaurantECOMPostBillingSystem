<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Unit;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\VendorType;
use App\Models\CategoryType;
use App\Models\PruchaseItem;
use Illuminate\Http\Request;
use App\Models\StoreToKitchen;
use App\Models\PruchaseBillLog;
use App\Models\PurchaseInvProd;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class PurchaseInvProdController extends Controller
{
    public function PurchaseInvProdIndex()
    {
        $purchaseInvProd = PurchaseInvProd::with('categorytype', 'category', 'vendortype', 'vendor')->latest()->get()->toArray();
        return view('admin.purchaseinvPrdoucts.purchaseInvProd_list', compact('purchaseInvProd'));
    }

    // search-------------------

    //  public function PurchaseInvProdIndexearch(Request $request)
    //  {
    //      $Vendortype = VendorType::where('status',1)->get()->toArray();
    //      $Vendor = Vendor::where('status',1)->get()->toArray();
    //      $Product = DB::table('assign_vendor_products')
    //      ->join('ingredients','ingredients.id','assign_vendor_products.product_id')
    //      ->join('units','units.id','assign_vendor_products.unit_id')
    //      ->where('ingredients.status',1)
    //      ->where('assign_vendor_products.vendor_type_id',$request->v_type_id)
    //      ->where('assign_vendor_products.vendor_id',$request->v_tye_wise_id)
    //      ->get()->toArray();
    //      // return $Product;
    //      $vendor_pre_value = Vendor::where('id',$request->v_tye_wise_id)->first();
    //      return view('admin.purchaseinvPrdoucts.add_edit_purchaseInvProd_list',compact('Product', 'Vendor','Vendortype','vendor_pre_value'));

    //  }
    // -----------------------
    // public function AddEditPurchaseInvProdIndex(Request $request, $id=null)
    // {

    //       if($request->isMethod('post')){
    //          $data = $request->all();
    //          if ($request->qty == null) {

    //             $notification = array(
    //                 'message' => 'Sorry you do not select any item',
    //                 'alert-type' => 'error'
    //             );
    //             return redirect()->back()->with($notification);

    //         }else
    //         {
    //             $validated = $request->validate([

    //                 'paid_amount'=>'required',
    //                 'payment_mode'=>'required',


    //             ]);
    //             DB::beginTransaction();
    //             try {
    //              $rand_no = rand('00000',99999);
    //             $invoice_id = "PID_".$rand_no;
    //             $purchase = new PurchaseInvProd();
    //             $purchase->v_type_id = $data['v_type_id'];
    //             $purchase->v_wise_type_id = $data['v_tye_wise_id'];
    //             $purchase->previous_amount = $data['previous_amount'];
    //             $purchase->total_bill = $data['total_bill'];
    //             $purchase->grand_total = $data['grand_total'];
    //             $purchase->paid_amount = $data['paid_amount'];
    //             $purchase->remaining_amount = $data['remaining_amount'];
    //             $purchase->product_purchase_date = $data['product_purchase_date'];
    //             $purchase->invoice_id = $invoice_id;
    //             $purchase->payment_mode = $data['payment_mode'];
    //             $purchase->save();
    //             $getlastinsertedId = DB::getPdo()->lastInsertId();

    //             foreach ($data['qty'] as $key => $value) {
    //                 if (!empty($value)) {
    //                     $purchaseInvProd = new PruchaseItem;
    //                     $gettotal = $data['qty'][$key] * $data['weight'][$key];

    //                     $purchaseInvProd->prod_id = $data['product_id'][$key];
    //                     $purchaseInvProd->purchase_inv_prods_id = $getlastinsertedId;
    //                     $purchaseInvProd->invoice_id = $invoice_id;
    //                     $purchaseInvProd->vendor_id = $data['v_tye_wise_id'];
    //                     $purchaseInvProd->unit = $data['unit_id'][$key];
    //                     $purchaseInvProd->price = $data['price'][$key];
    //                     $purchaseInvProd->qty = $data['qty'][$key];
    //                     $purchaseInvProd->weight = $data['weight'][$key];
    //                     $purchaseInvProd->total_weight = $data['qty'][$key]*$data['weight'][$key];
    //                     $purchaseInvProd->product_expire_date = $data['product_expire_date'][$key];
    //                     $purchaseInvProd->total_price = $data['amount'][$key];
    //                     $purchaseInvProd->previous_balance = $data['previous_amount'];
    //                     $purchaseInvProd->total_billing = $data['total_bill'];
    //                     $purchaseInvProd->grand_total = $data['grand_total'];
    //                     $purchaseInvProd->paid_amount = $data['paid_amount'];
    //                     $purchaseInvProd->remaining_amount = $data['remaining_amount'];
    //                     $purchaseInvProd->save();
    //                     $purchaseInvProd->status = 1;

    //                 }
    //  // update qty originalqty and price rate in product table
    //                     $getIngredients = Ingredient::where('id',$data['product_id'][$key])->first();

    //                     $getIngredients->purchase_stock = $getIngredients->purchase_stock + $data['qty'][$key];
    //                     $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock + $gettotal;
    //                     $getIngredients->update();



    //             }


    //                      // insert all price in purchase billing log table for all record of payemnts
    //               $pruchase_bill_log = new PruchaseBillLog();
    //               $pruchase_bill_log->invoice_id = $invoice_id;
    //               $pruchase_bill_log->vendor_id =  $data['v_tye_wise_id'];
    //               $pruchase_bill_log->previous_balance = $data['previous_amount'];
    //               $pruchase_bill_log->total_billing = $data['total_bill'];
    //               $pruchase_bill_log->grand_total = $data['grand_total'];
    //               $pruchase_bill_log->paid_amount = $data['paid_amount'];
    //               $pruchase_bill_log->remaining_amount = $data['remaining_amount'];
    //               $pruchase_bill_log->save();
    //              // update remaining amount to vendor table
    //             $update_vendor_tbl = Vendor::where('id',$request->v_tye_wise_id)->first();
    //             $update_vendor_tbl->v_wallet = $request->remaining_amount;
    //             $update_vendor_tbl->update();

    //              DB::commit();
    //             return redirect('admin/purchase-inv-product')->with('success_message',"Prdouct has been Purchase!");

    //             }catch (Exception $exception) {
    //                 DB::rollback();
    //                     return redirect()->back()->with('error_message', $exception->getMessage());

    //             }

    //         }

    //         }
    //     $unit = Unit::where('status',1)->get()->toArray();
    //     $Vendortype = VendorType::where('status',1)->get()->toArray();
    //     $Vendor = Vendor::where('status',1)->get()->toArray();

    //     $CategoryType = CategoryType::where('status',1)->get()->toArray();
    //     $Product = Ingredient::with('unit')->where('status',1)->limit(0)->get()->toArray();
    //     return view('admin.purchaseinvPrdoucts.add_edit_purchaseInvProd_list',compact('unit','Vendor','Vendortype','CategoryType','Product'));

    // }

    public function AddEditPurchaseInvProdIndex(Request $request)
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
                if ($data['order_taken'] == "full-order-added") {
                    $validated = $request->validate([

                        'paid_amount' => 'required|numeric',
                        'payment_mode' => 'required',
                        'total_bill' => 'required|numeric',
                        'grand_total' => 'required|numeric',
                        'remaining_amount' => 'required|numeric',
                        'expense_amt' => 'required|numeric',



                    ]);
                }
                DB::beginTransaction();
                try {


                    $rand_no = rand('00000', 99999);
                    $invoice_id = "PID_" . $rand_no;
                    $purchase = new PurchaseInvProd();
                    $purchase->v_type_id = $data['v_type_id'];
                    $purchase->v_wise_type_id = $data['v_tye_wise_id'];
                    $purchase->previous_amount = $data['previous_amount'];
                    $purchase->order_taken = $data['order_taken'];
                    if ($data['order_taken'] == "full-order-added") {

                        $purchase->total_bill = $data['total_bill'];
                        $purchase->grand_total = $data['grand_total'];
                        $purchase->paid_amount = $data['paid_amount'];
                        $purchase->remaining_amount = $data['remaining_amount'];
                        $purchase->payment_mode = $data['payment_mode'];
                        $purchase->expense_amt = $data['expense_amt'];
                    } else {
                        $purchase->total_bill = 0;
                        $purchase->grand_total = 0;
                        $purchase->paid_amount = 0;
                        $purchase->remaining_amount = 0;
                        $purchase->payment_mode = 'Pending-Bill';
                        $purchase->expense_amt = 0;
                    }

                    $purchase->product_purchase_date = $data['product_purchase_date'];
                    $purchase->invoice_id = $invoice_id;

                    $purchase->save();
                    $getlastinsertedId = DB::getPdo()->lastInsertId();

                    foreach ($data['qty'] as $key => $value) {
                        if (!empty($value)) {
                            $purchaseInvProd = new PruchaseItem;
                            $gettotal = $data['qty'][$key] * $data['weight'][$key];

                            $purchaseInvProd->prod_id = $data['product_id'][$key];
                            $purchaseInvProd->purchase_inv_prods_id = $getlastinsertedId;
                            $purchaseInvProd->invoice_id = $invoice_id;
                            $purchaseInvProd->vendor_id = $data['v_tye_wise_id'];
                            $purchaseInvProd->unit = $data['unit_id'][$key];
                            $purchaseInvProd->price = $data['price'][$key];
                            $purchaseInvProd->qty = $data['qty'][$key];
                            $purchaseInvProd->weight = $data['weight'][$key];
                            $purchaseInvProd->total_weight = $data['qty'][$key] * $data['weight'][$key];
                            $purchaseInvProd->product_expire_date = $data['product_expire_date'][$key];
                            $purchaseInvProd->total_price = $data['amount'][$key];
                            $purchaseInvProd->save();
                            if ($data['order_taken'] == "full-order-added") {
                                // update qty originalqty and price rate in product table
                                $getIngredients = Ingredient::where('id', $data['product_id'][$key])->first();
                                $getIngredients->purchase_stock = $getIngredients->purchase_stock + $data['qty'][$key];
                                $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock + $gettotal;
                                $getIngredients->update();
                            }
                        }
                    }

                    // insert all price in purchase billing log table for all record of payemnts

                    if ($data['order_taken'] == "full-order-added") {

                        $pruchase_bill_log = new PruchaseBillLog();
                        $pruchase_bill_log->invoice_id = $invoice_id;
                        $pruchase_bill_log->vendor_id =  $data['v_tye_wise_id'];
                        $pruchase_bill_log->previous_balance = $data['previous_amount'];
                        $pruchase_bill_log->total_billing = $data['total_bill'];
                        $pruchase_bill_log->grand_total = $data['grand_total'];
                        $pruchase_bill_log->paid_amount = $data['paid_amount'];
                        $pruchase_bill_log->remaining_amount = $data['remaining_amount'];
                        $pruchase_bill_log->save();

                        // update remaining amount to vendor table
                        $update_vendor_tbl = Vendor::where('id', $request->v_tye_wise_id)->first();
                        $update_vendor_tbl->v_wallet = $request->remaining_amount;
                        $update_vendor_tbl->update();
                    }


                    DB::commit();
                    return redirect('admin/purchase-inv-product')->with('success_message', "Prdouct has been Purchase!");
                } catch (Exception $exception) {
                    DB::rollback();
                    return redirect()->back()->with('error_message', $exception->getMessage());
                }
            }
        }


        $unit = Unit::where('status', 1)->get()->toArray();
        $Vendortype = VendorType::where('status', 1)->get()->toArray();
        $Vendor = Vendor::where('status', 1)->get()->toArray();

        $CategoryType = CategoryType::where('status', 1)->get()->toArray();
        $Product = Ingredient::with('unit')->where('status', 1)->get()->toArray();
        return view('admin.purchaseinvPrdoucts.add_edit_purchaseInvProd_list', compact('unit', 'Vendor', 'Vendortype', 'CategoryType', 'Product'));
    }

    public function EditPurchaseInvProdIndex(Request $request, $id)
    {
        $purchase =  PurchaseInvProd::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($data['order_taken'] == "full-order-added") {
                $validated = $request->validate([

                    'paid_amount' => 'required|numeric',
                    'payment_mode' => 'required',
                    'total_bill' => 'required|numeric',
                    'grand_total' => 'required|numeric',
                    'remaining_amount' => 'required|numeric',
                    'expense_amt' => 'required|numeric',



                ]);
            }
            DB::beginTransaction();
            try {


                $Updatepurchase =  PurchaseInvProd::where('id', $id)->first();
                $Updatepurchase->previous_amount = $data['previous_amount'];
                $Updatepurchase->order_taken = $data['order_taken'];
                if ($data['order_taken'] == "full-order-added") {
                    $Updatepurchase->total_bill = $data['total_bill'];
                    $Updatepurchase->grand_total = $data['grand_total'];
                    $Updatepurchase->paid_amount = $data['paid_amount'];
                    $Updatepurchase->remaining_amount = $data['remaining_amount'];
                    $Updatepurchase->payment_mode = $data['payment_mode'];
                    $Updatepurchase->expense_amt = $data['expense_amt'];
                } else {
                    $Updatepurchase->total_bill = 0;
                    $Updatepurchase->grand_total = 0;
                    $Updatepurchase->paid_amount = 0;
                    $Updatepurchase->remaining_amount = 0;
                    $Updatepurchase->payment_mode = 'Pending-Bill';
                    $Updatepurchase->expense_amt = 0;
                }
                $Updatepurchase->save();

                foreach ($data['qty'] as $key => $value) {
                    if (!empty($value)) {

                        $updateitempurchaseExists = PruchaseItem::where('purchase_inv_prods_id', $id)->where('prod_id', $data['product_id'][$key])->exists();
                        if ($updateitempurchaseExists) {


                            $gettotalu = $data['qty'][$key] * $data['weight'][$key];
                            $updateitempurchase = PruchaseItem::where('purchase_inv_prods_id', $id)->where('prod_id', $data['product_id'][$key])->first();
                            $updateitempurchase->prod_id = $data['product_id'][$key];
                            $updateitempurchase->purchase_inv_prods_id = $id;
                            $updateitempurchase->invoice_id = $purchase['invoice_id'];
                            $updateitempurchase->vendor_id = $purchase['v_wise_type_id'];
                            $updateitempurchase->unit = $data['unit_id'][$key];
                            $updateitempurchase->price = $data['price'][$key];
                            $updateitempurchase->qty = $data['qty'][$key];
                            $updateitempurchase->weight = $data['weight'][$key];
                            $updateitempurchase->total_weight = $data['qty'][$key] * $data['weight'][$key];
                            $updateitempurchase->product_expire_date = $data['product_expire_date'][$key];
                            $updateitempurchase->total_price = $data['amount'][$key];
                            $updateitempurchase->save();
                            if ($data['order_taken'] == "full-order-added") {

                                // update qty originalqty and price rate in product table
                                $getIngredients = Ingredient::where('id', $data['product_id'][$key])->first();
                                $getIngredients->purchase_stock = $getIngredients->purchase_stock + $data['qty'][$key];
                                $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock + $gettotalu;
                                $getIngredients->update();
                            }
                        } else {
                            $purchaseInvProd = new PruchaseItem;
                            $gettotal = $data['qty'][$key] * $data['weight'][$key];

                            $purchaseInvProd->prod_id = $data['product_id'][$key];
                            $purchaseInvProd->purchase_inv_prods_id = $id;
                            $purchaseInvProd->invoice_id = $purchase['invoice_id'];
                            $purchaseInvProd->vendor_id = $purchase['v_wise_type_id'];
                            $purchaseInvProd->unit = $data['unit_id'][$key];
                            $purchaseInvProd->price = $data['price'][$key];
                            $purchaseInvProd->qty = $data['qty'][$key];
                            $purchaseInvProd->weight = $data['weight'][$key];
                            $purchaseInvProd->total_weight = $data['qty'][$key] * $data['weight'][$key];
                            $purchaseInvProd->product_expire_date = $data['product_expire_date'][$key];
                            $purchaseInvProd->total_price = $data['amount'][$key];
                            $purchaseInvProd->save();
                            if ($data['order_taken'] == "full-order-added") {

                                // update qty originalqty and price rate in product table
                                $getIngredients = Ingredient::where('id', $data['product_id'][$key])->first();
                                $getIngredients->purchase_stock = $getIngredients->purchase_stock + $data['qty'][$key];
                                $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock + $gettotal;
                                $getIngredients->update();
                            }
                        }
                    }
                }


                // insert all price in purchase billing log table for all record of payemnts

                if ($data['order_taken'] == "full-order-added") {

                    $pruchase_bill_log = new PruchaseBillLog();
                    $pruchase_bill_log->invoice_id = $purchase['invoice_id'];
                    $pruchase_bill_log->vendor_id =  $purchase['v_wise_type_id'];
                    $pruchase_bill_log->previous_balance = $data['previous_amount'];
                    $pruchase_bill_log->total_billing = $data['total_bill'];
                    $pruchase_bill_log->grand_total = $data['grand_total'];
                    $pruchase_bill_log->paid_amount = $data['paid_amount'];
                    $pruchase_bill_log->remaining_amount = $data['remaining_amount'];
                    $pruchase_bill_log->save();

                    // update remaining amount to vendor table
                    $update_vendor_tbl = Vendor::where('id', $purchase['v_wise_type_id'])->first();
                    $update_vendor_tbl->v_wallet = $request->remaining_amount;
                    $update_vendor_tbl->update();
                }

                DB::commit();
                return redirect('admin/purchase-inv-product')->with('success_message', "Prdouct has been Purchase!");
            } catch (Exception $exception) {
                DB::rollback();
                return redirect()->back()->with('error_message', $exception->getMessage());
            }
        }

        $getpurchaseitem = PruchaseItem::with('product', 'unit')->where('purchase_inv_prods_id', $purchase['id'])->get();
        $getProduct = Ingredient::with('unit')->where('status', 1)->get()->toArray();
        $getVendorPrivAmt = Vendor::where('id', $purchase['v_wise_type_id'])->first()->toArray();
        return view('admin.purchaseinvPrdoucts.edit_purchaseInvProd_list', compact('getpurchaseitem', 'purchase', 'getProduct', 'getVendorPrivAmt'));
    }

    public function ViewPurchaseDetails($id)
    {
        $ViewPurchaseProd = PurchaseInvProd::with('categorytype', 'category', 'vendortype', 'vendor')->where('id', $id)->first()->toArray();
        $viewPurchaseitem = PruchaseItem::with('product', 'unit')->where('vendor_id', $ViewPurchaseProd['v_wise_type_id'])->where('purchase_inv_prods_id', $id)->where('total_price', '!=', '0')->get()->toArray();

        return view('admin.purchaseinvPrdoucts.view_purchase_products', compact('ViewPurchaseProd', 'viewPurchaseitem'));
    }

    public function PurchaseInvProdIndexDelete($id)
    {
        $purchaseInvProd = PurchaseInvProd::findOrFail($id);
        try {

            if ($purchaseInvProd['order_taken'] == "more-orderWillTake") {
                $purchaseInvProd->delete();
                $message = "Your Purchase Prdouct   is Delete Successfully!";
                return redirect('admin/purchase-inv-product')->with('success_message', $message);
            } else {
                DB::beginTransaction();
                $getPruchaseItem = PruchaseItem::where('purchase_inv_prods_id', $id)->get()->toArray();

                foreach ($getPruchaseItem as $key => $value) {
                    if (!empty($value)) {


                        $updatePruchaseItem = PruchaseItem::where('id', $value['id'])->first()->toArray();

                        // update qty originalqty and price rate in product table
                        $getIngredients = Ingredient::where('id', $updatePruchaseItem['prod_id'])->first();
                        $getIngredients->purchase_stock = $getIngredients->purchase_stock - $updatePruchaseItem['qty'];
                        $getIngredients->purchase_Wtstock = $getIngredients->purchase_Wtstock - $updatePruchaseItem['total_weight'];
                        $getIngredients->update();
                    }
                }
                PruchaseItem::where('purchase_inv_prods_id', $id)->delete();

                $update_vendor_tbl = Vendor::where('id', $purchaseInvProd['v_wise_type_id'])->first();
                $update_vendor_tbl->v_wallet = $purchaseInvProd['previous_amount'];
                $update_vendor_tbl->update();



                PruchaseBillLog::where('invoice_id', $purchaseInvProd['invoice_id'])->delete();
                $purchaseInvProd->delete();

                DB::commit();
                $message = "Delete Successfully!";
                return redirect('admin/purchase-inv-product')->with('success_message', $message);
            }
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                $message = "data cant be deleted";
                return redirect('admin/purchase-inv-product')->with('error_message', $message);
            }
        }
    }
    public function PurchaseInvProdIndexdeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("purchase_inv_prods")->whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Purchase Prdouct Deleted successfully."]);
    }
}
