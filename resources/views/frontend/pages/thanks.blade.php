<?php use App\Models\MenuItemPrice;?>
@extends('frontend.layouts.layout')

@section('title', 'Thanks You')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Thank You</h2>
            </div>
            <div class="col-12">
                <a href="{{ url('/') }}">Home</a>
                <a href="">Thank You</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
      <!-- Cart-Page -->
      <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">
               <div class="col-lg-12" align="center">
                <h3>You Order has Been Place Successfully</h3>
                <p>
                    Your Order number is {{ Session::get('order_id') }} and Grand Total is Rs.{{ Session::get('grand_total') }}
                </p>
               </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Cart-Page /- -->

@endsection

<?php 
Session::forget('grand_total');
Session::forget('order_id');
?>
