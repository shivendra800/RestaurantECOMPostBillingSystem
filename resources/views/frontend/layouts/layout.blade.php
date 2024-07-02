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
        <script src="{{url('/')}}/admin_assets/plugins/jquery/jquery.min.js"></script>
        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/front_assets/lib/animate/animate.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/front_assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/front_assets/lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="{{ url('/') }}/front_assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

        <!-- Template Stylesheet -->
        <link href="{{ url('/') }}/front_assets/css/style.css" rel="stylesheet">
        <script type="text/javascript" src="{{url('front_assets/custom.js')}}"></script>
      


    </head>

    <body>
        {{-- <div class="loader">
            <img src="{{ asset('front_assets/loader.gif') }}" alt="loading..." />
         </div> --}}
        <!-- Nav Bar Start -->
         @include('frontend.layouts.header')
        <!-- Nav Bar End -->


          @yield('content')


        <!-- Footer Start -->
         @include('frontend.layouts.footer')
        <!-- Footer End -->

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
     {{-- @yield('script') --}}
        <!-- JavaScript Libraries -->
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
              for(i=0;i<linkObj.length;i++) { 
                if(document.location.href.indexOf(linkObj[i].href)>=0) {
                  linkObj[i].classList.add("active");
                }
              }
            }
            
            window.onload = setActive;
            </script>   
    </body>
</html>
