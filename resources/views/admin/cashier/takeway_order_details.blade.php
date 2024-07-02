@extends('admin.layouts.layout')
@section('title', 'Take Away Order Details')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Take Away Order Details</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Take Away Details </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
 
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Take Away Details</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Take Way Purchase  Order Details</h4><br>
                                <div class="form-group">
                                    <label>Order No</label>
                                    <input class="form-control" value="{{ $takeoutorderslip['order_no'] }}" readonly="">
                                </div>
                                 <div class="form-group">
                                    <label>Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorderslip['sub_total'] }}" readonly="">
                                </div>
                                @if(!empty($takeoutorderslip['coupon_per']))
                                <div class="form-group">
                                    <label>Coupon Apply</label>
                                    <input class="form-control" value="{{ $takeoutorderslip['coupon_per'] }}% Off" readonly="">
                                </div>
                                @endif
                                @if(!empty($takeoutorderslip['subtotalwithoffer']))
                                <div class="form-group">
                                    <label>New Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorderslip['subtotalwithoffer'] }}" readonly="">
                                </div>
                                @endif
                               
                                <div class="form-group">
                                    <label>Total Tax</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorderslip['total_tax'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="Rs.{{ $takeoutorderslip['grand_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <input class="form-control" value="{{ $takeoutorderslip['payment_mode'] }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Take Way Purchase  Item List</h4><br>
                               
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Item Name</th>
                                    <th>Item QTY</th>
                                    <th style="width: 40px">Item Price</th>
                                    <th style="width: 40px">Total Amount</th>
                                    <th style="width: 40px">Offer Applicable</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($takewayorderitemslip as  $index => $orderitem )
            
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                           <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                                           <td>{{ $orderitem['item_qty'] }}</td>
                                           <td>Rs.{{ $orderitem['price'] }}</td>
                                           <td>Rs.{{ $orderitem['amount'] }}</td>
                                           <td class="text-success">
                                            @if(!empty($orderitem['no_of_qty_buy']))
                                            Buy{{ $orderitem['no_of_qty_buy'] }} Get {{$orderitem['no_qty_buy_to_free']}}Free
                                            @else
                                            No Offer
                                            @endif
                                        </td>
                                      </tr>
                                        
                                    @endforeach
                                
                                </tbody>
                              </table>
                              
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Take Way Order Wise Tax  List</h4><br>
                               
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

                       

                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>


  @endsection
  @section('script')
 


@endsection