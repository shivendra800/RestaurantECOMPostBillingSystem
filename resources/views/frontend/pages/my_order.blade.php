@extends('frontend.layouts.layout')

@section('title','My Order List')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Order List</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">OrderList</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
                <div class="shadow bg-white p-3">
                <h4 class="mb-4">MY Order</h4>
                <hr>
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>Order Id</th>
                            <th>Tracking No</th>
                            <th>Username</th>
                            <th>Payment Mode</th>
                            <th>Order Date</th>
                            <th>Status Message</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                          <tbody>
                            @forelse ($myorders as $index=> $orderItem )
                            <tr>
                               <td>{{ $index+1  }}</td>
                             <td>{{ $orderItem->order_no   }}</td>
                            <td>{{ $orderItem->name   }}</td>
                            <td>{{ $orderItem->payment_method   }}</td>
                            <td>{{ $orderItem->created_at   }}</td>
                            <td>{{ $orderItem->order_status   }}</td>
                            <td>
                            <a href="{{ url('my-order-details/'.$orderItem->order_no) }}" class="btn btn-primary btn-sm">View</a>
                            @if($orderItem->order_status == 'New-Order')
                            <a href="{{ url('cancle-MyOrder/'.$orderItem->id) }}" class="btn btn-danger btn-sm">Cancle Order</a>
                            @endif
                        </td> 

                        </tr>
                            @empty
                            <tr>
                                <td colspan="7">No Orders Available</td>
                            </tr>

                            @endforelse
                          </tbody>

                    </table>
                      <div>
                        {{ $myorders->links() }}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection