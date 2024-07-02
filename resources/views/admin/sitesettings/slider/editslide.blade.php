@extends('admin.layouts.layout')

@section('title', 'Edit Slide')

@section('content')

    <style>
        body {
            overflow-x: hidden;
        }

        label {
            margin-top: .6rem;
        }
    </style>

    <div class="row">
        <div class="col-md-12 grid margin">

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Home Slider Set-Up</h3>
                </div>

                <div class="title p-3 ">
                    <h5><strong>Edit Slide</strong></h5><br>

                </div>


                <form class="forms-sample p-3" action="{{ url('admin/edit-slide/' . $slider->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <img src="{{ asset('front_assets/img/slider/' . $slider->photo) }}" style="width:100%;" />
                        </div>
                    </div>
                    <br>
                    <label>Replace Photo</label>
                    <input name="photo" value="{{ old('photo') }}" type="file" class="form-control" placeholder=""
                        style="height:50px;padding:.6rem;">

                    <label>Heading</label>
                    <input name="heading" value="{{ $slider->heading }}" type="text" class="form-control" placeholder=""
                        style="height:50px;padding:.6rem;">


                    <label>Short Description</label>
                    <input name="short_description" value="{{ $slider->short_description }}" type="text"
                        class="form-control" placeholder="" style="height:50px;padding:.6rem;">


                    <label>Button Name</label>
                    <input name="btn_name" value="{{ $slider->btn_name }}" type="text" class="form-control"
                        placeholder="" style="height:50px;padding:.6rem;">

                    <label>Button URL</label>
                    <input name="url" value="{{ $slider->url }}" type="text" class="form-control" placeholder=""
                        style="height:50px;padding:.6rem;">

                    {{-- <label>Status</label>
                    <select name="status" value="{{ $slider->status }}" type="text" class="form-control" placeholder=""
                        style="height:50px;padding:.6rem;">
                        <option>{{ $slider->status }}</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select> --}}
                    <br>
                    <button type="submit" class="btn btn-success mr-2">Update Slide</button>

                </form>


            </div>
        </div>
    </div>
@endsection
