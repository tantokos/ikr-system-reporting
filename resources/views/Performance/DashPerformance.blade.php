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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/font-awesome/css/font-awesome.min.css') }}">

    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">


    {{-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('assets/datatables/datatables-1.13.6/css/jquery.datatables.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('asset/DataTables/datatables.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="index.html">
                            <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                                </div>
                            </li>
                            {{-- <li class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                </div>
                            </div>
                        </li> --}}
                            {{--  <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li> --}}
                        </ul>
                        <ul class="nav-right">
                            {{-- <li class="header-notification">
                            <a href="#!">
                                <i class="ti-bell"></i>
                                <span class="badge bg-c-pink"></span>
                            </a>
                            <ul class="show-notification">
                                <li>
                                    <h6>Notifications</h6>
                                    <label class="label label-danger">New</label>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius" src="assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">John Doe</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius" src="assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Joseph William</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius" src="assets/images/avatar-3.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Sara Soudein</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li> --}}

                            <li class="user-profile header-notification">
                                <a href="#!">
                                    <img src="{{ asset('assets/images/avatar-4.jpg ') }}" class="img-radius"
                                        alt="User-Profile-Image">
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    {{-- <li>
                                    <a href="#!">
                                        <i class="ti-settings"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="ti-user"></i> Profile
                                    </a>
                                </li>
            
                                <li>
                                    <a href="#">
                                        <i class="ti-lock"></i> Lock Screen
                                    </a>
                                </li> --}}
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
                                <span class="searchbar-toggle"> </span>
                                <div class="pcoded-search-box ">
                                    <input type="text" placeholder="Search">
                                    <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                            <ul class="pcoded-item pcoded-left-item">
                                {{-- <li class="">
                                <a href="{{ route('dashWo') }}">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> --}}
                                <li class="{{ request()->is('dashEmployee*') ? 'active' : '' }}">
                                    <a href="{{ route('dashEmployee') }}">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard Karyawan</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('dashAset*') ? 'active' : '' }}">
                                    <a href="{{ route('dashAset.index') }}">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard Aset</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('dashTim*') ? 'active' : '' }}">
                                    <a href="{{ route('dashTim.index') }}">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard Tim</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                {{-- <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Components</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class=" ">
                                        <a href="accordion.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Accordion</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="breadcrumb.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Breadcrumbs</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="button.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Button</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="tabs.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Tabs</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="color.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Color</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="label-badge.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Label Badge</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="tooltip.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Tooltip</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="typography.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Typography</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="notification.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Notification</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="icon-themify.html">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Themify</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                    
                                </ul>
                            </li> --}}
                            </ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li
                                    class="pcoded-hasmenu pcoded-trigger {{ request()->is('employee*', 'branch*', 'callsignLead*', 'callsignTim*', 'fat*', 'aset*') ? 'active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data
                                            Master</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ request()->is('employee*') ? 'active' : '' }}">
                                            <a href="/employee">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    Karyawan</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('branch*') ? 'active' : '' }} ">
                                            <a href="{{ route('branch.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    Branch</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('callsignLead*') ? 'active' : '' }} ">
                                            <a href="{{ route('callsignLead.index') }}">
                                                {{-- <a href="/callsignLeadShow/2"> --}}
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    Lead Callsign</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('callsignTim*') ? 'active' : '' }} ">
                                            <a href="{{ route('callsignTim.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    Callsign</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('fat*') ? 'active' : '' }}">
                                            <a href="{{ route('fat.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    FAT & Cluster</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        {{-- <li class="{{ request()->is('tool*') ? 'active' : '' }}">
                                        <a href="#">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Tools</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}
                                        <li class="{{ request()->is('aset*') ? 'active' : '' }}">
                                            <a href="{{ route('aset.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data
                                                    Asset</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        {{-- <li class="{{ request()->is('Wh*') ? 'active' : '' }}  ">
                                        <a href="{{ route('warehouse.index') }}">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Warehouse</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}
                                        {{-- <li class="{{ request()->is('import*') ? 'active' : '' }} ">
                                        <a href="{{ route('import.index') }}">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data import</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}
                                        {{-- <li class="{{ request()->is('batchWO*') ? 'active' : '' }} ">
                                        <a href="{{ route('batchWO.index') }}">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Batch WO</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}
                                        {{-- <li class="{{ request()->is('batchWOI*') ? 'active' : '' }} ">
                                        <a href="{{ route('batchWOIdx.index') }}">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Batch idx</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}
                                    </ul>
                            </ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>

                            <ul class="pcoded-item pcoded-left-item">
                                <li
                                    class="pcoded-hasmenu pcoded-trigger {{ request()->is('transaksi*') ? 'active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                                        <span class="pcoded-mtext"
                                            data-i18n="nav.basic-components.main">Transaksi</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ request()->is('peminjaman*') ? 'active' : '' }}  ">
                                            <a href="{{ route('peminjaman.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext"
                                                    data-i18n="nav.form-components.main">Distribusi Aset</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="{{ request()->is('pengembalian*') ? 'active' : '' }}  ">
                                            <a href="{{ route('pengembalian.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext"
                                                    data-i18n="nav.form-components.main">Pengembalian Aset</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>



                                        {{-- <li class="{{ request()->is('monitMT*') ? 'active' : '' }}  ">
                                        <a href="{{ route('monitMTFtth.index')}}">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO MT FTTH</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO Dismantle</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO IB FTTX</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO MT FTTX</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> --}}

                                    </ul>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                                <li
                                    class="pcoded-hasmenu pcoded-trigger {{ request()->is('monit*') ? 'active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                                        <span class="pcoded-mtext"
                                            data-i18n="nav.basic-components.main">Monitoring</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="#">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO IB
                                                    FTTH</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('monitMT*') ? 'active' : '' }}  ">
                                            <a href="{{ route('monitMTFtth.index') }}">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO MT
                                                    FTTH</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="#">

                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO
                                                    Dismantle</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="#">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO IB
                                                    FTTX</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="#">
                                                <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">WO MT
                                                    FTTX</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>
                            </ul>

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms"></div>




                        </div>
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



                                        <div class="row">
                                            <div class="col-md-12">

                                                <div id="reportrange"
                                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        {{-- </div>   --}}
                                        <!-- order-card end -->

                                        <!-- statustic and process start -->

                                        <!-- <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        {{-- <div style="position: relative"> --}}
                                                                        <canvas id="Month-chart"></canvas>
                                                                        {{-- </div> --}}
                                                                    </div>
                                                                </div>
                                                            </div> -->


                                        <div class="row">

                                            <div class="col col-lg-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaktim" value="">
                                                                <span class="text-inverse"><small>All
                                                                        Branch</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaktim" value="">
                                                                <span class="text-inverse"><small>Jakarta
                                                                        Timur</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Jakarta
                                                                        Selatan</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Jakarta
                                                                        Pusat</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Jakarta
                                                                        Utara</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Bekasi</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Bogor</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span
                                                                    class="text-inverse"><small>Tangerang</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Medan</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Pangkal
                                                                        Pinang</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span
                                                                    class="text-inverse"><small>Pontianak</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Jambi</small></span>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label>
                                                                <input type="checkbox" id="jaksel" value="">
                                                                <span class="text-inverse"><small>Bali</small></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-sm">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                {{-- <div style="position: relative"> --}}
                                                                <canvas id="posisiBranch-timurIB"></canvas>
                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                {{-- <div style="position: relative"> --}}
                                                                <canvas id="posisiBranch-off"></canvas>
                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                {{-- <div style="position: relative"> --}}
                                                                <canvas id="posisiBranch-ijin/cuti"></canvas>
                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                {{-- <div style="position: relative"> --}}
                                                                <canvas id="posisiBranch-absen"></canvas>
                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                        </div>

                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{-- <div style="position: relative"> --}}
                                                        <canvas id="posisiBranch-selatanIB"></canvas>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{-- <div style="position: relative"> --}}
                                                        <canvas id="posisiBranch-selatanMT"></canvas>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{-- <div style="position: relative"> --}}
                                                        <canvas id="posisiBranch-BekasiIB"></canvas>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        {{-- <div style="position: relative"> --}}
                                                        <canvas id="posisiBranch-BekasiMT"></canvas>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

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
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
    integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });


    const ctxPosTimurIB = document.getElementById('posisiBranch-timurIB');

    new Chart(ctxPosTimurIB, {
        type: 'line',
        data: {
            labels: ['Januari', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Absensi Kehadiran Karyawan',
                data: ['27', '24', '26', '23', '21', '24', '25', '27', '24', '23', '25', '26'],
                // backgroundColor: backgroundTimur,
                datalabels: {
                    align: 'end',
                    anchor: 'start'
                },
                backgroundColor: [
                    'rgb(153, 102, 255)'
                    
                ],
                borderColor: [
                    'rgb(153, 102, 255)'
                    
                ],
                // borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        stepSize: 15,
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosOff = document.getElementById('posisiBranch-off');

    new Chart(ctxPosOff, {
        type: 'line',
        data: {
            labels: ['Januari', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Absensi Off Karyawan',
                data: ['8', '7', '8', '7', '7', '8', '7', '7', '8', '8', '7', '8'],
                // backgroundColor: backgroundTimur,
                datalabels: {
                    align: 'end',
                    anchor: 'start'
                },
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 0.6)',
                ],

            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        stepSize: 10,
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosIjin = document.getElementById('posisiBranch-ijin/cuti');

    new Chart(ctxPosIjin, {
        type: 'line',
        data: {
            labels: ['Januari', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Absensi Ijin/Cuti Karyawan',
                data: ['1', '0', '0', '2', '0', '0', '0', '1', '0', '0', '0', '1'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [

                    'rgba(201, 203, 207)'
                ],
                borderColor: [

                    'rgb(201, 203, 207)'
                ],
                datalabels: {
                    align: 'end',
                    anchor: 'start'
                }

            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        stepSize: 8,
                    },
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosAbsen = document.getElementById('posisiBranch-absen');

    new Chart(ctxPosAbsen, {
        type: 'line',
        data: {
            labels: ['Januari', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Karyawan Absen',
                data: ['0', '0', '0', '1', '0', '1', '0', '0', '0', '1', '0', '0'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [

                'rgba(255, 99, 132, 0.6)',
                ],
                borderColor: [

                'rgba(255, 99, 132, 0.6)',
                ],
                datalabels: {
                    align: 'end',
                    anchor: 'start'
                }

            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        stepSize: 4,
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosTimurMT = document.getElementById('posisiBranch-timurMT');

    new Chart(ctxPosTimurMT, {
        type: 'bar',
        data: {
            labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
            datasets: [{
                label: 'Jumlah Tim Maintenance - Jakarta Timur',
                data: ['2', '12', '36'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        // stepSize: 5
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosSelatanIB = document.getElementById('posisiBranch-selatanIB');

    new Chart(ctxPosSelatanIB, {
        type: 'bar',
        data: {
            labels: ['Leader Installer', 'Callsign Tim Installer', 'Installer'],
            datasets: [{
                label: 'Jumlah Tim Installer - Jakarta Selatan',
                data: ['2', '8', '24'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        // stepSize: 5
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosSelatanMT = document.getElementById('posisiBranch-selatanMT');

    new Chart(ctxPosSelatanMT, {
        type: 'bar',
        data: {
            labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
            datasets: [{
                label: 'Jumlah Tim Maintenance - Jakarta Selatan',
                data: ['3', '15', '44'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        // stepSize: 5
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosBekasiIB = document.getElementById('posisiBranch-BekasiIB');

    new Chart(ctxPosBekasiIB, {
        type: 'bar',
        data: {
            labels: ['Leader Installer', 'Callsign Tim Installer', 'Installer'],
            datasets: [{
                label: 'Jumlah Tim Installer - Bekasi',
                data: ['1', '7', '21'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        // stepSize: 5
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });

    const ctxPosBekasiMT = document.getElementById('posisiBranch-BekasiMT');

    new Chart(ctxPosBekasiMT, {
        type: 'bar',
        data: {
            labels: ['Leader Maintenance', 'Callsign Tim Maintenance', 'Maintenance'],
            datasets: [{
                label: 'Jumlah Tim Maintenance - Bekasi',
                data: ['2', '8', '19'],
                // backgroundColor: backgroundTimur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        // stepSize: 5
                    }
                },

            }
        },
        plugins: [ChartDataLabels]

    });
</script>

</html>
