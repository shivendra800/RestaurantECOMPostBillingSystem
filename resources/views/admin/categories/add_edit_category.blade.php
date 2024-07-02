@extends('admin.layouts.layout')

@section('title','Add-Edit-Category')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Category</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Category</li>
            
          </ol>
        </div>
         
      

      </div>
    </div><!-- /.container-fluid -->
  </section>
  

  <section class="content">
    <div class="container-fluid">
      <div class="row">
       
        <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}}-Category</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}"
                            @else action="{{ url('admin/add-edit-category/'.$category['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Category Type</label>
                            <select class="form-control @error('c_type_id') is-invalid @enderror" name="c_type_id">
                                <option value="" >Select Category Type</option>
                                @foreach ($CType as $type)
                                     <option value="{{$type['id']}}" @selected($type['id'] == $category['c_type_id']) {{(old('c_type_id') == $type['id']?'selected':'')}}>{{$type['c_type']}}</option>
                                @endforeach
                            </select>
                            @error('c_type_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category  Name</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="" placeholder="Enter category Firm Name" name="category_name" 
                            @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}"  @else value="{{ old('category_name') }}" @endif>
                            @error('category_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      
                     
                   
                      
                       
                    </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/category" class="btn btn-secondary">Back</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
         
      </div>
    </div>
  </section>

 

    
@endsection
    
