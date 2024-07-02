@extends('admin.layouts.layout')
@section('title','Kitchen Stock Graph')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kitchen Stock Graph</li>
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

 <!-------------- Kitchen  Waste Log  Start  -------------------->


 <div class="row">
    <div class="col-md-6">
      <h3 class="text-center">Yearly Wise Kitchen Waste  Report</h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
                
                  <div class="d-flex">    
                    <div id="piechart_3d" style="width: 1000px; height: 300px"></div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
    <div class="col-md-6">
      <h3 class="text-center"> Monthly Wise Kitchen Waste  Report</h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
               
                  <div class="d-flex">    
                    <div id="kitechenwastelogmonthly" style="width: 1000px; height: 300px"></div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
  </div>


        <!-------------- Kitchen  Waste Log  End  -------------------->

        
    <!-------------- Kitchen  UseStock Log  Start  -------------------->


<div class="row">
  <div class="col-md-6">
    <h3 class="text-center">Yearly Wise Kitchen UseStock  Report</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
              
                <div class="d-flex">    
                  <div id="KitchenUseStockyear" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>
  <div class="col-md-6">
    <h3 class="text-center"> Monthly Wise Kitchen UseStock  Report</h3>
      <div class="col-md-12 col-md-offset-2">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="card-body">
               
                <div class="d-flex">    
                  <div id="kitechenusemonthly" style="width: 1000px; height: 300px"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>	
  </div>
</div>


      <!-------------- Kitchen  UseStock Log  End  -------------------->

            
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
   
   <!-------------- Kitchen  Waste Log  Start  -------------------->
   
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
  
        var data = google.visualization.arrayToDataTable({{ Js::from($result) }});
  
        var options = {
          title: 'Yearly Kitchen Waste Graph',
          is3D: true,
        };
  
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable({{ Js::from($resultmonthkitwastelog) }});

    var options = {
      title: 'Kitchen Waste Monthly',
      is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('kitechenwastelogmonthly'));
    chart.draw(data, options);
  }
</script>


    <!-------------- Kitchen  Waste Log  End  -------------------->

    <!-------------- Kitchen  Use Stock Log  Start  -------------------->


    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
  
        var data = google.visualization.arrayToDataTable({{ Js::from($resultmonthkuselog) }});
  
        var options = {
          title: 'Kitchen UseStock Monthly',
          is3D: true,
        };
  
        var chart = new google.visualization.PieChart(document.getElementById('kitechenusemonthly'));
        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable({{ Js::from($YearStockKit) }});

    var options = {
      title: 'Kitchen Waste Monthly',
      is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('KitchenUseStockyear'));
    chart.draw(data, options);
  }
</script>

 <!-------------- Kitchen  Use Stock Log  End  -------------------->

@endsection
