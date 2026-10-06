@extends('frontend.layouts.app')

@section('content')

<style>
    .kkis-about-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fff7e8 0%, #eef9ff 52%, #fff 100%);
        padding: 100px 0 80px;
    }
    .kkis-about-hero:before {
        content: "";
        position: absolute;
        inset: 40px auto auto -120px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255, 179, 64, 0.22);
    }
    .kkis-about-hero:after {
        content: "";
        position: absolute;
        right: -90px;
        bottom: -120px;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        background: rgba(23, 59, 105, 0.12);
    }
    .kkis-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 999px;
        background: #fff;
        color: var(--theme-color);
        font-weight: 700;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 18px;
    }
    .kkis-hero-card {
        position: relative;
        z-index: 1;
        background: #fff;
        border-radius: 30px;
        padding: 18px;
        box-shadow: 0 24px 60px rgba(20, 47, 80, 0.14);
    }
    .kkis-hero-card img {
        border-radius: 24px;
        width: 100%;
    }
    .kkis-stat {
        background: #fff;
        border-radius: 22px;
        padding: 24px 20px;
        height: 100%;
        box-shadow: 0 14px 40px rgba(28, 54, 93, 0.08);
        border: 1px solid rgba(28, 54, 93, 0.06);
    }
    .kkis-stat strong {
        display: block;
        font-size: 32px;
        color: var(--theme-color);
        line-height: 1;
        margin-bottom: 8px;
    }
    .kkis-about-card {
        display: block;
        height: 100%;
        background: #fff;
        border-radius: 24px;
        padding: 30px 26px;
        box-shadow: 0 18px 45px rgba(28, 54, 93, 0.08);
        border: 1px solid rgba(28, 54, 93, 0.07);
        transition: all 0.3s ease;
    }
    .kkis-about-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 60px rgba(28, 54, 93, 0.14);
    }
    .kkis-about-card .icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 179, 64, 0.16);
        color: var(--theme-color);
        font-size: 26px;
        margin-bottom: 18px;
    }
    .kkis-about-card h3 {
        font-size: 22px;
        margin-bottom: 10px;
    }
    .kkis-about-card p {
        margin-bottom: 0;
        color: #5f6470;
    }
    .kkis-core {
        background: linear-gradient(135deg, var(--theme-color), #173b69);
        border-radius: 34px;
        padding: 48px;
        color: #fff;
        overflow: hidden;
        position: relative;
    }
    .kkis-core:after {
        content: "";
        position: absolute;
        right: -80px;
        top: -80px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.13);
    }
    .kkis-core h2,
    .kkis-core p {
        color: #fff;
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Welcome to KKIS</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Welcome to KKIS</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="kkis-about-hero">
    <div class="container position-relative z-index-common">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <h2 class="sec-title mb-3">Welcome to K. K. International School</h2>
                <p class="sec-text mb-4">Welcome to K. K. International School, a beacon of quality education
                    established in 2073 BS in the heart of Dharan-15, Sunsari, Nepal. Proudly certified as an A-Grade
                    School by the District Education Department, Sunsari, K. K. International School has been a leading
                    path of Academic Excellence, serving the young minds with dedication and passion.</p>
                <p class="sec-text mb-4">Guided by our motto, "Learning Today for a Better Tomorrow," we have nurtured
                    thousands of students, empowering them to excel in academics and beyond.</p>
                <p class="sec-text mb-4">We are immensely grateful to our wonderful parents for trusting us and standing
                    by every innovative step we’ve taken for the holistic development of our children.</p>
                <a href="{{ url('contact-us') }}" class="vs-btn">Contact Us</a>
            </div>
            <div class="col-lg-6">
                <div class="kkis-hero-card">
                    <img src="{{ url('assets/frontend/img/about/ab-2-1.jpg') }}" alt="K. K. International School">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row gy-4 mb-5">
            <div class="col-md-6 col-xl-3">
                <div class="kkis-stat">
                    <strong>2073</strong>
                    <span>Established BS</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="kkis-stat">
                    <strong>A</strong>
                    <span>Grade School</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="kkis-stat">
                    <strong>Safe</strong>
                    <span>Earthquake-resistant campus</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="kkis-stat">
                    <strong>Care</strong>
                    <span>Low teacher-student ratio</span>
                </div>
            </div>
        </div>

        <div class="kkis-core mb-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <span class="sec-subtitle text-white">About KKIS</span>
                    <h2 class="sec-title mb-3">A true home for learning</h2>
                    <p>At K. K. International School, we pride ourselves on offering world-class infrastructure,
                        including earthquake-resistant buildings, a clean, green, and peaceful campus, and a low
                        teacher-student ratio to ensure individual care for each child.</p>
                    <p>Our highly trained and supportive faculty are dedicated to molding young minds in well-equipped
                        classrooms and modern practical labs. We foster creativity, critical thinking, and an engaged
                        learning approach, making education a joyful journey.</p>
                    <p class="mb-0">Our continuous assessment system monitors progress and provides personalized
                        feedback, ensuring every student thrives. Complemented by a hygienic cafeteria offering
                        nutritious meals and ample space for indoor games, K. K. International School is truly a home
                        for learning.</p>
                </div>
                <div class="col-lg-5">
                    <div class="list-style1 text-white">
                        <ul class="list-unstyled mb-0">
                            <li>World-class infrastructure</li>
                            <li>Earthquake-resistant buildings</li>
                            <li>Clean, green, and peaceful campus</li>
                            <li>Low teacher-student ratio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="title-area text-center">
            <span class="sec-subtitle">Explore About Us</span>
            <h2 class="sec-title">Know More About KKIS</h2>
        </div>
        <div class="row gy-4">
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('about-us') }}">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <h3>Welcome to KKIS</h3>
                    <p>Discover our journey, campus and educational values.</p>
                </a>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('mission') }}">
                    <span class="icon"><i class="fas fa-bullseye"></i></span>
                    <h3>Vision &amp; Mission</h3>
                    <p>Understand the purpose and direction that guide our school.</p>
                </a>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('chairman-message') }}">
                    <span class="icon"><i class="fas fa-user-tie"></i></span>
                    <h3>Chairman's Message</h3>
                    <p>Read the leadership message for parents and students.</p>
                </a>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('board-of-directors') }}">
                    <span class="icon"><i class="fas fa-users-cog"></i></span>
                    <h3>Board of Directors</h3>
                    <p>Meet the governance team supporting KKIS growth.</p>
                </a>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('team') }}">
                    <span class="icon"><i class="fas fa-chalkboard-teacher"></i></span>
                    <h3>Our Team</h3>
                    <p>Know the educators and staff dedicated to every child.</p>
                </a>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="kkis-about-card" href="{{ url('accomplishment') }}">
                    <span class="icon"><i class="fas fa-award"></i></span>
                    <h3>Awards &amp; Accolades</h3>
                    <p>Explore achievements and recognitions of our school.</p>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
