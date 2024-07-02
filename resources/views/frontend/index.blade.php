@extends('frontend.layouts.layout')

@section('content')


<!-- slick 1.9 -->
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
</style>
<!-- Carousel Start -->
<div class="carousel">
    <div class="container-fluid">
        <div class="owl-carousel">
            @foreach ($slider as $slide)
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="{{ asset('front_assets/img/slider/' . $slide->image) }}" alt="Image">
                </div>
                <div class="carousel-text">
                    <h1> <span>{{ $slide->title }}</span></h1>
                    <p>{{ $slide->link }}</p>
                    <div class="carousel-btn">
                        <a class="btn custom-btn" href="{{ url('menu') }}">View Menu</a>
                        <a class="btn custom-btn" href="{{ url('table-booking') }}">Book Table</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Booking Start -->
<div class="booking mt-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="booking-content">
                    <div class="section-header">
                        <p>Book A Table</p>
                        <h2>Book Your Table For Private Dinners & Happy Hours</h2>
                    </div>
                    <div class="about-text">
                        <p>Whether you’re here for a bite or a string of night, make a reservation to not miss out the experience of seamless dining and party. Enjoy global cuisines meshed with trendy spirits with strong Indian influences with hospitality that allures amidst tranquil ambience. Progressive music flirts with global influences to rejoice the night!</p>
                        <p>Good times start with a noble drink, and yes we’ll curate that for you! Living Room’s sumptuous space is an oasis of warmth, mystery and magical cocktails where for the space of an evening guests and visitors alike can enjoy a glorious sense of disconnection from the outside world.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="booking-form">
                    <form>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="text" class="form-control cust_name " id="name" name="cust_name" placeholder="Your Name">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-user"></i></div>

                                </div>
                            </div>
                            <span id="cust_name_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="email" class="form-control cust_email" id="email" name="cust_email" placeholder="Your Email">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                </div>

                            </div>
                            <span id="cust_email_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="number" class="form-control cust_phone" id="phone" name="cust_phone" placeholder="Your Phone Number">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-mobile-alt"></i></div>
                                </div>

                            </div>
                            <span id="cust_phone_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input table_booking_date" name="table_booking_date" placeholder="Date" data-target="#date" data-toggle="datetimepicker" />
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>

                            </div>
                            <span id="table_booking_date_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group time" id="time" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input table_booking_time" name="table_booking_time" placeholder="Check In-Time" data-target="#time" data-toggle="datetimepicker" />
                                <div class="input-group-append" data-target="#time" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>

                            </div>
                            <span id="table_booking_time_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group time" id="time" data-target-input="nearest">
                                <input type="time" class="form-control table_booking_timeout" name="table_booking_timeout" placeholder="Check Out-Time" />
                                {{-- <div class="input-group-append">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div> --}}

                            </div>
                            <span id="table_booking_timeout_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="number" class="form-control no_person" id="email" name="no_person" placeholder="Enter No Of Person">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-user"></i></div>
                                </div>

                            </div>
                            <span id="no_person_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group ">
                                <select class="custom-select text-dark form-control table_type" name="table_type">
                                    <option value="">Select Table Type</option>
                                    <option value="Center Table">Center Table</option>
                                    <option value="Front Table">Front Table</option>
                                    <option value="Side Table">Side Table</option>
                                    <option value="Left Corner Table">Left Corner Table</option>
                                    <option value="Right Corner Table">Right Corner Table</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-chevron-down"></i></div>
                                </div>

                            </div>
                            <span id="table_type_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="text" class="form-control message" id="email" name="message" placeholder="Enter Your Message">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-message"></i></div>
                                </div>

                            </div>
                            <span id="message_error" class="text-danger"></span>
                        </div>

                        <div class="control-group">
                            <div class="input-group">
                                <input type="text" class="form-control payment_amount" id="payment_amount" name="payment_amount" value="500" readonly placeholder="Enter No Of Person">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-money"></i></div>
                                </div>

                            </div>
                        </div>

                        <div>
                            {{-- <button class="btn custom-btn razorpay-btn" type="submit">Pay With
                                            Razorpay</button> --}}

                            <button class="btn btn-primary  w-100 mt-3 razorpay-btn" type="button">Pay With
                                Razorpay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->


