@extends('admin.layouts.layout')
@section('title','BarTableWiseChairOrderCheckoutList')

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
                    <li class="breadcrumb-item active">Bar Table Wise Chair Order Checkout List</li>
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


                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bar Table Wise Chair Order Checkout List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Order No</th>
                                    <th>BarTable</th>
                                    <th>BarOrderTakenBy</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getbarTableCheckout as $index=>$barTableOrder)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td style="color:rgb(209, 10, 10);">{{$barTableOrder['order_no']}}</td>
                                    <td>{{$barTableOrder['tables']['table_name']}}</td>
                                    <td style="color:red;">{{$barTableOrder['staffs']['name']}}</td>
                                    <td class=" btn btn-info">{{$barTableOrder['order_status']}}</td>
                                    <td>
                                        <div style="display:inline-flex;">
                                            @if($barTableOrder['grand_total']==0)
                                            <a title="View Bar Table Order For Checkout" href="{{ url('admin/view-barTableWiseChairCheckoutOrder/'.$barTableOrder['order_no'] ) }}"><i style="font-size:25px;" class="fa fa-shopping-cart"></i></a>&nbsp;&nbsp;
                                             @else
                                             <a href="{{ url('admin/print-barorder-receipt/'.$barTableOrder['order_no'] ) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>&nbsp;
                                             <a class="btn btn-block btn-warning btn-xs" title="Process To Checkout " href="{{ url('admin/finallybarTableCheckoutOrder/'.$barTableOrder['order_no'] ) }}">ProcessToCheckout</a>&nbsp;&nbsp;

                                             @endif
                                        </div>
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

@endsection