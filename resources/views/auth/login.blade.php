@extends('frontend.layouts.layout')

@section('title','Login')

@section('content')


<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Login</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Login</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Booking Start -->
<div class="booking mt-5">
    <div class="" style="background-image: url({{url('front_assets/img/feature-2.jpg')}});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-3"></div>
            <div class="col-lg-6">
                <div class="booking-form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="control-group">
                            <div class="input-group">
                                <input type="email" class="form-control email" id="email" name="email" placeholder="Your Email">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>
                        <div class="control-group">
                            <div class="input-group">
                                <input type="password" class="form-control password" id="email" name="password" placeholder="Your Password">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="far fa-eye"></i></div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>


                        <div>
                            <button class="btn custom-btn " type="submit">Login</button>


                        </div>
                    </form>
                    <div class="control-group">
                        <div class="input-group">
                            <a class="text-danger" href="{{ route('register') }}">
                                {{ __('Registered Your Self?') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
</div>


@endsection

@section('script')


@endsection