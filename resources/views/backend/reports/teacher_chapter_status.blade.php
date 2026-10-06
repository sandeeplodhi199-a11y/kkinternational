@extends('backend.layouts.app')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap');

/* ═══════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════ */
:root {
    --c-bg:       #f0f2f8;
    --c-card:     #ffffff;
    --c-border:   #e4e9f2;

    /* Section accent colors */
    --ca1: #6366f1; --ca1l: #eef2ff; --ca1m: #c7d2fe; /* indigo */
    --ca2: #0891b2; --ca2l: #ecfeff; --ca2m: #a5f3fc; /* cyan */
    --ca3: #d97706; --ca3l: #fffbeb; --ca3m: #fcd34d; /* amber */
    --ca4: #dc2626; --ca4l: #fff1f2; --ca4m: #fca5a5; /* red */
    --ca5: #7c3aed; --ca5l: #f5f3ff; --ca5m: #ddd6fe; /* violet */

    /* Semantic */
    --done:    #059669;
    --done-bg: #ecfdf5;
    --done-bd: #6ee7b7;
    --pend:    #dc2626;
    --pend-bg: #fff1f2;
    --pend-bd: #fca5a5;
    --neut:    #64748b;
    --neut-bg: #f1f5f9;
    --blue:    #0369a1;
    --blue-bg: #e0f2fe;

    /* Text */
    --t1: #0d1117;
    --t2: #2d3748;
    --t3: #6b7280;
    --t4: #9ca3af;

    --r:  16px;
    --rs: 10px;
    --rx: 50px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--c-bg);
    font-family: 'Outfit', sans-serif;
    color: var(--t2);
    font-size: 14px;
    line-height: 1.5;
}

.xp-wrap {
    max-width: 1500px;
    margin: 0 auto;
    padding: 28px 28px 64px;
}

/* ═══════════════════════════════════════════
   HEADER
═══════════════════════════════════════════ */
.xp-hero {
    border-radius: 22px;
    margin-bottom: 20px;
    padding: 32px 38px;
    background: linear-gradient(130deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #0369a1 100%);
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(67,56,202,.35);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}
.xp-hero::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
    top: -200px; right: -100px;
    pointer-events: none;
}
.xp-hero::after {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(3,105,161,.3) 0%, transparent 70%);
    bottom: -120px; left: 100px;
    pointer-events: none;
}
/* subtle grid texture */
.xp-hero-bg-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
}
.xp-hero-left { position: relative; z-index: 1; }
.xp-hero-left h2 {
    color: #fff;
    font-size: 1.75rem;
    font-weight: 900;
    letter-spacing: -.5px;
    margin-bottom: 8px;
    line-height: 1.1;
}
.xp-hero-left h2 i { color: #a5b4fc; }
.xp-hero-left p { color: rgba(255,255,255,.65); font-size: .9rem; font-weight: 500; }
.xp-hero-right {
    position: relative;
    z-index: 1;
    display: flex;
    gap: 10px;
    flex-shrink: 0;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.hero-chip {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: var(--rx);
    padding: 8px 16px;
    color: #fff;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .4px;
    display: flex;
    align-items: center;
    gap: 7px;
    backdrop-filter: blur(12px);
}
.hero-chip i { color: #a5b4fc; font-size: .9rem; }

/* ═══════════════════════════════════════════
   FILTER
═══════════════════════════════════════════ */
.xp-filter {
    background: var(--c-card);
    border-radius: var(--r);
    padding: 20px 26px;
    margin-bottom: 24px;
    border: 1px solid var(--c-border);
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    display: flex;
    align-items: flex-end;
    gap: 14px;
    flex-wrap: wrap;
}
.xp-filter-field { flex: 1; min-width: 200px; }
.xp-filter-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--t4);
    margin-bottom: 8px;
}
.xp-filter-field label i { color: #6366f1; }
.xp-filter-field select {
    width: 100%;
    padding: 11px 38px 11px 14px;
    border: 1.5px solid var(--c-border);
    border-radius: var(--rs);
    font-family: 'Outfit', sans-serif;
    font-size: .9rem;
    font-weight: 500;
    color: var(--t1);
    background: #fafbff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23a0aec0' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 13px center;
    appearance: none;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
}
.xp-filter-field select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.15);
}
.btn-xp-gen {
    padding: 11px 28px;
    background: linear-gradient(135deg, #4338ca, #6366f1);
    color: #fff;
    border: none;
    border-radius: var(--rs);
    font-family: 'Outfit', sans-serif;
    font-size: .9rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(99,102,241,.35);
    transition: transform .15s, box-shadow .2s;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: .2px;
}
.btn-xp-gen:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99,102,241,.45);
    color: #fff;
}

