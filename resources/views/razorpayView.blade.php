@extends('frontend.layouts.layout')

@section('title','Razorpay Payment Gateway')

@section('content')


<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Razorpay Payment Gateway</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Razorpay</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3 col-md-offset-6">

            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {{ $message }}
                </div>
            @endif

            {{-- @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif --}}

            <div class="card card-default">
                <div class="card-header">
                    Dunkle Beverage - Razorpay Payment Gateway
                </div>
               

        
                <div class="card-body text-center">
                    <form action="{{ route('razorpay.payment.store') }}" method="POST" >
                        @csrf

                        <input class="form-control " type="hidden" name="order_id" id="order_id" value="{{ Session::get('order_id') }}">
                       
                       
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env('RAZORPAY_KEY') }}"
                                data-amount="{{ $order->grand_total *100 }}"
                                data-buttontext="Pay {{ $order->grand_total }} INR"
                                data-name="Dunkle Beverage"
                                data-description="Rozerpay"
                                data-image="{{ url('/') }}/front_assets/img/logo.png"
                                data-prefill.name="{{ $order->name }}"
                                data-prefill.email="{{ $order->email }}"
                                data-prefill.contact="{{ $order->mobile }}"
                                data-theme.color="#ff7529">
                        </script>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>



@endsection