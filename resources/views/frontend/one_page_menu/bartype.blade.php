<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dunkel Beverage</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keyword')">
    <meta name=" author" content="Shivendra">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/img/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/img/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/img/logo.png') }}">

    <!-- Favicon -->
    {{-- <link href="{{ url('/') }}/front_assets/img/favicon.ico" rel="icon"> --}}
    <link rel="icon" type="image/png" href="{{ url('/') }}/front_assets/img/favicon.png">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Nunito:600,700" rel="stylesheet">
    <script src="{{ url('/') }}/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/front_assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/front_assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/front_assets/lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="{{ url('/') }}/front_assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{ url('/') }}/front_assets/css/style.css" rel="stylesheet">

</head>

<body>




    <style>
        /* Product Card */
        .product-card {
            background-color: #fff;
            border: 1px solid #ccc;
            margin-bottom: 24px;
        }

        .product-card a {
            text-decoration: none;
        }

        .product-card .stock {
            position: absolute;
            color: #fff;
            border-radius: 4px;
            padding: 2px 12px;
            margin: 8px;
            font-size: 12px;
        }

        .product-card .product-card-img {
            max-height: 260px;
            overflow: hidden;
            border-bottom: 1px solid #ccc;
        }

        .product-card .product-card-img img {
            width: 100%;
        }

        .product-card .product-card-body {
            padding: 10px 10px;
        }

        .product-card .product-card-body .product-brand {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 4px;
            color: #937979;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .product-card .product-card-body .product-name {
            font-size: 20px;
            font-weight: 600;
            color: #000;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .product-card .product-card-body .selling-price {
            font-size: 22px;
            color: #000;
            font-weight: 600;
            margin-right: 8px;
        }

        .product-card .product-card-body .original-price {
            font-size: 18px;
            color: #937979;
            font-weight: 400;
            text-decoration: line-through;
        }

        .product-card .product-card-body .btn1 {
            border: 1px solid;
            margin-right: 3px;
            border-radius: 0px;
            font-size: 12px;
            margin-top: 10px;
        }

        div.scrollmenu {
            background-color: #c60f0f;
            overflow: auto;
            white-space: nowrap;
        }

        div.scrollmenu a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }

        div.scrollmenu a:hover {
            background-color: #777;
        }

        /* Product Card End */
    </style>

    <!-- Page Header Start -->
    <div class="page-header mb-0" style="background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(front_assets/img/brands-wine-square-new.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Bar Menu</h2>
                </div>
                <div class="col-12">
                    <a href="{{url('Menu-List')}}">Home</a>
                    <a href="#">Menu</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Menu Start -->
    <div class="menu">
        <div class="container">
            <div class="section-header text-center">
                <p>Bar Menu</p>
                <h2>Delicious Bar Menu</h2>
            </div>




            <div class="menu-tab ">
                <div class="scrollmenu ">
                    <div id="premier-topnav">
                        <a class="nav-link active" data-toggle="pill" href="#burgers">All</a>
                        @foreach ($getmenu as $menus)
                            <a class="nav-link " data-toggle="pill"
                                href="#category{{ $menus->id }}">{{ $menus['menu_subcat_name'] }}</a>
                        @endforeach
                    </div>

                </div>
                {{-- <ul class="nav nav-pills justify-content-center ">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#burgers">All</a>
                            </li>
                            @foreach ($getmenu as $menus)
                            <li class="nav-item ">
                                <a class="nav-link" data-toggle="pill" href="#category{{$menus->id}}">{{ $menus['menu_subcat_name']}}</a>
                            </li>
                            @endforeach

                        </ul> --}}
                <div class="tab-content">
                    @php
                        $getallmenu = App\Models\MenuItemPrice::with('menusubCategory')->orderBy('id', 'DESC')->get();
                    @endphp
                    <div id="burgers" class="container tab-pane active">
                        <div class="row">
                            @foreach ($getallmenu as $menuall)
                                <div class="col-md-3">

                                    <div class="product-card">

                                        <div class="product-card-img" >
                                            <label class="stock bg-success">In Stock</label>
                                            @if ($menuall->menu_item_name == null)
                                                <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}"
                                                   
                                                    alt="{{ $menuall->menu_item_name }}">
                                            @else
                                                <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" style="width: 250px; height:250px" alt="No Image">-->

                                                <img src="{{ url('/') }}/front_assets/img/brands-wine-square-new.jpg"
                                                    >
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            <p class="product-brand">{{ $menuall->menusubCategory->menu_subcat_name }}
                                            </p>
                                            <h5 class="product-name">
                                                {{-- <a href="{{ url('menu-item/'.$menuall['id']) }}"> --}}
                                                {{ $menuall->menu_item_name }}
                                                {{-- </a> --}}
                                            </h5>
                                            <div>
                                                <span class="selling-price">Rs.{{ $menuall->menu_item_price }}</span>
                                                {{-- <span class="original-price">$799</span> --}}
                                            </div>
                                            <div class="mt-2">
                                                {{-- <form action="{{ url('add-tocart/'.$menuall['id']) }}" method="post" enctype="multipart/form-data">
                                                        @csrf

                                                        <input type="hidden" name="menu_item_price" value="{{ $menuall['menu_item_price'] }}">
                                                        <input type="hidden" class="quantity-text-field" name="menu_item_qty"  min="1" max="100" value="1">
                                                    <button  type="submit" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</button>


                                                    <a href="{{ url('menu-item/'.$menuall['id']) }}" class="btn btn1"> View </a>

                                                </form> --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="col-lg-5 d-none d-lg-block">
                                        <img src="{{ url('/') }}/front_assets/img/brands-wine-square-new.jpg" alt="Image">
                                    </div> --}}
                        </div>
                    </div>
                    @foreach ($getmenu as $menus)
                        <div id="category{{ $menus->id }}" class="container tab-pane fade">
                            @php
                                $catwiseProduct = App\Models\MenuItemPrice::where('menu_subcat_id', $menus->id)
                                    ->orderBy('id', 'DESC')
                                    ->get();
                            @endphp

                            <div class="row">
                                @foreach ($catwiseProduct as $menuitems)
                                    <div class="col-md-3">

                                        <div class="product-card">

                                            <div class="product-card-img" >
                                                <label class="stock bg-success">In Stock</label>
                                                @if ($menuitems->menu_item_name == null)
                                                    <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuitems->menu_item_image }}"
                                                      
                                                        alt="{{ $menuitems->menu_item_name }}">
                                                @else
                                                    <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" style="width: 250px; height:250px" alt="No Image">-->

                                                    <img src="{{ url('/') }}/front_assets/img/brands-wine-square-new.jpg"
                                                        >
                                                @endif
                                            </div>
                                            <div class="product-card-body">
                                                <p class="product-brand">{{ $menus->menu_subcat_name }}</p>
                                                <h5 class="product-name">
                                                    <a href="{{ url('menu-item/' . $menuitems['id']) }}">
                                                        {{ $menuitems->menu_item_name }}
                                                    </a>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="selling-price">Rs.{{ $menuitems->menu_item_price }}</span>
                                                    {{-- <span class="original-price">$799</span> --}}
                                                </div>
                                                <div class="mt-3">
                                                    <!--<form action="{{ url('add-tocart/' . $menuitems['id']) }}"-->
                                                    <!--    method="post" enctype="multipart/form-data">-->
                                                    <!--    @csrf-->
                                                       
                                                    <!--    <input type="hidden" name="menu_item_price"-->
                                                    <!--        value="{{ $menuitems['menu_item_price'] }}">-->
                                                    <!--    <input type="hidden" class="quantity-text-field"-->
                                                    <!--        name="menu_item_qty" min="1" max="100"-->
                                                    <!--        value="1">-->
                                                    <!--    <button type="submit" class="btn btn1"> <i-->
                                                    <!--            class="fa fa-shopping-cart"></i> Add To Cart</button>-->


                                                    <!--    <a href="{{ url('menu-item/' . $menuitems['id']) }}"-->
                                                    <!--        class="btn btn1"> View </a>-->
                                                    <!--</form>-->
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/front_assets/lib/easing/easing.min.js"></script>
    <script src="{{ url('/') }}/front_assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ url('/') }}/front_assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="{{ url('/') }}/front_assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="{{ url('/') }}/front_assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Contact Javascript File -->
    <script src="{{ url('/') }}/front_assets/mail/jqBootstrapValidation.min.js"></script>
    <script src="{{ url('/') }}/front_assets/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="{{ url('/') }}/front_assets/js/main.js"></script>


    <script type="text/javascript" src="{{ url('/') }}/front_assets/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/front_assets/toastr.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>


    <script>
        function setActive() {
            linkObj = document.getElementById('premier-topnav').getElementsByTagName('a');
            for (i = 0; i < linkObj.length; i++) {
                if (document.location.href.indexOf(linkObj[i].href) >= 0) {
                    linkObj[i].classList.add("active");
                }
            }
        }

        window.onload = setActive;
    </script>




</body>

</html>