/* ═══════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════ */
.xp-stats { display: flex; gap: 14px; margin-bottom: 24px; flex-wrap: wrap; }
.xp-stat {
    flex: 1; min-width: 180px;
    background: var(--c-card);
    border-radius: var(--r);
    padding: 20px 22px;
    border: 1px solid var(--c-border);
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform .2s, box-shadow .2s;
    position: relative;
    overflow: hidden;
}
.xp-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
}
.xp-stat.s1::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
.xp-stat.s2::before { background: linear-gradient(90deg, #0891b2, #22d3ee); }
.xp-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
.xp-stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.xp-stat-icon.i1 { background: var(--ca1l); color: var(--ca1); }
.xp-stat-icon.i2 { background: var(--ca2l); color: var(--ca2); }
.xp-stat-num {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--t1);
    line-height: 1;
    font-family: 'Space Mono', monospace;
    letter-spacing: -1px;
}
.xp-stat-lbl {
    font-size: .73rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .7px;
    color: var(--t4);
    margin-top: 4px;
}

/* ═══════════════════════════════════════════
   SECTION CARD
═══════════════════════════════════════════ */
.xp-section {
    border-radius: 20px;
    margin-bottom: 24px;
    border: 1px solid var(--c-border);
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    overflow: hidden;
    background: var(--c-card);
    transition: box-shadow .25s;
}
.xp-section:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); }

/* Per-section color theming */
.xp-section:nth-child(1) { --sec-c: var(--ca1); --sec-l: var(--ca1l); --sec-m: var(--ca1m); }
.xp-section:nth-child(2) { --sec-c: var(--ca2); --sec-l: var(--ca2l); --sec-m: var(--ca2m); }
.xp-section:nth-child(3) { --sec-c: var(--ca3); --sec-l: var(--ca3l); --sec-m: var(--ca3m); }
.xp-section:nth-child(4) { --sec-c: var(--ca4); --sec-l: var(--ca4l); --sec-m: var(--ca4m); }
.xp-section:nth-child(5) { --sec-c: var(--ca5); --sec-l: var(--ca5l); --sec-m: var(--ca5m); }

.xp-sec-head {
    padding: 14px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid var(--c-border);
    background: var(--sec-l);
    border-left: 5px solid var(--sec-c);
}
.sec-badge {
    background: var(--sec-c);
    color: #fff;
    font-size: .68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: var(--rx);
}
.xp-sec-head h5 {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--t1);
    letter-spacing: -.2px;
}
.sec-divider {
    width: 1px; height: 20px;
    background: var(--sec-m);
}
.xp-sec-meta {
    font-size: .78rem;
    font-weight: 600;
    color: var(--sec-c);
    background: rgba(255,255,255,.7);
    padding: 3px 10px;
    border-radius: var(--rx);
    border: 1px solid var(--sec-m);
    margin-left: auto;
}

/* ═══════════════════════════════════════════
   TABLE
═══════════════════════════════════════════ */
.table-responsive { overflow-x: auto; }
.xp-table { width: 100%; border-collapse: collapse; }

