@extends('frontend.layouts.layout')

@section('title','About Us')

@section('content')

  <!-- Page Header Start -->
  <div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>About Us</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">About Us</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->





<!-- About Start -->
<div class="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="{{ url('/') }}/front_assets/img/about.jpg" alt="Image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-header">
                        <p>About Us</p>
                        <h2>{{ $sitesetting['website_name'] }}</h2>
                    </div>
                    <div class="about-text">
                        <p>
                            {{ $sitesetting['about_description'] }}
                        </p>
                      
                        <a class="btn custom-btn" href="">Experience::-{{ $sitesetting['total_exp'] }}</a>
                        <a class="btn custom-btn" href="">Master Chefs::-{{ $sitesetting['master_chefs'] }}</a>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->






@endsection