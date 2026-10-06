@extends('frontend.layouts.app')


@section('content')

    <section class="vs-error-wrapper space-top space-extra-bottom" data-bg-src="assets/img/bg/error-bg.png">
        <div class="container">
            <div class="row gx-100 text-center text-lg-start">
                <div class="col-lg-5 col-xl-auto">
                    <img src="assets/img/shape/error-shape.svg" alt="shape">
                </div>
                <div class="col-lg-7 col-xl">
                    <div class="error-content">
                        <h1 class="error-number">404</h1>
                        <h2 class="error-title">Ops, Page not found</h2>
                        <p class="error-text">You can search for the page you want here or return to the homepage.</p>
                        <form action="#" class="search-inline">
                            <input type="text" class="form-control" placeholder="Search Keyword....">
                            <button><i class="far fa-search"></i></button>
                        </form>
                        <a href="{{ url('/') }}" class="vs-btn style4">Back To Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    
    @endsection