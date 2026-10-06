@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Frequently Asked Questions</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Frequently Asked Questions</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-extra-bottom">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        <div class="title-divider1"></div>

        <div class="accordion accordion-style1" id="faqVersion3">
            @forelse($faq as $index => $item)
                <div class="accordion-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="accordion-header" id="heading_{{ $item->id }}">
                        <button
                            class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse_{{ $item->id }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="collapse_{{ $item->id }}"
                        >
                            {{ $item->name }}
                        </button>
                    </div>
                    <div
                        id="collapse_{{ $item->id }}"
                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                        aria-labelledby="heading_{{ $item->id }}"
                        data-bs-parent="#faqVersion3"
                    >
                        <div class="accordion-body">
                            <p>{!! $item->content !!}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <p>No FAQs available at the moment.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
