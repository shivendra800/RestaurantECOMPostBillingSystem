@extends('admin.layouts.layout')
@section('title','BarTable Chair List')

@section('content')

<section class="content-header">
    <div class="container-fluid">
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


        <div class="row mb-2">

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"> BarTable Chair List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title ">
                            <a href="{{url('/')}}/admin/bartable"> <button type="button" class="btn btn-block btn-info btn-flat ">Back </button></a>
                        </h3>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <form class="forms-sample" action="{{ url('admin/Add-BarChairTablwWise/'.$getbartable['id']) }}" method="post" enctype="multipart/form-data">
                                    @csrf
        
        
        
        
                                    <div class="bagdge badge-warning text-center">
                                        <span  for="table_name">Table Name</span>
                                        &nbsp;{{ $getbartable['table_name'] }}
                                    </div>
                                    <br>
                                    <div class="form-group text-center">
                                        <div class="field_wrapper">
                                            <div>
                                            <label for="l">Enter Chair Name</label>
                                                <input type="text" name="chair_name[]" placeholder="Enter Chair Name" required="" />
        
                                                <a href="javascript:void(0);" class="add_button btn btn-success" title="Add field">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </div>
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

              
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">BarTable Chair List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>ID</th>
                                    <th>Bar Table Name</th>
                                    <th>Bar Chair Name</th>
                                    <th>Bar Table Wise Chair Booking Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getallChair as $index=>$type)
                                <tr>

                                    <td>{{$index+1}}</td>
                                    <td>{{$type['bartablename']['table_name']}}</td>
                                    <td>{{$type['chair_name']}}</td>

                                    <td>
                                        @if($type['tablechairs_status']==1)
                                        <button class="btn btn-success">Bar Table Chair Is Already Booked!</button>
                                        @else
                                        <button class="btn btn-warning">Bar Table Chair is Not Book Yet!</button>
                                        @endif
                                    </td>



                                    <td>
                                        <div style="display:inline-flex;">

                                            <form method="post" id="delete_form_{{ $type['id'] }}" action="{{ url('/') }}/admin/Delete-BarTableWiseChair/{{ $type['id'] }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="deleted_id" value="{{ $type['id'] }}">
                                                <span onclick="deleteRow('{{ $type['id']  }}')" type="button" class="badge badge-danger" title="Click to delete this row"><i class="fa fa-trash"></i></span>
                                            </form>
                                        </div>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection
@section('script')


<script>
    //Products Attributes Add Remove Script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><label for="l">Enter Chair Name</label><input type="text" name="chair_name[]" required placeholder="Enter ChairName"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
</script>


<script>
    function ActiveRow(id) {
        console.log(id);
        swal({
                title: "Are you sure?"
                , text: "You want to change status"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    $("#active_form_" + id).submit();
                } else {
                    //swal("Your data is safe!");
                }
            });

    }

    function InActiveRow(id) {
        swal({
                title: "Are you sure?"
                , text: "You want to change status"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    $("#inactive_form_" + id).submit();
                } else {
                    //swal("Your data is safe!");
                }
            });

    }

    function deleteRow(id) {
        swal({
                title: "Are you sure?"
                , text: "Once deleted, you will not be able to recover this imaginary file!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    $("#delete_form_" + id).submit();
                } else {
                    swal("Your data is safe!");
                }
            });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {


        $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {


                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {


                    var join_selected_values = allVals.join(",");


                    $.ajax({
                        url: $(this).data('url')
                        , type: 'DELETE'
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , data: 'ids=' + join_selected_values
                        , success: function(data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        }
                        , error: function(data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]'
            , onConfirm: function(event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function(e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href
                , type: 'DELETE'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , success: function(data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                }
                , error: function(data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>
@endsection