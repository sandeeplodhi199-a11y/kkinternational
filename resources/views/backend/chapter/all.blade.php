@extends('backend.layouts.app')
@section('content')

@php
use Illuminate\Support\Facades\DB;

$gradeIds   = $page->pluck('grade_id')->unique()->filter();
$subjectIds = $page->pluck('subject_id')->unique()->filter();

$grades   = DB::table('tbl_grade')->whereIn('id', $gradeIds)->pluck('name', 'id');
$subjects = DB::table('tbl_subject')->whereIn('id', $subjectIds)->pluck('name', 'id');


@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --ch-primary   : #4f46e5;
    --ch-primary-lt: #eef2ff;
    --ch-green     : #16a34a;
    --ch-green-lt  : #dcfce7;
    --ch-red       : #dc2626;
    --ch-red-lt    : #fee2e2;
    --ch-amber     : #d97706;
    --ch-amber-lt  : #fef3c7;
    --ch-border    : #e2e8f0;
    --ch-text      : #1e293b;
    --ch-muted     : #64748b;
    --ch-shadow    : 0 4px 24px rgba(79,70,229,.08);
}

.ch-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 24px;
    background: #f0f4ff;
    min-height: 100%;
    color: var(--ch-text);
}

/* ── Top bar ── */
.ch-topbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 22px;
}

/* ── Smart Search Box ── */
.ch-search-box {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid var(--ch-border);
    border-radius: 10px;
    padding: 0 14px;
    gap: 8px;
    transition: border-color .2s, box-shadow .2s;
    box-shadow: 0 2px 8px rgba(79,70,229,.06);
}
.ch-search-box:focus-within {
    border-color: var(--ch-primary);
    box-shadow: 0 0 0 3px rgba(79,70,229,.15);
}
.ch-search-box input {
    border: none; outline: none; background: transparent;
    padding: 10px 0; font-size: 14px; width: 210px;
    font-family: inherit; color: var(--ch-text);
}
.ch-search-box input::placeholder { color: #94a3b8; }
.ch-search-clear {
    cursor: pointer; display: inline-flex;
    align-items: center; justify-content: center;
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--ch-red-lt); color: var(--ch-red);
    font-weight: 700; font-size: 11px; flex-shrink: 0;
    transition: filter .2s;
}
.ch-search-clear:hover { filter: brightness(.9); }

/* ── Filter Select ── */
.ch-select-wrap {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid var(--ch-border);
    border-radius: 10px;
    padding: 0 12px;
    gap: 6px;
    transition: border-color .2s;
}
.ch-select-wrap:focus-within { border-color: var(--ch-primary); }
.ch-select-wrap select {
    border: none; outline: none; background: transparent;
    padding: 10px 0; font-size: 14px;
    font-family: inherit; color: var(--ch-text);
    min-width: 140px; cursor: pointer;
    appearance: none; -webkit-appearance: none;
}
.ch-select-wrap svg { flex-shrink: 0; color: var(--ch-muted); }

/* Clear filter link */
.ch-clear-link {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 12.5px; color: var(--ch-red);
    text-decoration: none; font-weight: 600;
    padding: 6px 10px; border-radius: 8px;
    background: var(--ch-red-lt); transition: filter .2s;
}
.ch-clear-link:hover { filter: brightness(.92); text-decoration: none; }

.ch-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 18px; border-radius: 10px; font-size: 13.5px;
    font-weight: 600; cursor: pointer; border: none;
    text-decoration: none; white-space: nowrap;
    transition: filter .2s, transform .15s; font-family: inherit;
}
.ch-btn:hover { filter: brightness(1.07); transform: translateY(-1px); text-decoration: none; }
.ch-btn-filter  { background: var(--ch-primary-lt); color: var(--ch-primary); }
.ch-btn-success { background: var(--ch-green); color: #fff; }
.ch-spacer { flex: 1; }

/* ── Card ── */
.ch-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: var(--ch-shadow);
    overflow: hidden;
}
.ch-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #fff;
}
.ch-card-head h3 {
    margin: 0; font-size: 16px; font-weight: 700;
    display: flex; align-items: center; gap: 9px;
}
.ch-count-badge {
    background: rgba(255,255,255,.22);
    border-radius: 20px; padding: 2px 12px;
    font-size: 13px; font-weight: 600;
}

