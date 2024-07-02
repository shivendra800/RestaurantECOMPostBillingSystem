@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Menu Category </h1>
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
                  <form class="forms-sample" @if(empty($menuCatList['id'])) action="{{ url('admin/add-edit-MenuCategory') }}"
                            @else action="{{ url('admin/add-edit-MenuCategory/'.$menuCatList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Menu Category Name</label>
                        <input type="text" class="form-control @error('menu_cat_name') is-invalid @enderror" id="" placeholder="Enter Menu Category" name="menu_cat_name" 
                        @if(!empty($menuCatList['menu_cat_name']))
                                 value="{{ $menuCatList['menu_cat_name'] }}"  @else value="{{ old('menu_cat_name') }}" @endif>
                        @error('menu_cat_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/menu-category" class="btn btn-secondary">Back</a>
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
    
