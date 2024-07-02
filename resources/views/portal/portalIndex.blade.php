<!DOCTYPE html>
<html lang="en">

<head>

    <title>IKR System </title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Gradient Able Bootstrap admin template made using Bootstrap 4. The starter version of Gradient Able is completely free for personal project." />
    <meta name="keywords"
        content="flat ui, admin , Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="codedthemes">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}>
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets/icon/font-awesome/css/font-awesome.min.css')}}">

    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/icofont/css/icofont.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}">



    <link href="{{asset('assets/datatables/datatables-1.13.6/css/jquery.datatables.min.css')}}"
        rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



</head>

<body>

    <!-- Pre-loader start -->

    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">


                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                                </div>
                            </li>


                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <a href="#">
                                    <img src="{{ asset('assets/images/avatar-4.jpg ') }}" class="img-radius" alt="User-Profile-Image">
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>

                        <div class="pcoded-inner-navbar main-menu">

                            <div class="pcoded-search">
                                <div class="pcoded-search-box ">
                                </div>
                            </div>
                            <ul class="pcoded-item pcoded-left-item"></ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms"></div>
                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/logo-misitel-ico2.png') }}">
                                </div>
                                <div class="text-center">
                                </div>
                            </div>
                            <ul class="pcoded-item pcoded-left-item"></ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms"></div>
                            <div >

                                <div class="form-group text-center">
                                    <img src="{{ asset('storage/image-kry/' . $emp->foto_karyawan) }}" style="width: 100px;height: 100px;" class="img-radius" alt="User-Profile-Image">
                                </div>

                                <div class="form-group text-center">
                                    <h5>{{ $emp->nama_karyawan}}</h5>
                                </div>
                                <hr>
                                <div class="form-group text-center">
                                    <p>{{ $emp->nik_karyawan}}</p>
                                </div>
                                <div class="form-group text-center">
                                    <p>{{ $emp->email}}</p>
                                </div>
                                <div class="form-group text-center">
                                    <p>{{ $emp->posisi }}</p>
                                </div>
                            </div>
                        </div>

                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">

                                        <h1 class="h3 mb-2 text-gray-800">PT. Mitra Sinergi Telematika</h1>
                                        <hr>
                                        
                                       
                                        <div class="row">
                                            @for ($p = 0; $p<count($portal); $p++ )
                                            <div class="col-sm-4 col-lg-6">
                                                <div class="card bg-light">

                                                    <div class="card-block text-center">
                                                        @if($portal[$p]->portal_link == '#')
                                                        <div classs="text-center"><a href="#"><i class="ti-list fs-4"></i></a>
                                                        </div>
                                                        @else
                                                        <div classs="text-center"><a  href="{{ route($portal[$p]->portal_link) }}"><i class="ti-list fs-4"></i></a>
                                                        </div>
                                                        @endif
                                                        <strong>{{ $portal[$p]->portal_menu }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfor
                                            
                                            {{-- <div class="col-sm-4 col-lg-6">
                                                <div class="card bg-light"> 

                                                    <div class="card-block text-center">
                                                        <div class="text-center"><a href="{{ route('dashAset.index') }}"><i class="ti-layout-grid3 fs-4"></i></a>
                                                        </div>
                                                        <strong>Inventory Assets</strong>
                                                    </div>
                                                </div>
                                            </div> --}}


                                            {{-- <div class="col-sm-4 col-lg-6">
                                                <div class="card bg-light">

                                                    <div class="card-block text-center">
                                                        <div class="text-center"><a href="{{ route('dashEmployee') }}"><i class="ti-user fs-4"></i></a></div>
                                                        <strong>Human Resource</strong>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-sm-4 col-lg-6">
                                                <div class="card bg-light">

                                                    <div class="card-block text-center">
                                                        <div class="text-center"><a href="#"><i class="ti-stats-up fs-4"></i></a></div>
                                                        <strong>Performance Karyawan</strong>
                                                    </div>
                                                </div>
                                            </div> --}}


                                        </div>
                                    </div>















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
    <script type="text/javascript" src="{{asset('assets/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/popper.js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{asset('assets/js/modernizr/modernizr.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/modernizr/css-scrollbars.js')}}"></script>

    <!-- Custom js -->
    <script type="text/javascript" src="{{asset('assets/js/script.js')}}"></script>

    <script src="{{asset('assets/js/vartical-demo.js')}}"></script>
    <script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>



</body>


</html>
