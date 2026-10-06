@extends('frontend.layouts.app')


@section('content')

<style>
    .home-grade-section .sec-subtitle {
        color: #10233f !important;
        letter-spacing: 0.16em;
        font-size: 14px;
        line-height: 1.35;
        margin-bottom: 14px;
    }

    .home-grade-section .sec-title {
        color: #10233f !important;
        font-size: clamp(34px, 4vw, 54px);
        line-height: 1.12;
        margin-bottom: 18px;
    }

    .home-grade-section .kkis-highlight-card .media-label {
        color: #10233f !important;
        font-size: 20px !important;
        line-height: 1.2;
        margin-bottom: 4px !important;
    }

    .home-grade-section .kkis-highlight-card .media-title {
        color: #334155 !important;
        font-size: 16px;
    }

    .home-grade-section .kkis-highlight-card .media-icon {
        background-color: rgba(255, 214, 90, 0.22);
    }


    .home-leaders-section .sec-title,
    .home-leaders-section .list-style1 li {
        color: #10233f !important;
    }

    .home-leaders-section .list-style1 li:before {
        color: #10233f !important;
        border-color: #ffd65a !important;
    }

    .home-thrive-section .sec-subtitle,
    .home-thrive-section .sec-title {
        color: #10233f !important;
    }

    .home-thrive-section .accordion-style1 .accordion-button:hover,
    .home-thrive-section .accordion-style1 .accordion-button:not(.collapsed) {
        background-color: #10233f !important;
        color: #ffffff !important;
    }

    .home-thrive-section .accordion-style1 .accordion-button:before {
        background-color: #ffd65a !important;
        color: #10233f !important;
    }
    @media (max-width: 767px) {
        .home-grade-section .sec-title {
            font-size: 34px;
        }
    }
</style>

<section class="vs-hero-wrapper">
    <div class="vs-hero-carousel" data-height="693" data-container="1900" data-slidertype="responsive"
        data-navbuttons="true">

        @foreach($slider as $sli)
        <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:in; kenburnsscale:1.1;">

            {{-- Background Image --}}
            <img width="1920" height="693" src="{{ asset('public/uploads/' . $sli->image) }}" class="ls-bg" alt="bg"
                decoding="async">

        </div>
        @endforeach

    </div>
</section>

<section class="space-top space-extra-bottom home-grade-section">
    <div class="container">
        <div class="row gx-70 align-items-center">

            <div class="col-lg-6">
                <div class="img-box1">
                    <div class="vs-circle"></div>
                    <div class="img-1 mega-hover"><img src="{{ url('public/images/img1.jpeg') }}"
                            alt="about"></div>
                    <div class="img-2 mega-hover"><img src="{{ url('public/images/img2.jpeg') }}"
                            alt="about"></div>
                    <div class="img-3 mega-hover"><img src="{{ url('public/images/img3.jpeg') }}"
                            alt="about"></div>
                    <div class="img-4 mega-hover"><img src="{{ url('public/images/photo1.jpeg') }}"
                            alt="about"></div>
                </div>
            </div>

            <div class="col-lg-6 text-center text-lg-start">
                <span class="sec-subtitle">Recognized by the District Education Office, Sunsari</span>
                <h2 class="sec-title">Officially Classified as an A-Grade School</h2>
                <p class="sec-text pe-xl-5 mb-4 pb-xl-3">K.K. International School is proud to be officially classified as an A-Grade School by the District Education Office, Sunsari. This recognition reflects our unwavering commitment to academic excellence, quality teaching, holistic student development, and a safe, nurturing learning environment. We are dedicated to empowering every child with the knowledge, skills, and values needed to succeed in an ever-changing world.</p>
                <div class="row gx-70 justify-content-center justify-content-lg-start text-md-start">
                    <div class="col-auto">
                        <div class="vs-media media-style1 kkis-highlight-card">
                            <div class="media-icon"><img src="{{ url('assets/frontend/img/icon/ab-1-1.svg') }}"
                                    alt="icon"></div>
                            <div class="media-body">
                                <p class="media-label mb-1">Holistic Education</p>
                                <p class="media-title">Academics | Sports | Values</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="vs-media media-style1 kkis-highlight-card">
                            <div class="media-icon"><img src="{{ url('assets/frontend/img/icon/ab-1-2.svg') }}"
                                    alt="icon"></div>
                            <div class="media-body">
                                <p class="media-label mb-1">Future-Ready Learning</p>
                                <p class="media-title">Innovation | Creativity | Technology</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<div data-bg-src="{{ url('assets/frontend/img/bg/bg-h-1-1.jpg') }}">

    <section class="space-top space-extra-bottom home-leaders-section">
        <div class="container">
            <div class="row align-items-center justify-content-between flex-row-reverse">
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="img-box2">
                        <div class="transform-banner"><img src="{{ url('assets/frontend/img/about/ab-2-1.jpg') }}"
                                alt="about"></div>
                        <div class="vs-circle jump"></div>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="sec-title me-xxl-5">Shaping Tomorrow's Leaders</h2>
                    <p class="sec-text col-xl-10 pe-4 mb-4">At K.K. International School, we inspire students to dream big, think independently, and lead with confidence. Through academic excellence, dedicated teachers, innovative teaching methods, and holistic development, we empower every child with the knowledge, skills, and values needed to succeed in school and beyond.</p>
                    <div class="row justify-content-center justify-content-lg-start text-start">
                        <div class="col-auto">
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li>Inspiring Young Minds</li>
                                    <li>Building Strong Character</li>
                                    <li>Encouraging Innovation</li>
                                    <li>Promoting Lifelong Learning</li>
                                    <li>Developing Leadership Skills</li>
                                    <li>Preparing Students for the Future</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>


