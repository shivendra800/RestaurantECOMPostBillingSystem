@extends('admin.layouts.layout')
@section('title','Free Order Item ')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Free Order Item</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="col-md-4">
    <div class="card ">
        <div class="card-body text-center ">
            <div class="form-group bg-info p-2">
                <label>Menu Item Name</label>
                <br>
                 <strong class="text-center bg-danger p-1">{{ $menuitemlt['menu_item_name'] }} </strong>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <h4>Free Item Qty Total</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>Today Free Item Total</label>
                            <br>
                             <strong class="text-center bg-danger p-1">{{ $totalitemfreeDay }} Free Item</strong>
                        </div>
                        <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>This Month Free Item Total</label>
                            <br>
                             <strong class="text-center bg-danger p-1">{{ $totalitemfreeMonth }} Free Item</strong>
                        </div>
                        <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              <div class="card text-center">
                  <div class="card-body">
                      <div class="form-group bg-warning p-2">
                          <label>This Year Free Item Total</label>
                          <br>
                          <strong class="text-center bg-danger p-1">{{ $totalitemfreeYear }} Free Item</strong>
                          
                      </div>
                      <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
        </div>
        <hr>

        <div class="row">
            <h4>Free Item  Total Price</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>Today Free Item Total</label>
                            <br>
                             <strong class="text-center bg-danger p-1">{{ $totalitemfreeAmtDay }} </strong>
                        </div>
                        <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group bg-warning p-2">
                            <label>This Month Free Item Total</label>
                            <br>
                             <strong class="text-center bg-danger p-1">{{ $totalitemfreeAmtMonth }} </strong>
                        </div>
                        <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              <div class="card text-center">
                  <div class="card-body">
                      <div class="form-group bg-warning p-2">
                          <label>This Year Free Item Total</label>
                          <br>
                          <strong class="text-center bg-danger p-1">{{ $totalitemfreeAmtYear }} </strong>
                          
                      </div>
                      <a href="{{ url('admin/Total-Loss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
