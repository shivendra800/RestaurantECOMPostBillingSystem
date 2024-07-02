<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExtraMenu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Models\MenuSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use App\Models\MenuItemPrice;

class MenuCategoryController extends Controller
{

// Restaurant Menu category Start----------------------------------------------------------------------------------------------

public function MenuSubCategoryIndex()
{
    $menSubcategory= MenuSubCategory::where('rest_type','restaurant-menu')->get()->toArray();
    return view('admin.menucategories.menu_subcategory')->with(compact('menSubcategory'));
}

 public function AddEditMenuSubCategory(Request $request, $id=null)
{
    if($id == ""){
        $title = "ADD";
        $menSubcategory = new MenuSubCategory;
        $message = "Restaurant Menu  Add Successfully!";
    }else{
        $title = "Edit";
        $menSubcategory =  MenuSubCategory::find($id);
        $message = " Restaurant Menu  Updated Successfully!";
          }
          if($request->isMethod('post')){
       
            $data = $request->all();
            $validated = $request->validate([


                 'menu_subcat_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_sub_categories,menu_subcat_name,'.$id,
                 'menu_image' => 'mimetypes:image/jpeg,image/png,image/jpg',
                                          
            ]);
            if ($request->hasFile('menu_image')) {
                $image_tmp = $request->file('menu_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front_assets/menu_img/' . $imageName;
                    Image::make($image_tmp)->save($imagePath);
                    $menSubcategory->menu_image = $imageName;
                }
            } elseif (!empty($data['current_menu_img'])) {
                $imageName = $data['current_menu_img'];
            } else {
                $imageName = "";
            }
            $menSubcategory->rest_type = "restaurant-menu";
            $menSubcategory->menu_subcat_name = $data['menu_subcat_name'];
            $menSubcategory->slug = str_replace(' ', '-', $data['menu_subcat_name']);
            $menSubcategory->save();

            return redirect('admin/menu-subcategory')->with('success_message',$message);
          }
          return view('admin.menucategories.add_edit_menu_subcategory')->with(compact('title','menSubcategory'));
    }
     
 

public function MenuSubCategoryDelete($id)
{
    $menSubcategory = MenuSubCategory::findOrFail($id);
    $menuitemlist = MenuItemPrice::where('menu_subcat_id',$id)->exists();
    try {
        if($menuitemlist)
        {
           
            $message= "This  Subcategory  (".$menSubcategory['menu_subcat_name'].") is used in another table   so can't delete it!";
            return redirect('/admin/menu-subcategory')->with('error_message',$message);

        }else{
        $menSubcategory->delete();
        $message= "Your   (".$menSubcategory['menu_subcat_name'].") is Delete Successfully!";
        return redirect('/admin/menu-subcategory')->with('success_message',$message);
        }
    } catch (QueryException $e){
    if($e->getCode() == "23000"){
        $message= "data cant be deleted";
        return redirect('/admin/menu-subcategory')->with('error_message',$message);
    }}   
}

public function MenuSubCategoryStatusChange(Request $request)
{
    
    $status_id=$request->get('status_id');

    $statuschange=DB::table('menu_sub_categories')
        ->where('id',$status_id)
        ->first();

    DB::table('menu_sub_categories')
    ->where('id',$status_id)
    ->update(array(
        'updated_at'=>date('Y-m-d H:i:s'),
        'status'=>$request->get('status')
    ));
    return redirect('admin/menu-subcategory')->with('success_message',"Status updated Successfully!");
}

public function deleteAllMenuSubCategory(Request $request)
{
    $ids = $request->ids;
    DB::table("menu_sub_categories")->whereIn('id',explode(",",$ids))->delete();
    return response()->json(['success'=>"Menu Subcategory All Items Deleted successfully."]);
}

// Restaurant Menu category End----------------------------------------------------------------------------------------------

// Bar Menu category Start----------------------------------------------------------------------------------------------

public function BarMenuSubCategoryIndex()
{
    $menSubcategory= MenuSubCategory::where('rest_type','bar-menu')->get()->toArray();
    return view('admin.menucategories.bar_menu_subcategory')->with(compact('menSubcategory'));
}

