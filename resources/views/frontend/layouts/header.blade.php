 @php
$sitesetting = App\Models\SiteSetting::first();

 @endphp

<div class="navbar navbar-expand-lg bg-light navbar-light">
    <div class="container-fluid">
        <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ url('/') }}/front_assets/img/logo.png" alt="Dunkel beverage Logo"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto premier-topnav" id="premier-topnav">
                <a href="{{ url('/') }}" class="nav-item nav-link ">Home</a>
                <a href="{{ url('about') }}" class="nav-item nav-link">About</a>
                <a href="{{ url('service') }}" class="nav-item nav-link">Service</a>
                <a href="{{ url('menu') }}" class="nav-item nav-link">Menu</a>
                <a href="{{ url('table-booking') }}" class="nav-item nav-link">Booking</a>
              
                <a href="{{ url('contact') }}" class="nav-item nav-link">Contact</a>
                  <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">@if(Auth::check()) {{ Auth::user()->name }} @else Login/Register  @endif</a>
                    <div class="dropdown-menu">
                        @if(Auth::check())
                        <a href="{{url('/')}}/view-cart" class="dropdown-item">My Cart</a>
                       
                        <a href="{{route('profile.edit')}}" class="dropdown-item">Dashboard</a>
                        <a href="{{url('/') }}/my-order-list" class="dropdown-item">My Order</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
        
                             
                            <a href="{{ route('logout') }}"  onclick="event.preventDefault();  this.closest('form').submit();" class="dropdown-item">Logout</a>
                        </form>
                        @else
                        <a href="{{url('login')}}" class="dropdown-item">Login</a>
                        <a href="{{url('register')}}" class="dropdown-item">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

