@extends('admin.layouts.layout')
@section('title','Today Order List')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @include('admin.errors.all_mesg')
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Today Order List</li>
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
              <h3 class="card-title">Today Order List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Order NO </th>
                  <th>Table Name </th>
                  <th>Staff Name</th>
                  <th>Today Table Book Date</th>
                  <th>Table Order Sub-Total</th>
                  <th>Table Order Grand Amount</th>
                  <th>Payment Mode & ID</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($todayorderlist as $index=>$todayorder)
                        <td>{{$index+1}}</td>
                        <td >
                          @if($todayorder['total_tax']== 0)
                          <a href="{{ url('/') }}/admin/view-order-details/{{$todayorder['order_no']}}">{{$todayorder['order_no']}}</a>
                          @else
                          {{$todayorder['order_no']}}
                          @endif
                        </td>
                        <td>
                            @if($todayorder['tables'] && $todayorder['tables']['table_name'] )
                            {{$todayorder['tables']['table_name']}}
                          @else
                          NA
                          @endif</td>
                        <td>
                            @if($todayorder['staffs'] && $todayorder['staffs']['name'] )
                            {{$todayorder['staffs']['name']}}
                          @else
                          NA
                          @endif
                          </td>
                        <td style="color: red;">{{ \Carbon\Carbon::parse($todayorder['created_at'])->isoFormat('MMM Do YYYY')}}</td>
                        <td>
                          Rs.{{$todayorder['sub_total']}}
                          <br>
                          @if($todayorder['coupon_per']>0)
                                        @if(!empty($todayorder['coupon_per']))
                                        <span class="text-success">Offer Apply: {{$todayorder['coupon_per']}}% Off </span>
                                        @endif
                                        <br>
                                        @if(!empty($todayorder['subtotalwithoffer']))
                                        <span class="text-danger">new-subtotal: {{$todayorder['subtotalwithoffer']}} </span>
                                        @endif
                                        @endif
                        </td>
                        <td>Rs.{{$todayorder['grand_total']}}</td>
                        <td class="text-danger">
                            <strong> {{$todayorder['payableamt']}}</strong><br>
                          @if($todayorder['payment_id']=="null")
                          {{$todayorder['payment_mode']}}--{{$todayorder['payment_id']}}
                          @else
                          {{$todayorder['payment_mode']}}
                            @endif
                        </td>
                        <td>
                          @if($todayorder['total_tax']== 0)
                                       <a href="{{ url('admin/View-order-details/'.$todayorder['order_no']) }}" class="text-danger">Generate Reciept</a>
                                        @else
                                        <a href="{{ url('admin/table-orderSlip/'.$todayorder['order_no'] ) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>&nbsp;
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
