@extends('admin.layouts.layout')
@section('title','View Order List')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> View Order List</h3>
                        <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/take-chairWiseOrder') }}" class="btn btn-block btn-info">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order  Information</h4><br>
                                <div class="form-group">
                                    <label>Order No </label>
                                    <input class="form-control" value="{{ $orderlist['order_no'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Table Name</label>
                                    <input class="form-control" value="{{ $orderlist['tables']['table_name'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Transfer Table Remark</label>
                                    <input class="form-control" value="{{ $orderlist['tran_table_remark'] }}" readonly="">
                                </div>
                                @if(Auth::guard('admin')->user()->type=="Admin")
                                <div class="form-group">
                                    <label>Staff Name</label>
                                    <input class="form-control" value="{{ $orderlist['staffs']['name'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Order Date</label>
                                    <input class="form-control" value="{{ \Carbon\Carbon::parse($orderlist['created_at'])->isoFormat('MMM Do YYYY')}}" readonly="">
                                </div>
                                @endif
                            </div>
                        </div>

                        @if(Auth::guard('admin')->user()->type=="Admin")
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Table Order Wise Tax  List</h4><br>
                               
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
                                    @foreach ($OrderWisetaxdet as  $index => $ordertax )
            
                                    <tr>
                                        <td>{{ $index+1 }}</td>
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
                    @if(Auth::guard('admin')->user()->type=="BarChasier")
                    @else
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Bill  Information</h4><br>
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $orderlist['sub_total'] }}" readonly="">
                                </div>
                                @if(!empty($orderlist['coupon_per']))
                                <div class="form-group">
                                    <label>Coupon Apply</label>
                                    <input class="form-control" value="{{ $orderlist['coupon_per'] }}% Off" readonly="">
                                </div>
                                @endif
                                @if(!empty($orderlist['subtotalwithoffer']))
                                <div class="form-group">
                                    <label>New Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $orderlist['subtotalwithoffer'] }}" readonly="">
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>Total Tax</label>
                                    <input class="form-control" value="Rs.{{ $orderlist['total_tax'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Order Status</label>
                                    <input class="form-control" value="{{ $orderlist['order_status'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="Rs.{{ $orderlist['grand_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <input class="form-control" value="{{ $orderlist['payment_mode'] }}" readonly="">
                                </div>
                            
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
                
               
            </div>
        </div>
    </div>
    @if(Auth::guard('admin')->user()->type=="BarChasier")
  
    <div class="col-md-12">
       
        <div class="card">
            <h4 class="card-title btn btn-warning">Add More Item </h4>
            <div class="card-body">
             
                <br>
              


                    <form method="post" action="{{ url('admin/add-barTableWiseChair-more-item/'.$orderlist['order_no']) }}" class="forms-sample">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-fields product_data">

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


                        </table>
                        <br>


                    </div> <!-- End card-body -->
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
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
                  <h3 class="card-title">Customer Order  Item</h3>
                  <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/take-chairWiseOrder') }}" class="btn btn-block btn-info">Back</a>

                </div>
                <!-- /.card-header -->
                
                <div class="card-body">
                  <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                            aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <th>Order Type  </th>
                        <th>Chair Name</th>
                      <th>Order Item Name </th>
                      <th>Total Qty</th>
                      <th>Order Item Amt</th>
                      <th>Order Item Status</th>
                    
                      {{-- <th>Action</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($ViewOrdersDetails as $item)
                             <tr>
                                <td class="text-danger">
                                    @if($item['order_type']=="bar-menu")
                                    <button>Bar Order</button>
                                    @else
                                    <button>Kitchen Order</button>
                                    @endif
                                </td>
                                <td><strong >{{ $item['barchairname']['chair_name'] }}</strong></td>
                                <td >{{ $item['menuitem']['menu_item_name'] }}</td>
                               
                                <td >
                                   <strong > OrderQTY:-{{ $item['item_qty'] }}<br></strong>
                                    @if(!empty($item['no_of_qty_buy']))
                                  <strong class="badge badge-warning">FreeQTY:-{{ $item['no_qty_buy_to_free'] }}  </strong> <br>
                                     @endif
                                    <strong class="badge badge-info">TotalQTY:-{{ $item['item_qty'] + $item['no_qty_buy_to_free'] }}</strong>
                                </td>
                                <td>
                                    ItemPrice:-Rs.{{ $item['price'] }}<br>
                                    Tax:-Rs.{{ $item['bar_tax_percentage'] }}%<br>
                                    TotalAmt:-Rs.{{ $item['amount'] }}
                                </td>
                               
                                <td class="text-warning">{{ $item['order_item_status'] }}</td>
                               
                                {{-- <td>
                                   

                                    @if($item['order_item_status']=="New-Order")
                                      <form method="post" id="delete_form_{{ $item['id'] }}"
                                      action="{{ url('/') }}/admin/Delete-BarTableOrder-Item/{{ $item['id'] }}">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="deleted_id" value="{{ $item['id'] }}">
                                      <span onclick="deleteRow('{{ $item['id']  }}')" type="button"
                                          class="badge badge-danger" title="Click to delete this row"><i
                                              class="fa fa-trash"></i></span>
                                      </form>
                                    @endif
                                </td> --}}
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
@section('script')

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
