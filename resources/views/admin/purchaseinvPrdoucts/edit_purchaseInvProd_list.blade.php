@extends('admin.layouts.layout')

@section('title', 'Purchase Product')

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
          {{-- error meg with close button---- --}}
          @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
          {{-- error meg --}}
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Purchase Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Purchase Product</li>

                </ol>
            </div>



        </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="container-fluid">
        <!-- search --->
   
    <div class="row">

        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Purchase Product</h3>
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/purchase-inv-product') }}" class="btn btn-block btn-info">Back</a>

                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="forms-sample" action="{{ url('admin/edit-PurchaseInvProdIndex/'.$purchase['id']) }}" method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body ">
                        <div class="row input-fields product_data">
                            

                            <table class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                                <thead>
                                    <tr>
    
    
                                      
                                        <th>Product Name</th>
                                        <th>Product Unit</th>
                                        <th>Buy Price</th>
                                        <th>Buy Qty</th>
                                        <th>Weight Of 1 Buy QTY</th>
                                        <th>Amount</th>
                                        <th>Product Expire Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getpurchaseitem as $index => $item)
                                    <tr class="product_data">
                                   
                                        <td>{{ $item['product']['ingredient_name'] }}
                                            <input type="hidden" name="product_id[]" value="{{$item['prod_id']}}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="unit_id[]"  value="{{$item['unit']}}">
                                            {{ $item['product']['unit']['unit_name']}}</td>
                                        <td>
                                            <input type="number" step="0.001" min="0" class="form-control price @error('price') is-invalid @enderror" name="price[]"  id="price" placeholder="Enter Your Price" onkeyup="CalculateTotal(this)" value="{{$item['price']}}" >
                                           
                                            @error('price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" step="0.001" min="0" class="form-control qty @error('qty') is-invalid @enderror" name="qty[]" id="qty"  placeholder="Enter Your Qty" onkeyup="CalculateTotal(this)" value="{{$item['qty']}}">
                                            @error('qty')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" step="0.001" min="0" class="form-control weight @error('weight') is-invalid @enderror" name="weight[]" id="weight"  placeholder="Enter Your weight" onkeyup="CalculateTotal(this)" value="{{$item['weight']}}">
                                            @error('weight')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount @error('amount') is-invalid @enderror" name="amount[]"  id="amount" placeholder="Enter Your Amount" readonly="" value="{{$item['total_price']}}">
                                            @error('amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="date" class="form-control product_expire_date @error('product_expire_date') is-invalid @enderror" value="{{ now()->format('Y-m-d') }}" name="product_expire_date[]" id="product_expire_date" placeholder="Enter Your product_expire_date" onkeyup="CalculateTotal(this)" >
                                            @error('product_expire_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                      
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Product Name</label>
                                    <select class="form-control @error('product_id') is-invalid @enderror select2"   id="product_id" onchange="getunit();">
                                        <option value="">Select Product Name</option>
                                        @foreach ($getProduct as $ingredient)
                                        <option value="{{ $ingredient['id'] }}">
                                            {{ $ingredient['ingredient_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <h5>Unit <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select class="form-control unit_id @error('unit_id') is-invalid @enderror"  id="unit_id" readonly>
                                           
                                        </select>
                                        @error('unit_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-top: 25px;">
                                <button class="btn btn-success addeventmore" id="add-more-field"><i class="fa fa-plus-circle"></i>Add </button>
                            </div>
                        


                        </div>


                        <div class="card-body">

                            <table class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info" width="100%" style="border-color: #ddd;">
                                <thead>
                                    <tr>
                                        
                                        <th>Product Name</th>
                                        <th>Product Unit</th>
                                        <th>Buy Qty</th>
                                        <th>Buy Price</th>                                     
                                        <th>Weight Of 1 Buy QTY</th>
                                        <th>Amount</th>
                                        <th>Product Expire Date </th>
                                        <th>Action</th>

                                    </tr>
                                </thead>

                                <tbody id="addRow" class="addRow">

                                </tbody>


                            </table><br>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Order Mode</label>
                                    <select name="order_taken" id="order_taken" class="form-control" required="" >
                                        <option value="">Select Order Mode</option>
                                        <option
                                           value="full-order-added" 
                                        @if (old('order_taken') == 'full-order-added') selected @endif  value="full-order-added">full-order-added</option>
                                        <option
                                           value="more-orderWillTake" 
                                        @if (old('order_taken') == 'more-orderWillTake') selected @endif  value="more-orderWillTake">more-orderWillTake</option>
                                    </select>
                                    @error('order_taken')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" id="openwithpayment">
                                <div class="col md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Total Bill</label>
                                        <input type="text" class="form-control total_bill @error('total_bill') is-invalid @enderror" name="total_bill" id="total_bill" placeholder="Enter Your total_bill" readonly="">
                                        @error('total_bill')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col md-4">
                                    <div class="form-group">
    
                                        <label for="exampleInputEmail1">Previous Amount</label>
                                     
                                        <input type="text" class="form-control previous_amount @error('previous_amount') is-invalid @enderror" name="previous_amount" id="previous_amount" value="{{ $getVendorPrivAmt['v_wallet']  }}" placeholder="Enter Your previous_amount" readonly="">
                                        @error('previous_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                       
                                    </div>
                                </div>
                                <div class="col md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Grand Total</label>
                                        <input type="text" class="form-control grand_total @error('grand_total') is-invalid @enderror" name="grand_total" id="grand_total" placeholder="Enter Your grand_total" readonly="">
                                        @error('grand_total')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                   <div class="col md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Expense Amt</label>
                                        <input type="text" class="form-control expense_amt @error('expense_amt') is-invalid @enderror" onkeyup="paymentUpdate()" name="expense_amt" id="expense_amt" placeholder="Enter Your expense_amt" >
                                        @error('expense_amt')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Paid Amount</label>
                                        <input type="text" step="0.001" min="0" class="form-control paid_amount @error('paid_amount') is-invalid @enderror" onkeyup="paymentUpdate()" name="paid_amount" id="paid_amount" placeholder="Enter Your paid_amount" >
                                        @error('paid_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Remaining Amt</label>
                                        <input type="text" class="form-control remaining_amount @error('remaining_amount') is-invalid @enderror" name="remaining_amount" id="remaining_amount" placeholder="Enter Your remaining_amount" readonly="">
                                        @error('remaining_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select name="payment_mode" id="" class="form-control"  >
                                            <option value="">Select Payment Mode</option>
                                            <option
                                               value="No-Payment" 
                                            @if (old('payment_mode') == 'No-Payment') selected @endif  value="No-Payment">No-Payment</option>
                                            <option
                                               value="Cash" 
                                            @if (old('payment_mode') == 'Cash') selected @endif  value="Cash">Cash</option>
                                            <option
                                                 value="Account" 
                                           @if (old('payment_mode') == 'Account') selected @endif  value="Account">Account</option>
                                            <option
                                               value="Upi"  
                                            @if (old('payment_mode') == 'Upi') selected @endif  value="Upi">Upi</option>
                                            <option
                                                value="Check" 
                                             @if (old('payment_mode') == 'Check') selected @endif  value="Check">Check</option>
                                        </select>
                                        @error('payment_mode')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>





                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/') }}/admin/purchase-inv-product" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->


        </div>

    </div>
    </div>
</section>


<script id="document-template" type="text/x-handlebars-template">
   

    <tr class="delete_add_more_item product_data" id="delete_add_more_item">

       
    <td>
        <input type="hidden" name="product_id[]" class="product_id" value="@{{product_id}}">
        @{{ menu_item_name }}
    </td>
    <td>
        <input type="hidden" name="unit_id[]" class="unit_id" value="@{{unit_id}}">
        @{{ unit_name }}
    </td>
    <td>
        <input type="number" required step="0.001" min="0" class="form-control qty @error('qty') is-invalid @enderror" name="qty[]" id="qty"  placeholder="Enter Your Qty" onkeyup="CalculateTotal(this)" >
        @error('qty')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>
    <td>
        <input type="number" required step="0.001" min="0" class="form-control price @error('price') is-invalid @enderror" name="price[]"  id="price" placeholder="Enter Your Price" onkeyup="CalculateTotal(this)" >
        @error('price')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>
   
    <td>
        <input type="number" required step="0.001" min="0" class="form-control weight @error('weight') is-invalid @enderror" name="weight[]" id="weight"  placeholder="Enter Your weight" onkeyup="CalculateTotal(this)" >
        @error('weight')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control amount @error('amount') is-invalid @enderror" name="amount[]"  id="amount" placeholder="Enter Your Amount" readonly="">
        @error('amount')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>
    <td>
        <input type="date" class="form-control product_expire_date @error('product_expire_date') is-invalid @enderror" value="{{ now()->format('Y-m-d') }}" name="product_expire_date[]" id="product_expire_date" placeholder="Enter Your product_expire_date" onkeyup="CalculateTotal(this)" >
        @error('product_expire_date')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </td>

    

     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
    </td>

    </tr>

</script>


<script src="{{url('/')}}/admin_assets/handlebars.js"></script>
@endsection
@section('script')
<script>
      
    $(document).ready(function() {
    
    $("#openwithpayment").hide();
    $("#order_taken").on("change", function() {
     
        if (this.value == "full-order-added") {
            $("#openwithpayment").show();
          
        }
         else {
            $("#openwithpayment").hide();
           
        }
    });
  
   
  
  
  });
  </script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".addeventmore", function() {
            var product_id = $('#product_id').val();
            var menu_item_name = $('#product_id').find('option:selected').text();
            var unit_id = $('#unit_id').val();
            var unit_name = $('#unit_id').find('option:selected').text();
          
            if (product_id == '') {
                $.notify("Menu is Required", {
                    globalPosition: 'top right'
                    , className: 'error'
                });
                // alert("Menu is Required");
                return false;
            }
            if (unit_id == '') {
                $.notify("Product unit  is Required", {
                    globalPosition: 'top right'
                    , className: 'error'
                });
                // alert("Menu Price is Required");
                return false;
            }




            var source = $("#document-template").html();
            var tamplate = Handlebars.compile(source);
            var data = {

                product_id: product_id,
                menu_item_name: menu_item_name,
                unit_id: unit_id,
                unit_name: unit_name,
                


            };
            var html = tamplate(data);
            // $("#addRow").append(html);
            $("#addRow").after(html);
        });

        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice();
        });

      
        // Calculate sum of amout in invoice 

        function totalAmountPrice() {
            var sum = 0;
            $(".buying_price").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            $('#estimated_amount').val(sum);
        }

    });

    function getunit() {
        
       
        var product_id = $("#product_id").val();
      // alert(product_id);

        $.ajax({
            url: "{{ url('/') }}/admin/getunit/" + product_id
            , dataType: "json"
            , success: function(data) {
            //    console.log("data", data);
               var option = "";
                option = "<option selected value=" + data.data[0].id + ">" + data.data[0].unit_name + "</option>";
               
                $("#unit_id").html(option);
                // var option = "";
                // for (var i = 0; i < data.data.length; i++) {
                //     if (v_type_id == data.data[i].id) {
                //         option += "<option selected value=" + data.data[i].id + ">" + data.data[
                //                 i]
                //             .unit_name + "</option>";
                //     } else {
                //         option += "<option value=" + data.data[i].id + ">" + data.data[i]
                //             .unit_name + "</option>";
                //     }
                // }
               
                // $("#unit_id").html(option);


            }
        });
    }
</script>

<script>
     $(document).ready(function() {
        CalculateTotal();
        Calculate();
        paymentUpdate();
     });
    // calculate one div class->product_data toatal amount 
    function CalculateTotal(ele) {
        
        var price = $(ele).closest('.product_data').find('.price').val(); // rate
        // alert(price);
        var qty = $(ele).closest('.product_data').find('.qty').val(); //quanity
        // var expense = $(ele).closest('.product_data').find('.expense').val();
        price = price == '' ? 0 : price;
        qty = qty == '' ? 0 : qty;
        // expense = expense == '' ? 0 : expense;
        if (!isNaN(price) && !isNaN(qty)) {
            // calculate all three data 
            var total = parseFloat(price) * parseFloat(qty);
            // set data in toatal price
            $(ele).closest('.product_data').find('.amount').val(total.toFixed(2));
        }
        Calculate() // here for auto set total billing amount 
    } //end here calculate one div class->product _data total amount 

    


    function Calculate() {
        var totalbilling = 0;
        $(".amount").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
                totalbilling += parseFloat(this.value);

            }
            var sub_total_billing = document.getElementById("grand_total").value = totalbilling;
            //total bill today  
            document.getElementById('total_bill').value = sub_total_billing;
            // previos bill balance
            var previous_amount = document.getElementById('previous_amount').value;
            // grand total bill
            var grand_total_balance = parseInt(sub_total_billing) + parseInt(previous_amount);

            document.getElementById('grand_total').value = grand_total_balance;

        });
    } // end total balance

    // remaining balance on click pay now input
    function paymentUpdate() {
        var u = document.getElementById('grand_total').value;
        var v = document.getElementById('paid_amount').value;
         var exp = document.getElementById('expense_amt').value;
        var w = parseInt(u) - parseInt(v) + parseInt(exp);
        document.getElementById('remaining_amount').value = w;

    }


</script>


<script>
    $(document).ready(function() {
        getVendor();
        getCategory();
      //   getunit();
// 

    });

    function getVendor() {
        var v_type_id = $("#v_type_id").val();
      //alert(v_type_id);

        var v_tye_wise_id = "{{ old('v_tye_wise_id') }}";

        $.ajax({
            url: "{{ url('/') }}/admin/getVendor/" + v_type_id
            , dataType: "json"
            , success: function(data) {
              // console.log("data", data);
                var option = "<option value=''>Select Vendor</option>";

                for (var i = 0; i < data.data.length; i++) {

                    if (v_type_id == data.data[i].id) {
                        option += "<option selected value=" + data.data[i].id + ">" + data.data[
                                i]
                            .vendor_name + "</option>";
                    } else {
                        option += "<option value=" + data.data[i].id + ">" + data.data[i]
                            .vendor_name + "</option>";
                    }
                }
                $("#v_tye_wise_id").html(option);


            }
        });
    }

    function getCategory() {
        var c_type_id = $("#c_type_id").val();
        // alert(state_id);s

        var c_tye_wise_id = "{{ old('c_tye_wise_id') }}";


        $.ajax({
            url: "{{ url('/') }}/admin/getCategory/" + c_type_id
            , dataType: "json"
            , success: function(data) {
                // console.log("data", data);
                var option = "<option value=''>Select Category</option>";
                for (var i = 0; i < data.data.length; i++) {
                    if (v_type_id == data.data[i].id) {
                        option += "<option selected value=" + data.data[i].id + ">" + data.data[
                                i]
                            .category_name + "</option>";
                    } else {
                        option += "<option value=" + data.data[i].id + ">" + data.data[i]
                            .category_name + "</option>";
                    }
                }
                $("#c_tye_wise_id").html(option);


            }
        });
    }

    // function getunit(ele) {
    //     // var product_id = $(".product_id").val();


    //     var product_id = $(ele).closest('.product_data').find('.product_id').val(); // rate
    //     //   alert(product_id);




    //     $.ajax({
    //         url: "{{ url('/') }}/admin/getunit/" + product_id
    //         , dataType: "json"
    //         , success: function(data) {
    //             // console.log("data", data);
    //             var option = "<option value=''>Select Unit</option>";
    //             for (var i = 0; i < data.data.length; i++) {
    //                 if (v_type_id == data.data[i].id) {
    //                     option += "<option selected value=" + data.data[i].id + ">" + data.data[
    //                             i]
    //                         .unit_name + "</option>";
    //                 } else {
    //                     option += "<option value=" + data.data[i].id + ">" + data.data[i]
    //                         .unit_name + "</option>";
    //                 }
    //             }
    //             $(ele).closest('.product_data').find('.unit_id').html(option);
    //             // $(".unit_id").html(option);


    //         }
    //     });
    // }

    function getPreAmt() {
        var v_tye_wise_id = $("#v_tye_wise_id").val();
        //  alert(v_tye_wise_id);

        $.ajax({
            url: "{{ url('/') }}/admin/vendor_wise_previous_balance/" + v_tye_wise_id
            , dataType: "json"
            , success: function(data) {
                //  console.log("data", data);
                // console.log("hhghg",data.data.v_wallet);
                var previous_amount = document.getElementById("previous_amount").value = data.data.v_wallet;



            }
        });
    }
</script>


@endsection