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

                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Take Table Order</h3>
                        </div>

                        <div class="card-body">
                            <form method="post" action="{{ url('admin/take-order/' . $gettableselect['id']) }}"
                                class="forms-sample">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-fields product_data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h5>Selected Table<span class="text-danger">*</span></h5>
                                                        <div class="controls">

                                                            <input type="text"
                                                                value="{{ $gettableselect['table_name'] }}-{{ $gettableselect['table_type'] }}"
                                                                class="form-control" readonly>
                                                            <input type="hidden" name="table_id"
                                                                value="{{ $gettableselect['id'] }}" class="form-control"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h5>Enter Total No Of Person To Serve <span
                                                                class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="total_no_person_intable"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="payableamt">PayAble Mode</label>
                                                        <select
                                                            class="form-control payableamt @error('payableamt') is-invalid @enderror"
                                                            id="payableamt" name="payableamt" required>
                                                            <option value="">Select PayAble Mode</option>
                                                            <option id="General" value="General">General</option>
                                                            <option id="NC" value="NC">NC</option>
                                                        </select>
                                                        @error('payableamt')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="nc_remark">
                                                    <div class="form-group">
                                                        <h5>Nc Remark<span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="nc_remark" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Select Item <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select id="item_id" class="form-control select2bs4" style="width: 100%;"
                                                                aria-label="Default select example">
                                                                <option selected="">Open this select menu</option>
                                                                @foreach ($menuitems as $menuitem)
                                                                    <option value="{{ $menuitem->id }}">
                                                                        {{ $menuitem->menu_item_name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div> <!-- // end form group -->
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5>Item Price <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" id="price"
                                                                class="form-control itemprice" readonly>
                                                            <input type="hidden" id="itemtype"
                                                                class="form-control itemtype" readonly>
                                                            <input type="hidden" id="menu_subcat_id"
                                                                class="form-control menu_subcat_id" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="padding-top: 25px;">
                                                    <span class="btn btn-success addeventmore" id="add-more-field"><i
                                                            class="fa fa-plus-circle"></i> </span>
                                                </div>

                                            </div>

                                        </div> <!-- end Row -->

                                        {{-- kkkkk --}}
                                        <div class="card-body">

                                            <table class="  table table-bordered table-hover dataTable dtr-inline"
                                                aria-describedby="example1_info" width="100%"
                                                style="border-color: #ddd;">
                                                <thead>
                                                    <tr>
                                                        <th> Serve Time</th>
                                                        <th>Remark</th>
                                                        <th>Item Name </th>
                                                        <th>Extra Item</th>
                                                        <th>Extra Item Price</th>
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

   <td><input type="text" name="item_serve_time[]"   placeholder="Enter The Serve of Selected Item " class="form-control"></td>
   <td><input type="text" name="remark[]"   placeholder="Enter Item Remark " class="form-control"></td>
    <td>
        <input type="hidden" name="item_id[]" class="item_id" value="@{{item_id}}">
        @{{ menu_item_name }}
    </td>
    <td>
        <select id="extra_menu_item_id" name="extra_menu_item_id[]" class="form-control extra_menu_item_id" onchange="getExtraMenuPrice(this);" aria-label="Default select example">
            <option value="">Open this select Extra Menu Item</option>
            @foreach($getExtraitem as $extramenu)
            <option value="{{ $extramenu->id }}">{{ $extramenu->extra_menu}}</option>
            @endforeach
        </select>
    </td>
    <td>

        <input type="text" name="extraItemPrice[]" class="form-control bg-warning extraItemPrice" id="extraItemPrice" readonly>
    </td>
     <td>
        <input type="text" name="price[]" value="@{{price}}"  class="form-control bg-warning " readonly>
        <input type="hidden" name="itemtype[]" value="@{{itemtype}}"  class="form-control bg-warning " readonly>
        <input type="hidden" name="menu_subcat_id[]" value="@{{menu_subcat_id}}"  class="form-control bg-warning " readonly>
    </td>
     <td>
        <input type="number" min="1" class="form-control item_qty text-right" name="item_qty[]"  value="1" required onkeyup="getoffer(this);">
    </td>

    <td>
        <input type="text" name="no_of_qty_buy[]" class="form-control bg-warning no_of_qty_buy" readonly>
    </td>

 <td>
    <input type="text" name="no_qty_buy_to_free[]" class="form-control no_qty_buy_to_free">
</td>
     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
    </td>

    </tr>

</script>
    <script src="{{ url('/') }}/admin_assets/handlebars.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".addeventmore", function() {
                var item_id = $('#item_id').val();
                var menu_item_name = $('#item_id').find('option:selected').text();
                var price = $('#price').val();
                var itemtype = $('#itemtype').val();
                var menu_subcat_id = $('#menu_subcat_id').val();

                if (item_id == '') {
                    $.notify("Menu is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });

                    return false;
                }
                if (price == '') {
                    $.notify("Menu Price is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });

                    return false;
                }
                var source = $("#document-template").html();
                var tamplate = Handlebars.compile(source);
                var data = {

                    item_id: item_id,
                    price: price,
                    itemtype: itemtype,
                    menu_subcat_id: menu_subcat_id,
                    menu_item_name: menu_item_name,



                };
                var html = tamplate(data);
                // $("#addRow").append(html);
                $("#addRow").after(html);
            });

            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_add_more_item").remove();

            });



        });
    </script>
    <script>
        function getoffer(ele) {
            var item_id = $(ele).closest('tr').find('.item_id').val();
            var item_qty = $(ele).closest('tr').find('.item_qty').val();
            $.ajax({
                url: "{{ url('/') }}/admin/getoffer/" + item_id + "/" + item_qty,
                dataType: "json",
                success: function(data) {
                   $(ele).closest('tr').find('input.no_of_qty_buy').val(data.no_of_qty_buy);
                    $(ele).closest('tr').find('input.no_qty_buy_to_free').val(data.no_qty_buy_to_free);

                }
            });
        }

        function getExtraMenuPrice(ele) {
            var extra_menu_item_id = $(ele).closest('tr').find('.extra_menu_item_id').val();
            $.ajax({
                url: "{{ url('/') }}/admin/extraMenuPrice/" + extra_menu_item_id,
                dataType: "json",
                success: function(data) {
                    $(ele).closest('tr').find('input.extraItemPrice').val(data.data[0].price);

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

                    dataType: "json",
                    success: function(data) {

                        $('#price').val(data.data[0].menu_item_price);
                        $('#itemtype').val(data.data[0].type);
                        $('#menu_subcat_id').val(data.data[0].menu_subcat_id);

                    }
                })
            });
        });
    </script>

@endsection
@section('script')
    <script>
        $("#nc_remark").hide();
        $(document).ready(function() {
            $('#payableamt').on('change', function() {
                if (this.value == 'NC') {
                    $("#nc_remark").show();
                } else {
                    $("#nc_remark").hide();
                }
            });
        });
    </script>

@endsection
