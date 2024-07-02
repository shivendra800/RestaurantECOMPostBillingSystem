@extends('admin.layouts.layout')

@section('title','Delivery Order List')

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
            <li class="breadcrumb-item active">Delivery Order List</li>
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
              <h3 class="card-title">Delivery Order  List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline w-100"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Address</th>
                  <th>Mobile</th>
                  <th>Payment Method</th>
                  <th>Grand Total</th>
                  <th>Current Order Status</th>
                  <th>View Details</th>
            
                 
                </tr>
                </thead>
                <tbody>
                    @foreach ($getonlineList as $index=>$onlineOrder)
                        <tr>
                       
                        <td>
                            {{$index+1}}
                        </td>
                        <td>{{$onlineOrder['name']}}</td>
                        <td>{{$onlineOrder['address']}},<br>{{ $onlineOrder['area'] }},<br>{{ $onlineOrder['city'] }},<br>{{ $onlineOrder['pincode'] }}</td>
                        <td>{{$onlineOrder['mobile']}}</td>
                        <td>{{$onlineOrder['payment_method']}}-{{ $onlineOrder['payment_gateway'] }}</td>
                        <td >Rs.{{$onlineOrder['grand_total']}}</td>
                        <td >{{$onlineOrder['order_status']}}</td>
                        <td>
                            <a title=" Online Order Details" href="{{ url('admin/assign-onlineOrderDetails/'.$onlineOrder['id'] ) }}"><i style="font-size:25px;" class="fa fa-info-circle"></i></a>&nbsp;&nbsp;

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