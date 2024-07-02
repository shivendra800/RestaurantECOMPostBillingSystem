<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Ingredient;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Models\MenuItemPrice;
use App\Models\MenuSubCategory;
use App\Models\MenuItemMultiImg;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MenuItemConfiguration;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class MenuItemPriceController extends Controller
{

    // Restaurant Menu Item Start----------------------------------------------------------------------------------------------
    public function MenuItemPriceIndex()
    {
        $title = "Menu Item Price";
        $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','restaurant-menu')->get()->toArray();
        return view('admin.menuitemprices.menu_item_price_list',compact('menuitemPrice','title'));
    }

    public function AddEditMenuItemPrice(Request $request,$id=null)
    {
      
       if($id== "")
       {
        $title = "Add";
        $menuitemPrice = new MenuItemPrice;
        $message = " Rest Menu Item Price & Name  is added Successfully! ";
        
       }else{
        $title = "Edit";
        $menuitemPrice= MenuItemPrice::find($id);
        $message = "Menu Item Price & Name  is updated successfully!";

       }

       if($request->isMethod('post'))
       {
        $data = $request->all();
       
        $validated = $request->validate([
            'menu_item_name' =>'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_item_prices,menu_item_name,'.$id,
            'menu_item_code' =>'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_item_prices,menu_item_code,'.$id,
            'menu_subcat_id' =>'required',
            'menu_item_price'=>'required',
            'description'=>'required',
            'menu_item_image' => 'mimetypes:image/jpeg,image/png,image/jpg',
            'buying_price'=>'required',
            
        ]);
        if ($request->hasFile('menu_item_image')) {
            $image_tmp = $request->file('menu_item_image');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'front_assets/menu_item_image/' . $imageName;
                Image::make($image_tmp)->save($imagePath);
                $menuitemPrice->menu_item_image = $imageName;
            }
        } elseif (!empty($data['current_menu_item_image'])) {
            $imageName = $data['current_menu_item_image'];
        } else {
            $imageName = "";
        }
        $menuitemPrice->menu_cat_id = 0;
        $menuitemPrice->type = "restaurant-menu";
        $menuitemPrice->menu_subcat_id = $data['menu_subcat_id'];
        $menuitemPrice->menu_item_code = $data['menu_item_code'];
        $menuitemPrice->menu_item_name = $data['menu_item_name'];
        $menuitemPrice->buying_price = $data['buying_price'];
        $menuitemPrice->menu_item_price = $data['menu_item_price'];
        $menuitemPrice->description = $data['description'];
        $menuitemPrice->save();
        return redirect('admin/menu-item-price')->with('success_message',$message);
       }
       $menuCatList= MenuSubCategory::where('status',1)->where('rest_type','restaurant-menu')->get()->toArray();
       return view('admin.menuitemprices.add_edit_menu_menu_item_price',compact('title','menuitemPrice','menuCatList'));
    }

     public function MenuItemPriceDelete($id)
    {
        $menuCatList = MenuItemPrice::findOrFail($id);
        $getOderItem = Orderitem::where('item_id',$id)->exists();
        $getTakeWayOrderItem = TakeWayOrderitem::where('item_id',$id)->exists();
        try {
            if($getOderItem || $getTakeWayOrderItem)
            {
               
                $message= "This  Item  (".$menuCatList['menu_item_name'].") is used in another table   so can't delete it!";
                return redirect('/admin/menu-item-price')->with('error_message',$message);

            }else{
                $menuCatList->delete();
                $message= "Your Menu Item (".$menuCatList['menu_item_name'].") is Delete Successfully!";
                return redirect('/admin/menu-item-price')->with('success_message',$message);
            }
          
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/menu-item-price')->with('error_message',$message);
        }}   
    }

    public function MenuItemPriceStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('menu_item_prices')
            ->where('id',$status_id)
            ->first();

        DB::table('menu_item_prices')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
         if(Auth::guard('admin')->user()->type == 'Kitchen-Manager'){
            return redirect()->back()->with('success_message',"Status updated Successfully!");
        }else{

            return redirect('admin/menu-item-price')->with('success_message',"Status updated Successfully!");
        }
    }

    public function deleteAllMenuItemPrice(Request $request)
    {
        $ids = $request->ids;
        DB::table("menu_item_prices")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Menu Item  Deleted successfully."]);
    }
    public function MenuPriceModify()
    {
        
        $title = "Menu Item Price";
        $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','restaurant-menu')->get()->toArray();
        return view('admin.menuitemprices.menu_price_modify')->with(compact('title','menuitemPrice'));
    }
    public function MenuPriceModifyall(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['id'] as $key => $attribute) {
                if (!empty($attribute)) {
                    $update_vendor_tbl = MenuItemPrice::where('id',$attribute)->first();
                    $update_vendor_tbl->menu_item_price =  $data['menu_item_price'][$key];
                    $update_vendor_tbl->update();
                }
            }
        
            return redirect()->back()->with('success_message', 'product price has bben updated Successfully!');
        }
    }

    public function MenuConfiguration(Request $request,$id)
    {
        $getsingleitem = MenuItemPrice::where('id', $id)->first();

        if($request->isMethod('post')){
            $data = $request->all();

            foreach ($data['use_weight'] as $key => $attribute) {
                if (!empty($attribute)) {

                    $CheckExist = MenuItemConfiguration ::where('menu_item_id', $id)->where('ingredient_id', $data['ingredient_id'][$key])->count();
                      if($CheckExist>0)
                      {
                        $menuitemConfirg =  MenuItemConfiguration::where('menu_item_id', $id)->where('ingredient_id', $data['ingredient_id'][$key])->first();
                        $menuitemConfirg->menu_item_id = $id;
                        $menuitemConfirg->ingredient_id = $data['ingredient_id'][$key];
                        $menuitemConfirg->unit_id = $data['unit_id'][$key];
                        $menuitemConfirg->use_weight = $data['use_weight'][$key];
                        $menuitemConfirg->outputKilograms = $data['outputKilograms'][$key];
                        $menuitemConfirg->outputLiters = $data['outputLiters'][$key];
                        $menuitemConfirg->size_per = $data['size_per'][$key];
                        $menuitemConfirg->rate_per = $data['rate_per'][$key];
                        $menuitemConfirg->amount = $data['amount'][$key];
                        $menuitemConfirg->save();
                      }else{
                        $menuitemConfirg = new MenuItemConfiguration;
                        $menuitemConfirg->menu_item_id = $id;
                        $menuitemConfirg->ingredient_id = $data['ingredient_id'][$key];
                        $menuitemConfirg->unit_id = $data['unit_id'][$key];
                        $menuitemConfirg->use_weight = $data['use_weight'][$key];
                        $menuitemConfirg->outputKilograms = $data['outputKilograms'][$key];
                        $menuitemConfirg->outputLiters = $data['outputLiters'][$key];
                        $menuitemConfirg->size_per = $data['size_per'][$key];
                        $menuitemConfirg->rate_per = $data['rate_per'][$key];
                        $menuitemConfirg->amount = $data['amount'][$key];
                        $menuitemConfirg->save();
                      }
                   
                    
                }
            }
    
             
       
               $notification = array(
                   'message' =>" Ingredient  Has Been  Assign To Menu Item   Successfully!",
                   'alert-type' =>'success'
               );
       
               return redirect()->back()->with($notification);
    
           }
        $getingredientbar = Ingredient::with('unit')->where('type','Bar-Product')->get()->toArray();
        $getingredientrest = Ingredient::with('unit')->where('type','Restaurant-Product')->get()->toArray();
        $getunit = Unit::get();
        $getmenuItemConfig = MenuItemConfiguration::with('getproduct')->where('menu_item_id', $id)->get();
        return view('admin.menuitemprices.get_menu_confirg',compact('getsingleitem','getingredientbar','getingredientrest','getunit','getmenuItemConfig'));
    }


    public function MenuItemConfirlistDelete($id)
    {
        $menuCatList = MenuItemConfiguration::findOrFail($id);
        try {
            $menuCatList->delete();
            $notification = array(
                'message' =>" Ingredient  Has Been Delete From Menu Ingredient   Successfully!",
                'alert-type' =>'success'
            );
            return redirect()->back()->with($notification);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect()->back()->with('error_message',$message);
        }}   
    }



    public function deleteAllMenuItemConfirlist(Request $request)
    {
        $ids = $request->ids;
        DB::table("menu_item_configurations")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Menu Item Confirlist  Deleted successfully."]);
    }


   

    public function AddImage(Request $request, $id)
    {
     
   $menuitemget = MenuItemPrice::select('id', 'menu_item_name', 'menu_item_code',  'menu_item_price','menu_subcat_id', 'menu_item_image')->find($id);
        //   $menuitemget=json_decode(json_encode($menuitemget),true);
        // dd($menuitemget);
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                //  echo"<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {

                    $image_tmp = Image::make($image);

                    $image_name = $image->getClientOriginalName();
                    //Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    //Generate New Image After resize
                    $imageName = $image_name . rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front_assets/menu_item_image/large/' . $imageName;
                    $smallImagePath = 'front_assets/menu_item_image/small/' . $imageName;
                    //Upload The Large,Medium Small Images after resize
                    Image::make($image_tmp)->resize(500, 500)->save($largeImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    $image = new MenuItemMultiImg;
                    $image->image = $imageName;
                    $image->menu_item_id = $id;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message', 'Menu Item Image has been Updated successfully!');
        }

        $getMultiimgitem = MenuItemMultiImg::where('menu_item_id', $id)->get();

        return view('admin.menuitemprices.add_images')->with(compact('menuitemget','getMultiimgitem'));
    }

    public function DeleteImage($id)
    {
        MenuItemMultiImg::where('id', $id)->delete();
        $message = "Menu Item Image has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    // Restaurant Menu Item End----------------------------------------------------------------------------------------------

 //Bar item start here
 public function BarMenuItemPriceIndex()
 {
     $title = " Bar Menu Item ";
     $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','bar-menu')->get()->toArray();
     return view('admin.menuitemprices.barmenu_item_price_list',compact('menuitemPrice','title'));
 }

 public function AddEditBarMenuItemPrice(Request $request,$id=null)
 {
   
    if($id== "")
    {
     $title = "Add";
     $menuitemPrice = new MenuItemPrice;
     $message = "Bar Menu Item Price & Name  is added Successfully! ";
     
    }else{
     $title = "Edit";
     $menuitemPrice= MenuItemPrice::find($id);
     $message = "Bar Menu Item Price & Name  is updated successfully!";

    }

    if($request->isMethod('post'))
    {
     $data = $request->all();
    
     $validated = $request->validate([
         'menu_item_name' =>'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_item_prices,menu_item_name,'.$id,
         'menu_item_code' =>'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_item_prices,menu_item_code,'.$id,
         'menu_subcat_id' =>'required',
         'menu_item_price'=>'required',
         'description'=>'required',
         'bar_unit'=>'required',
         'menu_item_image' => 'mimetypes:image/jpeg,image/png,image/jpg',
         'buying_price'=>'required',
         'bar_item_tax_type'=>'required'
     ]);
     
     if ($request->hasFile('menu_item_image')) {
         $image_tmp = $request->file('menu_item_image');
         if ($image_tmp->isValid()) {
             $extension = $image_tmp->getClientOriginalExtension();
             $imageName = rand(111, 99999) . '.' . $extension;
             $imagePath = 'front_assets/menu_item_image/' . $imageName;
             Image::make($image_tmp)->save($imagePath);
             $menuitemPrice->menu_item_image = $imageName;
         }
     } elseif (!empty($data['current_menu_item_image'])) {
         $imageName = $data['current_menu_item_image'];
     } else {
         $imageName = "";
     }
     $menuitemPrice->menu_cat_id = 0;
     $menuitemPrice->menu_subcat_id = $data['menu_subcat_id'];
     $menuitemPrice->menu_item_code = $data['menu_item_code'];
     $menuitemPrice->menu_item_name = $data['menu_item_name'];
     $menuitemPrice->menu_item_price = $data['menu_item_price'];
     $menuitemPrice->buying_price = $data['buying_price'];
     $menuitemPrice->description = $data['description'];
     $menuitemPrice->type = "bar-menu";
     $menuitemPrice->bar_unit = $data['bar_unit'];
     $menuitemPrice->bar_item_tax_type = $data['bar_item_tax_type'];
     if($data['bar_item_tax_type']=="Alcoholics")
     {
           $menuitemPrice->bar_tax_percentage = $data['bar_tax_percentage'];
     }
       if($data['bar_item_tax_type']=="Non-Alcoholics")
     {
           $menuitemPrice->bar_tax_percentage = 0;
     }
   
     $menuitemPrice->save();
     return redirect('admin/bar-menu-item-price')->with('success_message',$message);
    }
    $menuCatList= MenuSubCategory::where('status',1)->where('rest_type','bar-menu')->get()->toArray();
    return view('admin.menuitemprices.add_edit_barmenu_menu_item_price',compact('title','menuitemPrice','menuCatList'));
 }

 public function BarMenuItemPriceDelete($id)
 {
     $menuCatList = MenuItemPrice::where('type','bar-menu')->where('id',$id)->first();
     $getOderItem = Orderitem::where('item_id',$id)->exists();
     $getTakeWayOrderItem = TakeWayOrderitem::where('item_id',$id)->exists();
     try {
        if($getOderItem || $getTakeWayOrderItem)
        {
           
            $message= "This  Item  (".$menuCatList['menu_item_name'].") is used in another table   so can't delete it!";
            return redirect('/admin/bar-menu-item-price')->with('error_message',$message);

        }else{
         $menuCatList->delete();
         $message= "Your Bar Menu Item (".$menuCatList['menu_item_name'].") is Delete Successfully!";
         return redirect('/admin/bar-menu-item-price')->with('success_message',$message);
        }
     } catch (QueryException $e){
     if($e->getCode() == "23000"){
         $message= "data cant be deleted";
         return redirect('/admin/bar-menu-item-price')->with('error_message',$message);
     }}   
 }

 public function BarMenuItemPriceStatusChange(Request $request)
 {
     
     $status_id=$request->get('status_id');

     $statuschange=DB::table('menu_item_prices')
         ->where('id',$status_id)
         ->first();

     DB::table('menu_item_prices')
     ->where('id',$status_id)
     ->update(array(
         'updated_at'=>date('Y-m-d H:i:s'),
         'status'=>$request->get('status')
     ));
     return redirect('admin/bar-menu-item-price')->with('success_message',"Status updated Successfully!");
 }

 public function deleteAllBarMenuItemPrice(Request $request)
 {
     $ids = $request->ids;
     DB::table("menu_item_prices")->where('type','bar-menu')->whereIn('id',explode(",",$ids))->delete();
     return response()->json(['success'=>"Restaurant Menu Item  Deleted successfully."]);
 }
 public function BarMenuPriceModify()
 {
     
     $title = "Bar Menu Item Price";
     $menuitemPrice = MenuItemPrice::with('menuCategory','menusubCategory')->where('type','bar-menu')->get()->toArray();
     return view('admin.menuitemprices.barmenu_price_modify')->with(compact('title','menuitemPrice'));
 }
 public function BarMenuPriceModifyall(Request $request)
 {
     if ($request->isMethod('post')) {
         $data = $request->all();

         foreach ($data['id'] as $key => $attribute) {
             if (!empty($attribute)) {
                 $update_vendor_tbl = MenuItemPrice::where('id',$attribute)->first();
                 $update_vendor_tbl->menu_item_price =  $data['menu_item_price'][$key];
                 $update_vendor_tbl->update();
             }
         }
     
         return redirect()->back()->with('success_message', 'Bar Item price has been updated Successfully!');
     }
 }



//Bar menu item end here

   
}
