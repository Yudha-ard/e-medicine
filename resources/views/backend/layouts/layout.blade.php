<!DOCTYPE html>
<htm llang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>@yield('title') | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-widt, initial-scale=1.0">
        <meta content="E-Medicine" name="description" />
        <meta content="Kelompok-1" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('frontend/assets/images/logo-dark.png') }}">

        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ URL::asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ URL::asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <script src="{{ URL::asset('backend/assets/js/pages/apexcharts.js') }}"></script>
    </head>

    <!-- <body data-sidebar="dark" data-layout-mode="dark"> -->
    <body data-sidebar="colored">
        @include('sweetalert::alert')
 
        <!-- Begin page -->
        <div id="layout-wrapper">
 
            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ URL::asset('backend/assets/images/logo-dark-mini.png') }}" alt="" height="20">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ URL::asset('backend/assets/images/logo-dark.png') }}" alt="" height="45">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        
                    <div class="d-flex" style="position: fixed; right: 20px;">
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ URL::asset('storage/images/user/'.Auth::user()->img_profile)}}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="margin-left: -95px">
                                <!-- item-->
                                <a class="dropdown-item d-block" href="{{ Auth::user()->role === 'administrator' ? route('admin.profile') : (Auth::user()->role === 'customer' ? route('customer.profile') : (Auth::user()->role === 'apoteker' ? route('apoteker.profile') : route('kurir.profile'))) }}"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                    <span key="t-logout">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    
                                @csrf
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>

                            <li>
                                <a href="{{ Auth::user()->role === 'administrator' ? route('admin.dashboard') : (Auth::user()->role === 'customer' ? route('customer.dashboard') : (Auth::user()->role === 'apoteker' ? route('apoteker.dashboard') : route('kurir.dashboard'))) }}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboards</span>
                                </a>
                            </li>

                            <li class="menu-title" key="t-apps">Apps</li>

                            @if(Auth::user()->role === 'administrator')
                                <li>
                                    <a href="{{ route('admin.apotek') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Apotek</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.transaksi') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Transaksi</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.riwayat') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Riwayat</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.user') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">User</span>
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'apoteker')
                                <li>
                                    <a href="{{ route('apoteker.obat') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Obat</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('apoteker.kategori') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Kategori</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('apoteker.order') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Order</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('apoteker.transaksi') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Transaksi</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('apoteker.riwayat') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Riwayat</span>
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'kurir')
                                <li>
                                    <a href="{{ route('kurir.order') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Order</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('kurir.riwayat') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Riwayat</span>
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'customer')
                                <li>
                                    <a href="{{ route('customer.apotek') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Apotek</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('customer.order') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Order</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('customer.transaksi') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Transaksi</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('customer.riwayat') }}" class="waves-effect">
                                        <i class="bx bx-detail"></i>
                                        <span key="t-blog">Riwayat</span>
                                    </a>
                                </li>
                            @endif

                            <li class="menu-title" key="t-pages">Settings</li>

                            <li>
                                <a href="{{ Auth::user()->role === 'administrator' ? route('admin.profile') : (Auth::user()->role === 'customer' ? route('customer.profile') : (Auth::user()->role === 'apoteker' ? route('apoteker.profile') : route('kurir.profile'))) }}" class="waves-effect">
                                    <i class="bx bx-user-circle"></i>
                                    <span key="t-authentication">Profile</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            
            @yield('content')

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }}.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Kelompok 1
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ URL::asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- dashboard init -->
        <script src="{{ URL::asset('backend/assets/js/pages/dashboard.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ URL::asset('backend/assets/js/app.js') }}"></script>
    </body>

</html>