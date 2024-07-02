@extends('admin.layouts.layout')
@section('title', 'View Product Details')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Table Wise Order Details</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Table Wise Order Details</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header bg-info  ">
                        <div class="card-title " style="display:inline-flex; float:right">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes['tables']->table_name}}--{{$orderes['tables']->table_type}}</div> &nbsp;

                        </div>
                        <div class="card-title  " style="display:inline-flex; float:center">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes['staffs']->name}}</div> &nbsp;

                        </div>
                        <div class="card-title " style="display:inline-flex; float:left">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes->order_no}}</div> &nbsp;

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Table Order Checkout</h3>
                    </div>
                </div>
                <div class="row">
                   
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Table Order Item List</h4>

                            </div>
                            @if(empty($gettaxinst['order_no']))
                            <form action="{{ url('admin/save-tax-temprazordata/'.$orderes['order_no']) }}" method="post">
                                @csrf
                                @endif
                            <table class="table table-striped">

                                <thead>

                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Item Name</th>
                                        <th>Total QTY</th>
                                        <th>Item QTY</th>
                                        <th>Item Price</th>
                                        <th>Total Amount</th>
                                        <th>Order Item Status</th>
                                        <th>Free Item</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($ordereitemlist as $index => $orderitem )
                                    @php

                                    $total += $orderitem['item_qty'] * $orderitem['price'];
                                    @endphp
                                    <tr>
                                        {{-- <td>{{ $index+1 }}</td> --}}
                                        <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                                        <td >{{ $orderitem['item_qty'] + $orderitem['no_qty_buy_to_free'] }}</td>
                                        <td>{{ $orderitem['item_qty'] }}</td>
                                        <td>Rs.{{ $orderitem['price'] }}</td>
                                        <td>Rs.{{ $orderitem['amount'] }}</td>
                                        <td class="text-info">{{ $orderitem['order_item_status'] }} <br>
                                            <strong class="text-danger">{{ $orderitem['order_waste_remark'] }}</strong>

                                        </td>
                                        <td>
                                            @if(!empty($orderitem['no_of_qty_buy']))
                                            <p class="badge badge-success">Get Free {{ $orderitem['no_qty_buy_to_free'] }} Item </p>
                                            @else
                                            <p class="badge badge-danger"> No Offer</p>
                                            @endif
                                        </td>
                                    </tr>

                                    @endforeach

                                    <tr style="background-color: bisque; ">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Sub Total</td>
                                        <strong>
                                            <td>Rs.{{ $total }}/

                                                <input type="hidden" name="sub_total" value="{{ $total }}">
                                            </td>

                                        </strong>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                    $date = date('Y-m-d');
                                    $coupon =App\Models\CouponOnPrice::where('order_amount','<=',$total)->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
                                            $max_code = $coupon->max('promocode');
                                            $max_amount = $coupon->max('order_amount');
                                            $max_offer_per = $coupon->max('offer_per');
                                            $max_remark = $coupon->max('remark');
                                            @endphp
                                            @if($max_amount)
                                            <tr style="background-color: bisque; ">

                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <td>Apply Coupon</td>

                                                <strong>
                                                    <td>


                                                        @if($max_amount)
                                                        <input type="hidden" name="coupon_avail_amount"  value="{{$max_amount}}" placeholder="coupon percentage">
                                                        <input type="text" name="coupon_code" value="{{$max_code}}" placeholder="coupon code" readonly style="background-color: rgb(237, 230, 230)">
                                                        <input type="hidden" name="coupon_per" value="{{$max_offer_per}}" placeholder="coupon per" readonly>
                                                        <button class="btn btn-warning">{{$max_offer_per}}% Off</button>
                                                        @else
                                                        <input type="hidden" name="coupon_avail_amount"  value="0" placeholder="coupon percentage">
                                                        <input type="hidden" name="coupon_code" value="0" placeholder="coupon code" readonly style="background-color: rgb(237, 230, 230)">
                                                        <input type="hidden" name="coupon_per" value="0" placeholder="coupon per" readonly>
                                                        <input type="hidden" name="subtotalwithoffer" value="0">
                                                        @endif
                                                    </td>
                                                </strong>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                            {{-- if offer  --}}
                                            @if($max_amount)
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Now Sub Total</td>
                                                <strong>
                                                    @php
                                                    $subtotalwithoffer = $total - (($total*$max_offer_per)/100)
                                                    @endphp
                                                    <td>Rs.{{ $subtotalwithoffer }}/

                                                        <input type="hidden" name="subtotalwithoffer" value="{{ $subtotalwithoffer }}">
                                                    </td>

                                                </strong>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <!----  Total Tax Impl  --->
                                            @php
                                            $totaltax =0;
                                            @endphp
                                            @foreach ($gettax as $taxlist )
                                            @php

                                            $totaltax += $taxlist['tax_percentage'] * $subtotalwithoffer/100;
                                            @endphp
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td>{{ $taxlist['tax_name'] }}
                                                    <input type="hidden" name="tax_name[]" value="{{ $taxlist['tax_name'] }}">
                                                </td>
                                                <td>{{ $taxlist['tax_percentage']  }}%
                                                    <input type="hidden" name="tax_percentage[]" value="{{ $taxlist['tax_percentage']  }}">
                                                </td>
                                                <td>Rs.{{ $taxlist['tax_percentage'] *$subtotalwithoffer/100 }}

                                                    <input type="hidden" name="tax_amt[]" value="{{ $taxlist['tax_percentage'] *$subtotalwithoffer/100  }}">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            @endforeach

                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> Total Tax</td>
                                                <strong>
                                                    <td>Rs.{{ $totaltax }}/

                                                        <input type="hidden" name="total_tax" value="{{ $totaltax }}">
                                                    </td>
                                                    <td></td>
                                                    <td></td>

                                                </strong>
                                            </tr>

                                            <!----  Total Tax Impl End --->

                                            @php
                                            $grandtotal = $subtotalwithoffer+$totaltax ;
                                            @endphp
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Grand Total</td>
                                                <strong>
                                                    <td>Rs.{{round($grandtotal, 2)}}/

                                                        <input type="hidden" name="grand_total" value="{{round($grandtotal, 2)}}">
                                                    </td>
                                                </strong>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            {{-- end offer  --}}
                                            {{-- normal  --}}
                                            @else

                                            <!----  Total Tax Impl  --->
                                            @php
                                            $totaltax =0;
                                            @endphp

                                            @foreach ($gettax as $taxlist )
                                            @php

                                            $totaltax += $taxlist['tax_percentage'] * $total/100;
                                            @endphp
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td>{{ $taxlist['tax_name'] }}
                                                    <input type="hidden" name="tax_name[]" value="{{ $taxlist['tax_name'] }}">
                                                </td>
                                                <td>{{ $taxlist['tax_percentage']  }}%
                                                    <input type="hidden" name="tax_percentage[]" value="{{ $taxlist['tax_percentage']  }}">
                                                </td>
                                                <td>Rs.{{ $taxlist['tax_percentage'] *$total/100 }}

                                                    <input type="hidden" name="tax_amt[]" value="{{ $taxlist['tax_percentage'] *$total/100  }}">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            @endforeach

                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> Total Tax</td>
                                                <strong>
                                                    <td>Rs.{{ $totaltax }}/

                                                        <input type="hidden" name="total_tax" value="{{ $totaltax }}">
                                                    </td>

                                                </strong>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <!----  Total Tax Impl End --->
                                            @php
                                            $grandtotal = $total +$totaltax ;
                                            @endphp
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Grand Total</td>
                                                <strong>
                                                    <td>Rs.{{round($grandtotal, 2)}}/

                                                        <input type="hidden" name="grand_total" value="{{ $grandtotal }}">
                                                    </td>
                                                </strong>
                                                <td></td>
                                                <td></td>
                                            </tr>


                                            @endif

                                </tbody>
                            </table>
                        </div>



                    </div>


                    @if(empty($gettaxinst['order_no']))

                    <div class="w-10 h-10">
        
                        <button class="btn btn-warning text-dark" type="submit">Ready to Generate Reciept ? Click Here</button>

                    </div>
                    </form>

                    @else



                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ url('admin/tableorder-checkout/'.$orderes['order_no']) }}">
                                    @csrf
                                    <input type="hidden" name="orderid" class="order_id" value="{{ $orderes['order_no'] }}">
                                    <h4 class="card-title"> Table Order Item Checkout Process</h4><br>
                                    <div class="form-group">
                                        <label>Sub Total</label>
                                        <input class="form-control sub_total" name="sub_total" id="sub_total" value="{{ $total }}" readonly>
                                    </div>
                                    @if($max_amount)
                                    <input type="hidden" name="coupon_avail_amount" value="{{$max_amount}}" placeholder="coupon percentage" class="coupon_avail_amount">
                                    <input type="hidden" name="coupon_code" value="{{$max_code}}" placeholder="coupon code" class="coupon_code" readonly style="background-color: rgb(237, 230, 230)">
                                    <input type="hidden" name="coupon_per" value="{{$max_offer_per}}" placeholder="coupon per" class="coupon_per" readonly>

                                    @else
                                    <input type="hidden" name="coupon_avail_amount" value="0" placeholder="coupon percentage" class="coupon_avail_amount">
                                    <input type="hidden" name="coupon_code" value="0" placeholder="coupon code" class="coupon_code" readonly style="background-color: rgb(237, 230, 230)">
                                    <input type="hidden" name="coupon_per" value="0" placeholder="coupon per" readonly class="coupon_per">
                                    <input type="hidden" name="subtotalwithoffer" value="0" class="subtotalwithoffer">
                                    @endif
                                    @if($max_amount)
                                    <div class="form-group">
                                        <label>After Discount Sub Total</label>
                                        <input class="form-control subtotalwithoffer" name="subtotalwithoffer" id="subtotalwithoffer" value="{{ $subtotalwithoffer }}" readonly>
                                    </div>

                                    @endif


                                    @if($max_amount)
                                    <div class="form-group">
                                        <label>Total Tax</label>
                                        <input class="form-control total_tax" name="total_tax" id="total_tax" value="{{round($totaltax, 2)}}" readonly>

                                    </div>
                                    @else

                                    <div class="form-group">
                                        <label>Total Tax</label>
                                        <input class="form-control total_tax" name="total_tax" id="total_tax" value="{{round($totaltax, 2)}}" readonly>

                                    </div>

                                    @endif
                                    <div class="form-group">
                                        <label>Grand Total (RoundOff Amount) </label>
                                        <input class="form-control grand_total" name="grand_total" id="grand_total" value="{{round($grandtotal)}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile No</label>
                                        <input class="form-control mobile_no @error('mobile_no') is-invalid @enderror" id="mobile_no" type="number" name="mobile_no">
                                        @error('mobile_no')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($orderes['payment_mode']== "")
                                    <div class="form-group">
                                        <label for="payment_mode">Payment Mode</label>

                                        <select class="form-control payment_mode @error('payment_mode') is-invalid @enderror" id="payment_mode" name="payment_mode">
                                            <option value="">Select Payment Mode</option>
                                            <option id="Cash" value="Cash">Cash</option>
                                            <option id="Online" value="Online">Online</option>
                                            <option id="Card Swip" value="Card Swip">Card Swip</option>
                                            <option id="QRCodeWithSlip" value="QRCodeWithSlip">QRCodeWithSlip</option>

                                        </select>

                                        <input type="text" name="taken_cash_amount" id="cash_amount" placeholder="Taken Cash Amount">

                                        <input type="text" name="given_change_amount" id="change_amount" placeholder="Given Change Amount" readonly>
                                        @error('payment_mode')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="card-footer">

                                        <button type="submit" id="cash-btn" class="btn btn-primary">Submit</button>


                                        <button class="btn btn-primary  w-100 mt-3 razorpay-btn btn-submit" style="border-radius:0px;" id="razorpay-btn" type="button">Purchase</button> </div>

                                    @else

                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <input class="form-control" value="{{ $orderes['payment_mode'] }}" readonly>
                                    </div>

                                    @if($orderes['taken_cash_amount'] == null && $orderes['given_change_amount'] == null )

                                    @else

                                    <div class="form-group">
                                        <label>Taken Cash Amount</label>
                                        <input class="form-control" value="{{ $orderes['taken_cash_amount'] }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Given Change Amount</label>
                                        <input class="form-control" value="{{ $orderes['given_change_amount'] }}" readonly>
                                    </div>

                                    @endif


                                    @endif
                                </form>

                            </div>
                        </div>
                    </div>

                    @endif

                </div>

            </div>
        </div>
    </div>
