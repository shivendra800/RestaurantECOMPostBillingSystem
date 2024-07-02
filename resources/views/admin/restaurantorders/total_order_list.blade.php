@extends('admin.layouts.layout')
@section('title','All Table Order List')

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
                    <li class="breadcrumb-item active">All Order List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        
<div class="row">
    <div class="col-lg-12 ">
        <h3>Table Order Sale</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{round($totalTableOrdersale, 2)}}</h3>

                <p>Overall Sale </p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{round($todayTablesale, 2)}}</h3>

                <p>Today Sale</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{round($MonthsTablesale, 2)}}</h3>

                <p>This Month Sale</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{round($YearTablesale, 2)}}</h3>

                <p>This Year Sale</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>  

<hr>
<div class="row">
    <div class="col-lg-12 ">
        <h3>Table Order Cash Collection</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <p>OverallCashPayment </p>
                <h3>{{round($totalTableOrdersaleCash, 2)}}</h3>
              
                <p>OverallcountCash</p>
                <h3>{{round($totalTableOrdersaleCashCount, 2)}}</h3>
             
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <p>Today Total CashPayment </p>
                <h3>{{round($todayTablesaleCash, 2)}}</h3>
                
                <p>Today Total Cash No  </p>
                <h3>{{round($todayTablesaleCashCount, 2)}}</h3>

               
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">

                <p>This Month CashPayment</p>
                <h3>{{round($MonthsTablesaleCash, 2)}}</h3>
                <p>This Month CashCount No</p>
                <h3>{{round($MonthsTablesaleCashCount, 2)}}</h3>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <p>This Year CashPayment</p>
                <h3>{{round($YearTablesaleCash, 2)}}</h3>
                <p>This Year CashCount No</p>
                <h3>{{round($YearTablesaleCashCount, 2)}}</h3>
                
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<hr>
<div class="row">
    <div class="col-lg-12 ">
        <h3>Table Order QRCodeWithSlip Collection</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <p>OverallQRCodeWithSlipPayment </p>
                <h3>{{round($totalTableOrdersaleQRCodeWithSlip, 2)}}</h3>
              
                <p>OverallcountQRCodeWithSlip</p>
                <h3>{{round($totalTableOrdersaleQRCodeWithSlipCount, 2)}}</h3>
             
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <p>TodayTotalQRCodeWithSlipPayment </p>
                <h3>{{round($todayTablesaleQRCodeWithSlip, 2)}}</h3>
                
                <p>Today Total QRCodeWithSlip No  </p>
                <h3>{{round($todayTablesaleQRCodeWithSlipCount, 2)}}</h3>

               
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">

                <p>ThisMonthQRCodeWithSlipPayment</p>
                <h3>{{round($MonthsTablesaleQRCodeWithSlip, 2)}}</h3>
                <p>ThisMonthQRCodeWithSlipCountNo</p>
                <h3>{{round($MonthsTablesaleQRCodeWithSlipCount, 2)}}</h3>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <p>This Year QRCodeWithSlipPayment</p>
                <h3>{{round($YearTablesaleQRCodeWithSlip, 2)}}</h3>
                <p>This Year QRCodeWithSlipCount No</p>
                <h3>{{round($YearTablesaleQRCodeWithSlipCount, 2)}}</h3>
                
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<hr>
<div class="row">
    <div class="col-lg-12 ">
        <h3>Table Order CardSwip Collection</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <p>OverallCardSwipPayment </p>
                <h3>{{round($totalTableOrdersaleCardSwip, 2)}}</h3>
              
                <p>OverallcountCardSwip</p>
                <h3>{{round($totalTableOrdersaleCardSwipCount, 2)}}</h3>
             
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <p>TodayTotalCardSwipPayment </p>
                <h3>{{round($todayTablesaleCardSwip, 2)}}</h3>
                
                <p>Today Total QRCodeWithSlip No  </p>
                <h3>{{round($todayTablesaleCardSwipCount, 2)}}</h3>

               
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">

                <p>ThisMonthCardSwipPayment</p>
                <h3>{{round($MonthsTablesaleCardSwip, 2)}}</h3>
                <p>ThisMonthQRCodeWithSlipCountNo</p>
                <h3>{{round($MonthsTablesaleCardSwipCount, 2)}}</h3>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <p>This Year CardSwipPayment</p>
                <h3>{{round($YearTablesaleCardSwip, 2)}}</h3>
                <p>This Year CardSwipCount No</p>
                <h3>{{round($YearTablesaleCardSwipCount, 2)}}</h3>
                
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<hr>
<div class="row">
    <div class="col-lg-12 ">
        <h3>Table Order Online Collection</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <p>OverallOnlinePayment </p>
                <h3>{{round($totalTableOrdersalePaidRazorpay, 2)}}</h3>
              
                <p>OverallcountOnline</p>
                <h3>{{round($totalTableOrdersalePaidRazorpayCount, 2)}}</h3>
             
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <p>TodayTotalOnline </p>
                <h3>{{round($todayTablesalePaidRazorpay, 2)}}</h3>
                
                <p>Today TotalOnline </p>
                <h3>{{round($todayTablesalePaidRazorpayCount, 2)}}</h3>

               
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">

                <p>ThisMonthOnline Payment</p>
                <h3>{{round($MonthsTablesalePaidRazorpay, 2)}}</h3>
                <p>ThisMonthQRCodeWithSlipCountNo</p>
                <h3>{{round($MonthsTablesalePaidRazorpayCount, 2)}}</h3>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <p>This Year Online Payment</p>
                <h3>{{round($YearTablesalePaidRazorpay, 2)}}</h3>
                <p>This Year CardSwipCount No</p>
                <h3>{{round($YearTablesalePaidRazorpayCount, 2)}}</h3>
                
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<hr>
        
        </div>
        </section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h2 class="btn btn-warning">Search Data Of Table Order</h2>
                        <div class="card-header">
                            <form action="{{ url('/admin/table-orders-SearchDateWsie') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="date" name="start_date" class="form-control" placeholder="Enter Start Date" value="{{ Request::get('start_date')  }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="end_date" class="form-control" placeholder="Enter End Date" value="{{ Request::get('end_date')  }}" required>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Over All Table Order Collection</label>
                                    <input class="form-control" value="{{ $overallcollectionwithGSt }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                          <div class="card-body">
                              <div class="form-group">
                                  <label>Over All Table Order Tax Collection</label>
                                  <input class="form-control" value="{{ $overallcollectionwithoutGSt }}" readonly="">
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Order List</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order NO </th>
                                    <th>Table Name </th>
                                  
                                    <th>Table Order Date</th>
                                    <th>Table Order Sub-Total</th>
                                    <th>Table Order Grand Amount</th>
                                    <th>Payment Mode & ID</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totalorderlist as $index=>$totalorder)
                                <td>{{$index+1}}</td>
                                <td>
                                    <a href="{{ url('/') }}/admin/view-order-details/{{$totalorder['order_no']}}">{{$totalorder['order_no']}}</a>
                                </td>
                                <td>{{$totalorder['tables']['table_type']}}</td>
                              
                                <td style="color: red;">{{ \Carbon\Carbon::parse($totalorder['created_at'])->isoFormat('MMM Do YYYY')}}</td>
                                <td>
                                    {{$totalorder['sub_total']}}
                                    <br>
                                    @if(!empty($totalorder['coupon_per']))
                                    <span class="text-success">Offer Apply: {{$totalorder['coupon_per']}}% Off </span>
                                    @endif
                                    <br>
                                    @if(!empty($totalorder['subtotalwithoffer']))
                                    <span class="text-danger">new-subtotal: {{$totalorder['subtotalwithoffer']}} </span>
                                    @endif
                                </td>
                                <td>{{$totalorder['grand_total']}}</td>
                                <td class="btn btn-warning">
                                    @if($totalorder['payment_id']=="null")
                                    {{$totalorder['payment_mode']}}--{{$totalorder['payment_id']}}
                                    @else
                                    {{$totalorder['payment_mode']}}
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