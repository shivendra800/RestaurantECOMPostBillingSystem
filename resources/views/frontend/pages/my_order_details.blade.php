@extends('frontend.layouts.layout')

@section('title','My Order List')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

body {
	background-color: #eeeeee;
	font-family: 'Open Sans', serif
}

.container {
	margin-top: 50px;
	margin-bottom: 50px
}

.card {
	position: relative;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	background-color: #fff;
	background-clip: border-box;
	border: 1px solid rgba(0, 0, 0, 0.1);
	border-radius: 0.10rem
}

.card-header:first-child {
	border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
}

.card-header {
	padding: 0.75rem 1.25rem;
	margin-bottom: 0;
	background-color: #fff;
	border-bottom: 1px solid rgba(0, 0, 0, 0.1)
}

.track {
	position: relative;
	background-color: #ddd;
	height: 7px;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin-bottom: 60px;
	margin-top: 50px
}

.track .step {
	-webkit-box-flex: 1;
	-ms-flex-positive: 1;
	flex-grow: 1;
	width: 25%;
	margin-top: -18px;
	text-align: center;
	position: relative
}

.track .step.active:before {
	background: #FF5722
}

.track .step::before {
	height: 7px;
	position: absolute;
	content: "";
	width: 100%;
	left: 0;
	top: 18px
}

.track .step.active .icon {
	background: #ee5435;
	color: #fff
}

.track .icon {
	display: inline-block;
	width: 40px;
	height: 40px;
	line-height: 40px;
	position: relative;
	border-radius: 100%;
	background: #ddd
}

.track .step.active .text {
	font-weight: 400;
	color: #000
}

.track .text {
	display: block;
	margin-top: 7px
}

.itemside {
	position: relative;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	width: 100%
}

.itemside .aside {
	position: relative;
	-ms-flex-negative: 0;
	flex-shrink: 0
}

.img-sm {
	width: 80px;
	height: 80px;
	padding: 7px
}

ul.row,
ul.row-sm {
	list-style: none;
	padding: 0
}

.itemside .info {
	padding-left: 15px;
	padding-right: 7px
}

.itemside .title {
	display: block;
	margin-bottom: 5px;
	color: #212529
}

p {
	margin-top: 0;
	margin-bottom: 1rem
}

.btn-warning {
	color: #ffffff;
	background-color: #ee5435;
	border-color: #ee5435;
	border-radius: 1px
}

