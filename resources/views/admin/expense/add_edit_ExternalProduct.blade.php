@extends('admin.layouts.layout')

@section('title',$title.'ExternalProduct')

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
          <h1>ExternalProduct</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-ExternalProduct</li>
            
          </ol>
        </div>
         
      

      </div>
    </div><!-- /.container-fluid -->
  </section>
   

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}} ExternalProduct</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($AddeditExtProd['id'])) action="{{ url('admin/add-edit-ExternalProduct') }}"
                            @else action="{{ url('admin/add-edit-ExternalProduct/'.$AddeditExtProd['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Ext Product Type</label>
                          <input type="text" class="form-control @error('ext_product_type') is-invalid @enderror" id="" placeholder="Enter Ext Product Type" name="ext_product_type" 
                          @if(!empty($AddeditExtProd['ext_product_type']))
                                   value="{{ $AddeditExtProd['ext_product_type'] }}"  @else value="{{ old('ext_product_type') }}" @endif>
                          @error('ext_product_type')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ext Product Name</label>
                        <input type="text" class="form-control @error('ext_product_name') is-invalid @enderror" id="" placeholder="Enter Ext Product Name" name="ext_product_name" 
                        @if(!empty($AddeditExtProd['ext_product_name']))
                                 value="{{ $AddeditExtProd['ext_product_name'] }}"  @else value="{{ old('ext_product_name') }}" @endif>
                        @error('ext_product_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/') }}/admin/expense-TypeProduct" class="btn btn-secondary">Back</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </section>

 
@endsection
    
