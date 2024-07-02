@extends('admin.layouts.layout')
@section('title','Table Order Dashboard')
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
            <li class="breadcrumb-item active">Table Order Dashboard </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
        <a href="{{ url('/admin/table-orders') }}" class="btn btn-warning">View Details</a>
      <!-------- Table Order Date Wise  Sale Graph Start   --------------->
      <div class="col-md-12">
        <h3 class="text-center">Table Order  Sale Of Current Month According To Date Wise</h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4>Table Order Day Wise Sale </h4>
                    <div class="d-flex">
                        
                        <canvas id="TableDayChart" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>

            <!-------- Table Order Date Wise  Sale Graph End   --------------->

      <!-------- Table Order Month Wise  Sale Graph Start   --------------->
      <div class="col-md-12">
        <h3 class="text-center">Table Order  Sale Of Current Year According To Month Wise</h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4>Table Order  Sale </h4>
                    <div class="d-flex">
                        
                        <canvas id="myChart" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>

            <!-------- Table Order Month Wise  Sale Graph End   --------------->
      <!-------- Table Order Year Wise  Sale Graph Start   --------------->
      <div class="col-md-12">
        <h3 class="text-center">Table Order  Year Wise Sale </h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4>Table Order Year  Sale </h4>
                    <div class="d-flex">
                        
                        <canvas id="TableYearChart" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>

            <!-------- Table Order Year Wise  Sale Graph End   --------------->

               <!-------- Table Order Item  Sale Graph Start   --------------->

            <div class="col-md-12">
              <h3 class="text-center">Item Sale  Table Wise Report</h3>
                <div class="col-md-12 col-md-offset-2">
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-body">
                          <div class="d-flex">    
                            <div id="barchartTopSale" style="width: 1000px; height: 300px"></div>
                          </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>	
            </div>
                 <!-------- Table Order Item  Sale Graph End   --------------->
    </div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <script type="text/javascript">

     // Table Order DayWise Graph
     var daywisetablelabels = {{ Js::from($daywisetablelabels) }};
        var daywisetabledata = {{ Js::from($daywisetabledata) }};

        const dataTableDay = {
            labels: daywisetablelabels,
            datasets: [{
                label: 'Table Order Year Sale ',
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                data: daywisetabledata,
            }]
        };

        const configTableDay = {
            type: 'bar',
            data: dataTableDay,
            options: {}
        };

        const TableDayChart = new Chart(
            document.getElementById('TableDayChart'),
            configTableDay
        );
   

   ////  Table Order Monthwise Sale
    
        var labels =  {{ Js::from($labels) }};
        var users =  {{ Js::from($data) }};
    
        const data = {
          labels: labels,
          datasets: [{
            label: 'Grand Total Amount  According To Month Wise',
            backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            data: users,
          }]
        };
    
        const config = {
          type: 'line',
          data: data,
          options: {}
        };
    
        const myChart = new Chart(
          document.getElementById('myChart'),
          config
        );


        ////  Table Order Year Sale

        var TableYearSalelabels = {{ Js::from($TableYearSalelabels) }};
        var TableYearSaledata = {{ Js::from($TableYearSaledata) }};

        const dataTableYear = {
            labels: TableYearSalelabels,
            datasets: [{
                label: 'Table Order Year Sale ',
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                data: TableYearSaledata,
            }]
        };

        const configTableYear = {
            type: 'bar',
            data: dataTableYear,
            options: {}
        };

        const TableYearChart = new Chart(
            document.getElementById('TableYearChart'),
            configTableYear
        );

    
  </script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
   ///     Menu Item of Table Order Sale Start-------------------------
   var topsales = <?php echo $topsales; ?>;
      console.log(topsales);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTopSale);
      function barchartTopSale() {
          var data = google.visualization.arrayToDataTable(topsales);
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