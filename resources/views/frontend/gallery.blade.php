@extends('frontend.layouts.app')

@section('content')
<style>
    .gallery-cat-card{height:100%;background:#fff;border-radius:24px;overflow:hidden;box-shadow:0 18px 45px rgba(16,42,76,.1);border:1px solid rgba(16,42,76,.08);transition:.25s}
    .gallery-cat-card:hover{transform:translateY(-6px);box-shadow:0 24px 60px rgba(16,42,76,.15)}
    .gallery-cat-thumb{height:240px;background:linear-gradient(135deg,#10233f,#173b69);display:flex;align-items:center;justify-content:center;color:#fff;font-size:54px}
    .gallery-cat-thumb img{width:100%;height:100%;object-fit:cover}
    .gallery-cat-body{padding:24px}
    .gallery-cat-body h3{font-size:24px;color:#102a4c;margin-bottom:8px}
    .gallery-cat-body p{margin-bottom:18px;color:#667085}
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Photo Gallery</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Photo Gallery</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-extra-bottom pt-4">
    <div class="container">
        <div class="row gy-4">
            @forelse($galleryCategories as $cat)
                @php
                    $firstImage = $cat->images()->where('is_deleted',0)->where('staus','Active')->latest('id')->first();
                    $thumbnail = $cat->image ?: optional($firstImage)->image;
                @endphp
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url('gallery/'.$cat->slug) }}" class="gallery-cat-card d-block">
                        <div class="gallery-cat-thumb">
                            @if($thumbnail)
                                <img src="{{ url('public/uploads/'.$thumbnail) }}" alt="{{ $cat->name }}">
                            @else
                                <i class="fas fa-images"></i>
                            @endif
                        </div>
                        <div class="gallery-cat-body">
                            <h3>{{ $cat->name }}</h3>
                            <p>{{ $cat->active_images_count }} Images</p>
                            <span class="vs-btn">View Images</span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center"><p>No gallery category available.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