.btn-warning:hover {
	color: #ffffff;
	background-color: #ff2b00;
	border-color: #ff2b00;
	border-radius: 1px
}
</style>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Order List</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">OrderList</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shadow bg-white p-3">

                        <h4 class="text-primary">
                            <i class="fa fa-shopping-cart text-dark"></i> My Order Details
                            <a href="{{ url('my-order-list') }}" class="btn btn-danger btn-sm float-end">Back</a>
                        </h4>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Order Details</h5>
                                <hr>

                                <h6>Order Id : {{ $order->id  }}</h6>
                                <h6>Tracking No : {{ $order->order_no  }}</h6>
                                <h6>Order Date : {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('MMM Do YYYY')}}</h6>
                                <h6>Payment Mode : {{ $order->payment_method  }}-{{ $order->payment_gateway  }}</h6>
                                <h6 class="border p-2 text-success">Order Status Message :
                                    <span class="text-uppercase">{{ $order->order_status }}</span>
                                 </h6>
                                 @if($order->canceled_date !=NULL)
                                 <h6 class="text-danger">Order Cancel Date : {{ \Carbon\Carbon::parse($order->canceled_date)->isoFormat('MMM Do YYYY')}}</h6>
                                 @endif
                            </div>
                            <div class="col-md-6">
                                <h5>User Details</h5>
                                <hr>

                                <h6>Full Name : {{ $order->name  }}</h6>
                                <h6>Email : {{ $order->email  }}</h6>
                                <h6>Phone No : {{ $order->mobile  }}</h6>
                                <h6>Address : {{ $order->address}}</h6>
                                <h6>Pin Code : {{ $order->pincode  }}</h6>

                            </div>
                        </div>
                        <br/>
                        <hr>
                          <h5>Order Status </h5>
                        <div class="track">

                            @if($order['order_status'] =="New-Order" ||$order['order_status'] =="Order-Accepted"||$order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Prepared"||$order['order_status']=="Order-Collected"||$order['order_status']=="Order-Delivered")
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Place</span> </div>
                            @else
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Place</span> </div>
                            @endif
                 @if($order['order_status'] =="Order-Accepted"||$order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Prepared"||$order['order_status']=="Order-Collected"||$order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")

                                    @if($order['order_status'] =="Order-Accepted"||$order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Prepared"||$order['order_status']=="Order-Collected"||$order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                    @else
                                    <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                    @endif
                                
                                    @if($order['order_status']=="Order-Preparing"||$order['order_status']=="Order-Prepared"||$order['order_status']=="Order-Collected"||$order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active">   <img src="{{ url('/') }}/front_assets/cooking.gif"style="width: 50px; height: 50px" alt=""> <span class="text">Order-Preparing</span> </div>
                                    @else
                                    <div class="step"> <img src="{{ url('/') }}/front_assets/cooking.gif"
                                        style="width: 50px; height: 50px" alt=""> <span class="text">Order-Preparing</span> </div>
                                    @endif
                                    @if($order['order_status']=="Order-Prepared"||$order['order_status']=="Order-Collected"||$order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active"> <img src="{{ url('/') }}/front_assets/food-delivery.gif"style="width: 50px; height: 50px" alt=""> <span class="text">Order-Prepared</span> </div>
                                    @else
                                    <div class="step"> <img src="{{ url('/') }}/front_assets/food-delivery.gif"style="width: 50px; height: 50px"> <span class="text">Order-Prepared</span> </div>
                                    @endif
                                    @if($order['order_status']=="Order-Collected"||$order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active"> <img src="{{ url('/') }}/front_assets/sand-clock.gif"style="width: 50px; height: 50px"> <span class="text">Ready for pickup</span> </div>
                                    @else
                                    <div class="step "> <img src="{{ url('/') }}/front_assets/sand-clock.gif"style="width: 50px; height: 50px"> <span class="text">Ready for pickup</span> </div>
                                    @endif
                                    @if($order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active"> <img src="{{ url('/') }}/front_assets/delivery-man.png"style="width: 50px; height: 50px"> <span class="text">Order Picked </span> </div>
                                    @else
                                    <div class="step ">
                                    <img src="{{ url('/') }}/front_assets/delivery-man.png"style="width: 50px; height: 50px"> <span class="text">Order Picked </span> </div>
                                    @endif

                                    @if($order['order_status']=="Order-TakenBy-DeliveryBoy"||$order['order_status']=="Order-Delivered")
                                    <div class="step active"> <img src="{{ url('/') }}/front_assets/truck.gif"style="width: 50px; height: 50px"><span class="text"> On the way </span> </div>
                                    @else
                                    <div class="step"> <img src="{{ url('/') }}/front_assets/truck.gif"style="width: 50px; height: 50px"><span class="text"> On the way </span> </div>
                                    @endif

                                    @if($order['order_status']=="Order-Delivered")
                                    <div class="step active"> <img src="{{ url('/') }}/front_assets/delivery.gif"style="width: 50px; height: 50px"><span class="text">Order-Delivered</span> </div>
                                    @else
                                    <div class="step"> <img src="{{ url('/') }}/front_assets/delivery.gif"style="width: 50px; height: 50px"><span class="text">Order-Delivered</span> </div>
                                    @endif
                                  

            @else                  
             
               @if($order['order_status']=="Cancelled")
               <div class="step active"> <img src="{{ url('/') }}/front_assets/cancel.gif"style="width: 50px; height: 50px"><span class="text">Order-Cancelled</span> </div>
               @else
               <div class="step "> <img src="{{ url('/') }}/front_assets/cancel.gif"style="width: 50px; height: 50px"><span class="text">Order-Cancelled</span> </div>
               @endif
            @endif
                          
                            
                        </div>
                        <hr>

                        <h5>Order Item</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th>Item Id</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>

                                </tr>
                                </thead>
                                  <tbody>
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                @foreach($order['orders_products'] as $orderItem)
                                <tr>
                                    <td width=5%>{{ $orderItem->id }}</td>
                                    <td width=10%>
                                        @if($orderItem['menuItem']['menu_item_image'])
                                        <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $orderItem['menuItem']['menu_item_image'] }}"
                                        style="width: 50px; height: 50px" alt="">
                                        @else
                                        <img src=""
                                        style="width: 50px; height: 50px" alt="">
                                        @endif


                                    </td>
                                    <td width=20%>
                                        {{ $orderItem->product_name }}
                                        <br>
                                        @if($orderItem->product_code)
                                        <span>with Code:{{ $orderItem->product_code }}</span>
                                        @endif
                                      
                                    </td>
                                    <td width=10%>Rs {{ $orderItem->product_price }}</td>
                                    <td width=10%>
                                        OrderQTY => {{ $orderItem->product_qty }}
                                        <br>
                                        @if($orderItem->no_qty_buy_to_free>0)
                                        <span>  FreeQTY => {{ $orderItem->no_qty_buy_to_free }}</span>
                                        @endif
                                    </td>
                                    <td width=10% class="fw-bold">{{ $orderItem->product_qty * $orderItem->product_price }}</td>
                                    @php
                                    $totalPrice += $orderItem->product_qty * $orderItem->product_price ;
                                @endphp
                                 <!--<td width=10%>-->
                                 <!--   @if($order->status_message =='completed' &&  $orderItem->rstatus == false)-->
                                 <!--   {{-- <a href="{{ url('userreview',['order_item_id'=>$orderItem->id]) }}">Write Review</a> --}}-->
                                    <!--<a href="{{ url('review/'.$orderItem->id) }}" class="btn btn-primary btn-sm">Write Review</a>-->
                                 <!--   @endif-->
                                 <!--</td>-->
                                </tr>


                                @endforeach
                                <tr>
                                    <td colspan="5" class="fw-bold">SubTotal :</td>
                                    <td colspan="1" class="fw-bold">Rs {{ $order['subtotal'] }} </td>
                                </tr>
                                @if($order['subtotalwithoffer']>0)
                                <tr>
                                    <td colspan="5" class="fw-bold">Coupon % :</td>
                                    <td colspan="1" class="fw-bold text-danger">{{ $order->coupon_per }}% </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="fw-bold">After Discount SubTotal :</td>
                                    <td colspan="1" class="fw-bold">Rs {{ $order['subtotalwithoffer'] }} </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="5" class="fw-bold">Total Tax :</td>
                                    <td colspan="1" class="fw-bold">Rs {{ $order['total_tax'] }} </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="fw-bold">Grand Total :</td>
                                    <td colspan="1" class="fw-bold">Rs {{ $order['grand_total'] }} </td>
                                </tr>
                                  </tbody>

                            </table>

                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection