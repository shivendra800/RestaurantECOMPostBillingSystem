@extends('admin.layouts.layout')
@section('title','Total Copuon Loss')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Coupon Total Coupon Loss</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">


                <div class="col-md-12">
                    <h3 class="text-center">Table Order  Sale Of Current Month According To Date Wise</h3>
                      <div class="col-md-12 col-md-offset-2">
                        <div class="col-xl-12">
                          <div class="card">
                            <div class="card-body">
                              <div class="card-body">
                                <h4>Table Order Day Wise Sale </h4>
                                <div class="d-flex">
                                    
                                    <div id="barchartTopSale" style="width: 1000px; height: 300px"></div>
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>	
                  </div>
            
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

 ///     Menu Item of Table Order Sale Start-------------------------
 var orderitemsaleTable = <?php echo $orderitemsaleTable; ?>;
      console.log(orderitemsaleTable);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTopSale);
      function barchartTopSale() {
          var data = google.visualization.arrayToDataTable(orderitemsaleTable);
          var options = {
              title: 'Menu Item Wise Sale',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.BarChart(document.getElementById('barchartTopSale'));
          chart.draw(data, options);
      } 

 ///     Menu Item of Table Order Sale End-------------------------


  </script>

@endsection
