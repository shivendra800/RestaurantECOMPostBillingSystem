@extends('frontend.layouts.layout')

@section('title','Service')

@section('content')
  <!-- Page Header Start -->
  <div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Why Choose Us</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Features</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


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
                                I train my chefs with a blindfold. I’ll get my sous chef and myself to cook a dish. The young chef would have to sit down and eat it with a blindfold. If they can’t identify the flavor, they shouldn’t be cooking the dish.                                        </p>
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
                                Our menu is exquisitely created with an entirely unique approach that is fun and familiar, yet innovative. Our immense concentration and focus on giving the best in class food across all cuisines has earned a huge customer base for the entire menu.                                        </p>
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

@endsection