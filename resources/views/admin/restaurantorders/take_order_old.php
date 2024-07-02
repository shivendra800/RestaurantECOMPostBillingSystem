@extends('admin.layouts.layout')
@section('title',"Take Order")
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    <div class="card">
        <div class="card-header bg-warning text-center">
            <h3 class="card-title  "> Offer List</h3>

        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table  class="  table table-bordered table-hover dataTable dtr-inline bg-secondary" aria-describedby="example1_info">
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
                    <table  class="  table table-bordered table-hover dataTable dtr-inline bg-secondary" aria-describedby="example1_info">
                       
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
                    <!-- /.card-header -->
                    <!-- form start -->
                                  <!-- /.box-header -->
                     <div class="card-body">


                            <form method="post" action="{{ url('admin/take-order/'.$gettableselect['id']) }}" class="forms-sample">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-fields product_data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h5>Selected Table<span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            {{-- <select name="table_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">Select Table</option>
                                                                @foreach($tables as $table)
                                                                <option value="{{ $table->id }}">{{ $table->table_name }}--{{ $table->table_type }}</option>

                                                            
                                                                @endforeach
                                                            </select> --}}
                                                            <input type="text" value="{{ $gettableselect['table_name'] }}-{{ $gettableselect['table_type'] }}" class="form-control" readonly>
                                                            <input type="hidden" name="table_id" value="{{ $gettableselect['id'] }}" class="form-control" readonly>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h5>Enter Total No Of Person To Serve  <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number"  name="total_no_person_intable" class="form-control" required>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                          
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Select Item <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="item_id[]" required="" id="item_id"  class="form-control item_id select2" onchange="getItemprice(this);">
                                                                <option value="" selected="" disabled="">Select Menu Item</option>
                                                                @foreach($menuitems as $menuitem)
                                                                <option value="{{ $menuitem->id }}">{{ $menuitem->menu_item_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> <!-- // end form group -->
                                                </div> <!-- End col-md-5 -->
                                                


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5>Item Price <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text"  name="price[]" class="form-control itemprice" readonly>
                                                            <input type="hidden"  name="menu_cat_id[]" class="form-control menu_cat_id">
                                                            <input type="hidden"  name="menu_subcat_id[]" class="form-control menu_subcat_id">
                                                         
                                                        </div>
                                                    </div>
                                                </div><!-- End col-md-5 -->

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5>Item Qty<span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="item_qty[]" class="form-control item_qty" onkeyup="getoffer(this);" required="">
                                                            
                                                              
                                                            <input type="hidden" name="amount[]"  class="form-control amount">
                                                            <input type="hidden" name="grand_total" value="0" class="form-control">
                                                        </div>
                                                    </div>
                                                </div><!-- End col-md-5 -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Item Serve Time</h5>
                                                        <div class="controls">
                                                            <input type="text" name="item_serve_time[]" class="form-control" placeholder="Item serve Time (Eg:Server This item after 30 min)">
                                                        </div>
                                                    </div>
                                                </div><!-- End col-md-5 -->
                                                <div class="col-md-2 ml-2">
                                                    <div class="form-group">
                                                        <h5>Buy Item Qty<span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="no_of_qty_buy[]" class="form-control bg-warning no_of_qty_buy" readonly>
                                                        </div>
                                                    </div>
                                                </div><!-- End col-md-5 -->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5>Get Free Item Qty<span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="no_qty_buy_to_free[]" class="form-control bg-warning no_qty_buy_to_free"readonly>
                                                        </div>
                                                    </div>
                                                </div><!-- End col-md-5 -->
                                            </div>
                                               
                                                
                                               
                                                
                                                 
                                            </div> <!-- end Row -->


                                           
                                               
                                           
                                        <div class="col-md-2" style="padding-top: 25px;">
                                            <span class="btn btn-success addeventmore" id="add-more-field"><i class="fa fa-plus-circle"></i> </span>
                                        </div>
                                     
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







<script type="text/javascript">
 


function getoffer(ele) {
            // var item_id = $(".item_id").val();
            var item_id = $(ele).closest('.product_data').find('.item_id').val();
            var item_qty = $(ele).closest('.product_data').find('.item_qty').val();
           
           // alert(item_qty);
            $.ajax({
                url: "{{ url('/') }}/admin/getoffer/" + item_id+"/"+item_qty,
                dataType: "json",
                success: function(data) {
                    //  console.log("data", data);
                     console.log("hhghg",data.no_qty_buy_to_free);
                    // var price = document.getElementById("price").value = data.data[0].menu_item_price;
                       $(ele).closest('.product_data').find('.no_of_qty_buy').val(data.no_of_qty_buy);
                       $(ele).closest('.product_data').find('.no_qty_buy_to_free').val(data.no_qty_buy_to_free);
                    

                }
            });
        }
   

    function getItemprice(ele) {
            // var item_id = $(".item_id").val();
            var item_id = $(ele).closest('.product_data').find('.item_id').val();

           

            $.ajax({
                url: "{{ url('/') }}/admin/getItemprice/" + item_id,
                dataType: "json",
                success: function(data) {
                    //  console.log("data", data);
                    // console.log("hhghg",data.data[0].menu_item_price);
                    // var price = document.getElementById("price").value = data.data[0].menu_item_price;
                       $(ele).closest('.product_data').find('.itemprice').val(data.data[0].menu_item_price);
                       $(ele).closest('.product_data').find('.menu_cat_id').val(data.data[0].menu_cat_id);
                       $(ele).closest('.product_data').find('.menu_subcat_id').val(data.data[0].menu_subcat_id);
                  


                }
            });
        }

        // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////

        $( document ).ready(function() {
        
    // Add More buuton work ----jquery here
    $(function(){
    var max_fields = 10;
    var x = 1;
    var more_fields = `
                                       
                                          <hr>
                                         <div class="row One-div product_data">
                                            
                                            <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Select Item <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="item_id[]" required="" id="item_id" class="form-control item_id " onchange="getItemprice(this);">
                                                                <option value="" selected="" disabled="">Select Menu Item</option>
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
                                                            <input type="text"  name="price[]" class="form-control itemprice" readonly>
                                                            <input type="hidden"  name="menu_cat_id[]"  class="form-control menu_cat_id">
                                                            <input type="hidden"  name="menu_subcat_id[]" class="form-control menu_subcat_id">
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                           
                                            <div class="form-group col-md-2">
                                                <label class="control-label mb-1" for="qty">Qty</label>
                                                <input type="number"  value="{{old('qty')}}" class="form-control  @error('qty') is-invalid @enderror item_qty" name="item_qty[]" onkeyup="getoffer(this);" required="">
                                               
                                                <input type="hidden"  value="0" name="amount[]" class="form-control amount">
                                                @error('qty')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                               @enderror
                                            </div>
                                           
                                            <div class="form-group col-md-4">
                                                <label class="control-label mb-1" for="item_serve_time">Item Serve Time</label>
                                                <input type="text"  value="{{old('item_serve_time')}}" class="form-control  @error('item_serve_time') is-invalid @enderror item_serve_time" name="item_serve_time[]" placeholder="Item serve Time (Eg:Server This item after 30 min)" >
                                                @error('item_serve_time')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                               @enderror
                                            </div>
                                          <br>
                                        
                                            <div class="form-group col-md-3">
                                                <label class="control-label mb-1">Buy Item Qty</label>
                                                
                                                
                                                    <input type="text" name="no_of_qty_buy[]" class="form-control bg-warning no_of_qty_buy" readonly>
                                                
                                           
                                           </div><!-- End col-md-5 -->
                                           <div class="form-group col-md-3">
                                                <label class="control-label mb-1">Get Free Item Qty</label>
                                                
                                                
                                                <input type="text" name="no_qty_buy_to_free[]" class="form-control bg-warning no_qty_buy_to_free"readonly>
                                           
                                           </div><!-- End col-md-5 -->
                                        
                                     
                                            <a href="#" class="delete badge badge-danger p-3 m-2" style="width:70px; height:40px">Delete</a>
                                   
                                            </div>
                                       
                                           
                     
                `;
    //  add more button --
    $('#add-more-field').on('click', (function (e) {
         
        e.preventDefault();
        if (x < max_fields) {
            x++;
        $(".input-fields").append(more_fields);
        }
        else {
            alert('You Reached the limits')
        }
    }));
    // delete button--
    $(".input-fields").on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('.One-div').remove();
        x--;
        
    })

    

  });//add more button function end -----------------------
 
 

   
});


</script>




@endsection
