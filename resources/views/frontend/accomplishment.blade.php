@extends('frontend.layouts.app')


@section('content')


    <div class="breadcumb-wrapper " data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Awards &amp; Accolades</h1>
                <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Awards &amp; Accolades</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class=" space">
        <div class="container">
            <div class="row gy-gx filter-active">
                @foreach($accomplishment as $acco)
                <div class="col-sm-6 col-lg-4 filter-item">
                    <div class="gallery-style1 layout2">
                        <div class="gallery-img">
                            <img src="{{ url('public/uploads/'. $acco->image) }}" alt="gallery">
                            <a href="{{ url('public/uploads/'. $acco->image) }}" class="gallery-btn popup-image"><i class="fal fa-plus"></i></a>
                        </div>
                    </div>
                </div>
             
                @endforeach
            </div>
        </div>
    </div>

   
    
    @endsection
