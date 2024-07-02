@extends('admin.layouts.layout')
@section('title','Bar Sell Report ')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Bar Sell Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <h4>Bar Sell Report Price</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>Today Bar Sell Report</label>
                            <br>
                             <strong class="text-center bg-danger p-1">Rs.{{ $totalitemfreeDay }} </strong>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>This Month Bar Sell Report</label>
                            <br>
                             <strong class="text-center bg-danger p-1">Rs.{{ $totalitemfreeMonth }}</strong>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              <div class="card text-center">
                  <div class="card-body">
                      <div class="form-group bg-warning p-2">
                          <label>This Year Bar Sell Report</label>
                          <br>
                          <strong class="text-center bg-danger p-1">Rs.{{ $totalitemfreeYear }}</strong>
                          
                      </div>
                     
                  </div>
              </div>
          </div>
        </div>
        <hr>

        

       
       
    <!-- /.container-fluid -->
    </div>
</section>
<!-- /.content -->



@endsection
