@extends('admin.layouts.layout')
@section('title','ExternalProduct Use Stock Log ')

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
            <li class="breadcrumb-item active">ExternalProduct Use Stock Log</li>
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

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">ExternalProduct Use Stock Log</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  <th>Ext Prod Name</th>
                  <th>Before Transfer Qty</th>
                  <th>Transfer Qty</th>
                  <th>After Transfer Qty</th>
                  <th>Remark</th>
                  <th>Use Stock Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($getextProductLog as $index=>$ExtProduct)
                        <tr>
                       
                  
                        <td>{{$index+1}}</td>                
                        <td>{{$ExtProduct['extproduct']['ext_product_name']}}</td>
                        <td class="text-danger">{{$ExtProduct['before_transfer_qty']}}</td>
                        <td class="text-danger">{{$ExtProduct['transfer_qty']}}</td>
                        <td class="text-danger">{{$ExtProduct['after_transfer_qty']}}</td>
                        <td class="text-danger">{{$ExtProduct['remark']}}</td>
                        <td class="text-danger">{{ \Carbon\Carbon::parse($ExtProduct['created_at'])->isoFormat('MMM Do YYYY')}}</td>


                            
                        
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

@endsection
@section('script')
    
@endsection
