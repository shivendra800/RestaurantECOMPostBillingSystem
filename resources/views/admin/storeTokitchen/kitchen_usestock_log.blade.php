@extends('admin.layouts.layout')
@section('title',' Kitchen  Use Stock Log   ')

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
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active"><a href="{{ url('admin/Kitchen-UseStock-Log') }}"> Kitchen  Use Stock Log </a>  </li>
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
                        <h2 class="btn btn-warning">Search Data Of Kitchen Use Stock</h2>
                        <div class="card-header">
                           <form action="{{ url('/admin/date-wise-serach-kitechenUseStock') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="date" name="start_date" class="form-control" placeholder="Enter Start Date" value="{{ Request::get('start_date')  }}" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="end_date" class="form-control" placeholder="Enter End Date" value="{{ Request::get('end_date')  }}" required>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="product_name"   >
                                      <option value=""> Select Name</option>
                                      @foreach ($getingredient as  $nameindr )
                                      <option value="{{ $nameindr['id'] }}" {{ Request::get('product_name') == $nameindr['id'] ? 'selected':'' }} >{{ $nameindr['ingredient_name'] }}</option>
            
                
                                      @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mt-1">
                                    <button type="submit">Search</button>
                                </div>
    
                            </div> 
    
    
                           </form>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Kitchen  Use Stock Log  </h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>
                                  <th>Product Unit</th>
                                  <th>Current Qty</th>
                                  <th>Use Stock</th>
                                  <th>After Use Remaining Stock</th>
                                 
                                  <th>Use  Update Date </th>
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($kitchenUsestocklog as $index=>$KitchenStock)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                         <td>{{$KitchenStock['product']['ingredient_name']}}</td>
                                         <td> 
                                      
                                             @if(is_numeric($KitchenStock['unit_id']))
                                            {{$KitchenStock['unit']['unit_name']}}
                                            @else
                                            {{$KitchenStock['unit_id']}}
                                            @endif
                                        </td>
                                         <td>{{$KitchenStock['kitchen_current_stock']}}</td>
                                         <td>{{$KitchenStock['usestock_stock']}}</td>
                                         <td>{{$KitchenStock['after_use_stock']}}</td>
                                        
                                         <td class="btn btn-warning">{{ \Carbon\Carbon::parse($KitchenStock['created_at'])->isoFormat('MMM Do YYYY')}}</td>
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