.xp-table thead tr.gh th {
    font-size: .7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .7px;
    padding: 10px 14px 5px;
    border-bottom: none;
    text-align: center;
}
.gh .h-ch  { background: #eef2ff; color: #4338ca; border-top: 2px solid #c7d2fe; }
.gh .h-pg  { background: #ecfdf5; color: #047857; border-top: 2px solid #6ee7b7; }
.gh .h-nn  { background: #f9fafb; }

.xp-table thead tr.sh th {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 5px 14px 12px;
    border-bottom: 2px solid var(--c-border);
    text-align: center;
    color: var(--t3);
}
.sh .h-ch { background: #eef2ff; }
.sh .h-pg { background: #ecfdf5; }
.sh .h-nn { background: #f9fafb; }

.xp-table tbody td {
    padding: 14px 14px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.xp-table tbody tr.dr:hover td { background: #fafbff; }
.xp-table tbody tr.xr td { background: #fcfdff; padding: 0; border-bottom: 2px solid var(--c-border); }
.xp-table tbody tr.xr:hover td { background: #f7f9ff; }

.row-num {
    font-size: .8rem;
    font-weight: 700;
    color: var(--t4);
    width: 40px;
    text-align: center;
}
.sub-name {
    font-size: .95rem;
    font-weight: 800;
    color: var(--t1);
    letter-spacing: -.1px;
}

/* ── Number pill ── */
.xn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 28px;
    padding: 0 10px;
    border-radius: var(--rx);
    font-family: 'Space Mono', monospace;
    font-size: .8rem;
    font-weight: 700;
    line-height: 1;
    border: 1.5px solid transparent;
}
.xn.nn  { background: var(--neut-bg); color: var(--neut); border-color: #e2e8f0; }
.xn.gn  { background: var(--done-bg); color: var(--done); border-color: var(--done-bd); }
.xn.rn  { background: var(--pend-bg); color: var(--pend); border-color: var(--pend-bd); }
.xn.bn  { background: var(--blue-bg); color: var(--blue); border-color: #7dd3fc; }

/* ── Progress ── */
.xp-prog { min-width: 120px; padding: 0 4px; }
.xp-prog-track {
    height: 10px;
    border-radius: var(--rx);
    background: #e9ecef;
    overflow: hidden;
    margin-bottom: 5px;
    position: relative;
}
.xp-prog-fill {
    height: 100%;
    border-radius: var(--rx);
    position: relative;
    transition: width .7s cubic-bezier(.4,0,.2,1);
}
.xp-prog-fill.full  { background: linear-gradient(90deg, #059669, #34d399); }
.xp-prog-fill.high  { background: linear-gradient(90deg, #0891b2, #22d3ee); }
.xp-prog-fill.mid   { background: linear-gradient(90deg, #d97706, #fbbf24); }
.xp-prog-fill.low   { background: linear-gradient(90deg, #dc2626, #f87171); }
.xp-prog-fill.zero  { background: #e5e7eb; }

.xp-prog-fill::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.35) 50%, transparent 100%);
    animation: shim 2s infinite;
}
@keyframes shim {
    0%   { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.xp-prog-fill.zero::after { display: none; }

.xp-prog-pct {
    font-family: 'Space Mono', monospace;
    font-size: .75rem;
    font-weight: 700;
    text-align: right;
}
.xp-prog-pct.c-g  { color: var(--done); }
.xp-prog-pct.c-b  { color: var(--ca2); }
.xp-prog-pct.c-a  { color: var(--ca3); }
.xp-prog-pct.c-r  { color: var(--pend); }
.xp-prog-pct.c-n  { color: var(--t4); }

/* ═══════════════════════════════════════════
   DETAIL EXPANSION PANEL
═══════════════════════════════════════════ */
.xp-detail {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
}
@media(max-width:768px) { .xp-detail { grid-template-columns: 1fr; } }

.xp-dp {
    padding: 16px 20px 18px;
    border-right: 2px solid #005bff;
}
.xp-dp:last-child { border-right: none; }

.dp-hd {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: .73rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .7px;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1.5px dashed;
}
.dp-hd.g { color: var(--done); border-color: var(--done-bd); }
.dp-hd.r { color: var(--pend); border-color: var(--pend-bd); }
.dp-hd.s { color: var(--t3); border-color: #e5e7eb; }

.dp-cnt {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px; height: 20px;
    border-radius: 50%;
    font-size: .68rem;
    font-weight: 800;
    font-family: 'Space Mono', monospace;
    margin-left: auto;
    flex-shrink: 0;
}
.dp-cnt.g { background: var(--done-bg); color: var(--done); }
.dp-cnt.r { background: var(--pend-bg); color: var(--pend); }
.dp-cnt.s { background: var(--neut-bg); color: var(--neut); }

.dp-tags { display: flex; flex-wrap: wrap; gap: 7px; }

.cht {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 11px;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 600;
    line-height: 1.3;
    transition: transform .15s, box-shadow .15s;
    cursor: default;
}
.cht:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.1); }

.cht.done {
    background: var(--done-bg);
    color: #065f46;
    border: 1px solid var(--done-bd);
}
.cht.done .ch-no {
    background: var(--done);
    color: #fff;
    font-size: .65rem;
    font-weight: 800;
    padding: 1px 5px;
    border-radius: 4px;
    font-family: 'Space Mono', monospace;
    white-space: nowrap;
}
.cht.done .ch-pg {
    font-size: .7rem;
    color: var(--done);
    opacity: .75;
    font-family: 'Space Mono', monospace;
}

.cht.pend {
    background: var(--pend-bg);
    color: #7f1d1d;
    border: 1px solid var(--pend-bd);
}
.cht.pend .ch-no {
    background: var(--pend);
    color: #fff;
    font-size: .65rem;
    font-weight: 800;
    padding: 1px 5px;
    border-radius: 4px;
    font-family: 'Space Mono', monospace;
    white-space: nowrap;
}
.cht.pend .ch-pg {
    font-size: .7rem;
    color: var(--pend);
    opacity: .75;
    font-family: 'Space Mono', monospace;
}

.cht.all {
    background: #f8fafc;
    color: var(--t2);
    border: 1px solid #e2e8f0;
}
.cht.all .ch-no {
    background: #e2e8f0;
    color: var(--neut);
    font-size: .65rem;
    font-weight: 800;
    padding: 1px 5px;
    border-radius: 4px;
    font-family: 'Space Mono', monospace;
    white-space: nowrap;
}

.dp-none { font-size: .8rem; color: var(--t4); font-style: italic; }
.dp-alldone {
    font-size: .82rem;
    color: var(--done);
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ═══════════════════════════════════════════
   SUMMARY
═══════════════════════════════════════════ */
.xp-summary {
    background: var(--c-card);
    border-radius: 20px;
    padding: 26px 30px;
    border: 1px solid var(--c-border);
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    margin-bottom: 24px;
    overflow: hidden;
    position: relative;
}
.xp-summary::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #0891b2, #059669);
}
.sum-hd {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.sum-hd-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eef2ff, #e0f2fe);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: #4338ca;
}
.sum-hd h5 {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--t1);
}
.sum-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
@media(max-width:600px) { .sum-grid { grid-template-columns: 1fr; } }

.sum-row label {
    font-size: .72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--t4);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
}
.sum-row label i { font-size: .8rem; }
.sum-track {
    height: 18px;
    border-radius: var(--rx);
    background: #e9ecef;
    overflow: hidden;
    margin-bottom: 8px;
    position: relative;
}
.sum-fill {
    height: 100%;
    border-radius: var(--rx);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 10px;
    font-family: 'Space Mono', monospace;
    font-size: .7rem;
    font-weight: 700;
    color: #fff;
    min-width: 40px;
    transition: width .8s cubic-bezier(.4,0,.2,1);
    position: relative;
    overflow: hidden;
}
.sum-fill::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent);
    animation: shim 2.5s infinite;
}
.sum-fill.pg  { background: linear-gradient(90deg, #059669, #10b981, #34d399); }
.sum-fill.ch  { background: linear-gradient(90deg, #4338ca, #6366f1, #818cf8); }
.sum-sub {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sum-sub span {
    font-size: .82rem;
    color: var(--t3);
    font-family: 'Space Mono', monospace;
}
.sum-sub .pct-lbl {
    font-size: .82rem;
    font-weight: 700;
}
.sum-fill.pg + .sum-sub .pct-lbl, .pg-pct { color: var(--done); }
.sum-fill.ch + .sum-sub .pct-lbl, .ch-pct { color: #4338ca; }

/* ═══════════════════════════════════════════
   EMPTY
═══════════════════════════════════════════ */
.xp-empty {
    background: var(--c-card);
    border-radius: 20px;
    padding: 80px 32px;
    text-align: center;
    border: 1px solid var(--c-border);
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.xp-empty-icon {
    width: 90px; height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ca1l), var(--ca2l));
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 2.2rem;
    color: var(--ca1);
}
.xp-empty h4 { font-size: 1.15rem; font-weight: 800; color: var(--t1); margin-bottom: 8px; }
.xp-empty p  { font-size: .875rem; color: var(--t4); }

/* ═══════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════ */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.xp-wrap > * {
    animation: fadeUp .45s ease both;
}
.xp-wrap > *:nth-child(1) { animation-delay: .04s; }
.xp-wrap > *:nth-child(2) { animation-delay: .10s; }
.xp-wrap > *:nth-child(3) { animation-delay: .16s; }
.xp-wrap > *:nth-child(4) { animation-delay: .22s; }
.xp-wrap > *:nth-child(n+5) { animation-delay: .26s; }

@media(max-width:768px) {
    .xp-wrap { padding: 14px 14px 44px; }
    .xp-hero { padding: 24px 22px; }
    .xp-hero-right { display: none; }
    .xp-hero-left h2 { font-size: 1.25rem; }
    .xp-dp { border-right: none; border-bottom: 1px solid var(--c-border); }
    .xp-dp:last-child { border-bottom: none; }
}
</style>

<div class="content-wrapper">
<div class="xp-wrap">

    {{-- ═══ HERO HEADER ══════════════════════════════════════ --}}
    <div class="xp-hero">
        <div class="xp-hero-bg-grid"></div>
        <div class="xp-hero-left">
            <h2><i class="fas fa-chart-line me-2"></i>Chapter-wise Progress Report</h2>
            <p>Track completed chapters vs pending chapters with page counts</p>
        </div>
        <div class="xp-hero-right">
            <div class="hero-chip"><i class="fas fa-book-open"></i> Progress Dashboard</div>
            <div class="hero-chip"><i class="fas fa-layer-group"></i> Chapter Analytics</div>
        </div>
    </div>

    {{-- ═══ FILTER ════════════════════════════════════════════ --}}
    <div class="xp-filter">
        <form method="GET" action="{{ route('teacher.chapter-status.report') }}" id="filterForm"
              style="display:contents;">
            <div class="xp-filter-field">
                <label><i class="fas fa-calendar-alt"></i> Academic Session</label>
                <select name="session_id" id="session_id" required>
                    <option value="">— Select Session —</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ $session_id == $session->id ? 'selected' : '' }}>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="xp-filter-field">
                <label><i class="fas fa-graduation-cap"></i> Grade</label>
                <select name="grade_id" id="grade_id" required>
                    <option value="">— Select Grade —</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $grade_id == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-xp-gen">
                <i class="fas fa-chart-bar"></i> Generate Report
            </button>
        </form>
    </div>

    {{-- ═══ REPORT ═════════════════════════════════════════════ --}}
    @if($reportData->count() > 0)
        <?php
            $totalCompletedPages  = $reportData->sum('completed_pages');
            $totalAllPages        = $reportData->sum('total_pages');
            $overallPercentage    = $totalAllPages > 0 ? round(($totalCompletedPages / $totalAllPages) * 100, 2) : 0;
            $totalPendingPages    = $totalAllPages - $totalCompletedPages;
            $uniqueSections       = $reportData->pluck('section_name')->unique()->count();
            $uniqueSubjects       = $reportData->pluck('subject_name')->unique()->count();
        ?>

        {{-- STATS --}}
        <div class="xp-stats">
            <div class="xp-stat s1">
                <div class="xp-stat-icon i1"><i class="fas fa-users"></i></div>
                <div>
                    <div class="xp-stat-num">{{ $uniqueSections }}</div>
                    <div class="xp-stat-lbl">Total Sections</div>
                </div>
            </div>
            <div class="xp-stat s2">
                <div class="xp-stat-icon i2"><i class="fas fa-book"></i></div>
                <div>
                    <div class="xp-stat-num">{{ $uniqueSubjects }}</div>
                    <div class="xp-stat-lbl">Total Subjects</div>
                </div>
            </div>
        </div>

        {{-- SECTION TABLES --}}
        @foreach($reportData->groupBy('section_name') as $sectionName => $sectionData)
        <?php $subjectCount = $sectionData->count(); ?>
        <div class="xp-section">
            <div class="xp-sec-head">
                <span class="sec-badge">Section</span>
                <h5>{{ $sectionName }}</h5>
                <div class="sec-divider"></div>
                <span class="xp-sec-meta">{{ $subjectCount }} {{ Str::plural('Subject', $subjectCount) }}</span>
            </div>

            <div class="table-responsive">
                <table class="xp-table">
                    <thead>
                        <tr class="gh">
                            <th class="h-nn" rowspan="2" style="vertical-align:middle; width:46px;"></th>
                            <th class="h-nn" rowspan="2" style="vertical-align:middle; text-align:left; padding-left:14px;">Subject</th>
                            <th class="h-ch" colspan="3">Chapter Stats</th>
                            <th class="h-pg" colspan="3">Page Stats</th>
                            <th class="h-nn" rowspan="2" style="vertical-align:middle; min-width:140px; text-align:center;">Progress</th>
                        </tr>
                        <tr class="sh">
                            <th class="h-ch">Total</th>
                            <th class="h-ch">Done</th>
                            <th class="h-ch">Pending</th>
                            <th class="h-pg">Total</th>
                            <th class="h-pg">Done</th>
                            <th class="h-pg">Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sectionData as $index => $subjectData)
                        <?php
                            $pct = $subjectData->percentage;
                            $progClass = $pct >= 100 ? 'full' : ($pct >= 70 ? 'high' : ($pct >= 30 ? 'mid' : ($pct > 0 ? 'low' : 'zero')));
                            $pctClass  = $pct >= 100 ? 'c-g' : ($pct >= 70 ? 'c-b' : ($pct >= 30 ? 'c-a' : ($pct > 0 ? 'c-r' : 'c-n')));
                        ?>
                        <tr class="dr">
                            <td class="row-num">{{ $index + 1 }}</td>
                            <td style="padding-left:14px;"><span class="sub-name">{{ $subjectData->subject_name }}</span></td>
                            <td class="text-center"><span class="xn nn">{{ $subjectData->total_chapters }}</span></td>
                            <td class="text-center"><span class="xn gn">{{ $subjectData->completed_chapters }}</span></td>
                            <td class="text-center"><span class="xn rn">{{ $subjectData->pending_chapters }}</span></td>
                            <td class="text-center"><span class="xn bn">{{ $subjectData->total_pages }}</span></td>
                            <td class="text-center"><span class="xn gn">{{ $subjectData->completed_pages }}</span></td>
                            <td class="text-center"><span class="xn rn">{{ $subjectData->pending_pages }}</span></td>
                            <td>
                                <div class="xp-prog">
                                    <div class="xp-prog-track">
                                        <div class="xp-prog-fill {{ $progClass }}" style="width:{{ $pct }}%;"></div>
                                    </div>
                                    <div class="xp-prog-pct {{ $pctClass }}">{{ $pct }}%</div>
                                </div>
                            </td>
                        </tr>

                        {{-- DETAIL ROW --}}
                        <tr class="xr">
                            <td colspan="9">
                                <div class="xp-detail">

                                    {{-- Completed --}}
                                    <div class="xp-dp">
                                        <div class="dp-hd g">
                                            <i class="fas fa-check-circle"></i>
                                            Completed
                                            <span class="dp-cnt g">{{ count($subjectData->completed_chapters_list) }}</span>
                                        </div>
                                        <div class="dp-tags">
                                            @if(count($subjectData->completed_chapters_list) > 0)
                                                @foreach($subjectData->completed_chapters_list as $chapter)
                                                    <span class="cht done">
                                                        <span class="ch-no">Chshuu{{ $chapter->chapter_no }}</span>
                                                        {{ Str::limit($chapter->name, 20) }}
                                                        <span class="ch-pg">{{ $chapter->no_of_pages }}p</span>
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="dp-none">No completed chapters yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Pending --}}
                                    <div class="xp-dp">
                                        <div class="dp-hd r">
                                            <i class="fas fa-hourglass-half"></i>
                                            Pending
                                            <span class="dp-cnt r">{{ count($subjectData->pending_chapters_list) }}</span>
                                        </div>
                                        <div class="dp-tags">
                                            @if(count($subjectData->pending_chapters_list) > 0)
                                                @foreach($subjectData->pending_chapters_list as $chapter)
                                                    <span class="cht pend">
                                                        <span class="ch-no">Ch{{ $chapter->chapter_no }}</span>
                                                        {{ Str::limit($chapter->name, 20) }}
                                                        <span class="ch-pg">{{ $chapter->no_of_pages }}p</span>
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="dp-alldone">
                                                    <i class="fas fa-star"></i> All chapters completed!
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- All chapters --}}
                                    <div class="xp-dp">
                                        <div class="dp-hd s">
                                            <i class="fas fa-list-ul"></i>
                                            All Chapters
                                            <span class="dp-cnt s">{{ count($subjectData->all_chapters_list) }}</span>
                                        </div>
                                        <div class="dp-tags">
                                            @foreach($subjectData->all_chapters_list as $chapter)
                                                <span class="cht all">
                                                    <span class="ch-no">Ch{{ $chapter->chapter_no }}</span>
                                                    {{ Str::limit($chapter->name, 20) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        {{-- SUMMARY --}}
        <?php $chapPct = $totalAllChaptersCount > 0 ? round(($totalCompletedChaptersCount / $totalAllChaptersCount) * 100, 2) : 0; ?>
        <div class="xp-summary">
            <div class="sum-hd">
                <div class="sum-hd-icon"><i class="fas fa-chart-pie"></i></div>
                <h5>Overall Progress Summary</h5>
            </div>
            <div class="sum-grid">
                <div class="sum-row">
                    <label><i class="fas fa-file-alt" style="color:#059669;"></i> Pages Progress</label>
                    <div class="sum-track">
                        <div class="sum-fill pg" style="width:{{ $overallPercentage }}%;">{{ $overallPercentage }}%</div>
                    </div>
                    <div class="sum-sub">
                        <span>{{ $totalCompletedPages }} / {{ $totalAllPages }} pages completed</span>
                        <span class="pct-lbl" style="color:var(--done);">{{ $overallPercentage }}%</span>
                    </div>
                </div>
                <div class="sum-row">
                    <label><i class="fas fa-book-open" style="color:#4338ca;"></i> Chapters Progress</label>
                    <div class="sum-track">
                        <div class="sum-fill ch" style="width:{{ $chapPct }}%;">{{ $chapPct }}%</div>
                    </div>
                    <div class="sum-sub">
                        <span>{{ $totalCompletedChaptersCount ?? 0 }} / {{ $totalAllChaptersCount ?? 0 }} chapters completed</span>
                        <span class="pct-lbl" style="color:#4338ca;">{{ $chapPct }}%</span>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="xp-empty">
            @if($session_id && $grade_id)
                <div class="xp-empty-icon"><i class="fas fa-inbox"></i></div>
                <h4>No Data Found</h4>
                <p>No subjects or chapters available for the selected filters.</p>
            @else
                <div class="xp-empty-icon"><i class="fas fa-sliders-h"></i></div>
                <h4>Select Filters to View Report</h4>
                <p>Please select a Session &amp; Grade to generate the chapter-wise progress report.</p>
            @endif
        </div>
    @endif

</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#grade_id').change(function () {
        if ($(this).val() && $('#session_id').val()) { $('#filterForm').submit(); }
    });
    $('#filterForm').submit(function () {
        var btn = $(this).find('button[type="submit"]');
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Loading...').prop('disabled', true);
    });
});
</script>

@endsection
