@extends('admin.layouts.layout')

@section('title','Assign Order List')

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
            <li class="breadcrumb-item active">Assign Order List</li>
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
              <h3 class="card-title">Assign Order  List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <form action="{{ url('/') }}/admin/deliveryboy-ChangeOrderStatus" method="post">
                    @csrf
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
                  <th>Change Order Status</th>
                 
                </tr>
                </thead>
                <tbody>
                    @foreach ($getonlineList as $index=>$onlineOrder)
                        <tr>
                       
                        <td>
                            <a title="update Online Order Details" href="{{ url('admin/assign-onlineOrderDetails/'.$onlineOrder['id'] ) }}">
                            {{$onlineOrder['order_no']}}
                            <input type="hidden" name="order_id[]" class="form-control" value="{{$onlineOrder['id']}}">

                            </a>
                        </td>
                        <td>{{$onlineOrder['name']}}</td>
                        <td>{{$onlineOrder['address']}},<br>{{ $onlineOrder['area'] }},<br>{{ $onlineOrder['city'] }},<br>{{ $onlineOrder['pincode'] }}</td>
                        <td>{{$onlineOrder['mobile']}}</td>
                        <td>{{$onlineOrder['payment_method']}}-{{ $onlineOrder['payment_gateway'] }}</td>
                        <td >Rs.{{$onlineOrder['grand_total']}}</td>
                        <td >{{$onlineOrder['order_status']}}</td>
                        <td>
                            <select name="order_status[]" id="order_status" class="form-control">
                                <option value="">Change Order Status</option>
                                @foreach ($orderStatuses as $status )
                                <option value="{{ $status['name'] }}" @if(!empty($orderDetails['order_status'])&& $orderDetails['order_status']==$status['name']) selected="" @endif> {{ $status['name'] }}</option>
                                @endforeach
                            </select>
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