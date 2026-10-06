@extends('backend.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
* { margin:0; padding:0; box-sizing:border-box; }

.content-wrapper {
    background:#f4f6f9;
    min-height:100vh;
    padding:20px;
}

.page-title {
    font-weight:800;
    background:linear-gradient(135deg,#1e293b,#4f46e5);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    font-size:1.8rem;
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:25px;
}

.card-custom {
    background:#fff;
    border-radius:20px;
    padding:25px 30px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    border:1px solid rgba(0,0,0,.05);
    margin-bottom:30px;
}

label {
    font-weight:600;
    font-size:13px;
    color:#475569;
    margin-bottom:8px;
    display:block;
}

.form-control, .form-select {
    border-radius:12px;
    border:2px solid #e2e8f0;
    font-size:14px;
    padding:10px 12px;
    width:100%;
}

.form-control:focus, .form-select:focus {
    border-color:#4f46e5;
    box-shadow:0 0 0 3px rgba(79,70,229,.1);
    outline:none;
}

.btn-generate, .btn-print-all {
    padding:11px 28px;
    border-radius:40px;
    border:none;
    font-weight:600;
    font-size:14px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition:all 0.3s;
}

.btn-generate {
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
}

.btn-print-all {
    background:linear-gradient(135deg,#0284c7,#0369a1);
    color:#fff;
}

.btn-generate:hover, .btn-print-all:hover {
    transform:translateY(-2px);
    box-shadow:0 6px 20px rgba(0,0,0,.2);
}

#sectionCheckboxList, #examCheckboxList {
    max-height:130px;
    overflow-y:auto;
    border:2px solid #e2e8f0;
    border-radius:12px;
    padding:10px;
    background:#f8fafc;
}

#sectionCheckboxList .form-check,
#examCheckboxList .form-check {
    margin-bottom:6px;
}

.preview-toolbar {
    background:linear-gradient(135deg,#1e293b,#0f172a);
    color:#fff;
    border-radius:16px;
    padding:15px 25px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:20px;
}

.preview-page-counter {
    background:rgba(255,255,255,.15);
    padding:5px 15px;
    border-radius:20px;
    font-size:13px;
}

.page-tabs {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.page-tab {
    background:#fff;
    border:2px solid #e2e8f0;
    border-radius:10px;
    padding:8px 18px;
    font-size:13px;
    font-weight:600;
    color:#64748b;
    cursor:pointer;
    transition:all .2s;
}

.page-tab:hover, .page-tab.active {
    background:#4f46e5;
    border-color:#4f46e5;
    color:#fff;
}

.slip-tab-content { display:none; }
.slip-tab-content.active { display:block; }

.slip-screen-wrap {
    background:#e5e7eb;
    padding:30px;
    border-radius:16px;
    overflow-x:auto;
}

/* ───── MARKSHEET STYLES ───── */
.slip-outer {
    width:100%;
    min-width:900px;
    background:#fff;
    font-family:'Times New Roman', Arial, sans-serif;
    margin:0 auto;
    padding:15px 20px;
}

.school-name {
    font-size:22px;
    font-weight:700;
    color:#000;
    letter-spacing:1px;
    font-family:'Inter', sans-serif;
}

.school-address {
    font-size:12px;
    color:#000;
    margin-top:3px;
    font-family:'Inter', sans-serif;
}

.exam-title {
    font-size:14px;
    font-weight:700;
    font-family:'Inter', sans-serif;
}

.exam-subtitle {
    font-size:12px;
    font-weight:600;
    font-family:'Inter', sans-serif;
}

.marks-table {
    width:100%;
    border-collapse:collapse;
    font-size:10px;
    font-family:'Inter', sans-serif;
}

.marks-table th,
.marks-table td {
    border:1px solid #000;
    padding:4px 5px;
    text-align:center;
    vertical-align:middle;
    white-space:nowrap;
    font-weight: 700;
}

.marks-table .name-cell {
    text-align:left;
    padding-left:6px;
    white-space:normal;
    min-width:120px;
}

.marks-table thead tr th {
    background:#f5f5f5;
    font-weight:700;
    font-size:10px;
}

.marks-table .sno-col  { width:28px; }
.marks-table .roll-col { width:35px; }
.marks-table .mark-col { width:30px; }
.marks-table .total-col{ width:40px; }
.marks-table .pct-col  { width:38px; }
.marks-table .rank-col { width:32px; }

.absent-mark { color:#dc2626; font-weight:700; }

/* ───── PRINT STYLES ───── */
@media print {
    .content-wrapper > .container-fluid > *:not(#printAllPages),
    .preview-toolbar, .page-tabs,
    #filterCard, .page-title,
    nav, header, footer, .sidebar, .main-footer {
        display:none !important;
    }

    #printAllPages {
        display:block !important;
        position:absolute;
        top:0; left:0;
        width:100%;
        margin:0; padding:0;
    }

    .print-slip-page {
        page-break-after:always;
        page-break-inside:avoid;
        padding:10px 15px;
    }

    .print-slip-page:last-child {
        page-break-after:auto;
    }

    .slip-outer {
        min-width:unset;
        width:100%;
        padding:10px 5px;
        box-shadow:none;
    }

    .marks-table { font-size:8pt; }
    .school-name { font-size:18pt !important; }

    .marks-table thead tr th,
    .marks-table .header-bg {
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

    @page {
        size:A4 landscape;
        margin:8mm;
    }

    body { margin:0; padding:0; background:#fff; }
}
</style>

<div class="content-wrapper">
<div class="container-fluid">

    <h4 class="page-title">
        <i class="fas fa-table"></i>
        <span>Student Consolidated Marks</span>
    </h4>

    {{-- FILTER CARD --}}
    <div class="card-custom" id="filterCard">
        <form id="filterForm" method="GET" action="{{ route('student_data_list') }}">
            <div class="row g-3 align-items-end">

                {{-- Session --}}
                <div class="col-md-3">
                    <label><i class="fas fa-calendar-alt text-primary me-1"></i> Session <span class="text-danger">*</span></label>
                    <select name="session_id" class="form-control" required>
                        <option value="">– Select Session –</option>
                        @foreach($sessions as $sess)
                            <option value="{{ $sess->id }}" {{ (isset($session_id) && $session_id == $sess->id) ? 'selected' : '' }}>
                                {{ $sess->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grade --}}
                <div class="col-md-2">
                    <label><i class="fas fa-layer-group me-1"></i> Grade</label>
                    <select name="grade_id" id="gradeSelect" class="form-control">
                        <option value="all">All Grades</option>
                        @foreach($grades as $g)
                            <option value="{{ $g->id }}" {{ (isset($grade_ids) && $grade_ids == $g->id) ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Section --}}
                <div class="col-md-2">
                    <label><i class="fas fa-users text-info me-1"></i> Section</label>
                    <div id="sectionCheckboxList">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="section_id" value="all" id="sectionAll" checked>
                            <label class="form-check-label" for="sectionAll">All Sections</label>
                        </div>
                    </div>
                </div>

                {{-- Exam --}}
                <div class="col-md-2">
                    <label><i class="fas fa-file-alt text-warning me-1"></i> Exam</label>
                    <div id="examCheckboxList">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exam_id" value="all" id="examAll" checked>
                            <label class="form-check-label" for="examAll">All Exams</label>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                    @if(isset($groups) && count($groups))
                    <button type="button" class="btn-print-all" onclick="printAllSlips()">
                        <i class="fas fa-print"></i> Print All
                    </button>
                    @endif
                </div>

            </div>
        </form>
    </div>

    {{-- PREVIEW AREA --}}
    @if(isset($groups) && count($groups))
    <div id="previewArea">
        <div class="preview-toolbar">
            <div class="pt-left">
                <i class="fas fa-file-spreadsheet me-2"></i>
                Preview – {{ $sessionName ?? '' }}
                <span class="preview-page-counter ms-2">{{ count($groups) }} page(s)</span>
            </div>
            <button class="btn-print-all" onclick="printAllSlips()">
                <i class="fas fa-print me-1"></i> Print All
            </button>
        </div>

        <div class="page-tabs" id="pageTabs">
            @foreach($groups as $key => $group)
            <div class="page-tab {{ $loop->first ? 'active' : '' }}" onclick="showPage({{ $loop->index }})">
                <i class="fas fa-file me-1"></i>{{ $group['grade_name'] }} – {{ $group['section_name'] }}
            </div>
            @endforeach
        </div>

        @foreach($groups as $key => $group)
        <div class="slip-tab-content {{ $loop->first ? 'active' : '' }}" id="page_{{ $loop->index }}">
            <div class="slip-screen-wrap">
                @include('backend.teacher.partials.student_mark_data', ['group' => $group])
            </div>
        </div>
        @endforeach
    </div>

    @elseif(request()->filled('session_id'))
    <div class="card-custom text-center text-danger py-5">
        <i class="fas fa-users-slash fa-2x mb-3 d-block"></i>
        <p class="mb-0 fw-semibold">No students found for the selected criteria.</p>
    </div>
    @endif

</div>
</div>

{{-- PRINT CONTAINER --}}
<div id="printAllPages" style="display:none;">
    @if(isset($groups) && count($groups))
        @foreach($groups as $group)
        <div class="print-slip-page">
            @include('backend.teacher.partials.student_mark_data', ['group' => $group])
        </div>
        @endforeach
    @endif
</div>

<script>
$(document).ready(function () {

    $('#gradeSelect').on('change', function () {
        let gradeId = $(this).val();
        loadSections(gradeId);
        loadExams(gradeId);
    });

    function loadSections(gradeId) {
        let $box = $('#sectionCheckboxList');

        if (!gradeId || gradeId === 'all') {
            $box.html(radioHtml('section_id', 'all', 'sectionAll', 'All Sections', true));
            return;
        }

        $box.html('<div class="text-muted p-1"><i class="fas fa-spinner fa-spin me-1"></i> Loading…</div>');

        $.get("{{ url('admin/get-sections') }}/" + gradeId, function (res) {
            let html = radioHtml('section_id', 'all', 'sectionAll', 'All Sections', true);
            res.forEach(s => {
                html += radioHtml('section_id', s.id, 'sec_' + s.id, s.name, false);
            });
            $box.html(html);

            @if(isset($section_ids) && $section_ids !== 'all')
                $box.find('input[value="{{ $section_ids }}"]').prop('checked', true);
            @endif
        }).fail(() => $box.html('<div class="text-danger p-1">Error loading sections</div>'));
    }

    function loadExams(gradeId) {
        let $box = $('#examCheckboxList');

        if (!gradeId || gradeId === 'all') {
            $box.html(radioHtml('exam_id', 'all', 'examAll', 'All Exams', true));
            return;
        }

        $box.html('<div class="text-muted p-1"><i class="fas fa-spinner fa-spin me-1"></i> Loading…</div>');

        // ★ FIX: route() use karo + e.exam_name
        let examUrl = "{{ route('get.exams', ':grade_id') }}".replace(':grade_id', gradeId);

        $.get(examUrl, function (res) {
            let html = radioHtml('exam_id', 'all', 'examAll', 'All Exams', true);
            res.forEach(e => {
                html += radioHtml('exam_id', e.id, 'exam_' + e.id, e.exam_name, false); // ★ e.exam_name
            });
            $box.html(html);

            @if(isset($exam_id) && $exam_id !== 'all')
                $box.find('input[value="{{ $exam_id }}"]').prop('checked', true);
            @endif
        }).fail(() => $box.html('<div class="text-danger p-1">Error loading exams</div>'));
    }

    function radioHtml(name, val, id, label, checked) {
        return `<div class="form-check">
            <input class="form-check-input" type="radio" name="${name}"
                   value="${val}" id="${id}" ${checked ? 'checked' : ''}>
            <label class="form-check-label" for="${id}">${label}</label>
        </div>`;
    }

    // Page load par agar grade already selected ho
    let preGrade = $('#gradeSelect').val();
    if (preGrade && preGrade !== 'all') {
        loadSections(preGrade);
        loadExams(preGrade);
    }
});

function showPage(idx) {
    $('.slip-tab-content').removeClass('active');
    $('.page-tab').removeClass('active');
    $('#page_' + idx).addClass('active');
    $('.page-tab').eq(idx).addClass('active');
}

function printAllSlips() {
    let pc = document.getElementById('printAllPages');
    pc.style.display = 'block';
    setTimeout(function () {
        window.print();
        setTimeout(() => pc.style.display = 'none', 500);
    }, 150);
}
</script>

@endsection