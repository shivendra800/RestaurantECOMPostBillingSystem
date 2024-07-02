@extends('admin.layouts.layout')
@section('title','Total-DiscountPercentage-CouponLoss')

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
                    <li class="breadcrumb-item active">Total-DiscountPercentage-CouponLoss</li>
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
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group bg-warning text-center p-2">
                                    <label>Over All Sale Discount</label>
                                    <br>
                                   <strong class="bg-danger text-center p-1">Rs.{{$overallsaledis}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

             
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total-DiscountPercentage-CouponLoss</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>Order Type</th>
                                    <th>Order No</th>
                                    <th>Sub Total</th>
                                    <th>Discount Amount</th>
                                    <th>New Subtotal Amount</th>
                                    <th>Total Tax</th>
                                    <th>Grand Total</th>
                                    <th> Order Date</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                             
                                @foreach ($tableOderSale as $index=>$todayorder)
                                <tr>

                                    <td class="btn btn-info">Table Order</td>
                                    <td>
                                       
                                        {{$todayorder['order_no']}}
                                     
                                    </td>
                                    <td>
                                        Rs.{{$todayorder['sub_total']}}
                                        
                                    </td>
                                    <td ><span class="badge badge-danger">{{$todayorder['coupon_per']}}% Off</span>
                                        <br>
                                        <strong class="btn btn-warning">Rs.{{$todayorder['sub_total'] - $todayorder['subtotalwithoffer']}}</strong>
                                    </td>
                                    
                                    <td>Rs.{{$todayorder['subtotalwithoffer']}}</td>
                                    <td>Rs.{{$todayorder['total_tax']}}</td>
                                    <td>Rs.{{$todayorder['grand_total']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($todayorder->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
            

                                </tr>
                               

                                @endforeach

                                @foreach ($takeOderSale as $index=>$todayorder)
                                <tr>

                                    <td class="btn btn-info">TakeAway Order</td>
                                    <td>
                                       
                                        {{$todayorder['order_no']}}
                                     
                                    </td>
                                    <td>
                                        Rs.{{$todayorder['sub_total']}}
                                        
                                    </td>
                                    <td ><span class="badge badge-danger">{{$todayorder['coupon_per']}}% Off</span>
                                        <br>
                                        <strong class="btn btn-warning">Rs.{{$todayorder['sub_total'] - $todayorder['subtotalwithoffer']}}</strong>
                                    </td>
                                    
                                    <td>Rs.{{$todayorder['subtotalwithoffer']}}</td>
                                    <td>Rs.{{$todayorder['total_tax']}}</td>
                                    <td>Rs.{{$todayorder['grand_total']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($todayorder->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
            

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