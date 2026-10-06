@extends('backend.layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
:root {
    --ink: #0f172a;
    --ink2: #334155;
    --ink3: #64748b;
    --surface: #f1f5f9;
    --white: #ffffff;
    --border: #e2e8f0;
    --blue: #2563eb;
    --blue-lt: #dbeafe;
    --green: #16a34a;
    --green-lt: #dcfce7;
    --amber: #d97706;
    --amber-lt: #fef3c7;
    --red: #dc2626;
    --red-lt: #fee2e2;
    --purple: #7c3aed;
    --purple-lt: #ede9fe;
    --teal: #0891b2;
    --teal-lt: #cffafe;
    --pink: #db2777;
    --pink-lt: #fce7f3;
    --radius: 14px;
    --radius-sm: 8px;
    --shadow: 0 4px 24px rgba(15,23,42,.07);
}
*{box-sizing:border-box;margin:0;padding:0}
body,.content-wrapper{font-family:'Plus Jakarta Sans',sans-serif;background:var(--surface);color:var(--ink)}
.content-wrapper{padding:24px 20px 80px;min-height:100vh}

/* ── Page Header ── */
.pg-header{display:flex;align-items:center;gap:14px;margin-bottom:22px}
.pg-icon{width:52px;height:52px;background:linear-gradient(135deg,#2563eb,#7c3aed);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;flex-shrink:0;box-shadow:0 6px 20px rgba(37,99,235,.35)}
.pg-title{font-size:1.5rem;font-weight:800;color:var(--ink);line-height:1.2}
.pg-sub{font-size:12.5px;color:var(--ink3);margin-top:2px}

/* ── Tabs ── */
.tab-nav{display:flex;gap:6px;background:var(--white);border-radius:60px;padding:6px;box-shadow:var(--shadow);margin-bottom:20px;width:fit-content}
.tab-btn{padding:9px 24px;border-radius:50px;border:none;background:transparent;font-size:13px;font-weight:600;color:var(--ink3);cursor:pointer;transition:all .25s;font-family:inherit;display:flex;align-items:center;gap:7px}
.tab-btn.active{background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;box-shadow:0 4px 14px rgba(37,99,235,.35)}
.tab-btn:hover:not(.active){background:var(--surface);color:var(--ink)}
.tab-pane{display:none}
.tab-pane.active{display:block}

/* ── Step Tracker ── */
.step-track{display:flex;align-items:center;justify-content:center;background:var(--white);border-radius:60px;padding:10px 28px;box-shadow:var(--shadow);margin-bottom:18px;overflow-x:auto;flex-wrap:nowrap}
.stp{display:flex;flex-direction:column;align-items:center;gap:4px;min-width:60px}
.stp-num{width:36px;height:36px;background:#e2e8f0;color:#94a3b8;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;transition:all .35s cubic-bezier(.4,0,.2,1)}
.stp-label{font-size:10px;font-weight:600;color:#94a3b8;letter-spacing:.3px;transition:color .3s}
.stp.active .stp-num{background:linear-gradient(135deg,var(--blue),var(--purple));color:#fff;box-shadow:0 4px 14px rgba(37,99,235,.4);transform:scale(1.1)}
.stp.active .stp-label{color:var(--blue)}
.stp.done .stp-num{background:var(--green);color:#fff}
.stp.done .stp-label{color:var(--green)}
.stp-line{width:50px;height:2px;background:#e2e8f0;margin-bottom:20px;flex-shrink:0;transition:background .4s}
.stp-line.filled{background:var(--green)}

/* ── Suggestion Bar ── */
.sug-bar{display:flex;align-items:center;gap:12px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-left:5px solid var(--amber);border-radius:12px;padding:12px 18px;margin-bottom:16px;font-size:13px;font-weight:600;color:#92400e;box-shadow:0 2px 10px rgba(217,119,6,.1);transition:all .3s}
.sug-bar i{font-size:1.1rem;flex-shrink:0}
.sug-bar.ok{background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-color:var(--green);color:#14532d}

/* ── Cards ── */
.card-w{background:var(--white);border-radius:20px;box-shadow:var(--shadow);border:1px solid rgba(0,0,0,.04);overflow:hidden;margin-bottom:18px}
.card-hdr{background:linear-gradient(135deg,#1e293b,#0f172a);padding:16px 24px;display:flex;align-items:center;gap:12px}
.card-hdr-title{font-size:15px;font-weight:700;color:#fff}
.card-hdr-sub{font-size:11px;color:#94a3b8;margin-top:2px}
.card-body-inner{padding:24px}

/* ── Form ── */
.form-row{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:18px}
.form-col{flex:1;min-width:170px}
.form-col.wide{flex:2;min-width:240px}
.fld-label{font-size:11.5px;font-weight:700;color:var(--ink2);letter-spacing:.4px;margin-bottom:7px;display:flex;align-items:center;gap:6px;text-transform:uppercase}
.fld-label .req{color:var(--red);margin-left:2px}
.form-control,select.form-control{width:100%;border:2px solid var(--border);border-radius:var(--radius-sm);padding:10px 12px;font-size:13.5px;font-family:inherit;color:var(--ink);background:var(--white);transition:border-color .2s,box-shadow .2s;outline:none;appearance:none}
.form-control:focus,select.form-control:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.err-msg{font-size:11px;color:var(--red);margin-top:4px;font-weight:600;display:none}

/* ── Radio Lists ── */
.radio-scroll{max-height:160px;overflow-y:auto;border:2px solid var(--border);border-radius:var(--radius-sm);background:var(--surface);transition:border-color .2s}
.radio-scroll:hover{border-color:var(--blue)}
.radio-item{display:flex;align-items:center;gap:9px;padding:9px 13px;cursor:pointer;border-bottom:1px solid var(--border);transition:background .15s;font-size:13px;font-weight:500}
.radio-item:last-child{border-bottom:none}
.radio-item:hover{background:#eff6ff}
.radio-item input[type=radio]{accent-color:var(--blue);width:15px;height:15px;cursor:pointer;flex-shrink:0}
.radio-item.selected{background:#dbeafe}

/* ── Chapter Checkbox Cards ── */
.chapter-grid-wrap{border:2px solid var(--border);border-radius:var(--radius);overflow:hidden;background:var(--white);transition:border-color .2s}
.chapter-grid-wrap:focus-within{border-color:var(--blue)}
.ch-grid-header{background:#f8fafc;padding:11px 16px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border)}
.ch-grid-title{font-size:12px;font-weight:700;color:var(--ink2);display:flex;align-items:center;gap:8px;text-transform:uppercase;letter-spacing:.4px}
.ch-count-badge{background:var(--blue-lt);color:var(--blue);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;transition:all .2s}
.ch-count-badge.has-sel{background:var(--green-lt);color:#14532d}
.ch-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(155px,1fr));gap:10px;padding:14px;max-height:320px;overflow-y:auto}
.ch-card{border:2px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;cursor:pointer;transition:all .18s;position:relative;background:var(--white);display:block;user-select:none}
.ch-card:hover{border-color:#93c5fd;background:#f0f9ff;transform:translateY(-1px)}
.ch-card input[type=checkbox]{position:absolute;top:9px;right:9px;width:15px;height:15px;cursor:pointer;accent-color:var(--blue)}
.ch-card .ch-num{font-size:10px;font-weight:700;letter-spacing:.5px;margin-bottom:4px;text-transform:uppercase}
.ch-card .ch-name{font-size:12.5px;font-weight:600;color:var(--ink);line-height:1.35;padding-right:20px}
.ch-card .ch-pg{font-size:11px;margin-top:6px;font-weight:500}

/* Colorful selected states */
.ch-card.sel-blue{border-color:#2563eb;background:#dbeafe}
.ch-card.sel-blue .ch-num{color:#1d4ed8}
.ch-card.sel-blue .ch-pg{color:#1e40af}
.ch-card.sel-green{border-color:#16a34a;background:#dcfce7}
.ch-card.sel-green .ch-num{color:#15803d}
.ch-card.sel-green .ch-pg{color:#166534}
.ch-card.sel-amber{border-color:#d97706;background:#fef3c7}
.ch-card.sel-amber .ch-num{color:#b45309}
.ch-card.sel-amber .ch-pg{color:#92400e}
.ch-card.sel-red{border-color:#dc2626;background:#fee2e2}
.ch-card.sel-red .ch-num{color:#b91c1c}
.ch-card.sel-red .ch-pg{color:#991b1b}
.ch-card.sel-purple{border-color:#7c3aed;background:#ede9fe}
.ch-card.sel-purple .ch-num{color:#6d28d9}
.ch-card.sel-purple .ch-pg{color:#5b21b6}
.ch-card.sel-teal{border-color:#0891b2;background:#cffafe}
.ch-card.sel-teal .ch-num{color:#0e7490}
.ch-card.sel-teal .ch-pg{color:#155e75}
.ch-card.sel-pink{border-color:#db2777;background:#fce7f3}
.ch-card.sel-pink .ch-num{color:#be185d}
.ch-card.sel-pink .ch-pg{color:#9d174d}

/* Chapter footer summary */
.ch-footer{padding:10px 16px;background:#f8fafc;border-top:1px solid var(--border);font-size:12px;color:var(--ink3);display:flex;gap:16px;flex-wrap:wrap}
.ch-footer b{color:var(--ink2)}

/* ── Skeleton ── */
@keyframes shimmer{0%{background-position:-600px 0}100%{background-position:600px 0}}
.skeleton{background:linear-gradient(90deg,#e2e8f0 25%,#f1f5f9 50%,#e2e8f0 75%);background-size:600px 100%;animation:shimmer 1.4s infinite linear;border-radius:8px}
.sk-item{height:38px;margin:6px 8px}

/* ── Buttons ── */
.btn-submit{background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border:none;border-radius:40px;padding:12px 34px;font-size:14px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:9px;transition:all .3s;box-shadow:0 4px 16px rgba(22,163,74,.35);font-family:inherit}
.btn-submit:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 24px rgba(22,163,74,.45)}
.btn-submit:disabled{background:linear-gradient(135deg,#94a3b8,#64748b);cursor:not-allowed;transform:none;box-shadow:none}
.btn-submit .spin{width:17px;height:17px;border:2.5px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:rot .7s linear infinite;display:none}
@keyframes rot{to{transform:rotate(360deg)}}
.btn-secondary{background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;border-radius:40px;padding:11px 28px;font-size:13.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .3s;font-family:inherit;box-shadow:0 4px 14px rgba(37,99,235,.3)}
.btn-secondary:hover{transform:translateY(-2px)}

/* ── Coverage Preview ── */
.cov-preview{margin-top:18px;border:2px solid var(--border);border-radius:var(--radius);overflow:hidden;display:none}
.cov-phdr{background:linear-gradient(135deg,#0284c7,#0369a1);padding:12px 20px;color:#fff;font-weight:700;font-size:14px;display:flex;align-items:center;gap:9px}
.cov-pbody{padding:18px 20px}
.cov-stat-row{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:14px}
.cov-stat{flex:1;min-width:110px;background:var(--surface);border-radius:10px;padding:12px 14px;border:1px solid var(--border);text-align:center}
.cov-stat .val{font-size:20px;font-weight:800;color:var(--blue);font-family:'JetBrains Mono',monospace}
.cov-stat .lbl{font-size:10.5px;font-weight:600;color:var(--ink3);margin-top:3px;text-transform:uppercase;letter-spacing:.3px}
.prog-wrap{margin-top:10px}
.prog-label{display:flex;justify-content:space-between;font-size:12px;font-weight:600;color:var(--ink2);margin-bottom:6px}
.prog-bar{height:13px;background:#e2e8f0;border-radius:20px;overflow:hidden}
.prog-fill{height:100%;border-radius:20px;background:linear-gradient(90deg,#16a34a,#22c55e);transition:width .65s cubic-bezier(.4,0,.2,1);width:0%}
.prog-fill.warn{background:linear-gradient(90deg,#d97706,#f59e0b)}
.prog-fill.danger{background:linear-gradient(90deg,#dc2626,#ef4444)}

/* ── Report ── */
.filter-card{background:var(--white);border-radius:16px;box-shadow:var(--shadow);padding:20px 22px;margin-bottom:18px;border:1px solid rgba(0,0,0,.04)}
.filter-title{font-size:13px;font-weight:700;color:var(--ink2);margin-bottom:14px;display:flex;align-items:center;gap:7px;text-transform:uppercase;letter-spacing:.4px}
.stat-cards{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:20px}
.stat-c{flex:1;min-width:150px;background:var(--white);border-radius:16px;padding:18px 20px;box-shadow:var(--shadow);border:1px solid rgba(0,0,0,.04);position:relative;overflow:hidden}
.stat-c::before{content:'';position:absolute;top:-20px;right:-20px;width:80px;height:80px;border-radius:50%;opacity:.08}
.stat-c.blue::before{background:var(--blue)}
.stat-c.green::before{background:var(--green)}
.stat-c.amber::before{background:var(--amber)}
.stat-c.red::before{background:var(--red)}
.stat-c .sc-val{font-size:28px;font-weight:800;font-family:'JetBrains Mono',monospace;line-height:1}
.stat-c.blue .sc-val{color:var(--blue)}
.stat-c.green .sc-val{color:var(--green)}
.stat-c.amber .sc-val{color:var(--amber)}
.stat-c.red .sc-val{color:var(--red)}
.stat-c .sc-lbl{font-size:11.5px;font-weight:600;color:var(--ink3);margin-top:5px;text-transform:uppercase;letter-spacing:.4px}
.stat-c .sc-icon{position:absolute;top:16px;right:18px;font-size:22px;opacity:.2}
.chart-grid{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:20px}
.chart-box{background:var(--white);border-radius:16px;box-shadow:var(--shadow);border:1px solid rgba(0,0,0,.04);overflow:hidden;flex:1;min-width:300px}
.chart-box-hdr{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center}
.chart-box-title{font-size:13px;font-weight:700;color:var(--ink2);display:flex;align-items:center;gap:7px}
.chart-box-body{padding:18px;min-height:260px;display:flex;align-items:center;justify-content:center}
.chart-box-body canvas{max-height:240px}
.report-table-wrap{background:var(--white);border-radius:16px;box-shadow:var(--shadow);border:1px solid rgba(0,0,0,.04);overflow:hidden}
.report-table-hdr{padding:16px 20px;background:linear-gradient(135deg,#1e293b,#0f172a);display:flex;align-items:center;justify-content:space-between}
.report-table-hdr span{font-size:14px;font-weight:700;color:#fff;display:flex;align-items:center;gap:9px}
.report-table{width:100%;border-collapse:collapse}
.report-table thead th{background:#f8fafc;padding:11px 14px;font-size:11.5px;font-weight:700;color:var(--ink2);text-transform:uppercase;letter-spacing:.4px;border-bottom:2px solid var(--border);white-space:nowrap}
.report-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .15s}
.report-table tbody tr:hover{background:#f8fafc}
.report-table td{padding:11px 14px;font-size:13px;vertical-align:middle}
.badge-pct{display:inline-flex;align-items:center;padding:4px 10px;border-radius:20px;font-size:11.5px;font-weight:700}
.badge-pct.high{background:var(--green-lt);color:#14532d}
.badge-pct.mid{background:var(--amber-lt);color:#7c3409}
.badge-pct.low{background:var(--red-lt);color:#7f1d1d}
.mini-bar{height:6px;border-radius:10px;background:#e2e8f0;margin-top:5px;overflow:hidden;width:90px}
.mini-bar-fill{height:100%;border-radius:10px;background:linear-gradient(90deg,#16a34a,#22c55e)}
.mini-bar-fill.mid{background:linear-gradient(90deg,#d97706,#f59e0b)}
.mini-bar-fill.low{background:linear-gradient(90deg,#dc2626,#ef4444)}

/* ── Toast ── */
#toast-wrap{position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px}

/* ── Misc ── */
.sec-divider{border:none;border-top:2px dashed var(--border);margin:20px 0}
.no-data-msg{text-align:center;padding:40px;color:var(--ink3);font-size:14px}
.no-data-msg i{font-size:36px;display:block;margin-bottom:10px;opacity:.4}
.mt-4{margin-top:1rem}
.text-end{text-align:right}
.w-100{width:100%}

@media(max-width:768px){
    .form-row{flex-direction:column}
    .stp-line{width:22px}
    .pg-title{font-size:1.2rem}
    .stat-cards{flex-direction:column}
    .ch-grid{grid-template-columns:repeat(auto-fill,minmax(130px,1fr))}
}
</style>

<div class="content-wrapper">
<div class="container-fluid">
    <div id="toast-wrap"></div>

    {{-- Page Header --}}
    <div class="pg-header">
        <div class="pg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div>
            <div class="pg-title">Exam Syllabus Coverage</div>
            <div class="pg-sub">
                @if(auth()->user()->type == 'teacher')
                    Apne assigned grades &amp; subjects ki syllabus coverage track karo
                @else
                    Grade-wise subject syllabus coverage map karo
                @endif
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tab-nav">
        <button class="tab-btn active" data-tab="entry"><i class="fas fa-edit"></i> Entry Form</button>
        <button class="tab-btn" data-tab="report"><i class="fas fa-chart-bar"></i> Reports &amp; Analytics</button>
    </div>

    {{-- ═══════════ TAB 1: ENTRY FORM ═══════════ --}}
    <div class="tab-pane active" id="tab-entry">

        {{-- Step Tracker --}}
        <div class="step-track">
            <div class="stp active" id="stp1"><div class="stp-num">1</div><div class="stp-label">Session</div></div>
            <div class="stp-line" id="line1"></div>
            <div class="stp" id="stp2"><div class="stp-num">2</div><div class="stp-label">Grade</div></div>
            <div class="stp-line" id="line2"></div>
            <div class="stp" id="stp3"><div class="stp-num">3</div><div class="stp-label">Exam</div></div>
            <div class="stp-line" id="line3"></div>
            <div class="stp" id="stp4"><div class="stp-num">4</div><div class="stp-label">Subject</div></div>
            <div class="stp-line" id="line4"></div>
            <div class="stp" id="stp5"><div class="stp-num">5</div><div class="stp-label">Chapters</div></div>
        </div>

        {{-- Suggestion Bar --}}
        <div class="sug-bar" id="sugBar">
            <i class="fas fa-lightbulb"></i>
            <span id="sugText">📌 Step 1: Select a session to begin</span>
        </div>

        {{-- Entry Card --}}
        <div class="card-w">
            <div class="card-hdr">
                <i class="fas fa-clipboard-list" style="color:#94a3b8;font-size:17px;"></i>
                <div>
                    <div class="card-hdr-title">Coverage Entry Form</div>
                    <div class="card-hdr-sub">
                        @if(auth()->user()->type == 'teacher')
                            Apne assigned subjects ki coverage bharein
                        @else
                            Grade aur subject select karke coverage map karein
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body-inner">
                <form id="covForm">
                    @csrf
                    {{-- Hidden fields --}}
                    <input type="hidden" id="h_session"     name="session_id">
                    <input type="hidden" id="h_grade"       name="grade_id">
                    <input type="hidden" id="h_exam"        name="exam_id">
                    <input type="hidden" id="h_subject"     name="subject_id">
                    <input type="hidden" id="h_chapter_ids" name="selected_chapter_ids">
                    <input type="hidden" id="h_covered"     name="covered_pages">
                    <input type="hidden" id="h_total"       name="total_pages">
                    <input type="hidden" id="h_pct"         name="coverage_percent">

                    {{-- Row 1: Session + Grade --}}
                    <div class="form-row">
                        <div class="form-col">
                            <div class="fld-label">
                                <i class="fas fa-calendar-alt" style="color:var(--blue)"></i>
                                Session <span class="req">*</span>
                            </div>
                            <select id="sel_session" class="form-control" required>
                                <option value="">📅 Select Session</option>
                                @foreach($session as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                            <div class="err-msg" id="err_session">Please select a session.</div>
                        </div>

                        <div class="form-col">
                            <div class="fld-label">
                                <i class="fas fa-layer-group" style="color:var(--teal)"></i>
                                Grade <span class="req">*</span>
                            </div>
                            <select id="sel_grade" class="form-control" required>
                                <option value="">⭐ Select Grade</option>
                                @foreach($grade as $g)
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endforeach
                            </select>
                            <div class="err-msg" id="err_grade">Please select a grade.</div>
                        </div>
                    </div>

                    {{-- Row 2: Exam + Subject --}}
                    <div class="form-row">
                        <div class="form-col">
                            <div class="fld-label">
                                <i class="fas fa-file-alt" style="color:var(--green)"></i>
                                Exam <span class="req">*</span>
                            </div>
                            <div class="radio-scroll" id="examList">
                                <div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;">
                                    <i class="fas fa-info-circle"></i>&nbsp;Select grade first
                                </div>
                            </div>
                            <div class="err-msg" id="err_exam">Please select an exam.</div>
                        </div>

                        <div class="form-col wide">
                            <div class="fld-label">
                                <i class="fas fa-book" style="color:var(--red)"></i>
                                Subject <span class="req">*</span>
                            </div>
                            <div class="radio-scroll" id="subjectList">
                                <div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;">
                                    <i class="fas fa-info-circle"></i>&nbsp;Select exam first
                                </div>
                            </div>
                            <div class="err-msg" id="err_subject">Please select a subject.</div>
                        </div>
                    </div>

                    <hr class="sec-divider">

                    {{-- Chapter Checkbox Grid --}}
                    <div id="chapter_section" style="display:none; margin-bottom:18px;">
                        <div class="fld-label" style="margin-bottom:10px;">
                            <i class="fas fa-book-open" style="color:var(--purple)"></i>
                            Select Chapters Covered <span class="req">*</span>
                        </div>
                        <div class="chapter-grid-wrap">
                            <div class="ch-grid-header">
                                <div class="ch-grid-title">
                                    <i class="fas fa-check-square" style="color:var(--blue);font-size:14px;"></i>
                                    Click to select/deselect chapters
                                </div>
                                <span class="ch-count-badge" id="ch_count_badge">0 selected</span>
                            </div>
                            <div class="ch-grid" id="chapterGrid"></div>
                            <div class="ch-footer" id="ch_footer" style="display:none;">
                                Covered Pages: <b id="ch_covered_pg">0</b> &nbsp;/&nbsp;
                                Total Pages: <b id="ch_total_pg">0</b> &nbsp;|&nbsp;
                                Coverage: <b id="ch_pct_txt">0%</b>
                            </div>
                        </div>
                        <div class="err-msg" id="err_chapters">Please select at least one chapter.</div>
                    </div>

                    {{-- Live Coverage Preview --}}
                    <div class="cov-preview" id="covPreview">
                        <div class="cov-phdr"><i class="fas fa-chart-pie"></i> Live Coverage Preview</div>
                        <div class="cov-pbody">
                            <div class="cov-stat-row">
                                <div class="cov-stat"><div class="val" id="pv_covered">0</div><div class="lbl">Covered Pages</div></div>
                                <div class="cov-stat"><div class="val" id="pv_total">0</div><div class="lbl">Total Pages</div></div>
                                <div class="cov-stat">
                                    <div class="val" id="pv_pct" style="color:var(--green)">0%</div>
                                    <div class="lbl">Coverage %</div>
                                </div>
                            </div>
                            <div class="prog-wrap">
                                <div class="prog-label">
                                    <span>Coverage Progress</span>
                                    <span id="pv_pct_lbl">0%</span>
                                </div>
                                <div class="prog-bar">
                                    <div class="prog-fill" id="prog_fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn-submit" id="submitBtn" disabled>
                            <div class="spin" id="submitSpinner"></div>
                            <i class="fas fa-save" id="submitIcon"></i>
                            <span id="submitTxt">Save Syllabus Coverage</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /tab-entry --}}

    {{-- ═══════════ TAB 2: REPORTS ═══════════ --}}
    <div class="tab-pane" id="tab-report">

        <div class="filter-card">
            <div class="filter-title">
                <i class="fas fa-filter" style="color:var(--blue)"></i> Report Filters
            </div>
            <div class="form-row" style="margin-bottom:0;">
                <div class="form-col">
                    <div class="fld-label"><i class="fas fa-calendar-alt" style="color:var(--blue)"></i> Session</div>
                    <select id="r_session" class="form-control">
                        <option value="">All Sessions</option>
                        @foreach($session as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-col">
                    <div class="fld-label"><i class="fas fa-layer-group" style="color:var(--teal)"></i> Grade</div>
                    <select id="r_grade" class="form-control">
                        <option value="">All Grades</option>
                        @foreach($grade as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-col">
                    <div class="fld-label"><i class="fas fa-file-alt" style="color:var(--green)"></i> Exam</div>
                    <select id="r_exam" class="form-control">
                        <option value="">All Exams</option>
                    </select>
                </div>
                <div class="form-col" style="display:flex;align-items:flex-end;">
                    <button class="btn-secondary w-100" id="loadReportBtn" style="border-radius:10px;justify-content:center;">
                        <i class="fas fa-search"></i> Load Report
                    </button>
                </div>
            </div>
        </div>

        <div class="stat-cards">
            <div class="stat-c blue"><i class="fas fa-list-ol sc-icon"></i><div class="sc-val" id="sc_total">—</div><div class="sc-lbl">Total Records</div></div>
            <div class="stat-c green"><i class="fas fa-check-circle sc-icon"></i><div class="sc-val" id="sc_avg">—</div><div class="sc-lbl">Avg Coverage %</div></div>
            <div class="stat-c amber"><i class="fas fa-exclamation-triangle sc-icon"></i><div class="sc-val" id="sc_below">—</div><div class="sc-lbl">Below 50%</div></div>
            <div class="stat-c red"><i class="fas fa-times-circle sc-icon"></i><div class="sc-val" id="sc_zero">—</div><div class="sc-lbl">Not Started (0%)</div></div>
        </div>

        <div class="chart-grid">
            <div class="chart-box" style="flex:1.5;">
                <div class="chart-box-hdr">
                    <div class="chart-box-title"><i class="fas fa-chart-bar" style="color:var(--blue)"></i> Coverage % by Subject</div>
                </div>
                <div class="chart-box-body"><canvas id="barChart"></canvas></div>
            </div>
            <div class="chart-box" style="flex:1;max-width:320px;">
                <div class="chart-box-hdr">
                    <div class="chart-box-title"><i class="fas fa-chart-pie" style="color:var(--purple)"></i> Status Breakdown</div>
                </div>
                <div class="chart-box-body"><canvas id="doughnutChart"></canvas></div>
            </div>
        </div>

        <div class="report-table-wrap">
            <div class="report-table-hdr">
                <span><i class="fas fa-table"></i> Detailed Coverage Report</span>
                <button class="btn-secondary" id="exportCsvBtn" style="padding:8px 18px;font-size:12px;border-radius:8px;">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>
            <div style="overflow-x:auto;">
                <table class="report-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Grade</th>
                            <th>Exam</th>
                            <th>Subject</th>
                            @if(auth()->user()->type != 'teacher')
                                <th>Mapped By</th>
                            @endif
                            <th>Chapters Covered</th>
                            <th>Covered Pg</th>
                            <th>Total Pg</th>
                            <th>Coverage %</th>
                        </tr>
                    </thead>
                    <tbody id="reportTbody">
                        <tr>
                            <td colspan="{{ auth()->user()->type == 'teacher' ? 8 : 9 }}" class="no-data-msg">
                                <i class="fas fa-filter"></i>
                                Apply filters and click "Load Report"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- /tab-report --}}

</div>
</div>

<script>
$(function () {

    const isTeacher = {{ auth()->user()->type == 'teacher' ? 'true' : 'false' }};
    const TOKEN     = '{{ csrf_token() }}';

    // ── Color palette for chapter cards ──────────────────────
    const CH_COLORS = ['sel-blue','sel-green','sel-amber','sel-red','sel-purple','sel-teal','sel-pink'];

    // ── Toast ────────────────────────────────────────────────
    function toast(msg, type = 'success') {
        const icons = { success:'fa-check-circle', error:'fa-exclamation-circle', info:'fa-info-circle', warning:'fa-exclamation-triangle' };
        const bgColors = { success:'linear-gradient(135deg,#10b981,#059669)', error:'linear-gradient(135deg,#ef4444,#dc2626)', info:'linear-gradient(135deg,#3b82f6,#2563eb)', warning:'linear-gradient(135deg,#f59e0b,#d97706)' };
        const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
        const el = $(`<div id="${toastId}" style="
            background:${bgColors[type]||bgColors.info};min-width:300px;max-width:440px;
            padding:13px 18px;border-radius:12px;color:#fff;font-size:13.5px;font-weight:500;
            display:flex;align-items:center;gap:11px;
            box-shadow:0 8px 30px rgba(0,0,0,.18);
            animation:slideInR .3s ease;position:relative;overflow:hidden;
            border:1px solid rgba(255,255,255,.2);">
            <i class="fas ${icons[type]||icons.info}" style="font-size:18px;"></i>
            <span style="flex:1;line-height:1.4;">${msg}</span>
            <i class="fas fa-times" style="cursor:pointer;opacity:.7;font-size:13px;"
               onclick="$(this).closest('div').fadeOut(250,function(){$(this).remove();})"></i>
            <div style="position:absolute;bottom:0;left:0;height:3px;background:rgba(255,255,255,.45);width:100%;animation:shrinkW 4s linear forwards;"></div>
        </div>`);
        if (!$('#_toastStyles').length) {
            $('head').append(`<style id="_toastStyles">
                @keyframes slideInR{from{transform:translateX(110%);opacity:0}to{transform:translateX(0);opacity:1}}
                @keyframes shrinkW{from{width:100%}to{width:0%}}
            </style>`);
        }
        $('#toast-wrap').append(el);
        setTimeout(() => el.fadeOut(300, function(){ $(this).remove(); }), 4000);
    }

    // ── State ────────────────────────────────────────────────
    let st = { session_id:'', grade_id:'', exam_id:'', subject_id:'', chapter_ids:[] };
    let chapterData = [];
    let barInst = null, donutInst = null;

    // ── Tab switching ────────────────────────────────────────
    $('.tab-btn').on('click', function () {
        const t = $(this).data('tab');
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('active');
        $('#tab-' + t).addClass('active');
    });

    // ── Skeleton ─────────────────────────────────────────────
    function skRadio(id, n = 3) {
        let h = '';
        for (let i = 0; i < n; i++) h += `<div class="skeleton sk-item"></div>`;
        $('#' + id).html(h);
    }

    // ── Step Tracker + Suggestion Bar ────────────────────────
    function updateUI() {
        const chks = [
            !!st.session_id,
            !!st.grade_id,
            !!st.exam_id,
            !!st.subject_id,
            st.chapter_ids.length > 0
        ];
        ['#stp1','#stp2','#stp3','#stp4','#stp5'].forEach((id, i) => {
            const el = $(id);
            el.removeClass('active done');
            if (chks[i]) {
                el.addClass('done');
                if (['#line1','#line2','#line3','#line4'][i]) $(['#line1','#line2','#line3','#line4'][i]).addClass('filled');
            } else {
                if (['#line1','#line2','#line3','#line4'][i]) $(['#line1','#line2','#line3','#line4'][i]).removeClass('filled');
                if (i === chks.findIndex(v => !v)) el.addClass('active');
            }
        });

        const bar = $('#sugBar'), txt = $('#sugText');
        bar.removeClass('ok');
        if      (!st.session_id)           txt.text('📌 Step 1: Select a session to begin');
        else if (!st.grade_id)             txt.text('📌 Step 2: Select a grade');
        else if (!st.exam_id)              txt.text('📌 Step 3: Select an exam');
        else if (!st.subject_id)           txt.text('📌 Step 4: Pick a subject');
        else if (!st.chapter_ids.length)   txt.text('📌 Step 5: Select chapters covered');
        else { txt.text('✅ All done! Review and save.'); bar.addClass('ok'); }

        const ready = st.session_id && st.grade_id && st.exam_id && st.subject_id && st.chapter_ids.length;
        $('#submitBtn').prop('disabled', !ready);
    }

    // ── Recalculate coverage ─────────────────────────────────
    function recalc() {
        const selectedIds = st.chapter_ids.map(Number);
        if (!selectedIds.length || !chapterData.length) {
            $('#covPreview').slideUp(200);
            $('#ch_footer').hide();
            return;
        }
        const covered = chapterData.filter(c => selectedIds.includes(c.id))
                                   .reduce((s, c) => s + (parseInt(c.no_of_pages) || 0), 0);
        const total   = chapterData.reduce((s, c) => s + (parseInt(c.no_of_pages) || 0), 0) || 1;
        const pct     = Math.round((covered / total) * 100);

        $('#h_covered').val(covered);
        $('#h_total').val(total);
        $('#h_pct').val(pct);
        $('#h_chapter_ids').val(selectedIds.join(','));

        // Footer inside chapter grid
        $('#ch_covered_pg').text(covered);
        $('#ch_total_pg').text(total);
        $('#ch_pct_txt').text(pct + '%');
        $('#ch_footer').show();

        // Preview card
        $('#pv_covered').text(covered);
        $('#pv_total').text(total);
        $('#pv_pct, #pv_pct_lbl').text(pct + '%');
        const fill = $('#prog_fill').removeClass('warn danger');
        fill.css('width', pct + '%');
        if      (pct < 40) fill.addClass('danger');
        else if (pct < 70) fill.addClass('warn');
        $('#pv_pct').css('color', pct >= 70 ? 'var(--green)' : pct >= 40 ? 'var(--amber)' : 'var(--red)');
        $('#covPreview').slideDown(250);
        updateUI();
    }

    // ── Load chapters as colorful checkbox cards ──────────────
    function loadChapters() {
        if (!st.grade_id || !st.subject_id) return;
        $('#chapterGrid').html(
            '<div class="skeleton" style="height:80px;margin:10px;border-radius:8px;"></div>'.repeat(4)
        );
        $('#chapter_section').show();
        $('#ch_footer').hide();
        $('#covPreview').hide();

        $.get(`{{ url('admin/get-syllabus-chapters') }}`, {
            grade_id:   st.grade_id,
            subject_id: st.subject_id
        }, function (res) {
            chapterData = res;
            if (!res || !res.length) {
                $('#chapterGrid').html(
                    '<div style="padding:20px;color:var(--ink3);font-size:13px;text-align:center;">' +
                    '<i class="fas fa-book-open" style="font-size:24px;opacity:.3;display:block;margin-bottom:8px;"></i>' +
                    'No chapters found for this subject.</div>'
                );
                return;
            }
            let html = '';
            res.forEach((c, i) => {
                const col = CH_COLORS[i % CH_COLORS.length];
                html += `<label class="ch-card" data-color="${col}" data-id="${c.id}">
                    <input type="checkbox" value="${c.id}">
                    <div class="ch-num" style="color:var(--ink3)">Chapter ${c.chapter_no}</div>
                    <div class="ch-name">${c.name}</div>
                    <div class="ch-pg" style="color:var(--ink3)"><b>${c.no_of_pages || 0}</b> pages</div>
                </label>`;
            });
            $('#chapterGrid').html(html);

            // Pre-fill existing record
            if (window._existRec && window._existRec.selected_chapter_ids) {
                const existIds = String(window._existRec.selected_chapter_ids).split(',').map(Number).filter(Boolean);
                existIds.forEach(id => {
                    const card = $(`#chapterGrid label[data-id="${id}"]`);
                    if (card.length) {
                        card.find('input').prop('checked', true);
                        card.addClass(card.data('color'));
                    }
                });
                st.chapter_ids = existIds.map(String);
                updateChapterCount();
                recalc();
                window._existRec = null;
            }
            updateUI();
        }).fail(() => toast('Failed to load chapters', 'error'));
    }

    function updateChapterCount() {
        const n = st.chapter_ids.length;
        const badge = $('#ch_count_badge');
        badge.text(n + (n === 1 ? ' chapter' : ' chapters') + ' selected');
        badge.toggleClass('has-sel', n > 0);
    }

    // ── Chapter checkbox change ──────────────────────────────
    $(document).on('change', '#chapterGrid input[type=checkbox]', function () {
        const card  = $(this).closest('label');
        const color = card.data('color');
        const val   = String($(this).val());
        if ($(this).is(':checked')) {
            card.addClass(color);
            if (!st.chapter_ids.includes(val)) st.chapter_ids.push(val);
        } else {
            card.removeClass(color);
            st.chapter_ids = st.chapter_ids.filter(v => v !== val);
        }
        updateChapterCount();
        recalc();
        updateUI();
    });

    // ── Load subjects ────────────────────────────────────────
    function loadSubjects() {
        if (!st.grade_id || !st.exam_id) return;
        skRadio('subjectList');
        $.get(`{{ url('admin/get-syllabus-coverage-subjects') }}`, {
            exam_id:  st.exam_id,
            grade_id: st.grade_id
        }, function (res) {
            if (!res || !res.length) {
                $('#subjectList').html('<div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;"><i class="fas fa-ban"></i>&nbsp;No subjects found</div>');
                toast('No subjects found for this exam', 'info');
                return;
            }
            let h = '';
            res.forEach(s => {
                const sname = s.subject_name || s.name || '(Unnamed)';
                h += `<label class="radio-item">
                        <input type="radio" name="subject_r" value="${s.id}" data-name="${sname}">
                        <i class="fas fa-book" style="color:var(--red);font-size:11px;flex-shrink:0;"></i>
                        ${sname}
                      </label>`;
            });
            $('#subjectList').html(h);
            toast(`${res.length} subject(s) loaded`, 'success');
            updateUI();
        }).fail(() => toast('Failed to load subjects', 'error'));
    }

    // ── Load exams ───────────────────────────────────────────
    function loadExams(gradeId) {
        skRadio('examList');
        $.get(`{{ url('admin/get-exams-syllabus') }}/` + gradeId, function (res) {
            if (!res || !res.length) {
                $('#examList').html('<div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;"><i class="fas fa-ban"></i>&nbsp;No exams found</div>');
                toast('No exams found for this grade', 'info');
                return;
            }
            let h = '';
            res.forEach(e => {
                h += `<label class="radio-item">
                        <input type="radio" name="exam_r" value="${e.id}" data-name="${e.exam_name}">
                        <i class="fas fa-file-alt" style="color:var(--green);font-size:11px;flex-shrink:0;"></i>
                        ${e.exam_name}
                      </label>`;
            });
            $('#examList').html(h);
            toast(`${res.length} exam(s) loaded`, 'success');
            updateUI();
        }).fail(() => toast('Failed to load exams', 'error'));
    }

    // ── Reset downstream ─────────────────────────────────────
    function resetBelow(from) {
        if (from === 'grade') {
            st.exam_id = ''; st.subject_id = ''; st.chapter_ids = [];
            $('#examList').html('<div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;"><i class="fas fa-info-circle"></i>&nbsp;Select grade first</div>');
            $('#subjectList').html('<div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;"><i class="fas fa-info-circle"></i>&nbsp;Select exam first</div>');
            $('#chapter_section').hide(); $('#covPreview').hide();
            $('#ch_count_badge').text('0 selected').removeClass('has-sel');
        }
        if (from === 'exam') {
            st.subject_id = ''; st.chapter_ids = [];
            $('#subjectList').html('<div class="radio-item" style="color:var(--ink3);justify-content:center;font-size:12px;"><i class="fas fa-info-circle"></i>&nbsp;Select exam first</div>');
            $('#chapter_section').hide(); $('#covPreview').hide();
            $('#ch_count_badge').text('0 selected').removeClass('has-sel');
        }
        if (from === 'subject') {
            st.chapter_ids = [];
            $('#chapter_section').hide(); $('#covPreview').hide();
            $('#ch_count_badge').text('0 selected').removeClass('has-sel');
        }
    }

    // ── Check existing record ────────────────────────────────
    function checkExisting() {
        if (!st.session_id || !st.grade_id || !st.exam_id || !st.subject_id) return;
        $.get(`{{ url('admin/get-syllabus-coverage-existing') }}`, {
            session_id: st.session_id,
            grade_id:   st.grade_id,
            exam_id:    st.exam_id,
            subject_id: st.subject_id
        }, function (res) {
            if (res && res.id) {
                window._existRec = res;
                toast('Existing record found — you can update it.', 'info');
            }
            loadChapters();
        }).fail(() => { toast('Error checking existing record', 'error'); loadChapters(); });
    }

    // ══════════════════════════════════════════════════════════
    //  ENTRY FORM EVENTS
    // ══════════════════════════════════════════════════════════

    $('#sel_session').on('change', function () {
        st.session_id = $(this).val();
        $('#h_session').val(st.session_id);
        if (st.session_id) toast('Session: ' + $(this).find('option:selected').text(), 'success');
        updateUI();
    });

    $('#sel_grade').on('change', function () {
        st.grade_id = $(this).val();
        $('#h_grade').val(st.grade_id);
        resetBelow('grade');
        if (st.grade_id) { toast('Grade: ' + $(this).find('option:selected').text(), 'success'); loadExams(st.grade_id); }
        updateUI();
    });

    $(document).on('change', 'input[name=exam_r]', function () {
        st.exam_id = $(this).val();
        $('#h_exam').val(st.exam_id);
        $(this).closest('.radio-item').addClass('selected').siblings().removeClass('selected');
        resetBelow('exam');
        toast('Exam selected', 'success');
        loadSubjects();
        updateUI();
    });

    $(document).on('change', 'input[name=subject_r]', function () {
        st.subject_id = $(this).val();
        $('#h_subject').val(st.subject_id);
        $(this).closest('.radio-item').addClass('selected').siblings().removeClass('selected');
        resetBelow('subject');
        toast('Subject selected — loading chapters...', 'info');
        checkExisting();
        updateUI();
    });

    // ── Form Submit ──────────────────────────────────────────
    $('#covForm').on('submit', function (e) {
        e.preventDefault();
        let ok = true;
        if (!st.session_id)         { $('#err_session').show();  ok = false; } else $('#err_session').hide();
        if (!st.grade_id)           { $('#err_grade').show();    ok = false; } else $('#err_grade').hide();
        if (!st.exam_id)            { $('#err_exam').show();     ok = false; } else $('#err_exam').hide();
        if (!st.subject_id)         { $('#err_subject').show();  ok = false; } else $('#err_subject').hide();
        if (!st.chapter_ids.length) { $('#err_chapters').show(); ok = false; } else $('#err_chapters').hide();
        if (!ok) { toast('Please fill all required fields.', 'error'); return; }

        $('#submitBtn').prop('disabled', true);
        $('#submitSpinner').show();
        $('#submitIcon').hide();
        $('#submitTxt').text('Saving...');

        $.ajax({
            url:    `{{ url('admin/save-syllabus-coverage') }}`,
            method: 'POST',
            data: {
                _token:                TOKEN,
                session_id:            st.session_id,
                grade_id:              st.grade_id,
                exam_id:               st.exam_id,
                subject_id:            st.subject_id,
                selected_chapter_ids:  st.chapter_ids.join(','),
                covered_pages:         $('#h_covered').val(),
                total_pages:           $('#h_total').val(),
                coverage_percent:      $('#h_pct').val()
            },
            success:  res  => toast(res.message || 'Coverage saved!', 'success'),
            error:    xhr  => toast(xhr.responseJSON?.message || 'Something went wrong.', 'error'),
            complete: function () {
                $('#submitBtn').prop('disabled', false);
                $('#submitSpinner').hide();
                $('#submitIcon').show();
                $('#submitTxt').text('Save Syllabus Coverage');
                updateUI();
            }
        });
    });

    // ══════════════════════════════════════════════════════════
    //  REPORT EVENTS
    // ══════════════════════════════════════════════════════════

    $('#r_grade').on('change', function () {
        const gid = $(this).val();
        $('#r_exam').html('<option value="">All Exams</option>');
        if (!gid) return;
        $.get(`{{ url('admin/get-exams-syllabus') }}/` + gid, function (res) {
            let opts = '<option value="">All Exams</option>';
            res.forEach(e => opts += `<option value="${e.id}">${e.exam_name}</option>`);
            $('#r_exam').html(opts);
        }).fail(() => toast('Failed to load exams for report', 'error'));
    });

    const rColspan = isTeacher ? 8 : 9;

    $('#loadReportBtn').on('click', function () {
        toast('Loading report...', 'info');
        $('#reportTbody').html(`<tr><td colspan="${rColspan}">
            <div class="skeleton sk-item" style="margin:10px;height:30px;"></div>
            <div class="skeleton sk-item" style="margin:10px;height:30px;"></div>
            <div class="skeleton sk-item" style="margin:10px;height:30px;"></div>
        </td></tr>`);
        $.get(`{{ url('admin/get-syllabus-coverage-report') }}`, {
            session_id: $('#r_session').val(),
            grade_id:   $('#r_grade').val(),
            exam_id:    $('#r_exam').val()
        }, function (res) {
            renderReport(res);
            if (res && res.length) toast(`${res.length} record(s) loaded`, 'success');
            else toast('No records found', 'info');
        }).fail(() => {
            toast('Failed to load report', 'error');
            $('#reportTbody').html(`<tr><td colspan="${rColspan}" class="no-data-msg"><i class="fas fa-exclamation-triangle"></i>Failed to load</td></tr>`);
        });
    });

    function renderReport(data) {
        if (!data || !data.length) {
            $('#reportTbody').html(`<tr><td colspan="${rColspan}" class="no-data-msg"><i class="fas fa-inbox"></i>No records found</td></tr>`);
            $('#sc_total, #sc_avg, #sc_below, #sc_zero').text('0');
            destroyCharts();
            return;
        }
        const total = data.length;
        const avg   = Math.round(data.reduce((s, r) => s + (parseFloat(r.coverage_percent) || 0), 0) / total);
        const below = data.filter(r => (parseFloat(r.coverage_percent) || 0) < 50).length;
        const zero  = data.filter(r => (parseFloat(r.coverage_percent) || 0) === 0).length;
        $('#sc_total').text(total);
        $('#sc_avg').text(avg + '%');
        $('#sc_below').text(below);
        $('#sc_zero').text(zero);

        let rows = '';
        data.forEach((r, i) => {
            const pct  = parseFloat(r.coverage_percent) || 0;
            const cls  = pct >= 70 ? 'high' : pct >= 40 ? 'mid' : 'low';
            const bCls = pct >= 70 ? ''     : pct >= 40 ? 'mid' : 'low';
            const teacherCell = isTeacher ? '' :
                `<td style="font-size:12px;color:var(--ink3);">${r.mapped_by || '<em>—</em>'}</td>`;
            // chapters_display: pipe-separated list from controller
            const chDisplay = r.chapters_display || '—';
            // Wrap in small scrollable box if long
            const chCell = `<td style="font-size:11.5px;color:var(--ink2);max-width:240px;">
                <div style="max-height:60px;overflow-y:auto;line-height:1.7;">
                    ${chDisplay.split(' | ').map(ch =>
                        `<span style="display:inline-block;background:var(--blue-lt);color:var(--blue);
                         font-size:10.5px;font-weight:700;padding:1px 7px;border-radius:10px;
                         margin:1px 2px;">${ch}</span>`
                    ).join('')}
                </div>
            </td>`;
            rows += `<tr>
                <td><b>${i + 1}</b></td>
                <td><span style="background:var(--blue-lt);color:var(--blue);padding:3px 8px;border-radius:6px;font-size:11.5px;font-weight:700;">${r.grade_name || '—'}</span></td>
                <td style="font-size:12px;">${r.exam_name || '—'}</td>
                <td><b>${r.subject_name || '—'}</b></td>
                ${teacherCell}
                ${chCell}
                <td><b style="color:var(--green);">${r.covered_pages || 0}</b></td>
                <td>${r.total_pages || 0}</td>
                <td>
                    <span class="badge-pct ${cls}">${pct}%</span>
                    <div class="mini-bar"><div class="mini-bar-fill ${bCls}" style="width:${Math.min(pct,100)}%;"></div></div>
                </td>
            </tr>`;
        });
        $('#reportTbody').html(rows);
        renderCharts(data);
    }

    function destroyCharts() {
        if (barInst)   { barInst.destroy();   barInst   = null; }
        if (donutInst) { donutInst.destroy(); donutInst = null; }
    }

    function renderCharts(data) {
        destroyCharts();
        const labels    = data.map(r => r.subject_name || '?');
        const values    = data.map(r => parseFloat(r.coverage_percent) || 0);
        const bgColors  = values.map(v => v >= 70 ? 'rgba(22,163,74,.8)' : v >= 40 ? 'rgba(217,119,6,.8)' : 'rgba(220,38,38,.8)');
        const bdrColors = values.map(v => v >= 70 ? '#16a34a' : v >= 40 ? '#d97706' : '#dc2626');

        barInst = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: { labels, datasets: [{ label:'Coverage %', data:values, backgroundColor:bgColors, borderColor:bdrColors, borderWidth:2, borderRadius:8, borderSkipped:false }] },
            options: {
                responsive:true, maintainAspectRatio:false,
                plugins: { legend:{display:false}, tooltip:{callbacks:{label:c=>`${c.parsed.y}% coverage`}} },
                scales: {
                    y: { beginAtZero:true, max:100, grid:{color:'rgba(0,0,0,.05)'}, ticks:{callback:v=>v+'%',font:{size:11}} },
                    x: { grid:{display:false}, ticks:{font:{size:11},maxRotation:30} }
                }
            }
        });

        const high = data.filter(r => (parseFloat(r.coverage_percent)||0) >= 70).length;
        const mid  = data.filter(r => { const p = parseFloat(r.coverage_percent)||0; return p>=40 && p<70; }).length;
        const low  = data.filter(r => (parseFloat(r.coverage_percent)||0) < 40).length;

        donutInst = new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['High ≥70%','Medium 40–69%','Low <40%'],
                datasets: [{ data:[high,mid,low],
                    backgroundColor:['rgba(22,163,74,.85)','rgba(217,119,6,.85)','rgba(220,38,38,.85)'],
                    borderColor:['#16a34a','#d97706','#dc2626'], borderWidth:2, hoverOffset:10 }]
            },
            options: { responsive:true, maintainAspectRatio:false,
                plugins: { legend:{position:'bottom',labels:{font:{size:11},padding:14}},
                    tooltip:{callbacks:{label:c=>`${c.label}: ${c.raw}`}} }, cutout:'65%' }
        });
    }

    // ── Export CSV ───────────────────────────────────────────
    $('#exportCsvBtn').on('click', function () {
        const hdrCols = isTeacher
            ? ['#','Grade','Exam','Subject','Chapters Covered','Covered Pages','Total Pages','Coverage %']
            : ['#','Grade','Exam','Subject','Mapped By','Chapters Covered','Covered Pages','Total Pages','Coverage %'];
        const rows = [hdrCols];
        $('#reportTable tbody tr').each(function () {
            const tds = $(this).find('td');
            if (tds.length < 5) return;
            const row = [];
            tds.each(function (i) {
                if (i === tds.length - 1) row.push($(this).find('.badge-pct').text().trim());
                else row.push($(this).text().replace(/\s+/g,' ').trim());
            });
            rows.push(row);
        });
        const csv = rows.map(r => r.map(v => '"' + String(v).replace(/"/g,'""') + '"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv], { type:'text/csv' }));
        a.download = 'syllabus_coverage_report.csv';
        a.click();
        toast('CSV exported!', 'success');
    });

    updateUI();
});
</script>

@endsection