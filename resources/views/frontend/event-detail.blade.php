@extends('frontend.layouts.app')



@section('content')


<style>
    /* -- Variables -- */
    :root {
        --green-dark: #10233f;
        --green-mid:  #173b69;
        --green-soft: #f4fbff;
        --amber:      #b8860b;
        --amber-soft: #fff7d6;
        --txt:        #1c1c1e;
        --txt-muted:  #6b7280;
        --border:     #e5e7eb;
        --radius:     12px;
        --card-shadow: 0 2px 12px rgba(16,35,63,.07);
    }

    /* -- Breadcrumb -- */
    .kk-breadcrumb {
        background: linear-gradient(135deg, var(--green-dark) 0%, #081528 100%);
        padding: 60px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .kk-breadcrumb::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }
    .kk-breadcrumb::after {
        content: '';
        position: absolute;
        bottom: -40px; right: 140px;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,.03);
        pointer-events: none;
    }
    .kk-breadcrumb .eyebrow {
        font-size: 11px;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: rgba(255,255,255,.5);
        margin-bottom: 8px;
    }
    .kk-breadcrumb h1 {
        font-size: 34px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 6px;
        line-height: 1.25;
    }
    .kk-breadcrumb .sub {
        font-size: 14px;
        color: rgba(255,255,255,.6);
        margin-bottom: 18px;
    }
    .kk-breadcrumb .bc-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255,255,255,.45);
    }
    .kk-breadcrumb .bc-nav a {
        color: rgba(255,255,255,.7);
        text-decoration: none;
        transition: color .15s;
    }
    .kk-breadcrumb .bc-nav a:hover { color: #fff; }
    .kk-breadcrumb .bc-nav .sep { color: rgba(255,255,255,.3); }

    /* -- Section -- */
    .event-detail-section { padding: 64px 0; background: #f6f8f6; }

    /* -- Layout -- */
    .detail-main   { /* left column */ }
    .detail-sidebar { /* right column */ }

    /* -- Date chip -- */
    .date-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--amber-soft);
        color: #10233f;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 12px;
    }
    .date-chip i { font-size: 14px; }

    /* -- Event title -- */
    .event-detail-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--txt);
        line-height: 1.3;
        margin-bottom: 24px;
    }

    /* -- Hero image -- */
    .detail-hero-img {
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 32px;
        border: 1px solid var(--border);
    }
    .detail-hero-img img {
        width: 100%;
        height: 420px;
        object-fit: cover;
        display: block;
        transition: transform .4s;
    }
    .detail-hero-img:hover img { transform: scale(1.02); }

    /* -- Content box -- */
    .content-box {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: var(--card-shadow);
    }
    .content-box h2 {
        font-size: 22px;
        font-weight: 700;
        color: var(--txt);
        margin-bottom: 8px;
    }
    .kk-divider {
        height: 3px;
        width: 40px;
        background: var(--amber);
        border-radius: 2px;
        margin-bottom: 18px;
    }
    .content-box .event-body {
        font-size: 15px;
        color: var(--txt-muted);
        line-height: 1.85;
    }
    .content-box .event-body p { margin-bottom: 14px; }
    .content-box .event-body p:last-child { margin-bottom: 0; }

    /* Short content tags */
    .highlight-note {
        background: #f4fbff;
        border-left: 4px solid var(--green-mid);
        border-radius: 0 8px 8px 0;
        padding: 14px 18px;
        font-size: 14px;
        color: #f4fbff;
        margin-top: 20px;
        line-height: 1.65;
    }

    /* -- Sidebar cards -- */
    .sidebar-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: var(--card-shadow);
    }
    .sidebar-card h4 {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--txt-muted);
        margin-bottom: 14px;
    }

    /* Coordinator card */
    .coord-card {
        background: #10233f;
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 16px;
        color: #fff;
        box-shadow: 0 4px 16px rgba(16,35,63,.2);
    }
    .coord-avatar {
        width: 48px; height: 48px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700;
        color: #fff;
        margin-bottom: 12px;
        letter-spacing: .02em;
    }
    .coord-card .coord-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .coord-card .coord-role {
        font-size: 12px;
        opacity: .65;
        margin-bottom: 14px;
    }
    .coord-info-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 7px 0;
        border-top: 1px solid rgba(255,255,255,.1);
        font-size: 13px;
        color: rgba(255,255,255,.85);
    }
    .coord-info-row i {
        font-size: 14px;
        color: rgba(255,255,255,.6);
        margin-top: 1px;
        flex-shrink: 0;
    }
    .coord-info-row a {
        color: rgba(255,255,255,.85);
        text-decoration: none;
    }
    .coord-info-row a:hover { color: #fff; }

    /* Info rows inside sidebar-card */
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row i { color: var(--green-mid); font-size: 15px; margin-top: 1px; flex-shrink: 0; }
    .info-row .lbl { color: var(--txt-muted); min-width: 52px; flex-shrink: 0; }
    .info-row .val { color: var(--txt); }

    /* -- Countdown -- */
    .countdown-card {
        background: var(--green-soft);
        border-radius: var(--radius);
        border: 1px solid #d9e7f5;
        padding: 20px;
        margin-bottom: 16px;
    }
    .countdown-card h4 {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--green-dark);
        margin-bottom: 14px;
    }
    .cd-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .cd-cell {
        background: #fff;
        border-radius: 8px;
        padding: 10px 6px;
        text-align: center;
        border: 1px solid #d9e7f5;
    }
    .cd-num {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: var(--green-dark);
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    .cd-lbl {
        display: block;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--txt-muted);
        margin-top: 4px;
    }

    /* -- Back button -- */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: var(--green-dark);
        text-decoration: none;
        padding: 8px 16px;
        border: 1.5px solid var(--green-dark);
        border-radius: 8px;
        transition: all .15s;
        margin-bottom: 24px;
    }
    .back-btn:hover {
        background: var(--green-dark);
        color: #fff;
    }
    .back-btn i { font-size: 14px; }

    @media (max-width: 991px) {
        .detail-hero-img img { height: 280px; }
        .event-detail-title  { font-size: 24px; }
        .kk-breadcrumb h1    { font-size: 24px; }
    }
    @media (max-width: 767px) {
        .kk-breadcrumb { padding: 40px 0 32px; }
        .detail-hero-img img { height: 220px; }
    }
