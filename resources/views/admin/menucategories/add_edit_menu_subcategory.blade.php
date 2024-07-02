@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Menu Category</h1>
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
       
        <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($menSubcategory['id'])) action="{{ url('admin/add-edit-menu-subcategory') }}"
                            @else action="{{ url('admin/add-edit-menu-subcategory/'.$menSubcategory['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                               
                                  
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Menu Category Name</label>
                                        <input type="text" class="form-control @error('menu_subcat_name') is-invalid @enderror" id="" placeholder="Enter category Firm Name" name="menu_subcat_name" 
                                        @if(!empty($menSubcategory['menu_subcat_name'])) value="{{ $menSubcategory['menu_subcat_name'] }}"  @else value="{{ old('menu_subcat_name') }}" @endif>
                                        @error('menu_subcat_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="logo_image">Menu Category Image </label>
                                      <input type="file"
                                          class="form-control @error('menu_image') is-invalid @enderror"
                                          id="menu_image" name="menu_image" accept="application/image">
                                      @error('menu_image')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                      @if (!empty($menSubcategory->menu_image))
                                          <a target="_blank"
                                              href="{{ url('front_assets/menu_img/' . $menSubcategory->menu_image) }}">View
                                              Image</a>&nbsp;&nbsp;
                                          <div><img style="width: 60px; height:60px;"s
                                                  src="{{ url('front_assets/menu_img/' . $menSubcategory->menu_image) }}"
                                                  alt=""></div>

                                          <input type="hidden" name="current_menu_image"
                                              value="{{ $menSubcategory->menu_image }}">
                                      @endif
                                  </div>
                              </div>

                                <div class="card-footer">
                      
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{url('/')}}/admin/menu-subcategory" class="btn btn-secondary">Back</a>
                                  </div>
                      
            

                            </div>
                            <div class="col-md-3"></div>
                    
                     
                   
                      
                       
                    </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                   
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
         
      </div>
    </div>
  </section>

 

    
@endsection
    
