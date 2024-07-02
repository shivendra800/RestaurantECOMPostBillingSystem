@extends('admin.layouts.layout')
@section('title','Update Staff Password ')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5>Update Staff Password </h5>
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
                <h3 class="card-title">Update Staff <small> Password</small></h3>
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
              <form action="{{ url('admin/updatestaffWise-password/'.$adminDetails['staff_id']) }}" class="forms-sample" method="post">@csrf
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
                    <label for="new_password">New Password</label>
                    <input type="password" name="password" class="form-control"  placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="confirm_pasword">Confirm Password</label>
                    <input type="password" name="confirm_pasword" class="form-control"  placeholder="Password">
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
