@extends('admin.layouts.layout')
@section('title', 'Take Away Order Item Status')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Take Away Order Item Status</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Take Away Order Item Status </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Take Away Order Item Status</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Take Way Purchase  Order Details</h4><br>
                                <div class="form-group">
                                    <label>Order No</label>
                                    <input class="form-control" value="{{ $vieworder['order_no'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input class="form-control" value="Rs.{{ $vieworder['sub_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Total Tax</label>
                                    <input class="form-control" value="Rs.{{ $vieworder['total_tax'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" value="Rs.{{ $vieworder['grand_total'] }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <input class="form-control" value="{{ $vieworder['payment_mode'] }}" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Take Way Order Item Status</h4><br>
                               
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 40px">Item Name</th>
                                    <th style="width: 40px">Item QTY</th>
                                    <th style="width: 40px">Item Price</th>
                                    <th style="width: 40px">Total Amount</th>
                                    <th style="width: 40px">Order Item Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viewOrderitem as  $index => $orderitem )
            
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                           <td>{{ $orderitem['menuitem']['menu_item_name'] }}</td>
                                           <td>{{ $orderitem['item_qty'] }}</td>
                                           <td>Rs.{{ $orderitem['price'] }}</td>
                                           <td>Rs.{{ $orderitem['amount'] }}</td>
                                           <td class="btn btn-warning">{{ $orderitem['order_item_status'] }}</td>
                                      </tr>
                                        
                                    @endforeach
                                
                                </tbody>
                              </table>
                        </div>

                       

                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Kitchen Order Status</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/update-kitchen-order-status/'.$vieworder['order_no']) }}">
                @csrf
              <div class="card-body">
                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
             
                <div class="form-group">
                    <label for="updated_kitchen_order_status">Change Order Status Of Kitchen</label>
                    <select class="form-control @error('updated_kitchen_order_status') is-invalid @enderror" id="updated_kitchen_order_status" name="updated_kitchen_order_status">
                      <option value="">Select Order Status Of Kitchen</option>
                        <option  value="Order-Delivered">Order-Delivered</option>
                    </select>
                    @error('updated_kitchen_order_status')
                    <div class="alert alert-danger">{{ $message }}</div>
                   @enderror
                </div>
              
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
          </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


  @endsection
  @section('script')
 


@endsection