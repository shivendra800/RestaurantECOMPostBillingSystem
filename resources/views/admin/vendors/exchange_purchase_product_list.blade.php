
@extends('admin.layouts.layout')
@section('title','Vendor Wise Product Return Item')

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

    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Return Item</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('admin/exchange-purchasePrdouct/'.$getvendor['id']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                        <div class="row">

                            <div class="col-md-3"></div>
                            <div class="col-md-6">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5> Vendor Current  Total Amount </h5>
                                        <div class="controls">
                                            <input type="text" name="vendor_total_amt" id="vendor_total_amt" value="{{ $getvendor['v_wallet'] }}" class="form-control vendor_total_amt" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Product Type</label>
                                          <select class="form-control select2 @error('return_product_id') is-invalid @enderror"  name="return_product_id"  id="product_id" onchange="getunit();">
                                            <option value="" >Select Product Type</option>
                                            @foreach ($getassignlist as $ptype)
                                                 <option value="{{ $ptype['id'] }}">{{ $ptype['ingredient_name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('return_product_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                      </div>
                                      
                                    
                                        <div class="form-group">
                                            <h5>Unit <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <select class="form-control unit_id @error('unit_id') is-invalid @enderror" id="unit_id" readonly>
                                                   
                                                </select>
                                                @error('unit_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                       
                                    
                                      <div class="form-group">
                                        <h5> Price <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="return_price" id="price" class="form-control price @error('return_price') is-invalid @enderror" >
                                        </div>
                                        @error('return_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                      <div class="form-group">
                                        <h5> Qty <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="return_qty" id="qty" class="form-control qty @error('return_qty') is-invalid @enderror" onkeyup="calc()">
                                        </div>
                                        @error('return_qty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                    <div class="form-group">
                                        <h5>Return Weight <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="return_weight" id="return_weight" class="form-control return_weight @error('return_weight') is-invalid @enderror" onkeyups="calc()">
                                        </div>
                                        @error('return_weight')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                    
                                      
                                    <div class="form-group">
                                        <h5> Total Weight <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="return_total_weight" id="return_total_weight" class="form-control return_total_weight @error('return_total_weight') is-invalid @enderror" readonly>
                                        </div>
                                        @error('return_total_weight')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                     

                                        <div class="form-group">
                                            <h5> Total Amount <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="return_total_amt" id="total_price" class="form-control total_price @error('return_total_amt') is-invalid @enderror" readonly>
                                            </div>
                                            @error('return_total_amt')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    
                                   
    
                                </div>
                            
                            
                           

                            </div>
                           
                        </div>
                        <div class="col-md-3"></div>
                        <div class="text-center">
                            <button type="submit" class="btn  btn-info "> Submit </button>
                            <a href="{{url('/')}}/admin/vendor" class="btn btn-secondary">Back</a>
                        </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->


            </div>

        </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
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

    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
    
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Return Product List </h3>
              <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/vendor') }}" class="btn btn-block btn-info">Back</a>

            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
            
                <tr>
                 
              
                  <th>ID</th>
                  <th>Assign Product </th>
                  <th>Assign Unit</th>  
                  <th>Return Price</th>  
                  <th>Return QTY</th>     
                  <th>Return 1-QTY Weight</th>        
                  <th>Return Total Weight OR QtY</th>     
                  <th>Return Total Amount</th>  
                  <th>Return Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getreturnItemList as $index=>$getitem)
                        <tr >
                       
                        <td>{{$index+1}}</td>
                        <td>{{$getitem['getproduct']['ingredient_name']}}</td>
                        <td>{{$getitem['getproduct']['unit']['unit_name']}}</td>
                        <td>{{$getitem['return_price']}}</td>
                        <td>{{$getitem['return_qty']}}</td>
                        <td>{{$getitem['return_weight']}}</td>
                        <td>{{$getitem['return_total_weight']}}</td>
                        <td>{{$getitem['return_total_amt']}}</td>
                        <td style="color:blue;">{{ \Carbon\Carbon::parse($getitem['created_at'])->isoFormat('MMM Do YYYY')}}</td>   

                        
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
     $('#price,#qty,#return_weight').keyup(function(){
     var textValue1 =$('#price').val();
     var textValue2 = $('#qty').val();
    var textValue3 = $('#return_weight').val();
   

    $('#total_price').val(textValue1 * textValue2); 
   $('#return_total_weight').val(textValue2 * textValue3); 
 });

 function getunit() {
        
       
        var product_id = $("#product_id").val();
      // alert(product_id);

        $.ajax({
            url: "{{ url('/') }}/admin/getunit/" + product_id
            , dataType: "json"
            , success: function(data) {
            //    console.log("data", data);
               var option = "";
                option = "<option selected value=" + data.data[0].id + ">" + data.data[0].unit_name + "</option>";

               
                $("#unit_id").html(option);
              
               


            }
        });
    }

</script>

@endsection