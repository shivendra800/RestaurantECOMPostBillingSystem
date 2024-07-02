@extends('admin.layouts.layout')
@section('title','Today Order List')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @include('admin.errors.all_mesg')
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Today Order List</li>
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
              <h3 class="card-title">Today Order List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Order NO </th>
                  <th>Table Name </th>

                  <th>Today Table Book Date</th>
                  <th>Table Order Sub-Total</th>
                  <th>Tax</th>
                  <th>Table Order Grand Amount</th>

                  <th>Payment Mode & ID</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>
                      @php
                  $grandtotal = 0 ;
                  $tax = 0 ;

                  @endphp
                    @foreach ($todayorderlist as $index=>$todayorder)
                        <td>{{$index+1}}</td>
                        <td >
                          @if($todayorder['total_tax']== 0)
                          <a href="{{ url('/') }}/admin/view-order-details/{{$todayorder['order_no']}}">{{$todayorder['order_no']}}</a>
                          @else
                          {{$todayorder['order_no']}}
                          @endif
                        </td>
                        <td>
                            @if($todayorder['tables'] && $todayorder['tables']['table_name'] )
                              {{$todayorder['tables']['table_name']}}
                            @else
                            NA
                            @endif
                        </td>

                        <td style="color: red;">{{ \Carbon\Carbon::parse($todayorder['created_at'])->isoFormat('MMM Do YYYY')}}</td>
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
                        </td>
                           <td>{{$todayorder['total_tax']}}</td>
                        <td>{{$todayorder['grand_total']}}</td>
                        <td class="text-warning">
                          @if($todayorder['payment_id']=="null")
                          {{$todayorder['payment_mode']}}--{{$todayorder['payment_id']}}
                          @else
                          {{$todayorder['payment_mode']}}
                            @endif

                        </td>
                        <td>
                          @if($todayorder['total_tax']== 0)

                                       <a class="btn btn-block btn-warning btn-xs" href="{{ url('/') }}/admin/view-order-details/{{$todayorder['order_no']}}">ADD More Item</a>
                                       @if (Auth::guard('admin')->user()->type == "Admin")
                                        @if($todayorder['payment_mode']== NULL)
                                        <a class="btn btn-block btn-danger btn-xs" href="{{ url('/') }}/admin/delete-table-order/{{$todayorder['order_no']}}">Delete</a>
                                        @endif
                                       @endif
                                       <a class="btn btn-block btn-info btn-xs" href="{{ url('admin/View-order-details/'.$todayorder['order_no']) }}" class="text-danger">Generate Reciept</a>
                                       @else
                                        <a class="btn btn-block btn-info btn-xs" href="{{ url('admin/table-orderSlip/'.$todayorder['order_no']) }}" target="_blank">View/Print Reciept</a><br>

                                        @if($todayorder['payment_mode']== NULL)
                                        <a class="btn btn-block btn-primary btn-xs" href="{{ url('admin/table-paymentupdated/'.$todayorder['order_no']) }}" class="text-success">Process For Checkout</a>
                                        @endif
                                        @endif
                          </td>
                            @php

                                $grandtotal += $todayorder['grand_total'];
                                $tax +=$todayorder['total_tax']


                                @endphp
                </tr>
                @endforeach
                   <tr style="background-color: bisque; ">
                  <td></td>
                  <td>Total Collection</td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td>{{ $tax }}</td>

                  <td>{{$grandtotal}}</td>
                  <td></td>
                  <td></td>
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
