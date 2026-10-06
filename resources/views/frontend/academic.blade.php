@extends('frontend.layouts.app')

@section('content')

<style>
    .kkis-academic {
        background: linear-gradient(180deg, #f7fbff 0%, #ffffff 46%, #fff8ee 100%);
        position: relative;
        overflow: hidden;
    }
    .kkis-academic:before,
    .kkis-academic:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    .kkis-academic:before {
        width: 280px;
        height: 280px;
        left: -120px;
        top: 70px;
        background: rgba(16, 35, 63, 0.08);
    }
    .kkis-academic:after {
        width: 340px;
        height: 340px;
        right: -140px;
        bottom: 110px;
        background: rgba(255, 204, 0, 0.18);
    }
    .academic-hero-card {
        background: #fff;
        border: 1px solid rgba(20, 47, 80, 0.08);
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 24px 70px rgba(20, 47, 80, 0.12);
        position: relative;
        z-index: 1;
    }
    .academic-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 999px;
        background: rgba(16, 35, 63, 0.08);
        color: #10233f;
        font-weight: 800;
        margin-bottom: 18px;
    }
    .academic-hero-card h2 {
        font-size: clamp(32px, 4vw, 54px);
        line-height: 1.08;
        margin-bottom: 18px;
        color: #102a4c;
    }
    .academic-hero-card p {
        color: #5d6878;
        font-size: 17px;
        line-height: 1.85;
    }
    .academic-fact {
        height: 100%;
        background: #102a4c;
        color: #fff;
        border-radius: 24px;
        padding: 26px 22px;
        box-shadow: 0 18px 45px rgba(16, 42, 76, 0.16);
    }
    .academic-fact .icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.13);
        color: #ffcc00;
        font-size: 24px;
        margin-bottom: 18px;
    }
    .academic-fact strong {
        display: block;
        color: #fff;
        font-size: 28px;
        line-height: 1;
        margin-bottom: 8px;
    }
    .academic-fact span {
        color: rgba(255, 255, 255, 0.82);
    }
    .academic-card {
        height: 100%;
        background: #fff;
        border-radius: 26px;
        padding: 30px 26px;
        border: 1px solid rgba(20, 47, 80, 0.08);
        box-shadow: 0 16px 45px rgba(20, 47, 80, 0.08);
        transition: all 0.25s ease;
    }
    .academic-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(20, 47, 80, 0.13);
    }
    .academic-card .icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 204, 0, 0.2);
        color: #10233f;
        font-size: 26px;
        margin-bottom: 18px;
    }
    .academic-card h3 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #102a4c;
    }
    .academic-card p {
        margin-bottom: 0;
        color: #5f6876;
        line-height: 1.75;
    }
    .academic-callout {
        background: linear-gradient(135deg, #10233f 0%, #173b69 100%);
        color: #fff;
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 24px 70px rgba(16, 35, 63, 0.18);
        position: relative;
        overflow: hidden;
    }
    .academic-callout:after {
        content: "";
        position: absolute;
        right: -70px;
        top: -70px;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        background: rgba(255, 204, 0, 0.35);
    }
    .academic-callout h2,
    .academic-callout p {
        color: #fff;
    }
    .academic-extra {
        background: #fff;
        border-radius: 26px;
        padding: 22px;
        border: 1px solid rgba(20, 47, 80, 0.08);
        box-shadow: 0 16px 45px rgba(20, 47, 80, 0.08);
    }
    .academic-extra img {
        width: 100%;
        border-radius: 20px;
        aspect-ratio: 4 / 3;
        object-fit: cover;
    }
    @media (max-width: 767px) {
        .academic-hero-card,
        .academic-callout {
            padding: 28px 22px;
            border-radius: 24px;
        }
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Academics</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Academics</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="kkis-academic space-top space-extra-bottom">
    <div class="container position-relative z-index-common">
        <div class="academic-hero-card mb-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <span class="academic-label"><i class="fas fa-book-open"></i> Academics at KKIS</span>
                    <h2>Rigorous learning with care, clarity and continuous growth</h2>
                    <p>At K. K. International School (KKIS), we are dedicated to providing a rigorous,
                        well-structured, and future-focused academic program that empowers students to achieve
                        excellence in every stage of their educational journey.</p>
                    <p class="mb-0">Affiliated with the National Examination Board (NEB), Nepal, the school strictly
                        follows the national curriculum and prescribed syllabus, ensuring that students receive a strong
                        academic foundation aligned with national educational standards.</p>
                </div>
                <div class="col-lg-5">
                    <div class="row gy-3">
                        <div class="col-sm-6">
                            <div class="academic-fact">
                                <span class="icon"><i class="fas fa-university"></i></span>
                                <strong>NEB</strong>
                                <span>Curriculum aligned</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="academic-fact">
                                <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                                <strong>3</strong>
                                <span>Unit tests yearly</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="academic-fact">
                                <span class="icon"><i class="fas fa-file-signature"></i></span>
                                <strong>3</strong>
                                <span>Terminal examinations</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="academic-fact">
                                <span class="icon"><i class="fas fa-users"></i></span>
                                <strong>6</strong>
                                <span>Parent-teacher meetings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-md-6">
                <div class="academic-card">
                    <span class="icon"><i class="fas fa-chalkboard-teacher"></i></span>
                    <h3>Expert-guided academic planning</h3>
                    <p>Our academic planning is continuously enriched through the guidance of educational experts and
                        experienced professionals, while the effective implementation of teaching and learning
                        strategies is carefully monitored by the school management.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="academic-card">
                    <span class="icon"><i class="fas fa-chart-line"></i></span>
                    <h3>Continuous assessment and feedback</h3>
                    <p>KKIS conducts three Unit Tests and three Terminal Examinations throughout the academic year.
                        Student performance is closely tracked and regularly communicated to parents through six PTMs,
                        creating a strong partnership between home and school.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="academic-card">
                    <span class="icon"><i class="fas fa-route"></i></span>
                    <h3>Learning beyond the classroom</h3>
                    <p>Students regularly participate in educational excursions, field visits, research activities,
                        project-based learning, and experiential programs that enhance practical knowledge, critical
                        thinking, and real-world understanding.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="academic-card">
                    <span class="icon"><i class="fas fa-lightbulb"></i></span>
                    <h3>Personalized academic support</h3>
                    <p>This systematic approach allows for timely feedback and personalized academic support whenever
                        needed, helping every learner build confidence, curiosity, and a lifelong love for learning.</p>
                </div>
            </div>
        </div>

        <div class="academic-callout mb-5">
            <div class="row align-items-center gy-3 position-relative z-index-common">
                <div class="col-lg-9">
                    <h2 class="sec-title mb-3">Preparing students for examinations and the future</h2>
                    <p class="mb-0">With a commitment to academic excellence, continuous improvement, and holistic
                        development, KKIS creates a learning environment where students are inspired to explore,
                        achieve, and excel, preparing them not only for examinations but also for the opportunities and
                        challenges of the future.</p>
                </div>
                <div class="col-lg-3 text-lg-end">
                    <a href="{{ url('contact-us') }}" class="vs-btn style2">Contact Us</a>
                </div>
            </div>
        </div>

        @if($academic->isNotEmpty())
            <div class="title-area text-center mb-4">
                <span class="sec-subtitle">More Academics Updates</span>
                <h2 class="sec-title">From KKIS</h2>
            </div>
            <div class="row gy-4">
                @foreach($academic as $item)
                    <div class="col-lg-6">
                        <div class="academic-extra">
                            @if(!empty($item->image))
                                <img src="{{ url('public/uploads/' . $item->image) }}" alt="Academics">
                            @endif
                            <div class="{{ !empty($item->image) ? 'mt-4' : '' }}">
                                {!! $item->name !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
