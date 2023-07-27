<!DOCTYPE html>
<html lang="en">

    <head>    
        <meta charset="utf-8" />
        <title>Register | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="E-Medicine" name="description" />
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

    <body style="background: radial-gradient(circle at 0% 120%, rgba(47, 85, 212, 0.1) 0%, rgba(47, 85, 212, 0.1) 33.333%, rgba(47, 85, 212, 0.3) 33.333%, rgba(47, 85, 212, 0.3) 66.666%, rgba(47, 85, 212, 0.5) 66.666%, rgba(47, 85, 212, 0.5) 99.999%)">
    @include('sweetalert::alert')
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft" style="background-color: #cfe4ff">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Register</h5>
                                            <p>Get your {{ env('APP_NAME') }} account now !</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('backend/assets/images/doctor.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <a>
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('backend/assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="needs-validation" action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter username" value="{{ old('name') }}" required>
                                            <div class="invalid-feedback">
                                                Please Enter Username
                                            </div>  
                                            @if ($errors->has('name'))
                                                <div class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>  
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
                                            <label for="address" class="form-label">Address</label>
                                            <textarea rows="5" type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>{{ old('address') }}</textarea>  
                                            <div class="invalid-feedback">
                                                Please Enter Address
                                            </div>
                                            @if ($errors->has('address'))
                                                <div class="text-danger">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif    
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}" required>  
                                            <div class="invalid-feedback">
                                                Please Enter Phone Number
                                            </div>
                                            @if ($errors->has('phone'))
                                                <div class="text-danger">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif    
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" required>
                                                <button class="btn btn-light" type="button" onclick="showPass('password')"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a password.
                                            </div>
                                            @if ($errors->has('password'))
                                                <div class="text-danger">
                                                {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                            </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter confirm password" aria-label="Password" required>
                                                <button class="btn btn-light" type="button" onclick="showPass('password_confirmation')"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter password confirmation.
                                            </div>
                                        </div>
                                                                                
                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                        </div>

                                    </form>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Already have an account ? <a href="{{ route('login') }}" class="text-primary">Login</a></p>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                                <p>{{ env('APP_NAME') }} © <script>document.write(new Date().getFullYear())</script>
                                </br>Made with <i class="mdi mdi-heart text-danger"></i> by Kelompok 1</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ URL::asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- validation init -->
        <script src="{{ URL::asset('backend/assets/js/pages/validation.init.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ URL::asset('backend/assets/js/app.js') }}"></script>

    </body>
</html>

