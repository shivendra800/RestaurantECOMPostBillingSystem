@extends('admin.layouts.layout')
@section('title','View Table Order Item')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>View Table Order Item</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">View Table Order Item </li>
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
                   {{ $getorderNo['order_no'] }} 
                </div>   
                <br>
            </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br>
            <li class="nav-item">
                <div class="card-header bg-success ">
                   {{ $getorderNo['tables']['table_name'] }}--{{ $getorderNo['tables']['table_type'] }} 
                </div>   
            </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
                <div class="card-header bg-danger ">
                   {{ $getorderNo['staffs']['name'] }}
                </div>      
            </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
                <div class="card-header bg-warning ">
                   {{ $getorderNo['order_status'] }}
                </div>      
            </li>
        </ul>
    </div>
 
</div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">View Table Order Item</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th style="width: 80px">Item Name</th>
                
                  <th style="width: 80px">Total Item QTY</th>
                  <th style="width: 40px">Order Item Status</th>
                  <th style="width: 80px">Replace Remark</th>
                  <th style="width: 80px">Request To Delete </th>
                  <th style="width: 40px">Action</th>
                 
                </tr>
                </thead>
                <tbody>
                    @foreach ($orderNoWiseItem as $index=>$orderitem)
                        <tr>
                       
                        
                    
                        <td>{{ $orderitem['menuitem']['menu_item_name'] }}<br>
                          <strong>ItemServeTime:-  {{ $orderitem['item_serve_time'] }}</strong>
                        
                        </td>
                       
                                          <td>{{ $orderitem['item_qty'] + $orderitem['no_qty_buy_to_free']  }}</td>
                                           <td class="btn btn-warning">{{ $orderitem['order_item_status'] }}</td>
                                         
                                           <td ><strong class="text-danger">{{ $orderitem['order_waste_remark'] }}</strong></td>
                                           <td>
                                            @if($orderitem['reqTodelete']=="Delete Request Has Been Sent To The Kitchen!")
                                            <form method="post" action="{{ url('admin/delete-kitchen-approvel/'.$orderitem['id']) }}" class="forms-sample">
                                              @csrf
                                              <div class="form-group">
                        
                                              <select name="reqTodelete" id="reqTodelete" class="form-control @error('reqTodelete') is-invalid @enderror" >
                                                  <option value="">Select</option>
                                                  <option value="Accept-Delete-Request" id="Accept-Delete-Request" @if (isset($menuitemPrice['reqTodelete']) && $menuitemPrice['reqTodelete'] == 'Accept-Delete-Request') selected @endif>
                                                      Accept-Delete-Request</option>
                                                  <option value="Cancle-Delete-Request" id="Cancle-Delete-Request" @if (isset($menuitemPrice['reqTodelete']) && $menuitemPrice['reqTodelete'] == 'Cancle-Delete-Request') selected @endif>
                                                      Cancle-Delete-Request</option>
                                              </select>
                                             
                                          </div>
                                          <div class="form-group">
                                            <button type="submit">submit</button>

                                          </div>
                                            </form>

                                            
                                                                        
                                            @endif
                                           </td>
                                     <td> 
                                       @if($orderitem['order_item_status']=="New-Order")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Accepted">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Accepted")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Preparing">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success"  type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Preparing")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Prepared">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Order-Prepared")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Order-Collected">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        
                                   

                                        @if($orderitem['order_item_status']=="Replace-Item")
                                      

                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Replace-Order-Preparing">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success"  type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Replace-Order-Preparing")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Replace-Order-Prepared">
                                                <span onclick="InActiveRow('{{ $orderitem['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row">{{ $orderitem['order_item_status']  }}</span>
                                        </form>
                                        @endif
                                        @if($orderitem['order_item_status']=="Replace-Order-Prepared")
                                        <form method="post" id="active_form_{{ $orderitem['id'] }}"
                                                action="{{ url('/') }}/admin/Change-Order-Item-Status">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_id"
                                                    value="{{ $orderitem['id'] }}">
                                                <input type="hidden" name="status" value="Replace-Order-Collected">
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