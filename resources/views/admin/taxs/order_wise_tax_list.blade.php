@extends('admin.layouts.layout')
@section('title','Order Tax Report')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> {{Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        
      <div class="row mb-2">
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Order Tax Report</li>
          </ol>
        </div>
      </div>
      <div class="row mb-2">

        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-calculator"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Order Tax Report</span>
                <span class="info-box-number">Total Order Tax Percentage-:<strong  style="color:red;">{{ $totalTaxPercOrdersale }}%</strong></span>
                <span class="info-box-number">Total Order Tax Collection-Rs-<strong style="color:red;">{{ $totalTaxOrdersale }}</strong></span>
              </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-calculator"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Today Order Tax Report </span>
                <span class="info-box-number">Total Order Tax Percentage-:<strong style="color:red;">{{ $todayTaxPercsale }}%</strong></span>
                <span class="info-box-number">Total Order Tax Collection-Rs-<strong style="color:red;">{{ $todayTaxsale }}</strong></span>
              </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-calculator"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Monthly Order Tax Report</span>
                <span class="info-box-number">Total Order Tax Percentage-:<strong style="color:red;">{{ $MonthsTaxPercsale }}%</strong></span>
                <span class="info-box-number">Total Order Tax Collection-Rs-<strong style="color:red;">{{ $MonthsTaxsale }}</strong></span>
              </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-calculator"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Yearly Order Tax Report</span>
                <span class="info-box-number">Total Order Tax Percentage-:<strong style="color:red;">{{ $YearTaxPercsale }}%</strong> </span>
                <span class="info-box-number">Total Order Tax Collection-Rs-<strong style="color:red;">{{ $YearTaxsale }}</strong></span>
              </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
      <h3 class="text-center">Tax Month Report Of Day Wise</h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
                  <h4>Day Wise Tax Graph  </h4>
                  <div class="d-flex">    
                    <div id="barchartTaxDay" style="width: 1000px; height: 300px"></div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
  
    <div class="col-md-12">
      <h3 class="text-center">Tax Of Current  Year Report  Of Months Wise</h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
                  <h4>Month Wise Tax Graph  </h4>
                  <div class="d-flex">    
                    <div id="barchartTaxMonth" style="width: 1000px; height: 300px"></div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
  
    <div class="col-md-12">
      <h3 class="text-center">Tax  Year Wise Report</h3>
        <div class="col-md-12 col-md-offset-2">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="card-body">
                  <h4>Year Wise Tax Graph  </h4>
                  <div class="d-flex">    
                    <div id="barchartTaxYear" style="width: 1000px; height: 300px"></div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>	
    </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Order Tax Report List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>Order No</th>
                  <th>Tax Name</th>
                  <th>Tax Percentage</th>
                  <th>Tax Amount</th>
                  <th>Order Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($ordertax as $index=>$taxList)
                        <tr>
                       
                        <td>{{$index+1}}</td>
                        <td>{{$taxList['order_no']}}</td>
                        <td>{{$taxList['tax_name']}}</td>
                        <td>{{$taxList['tax_percentage']}}%</td>
                        <td>{{$taxList['tax_amount']}}</td>
                        <td class="btn btn-info">{{ \Carbon\Carbon::parse($taxList->created_at)->isoFormat('MMM Do YYYY')}}</td>
                      
                     
                        
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
  <!-- /.content -->

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

     ///   Tax Day  Wise Graph

     var orderwiseTaxDateWise = <?php echo $orderwiseTaxDateWise; ?>;
      console.log(orderwiseTaxDateWise);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTaxDay);
      function barchartTaxDay() {
          var data = google.visualization.arrayToDataTable(orderwiseTaxDateWise);
          var options = {
              title: 'Order Wise Day Tax',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.LineChart(document.getElementById('barchartTaxDay'));
          chart.draw(data, options);
      }   
      
         ///   Tax Month  Wise Graph

         var orderwiseTaxMonthWise = <?php echo $orderwiseTaxMonthWise; ?>;
      console.log(orderwiseTaxMonthWise);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTaxMonth);
      function barchartTaxMonth() {
          var data = google.visualization.arrayToDataTable(orderwiseTaxMonthWise);
          var options = {
              title: 'Order Wise Month Tax',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.LineChart(document.getElementById('barchartTaxMonth'));
          chart.draw(data, options);
      } 

      
         ///   Tax Year  Wise Graph

         var orderwiseTaxYearWise = <?php echo $orderwiseTaxYearWise; ?>;
      console.log(orderwiseTaxYearWise);
      google.charts.load('current', {
          'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(barchartTaxYear);
      function barchartTaxYear() {
          var data = google.visualization.arrayToDataTable(orderwiseTaxYearWise);
          var options = {
              title: 'Order Wise Year Tax',
              curveType: 'function',
              legend: {
                  position: 'bottom'
              }
          };
          var chart = new google.visualization.BarChart(document.getElementById('barchartTaxYear'));
          chart.draw(data, options);
      } 


</script>

@endsection
