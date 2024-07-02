<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\BarTokenGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class GenrateTokentController extends Controller
{
    public function GenarateToken()
    {
        $gettokenList = BarTokenGenerate::latest()->get()->toarray();
        return view('admin.genarteToken.bar_token_list',compact('gettokenList'));
    }

    public function AddEditGenarateToken(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add";
            $genrateToken = new BarTokenGenerate;
            $message = " Added Successfully!";
        }
        else{
            $title= "Edit";
            $genrateToken = BarTokenGenerate::find($id);
            $message = " Updated Successfully!";
        }
       
        if($request->isMethod('post')){
            $data = $request->all();
            $validated = $request->validate([

                'token_amount' => 'required|numeric|gt:0',
                'payment_mode' => 'required',
                 'name' => 'required',
                  'mobile_no' => 'required|digits:10|numeric',
                //   'no_of_bill_print' => 'required',

            ]);
               #Store Unique Order/Product Number
               $unique_no = BarTokenGenerate::orderBy('id', 'DESC')->pluck('id')->first();
               if($unique_no == null or $unique_no == "") {
                   #If Table is Empty
                   $unique_no = 1;
               } else {
                   #If Table has Already some Data
                   $unique_no = $unique_no + 1;
               }
               $genrateToken->token_no = 'DUNKELBARTOKEN-' . $unique_no;
            $genrateToken->token_amount = $data['token_amount'];  
            
             $genrateToken->name = $data['name'];
              $genrateToken->mobile_no = $data['mobile_no'];
              
               $genrateToken->no_of_bill_print = 0;
              
                if (!empty($data['is_discount'])) {
                $genrateToken->is_discount = $data['is_discount'];
                $genrateToken->payment_mode = "D";
            } else {
                $genrateToken->is_discount = "No";
                $genrateToken->payment_mode = $data['payment_mode'];
            }
            $genrateToken->save();
            $getlastinsertedId = DB::getPdo()->lastInsertId();
            $notification = array(
                'message' => " Table Order Bill Created Successfully!",
                'alert-type' => 'success'
            );
                
           
             return redirect('admin/genaratetoken/' . $getlastinsertedId)->with($notification);
        }
        return view('admin.genarteToken.add_genarteToken',compact('genrateToken','title'));

    }

    public function GenarateTokenDelete($id)
    {
        $unit = BarTokenGenerate::findOrFail($id);
        try {
            $unit->delete();
            $message= " Delete Successfully!";
            return redirect('/admin/genarate-token')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/genarate-token')->with('error_message',$message);
        }}   
    }

    public function PrintGenarateToken($Tokenno)
    {
       
        $gettokenlist = BarTokenGenerate::where('id', $Tokenno)->first();
        $getsiteSetting = SiteSetting::first();
        return view('admin.genarteToken.print_token_view',compact('gettokenlist','getsiteSetting'));
    }
}
