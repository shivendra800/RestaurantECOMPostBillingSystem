@extends('admin.layouts.layout')
@section('title', 'View Order List')

@section('content')
    <script src="{{ url('/') }}/admin_assets/3.5.1-jquery.min.js"></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Order List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('admin.errors.all_mesg')
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> View Order List</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Order Information</h4><br>
                                    <div class="form-group">
                                        <label>Order No </label>
                                        <input class="form-control" value="{{ $orderlist['order_no'] }}" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label>Table Type</label>
                                        @if ($orderlist['tables'] && $orderlist['tables']['table_name'])
                                            <input class="form-control" value="{{ $orderlist['tables']['table_name'] }}"
                                                readonly="">
                                        @else
                                            NA
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label>Transfer Table Remark</label>
                                        <input class="form-control" value="{{ $orderlist['tran_table_remark'] }}"
                                            readonly="">
                                    </div>

                                    <div class="form-group">
                                        <label>Order Date</label>
                                        <input class="form-control"
                                            value="{{ \Carbon\Carbon::parse($orderlist['created_at'])->isoFormat('MMM Do YYYY') }}"
                                            readonly="">
                                    </div>
                                </div>
                            </div>

                            @if (Auth::guard('admin')->user()->type == 'Admin')
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Table Order Wise Tax List</h4><br>

                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th style="width: 40px">Tax Name</th>
                                                <th style="width: 40px">Tax Percentage</th>
                                                <th style="width: 40px">Tax On SubTotal Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($OrderWisetaxdet as $index => $ordertax)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $ordertax['tax_name'] }}</td>
                                                    <td>{{ $ordertax['tax_percentage'] }}%</td>
                                                    <td class="text-success">Rs.{{ $ordertax['tax_amount'] }}</td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                        @if (Auth::guard('admin')->user()->type == 'Waiter' || Auth::guard('admin')->user()->type == 'Cashier')
                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Table Transfer </h4><br>
                                        <form method="post"
                                            action="{{ url('admin/transfer-cust-table/' . $orderlist['order_no']) }}"
                                            class="forms-sample">
                                            @csrf
                                            <div class="form-group">
                                                <label>Select Table </label>
                                                <select name="table_id" required="" class="form-control select2bs4"
                                                    style="width: 100%;">
                                                    <option value="" selected="" disabled="">Select Table
                                                    </option>
                                                    @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}">
                                                            {{ $table->table_name }}--{{ $table->table_type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-xs-right">
                                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Order Item Transfer To Other Table </h4><br>
                                        <form method="post"
                                            action="{{ url('admin/transfer-OrderitemToOtherTable/' . $orderlist['order_no']) }}"
                                            class="forms-sample">
                                            @csrf
                                            <div class="form-group">
                                                <label>Select Transfer Item </label>
                                                <select name="current_order_id" required=""
                                                    class="form-control select2bs4" style="width: 100%;">
                                                    <option value="" selected="" disabled="">Select Item
                                                    </option>
                                                    @foreach ($ViewOrdersDetails as $itemtransfer)
                                                        <option value="{{ $itemtransfer->id }}">
                                                            {{ $itemtransfer['menuitem']['menu_item_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Select Item Transfer Table </label>
                                                <select name="table_wise_order_no" required=""
                                                    class="form-control select2bs4" style="width: 100%;">
                                                    <option value="" selected="" disabled="">Select Table
                                                    </option>
                                                    @foreach ($getorderTablelist as $transfertable)
                                                        <option value="{{ $transfertable->order_no }}">
                                                            {{ $transfertable['tables']['table_name'] }}--{{ $transfertable['tables']['table_type'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-xs-right">
                                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card-body">
                                    <table class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info" width="100%" style="border-color: #ddd;">
                                        <thead>
                                            <tr>
                                                @if ($orderlist['total_tax'] == 0)
                                                    <a class="btn btn-block btn-info btn-xs"
                                                        href="{{ url('admin/View-order-details/' . $orderlist['order_no']) }}"
                                                        class="text-danger">Generate Reciept</a>
                                                @else
                                                    <a class="btn btn-block btn-info btn-xs"
                                                        href="{{ url('admin/table-orderSlip/' . $orderlist['order_no']) }}"
                                                        target="_blank">View/Print Reciept</a><br>
                                                    @if ($orderlist['payment_mode'] == null)
                                                        <a class="btn btn-block btn-primary btn-xs"
                                                            href="{{ url('admin/table-paymentupdated/' . $orderlist['order_no']) }}"
                                                            class="text-success">Process For Checkout</a>
                                                    @endif
                                                @endif
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Order Bill Information</h4><br>
                                        <div class="form-group">
                                            <label>Sub Total</label>
                                            <input class="form-control" value="Rs.{{ $orderlist['sub_total'] }}"
                                                readonly="">
                                        </div>
                                        @if (!empty($orderlist['coupon_per']))
                                            <div class="form-group">
                                                <label>Coupon Apply</label>
                                                <input class="form-control" value="{{ $orderlist['coupon_per'] }}% Off"
                                                    readonly="">
                                            </div>
                                        @endif
                                        @if (!empty($orderlist['subtotalwithoffer']))
                                            <div class="form-group">
                                                <label>New Sub Total</label>
                                                <input class="form-control"
                                                    value="Rs.{{ $orderlist['subtotalwithoffer'] }}" readonly="">
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Total Tax</label>
                                            <input class="form-control" value="Rs.{{ $orderlist['total_tax'] }}"
                                                readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label>Order Status</label>
                                            <input class="form-control" value="{{ $orderlist['order_status'] }}"
                                                readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label>Grand Total</label>
                                            <input class="form-control" value="Rs.{{ $orderlist['grand_total'] }}"
                                                readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label>Payment Mode</label>
                                            <input class="form-control" value="{{ $orderlist['payment_mode'] }}"
                                                readonly="">
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>


                </div>
            </div>
        </div>
        @if (Auth::guard('admin')->user()->type == 'Waiter' || Auth::guard('admin')->user()->type == 'Cashier')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title btn btn-warning">Add More Item </h4><br>
                        <div class="card-body">


                            <form method="post" action="{{ url('admin/take-more-item/' . $orderlist['order_no']) }}"
                                class="forms-sample">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-fields product_data">

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Select Item <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select id="item_id" class="form-control select2bs4"
                                                                style="width: 100%;">
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
                                                <input type="submit" class="btn btn-rounded btn-info mb-5"
                                                    value="Submit">
                                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Order Item </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>Order Type </th>
                                        <th> Item Name </th>
                                        <th> Item Qty </th>
                                        <th>Free Item Qty </th>
                                        <th> Item Price</th>
                                        <th> Amount</th>
                                        <th> Item Status</th>
                                        <th>Action</th>
                                        <th>Replace Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ViewOrdersDetails as $item)
                                        @php

                                            $amount = $item['item_qty'] * $item['price'];

                                        @endphp
                                        <tr>
                                            <td class="text-danger">
                                                @if ($item['order_type'] == 'bar-menu')
                                                    <button>Bar Order</button>
                                                @else
                                                    <button>Kitchen Order</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item['menuitem'] && $item['menuitem']['menu_item_name'])
                                                    {{ $item['menuitem']['menu_item_name'] }}<br>
                                                    @if ($item['extraItemPrice'] != null)
                                                        <span class="badge badge-info"> ExrtraItem:-
                                                            @if ($item['extraitemadd'] && $item['extraitemadd']['extra_menu'])
                                                                {{ $item['extraitemadd']['extra_menu'] }}
                                                            @else
                                                                NA
                                                            @endif
                                                        </span>
                                                    @endif
                                                @else
                                                    NA
                                                @endif
                                            </td>

                                            <td>
                                                <strong> Order Qty {{ $item['item_qty'] }}<br></strong>
                                                <strong>Total
                                                    Qty:-{{ $item['item_qty'] + $item['no_qty_buy_to_free'] }}<br></strong>
                                            </td>
                                            <td>
                                                @if (!empty($item['no_of_qty_buy']))
                                                    <strong class="badge badge-info">{{ $item['no_qty_buy_to_free'] }}
                                                    </strong>
                                                @else
                                                    <small class="badge badge-danger"> No Offer</small>
                                                @endif
                                            </td>
                                            <td>
                                                Rs.{{ $item['price'] }}
                                                @if ($item['extraItemPrice'] != null)
                                                    <span class="badge badge-info"> ExrtraItemPrice:-
                                                        {{ $item['extraItemPrice'] }}</span>
                                                @endif
                                            </td>
                                            <td>Rs.{{ $item['amount'] }}</td>
                                            <td class="btn btn-warning">{{ $item['order_item_status'] }}</td>
                                            <td>
                                                @if ($item['order_item_status'] == 'Order-Collected')
                                                    <form
                                                        action="{{ url('admin/waiter-order-item-replace/' . $item['id']) }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="text" name="order_waste_remark"
                                                            class="form-control" required>
                                                        <button type="submit" class="badge badge-danger">Replace</button>
                                                    </form>
                                                @endif
                                                @if ($item['order_item_status'] == 'New-Order')
                                                    <form method="post" id="delete_form_{{ $item['id'] }}"
                                                        action="{{ url('/') }}/admin/Delete-Order-Item/{{ $item['id'] }}">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="deleted_id"
                                                            value="{{ $item['id'] }}">
                                                        <span onclick="deleteRow('{{ $item['id'] }}')" type="button"
                                                            class="badge badge-danger" title="Click to delete this row"><i
                                                                class="fa fa-trash"></i></span>
                                                    </form>
                                                @endif
                                                @if ($item['order_item_status'] == 'Order-Accepted')
                                                    {{-- <button>{{ $item['reqTodelete'] }}</button> --}}
                                                    @if ($item['reqTodelete'] == 'NUll')
                                                        @if ($item['reqTodelete'] != 'Delete Request Has Been Sent To The Kitchen!')
                                                            <form method="post" id="inactive_form_{{ $item['id'] }}"
                                                                action="{{ url('/') }}/admin/RequestForDeleteItemKichen/{{ $item['id'] }}">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="status_id"
                                                                    value="{{ $item['id'] }}">
                                                                <input type="hidden" name="status" value="0">
                                                                <span onclick="InActiveRow('{{ $item['id'] }}')"
                                                                    class="badge badge-danger" type="button"
                                                                    title="Click to In-Active this row">RequesForDelete</span>
                                                            </form>
                                                        @else
                                                            <button>{{ $item['reqTodelete'] }}</button>
                                                        @endif
                                                    @else
                                                        <button>{{ $item['reqTodelete'] }}</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td><strong class="text-danger">{{ $item['order_waste_remark'] }}</strong>
                                            </td>
                                        </tr>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
        <input type="text" name="no_qty_buy_to_free[]" class="form-control  no_qty_buy_to_free">
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
                    // alert("Menu is Required");
                    return false;
                }
                if (price == '') {
                    $.notify("Menu Price is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                    // alert("Menu Price is Required");
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
            // var item_id = $(".item_id").val();
            var item_id = $(ele).closest('tr').find('.item_id').val();
            var item_qty = $(ele).closest('tr').find('.item_qty').val();
            // alert(item_qty);
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
            // alert(extra_menu_item_id);
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
    
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.common.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.js"></script>
    
    <script>
        function deleteRow(id) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#delete_form_" + id).submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
        }
    </script>
@endsection
@section('script')

   


    <script>
        function ActiveRow(id) {
            console.log(id);
            swal({
                    title: "Are you sure?",
                    text: "You want to change status",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#active_form_" + id).submit();
                    } else {
                        //swal("Your data is safe!");
                    }
                });

        }

        function InActiveRow(id) {
            swal({
                    title: "Are you sure?",
                    text: "You want to change status",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#inactive_form_" + id).submit();
                    } else {
                        //swal("Your data is safe!");
                    }
                });

        }

        
    </script>



@endsection
