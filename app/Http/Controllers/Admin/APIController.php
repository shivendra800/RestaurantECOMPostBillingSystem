<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PurchaseInvProd;

class APIController extends Controller
{
    public function getVendor($vtypeid)
    {
        try {

            $vendor = DB::table('vendors')->where('vendor_type',$vtypeid)->get();
            $json['api_status'] = "OK";
            $json['data'] = $vendor;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();

            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();

        }
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function getProdType($prodtypeid)
    {
        try {

            $indrglist = DB::table('ingredients')->where('product_type_id',$prodtypeid)->get();
            $json['api_status'] = "OK";
            $json['data'] = $indrglist;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();

            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();

        }
        header('Content-type: application/json');
        echo json_encode($json);
    }
    public function getCategory($ctypeid)
    {
        try {

            $category = DB::table('categories')->where('c_type_id',$ctypeid)->get();
            $json['api_status'] = "OK";
            $json['data'] = $category;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();

            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();

        }
        header('Content-type: application/json');
        echo json_encode($json);
    }
    public function getunit($product_id)
    {
       
        try {
           
            $unit = DB::table('ingredients')->join('units','units.id','ingredients.unit_id')->select('units.id','units.unit_name')->where('ingredients.id',$product_id)->get();
            $json['api_status'] = "OK";
            $json['data'] = $unit;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }
    public function vendor_wise_previous_balance($vendor_wise_previous_balance)
    {
        
         try {
          
            $vendor_pre_amt = DB::table('vendors')->where('id',$vendor_wise_previous_balance)->first();
            $json['api_status'] = "OK";
            $json['data'] = $vendor_pre_amt;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
            
        }
        header('Content-type: application/json');
        echo json_encode($json);

    }
    public function getsubcatmenu($meni_cat_id)
    {
       
        try {
           
            $getsubcatmenu = DB::table('menu_sub_categories')->where('menu_cat_id',$meni_cat_id)->get();
            $json['api_status'] = "OK";
            $json['data'] = $getsubcatmenu;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }


    public function getItemprice($item_id)
    {
       
        try {
           
            $getitemprice = DB::table('menu_item_prices')->where('id',$item_id)->get();
            $json['api_status'] = "OK";
            $json['data'] = $getitemprice;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function getoffer($item_id,$item_qty)
    {
       
        try {
            $date = date('Y-m-d');
            $getoffer = DB::table('product_wise_coupons')->where('no_of_qty_buy','<=',$item_qty)->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
            $no_qty_buy_to_free = $getoffer->where('product_id',$item_id)->max('no_qty_buy_to_free');
            $no_of_qty_buy = $getoffer->where('product_id',$item_id)->max('no_of_qty_buy');

            if($no_of_qty_buy <= $item_qty)
            {
                $getqty = $item_qty / $no_of_qty_buy;
                if(fmod($getqty, 1) == 0.00){
                    $getfreeqty = $getqty * $no_qty_buy_to_free;
                } else {
                    $get= (int)$getqty;
                    if(fmod($get, 1) == 0.00){       
                        $getfreeqty = $get * $no_qty_buy_to_free;
                    } else {
                        $getfreeqty = $get * $no_qty_buy_to_free;
                    }
                }
            }
            $json['api_status'] = "OK";
            $json['no_qty_buy_to_free'] = $getfreeqty;                                                             
            $json['no_of_qty_buy'] = $no_of_qty_buy;                                                             
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }

    public function extraMenuPrice($extra_menu_item_id)
    {
       
        try {
           
            $extraMenuPrice = DB::table('extra_menus')->where('id',$extra_menu_item_id)->get();
            $json['api_status'] = "OK";
            $json['data'] = $extraMenuPrice;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }
    public function getExternalProdType($prodtypeid)
    {
        try {
            $getextprod = DB::table('external_products')->where('ext_product_type',$prodtypeid)->get();
            $json['api_status'] = "OK";
            $json['data'] = $getextprod;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }
public function getExtrentalVendor($v_type)
    {
        try {
            $getextvendortype = DB::table('external_vendors')->where('vendor_type',$v_type)->get();
            $json['api_status'] = "OK";
            $json['data'] = $getextvendortype;
            $json['msg'] = "";
        } catch (\Exception $e) {
            DB::rollback();
            $json['api_status'] = "ERROR";
            $json['msg'] = "Error-" . $e->getLine() . " :- " . $e->getMessage();
        }
        header('Content-type: application/json');
        echo json_encode($json);
    }







}
