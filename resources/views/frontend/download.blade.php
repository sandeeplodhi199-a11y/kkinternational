@extends('frontend.layouts.app')


@section('content')


    <div class="breadcumb-wrapper " data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Download </h1>
                <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Download </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
    <section class=" space-top space-extra-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-between flex-row-reverse">
                <div class="col-lg-6 col-xl-auto text-center text-lg-end">
                    <div class="img-box2">
                        <div class="transform-banner"><img src="{{ url('assets/frontend/img/about/ab-2-1.jpg') }}" alt="about"></div>
                        <div class="vs-circle jump"></div>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="sec-title me-xxl-5">Your child's best start in life</h2>
                    <p class="sec-text col-xl-10 pe-4 mb-4">We are constantly expanding the range of services offered,
                        taking children of all ages. Our goal is to carefully educate and develop a fun way. We strive
                        to turn the learning process.</p>
                    <div class="row justify-content-center justify-content-lg-start text-start">
                        <div class="col-auto">
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li>Comprehensive reporting on individual achievement</li>
                                    <li>Educational field trips and school presentations</li>
                                    <li>Individual attention in a small-class setting</li>
                                    <li>Learning program with after-school care</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @endsection