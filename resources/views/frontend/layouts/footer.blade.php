@php
$sitesetting = App\Models\SiteSetting::first();

 @endphp

<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-contact">
                            <h2>Our Address</h2>
                            <p><i class="fa fa-map-marker-alt"></i>{{ $sitesetting['addresss'] }}</p>
                            <p><i class="fa fa-phone-alt"></i>{{ $sitesetting['phone'] }}</p>
                            <p><i class="fa fa-envelope"></i>{{ $sitesetting['email'] }}</p>
                            <div class="footer-social">
                                <a href="{{ $sitesetting['twitter'] }}"><i class="fab fa-twitter"></i></a>
                                <a href="{{ $sitesetting['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{ $sitesetting['youtube'] }}"><i class="fab fa-youtube"></i></a>
                                <a href="{{ $sitesetting['instagram'] }}"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-link">
                            <h2>Quick Links</h2>
                            <a href="{{ url('term-condition') }}">Terms of use</a>
                            <a href="{{ url('privacy-policy') }}">Privacy policy</a>
                            <a href="{{ url('table-booking') }}">Reservation</a>
                            <a href="{{ url('contact') }}">Contact Us</a>
                            <a href="{{'about'}}">About</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="footer-newsletter">
                    <h2>Scan Code To Get Menu</h2>
                    <p>
                        <?php echo DNS2D::getBarcodeHTML('https://dunkelbeverage.com/menu', 'QRCODE',5,5);  ?>
                    </p>
                    <div class="form">
                        <input class="form-control" placeholder="Email goes here">
                        <button class="btn custom-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>Copyright &copy; <a href="#">{{ $sitesetting['website_name'] }}</a>, All Right Reserved.</p>
            <p>Designed By <a href="http://uifstechnologies.com/">Uifs Technlogies</a></p>
        </div>
    </div>
</div>
<!-- Footer End -->
