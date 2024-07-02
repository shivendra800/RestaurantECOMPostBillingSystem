<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--<link rel="stylesheet" href="style.css">-->
             <style>

            * {
    font-size: 8px;
    font-family: 'Times New Roman';
    font-weight: bold;
     padding: 0  ;
    margin: 0  ;
}

td,
th,
tr,
table {
    border-top: .2px solid ;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;

    }
    .ticket {
          padding-top: 0px;
           padding-bottom: 0px ;
            margin-top: 0px;
           margin-bottom: 0px;
     }

}

        </style>
        <title>Receipt</title>
    </head>
    <body style="display:table-cell; text-align:center; vertical-align:middle;">
        <div class="ticket text-center">
            <a href="{{url('/')}}/admin/today-Take-away-order" class="hidden-print " style="font-size:30px; color:red;">Back</a>

             <p class="centered">
                 <img src="{{ asset('front_assets/img/logo.png') }}" alt="Logo" style="width: 30px;height: 30px;">
                 <br>
              {{ $getsiteSetting['website_name'] }}
                <br>
                <!--@if($takeoutorderslip['payment_mode']==NULL)-->
                <!--  <img src="{{ $takeoutorderslip['image_url'] }}" alt="Dunkel beverage" style="width: 80px;height: 80px;">-->
                <!--@endif-->
                 </p>

                <p class="centered">
                 <h2>Contact Info</h2>
                  Address : {{ $getsiteSetting['addresss'] }}</br>
                      GST   : <strong>01AAJCD8525H1ZS</strong></br>
                    PayAble Mode    : {{ $takeoutorderslip['payableamt'] }}</br>
                    Order No   : {{ $takeoutorderslip['order_no'] }}</br>
                    Waiter Name   :   @if($takeoutorderslip['staffs'] && $takeoutorderslip['staffs']['name'] )
                                     {{$takeoutorderslip['staffs']['name']}}
                                     @endif</br>
                    Table   :  @if($takeoutorderslip['tables'] && $takeoutorderslip['tables']['table_name'] )
                                    {{$takeoutorderslip['tables']['table_name']}}
                                      @endif</br>

            <table>
                <thead>
                    <tr>

                        <th class="description">Item Name</th>
                        <th class="description">Qty</th>
                        <th class="description">Offer</th>
                        <th class="description">Item Price</th>
                        <th class="description">Total Amount</th>
                        <th class="description"></th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($takewayorderitemslip as $index=>$tkitem )
                    <tr>
                        <!--<td class="quantity">{{ $index+1 }}</td>-->
                        <td class="description">
                            @if( $tkitem['menuitem']['menu_item_name'] &&  $tkitem['menuitem']['menu_item_name'])
                           {{  $tkitem['menuitem']['menu_item_name'] }}
                            @endif
                           <br>
                         @if($tkitem['extra_menu_item_id']!=NULL)
                                @if( $tkitem['extraitemadd'] &&  $tkitem['extraitemadd']['extra_menu'])
                                {{$tkitem['extraitemadd']['extra_menu']}}
                                @endif
                         @endif
                        </td>
                        <td class="price">{{ $tkitem['item_qty'] }}</td>

                        <td class="price">
                        @if(!empty($tkitem['no_of_qty_buy']))
                              <p class="itemtext">Get {{$tkitem['no_qty_buy_to_free']}} Free</p>
                              @else
                              <p class="itemtext">0</p>
                              @endif</td>
                        <td class="price">{{ $tkitem['price'] }}<br>
                             @if($tkitem['extra_menu_item_id']!=NULL)
                                {{$tkitem['extraItemPrice']}}

                                @endif
                        </td>
                         <td class="price">{{ $tkitem['amount'] }}</td>
                         <td class="price"></td>
                    </tr>


                     @endforeach

                </tbody>
                   <tr>

                        <td class="price"></td>
                        <td class="price"></td>

                        <td class="price"> </td>
                        <td class="description"  style="font-size: 7px;" >Sub Total</td>
                         <td class="price"  style="font-size: 7px;">{{ $takeoutorderslip['sub_total'] }}</td>
                         <td></td>
                    </tr>
                     @if(!empty($takeoutorderslip['coupon_per']>0))
                        <tr >

                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="description" style="font-size: 7px;">
                            Discount
                          </td>
                          <td class="description" style="font-size: 7px;">
                              {{ $takeoutorderslip['coupon_per'] }} % Off
                          </td>
                          <td></td>
                        </tr>
                        <tr >

                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="Rate" style="font-size: 7px;">
                               New Sub Total
                          </td>
                          <td class="description" style="font-size: 7px;">
                              {{ $takeoutorderslip['subtotalwithoffer'] }}
                          </td>
                          <td></td>
                        </tr>
                      @endif

                      <tbody>
                        @foreach ($orderwisetax as $taxduct )
                        <tr >

                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="description"  style="font-size: 7px;">{{ $taxduct['tax_name'] }} {{ $taxduct['tax_percentage'] }}%</td>

                          <td class="description"  style="font-size: 7px;">{{ $taxduct['tax_amount'] }}</td>
                          <td></td>
                        </tr>

                        @endforeach

                      </tbody>
                      <br>
                            <tr >
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="description">
                                    <h2>Grand Total</h2>
                                </td>
                                <td class="description">
                                    <h2>{{ $takeoutorderslip['grand_total'] }}</h2>
                                </td>
                                <td></td>
                            </tr>
                </table>
            <p class="centered">Thanks for your purchase!
                <br></p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script>
          window.addEventListener("load", window.print());
        </script>

    </body>
</html>
