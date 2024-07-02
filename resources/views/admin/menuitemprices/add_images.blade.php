@extends('admin.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
    
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Menu Item Multi Images</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
         
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Multi Images</h4>
                        <br>
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
                        <form class="forms-sample" action="{{ url('admin/add-images/'.$menuitemget['id']) }}" method="post" enctype="multipart/form-data">
                            @csrf




                            <div class="form-group">
                                <label for="menu_item_name">Menu Item Name</label>
                                &nbsp;{{ $menuitemget['menu_item_name'] }}
                            </div>
                            <div class="form-group">
                                <label for="menu_item_code">Menu Item code</label>
                                &nbsp;{{ $menuitemget['menu_item_code'] }}
                            </div>
                           
                            <div class="form-group">
                                <label for="menu_item_price">Menu Item Price</label>
                                &nbsp;{{ $menuitemget['menu_item_price'] }}
                            </div>
                            <div class="form-group">
                                @if(!empty($menuitemget['menu_item_image']))
                                <img style="width: 120px;" src="{{ url('front_assets/menu_item_image/'.$menuitemget['menu_item_image']) }}">
                                @else
                                <img style="width: 120px;" src="{{ url('admin_assets/food-dummy.png') }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="field_wrapper">

                                    <input type="file" name="images[]" multiple="" id="images">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light" >Cancel</button>
                        </form>
                        <br>
                        <h4 class="card-title">View Menu Item  Images</h4>

                        <table id="sections" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getMultiimgitem as $image)
                                <tr>
                                    <td>{{ $image['id'] }}</td>
                                    <td>
                                        <img style="width: 60px; height:60px;" src=" {{ asset('front_assets/menu_item_image/small/'.$image['image']) }}" </td>
                                    <td>
                                        <form method="post" id="delete_form_{{ $image['id'] }}"
                                        action="{{ url('/') }}/admin/delete-multiimage/{{ $image['id'] }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="deleted_id" value="{{ $image['id'] }}">
                                        <span onclick="deleteRow('{{ $image['id']  }}')" type="button"
                                            class="badge badge-danger" title="Click to delete this row"><i
                                                class="fa fa-trash"></i></span>
                                        </form>
                                    </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


    @endsection
    @section('script')
  <script>
      function deleteRow(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#delete_form_" + id).submit();
                } else {
                    swal("Your data is safe!");
                }
            });
    }
  </script>

    @endsection
