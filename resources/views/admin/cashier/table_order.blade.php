@extends('admin.layouts.layout')
@section('title','Table Order')

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
                    <li class="breadcrumb-item active">Table Order</li>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table Order</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Order No</th>
                                    <th>Sub Total</th>
                                    <th>Total  Tax</th>
                                    <th>Grand Total</th>
                                    <th>Order Status</th>
                                    <th>Payment Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $grandtotal = 0 ;
                                $total_tax = 0 ;
                                $sub_total = 0;
                                @endphp
                                @foreach ($tableordertb as $index=>$todayorder)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td>
                                        @if($todayorder['total_tax']== 0)
                                        <a href="{{ url('admin/View-order-details/'.$todayorder['order_no']) }}"> {{$todayorder['order_no']}}</a>
                                        @else
                                        {{$todayorder['order_no']}}
                                        @endif
                                        <br>
                                       TableNO:- {{$todayorder['tables']->table_name}}
                                    </td>
                                    <td>{{$todayorder['sub_total']}}</td>
                                    <td>{{$todayorder['total_tax']}}</td>
                                    <td>{{$todayorder['grand_total']}}</td>
                                    <td class="bg-green">{{$todayorder['order_status']}}</td>
                                    <td class="bg-info">
                                        <strong>{{ $todayorder['payableamt'] }}</strong><br>
                                        {{$todayorder['payment_mode']}}
                                    </td>
                                    <td>
                                        @if($todayorder['order_status']!="Order Completed")
                                        @if($todayorder['total_tax']== 0)
                                        <a class="btn btn-primary" href="{{ url('admin/view-order-details/'.$todayorder['order_no']) }}">View Order</a>
                                        <br>
                                        <a class="btn btn-warning" href="{{ url('admin/View-order-details/'.$todayorder['order_no']) }}">Generate Reciept</a>
                                        @else
                                       
                                        <br>

                                        @if($todayorder['payment_mode']== NULL)
                                        {{-- <a class="btn btn-info" href="{{ url('admin/table-orderSlip/'.$todayorder['order_no']) }}" target="_blank">Order Slip</a> --}}
                                        <a href="{{ url('admin/table-orderSlip/'.$todayorder['order_no'] ) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>&nbsp;

                                        <a class="btn btn-warning" href="{{ url('admin/table-paymentupdated/'.$todayorder['order_no']) }}">Process For Checkout</a>
                                        @endif
                                        @endif
                                        @else
                                        <a href="{{ url('admin/table-orderSlip/'.$todayorder['order_no'] ) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>&nbsp;
                                        @endif


                                    </td>

                                    @php

                                    $grandtotal += $todayorder['grand_total'];
                                  
                                    $total_tax += $todayorder['total_tax'];
                                    $sub_total +=  $todayorder['sub_total'];
                                    @endphp





                                </tr>
                               

                                @endforeach
                                <tr style="background-color: bisque; " >
                                  <td></td>
                                  <td>Total Collection</td>
                                  <td>{{ $sub_total }}</td>
                                  <td>{{ $total_tax }}</td>
                  
                                  <td>{{$grandtotal}}</td>  
                                  
                               <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  
                              
                                 
                          
                              </tr>

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