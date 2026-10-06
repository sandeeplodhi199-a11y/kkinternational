@extends('frontend.layouts.app')

@section('content')

<style>
    .vision-mission-section {
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
    }
    .vm-card {
        position: relative;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(16, 35, 63, 0.08);
        border-radius: 30px;
        padding: 28px;
        box-shadow: 0 22px 60px rgba(16, 35, 63, 0.09);
    }
    .vm-card:before {
        content: "";
        position: absolute;
        right: -80px;
        top: -80px;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        background: rgba(255, 214, 90, 0.22);
    }
    .vm-card:nth-child(even):before {
        right: auto;
        left: -80px;
        background: rgba(16, 35, 63, 0.08);
    }
    .vm-image-wrap {
        position: relative;
        z-index: 1;
        border-radius: 24px;
        overflow: hidden;
        background: #eef4fb;
        box-shadow: inset 0 0 0 1px rgba(16, 35, 63, 0.06);
    }
    .vm-image-wrap img {
        display: block;
        width: 100%;
        height: 360px;
        object-fit: cover;
        object-position: center;
    }
    .vm-content {
        position: relative;
        z-index: 1;
        padding: 12px 10px;
    }
    .vm-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 999px;
        background: #f3f8ff;
        color: #10233f;
        font-weight: 800;
        margin-bottom: 18px;
    }
    .vm-content h1,
    .vm-content h2,
    .vm-content h3,
    .vm-content h4 {
        color: #10233f;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 16px;
        text-align: left !important;
    }
    .vm-content h1,
    .vm-content h2 {
        font-size: clamp(28px, 3vw, 42px);
    }
    .vm-content p,
    .vm-content li,
    .vm-content div {
        color: #4b5b70;
        font-size: 16px;
        line-height: 1.85;
        text-align: left !important;
    }
    .vm-content p {
        margin-bottom: 14px;
    }
    .vm-content ul,
    .vm-content ol {
        padding-left: 20px;
        margin-bottom: 0;
    }
    .vm-content img {
        display: none;
    }
    .vm-empty {
        background: linear-gradient(135deg, #10233f, #213d69);
        border-radius: 24px;
        padding: 36px;
        text-align: center;
        color: #fff;
        box-shadow: 0 18px 50px rgba(16, 35, 63, 0.18);
    }
    .vm-empty h3 {
        color: #fff;
        margin-bottom: 0;
    }
    @media (max-width: 991px) {
        .vm-card {
            padding: 18px;
        }
        .vm-image-wrap img {
            height: 280px;
        }
        .vm-content {
            padding: 22px 6px 6px;
        }
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Vision &amp; Mission</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Vision &amp; Mission</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="vision-mission-section space-top space-extra-bottom">
    <div class="container">
        @if($mission->isNotEmpty())
            <div class="row gy-5">
                @foreach($mission as $index => $item)
                    <div class="col-12">
                        <div class="vm-card">
                            <div class="row align-items-center gy-4 {{ $index % 2 == 0 ? 'flex-lg-row-reverse' : '' }}">
                                <div class="col-lg-6">
                                    <div class="vm-image-wrap">
                                        @if($item->image)
                                            <img src="{{ url('public/uploads/' . $item->image) }}" alt="{{ strip_tags($item->name ?? 'Vision and Mission') }}">
                                        @else
                                            <img src="{{ url('assets/frontend/img/about/ab-2-1.jpg') }}" alt="Vision and Mission">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="vm-content">
                                        <span class="vm-label">
                                            <i class="fas fa-star"></i>
                                            {{ $index % 2 == 0 ? 'Our Vision' : 'Our Mission' }}
                                        </span>
                                        {!! $item->name !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="vm-empty">
                <h3>No Vision &amp; Mission Content Found!</h3>
            </div>
        @endif
    </div>
</section>

@endsection
