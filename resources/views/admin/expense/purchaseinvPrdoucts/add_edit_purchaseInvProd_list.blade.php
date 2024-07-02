@extends('admin.layouts.layout')

@section('title', 'Capital Purchase Product')

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
                <h1>Capital Purchase Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Capital Purchase Product</li>

                </ol>
            </div>



        </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="container-fluid">
        <!-- search --->
        @if(!empty($vendor_pre_value))
       
        @else
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
               
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Search External Wise Vendor Assign Product</h3>
                        <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/capital-purchaseInvList') }}" class="btn btn-block btn-info">Back</a>

                    </div>

                    <form class="forms-sample" action="{{ url('admin/add-edit-CapitalPurchaseInvProdIndexearch') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Vendor Type</label>
                                        <select class="form-control @error('v_type_id') is-invalid @enderror" name="v_type_id" onchange="getVendor();" id="v_type_id" required>
                                            <option value="">Select Vendor Type</option>
                                            @foreach ($getExternalVendor as $VType)
                                            <option value="{{ $VType['vendor_type'] }}" {{ old('v_type_id') == $VType['id'] ? 'selected' : '' }}>
                                                {{ $VType['vendor_type'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('v_type_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Vendor</label>
                                        <select class="form-control v_tye_wise_id @error('v_wise_type_id') is-invalid @enderror" name="v_tye_wise_id" required id="v_tye_wise_id" onchange="getPreAmt();">
                                            <option value="">Select Vendor</option>

                                        </select>
                                        @error('v_wise_type_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>



                    </form>




                </div>
            </div>
        </div>
        @endif




    </div>
    @if(!empty($vendor_pre_value))
    <div class="row">

        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Purchase Product</h3>
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/capital-purchaseInvList') }}" class="btn btn-block btn-info">Back</a>

                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="forms-sample" action="{{ url('admin/add-edit-CapitalPurchaseInvProdIndex') }}" method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body ">
                        <div class="row input-fields product_data">
                            @if(!empty($vendor_pre_value))

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Search Vendor Name</label>
                                    <input type="text" class="form-control" readonly value="{{$vendor_pre_value->vendor_name}}">
                                    <input type="hidden" class="form-control" name="vendor_id" readonly value="{{$vendor_pre_value->id}}">
                                  
                                </div>
                            </div>
                            @endif

                        </div>

                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Product Name</th>                                  
                                    <th>Buy Price</th>
                                    <th>Buy Qty</th>                                 
                                    <th>Amount</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Product as $index => $ingredient)
                                <tr class="product_data">

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ingredient->ext_product_name }}
                                        <input type="hidden" name="product_id[]" class="form-control product_id" value="{{ $ingredient->ext_product_id}}">
                                    </td>
                                 
                                    <td>
                                        <input type="number" class="form-control price @error('price') is-invalid @enderror" name="price[]"  id="price" placeholder="Enter Your Price" onkeyup="CalculateTotal(this)" >
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control qty @error('qty') is-invalid @enderror" name="qty[]" id="qty"  placeholder="Enter Your Qty" onkeyup="CalculateTotal(this)" >
                                        @error('qty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                  
                                    <td>
                                        <input type="text" class="form-control amount @error('amount') is-invalid @enderror" name="amount[]"  id="amount" placeholder="Enter Your Amount" readonly="">
                                        @error('amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                  



                                </tr>
                                @endforeach
                            </tbody>
                        </table>




                        <div class="row">
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
                                    @if(!empty($vendor_pre_value))
                                    <input type="text" class="form-control previous_amount @error('previous_amount') is-invalid @enderror" name="previous_amount" id="previous_amount" value="{{$vendor_pre_value->v_wallet}}" placeholder="Enter Your previous_amount" readonly="">
                                    @error('previous_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @endif
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
                                    <label for="exampleInputEmail1">Paid Amount</label>
                                    <input type="text" class="form-control paid_amount @error('paid_amount') is-invalid @enderror" onkeyup="paymentUpdate()" name="paid_amount" id="paid_amount" placeholder="Enter Your paid_amount" required="">
                                    @error('paid_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remaining Amount</label>
                                    <input type="text" class="form-control remaining_amount @error('remaining_amount') is-invalid @enderror" name="remaining_amount" id="remaining_amount" placeholder="Enter Your remaining_amount" readonly="">
                                    @error('remaining_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select name="payment_mode" id="" class="form-control" required="" >
                                        <option value="">Select Payment Mode</option>
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
                    <!-- /.card-body -->

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/') }}/admin/ingredient" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->


        </div>

    </div>
    @endif
    </div>
</section>






@endsection
@section('script')

<script>
    // calculate one div class->product_data toatal amount 
    function CalculateTotal(ele) {
        var price = $(ele).closest('.product_data').find('.price').val(); // rate
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
        var w = parseInt(u) - parseInt(v);
        document.getElementById('remaining_amount').value = w;

    }
</script>


<script>
    $(document).ready(function() {
        getVendor();
        


    });

    function getVendor() {
        var v_type_id = $("#v_type_id").val();
        // alert(state_id);

        var v_tye_wise_id = "{{ old('v_tye_wise_id') }}";

        $.ajax({
            url: "{{ url('/') }}/admin/getExtrentalVendor/" + v_type_id
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

    function getunit(ele) {
        // var product_id = $(".product_id").val();


        var product_id = $(ele).closest('.product_data').find('.product_id').val(); // rate
        //   alert(product_id);




        $.ajax({
            url: "{{ url('/') }}/admin/getunit/" + product_id
            , dataType: "json"
            , success: function(data) {
                // console.log("data", data);
                var option = "<option value=''>Select Unit</option>";
                for (var i = 0; i < data.data.length; i++) {
                    if (v_type_id == data.data[i].id) {
                        option += "<option selected value=" + data.data[i].id + ">" + data.data[
                                i]
                            .unit_name + "</option>";
                    } else {
                        option += "<option value=" + data.data[i].id + ">" + data.data[i]
                            .unit_name + "</option>";
                    }
                }
                $(ele).closest('.product_data').find('.unit_id').html(option);
                // $(".unit_id").html(option);


            }
        });
    }

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