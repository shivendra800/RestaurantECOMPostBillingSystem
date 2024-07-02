<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ingredient;
use App\Models\KitchenStock;
use Illuminate\Http\Request;
use App\Models\StoreToKitchen;
use App\Models\BarProReceStock;
use App\Models\KitchenWastelog;
use App\Models\ReviceBarStockLog;
use App\Models\KitchenUseStocklog;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenProReceStock;
use App\Models\RestaurantStoreRoom;
use App\Http\Controllers\Controller;
use App\Models\UpdateSpoilExpireStock;
use App\Models\TransferBarToStoreStock;
use App\Models\TransferKitchenToStoreStock;

class RestaurantStoreRoomController extends Controller
{
    public function StoreToKitchen()
    {
        $getingredient = Ingredient::with('unit')->get()->toArray();
        return view('admin.storeTokitchen.store_room_list')->with(compact('getingredient'));
    }
    public function AddEditStoreRoom(Request $request)
    {

                    if ($request->isMethod('post')) {
                        $data = $request->all();
                       

                            foreach ($data['product_id'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $update_vendor_tbl = Ingredient::where('id',$attribute)->where('purchase_Wtstock','>=',$data['consumption_qty'][$key])->first();
                                    if($update_vendor_tbl){
                                     
                                        $update_vendor_tbl->purchase_Wtstock =$data['store_stock_qty'][$key];
                                    $update_vendor_tbl->store_stock_qty =$data['store_stock_qty'][$key];
                                    $update_vendor_tbl->remark =$data['remark'][$key];
                                    $update_vendor_tbl->consumption_qty = $update_vendor_tbl->consumption_qty + $data['consumption_qty'][$key];
                                    $update_vendor_tbl->update();
                                  

                                    }else{
                                        $message = "The Stock Can't Move To Kitchen .Plz Enter Valid Value!";
                                        return redirect()->back()->with('error_message', $message);  
                                    }
                                    
                                }
                            }
                            $message = "Your Qty Has Been Updated!";
                            return redirect()->back()->with('success_message', $message);  
                    }
    }
    public function KitchenReciveStock()
    {
        $kitchenStock = Ingredient::with('unit')->where('consumption_qty','>',0)->get()->toArray();
        return view('admin.storeTokitchen.kitchen_stock')->with(compact('kitchenStock'));
    }

