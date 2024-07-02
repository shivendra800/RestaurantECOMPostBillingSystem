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
                  <form class="forms-sample" @if(empty($tableList['id'])) action="{{ url('admin/add-edit-barTable') }}"
                            @else action="{{ url('admin/add-edit-barTable/'.$tableList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Bar Table Name</label>
                        <input type="text" class="form-control @error('table_name') is-invalid @enderror" id="" placeholder="Enter  Bar Table Name" name="table_name" 
                        @if(!empty($tableList['table_name']))
                                 value="{{ $tableList['table_name'] }}"  @else value="{{ old('table_name') }}" @endif>
                        @error('table_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Bar Table Wise Total Chairs</label>
                          <input type="number" class="form-control @error('total_chair') is-invalid @enderror" id="" name="total_chair" placeholder="Enter Bar Table Wise Total Chairs"
                          @if(!empty($tableList['total_chair']))
                                   value="{{ $tableList['total_chair'] }}"  @else value="{{ old('total_chair') }}" @endif>
                          @error('total_chair')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/bartable" class="btn btn-secondary">Back</a>
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
    
