@extends('admin.layouts.layout')
@section('title','Generate Token')

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
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Generate Token</li>
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
                       <a href="{{url('/')}}/admin/add-edit-genarate-token"> <button type="button" class="btn btn-block btn-info btn-flat ">Create Generate Token</button></a>
                    </h3>
                </div>
             </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Generate Token</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>Token No </th>
                  <th>Token Amount </th>
                  <th>Payment Mode</th>
                  <th>Is Discount</th>
                   <th>Created At</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($gettokenList as $index=>$unit)
                        <tr>
                       
                     
                        <td>{{$index+1}}</td>
                        <td>{{$unit['token_no']}}</td>
                        <td>{{$unit['token_amount']}}</td>
                        <td>{{$unit['payment_mode']}}</td>
                        <td>{{ \Carbon\Carbon::parse($unit['created_at'])->isoFormat('MMM Do YYYY')}}</td>
                        <td>
                             @if( $unit['is_discount'] == "Yes")
                            D
                            @else
                            General
                            @endif
                            </td>

                            <td>
                              <div style="display:inline-flex;">
                                 <a title="Print Token " href="{{ url('admin/genaratetoken/'.$unit['id'] ) }}"><i style="font-size:25px;" class="fa fa-file"></i></a>&nbsp;&nbsp;

                               @if(Auth::guard('admin')->user()->type=="Admin")
                                <a title="Edit type Details" href="{{ url('admin/add-edit-genarate-token/'.$unit['id'] ) }}"><i style="font-size:25px;" class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                <form method="post" id="delete_form_{{ $unit['id'] }}"
                                action="{{ url('/') }}/admin/Delete-genarate-token/{{ $unit['id'] }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="deleted_id" value="{{ $unit['id'] }}">
                                <span onclick="deleteRow('{{ $unit['id']  }}')" type="button"
                                    class="badge badge-danger" title="Click to delete this row"><i
                                        class="fa fa-trash"></i></span>
                                </form>
                               @endif
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
