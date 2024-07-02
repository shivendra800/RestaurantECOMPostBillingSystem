@extends('frontend.layouts.layout')

@section('title','View Cart')

@section('content')


<style>
    /* Cart or Wishlist */
    .shopping-cart .cart-header {
        padding: 10px;
    }

    .shopping-cart .cart-header h4 {
        font-size: 18px;
        margin-bottom: 0px;
    }

    .shopping-cart .cart-item a {
        text-decoration: none;
    }

    .shopping-cart .cart-item {
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
        padding: 10px 10px;
        margin-top: 10px;
    }

    .shopping-cart .cart-item .product-name {
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        cursor: pointer;
    }

    .shopping-cart .cart-item .price {
        font-size: 16px;
        font-weight: 600;
        padding: 4px 2px;
    }

    .shopping-cart .btn1 {
        border: 1px solid;
        margin-right: 3px;
        border-radius: 0px;
        font-size: 10px;
    }

    .shopping-cart .btn1:hover {
        background-color: #2874f0;
        color: #fff;
    }

    .shopping-cart .input-quantity {
        border: 1px solid #000;
        margin-right: 3px;
        font-size: 12px;
        width: 40%;
        outline: none;
        text-align: center;
    }

    /* Cart or Wishlist */
</style>
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>View Cart</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Cart</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="py-3 py-md-5 bg-light">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="shopping-cart">

                    <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Products</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Price</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Quantity</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Total Amt</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>Remove</h4>
                            </div>
                        </div>
                    </div>
                    @php $total_price=0 @endphp
                    @foreach ($MenuItemCart as $cartlist )
                  
                    <div class="cart-item">
                        {{-- Apply Coupon Product Wise --}}
                        @php
                        $date = date('Y-m-d');
                         $productcoupon =App\Models\ProductWiseCoupon::where('no_of_qty_buy','<=',$cartlist['menu_item_qty'])->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
                                $free_qty = $productcoupon->where('product_id',$cartlist['menu_item_id'])->max('no_qty_buy_to_free');
                                $no_of_qty_buy = $productcoupon->where('product_id',$cartlist['menu_item_id'])->max('no_of_qty_buy');
                               
                               if($free_qty>0)
                               {
    
                                if($no_of_qty_buy <= $cartlist['menu_item_qty'])
                            {
                                
                                $getqty = ($cartlist['menu_item_qty'] / $no_of_qty_buy);
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

                        <div class="row">
                            <div class="col-md-4 my-auto">
                                <a href="">
                                    <label class="product-name">
                                        <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $cartlist['usermenuitem']['menu_item_image'] }}" style="width: 50px; height: 50px" alt="">
                                        {{ $cartlist['usermenuitem']['menu_item_name'] }}
                                      @if($free_qty>0) <button class="btn btn-warning"> Get {{ $free_qty}} Free</button> @endif
                                    </label>
                                </a>
                            </div>
                            <div class="col-md-2 my-auto">
                                <label class="price">Rs.{{ $cartlist['usermenuitem']['menu_item_price'] }} </label>
                            </div>
                         
                            <div class="col-md-2  my-auto">
                                <div class="quantity">
                                    <div class="input-group">
                                        <a class="btn btn1 minus-a updateMenuCartItem" data-cartid="{{ $cartlist['id'] }}" data-qty="{{  $cartlist['menu_item_qty'] }}"  data-min="1"><i class="fa fa-minus"></i></a>
                                        <input type="text" value="{{ $cartlist['menu_item_qty'] }}" class="input-quantity quantity-text-field" />
                                        <a class="btn btn1 plus-a updateMenuCartItem" data-cartid="{{ $cartlist['id'] }}" data-qty="{{  $cartlist['menu_item_qty'] }}" data-max="1000"><i class="fa fa-plus"></i></a>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 my-auto">
                                <label class="price">Rs.{{ $cartlist['usermenuitem']['menu_item_price'] * $cartlist['menu_item_qty'] }} </label>
                            </div>
                            <div class="col-md-2 col-5 my-auto">
                                <div class="remove">
                                    <button class="btn btn-danger btn-sm deleteMenuCartitem" data-cartid="{{ $cartlist['id'] }}">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    @php $total_price =  $total_price + ( $cartlist['menu_item_price'] *$cartlist['menu_item_qty']) @endphp
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>
   <div class="row">
       <div class="col-lg-8">
         
       </div>
       <div class="col-lg-4">
        <span class="text-bold"> <b>Cart Total</b> </span>
        <hr>

           <div class="row">
            <div class="col-md-6">SubTotal</div>
            <div class="col-md-6">Rs.{{ $total_price }}</div>
           </div>
            @php
               $date = date('Y-m-d');
               $coupon =App\Models\CouponOnPrice::where('order_amount','<=',$total_price)->where('start_date', '<=', $date)->where('expiry_date', '>=', $date)->get();
                   $max_code = $coupon->max('promocode');
                   $max_amount = $coupon->max('order_amount');
                   $max_offer_per = $coupon->max('offer_per');
                   $max_remark = $coupon->max('remark');
            @endphp

                @if($max_amount)
                <div class="row">
                    <div class="col-md-6">Apply Coupon(<strong>{{$max_code}}</strong>)</div>
                    <div class="col-md-6"><button class="btn btn-warning">{{$max_offer_per}}% Off</button></div>
                   </div>
                @endif

                @if($max_amount)
                {{-- After Discount New SubTotal ,Tax and Grand Total  --}}
                @php
                $subtotalwithoffer = $total_price - (($total_price*$max_offer_per)/100)
                @endphp

                    <div class="row">
                        <div class="col-md-6">After Discount SubTotal</div>
                        <div class="col-md-6">Rs.{{ $subtotalwithoffer }}</div>
                    </div>

                @php $tax_price = 0;@endphp
                @foreach ($gettaxList as $tax )
                <div class="row">
                 <div class="col-md-6">{{ $tax['tax_name'] }} <span>{{ $tax['tax_percentage'] }}%</span></div>
                 <div class="col-md-6">Rs.{{$subtotalwithoffer * $tax['tax_percentage']/100}}</div>
                </div>
                @php $tax_price =  $tax_price + ( $subtotalwithoffer * $tax['tax_percentage']/100) @endphp
                @endforeach
                <div class="row">
                    <div class="col-md-6">Grand Total</div>
                    <div class="col-md-6">Rs.{{ $subtotalwithoffer + $tax_price }}</div>
                   </div>

                @else
                    {{-- After Discount New SubTotal ,Tax and Grand Total End --}}

                 {{-- Coupon Not Apply tax and grand total  --}}

                        @php $tax_price = 0;@endphp
                    @foreach ($gettaxList as $tax )
                        <div class="row">
                        <div class="col-md-6">{{ $tax['tax_name'] }} <span>{{ $tax['tax_percentage'] }}%</span></div>
                        <div class="col-md-6">Rs.{{$total_price * $tax['tax_percentage']/100}}</div>
                        </div>
                      @php $tax_price =  $tax_price + ( $total_price * $tax['tax_percentage']/100) @endphp
                    @endforeach


                <div class="row">
                    <div class="col-md-6">Grand Total</div>
                    <div class="col-md-6">Rs.{{ $total_price + $tax_price }}</div>
                </div>
   {{-- Coupon Not Apply tax and grand total End  --}}
                @endif



         
          
          
           <div class="row mt-1">
            <div class="col-md-12 ">
                
                    <a href="{{ url('checkout') }}"  class="btn btn-warning" >Proceed  To CheckOut</a>
                
            </div>
                
           </div>
      
       </div>
   </div>

@endsection