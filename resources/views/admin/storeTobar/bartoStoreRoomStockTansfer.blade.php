@extends('admin.layouts.layout')
@section('title','Transfer Stock Bar To  Store Room')

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
                    <li class="breadcrumb-item active">Transfer Stock Bar To  Store Room</li>
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

                <div class="card card-primary card-outline">
                    <div class="card-header">

                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transfer Stock Bar To  Store Room</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form action="{{ url('/') }}/admin/transfer-BarToStoreStockSave" method="post">
                                  @csrf

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>
                                   <th>Current Stock</th>
                                  <th>Reduce </th>
                                  <th>Transfer To StoreRomm Stock</th>
                                  <th>Remark</th>
            
                               
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getbarStock as $index=>$getproduct)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$getproduct['product']['ingredient_name']}}
                                          <input type="hidden" name="product_id[]" class="form-control" value="{{$getproduct['product_id']}}">
                                        </td>
                                        <td style="color:blue;">
                                            {{$getproduct['consumption_qty']}} 
                                             <input type="hidden" name="consumption_qty[]" value="{{$getproduct['consumption_qty']}}" class="form-control consumption_qty" id="consumption_qty" >
                                        </td>
                                        <td>   <input type="text"  name="store_stock_qty[]" class="form-control store_stock_qty" id="store_stock_qty"  readonly value="{{$getproduct['consumption_qty']}}"></td>
                                        <td> <input type="number"  step="0.001" min="0"   name="trnsfertostore[]" class="form-control trnsfertostore"  id="trnsfertostore" onkeyup="CalculateTotal(this)"></td>
                                        <td><input type="text" name="remark[]"  class="form-control"></td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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
    function CalculateTotal(ele)
  {

          var consumption_qty = $(ele).closest('tr').find('.consumption_qty').val();
          var trnsfertostore = $(ele).closest('tr').find('.trnsfertostore').val();

            consumption_qty = consumption_qty == '' ? 0 : consumption_qty;
            trnsfertostore = trnsfertostore == '' ? 0 : trnsfertostore;
       
              if (!isNaN(consumption_qty) && !isNaN(trnsfertostore))
               {
                     // calculate 
                  var total = parseFloat(consumption_qty) - parseFloat(trnsfertostore) ;
                  
                  var remaingqty = parseFloat(total);
                 
                        // set data in qty
                  $(ele).closest('tr').find('.store_stock_qty').val(remaingqty.toFixed(2));
                 
                }

    
  }
</script>
    
@endsection
