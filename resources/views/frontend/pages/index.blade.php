@extends('frontend.layouts.layout')

@section('title', 'Home')

@section('content')
<section class="bg-half-170 d-table w-100">
    <div class="container">
        <div class="row mt-5 align-items-center">
            <div class="col-lg-7 col-md-7">
                <div class="title-heading me-lg-4">
                    <h1 class="heading mb-3">Our Creativity Is Your <span class="text-primary">Success</span> </h1>
                    <p class="para-desc text-muted">Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap v5 html page.</p>
                    <div class="mt-4">
                        <a href="page-contact-one.html" class="btn btn-primary mt-2 me-2"><i class="uil uil-envelope"></i> Get Started</a>
                        <a href="documentation.html" class="btn btn-outline-primary mt-2"><i class="uil uil-book-alt"></i> Documentation</a>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-lg-5 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <img src="{{ URL::asset('frontend/assets/images/Startup_SVG.svg') }}" alt="">
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
@stop