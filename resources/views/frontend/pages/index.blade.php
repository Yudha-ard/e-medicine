@extends('frontend.layouts.layout')

@section('title', 'Home')

@section('content')
<section class="bg-half-170 d-table w-100 home-wrapper overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="title-heading mb-3">
                    <span class="badge badge-pill badge-soft-primary"><b>Medical</b></span>
                    <h4 class="heading my-3">Welcome to</br>
                        <span class="text-primary">E-Medicine</span>
                    </h4>
                    <p class="para-desc text-muted mb-5 mt-3">
                        adalah platform revolusioner yang memudahkan Anda untuk memesan obat secara online kapan pun dan di mana pun Anda berada.
                        Dengan fitur pemesanan obat 24 jam, Anda tidak perlu lagi khawatir tentang ketersediaan obat atau batasan waktu.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('frontend.about') }}" class="btn btn-primary mr-2 mt-2">About Us</a>
                        <a href="{{ route('login') }}" class="btn btn-soft-primary mt-2">Get Started</a>
                    </div>
                    <p class="text-muted mb-0 mt-3">Don't have an account yet?
                        <a href="{{ route('register') }}" class="text-primary ml-2 h6 mb-0">
                            Signup <i data-feather="arrow-right" class="fea icon-sm"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="ml-lg-4">
                    <img src="{{ URL::asset('frontend/assets/images/capsul.png') }}" class="img-fluid moving-object" alt="" style="">
                </div>
            </div>
        </div>
    </div>
</section>
@stop