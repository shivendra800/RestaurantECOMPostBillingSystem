@extends('admin.layouts.layout')
@section('title', 'Take Away Order')

@section('content')

<style>
    body {
  font-family: "Open Sans", sans-serif;
  font-size: 13px;
  font-weight: 400;
  color: #8184a1;
  line-height: 1.3;
}
h4 {
  margin-top: 0;
  margin-bottom: 50px;
}
/* a:link, a:visited {
  transition: color 0.15s ease 0s, border-color 0.15s ease 0s, background-color 0.15s ease 0s;
} */
.container {
  display: flex;
  width: 100%;
  height: 100vh;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.quantity {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}
.quantity__minus,
.quantity__plus {
  display: block;
  width: 22px;
  height: 23px;
  margin: 0;
  background: #dee0ee;
  text-decoration: none;
  text-align: center;
  line-height: 23px;
}
.quantity__minus:hover,
.quantity__plus:hover {
  background: #575b71;
  color: #fff;
} 
.quantity__minus {
  border-radius: 3px 0 0 3px;
}
.quantity__plus {
  border-radius: 0 3px 3px 0;
}
.quantity__input {
  width: 32px;
  height: 19px;
  margin: 0;
  padding: 0;
  text-align: center;
  border-top: 2px solid #dee0ee;
  border-bottom: 2px solid #dee0ee;
  border-left: 1px solid #dee0ee;
  border-right: 2px solid #dee0ee;
  background: #fff;
  color: #8184a1;
}
.quantity__minus:link,
.quantity__plus:link {
  color: #8184a1;
} 
.quantity__minus:visited,
.quantity__plus:visited {
  color: #fff;
}
</style>


<!-- Content Wrapper. Contains page content -->
{{-- <div class=""> --}}
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Take Away Order</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Take Away Order</li>
                </ol>
            </div>
        </div>
    </div>

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


    <div class="card card-primary card-outline">
        <div class="card-header">
            <h2 class="btn btn-warning">Search Data Of Menu Item</h2>
            <div class="card-header">
                <form action="{{ url('/admin/serach-menuitem') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control" placeholder="Enter Menu Item & Code Name " value="{{ Request::get('keyword')  }}" required>
                        </div>
                        <div class="col-md-4 mt-1">
                            <button type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div class="card card-info card-tabs">
    <div class="card-header p-0 pt-1">
        <a href="{{ url('admin/Take-away-order') }}">
            <h6 class="btn btn-danger">ALL Menu List </h6>
        </a>
        <br>
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

            @foreach ($subcategory as $subcategories)
            <li class="nav-item">
                <div class="card-header bg-primary ">
                    <a href="{{ url('/') }}/admin/product-list/{{ $subcategories->id }}">
                        <h6 class="btn btn-warning"> {{ $subcategories->menu_subcat_name }}</h6>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>

    </div>
    <!-- /.card -->
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">



            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">All Item</div>
                    <div class="card-body">

                        <div class="row">
                            @foreach ($menuitem as $menuitems)
                            <div class="col-sm-4 product_data">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0 bg-warning text-bold text-center">
                                        {{ $menuitems->menu_item_name }}
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">

                                            <div class="col-12 text-center">
                                                <img src="{{ url('admin_assets/food-dummy.png') }}" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-center">



                                            <a href="#" class="btn btn-sm bg-teal">
                                                Rs. {{ $menuitems->menu_item_price }}
                                            </a>
                                            <input type="hidden" name="item_id" value="{{ $menuitems->id }}" class="item_id">
                                            <input type="hidden" name="price" value="{{ $menuitems->menu_item_price }}" class="price">
                                            <input type="hidden" name="item_qty" value="1" class="item_qty">


                                            <a href="#" class="btn btn-sm btn-primary addTocart  p-1">
                                                <img class="foodtype " style="height: 20px" ng-src="images/1.jpg" src="{{ url('admin_assets/non-veg.jpg') }}">&nbsp; Add
                                            </a>


                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach


                        </div>
                        {{ $menuitem->links() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Order Items</div>
                    <div class="card-body table-responsive cartitemdiv">
                        <form action="{{ url('admin/process-next-takeorder/') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                                <thead class="bg-primary">
                                    <tr>


                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Item Qty</th>
                                        {{-- <th>Delete</th> --}}
                                        <th>Item Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @php $total = 0; @endphp
                                    @foreach ($takewarycartitem as $index => $itemlist)

                                    @php
                                    $date = date('Y-m-d');
                                    $productcoupon =App\Models\ProductWiseCoupon::where('no_of_qty_buy','<=',$itemlist['item_qty'])->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
                                            $free_qty = $productcoupon->where('product_id',$itemlist['item_id'])->max('no_qty_buy_to_free');
                                            $no_of_qty_buy = $productcoupon->where('product_id',$itemlist['item_id'])->max('no_of_qty_buy');
                                           
                                           if($free_qty>0)
                                           {
 
                                            if($no_of_qty_buy <= $itemlist['item_qty'])
                                        {
                                            
                                            $getqty = ($itemlist['item_qty'] / $no_of_qty_buy);
                                            if(fmod($getqty, 1) == 0.00){
                                                $free_qty = $getqty * $free_qty;
                                            } else {
                                                $get= (int)$getqty;
                                                if(fmod($get, 1) == 0.00){       
                                                    $free_qty = $get * $free_qty;
                                                } else {
                                                    $free_qty = $get * $free_qty;
                                                }
                                               
                                            }
                                            
                                        }

                                           }
                                           
                                       
                                            

                                            @endphp

                                       

                                            @php

                                            $total += $itemlist['item_qty'] * $itemlist['price'];
                                            @endphp
                                            <tr class="productdata">

                                                <td class="bg-primary">{{ $index + 1 }}</td>
                                                <td class="text-center bg-info">{{ $itemlist['menuitem']->menu_item_name }}
                                                    <input type="hidden" name="item_id[]" value="{{ $itemlist['item_id'] }}">
                                                    <br>
                                                    @if(!empty($no_of_qty_buy))
                                                    <button class="btn btn-warning"> Get {{ $free_qty}} Free</button>
                                                    <input type="hidden" name="no_of_qty_buy[]" value="{{$no_of_qty_buy}}">
                                                    <input type="hidden" name="no_qty_buy_to_free[]" value="{{$free_qty}}">
                                                    @else
                                                    <input type="hidden" name="no_of_qty_buy[]" value="0">
                                                    <input type="hidden" name="no_qty_buy_to_free[]" value="0">
                                                    @endif

                                                </td>

                                                <td class="text-center bg-danger">
                                                    {{-- <div style="display:inline-flex;"> --}}

                                                        {{-- <div class="col-sx-6"> --}}
                                                            {{-- <div class="input-group text-center mb-3" style="width: 130px;"> --}}
                                                                {{-- <button class="input-group-text changeQunatity decrement-btn">-</button>
                                                                <input type="text" value="{{ $itemlist['item_qty'] }}" class="form-control qty-input text-center item_qty">
                                                                <input type="hidden" class="item_id" value="{{ $itemlist['item_id'] }}">
                                                                <input type="hidden" class="cart_id" value="{{ $itemlist['id'] }}">
                                                                <button class="input-group-text changeQunatity increment-btn">+</button> --}}

                                                                <div class="quantity" id="myDiv">
                                                                    <a class="quantity__minus minus-a updateCartItem" data-cartid="{{ $itemlist['id'] }}" data-qty="{{  $itemlist['item_qty'] }}"  data-min="1">&#45;</a>
                                                                    <input type="text" class="quantity__input " value="{{  $itemlist['item_qty'] }}" readonly>
                                                                    <a class="quantity__plus plus-a updateCartItem" data-cartid="{{ $itemlist['id'] }}" data-qty="{{  $itemlist['item_qty'] }}" data-max="1000">&#43;</a>

                                                                   
                                                                </div>
                                                          
                                                            {{-- </div> --}}
                                                        {{-- </div>
                                                        <div class="col-sx-6"> --}}
                                                            {{-- <button class="btn btn-danger delele-cart-item result"> <i class="fa fa-trash"></i>
                                                            </button> --}}
                                                            {{-- <div class="action-wrapper">
                                                            
                                                                <button class="button button-outline-secondary fas fa-trash deleteCartitem" data-cartid="{{ $itemlist['id'] }}"></button>
                                                            </div> --}}
{{-- 
                                                            <form method="post" id="delete_form_{{ $itemlist['id'] }}"
                                                            action="{{ url('/') }}/admin/Delete-cartitem/{{ $itemlist['id'] }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="deleted_id" value="{{ $itemlist['id'] }}">
                                                            <span onclick="deleteRow('{{ $itemlist['id']  }}')" type="button"
                                                                class="badge badge-danger" title="Click to delete this row"><i
                                                                    class="fa fa-trash"></i></span>
                                                            </form> --}}
                                                            <a href="{{ url('/') }}/admin/Delete-cartitem/{{ $itemlist['id'] }}"><i
                                                                class="fa fa-trash"></i></a>
                                                        {{-- </div>
                                                    </div> --}}


                                                    <input type="hidden" name="item_qty[]" value="{{ $itemlist['item_qty'] }}">


                                                </td>
                                                
                                                <td class="text-center bg-info">Rs.{{ $itemlist['price'] }}
                                                    <input type="hidden" name="price[]" value="{{ $itemlist['price'] }}">
                                                </td>
                                                <td class="text-center bg-info">
                                                    Rs.{{ $itemlist['item_qty'] * $itemlist['price'] }}
                                                    <input type="hidden" name="amount[]" value="{{ $itemlist['item_qty'] * $itemlist['price'] }}">
                                                </td>

                                            </tr>
                                            @endforeach
                                            @if($takewarycartitem->count()>0)
                                            <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Sub Total</td>
                                                <strong>
                                                    <td>Rs.{{ $total }}/

                                                        <input type="hidden" name="sub_total" value="{{ $total }}">
                                                    </td>

                                                </strong>
                                            </tr>
                                         

                                            @php
                                            $date = date('Y-m-d');
                                            $coupon =App\Models\CouponOnPrice::where('order_amount','<=',$total)->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
                                                    $max_code = $coupon->max('promocode');
                                                    $max_amount = $coupon->max('order_amount');
                                                    $max_offer_per = $coupon->max('offer_per');
                                                    $max_remark = $coupon->max('remark');
                                                    @endphp
                                                    @if($max_amount)
                                                    <tr style="background-color: bisque; ">

                                                        <td></td>
                                                        <td></td>
                                                        <td></td>

                                                        <td>Apply Coupon</td>

                                                        <strong>
                                                            <td>

                                                                <input type="hidden" name="coupon_avail_amount" value="{{$max_amount}}" placeholder="coupon percentage">
                                                                <input type="text" name="coupon_code" value="{{$max_code}}" placeholder="coupon code" readonly style="background-color: rgb(237, 230, 230)">
                                                                <input type="hidden" name="coupon_per" value="{{$max_offer_per}}" placeholder="coupon per" readonly>
                                                                <button class="btn btn-warning">{{$max_offer_per}}% Off</button>

                                                            </td>
                                                        </strong>
                                                    </tr>
                                                    @else
                                                    <input type="hidden" name="coupon_avail_amount" value="0" placeholder="coupon percentage">
                                                    <input type="hidden" name="coupon_code" value="0" placeholder="coupon code" readonly style="background-color: rgb(237, 230, 230)">
                                                    <input type="hidden" name="coupon_per" value="0" placeholder="coupon per" readonly>
                                                    <input type="hidden" name="subtotalwithoffer" value="0">
                                                    @endif
                                                    {{-- if offer  --}}
                                                    @if($max_amount)
                                                    <tr style="background-color: bisque; ">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Now Sub Total</td>
                                                        <strong>
                                                            @php
                                                            $subtotalwithoffer = $total - (($total*$max_offer_per)/100)
                                                            @endphp
                                                            <td>Rs.{{ $subtotalwithoffer }}/

                                                                <input type="hidden" name="subtotalwithoffer" value="{{ $subtotalwithoffer }}">
                                                            </td>

                                                        </strong>
                                                    </tr>

                                                    <!----  Total Tax Impl  --->
                                                    @php
                                                    $totaltax =0;
                                                @endphp
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Tax Name</th>
                                                    <th>Tax Percentage</th>
                                                    <th>Tax Amount</th>
                                                </tr>
                                               @foreach ($gettax as  $taxlist )
                                               @php
    
                                                $totaltax += $taxlist['tax_percentage'] * $subtotalwithoffer/100;
                                                @endphp
                                               <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $taxlist['tax_name'] }}
                                                    <input type="hidden" name="tax_name[]" value="{{ $taxlist['tax_name'] }}">
                                                </td>
                                                <td>{{ $taxlist['tax_percentage']  }}%
                                                    <input type="hidden" name="tax_percentage[]" value="{{ $taxlist['tax_percentage']  }}">
                                                </td>
                                                <td>Rs.{{ $taxlist['tax_percentage'] *$subtotalwithoffer/100 }}
    
                                                    <input type="hidden" name="tax_amt[]" value="{{ $taxlist['tax_percentage'] *$subtotalwithoffer/100  }}">
                                                </td>
                                               </tr>
                                                   
                                               @endforeach
    
                                               <tr style="background-color: bisque; ">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> Total Tax</td>
                                                <strong>
                                                    <td>Rs.{{ $totaltax }}/
    
                                                        <input type="hidden" name="total_tax" value="{{ $totaltax }}">
                                                    </td>
    
                                                </strong>
                                            </tr>

                                             <!----  Total Tax Impl End --->
                                       
                                                  
                                                    @php
                                                    $grandtotal = $subtotalwithoffer + $totaltax;
                                                    @endphp
                                                    <tr style="background-color: bisque; ">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Grand Total</td>
                                                        <strong>
                                                            <td>Rs.{{round($grandtotal, 2)}}/

                                                                <input type="hidden" name="grand_total" value="{{ $grandtotal }}">
                                                            </td>
                                                        </strong>
                                                    </tr>
                                                    {{-- end offer  --}}
                                                    {{-- normal  --}}
                                                    @else
                                                      <!----  Total Tax Impl  --->
                                                      @php
                                                      $totaltax =0;
                                                  @endphp
                                                   <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Tax Name</th>
                                                    <th>Tax Percentage</th>
                                                    <th>Tax Amount</th>
                                                </tr>
                                                 @foreach ($gettax as  $taxlist )
                                                 @php
      
                                                  $totaltax += $taxlist['tax_percentage'] * $total/100;
                                                  @endphp
                                                 <tr>
                                                    <td></td>
                                                    <td></td>
                                                  <td>{{ $taxlist['tax_name'] }}
                                                      <input type="hidden" name="tax_name[]" value="{{ $taxlist['tax_name'] }}">
                                                  </td>
                                                  <td>{{ $taxlist['tax_percentage']  }}%
                                                      <input type="hidden" name="tax_percentage[]" value="{{ $taxlist['tax_percentage']  }}">
                                                  </td>
                                                  <td>Rs.{{ $taxlist['tax_percentage'] *$total/100 }}
      
                                                      <input type="hidden" name="tax_amt[]" value="{{ $taxlist['tax_percentage'] *$total/100  }}">
                                                  </td>
                                                 </tr>
                                                     
                                                 @endforeach
      
                                                 <tr style="background-color: bisque; ">
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td> Total Tax</td>
                                                  <strong>
                                                      <td>Rs.{{ $totaltax }}/
      
                                                          <input type="hidden" name="total_tax" value="{{ $totaltax }}">
                                                      </td>
      
                                                  </strong>
                                              </tr>
  
                                               <!----  Total Tax Impl End --->
                                                  
                                                    @php
                                                    $grandtotal = $total + $totaltax;
                                                    @endphp
                                                    <tr style="background-color: bisque; ">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Grand Total</td>
                                                        <strong>
                                                            <td>Rs.{{round($grandtotal, 2)}}/

                                                                <input type="hidden" name="grand_total" value="{{ $grandtotal }}">
                                                            </td>
                                                        </strong>
                                                    </tr>
                                                    @endif
                                                    @endif
                                </tbody>

                            </table>
                            @if($takewarycartitem->count()>0)


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="qrcodeplace">Place Order</button>
                            </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.container-fluid -->
</section>


{{-- </div> --}}

@endsection

@section('script')


<script>
    $(document).ready(function() {

        $("#check_coupon").keyup(function() {
            var check_coupon = $("#check_coupon").val();
            // alert(check_coupon);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , type: "post"
                , url: "{{ url('/') }}/admin/check-couponcode"
                , data: {
                    check_coupon: check_coupon
                }
                , success: function(response) {
                    console.log(response);
                    console.log(response.mesg);


                    if (response.mesg == "false") {
                        $("#check_coupon_error").html("<font color='red'>Invalid Coupon!</font>");
                    } else if (response.mesg == "true") {
                        $("#check_coupon_error").html("<font color='green'>Valid Coupon !</font>");
                        $("#coupon_per").val(response.data.offer_per);
                    }

                }
                , error: function() {
                    alert("Error");
                }
            , });
        });



       
    });
    $(document).ready(function() {
        //   add to cart----------
        $('.addTocart').click(function(e) {
            e.preventDefault();

            var item_id = $(this).closest('.product_data').find('.item_id').val();
            var item_qty = $(this).closest('.product_data').find('.item_qty').val();
            var price = $(this).closest('.product_data').find('.price').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post"
                , url: "{{ url('admin/add_to_cart') }}"
                , data: {
                    'item_id': item_id
                    , 'item_qty': item_qty
                    , 'price': price,

                },

                success: function(response) {
                    swal(response.status);
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1);

                }

            });


        });
        //   increment ------
        $(document).on('click', '.increment-btn', function(e) {
            e.preventDefault();
            var inc_value = $(this).closest('.productdata').find('.qty-input').val();
            var inc_value = $('.qty-input').val();
            var value = parseInt(inc_value, 10);
            value = isNaN(value) ? 0 : value;
            if (value < 10) {
                value++;
                $(this).closest('.productdata').find('.qty-input').val(value);
            }
        });
        //    decrement-----------
        $(document).on('click', '.decrement-btn', function(e) {
            e.preventDefault();
            var dec_value = $(this).closest('.productdata').find('.qty-input').val();
            var value = parseInt(dec_value, 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                $(this).closest('.productdata').find('.qty-input').val(value);
            }
        });

        //  change qunantity-------------
        $(document).on('click', '.changeQunatity', function(e) {
            e.preventDefault();
            var item_id = $(this).closest('.productdata').find('.item_id').val();

            var item_qty = $(this).closest('.productdata').find('.item_qty').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            data = {
                'item_id': item_id
                , 'item_qty': item_qty
            , }
            $.ajax({
                method: "post"
                , url: "{{ url('/') }}/admin/update_cart"
                , data: data,

                success: function(response) {
                    swal(response.status);
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }

            });
        });

        // delete cart------------
        $(document).on('click', '.delele-cart-item', function(e) {

            e.preventDefault();

            var cart_id = $(this).closest('.productdata').find('.cart_id').val();
            var result = confirm("Are You sure To Delete This Cart Item?");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post"
                , url: "{{ url('/') }}/admin/delete_cart_item"
                , data: {
                    'cart_id': cart_id
                , },

                success: function(response) {

                    swal(response.status);
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }

            });
        });
    });
</script>


<script>
    function ActiveRow(id)
  {
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
        $("#active_form_"+id).submit();
      } else {
        //swal("Your data is safe!");
      }
    });
  
  }
  
  function InActiveRow(id)
  {
    swal({
      title: "Are you sure?",
      text: "You want to change status",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $("#inactive_form_"+id).submit();
      } else {
        //swal("Your data is safe!");
      }
    });
  
  }
  
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
  
  <script type="text/javascript">
    $(document).ready(function () {
  
  
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });
  
  
        $('.delete_all').on('click', function(e) {
  
  
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
  
  
            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  
  
  
                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  
  
  
                    var join_selected_values = allVals.join(","); 
  
  
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
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
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
  
  
                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });
  
  
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });
  
  
        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();
  
  
            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
  
  
            return false;
        });
    });
  </script>
@endsection

    



