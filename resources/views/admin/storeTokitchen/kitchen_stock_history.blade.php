@extends('admin.layouts.layout')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Kitchen Stock Add Histroy</h3>
            </div>
            <!-- /.card-header -->

            <div class="card card-primary card-outline">
              <h2 class="btn btn-warning">Search Data Of Kitchen Stock Add Histroy</h2>
              <div class="card-header">
                 <form action="{{ url('/admin/date-wise-serach-KitchenStockHistroy') }}" method="post">
                  @csrf
                  <div class="row">
                      <div class="col-md-4">
                          <input type="date" name="start_date" class="form-control" placeholder="Enter Start Date" value="{{ Request::get('start_date')  }}" required>
                      </div>
                      <div class="col-md-4">
                          <input type="date" name="end_date" class="form-control" placeholder="Enter End Date" value="{{ Request::get('end_date')  }}" required>
                      </div>
                      <div class="col-md-4">
                        <select class="form-control" name="product_name"   >
                          <option value=""> Select Name</option>
                          @foreach ($getingredient as  $nameindr )
                          <option value="{{ $nameindr['id'] }}" {{ Request::get('product_name') == $nameindr['id'] ? 'selected':'' }} >{{ $nameindr['ingredient_name'] }}</option>

    
                          @endforeach
                        </select>
                    </div>
                      <div class="col-md-4 mt-1">
                          <button type="submit">Search</button>
                      </div>

                  </div> 


                 </form>
              </div>
          </div>
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Product Name</th>
                  <th>Product Unit</th>
                  <th>Kitchen Stock</th>
                  <th>Stock Add Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getKitchenStock as $index=>$item)
                         <tr>
                            <td>{{$index+1}}</td>
                            <td>{{ $item['product']['ingredient_name'] }}</td>
                            <td>{{ $item['unit']['unit_name'] }}</td>
                            <td>{{ $item['consumption_qty'] }}</td>
                            <td  style="color: blue;">{{ \Carbon\Carbon::parse($item['created_at'])->isoFormat('MMM Do YYYY')}}</td>
                         </tr>                                                                
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