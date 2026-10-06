@extends('frontend.layouts.app')

@section('content')

@php
    $directors = [
        [
            'name' => 'Er. Praveen Agrawal',
            'image' => 'public/uploads/board-directors/praveen-agrawal.png',
            'designation' => 'Board Chairman',
        ],
        [
            'name' => 'Dr. Rajendra Sharma',
            'image' => 'public/uploads/board-directors/rajendra-sharma.png',
            'designation' => 'Board Director',
        ],
        [
            'name' => 'Mr. Giridhari Sapkota',
            'image' => 'public/uploads/board-directors/giridhari-sapkota.png',
            'designation' => 'Board Director',
        ],
        [
            'name' => 'Mr. Ashok Kumar Agrawal',
            'image' => 'public/uploads/board-directors/ashok-kumar-agrawal.png',
            'designation' => 'Board Director',
        ],

          [
            'name' => 'Mr. Sunil Agrawal',
            'image' => 'public/uploads/board-directors/sunil-agrawal.png',
            'designation' => 'Board Director',
        ],
        
        
    ];
@endphp

<style>
    .directors-wrap {
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%);
    }

    .directors-wrap::before,
    .directors-wrap::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.45;
    }

    .directors-wrap::before {
        width: 260px;
        height: 260px;
        background: #ffe59a;
        left: -110px;
        top: 60px;
    }

    .directors-wrap::after {
        width: 320px;
        height: 320px;
        background: #dbeafe;
        right: -140px;
        bottom: 60px;
    }

    .director-card {
        position: relative;
        z-index: 1;
        height: 100%;
        padding: 14px;
        border-radius: 28px;
        background: #fff;
        border: 1px solid rgba(13, 39, 74, 0.08);
        box-shadow: 0 18px 50px rgba(13, 39, 74, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .director-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 65px rgba(13, 39, 74, 0.14);
    }

    .director-photo {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        aspect-ratio: 4 / 4.7;
        background: #eef4fb;
    }

    .director-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.35s ease;
    }

    .director-card:hover .director-photo img {
        transform: scale(1.04);
    }

    .director-info {
        padding: 24px 10px 12px;
        text-align: center;
    }

    .director-info h3 {
        margin-bottom: 7px;
        color: #10284c;
        font-size: 24px;
        line-height: 1.25;
        text-transform: none;
    }

    .director-info span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 214, 90, 0.22);
        color: #10233f;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .director-info span::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ffd65a;
        box-shadow: 0 0 0 3px rgba(255, 214, 90, 0.22);
    }

    @media (max-width: 575px) {
        .director-info h3 {
            font-size: 21px;
        }
    }

    .breadcumb-title,
    .breadcumb-menu li,
    .breadcumb-menu a {
        text-transform: none !important;
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Board of Directors</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Board of Directors</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="directors-wrap space-top space-extra-bottom">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            @foreach ($directors as $director)
                <div class="col-md-6 col-xl-4">
                    <div class="director-card">
                        <div class="director-photo">
                            <img src="{{ url($director['image']) }}" alt="{{ $director['name'] }}">
                        </div>
                        <div class="director-info">
                            <h3>{{ $director['name'] }}</h3>
                            <span>{{ $director['designation'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
