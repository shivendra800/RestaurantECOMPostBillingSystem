@extends('admin.layouts.layout')
@section('title','Purchase Product List')

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
                    <li class="breadcrumb-item active">Purchase Product  List</li>
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

                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Purchase Prdouct List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Purchase id</th>
                                   <th>Product Name</th>
                                  <th>1-Qty Price</th>
                                  <th>Total Qty</th>
                                  <th>1-Qty Weight/Qty</th>
                                    <th>Total Weight</th>
                                  <th>Product Amount</th>
                                  <th>Product Expire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getpurchaseItem as $index=>$item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{ $item['invoice_id'] }}</td>
                                        <td>{{ $item['product']['ingredient_name'] }}</td>
                               
                                <td>{{ $item['price'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['weight'] }}</td>
                                 <td >{{ $item['total_weight'] }}/{{ $item['unit']['unit_name'] }}</td>
                                <td>{{ $item['total_price'] }}</td>
                                <td >{{ \Carbon\Carbon::parse($item['product_expire_date'])->isoFormat('MMM Do YYYY')}}</td>
                                </tr>


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



@endsection
