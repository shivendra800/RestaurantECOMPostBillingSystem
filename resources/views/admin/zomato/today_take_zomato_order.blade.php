@extends('admin.layouts.layout')

@section('title','Today-Zomato-Order')

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
                    <li class="breadcrumb-item active">Today Zomato Order List</li>
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
                @if(Auth::guard('admin')->user()->type=='Admin')
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h2 class="btn btn-warning">Search Data Of Today Zomato Order</h2>
                        <div class="card-header">
                            <form action="{{ url('/admin/takeway-orders-SearchDateWsie') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="date" name="start_date" class="form-control" placeholder="Enter Start Date" value="{{ Request::get('start_date')  }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="end_date" class="form-control" placeholder="Enter End Date" value="{{ Request::get('end_date')  }}" required>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <button type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endif
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Over All Zomato Collection</label>
                                    <input class="form-control" value="{{ $overallcollectionwithGSt }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                          <div class="card-body">
                              <div class="form-group">
                                  <label>Over All Zomato  Tax Collection</label>
                                  <input class="form-control" value="{{ round($overallcollectionwithoutGSt,2) }} " readonly="">
                              </div>
                          </div>
                      </div>
                  </div>
                </div>


                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Today Zomato Order List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Order No</th>
                                    <th>Cust Name</th>
                                    <th>Sub Total</th>

                                    <th>Grand Total</th>
                                    <th>Order Status</th>
                                    <th>Kitchen Order Status</th>
                                    <th>Delivery Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($todayZomatoorderlist as $index=>$todayorder)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td>

                                        {{$todayorder['order_no']}}
                                        <br>
                                       ZomataoID- {{$todayorder['zomtao_order_id']}}


                                    </td>
                                    <td>
                                        {{$todayorder['cust_name']}}
                                    </td>
                                    <td>
                                        {{$todayorder['sub_total']}}
                                        <br>
                                        @if(!empty($todayorder['coupon_per']))
                                        <span class="text-success">Offer Apply: {{$todayorder['coupon_per']}}% Off </span>
                                        @endif
                                        <br>
                                        @if(!empty($todayorder['subtotalwithoffer']))
                                        <span class="text-danger">new-subtotal: {{$todayorder['subtotalwithoffer']}} </span>
                                        @endif
                                        Total-Tax:-{{$todayorder['total_tax']}}
                                    </td>

                                    <td>{{$todayorder['grand_total']}}</td>
                                    <td class="">
                                        <span class="text-warning"><b> {{$todayorder['order_status']}}</b></span>
                                        <br>
                                        {{$todayorder['payment_mode']}}
                                    </td>
                                    <td class="">
                                       <span class="text-danger"><b>{{$todayorder['updated_kitchen_order_status']}}</b></span>
                                        @if($todayorder['updated_kitchen_order_status'] !="Order-Delivered")
                                        <form action="{{ url('admin/Update-Zomatao-KitchOrder/'.$todayorder['order_no']) }}">
                                            @csrf
                                            <input type="hidden" name="updated_kitchen_order_status" value="Order-Delivered">

                                           <div class="card-footer">
                                                <button type="submit" class="btn btn-block bg-gradient-info btn-xs">Update Kitchen Status</button>
                                            </div>
                                        </form>
                                        @endif
                                    </td>
                                    <td class="">
                                        <span class="text-info"><b> {{$todayorder['delivery_status']}}</b></span>
                                        @if($todayorder['delivery_status'] !="Hand-OverTo-DeliveryBoy")
                                        <form action="{{ url('admin/Update-Zomatao-DeliveryBoySt/'.$todayorder['order_no']) }}">
                                            @csrf
                                            <input type="hidden" name="delivery_status" value="Hand-OverTo-DeliveryBoy">

                                           <div class="card-footer">
                                                <button type="submit" class="btn btn-block bg-gradient-info btn-xs">Update DeliveryBoy Status</button>
                                            </div>
                                        </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-block bg-gradient-info btn-xs" href="{{ url('admin/Zomatao-Order-Slip/'.$todayorder['order_no']) }}">Print-ZomataoOrderSlip</a>


                                       <a class="btn btn-block bg-gradient-primary btn-xs" href="{{ url('admin/view-Zomato-orderStatus/'.$todayorder['order_no']) }}">View Order Details</a>


                                    </td>


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

