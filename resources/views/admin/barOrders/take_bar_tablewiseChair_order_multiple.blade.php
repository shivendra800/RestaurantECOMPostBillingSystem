@extends('admin.layouts.layout')
@section('title',"Take Table Bar Order")
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Take Table Bar Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Take Table Bar Order</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <div class="card">
        {{-- <div class="card-header bg-warning text-center">
            <h3 class="card-title  "> Offer List</h3>

        </div> --}}
        <!-- /.card-header -->

        {{-- <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="  table table-bordered table-hover dataTable dtr-inline bg-secondary" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Offer</th>
                                <th>Validity</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productWiseCoupon as $index=>$itemcoupon)
                            <tr id="tr_{{$itemcoupon['id']}}">


                                <td>{{ $itemcoupon['menuitem']['menu_item_name'] }}</td>
                                <td class="badge badge-danger">Buy {{ $itemcoupon['no_of_qty_buy'] }} Get {{ $itemcoupon['no_qty_buy_to_free'] }} Free</td>


                                <td>{{ \Carbon\Carbon::parse($itemcoupon['start_date'])->isoFormat('MMM Do YYYY')}} - {{ \Carbon\Carbon::parse($itemcoupon['expiry_date'])->isoFormat('MMM Do YYYY')}}</td>
                            </tr>
                            @endforeach


                        </tbody>

                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="  table table-bordered table-hover dataTable dtr-inline bg-secondary" aria-describedby="example1_info">

                        <thead>
                            <tr>
                                <th>Offer</th>

                                <th>Validity</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupononprice as $index=>$itemcoupon)
                            <tr id="tr_{{$itemcoupon['id']}}">


                                <td class="badge badge-danger">{{ $itemcoupon['offer_per'] }}% On Order Above Rs.{{ $itemcoupon['order_amount'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($itemcoupon['start_date'])->isoFormat('MMM Do YYYY')}} - {{ \Carbon\Carbon::parse($itemcoupon['expiry_date'])->isoFormat('MMM Do YYYY')}}</td>


                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div> --}}
        <!-- /.card-body -->
    </div>

