@extends('admin.layouts.layout')

@section('title',$title.'Table Booking')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Unit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}-Table Booking</li>
            
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
                    <h3 class="card-title">{{$title}} Table Booking</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="forms-sample" @if(empty($tablebook['id'])) action="{{ url('admin/add-edit-TableBooking') }}"
                            @else action="{{ url('admin/add-edit-TableBooking/'.$tablebook['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Cust Name</label>
                        <input type="text" class="form-control @error('cust_name') is-invalid @enderror" id="" placeholder="Enter Customer Name" name="cust_name" 
                        @if(!empty($tablebook['cust_name']))
                                 value="{{ $tablebook['cust_name'] }}"  @else value="{{ old('cust_name') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('cust_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Cust Email</label>
                        <input type="email" class="form-control @error('cust_email') is-invalid @enderror" id="" placeholder="Enter Customer Email" name="cust_email" 
                        @if(!empty($tablebook['cust_email']))
                                 value="{{ $tablebook['cust_email'] }}"  @else value="{{ old('cust_email') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('cust_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Cust Phone</label>
                        <input type="number" class="form-control @error('cust_phone') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="cust_phone" 
                        @if(!empty($tablebook['cust_phone']))
                                 value="{{ $tablebook['cust_phone'] }}"  @else value="{{ old('cust_phone') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('cust_phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Booking Date</label>
                        
                        @if(!empty($tablebook['table_booking_date'])) 
                        <input type="text" class="form-control @error('table_booking_date') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="table_booking_date" 
                                 value="{{ $tablebook['table_booking_date'] }}" @if($tablebook['id']!="") disabled=""  @endif>

                                   @else
                                   <input type="date" class="form-control @error('table_booking_date') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="table_booking_date" 
                                    value="{{ old('table_booking_date') }}">
                                   
                                     @endif
                        @error('table_booking_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Booking In Time</label>
                        
                        <input type="text" class="form-control @error('table_booking_time') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="table_booking_time" 
                        @if(!empty($tablebook['table_booking_time']))
                                 value="{{ $tablebook['table_booking_time'] }}"  @else value="{{ old('table_booking_time') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('table_booking_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Booking Out Time</label>
                        <input type="text" class="form-control @error('table_booking_timeout') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="table_booking_timeout" 
                        @if(!empty($tablebook['table_booking_timeout']))
                                 value="{{ $tablebook['table_booking_timeout'] }}"  @else value="{{ old('table_booking_timeout') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('table_booking_timeout')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Table Type</label>
                        <select name="table_type"  class="form-control">
                          <option value="">Select Table Type</option>
                          <option
                              @if ($tablebook != null) @if ($tablebook->table_type == 'Center Table') 
                              value="{{ $tablebook->table_type = 'Center Table' }}" selected @endif
                          @else @if (old('table_type') == 'Center Table') selected @endif @endif
                           value="Center Table">Center Table</option>

                          <option @if ($tablebook != null) @if ($tablebook->table_type == 'Front Table') 
                            value="{{ $tablebook->table_type = 'Front Table' }}" selected @endif
                        @else @if (old('table_type') == 'Front Table') selected @endif @endif
                         value="Front Table">Front Table</option>

                          <option @if ($tablebook != null) @if ($tablebook->table_type == 'Side Table') 
                            value="{{ $tablebook->table_type = 'Side Table' }}" selected @endif
                        @else @if (old('table_type') == 'Side Table') selected @endif @endif
                         value="Side Table">Side Table</option>

                          <option @if ($tablebook != null) @if ($tablebook->table_type == 'Left Corner Table') 
                            value="{{ $tablebook->table_type = 'Left Corner Table' }}" selected @endif
                        @else @if (old('table_type') == 'Left Corner Table') selected @endif @endif
                         value="Left Corner Table">Left Corner Table</option>

                          <option @if ($tablebook != null) @if ($tablebook->table_type == 'Right Corner Table') 
                            value="{{ $tablebook->table_type = 'Right Corner Table' }}" selected @endif
                        @else @if (old('table_type') == 'Right Corner Table') selected @endif @endif
                         value="Right Corner Table">Right Corner Table</option>
                       

                      </select>
                        @error('no_person')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">No Of Person</label>
                        <input type="number" class="form-control @error('no_person') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="no_person" 
                        @if(!empty($tablebook['no_person']))
                                 value="{{ $tablebook['no_person'] }}"  @else value="{{ old('no_person') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('no_person')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Message</label>
                        <input type="text" class="form-control @error('message') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="message" 
                        @if(!empty($tablebook['message']))
                                 value="{{ $tablebook['message'] }}"  @else value="{{ old('message') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Payment ID</label>
                        <input type="text" class="form-control @error('payment_id') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="payment_id" 
                        @if(!empty($tablebook['payment_id']))
                                 value="{{ $tablebook['payment_id'] }}"  @else value="{{ old('payment_id') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('payment_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Payment Amount</label>
                        <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" id="" placeholder="Enter Customer Phone" name="payment_amount" 
                        @if(!empty($tablebook['payment_amount']))
                                 value="{{ $tablebook['payment_amount'] }}"  @else value="{{ old('payment_amount') }}" @endif @if($tablebook['id']!="") disabled=""  @endif>
                        @error('payment_amount')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label>Change Table Booking Status</label>
                        <select name="table_booking_status" id="" class="form-control"  >
                            <option value="">Select Table Booking</option>
                            <option
                                @if ($tablebook != null) @if ($tablebook->table_booking_status == 'Request For Table Booking') value="{{ $tablebook->table_booking_status == 'Request For Table Booking' }}" selected @endif
                            @else @if (old('table_booking_status') == 'Request For Table Booking') selected @endif @endif value="Request For Table Booking">Request For Table Booking</option>
                            <option
                                @if ($tablebook != null) @if ($tablebook->table_booking_status == 'Table Booking Confirm') value="{{ $tablebook->table_booking_status == 'Table Booking Confirm' }}" selected @endif
                            @else @if (old('table_booking_status') == 'Table Booking Confirm') selected @endif @endif value="Table Booking Confirm">Table Booking Confirm</option>

                        </select>
                        @error('table_booking_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                      
                      
                     
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
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
    
