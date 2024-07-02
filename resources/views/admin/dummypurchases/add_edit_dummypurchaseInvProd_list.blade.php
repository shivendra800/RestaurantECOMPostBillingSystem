@extends('admin.layouts.layout')

@section('title', 'Make Purchase Product Note')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Make Purchase Product Note</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Make Purchase Product Note</li>

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
                        <h3 class="card-title"> Product Search</h3>
                        <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/Dummypurchase-inv-product') }}" class="btn btn-block btn-info">Back</a>

                    </div>

                    <form class="forms-sample" action="{{ url('admin/add-edit-DummyPurchaseInvProdIndexearch') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Vendor Type</label>
                                        <select class="form-control @error('v_type_id') is-invalid @enderror" name="v_type_id" onchange="getVendor();" id="v_type_id">
                                            <option value="">Select Vendor Type</option>
                                            @foreach ($Vendortype as $VType)
                                            <option value="{{ $VType['id'] }}" {{ old('v_type_id') == $VType['id'] ? 'selected' : '' }}>
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
                                        <select class="form-control v_tye_wise_id @error('v_wise_type_id') is-invalid @enderror" name="v_tye_wise_id" id="v_tye_wise_id" onchange="getPreAmt();">
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




    </div>
    <div class="row">

        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Make Purchase Product Note</h3>
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/Dummypurchase-inv-product') }}" class="btn btn-block btn-info">Back</a>

                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="forms-sample" action="{{ url('admin/add-edit-DummyPurchaseInvProdIndex') }}" method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body ">
                        <div class="row input-fields product_data">
                           
                            @if(!empty($vendor_pre_value))

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Search Vendor Name</label>
                                    <input type="text" class="form-control" readonly value="{{$vendor_pre_value->vendor_name}}">
                                    <input type="hidden" class="form-control" name="v_tye_wise_id" readonly value="{{$vendor_pre_value->id}}">
                                    <input type="hidden" name="v_type_id" class="form-control" readonly value="{{$vendor_pre_value->vendor_type}}">
                                </div>
                            </div>
                            @endif

                        </div>

                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Unit</th>
                                    <th>Buy Qty</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Product as $index => $ingredient)
                                <tr class="product_data">

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ingredient->ingredient_name }}
                                        <input type="hidden" name="product_id[]" class="form-control product_id" value="{{ $ingredient->product_id}}">
                                    </td>
                                    <td style="color:red;">{{ $ingredient->unit_name }}
                                        <input type="hidden" name="unit_id[]" class="form-control unit_id" value="{{ $ingredient->unit_id}}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control qty @error('qty') is-invalid @enderror" name="qty[]" id="qty" placeholder="Enter Your Buy Qty" onkeyup="CalculateTotal(this)" >
                                        @error('qty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                



                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/') }}/admin/Dummypurchase-inv-product" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->


        </div>

    </div>
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
        getCategory();
        getunit();


    });

    function getVendor() {
        var v_type_id = $("#v_type_id").val();
        // alert(state_id);

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