@extends('frontend.layouts.app')

@section('content')
<style>
    .video-cat-card{height:100%;background:#fff;border-radius:24px;overflow:hidden;box-shadow:0 18px 45px rgba(16,42,76,.1);border:1px solid rgba(16,42,76,.08);transition:.25s}
    .video-cat-card:hover{transform:translateY(-6px);box-shadow:0 24px 60px rgba(16,42,76,.15)}
    .video-cat-thumb{height:220px;background:linear-gradient(135deg,#10233f,#173b69);display:flex;align-items:center;justify-content:center;color:#fff;font-size:54px}
    .video-cat-thumb img{width:100%;height:100%;object-fit:cover}
    .video-cat-body{padding:24px}
    .video-cat-body h3{font-size:24px;color:#102a4c;margin-bottom:8px}
    .video-cat-body p{margin-bottom:18px;color:#667085}
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Video Gallery</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Video Gallery</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-extra-bottom pt-4">
    <div class="container">
        <div class="row gy-4">
            @forelse($videoCategories as $cat)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url('video/'.$cat->slug) }}" class="video-cat-card d-block">
                        <div class="video-cat-thumb">
                            @if($cat->image)
                                <img src="{{ url('public/uploads/'.$cat->image) }}" alt="{{ $cat->name }}">
                            @else
                                <i class="fas fa-play-circle"></i>
                            @endif
                        </div>
                        <div class="video-cat-body">
                            <h3>{{ $cat->name }}</h3>
                            <p>{{ $cat->active_videos_count }} Videos</p>
                            <span class="vs-btn">View Videos</span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center"><p>No video category available.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
