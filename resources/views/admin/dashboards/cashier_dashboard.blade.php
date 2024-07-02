@extends('admin.layouts.layout')
@section('title', 'Chashier Dashboard')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chashier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chashier </li>
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
      <h4>Table Order  Sale Of Current Year According To Month Wise</h4>
      <canvas id="myChart" height="100px"></canvas>
          </div>
        </div>
      </section>
      <hr>

      <div class="card-body">
        <h4>Take Way Order  Sale Of Current Year According To Month Wise</h4>
        <div class="d-flex">
            
            <canvas id="feeChart" height="100px"></canvas>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">All Table List</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="btn-group w-100 mb-2">
                                    <a class="btn btn-info active" href="javascript:void(0)" data-filter="all"> All</a>
                                    <a class="btn btn-info" href="javascript:void(0)" data-filter="2">Not Booked Table(Blue)
                                    </a>
                                    <a class="btn btn-info" href="javascript:void(0)" data-filter="3"> Booked Table(Grey)
                                    </a>
                                    <a class="btn btn-info" href="javascript:void(0)" data-filter="4"> All Table(Blue, Grey)
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle=""> Shuffle items
                                    </a>
                                    <div class="float-right">
                                        <select class="custom-select" style="width: auto;" data-sortorder="">
                                            <option value="index"> Sort by Position </option>
                                            <option value="sortData"> Sort by Custom Data </option>
                                        </select>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortasc=""> Ascending
                                            </a>
                                            <a class="btn btn-default" href="javascript:void(0)" data-sortdesc="">
                                                Descending </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="filter-container p-0 row"
                                    style="padding: 3px; position: relative; width: 100%; display: flex; flex-wrap: wrap; height: 331px;">
                                    @foreach ($notbooked as $notbook)
                                        <div class="filtr-item col-sm-2" data-category="2, 4" data-sort="black sample"
                                            style="opacity: 1; transform: scale(1) translate3d(171px, 0px, 0px); backface-visibility: hidden; perspective: 1000px; transform-style: preserve-3d; position: absolute; width: 167.5px; transition: all 0.5s ease-out 0ms, width 1ms ease 0s;">
                                            <a href="#">
                                                <span class="card align-items-center d-flex justify-content-center"
                                                    style="height:149.5px; weight=149.5px; background-color: #2a51cca6; color: white;">{{ $notbook['table_name'] }}</span>
                                            </a>
                                        </div>
                                    @endforeach

                                    @foreach ($booked as $booked)
                                        <div class="filtr-item col-sm-2" data-category="3, 4" data-sort="red sample"
                                            style="opacity: 1; transform: scale(1) translate3d(342px, 0px, 0px); backface-visibility: hidden; perspective: 1000px; transform-style: preserve-3d; position: absolute; width: 167.5px; transition: all 0.5s ease-out 0ms, width 1ms ease 0s;">
                                            <a href="{{ url('/') }}/admin/View-order-details/{{ $booked['order_no'] }}">
                                                <span class="card align-items-center d-flex justify-content-center"
                                                    style=" font-size: 15px; height:149.5px; weight=149.5px; background-color: #82737385; color: black;">{{ $booked['table_name'] }}
                                                    <h5 style="color:black; font-size: 15px;">Order
                                                        ID-<strong>{{ $booked['order_no'] }}</strong></h5>
                                                    <h5 style="color:black;  font-size: 15px;">
                                                        Weiter-<strong>{{ $booked['name'] }}</strong></h5>
                                                </span>
                                            </a>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">All Table Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($AllTable as $alltables)
                                    <div class="col-sm-2">
                                        <a href="#">
                                            <span class="card align-items-center d-flex justify-content-center"
                                                style="height:149.5px; weight=149.5px; background-color: lightgoldenrodyellow;">{{ $alltables['table_name'] }}</span>


                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      
    <script type="text/javascript">
      
          var labels =  {{ Js::from($labels) }};
          var users =  {{ Js::from($data) }};
      
          const data = {
            labels: labels,
            datasets: [{
              label: 'Grand Total Amount  According To Month Wise',
              backgroundColor: 'rgb(255, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
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


             ///////////////

        var takeWayOrderlabels = {{ Js::from($takeWayOrderlabels) }};
        var takeWayOrderdata = {{ Js::from($takeWayOrderdata) }};

        const datafee = {
            labels: takeWayOrderlabels,
            datasets: [{
                label: 'Take Way Order ',
                backgroundColor: 'rgb(0, 191, 255)',
                borderColor: 'rgb(0, 191, 255)',
                data: takeWayOrderdata,
            }]
        };

        const configfee = {
            type: 'bar',
            data: datafee,
            options: {}
        };

        const feeChart = new Chart(
            document.getElementById('feeChart'),
            configfee
        );

        
      
    </script>


@endsection