/* ── Active filter pills ── */
.ch-filter-bar {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: var(--ch-primary-lt);
    border-bottom: 1px solid #dde3ff;
    flex-wrap: wrap;
    font-size: 12.5px; font-weight: 600; color: var(--ch-primary);
}
.ch-filter-bar span { opacity: .7; }
.ch-filter-pill {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fff; border: 1.5px solid var(--ch-primary);
    border-radius: 20px; padding: 2px 10px;
    font-size: 12px; font-weight: 700; color: var(--ch-primary);
    opacity: 1 !important;
}

/* ── Alerts ── */
.ch-alert-success {
    margin: 14px 20px 0;
    background: var(--ch-green-lt);
    border-left: 4px solid var(--ch-green);
    color: var(--ch-green);
    padding: 11px 15px; border-radius: 8px;
    font-size: 14px; font-weight: 500;
}
.ch-alert-empty {
    padding: 48px 20px; text-align: center;
    color: var(--ch-muted); font-size: 15px;
}
.ch-alert-empty svg { display: block; margin: 0 auto 14px; opacity: .3; }

/* ── Table ── */
.ch-table-wrap { overflow-x: auto; }
.ch-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.ch-table thead tr {
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    color: #fff;
}
.ch-table thead th {
    padding: 12px 15px; font-weight: 600;
    white-space: nowrap; text-align: left; letter-spacing: .3px;
}
.ch-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.ch-table tbody tr:nth-child(even) { background: #fbfaff; }
.ch-table tbody tr:hover { background: #f3f0ff !important; }
.ch-table tbody td { padding: 11px 15px; vertical-align: middle; }

/* Cells */
.ch-sno {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--ch-primary-lt); color: var(--ch-primary);
    font-weight: 700; font-size: 12px;
}
.ch-pill {
    display: inline-block; padding: 3px 10px; border-radius: 6px;
    background: var(--ch-primary-lt); color: var(--ch-primary);
    font-weight: 700; font-size: 13px;
}
.ch-pages {
    display: inline-flex; align-items: center; gap: 4px;
    background: var(--ch-amber-lt); color: var(--ch-amber);
    border-radius: 6px; padding: 3px 10px;
    font-size: 12px; font-weight: 600;
}
.ch-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 20px; font-size: 12px;
    font-weight: 600; text-decoration: none; transition: filter .2s;
}
.ch-status:hover { filter: brightness(.92); text-decoration: none; }
.ch-status::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: currentColor;
}
.ch-status.active   { background: var(--ch-green-lt); color: var(--ch-green); }
.ch-status.inactive { background: var(--ch-red-lt);   color: var(--ch-red);   }
.ch-user {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600; color: #fff; white-space: nowrap;
}
.ch-date { color: var(--ch-muted); font-size: 12px; white-space: nowrap; }

/* ── Action dropdown ── */
.ch-action { position: relative; display: inline-block; }
.ch-action-btn {
    width: 32px; height: 32px; border-radius: 8px;
    background: #f1f5f9; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ch-muted); font-size: 18px; line-height: 1;
    transition: background .15s;
}
.ch-action-btn:hover { background: var(--ch-primary-lt); color: var(--ch-primary); }
.ch-dropdown {
    display: none; position: absolute; right: 0; top: 38px;
    background: #fff; border: 1.5px solid var(--ch-border);
    border-radius: 10px; box-shadow: 0 8px 28px rgba(0,0,0,.12);
    z-index: 999; min-width: 130px; overflow: hidden;
}
.ch-dropdown.open { display: block; }
.ch-dropdown a {
    display: block; padding: 10px 16px; font-size: 13.5px;
    color: var(--ch-text); text-decoration: none;
    font-weight: 500; transition: background .15s;
}
.ch-dropdown a:hover        { background: var(--ch-primary-lt); color: var(--ch-primary); }
.ch-dropdown a.ch-del:hover { background: var(--ch-red-lt);     color: var(--ch-red);     }

