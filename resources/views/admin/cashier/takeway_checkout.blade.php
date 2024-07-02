@extends('admin.layouts.layout')
@section('title', 'Take Away Order Checkout')

@section('content')

<section class="content-header">
    <div class="container-fluid" id="mycontent">
        <div class="row">
            <div class="col-sm-6">
                <h1>Take Away Order Checkout</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Take Away Checkout </li>
                </ol>
            </div>
        </div>
        
    </div>
</section>
<section class="content" >
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Take Away Checkout</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Take Way Purchase Order Details</h4><br>
                                <div class="form-group">
                                    <label>Order No</label>
                                    <input class="form-control" value="{{ $takeoutorder['order_no'] }}" readonly="">
                                </div>
                                
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorder['sub_total'] }}" readonly="">
                                </div>
                                @if(!empty($takeoutorder['coupon_per']))
                                <div class="form-group">
                                    <label>Coupon Apply</label>
                                    <input class="form-control" value="{{ $takeoutorder['coupon_per'] }}% Off" readonly="">
                                </div>
                                @endif
                                @if(!empty($takeoutorder['subtotalwithoffer']))
                                <div class="form-group">
                                    <label>New Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorder['subtotalwithoffer'] }}" readonly="">
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>Total Tax</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorder['total_tax'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorder['grand_total'] }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Take Way Purchase Item List</h4><br>

                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Item Name</th>
                                        <th>Total Order QTY</th>
                                        <th>Item QTY</th>
                                        <th style="width: 40px">Free Item</th>
                                        <th style="width: 40px">Item Price</th>
                                        <th style="width: 40px">Total Amount</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($takewayorderitem as $index => $orderitem )

                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                                        <td>{{ $orderitem['item_qty'] + $orderitem['no_qty_buy_to_free'] }}</td>
                                        <td>{{ $orderitem['item_qty'] }}</td>
                                        <td class="text-success">
                                            @if(!empty($orderitem['no_of_qty_buy']))
                                           Get {{$orderitem['no_qty_buy_to_free']}}Free
                                            @else
                                            No Offer
                                            @endif
                                        </td>
                                        <td>Rs.{{ $orderitem['price'] }}</td>
                                        <td>Rs.{{ $orderitem['amount'] }}</td>
                                        
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<section class="content" >
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Fill Form For Order Completed</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('admin/takeorder-checkout-save/'.$takeoutorder['order_no']) }}">

                        @csrf

                        <input type="hidden" name="orderid" class="order_id" value="{{ $takeoutorder['order_no'] }}">
                        @php
                            $grandtotal = $takeoutorder['grand_total'];
                            $gandtotalroundoff = round($grandtotal);
                        @endphp
                        <input class="form-control grand_total" type="hidden" name="grand_total" id="grand_total" value="{{ $gandtotalroundoff }}">
                        <div class="card-body">
                            @if(Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> {{Session::get('error_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            <div class="form-group">
                                <label>Mobile No</label>
                                <input class="form-control mobile_no @error('mobile_no') is-invalid @enderror" id="mobile_no"  type="number" name="mobile_no" >
                                @error('mobile_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

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

                                <input type="text" name="given_change_amount" id="change_amount" placeholder="Given Change Amount">
                                @error('payment_mode')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="cash-btn" class="btn btn-primary">Submit</button>

                            <button class="btn btn-primary  w-100 mt-3 razorpay-btn btn-submit"  style="border-radius:0px;" id="razorpay-btn" type="button" >Purchase</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
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
      }else if (this.value == "Card Swip"||this.value == "QRCodeWithSlip") {
          $("#cash_amount").hide();
          $("#change_amount").hide();
          $('#cash-btn').show(); 
          $('#razorpay-btn').hide();
      }
       else {
          $("#cash_amount").hide();
          $("#change_amount").hide();
          $('#cash-btn').hide(); 
          $('#razorpay-btn').show();
      }
  });

  $("#cash_amount").keyup(function(){
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
            
               var mobile_no = $('.mobile_no').val();

           
           
                var data = {
                    'grand_total': grand_total,
                    'order_id': order_id,
                     'mobile_no':mobile_no,
                    
                     }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    method: "post",
                    url: "{{ url('/') }}/admin/proceed-to-pay-takeway",
                    data: data,
                    success: function(response) {
                        // console.log(response.grand_total);
                        var options = {
                            "key": "rzp_test_T6cYO2ODoHQ6A9", // Enter the Key ID generated from the Dashboard
                            // "amount": 1*100 , // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                             "amount":response.grand_total*100 , // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": "DunkalBevarage",                     
                            "description": "Thank For chooseing us",
                            "image": "https://example.com/your_logo",
                            // "order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function(razorpayresponse) {
                                // alert(razorpayresponse.razorpay_payment_id);
                                $.ajax({

                                    method: "post",
                                    url: "{{ url('/') }}/admin/takeorder-checkout-save/"+ order_id,
                                    data: {
                                        'grand_total': response.grand_total,
                                        'order_id': response.order_id,
                                         'mobile_no': response.mobile_no,
                                        'payment_mode': 'Paid by Razorpay',
                                        'payment_id': razorpayresponse.razorpay_payment_id,
                                             
                                    },
                                    success: function(
                                        razorpaysuccesresponse) {
                                        swal(razorpaysuccesresponse
                                                .status)
                                            .then((value) => {
                                                // window.location.reload();
                                                window.location.href = "{{ url('/') }}/admin/today-Take-away-orderSlip/"+ order_id;
                                                // var url = "{{ url('/') }}/admin/today-Take-away-orderSlip/"+ order_id;
                                                // window.open(url, '_blank');
                                                // window.location = document.referrer;

                                            });


                                    }
                                });
                            },
                            "prefill": {
                            //   "name": response.firstname + ' ' + response.lastname,
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