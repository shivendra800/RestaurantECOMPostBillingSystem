@extends('admin.layouts.layout')
@section('title','AddEditView Assign Ingredient  Menu Item  List')

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
                    <li class="breadcrumb-item active">AddEditView Assign Ingredient  Menu Item  List</li>
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

                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add And Update Assign Ingredient  Menu Item  List</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form action="{{ url('admin/menu-configuraton/'.$getsingleitem['id']) }}" method="post">
                                  @csrf

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Item  Name</th>
                                  <th>RECIPE UNIT </th>
                                  <th>RECIPE QTY </th>
                                  <th>UNIT PER KG/LTR</th>
                                  <th>SIZE PER KG/LTR</th>
                                  <th>RATE PER KG/LTR</th>
                                  <th>AMOUNT</th>
                                  <th>Convert In Kg</th>
                                  <th>Convert In Liter</th>
            
                               
                                </tr>
                                </thead>
                        
                                 <tbody>

                                    @if ($getsingleitem['type']=="restaurant-menu")

                                        @foreach ($getingredientrest as $index=>$getproduct)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$getproduct['ingredient_name']}}
                                            <input type="hidden" name="ingredient_id[]" class="form-control" value="{{$getproduct['id']}}">
                                            </td>
                                            <td>
                                            <select class="form-control unit_id" name="unit_id[]" id="unit_id" onchange="CalculateTotal(this)">
                                                <option value="" >Select Use Ingredient Unit</option>

                                                <option value="Gram" @if (old('unit_id') == "Gram") {{ 'selected' }} @endif >Gram</option>
                                                <option value="ML" @if (old('unit_id') == "ML") {{ 'selected' }} @endif >Ml</option>
                                                <option value="Piece" @if (old('unit_id') == "Piece") {{ 'selected' }} @endif >Piece</option>


                                            </select>
                                            </td>

                                            <td>
                                            <input type="number"  step="0.001" min="0"   name="use_weight[]" class="form-control use_weight"   id="use_weight" onkeyup="CalculateTotal(this)"></td>
                                            <td style="color:orange;">
                                                {{$getproduct['unit']['unit_name']}}

                                            </td>
                                            <td>
                                                <input type="text" class="form-control size_per" name="size_per[]" placeholder="Enter  SIZE PER KG/LTR">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control rate_per" name="rate_per[]" placeholder="Enter  RATE PER KG/LTR" onkeyup="rate_per(this);">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control useamount" name="amount[]" placeholder="Enter Amount" >
                                            </td>
                                            <td>
                                            <input type="text" class="form-control outputKilograms" name="outputKilograms[]" id="outputKilograms" value="0" readonly>
                                            </td>
                                            <td>
                                            <input type="text" class="form-control outputLiters" name="outputLiters[]" id="outputLiters" value="0" readonly>
                                            </td>




                                        </tr>
                                        @endforeach
                                    @else

                                    @foreach ($getingredientbar as $index=>$getproduct)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$getproduct['ingredient_name']}}
                                          <input type="hidden" name="ingredient_id[]" class="form-control" value="{{$getproduct['id']}}">
                                        </td>
                                        <td>
                                          <select class="form-control unit_id" name="unit_id[]" id="unit_id" onchange="CalculateTotal(this)">
                                            <option value="" >Select Use Ingredient Unit</option>

                                            {{-- <option value="Gram" @if (old('unit_id') == "Gram") {{ 'selected' }} @endif >Gram</option> --}}
                                            <option value="ML" @if (old('unit_id') == "ML") {{ 'selected' }} @endif >Ml</option>
                                            <option value="Piece" @if (old('unit_id') == "Piece") {{ 'selected' }} @endif >Piece</option>


                                        </select>
                                        </td>

                                        <td>
                                          <input type="number"  step="0.001" min="0"   name="use_weight[]" class="form-control use_weight"   id="use_weight" onkeyup="CalculateTotal(this)"></td>
                                          <td style="color:orange;">
                                            {{$getproduct['unit']['unit_name']}}

                                          </td>
                                          <td>
                                            <input type="text" class="form-control size_per" name="size_per[]" placeholder="Enter  SIZE PER KG/LTR">
                                          </td>
                                          <td>
                                            <input type="text" class="form-control rate_per" name="rate_per[]" placeholder="Enter  RATE PER KG/LTR" onkeyup="rate_per(this);">
                                          </td>
                                          <td>
                                            <input type="text" class="form-control useamount" name="amount[]" placeholder="Enter Amount" >
                                          </td>
                                          <td>
                                          <input type="text" class="form-control outputKilograms" name="outputKilograms[]" id="outputKilograms" value="0" readonly>
                                        </td>
                                        <td>
                                          <input type="text" class="form-control outputLiters" name="outputLiters[]" id="outputLiters" value="0" readonly>
                                        </td>




                                    </tr>
                                    @endforeach

                                    @endif

                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
          
  
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Assign Ingredient To Menu Item  List</h3>
            
          </div>
          <!-- /.card-header -->
          
          <div class="card-body">
            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                      aria-describedby="example1_info">
             {{-- <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('admin/MenuItemConfirlistDeleteAll') }}">Delete All Selected</button> --}}

              <tr>
               
                {{-- <th width="50px"><input type="checkbox" id="master"></th> --}}
                <th>ID</th>
                <th>Item Name </th>  
                <th>RECIPE QTY /RECIPE UNIT </th>   
                <th>SIZE PER/UNIT PER </th>
                <th>RATE PER</th>
                <th>Amount</th>
                <th>Convert In Kg</th>    
                <th>Convert In Liter</th>   
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @php
                  $getamount =0;
                @endphp
                  @foreach ($getmenuItemConfig as $index=>$getitem)
                  @php
                    $getamount +=$getitem['amount'];
                  @endphp
                  <tr id="tr_{{$getitem['id']}}">
                 
                  {{-- <td><input type="checkbox" class="sub_chk" data-id="{{$getitem['id']}}"></td> --}}
                      <td>{{$index+1}}</td>
                      <td>{{$getitem['getproduct']['ingredient_name']}}</td>
                      <td>{{$getitem['use_weight']}}/{{$getitem['unit_id']}}</td>
                      <td>{{$getitem['size_per']}}/{{$getitem['getproduct']['unit']['unit_name']}}</td>
                       <td>{{ $getitem['rate_per'] }}</td>
                       <td>{{ $getitem['amount'] }}</td>
                      <td>{{$getitem['outputKilograms']}}/Kg</td>
                      <td>{{$getitem['outputLiters']}}/Liter</td>
                          <td>
                            <div style="display:inline-flex;">
                              <form method="post" id="delete_form_{{ $getitem['id'] }}"
                              action="{{ url('/') }}/admin/Delete-MenuItemconfiguraton/{{ $getitem['id'] }}">
                              {{ csrf_field() }}
                              <input type="hidden" name="deleted_id" value="{{ $getitem['id'] }}">
                              <span onclick="deleteRow('{{ $getitem['id']  }}')" type="button"
                                  class="badge badge-danger" title="Click to delete this row"><i
                                      class="fa fa-trash"></i></span>
                              </form>
                            </div>
                          </form>
                          </td>
                      
              </tr>
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><strong>{{ $getamount }}</strong></td>
                <td></td>
                <td></td>
                <td></td>
                
              </tr>
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
<script>
   
   function rate_per(ele)
  {
           var size_per = $(ele).closest('tr').find('.size_per').val();
          var use_weight = $(ele).closest('tr').find('.use_weight').val();
          var rate_per = $(ele).closest('tr').find('.rate_per').val();
       
         

            size_per = size_per == '' ? 0 : size_per;
            use_weight = use_weight == '' ? 0 : use_weight;
            rate_per = rate_per == '' ? 0 : rate_per;
          
       
              if (!isNaN(use_weight))
               {

                
                   var calsizeperrate =   parseFloat(use_weight)/parseFloat(size_per);
                  var gramtotal = parseFloat(calsizeperrate) * parseFloat(rate_per) ;
                  $(ele).closest('tr').find('.useamount').val(gramtotal.toFixed(2));
                  
              
                       
               
                 
                }

    
  }

  function CalculateTotal(ele)
  {
           var unit_id = $(ele).closest('tr').find('.unit_id').val();
          //  alert(unit_id);
          var use_weight = $(ele).closest('tr').find('.use_weight').val();
       
         

            use_weight = use_weight == '' ? 0 : use_weight;
          
       
              if (!isNaN(use_weight))
               {

                if(unit_id == "Gram"){
                     
                  var gramtotal = parseFloat(use_weight)/1000 ;
                  $(ele).closest('tr').find('.outputKilograms').val(gramtotal.toFixed(2));
                  
                }

                if(unit_id == "ML"){

                  var mltotal = parseFloat(use_weight)/1000 ;
                  $(ele).closest('tr').find('.outputLiters').val(mltotal.toFixed(2));

                }
                 
                       
               
                 
                }

    
  }
  </script>
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