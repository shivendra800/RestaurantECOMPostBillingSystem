@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Bar Menu Item Price Name</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
            
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
                    <h3 class="card-title">{{$title}}</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($menuitemPrice['id'])) action="{{ url('admin/add-edit-barMenuItemPrice') }}"
                            @else action="{{ url('admin/add-edit-barMenuItemPrice/'.$menuitemPrice['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                          
                          
                             
                                  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Bar Menu Category </label>
                                        <select class="form-control @error('menu_subcat_id') is-invalid @enderror" name="menu_subcat_id" >
                                            <option value="" >Select Category Type</option>
                                            @foreach ($menuCatList as $type)
                                            <option value="{{$type['id']}}" @selected($type['id'] == $menuitemPrice['menu_subcat_id']) {{(old('menu_subcat_id') == $type['id']?'selected':'')}}>{{$type['menu_subcat_name']}}</option>
                                       @endforeach
                                           
                                        </select>
                                        @error('menu_subcat_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                      
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Menu Item Code</label>
                                      <input type="text" class="form-control @error('menu_item_code') is-invalid @enderror" id="" placeholder="Enter Menu Item Code" name="menu_item_code" 
                                      @if(!empty($menuitemPrice['menu_item_code'])) value="{{ $menuitemPrice['menu_item_code'] }}"  @else value="{{ old('menu_item_code') }}" @endif>
                                      @error('menu_item_code')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                              </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Menu Item Name</label>
                                        <input type="text" class="form-control @error('menu_item_name') is-invalid @enderror" id="" placeholder="Enter category Firm Name" name="menu_item_name" 
                                        @if(!empty($menuitemPrice['menu_item_name'])) value="{{ $menuitemPrice['menu_item_name'] }}"  @else value="{{ old('menu_item_name') }}" @endif>
                                        @error('menu_item_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bar Buying Price</label>
                                        <input type="text" class="form-control @error('buying_price') is-invalid @enderror" id="" placeholder="Enter Bar Buying Price" name="buying_price" 
                                        @if(!empty($menuitemPrice['buying_price'])) value="{{ $menuitemPrice['buying_price'] }}"  @else value="{{ old('buying_price') }}" @endif>
                                        @error('buying_price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bar Selling Price</label>
                                        <input type="text" class="form-control @error('menu_item_price') is-invalid @enderror" id="" placeholder="Enter Bar Selling Price" name="menu_item_price" 
                                        @if(!empty($menuitemPrice['menu_item_price'])) value="{{ $menuitemPrice['menu_item_price'] }}"  @else value="{{ old('menu_item_price') }}" @endif>
                                        @error('menu_item_price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bar Menu Unit(Eg: 180Ml)</label>
                                        <input type="text" class="form-control @error('bar_unit') is-invalid @enderror" id="" placeholder="Enter Bar Menu Unit 80ML" name="bar_unit" 
                                        @if(!empty($menuitemPrice['bar_unit'])) value="{{ $menuitemPrice['bar_unit'] }}"  @else value="{{ old('bar_unit') }}" @endif>
                                        @error('bar_unit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label for="description">Description</label>
                                  <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{$menuitemPrice['description'] }}</textarea>
                                  @error('description')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                                </div>
                                </div>
                               
                           
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="logo_image">Menu Item Image </label>
                                      <input type="file"
                                          class="form-control @error('menu_item_image') is-invalid @enderror"
                                          id="menu_item_image" name="menu_item_image" accept="application/image">
                                      @error('menu_item_image')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                      @if (!empty($menuitemPrice->menu_item_image))
                                          <a target="_blank"
                                              href="{{ url('front_assets/menu_item_image/' . $menuitemPrice->menu_item_image) }}">View
                                              Image</a>&nbsp;&nbsp;
                                          <div><img style="width: 60px; height:60px;"s
                                                  src="{{ url('front_assets/menu_item_image/' . $menuitemPrice->menu_item_image) }}"
                                                  alt=""></div>

                                          <input type="hidden" name="current_menu_item_image"
                                              value="{{ $menuitemPrice->menu_item_image }}">
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Bar Item Type For Tax</label>
                                <select name="bar_item_tax_type" id="bar_item_tax_type" class="form-control @error('bar_item_tax_type') is-invalid @enderror" >
                                    <option value="">Select</option>
                                    <option value="Non-Alcoholics" id="Non-Alcoholics" @if (isset($menuitemPrice['bar_item_tax_type']) && $menuitemPrice['bar_item_tax_type'] == 'Non-Alcoholics') selected @endif>
                                        Non-Alcoholics</option>
                                    <option value="Alcoholics" id="Alcoholics" @if (isset($menuitemPrice['bar_item_tax_type']) && $menuitemPrice['bar_item_tax_type'] == 'Alcoholics') selected @endif>
                                        Alcoholics</option>
                                </select>
                                @error('bar_item_tax_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                          
                              <div class="col-md-6" id="bar_tax_percentage">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bar Tax Percentage Number</label>
                                    <input type="number" class="form-control @error('bar_tax_percentage') is-invalid @enderror" id="" placeholder="Enter Bar Tax Percentage Number" name="bar_tax_percentage" 
                                    @if(!empty($menuitemPrice['bar_tax_percentage'])) value="{{ $menuitemPrice['bar_tax_percentage'] }}"  @else value="{{ old('bar_tax_percentage') }}" @endif>
                                    @error('bar_tax_percentage')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                               
                      
            

                            </div>
                            <div class="col-md-12 text-center">
                                <div class="card-footer">
                      
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{url('/')}}/admin/bar-menu-item-price" class="btn btn-secondary">Back</a>
                                  </div>
                            </div>
                           
                    
                     
                   
                      
                       
                    </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                   
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
         
      </div>
    </div>
  </section>

 

    
@endsection
@section('script')
<script>  
    $(document).ready(function(){
        $('#bar_item_tax_type').on('change', function() {
          if ( this.value == 'Alcoholics')
          {
            $("#bar_tax_percentage").show();
          }
          else
          {
            $("#bar_tax_percentage").hide();
          }
        });
    });
    </script>

<script>


      
//     $(document).ready(function() {
    
//     $('#bar_tax_percentage').hide();
//     $("#bar_item_tax_type").on("change", function() {
//       // alert("payment_mode");
//         if (this.value == "Alcoholics") {
//             $("#bar_tax_percentage").show();
//         }
//          else {
//             $("#bar_tax_percentage").hide();
//         }
//     });

  
//   });
  </script>

<script>
$(document).ready(function() {
   
   getsubcatmenu();
 });
function getsubcatmenu() {
       var menu_cat_id = $("#menu_cat_id").val();
       // alert(state_id);s
       @if ($menuitemPrice != null)
            var menu_subcat_id="{{ $menuitemPrice['menu_subcat_id'] }}";
        @else
            var menu_subcat_id="{{ old('menu_subcat_id') }}";
        @endif

       $.ajax({
           url: "{{ url('/') }}/admin/getsubcatmenu/" + menu_cat_id,
           dataType: "json",
           success: function(data) {
               // console.log("data", data);
               var option = "<option value=''>Select SubCategory</option>";
               for (var i = 0; i < data.data.length; i++) {
                   if (menu_subcat_id == data.data[i].id) {
                       option += "<option selected value=" + data.data[i].id + ">" + data.data[
                               i]
                           .menu_subcat_name + "</option>";
                   } else {
                       option += "<option value=" + data.data[i].id + ">" + data.data[i]
                           .menu_subcat_name + "</option>";
                   }
               }
               $("#menu_subcat_id").html(option);
              
           }
       });
   }
</script>
    
@endsection
    
