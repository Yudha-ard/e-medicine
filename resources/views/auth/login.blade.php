<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Login | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="E-Medichine" name="description" />
        <meta content="Kelompok-1" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('backend/assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ URL::asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ URL::asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ URL::asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft" style="background-color: #cfe4ff">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Login to continue to {{ env('APP_NAME') }}.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('backend/assets/images/doctor.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div class="auth-logo">
                                    <a class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('backend/assets/images/logo-light.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('backend/assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                            
                                            <div class="invalid-feedback">
                                                Please Enter Email
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif

                                        </div>
                
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required>
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                
                                                <div class="invalid-feedback">
                                                    Please Enter Password
                                                </div>
                                                @if ($errors->has('password'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>
                                        
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </form>
                                    
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Register </a> </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
    
                            <div>
                                <p>{{ env('APP_NAME') }} © <script>document.write(new Date().getFullYear())</script></br>
                                Made with <i class="mdi mdi-heart text-danger"></i> by Kelompok 1</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ URL::asset('backend/assets/js/app.js') }}"></script>
    </body>
</html>

