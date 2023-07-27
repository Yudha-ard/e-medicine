@extends('frontend.layouts.layout')

@section('title', 'Contact')

@section('content')
<section class="bg-half bg-light d-table w-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title">Contact Us</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section bg-half-170 d-table w-100 home-wrapper overflow-hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 text-center features feature-clean">
                    <div class="icons text-primary text-center mx-auto">
                        <i class="uil uil-phone d-block rounded h3 mb-0"></i>
                    </div>
                    <div class="content mt-3">
                        <h5 class="font-weight-bold">Phone</h5>
                        <p class="text-muted">Start working with E-Medicine that can provide everything</p>
                        <a href="{{ url('https://wa.me/628113278005') }}" class="text-primary">0811-3278-005</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="card border-0 text-center features feature-clean">
                    <div class="icons text-primary text-center mx-auto">
                        <i class="uil uil-envelope d-block rounded h3 mb-0"></i>
                    </div>
                    <div class="content mt-3">
                        <h5 class="font-weight-bold">Email</h5>
                        <p class="text-muted">Start working with E-Medicine that can provide everything</p>
                        <a href="mailto:call@e-medicine.com" class="text-primary">call@e-medicine.com</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="card border-0 text-center features feature-clean">
                    <div class="icons text-primary text-center mx-auto">
                        <i class="uil uil-map-marker d-block rounded h3 mb-0"></i>
                    </div>
                    <div class="content mt-3">
                        <h5 class="font-weight-bold">Location</h5>
                        <p class="text-muted">Jl. Ketintang No.156, Ketintang, Kec. Gayungan, <br>Surabaya, Jawa Timur 60231</p>
                        <a href="https://www.google.com/maps/place/Institut+Teknologi+Telkom+Surabaya/@-7.3105061,112.7286602,15z/data=!4m2!3m1!1s0x0:0x1dbecb0b2e9b059f?sa=X&ved=2ahUKEwjM6sXUuK6AAxXEwjgGHYFmCr4Q_BJ6BAhlEAA&ved=2ahUKEwjM6sXUuK6AAxXEwjgGHYFmCr4Q_BJ6BAhxEAg"
                            class="video-play-icon h6 text-primary">View on Google map</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop