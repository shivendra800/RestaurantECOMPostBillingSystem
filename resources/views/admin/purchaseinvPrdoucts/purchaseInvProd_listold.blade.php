@extends('admin.layouts.layout')
@section('title','Purchase Product')

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
            <li class="breadcrumb-item active">Purchase Product</li>
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
                       <a href="{{url('/')}}/admin/add-edit-PurchaseInvProdIndex"> <button type="button" class="btn btn-block btn-info btn-flat ">Purchase Product</button></a>
                    </h3>
                </div>
             </div>
           
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Purchase Prdouct List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
    
              
                <thead>
                <tr>
                 
               
                  <th>ID</th>
                   <th>Order No</th>
                  <th>Vendor Name</th>
                  <th>Bill</th>
                  <th>Grand Total</th>
                  <th>Paid Amount</th>
                  <th>Remaining Amount</th>
                  <th>Purchase Date</th>
                  <th>Bill Generated Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseInvProd as $index=>$purchaseInvProd)
                        <tr id="tr_{{$purchaseInvProd['id']}}">
                       
               
                        <td>{{$index+1}}</td> 
                        <td>{{$purchaseInvProd['invoice_id']}}</td>

                        <td><strong>{{$purchaseInvProd['vendor']['vendor_name']}}</strong><br><small>{{$purchaseInvProd['vendortype']['vendor_type']}}</small></td>
                        <td>Rs.{{$purchaseInvProd['total_bill']}}</td>
                        <td>Rs.{{$purchaseInvProd['grand_total']}}</td>
                        <td>Rs.{{$purchaseInvProd['paid_amount']}} <br>
                          <strong style="color:blue">{{$purchaseInvProd['payment_mode']}}</strong>
                        </td>
                        <td>Rs.{{$purchaseInvProd['remaining_amount']}}</td>
                     
                        <td style="color:red;">{{ \Carbon\Carbon::parse($purchaseInvProd['product_purchase_date'])->isoFormat('MMM Do YYYY')}}</td>
                        <th style="color:darkblue;">{{ \Carbon\Carbon::parse($purchaseInvProd['created_at'])->isoFormat('MMM Do YYYY')}}</th>

                            <td>
                              <div style="display:inline-flex;">

                                <a title="View-Purchase Product " href="{{ url('admin/View-Purchase/'.$purchaseInvProd['id'] ) }}"><i style="font-size:25px;" class="fa fa-file"></i></a>&nbsp;&nbsp;
                            
                          
  @if(Auth::guard('admin')->user()->type=="Admin")
                                <form method="post" id="delete_form_{{ $purchaseInvProd['id'] }}"
                                action="{{ url('/') }}/admin/Delete-PurchaseInvProdIndex/{{ $purchaseInvProd['id'] }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="deleted_id" value="{{ $purchaseInvProd['id'] }}">
                                <span onclick="deleteRow('{{ $purchaseInvProd['id']  }}')" type="button"
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
