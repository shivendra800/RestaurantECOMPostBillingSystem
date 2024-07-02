@extends('admin.layouts.layout')
@section('title','Dashboard')


    


@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
  <h4>Purchase Inventory Product Amount Of Current Year According To Month Wise</h4>
  <canvas id="myChart" height="100px"></canvas>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Invertory Current Stock List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Current Stock</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getinvtstk as $index=>$ingredient)
                        <tr id="tr_{{$ingredient['id']}}">
                       
                        <td>{{$index+1}}</td>
                        <td>{{$ingredient['ingredient_name']}}</td>
                        <td style="color:red;">{{$ingredient['purchase_Wtstock']}} {{$ingredient['unit']['unit_name']}}</td>
             
                        
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
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Invertory Low Level  Stock Alert List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
              aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Low Stock Alert</th>
                  <th>Current Stock</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getinvtstk as $index=>$ingredient)
                      @if($ingredient['min_qty']>=$ingredient['purchase_Wtstock'])
                        <tr>
                       
                        <td>{{$index+1}}</td>
                        <td>{{$ingredient['ingredient_name']}}</td>
                        <td style="color:red;"><strong>{{$ingredient['min_qty']}}</strong></td>
                        <td style="color:orange;">{{$ingredient['purchase_Wtstock']}} {{$ingredient['unit']['unit_name']}}</td>
             
                        
                </tr>
                @endif
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

  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kitchen Current   Stock </h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        

                            <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Prdouct Name</th>
                                  <th>Product Unit</th>
                                  <th>Consumtion Qty</th>
                                </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach ($getKitchenStock as $index=>$KitchenStock)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                         <td>{{$KitchenStock['product']['ingredient_name']}}</td>
                                         <td>{{$KitchenStock['unit']['unit_name']}}</td>
                                         <td>{{$KitchenStock['consumption_qty']}}
                                        </td>
                                    </tr>
                                </form>
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



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
<script type="text/javascript">
  
      var labels =  {{ Js::from($labels) }};
      var users =  {{ Js::from($data) }};
  
      const data = {
        labels: labels,
        datasets: [{
          label: 'Grand Total Amount According To Month Wise',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users,
        }]
      };
  
      const config = {
        type: 'bar',
        data: data,
        options: {}
      };
  
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
  
</script>
    
@endsection