<!-- About Start -->
<div class="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="{{ url('/') }}/front_assets/aboutus_image/{{ $sitesetting['about_image1'] }}" alt="Image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-header">
                        <p>About Us</p>
                        <h2>Welcome to <i class="fa fa-utensils text-primary me-2"></i>{{ $sitesetting['website_name'] }}</h2>
                    </div>
                    <div class="about-text">
                        <p>{{ $sitesetting['about_description'] }}</p>

                        <a class="btn custom-btn" href="{{ url('table-booking') }}">Book A Table</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->



<!-- Feature Start -->
<div class="feature">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="section-header">
                    <p>Why Choose Us</p>
                    <h2>Our Key Features</h2>
                </div>
                <div class="feature-text">
                    <div class="feature-img">
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ url('/') }}/front_assets/img/feature-1.jpg" alt="Image">
                            </div>
                            <div class="col-6">
                                <img src="{{ url('/') }}/front_assets/img/feature-2.jpg" alt="Image">
                            </div>
                            <div class="col-6">
                                <img src="{{ url('/') }}/front_assets/img/feature-3.jpg" alt="Image">
                            </div>
                            <div class="col-6">
                                <img src="{{ url('/') }}/front_assets/img/feature-4.jpg" alt="Image">
                            </div>
                        </div>
                    </div>
                    <p>
                        The only place where the combination of beguiling décor, enthralling selections of bottles, and glowing hospitality, all driven by the profoundest desire to enchant and delight, can trigger a genuinely transcendental experience in every sip of your drink.
                    </p>
                    <a class="btn custom-btn" href="{{ url('menu') }}">Book A Table</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-item">
                            <i class="flaticon-cooking"></i>
                            <h3>World’s best Chef</h3>
                            <p>
                                I train my chefs with a blindfold. I’ll get my sous chef and myself to cook a dish. The young chef would have to sit down and eat it with a blindfold. If they can’t identify the flavor, they shouldn’t be cooking the dish. </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-item">
                            <i class="flaticon-vegetable"></i>
                            <h3>Natural ingredients</h3>
                            <p>
                                The key is to set realistic customer expectations and then not to just meet them, but to exceed them — preferably in unexpected and helpful ways.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-item">
                            <i class="flaticon-medal"></i>
                            <h3>What can we cook for you?</h3>
                            <p>
                                Our menu is exquisitely created with an entirely unique approach that is fun and familiar, yet innovative. Our immense concentration and focus on giving the best in class food across all cuisines has earned a huge customer base for the entire menu. </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-item">
                            <i class="flaticon-meat"></i>
                            <h3>Fresh vegetables & Meet</h3>
                            <p>
                                Nothing will benefit human health and increase the chances for survival of life on Earth as much as the evolution to a vegetarian diet.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Feature End -->




