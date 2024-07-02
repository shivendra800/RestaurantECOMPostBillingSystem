<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\OrderWiseTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class TaxController extends Controller
{
    public function TaxIndex()
    {
        $taxList= Tax::all();
        return view('admin.taxs.tax_list')->with(compact('taxList'));
    }


    public function AddEditTax(Request $request,$id=null)
    {
        if($id==""){
            $title= "Add Tax";
            $taxList= new Tax;
            $message= "Your Tax Has been Add Successfully!";

        }else{
            $title= "Edit Tax";
            $taxList= Tax::find($id);
            $message= "Your Tax Has been Edit Successfully!";
        } 
           if($request->isMethod('post')){
            $data= $request->all();
            $validated = $request->validate([
                'tax_name' =>'required|regex:/[a-zA-Z\s]+/||unique:taxes,tax_name,'.$id,
                'tax_percentage'=>'required',
            ]);
                   
            $taxList->tax_name = $data['tax_name'];
            $taxList->tax_percentage = $data['tax_percentage'];
            $taxList->status = 1;
            $taxList->save();

            // DB::statement('Alter table restaurant_orders add ' . $data['tax_name'] . ' varchar(255) after sub_total');
            // DB::statement('Alter table take_way_orders add ' . $data['tax_name'] . ' varchar(255) after sub_total');

            return redirect('admin/tax')->with('success_message',$message);

           }
        return view('admin.taxs.add_edit_tax')->with(compact('taxList','title'));
    }

    public function TaxDelete($id)
    {
        $tax = Tax::findOrFail($id);
        try {
            $tax->delete();
            $message= "Your tax  (".$tax['tax_name'].") is Delete Successfully!";
            return redirect('/admin/tax')->with('success_message',$message);
        } catch (QueryException $e){
        if($e->getCode() == "23000"){
            $message= "data cant be deleted";
            return redirect('/admin/tax')->with('error_message',$message);
        }}   
    }

    public function TaxdeleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("taxes")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Tax Deleted successfully."]);
      
    }

    public function ChangeTaxStatus(Request $request)
    {
        $status_id=$request->get('status_id');

        $statuschange=DB::table('taxes')
            ->where('id',$status_id)
            ->first();

        DB::table('taxes')
        ->where('id',$status_id)
        ->update(array(
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>$request->get('status')
        ));
        return redirect('admin/tax')->with('success_message',"Status updated Successfully!");
    }


    public function TaxCollectionReport()
    {
        $ordertax= OrderWiseTax::latest()->get();

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
   

        $totalTaxOrdersale = OrderWiseTax::sum('tax_amount');
        $todayTaxsale = OrderWiseTax::whereDate('created_at',$todayDate)->sum('tax_amount');
        $MonthsTaxsale = OrderWiseTax::whereMonth('created_at',$thisMonth)->whereYear('created_at', $thisYear)->sum('tax_amount');
        $YearTaxsale = OrderWiseTax::whereYear('created_at', $thisYear)->sum('tax_amount');

        $totalTaxPercOrdersale = OrderWiseTax::sum('tax_percentage');
        $todayTaxPercsale = OrderWiseTax::whereDate('created_at',$todayDate)->sum('tax_percentage');
        $MonthsTaxPercsale = OrderWiseTax::whereMonth('created_at',$thisMonth)->whereYear('created_at', $thisYear)->sum('tax_percentage');
        $YearTaxPercsale = OrderWiseTax::whereYear('created_at', $thisYear)->sum('tax_percentage');


        $orderwiseTaxDateWise = OrderWiseTax::select(
            DB::raw("DATE(created_at) as DATE"),
            DB::raw("SUM(tax_amount) as tax_amount"),
            DB::raw("SUM(tax_percentage) as tax_percentage")
        )
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->orderBy(DB::raw("DATE(created_at)"))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        $resTaxday[] = ['DATE', 'Total Tax Amount', 'Total Tax Percentage'];
        foreach ($orderwiseTaxDateWise as $key => $val) {
            $resTaxday[++$key] = [$val->DATE, (int)$val->tax_amount, (int)$val->tax_percentage];
        }
        $orderwiseTaxMonthWise = OrderWiseTax::select(
            DB::raw("MONTHNAME(created_at) as MONTHNAME"),
            DB::raw("SUM(tax_amount) as tax_amount"),
            DB::raw("SUM(tax_percentage) as tax_percentage")
        )
            ->whereYear('created_at', date('Y'))
            ->orderBy(DB::raw("MONTHNAME(created_at)"))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->get();

        $resTaxMonth[] = ['MONTHNAME', 'Total Tax Amount', 'Total Tax Percentage'];
        foreach ($orderwiseTaxMonthWise as $key => $val) {
            $resTaxMonth[++$key] = [$val->MONTHNAME, (int)$val->tax_amount, (int)$val->tax_percentage];
        }

        $orderwiseTaxYearWise = OrderWiseTax::select(
            DB::raw("year(created_at) as year"),
            DB::raw("SUM(tax_amount) as tax_amount"),
            DB::raw("SUM(tax_percentage) as tax_percentage")
        )
            ->orderBy(DB::raw("Year(created_at)"))
            ->groupBy(DB::raw("Year(created_at)"))
            ->get();

        $resTaxYear[] = ['Year', 'Total Tax Amount', 'Total Tax Percentage'];
        foreach ($orderwiseTaxYearWise as $key => $val) {
            $resTaxYear[++$key] = [$val->year, (int)$val->tax_amount, (int)$val->tax_percentage];
        }

        return view('admin.taxs.order_wise_tax_list')->with(compact('ordertax','totalTaxOrdersale','todayTaxsale','MonthsTaxsale',
                  'totalTaxPercOrdersale','todayTaxPercsale','MonthsTaxPercsale','YearTaxPercsale','YearTaxsale'))->with('orderwiseTaxDateWise', json_encode($resTaxday))->with('orderwiseTaxMonthWise', json_encode($resTaxMonth))
                  ->with('orderwiseTaxYearWise', json_encode($resTaxYear));
    }
}