    public function KitchenReciveStocksave(Request $request)
    {
        
       
            if ($request->isMethod('post')) {
                  $data = $request->all();

                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $update_vendor_tbl = KitchenProReceStock::where('product_id',$attribute)->first();
                        $update_vendor_tbl->consumption_qty = $update_vendor_tbl->consumption_qty + $data['consumption_qty'][$key];
                        $update_vendor_tbl->update();


                        $stockrevicehistrkt = new KitchenStock;
                        $stockrevicehistrkt->consumption_qty = $data['consumption_qty'][$key];
                        $stockrevicehistrkt->product_id = $data['product_id'][$key];
                        $stockrevicehistrkt->unit_id = $data['unit_id'][$key];
                         $stockrevicehistrkt->save();

                    }
                }
               
                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        Ingredient::where(['id' => $data['product_id'][$key]])->update([
                                'consumption_qty' => $data['c_qty'][$key]
                                ]);
                    }
                }
            
                return redirect()->back()->with('success_message', 'Added Items!');
            }
                }
    public function KitchenStockHistroy()
    {
        $getKitchenStock = KitchenStock::with('unit','product')->get()->toArray(); 
        $getingredient = Ingredient::get()->toArray();
        return view('admin.storeTokitchen.kitchen_stock_history')->with(compact('getKitchenStock','getingredient'));
    }
    public function KitchenStock()
    {
        $getKitchenStock = KitchenProReceStock::with('unit','product')->where('consumption_qty','>','0')->get()->toArray();
       
        return view('admin.storeTokitchen.kitchen_stock_list')->with(compact('getKitchenStock'));
    }

    public function datewiseserachKitchenStockHistroy(Request $request)
    {
        

        if($request->product_name==""||$request->product_name=="NULL")
        {
            $getKitchenStock = KitchenStock::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_stocks.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            // ->where('product_id',$request->product_name)
            ->get()->toArray();

        }else{
            $getKitchenStock = KitchenStock::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_stocks.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            ->where('product_id',$request->product_name)
            ->get()->toArray();
        }
       
   

  
   
  
       $getingredient = Ingredient::get()->toArray();
       return view('admin.storeTokitchen.kitchen_stock_history')->with(compact('getingredient','getKitchenStock'));
    }

    public function KitchenWaste()
    {
        $getKitchenStock = KitchenProReceStock::with('unit','product')->where('consumption_qty','>','0')->get()->toArray();
        return view('admin.storeTokitchen.kitchen_waste_mang')->with(compact('getKitchenStock'));
    }

    public function KitchenWasteUpdate(Request $request)
    {

       
                    if ($request->isMethod('post')) {
                        $data = $request->all();

                            foreach ($data['product_id'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $update_vendor_tbl = KitchenProReceStock::where('id',$attribute)->where('consumption_qty','>=',$data['waste_qty'][$key])->first();
                                    if($update_vendor_tbl){

                                        $update_vendor_tbl->consumption_qty =$data['after_waste_stock'][$key];
                                        $update_vendor_tbl->kitchen_stock_qty =$data['after_waste_stock'][$key];
                                        $update_vendor_tbl->remark =$data['remark'][$key];
                                        $update_vendor_tbl->waste_qty =  $data['waste_qty'][$key];
                                        $update_vendor_tbl->update();
    
                                        $wastelog = new KitchenWastelog;
                                        $wastelog->kitchen_cuurent_stock = $data['consumption_qty'][$key];
                                        $wastelog->waste_stock = $data['waste_qty'][$key];
                                        $wastelog->after_waste_stock = $data['after_waste_stock'][$key];
                                        $wastelog->product_id = $data['ingredient_id'][$key];
                                        $wastelog->unit_id = $data['unit_id'][$key];
                                         $wastelog->save();

                                    }else{

                                        $message = "Kitchen Waste Stock  Has Been Not Updated .Plz Enter Valid Number!";
                                        return redirect()->back()->with('error_message', $message);  

                                    }
                               

                                }

                            }
                            $message = "Kitchen Waste Stock  Has Been Updated!";
                            return redirect()->back()->with('success_message', $message);  
                    }
    }

    public function KitchenWasteLog()
    {
         $kitchenwastelog = KitchenWastelog::with('unit','product')->where('waste_stock','>','0')->get()->toArray();
         $getingredient = Ingredient::get()->toArray();  
        return view('admin.storeTokitchen.kitchen_waste_log')->with(compact('kitchenwastelog','getingredient'));
    }


    public function KitchenUseStock()
    {
        $updateusestock = KitchenProReceStock::with('unit','product')->where('consumption_qty','>','0')->get()->toArray();
        return view('admin.storeTokitchen.kitchen_usestock_mang')->with(compact('updateusestock'));
    }

    public function KitchenUseStockUpdate(Request $request)
    {

       
                    if ($request->isMethod('post')) {
                        $data = $request->all();

                            foreach ($data['product_id'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $update_vendor_tbl = KitchenProReceStock::where('id',$attribute)->where('consumption_qty','>=',$data['usestock_stock'][$key])->first();
                                    if($update_vendor_tbl){

                                        $update_vendor_tbl->consumption_qty =$data['after_use_stock'][$key];
                                        $update_vendor_tbl->kitchen_stock_qty =$data['after_use_stock'][$key];
                                        $update_vendor_tbl->remark =$data['remark'][$key];
                                        $update_vendor_tbl->usestock_stock = $data['usestock_stock'][$key];
                                        $update_vendor_tbl->update();
    
                                        $updateUseStocklog = new KitchenUseStocklog;
                                        $updateUseStocklog->kitchen_current_stock = $data['consumption_qty'][$key];
                                        $updateUseStocklog->usestock_stock = $data['usestock_stock'][$key];
                                        $updateUseStocklog->after_use_stock = $data['after_use_stock'][$key];
                                        $updateUseStocklog->product_id = $data['ingredient_id'][$key];
                                        $updateUseStocklog->unit_id = $data['unit_id'][$key];
                                         $updateUseStocklog->save();
    

                                    }else{
                                        $message = "Today Use  Stock Of Kitchen  Has Been Not Updated! Plz Enter Valid Number!";
                                        return redirect()->back()->with('error_message', $message); 
                                    }
                                  
                                }

                            }
                            $message = "Today Use  Stock Of Kitchen  Has Been Updated!";
                            return redirect()->back()->with('success_message', $message);  
                    }
    }

    public function KitchenUseStockLog()
    {
         $kitchenUsestocklog = KitchenUseStocklog::with('unit','product')->get()->toArray();
         $getingredient = Ingredient::get()->toArray();  
        return view('admin.storeTokitchen.kitchen_usestock_log')->with(compact('kitchenUsestocklog','getingredient'));
    }

     public function datewiseserachkitechenwaste(Request $request)
     {
        
        // $kitchenwastelog = KitchenWastelog::with('unit','product')
        // ->where('waste_stock','>','0')
        // ->whereBetween(DB::raw("DATE_FORMAT(kitchen_wastelogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
        // ->get()->toArray();

        if($request->product_name==""||$request->product_name=="NULL")
        {
            $kitchenwastelog = KitchenWastelog::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_wastelogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            // ->where('product_id',$request->product_name)
            ->get()->toArray();

        }else{
            $kitchenwastelog = KitchenWastelog::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_wastelogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            ->where('product_id',$request->product_name)
            ->get()->toArray();
        }
       $getingredient = Ingredient::get()->toArray();  
        return view('admin.storeTokitchen.kitchen_waste_log')->with(compact('kitchenwastelog','getingredient'));
     }

     public function datewiseserachkitechenUseStock(Request $request)
     {
        
        // $kitchenUsestocklog = KitchenUseStocklog::with('unit','product')
        // ->where('usestock_stock','>','0')
        // ->whereBetween(DB::raw("DATE_FORMAT(kitchen_use_stocklogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
        // ->get()->toArray();

        if($request->product_name==""||$request->product_name=="NULL")
        {
            $kitchenUsestocklog = KitchenUseStocklog::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_use_stocklogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            // ->where('product_id',$request->product_name)
            ->get()->toArray();

        }else{
            $kitchenUsestocklog = KitchenUseStocklog::with('unit','product')
            ->whereBetween(DB::raw("DATE_FORMAT(kitchen_use_stocklogs.created_at,'%Y-%m-%d')"), [$request->start_date, $request->end_date])
            ->where('product_id',$request->product_name)
            ->get()->toArray();
        }
       $getingredient = Ingredient::get()->toArray();  
        return view('admin.storeTokitchen.kitchen_usestock_log')->with(compact('kitchenUsestocklog','getingredient'));
     }



     ///  Bar Section Start


     public function StoreToBar()
     {
         $getingredient = Ingredient::with('unit')->get()->toArray();
         return view('admin.storeTobar.bar_store_room_list')->with(compact('getingredient'));
     }
     public function AddStoreRoomBar(Request $request)
     {
 
                     if ($request->isMethod('post')) {
                         $data = $request->all();
                        
 
                             foreach ($data['product_id'] as $key => $attribute) {
                                 if (!empty($attribute)) {
 
                                     $update_vendor_tbl = Ingredient::where('id',$attribute)->where('purchase_Wtstock','>=',$data['consumption_qty'][$key])->first();
                                     if($update_vendor_tbl){
                                      
                                         $update_vendor_tbl->purchase_Wtstock =$data['store_stock_qty'][$key];
                                     $update_vendor_tbl->store_stock_qty =$data['store_stock_qty'][$key];
                                     $update_vendor_tbl->remark =$data['remark'][$key];
                                     $update_vendor_tbl->bar_consumption_qty = $update_vendor_tbl->bar_consumption_qty + $data['consumption_qty'][$key];
                                     $update_vendor_tbl->update();
                                   
 
                                     }else{
                                         $message = "The Stock Can't Move To Kitchen .Plz Enter Valid Value!";
                                         return redirect()->back()->with('error_message', $message);  
                                     }
                                     
                                 }
                             }
                             $message = "Your Qty Has Been Updated!";
                             return redirect()->back()->with('success_message', $message);  
                     }
     }

     public function BarReciveStock(Request $request)
     {
         
        
             if ($request->isMethod('post')) {
                   $data = $request->all();
 
                 foreach ($data['product_id'] as $key => $attribute) {
                     if (!empty($attribute)) {

                        $update_vendor_tbl = BarProReceStock::where('product_id',$attribute)->first();
                        if($update_vendor_tbl)
                        {
                            $update_vendor_tbl->consumption_qty = $update_vendor_tbl->consumption_qty + $data['consumption_qty'][$key];
                            $update_vendor_tbl->update();
                        }else{
                            $save_vendor_tbl= new BarProReceStock();
                        $save_vendor_tbl->product_id = $attribute;
                            $save_vendor_tbl->consumption_qty =  $data['consumption_qty'][$key];
                            $save_vendor_tbl->save();
                        }
                        
 
 
                         $stockrevicehistrkt = new ReviceBarStockLog;
                         $stockrevicehistrkt->consumption_qty = $data['consumption_qty'][$key];
                         $stockrevicehistrkt->product_id = $data['product_id'][$key];
                         $stockrevicehistrkt->unit_id = $data['unit_id'][$key];
                          $stockrevicehistrkt->save();
 
                     }
                 }
                
                 foreach ($data['product_id'] as $key => $attribute) {
                     if (!empty($attribute)) {
                         Ingredient::where(['id' => $data['product_id'][$key]])->update([
                                 'bar_consumption_qty' => $data['c_qty'][$key]
                                 ]);
                     }
                 }
             
                 return redirect()->back()->with('success_message', 'Added Items!');
             }
             $barstockRecive = Ingredient::with('unit')->where('bar_consumption_qty','>',0)->get()->toArray();
             return view('admin.storeTobar.recive_bar_stock')->with(compact('barstockRecive'));
                 }


    public function BarCurrentStock()
    {
        
        $getbarStock = BarProReceStock::with('unit','product')->where('consumption_qty','>','0')->get()->toArray();
        return view('admin.storeTobar.bar_current_stock')->with(compact('getbarStock'));
    }
    public function BarReciveStockHistroy()
    {
        $getbarrevicelog = ReviceBarStockLog::with('unit','product')->get()->toArray(); 
         $getingredient = Ingredient::get()->toArray();
       
        return view('admin.storeTobar.bar_revice_stock_log')->with(compact('getbarrevicelog','getingredient'));
    }   

    public function UpdateStockForSpoilExpire()
    {
        $getingredient = Ingredient::with('unit')->get()->toArray();
        return view('admin.storeTokitchen.update_stock_spoil_expire')->with(compact('getingredient'));
    }
    public function UpdateStockForSpoilExpireSave(Request $request)
    {

                    if ($request->isMethod('post')) {
                        $data = $request->all();
                       

                            foreach ($data['spoil_expire_stock'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $update_vendor_tbl = Ingredient::where('id',$data['product_id'][$key])->where('purchase_Wtstock','>=',$data['spoil_expire_stock'][$key])->first();
                                    if($update_vendor_tbl){
                                     
                                    $update_vendor_tbl->purchase_Wtstock =$data['store_stock_qty'][$key];
                                    $update_vendor_tbl->store_stock_qty =$data['store_stock_qty'][$key];
                                    $update_vendor_tbl->remark =$data['remark'][$key];
                                    $update_vendor_tbl->spoil_expire_stock = $update_vendor_tbl->spoil_expire_stock + $data['spoil_expire_stock'][$key];
                                    $update_vendor_tbl->update();

                                    $updatespoilExpireLog = new UpdateSpoilExpireStock;
                                    $updatespoilExpireLog->product_id = $data['product_id'][$key];
                                    $updatespoilExpireLog->unit_id = $data['unit_id'][$key];
                                    $updatespoilExpireLog->current_stock = $data['store_stock_qty'][$key]+$data['spoil_expire_stock'][$key];
                                    $updatespoilExpireLog->spoil_expire_stock = $data['spoil_expire_stock'][$key];
                                    $updatespoilExpireLog->after_spoil_expire_totalstock = $data['store_stock_qty'][$key];
                                    $updatespoilExpireLog->remark = $data['remark'][$key];
                                     $updatespoilExpireLog->save();
                                  

                                    }else{
                                        $message = "The Stock Can't Be Update .Plz Enter Valid Value!";
                                        return redirect()->back()->with('error_message', $message);  
                                    }
                                    
                                }
                            }
                            $message = "Your Qty Has Been Updated!";
                            return redirect()->back()->with('success_message', $message);  
                    }
    }

    public function UpdateStockForSpoilExpireLog()
    {
        $spilExpireLogStore = UpdateSpoilExpireStock::with('unit','product')->get()->toArray(); 
        $getingredient = Ingredient::get()->toArray();
      
       return view('admin.storeTobar.spilExpireLogStore')->with(compact('spilExpireLogStore','getingredient'));
    }

    public function TransferBarToStoreStock()
    {
            $getbarStock = BarProReceStock::with('product')->get()->toArray();
        return view('admin.storeTobar.bartoStoreRoomStockTansfer')->with(compact('getbarStock'));
    }
    public function TransferBarToStoreStockSave(Request $request)
    {

        if ($request->isMethod('post')) {
                $data = $request->all();
           

                foreach ($data['trnsfertostore'] as $key => $attribute) {
                    if (!empty($attribute)) {

                             $update_vendor_tbl = BarProReceStock::where('product_id',$data['product_id'][$key])->where('consumption_qty','>=',$attribute)->first();
                        if($update_vendor_tbl){
                         
                        $update_vendor_tbl->consumption_qty =$data['store_stock_qty'][$key];
                        $update_vendor_tbl->remark =$data['remark'][$key];
                        $update_vendor_tbl->trnsfertostore = $update_vendor_tbl->trnsfertostore + $attribute;
                        $update_vendor_tbl->update();
                      

                        }else{
                            $message = "The Stock Can't Move To Store Room  .Plz Enter Valid Value!";
                            return redirect()->back()->with('error_message', $message);  
                        }
                        
                    }
                }
                $message = "Your Qty Has Been Updated!";
                return redirect()->back()->with('success_message', $message);  
        }
    }

    public function ReviceStockTransferFromBar(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($request->product_id == null) {

                $notification = array(
                'message' => 'Sorry you do not have any item', 
                'alert-type' => 'error'
            );
            return redirect()->back( )->with($notification);

            } else {

                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $reciveBarStock = BarProReceStock::where('product_id', $attribute)->first();
                        $reciveBarStock->trnsfertostore = $reciveBarStock->trnsfertostore - $data['trnsfertostore'][$key];
                        $reciveBarStock->update();


                        $stockrevicehistrkt = new TransferBarToStoreStock;
                        $stockrevicehistrkt->transfer_stock = $data['trnsfertostore'][$key];
                        $stockrevicehistrkt->product_id = $data['product_id'][$key];
                        $stockrevicehistrkt->current_stock = $reciveBarStock['consumption_qty'] + $data['trnsfertostore'][$key];
                        $stockrevicehistrkt->remaing_stock_in_bar = $reciveBarStock['consumption_qty'] - $data['trnsfertostore'][$key];
                        $stockrevicehistrkt->remark = $reciveBarStock['remark'];
                        $stockrevicehistrkt->save();



                    }
                }

                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {

                        $update_vendor_tbl = Ingredient::where('id', $attribute)->first();
                        $update_vendor_tbl->purchase_Wtstock = $update_vendor_tbl->purchase_Wtstock + $data['trnsfertostore'][$key];
                        $update_vendor_tbl->store_stock_qty = $update_vendor_tbl->purchase_Wtstock + $data['trnsfertostore'][$key];
                        $update_vendor_tbl->update();




                    }
                }

            }
    
      
          return redirect()->back()->with('success_message', 'Added Items!');
      }
      $getbarStock = BarProReceStock::with('product')->where('trnsfertostore','>','0')->get()->toArray();
        return view('admin.storeTobar.recive_stock_from_bar')->with(compact('getbarStock'));
    }

    public function TransferBarToStoreStockLog()
    {
       
        $RecivceLogBarToStore = TransferBarToStoreStock::with('product')->get()->toArray(); 
       return view('admin.storeTobar.recive_log_from_bar')->with(compact('RecivceLogBarToStore'));
    }

    public function TransferKitchenToStoreStock(Request $request)
    {

       
                    if ($request->isMethod('post')) {
                        $data = $request->all();

                            foreach ($data['transferstoreroom'] as $key => $attribute) {
                                if (!empty($attribute)) {

                                    $update_vendor_tbl = KitchenProReceStock::where('product_id',$data['product_id'][$key])->where('consumption_qty','>=',$attribute)->first();
                                    if($update_vendor_tbl){

                                        $update_vendor_tbl->consumption_qty =$data['after_transfer_stock'][$key];
                                        $update_vendor_tbl->kitchen_stock_qty =$data['after_transfer_stock'][$key];
                                        $update_vendor_tbl->remark =$data['remark'][$key];
                                        $update_vendor_tbl->transferstoreroom =  $update_vendor_tbl->transferstoreroom + $data['transferstoreroom'][$key];
                                        $update_vendor_tbl->update();

                                    }else{

                                        $message = "Stock  Has Been Not Updated .Plz Enter Valid Number!";
                                        return redirect()->back()->with('error_message', $message);  

                                    }
                               

                                }

                            }
                            $message = "Stock  Has Been Updated!";
                            return redirect()->back()->with('success_message', $message);  
                    }
                    $getKitchenStock = KitchenProReceStock::with('unit','product')->where('consumption_qty','>','0')->get()->toArray();
        return view('admin.storeTokitchen.kitchn_transfer_storerromstock')->with(compact('getKitchenStock'));
    }

    public function ReviceStockTransferFromKitchen(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($request->product_id == null) {

                $notification = array(
                'message' => 'Sorry you do not have any item', 
                'alert-type' => 'error'
            );
            return redirect()->back( )->with($notification);

            } else {

                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {
                        $reciveBarStock = KitchenProReceStock::where('product_id', $attribute)->first();
                        $reciveBarStock->transferstoreroom = $reciveBarStock->transferstoreroom - $data['transferstoreroom'][$key];
                        $reciveBarStock->update();


                        $stockrevicehistrkt = new TransferKitchenToStoreStock;
                        $stockrevicehistrkt->transfer_stock = $data['transferstoreroom'][$key];
                        $stockrevicehistrkt->product_id = $data['product_id'][$key];
                        $stockrevicehistrkt->current_stock = $reciveBarStock['kitchen_stock_qty'] + $data['transferstoreroom'][$key];
                        $stockrevicehistrkt->remaing_stock_in_bar = $reciveBarStock['kitchen_stock_qty'] - $data['transferstoreroom'][$key];
                        $stockrevicehistrkt->remark = $reciveBarStock['remark'];
                        $stockrevicehistrkt->save();



                    }
                }

                foreach ($data['product_id'] as $key => $attribute) {
                    if (!empty($attribute)) {

                        $update_vendor_tbl = Ingredient::where('id', $attribute)->first();
                        $update_vendor_tbl->purchase_Wtstock = $update_vendor_tbl->purchase_Wtstock + $data['transferstoreroom'][$key];
                        $update_vendor_tbl->store_stock_qty = $update_vendor_tbl->purchase_Wtstock + $data['transferstoreroom'][$key];
                        $update_vendor_tbl->update();




                    }
                }

            }
    
      
          return redirect()->back()->with('success_message', 'Added Items!');
      }
      $getbarStock = KitchenProReceStock::with('product','unit')->where('transferstoreroom','>','0')->get()->toArray();
        return view('admin.storeTobar.recive_transfer_stock_from_kitchen')->with(compact('getbarStock'));
    }

    public function TransferKitchenToStoreStockLog()
    {
       
        $transferStoreRecivceLogBarToStore = TransferKitchenToStoreStock::with('product')->get()->toArray(); 
       return view('admin.storeTobar.transferkitchen_recive_log_from_store')->with(compact('transferStoreRecivceLogBarToStore'));
    }
              

}
