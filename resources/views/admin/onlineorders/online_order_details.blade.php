@extends('admin.layouts.layout')

@section('title','OnlineOrder Details')

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
            <li class="breadcrumb-item active">Online Order</li>
            <li class="breadcrumb-item active"><a href="{{ url('admin/online-order') }}">Back</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
 


  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Details</h4><br>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Order ID:</label>
                            <label>{{ $orderDetails['order_no'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label tyle="font-weight: 550;">Order Date:</label>
                            <label>{{  date('Y-m-d h:i:s',strtotime($orderDetails['created_at'])) }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Order States:</label>
                            <label>{{ $orderDetails['order_status'] }}</label>
                        </div>
                      
                         <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Shipping Charges:</label>
                            <label>Rs.{{ $orderDetails['shipping_charges'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Sub Total:</label>
                            <label>Rs.{{ $orderDetails['subtotal'] }}</label>
                        </div>
                        @if(!empty($orderDetails['coupon_code']))
                         <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Coupon Code:</label>
                            <label>{{ $orderDetails['coupon_code'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Coupon %:</label>
                            <label>{{ $orderDetails['coupon_per'] }}%</label>
                        </div>
                        @endif
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">After Discount Sub Total:</label>
                            <label>Rs.{{ $orderDetails['subtotalwithoffer'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Total Tax:</label>
                            <label>Rs.{{ $orderDetails['total_tax'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Grand Total:</label>
                            <label>Rs.{{ $orderDetails['grand_total'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Payment Method:</label>
                            <label>{{ $orderDetails['payment_method'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Payment Gateway:</label>
                            <label>{{ $orderDetails['payment_gateway'] }}</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Delivery Address </h1><br>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Name:</label>
                            <label>{{ $orderDetails['name'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Email:</label>
                            <label>{{ $orderDetails['email'] }}</label>
                        </div>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Address:</label>
                            <label>{{ $orderDetails['address'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Area:</label>
                            <label>{{ $orderDetails['area'] }}</label>
                        </div>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">City:</label>
                            <label>{{ $orderDetails['city'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">State:</label>
                            <label>{{ $orderDetails['state'] }}</label>
                        </div>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Pincode:</label>
                            <label>{{ $orderDetails['pincode'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Mobile:</label>
                            <label>{{ $orderDetails['mobile'] }}</label>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Order Status</h4><br>
                     
                          <form action="{{ url('admin/update-order-status') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                            <select name="order_status" id="order_status" class="form-control" required="">
                                <option value="">Change Order Status</option>
                                @foreach ($orderStatuses as $status )
                                <option value="{{ $status['name'] }}" @if(!empty($orderDetails['order_status'])&& $orderDetails['order_status']==$status['name']) selected="" @endif> {{ $status['name'] }}</option>
                                @endforeach
                            </select>
                            @if($orderDetails['assign_id']==0)
                            <select name="assign_id" id="assign_id" class="form-control">
                                <option value="">Select Delivery Boy</option>
                                @foreach ($getdeliveryBoy as $delivboy )
                                <option value="{{ $delivboy['id'] }}" @if(!empty($orderDetails['assign_id'])&& $orderDetails['assign_id']==$delivboy['id']) selected="" @endif> {{ $delivboy['name'] }}</option>
                                @endforeach
                            </select>
                            @else
                            <select name="assign_id"  class="form-control">
                                @foreach ($getdeliveryBoy as $delivboy )
                                <option value="{{ $delivboy['id'] }}" @if(!empty($orderDetails['assign_id'])&& $orderDetails['assign_id']==$delivboy['id']) selected="" @endif> {{ $delivboy['name'] }}</option>
                                @endforeach
                            </select>

                                
                            @endif
                            <button type="submit">Update Order Status</button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ordered Menu Item</h4>
                        <table class="table table-striped table-borderless">
                            <tr>
                                <td colspan="2"><strong>Menu Item Details</strong></td></tr>
                               <tr>
                                
                                <th>Menu Item Code</th>
                                <th>Menu Item Name</th>
                                <th>Menu Item Qty</th>
                                <th>Item Status</th>
                               </tr>

                                @foreach ($orderDetails['orders_products'] as $product )
                                   <tr>
                                   
                                    <td>{{ $product['product_code'] }}</td>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ $product['product_qty'] }}</td>
                                  
                                    <td> 
                                    @if(Auth::guard('admin')->user()->type=="Kitchen-Manager")
                                         <form action="{{ url('admin/update-order-item-status') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                        <select name="order_item_status" id="order_item_status" required="">
                                            @foreach ($orderItemStatuses as $status )

                                            <option value="{{ $status['name'] }}" @if(!empty($product['item_status'])&& $product['item_status']==$status['name']) selected="" @endif> {{ $status['name'] }}</option>
                                            @endforeach
                                        </select> <br>
                                      <br>  <button type="submit">Update Order Status</button>
                                    </form>

                                    @else
                                    {{ $product['item_status'] }}
                                    @endif
                                </td>
                                    
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </section>


  <script>
  
  </script>

@endsection