@extends('admin.layouts.layout')

@section('title',$title.'Unit')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Unit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Unit</li>
            
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
                    <h3 class="card-title">{{$title}} Unit</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($unit['id'])) action="{{ url('admin/add-edit-unit') }}"
                            @else action="{{ url('admin/add-edit-unit/'.$unit['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Unit Name</label>(eg.Kg,ML)
                        <input type="text" class="form-control @error('unit_name') is-invalid @enderror" id="" placeholder="Enter Unit Name" name="unit_name" 
                        @if(!empty($unit['unit_name']))
                                 value="{{ $unit['unit_name'] }}"  @else value="{{ old('unit_name') }}" @endif>
                        @error('unit_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/') }}/admin/unit" class="btn btn-secondary">Back</a>
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
    
