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

  <section class="content">
    <div class="container-fluid">
            <!-------- Take Way Order Day Wise  Sale Graph Start   --------------->

            <a href="{{ url('/admin/today-Take-away-order') }}"class="btn btn-warning" >View Details</a>

    <div class="col-md-12">
        <h3 class="text-center">Take Way Order Day Wise  Sale Graph  </h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4>Take Way Order Day Wise Sale Report  </h4>
                    <div class="d-flex">
                        
                        <canvas id="DayWisetakeaway" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>
  
        <!-------- Take Way Order Day Wise  Sale Graph End   --------------->
        
         <!-------- Take Way Order Month Wise  Sale Graph Start   --------------->
  
      <div class="col-md-12">
        <h3 class="text-center">Take Way Order Month Wise  Sale Graph  </h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4>Take Way Order Month Wise Sale Report  </h4>
                    <div class="d-flex">
                        
                        <canvas id="feeChart" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>
  
        <!-------- Take Way Order Month Wise  Sale Graph End   --------------->
  
       <!-------- Take Way Order Year Wise  Sale Graph Start   --------------->
    <div class="col-md-12">
      <h3 class="text-center">Take Way Order Year  Sale  </h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
                  <h4>Take Way Order Year  Sale  </h4>
                  <div class="d-flex">
                      
                      <canvas id="TakeWayYearChart" height="100px"></canvas>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
  
      <!-------- Take Way Order Month Wise  Sale Graph End   --------------->
  
     
    
      <!-------- Take Way Order Item   Sale Graph Start   --------------->
      <div class="col-md-12">
        <h3 class="text-center">Item Sale Take Way Wise Report</h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <div class="d-flex">    
                      <div id="barchartTopSaleTk" style="width: 1000px; height: 300px"></div>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>
   <!-------- Take Way Order Item   Sale Graph End   --------------->
    </div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <script type="text/javascript">

        /// Take Way DayWise Graph

        var daywisetakeawaylabels = {{ Js::from($daywisetakeawaylabels) }};
      var daywisetakeawaydata = {{ Js::from($daywisetakeawaydata) }};

      const dataDayWisePurchInv = {
          labels: daywisetakeawaylabels,
          datasets: [{
              label: 'Take Way Order ',
              backgroundColor: 'rgb(0, 191, 255)',
              borderColor: 'rgb(0, 191, 255)',
              data: daywisetakeawaydata,
          }]
      };

      const configDayWisePurchInv = {
          type: 'bar',
          data: dataDayWisePurchInv,
          options: {}
      };

      const DayWisetakeaway = new Chart(
          document.getElementById('DayWisetakeaway'),
          configDayWisePurchInv
      );

      
       
           /////////////// TakeWay Order month Wise

      var takeWayOrderlabels = {{ Js::from($takeWayOrderlabels) }};
      var takeWayOrderdata = {{ Js::from($takeWayOrderdata) }};

      const datafee = {
          labels: takeWayOrderlabels,
          datasets: [{
              label: 'Take Way Order ',
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
              data: takeWayOrderdata,
          }]
      };

      const configfee = {
          type: 'line',
          data: datafee,
          options: {}
      };

      const feeChart = new Chart(
          document.getElementById('feeChart'),
          configfee
      );

        ////  TakeWay Order Year Sale

        var TakeWayYearSalelabels = {{ Js::from($TakeWayYearSalelabels) }};
        var TakeWayYearSaledata = {{ Js::from($TakeWayYearSaledata) }};

        const dataTakeWayYear = {
            labels: TakeWayYearSalelabels,
            datasets: [{
                label: 'Take Way Order Year Sale ',
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
                data: TakeWayYearSaledata,
            }]
        };

        const configTakeWayYear = {
            type: 'bar',
            data: dataTakeWayYear,
            options: {}
        };

        const TakeWayYearChart = new Chart(
            document.getElementById('TakeWayYearChart'),
            configTakeWayYear
        );
 
    
  </script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
     ///     Menu Item of Take Way Order Sale Start-------------------------
 var topsalesTak = <?php echo $topsalesTak; ?>;
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTopSaleTk);
      function barchartTopSaleTk() {
          var data = google.visualization.arrayToDataTable(topsalesTak);
          var options = {
              title: 'Menu Item Wise Sale',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.BarChart(document.getElementById('barchartTopSaleTk'));
          chart.draw(data, options);
      } 

 ///     Menu Item of Take Way Order Sale End-------------------------
</script>

  @endsection