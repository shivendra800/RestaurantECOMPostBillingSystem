@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Table</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
            
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
                    <h3 class="card-title">{{$title}} </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($tableList['id'])) action="{{ url('admin/add-edit-Table') }}"
                            @else action="{{ url('admin/add-edit-Table/'.$tableList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Name</label>
                        <input type="text" class="form-control @error('table_name') is-invalid @enderror" id="" placeholder="Enter  Table Type" name="table_name" 
                        @if(!empty($tableList['table_name']))
                                 value="{{ $tableList['table_name'] }}"  @else value="{{ old('table_name') }}" @endif>
                        @error('table_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Type</label>
                        <input type="text" class="form-control @error('table_type') is-invalid @enderror" id="" placeholder="Enter  Table Type" name="table_type" 
                        @if(!empty($tableList['table_type']))
                                 value="{{ $tableList['table_type'] }}"  @else value="{{ old('table_type') }}" @endif>
                        @error('table_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Table Capacity</label>
                          <input type="text" class="form-control @error('table_capacity') is-invalid @enderror" id="" name="table_capacity" placeholder="Enter Table Capacity"
                          @if(!empty($tableList['table_capacity']))
                                   value="{{ $tableList['table_capacity'] }}"  @else value="{{ old('table_capacity') }}" @endif>
                          @error('table_capacity')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/table" class="btn btn-secondary">Back</a>
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
    
