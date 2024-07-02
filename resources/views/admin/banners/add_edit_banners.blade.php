@extends('admin.layouts.layout')
@section('content')

        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Slider</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">{{ $title }}</h4><br>
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

                        {{-- error meg with close button---- --}}
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        {{-- error meg --}}
                        <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-banner-image') }}" @else action="{{ url('admin/add-banner-image/'.$banner['id']) }}" @endif method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">Slider Type</label>
                                <select class="form-control" id="type" name="type" required="">
                                    <option value="">Select Banner Type</option>
                                    <option @if(!empty($banner['type'])&& $banner['type']=="Slider")
                                    selected="" @endif value="Slider">Slider</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="image">Slider Image</label>
                                <input type="file" class="form-control" id="image" name="image" >
                                @if(!empty($banner['image']))
                                <a target="_blank" href="{{ url('front_assets/banner_images/'.$banner['image']) }}">View Image</a>&nbsp;&nbsp;
                                                <!--<a href="{{ url('/') }}/admin/Delete-banner/{{$banner['id']}}"  title="Click to edit this row"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a>-->
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


                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
           
        </div>

    @endsection
