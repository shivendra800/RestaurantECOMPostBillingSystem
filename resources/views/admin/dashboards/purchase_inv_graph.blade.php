@extends('admin.layouts.layout')
@section('title','Purchase Inventory Graph')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Purchase Inventory Graph</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
            <!-------------------   Purchase Inv Total Bill Start ------------------------------------------>

            <div class="row">
              <div class="col-lg-12 ">
                  <h3>Purchase Inventory Total Bill</h3>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{round($todayTotalBill, 2)}}</h3>
  
                          <p>Today Purchase Total Bill</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{round($MonthsTotalBill, 2)}}</h3>
  
                          <p>This Month Purchase Total Bill</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{round($YearTotalBill, 2)}}</h3>
  
                          <p>This Year Purchase Total Bill</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
          <hr>
  
  
          <!--------------   Purchase Inv Total Bill End ---------------------------------->
  
          <!-------------------   Purchase Inv Paid Amount Start ------------------------------------------>
  
          <div class="row">
              <div class="col-lg-12 ">
                  <h3>Purchase Inventory Paid Amount</h3>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{round($todayPaidAtm, 2)}}</h3>
  
                          <p>Today Purchase Paid Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{round($MonthsPaidAtm, 2)}}</h3>
  
                          <p>This Month Purchase Paid Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{round($YearPaidAtm, 2)}}</h3>
  
                          <p>This Year Purchase Paid Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
          <hr>
  
  
          <!--------------   Purchase Inv Paid Amount End ---------------------------------->
  
          <!-------------------   Purchase Inv Reaming Amount Start ------------------------------------------>
  
          <div class="row">
              <div class="col-lg-12 ">
                  <h3>Purchase Inventory Reaming Amount</h3>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{round($todayReamingAtm, 2)}}</h3>
  
                          <p>Today Purchase Reaming Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{round($MonthsReamingAtm, 2)}}</h3>
  
                          <p>This Month Purchase Reaming Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{round($YearReamingAtm, 2)}}</h3>
  
                          <p>This Year Purchase Reaming Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
          <hr>
  
  
          <!--------------   Purchase Inv Reaming Amount End ---------------------------------->
  
          <!-------------------   Purchase Inv Previous Amount Start ------------------------------------------>
  
          <div class="row">
              <div class="col-lg-12 ">
                  <h3>Purchase Inventory Previous Amount</h3>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{round($todayPreviousAtm, 2)}}</h3>
  
                          <p>Today Purchase Previous Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{round($MonthsPreviousAtm, 2)}}</h3>
  
                          <p>This Month Purchase Previous Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{round($YearPreviousAtm, 2)}}</h3>
  
                          <p>This Year Purchase Previous Amount</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ url('admin/purchase-inv-product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
          <hr>
  
  
          <!--------------   Purchase Inv Previous Amount End ---------------------------------->
        <div class="row">
            <div class="col-12">


           <!------------------------------  Purchase Invt. Product Start ------------------------>
  <section class="content">
    <div class="container-fluid">
  <div class="col-md-12">
    <h3 class="text-center">Purchase Inventory Product Day Wise Sale Graph</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
                <h4>Day Wise Purchase Inv. Graph  </h4>
                <div class="d-flex">    
                  <div id="barchart" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>

  <div class="col-md-12">
    <h3 class="text-center">Purchase Inventory Product Month Wise Sale Graph</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
                <h4>Current Year Month Wise Purchase Inv. Graph </h4>
                <div class="d-flex">    
                  <div id="Monthchart" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>

  <div class="col-md-12">
    <h3 class="text-center">Purchase Inventory Product Year Wise Sale Graph</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
                <h4>Overall Year Wise Purchase Inv. Graph</h4>
                <div class="d-flex">    
                  <div id="linechart" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>

  <div class="col-md-12">
    <h3 class="text-center">Overall Item   Purchase Inventory   Graph</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
                <div class="d-flex">    
                  <div id="linechartitem" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>
  <hr>


  <!--------------------    Purchase Inv .Product End --------------------------------->
            
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


<!-----  Purchase Inventory Sale Graph   Start -------------------------------->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

  ///   Purchase Year Wise Graph
      var PurchaseInvProd = <?php echo $PurchaseInvProd; ?>;
      console.log(PurchaseInvProd);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(lineChart);
      function lineChart() {
          var data = google.visualization.arrayToDataTable(PurchaseInvProd);
          var options = {
              title: 'Purchase Inventory Product',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.BarChart(document.getElementById('linechart'));
          chart.draw(data, options);
      }  

 ///   Purchase Month  Wise Graph
      var PurchaseInvProdMonth = <?php echo $PurchaseInvProdMonth; ?>;
      console.log(PurchaseInvProdMonth);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(Monthchart);
      function Monthchart() {
          var data = google.visualization.arrayToDataTable(PurchaseInvProdMonth);
          var options = {
              title: 'Purchase Inventory Product',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.LineChart(document.getElementById('Monthchart'));
          chart.draw(data, options);
      }    

       ///   Purchase Day  Wise Graph

      var PurchaseInvProdDayWise = <?php echo $PurchaseInvProdDayWise; ?>;
      console.log(PurchaseInvProdDayWise);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchart);
      function barchart() {
          var data = google.visualization.arrayToDataTable(PurchaseInvProdDayWise);
          var options = {
              title: 'Purchase Inventory Product',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.LineChart(document.getElementById('barchart'));
          chart.draw(data, options);
      }   

      var PurchaseInvitem = <?php echo $PurchaseInvitem; ?>;
      console.log("ffff",PurchaseInvitem);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(lineChartssss);
      function lineChartssss() {
          var data = google.visualization.arrayToDataTable(PurchaseInvitem);
          var options = {
              title: 'Purchase Inventory Product Item',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.LineChart(document.getElementById('linechartitem'));
          chart.draw(data, options);
      }  


  </script>

@endsection
