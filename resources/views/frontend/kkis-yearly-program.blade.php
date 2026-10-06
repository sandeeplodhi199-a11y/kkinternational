@extends('frontend.layouts.app')

@section('content')

<style>
    .yearly-section { background: linear-gradient(180deg, #fff 0%, #f7fbff 100%); }
    .yearly-card {
        background: #fff;
        border: 1px solid rgba(16,35,63,.08);
        border-radius: 30px;
        padding: 42px;
        box-shadow: 0 22px 60px rgba(16,35,63,.09);
    }
    .event-pill {
        display: inline-flex;
        margin: 6px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255, 214, 90, 0.22);
        color: #10233f;
        font-weight: 700;
        border: 1px solid rgba(16, 35, 63, 0.08);
    }
    .event-pill:hover {
        background: var(--theme-color);
        color: #fff;
    }
    .program-theme .sec-subtitle,
    .program-theme h1,
    .program-theme h2,
    .program-theme h3,
    .program-theme h4,
    .program-theme a:hover {
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
            <h1 class="breadcumb-title">KKIS Yearly Program</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>KKIS Yearly Program</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="yearly-section space-top space-extra-bottom program-theme">
    <div class="container">
        <div class="yearly-card mb-5">
            <span class="sec-subtitle">One Academic Session</span>
            <h2 class="sec-title mb-3">KKIS Yearly Programs for One Academic Session</h2>
            <p class="sec-text">At K. K. International School (KKIS), we believe that education extends far beyond the
                classroom. Our thoughtfully designed annual calendar is enriched with a wide range of academic,
                cultural, social, and co-curricular activities that provide students with meaningful experiences and
                lifelong learning opportunities. These activities help nurture confidence, leadership, creativity,
                empathy, and a deeper understanding of the world around them.</p>
            <p class="sec-text">As a truly inclusive learning community, KKIS embraces and respects the rich diversity
                of cultures, traditions, religions, and beliefs. We proudly celebrate and acknowledge major festivals,
                cultural events, and religious occasions from different faiths, fostering an environment of mutual
                respect, harmony, and understanding. Through these celebrations, students gain valuable insights into
                various traditions and develop an appreciation for the values that unite humanity.</p>
            <p class="sec-text mb-0">At KKIS, we are committed to nurturing responsible global citizens who honor
                diversity, practice tolerance, and uphold the principles of respect, compassion, and unity. We believe
                that by learning about and celebrating different cultures and beliefs, our students become more
                open-minded, socially aware, and prepared to thrive in an interconnected world.</p>
        </div>

        <div class="yearly-card">
            <h2 class="h3 mb-4">Major Festivals & Events</h2>
            @foreach([
                'Investiture Ceremony','Miss & Master KKIS Talent Show','Fancy Dress Competitions','Janai Purnima Celebrations','Krishna Janmashtami Celebrations','Children’s Day Celebrations','Guru Purnima Celebrations','Dashain Celebrations','Annual Programs','Annual Sports & Games','Christmas Celebrations','Holi Celebrations','Saraswati Puja Celebrations','Annual Picnics','Tour','Field Visits Programs'
            ] as $event)
                <span class="event-pill">{{ $event }}</span>
            @endforeach
        </div>

        <div class="yearly-card mt-5">
            <h2 class="h3 mb-4">CCA (Co-curricular Activities)</h2>
            @foreach([
                'Soft Board Decoration Competitions','Crossword Puzzle Competitions','Poetry Writing Competitions','Spell Bee Competitions','Reading Competitions','Art & Craft Competitions','Interview with Principal','Handwriting Competitions','Elocution Competitions','Mathematics Quiz Competitions','Science Quiz Competitions','General Knowledge Quiz Competitions','Computer Science Quiz Competitions','Essay Writing Competitions','Kite Making Competitions','Story Telling Competitions','Debate Competitions','Story Writing Competitions','Dictation Competitions','Declamation Competitions','Book Review Writing Competitions'
            ] as $event)
                <span class="event-pill">{{ $event }}</span>
            @endforeach
        </div>
    </div>
</section>

@endsection