<div class="container">
    <div class="col-md-12">
        <div class="section-header text-center">
            <p>Food Menu</p>
            <h2>Delicious Food Menu</h2>
        </div>
    </div>
    <div id="slick">
        @foreach ($menuitem as $menuall )
        <div class="slide">
            <div class="item">
                <div class="product-card ">
                    <div class="product-card-img">
                        <label class="stock bg-danger">New</label>

                        <a href="{{ url('menu-item/'.$menuall['id']) }}">
                            @if($menuall->menu_item_name ==NULL)
                            <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}" style="width: 250px; height:250px" alt="{{$menuall->menu_item_name}}">
                            @else
              <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" style="width: 250px; height:250px" alt="No Image">-->
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
                @foreach ($menu as $menus)
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#category{{$menus->id}}">{{ $menus['menu_subcat_name']}}</a>
                </li>
                @endforeach

            </ul>
            <div class="tab-content">
                @php
                $getallmenu = App\Models\MenuItemPrice::orderBy('id', 'DESC')->limit(7)->get();
                @endphp
                <div id="burgers" class="container tab-pane active">
                    <div class="row">
                        <div class="col-lg-7 col-md-12">
                            @foreach ($getallmenu as $menuall)
                            <a href="{{ url('menu-item/'.$menuall['id']) }}">
                                <div class="menu-item">
                                    <div class="menu-img">
              <!--                          @if($menuall->menu_item_image==NULL)-->
              <!--                          <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}" alt="Image">-->
              <!--                            @else-->
              <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" alt="No Image">-->
 
              <!--              @endif-->
                <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                                    </div>
                                    <div class="menu-text">
                                        <h3><span>{{$menuall->menu_item_name}}</span><strong>Rs.{{$menuall->menu_item_price}}</strong></h3>

                                    </div>
                                </div>

                            </a>
                            @endforeach
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                            <div class="mt-3">
                            <?php echo DNS2D::getBarcodeHTML('https://dunkelbeverage.com/menu', 'QRCODE',8,8);  ?>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($menu as $menus)
                <div id="category{{$menus->id}}" class="container tab-pane fade">
                    @php
                    $catwiseProduct = App\Models\MenuItemPrice::where('menu_subcat_id', $menus->id)
                    ->orderBy('id', 'DESC')
                    ->limit(7)->get();
                    @endphp

                    <div class="row">
                        <div class="col-lg-7 col-md-12">
                            @foreach ($catwiseProduct as $menuitems)
                            <a href="{{ url('menu-item/'.$menuitems['id']) }}">
                                <div class="menu-item">

                                    <div class="menu-img">
              <!--                           @if($menuitems->menu_item_image ==NULL)-->
              <!--                          <img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuitems->menu_item_image }}" alt="Image">-->
              <!--                                   @else-->
              <!--<img src="{{ url('/') }}/front_assets/noimageAvailable.jpg" alt="No Image">-->
 
              <!--              @endif-->
                <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                                    </div>
                                    <div class="menu-text">
                                        <h3><span>{{$menuitems->menu_item_name}}</span> <strong>Rs.{{$menuitems->menu_item_price}}</strong></h3>
                                        {{-- <p>Lorem ipsum dolor sit amet elit. Phasel nec preti facil</p> --}}
                                    </div>

                                </div>
                            </a>
                            @endforeach
                        </div>

                        <div class="col-lg-5 d-none d-lg-block">
                            <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                            <?php echo DNS2D::getBarcodeHTML('https://dunkelbeverage.com/menu', 'QRCODE',8,8);  ?>
                            
                        </div>
                         
                    </div>

                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
<!-- Menu End -->




