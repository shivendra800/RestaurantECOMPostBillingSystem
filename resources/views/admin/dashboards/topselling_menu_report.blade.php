@extends('admin.layouts.layout')
@section('title',$title)

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
                    <li class="breadcrumb-item active">Top Selling Menu  Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                 {{-- today----------------------------- --}}
                 <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-danger">Today Top Selling Menu Item ReportList</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Total Sell</th>
                                    <th>Amount Total Sell</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orderitemstoday as $index=>$orderitems)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                      @if(empty($orderitems->menuitem->id))

                                       
                                        @else
                                         {{$orderitems->menuitem->menu_item_name}}--{{$orderitems->menuitem->id}}
                                        @endif
                      
           
                                        </td>
                                    <td >
                                        @if(empty($orderitems->menuitem->id))
                                        @else
                                        <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalordertoday($orderitems->item_id)}}</span>

                                        @endif
                                        </td>
                                        <td >
                                            @if(empty($orderitems->menuitem->id))
                                            @else
                                            <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalordersumtoday($orderitems->item_id)}}</span>
    
                                            @endif
                                            </td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orderitemstoday->links() }}
                    <!-- /.card-body -->
                </div>

                 {{-- month -------------------------------------------------}}
                 <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-danger">Month Top Selling Menu Item ReportList</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Total Sell</th>
                                    <th>Amount Total Sell</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orderitemsmonth as $index=>$orderitems)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                      @if(empty($orderitems->menuitem->id))

                                       
                                        @else
                                         {{$orderitems->menuitem->menu_item_name}}--{{$orderitems->menuitem->id}}
                                        @endif
                      
           
                                        </td>
                                    <td >
                                        @if(empty($orderitems->menuitem->id))
                                        @else
                                                                                <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalordermonth($orderitems->item_id)}}</span>

                                        @endif
                                        </td>
                                        <td >
                                            @if(empty($orderitems->menuitem->id))
                                            @else
                                            <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalordersummonth($orderitems->item_id)}}</span>
    
                                            @endif
                                            </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    {{ $orderitemsmonth->links() }}
                    <!-- /.card-body -->
                </div>
                 {{-- yearly------------------------------------------------ --}}
                 <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-danger">Year Top Selling Menu Item ReportList</h3>

                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Total Sell</th>
                                    <th>Amount Total Sell</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orderitemsyear as $index=>$orderitems)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                      @if(empty($orderitems->menuitem->id))

                                       
                                        @else
                                         {{$orderitems->menuitem->menu_item_name}}--{{$orderitems->menuitem->id}}
                                        @endif
                      
           
                                        </td>
                                    <td >
                                        @if(empty($orderitems->menuitem->id))
                                        @else
                                                                                <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalorderyear($orderitems->item_id)}}</span>

                                        @endif
                                        </td>
                                        <td >
                                            @if(empty($orderitems->menuitem->id))
                                            @else
                                            <span class="badge badge-success" style="fornt-size:20px;">{{$orderitems->menuitem->totalordersumyear($orderitems->item_id)}}</span>
    
                                            @endif
                                            </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    {{ $orderitemsyear->links() }}
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>


@endsection