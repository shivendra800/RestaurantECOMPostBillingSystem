
@extends('admin.layouts.layout')
{{-- @push('meta')
    <meta http-equiv="refresh" content="2">
    
@endpush --}}

{{-- @section('time',"10") --}}
@section('title','Table Order')

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
                    <li class="breadcrumb-item active">Table Order List</li>
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
                        <h3 class="card-title">Table Order List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Order No</th>
                                  <th>Table Name</th>
                               
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($orderNoWiseItem as $index=> $tablebook )
          
                                <tr>
                                  <td>{{ $index+1 }}</td>
                                  <td>
                                    {{ $tablebook['order_no'] }}
                                    <br>
                                  <span class="badge badge-danger"> {{ $tablebook['group_item'] }}</span>
                                </td>
                                  <td>{{ $tablebook['orderwise']['tables']['table_name'] }}</td>
                                 
                                  <td>
                                    
                                   <li><a class="btn btn-info" href="{{ url('admin/view-restbar-orderitem/'.$tablebook['group_item']) }}">View Order</a></li> 
                                @if($tablebook['order_item_status']=="New-Order")
                               
                                    <form method="post" id="active_form_{{ $tablebook['id'] }}"
                                    action="{{ url('/') }}/admin/accept-restBarorder-status">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="status_id"
                                        value="{{ $tablebook['group_item'] }}">
                                    <input type="hidden" name="status" value="Order-Accepted">
                                  <li><span onclick="InActiveRow('{{ $tablebook['id'] }}')" class="btn btn-primary" type="button" title="Click to In-Active this row">Click Here To Accept Order</span></li>  
                            </form>

                            @else
                            <li><a class="btn btn-warning" target="_blank" href="{{ url('admin/print-kot-restBarordersummary/'.$tablebook['group_item']) }}">Print KOT</a></li> 
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