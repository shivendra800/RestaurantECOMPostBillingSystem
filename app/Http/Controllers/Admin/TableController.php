<?php

namespace App\Http\Controllers\Admin;

use App\Models\Table;
use App\Models\BarTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BarTableChair;
use App\Models\RestaurantOrder;
use Illuminate\Database\QueryException;

class TableController extends Controller
{
    public function TableIndex()
    {
        $tableList = Table::get()->toArray();
        return view('admin.tables.tables_list',compact('tableList'));
    }

    public function AddEditTable(Request $request,$id=null)
    {
        DB::commit();
       if($id== "")
       {
        $title = "Add Table";
        $tableList = new Table;
        $message = "Table is added Successfully! ";
        
       }else{
        $title = "Edit Table";
        $tableList= Table::find($id);
        $message = "Table is updated successfully!";

       }

       if($request->isMethod('post'))
       {
        $data = $request->all();
       
        $validated = $request->validate([
            // 'table_type'=>'required|unique:tables,table_type,'.$id,
            'table_type'=>'required|',
            'table_capacity'=>'required',
            'table_name'=>'required',
        ]);

        $tableList->table_type = $data['table_type'];
        $tableList->table_capacity = $data['table_capacity'];
        $tableList->table_name = $data['table_name'];
        $tableList->save();
       
        DB::commit();
        return redirect('admin/table')->with('success_message',$message);

       }
       return view('admin.tables.add_edit_tables',compact('title','tableList'));
    }

    public function TableDelete($id)
    {
        $vType = Table::findOrFail($id);
        $getOderItem = RestaurantOrder::where('table_id',$id)->exists();
        try {
            if($getOderItem)
            {
                $message= "This  Table  (".$vType['table_type'].") is used in another table   so can't delete it!";
            return redirect('/admin/table')->with('error_message',$message);
 
            }else{
            $vType->delete();
            $message= "Your Table (".$vType['table_type'].") is Delete Successfully!";
            return redirect('/admin/table')->with('success_message',$message);
            }
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/table')->with('error_message',$message);
        }}   
    }

    public function TableStatusChange(Request $request)
    {
        
        $status_id=$request->get('status_id');

        $statuschange=DB::table('tables')
            ->where('id',$status_id)
            ->first();

        DB::table('tables')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/table')->with('success_message',"Status updated Successfully!");
    }

    public function TabledeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("tables")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"tables  Deleted successfully."]);
    }

    // bar table chairs

    public function BarTableIndex()
    {
        $tableList = BarTable::get()->toArray();
        return view('admin.tables.bartables_list',compact('tableList'));
    }

    public function AddEditBarTable(Request $request,$id=null)
    {
        DB::commit();
       if($id== "")
       {
        $title = "Add Bar Table";
        $tableList = new BarTable;
        $message = "Bar Table is added Successfully! ";
        
       }else{
        $title = "Edit Bar Table";
        $tableList= BarTable::find($id);
        $message = "Bar Table is updated successfully!";

       }

       if($request->isMethod('post'))
       {
        $data = $request->all();
       
        $validated = $request->validate([
            'table_name'=>'required|unique:bar_tables,table_name,'.$id,
            'total_chair'=>'required',
        ]);

        $tableList->table_name = $data['table_name'];
        $tableList->total_chair = $data['total_chair'];
        $tableList->save();
       
        DB::commit();
        return redirect('admin/bartable')->with('success_message',$message);

       }
       return view('admin.tables.add_edit_bartables',compact('title','tableList'));
    }

    public function BarTableDelete($id)
    {
        $vType = BarTable::findOrFail($id);
      
        try {
            $getchair = BarTableChair::where('table_id',$id)->delete();
            $vType->delete();
           
            $message= "Your Bar   (".$vType['table_name'].") is Delete Successfully!";
            return redirect('/admin/bartable')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/bartable')->with('error_message',$message);
        }}   
    }


    public function AddBarChairTablwWise(Request $request ,$bartableid)
    {

        $getbartable = BarTable::where('id',$bartableid)->first()->toArray();
        if ($request->isMethod('post')) {
            $data = $request->all();
        
            foreach ($data['chair_name'] as $key => $value) {
                if (!empty($value)) {               

                    $attribute = new BarTableChair;
                    $attribute->table_id = $bartableid;
                    $attribute->chair_name = $data['chair_name'][$key];
                    $attribute->save();                 
                }
            }
            return redirect()->back()->with('success_message', 'Table Wise  Chair Add Successfully!');
        }

           $getallChair = BarTableChair::with('bartablename')->where('table_id',$bartableid)->get()->toArray();
        return view('admin.tables.add_view_barTableWiseChair',compact('getbartable','getallChair'));
    }

    public function BarTableWiseChairDelete($id)
    {
       
        $vType = BarTableChair::findOrFail($id);
        try {
            $vType->delete();
            $message= "Your Bar Table Wise  (".$vType['chair_name'].") is Delete Successfully!";
            return redirect()->back()->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/bartable')->with('error_message',$message);
        }}   
    }




}
