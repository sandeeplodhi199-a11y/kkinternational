@extends('frontend.layouts.app')

@section('content')

<style>
    .kkis-admission {
        background: linear-gradient(180deg, #f7fbff 0%, #ffffff 45%, #fff8ee 100%);
        position: relative;
        overflow: hidden;
    }
    .kkis-admission:before,
    .kkis-admission:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    .kkis-admission:before {
        width: 300px;
        height: 300px;
        left: -130px;
        top: 90px;
        background: rgba(16, 35, 63, 0.08);
    }
    .kkis-admission:after {
        width: 360px;
        height: 360px;
        right: -150px;
        bottom: 80px;
        background: rgba(255, 204, 0, 0.18);
    }
    .admission-hero {
        position: relative;
        z-index: 1;
        background: #fff;
        border: 1px solid rgba(16, 42, 76, 0.08);
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 24px 70px rgba(16, 42, 76, 0.12);
    }
    .admission-label {
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
    .admission-hero h2 {
        font-size: clamp(32px, 4vw, 54px);
        line-height: 1.08;
        color: #102a4c;
        margin-bottom: 18px;
    }
    .admission-hero p,
    .admission-card p,
    .document-card li {
        color: #5f6876;
        line-height: 1.75;
    }
    .age-card,
    .admission-card,
    .document-card {
        height: 100%;
        background: #fff;
        border-radius: 24px;
        padding: 28px 24px;
        border: 1px solid rgba(16, 42, 76, 0.08);
        box-shadow: 0 16px 45px rgba(16, 42, 76, 0.08);
    }
    .age-card {
        text-align: center;
        transition: all 0.25s ease;
    }
    .age-card:hover,
    .admission-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 60px rgba(16, 42, 76, 0.13);
    }
    .age-card strong {
        display: block;
        color: #102a4c;
        font-size: 22px;
        margin-bottom: 6px;
    }
    .age-card span {
        color: #10233f;
        font-weight: 800;
    }
    .process-heading {
        background: linear-gradient(135deg, #10233f 0%, #173b69 100%);
        color: #fff;
        border-radius: 28px;
        padding: 34px;
        height: 100%;
    }
    .process-heading h2,
    .process-heading p {
        color: #fff;
    }
    .admission-card .step-number {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 204, 0, 0.22);
        color: #10233f;
        font-weight: 900;
        font-size: 20px;
        margin-bottom: 18px;
    }
    .admission-card h3,
    .document-card h3 {
        color: #102a4c;
        font-size: 22px;
        margin-bottom: 12px;
    }
    .document-card ul {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .document-card li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 12px;
    }
    .document-card li:before {
        content: "";
        position: absolute;
        left: 0;
        top: 10px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10233f;
    }
    .final-callout {
        background: linear-gradient(135deg, #10233f 0%, #173b69 100%);
        color: #fff;
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 24px 70px rgba(16, 35, 63, 0.18);
        position: relative;
        overflow: hidden;
    }
    .final-callout:after {
        content: "";
        position: absolute;
        right: -80px;
        top: -80px;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: rgba(255, 204, 0, 0.32);
    }
    .final-callout h2,
    .final-callout p,
    .final-callout li {
        color: #fff;
    }
    .final-callout ul {
        margin: 0;
        padding-left: 20px;
    }
    @media (max-width: 767px) {
        .admission-hero,
        .final-callout {
            padding: 28px 22px;
            border-radius: 24px;
        }
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Admission Procedures</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Admission Procedures</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="kkis-admission space-top space-extra-bottom">
    <div class="container position-relative z-index-common">
        <div class="admission-hero mb-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8">
                    <span class="admission-label"><i class="fas fa-school"></i> Begin Your Child's Journey</span>
                    <h2>A welcoming, transparent, and student-centered admission process</h2>
                    <p>At K. K. International School (KKIS), we are committed to providing a welcoming, transparent,
                        and student-centered admission process. We believe that every child is unique and deserves an
                        educational environment that nurtures their talents, character, and academic potential.</p>
                    <p class="mb-0">Our admission process is carefully designed to help parents and students become
                        familiar with the school's philosophy, facilities, and academic expectations before joining the
                        KKIS family.</p>
                </div>
                <div class="col-lg-4">
                    <div class="process-heading">
                        <span class="sec-subtitle text-white">Admission Help</span>
                        <h2 class="h3 mb-3">Visit, interact and enroll with confidence</h2>
                        <p class="mb-4">Our admission team guides families through registration, interaction, school
                            tour, documents and final enrollment.</p>
                        <a href="{{ url('contact-us') }}" class="vs-btn style2">Contact Admission Team</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="title-area text-center mb-4">
            <span class="sec-subtitle">Age Criteria</span>
            <h2 class="sec-title">Minimum age requirements</h2>
            <p class="sec-text mx-auto">Age eligibility is determined according to the school's admission guidelines
                for the respective academic session.</p>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="age-card"><strong>Play Group</strong><span>2 Years</span></div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="age-card"><strong>Nursery</strong><span>3 Years</span></div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="age-card"><strong>LKG</strong><span>4 Years</span></div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="age-card"><strong>UKG</strong><span>5 Years</span></div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-2">
                <div class="age-card"><strong>Grade 1</strong><span>6 Years</span></div>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-lg-4">
                <div class="process-heading">
                    <span class="sec-subtitle text-white">PG to Grade 1</span>
                    <h2 class="h3 mb-3">Child-friendly admission process</h2>
                    <p class="mb-0">For admissions from Play Group (PG) to Grade 1, KKIS focuses on understanding the
                        child's developmental readiness rather than conducting formal written examinations.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">1</span>
                            <h3>Registration</h3>
                            <p>Parents complete the admission registration form and submit the necessary preliminary
                                information.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">2</span>
                            <h3>Parent-child interactive meeting</h3>
                            <p>The child, accompanied by parents or guardians, participates in a friendly session with
                                the Admission Team to understand communication skills, social development, learning
                                readiness, interests, and personality.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">3</span>
                            <h3>School and wing tour</h3>
                            <p>Families receive a guided tour of the campus, classrooms, laboratories, activity areas,
                                sports facilities, and learning spaces.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">4</span>
                            <h3>Admission confirmation</h3>
                            <p>Admission is granted after successful interaction, verification, submission of required
                                documents, and completion of enrollment formalities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-lg-4">
                <div class="process-heading">
                    <span class="sec-subtitle text-white">Grades 2 to 9</span>
                    <h2 class="h3 mb-3">Academic placement and support</h2>
                    <p class="mb-0">Students seeking admission to Grades 2 to 9 undergo a comprehensive process to
                        ensure appropriate academic placement and support.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">1</span>
                            <h3>Registration</h3>
                            <p>Parents complete the admission registration form and submit the required academic
                                records.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">2</span>
                            <h3>Entrance examination</h3>
                            <p>Applicants appear for an entrance assessment designed to evaluate academic proficiency
                                and readiness for the respective grade level.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">3</span>
                            <h3>Interactive session</h3>
                            <p>Students participate in an interaction with the Academic Team to assess communication
                                skills, learning attitude, interests, and suitability for the academic program.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admission-card">
                            <span class="step-number">4</span>
                            <h3>Review and decision</h3>
                            <p>Admission eligibility is determined based on entrance examination results, academic
                                records, and the interaction session.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-lg-6">
                <div class="document-card">
                    <h3>Required Documents - PG to Grade 1</h3>
                    <ul>
                        <li>Birth Certificate (Original and Photocopy)</li>
                        <li>Recent Passport-Size Photographs</li>
                        <li>Medical Fitness Certificate</li>
                        <li>Immunization/Vaccination Record (if applicable)</li>
                        <li>Parent/Guardian Identification Documents</li>
                        <li>Completed Admission Form</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="document-card">
                    <h3>Required Documents - Grades 2 to 9</h3>
                    <ul>
                        <li>Birth Certificate</li>
                        <li>Recent Passport-Size Photographs</li>
                        <li>Previous School Academic Report Cards/Mark Sheets</li>
                        <li>Transfer Certificate (TC)</li>
                        <li>IEMS Transfer Number from the Previous School</li>
                        <li>Medical Fitness Certificate</li>
                        <li>Parent/Guardian Identification Documents</li>
                        <li>Completed Admission Form</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="final-callout">
            <div class="row align-items-center gy-4 position-relative z-index-common">
                <div class="col-lg-7">
                    <span class="sec-subtitle text-white">Final Enrollment</span>
                    <h2 class="sec-title mb-3">Join the KKIS Family</h2>
                    <p>At KKIS, we do not simply admit students. We welcome future leaders, innovators, thinkers, and
                        responsible global citizens into a vibrant learning community.</p>
                    <p class="mb-0">We invite parents and students to visit our campus, interact with our educators, and
                        experience firsthand the warmth, excellence, and opportunities that make K. K. International
                        School a preferred destination for quality education.</p>
                </div>
                <div class="col-lg-5">
                    <h3 class="h4 text-white mb-3">Admission is confirmed upon:</h3>
                    <ul>
                        <li>Successful completion of the admission process</li>
                        <li>Submission of all required documents</li>
                        <li>Verification of records</li>
                        <li>Payment of prescribed admission and registration fees</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
