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
  <h4>Total Table Order Take By Waiter</h4>
  <canvas id="myChart" height="100px"></canvas>
      </div>
    </div>
  </section>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <script type="text/javascript">
    
        var labels =  {{ Js::from($labels) }};
        var users =  {{ Js::from($data) }};
    
        const data = {
          labels: labels,
          datasets: [{
            label: 'Order Taken By Waiter Wise According To Month Wise',
            backgroundColor: 'rgb(99, 112, 255)',
            borderColor: 'rgb(99, 112, 255)',
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
