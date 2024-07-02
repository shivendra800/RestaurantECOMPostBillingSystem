@extends('admin.layouts.layout')
@section('title','Total Copuon Loss')

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
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Coupon Total Coupon Loss</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                
                  <!-- /.card -->
                  <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="form-group bg-warning p-2">
                                    <label>Over All Sold Item Amount</label>
                                    <br>
                                     <strong class="text-center bg-danger p-1">Rs.{{ $overallsale }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="form-group bg-warning p-2">
                                    <label>Over All Sale  Item Without Free Item</label>
                                    <br>
                                     <strong class="text-center bg-danger p-1">Rs.{{ $itemSalewithoutfree }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card text-center">
                          <div class="card-body">
                              <div class="form-group bg-warning p-2">
                                  <label>Over All Free Given Item Amount</label>
                                  <br>
                                  <strong class="text-center bg-danger p-1">Rs.{{ $itemfreelose }}</strong>
                                  
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

             
                <!-- /.card -->
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product Wise Coupon Sale Report</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                   <th>Order Type</th>
                                    <th>Order No.</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Item Buy Qty</th>
                                    <th>Amount Without Free Item</th>
                                  
                                    <th>No.Free Item</th>
                                    <th>Free Item Total Amount</th>
                                    <th>Item Order Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              
                                @foreach ($itemfreelist as $index=>$itemcoupon)
                                    <tr id="tr_{{$itemcoupon['id']}}">
                                     
                                        <td class="btn btn-info">Table Order</td>
                                    <td>{{ $itemcoupon['order_no'] }}</td>
                                    <td>{{ $itemcoupon['menuitem']['menu_item_name'] }}</td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['price'] }}</td>
                                    <td>{{ $itemcoupon['item_qty'] }} Item <p class="badge badge-danger">Buy</p></td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['amount'] }}</td>                  
                                    <td >{{ $itemcoupon['no_qty_buy_to_free'] }} Item <p class="badge badge-danger">Free</p></td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['no_qty_buy_to_free'] * $itemcoupon['price'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($itemcoupon->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
            
                                        
                                    
                            </tr>
                            @endforeach

                            @foreach ($takeawayoderitemfreelist as $index=>$itemcoupon)
                                    <tr id="tr_{{$itemcoupon['id']}}">
                                   
                                    <td class="btn btn-info">TakeAway Order</td>
                                    <td>{{ $itemcoupon['order_no'] }}</td>
                                    <td>{{ $itemcoupon['menuitem']['menu_item_name'] }}</td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['price'] }}</td>
                                    <td>{{ $itemcoupon['item_qty'] }} Item <p class="badge badge-danger">Buy</p></td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['amount'] }}</td>                  
                                    <td >{{ $itemcoupon['no_qty_buy_to_free'] }} Item <p class="badge badge-danger">Free</p></td>
                                    <td class="text-danger">Rs.{{ $itemcoupon['no_qty_buy_to_free'] * $itemcoupon['price'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($itemcoupon->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
            
                                        
                                    
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
<!-- /.content -->

@endsection
@section('script')


<script>
    function ActiveRow(id) {
        console.log(id);
        swal({
                title: "Are you sure?"
                , text: "You want to change status"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
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
                title: "Are you sure?"
                , text: "You want to change status"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    $("#inactive_form_" + id).submit();
                } else {
                    //swal("Your data is safe!");
                }
            });

    }

    function deleteRow(id) {
        swal({
                title: "Are you sure?"
                , text: "Once deleted, you will not be able to recover this imaginary file!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    $("#delete_form_" + id).submit();
                } else {
                    swal("Your data is safe!");
                }
            });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {


        $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {


                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {


                    var join_selected_values = allVals.join(",");


                    $.ajax({
                        url: $(this).data('url')
                        , type: 'DELETE'
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , data: 'ids=' + join_selected_values
                        , success: function(data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        }
                        , error: function(data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]'
            , onConfirm: function(event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function(e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href
                , type: 'DELETE'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , success: function(data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                }
                , error: function(data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>
@endsection