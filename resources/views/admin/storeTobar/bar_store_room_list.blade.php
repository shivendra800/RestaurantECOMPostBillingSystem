@extends('admin.layouts.layout')
@section('title','Restaurant Store Room')

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
                    <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Restaurant Store Room</li>
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
                        <h3 class="card-title">Store Room To Kitchen Stock Shiftting</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form action="{{ url('/') }}/admin/add-store-to-Bar" method="post">
                                  @csrf

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>
                                  <th>Product Unit</th>
                                  <th>Stock</th>
                                  <th>Store Room Stock</th>
                                  <th>Store To Bar</th>
                                  <th>Remark</th>
            
                               
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getingredient as $index=>$getproduct)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$getproduct['ingredient_name']}}
                                          <input type="hidden" name="product_id[]" class="form-control" value="{{$getproduct['id']}}">
                                        </td>
                                       
                                        <td>{{$getproduct['unit']['unit_name']}}
                                          <input type="hidden" name="unit_id[]" class="form-control" value="{{$getproduct['unit_id']}}">
                                        </td>
                                        <td style="color:blue;">
                                            {{$getproduct['purchase_Wtstock']}} {{$getproduct['unit']['unit_name']}}
                                             <input type="hidden" name="purchase_Wtstock[]" value="{{$getproduct['purchase_Wtstock']}}" class="form-control purchase_Wtstock" id="purchase_Wtstock" >
                                        </td>
                                        <td>   <input type="text"  name="store_stock_qty[]" class="form-control store_stock_qty" id="store_stock_qty"  readonly value="{{$getproduct['purchase_Wtstock']}}"></td>
                                        <td> <input type="number"  step="0.001" min="0"   name="consumption_qty[]" class="form-control consumption_qty"  value="0" id="consumption_qty" onkeyup="CalculateTotal(this)"></td>
                                        <td><input type="text" name="remark[]" value="0" class="form-control"></td>
                                        
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

          var purchase_Wtstock = $(ele).closest('tr').find('.purchase_Wtstock').val();
          var consumption_qty = $(ele).closest('tr').find('.consumption_qty').val();

            purchase_Wtstock = purchase_Wtstock == '' ? 0 : purchase_Wtstock;
            consumption_qty = consumption_qty == '' ? 0 : consumption_qty;
       
              if (!isNaN(purchase_Wtstock) && !isNaN(consumption_qty))
               {
                     // calculate 
                  var total = parseFloat(purchase_Wtstock) - parseFloat(consumption_qty) ;
                  
                  var remaingqty = parseFloat(total);
                 
                        // set data in qty
                  $(ele).closest('tr').find('.store_stock_qty').val(remaingqty.toFixed(2));
                 
                }

    
  }
</script>
    
@endsection
