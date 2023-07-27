<!doctype html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title>@yield('title') | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-Medicine">
        <meta name="keywords" content="E-Medicine">
        <meta name="author" content="Kelompok-1">

        <link rel="shortcut icon" href="{{ URL::asset('frontend/assets/images/logo-dark.png') }}">

        <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css') }}">
        <link href="{{ URL::asset('frontend/assets/css/tiny-slider.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('frontend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('frontend/assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('https://unicons.iconscout.com/release/v4.0.0/css/line.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ URL::asset('frontend/assets/css/style.min.css') }}" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">
        <style type="text/css">
            @-webkit-keyframes mover {
                0% { transform: translateY(0); }
                100% { transform: translateY(-20px); }
            }
            @keyframes mover {
                0% { transform: translateY(0); }
                100% { transform: translateY(-20px); }
            }

            .moving-object {
                position: relative;
                -webkit-animation: mover 2s infinite  alternate;
                animation: mover 2s infinite  alternate;
            }
        </style>
    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
        <!-- Loader -->
        

        
        <!-- Navbar Start -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <a class="logo" href="index.html">
                    <img src="{{ URL::asset('frontend/assets/images/logo-dark.png') }}" height="60" class="logo-light-mode" alt="">
                </a>                
                <!-- Logo End -->

                <!-- End Logo container-->
                <div class="menu-extras">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>

                <!--Login button Start-->
                <ul class="buy-button list-inline mb-0">
                    <li class="list-inline-item mb-0">
                    @auth
                        @php
                            $userType = auth()->user()->role;
                        @endphp
                        <a href="{{ $userType === 'administrator' ? route('admin.dashboard') :
                                    ($userType === 'apoteker' ? route('apoteker.dashboard') :
                                    ($userType === 'kurir' ? route('kurir.dashboard') : route('customer.dashboard'))) }}"
                            class="btn btn-pills btn btn-soft-primary text-small">
                            <i class="uil uil-home"></i> Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-md m-1 btn-pills btn btn-soft-primary text-small">
                            <i class="uil uil-sign-in-alt"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-md m-1 btn-pills btn btn-soft-info text-small">
                            <i class="uil uil-user-plus"></i> Sign Up
                        </a>
                        @endauth
                    </li>
            
                </ul>
                <!--Login button End-->

                <div id="navigation">
                    <!-- Navigation Menu-->   
                    <ul class="navigation-menu">
                        <li>
                            <a href="{{ route('frontend.index') }}" class="sub-menu-item">Home</a>
                        </li>

                        <li>
                            <a href="{{ route('frontend.about') }}" class="sub-menu-item">About</a>
                        </li>

                        <li>
                            <a href="{{ route('frontend.contact') }}" class="sub-menu-item">Contact</a>
                        </li>
                        
                    </ul>
                </div><!--end navigation-->
            </div><!--end container-->
        </header><!--end header-->
        <!-- Navbar End -->

        <!-- Hero Start -->
        @yield('content')
        
    

        <div class="offcanvas offcanvas-start shadow border-0" tabindex="-1" id="switcher-sidebar" aria-labelledby="offcanvasLeftLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasLeftLabel" class="mb-0">
                    <img src="{{ URL::asset('frontend/assets/images/logo-dark.png') }}" height="24" class="light-version" alt="">
                    <img src="{{ URL::asset('frontend/assets/images/logo-light.png') }}" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4 pb-0">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h6 class="fw-bold">Select your color</h6>
                            <ul class="pattern mb-0 mt-3">
                                <li>
                                    <a class="color-list rounded color1" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Primary" onclick="setColorPrimary()"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color2" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Green" onclick="setColor('green')"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color3" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow" onclick="setColor('yellow')"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Switcher End -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
        <!-- Back to top -->

        <!-- Javascript -->
        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
        <!-- SLIDER -->
        <script src="{{ URL::asset('frontend/assets/js/tiny-slider.js') }}"></script>
        <!-- Main Js -->
        <script src="{{ URL::asset('frontend/assets/js/feather.min.js') }}"></script>
        <script src="{{ URL::asset('frontend/assets/js/plugins.init.js') }}"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="{{ URL::asset('frontend/assets/js/app.js') }}"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->

    </body>

</html>