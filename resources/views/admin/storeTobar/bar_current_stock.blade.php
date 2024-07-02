@extends('admin.layouts.layout')
@section('title',' Current Bar  Stock ')

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
                    <li class="breadcrumb-item active"> Current Bar  Stock </li>
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
                        <h3 class="card-title"> Current Bar  Stock </h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Product Name</th>
                                  {{-- <th>Product Unit</th> --}}
                                  <th>Current Stock </th>
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getbarStock as $index=>$currentstock)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                         <td>{{$currentstock['product']['ingredient_name']}}</td>
                                         {{-- <td>{{$currentstock['unit']['unit_name']}}</td> --}}
                                         <td>{{$currentstock['consumption_qty']}}
                                        </td>
                                    </tr>
                                </form>
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
    function CalculateTotal(ele)
  {

          var purchase_stock = $(ele).closest('tr').find('.purchase_stock').val();
          var consumption_qty = $(ele).closest('tr').find('.consumption_qty').val();

            purchase_stock = purchase_stock == '' ? 0 : purchase_stock;
            consumption_qty = consumption_qty == '' ? 0 : consumption_qty;
       
              if (!isNaN(purchase_stock) && !isNaN(consumption_qty))
               {
                     // calculate 
                  var total = parseInt(purchase_stock) - parseInt(consumption_qty) ;
                        // set data in qty
                  $(ele).closest('tr').find('.store_stock_qty').val(total.toFixed(2));
                 
                }

    
  }
</script>
    
@endsection
