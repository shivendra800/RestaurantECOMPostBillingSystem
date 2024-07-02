<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Ingredient;

use function Pest\Laravel\post;

class CategoryController extends Controller
{
    
    public function categorytypeIndex()
    {
        $CType = CategoryType::get()->toArray();
        return view('admin.categories.category_type_list',compact('CType'));
    }

    public function AddEditCType(Request $request,$id=null)
    {
       if($id== "")
       {
        $title = "Add";
        $CType = new CategoryType;
        $message = "Product Type is added Successfully! ";
        
       }else{
        $title = "Edit";
        $CType= CategoryType::find($id);
        $message = "Product Type is updated successfully!";

       }

       if($request->isMethod('post'))
       {
        $data = $request->all();
       
        $validated = $request->validate([
            'c_type' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:category_types,c_type,'.$id,
        ]);

        $CType->c_type = $data['c_type'];
        $CType->slug = str_replace(' ', '-', $data['c_type']);
        $CType->status=1;
        $CType->save();
       
       
        return redirect('admin/category-type')->with('success_message',$message);

       }
       return view('admin.categories.add_edit_category_type',compact('title','CType'));
    }

     public function categorytypeDelete($id)
    {
        $vType = CategoryType::findOrFail($id);
        $getingredient = Ingredient::where('product_type_id',$id)->exists();
        try {
           
            if($getingredient)
            {
                $message= "This  Product Type  (".$vType['c_type'].") is used in another table   so can't delete it!";
            return redirect('/admin/category-type')->with('error_message',$message);
 
            }else{
                 $vType->delete();
            $message= "Your Product Type (".$vType['c_type'].") is Delete Successfully!";
            return redirect('/admin/category-type')->with('success_message',$message);
            }
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/category-type')->with('error_message',$message);
        }}   
    }


    public function CTypeStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('category_types')
            ->where('id',$status_id)
            ->first();

        DB::table('category_types')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/category-type')->with('success_message',"Status updated Successfully!");
    }

    public function deleteAllcategorytype(Request $request)
    {
        $ids = $request->ids;
        DB::table("category_types")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Categories Type Deleted successfully."]);
    }
// category ----------------------------------------------------------------------------------------------

public function categoryIndex()
{
    $category= Category::with('categorytype')->get()->toArray();
    return view('admin.categories.category_list')->with(compact('category'));
}

 public function AddEditCategory(Request $request, $id=null)
{
    if($id == ""){
        $title = "ADD";
        $category = new Category;
        $message = "Category Add Successfully!";
    }else{
        $title = "Edit";
        $category =  Category::find($id);
        $message = "Category Updated Successfully!";
          }
          if($request->isMethod('post')){
       
            $data = $request->all();
            $validated = $request->validate([
              
                'category_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:categories',
                'c_type_id'=>'required',
                                          
            ]);
            $category->category_name = $data['category_name'];
            $category->c_type_id = $data['c_type_id'];
            $category->slug = str_replace(' ', '-', $data['category_name']);
            $category->status=1;
            $category->save();

            return redirect('admin/category')->with('success_message',$message);
          }
          $CType= CategoryType::where('status',1)->get()->toArray();
          return view('admin.categories.add_edit_category')->with(compact('title','category','CType'));
    }
     
 

public function categoryDelete($id)
{
    $category = Category::findOrFail($id);
    try {
        $category->delete();
        $message= "Your Vendor  (".$category['category_name'].") is Delete Successfully!";
        return redirect('/admin/category')->with('success_message',$message);
    } catch (QueryException $e){
    if($e->getCode() == "23000"){
        $message= "data cant be deleted";
        return redirect('/admin/category')->with('error_message',$message);
    }}   
}

public function CategoryStatusChange(Request $request)
{
    
    $status_id=$request->get('status_id');

    $statuschange=DB::table('categories')
        ->where('id',$status_id)
        ->first();

    DB::table('categories')
    ->where('id',$status_id)
    ->update(array(
        'updated_at'=>date('Y-m-d H:i:s'),
        'status'=>$request->get('status')
    ));
    return redirect('admin/category')->with('success_message',"Status updated Successfully!");
}

public function deleteAllcategory(Request $request)
{
    $ids = $request->ids;
    DB::table("categories")->whereIn('id',explode(",",$ids))->delete();
    return response()->json(['success'=>"Products Deleted successfully."]);
}

}
