@extends('admin.layouts.layout')
@section('title',' Received Return Stock From Kichen  ')

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
                    <li class="breadcrumb-item active">Received Return Stock From Kichen  </li>
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
                        <h3 class="card-title">Received Return Stock From Kichen  </h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        
                        <form action="{{ url('admin/ReviceStockTransferFromKitchen/') }}" method="post">
                            @csrf
                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>
                                  <th>Consumtion Qty</th>                               
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getbarStock as $index=>$getproduct)
                                  
                                    <tr>
                                        <td>{{$index+1}}</td>
                                         <td>{{$getproduct['product']['ingredient_name']}}/<small>{{ $getproduct['unit']['unit_name'] }}</small>
                                            <input type="hidden" name="product_id[]" class="form-control "  value="{{ $getproduct['product_id'] }}" id="product_id">
                
                                        </td>
                                         <td>{{$getproduct['transferstoreroom']}}
                                            <input type="hidden" name="transferstoreroom[]" class="form-control transferstoreroom"  value="{{ $getproduct['transferstoreroom'] }}" id="transferstoreroom">
                                        </td>
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