</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Take Table Bar Order</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <!-- /.box-header -->
                    <div class="card-body">


                        <form method="post" action="{{ url('admin/take-bar-tableWiseChair-order/'.$gettableselect['id']) }}" class="forms-sample">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-fields product_data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5>Selected Table<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                       
                                                        <input type="text" value="{{ $gettableselect['table_name'] }}" class="form-control" readonly>
                                                        <input type="hidden" name="table_id" value="{{ $gettableselect['id'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5>Enter Total No Of Person To Serve <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="number" name="total_no_person_intable" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Select Chairs <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select id="chairs_id" class="form-control select2" aria-label="Default select example">
                                                            <option selected="">Open this select Chairs</option>
                                                            @foreach($gtChairTablwWise as $chairs)
                                                            <option value="{{ $chairs->id }}">{{ $chairs->chair_name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div> <!-- // end form group -->
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Select Item <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select id="item_id" class="form-control select2" aria-label="Default select example">
                                                            <option selected="">Open this select menu</option>
                                                            @foreach($menuitems as $menuitem)
                                                            <option value="{{ $menuitem->id }}">{{ $menuitem->menu_item_name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div> <!-- // end form group -->
                                            </div>




                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <h5>Item Price <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" id="price" class="form-control itemprice" readonly>
                                                        <input type="hidden" id="itemtype" class="form-control itemtype" readonly>
                                                        <input type="hidden" id="menu_subcat_id" class="form-control menu_subcat_id" readonly>
                                                        <input type="hidden" id="bar_tax_percentage" class="form-control bar_tax_percentage" readonly>

 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 25px;">
                                                <span class="btn btn-success addeventmore" id="add-more-field"><i class="fa fa-plus-circle"></i> </span>
                                            </div>


                                        </div>





                                    </div> <!-- end Row -->








                                    {{-- kkkkk --}}
                                    <div class="card-body">

                                        <table class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info" width="100%" style="border-color: #ddd;">
                                            <thead>
                                                <tr>
                                                    <th>Chairs Name</th>
                                                    <th>Item Serve Time</th>
                                                    <th>Menu Item Name </th>
                                                    <th>Price</th>
                                                    <th> QTY</th>
                                                    <th>Buy Item Qty</th>
                                                    <th>Get Free Item Qty</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>

                                            <tbody id="addRow" class="addRow">

                                            </tbody>


                                        </table><br>


                                    </div> <!-- End card-body -->
                                    <div class="text-xs-right">
                                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                    </div>
                        </form>




                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
    </div>
</section>





<script id="document-template" type="text/x-handlebars-template">

    <tr class="delete_add_more_item" id="delete_add_more_item">
   <td>
    <input type="hidden" name="chairs_id[]" class="chairs_id" value="@{{chairs_id}}">
    @{{ chair_name }}
    </td>
   <td><input type="text" name="item_serve_time[]"  required placeholder="Enter The Serve of Selected Item " class="form-control"></td>
    <td>
        <input type="hidden" name="item_id[]" class="item_id" value="@{{item_id}}">
        @{{ menu_item_name }}
    </td>

     <td>
        <input type="text" name="price[]" value="@{{price}}"  class="form-control bg-warning " readonly>
        <input type="hidden" name="itemtype[]" value="@{{itemtype}}"  class="form-control bg-warning " readonly>
        <input type="hidden" name="menu_subcat_id[]" value="@{{menu_subcat_id}}"  class="form-control bg-warning " readonly>
        <input type="hidden" name="bar_tax_percentage[]" value="@{{bar_tax_percentage}}"  class="form-control bg-warning " readonly>
    </td>

     <td>
        <input type="number" min="1" class="form-control item_qty text-right" name="item_qty[]"  value="" required onkeyup="getoffer(this);"> 
     

    </td>

    <td>
        <input type="text" name="no_of_qty_buy[]" class="form-control bg-warning no_of_qty_buy" readonly>
    </td>

 <td>
    <input type="text" name="no_qty_buy_to_free[]" class="form-control bg-warning no_qty_buy_to_free"readonly>
</td>

    

     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
    </td>

    </tr>

</script>
<script src="{{url('/')}}/admin_assets/handlebars.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".addeventmore", function() {
            var chairs_id = $('#chairs_id').val();
            var chair_name = $('#chairs_id').find('option:selected').text();
            var item_id = $('#item_id').val();
            var menu_item_name = $('#item_id').find('option:selected').text();
            var price = $('#price').val();
            var itemtype = $('#itemtype').val();
            var menu_subcat_id = $('#menu_subcat_id').val();
            var bar_tax_percentage = $('#bar_tax_percentage').val();
           

            if(chairs_id == ''){
                $.notify("chair  is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
                 }
          
            if (item_id == '') {
                $.notify("Menu is Required", {
                    globalPosition: 'top right'
                    , className: 'error'
                });
                // alert("Menu is Required");
                return false;
            }
            if (price == '') {
                $.notify("Menu Price is Required", {
                    globalPosition: 'top right'
                    , className: 'error'
                });
                // alert("Menu Price is Required");
                return false;
            }




            var source = $("#document-template").html();
            var tamplate = Handlebars.compile(source);
            var data = {

                item_id: item_id
                , chairs_id: chairs_id
                , chair_name: chair_name
                , price: price
                , bar_tax_percentage: bar_tax_percentage
                , itemtype: itemtype
                , menu_subcat_id: menu_subcat_id
                , menu_item_name: menu_item_name,
                


            };
            var html = tamplate(data);
            $("#addRow").append(html);
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
</script>

<script>
    function getoffer(ele) {
        // var item_id = $(".item_id").val();
        var item_id = $(ele).closest('tr').find('.item_id').val();
        var item_qty = $(ele).closest('tr').find('.item_qty').val();

        // alert(item_qty);
        $.ajax({
            url: "{{ url('/') }}/admin/getoffer/" + item_id + "/" + item_qty
            , dataType: "json"
            , success: function(data) {
                //  console.log("data", data);
                console.log("hhghg", data.no_qty_buy_to_free);
                // var price = document.getElementById("price").value = data.data[0].menu_item_price;
                $(ele).closest('tr').find('input.no_of_qty_buy').val(data.no_of_qty_buy);
                $(ele).closest('tr').find('input.no_qty_buy_to_free').val(data.no_qty_buy_to_free);


            }
        });
    }
</script>




<script type="text/javascript">
    $(function() {
        $(document).on('change', '#item_id', function() {
            var item_id = $(this).val();
            $.ajax({
                url: "{{ url('/') }}/admin/getItemprice/" + item_id,

                dataType: "json"
                , success: function(data) {

                    $('#price').val(data.data[0].menu_item_price);
                    $('#itemtype').val(data.data[0].type);
                    $('#menu_subcat_id').val(data.data[0].menu_subcat_id);
                    $('#bar_tax_percentage').val(data.data[0].bar_tax_percentage);




                }
            })
        });
    });
</script>








@endsection