@extends('admin.layouts.layout')
@section('title','Online Payment Details')

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
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Online Payment Details</li>
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


               
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group bg-warning text-center p-2">
                                    <label>Over All Total Online</label>
                                    <br>
                                   <strong class="bg-danger text-center p-1">{{$overallsaledis}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                                      <!--------  Order Date Wise  Sale Graph Start   --------------->
      <div class="col-md-12">
        <h3 class="text-center"> Order  Sale Of Current Month According To Date Wise</h3>
          <div class="col-md-12 col-md-offset-2">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-body">
                    <h4> Order Day Wise Sale </h4>
                    <div class="d-flex">
                        
                        <canvas id="TableDayChart" height="100px"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>	
      </div>

            <!--------  Order Date Wise  Sale Graph End   --------------->

               <!--------  Order Month Wise  Sale Graph Start   --------------->
         <div class="col-md-12">
            <h3 class="text-center"> Order  Sale Of Current Year According To Month Wise</h3>
              <div class="col-md-12 col-md-offset-2">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-body">
                        <h4> Order Month Wise Sale </h4>
                        <div class="d-flex">
                            
                            <canvas id="TableMonthChart" height="100px"></canvas>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>	
          </div>
    
                <!--------  Order Month Wise  Sale Graph End   --------------->
                   <!--------  Order Year Wise  Sale Graph Start   --------------->
         <div class="col-md-12">
            <h3 class="text-center"> Order  Sale Of  Year According To Year Wise</h3>
              <div class="col-md-12 col-md-offset-2">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-body">
                        <h4> Order Year Wise Sale </h4>
                        <div class="d-flex">
                            
                            <canvas id="TableYearChart" height="100px"></canvas>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>	
          </div>
    
                <!--------  Order Year Wise  Sale Graph End   --------------->

             
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Online Payment Details</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">

                            <thead>
                                <tr>


                                    <th>Order Type</th>
                                    <th>Order No</th>
                                    <th>Sub Total</th>
                                    <th>Discount Amount</th>
                                    <th>New Subtotal Amount</th>
                                    <th>Total Tax</th>
                                    <th>Grand Total</th>
                                    <th> Order Date</th>
                                    <th> Mode</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                             
                                @foreach ($tableOderSale as $index=>$todayorder)
                                <tr>

                                    <td class="btn btn-info">Table Order</td>
                                    <td>
                                       
                                        {{$todayorder['order_no']}}
                                     
                                    </td>
                                    <td>
                                        {{$todayorder['sub_total']}}
                                        
                                    </td>
                                    <td ><span class="badge badge-danger">{{$todayorder['coupon_per']}}% Off</span>
                                        <br>
                                        <strong class="btn btn-warning">{{$todayorder['sub_total'] - $todayorder['subtotalwithoffer']}}</strong>
                                    </td>
                                    
                                    <td>{{$todayorder['subtotalwithoffer']}}</td>
                                    <td>{{$todayorder['total_tax']}}</td>
                                    <td>{{$todayorder['grand_total']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($todayorder->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                    <td>{{$todayorder['payment_mode']}}</td>
                                        
            

                                </tr>
                               

                                @endforeach

                                @foreach ($takeOderSale as $index=>$todayorder)
                                <tr>

                                    <td class="btn btn-info">TakeAway Order</td>
                                    <td>
                                       
                                        {{$todayorder['order_no']}}
                                     
                                    </td>
                                    <td>
                                        {{$todayorder['sub_total']}}
                                        
                                    </td>
                                    <td ><span class="badge badge-danger">{{$todayorder['coupon_per']}}% Off</span>
                                        <br>
                                        <strong class="btn btn-warning">{{$todayorder['sub_total'] - $todayorder['subtotalwithoffer']}}</strong>
                                    </td>
                                    
                                    <td>{{$todayorder['subtotalwithoffer']}}</td>
                                    <td>{{$todayorder['total_tax']}}</td>
                                    <td>{{$todayorder['grand_total']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($todayorder->created_at)->isoFormat('MMM Do YYYY')}}</td>
                                        
                                    <td>{{$todayorder['payment_mode']}}</td>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
<script type="text/javascript">


   // Table Order DayWise Graph
   var daywisetablelabelsCash = {{ Js::from($daywisetablelabelsCash) }};
      var daywisetabledataCash = {{ Js::from($daywisetabledataCash) }};
      var daywisetakeawaydataCash = {{ Js::from($daywisetakeawaydataCash) }};

      const dataTableDay = {
          labels: daywisetablelabelsCash,
          datasets: [
            {
              label: 'Table Order Date Wise Sale ',
              backgroundColor: [
                  'rgba(168, 50, 160)',
                  'rgba(168, 50, 146)',
                  'rgba(168, 50, 117)',
                  'rgba(168, 50, 103)',
                  'rgba(101, 168, 50)',
                  'rgba(255, 99, 132)',
                  'rgba(54, 162, 235)',
                  'rgba(255, 206, 86)',
                  'rgba(75, 192, 192)',
                  'rgba(153, 102, 255)',
                  'rgba(255, 159, 64)'
              ],
              borderColor: [
                  'rgba(168, 50, 160)',
                  'rgba(168, 50, 146)',
                  'rgba(168, 50, 117)',
                  'rgba(168, 50, 103)',
                  'rgba(101, 168, 50)',
                  'rgba(255, 99, 132)',
                  'rgba(54, 162, 235)',
                  'rgba(255, 206, 86)',
                  'rgba(75, 192, 192)',
                  'rgba(153, 102, 255)',
                  'rgba(255, 159, 64)'
              ],
              data: daywisetabledataCash,
          },
          {
              label: 'TakeWay Order Date Wise Sale',
              backgroundColor: [
                   'rgba(101, 168, 50)',
                  'rgba(50, 168, 82)',
                  'rgba(50, 168, 127)',
                  'rgba(62, 50, 168)',
                  'rgba(105, 50, 168)',
                  'rgba(139, 50, 168)',
                  'rgba(148, 50, 168)',
                  'rgba(168, 50, 160)',
                  'rgba(168, 50, 146)',
                  'rgba(168, 50, 117)',
                  'rgba(168, 50, 103)'
                  
              ],
              borderColor: [
                  'rgba(101, 168, 50)',
                   'rgba(50, 168, 82)',
                  'rgba(50, 168, 127)',
                  'rgba(62, 50, 168)',
                  'rgba(105, 50, 168)',
                  'rgba(139, 50, 168)',
                  'rgba(148, 50, 168)',
                  'rgba(168, 50, 160)',
                  'rgba(168, 50, 146)',
                  'rgba(168, 50, 117)',
                  'rgba(168, 50, 103)'
                 
              ],
              data: daywisetakeawaydataCash,
          }
        ]
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


      var takeWayOrderlabelsCash = {{ Js::from($takeWayOrderlabelsCash) }};
      var takeWayOrderdataCash = {{ Js::from($takeWayOrderdataCash) }};

      var stableorderSumdataCash = {{ Js::from($stableorderSumdataCash) }};

      const dataTableMonth = {
          labels: takeWayOrderlabelsCash,
          datasets: [
            {
              label: 'Table Order Month Wise Sale ',
              backgroundColor: [
                'rgba(54, 162, 235)',
              ],
              borderColor: [
                'rgba(54, 162, 235)',
              ],
              data: stableorderSumdataCash,
          },
          {
              label: 'TakeWay Order Month Wise Sale',
              backgroundColor: [
                    'rgba(235, 186, 52)',
                    
                  
              ],
              borderColor: [
                'rgba(235, 186, 52)',
                   
                 
              ],
              data: takeWayOrderdataCash,
          }
        ]
      };

      const configTableMonth = {
          type: 'bar',
          data: dataTableMonth,
          options: {}
      };

      const TableMonthChart = new Chart(
          document.getElementById('TableMonthChart'),
          configTableMonth
      );


      ///////


      var TakeWaysYearSalelabels = {{ Js::from($TakeWaysYearSalelabels) }};
      var TakeWaysYearSaledata = {{ Js::from($TakeWaysYearSaledata) }};

      var TablesYearSaledata = {{ Js::from($TablesYearSaledata) }};

      const dataTableYear = {
          labels: TakeWaysYearSalelabels,
          datasets: [
            {
              label: 'Table Order Year Wise Sale ',
              backgroundColor: [
                'rgba(235, 122, 52)',
              ],
              borderColor: [
                'rgba(235, 122, 52)',
              ],
              data: TablesYearSaledata,
          },
          {
              label: 'TakeWay Order Year Wise Sale',
              backgroundColor: [
                    'rgba(235, 52, 201)',
                    
                  
              ],
              borderColor: [
                'rgba(235, 52, 201)',
                   
                 
              ],
              data: TakeWaysYearSaledata,
          }
        ]
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


      
    