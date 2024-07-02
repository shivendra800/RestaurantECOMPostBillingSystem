@extends('admin.layouts.layout')

@section('title',$title.'Generate Token')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Generate Token</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Generate Token</li>
            
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
                    <h3 class="card-title">{{$title}} Generate Token</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($genrateToken['id'])) action="{{ url('admin/add-edit-genarate-token') }}"
                            @else action="{{ url('admin/add-edit-genarate-token/'.$genrateToken['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                           <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="" placeholder="Enter Name" name="name" 
                        @if(!empty($genrateToken['name']))
                                 value="{{ $genrateToken['name'] }}"  @else value="{{ old('name') }}" @endif>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                         <div class="form-group">
                        <label for="exampleInputEmail1">Mobile No </label>
                        <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" id="" placeholder="Enter Mobile" name="mobile_no"  
                        @if(!empty($genrateToken['mobile_no']))
                                 value="{{ $genrateToken['mobile_no'] }}"  @else value="{{ old('mobile_no') }}" @endif>
                        @error('mobile_no')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Token Amount</label>
                        <input type="text" class="form-control @error('token_amount') is-invalid @enderror" id="" placeholder="Enter Token Amount" name="token_amount" 
                        @if(!empty($genrateToken['token_amount']))
                                 value="{{ $genrateToken['token_amount'] }}"  @else value="{{ old('token_amount') }}" @endif>
                        @error('token_amount')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <!--   <div class="form-group">-->
                      <!--  <label for="exampleInputEmail1">No Of Time Bill Generate for Token </label>-->
                      <!--  <input type="text" class="form-control @error('no_of_bill_print') is-invalid @enderror" id="" placeholder="Enter No Of Time Bill Generate for Token " name="no_of_bill_print" -->
                      <!--  @if(!empty($genrateToken['no_of_bill_print']))-->
                      <!--           value="{{ $genrateToken['no_of_bill_print'] }}"  @else value="{{ old('no_of_bill_print') }}" @endif>-->
                      <!--  @error('no_of_bill_print')-->
                      <!--      <div class="alert alert-danger">{{ $message }}</div>-->
                      <!--  @enderror-->
                      <!--</div>-->
                      
                      <div class="form-group">
                        <label for="payment_mode">Payment Mode</label>
                        <select class="form-control payment_mode @error('payment_mode') is-invalid @enderror" id="payment_mode" name="payment_mode">
                            <option value="">Select Payment Mode</option>
                            <option
                             @if ($genrateToken != null) @if ($genrateToken->payment_mode == 'Cash') value="{{ $genrateToken->payment_mode == 'Cash' }}" selected @endif
                            @else @if (old('payment_mode') == 'Cash') selected @endif @endif value="Cash">Cash
                            </option>Card Swip
                              <option
                             @if ($genrateToken != null) @if ($genrateToken->payment_mode == 'Card Swip') value="{{ $genrateToken->payment_mode == 'Card Swip' }}" selected @endif
                            @else @if (old('payment_mode') == 'Card Swip') selected @endif @endif value="Card Swip">Card Swip
                            </option>
                            
                           
                        <option
                            @if ($genrateToken != null) @if ($genrateToken->payment_mode == 'QRCodeWithSlip') value="{{ $genrateToken->payment_mode == 'QRCodeWithSlip' }}" selected @endif
                        @else @if (old('payment_mode') == 'QRCodeWithSlip') selected @endif @endif value="QRCodeWithSlip">QRCodeWithSlip</option>
                            
                           

                        </select>

                      @error('payment_mode')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                      <div class="form-group">
                                    <label for="is_discount">Is Discount</label>
                                    <input type="checkbox" class="form-control" name="is_discount" id="is_discount" value="Yes" @if(!empty($genrateToken['is_discount'])&& $genrateToken['is_discount']=="Yes" ) checked="" @endif placeholder="Enter is_discount">
                       </div>
                    </div>
                 
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/') }}/admin/genarate-token" class="btn btn-secondary">Back</a>
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
    
