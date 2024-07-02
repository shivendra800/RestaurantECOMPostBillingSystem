@extends('admin.layouts.layout')

@section('title', 'Add Edit Slider')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Slider</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Slider</li>
            
          </ol>
        </div>
         
      

      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        {{-- <div class="col-md-3"></div> --}}
        <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}} Slider</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-banner-image') }}" @else action="{{ url('admin/add-banner-image/'.$banner['id']) }}" @endif method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <label for="title">Banner Type</label>
                        <select class="form-control" id="type" name="type" required="">
                            <option value="">Select Banner Type</option>
                            <option @if(!empty($banner['type'])&& $banner['type']=="Slider")
                            selected="" @endif value="Slider">Slider</option>
                            {{-- <option @if(!empty($banner['type'])&& $banner['type']=="Fix")
                            selected="" @endif value="Fix">Fix</option>
                            <option @if(!empty($banner['type'])&& $banner['type']=="About-us")
                            selected="" @endif value="About-us">About-us</option> --}}
                        </select>

                    </div>
                    
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" id="image" name="image" >
                        @if(!empty($banner['image']))
                        <a target="_blank" href="{{ url('front_assets/img/slider/'.$banner['image']) }}">View Image</a>
                        <input type="hidden" name="current_image" value="{{$banner->image  }}">
                        @endif
                    </div>
                
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title"@if(!empty($banner['title']))
                         value="{{ $banner['title'] }}"  @else value="{{ old('title') }}" @endif
                         placeholder="Enter banner Name" required>

                    </div>
               


                    
                    <div class="form-group">
                        <label for="link">Sort Details</label>
                        <input type="text" class="form-control" name="link" id="link"@if(!empty($banner['link']))
                         value="{{ $banner['link'] }}"  @else value="{{ old('link') }}" @endif
                         placeholder="Enter Sort Details">

                    </div>
                
                    <div class="form-group">
                        <label for="alt">alt</label>
                        <input type="text" class="form-control" name="alt" id="alt"@if(!empty($banner['alt']))
                        value="{{ $banner['alt'] }}"  @else value="{{ old('alt') }}" @endif
                        placeholder="Enter alt" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </div>
                
                </form>
                </div>
                <!-- /.card -->
            
              
        </div>
        {{-- <div class="col-md-3"></div> --}}
      </div>
    </div>
  </section>
        

@endsection
