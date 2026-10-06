@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $service->name }}</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('services') }}">Services</a></li>
                    <li>{{ $service->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="service-details">
                    @if($service->image)
                    <div class="service-details-img mb-40">
                        <img src="{{ asset('public/uploads/' . $service->image) }}" 
                             alt="{{ $service->image_alt ?? $service->name }}" 
                             title="{{ $service->image_title ?? $service->name }}"
                             class="img-fluid w-100 rounded">
                        @if($service->image_description)
                        <p class="img-caption mt-2 text-muted">{{ $service->image_description }}</p>
                        @endif
                    </div>
                    @endif
                    
                    <div class="service-details-content">
                        <h2>{{ $service->name }}</h2>
                        <div class="service-description">
                            {!! $service->content !!}
                        </div>
                        
                        @if($service->additional_content)
                        <div class="service-additional mt-4">
                            {!! $service->additional_content !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar">
                    <!-- Services List Widget -->
                    <div class="widget widget_categories">
                        <h3 class="widget_title">Our Services</h3>
                        <ul>
                            @php
                            $otherServices = App\Models\Service::where('staus', 'Active')
                                                             ->where('is_deleted', 0)
                                                             ->where('id', '!=', $service->id)
                                                             ->limit(5)
                                                             ->get();
                            @endphp
                            @forelse($otherServices as $otherService)
                            <li>
                                <a href="{{ url('service/' . $otherService->slug) }}">
                                    {{ $otherService->name }}
                                    <span class="float-end"><i class="far fa-arrow-right"></i></span>
                                </a>
                            </li>
                            @empty
                            <li>No other services available</li>
                            @endforelse
                        </ul>
                    </div>
                    
                    <!-- Contact Widget -->
                    <div class="widget widget_cta">
                        <div class="cta-box" style="background-image: url('{{ url('assets/frontend/img/bg/cta-bg.jpg') }}');">
                            <div class="cta-box-content">
                                <h4 class="cta-title">Need Help?</h4>
                                <p class="cta-text">Contact us for any queries about our services</p>
                                <a href="{{ url('contact') }}" class="btn btn-primary">
                                    Contact Us <i class="far fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Brochure Download Widget -->
                    @if($service->brochure_file)
                    <div class="widget widget_brochure">
                        <h3 class="widget_title">Download Brochure</h3>
                        <div class="brochure-content text-center">
                            <i class="fas fa-file-pdf fa-3x mb-3" style="color: #10233f;"></i>
                            <p>Download our service brochure for more details</p>
                            <a href="{{ asset('public/uploads/brochures/' . $service->brochure_file) }}" 
                               class="btn btn-outline-primary btn-sm" 
                               download>
                                <i class="fas fa-download me-2"></i>Download PDF
                            </a>
                        </div>
                    </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection


<style>
/* Service Details Styles */
.service-details-img {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}
.service-details-img img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.service-details-content h2 {
    font-size: 32px;
    margin-bottom: 20px;
    color: var(--title-color, #1a1a1a);
}
.service-details-content h3 {
    font-size: 24px;
    margin: 25px 0 15px;
    color: var(--title-color, #1a1a1a);
}
.service-details-content h4 {
    font-size: 20px;
    margin: 20px 0 12px;
    color: var(--title-color, #1a1a1a);
}
.service-details-content p {
    margin-bottom: 20px;
    line-height: 1.8;
    color: #555;
}
.service-details-content ul,
.service-details-content ol {
    margin: 20px 0;
    padding-left: 20px;
}
.service-details-content li {
    margin-bottom: 10px;
    line-height: 1.6;
}
.service-details-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 8px;
}

/* Sidebar Widget Styles */
.widget {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    margin-bottom: 30px;
}
.widget_title {
    font-size: 22px;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--theme-color, #10233f);
    position: relative;
}
.widget_categories ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.widget_categories ul li {
    margin-bottom: 12px;
    border-bottom: 1px solid #e0e0e0;
}
.widget_categories ul li:last-child {
    border-bottom: none;
}
.widget_categories ul li a {
    display: block;
    color: #555;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 8px 0;
}
.widget_categories ul li a:hover {
    color: var(--theme-color, #10233f);
    padding-left: 10px;
}

/* CTA Box Styles */
.cta-box {
    background-size: cover;
    background-position: center;
    padding: 40px 25px;
    text-align: center;
    border-radius: 8px;
    position: relative;
    z-index: 1;
}
.cta-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    border-radius: 8px;
    z-index: -1;
}
.cta-title {
    color: #fff;
    font-size: 24px;
    margin-bottom: 15px;
}
.cta-text {
    color: #fff;
    margin-bottom: 20px;
}

/* Button Styles */
.btn-primary {
    background-color: var(--theme-color, #10233f);
    border-color: var(--theme-color, #10233f);
}
.btn-primary:hover {
    background-color: transparent;
    color: var(--theme-color, #10233f);
}
.widget_brochure {
    text-align: center;
}
.brochure-content p {
    margin-bottom: 15px;
    color: #666;
}
</style>
