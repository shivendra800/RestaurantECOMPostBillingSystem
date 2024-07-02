@extends('frontend.layouts.layout')

@section('title','Menu Item List')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<style>
        /* bootstrap 3 multi-col carousel */
        #slick {
        display: none;

        &.slick-initialized {
            display: block;
        }

        /* .slick-list emulates .row */
        .slick-list {
            margin-left: -15px;
            margin-right: -15px;
        }

        /* .slick-slide emulates .col- */
        .slick-slide {
            padding-right: 15px;
            padding-left: 15px;
            cursor: initial;

            &:focus {
                outline: none;
            }
        }

        /* slick arrows */
        .slick-arrow {
            position: absolute;
            top: 50%;
            z-index: 1;
            width: 30px;
            height: 30px;
            overflow: hidden;
            margin: 0;
            padding: 0;
            border: 0;
            opacity: .5;
            transition: opacity .5s ease;
            font-family: "Glyphicons Halflings";
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            font-size: 0;
            background: none;
            color: transparent;

            &:hover {
                opacity: 1;
            }

            &:before {
                font-size: 30px;
                color: #212529;
            }

            &.slick-prev {
                left: 0;
                transform: translate(calc(-100% - 15px), -50%);

                &:before {
                    /* content: "\e079"; */
                }
            }

            &.slick-next {
                right: 0;
                transform: translate(calc(100% + 15px), -50%);

                &:before {
                    /* content: "\e080"; */
                }
            }
        }

        /* slick dots */
        .slick-dots {
            position: absolute;
            bottom: 0;
            left: 50%;
            padding: 0;
            list-style: none;
            z-index: 1;
            margin: 0;
            display: block;
            transform: translate(-50%, calc(100% + 30px));

            >LI {
                float: left;
                display: block;
                padding: 1px;
                margin-right: 4px;

                BUTTON {
                    display: block;
                    width: 10px;
                    height: 10px;
                    text-indent: -999px;
                    cursor: pointer;
                    background: transparent;
                    padding: 0;
                    overflow: hidden;
                    border: 1px solid #212529;
                    border-radius: 50%;

                    &:focus {
                        outline: none;
                    }

                }

                &.slick-active,
                &:hover {
                    padding: 0;

                    BUTTON {
                        width: 12px;
                        height: 12px;
                        background: #212529;
                        border: 1px solid #212529;
                    }
                }

                &:last-child {
                    margin-right: 0;
                }
            }
        }
    }

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

    /* Product Card End */
    /* Product View */
