@extends('frontend.layouts.app')

@section('content')

<style>
    .day-boarding-hero {
        background: linear-gradient(135deg, #fff7e8 0%, #eef9ff 58%, #fff 100%);
        position: relative;
        overflow: hidden;
        padding: 95px 0 75px;
    }
    .day-boarding-hero:before {
        content: "";
        position: absolute;
        left: -110px;
        top: 40px;
        width: 310px;
        height: 310px;
        border-radius: 50%;
        background: rgba(255, 179, 64, 0.22);
    }
    .day-boarding-hero:after {
        content: "";
        position: absolute;
        right: -90px;
        bottom: -120px;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        background: rgba(23, 59, 105, 0.12);
    }
    .program-badge {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        background: #fff;
        color: var(--theme-color);
        border-radius: 999px;
        padding: 9px 18px;
        font-weight: 700;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 18px;
    }
    .program-card {
        background: #fff;
        border-radius: 24px;
        padding: 30px 26px;
        height: 100%;
        box-shadow: 0 18px 45px rgba(28, 54, 93, 0.08);
        border: 1px solid rgba(28, 54, 93, 0.07);
        transition: all 0.3s ease;
    }
    .program-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 60px rgba(28, 54, 93, 0.14);
    }
    .program-card .icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 179, 64, 0.16);
        color: var(--theme-color);
        font-size: 25px;
        margin-bottom: 18px;
    }
    .program-highlight {
        background: linear-gradient(135deg, var(--theme-color), #173b69);
        border-radius: 32px;
        padding: 44px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .program-highlight h2,
    .program-highlight p,
    .program-highlight li {
        color: #fff;
    }
    .program-time {
        background: #fff;
        border-radius: 22px;
        padding: 24px 20px;
        height: 100%;
        box-shadow: 0 14px 40px rgba(28, 54, 93, 0.08);
    }
    .program-time strong {
        display: block;
        color: var(--theme-color);
        font-size: 28px;
        line-height: 1.1;
        margin-bottom: 8px;
    }
    .program-theme .sec-subtitle:not(.text-white),
    .program-theme h1,
    .program-theme h2,
    .program-theme h3,
    .program-theme h4,
    .program-theme a:hover {
        color: var(--theme-color) !important;
    }
    .program-theme .program-card:hover .icon,
    .program-theme .program-badge {
        background: rgba(255, 214, 90, 0.22);
        color: var(--theme-color) !important;
    }
    .program-theme [style*="color:red"],
    .program-theme [style*="color: red"],
    .program-theme [style*="#ff0000"],
    .program-theme [style*="#e70d3c"] {
        color: var(--theme-color) !important;
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Day Boarding Programs</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Day Boarding Programs</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="day-boarding-hero program-theme">
    <div class="container position-relative z-index-common">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7">
                <span class="program-badge"><i class="fas fa-clock"></i> 7:10 AM to 5:45 PM</span>
                <h2 class="sec-title mb-3">A complete day boarding experience for every child</h2>
                <p class="sec-text mb-4">The Day Boarding Program at K. K. International School is a comprehensive,
                    year-round educational enrichment program designed to ensure the continuous academic, personal and
                    social development of every student.</p>
                <p class="sec-text mb-4">Students receive individualized attention, academic foundation support,
                    nutritious meals, supervised study, and meaningful opportunities to build confidence, discipline,
                    creativity and teamwork.</p>
                <a href="{{ url('contact-us') }}" class="vs-btn">Enquire Now</a>
            </div>
            <div class="col-lg-5">
                <div class="program-highlight">
                    <span class="sec-subtitle text-white">Morning Academic Support</span>
                    <h2 class="sec-title mb-3">7:10 AM to 9:10 AM</h2>
                    <p class="mb-0">Experienced educators guide students through concepts taught in regular classes,
                        provide additional practice, clarify doubts and offer personalized assistance for confident
                        academic success.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="space-top space-extra-bottom program-theme">
    <div class="container">
        <div class="row gy-4 mb-5">
            <div class="col-md-6 col-xl-3">
                <div class="program-time">
                    <strong>7:10 AM</strong>
                    <span>Program starts with academic support</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="program-time">
                    <strong>3 Meals</strong>
                    <span>Nutritious meals during the day</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="program-time">
                    <strong>Study</strong>
                    <span>Homework completed under supervision</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="program-time">
                    <strong>5:45 PM</strong>
                    <span>Students return home stress-free</span>
                </div>
            </div>
        </div>

        <div class="title-area text-center">
            <span class="sec-subtitle">Program Benefits</span>
            <h2 class="sec-title">What Students Receive</h2>
        </div>
        <div class="row gy-4">
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-book-open"></i></span>
                    <h3 class="h4">Academic Strengthening</h3>
                    <p>Students revise class concepts, practice more, clear doubts and close learning gaps with
                        personalized guidance.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-apple-alt"></i></span>
                    <h3 class="h4">Healthy Daily Routine</h3>
                    <p>The program includes three nutritious meals and a balanced day designed around learning, care and
                        wellness.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <h3 class="h4">Co-curricular Growth</h3>
                    <p>Students participate in co-curricular and extracurricular activities that build leadership,
                        creativity and teamwork.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-pencil-alt"></i></span>
                    <h3 class="h4">Supervised Study</h3>
                    <p>A dedicated study period helps students complete homework and academic tasks within the school
                        premises.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-heart"></i></span>
                    <h3 class="h4">Homely Care</h3>
                    <p>The KKIS Day Boarding Team creates a warm, safe and homely environment where every child feels
                        valued.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="program-card">
                    <span class="icon"><i class="fas fa-star"></i></span>
                    <h3 class="h4">Holistic Development</h3>
                    <p>Academic excellence, personal care, structured learning and healthy living help students reach
                        their fullest potential.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
