@extends('frontend.layouts.app')




@section('content')
<style>
    /* ── Variables ── */
    :root {
        --green-dark: #10233f;
        --green-mid:  #173b69;
        --green-soft: #f4fbff;
        --amber:      #b8860b;
        --amber-soft: #fff7d6;
        --txt:        #1c1c1e;
        --txt-muted:  #5f6876;
        --border:     #e5e7eb;
        --radius:     12px;
        --card-shadow: 0 2px 12px rgba(16,35,63,.07);
    }

    /* ── Breadcrumb ── */
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
        font-size: 36px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 6px;
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

    /* ── Section ── */
    .events-section { padding: 64px 0; background: #f6f8f6; }

    /* ── Event Card ── */
    .event-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: transform .2s, box-shadow .2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(16,35,63,.13);
    }
    .event-card .card-img-wrap {
        position: relative;
        overflow: hidden;
    }
    .event-card .card-img-wrap img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        display: block;
        transition: transform .35s;
    }
    .event-card:hover .card-img-wrap img { transform: scale(1.04); }

    /* Date badge */
    .date-badge {
        position: absolute;
        top: 14px; left: 14px;
        background: var(--amber);
        color: #fff;
        border-radius: 8px;
        padding: 6px 10px;
        text-align: center;
        line-height: 1.1;
        min-width: 46px;
        box-shadow: 0 2px 8px rgba(255,214,90,.35);
    }
    .date-badge .day  { display: block; font-size: 22px; font-weight: 700; }
    .date-badge .mon  { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .06em; }

    /* Card body */
    .event-card .card-body {
        padding: 18px 20px 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .card-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }
    .card-meta-row .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--txt-muted);
    }
    .card-meta-row .meta-item i {
        color: var(--green-mid);
        font-size: 13px;
    }
    .event-card h3.card-title {
        font-size: 17px;
        font-weight: 600;
        color: var(--txt);
        line-height: 1.45;
        margin-bottom: 8px;
    }
    .event-card h3.card-title a {
        color: inherit;
        text-decoration: none;
        transition: color .15s;
    }
    .event-card h3.card-title a:hover { color: var(--green-dark); }
    .event-card .card-excerpt {
        font-size: 13px;
        color: var(--txt-muted);
        line-height: 1.7;
        flex: 1;
        margin-bottom: 16px;
    }
    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--green-dark);
        text-decoration: none;
        border-bottom: 1.5px solid var(--green-soft);
        padding-bottom: 2px;
        transition: border-color .15s, color .15s;
        align-self: flex-start;
    }
    .read-more-btn:hover {
        color: var(--green-mid);
        border-color: var(--green-mid);
    }
    .read-more-btn i { font-size: 14px; transition: transform .15s; }
    .read-more-btn:hover i { transform: translateX(3px); }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }
    .empty-state .icon-wrap {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: var(--green-soft);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px;
        font-size: 30px;
        color: var(--green-mid);
    }
    .empty-state h3 { font-size: 20px; color: var(--txt); margin-bottom: 8px; }
    .empty-state p  { font-size: 14px; color: var(--txt-muted); }

    /* ── Pagination override ── */
    .kk-pagination { display: flex; justify-content: center; margin-top: 48px; }
    .kk-pagination .pagination {
        display: flex; gap: 6px; list-style: none; padding: 0; margin: 0;
    }
    .kk-pagination .page-item .page-link {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--txt-muted);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all .15s;
    }
    .kk-pagination .page-item.active .page-link,
    .kk-pagination .page-item .page-link:hover {
        background: var(--green-dark);
        color: #fff;
        border-color: var(--green-dark);
    }

    @media (max-width: 767px) {
        .kk-breadcrumb h1 { font-size: 26px; }
        .kk-breadcrumb { padding: 44px 0 36px; }
    }

    .event-card .card-body {
    padding: 18px 20px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: #10233f;
}
</style>



  <div class="breadcumb-wrapper " data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Event List </h1>
                <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Event List </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

{{-- ── Events Section ── --}}
<section class="events-section">
    <div class="container">

        @if(isset($data['events']) && $data['events']->count() > 0)

            <div class="row g-4">
                @foreach($data['events'] as $event)
                <div class="col-md-6 col-xl-4">
                    <div class="event-card">

                        {{-- Image --}}
                        <div class="card-img-wrap">
                            <a href="{{ url('event/' . $event->slug) }}">
                                <img
                                    src="{{ $event->image ? url('public/uploads/' . $event->image) : url('assets/frontend/img/about/ev-d-1-1.jpg') }}"
                                    alt="{{ $event->name }}"
                                >
                            </a>
                            @if($event->event_date)
                            <div class="date-badge">
                                <span class="day">{{ date('d', strtotime($event->event_date)) }}</span>
                                <span class="mon">{{ date('M', strtotime($event->event_date)) }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="card-body">
                            <div class="card-meta-row">
                                <span class="meta-item">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $event->event_date ? date('d M Y', strtotime($event->event_date)) : 'Date TBA' }}
                                </span>
                                @if($event->event_time)
                                <span class="meta-item">
                                    <i class="far fa-clock"></i>
                                    {{ $event->event_time }}
                                </span>
                                @endif
                                @if($event->conduct_by)
                                <span class="meta-item">
                                    <i class="far fa-user"></i>
                                    {{ $event->conduct_by }}
                                </span>
                                @endif
                            </div>

                            <h3 class="card-title">
                                <a href="{{ url('event/' . $event->slug) }}" style="color:white">{{ $event->name }}</a>
                            </h3>

                            <p class="card-excerpt">
                                {{ Str::limit($event->short_content ?? 'Click to view event details and find out more about this upcoming event.', 110) }}
                            </p>

                            <a href="{{ url('event/' . $event->slug) }}" class="read-more-btn">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="kk-pagination">
                {{ $data['events']->links() }}
            </div>

        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="far fa-calendar-times"></i>
                </div>
                <h3>No Events Found</h3>
                <p>Please check back later for upcoming events.</p>
            </div>
        @endif

    </div>
</section>

@endsection