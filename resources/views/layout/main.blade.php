<!DOCTYPE html>
<html lang="en">

<head>

    @include('layout.head')

</head>

<body>
	  {{-- <div class="fixed-button">
		<a href="https://codedthemes.com/item/gradient-able-admin-template" target="_blank" class="btn btn-md btn-primary">
			<i class="fa fa-shopping-cart" aria-hidden="true"></i> Upgrade To Pro
		</a>
	  </div> --}}
        <!-- Pre-loader start -->
    {{-- <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div> --}}
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
               @include('layout.navbar');
           </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        {{-- <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div> --}}
                        
                       
                        <!-- aset nav -->
                            @include('layout.sidebar')
                           

                        <!-- End aset nav -->
                        
                        

                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <div class="page-wrapper">
								

                                    <div class="page-body">

                                                        @yield('content')

                                    </div>
                                    <!-- akhir Content -->
                                </div>
                            </div>
                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
<!--[if lt IE 9]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('assets/js/modernizr/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/modernizr/css-scrollbars.js') }}"></script>

<!-- Custom js -->
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>

<script src="{{ asset('assets/js/vartical-demo.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
{{-- <script src="assets/js/app.js"></script> --}}


</body>
{{-- <script src="{{ asset('assets/js/pcoded.min.js') }}"></script> --}}
@yield('script')

</html>
