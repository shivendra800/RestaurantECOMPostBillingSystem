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
            <li class="breadcrumb-item active">Menu Item Price</li>
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
              <h3 class="card-title">Menu Price List</h3>
              
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <form action="{{ url('admin/all-menu-price-modify/') }}"  method="post">
                    @csrf
              <table id="example1" class="  table table-bordered table-hover dataTable dtr-inline"
                                        aria-describedby="example1_info">
                <thead>
                <tr>
                 
                  <th>ID</th>
                  {{-- <th>Menu Category Name </th> --}}
                  <th>Menu Category Name</th>
                  <th>Item Name</th>
                  <th>Item Price</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($menuitemPrice as $index=>$menuitemPrice)
                        <tr>
            
                        <td>{{$index+1}}
                            <input type="hidden" name="id[]" value="{{$menuitemPrice['id']}}">
                        </td>
                        {{-- <td>{{$menuitemPrice['menu_category']['menu_cat_name']}}</td> --}}
                        <td>
                          @if($menuitemPrice['menu_subcat_id'] == " " || $menuitemPrice['menu_subcat_id'] == NULL)
                          Root

                          @else       
                          {{$menuitemPrice['menusub_category']['menu_subcat_name']}}      
                          @endif             
                          </td>
                        <td>{{$menuitemPrice['menu_item_name']}}</td>
                        <td>
                            <input type="text" class="sub_chk" name="menu_item_price[]" value="{{$menuitemPrice['menu_item_price']}}">
                        </td>
                        
                      
                        
                </tr>
                @endforeach
                </tbody>
              </table>
              <div  class="text-center">
                <button type="submit" class="btn btn-primary">Update Price</button>
              </div>
              
                </form>
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



