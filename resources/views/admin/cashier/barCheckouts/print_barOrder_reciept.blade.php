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
}

td,
th,
tr,
table {
    border-top: 1px solid black;
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
}

        </style>
        
        <title>Receipt example</title>
    </head>
    <body>
        <div class="ticket">
             
            
             <p class="centered">
                 <img src="{{ asset('front_assets/img/logo.png') }}" alt="Logo" style="width: 20px;height: 20px;">
                 <br>
              {{ $getsiteSetting['website_name'] }}
                <br> 
                @if($getbarTableOrder['payment_mode']==NULL)
                @if($getbarTableOrder['image_url']!=NULL)
                  <img src="{{ $getbarTableOrder['image_url'] }}" alt="Dunkel beverage" style="width: 80px;height: 80px;">
                
                  @endif
                @endif
                 </p>
                 
                 <!--<p class="centered"> -->
                 <!-- <h2>Contact Info</h2>-->
                 <!--   Address : {{ $getsiteSetting['addresss'] }}</br>-->
                 <!--   Email   : {{ $getsiteSetting['email'] }}</br>-->
                 <!--   Phone   : {{ $getsiteSetting['phone'] }}</br>-->
                 <!--</p>-->
            <table>
                <thead>
                    <tr>
                        <!--<th class="quantity" >S.N</th>-->
                        <th class="description">Item Name</th>
                        <th class="description">Qty</th>
                        <th class="description">Offer</th>
                        <th class="description">Item Price</th>
                        <th class="description">Total Amount</th>
                        <th class="description"></th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($getbarTableOrderItem as $index=>$tkitem )
                    <tr>
                        <!--<td class="quantity">{{ $index+1 }}</td>-->
                        <td class="description">{{ $tkitem['menuitem']['menu_item_name'] }}</td>
                        <td class="price">{{ $tkitem['item_qty'] }}</td>
                       
                        <td class="price"> 
                        @if(!empty($tkitem['no_of_qty_buy']))
                              <p class="itemtext">Get {{$tkitem['no_qty_buy_to_free']}} Free</p>
                              @else
                              <p class="itemtext">0</p>
                              @endif</td>
                        <td class="price">Rs.{{ $tkitem['price'] }}</td>
                         <td class="price">Rs.{{ $tkitem['amount'] }}</td>
                         <td class="price"></td>
                    </tr>
                   
                   
                     @endforeach
                    
                </tbody>
                   <tr>
                        
                        <td class="price"></td>
                        <td class="price"></td>
                       
                        <td class="price"> </td>
                        <td class="description">Sub Total</td>
                         <td class="price">Rs.{{ $getbarTableOrder['sub_total'] }}</td>
                         <td></td>
                    </tr>
                     @if(!empty($getbarTableOrder['subtotalwithoffer']))
                        <tr >
                          
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="description">
                              <h2>Discount Apply </h2>
                          </td>
                          <td class="description">
                              <h2> {{ $getbarTableOrder['coupon_per'] }} % Off</h2>
                          </td>
                          <td></td>
                        </tr>
                        <tr >
                          
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="Rate">
                              <h2>New Sub Total</h2>
                          </td>
                          <td class="description">
                              <h2>Rs.{{ $getbarTableOrder['subtotalwithoffer'] }}</h2>
                          </td>
                          <td></td>
                        </tr>
                      @endif

                      <tbody>
                        @foreach ($barOrderTax as $taxduct )
                        <tr >
                          
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="description">{{ $taxduct['tax_name'] }} {{ $taxduct['tax_percentage'] }}%</td>
                         
                          <td class="description">Rs.{{ $taxduct['tax_amount'] }}</td>
                          <td></td>
                        </tr>
                            
                        @endforeach
                       
                      </tbody>
                      <br>
        
                            <tr >
                                
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="price">
                                    <h2>Grand Total</h2>
                                </td>
                                <td class="description">
                                    <h2>Rs.{{ $getbarTableOrder['grand_total'] }}</h2>
                                </td>
                                <td></td>
                            </tr>

                            @if($getbarTableOrder['taken_cash_amount']!= 0)

                            <tr >
                              
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="price">
                                  <h2>Given Cash</h2>
                              </td>
                              <td class="price">
                                  <h2>Rs.{{ $getbarTableOrder['taken_cash_amount'] }}</h2>
                              </td>
                               <td></td>
                          </tr>
                          <tr >
                           
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="price">
                                <h2>Taken Change Amount</h2>
                            </td>
                            <td class="price">
                                <h2>Rs.{{ $getbarTableOrder['given_change_amount'] }}</h2>
                            </td>
                             <td></td>
                        </tr>
                        @endif
            </table>
            <p class="centered">Thanks for your purchase!
                <br></p>
        </div>
  <!--       <button id="btnPrint" class="hidden-print">Print</button>
        <script>
            const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});
        </script> -->
        <script>
  window.addEventListener("load", window.print());
</script>
        
    </body>
</html>