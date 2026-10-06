@extends('backend.layouts.app')
@section('content')

<style>
:root {
    --navy:      #1a3a6b;
    --navy-dark: #0d2246;
    --blue:      #2d6cdf;
    --red:       #e74c3c;
    --red-dark:  #c0392b;
    --green:     #27ae60;
    --gold:      #f39c12;
    --bg:        #eef2fb;
    --card:      #ffffff;
    --border:    #d4dcf0;
    --muted:     #7a8ab0;
    --dark:      #1a1a2e;
    --radius:    16px;
    --shadow:    0 4px 24px rgba(26,58,107,0.13);
}

* { box-sizing: border-box; }

body { background: var(--bg); }

/* ── Hero header ── */
.ac-hero {
    background: linear-gradient(120deg, #0d2246 0%, #1a3a6b 40%, #2d6cdf 100%);
    /* padding: 2.8rem 3rem 3.5rem; */
    position: relative;
    overflow: hidden;
    margin-bottom: 0;
    margin-top: -3px;
    margin-left: 73px;
}
.ac-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.ac-hero-inner {
    position: relative;
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
}
.ac-hero-left { display: flex; align-items: center; gap: 1.4rem; }
.ac-hero-icon {
    width: 70px; height: 70px;
    background: rgba(255,255,255,0.12);
    border: 2px solid rgba(255,255,255,0.25);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem;
    backdrop-filter: blur(4px);
}
.ac-hero h1 { margin: 0; color: #fff; font-size: 2rem; font-weight: 800; letter-spacing: -.01em; }
.ac-hero p  { margin: .3rem 0 0; color: rgba(255,255,255,.7); font-size: .95rem; }
.ac-hero-stats {
    display: flex; gap: 1rem; flex-wrap: wrap;
}
.stat-pill {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50px;
    padding: .5rem 1.2rem;
    color: #fff;
    font-size: .82rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
    display: flex; align-items: center; gap: .4rem;
}
.stat-pill .dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 6px #4ade80;
}

/* ── Wave divider ── */
.hero-wave {
    display: block;
    width: 100%;
    height: 50px;
    margin-top: -2px;
}

/* ── Main content area ── */
.ac-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 2rem 3rem;
}

/* ── Step cards grid ── */
.steps-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
@media (max-width: 900px) { .steps-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 520px) { .steps-grid { grid-template-columns: 1fr; } }

.step-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 1.4rem 1.2rem 1.2rem;
    position: relative;
    border-top: 3px solid transparent;
    transition: transform .2s, box-shadow .2s;
}
.step-card:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(26,58,107,0.18); }
.step-card.s1 { border-top-color: var(--navy); }
.step-card.s2 { border-top-color: var(--blue); }
.step-card.s3 { border-top-color: var(--gold); }
.step-card.s4 { border-top-color: var(--green); }

.step-num {
    position: absolute;
    top: -14px; left: 1.2rem;
    width: 28px; height: 28px;
    border-radius: 50%;
    color: #fff;
    font-size: .8rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.s1 .step-num { background: var(--navy); }
.s2 .step-num { background: var(--blue); }
.s3 .step-num { background: var(--gold); }
.s4 .step-num { background: var(--green); }

.step-label {
    font-size: .65rem;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    margin-bottom: .6rem;
    margin-top: .2rem;
}
.s1 .step-label { color: var(--navy); }
.s2 .step-label { color: var(--blue); }
.s3 .step-label { color: var(--gold); }
.s4 .step-label { color: var(--green); }

/* ── Custom Select ── */
.custom-select-wrap { position: relative; }
.custom-select-wrap select {
    width: 100%;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: .65rem 2.6rem .65rem 1rem;
    font-size: .92rem;
    color: var(--dark);
    background: #f7f9ff;
    appearance: none;
    cursor: pointer;
    transition: border .2s, box-shadow .2s, background .2s;
    outline: none;
}
.custom-select-wrap select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(45,108,223,.15);
    background: #fff;
}
.custom-select-wrap select:disabled {
    opacity: .5; cursor: not-allowed; background: #f0f4ff;
}
.custom-select-wrap::after {
    content: '';
    position: absolute;
    right: 1rem; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid var(--muted);
    pointer-events: none;
    transition: border-top-color .2s;
}
.custom-select-wrap:focus-within::after { border-top-color: var(--blue); }

