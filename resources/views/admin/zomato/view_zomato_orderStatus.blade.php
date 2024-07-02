@extends('admin.layouts.layout')
@section('title', 'Zomato Order Item Status')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Zomato Order Item Status</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Zomato Order Item Status </li>
                    <li class="breadcrumb-item">  <a href="{{url('/')}}/admin/Today-Take-zomato-order">Back</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Zomato Order Item Status</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Zomato Purchase  Order Details</h4><br>
                                <div class="form-group">
                                    <label>Order No</label>
                                    <input class="form-control" value="{{ $vieworder['order_no'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input class="form-control" value="{{ $vieworder['sub_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Total Tax</label>
                                    <input class="form-control" value="{{ $vieworder['total_tax'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="{{ $vieworder['grand_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <input class="form-control" value="{{ $vieworder['payment_mode'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Order Date</label>

                                    <input class="form-control" value="{{ \Carbon\Carbon::parse($vieworder['created_at'])->isoFormat('MMM Do YYYY')}}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Zomato Order Item Status</h4><br>

                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 40px">Item Name</th>
                                    <th style="width: 40px">Item QTY</th>
                                    <th style="width: 40px">Item Price</th>
                                    <th style="width: 40px">Total Amount</th>
                                    <th style="width: 40px">Order Item Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viewOrderitem as  $index => $orderitem )

                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                           <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                                           <td>{{ $orderitem['item_qty'] }}</td>
                                           <td>Rs.{{ $orderitem['price'] }}</td>
                                           <td>Rs.{{ $orderitem['amount'] }}</td>
                                           <td class="badge badge-warning">{{ $orderitem['order_item_status'] }}</td>
                                      </tr>

                                    @endforeach

                                </tbody>
                              </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Zomato Order ID</label>
                                    <input class="form-control" value="{{ $vieworder['zomtao_order_id'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input class="form-control" value="{{ $vieworder['cust_name'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input class="form-control" value="{{ $vieworder['coupon_per'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <input class="form-control" value="{{ $vieworder['payment_mode'] }}" readonly="">
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


  @endsection
