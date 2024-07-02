<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
  <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
  <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
  <title>Print Restaurant Bar KOT</title>

<style>
    #invoice-POS {
  border: 1px solid #ddd;
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: 0.9em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS p {
  font-size: 0.7em;
  color: #666;
  line-height: 1.2em;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}
#invoice-POS #top {
  min-height: 100px;
}
#invoice-POS #mid {
  min-height: 80px;
}
#invoice-POS #bot {
  min-height: 50px;
}
#invoice-POS #top .logo {
  height: 50px;
  width: 50px;
  background: url('{{asset('front_assets/img/logo.png')}}') no-repeat;
  background-size: 50px 50px;
}
#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: 0.5em;
  background: #EEE;
}
#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: 0.5em;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
}
</style>
</head>
<body translate="no" >

<div id="invoice-POS">
    
    <center id="top">
      <div class="logo"></div>
      <div class="info"> 
        <h2>Dunkel Beverage</h2>
      </div>
    </center>
    
    <div id="mid">
      <div class="info">
        <h2>Order Summary Info</h2>
        <p> 
            Order No : {{ $getorderNo['order_no'] }}</br>
            No Of Person To Serve : {{ $getorderNo['total_no_person_intable'] }}</br>
            Table No  : {{ $getorderNo['tables']['table_name'] }}</br>
            Waiter Name    : {{ $getorderNo['staffs']['name'] }}</br>
            Order Date : {{ \Carbon\Carbon::parse($getorderNo['created_at'])->isoFormat('MMM Do YYYY')}}</br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    <h2> Bar Order KOT</h2>
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Item</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Order Status</h2></td>
							</tr>
                           @foreach ($getorderitemList as $itemLst )
                           <tr class="service">
                            <td class="tableitem"><p class="itemtext">{{ $itemLst['menuitem']['menu_item_name'] }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ $itemLst['item_qty'] + $itemLst['no_qty_buy_to_free']  }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ $itemLst['order_item_status'] }}</p></td>
                        </tr>
                           @endforeach
						

							

							{{-- <tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td class="payment"><h2>3,644.25</h2></td>
							</tr> --}}

						</table>
					</div>

					<div id="legalcopy">
						<p class="legal"><strong>Thank you for your Order!</strong>
                            This Is Order Summary.
						</p>
                        <button id="btnPrint">Print this page</button>
                       
					</div>

				</div>
  </div>




<script>
    const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});
</script>

</body>

</html>


