@extends('admin.layouts.layout')
@section('title','View Capital Purchase Product')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Capital Purchased Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Capital Purchased Details</li>

                </ol>
            </div>



        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Capital Purchased Details</h3>
                        <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/capital-purchaseInvList') }}" class="btn btn-block btn-info">Back</a>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Capital Purchase  Information</h4><br>
                                <div class="form-group">
                                    <label>Vendor Type</label>
                                    <input class="form-control" value="{{ $ViewPurchaseProd['extvendor']['vendor_type'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Vendor Name</label>
                                    <input class="form-control" value="{{ $ViewPurchaseProd['extvendor']['vendor_name'] }}" readonly="">
                                </div>
                              
                                <div class="form-group">
                                    <label>Product Enter Date</label>
                                    <input class="form-control" value="{{ \Carbon\Carbon::parse($ViewPurchaseProd['created_at'])->isoFormat('MMM Do YYYY')}}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Inovice No</label>
                                    <input class="form-control" value="{{ $ViewPurchaseProd['invoice_id'] }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Capital Purchase Bill Information</h4><br>

                                <div class="form-group">
                                    <label>This Purchase Product Bill</label>
                                    <input class="form-control" value="Rs.{{ $ViewPurchaseProd['total_bill'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="Rs.{{ $ViewPurchaseProd['grand_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Paid Amount</label>
                                    <input class="form-control" value="Rs.{{ $ViewPurchaseProd['paid_amount'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Remaining Amount</label>
                                    <input class="form-control" value="Rs.{{ $ViewPurchaseProd['remaining_amount'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Previous Amount</label>
                                    <input class="form-control" value="Rs.{{ $ViewPurchaseProd['previous_amount'] }}" readonly="">
                                </div>
                            </div>

                        </div>

                       

                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Capital Purchase Product Item</h3>
                </div>
                <!-- /.card-header -->
                
                <div class="card-body">
                  <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                            aria-describedby="example1_info">
                    <thead>
                    <tr>
                     
                      <th>Purchase Invoice No </th>
                      <th>Product Name</th>                    
                      <th>Product Qty</th>
                      <th>Product Price</th>
                      <th>Product Amount</th>
                   
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewPurchaseitem as $item)
                             <tr>
                              
                                <td>{{ $item['invoice_id'] }}</td>
                                <td>{{ $item['extproduct']['ext_product_name'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rs.{{ $item['price'] }}</td>                              
                                <td>Rs.{{ $item['total_price'] }}</td>
                             </tr>
                           
                                               
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
@endsection