<section class="space-extra-bottom home-thrive-section">
    <div class="container">
        <div class="row gx-80">
            <div class="col-lg-6 pb-3 pb-xl-0">
                <div class="img-box3">
                    <div class="img-1 mega-hover">
                        <img src="{{ url('assets/frontend/img/about/faq-1-1.jpg') }}" alt="FAQ">
                        <a href="https://www.youtube.com/watch?v=3BxZgdRukjU"
                            class="play-btn popup-video position-center"><i class="fas fa-play"></i></a>
                    </div>
                    <div class="vs-circle jump"></div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="title-area text-center text-lg-start">
                    <h2 class="sec-title">Why Students Thrive at K.K. International School</h2>
                    <p class="sec-text mb-4">At K.K. International School, every child is encouraged to explore, achieve, and grow in an environment that nurtures excellence, confidence, and lifelong learning.</p>
                </div>
                <div class="accordion accordion-style1" id="faqVersion1">
                    <div class="accordion-item active">
                        <div class="accordion-header" id="headingOne1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                Academic Excellence
                            </button>
                        </div>
                        <div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne1"
                            data-bs-parent="#faqVersion1">
                            <div class="accordion-body">
                                <p>We provide a strong academic foundation through engaging teaching methods, continuous assessment, and concept-based learning that helps students achieve their full potential.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingTwo1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                Holistic Development
                            </button>
                        </div>
                        <div id="collapseTwo1" class="accordion-collapse collapse" aria-labelledby="headingTwo1"
                            data-bs-parent="#faqVersion1">
                            <div class="accordion-body">
                                <p>Students participate in sports, arts, leadership activities, cultural programs, and community engagement, ensuring balanced physical, social, and emotional growth.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingThree1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                Safe &amp; Supportive Environment
                            </button>
                        </div>
                        <div id="collapseThree1" class="accordion-collapse collapse" aria-labelledby="headingThree1"
                            data-bs-parent="#faqVersion1">
                            <div class="accordion-body">
                                <p>A secure campus, caring teachers, and a positive school culture create an environment where every child feels respected, valued, and motivated to learn.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingFour1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                Preparing for the Future
                            </button>
                        </div>
                        <div id="collapseFour1" class="accordion-collapse collapse" aria-labelledby="headingFour1"
                            data-bs-parent="#faqVersion1">
                            <div class="accordion-body">
                                <p>We equip students with critical thinking, creativity, communication, digital literacy, and leadership skills, preparing them to excel in higher education and life.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-smoke space-top space-extra-bottom">
    <div class="container">
        <div class="row flex-row-reverse align-items-center gx-60">
            <div class="col-lg-6 text-center text-lg-start mb-40 mb-lg-0">
                <img src="{{ url('assets/frontend/img/about/testi-1-1.png') }}" alt="childrens" class="w-100">
            </div>

            <div class="col-lg-6">
                <div class="title-area text-center">
                    <span class="sec-subtitle">Testimonials</span>
                    <h2 class="sec-title">Parents Reviews</h2>
                </div>

                <div class="vs-carousel" data-fade="true" data-dots="true" data-xl-dots="true" data-ml-dots="true"
                    data-lg-dots="true" data-md-dots="true" data-sm-dots="true" data-xs-dots="true">

                    @foreach($testimonial as $test)
                    <div>
                        <div class="testi-style1">
                            <div class="testi-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>

                            <h3 class="testi-name h2">{{ $test->name }}</h3>

                            <div class="testi-rating">
                                @for($i = 1; $i <= 5; $i++) @if($i <=(int)$test->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                            </div>

                            <p class="testi-text">
                                {!! $test->content !!}
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>


@endsection
