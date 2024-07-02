@extends('admin.layouts.layout')
@section('title','capital-UseStock')

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
                    <li class="breadcrumb-item active">capital-UseStock</li>
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
                        <h3 class="card-title">capital-UseStock</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form action="{{ url('/') }}/admin/capital-UseStock" method="post">
                                  @csrf

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>                                
                                  <th>Current Stock</th>
                                  <th>Store Room Stock</th>
                                  <th>Use Stock</th>
                                  <th>Remark</th>
            
                               
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getextProduct as $index=>$getproduct)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$getproduct['ext_product_name']}}
                                          <input type="hidden" name="product_id[]" class="form-control" value="{{$getproduct['id']}}">
                                        </td>
                                       
                                     
                                        <td style="color:blue;">
                                            {{$getproduct['ext_purchase_stock']}} 
                                             <input type="hidden" name="ext_purchase_stock[]" value="{{$getproduct['ext_purchase_stock']}}" class="form-control ext_purchase_stock" id="ext_purchase_stock" >
                                        </td>
                                        <td>   <input type="text"  name="ext_consumption_stock[]" class="form-control ext_consumption_stock" id="ext_consumption_stock"  readonly value="{{$getproduct['ext_purchase_stock']}}"></td>
                                        <td> <input type="number"  step="0.001" min="0"   name="use_qty[]" class="form-control use_qty"   id="use_qty" onkeyup="CalculateTotal(this)"></td>
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

          var ext_purchase_stock = $(ele).closest('tr').find('.ext_purchase_stock').val();
          var use_qty = $(ele).closest('tr').find('.use_qty').val();

            ext_purchase_stock = ext_purchase_stock == '' ? 0 : ext_purchase_stock;
            use_qty = use_qty == '' ? 0 : use_qty;
       
              if (!isNaN(ext_purchase_stock) && !isNaN(use_qty))
               {
                     // calculate 
                  var total = parseFloat(ext_purchase_stock) - parseFloat(use_qty) ;
                  
                  var remaingqty = parseFloat(total);
                 
                        // set data in qty
                  $(ele).closest('tr').find('.ext_consumption_stock').val(remaingqty.toFixed(2));
                 
                }

    
  }
</script>
    
@endsection
