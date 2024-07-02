@extends('frontend.layouts.layout')

@section('title','Checkout')

@section('content')


<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Checkout</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Checkout</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<header>


  <!-- Heading -->
  <div class="bg-primary">
    <div class="container py-4">
      <!-- Breadcrumb -->
      <nav class="d-flex">
        <h6 class="mb-0">
          <a href="" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="" class="text-white-50">2. Shopping cart</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="" class="text-white"><u>3. Order info & Payment</u></a>
          
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
  <!-- Heading -->
</header>

<section class="bg-white py-5">
  <div class="container">
    @if(Session::has('error_message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Errors:</strong> {{Session::get('error_message')}}
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
    @if($errors->any(''))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success:</strong> <?php echo implode('',$errors->all('<div>:message</div>')); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">
      <div class="col-xl-6 col-lg-6 mb-4" id="deliveryAddresses">
          @include('frontend.pages.delivery_address')
    </div>
     
      <div class="col-xl-6 card shadow-0 border p-4">
        <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf
        @if(count($deliveryAddresses)>0)
        <h4 class="mb-3">Delivery Addesses</h4>
        @foreach ($deliveryAddresses as $address )
        <div class="control-group" style="float:left;margin-right:5px;">
          <input type="radio" id="address{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}">
        </div>

        <div>
          <label class="control-label">{{ $address['name'] }},{{ $address['address'] }},{{ $address['city'] }},{{ $address['state'] }},{{ $address['pincode'] }},({{ $address['mobile'] }}).</label>
            <a style="float: right; margin-left:5px;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="removeAddress">Remove</a>&nbsp;&nbsp;
            <a style="float: right;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Edit</a>&nbsp;&nbsp;
        </div>
        @endforeach
        @endif
          <hr>
        <h4 class="mb-3">Your Order</h4>
        <div class="ms-lg-4 mt-4 " >  
          <hr />
          <div class="d-flex align-items-center mb-4">
            <table class="me-3 position-relative">
              <thead>
                  <tr class="d-flex justify-content-between">
                      <th class="mb-2">Product</th>
                      <th class="mb-4 text-right">Total</th>
                  </tr>
              </thead>
              <tbody>
                @php $total_price=0 @endphp
                @foreach ($MenuItemCart as $cartlist )
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
                <tr>
                  <td>
                    <a href="{{ url('menu-item/'.$cartlist['menu_item_id']) }}">
                        <img width="30" src="{{ url('/') }}/front_assets/menu_item_image/{{ $cartlist['usermenuitem']['menu_item_image'] }}" style="width: 30px; height: 30px" class="img-sm rounded border" alt="Product">
                    <h6 class="order-h6 "> {{ $cartlist['usermenuitem']['menu_item_name'] }} ({{ $cartlist['usermenuitem']['menu_item_code'] }})</h6>
                    Quantity:-<span class=" p-1">{{  $cartlist['menu_item_qty'] }}</span>
                    <br> @if(!empty($no_of_qty_buy))
                    <button class="btn btn-warning"> Get {{ $free_qty}} Free</button>
                 <input type="hidden" name="no_of_qty_buy[]" value="{{$no_of_qty_buy}}">
                    <input type="hidden" name="no_qty_buy_to_free[]" value="{{$free_qty}}">
                    @else
                    <input type="hidden" name="no_of_qty_buy[]" value="0">
                    <input type="hidden" name="no_qty_buy_to_free[]" value="0"> 
                    @endif
                  </td>
                <td>
                  <h6 class="price text-muted"><strong>Rs.{{ $cartlist['usermenuitem']['menu_item_price'] * $cartlist['menu_item_qty'] }}</strong></h6>
              </td>
                </tr>
                @php $total_price =  $total_price + ( $cartlist['menu_item_price'] *$cartlist['menu_item_qty']) @endphp
                @endforeach
              </tbody>
            </table>
          
          </div>
          <hr />
          <h6 class="mb-3">Summary</h6>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Sub Total:</p>
            <p class="mb-2">Rs.{{ $total_price }}</p>
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
          <div class="d-flex justify-content-between">
            <p class="mb-2" >Apply Coupon(<strong>{{$max_code}}</strong>)</p>
            <p class="mb-2 text-danger"><button class="btn btn-warning">{{$max_offer_per}}% Off</button></p>
          </div>
          <input type="hidden" name="coupon_avail_amount" value="{{$max_amount}}" placeholder="coupon percentage">
          <input type="hidden" name="coupon_code" value="{{$max_code}}" placeholder="coupon code">
          <input type="hidden" name="coupon_per" value="{{$max_offer_per}}" placeholder="coupon per">
          @else
          <input type="hidden" name="coupon_avail_amount" value="0" placeholder="coupon percentage">
          <input type="hidden" name="coupon_code" value="0" placeholder="coupon code">
          <input type="hidden" name="coupon_per" value="0" placeholder="coupon per" >
          @endif

          @if($max_amount)
          {{-- After Discount New SubTotal ,Tax and Grand Total  --}}
          @php
          $subtotalwithoffer = $total_price - (($total_price*$max_offer_per)/100)
          @endphp

          <div class="d-flex justify-content-between">
            <p class="mb-2">After Discount SubTotal:</p>
            <p class="mb-2">Rs.{{ $subtotalwithoffer }}</p>
            <input type="hidden" name="subtotal" value="{{ $total_price }}">
            <input type="hidden" name="subtotalwithoffer" value="{{ $subtotalwithoffer }}">
          </div>
        
          @php $tax_price = 0;@endphp
          @foreach ($gettaxList as $tax )
          <div class="d-flex justify-content-between">
            <p class="mb-2">{{ $tax['tax_name'] }}<span>{{ $tax['tax_percentage'] }}%</span></p>
            <p class="mb-2">Rs.{{$subtotalwithoffer * $tax['tax_percentage']/100}}</p>
            <input type="hidden" name="tax_name[]" value="{{ $tax['tax_name'] }}">
            <input type="hidden" name="tax_percentage[]" value="{{ $tax['tax_percentage'] }}">
            <input type="hidden" name="tax_amount[]" value="{{$subtotalwithoffer * $tax['tax_percentage']/100}}">
          </div>
          @php $tax_price =  $tax_price + ( $subtotalwithoffer * $tax['tax_percentage']/100) @endphp
          @endforeach
          <hr>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Grand Total:</p>
            <p class="mb-2 fw-bold">Rs.{{ $subtotalwithoffer + $tax_price }}</p>
            <input type="hidden" name="total_tax" value="{{ $tax_price }}">
            <input type="hidden" name="grand_total" value="{{ $subtotalwithoffer + $tax_price }}">
          </div>
          <hr/>
    {{-- After Discount New SubTotal ,Tax and Grand Total End --}}
          @else
          <input type="hidden" name="subtotalwithoffer" value="0">
          <input type="hidden" name="subtotal" value="{{ $total_price }}">
   {{-- Coupon Not Apply tax and grand total  --}}
          @php $tax_price = 0;@endphp
          @foreach ($gettaxList as $tax )
          <div class="d-flex justify-content-between">
            <p class="mb-2">{{ $tax['tax_name'] }}<span>{{ $tax['tax_percentage'] }}%</span></p>
            <p class="mb-2">Rs.{{$total_price * $tax['tax_percentage']/100}}</p>
            <input type="hidden" name="tax_name[]" value="{{ $tax['tax_name'] }}">
            <input type="hidden" name="tax_percentage[]" value="{{ $tax['tax_percentage'] }}">
            <input type="hidden" name="tax_amount[]" value="{{$total_price * $tax['tax_percentage']/100}}">
          </div>
          @php $tax_price =  $tax_price + ( $total_price * $tax['tax_percentage']/100) @endphp
          @endforeach
          <hr>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Grand Total:</p>
            <p class="mb-2 fw-bold">Rs.{{ $total_price + $tax_price }}</p>
            <input type="hidden" name="total_tax" value="{{ $tax_price }}">
            <input type="hidden" name="grand_total" value="{{ $total_price + $tax_price }}">
          </div>
          <hr/>
   {{-- Coupon Not Apply tax and grand total End  --}}
          @endif

       
       
          <div class="u-s-m-b-13">
            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-delivery" value="COD">
            <label class="label-text" for="cash-on-delivery">Cash on Delivery</label>
        </div>
        <div class="u-s-m-b-13">
            <input type="radio" class="radio-box" name="payment_gateway" id="Razorpay" value="Razorpay">
            <label class="label-text" for="Razorpay">Razorpay Payment Gateway </label>
        </div>
      
        <div class="u-s-m-b-13">
            <input type="checkbox" class="check-box" id="accept" name="accept" value="Yes"  title="Please Agree to T&C">
            <label class="label-text no-color" for="accept">I’ve read and accept the
                <a href="{{ url('term-condition') }}" class="u-c-brand">terms & conditions</a>
            </label>
        </div>
        <button type="submit" id="placeOrder" class="button button-outline-secondary">Place Order</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</section>


@endsection