<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class UnitController extends Controller
{
    public function unitIndex()
    {
       $unit = Unit::get()->toArray();
       return view('admin.units.unit_list',compact('unit'));
    }
    public function AddEditUnit(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $unit = new Unit;
            $message = "Unit Added Successfully!";
        }
        else{
            $title= "Edit";
            $unit = Unit::find($id);
            $message = "Unit Updated Successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([

                'unit_name' => 'required|regex:/[a-zA-Z\s]+/|max:255|unique:units,unit_name,'.$id

            ]);
            $unit->unit_name = $data['unit_name'];
            $unit->save();
            return redirect('admin/unit')->with('success_message',$message);
        }
        return view('admin.units.add_edit_unit',compact('unit','title'));

    }

    public function UnitDelete($id)
    {
        $unit = Unit::findOrFail($id);
        try {
            $unit->delete();
            $message= "Your unit  (".$unit['unit_name'].") is Delete Successfully!";
            return redirect('/admin/unit')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/unit')->with('error_message',$message);
        }}   
    }

    public function ChangeUnitStatus(Request $request)
    {
        $status_id=$request->get('status_id');

        $statuschange=DB::table('units')
            ->where('id',$status_id)
            ->first();

        DB::table('units')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/unit')->with('success_message',"Status updated Successfully!");
    }
    public function UnitdeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("units")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Unit Deleted successfully."]);
    }
}
