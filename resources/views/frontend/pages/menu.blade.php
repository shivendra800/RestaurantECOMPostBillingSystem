@extends('frontend.layouts.layout')

@section('title','Menu Item List')

@section('content')

<style>
    /* Product Card */
.product-card{
    background-color: #fff;
    border: 1px solid #ccc;
    margin-bottom: 24px;
}
.product-card a{
    text-decoration: none;
}
.product-card .stock{
    position: absolute;
    color: #fff;
    border-radius: 4px;
    padding: 2px 12px;
    margin: 8px;
    font-size: 12px;
}
.product-card .product-card-img{
    max-height: 260px;
    overflow: hidden;
    border-bottom: 1px solid #ccc;
}
.product-card .product-card-img img{
    width: 100%;
}
.product-card .product-card-body{
    padding: 10px 10px;
}
.product-card .product-card-body .product-brand{
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 4px;
    color: #937979;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.product-card .product-card-body .product-name{
    font-size: 20px;
    font-weight: 600;
    color: #000;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.product-card .product-card-body .selling-price{
    font-size: 22px;
    color: #000;
    font-weight: 600;
    margin-right: 8px;
}
.product-card .product-card-body .original-price{
    font-size: 18px;
    color: #937979;
    font-weight: 400;
    text-decoration: line-through;
}
.product-card .product-card-body .btn1{
    border: 1px solid;
    margin-right: 3px;
    border-radius: 0px;
    font-size: 12px;
    margin-top: 10px;
}
/* Product Card End */
</style>

       <!-- Page Header Start -->
       <div class="page-header mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Food Menu</h2>
                </div>
                <div class="col-12">
                    <a href="">Home</a>
                    <a href="">Menu</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

   
    <!-- Menu Start -->
    <div class="menu">
        <div class="container">
            <div class="section-header text-center">
                <p>Food Menu</p>
                <h2>Delicious Food Menu</h2>
            </div>
            <div class="menu-tab">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#burgers">All</a>
                    </li>
                    @foreach ($getmenu as $menus)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#category{{$menus->id}}">{{ $menus['menu_subcat_name']}}</a>
                    </li>
                    @endforeach
                    
                </ul>
                <div class="tab-content">
                    @php
                    $getallmenu = App\Models\MenuItemPrice::with('menusubCategory')->orderBy('id', 'DESC')->get();
                @endphp
                    <div id="burgers" class="container tab-pane active">
                        <div class="row">
                            @foreach ($getallmenu as $menuall)
                            <div class="col-md-3">
                            
                                <div class="product-card">
                                           
                                    <div class="product-card-img">
                                        <label class="stock bg-success">In Stock</label>
                                          @if($menuall->menu_item_name ==NULL)
                                        <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}" style="width: 250px; height:250px" alt="{{$menuall->menu_item_name}}">
                                  @else
              <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" style="width: 250px; height:250px" alt="No Image">-->

  <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" style="width: 250px; height:250px" > 
                            @endif
                                    </div>
                                    <div class="product-card-body">
                                        <p class="product-brand">{{ $menuall->menusubCategory->menu_subcat_name }}</p>
                                        <h5 class="product-name">
                                           <a href="{{ url('menu-item/'.$menuall['id']) }}">
                                            {{$menuall->menu_item_name}}
                                           </a>
                                        </h5>
                                        <div>
                                            <span class="selling-price">Rs.{{$menuall->menu_item_price}}</span>
                                            {{-- <span class="original-price">$799</span> --}}
                                        </div>
                                        <div class="mt-2">
                                            <form action="{{ url('add-tocart/'.$menuall['id']) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <input type="hidden" name="menu_item_id" value="{{ $menuall['id'] }}"> --}}
                                                <input type="hidden" name="menu_item_price" value="{{ $menuall['menu_item_price'] }}">
                                                <input type="hidden" class="quantity-text-field" name="menu_item_qty"  min="1" max="100" value="1">
                                            <button  type="submit" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</button>
                                          
                                            {{-- <a href="#" class="btn btn1"> <i class="fa fa-heart"></i> </a> --}}
                                            <a href="{{ url('menu-item/'.$menuall['id']) }}" class="btn btn1"> View </a>

                                        </form>
                                        </div>
                                    </div>
                                  
                                </div>   
                            </div>
                            @endforeach
                            {{-- <div class="col-lg-5 d-none d-lg-block">
                                <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                            </div> --}}
                        </div>
                    </div>
                    @foreach ($getmenu as $menus)
                    <div id="category{{$menus->id}}" class="container tab-pane fade">
                        @php
                        $catwiseProduct = App\Models\MenuItemPrice::where('menu_subcat_id', $menus->id)
                            ->orderBy('id', 'DESC')
                            ->get();
                    @endphp
                     
                       <div class="row">
                        @foreach ($catwiseProduct as $menuitems)
                        <div class="col-md-3">
                          
                            <div class="product-card">
                               
                                <div class="product-card-img">
                                    <label class="stock bg-success">In Stock</label>
                                       @if($menuitems->menu_item_name ==NULL)
                                        <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuitems->menu_item_image }}" style="width: 250px; height:250px" alt="{{$menuitems->menu_item_name}}">
                                  @else
              <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" style="width: 250px; height:250px" alt="No Image">-->

  <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" style="width: 250px; height:250px" > 
                            @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{ $menus->menu_subcat_name }}</p>
                                    <h5 class="product-name">
                                       <a href="{{ url('menu-item/'.$menuitems['id']) }}">
                                        {{$menuitems->menu_item_name}}
                                       </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">Rs.{{$menuitems->menu_item_price}}</span>
                                        {{-- <span class="original-price">$799</span> --}}
                                    </div>
                                    <div class="mt-3">
                                        <form action="{{ url('add-tocart/'.$menuitems['id']) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{-- <input type="hidden" name="menu_item_id" value="{{ $menuitems['id'] }}"> --}}
                                            <input type="hidden" name="menu_item_price" value="{{ $menuitems['menu_item_price'] }}">
                                            <input type="hidden" class="quantity-text-field" name="menu_item_qty"  min="1" max="100" value="1">
                                        <button  type="submit" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</button>
                                   
                                     
                                        <a href="{{ url('menu-item/'.$menuitems['id']) }}" class="btn btn1"> View </a>
                                    </form>
                                    </div>
                                </div>
                              
                            </div>
                           
                        </div>
                        @endforeach
                       </div>
                   
                       
                     
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->


@endsection