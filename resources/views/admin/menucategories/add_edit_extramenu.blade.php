@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Extra Menu </h1>
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
                    <h3 class="card-title">{{$title}}</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($extramenuList['id'])) action="{{ url('admin/add-edit-extramenu') }}"
                            @else action="{{ url('admin/add-edit-extramenu/'.$extramenuList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type">Select Restaurant Type </label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                              <option value="">Select Restaurant Type</option>
                                <option value="rest-extramenu" @if(isset($extramenuList['type']) && $extramenuList['type']=="rest-extramenu" ) selected @endif>rest-extramenu</option>

                                <option value="bar-extramenu" @if(isset($extramenuList['type']) && $extramenuList['type']=="bar-extramenu" ) selected @endif>bar-extramenu</option>
                              
                            </select>
                            @error('type')
                            <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Extra Menu Name</label>
                        <input type="text" class="form-control @error('extra_menu') is-invalid @enderror" id="" placeholder="Enter Extra Menu" name="extra_menu" 
                        @if(!empty($extramenuList['extra_menu']))
                                 value="{{ $extramenuList['extra_menu'] }}"  @else value="{{ old('extra_menu') }}" @endif>
                        @error('extra_menu')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Extra Menu Price</label>
                        <input type="number" step=0.01 class="form-control @error('price') is-invalid @enderror" id="" placeholder="Enter Extra Menu" name="price" 
                        @if(!empty($extramenuList['price']))
                                 value="{{ $extramenuList['price'] }}"  @else value="{{ old('price') }}" @endif>
                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/extra-menu" class="btn btn-secondary">Back</a>
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
    