</style>


  <div class="breadcumb-wrapper " data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Event Details </h1>
                <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Event Details </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

{{-- -- Detail Section -- --}}
<section class="event-detail-section">
    <div class="container">

        <a href="{{ url('events') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>

        <div class="row g-4">

            {{-- -- Left: Main Content -- --}}
            <div class="col-lg-8 detail-main">

                {{-- Date chip --}}
                @if($data['event']->event_date)
                <div class="date-chip">
                    <i class="far fa-calendar-alt"></i>
                    {{ date('l, d F Y', strtotime($data['event']->event_date)) }}
                </div>
                @endif

                <h1 class="event-detail-title">{{ $data['event']->name }}</h1>

                {{-- Hero image --}}
                <div class="detail-hero-img">
                    <img
                        src="{{ $data['event']->image ? url('public/uploads/' . $data['event']->image) : url('assets/frontend/img/about/ev-d-1-1.jpg') }}"
                        alt="{{ $data['event']->name }}"
                    >
                </div>

                {{-- About content --}}
                <div class="content-box">
                    <h2>About This Event</h2>
                    <div class="kk-divider"></div>
                    <div class="event-body">
                        {!! $data['event']->content ?? '<p>Event details will be updated soon. Please check back later for more information about this event.</p>' !!}
                    </div>

                    @if($data['event']->short_content)
                    <div class="highlight-note">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ $data['event']->short_content }}
                    </div>
                    @endif
                </div>

            </div>

            {{-- -- Right: Sidebar -- --}}
            <div class="col-lg-4 detail-sidebar">

                {{-- Coordinator --}}
                <div class="coord-card">
                    <div class="coord-avatar">
                        {{ strtoupper(substr($data['event']->conduct_by ?? 'TBA', 0, 2)) }}
                    </div>
                    <div class="coord-name">{{ $data['event']->conduct_by ?? 'To be announced' }}</div>
                    <div class="coord-role">Event Coordinator</div>

                    @if($data['event']->event_date)
                    <div class="coord-info-row">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ date('d F Y', strtotime($data['event']->event_date)) }}</span>
                    </div>
                    @endif

                    @if($data['event']->event_time)
                    <div class="coord-info-row">
                        <i class="far fa-clock"></i>
                        <span>{{ $data['event']->event_time }}</span>
                    </div>
                    @endif

                    <div class="coord-info-row">
                        <i class="fas fa-phone"></i>
                        <a href="tel:+0987654321">+977-25-525300</a>
                    </div>
                    <div class="coord-info-row">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a>
                    </div>
                </div>

               

                {{-- Countdown --}}
                @if($data['event']->event_date)
                @php
                    $endDate = date('Y/m/d', strtotime($data['event']->event_date));
                @endphp
                <div class="countdown-card" id="countdown-wrap">
                    <h4>Event Countdown</h4>
                    <div class="cd-grid">
                        <div class="cd-cell"><span class="cd-num" id="cd-days">00</span><span class="cd-lbl">Days</span></div>
                        <div class="cd-cell"><span class="cd-num" id="cd-hours">00</span><span class="cd-lbl">Hours</span></div>
                        <div class="cd-cell"><span class="cd-num" id="cd-mins">00</span><span class="cd-lbl">Mins</span></div>
                        <div class="cd-cell"><span class="cd-num" id="cd-secs">00</span><span class="cd-lbl">Secs</span></div>
                    </div>
                </div>
                @endif

            </div>
        </div>

    </div>
</section>


<script>
(function () {
    @if($data['event']->event_date)
    var endDate = new Date("{{ date('Y-m-d', strtotime($data['event']->event_date)) }}T00:00:00");
    @else
    return;
    @endif

    if (!endDate || isNaN(endDate.getTime())) return;

    var wrap = document.getElementById('countdown-wrap');
    if (!wrap) return;

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        var diff = endDate.getTime() - Date.now();
        if (diff <= 0) {
            wrap.innerHTML = '<p style="color:#10233f;font-weight:600;font-size:15px;margin:0;text-align:center;padding:8px 0;">&#9989; This event has started!</p>';
            return;
        }
        var days  = Math.floor(diff / 86400000);
        diff     %= 86400000;
        var hours = Math.floor(diff / 3600000);
        diff     %= 3600000;
        var mins  = Math.floor(diff / 60000);
        var secs  = Math.floor((diff % 60000) / 1000);

        document.getElementById('cd-days').textContent  = pad(days);
        document.getElementById('cd-hours').textContent = pad(hours);
        document.getElementById('cd-mins').textContent  = pad(mins);
        document.getElementById('cd-secs').textContent  = pad(secs);
    }

    tick();
    setInterval(tick, 1000);
})();
</script>

@endsection


