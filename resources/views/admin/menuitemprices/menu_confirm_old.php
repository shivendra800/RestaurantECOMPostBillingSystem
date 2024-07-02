@extends('admin.layouts.layout')

@section('title','Assign Menu Item Making ')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Assign Menu Item Making </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Assign Menu Item Making </li>
            
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
                    <h3 class="card-title">Assign Ingredient To Menu Item   </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample"  action="{{ url('admin/menu-configuraton/'.$getsingleitem['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="menu_item_id" value="{{ $getsingleitem['id'] }}">
                    <div class="card-body">

                    
                        <div class="form-group">
                            <div class="col-md-12 ">
                            <label for="exampleInputEmail1">Select Ingredient Name</label>
                            <select class="form-control @error('ingredient_id') is-invalid @enderror" name="ingredient_id">
                                <option value="" >Select Ingredient Name</option>
                                @foreach ($getingredient as $getprodt)
                                     <option value="{{$getprodt['id']}}"  {{(old('ingredient_id') == $getprodt['id']?'selected':'')}}>{{$getprodt['ingredient_name']}}</option>
                                @endforeach
                            </select>
                            @error('ingredient_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                       
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12 ">
                      <label for="exampleInputEmail1">Select Use Ingredient Unit</label>
                      <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" id="unit_id" onchange="weightConverter(this.value)">
                          <option value="" >Select Use Ingredient Unit</option>

                          <option value="Gram"  >Gram</option>
                          <option value="ML" >Ml</option>
                          <option value="Piece" >Piece</option>
                         
                        
                      </select>
                      @error('unit_id')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                 
                  </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Item Ingredient  Weight</label>
                <input type="text" class="form-control @error('use_weight') is-invalid @enderror" id="" oninput="weightConverter(this.value)" onchange="weightConverter(this.value)" placeholder="Enter category Firm Name" name="use_weight" 
                @if(!empty($menuitemConfirg['use_weight'])) value="{{ $menuitemConfirg['use_weight'] }}"  @else value="{{ old('use_weight') }}" @endif>
                @error('use_weight')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="hidden" name="outputKilograms" id="outputKilograms" value="0">
            <input type="hidden" name="outputLiters" id="outputLiters" value="0">
               
              

                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer text-center">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                     
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
              <h3 class="card-title">Assign Ingredient To Menu Item  List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
            
                <tr>
                 
              
                  <th>ID</th>
                  <th> Ingredient Name </th>  
                  <th>Use Weight</th>   
                  <th>Convert In Kg</th>    
                  <th>Convert In Liter</th>   
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getmenuItemConfig as $index=>$getitem)
                        <tr>
                       
                        <td>{{$index+1}}</td>
                        <td>{{$getitem['getproduct']['ingredient_name']}}</td>
                        <td>{{$getitem['use_weight']}}/{{$getitem['unit_id']}}</td>
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

 
  <script>
   
    function weightConverter(valNum) {

      var unit_id = $("#unit_id").val();
        //  alert(unit_id);
        if(unit_id == "Gram"){
          document.getElementById("outputKilograms").value=valNum/1000;
        }
        if(unit_id == "ML"){
          document.getElementById("outputLiters").value=valNum/1000;
        }
     
    }
    </script>
    
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
    
