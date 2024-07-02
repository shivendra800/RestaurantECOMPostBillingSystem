@extends('admin.layouts.layout')
@section('title','Table Booking Graph')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Table Booking Graph</li>
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
     <!-- Table Booking Amount (Stat box) -->
     <div class="row">
        <div class="col-lg-12 ">
          <h3>Table Booking Amount</h3>
        </div>
      </div>
       <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{round($totalTableBookingAmt, 2)}}</h3>

              <p>Overall Table Booking Amount </p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-booking-confirm') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{round($todayTableBookingAmt, 2)}}</h3>

              <p>Today Table Booking Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-booking-confirm') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{round($MonthsTableBookingAmt, 2)}}</h3>

              <p>This Month Table Booking Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-booking-confirm') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{round($YearTableBookingAmt, 2)}}</h3>

              <p>This Year Table Booking Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('admin/table-booking-confirm') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>


       <!-------- Table Order Date Wise  Sale Graph Start   --------------->
       <div class="col-md-12">
        <h3 class="text-center">Table Booking  Sale Of Current Month According To Date Wise</h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
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
            <h3 class="text-center">Table Booking  Sale Of Current Year According To Month Wise</h3>
              <div class="col-md-12 col-md-offset-2">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-body">
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
            <h3 class="text-center">Table Booking  Year Wise Sale </h3>
              <div class="col-md-12 col-md-offset-2">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-body">
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
    

            
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
<script type="text/javascript">


   // Table Booking DayWise Graph
   var daywisetableBookinglabels = {{ Js::from($daywisetableBookinglabels) }};
      var daywisetableBookingdata = {{ Js::from($daywisetableBookingdata) }};

      const dataTableDay = {
          labels: daywisetableBookinglabels,
          datasets: [{
              label: 'Table Booking Day Wise ',
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
              data: daywisetableBookingdata,
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
 

 ////  Table Booking Monthwise Sale
  
      var stablebookorderSumlabels =  {{ Js::from($stablebookorderSumlabels) }};
      var stablebookorderSumdata =  {{ Js::from($stablebookorderSumdata) }};
  
      const data = {
        labels: stablebookorderSumlabels,
        datasets: [{
          label: 'Table Booking  According To Month Wise',
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
          data: stablebookorderSumdata,
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


      ////  Table Booking  Year Sale

      var stablebookYearSumlabels = {{ Js::from($stablebookYearSumlabels) }};
      var stablebookYearSumdata = {{ Js::from($stablebookYearSumdata) }};

      const dataTableYear = {
          labels: stablebookYearSumlabels,
          datasets: [{
              label: 'Table Booking Year Wise ',
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
              data: stablebookYearSumdata,
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



@endsection
