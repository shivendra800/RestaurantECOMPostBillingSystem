@extends('admin.layouts.layout')

@section('title','Assign Vendor Product')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Assign Vendor Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Assign Vendor Product</li>
            
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
                    <h3 class="card-title">Assign Vendor Product</h3>
                    
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($getvendor['id'])) action="{{ url('admin/assign-vendor-BuyProduct') }}"
                            @else action="{{ url('admin/assign-vendor-BuyProduct/'.$getvendor['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                      <div class="form-group">
                        <label for="exampleInputEmail1">Select Product Type</label>
                          <select class="form-control @error('product_type_id') is-invalid @enderror" name="product_type_id" onchange="getVendor();" id="product_type_id">
                            <option value="" >Select Product Type</option>
                            @foreach ($prodType as $ptype)
                                 <option value="{{$ptype['id']}}"  {{(old('product_type_id') == $ptype['id']?'selected':'')}}>{{$ptype['c_type']}}</option>
                            @endforeach
                        </select>
                        @error('product_type_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                    <!-- /.card-body -->
                    <div class="col-12 col-md-12">
                      <div class="form-group">
                        <label>Assign Multiple Product</label>
                        <div class="select2-purple">
                          <select class="form-control product_id @error('product_id') is-invalid @enderror " multiple="multiple" data-placeholder="Select a State" name="product_id[]" id="product_id" data-dropdown-css-class="select2-purple" style="width: 100%;">
                            <option value="">Select Product</option>

                          </select>
                            @error('product_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          
                        </div>
                      </div>
                      <!-- /.form-group -->
                    </div>
            
                    <div class="card-footer text-center">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/vendor') }}" class="btn btn-block btn-info">Back</a>

                     
                    </div>
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
     
      </div>
    </div>
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
    
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Assign Product List</h3>
              <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/vendor') }}" class="btn btn-block btn-info">Back</a>

            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
            
                <tr>
                 
              
                  <th>ID</th>
                  <th>Assign Product Type</th>
                  <th>Assign Product </th>
                  <th>Assign Unit</th>             
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getassignlist as $index=>$getitem)
                        <tr >
                       
                        <td>{{$index+1}}</td>
                        <td>

                          @if($getitem['product_type_id']!=0)
                          {{$getitem['getproduct']['prodtype']['c_type']}}
                          @else
                           ---
                          @endif
                        </td>
                        <td>{{$getitem['getproduct']['ingredient_name']}}</td>
                        <td>{{$getitem['getunit']['unit_name']}}</td>
                            <td>
                              <div style="display:inline-flex;">
                                <form method="post" id="delete_form_{{ $getitem['id'] }}"
                                action="{{ url('/') }}/admin/Delete-AssignProduct/{{ $getitem['id'] }}">
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

 

    
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      getVendor();
      getCategory();
      getunit();
    });

    
    function getVendor() {
        var product_type_id = $("#product_type_id").val();
        // alert(state_id);

        var product_id = "{{ old('product_id') }}";

        $.ajax({
            url: "{{ url('/') }}/admin/getProdType/" + product_type_id
            , dataType: "json"
            , success: function(data) {
                // console.log("data", data);
                var option = "<option value=''>Select Product</option>";

                for (var i = 0; i < data.data.length; i++) {

                    if (product_type_id == data.data[i].id) {
                        option += "<option selected value=" + data.data[i].id + ">" + data.data[
                                i]
                            .ingredient_name + "</option>";
                    } else {
                        option += "<option value=" + data.data[i].id + ">" + data.data[i]
                            .ingredient_name + "</option>";
                    }
                }
                $("#product_id").html(option);


            }
        });
    }
  </script>
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
    
