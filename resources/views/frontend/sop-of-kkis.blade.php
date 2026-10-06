@extends('frontend.layouts.app')

@section('content')

<style>
    .sop-section { background: linear-gradient(180deg, #fff 0%, #f7fbff 100%); }
    .sop-card {
        background: #fff;
        border: 1px solid rgba(16,35,63,.08);
        border-radius: 30px;
        padding: 38px;
        box-shadow: 0 22px 60px rgba(16,35,63,.09);
    }
    .sop-list { list-style: none; margin: 0; padding: 0; }
    .sop-list li {
        display: flex;
        gap: 16px;
        padding: 13px 0;
        border-bottom: 1px solid rgba(16,35,63,.08);
        color: #4b5b70;
    }
    .sop-list li:last-child { border-bottom: 0; }
    .sop-list strong {
        min-width: 135px;
        color: #10233f;
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
    @media (max-width: 575px) {
        .sop-list li { display: block; }
        .sop-list strong { display: block; margin-bottom: 4px; }
    }
</style>

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">SOP of KKIS</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>SOP of KKIS</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="sop-section space-top space-extra-bottom program-theme">
    <div class="container">
        <div class="sop-card">
            <span class="sec-subtitle">Standard Operating Procedure</span>
            <h2 class="sec-title mb-4">Standard Operating Procedure of KKIS</h2>
            <ul class="sop-list">
                @foreach([
                    ['05:30', 'Wake Up (Hostel Students)'],
                    ['06:00 – 06:45', 'Personal Study'],
                    ['06:45', 'Breakfast'],
                    ['07:10 AM', 'Arrival of day boarding students'],
                    ['07:10 – 07:50', 'First Period'],
                    ['07:50 – 08:30', 'Second Period'],
                    ['08:30 – 09:10', 'Third Period'],
                    ['09:10 – 09:30', 'Breakfast'],
                    ['09:10 – 09:25', 'Arrival of day scholar students'],
                    ['09:30 – 09:50', 'Morning Assembly'],
                    ['09:50 – 10:30', 'First Period'],
                    ['10:30 – 11:10', 'Second Period'],
                    ['11:10 – 11:40', 'Third Period'],
                    ['11:40 – 12:30', 'Fourth Period'],
                    ['12:30 – 01:00', 'Lunch Break'],
                    ['01:00 – 01:40', 'Fifth Period'],
                    ['01:40 – 02:20', 'Sixth Period'],
                    ['02:20 – 03:00', 'Seventh Period'],
                    ['03:00 – 03:20', 'Zero Period'],
                    ['03:20', 'Departure Time for Day Scholar Students'],
                    ['03:20 – 04:10', 'ECA (Grade: 1-7)'],
                    ['03:20 – 04:10', 'Homework Completion for Grade (Grade: 8-10)'],
                    ['04:10 – 04:30', 'Snacks (Grade: 1-7)'],
                    ['04:30 – 04:45', 'Snacks (Grade: 8-10)'],
                    ['04:30 – 05:45', 'Homework Completion (Grade: 1-7)'],
                    ['04:45 – 05:30', 'ECA (Grade: 8-10)'],
                    ['05:30 – 05:45', 'Back to class (Grade: 8-10) (Keeping Books in the locker Grade: 1-7)'],
                    ['05:45', 'Departure Time for Day Boarding Students'],
                    ['05:45 – 06:00', 'Fresh up (Hostel Students)'],
                    ['06:00 – 06:45', 'Play'],
                    ['06:45 – 07:15', 'Bath'],
                    ['07:15 – 07:45', 'Dinner'],
                    ['07:45 – 09:30', 'Study'],
                    ['09:30', 'Bed Time']
                ] as [$time, $activity])
                    <li><strong>{{ $time }}</strong><span>{{ $activity }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

@endsection
