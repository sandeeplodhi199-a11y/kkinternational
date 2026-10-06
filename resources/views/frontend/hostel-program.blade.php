@extends('frontend.layouts.app')

@section('content')

<style>
    .program-theme {
        --kkis-navy: #10233f;
        --kkis-blue: #173b69;
        --kkis-gold: #ffd65a;
        --kkis-soft: #f7fbff;
        color: #24364f;
    }
    .program-detail-section {
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 56%, #fff9e8 100%);
    }
    .program-detail-card {
        background: #fff;
        border: 1px solid rgba(16,35,63,.10);
        border-radius: 30px;
        padding: 42px;
        box-shadow: 0 22px 60px rgba(16,35,63,.09);
        position: relative;
        overflow: hidden;
    }
    .program-detail-card:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--kkis-navy), var(--kkis-blue), var(--kkis-gold));
    }
    .program-theme .sec-subtitle {
        color: var(--kkis-blue) !important;
        letter-spacing: .12em;
    }
    .program-theme .sec-title,
    .program-theme h1,
    .program-theme h2,
    .program-theme h3,
    .program-theme h4 {
        color: var(--kkis-navy) !important;
    }
    .program-detail-card h2 { font-weight: 800; }
    .program-theme .sec-text,
    .program-feature p {
        color: #40516b;
    }
    .program-detail-card img {
        border: 6px solid #fff;
        box-shadow: 0 18px 45px rgba(16,35,63,.14);
    }
    .program-feature {
        height: 100%;
        background: #fff;
        border-radius: 22px;
        padding: 26px;
        border: 1px solid rgba(16,35,63,.10);
        box-shadow: 0 14px 38px rgba(16,35,63,.07);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .program-feature:hover {
        transform: translateY(-4px);
        border-color: rgba(255,214,90,.70);
        box-shadow: 0 18px 44px rgba(16,35,63,.12);
    }
    .program-feature i {
        color: var(--kkis-blue) !important;
        font-size: 30px;
        margin-bottom: 16px;
    }
    .program-feature:hover i,
    .program-theme a:hover {
        color: var(--kkis-gold) !important;
    }
    .program-theme [style*="color:red"],
    .program-theme [style*="color: red"],
    .program-theme [style*="#ff0000"],
    .program-theme [style*="#e70d3c"],
    .program-theme [style*="#dc3545"] {
        color: var(--kkis-navy) !important;
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Hostel Program</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Hostel Program</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="program-detail-section space-top space-extra-bottom program-theme">
    <div class="container">
        <div class="program-detail-card mb-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <span class="sec-subtitle">Residential Care</span>
                    <h2 class="sec-title mb-3">A secure and supportive second home</h2>
                    <p class="sec-text">The Hostel Program at K. K. International School is designed to provide students
                        with a safe, caring and disciplined residential environment. Students follow a healthy daily
                        routine with supervised study, personal care, play, meals and rest.</p>
                    <p class="sec-text mb-0">Our hostel team helps students develop independence, responsibility,
                        confidence and a strong sense of belonging while staying connected to the academic and cultural
                        life of KKIS.</p>
                </div>
                <div class="col-lg-5">
                    <img src="{{ url('public/images/hostel.jpeg') }}" alt="Hostel Program" class="w-100 rounded-4">
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-md-6 col-xl-3"><div class="program-feature"><i class="fas fa-shield-alt"></i><h3 class="h5">Safe Environment</h3><p>Secure, supervised and child-friendly residential care.</p></div></div>
            <div class="col-md-6 col-xl-3"><div class="program-feature"><i class="fas fa-book-reader"></i><h3 class="h5">Study Support</h3><p>Daily study time with discipline and academic focus.</p></div></div>
            <div class="col-md-6 col-xl-3"><div class="program-feature"><i class="fas fa-utensils"></i><h3 class="h5">Healthy Routine</h3><p>Balanced meals, play, bath, dinner and rest schedule.</p></div></div>
            <div class="col-md-6 col-xl-3"><div class="program-feature"><i class="fas fa-heart"></i><h3 class="h5">Personal Care</h3><p>Warm guidance that helps children feel at home.</p></div></div>
        </div>
    </div>
</section>

@endsection
