@extends('admin.layouts.layout')
@section('title','View TakeWay Order Item')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>View TakeWay Order Item</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">View TakeWay Order Item </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-info card-tabs">
    <div class="card-header p-0 pt-1">
        <br>
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
                <div class="card-header bg-primary ">
                   {{ $takeWayorder['order_no'] }} 
                </div>   
                <br>
            </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br>
        </ul>
    </div>
    <!-- /.card -->
</div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">View TakeWay Order Item</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 

                  <th style="width: 20px">ID</th>
                  <th style="width: 80px">Item Name</th>
                  <th style="width: 80px">Total Item QTY</th>
                  {{-- <th style="width: 10px">Item QTY</th>
                  <th style="width: 40px">Item Price</th>
                  <th style="width: 40px">Total Amount</th> --}}
                  <th style="width: 40px">Order Item Status</th>
                  {{-- <th style="width: 40px">Offer</th> --}}
                  <th style="width: 40px">Action</th>
                 
                </tr>
                </thead>
                <tbody>
                    @foreach ($orderNoWiseItem as $index=>$orderitem)
                        <tr>
                       
                        
                        <td>{{$index+1}}</td>
                        <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                        <td>{{ $orderitem['item_qty'] + $orderitem['no_qty_buy_to_free']  }}</td>
                                           {{-- <td>{{ $orderitem['item_qty'] }}</td>
                                           <td>Rs.{{ $orderitem['price'] }}</td>
                                           <td>Rs.{{ $orderitem['amount'] }}</td> --}}
                                           <td class="btn btn-warning">{{ $orderitem['order_item_status'] }}</td>
                                           {{-- <td class="">
                                             @if(!empty($orderitem['no_qty_buy_to_free']))
                                             <span class="text-success">{{$orderitem['no_qty_buy_to_free']}} Item  Free</span>
                                             <br>
                                             <span class="badge badge-info">Buy {{$orderitem['no_of_qty_buy']}}  Get  {{$orderitem['no_qty_buy_to_free']}} Free</span>
                                             @else
                                             <span class="text-danger"> No Offer</span>
                                             @endif
                                           </td> --}}
                                     <td> 
                                       @if($orderitem['order_item_status']=="New-Order")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-TakeWayOrder-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Accepted">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Accepted")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-TakeWayOrder-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Preparing">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success"  type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Preparing")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-TakeWayOrder-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Prepared">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Prepared")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-TakeWayOrder-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Collected">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                    </td>
                        
                       
                        
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->


@endsection
@section('script')

<script>
     function InActiveRow(id)
{
  console.log(id);
  swal({
    title: "Are you sure?",
    text: "You want to change status",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $("#active_form_"+id).submit();
    } else {
      //swal("Your data is safe!");
    }
  });

}
</script>

@endsection