@extends('admin.layouts.layout')
@section('title','ViewBarTableOrderCheckout')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @include('admin.errors.all_mesg')

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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header bg-info  ">
                        <div class="card-title " style="display:inline-flex; float:right">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes['tables']->table_name}}--{{$orderes['tables']->table_type}}</div> &nbsp;

                        </div>
                        <div class="card-title  " style="display:inline-flex; float:center">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes['staffs']->name}}</div> &nbsp;

                        </div>
                        <div class="card-title " style="display:inline-flex; float:left">
                            <div type="button" class="btn btn-block btn-danger btn-flat ">{{$orderes->order_no}}</div> &nbsp;

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.container-fluid -->
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

            <!-- /.row -->

            <form action="{{ url('admin/save-tax-temprazordata/'.$orderes['order_no']) }}" method="post">
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
                    <th>Subtotal</th>
                  </tr>
                  </thead>
                  <tbody>
                       @php
                           $subtotal_cost =0 ;
                       @endphp
                    @foreach ($ordereitemlist as $index=>$itemList )
                    @php
                      //  subtotal_cost
                      $subtotal_cost += $itemList['amount'] ;
                    @endphp
                    <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $itemList['menuitem']['menu_item_name'] }}<br>
                        @if($itemList['extraItemPrice']!=Null)
                       <small class="text-danger"> Extra:-{{ $itemList['extraitemadd']['extra_menu'] }}</small>
                       @endif
                    </td>
                    <td>{{ $itemList['item_qty'] }}</td>
                    <td>
                        {{ $itemList['menuitem']['menu_item_price'] }}<br>
                        @if($itemList['extraItemPrice']!=Null)
                        <small class="badge badge-info"> ExtraItemPrice:-   {{ $itemList['extraItemPrice'] }}</small>
                        @endif
                    </td>
                    <td>
                      {{$itemList['amount']}}
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
                    <tr>
                      <th>Apply Discount</th>
                      <td><input type="number" step="0.001" min="0" max="20" name="discount" value="0" ></td>
                    </tr>

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
