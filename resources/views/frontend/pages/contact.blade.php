@extends('frontend.layouts.layout')

@section('title','Contact Us')

@section('content')

  <!-- Page Header Start -->
  <div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Contact Us</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Contact</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->



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
<!-- Contact End -->


@endsection