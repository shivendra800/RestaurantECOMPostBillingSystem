@extends('admin.layouts.layout')
@section('title','Table List')

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
            <li class="breadcrumb-item active">Table List</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title ">
                       <a href="{{url('/')}}/admin/add-edit-Table"> <button type="button" class="btn btn-block btn-info btn-flat ">Create Table</button></a>
                    </h3>
                </div>
             </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Table List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('admin/TableIndexDeleteAll') }}">Delete All Selected</button>
                <thead>
                <tr>
                 
                  <th width="50px"><input type="checkbox" id="master"></th>
                  <th>ID</th>
                  <th>Table Name</th>
                  <th>Table Type</th>
                  <th>Table Capacity</th>
                  <th>Table Booking Status</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($tableList as $index=>$type)
                        <tr id="tr_{{$type['id']}}">
                       
                        <td><input type="checkbox" class="sub_chk" data-id="{{$type['id']}}"></td>
                        <td>{{$index+1}}</td>
                        <td>{{$type['table_name']}}</td>
                        <td>{{$type['table_type']}}</td>
                        <td>{{$type['table_capacity']}}</td>
                        <td>
                          @if($type['booking_status']==1)
                             <button class="btn btn-success">Table Is Already Booked!</button>
                          @else
                          <button class="btn btn-warning">Table is Not Book Yet!</button>
                          @endif
                        </td>
                        
                        <td>
                            

                         
                          <div style="display:inline-flex;">
                          

                            @if ($type['status'] == '1')
                                 <form method="post" id="inactive_form_{{ $type['id'] }}"
                                     action="{{ url('/') }}/admin/Change-menu-table-status">
                                     {{ csrf_field() }}
                                     <input type="hidden" name="status_id"
                                         value="{{ $type['id'] }}">
                                     <input type="hidden" name="status" value="0">
                                     <span onclick="InActiveRow('{{ $type['id'] }}')" class="badge badge-success" type="button" title="Click to In-Active this row"><i class="fa fa-eye"></i></span>
                                 </form>
                            @else
                                 <form method="post" id="active_form_{{ $type['id'] }}"
                                     action="{{ url('/') }}/admin/Change-menu-table-status">
                                     {{ csrf_field() }}
                                     <input type="hidden" name="status_id"
                                         value="{{ $type['id'] }}">
                                     <input type="hidden" name="status" value="1">
                                     <span onclick="ActiveRow('{{ $type['id'] }}')" type="button" class="badge badge-warning"><i class="fa fa-eye-slash"></i></span>
                                 </form>
                            @endif
                        </td>

                            <td>
                              <div style="display:inline-flex;">

                                <a title="Edit type Details" href="{{ url('admin/add-edit-Table/'.$type['id'] ) }}"><i style="font-size:25px;" class="fa fa-edit"></i></a>
                                <form method="post" id="delete_form_{{ $type['id'] }}"
                                action="{{ url('/') }}/admin/Delete-Table/{{ $type['id'] }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="deleted_id" value="{{ $type['id'] }}">
                                <span onclick="deleteRow('{{ $type['id']  }}')" type="button"
                                    class="badge badge-danger" title="Click to delete this row"><i
                                        class="fa fa-trash"></i></span>
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
  function ActiveRow(id)
{
  console.log(id);
  swal({
    title: "Are you sure?",
    text: "You want to change status",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $("#active_form_"+id).submit();
    } else {
      //swal("Your data is safe!");
    }
  });

}

function InActiveRow(id)
{
  swal({
    title: "Are you sure?",
    text: "You want to change status",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $("#inactive_form_"+id).submit();
    } else {
      //swal("Your data is safe!");
    }
  });

}

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

<script type="text/javascript">
  $(document).ready(function () {


      $('#master').on('click', function(e) {
       if($(this).is(':checked',true))  
       {
          $(".sub_chk").prop('checked', true);  
       } else {  
          $(".sub_chk").prop('checked',false);  
       }  
      });


      $('.delete_all').on('click', function(e) {


          var allVals = [];  
          $(".sub_chk:checked").each(function() {  
              allVals.push($(this).attr('data-id'));
          });  


          if(allVals.length <=0)  
          {  
              alert("Please select row.");  
          }  else {  


              var check = confirm("Are you sure you want to delete this row?");  
              if(check == true){  


                  var join_selected_values = allVals.join(","); 


                  $.ajax({
                      url: $(this).data('url'),
                      type: 'DELETE',
                      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      data: 'ids='+join_selected_values,
                      success: function (data) {
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
                      },
                      error: function (data) {
                          alert(data.responseText);
                      }
                  });


                $.each(allVals, function( index, value ) {
                    $('table tr').filter("[data-row-id='" + value + "']").remove();
                });
              }  
          }  
      });


      $('[data-toggle=confirmation]').confirmation({
          rootSelector: '[data-toggle=confirmation]',
          onConfirm: function (event, element) {
              element.trigger('confirm');
          }
      });


      $(document).on('confirm', function (e) {
          var ele = e.target;
          e.preventDefault();


          $.ajax({
              url: ele.href,
              type: 'DELETE',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data) {
                  if (data['success']) {
                      $("#" + data['tr']).slideUp("slow");
                      alert(data['success']);
                  } else if (data['error']) {
                      alert(data['error']);
                  } else {
                      alert('Whoops Something went wrong!!');
                  }
              },
              error: function (data) {
                  alert(data.responseText);
              }
          });


          return false;
      });
  });
</script>
@endsection
