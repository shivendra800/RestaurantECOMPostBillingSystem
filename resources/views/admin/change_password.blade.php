@extends('admin.layouts.layout')

@section('title','Change Password')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5>Update Password of {{ Auth::guard('admin')->user()->name }} is {{ Auth::guard('admin')->user()->type }}</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ Auth::guard('admin')->user()->type }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update {{ Auth::guard('admin')->user()->type }} <small> Password</small></h3>
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
                {{-- error meg with close button---- --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                {{-- error meg --}}
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ url('admin/change-password') }}" class="forms-sample" method="post">@csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputemail" value="{{ $adminDetails['email'] }}" placeholder="Email" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Type</label>
                        <input type="text" name="type" class="form-control" id="exampleInputemail" value="{{ $adminDetails['type'] }}" placeholder="type" readonly>
                      </div>
                  <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Password">
                    <span id="check_password"></span>
                  </div>
                  <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="confirm_pasword">Confirm Password</label>
                    <input type="password" name="confirm_pasword" class="form-control" id="confirm_pasword" placeholder="Password">
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 

    
@endsection

@section('script')

<script>
    $(document).ready(function() {
            // check Admin Password is correct or Not
    $("#current_password").keyup(function() {
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{ url('/') }}/admin/check-current-password",
            data: { current_password: current_password },
            success: function(resp) {
                // alert(resp);
                if (resp == "false") {
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                } else if (resp == "true") {
                    $("#check_password").html("<font color='green'>Current Password is Correct.</font>");
                }
            },
            error: function() {
                alert("Error");
            },
        });
    });
});
</script>


@endsection
    
