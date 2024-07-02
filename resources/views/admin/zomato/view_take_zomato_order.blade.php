@extends('admin.layouts.layout')
@section('title', 'Take Zomato Order')

@section('content')

    <style>
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
    <style>


        /* input style */
        /* input {
            background-color: #2980b9;
            color: white;
            margin: 0;
            padding: 10px 20px;
            font-size: 24px;
            font-weight: normal;
            width: calc(100% - 40px);
            border: none;
        } */

        /* input:hover {
            background-color: #3285c4;
        } */

        /* list style */
        /* .list {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 50vh;
            overflow-y: scroll;
        } */

        /* .listdata {
            cursor: pointer;
            background-color: #fff;
            height: 40px;
            line-height: 40px;
            color: #666;
            padding-left: 20px;
        } */

        .ex3 {
  /* background-color: lightblue; */
  /* width: 110px; */
  height: 700px;
  overflow: auto;
}
    </style>



    <!-- Content Wrapper. Contains page content -->
    {{-- <div class=""> --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Zomato Order</h1>
                </div>
                <div class="col-sm-6 d-none d-sm-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Zomato Order</li>
                    </ol>
                </div>
            </div>
        </div>
        {{--
        <div class="containersc">
            <!-- input -->
            <input id="search" type="text" placeholder="Search..."/>
            <a href="{{ url('admin/Take-away-order') }}">
                <h6 class="btn btn-danger">ALL Menu List </h6>
            </a>
            <!-- liste of value -->
            <ul class="list">
                @foreach ($subcategory as $subcategories)
              <li class="listdata">
                <div class="">
                    <a href="{{ url('/') }}/admin/product-list/{{ $subcategories->id }}">
                        <h6 class=""> {{ $subcategories->menu_subcat_name }}</h6>
                    </a>
                </div>
              </li>

              @endforeach

            </ul>
          </div> --}}



    </section>



    <section class="content">
        <div class="container-fluid">
            <div class="row">



                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">
                            <form action="" method="GET">

                                <div class="row">



                                    <div class="col-md-8">

                                        <label>MenuItem List</label>
                                        <br/>
                                          <select name="meniitem_id" class="form-control select2 ">
                                            <option value="">Select Menu Item</option>
                                            @foreach ($menuitemList as $menuitems)
                                            <option value="{{ $menuitems->id }}" >{{ $menuitems->menu_item_name }}</option>
                                            @endforeach

                                          </select>

                                    </div>

                                       <div class="col-md-2">
                                        <br/>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                       </div>
                                       <br/>
                                       <hr>
                                </div>
                            </form>
                            {{-- <form action="{{ url('/admin/serach-menuitem') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="keyword" class="form-control"
                                            placeholder="Enter Menu Item & Code Name " value="{{ Request::get('keyword') }}"
                                            required>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <button type="submit">Search</button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>


                        <div class="card-body">

                            <div class="row ex3" >
                                @foreach ($menuitem as $menuitems)

                                    <div class="col-sm-4 product_data " style="font-size: 12px;">
                                        <a href="#" class=" addTocart">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-header text-muted border-bottom-0 bg-warning  text-center">
                                                {{ $menuitems->menu_item_name }}
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">

                                                    <div class="col-12 text-center">
                                                        <img src="{{ url('admin_assets/food-dummy.png') }}" style="height:50; width:89px"
                                                            alt="user-avatar" class="img-circle img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer pt-0">
                                                <div class="text-center">



                                                    <a href="#" class="btn btn-sm bg-teal">
                                                        Rs. {{ $menuitems->menu_item_price }}
                                                    </a>
                                                    <input type="hidden" name="item_id" value="{{ $menuitems->id }}"
                                                        class="item_id">
                                                    <input type="hidden" name="price"
                                                        value="{{ $menuitems->menu_item_price }}" class="price">
                                                    <input type="hidden" name="item_qty" value="1" class="item_qty">


                                                    <a href="#" class="btn btn-sm btn-primary addTocart  p-1">
                                                        <img class="foodtype " style="height: 20px" ng-src="images/1.jpg"
                                                            src="{{ url('admin_assets/non-veg.jpg') }}">&nbsp; Add
                                                    </a>


                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    </div>

                                @endforeach


                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Order Items</div>
                        <div class="card-body table-responsive cartitemdiv">
                            @if ($takewarycartitem->count() > 0)
                                <form action="{{ url('admin/Checkout-Zomato-Order/') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <table class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">

                                        <thead class="bg-secondary">
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
                                                    $productcoupon = App\Models\ProductWiseCoupon::where('no_of_qty_buy', '<=', $itemlist['item_qty'])
                                                        ->where('start_date', '<=', $date)
                                                        ->where('expiry_date', '>=', $date)
                                                        ->get();
                                                    $free_qty = $productcoupon->where('product_id', $itemlist['item_id'])->max('no_qty_buy_to_free');
                                                    $no_of_qty_buy = $productcoupon->where('product_id', $itemlist['item_id'])->max('no_of_qty_buy');

                                                    if ($free_qty > 0) {
                                                        if ($no_of_qty_buy <= $itemlist['item_qty']) {
                                                            $getqty = $itemlist['item_qty'] / $no_of_qty_buy;
                                                            if (fmod($getqty, 1) == 0.0) {
                                                                $free_qty = $getqty * $free_qty;
                                                            } else {
                                                                $get = (int) $getqty;
                                                                if (fmod($get, 1) == 0.0) {
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

                                                    <td class="bg-secondary">{{ $index + 1 }}</td>
                                                    <td class="text-center ">
                                                        {{ $itemlist['menuitem']->menu_item_name }}
                                                        <input type="hidden" name="item_id[]"
                                                            value="{{ $itemlist['item_id'] }}">
                                                        <br>
                                                        @if (!empty($no_of_qty_buy))
                                                            <button class="btn btn-warning"> Get {{ $free_qty }}
                                                                Free</button>
                                                            <input type="hidden" name="no_of_qty_buy[]"
                                                                value="{{ $no_of_qty_buy }}">
                                                            <input type="hidden" name="no_qty_buy_to_free[]"
                                                                value="{{ $free_qty }}">
                                                        @else
                                                            <input type="hidden" name="no_of_qty_buy[]" value="0">
                                                            <input type="hidden" name="no_qty_buy_to_free[]"
                                                                value="0">
                                                        @endif

                                                    </td>

                                                    <td class="text-center  ">


                                                        <div class="quantity" id="myDiv">
                                                            <a class="quantity__minus minus-a updateZomataoCartItem"
                                                                data-cartid="{{ $itemlist['id'] }}"
                                                                data-qty="{{ $itemlist['item_qty'] }}"
                                                                data-min="1">&#45;</a>
                                                            <input type="text" class="quantity__input "
                                                                value="{{ $itemlist['item_qty'] }}" readonly>
                                                            <a class="quantity__plus plus-a updateZomataoCartItem"
                                                                data-cartid="{{ $itemlist['id'] }}"
                                                                data-qty="{{ $itemlist['item_qty'] }}"
                                                                data-max="1000">&#43;</a>


                                                        </div>


                                                        <a
                                                            href="{{ url('/') }}/admin/DeleteZomato-cartitem/{{ $itemlist['id'] }}"><i
                                                                class="fa fa-trash"></i></a>
                                                        {{-- </div>
                                                    </div> --}}


                                                        <input type="hidden" name="item_qty[]"
                                                            value="{{ $itemlist['item_qty'] }}">


                                                    </td>

                                                    <td class="text-center ">Rs.{{ $itemlist['price'] }}
                                                        <input type="hidden" name="price[]"
                                                            value="{{ $itemlist['price'] }}">
                                                    </td>
                                                    <td class="text-center ">
                                                        Rs.{{ $itemlist['item_qty'] * $itemlist['price'] }}
                                                        <input type="hidden" name="amount[]"
                                                            value="{{ $itemlist['item_qty'] * $itemlist['price'] }}">
                                                    </td>

                                                </tr>
                                            @endforeach

                                            <tr >
                                                {{-- <td></td>
                                                <td></td>
                                                <td></td> --}}
                                                <td colspan="4">Sub Total</td>
                                                <strong>
                                                    <td>Rs.{{ $total }}/

                                                        <input type="hidden" name="sub_total" id="sub_total"
                                                            value="{{ $total }}">
                                                    </td>

                                                </strong>
                                            </tr>
                                            <tr>
                                                {{-- <th></th>
                                                <th></th>
                                                <th></th> --}}
                                                <th colspan="4">Apply Discount</th>
                                                <td><input type="number" step="0.001" min="0" max="20"
                                                        name="discount" required id="discount"></td>
                                            </tr>
                                             <tr>
                                                {{-- <th></th>
                                                <th></th>
                                                <th></th> --}}
                                                <th colspan="4">Discounted SubTotal</th>
                                                <td><input type="text" name="afterdissubtotal" value="" required id="afterdissubtotal" readonly></td>
                                            </tr>




                                            @foreach ($gettax as $selectTax)
                                                @php

                                                    $checkTaxname = ($total * $selectTax['tax_percentage']) / 100;
                                                    $tax_amount = $total + $checkTaxname;

                                                @endphp
                                                <tr>
                                                    {{-- <th></th>
                                                    <th></th>
                                                    <th></th> --}}
                                                    <th colspan="4"></th>
                                                    <th>
                                                        <input type="checkbox"  name="tax_check_box[]" id="check"  class="checks"   data-price="{{ $checkTaxname }}"
                                                            value="{{ $selectTax->id }}">
                                                        <input type="hidden" name="tax_name[]"
                                                            value="{{ $selectTax->tax_name }}">
                                                        <input type="hidden" name="tax_percentage[]"
                                                            value="{{ $selectTax->tax_percentage }}">
                                                        {{ $selectTax['tax_name'] }}({{ $selectTax['tax_percentage'] }}%)
                                                    </th>

                                                    <!--<td>-->
                                                        {{-- {{ $checkTaxname }} --}}
                                                        <input type="hidden" name="tax_amount[]" id="tax_amount"
                                                            value="{{ $checkTaxname }}" readonly>
                                                    <!--</td>-->
                                                </tr>
                                            @endforeach

                                            <tr>
                                                {{-- <th></th>
                                                <th></th>
                                                <th></th> --}}
                                                <th colspan="4">Grand Total</th>
                                                <td> <h4><span id="tots">0.00</span></h4></td>
                                            </tr>







                                    </table>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" name="cust_name"
                                                    class="form-control @error('cust_name') is-invalid @enderror" required>

                                                @error('cust_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Zomato Order ID</label>
                                                <input type="text" name="zomtao_order_id"
                                                    class="form-control @error('zomtao_order_id') is-invalid @enderror"
                                                    required>

                                                @error('zomtao_order_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="payment_mode">Payment Mode</label>
                                                <select class="form-control  @error('payment_mode') is-invalid @enderror"
                                                    name="payment_mode" required>
                                                    <option value="">Select Payment Mode</option>
                                                    <option value="Cash">Cash</option>

                                                    <option value="UPI">UPI</option>


                                                </select>


                                                @error('payment_mode')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row no-print">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success float-right"><i
                                                    class="far fa-credit-card"></i>Generate Receipt</button>
                                        </div>
                                    </div>

                                </form>
                            @else
                                <span>No Item Added to Cart!!</span>
                            @endif


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
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
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
                    method: "post",
                    url: "{{ url('admin/zomato_add_to_cart') }}",
                    data: {
                        'item_id': item_id,
                        'item_qty': item_qty,
                        'price': price,

                    },

                    success: function(response) {
                        // swal(response.status);
                        toastr.success(response.status);
                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 60);

                    }

                });


            });



        });

        $(document).on('click', '.updateZomataoCartItem', function() {

            if ($(this).hasClass('plus-a')) {
                // Get Qty
                var quantity = $(this).data('qty');
                // Increase the Qty by 1
                new_qty = parseInt(quantity) + 1;
            }
            if ($(this).hasClass('minus-a')) {
                // Get Qty
                var quantity = $(this).data('qty');
                // Check Qty is Atleast 1
                if (quantity <= 1) {
                    alert("Item Quantity Must Be 1 or Greater !");
                    return false;
                }
                // desrease the Qty by 1
                new_qty = parseInt(quantity) - 1;
                // alert(new_qty);
            }
            var cartid = $(this).data('cartid');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    cartid: cartid,
                    qty: new_qty
                },
                url: 'update_zomato_cart',
                type: 'post',
                success: function(resp) {
                    //  alert(resp.status);
                    // swal(resp.status);
                    toastr.success(resp.status);
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 60);
                    // $('#myDiv').load('.quantity')
                    // alert('Reloaded')
                    if (resp.status == false) {
                        alert(resp.message);
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        });


    </script>
<script>
 $(document).ready(function() {
    var total = 0;
    var subvalue = $("#sub_total").val();
    $("#discount").keyup(function(){
    // alert(this.value);
        var subvalue = $("#sub_total").val();
        var dvalue =  parseInt(subvalue) - (parseInt(this.value) *  parseInt(subvalue))/100  ;

        // console.log(dvalue);
        $("#afterdissubtotal").val(dvalue.toFixed(2));
        $('#tots').text(Math.round(dvalue) );
    });
    $(document).on("click", ".checks", function() {
    if ($(this).prop('checked') == true) {
        total += Number($(this).data("price"));
        var afterdisamt = $("#afterdissubtotal").val();

        var checkamt = parseFloat(afterdisamt) + parseFloat(total) ;
        // console.log("afterdisamt",afterdisamt);
        // console.log("checkamt",checkamt);
    } else if ($(this).prop('checked') == false) {
        total -= Number($(this).data("price"));
        var afterdisamt = $("#afterdissubtotal").val();

       var checkamt = parseFloat(afterdisamt) + parseFloat(total) ;
    }
    // $('#tots').text(Math.round(total * 100) / 100);
    $('#tots').text(Math.round(checkamt) );
    });
    $('#tots').text(Math.round(subvalue) );






  });


</script>

    <script>
        //get input
        let input = document.getElementById("search");
        //get list of value
        let list = document.querySelectorAll(".list li");

        //function search on the list.
        function search() {
            for (let i = 0; i < list.length; i += 1) {
                //check if the element contains the value of the input
                if (list[i].innerText.toLowerCase().includes(input.value.toLowerCase())) {
                    list[i].style.display = "block";
                } else {
                    list[i].style.display = "none";
                }
            }
        }

        //to the change run search.
        input.addEventListener('input', search);
    </script>




@endsection
