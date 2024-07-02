@extends('admin.layouts.layout')
@section('title','Dashboard')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->

  <!-- /.content -->
 <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Table New Order</a>
                    <a href="{{ url('admin/table-orderList') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        {{-- <th>ID</th> --}}
                        <th>Order No</th>
                        <th>Table Name</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($tableorder as $index=> $tablebook )

                      <tr>
                        {{-- <td>{{ $index+1 }}</td> --}}
                        <td>{{ $tablebook['order_no'] }}</td>
                        <td>{{ $tablebook['tables']['table_name'] }}--{{ $tablebook['tables']['table_type'] }}</td>
                        {{-- <td><span class="tag tag-success">
                            {{ $tablebook['order_status'] }}
                        </span></td> --}}
                        <td>
                          <a href="{{ url('admin/table-orderList/') }}">View Order</a>
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
            <div class="col-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">TakeWay Order</a>
                    <a href="{{ url('admin/takeway-orderList') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        {{-- <th>ID</th> --}}
                        <th>Order No</th>
                        <th>Order Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($takeWayorder as $index=> $takewyItem )
      
                      <tr>
                        {{-- <td>{{ $index+1 }}</td> --}}
                        <td>{{ $takewyItem['order_no'] }}</td>
                        <td class="btn btn-success">{{ $takewyItem['updated_kitchen_order_status'] }}</td>
                        <td>
                          <a href="{{ url('admin/view-takeway-orderitem/'.$takewyItem['order_no']) }}">View Order</a>
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
            <div class="col-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Online Order</a>
                    <a href="{{ url('admin/online-orderList') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        {{-- <th>ID</th> --}}
                        <th>Order No</th>
                        <th>Order Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($onlineOrder as $index=> $onlineOrd )
      
                      <tr>
                        {{-- <td>{{ $index+1 }}</td> --}}
                        <td>{{ $onlineOrd['order_no'] }}</td>
                        <td class="badge badge-success">{{ $onlineOrd['order_status'] }}</td>
                        <td>
                          <a href="{{ url('admin/view-online-orderitem/'.$onlineOrd['id']) }}">View Order</a>
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
          </div>
        </div>
 </section>

 {{-- <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <div class="card-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Take Way New Order</a>
              <a href="{{ url('admin/takeway-orderList') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Order No</th>
                  <th>Order Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($takeWayorder as $index=> $takewyItem )

                <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $takewyItem['order_no'] }}</td>
                  <td class="btn btn-success">{{ $takewyItem['updated_kitchen_order_status'] }}</td>
                  <td>
                    <a href="{{ url('admin/view-takeway-orderitem/'.$takewyItem['order_no']) }}">View Order</a>
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
    </div>
  </div>
</section> --}}
    
@endsection