/* ── Action bar ── */
.action-bar {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 1.6rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.action-bar-left { display: flex; gap: .8rem; flex-wrap: wrap; align-items: center; }

/* Buttons */
.btn {
    display: inline-flex; align-items: center; gap: .5rem;
    border: none; border-radius: 12px;
    padding: .78rem 1.8rem;
    font-size: .93rem; font-weight: 700;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s, opacity .15s;
    position: relative; overflow: hidden;
    white-space: nowrap;
}
.btn::after {
    content: '';
    position: absolute; inset: 0;
    background: rgba(255,255,255,0);
    transition: background .15s;
}
.btn:hover::after { background: rgba(255,255,255,0.12); }
.btn:hover { transform: translateY(-2px); }
.btn:active { transform: translateY(0); }
.btn:disabled { opacity: .5; cursor: not-allowed; transform: none !important; }

.btn-preview {
    background: linear-gradient(135deg, #1a3a6b, #2d6cdf);
    color: #fff;
    box-shadow: 0 4px 16px rgba(26,58,107,0.3);
}
.btn-preview:hover { box-shadow: 0 6px 24px rgba(26,58,107,0.4); }

.btn-download {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: #fff;
    box-shadow: 0 4px 16px rgba(231,76,60,0.3);
}
.btn-download:hover { box-shadow: 0 6px 24px rgba(231,76,60,0.4); }

/* ── Alert ── */
.ac-alert {
    border-radius: 10px; padding: .85rem 1.2rem;
    font-size: .88rem; display: none;
    align-items: center; gap: .6rem;
    margin-bottom: 1rem;
}
.ac-alert-danger  { background: #fdecea; border-left: 4px solid var(--red); color: #922b21; display: none; }
.ac-alert-success { background: #eafaf1; border-left: 4px solid var(--green); color: #1e8449; display: none; }

/* ── Result bar ── */
.result-bar {
    background: linear-gradient(135deg, #e8f4fd, #dceeff);
    border: 1px solid #b8d4f8;
    border-radius: var(--radius);
    padding: 1.2rem 2rem;
    display: none;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(45,108,223,0.1);
}
.result-bar .rb-icon { font-size: 1.8rem; }
.result-bar .rb-main { flex: 1; }
.result-bar .rb-main strong { font-size: 1rem; color: var(--navy); font-weight: 700; }
.result-bar .rb-main p { margin: .2rem 0 0; color: var(--muted); font-size: .84rem; }
.rb-count {
    background: var(--navy);
    color: #fff;
    font-size: 1.5rem; font-weight: 800;
    padding: .4rem 1rem;
    border-radius: 12px;
    min-width: 64px; text-align: center;
}
.rb-pages {
    background: linear-gradient(135deg, var(--blue), var(--navy));
    color: #fff;
    padding: .4rem 1rem;
    border-radius: 50px;
    font-size: .82rem; font-weight: 700;
}
.scroll-link {
    color: var(--blue); font-size: .84rem; font-weight: 700;
    text-decoration: none; display: flex; align-items: center; gap: .3rem;
    padding: .4rem .8rem; border-radius: 8px;
    background: rgba(45,108,223,.08);
    transition: background .2s;
    white-space: nowrap;
}
.scroll-link:hover { background: rgba(45,108,223,.16); }

/* ── Spinner ── */
.btn-spinner {
    display: none; width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,.4);
    border-top-color: #fff; border-radius: 50%;
    animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Preview section ── */
#previewSection { display: none; margin-bottom: 3rem; }

.preview-topbar {
    background: linear-gradient(120deg, var(--navy-dark), var(--navy), var(--blue));
    border-radius: var(--radius) var(--radius) 0 0;
    padding: 1.2rem 2rem;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: .8rem;
}
.preview-topbar .pt-left h4 { margin: 0; color: #fff; font-size: 1rem; font-weight: 700; }
.preview-topbar .pt-left p  { margin: .25rem 0 0; color: rgba(255,255,255,.7); font-size: .82rem; }
.preview-topbar .pt-right   { display: flex; gap: .6rem; align-items: center; }
.pt-badge {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff; font-size: .78rem; font-weight: 700;
    padding: .3rem .9rem; border-radius: 50px;
    backdrop-filter: blur(4px);
}
.btn-back-top {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff; border-radius: 8px;
    padding: .35rem .9rem; font-size: .8rem;
    cursor: pointer; font-weight: 600;
    transition: background .15s;
}
.btn-back-top:hover { background: rgba(255,255,255,.22); }

.preview-scroll-outer {
    background: #b8bec8;
    padding: 18px 14px 14px;
    border-radius: 0 0 var(--radius) var(--radius);
    overflow-x: auto;
    box-shadow: inset 0 3px 12px rgba(0,0,0,0.12);
}

/* ── Loading card ── */
#previewLoading {
    display: none;
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 3.5rem 2rem;
    text-align: center;
    margin-bottom: 1.5rem;
}
#previewLoading .big-spin {
    width: 52px; height: 52px;
    border: 5px solid #dce6f8;
    border-top-color: var(--blue);
    border-radius: 50%;
    animation: spin .8s linear infinite;
    margin: 0 auto 1.2rem;
}
#previewLoading p { color: var(--muted); font-size: .95rem; }

/* ── A4 page in preview ── */
.a4-page {
    width: 210mm; min-width: 210mm;
    background: #fff;
    box-shadow: 0 2px 20px rgba(0,0,0,0.18);
    padding: 5mm 6mm 3mm 6mm;
    margin: 0 auto 14px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 9pt;
    border-radius: 2px;
}
.a4-page:last-child { margin-bottom: 0; }
.pg-label {
    text-align: center; font-size: 6.5pt; color: #aaa;
    letter-spacing: .1em; text-transform: uppercase;
    margin-bottom: 3mm; font-family: Arial, sans-serif;
}
.pg-outer { width: 100%; border-collapse: collapse; table-layout: fixed; }
.pg-outer td.cc { width: 50%; padding: 0 2mm 4mm 2mm; vertical-align: top; }

/* Card */
.ac-card { width: 100%; border-collapse: collapse; border: 1pt solid #b0bcd4; background: #fff; }
.ac-hdr  { border-bottom: 1pt solid #c8d4e8; padding: 0; }
.ac-hdr-inner { width: 100%; border-collapse: collapse; }
.ac-logo-cell { width: 17mm; padding: 2mm 1mm 2mm 2.5mm; vertical-align: middle; text-align: center; }
.ac-logo-circle {
    width: 38px; height: 38px; border-radius: 50%;
    background: #1a3a6b; color: #fff;
    font-size: 4.8pt; font-weight: 900; text-align: center;
    display: inline-flex; align-items: center; justify-content: center;
    border: 2px solid #c8d4e8; line-height: 1.2; padding: 2px;
}
.ac-info-cell { padding: 2mm 2mm 2mm 1mm; vertical-align: middle; text-align: center; }
.ac-tagline { font-size: 5.5pt; color: #666; font-style: italic; margin-bottom: .8mm; }
.ac-sname   { font-size: 9.5pt; font-weight: 900; color: #111; line-height: 1.1; }
.ac-saddr   { font-size: 5.8pt; color: #555; margin-top: .6mm; }
.ac-banner  {
    background: #1a3a6b; color: #fff;
    text-align: center; font-size: 7.5pt; font-weight: 900;
    letter-spacing: .2em; padding: 4px 0; display: block;
}
.ac-body    { padding: 6px 12% 5px 12%; text-align: center; }
.ac-ename   { text-align: center; font-size: 7.5pt; font-weight: 900; color: #111; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 1px; }
.ac-edate   { text-align: center; font-size: 6.5pt; color: #444; margin-bottom: 7px; }
.ac-itbl    { width: auto; border-collapse: collapse; margin: 0 auto; }
.ac-itbl td { font-size: 7.5pt; padding: 1.8px 0; color: #111; vertical-align: middle; }
.ac-lb  { width: 44px; font-weight: 400; color: #333; white-space: nowrap; text-align: left; }
.ac-cl  { width: 14px; text-align: center; color: #555; }
.ac-vl  { font-weight: 700; color: #111; min-width: 60px; text-align: left; }
.ac-sig { border-top: .7pt solid #ccd4e4; padding: 4px 8px 6px 8px; vertical-align: bottom; }
.ac-stbl { width: 100%; border-collapse: collapse; }
.ac-stbl td { text-align: center; width: 50%; padding: 0; vertical-align: bottom; }
.ac-sline { width: 65%; border: none; border-top: .8pt solid #555; margin: 0 auto 2px; display: block; height: 0; }
.ac-slbl  { font-size: 5.5pt; color: #444; letter-spacing: .06em; display: block; text-align: center; text-transform: uppercase; }
.ac-sigsvg { display: block; height: 20px; margin: 0 auto 2px; }
.ac-empty { width: 100%; border: 1pt dashed #c4cee4; background: #f5f7fc; height: 60mm; display: block; }

/* Logo Styling */
.ac-logo-wrap{
    width:70px;
    height:70px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    border-radius:50%;
    background:#fff;
}

.ac-logo-img{
    width:100%;
    height:100%;
    object-fit:contain;
}
</style>

{{-- ── HERO ── --}}
<div class="ac-hero">
    <div class="ac-hero-inner">
        <div class="ac-hero-left">
            <div class="ac-hero-icon">🎓</div>
            <div>
                <h1>Admit Card Generator</h1>
                <p>K.K. International School &nbsp;·&nbsp; Bulk Admit Card PDF Download</p>
            </div>
        </div>
        <div class="ac-hero-stats">
            <div class="stat-pill"><span class="dot"></span> 8 Cards Per Page</div>
            <div class="stat-pill">📄 A4 Portrait PDF</div>
            <div class="stat-pill">🖨️ Print Ready</div>
        </div>
    </div>
</div>
<svg class="hero-wave" viewBox="0 0 1440 50" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,30 C360,60 1080,0 1440,30 L1440,50 L0,50 Z" fill="#eef2fb"/>
</svg>

{{-- ── CONTENT ── --}}
<div class="ac-content">

    @if(session('error'))
    <div style="background:#fdecea; border-left:4px solid #e74c3c; color:#922b21; border-radius:12px; padding:1rem 1.5rem; margin-bottom:1.5rem;">
        ⚠️ {{ session('error') }}
    </div>
    @endif

    {{-- Alert --}}
    <div id="alertBox" class="ac-alert ac-alert-danger"></div>

    {{-- Steps grid --}}
    <div class="steps-grid">
        {{-- Step 1: Session --}}
        <div class="step-card s1">
            <div class="step-num">1</div>
            <div class="step-label">Academic Session</div>
            <div class="custom-select-wrap">
                <select id="sessionSelect">
                    <option value="">— Select Session —</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Step 2: Grade --}}
        <div class="step-card s2">
            <div class="step-num">2</div>
            <div class="step-label">Grade / Class</div>
            <div class="custom-select-wrap">
                <select id="gradeSelect" disabled>
                    <option value="">— Select Grade —</option>
                </select>
            </div>
        </div>

        {{-- Step 3: Section --}}
        <div class="step-card s3">
            <div class="step-num">3</div>
            <div class="step-label">Section</div>
            <div class="custom-select-wrap">
                <select id="sectionSelect" disabled>
                    <option value="">— Select Section —</option>
                </select>
            </div>
        </div>

        {{-- Step 4: Exam --}}
        <div class="step-card s4">
            <div class="step-num">4</div>
            <div class="step-label">Examination</div>
            <div class="custom-select-wrap">
                <select id="examSelect" disabled>
                    <option value="">— Select Exam —</option>
                </select>
            </div>
        </div>
    </div>

   
    <div class="action-bar-left">
        <button id="previewBtn" class="btn btn-preview">
            <span id="previewIcon">👁️</span>
            <div class="btn-spinner" id="previewSpinner"></div>
            <span id="previewBtnText">Preview Admit Cards</span>
        </button>
 
        <form id="downloadForm" method="POST" action="{{ route('download_admit_cards') }}" style="margin:0;">
            @csrf
            <input type="hidden" name="session_id" id="fSessionId">
            <input type="hidden" name="grade_id"   id="fGradeId">
            <input type="hidden" name="section_id" id="fSectionId">
            <input type="hidden" name="exam_id"    id="fExamId">
            <button type="submit" id="downloadBtn" class="btn btn-download" disabled>
                <span id="downloadIcon">📥</span>
                <div class="btn-spinner" id="downloadSpinner"></div>
                <span id="downloadText">Download PDF</span>
            </button>
        </form>
 
        {{-- NEW: Blank template button --}}
        <a href="{{ route('download_blank_admit_card') }}"
           class="btn btn-blank"
           id="blankBtn"
           target="_blank"
           title="Download 1 A4 page with 8 blank admit card slots for manual filling">
            🖨️ Download Blank Template
        </a>
    </div>
    <div style="color:var(--muted); font-size:.84rem;">
        Select all 4 filters, then preview or download
    </div>
</div>

    {{-- Result bar --}}
    <div class="result-bar" id="resultBar">
        <div class="rb-icon">👥</div>
        <div class="rb-main">
            <strong>Students found for selected criteria</strong>
            <p id="resultDetail"></p>
        </div>
        <div class="rb-count" id="studentCount">0</div>
        <div class="rb-pages" id="rbPages"></div>
        <a href="#previewSection" class="scroll-link" id="scrollLink">
            ↓ Scroll to preview
        </a>
    </div>

    {{-- Loading --}}
    <div id="previewLoading">
        <div class="big-spin"></div>
        <p>Loading admit card preview…</p>
    </div>

    {{-- Preview --}}
    <div id="previewSection">
        <div class="preview-topbar">
            <div class="pt-left">
                <h4>📄 Admit Card Preview</h4>
                <p id="previewMeta"></p>
            </div>
            <div class="pt-right">
                <span class="pt-badge" id="previewPageCount"></span>
                <button class="btn-back-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑ Back to top</button>
            </div>
        </div>
        <div class="preview-scroll-outer">
            <div id="previewPages"></div>
        </div>
    </div>

</div>{{-- /.ac-content --}}

<script>
const ROUTES = {
    getGrades:    "{{ route('get_grades',   ':id') }}",
    getSections:  "{{ route('get_sections', ':id') }}",
    getExams:     "{{ route('get_exams',    ':id') }}",
    previewCards: "{{ route('preview_admit_cards') }}",
};
const CSRF = "{{ csrf_token() }}";
const $id = id => document.getElementById(id);

const sessionSel = $id('sessionSelect');
const gradeSel   = $id('gradeSelect');
const sectionSel = $id('sectionSelect');
const examSel    = $id('examSelect');

function showAlert(msg, type='danger') {
    const b = $id('alertBox');
    b.textContent = msg;
    b.className = `ac-alert ac-alert-${type}`;
    b.style.display = 'flex';
    setTimeout(() => b.style.display='none', 4000);
}
function resetSel(el, ph) {
    el.innerHTML = `<option value="">${ph}</option>`;
    el.disabled = true;
}
async function getJSON(url) {
    const r = await fetch(url);
    if (!r.ok) throw new Error();
    return r.json();
}
async function postJSON(url, data) {
    const r = await fetch(url, {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify(data)
    });
    if (!r.ok) throw new Error();
    return r.json();
}
function fillSel(el, items, vk, lk) {
    items.forEach(it => {
        const o = document.createElement('option');
        o.value = it[vk]; o.textContent = it[lk];
        el.appendChild(o);
    });
    el.disabled = false;
}
function hidePreview() {
    $id('previewSection').style.display = 'none';
    $id('resultBar').style.display = 'none';
    $id('downloadBtn').disabled = true;
}

// Session change
sessionSel.addEventListener('change', async function() {
    resetSel(gradeSel,'— Select Grade —');
    resetSel(sectionSel,'— Select Section —');
    resetSel(examSel,'— Select Exam —');
    hidePreview();
    if (!this.value) return;
    try {
        const g = await getJSON(ROUTES.getGrades.replace(':id', this.value));
        if (!g.length) { showAlert('No grades found for this session.'); return; }
        fillSel(gradeSel, g, 'id', 'name');
    } catch { showAlert('Failed to load grades.'); }
});

// Grade change
gradeSel.addEventListener('change', async function() {
    resetSel(sectionSel,'— Select Section —');
    resetSel(examSel,'— Select Exam —');
    hidePreview();
    if (!this.value) return;
    try {
        const [secs, exams] = await Promise.all([
            getJSON(ROUTES.getSections.replace(':id', this.value)),
            getJSON(ROUTES.getExams.replace(':id', this.value))
        ]);
        if (!secs.length)  { showAlert('No sections found.'); return; }
        fillSel(sectionSel, secs, 'id', 'name');
        if (!exams.length) { showAlert('No exams found.'); return; }
        exams.forEach(ex => {
            const o = document.createElement('option');
            o.value = ex.id;
            o.textContent = `${ex.exam_name} (${ex.start_date} ~ ${ex.end_date})`;
            examSel.appendChild(o);
        });
        examSel.disabled = false;
    } catch { showAlert('Failed to load sections/exams.'); }
});

sectionSel.addEventListener('change', hidePreview);
examSel.addEventListener('change', hidePreview);

// Preview
$id('previewBtn').addEventListener('click', async function() {
    const sid = sessionSel.value, gid = gradeSel.value,
          sec = sectionSel.value, eid = examSel.value;
    if (!sid || !gid || !sec || !eid) {
        showAlert('Please select all four filters before previewing.');
        return;
    }
    $id('previewIcon').style.display    = 'none';
    $id('previewSpinner').style.display = 'inline-block';
    $id('previewBtnText').textContent   = 'Loading…';
    $id('previewSection').style.display = 'none';
    $id('previewLoading').style.display = 'block';

    try {
        const data = await postJSON(ROUTES.previewCards, {
            session_id:sid, grade_id:gid, section_id:sec, exam_id:eid
        });

        if (!data.students?.length) {
            showAlert('No students found for the selected criteria.');
            $id('previewLoading').style.display = 'none';
            return;
        }

        const pages = Math.ceil(data.count / 8);
        $id('studentCount').textContent = data.count;
        $id('rbPages').textContent = `${pages} page${pages>1?'s':''} · 8 per page`;
        $id('resultDetail').textContent = `${data.exam.name}  ·  ${data.exam.start_date} – ${data.exam.end_date}`;
        $id('resultBar').style.display = 'flex';

        $id('fSessionId').value = sid;
        $id('fGradeId').value   = gid;
        $id('fSectionId').value = sec;
        $id('fExamId').value    = eid;
        $id('downloadBtn').disabled = false;

        renderPreview(data);

        setTimeout(() => $id('previewSection').scrollIntoView({behavior:'smooth',block:'start'}), 120);
    } catch {
        showAlert('Preview failed. Please try again.');
        $id('previewLoading').style.display = 'none';
    } finally {
        $id('previewIcon').style.display    = 'inline';
        $id('previewSpinner').style.display = 'none';
        $id('previewBtnText').textContent   = 'Preview Admit Cards';
    }
});

function renderPreview(data) {
    const exam = data.exam, students = data.students;
    const pages = chunk(students, 8);

    $id('previewMeta').textContent =
        `${exam.name}  ·  ${exam.start_date} – ${exam.end_date}  ·  ${students.length} students`;
    $id('previewPageCount').textContent =
        `${pages.length} Page${pages.length>1?'s':''}`;

    let html = '';
    pages.forEach((pg, pi) => {
        html += `<div class="a4-page">
            <div class="pg-label">Page ${pi+1} of ${pages.length} &nbsp;·&nbsp; 2 columns × 4 rows</div>
            <table class="pg-outer" cellpadding="0" cellspacing="0"><tbody>`;
        chunk(pg, 2).forEach(row => {
            html += '<tr>';
            row.forEach(s => { html += `<td class="cc">${makeCard(s, exam)}</td>`; });
            if (row.length < 2) html += `<td class="cc"><div class="ac-empty"></div></td>`;
            html += '</tr>';
        });
        html += '</tbody></table></div>';
    });

    $id('previewPages').innerHTML = html;
    $id('previewLoading').style.display = 'none';
    $id('previewSection').style.display = 'block';
}



function makeCard(s, exam) {
    return `<table class="ac-card" cellpadding="0" cellspacing="0"><tbody>
        <tr><td class="ac-hdr">
            <table class="ac-hdr-inner" cellpadding="0" cellspacing="0"><tr>
                
                <!-- Logo Section -->
                <td class="ac-logo-cell">
                    <div class="ac-logo-wrap">
                        <img src="{{ url('public/uploads/' . $general->company_logo) }}" alt="Company Logo" class="ac-logo-img">
                    </div>
                </td>



                <!-- School Info -->
                <td class="ac-info-cell">
                    <div class="ac-tagline">{{ $general->school_title }}</div>
                    <div class="ac-sname">{{ $general->school_name }}</div>
                    <div class="ac-saddr">{{ $general->school_address }}</div>
                </td>

            </tr></table>
        </td></tr>

        <tr>
            <td style="padding:0;">
                <div class="ac-banner">ADMIT CARD</div>
            </td>
        </tr>

        <tr><td>
            <div class="ac-body">

                <div class="ac-ename">${esc(exam.name)}</div>
                <div class="ac-edate">
                    (${esc(exam.start_date)} – ${esc(exam.end_date)})
                </div>

                <table class="ac-itbl" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="ac-lb">Name</td>
                        <td class="ac-cl">:</td>
                        <td class="ac-vl">${esc(s.full_name)}</td>
                    </tr>

                    <tr>
                        <td class="ac-lb">Grade</td>
                        <td class="ac-cl">:</td>
                        <td class="ac-vl">${esc(s.grade_name)}</td>
                    </tr>

                    <tr>
                        <td class="ac-lb">Section</td>
                        <td class="ac-cl">:</td>
                        <td class="ac-vl">${esc(s.section_name)}</td>
                    </tr>

                    ${s.roll_number ? `
                    <tr>
                        <td class="ac-lb">Roll No</td>
                        <td class="ac-cl">:</td>
                        <td class="ac-vl">${esc(s.roll_number)}</td>
                    </tr>` : ''}
                </table>

            </div>
        </td></tr>

        <tr><td class="ac-sig">
            <table class="ac-stbl" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        ${sigSVG('ec')}
                        <span class="ac-sline"></span>
                        <span class="ac-slbl">Exam Controller</span>
                    </td>

                    <td>
                        ${sigSVG('pr')}
                        <span class="ac-sline"></span>
                        <span class="ac-slbl">Principal</span>
                    </td>
                </tr>
            </table>
        </td></tr>

    </tbody></table>`;
}


function sigSVG(t) {
    return t==='ec'
        ? `<svg class="ac-sigsvg" viewBox="0 0 72 22" xmlns="http://www.w3.org/2000/svg"><path d="M4 17 Q9 5 15 13 Q19 19 23 9 Q27 2 32 11 Q36 19 41 9 Q45 3 50 12 Q54 19 58 13 Q62 9 67 7" stroke="#333" stroke-width="1.2" fill="none" stroke-linecap="round"/><path d="M16 19 Q24 21 34 19" stroke="#333" stroke-width="0.9" fill="none" stroke-linecap="round"/></svg>`
        : `<svg class="ac-sigsvg" viewBox="0 0 72 22" xmlns="http://www.w3.org/2000/svg"><path d="M5 15 Q12 3 19 12 Q24 18 29 7 Q33 1 39 10 Q43 17 48 8 Q52 3 57 11 Q61 16 65 9" stroke="#333" stroke-width="1.2" fill="none" stroke-linecap="round"/><path d="M20 19 Q30 22 41 19" stroke="#333" stroke-width="0.9" fill="none" stroke-linecap="round"/></svg>`;
}

function esc(s) {
    return String(s??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function chunk(arr, n) {
    const out=[];
    for(let i=0;i<arr.length;i+=n) out.push(arr.slice(i,i+n));
    return out;
}

// Download spinner
$id('downloadBtn').addEventListener('click', function() {
    $id('downloadIcon').style.display    = 'none';
    $id('downloadSpinner').style.display = 'inline-block';
    $id('downloadText').textContent      = 'Generating…';
    setTimeout(() => {
        $id('downloadIcon').style.display    = 'inline';
        $id('downloadSpinner').style.display = 'none';
        $id('downloadText').textContent      = 'Download PDF';
    }, 5000);
});
</script>

@endsection