<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
     <title>{{ $dummyprodpurch['vendor']['vendor_name'] }}</title>
</head>
<body>


    <table id="customers">
        <tr>
            <td>
                <h2> Compay Details  </h2>
                <h2> {{ $getsiteSetting['website_name'] }}  </h2>
                    <p>Address : {{ $getsiteSetting['addresss'] }}</p>
              
            </td>
            <td>
                <h2>Vendor Details</h2>
             
                <p> Name:- <strong>{{ $dummyprodpurch['vendor']['vendor_name'] }}</strong></p>  
              <p>Frim Name :-<strong>{{ $dummyprodpurch['vendor']['v_firm_name'] }}</strong></p>
             
              <p>Address:- <strong>{{ $dummyprodpurch['vendor']['v_address'] }}</strong></p>
              <p>PhoneNo:- <strong>{{ $dummyprodpurch['vendor']['v_phone_no'] }}</strong></p>
               
                
            </td>
        </tr>


    </table>

 



    <table id="customers">
        <tr>
            <th width="10%">Sl</th>
            <th width="45%">Product Name</th>
            <th width="45%">Product Unit</th>
            <th width="45%">Product QTY</th>
        </tr>
         @foreach ($dummyprodpurchitem as $index=> $itemlist  )
             
        
        <tr>
            <td>{{$index+1}}</td>
            <td><b>{{ $itemlist['product']['ingredient_name'] }}</b></td>
            <td><b>{{ $itemlist['unit']['unit_name'] }}</b></td>
            <td>{{ $itemlist['qty'] }}</td>
        </tr>
          @endforeach

    </table>
    <br> <br>
    <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

</body>
</html>