/* ── Pagination ── */
.ch-pagination {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px; padding: 14px 20px;
    border-top: 1.5px solid var(--ch-border);
    font-size: 13px; color: var(--ch-muted);
}
.pg-links { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.pg-links a, .pg-links span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 36px; height: 36px; padding: 0 10px; border-radius: 8px;
    font-weight: 600; font-size: 13px; text-decoration: none;
    border: 1.5px solid var(--ch-border); color: var(--ch-text);
    transition: all .18s;
}
.pg-links a:hover             { background: var(--ch-primary); border-color: var(--ch-primary); color: #fff; }
.pg-links span.pg-active      { background: var(--ch-primary); border-color: var(--ch-primary); color: #fff; }
.pg-links span.pg-disabled    { opacity: .4; cursor: not-allowed; }
.pg-links span.pg-dots        { border: none; min-width: auto; padding: 0 4px; }
</style>

{{-- ════════════════════════════════════════════════ --}}
<div class="content-wrapper">
<div class="ch-page">

    {{-- ── Top bar: Search + Grade + Subject filter ── --}}
    <form method="get" action="" id="chFilterForm" style="display:contents">
    <div class="ch-topbar">

        {{-- Smart Search Box --}}
        <div class="ch-search-box">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#4f46e5">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text"
                   name="keyword"
                   id="chKeyword"
                   placeholder="Search chapter name…"
                   value="{{ $data['keyword'] ?? '' }}"
                   autocomplete="off">
            @if(!empty($data['keyword']))
            <span class="ch-search-clear" onclick="chClearSearch()" title="Clear search">✕</span>
            @endif
        </div>

        {{-- Grade Filter --}}
        <div class="ch-select-wrap">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
            <select name="filter_grade" id="chGradeFilter">
                <option value="">All Grades</option>
                @foreach($allGrades as $gId => $gName)
                    <option value="{{ $gId }}" {{ $data['filter_grade'] == $gId ? 'selected' : '' }}>
                        {{ $gName }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subject Filter — populated via AJAX --}}
        <div class="ch-select-wrap">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            <select name="filter_subject" id="chSubjectFilter">
                <option value="">All Subjects</option>
                @if(!empty($data['filter_subject']) && !empty($allSubjects[$data['filter_subject']]))
                    <option value="{{ $data['filter_subject'] }}" selected>
                        {{ $allSubjects[$data['filter_subject']] }}
                    </option>
                @endif
            </select>
        </div>

        {{-- Clear filters --}}
        @if(!empty($data['filter_grade']) || !empty($data['filter_subject']) || !empty($data['keyword']))
        <a href="{{ url()->current() }}" class="ch-clear-link">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
            Clear
        </a>
        @endif

        <div class="ch-spacer"></div>
        <a href="{{ url('admin/add-chapter') }}" class="ch-btn ch-btn-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Chapter
        </a>
    </div>
    </form>

    {{-- Card --}}
    <div class="ch-card">

        {{-- Card header --}}
        <div class="ch-card-head">
            <h3>
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
                Chapter Management
            </h3>
            <span class="ch-count-badge">{{ $page->total() }} Records</span>
        </div>

        {{-- Active filter indicator bar --}}
        @if(!empty($data['filter_grade']) || !empty($data['filter_subject']) || !empty($data['keyword']))
        <div class="ch-filter-bar">
            <span>Filtered by:</span>
            @if(!empty($data['keyword']))
                <span class="ch-filter-pill">🔍 "{{ $data['keyword'] }}"</span>
            @endif
            @if(!empty($data['filter_grade']))
                <span class="ch-filter-pill">
                    🎓 {{ $allGrades[$data['filter_grade']] ?? 'Grade' }}
                </span>
            @endif
            @if(!empty($data['filter_subject']))
                <span class="ch-filter-pill">
                    📘 {{ $allSubjects[$data['filter_subject']] ?? 'Subject' }}
                </span>
            @endif
        </div>
        @endif

        {{-- Session success --}}
        @if(\Session::has('success'))
        <div class="ch-alert-success">{!! \Session::get('success') !!}</div>
        @endif

        {{-- Table --}}
        @if($page->total() > 0)

        @php
        $userColors = ['#4f46e5','#16a34a','#dc2626','#d97706','#0891b2','#7c3aed','#db2777','#059669'];
        $authUser   = auth()->user();
        @endphp

        <div class="ch-table-wrap">
            <table class="ch-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Chapter Name</th>
                        <th>Ch. No</th>
                        <th>Pages</th>
                        <th>Status</th>
                        <th>Added By</th>
                        <th>Updated By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        @if(in_array('2_27', $permExplodesub) || in_array('2_28', $permExplodesub))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($page as $pgs)
                    <tr>
                        <td><span class="ch-sno">{{ $i + 1 }}</span></td>
                        <td>{{ $grades[$pgs->grade_id]   ?? '—' }}</td>
                        <td>{{ $subjects[$pgs->subject_id] ?? '—' }}</td>
                        <td style="font-weight:600">{{ $pgs->name }}</td>
                        <td><span class="ch-pill">{{ $pgs->chapter_no }}</span></td>
                        <td>
                            <span class="ch-pages">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                {{ $pgs->no_of_pages }}
                            </span>
                        </td>
                        <td>
                            @if($pgs->status == 'Active')
                                <a class="ch-status active"  href="{{ url('admin/chapter/'.$pgs->id.'?status=Inactive') }}">Active</a>
                            @else
                                <a class="ch-status inactive" href="{{ url('admin/chapter/'.$pgs->id.'?status=Active') }}">Inactive</a>
                            @endif
                        </td>
                        <td>
                            @php $c = $userColors[array_rand($userColors)]; @endphp
                            <span class="ch-user" style="background:{{ isset($users[$pgs->add_id]) ? $c : '#94a3b8' }}">
                                {{ $users[$pgs->add_id] ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            @php $c = $userColors[array_rand($userColors)]; @endphp
                            <span class="ch-user" style="background:{{ isset($users[$pgs->update_id]) ? $c : '#94a3b8' }}">
                                {{ $users[$pgs->update_id] ?? 'N/A' }}
                            </span>
                        </td>
                        <td><span class="ch-date">{{ \Carbon\Carbon::parse($pgs->created_at)->format('d M Y') }}</span></td>
                        <td><span class="ch-date">{{ \Carbon\Carbon::parse($pgs->updated_at)->format('d M Y') }}</span></td>

                        @if(in_array('2_27', $permExplodesub) || in_array('2_28', $permExplodesub))
                        <td>
                            <div class="ch-action">
                                <button class="ch-action-btn" onclick="chToggle(this)">⋮</button>
                                <div class="ch-dropdown">
                                    @if(in_array('2_27', $permExplodesub))
                                    <a href="{{ url('admin/edit-chapter/'.$pgs->id_hash) }}">✏️ Edit</a>
                                    @endif
                                    @if(in_array('2_27', $permExplodesub) && $authUser->type != 'teacher')
                                    <a class="ch-del"
                                       href="{{ url('admin/delete-chapter/'.$pgs->id) }}"
                                       onclick="return confirm('Are you sure you want to delete this chapter?')">
                                       🗑️ Delete
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @php ++$i; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($page->lastPage() > 1)
        <div class="ch-pagination">
            <span>Showing {{ $page->firstItem() }}–{{ $page->lastItem() }} of {{ $page->total() }} results</span>
            <div class="pg-links">

                {{-- Prev --}}
                @if($page->onFirstPage())
                <span class="pg-disabled">← Prev</span>
                @else
                <a href="{{ $page->previousPageUrl() }}">← Prev</a>
                @endif

                {{-- Window --}}
                @php
                    $cur  = $page->currentPage();
                    $last = $page->lastPage();
                    $from = max(1, $cur - 2);
                    $to   = min($last, $cur + 2);
                @endphp

                @if($from > 1)
                    <a href="{{ $page->url(1) }}">1</a>
                    @if($from > 2)<span class="pg-dots">…</span>@endif
                @endif

                @for($p = $from; $p <= $to; $p++)
                    @if($p == $cur)
                        <span class="pg-active">{{ $p }}</span>
                    @else
                        <a href="{{ $page->url($p) }}">{{ $p }}</a>
                    @endif
                @endfor

                @if($to < $last)
                    @if($to < $last - 1)<span class="pg-dots">…</span>@endif
                    <a href="{{ $page->url($last) }}">{{ $last }}</a>
                @endif

                {{-- Next --}}
                @if($page->hasMorePages())
                <a href="{{ $page->nextPageUrl() }}">Next →</a>
                @else
                <span class="pg-disabled">Next →</span>
                @endif

            </div>
        </div>
        @endif

        @else
        <div class="ch-alert-empty">
            <svg width="46" height="46" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            No chapters found. Try a different filter or add a new chapter.
        </div>
        @endif

    </div>{{-- /.ch-card --}}
</div>{{-- /.ch-page --}}
</div>{{-- /.content-wrapper --}}

<script>
/* ── Action dropdown toggle ── */
function chToggle(btn) {
    var dd = btn.nextElementSibling;
    document.querySelectorAll('.ch-dropdown.open').forEach(function(el) {
        if (el !== dd) el.classList.remove('open');
    });
    dd.classList.toggle('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.ch-action'))
        document.querySelectorAll('.ch-dropdown.open')
                .forEach(function(el) { el.classList.remove('open'); });
});

/* ── AJAX Subject Loader ── */
var _selectedSubject = '{{ $data['filter_subject'] ?? '' }}';

function chLoadSubjects(gradeId, callback) {
    var $sub = document.getElementById('chSubjectFilter');

    if (!gradeId) {
        $sub.innerHTML = '<option value="">All Subjects</option>';
        document.getElementById('chFilterForm').submit();
        return;
    }

    $sub.innerHTML = '<option value="">Loading…</option>';
    $sub.disabled  = true;

    fetch('/admin/get-subjects/' + gradeId)
        .then(function(r) { return r.json(); })
        .then(function(subjects) {
            var html = '<option value="">All Subjects</option>';
            subjects.forEach(function(s) {
                var sel = (String(s.id) === String(_selectedSubject)) ? ' selected' : '';
                html += '<option value="' + s.id + '"' + sel + '>' + s.name + '</option>';
            });
            $sub.innerHTML = html;
            $sub.disabled  = false;
            if (typeof callback === 'function') callback();
        })
        .catch(function() {
            $sub.innerHTML = '<option value="">All Subjects</option>';
            $sub.disabled  = false;
        });
}

/* Grade change — load subjects then auto-submit */
document.getElementById('chGradeFilter').addEventListener('change', function() {
    var gradeId = this.value;
    _selectedSubject = '';
    if (!gradeId) {
        document.getElementById('chSubjectFilter').innerHTML = '<option value="">All Subjects</option>';
        document.getElementById('chFilterForm').submit();
        return;
    }
    chLoadSubjects(gradeId, function() {
        document.getElementById('chFilterForm').submit();
    });
});

/* Subject change — just submit */
document.getElementById('chSubjectFilter').addEventListener('change', function() {
    document.getElementById('chFilterForm').submit();
});

/* On page load — if grade already selected, reload its subjects */
(function() {
    var gradeId = document.getElementById('chGradeFilter').value;
    if (gradeId) {
        chLoadSubjects(gradeId);
    }
})();

/* ── Smart Search ── */
var chKeyword = document.getElementById('chKeyword');
var chTimer   = null;

chKeyword.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('chFilterForm').submit();
        return;
    }
    clearTimeout(chTimer);
    var val = this.value.trim();
    if (val.length >= 2 || val.length === 0) {
        chTimer = setTimeout(function() {
            document.getElementById('chFilterForm').submit();
        }, 600);
    }
});

function chClearSearch() {
    chKeyword.value = '';
    document.getElementById('chFilterForm').submit();
}
</script>

@endsection