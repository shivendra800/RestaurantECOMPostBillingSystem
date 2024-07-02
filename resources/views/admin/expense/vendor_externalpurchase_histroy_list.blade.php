@extends('admin.layouts.layout')
@section('title','Capital Vendor Purchase Product Payment Histroy List')

@section('content')

<section class="content-header">
    <div class="container-fluid">      
      <div class="row mb-2">
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Capital Vendor Purchase Product Payment  History List</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Capital Purchase Product Payment History List</h3>
              <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/expense-vendor') }}" class="btn btn-block btn-info">Back</a>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>

                  <th>ID</th>
                  <th>Invoice ID</th>
                  <th>Today Purchase Bill</th>
                  <th>Grand Total</th>
                  <th>Remaining Amount</th>
                  <th>Paid Amount</th>
                  <th>Previous Balance</th>
                  <th>Bill Generated Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseHist as $index=>$pHist)
                        <td>{{$index+1}}</td>
                        <td>{{$pHist['invoice_id']}}</td> 
                        <td>Rs.{{$pHist['total_billing']}}</td>  
                        <td>Rs.{{$pHist['grand_total']}}</td>                 
                        <td>Rs.{{$pHist['remaining_amount']}}</td>   
                        <td>Rs.{{$pHist['paid_amount']}}</td>   
                        <td>Rs.{{$pHist['previous_balance']}}</td>   
                        <td style="color:blue;">{{ \Carbon\Carbon::parse($pHist['created_at'])->isoFormat('MMM Do YYYY')}}</td>   
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection
