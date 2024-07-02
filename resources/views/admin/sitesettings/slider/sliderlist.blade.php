@extends('admin.layouts.layout')

@section('title', 'Slides')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
        
      <div class="row mb-2">
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Menu Item Price</li>
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
            
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title ">
                       <a href="{{url('/')}}/admin/add-banner-image"> <button type="button" class="btn btn-block btn-info btn-flat ">Create Slider</button></a>
                    </h3>
                </div>
             </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Slider</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Title
                            </th>

                            <th>
                                Image
                            </th>

                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr>
                                <td>
                                    {{ $banner['id'] }}
                                </td>
                                <td>
                                    {{ $banner['title'] }}
                                </td>
                                <td>
                                    <img src=" {{ asset('front_assets/img/slider/' . $banner['image']) }}"
                                        style="width:70px; height:70px;">

                                <td>

                                    <a href="{{ url('admin/add-banner-image/' . $banner['id']) }}"> <i
                                        style="font-size:25px;" class="fas fa-edit"></i></a>
                                    <a href="{{ url('/') }}/admin/Delete-banner/{{ $banner['id'] }}"
                                        title="Click to edit this row"><span class="badge badge-danger"><i
                                                class="fa fa-trash"></i></span></a>
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
