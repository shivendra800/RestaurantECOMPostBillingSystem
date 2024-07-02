@extends('frontend.layouts.layout')

@section('title','Privacy Policy')

@section('content')


  <!-- Page Header Start -->
  <div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Privacy Policy</h2>
            </div>
            <div class="col-12">
                <a href="{{ url('/') }}">Home</a>
                <a href="">Privacy Policy</a>
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
                    <img src="{{ url('/') }}/front_assets/img/about.jpg" alt="Image" style="height: 1200px">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-header">
                        <p>Privacy Policy</p>
                        <h2>{{ $sitesetting['website_name'] }}</h2>
                    </div>
                    <div class="about-text">
                        
                        <p>
                            {{ $sitesetting['privacy_policy'] }}
                        </p>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


@endsection