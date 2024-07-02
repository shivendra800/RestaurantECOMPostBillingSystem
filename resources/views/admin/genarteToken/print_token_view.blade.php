
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

@media all {
.page-break { display: none; }
}

@media print {
.page-break { display: block; page-break-before: always; }
}

.circle {
        border-radius: 50%;
        width: 34px;
        height: 34px;
        padding: 10px;
        background: #fff;
        border: 3px solid #000;
        color: #000;
        text-align: center;
        font: 32px Arial, sans-serif;
      }

.center {
  margin: auto;
  width: 60%;
  border: 3px solid #73AD21;
  padding: 10px;
}



        </style>
        
        <title>Bar Token</title>
    </head>
   
    <body style="display:table-cell; text-align:center; vertical-align:middle;" >
       
        
        <div class="ticket text-center">
            <a href="{{url('/')}}/admin/genarate-token" class="hidden-print " style="font-size:30px; color:red;">Back</a>
            
             <p class="centered">
                 <img src="{{ asset('front_assets/img/logo.png') }}" alt="Logo" style="width: 30px;height: 30px;">
                 <br>
              {{ $getsiteSetting['website_name'] }}
               
                 </p>
                 <hr>
                <p class="centered"> 
                 <h2>Contact Info</h2>
                  Address : {{ $getsiteSetting['addresss'] }}</br>
               </p>
               <hr>
               <hr>
               <p class="centered"> 
                <h2>Token Details</h2>
                 Token No : {{ $gettokenlist['token_no'] }}</br>
                 Token Generate Date : {{ \Carbon\Carbon::parse($gettokenlist['created_at'])->isoFormat('MMM Do YYYY')}}</br>
                  Payment Mode : {{ $gettokenlist['payment_mode'] }}</br>
                  Name : {{ $gettokenlist['name'] }}</br>
                  Mobile : {{ $gettokenlist['mobile_no'] }}</br>
                  <!--Discount : {{ $gettokenlist['is_discount'] }}</br>-->
                  No OF Bill Generated : {{ $gettokenlist['no_of_bill_print'] }}</br
              </p>
              <hr>

              <p
              style="color:hsl(0, 96%, 53%); font-size:18px;line-height:20px; margin:0; font-weight: 500;">
              <strong  style="display: block;font-size: 13px; margin: 0 0 4px; color:rgba(0,0,0,.64); ">Token Amount</strong>
                  <div class="circle center">
                      {{ $gettokenlist['token_amount'] }}
                      @if( $gettokenlist['is_discount'] == "Yes")
                      <!--<span>D</span>-->
                      D
                       @endif
                  </div> 
              
          </p>

            <p class="centered">Thanks for your purchase!
                <br></p>
                
        </div>
        <br>
         <div class="page-break"></div>
       
        
        
       
      
  <br>

     
        <button id="btnPrint" class="hidden-print">Print</button>
        <script>
          window.addEventListener("load", window.print());
        </script>
        
    </body>
  
</html>