<!-- Contact Start -->
<div class="contact">
    <div class="container">
        <div class="section-header text-center">
            <p>Contact Us</p>
            <h2>Contact For Any Query</h2>
        </div>
        <div class="row align-items-center contact-information">
            <div class="col-md-6 col-lg-6">
                <div class="contact-info">
                    <div class="contact-icon">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Address</h3>
                        <p>{{ $sitesetting['addresss'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="contact-info">
                    <div class="contact-icon">
                        <i class="fa fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Call Us</h3>
                        <p>{{ $sitesetting['phone'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="contact-info">
                    <div class="contact-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Email Us</h3>
                        <p>{{ $sitesetting['email'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="contact-info">
                    <div class="contact-icon">
                        <i class="fa fa-share"></i>
                    </div>
                    <div class="contact-text">
                        <h3>Follow Us</h3>
                        <div class="contact-social">
                            <a href="{{ $sitesetting['twitter'] }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $sitesetting['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $sitesetting['youtube'] }}"><i class="fab fa-youtube"></i></a>
                            <a href="{{ $sitesetting['instagram'] }}"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row contact-form">
            <div class="col-md-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->



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


<script src="{{ url('/') }}/admin_assets/plugins/jquery/jquery.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function() {
        // rozarpay jquery---
        $('.razorpay-btn').click(function(e) {


            e.preventDefault();
            var cust_name = $('.cust_name').val();
            var cust_email = $('.cust_email').val();
            var cust_phone = $('.cust_phone').val();
            var table_booking_date = $('.table_booking_date').val();
            var no_person = $('.no_person').val();
            var table_type = $('.table_type').val();
            var message = $('.message').val();
            var payment_amount = $('.payment_amount').val();
            var table_booking_time = $('.table_booking_time').val();
            var table_booking_timeout = $('.table_booking_timeout').val();



            if (!cust_name) {
                cust_name_error = "cust_name  is required";
                $('#cust_name_error').html('');
                $('#cust_name_error').html(cust_name_error);
            } else {
                cust_name_error = "";
                $('#cust_name_error').html('');

            }
            if (!cust_email) {
                cust_email_error = "cust_email  is required";
                $('#cust_email_error').html('');
                $('#cust_email_error').html(cust_email_error);
            } else {
                cust_email_error = "";
                $('#cust_email_error').html('');

            }

            if (!cust_phone) {
                cust_phone_error = "cust_phone  is required";
                $('#cust_phone_error').html('');
                $('#cust_phone_error').html(cust_phone_error);
            } else {
                cust_phone_error = "";
                $('#cust_phone_error').html('');

            }


            if (!table_booking_date) {
                table_booking_date_error = "table_booking_date  is required";
                $('#table_booking_date_error').html('');
                $('#table_booking_date_error').html(table_booking_date_error);
            } else {
                table_booking_date_error = "";
                $('#table_booking_date_error').html('');

            }
            if (!no_person) {
                no_person_error = "no_person  is required";
                $('#no_person_error').html('');
                $('#no_person_error').html(no_person_error);
            } else {
                no_person_error = "";
                $('#no_person_error').html('');

            }

            if (!table_type) {
                table_type_error = "table_type  is required";
                $('#table_type_error').html('');
                $('#table_type_error').html(table_type_error);
            } else {
                table_type_error = "";
                $('#table_type_error').html('');

            }

            if (!message) {
                message_error = "message  is required";
                $('#message_error').html('');
                $('#message_error').html(message_error);
            } else {
                message_error = "";
                $('#message_error').html('');

            }
            if (!table_booking_time) {
                table_booking_time_error = "table_booking_time  is required";
                $('#table_booking_time_error').html('');
                $('#table_booking_time_error').html(table_booking_time_error);
            } else {
                table_booking_time_error = "";
                $('#table_booking_time_error').html('');

            }
            if (!table_booking_timeout) {
                table_booking_timeout_error = "table_booking_timeout  is required";
                $('#table_booking_timeout_error').html('');
                $('#table_booking_timeout_error').html(table_booking_timeout_error);
            } else {
                table_booking_timeout_error = "";
                $('#table_booking_timeout_error').html('');

            }



            if (cust_name_error != '' || cust_email_error != '' || cust_phone_error != '' || table_booking_date_error != '' ||
                no_person_error != '' || table_type_error != '' || message_error != '' ||
                table_booking_time_error != '') {
                return false;
            } else {




                var data = {
                    'cust_name': cust_name
                    , 'cust_email': cust_email
                    , 'cust_phone': cust_phone
                    , 'table_booking_date': table_booking_date
                    , 'no_person': no_person
                    , 'table_type': table_type
                    , 'message': message
                    , 'payment_amount': payment_amount
                    , 'table_booking_time': table_booking_time
                    , 'table_booking_timeout': table_booking_timeout,

                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    method: "post"
                    , url: "{{ url('/') }}/tablebooking-proceed-to-pay"
                    , data: data
                    , success: function(response) {
                        var options = {
                            "key": "rzp_test_T6cYO2ODoHQ6A9", // Enter the Key ID generated from the Dashboard
                            "amount": 500 * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            // "amount": response.total_price * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR"
                            , "name": response.cust_name
                            , "description": "Thank For chooseing us"
                            , "image": "https://example.com/your_logo",
                            // "order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function(razorpayresponse) {
                                // alert(razorpayresponse.razorpay_payment_id);
                                $.ajax({

                                    method: "post"
                                    , url: "{{ url('/') }}/store-table-booking"
                                    , data: {
                                        'payment_mode': 'Paid by Razorpay'
                                        , 'payment_id': razorpayresponse.razorpay_payment_id
                                        , 'cust_name': response.cust_name
                                        , 'cust_email': response.cust_email
                                        , 'cust_phone': response.cust_phone
                                        , 'table_booking_date': response.table_booking_date
                                        , 'no_person': response.no_person
                                        , 'table_type': response.table_type
                                        , 'message': response.message
                                        , 'payment_amount': response.payment_amount
                                        , 'table_booking_time': response.table_booking_time
                                        , 'table_booking_timeout': response.table_booking_timeout,


                                    }
                                    , success: function(
                                        razorpaysuccesresponse) {
                                        swal(razorpaysuccesresponse
                                                .status)
                                            .then((value) => {
                                                // window.location.reload();
                                                window.location.href = "{{ url('/') }}/table-booking";
                                            });


                                    }
                                });
                            }
                            , "prefill": {
                                "name": response.cust_name
                                , "email": response.cust_email
                                , "contact": response.cust_phone
                            },

                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp1 = new Razorpay(options);


                        rzp1.open();
                        e.preventDefault();

                        // alert(response.total_price);
                    }

                });

            }
        }); //end razorpay---



    });
</script>

@endsection