.product-view .product-name{
    font-size: 24px;
    color: #2874f0;
}
.product-view .product-name .label-stock{
    font-size: 13px;
    padding: 4px 13px;
    border-radius: 5px;
    color: #fff;
    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
    float: right;
}
.product-view .product-path{
    font-size: 13px;
    font-weight: 500;
    color: #252525;
    margin-bottom: 16px;
}
.product-view .selling-price{
    font-size: 26px;
    color: #000;
    font-weight: 600;
    margin-right: 8px;
}
.product-view .original-price{
    font-size: 18px;
    color: #937979;
    font-weight: 400;
    text-decoration: line-through;
}
.product-view .btn1{
    border: 1px solid;
    margin-right: 3px;
    border-radius: 0px;
    font-size: 14px;
    margin-top: 10px;
}
.product-view .btn1:hover{
    background-color: #2874f0;
    color: #fff;
}
.quantity {
  position: relative;
  display: inline-block;
  margin-left: 4px;
  margin-right: 4px; }
  .quantity .quantity-text-field {
    border: 1px solid #aaaaaa;
    display: inline-block;
    padding: 8px 18px;
    font-size: 12px;
    text-align: center;
    width: 98px;
    height: 36px;
    transition: all .3s; }
    .quantity .quantity-text-field:focus {
      outline: 0;
      border-color: #292929; }

.product-view .input-quantity{
    border: 3px solid #000;
    margin-right: 30px;
    font-size: 20px;
    margin-top: 18px;
    width: 70px;
    outline: none;
    text-align: center;
}
/* Product View */
</style>
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Product Detail</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Detail</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Single Post Start-->
<div class="py-3 py-md-5 ">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mt-3">
                      <!-- Carousel Start -->
            <div class="carousel">
                    <div class="owl-carousel">
                        @if($getmutiimgitem == NULL)
                        @foreach ($getmutiimgitem as $multiimg)
                        <div class="carousel-item"style="width: 500px; height:500px;">
                            <div class="carousel-img">
                                <img src="{{ asset('front_assets/menu_item_image/large/' . $multiimg->image) }}"  alt="Image">
                            </div>
                        </div>
                        @endforeach
                        @else
                         <div class="carousel-item"style="width: 500px; height:500px;">
                            <div class="carousel-img">
                                 <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg"  >
                                
                            </div>
                        </div>
                        @endif
                        
                    </div>
            </div>
            <!-- Carousel End -->
            </div>
         
            <div class="col-md-7 mt-3">
                <div class="product-view">
                    <h4 class="product-name">
                       {{ $menuitem['menu_item_name'] }}
                        <label class="label-stock bg-success">In Stock</label>
                    </h4>
                    <hr>
                    <div class="mt-3">
                    <p class="product-path">
                        Home / {{ $menuitem['menusubCategory']['menu_subcat_name'] }} /  {{ $menuitem['menu_item_name'] }} 
                    </p> 
                    </div>
                    <hr>
                    <div class="mt-3">
                        <h5 class="mb-0"> Description</h5>
                        <p>
                            {{ $menuitem['description'] }}
                        </p>
                    </div>
                    <hr>

                    <div class="quantity-wrapper u-s-m-b-22">
                        <Strong>Price:</Strong>
                        <span class="selling-price">Rs.{{ $menuitem['menu_item_price'] }}</span>
                        {{-- <span class="original-price">$499</span> --}}
                    </div>
                    <form action="{{ url('/add-to-cart') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="menu_item_id" value="{{ $menuitem['id'] }}">
                         <input type="hidden" name="menu_item_price" value="{{ $menuitem['menu_item_price'] }}">
                    <div class="quantity-wrapper u-s-m-b-22">
                        <span>Quantity:</span>
                        <div class="quantity">
                            <input type="number" class="quantity-text-field" name="menu_item_qty"  min="1" max="100" value="1">
                        </div>
                    </div>
                    <div class="mt-2">
                        <button  type="submit" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</button>
                        {{-- <a href="" class="btn btn1"> <i class="fa fa-heart"></i> Add To Wishlist </a> --}}
                    </div>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- Single Post End-->
<div class="container">
    <div class="col-md-12">
        <div class="section-header text-center">
            <p>Food Menu</p>
            <h2>Delicious Food Menu</h2>
        </div>
    </div>
    <div id="slick">
        @foreach ($getall as $menuall )
        <div class="slide">
            <div class="item">
                <div class="product-card ">
                    <div class="product-card-img">
                        <label class="stock bg-danger">New</label>

                        <a href="{{ url('menu-item/'.$menuall['id']) }}">
                             @if($menuall->menu_item_name ==NULL)
                            <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}" style="width: 250px; height:250px" alt="{{$menuall->menu_item_name}}">
                            @else

                             <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" style="width: 250px; height:250px" >
 
                            @endif
                           
                        </a>


                    </div>
                    <div class="product-card-body">
                        <p class="product-brand">{{ $menuall->menusubCategory->menu_subcat_name }}</p>
                        <h5 class="product-name">
                            <a href="{{ url('menu-item/'.$menuall['id']) }}">
                                {{$menuall->menu_item_name}}
                            </a>
                        </h5>
                        <div>
                            <span class="selling-price">Rs {{$menuall->menu_item_price}}</span>
                            {{-- <span class="original-price">Rs {{$menuall->menu_item_price}}</span> --}}
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

        </div>
        @endforeach

    </div>
</div>  



<script>
    // bootstrap 3 breakpoints 
    const breakpoint = {
        // extra small screen / phone
        xs: 480,
        // small screen / tablet
        sm: 768,
        // medium screen / desktop
        md: 992,
        // large screen / large desktop
        lg: 1200
    };

    // bootstrap 3 responsive multi column slick carousel
    $('#slick').slick({
        autoplay: true
        , autoplaySpeed: 2000
        , draggable: true
        , pauseOnHover: true
        , infinite: true
        , dots: false
        , arrows: false
        , speed: 1000,

        mobileFirst: true,

        slidesToShow: 1
        , slidesToScroll: 1,

        responsive: [{
                breakpoint: breakpoint.xs
                , settings: {
                    slidesToShow: 2
                    , slidesToScroll: 2
                }
            }
            , {
                breakpoint: breakpoint.sm
                , settings: {
                    slidesToShow: 3
                    , slidesToScroll: 3
                    , arrows: true
                }
            }
            , {
                breakpoint: breakpoint.md
                , settings: {
                    slidesToShow: 4
                    , slidesToScroll: 4
                    , arrows: true
                }
            }
            , {
                breakpoint: breakpoint.lg
                , settings: {
                    slidesToShow: 4
                    , slidesToScroll: 4
                    , arrows: true
                }
            }
        ]
    });
    
</script>

@endsection