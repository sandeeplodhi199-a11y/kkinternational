@extends('frontend.layouts.app')

@section('content')

<style>
    .pagi-btn.disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Team</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Our Team</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Team Area --}}
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row align-items-center">

            @foreach($team as $te)
                <div class="col-sm-6">
                    <div class="team-style1 layout2">
                        <div class="team-img">
                            <a href="#"><img src="{{ url('public/uploads/' . $te->image) }}" alt="team"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name h2">
                                <a href="#" class="text-inherit">{{ $te->name }}</a>
                            </h3>
                            <p class="team-degi">{{ $te->short_content }}</p>
                            <a href="tel:+97725525300" class="team-number">+977-25-525300</a>
                            <div class="vs-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Dynamic Pagination --}}
        @if($team->hasPages())
            <div class="text-center mt-30">
                <div class="vs-pagination pt-md-3">

                    {{-- Previous --}}
                    @if($team->onFirstPage())
                        <span class="pagi-btn disabled">Prev</span>
                    @else
                        <a href="{{ $team->previousPageUrl() }}" class="pagi-btn">Prev</a>
                    @endif

                    {{-- Page Numbers --}}
                    <ul>
                        @foreach($team->getUrlRange(1, $team->lastPage()) as $page => $url)
                            <li>
                                <a href="{{ $url }}" class="{{ $page == $team->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Next --}}
                    @if($team->hasMorePages())
                        <a href="{{ $team->nextPageUrl() }}" class="pagi-btn">Next</a>
                    @else
                        <span class="pagi-btn disabled">Next</span>
                    @endif

                </div>
            </div>
        @endif

    </div>
</section>

{{-- Call To Action --}}
<section class="space-bottom">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-xl-10">
                <div class="icon-btn style2 mb-4 mb-lg-5">
                    <img src="{{ url('assets/frontend/img/icon/cta-i-1-1.svg') }}" alt="icon">
                </div>
                <h2 class="sec-title mb-lg-3 pb-lg-1">Meet the People Behind KKIS</h2>
                <p class="sec-text col-10 mx-auto mb-3 mb-lg-5">Our team works together to create a safe, supportive and
                    inspiring learning environment for every student.</p>
                <a href="{{ url('contact-us') }}" class="vs-btn">Contact Us</a>
            </div>
        </div>
    </div>
</section>

@endsection
