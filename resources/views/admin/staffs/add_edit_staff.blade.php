@extends('admin.layouts.layout')

@section('title',$title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Staff Type & Role</h1>
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
                  <form class="forms-sample" @if(empty($staffList['id'])) action="{{ url('admin/add-edit-staffs') }}"
                            @else action="{{ url('admin/add-edit-staffs/'.$staffList['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Staff Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="" placeholder="Enter  Name" name="name" 
                        @if(!empty($staffList['name']))
                                 value="{{ $staffList['name'] }}"  @else value="{{ old('name') }}" @endif>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Staff Email</label>
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="" @if($staffList['id']!="") disabled="" @else  @endif name="email" placeholder="Enter Email"
                          @if(!empty($staffList['email']))
                                   value="{{ $staffList['email'] }}"  @else value="{{ old('email') }}" @endif>
                          @error('email')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Staff Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="" @if($staffList['id']!="") disabled="" @else  @endif placeholder="Enter Password" name="password" 
                            @if(!empty($staffList['password']))
                                     value="{{ $staffList['password'] }}"  @else value="{{ old('password') }}" @endif>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        <div class="form-group">
                            <label for="type">Select Role </label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                              <option value="">Select Role Of Staff</option>
                              <option value="BarChasier" @if(isset($staffList['type']) && $staffList['type']=="BarChasier" ) selected @endif>BarChasier</option>
                                <option value="Waiter" @if(isset($staffList['type']) && $staffList['type']=="Waiter" ) selected @endif>Waiter</option>
                                <option value="Kitchen-Manager" @if(isset($staffList['type']) && $staffList['type']=="Kitchen-Manager" ) selected @endif>Kitchen-Manager</option>
                                <option value="store-manager" @if(isset($staffList['type']) && $staffList['type']=="store-manager" ) selected @endif>store-manager</option>
                                <option value="Cashier" @if(isset($staffList['type']) && $staffList['type']=="Cashier" ) selected @endif>Cashier</option>
                                <option value="DeliveryBoy" @if(isset($staffList['type']) && $staffList['type']=="DeliveryBoy" ) selected @endif>DeliveryBoy</option>
                            </select>
                            @error('type')
                            <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>

                          <div class="form-group">
                            <label for="exampleInputEmail1">Staff Mobile</label>
                            <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="" placeholder="Enter Mobile" name="mobile" 
                            @if(!empty($staffList['mobile']))
                                     value="{{ $staffList['mobile'] }}"  @else value="{{ old('mobile') }}" @endif>
                            @error('mobile')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Staff Address</label>
                               <textarea name="address" class="form-control  @error('address') is-invalid @enderror">{{ $staffList['address'] }}</textarea>
                               @error('address')
                               <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                          </div>
                          <div class="form-group">
                            <label for="aadhar">Aadhar Docoument</label>
                            <input type="file" class="form-control @error('aadhar') is-invalid @enderror" accept="application/pdf" name="aadhar" id="aadhar" @if(!empty($staffList['aadhar'])) value="{{ $staffList['aadhar'] }}" @else value="{{ old('aadhar') }}" @endif @if($staffList['id']!="") disabled="" @else  @endif    >
                            <a target="_blank" href="{{ url('admin_assets/uploads/aadhar/'.$staffList['aadhar']) }}">View Adhar</a>&nbsp;&nbsp;
                            <a target="_blank" download="" href="{{ url('admin_assets/uploads/aadhar/'.$staffList['aadhar']) }}">Download Adhar</a>&nbsp;&nbsp;
                            @error('aadhar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </div>

                      </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/')}}/admin/staffs" class="btn btn-secondary">Back</a>
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
    
