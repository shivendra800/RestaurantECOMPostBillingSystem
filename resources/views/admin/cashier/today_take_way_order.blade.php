@extends('admin.layouts.layout')
@section('title','Take Way Order List')

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
                    <li class="breadcrumb-item active">Take Way Order List</li>
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
                        <h2 class="btn btn-warning">Search Data Of Take Way Order</h2>
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
                                    <label>Over All TakeWay Collection</label>
                                    <input class="form-control" value="{{ $overallcollectionwithGSt }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                          <div class="card-body">
                              <div class="form-group">
                                  <label>Over All TakeWay  Tax Collection</label>
                                  <input class="form-control" value="{{ round($overallcollectionwithoutGSt,2) }} " readonly="">
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

             
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Take Way Order List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Order No</th>
                                    <th>Sub Total</th>
                                    <th>Total Tax</th>
                                    <th>Grand Total</th>
                                    <th>Order Status</th>
                                    <th>Kitchen Order Status</th>
                                    <th>Payment Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                $grandtotal = 0 ;
                                $service_tax = 0 ;
                                $sub_total = 0;
                                @endphp --}}
                                @foreach ($todayTakeAwayorderlist as $index=>$todayorder)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td>
                                        @if($todayorder['payment_mode']== "")
                                        <a href="{{ url('admin/takeorder-checkout/'.$todayorder['order_no']) }}"> {{$todayorder['order_no']}}</a>
                                        @else
                                        {{$todayorder['order_no']}}
                                        @endif
                                    </td>
                                    <td>
                                        Rs.{{$todayorder['sub_total']}}
                                        <br>
                                        @if(!empty($todayorder['coupon_per']))
                                        <span class="text-success">Offer Apply: {{$todayorder['coupon_per']}}% Off </span>
                                        @endif
                                        <br>
                                        @if(!empty($todayorder['subtotalwithoffer']))
                                        <span class="text-danger">new-subtotal: {{$todayorder['subtotalwithoffer']}} </span>
                                        @endif
                                    </td>
                                    <td>Rs.{{$todayorder['total_tax']}}</td>
                                    <td>Rs.{{$todayorder['grand_total']}}</td>
                                    <td class="bg-green">{{$todayorder['order_status']}}</td>
                                    <td class="bg-red">{{$todayorder['updated_kitchen_order_status']}}</td>
                                    <td class="bg-info">{{$todayorder['payment_mode']}}</td>
                                    <td>
                                        <li><a href="{{ url('admin/today-Take-away-orderSlip/'.$todayorder['order_no']) }}">slip</a></li>
                                        @if(Auth::guard('admin')->user()->type=="Cashier")
                                        @if($todayorder['updated_kitchen_order_status']== "Order-Transfer-Kichen")
                                       <li><a href="{{ url('admin/view-takeway-orderStatus/'.$todayorder['order_no']) }}">View Order Item Status</a></li> 
                                       @endif
                                       @endif
                                    </td>
{{-- 
                                    @php

                                    $grandtotal += $todayorder['grand_total'];
                                  
                                    $service_tax += $todayorder['service_tax'];
                                    $sub_total +=  $todayorder['sub_total'];
                                    @endphp --}}





                                </tr>
                               

                                @endforeach
                                {{-- <tr style="background-color: bisque; " >
                                  <td></td>
                                  <td>Total Collection</td>
                                  <td>{{ $sub_total }}</td>
                                  <td>{{ $service_tax }}</td>
                  
                                  <td>{{$grandtotal}}</td>  
                                  
                               <td ></td>
                                  <td ></td>
                                  <td ></td>
                              </tr> --}}

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
@section('script')



@endsection