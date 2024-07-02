@extends('admin.layouts.layout')
@section('title','TakeWay Order List')

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
                    <li class="breadcrumb-item active">TakeWay Order List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">TakeWay Order List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table  class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Order No</th>
                                  <th>Order Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($takeWayorder as $index=> $takeWay )

                                <tr>
                                  <td>{{ $index+1 }}</td>
                                  <td>{{ $takeWay['order_no'] }}</td>
                                  <td ><small class="btn btn-block bg-gradient-success btn-xs">{{ $takeWay['updated_kitchen_order_status'] }}</small></td>
                                  <td>
                                    <a class="btn btn-block bg-gradient-info btn-xs" href="{{ url('admin/view-takeway-orderitem/'.$takeWay['order_no']) }}">View Order</a><br>
                                    @if($takeWay['updated_kitchen_order_status']=="Order-Transfer-Kichen")

                                        <form method="post" id="active_form_{{ $takeWay['id'] }}"
                                        action="{{ url('/') }}/admin/accept-takewayorderKich-status">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="status_id"
                                            value="{{ $takeWay['order_no'] }}">
                                        <input type="hidden" name="status" value="Order-Accepted">
                                      <span onclick="InActiveRow('{{ $takeWay['id'] }}')" class="btn btn-block bg-gradient-secondary btn-xs" type="button" title="Click to In-Active this row">Click Here To Accept Order</span>
                                </form>

                                @else
                                <a class="btn btn-block bg-gradient-warning btn-xs" target="_blank" href="{{ url('admin/print-takewayOrdrKot-summary/'.$takeWay['order_no']) }}">Print KOT</a>
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
            <div class="col-6">

                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Zomato Order List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Order No</th>
                                  <th>Order Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($zomatoorder as $index=> $zomato )

                                <tr>
                                  <td>{{ $index+1 }}</td>
                                  <td>{{ $zomato['order_no'] }}</td>
                                  <td ><small class="btn btn-block bg-gradient-success btn-xs">{{ $zomato['updated_kitchen_order_status'] }}</small></td>
                                  <td>
                                    <a class="btn btn-block bg-gradient-info btn-xs" href="{{ url('admin/view-takeway-orderitem/'.$zomato['order_no']) }}">View Order</a><br>
                                    @if($zomato['updated_kitchen_order_status']=="Order-Transfer-Kichen")

                                        <form method="post" id="active_form_{{ $zomato['id'] }}"
                                        action="{{ url('/') }}/admin/accept-takewayorderKich-status">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="status_id"
                                            value="{{ $zomato['order_no'] }}">
                                        <input type="hidden" name="status" value="Order-Accepted">
                                      <span onclick="InActiveRow('{{ $zomato['id'] }}')" type="button" class="btn btn-block bg-gradient-secondary btn-xs"  title="Click to In-Active this row">Click Here To Accept Order</span>
                                </form>

                                @else
                                <a class="btn btn-block bg-gradient-warning btn-xs" target="_blank" href="{{ url('admin/print-takewayOrdrKot-summary/'.$zomato['order_no']) }}">Print KOT</a>
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
@section('script')

<script>
    function playAudio() {
      var audio = document.getElementById("myAudio");
      audio.play();
    }

    function pauseAudio() {
      var audio = document.getElementById("myAudio");
      audio.pause();
    }
  </script>
  <script>
       function InActiveRow(id)
  {
    console.log(id);
    swal({
      title: "Are you sure?",
      text: "You want to change status",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $("#active_form_"+id).submit();
      } else {
        //swal("Your data is safe!");
      }
    });

  }
  </script>

@endsection
