@extends('admin.layouts.layout')
@section('title', 'Take Order')
@section('content')
<script src="{{ url('/') }}/admin_assets/3.5.1-jquery.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Take Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Take Order</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        @include('admin.errors.all_mesg')
        <div class="card">
            <div class="card-header bg-warning text-center">
                <h3 class="card-title  "> Offer List</h3>

            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="  table table-bordered table-hover dataTable dtr-inline bg-secondary"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Offer</th>
                                    <th>Validity</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($productWiseCoupon as $index => $itemcoupon)
                                    <tr id="tr_{{ $itemcoupon['id'] }}">


                                        <td>{{ $itemcoupon['menuitem']['menu_item_name'] }}</td>
                                        <td class="badge badge-danger">Buy {{ $itemcoupon['no_of_qty_buy'] }} Get
                                            {{ $itemcoupon['no_qty_buy_to_free'] }} Free</td>


                                        <td>{{ \Carbon\Carbon::parse($itemcoupon['start_date'])->isoFormat('MMM Do YYYY') }}
                                            -
                                            {{ \Carbon\Carbon::parse($itemcoupon['expiry_date'])->isoFormat('MMM Do YYYY') }}
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="  table table-bordered table-hover dataTable dtr-inline bg-secondary"
                            aria-describedby="example1_info">

                            <thead>
                                <tr>
                                    <th>Offer</th>

                                    <th>Validity</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupononprice as $index => $itemcoupon)
                                    <tr id="tr_{{ $itemcoupon['id'] }}">


                                        <td class="badge badge-danger">{{ $itemcoupon['offer_per'] }}% On Order Above
                                            Rs.{{ $itemcoupon['order_amount'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($itemcoupon['start_date'])->isoFormat('MMM Do YYYY') }}
                                            -
                                            {{ \Carbon\Carbon::parse($itemcoupon['expiry_date'])->isoFormat('MMM Do YYYY') }}
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                @foreach ($tables as $selecttable)
                    <div class="col-md-3">

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ $selecttable['table_name'] }}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong>Type:-</strong>{{ $selecttable['table_type'] }}
                                <br>
                                <strong>Capacity:-</strong>{{ $selecttable['table_capacity'] }} <small>person</small>
                                <br>
                                @if (Auth::guard('admin')->user()->type == 'Cashier')
                                    @if ($selecttable['booking_status'] == 0)
                                        <strong>Booking Status:-</strong><a
                                            href="{{ url('admin/take-table-order/' . $selecttable['id']) }}"><button
                                                class="btn btn-warning">Table is Not Book Yet!Click Here</button></a>
                                    @else
                                        @if($selecttable['table_order_no'] == " " || $selecttable['table_order_no'] == NULL || $selecttable['table_order_no'] == 0 )
                                        <span>Table Order-no Not Exists</span>
                                        @else
                                            <strong>Booking Status:-</strong><a
                                                href="{{ url('admin/view-order-details/' . $selecttable['table_order_no']) }}"><button
                                                    class="btn btn-danger">Table Is Already Booked!</button></a>
                                        @endif
                                    @endif
                                @else
                                    @if ($selecttable['booking_status'] == 0)
                                        <strong>Booking Status:-</strong><a
                                            href="{{ url('admin/take-order/' . $selecttable['id']) }}"><button
                                                class="btn btn-warning">Table is Not Book Yet!Click Here</button></a>
                                    @else
                                            @if($selecttable['table_order_no'] == " " || $selecttable['table_order_no'] == NULL || $selecttable['table_order_no'] == 0 )
                                            <span>Table Order-no Not Exists</span>
                                            @else
                                            <strong>Booking Status:-</strong><a  href="{{ url('admin/view-order-details/' . $selecttable['table_order_no']) }}"><button
                                                    class="btn btn-danger">Table Is Already Booked!</button></a>
                                            @endif
                                    @endif
                                @endif
                                <br>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                @endforeach
                <!-- /.col -->
            </div>
        </div>
    </section>





@endsection
