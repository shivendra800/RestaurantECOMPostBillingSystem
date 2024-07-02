@extends('admin.layouts.layout')
@section('title','Defect Menu Item')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> {{Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        <div class="row mb-2">

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Defect Menu Item List</li>
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

                
                  <!-- /.card -->
                  <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="form-group bg-warning p-2">
                                    <label>Over All Item Defect & Total Amount</label>
                                    <br>
                                     <strong class="text-center bg-danger p-1">Item Defect::-{{ $totalTableBookingAmt }}</strong><br>
                                     <strong class="text-center bg-danger p-1">Defect Amount::- {{ $totalTabdefectAmt }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="form-group bg-warning p-2">
                                    <label>Today  Item Defect & Total Amount</label>
                                    <br>
                                     <strong class="text-center bg-danger p-1">Item Defect::-{{ $todayOrderitemAmt }}</strong><br>
                                     <strong class="text-center bg-danger p-1">Defect Amount::- {{ $todaydefectAmt }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card text-center">
                          <div class="card-body">
                              <div class="form-group bg-warning p-2">
                                  <label>This Month Item Defect & Total Amount</label>
                                  <br>
                                  <strong class="text-center bg-danger p-1">Item Defect::-{{ $MonthsOrderitemAmt }}</strong><br>
                                  <strong class="text-center bg-danger p-1">Defect Amount::- {{ $MonthsdefectAmt }}</strong>
                                  
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="form-group bg-warning p-2">
                                <label>This Year Item Defect & Total Amount</label>
                                <br>
                                <strong class="text-center bg-danger p-1">Item Defect::-{{ $YearOrderitemAmt }}</strong><br>
                                <strong class="text-center bg-danger p-1">Defect Amount::- {{ $YeardefectAmt }}</strong>
                                
                            </div>
                        </div>
                    </div>
                </div>
                </div>



             
                <!-- /.card -->
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Defect Menu Item List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                   <th>Order Type</th>
                                    <th>Order No.</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Item Buy Qty</th>
                                     <th>Order Item Status</th>
                                     <th>Replace Remark</th>
                                    <th>Item Order Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              
                                @foreach ($itemfreelist as $index=>$itemcoupon)
                                    <tr id="tr_{{$itemcoupon['id']}}">
                                     
                                    <td>{{$index+1}}</td>
                                    <td>{{ $itemcoupon['order_no'] }}</td>
                                    <td>{{ $itemcoupon['menuitem']['menu_item_name'] }}</td>
                                    <td class="text-danger">{{ $itemcoupon['price'] }}</td>
                                    <td>{{ $itemcoupon['item_qty'] }} Item <p class="badge badge-danger">Buy</p></td>
                                    <td class="text-danger">{{ $itemcoupon['order_item_status'] }}</td>                  
                                    <td class="text-danger">{{ $itemcoupon['order_waste_remark']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($itemcoupon->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
            
                                        
                                    
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
