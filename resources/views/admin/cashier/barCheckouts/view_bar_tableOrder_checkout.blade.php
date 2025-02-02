@extends('admin.layouts.layout')
@section('title','ViewBarTableOrderCheckout')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
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


        <div class="row mb-2">

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">View Bar Table Order Checkout </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>{{ $getsiteSetting['website_name'] }}</strong><br>
                  {{ $getsiteSetting['addresss'] }}<br>
                  Phone: {{ $getsiteSetting['phone'] }}<br>
                  Email: {{ $getsiteSetting['email'] }}
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice #{{ $getbarTableOrder['order_no'] }}</b><br>
                <br>
                <b>Bar Table Name:</b> {{ $getbarTableOrder['tables']['table_name'] }}<br>
                <b>Invoice Date:</b> {{ \Carbon\Carbon::parse($getbarTableOrder['created_at'])->isoFormat('MMM Do YYYY')}}<br>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <form class="forms-sample" action="{{ url('admin/save-barTableCheckoutOrder/'.$getbarTableOrder['order_no']) }}"method="post" enctype="multipart/form-data">
               @csrf
            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Tax</th>
                    <th>Subtotal</th>
                  </tr>
                  </thead>
                  <tbody>
                       @php
                           $subtotal_cost =0 ;
                       @endphp
                    @foreach ($getbarTableOrderItem as $index=>$baritemList )
                    @php
                      $taxamt = $baritemList['menuitem']['bar_tax_percentage']/100;
                      $amt = $baritemList['item_qty'] * $baritemList['menuitem']['menu_item_price'] ;
                      $totalamt = $amt + $amt * $taxamt;

                      //  subtotal_cost
                      $subtotal_cost += $totalamt ;
                    @endphp
                    <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $baritemList['menuitem']['menu_item_name'] }}</td>
                    <td>{{ $baritemList['item_qty'] }}</td>
                    <td>{{ $baritemList['menuitem']['menu_item_price'] }}</td>
                    <td>
                      {{ $baritemList['menuitem']['bar_tax_percentage'] }}
                    </td>
                    <td>
                      {{$totalamt}}
                    </td>
                  </tr>
                    @endforeach
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                
              </div>
              <!-- /.col -->
              <div class="col-6">
                

                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Subtotal:</th>
                      <td>
                        {{ $subtotal_cost }}
                        <input type="hidden" name="sub_total" id="sub_total" value="{{ $subtotal_cost }}" readonly>
                      </td>
                    </tr>
                    @foreach ($gettax as $selectTax )
                    @php
                       $checkTaxname = $subtotal_cost*$selectTax['tax_percentage']/100;
                      $tax_amount = $subtotal_cost +$checkTaxname ;
                    
                    @endphp
                    <tr>
                      <th>
                        <input type="checkbox" checked  name="tax_check_box[]" value="{{ $selectTax->id }}">
                        <input type="hidden" name="tax_name[]" value="{{ $selectTax->tax_name }}">
                        <input type="hidden" name="tax_percentage[]" value="{{ $selectTax->tax_percentage }}">
                        {{ $selectTax['tax_name'] }}({{ $selectTax['tax_percentage'] }}%)
                      </th>

                      <td>
                        {{ $checkTaxname }}
                         <input type="hidden" name="tax_amount[]" value="{{ $checkTaxname }}" readonly>
                      </td>
                    </tr>
                    @endforeach
                    
                    {{-- <tr>
                      <th>Total Tax:</th>
                      <td><input type="text" name="total_tax" id="total1" readonly></td>
                    </tr>
                    <tr>
                      <th>Grand Total :</th>
                      <td><input type="text" name="grand_total" id="grand_total" readonly></td>
                    </tr> --}}
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i>Generate Receipt</button>
              </div>
            </div>
            </form>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
<!-- /.content -->

@endsection
@section('script')

<script>
  function getTotal(objSelector)
{
    var total = 0;
    objSelector.each(function () {
        total += parseFloat($(this).val());
    });
    $("#tot_amount").val(total.toFixed(3));
    if (total == 0) {
      var ss = 0;
        $('#total1').val('0');
        var subtotal =  $('#sub_total').val();
      var tot = parseFloat(subtotal);
        var gt = parseFloat(tot);
        $('#grand_total').val(gt);
    } else {
        $('#total1').val(total);
    
      var subtotal =  $('#sub_total').val();
      var tot = parseFloat(subtotal) + parseFloat(total);
        var gt = parseFloat(tot);
        $('#grand_total').val(gt);
        
    }
}
$(document).ready(function () {
    getTotal($(".tot_amount"));
    $(".tot_amount").change(function (event) {
        getTotal($(".tot_amount:checked"));
    });

});
</script>

@endsection