 public function AddEditBarMenuSubCategory(Request $request, $id=null)
{
    if($id == ""){
        $title = "ADD Bar";
        $menSubcategory = new MenuSubCategory;
        $message = "Bar Menu  Add Successfully!";
    }else{
        $title = "Edit";
        $menSubcategory =  MenuSubCategory::find($id);
        $message = " Bar Menu  Updated Successfully!";
          }
          if($request->isMethod('post')){
       
            $data = $request->all();
            $validated = $request->validate([


                 'menu_subcat_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:menu_sub_categories,menu_subcat_name,'.$id,
                 'menu_image' => 'mimetypes:image/jpeg,image/png,image/jpg',
                                          
            ]);
            if ($request->hasFile('menu_image')) {
                $image_tmp = $request->file('menu_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front_assets/menu_img/' . $imageName;
                    Image::make($image_tmp)->save($imagePath);
                    $menSubcategory->menu_image = $imageName;
                }
            } elseif (!empty($data['current_menu_img'])) {
                $imageName = $data['current_menu_img'];
            } else {
                $imageName = "";
            }
            $menSubcategory->rest_type = "bar-menu";
            $menSubcategory->menu_subcat_name = $data['menu_subcat_name'];
            $menSubcategory->slug = str_replace(' ', '-', $data['menu_subcat_name']);
            $menSubcategory->save();

            return redirect('admin/bar-menu-subcategory')->with('success_message',$message);
          }
          return view('admin.menucategories.add_edit_barmenu_subcategory')->with(compact('title','menSubcategory'));
    }
     
 

public function BarMenuSubCategoryDelete($id)
{
    $menSubcategory = MenuSubCategory::findOrFail($id);
    $menuitemlist = MenuItemPrice::where('menu_subcat_id',$id)->exists();
    try {
        if($menuitemlist)
        {
           
            $message= "This  Subcategory  (".$menSubcategory['menu_subcat_name'].") is used in another table   so can't delete it!";
            return redirect('/admin/bar-menu-subcategory')->with('error_message',$message);

        }else{
        $menSubcategory->delete();
        $message= "Your   (".$menSubcategory['menu_subcat_name'].") is Delete Successfully!";
        return redirect('/admin/bar-menu-subcategory')->with('success_message',$message);
        }
    } catch (QueryException $e){
    if($e->getCode() == "23000"){
        $message= "data cant be deleted";
        return redirect('/admin/bar-menu-subcategory')->with('error_message',$message);
    }}   
}


public function BarMenuSubCategoryStatusChange(Request $request)
{
    
    $status_id=$request->get('status_id');

    $statuschange=DB::table('menu_sub_categories')
        ->where('id',$status_id)
        ->first();

    DB::table('menu_sub_categories')
    ->where('id',$status_id)
    ->update(array(
        'updated_at'=>date('Y-m-d H:i:s'),
        'status'=>$request->get('status')
    ));
    return redirect('admin/bar-menu-subcategory')->with('success_message',"Status updated Successfully!");
}

public function deleteAllBarMenuSubCategory(Request $request)
{
    $ids = $request->ids;
    DB::table("menu_sub_categories")->whereIn('id',explode(",",$ids))->delete();
    return response()->json(['success'=>"Bar Menu Subcategory All Items Deleted successfully."]);
}

// Bar Menu category End----------------------------------------------------------------------------------------------


public function ExtraMenuIndex()
    {
        $extramenuList = ExtraMenu::get()->toArray();
        return view('admin.menucategories.extramenu_list',compact('extramenuList'));
    }

    public function AddEditExtraMenu(Request $request,$id=null)
    {
       if($id== "")
       {
        $title = "Add";
        $extramenuList = new ExtraMenu;
        $message = " Extra Menu is added Successfully! ";
        
       }else{
        $title = "Edit";
        $extramenuList= ExtraMenu::find($id);
        $message = "Extra Menu is updated successfully!";

       }

       if($request->isMethod('post'))
       {
        $data = $request->all();
       
        $validated = $request->validate([
            'extra_menu' =>'required|regex:/[a-zA-Z\s]+/|max:255',
            'type' =>'required',
            'price' =>'required',
        ]);

        $extramenuList->extra_menu = $data['extra_menu'];
        $extramenuList->type = $data['type'];
        $extramenuList->price = $data['price'];
       
        $extramenuList->save();
        return redirect('admin/extra-menu')->with('success_message',$message);
       }
       return view('admin.menucategories.add_edit_extramenu',compact('title','extramenuList'));
    }

    public function ExtraMenuDelete($id)
    {

        $extramenuList = ExtraMenu::findOrFail($id);
        try {
            $extramenuList->delete();
            $message= "Extra Menu  (".$extramenuList['extra_menu'].") is Delete Successfully!";
            return redirect('/admin/extra-menu')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/extra-menu')->with('error_message',$message);
        }}   
    }

}
