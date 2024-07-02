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
          
            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
              
                <table class="table table-bordered">
                    <col/>
                    @foreach ($getbarTableOrderItem as $index=>$baritemList )
                    <tr>
                      <td rowspan="2"></td>
                      <th colspan="4" scope="colgroup">{{ $baritemList['barchairname']['chair_name'] }}</th>                
                    </tr>
                    <tr>
                      <th scope="col">Qty</th>
                      <th scope="col">Item Price</th>
                      <th scope="col">Tax</th>
                      <th scope="col">Amount</th>
                     
                    </tr>
                    @php
                    $subtotal = 0;
                @endphp
                    @foreach ($getbarchairOrderItem as $index=>$getchairsorder )
              @if($baritemList['chairs_id']==$getchairsorder['chairs_id'])
              <form class="forms-sample" action="{{ url('admin/Checkout-chairwiseorder/'.$getchairsorder['chairs_id']) }}"method="post" enctype="multipart/form-data">
                @csrf
                      @php
                      $subtotal += $getchairsorder['amount'];
                      @endphp  
                    <tr>
                      <th scope="row">{{ $getchairsorder['menuitem']['menu_item_name'] }}
                        <input type="hidden" name="id[]"  value="{{ $getchairsorder['id'] }}" readonly>
                      </th>
                      <td>{{ $getchairsorder['item_qty'] }}</td>
                      <td>{{ $getchairsorder['price'] }}</td>
                      <td>{{ $getchairsorder['bar_tax_percentage'] }}%</td>
                      <td>{{ $getchairsorder['amount'] }}</td>
                     
                    </tr>
                    
                  
                    @endif
                    @endforeach
                    <tr>
                      <td rowspan="2"></td>
                      <th colspan="3" scope="colgroup">SubTotal</th>
                      <th colspan="3" scope="colgroup">
                        {{ $subtotal }}
                        <input type="hidden" name="sub_total" id="sub_total" value="{{ $subtotal }}" readonly>
                      </th>
              
                      
                    </tr>
                    <tr>
                      @php
                       $servchrg= $subtotal*$gettaxServiceCharge['tax_percentage']/100;
                       $grandtotla = $subtotal + $servchrg;

                      @endphp
                      {{-- <th> <input type="checkbox"  class="tot_amount_{{$servchrg  }}"  name="tax_check_box[]" value="{{ $servchrg }}"></th> --}}
                      <th colspan="3" scope="colgroup">{{ $gettaxServiceCharge['tax_name'] }}({{ $gettaxServiceCharge['tax_percentage'] }}%)</th>
                      <th colspan="3" scope="colgroup">
                        {{ $servchrg }}
                        <input type="hidden" name="servchrg" id="servchrg" value="{{ $servchrg }}" readonly>
                      </th>
                    </tr>
                    <tr>

                      <th colspan="1" scope="colgroup"></th>
                      <th colspan="3" scope="colgroup">Grand Total</th>
                      <th colspan="2" scope="colgroup">
                        {{ $grandtotla }}
                        <input type="hidden" name="grand_total"  value="{{ $grandtotla }}" readonly>
                        <input type="hidden" name="order_no"  value="{{ $getbarTableOrder['order_no'] }}" readonly>
                        <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i>Generate Receipt</button>
                 
                      </th>
          
                    </tr>

                   
                     
                   
                    </form>
                   
                    @endforeach
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
                

             
              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->

            <!-- this row will not appear when printing -->
          
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