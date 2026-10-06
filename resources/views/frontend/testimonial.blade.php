@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Testimonial</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Testimonial</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-extra-bottom pt-5">
    <div class="container">
        <div class="row justify-content-between text-center text-md-start">
            <div class="col-md-auto">
                <div class="title-area">
                    <h2 class="sec-title">What Parents Say</h2>
                </div>
            </div>
            <div class="col-md-auto align-self-end">
                <div class="sec-btns">
                    <button class="icon-btn" data-slick-prev=".testislide3">
                        <i class="far fa-arrow-left"></i>
                    </button>
                    <button class="icon-btn" data-slick-next=".testislide3">
                        <i class="far fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row vs-carousel testislide3" data-slide-show="2" data-md-slide-show="2">
            @forelse($testimonial as $item)
                <div class="col-lg-6">
                    <div class="testi-style2">
                        <p class="testi-text">{{ $item->content }}</p>
                        <div class="testi-body">
                            <div class="testi-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="media-body">
                                <h3 class="testi-name h4">{{ $item->name }}</h3>
                                <div class="testi-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $item->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No testimonials available at the moment.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection