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
                            {{-- @include('layout.sidebarAset') --}}
                            <div class="pcoded-inner-navbar main-menu">

                                <div class="pcoded-search">
                                    <span class="searchbar-toggle"> </span>
                                    <div class="pcoded-search-box ">
                                        <input type="text" placeholder="Search">
                                        <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                                <ul class="pcoded-item pcoded-left-item">
                                    
                                    
                                    <li class="{{ request()->is('report*','/') ? 'active' : '' }}">
                                        <a href="{{ route('report.index') }}">
                                            <span class="pcoded-micon"><i class="ti-home"></i><b>I</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Ikr Monthly Report</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    
                                </ul>
                                
                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li
                                        class="pcoded-hasmenu pcoded-trigger {{ request()->is('importftthmt*', 'branch*', 'callsignLead*', 'callsignTim*','fat*','aset*') ? 'active' : '' }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Master</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            
                                            
                                            <li class="{{ request()->is('importftthmt*') ? 'active' : '' }}">
                                                <a href="{{ route('import.ftthmttempIndex') }}">
                                                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth MT</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                </ul>
                            
                                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                            
                                <ul class="pcoded-item pcoded-left-item">
                                    <li
                                        class="pcoded-hasmenu pcoded-trigger {{ request()->is('peminjaman*','pengembalian*','disposal*') ? 'active' : '' }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Transaksi</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ request()->is('peminjaman*') ? 'active' : '' }}  ">
                                                <a href="{{ route('peminjaman.index') }}">
                                                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Distribusi Aset</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                            
                                            <li class="{{ request()->is('pengembalian*') ? 'active' : '' }}  ">
                                                <a href="{{ route('pengembalian.index') }}">
                                                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Pengembalian Aset</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>

                                            <li class="{{ request()->is('disposal*') ? 'active' : '' }}  ">
                                                <a href="{{ route('disposal.index') }}">
                                                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Disposal Aset</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        </ul>
                                </ul>
                            
                            
                               
                            </div>

                        <!-- End aset nav -->
                        
                        

                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <div class="page-wrapper">
								
									<!-- Page-header start -->
                                    {{-- <div class="page-header card">
                                        <div class="card-block">
                                            <h5 class="m-b-10">Sample Page</h5>
                                            <p class="text-muted m-b-10">lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                            <ul class="breadcrumb-title b-t-default p-t-10">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Pages</a></li>
                                                <li class="breadcrumb-item"><a href="#!">Sample page</a></li>
                                            </ul>
                                        </div>
                                    </div> --}}
                                    <!-- Page-header end -->
                                    
                                    <!-- awal Content -->
                                    <div class="page-body">
                                        {{-- <div class="row"> --}}
                                            {{-- <div class="col-sm-12"> --}}
                                                {{-- <div class="card"> --}}
                                                    {{-- <div class="card-header"> --}}

                                                        @yield('content')

                                                    {{-- </div>  --}}
                                                {{-- </div> --}}
                                            {{-- </div> --}}
                                        {{-- </div> --}}
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