</section>





@endsection
@section('script')
<script>
    $(document).ready(function() {

        $("#cash_amount").hide();
        $("#change_amount").hide();

        $('#cash-btn').hide();
        $('#razorpay-btn').hide();
        $("#payment_mode").on("change", function() {
            // alert("payment_mode");
            if (this.value == "Cash") {
                $("#cash_amount").show();
                $("#change_amount").show();
                $('#cash-btn').show();
                $('#razorpay-btn').hide();
            } else if (this.value == "Card Swip"||this.value == "QRCodeWithSlip") {
                $("#cash_amount").hide();
                $("#change_amount").hide();
                $('#cash-btn').show();
                $('#razorpay-btn').hide();
            } else {
                $("#cash_amount").hide();
                $("#change_amount").hide();
                $('#cash-btn').hide();
                $('#razorpay-btn').show();
            }
        });

        $("#cash_amount").keyup(function() {
            var cash_amount = $("#cash_amount").val();
            // alert(cash_amount);
            var grand_total = $("#grand_total").val();

            $("#change_amount").val(cash_amount - grand_total);
        });


    });
</script>



<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function() {
        // rozarpay jquery---
        $('.razorpay-btn').click(function(e) {
            e.preventDefault();
            var grand_total = $('.grand_total').val();
            var order_id = $('.order_id').val();

            var sub_total = $('.sub_total').val();
            var total_tax = $('.total_tax').val();




            var coupon_per = $('.coupon_per').val();
            var coupon_avail_amount = $('.coupon_avail_amount').val();
            var coupon_code = $('.coupon_code').val();
            var subtotalwithoffer = $('.subtotalwithoffer').val();

            var mobile_no = $('.mobile_no').val();


            var data = {
                'grand_total': grand_total
                , 'order_id': order_id
                , 'sub_total': sub_total
                , 'total_tax': total_tax,




                'coupon_per': coupon_per
                , 'coupon_avail_amount': coupon_avail_amount
                , 'coupon_code': coupon_code
                , 'subtotalwithoffer': subtotalwithoffer,

                'mobile_no': mobile_no,

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                method: "post"
                , url: "{{ url('/') }}/admin/proceed-to-pay"
                , data: data
                , success: function(response) {
                    var options = {
                        "key": "rzp_test_T6cYO2ODoHQ6A9", // Enter the Key ID generated from the Dashboard
                        // "amount": 1*100 , // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "amount": response.grand_total * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR"
                        , "name": "DunkalBevarage"
                        , "description": "Thank For chooseing us"
                        , "image": "https://example.com/your_logo",
                        // "order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                        "handler": function(razorpayresponse) {
                            // alert(razorpayresponse.razorpay_payment_id);
                            $.ajax({

                                method: "post"
                                , url: "{{ url('/') }}/admin/tableorder-checkout/" + order_id
                                , data: {
                                    'grand_total': response.grand_total
                                    , 'sub_total': response.sub_total
                                    , 'subtotalwithoffer': response.subtotalwithoffer
                                    , 'coupon_code': response.coupon_code
                                    , 'coupon_avail_amount': response.coupon_avail_amount
                                    , 'coupon_per': response.coupon_per
                                    , 'total_tax': response.total_tax,

                                    'mobile_no': response.mobile_no
                                    , 'order_id': response.order_id
                                    , 'payment_mode': 'Paid by Razorpay'
                                    , 'payment_id': razorpayresponse.razorpay_payment_id,

                                }
                                , success: function(
                                    razorpaysuccesresponse) {
                                    swal(razorpaysuccesresponse
                                            .status)
                                        .then((value) => {
                                            // window.location.reload();
                                            window.location.href = "{{ url('/') }}/admin/table-orderSlip/" + order_id;
                                        });


                                }
                            });
                        }
                        , "prefill": {
                            // "name": response.firstname + ' ' + response.lastname,
                            // "email": response.email,
                            "contact": response.mobile_no
                        },

                        "theme": {
                            "color": "#3399cc"
                        }
                    };
                    var rzp1 = new Razorpay(options);


                    rzp1.open();
                    e.preventDefault();

                    // alert(response.total_price);
                }

            });



        }); //end razorpay---



    });
</script>


@endsection