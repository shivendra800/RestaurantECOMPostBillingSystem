@extends('admin.layouts.layout')

@section('title','AddEditExternalVendor')

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
          <h1>Vendor</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                    <h3 class="card-title">{{$title}} AddEditExternalVendor</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($AddeditExtVend['id'])) action="{{ url('admin/add-edit-ExternalVendor') }}"
                            @else action="{{ url('admin/add-edit-ExternalVendor/'.$AddeditExtVend['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Vendor Type</label>
                            <input type="text" class="form-control @error('vendor_type') is-invalid @enderror" id="" placeholder="Enter External Vendor Type" name="vendor_type" 
                            @if(!empty($AddeditExtVend['vendor_type'])) value="{{ $AddeditExtVend['vendor_type'] }}"  @else value="{{ old('vendor_type') }}" @endif>
                            @error('vendor_type')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Firm Name</label>
                            <input type="text" class="form-control @error('v_firm_name') is-invalid @enderror" id="" placeholder="Enter Vendor Firm Name" name="v_firm_name" 
                            @if(!empty($AddeditExtVend['v_firm_name'])) value="{{ $AddeditExtVend['v_firm_name'] }}"  @else value="{{ old('v_firm_name') }}" @endif>
                            @error('v_firm_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Name</label>
                            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="" placeholder="Enter Vendor Name" name="vendor_name" 
                            @if(!empty($AddeditExtVend['vendor_name']))
                                     value="{{ $AddeditExtVend['vendor_name'] }}"  @else value="{{ old('vendor_name') }}" @endif>
                            @error('vendor_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Email</label>
                            <input type="text" class="form-control @error('v_email') is-invalid @enderror" id="" placeholder="Enter Vendor Email" name="v_email" 
                            @if(!empty($AddeditExtVend['v_email']))
                                     value="{{ $AddeditExtVend['v_email'] }}"  @else value="{{ old('v_email') }}" @endif>
                            @error('v_email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Address</label>
                            <input type="text" class="form-control @error('v_address') is-invalid @enderror" id="" placeholder="Enter Vendor Address" name="v_address" 
                            @if(!empty($AddeditExtVend['v_address']))
                                     value="{{ $AddeditExtVend['v_address'] }}"  @else value="{{ old('v_address') }}" @endif>
                            @error('v_address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor City</label>
                            <input type="text" class="form-control @error('v_city') is-invalid @enderror" id="" placeholder="Enter Vendor City" name="v_city" 
                            @if(!empty($AddeditExtVend['v_city']))
                                     value="{{ $AddeditExtVend['v_city'] }}"  @else value="{{ old('v_city') }}" @endif>
                            @error('v_city')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor State</label>
                            <input type="text" class="form-control @error('v_state') is-invalid @enderror" id="" placeholder="Enter Vendor State" name="v_state" 
                            @if(!empty($AddeditExtVend['v_state']))
                                     value="{{ $AddeditExtVend['v_state'] }}"  @else value="{{ old('v_state') }}" @endif>
                            @error('v_state')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Pincode</label>
                            <input type="text" class="form-control @error('v_pincode') is-invalid @enderror" id="" placeholder="Enter Vendor Pincode" name="v_pincode" 
                            @if(!empty($AddeditExtVend['v_pincode']))
                                     value="{{ $AddeditExtVend['v_pincode'] }}"  @else value="{{ old('v_pincode') }}" @endif>
                            @error('v_pincode')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor Phone No</label>
                            <input type="text" class="form-control @error('v_phone_no') is-invalid @enderror" id="" placeholder="Enter Vendor Phone No" name="v_phone_no" 
                            @if(!empty($AddeditExtVend['v_phone_no']))
                                     value="{{ $AddeditExtVend['v_phone_no'] }}"  @else value="{{ old('v_phone_no') }}" @endif>
                            @error('v_phone_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Vendor GSTIN No</label>
                            <input type="text" class="form-control @error('v_gstnin_no') is-invalid @enderror" id="" placeholder="Enter Vendor GSTIN NO" name="v_gstnin_no" 
                            @if(!empty($AddeditExtVend['v_gstnin_no']))
                                     value="{{ $AddeditExtVend['v_gstnin_no'] }}"  @else value="{{ old('v_gstnin_no') }}" @endif>
                            @error('v_gstnin_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                    </div>
                    <hr>
                    <div class="card-header">
                     <h3 class="card-title btn btn-warning">Bank Details Of Vendor</h3>
                    </div>
                    <div class="card-body">
                     <div class="row">

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank Name</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="" placeholder="Enter Bank Name" name="bank_name" 
                            @if(!empty($AddeditExtVend['bank_name'])) value="{{ $AddeditExtVend['bank_name'] }}"  @else value="{{ old('bank_name') }}" @endif >
                            @error('bank_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank Branch Name</label>
                            <input type="text" class="form-control @error('bank_branch_name') is-invalid @enderror" id="" placeholder="Enter Bank Branch Name" name="bank_branch_name" 
                            @if(!empty($AddeditExtVend['bank_branch_name'])) value="{{ $AddeditExtVend['bank_branch_name'] }}"  @else value="{{ old('bank_branch_name') }}" @endif >
                            @error('bank_ifse_code')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank IFSE Code</label>
                            <input type="text" class="form-control @error('bank_ifse_code') is-invalid @enderror" id="" placeholder="Enter Bank IFSE Code" name="bank_ifse_code" 
                            @if(!empty($AddeditExtVend['bank_ifse_code'])) value="{{ $AddeditExtVend['bank_ifse_code'] }}"  @else value="{{ old('bank_ifse_code') }}" @endif >
                            @error('bank_ifse_code')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank Account No</label>
                            <input type="text" class="form-control @error('bank_account_no') is-invalid @enderror" id="" placeholder="Enter Bank Account No" name="bank_account_no" 
                            @if(!empty($AddeditExtVend['bank_account_no'])) value="{{ $AddeditExtVend['bank_account_no'] }}"  @else value="{{ old('bank_account_no') }}" @endif >
                            @error('bank_account_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bank Link UPI ID</label>
                            <input type="text" class="form-control @error('bank_link_upi_id') is-invalid @enderror" id="" placeholder="Enter Bank Link UPI ID" name="bank_link_upi_id" 
                            @if(!empty($AddeditExtVend['bank_link_upi_id'])) value="{{ $AddeditExtVend['bank_link_upi_id'] }}"  @else value="{{ old('bank_link_upi_id') }}" @endif >
                            @error('bank_link_upi_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>

                    </div>
                    </div>
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/expense-vendor" class="btn btn-secondary">Back</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
            
              
        </div>
         
      </div>
    </div>
  </section>

 

    
@endsection
    
