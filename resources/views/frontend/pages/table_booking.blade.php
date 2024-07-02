@extends('frontend.layouts.layout')

@section('title','Table Booking')

@section('content')


 <!-- Page Header Start -->
 <div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Book A Table</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Booking</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Booking Start -->
<div class="booking">
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
                                <input type="text" class="form-control cust_name " id="name" name="cust_name"   placeholder="Your Name">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-user"></i></div>
                                    
                                </div>
                            </div>
                            <span id="cust_name_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="email" class="form-control cust_email" id="email" name="cust_email"  placeholder="Your Email">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                </div>
                              
                            </div>
                            <span id="cust_email_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="number" class="form-control cust_phone" id="phone" name="cust_phone"  placeholder="Your Phone Number">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-mobile-alt"></i></div>
                                </div>
                               
                            </div>
                            <span id="cust_phone_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input table_booking_date" name="table_booking_date" placeholder="Date" data-target="#date" data-toggle="datetimepicker"/>
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                               
                            </div>
                            <span id="table_booking_date_error" class="text-danger"></span>
                        </div>
                        <div class="control-group">
                            <div class="input-group time" id="time" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input table_booking_time" name="table_booking_time" placeholder="Check In-Time" data-target="#time" data-toggle="datetimepicker"/>
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
                                <input type="number" class="form-control no_person" id="email" name="no_person"  placeholder="Enter No Of Person">
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
                                <input type="text" class="form-control message" id="email" name="message"  placeholder="Enter Your Message">
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
                $getallmenu = App\Models\MenuItemPrice::orderBy('id', 'DESC')->get();
            @endphp
                <div id="burgers" class="container tab-pane active">
                    <div class="row">
                        <div class="col-lg-7 col-md-12">
                            @foreach ($getallmenu as $menuall)
                            <div class="menu-item">
                                <div class="menu-img">
                                    <!--<img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuall->menu_item_image }}" alt="Image">-->
                                     <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                                </div>
                                <div class="menu-text">
                                    <h3><span>{{$menuall->menu_item_name}}</span> <strong>Rs.{{$menuall->menu_item_price}}</strong></h3>
                             
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                        </div>
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
                        <div class="col-lg-7 col-md-12">
                            @foreach ($catwiseProduct as $menuitems)
                            <div class="menu-item">
                                <div class="menu-img">
                                    <!--<img src="{{ url('/') }}/front_assets/menu_item_image/{{ $menuitems->menu_item_image }}" alt="Image">-->
                                     <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                                </div>
                                <div class="menu-text">
                                    <h3><span>{{$menuitems->menu_item_name}}</span> <strong>Rs.{{$menuitems->menu_item_price}}</strong></h3>
                                    {{-- <p>Lorem ipsum dolor sit amet elit. Phasel nec preti facil</p> --}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <!--<img src="{{ url('/') }}/front_assets/menu_img/{{$menus->menu_image}}" alt="Image">-->
                            <img src="{{ url('/') }}/front_assets/img/menu-burger-img.jpg" alt="Image">
                        </div>
                    </div>
                   
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Menu End -->


<!-- Reservation Start -->

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
            no_person_error != '' || table_type_error != '' || message_error != ''  ||
            table_booking_time_error != '' ) {
                    return false;
            }else{

            
         
           
                var data = {
                    'cust_name': cust_name,
                    'cust_email': cust_email,
                    'cust_phone': cust_phone,
                    'table_booking_date': table_booking_date,
                    'no_person': no_person,
                    'table_type': table_type,
                    'message': message,
                    'payment_amount': payment_amount,
                    'table_booking_time': table_booking_time,
                    'table_booking_timeout': table_booking_timeout,
                     
                     }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    method: "post",
                    url: "{{ url('/') }}/tablebooking-proceed-to-pay",
                    data: data,
                    success: function(response) {
                        var options = {
                            "key": "rzp_test_T6cYO2ODoHQ6A9", // Enter the Key ID generated from the Dashboard
                            "amount": 500*100 , // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            // "amount": response.total_price * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": response.cust_name,
                            "description": "Thank For chooseing us",
                            "image": "https://example.com/your_logo",
                            // "order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function(razorpayresponse) {
                                // alert(razorpayresponse.razorpay_payment_id);
                                $.ajax({

                                    method: "post",
                                    url: "{{ url('/') }}/store-table-booking",
                                    data: {
                                        'payment_mode': 'Paid by Razorpay',
                                        'payment_id': razorpayresponse.razorpay_payment_id,
                                        'cust_name': response.cust_name,
                                        'cust_email': response.cust_email,
                                        'cust_phone': response.cust_phone,
                                        'table_booking_date': response.table_booking_date,
                                        'no_person': response.no_person,
                                        'table_type': response.table_type,
                                        'message': response.message,
                                        'payment_amount': response.payment_amount,
                                        'table_booking_time': response.table_booking_time,
                                        'table_booking_timeout': response.table_booking_timeout,
                                         
                                             
                                    },
                                    success: function(
                                        razorpaysuccesresponse) {
                                        swal(razorpaysuccesresponse
                                                .status)
                                            .then((value) => {
                                                // window.location.reload();
                                                window.location.href = "{{ url('/') }}/table-booking";
                                            });


                                    }
                                });
                            },
                            "prefill": {
                                "name": response.cust_name,
                                "email": response.cust_email,
                                "contact": response.cust_phone
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

@section('script')


@endsection