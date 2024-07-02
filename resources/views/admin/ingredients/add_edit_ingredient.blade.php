@extends('admin.layouts.layout')

@section('title',$title.'Ingredient')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Ingredient</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Ingredient</li>
            
          </ol>
        </div>
         
      

      </div>
    </div><!-- /.container-fluid -->
  </section>
   

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}} Ingredient</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($ingredient['id'])) action="{{ url('admin/add-edit-Ingredient') }}"
                            @else action="{{ url('admin/add-edit-Ingredient/'.$ingredient['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                      <div class="form-group">
                        <label for="exampleInputEmail1">Select Product Type</label>
                        <select class="form-control @error('product_type_id') is-invalid @enderror" name="product_type_id">
                            <option value="" >Select Product Type</option>
                            @foreach ($prodType as $ptype)
                                 <option value="{{$ptype['id']}}" @selected($ptype['id'] == $ingredient['product_type_id']) {{(old('product_type_id') == $ptype['id']?'selected':'')}}>{{$ptype['c_type']}}</option>
                            @endforeach
                        </select>
                        @error('product_type_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                        <div class="form-group">
                        <label for="type">Select Item Type </label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                          <option value="">Select Product Item Type</option>
                          <option value="Bar-Product" @if(isset($ingredient['type']) && $ingredient['type']=="Bar-Product" ) selected @endif>Bar-Product</option>
                            <option value="Restaurant-Product" @if(isset($ingredient['type']) && $ingredient['type']=="Restaurant-Product" ) selected @endif>Restaurant-Product</option>

                        </select>
                        @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                    </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Product Name</label>
                        <input type="text" class="form-control @error('ingredient_name') is-invalid @enderror" id="" placeholder="Enter Unit Name" name="ingredient_name" 
                        @if(!empty($ingredient['ingredient_name']))
                                 value="{{ $ingredient['ingredient_name'] }}"  @else value="{{ old('ingredient_name') }}" @endif>
                        @error('ingredient_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Min Stock Qty Alert</label>
                        <input type="number" class="form-control @error('min_qty') is-invalid @enderror" id="" placeholder="Enter Min Qty Alert" name="min_qty" 
                        @if(!empty($ingredient['min_qty']))
                                 value="{{ $ingredient['min_qty'] }}"  @else value="{{ old('min_qty') }}" @endif>
                        @error('min_qty')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                        
                            <div class="form-group">
                                <label for="exampleInputEmail1">Select Unit</label>
                                <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                    <option value="" >Select Unit</option>
                                    @foreach ($unit as $unit)
                                         <option value="{{$unit['id']}}" @selected($unit['id'] == $ingredient['unit_id']) {{(old('unit_id') == $unit['id']?'selected':'')}}>{{$unit['unit_name']}}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                              </div>

                              
                        
                     
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/') }}/admin/ingredient" class="btn btn-secondary">Back</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </section>

 

    
@endsection
    
