@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tax</h1>
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$title}} </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($taxList['id'])) action="{{ url('admin/add-edit-Tax') }}"
                            @else action="{{ url('admin/add-edit-Tax/'.$taxList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tax Name</label>
                        <input type="text" class="form-control @error('tax_name') is-invalid @enderror" id="" placeholder="Enter tax Name" name="tax_name"  @if($taxList['id']!="") disabled="" @else required="" @endif
                        @if(!empty($taxList['tax_name']))
                                 value="{{ $taxList['tax_name'] }}"  @else value="{{ old('tax_name') }}" @endif>
                        @error('tax_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tax Percentage %</label>
                        <input type="number" step="0.001" min="0" class="form-control @error('tax_percentage') is-invalid @enderror" id="" placeholder="Enter tax %" name="tax_percentage" 
                        @if(!empty($taxList['tax_percentage']))
                                 value="{{ $taxList['tax_percentage'] }}"  @else value="{{ old('tax_percentage') }}" @endif>
                        @error('tax_percentage')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/') }}/admin/tax" class="btn btn-secondary">Back</a>
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
    
