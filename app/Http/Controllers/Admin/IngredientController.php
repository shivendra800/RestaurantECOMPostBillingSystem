<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\KitchenProReceStock;
use App\Models\Unit;
use App\Models\Vendor;
use App\Models\VendorType;
use Illuminate\Database\QueryException;
use App\Models\KitchenStock;
use App\Models\PruchaseItem;

class IngredientController extends Controller
{
    public function IngredientIndex()
    {
       $ingredient = Ingredient::with('unit','Prodtype','vendor')->get()->toArray();
       $prodType = CategoryType::get()->toArray();
       return view('admin.ingredients.ingredient_list',compact('ingredient','prodType'));
    }

    public function InventoryStock()
    {
       $getinvtstk = Ingredient::with('unit','category','Prodtype','vendor')->orderBy('purchase_Wtstock', 'DESC')->get()->toArray();
       $prodType = CategoryType::get()->toArray();
         // dd($getinvtstk );
       return view('admin.ingredients.inventory_stock',compact('getinvtstk','prodType'));
    }
    public function AddEditIngredient(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $ingredient = new Ingredient;
          
            $message = "Ingredient Added Successfully!";
            if($request->isMethod('post')){
                $data = $request->all();
                $validated = $request->validate([

                   
                    'product_type_id'=>'required',
                    'ingredient_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:ingredients,ingredient_name,'.$id,
                    'unit_id'=>'required',
                    'min_qty'=>'required',
                     'type'=>'required',

    
                ]);

                $ingredient->product_type_id = $data['product_type_id'];
                $ingredient->ingredient_name = $data['ingredient_name'];
                $ingredient->unit_id = $data['unit_id'];
                $ingredient->min_qty = $data['min_qty'];
                 $ingredient->type = $data['type'];
                $ingredient->save();
                $lastid = DB::getPdo()->lastInsertId();
                
                $kitchenStockrecepro= new KitchenProReceStock;
                $kitchenStockrecepro->product_id = $lastid;
                $kitchenStockrecepro->unit_id = $data['unit_id'];
                $kitchenStockrecepro->save();
                return redirect('admin/ingredient')->with('success_message',$message);
            }
        }
        else{
            $title= "Edit";
            $ingredient = Ingredient::find($id);
          
            $message = "Ingredient Updated Successfully!";
            if($request->isMethod('post')){
                $data = $request->all();
                $validated = $request->validate([
                    'product_type_id'=>'required',
                    'ingredient_name' =>  'required|regex:/[a-zA-Z\s]+/|max:255|unique:ingredients,ingredient_name,'.$id,
                    'unit_id'=>'required',
                    'min_qty'=>'required',
                     'type'=>'required',

    
                ]);
                $ingredient->product_type_id = $data['product_type_id'];
                $ingredient->ingredient_name = $data['ingredient_name'];
                $ingredient->unit_id = $data['unit_id'];
                $ingredient->min_qty = $data['min_qty'];
                 $ingredient->type = $data['type'];
                $ingredient->save();

                $kitchenStockrecepro= KitchenProReceStock::where('product_id',$id)->first();
                $kitchenStockrecepro->product_id = $id;
                $kitchenStockrecepro->unit_id = $data['unit_id'];
                $kitchenStockrecepro->save();
                return redirect('admin/ingredient')->with('success_message',$message);
            }
        }

        $unit = Unit::where('status',1)->get()->toArray();
        $Vendor = Vendor::where('status',1)->get()->toArray();
        $prodType = CategoryType::get()->toArray();
        return view('admin.ingredients.add_edit_ingredient',compact('ingredient','title','unit','Vendor','prodType'));

    }

      public function IngredientDelete($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $purchseitem = PruchaseItem::where('prod_id',$id)->exists();
        $kitstock = KitchenStock::where('product_id',$id)->exists();
        try {
            if($purchseitem || $kitstock)
            {
                $message= "This  ingredient  (".$ingredient['ingredient_name'].") is used in another table   so can't delete it!";
            return redirect('/admin/ingredient')->with('error_message',$message);
 
            }else{
            $ingredient->delete();
            $KitchenProReceStock =KitchenProReceStock::where('product_id',$id)->delete();
            $message= "Your ingredient  (".$ingredient['ingredient_name'].") is Delete Successfully!";
            return redirect('/admin/ingredient')->with('success_message',$message);
            }
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/ingredient')->with('error_message',$message);
        }}   
    }

    public function ChangeIngredientStatus(Request $request)
    {
        $status_id=$request->get('status_id');

        $statuschange=DB::table('ingredients')
            ->where('id',$status_id)
            ->first();

        DB::table('ingredients')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/ingredient')->with('success_message',"Status updated Successfully!");
    }
    public function IngredientdeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("ingredients")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"ingredient Deleted successfully."]);
    }


    public function Serachprodtypewise(Request $request)
    {
       
           $ingredient = Ingredient::with('unit','Prodtype','vendor')->where('product_type_id',$request->product_name)->get()->toArray();
           $prodType = CategoryType::get()->toArray();
           return view('admin.ingredients.ingredient_list',compact('ingredient','prodType'));
    }
    
     public function Serachprodtypewises(Request $request)
    {

           $getinvtstk = Ingredient::with('unit','Prodtype','vendor')->where('product_type_id',$request->product_name)->get()->toArray();
           $prodType = CategoryType::get()->toArray();
           return view('admin.ingredients.inventory_stock',compact('getinvtstk','prodType'));
    }
      public function GetInvPurchaseProductList(Request $request)
    {
            $getpurchaseItem = \App\Models\PruchaseItem::with('product','unit')->latest()->get()->toArray();
        return view('admin.purchaseinvPrdoucts.get_purchase_item_list',compact('getpurchaseItem'));

    }
}
