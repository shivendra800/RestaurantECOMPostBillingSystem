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
   /*   html, body {*/
   /* width: 80mm;*/
   /* height:100%;*/
   /* position:absolute;*/
   /*}*/
      
    
}






        </style>
        
        <title>KOT</title>
    </head>
    <body style="display:table-cell; text-align:center; vertical-align:middle;">
        <div class="ticket text-center">
            <a href="{{url('/')}}/admin/table-orderList" class="hidden-print " style="font-size:30px; color:red;">Back</a>
            
             <p class="centered">
              
              <b><img src="{{ asset('front_assets/img/logo.png') }}" alt="Logo" style="width: 30px;height: 30px;"></b>
                 <br>
                 Dunkel Beverage
                <br> 
               <hr>
                 </p>
               
                <p class="centered"> 
                 <h2>Order  Info</h2>
                 PayAble Mode : {{ $getorderNo['payableamt'] }}</br>
                 Order No : {{ $getorderNo['order_no'] }}</br>
                 No Of Person To Serve : {{ $getorderNo['total_no_person_intable'] }}</br>
                 Table No : {{ $getorderNo['tables']['table_name'] }}</br>
                 Assign To : {{ $getorderNo['staffs']['name'] }}</br>
                Order Date : {{ \Carbon\Carbon::parse($getorderNo['order_time'])->isoFormat('MMM Do YYYY H:m:s')}} </br>
                 
                 </p>
                 <hr>
                 <strong>Print KOT</strong>
                 <hr>
            <table>
                <thead>
                    <tr>
                      
                        <th class="description">Item </th>
                        <th class="description">Additional</th>
                        <th class="description">Qty</th>
                        <!--<th class="description">Order Status</th>-->
                      
                    </tr>
                </thead>
                <tbody>
                @foreach ($getorderitemList as $itemLst )
                    <tr>
                     
                        <td class="description">
                            <strong>{{ $itemLst['menuitem']['menu_item_name'] }}<br></strong>
    
                            <strong>ServeTime:- {{ $itemLst['item_serve_time'] }}</strong><br>
                            <strong>Remark:- {{ $itemLst['remark'] }}</strong>
                        </td>
                        <td class="price"> <strong>
                            @if($itemLst['extra_menu_item_id']!=0)
                            {{$itemLst['extraitemadd']['extra_menu']}}
                            @else
                            ---
                            @endif
                           </strong></td>
                       
                        <td class="price"> 
                            {{ $itemLst['item_qty'] + $itemLst['no_qty_buy_to_free']  }}
                      </td>
                        <!--<td class="price">-->
                        <!--    {{ $itemLst['order_item_status'] }}-->
                        <!--</td>-->
                        
                    </tr>
                   
                   
                     @endforeach
                    
                </tbody>
                  
                  

            </table>
           
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script>
          window.addEventListener("load", window.print());
        </script>
        
    </body>
</html>