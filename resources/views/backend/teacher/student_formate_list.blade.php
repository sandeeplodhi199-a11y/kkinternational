@extends('backend.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.content-wrapper {
    background: #f4f6f9;
    min-height: 100vh;
    padding: 20px;
}

.page-title {
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #4f46e5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.card-custom {
    background: #fff;
    border-radius: 20px;
    padding: 25px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    border: 1px solid rgba(0,0,0,.05);
    margin-bottom: 30px;
}

label {
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    margin-bottom: 8px;
    display: block;
}

.form-control, .form-select {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-size: 14px;
    padding: 10px 12px;
    width: 100%;
}

.form-control:focus, .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
    outline: none;
}

.btn-generate, .btn-print-all {
    padding: 11px 28px;
    border-radius: 40px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-generate {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff;
}

.btn-print-all {
    background: linear-gradient(135deg, #0284c7, #0369a1);
    color: #fff;
}

.btn-generate:hover, .btn-print-all:hover {
    transform: translateY(-2px);
}

#sectionCheckboxList {
    max-height: 130px;
    overflow-y: auto;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px;
    background: #f8fafc;
}

#sectionCheckboxList .form-check {
    margin-bottom: 6px;
}

.preview-toolbar {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    color: #fff;
    border-radius: 16px;
    padding: 15px 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.preview-page-counter {
    background: rgba(255,255,255,.15);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 13px;
}

.page-tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.page-tab {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
}

.page-tab:hover, .page-tab.active {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
}

.slip-tab-content {
    display: none;
}

.slip-tab-content.active {
    display: block;
}

.slip-screen-wrap {
    background: #e5e7eb;
    padding: 30px;
    border-radius: 16px;
    display: flex;
    justify-content: center;
}

/* ─────────────────────────────────────────────────────────────
   SLIP STYLES - EXACTLY AS PER YOUR DESIGN
───────────────────────────────────────────────────────────── */
.slip-outer {
    width: 100%;
    max-width: 210mm;
    background: #fff;
    font-family: 'Times New Roman', Arial, sans-serif;
    margin: 0 auto;
    padding: 15px 20px;
}

/* Header Section */
.slip-header {
    text-align: center;
    margin-bottom: 15px;
}

.school-name {
    font-size: 24px;
    font-weight: 700;
    color: #000;
    letter-spacing: 1px;
    font-family: 'Inter';
}

.school-address {
    font-size: 12px;
    color: #000;
    margin-top: 3px;
    font-family: 'Inter';
}

.exam-title {
    font-size: 14px;
    font-weight: 700;
    margin-top: 10px;
    font-family: 'Inter';
}

.exam-subtitle {
    font-size: 12px;
    font-weight: 600;
    font-family: 'Inter';
}

/* Subject Line */
.subject-line {
    text-align: center;
    margin: 10px 0 15px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'Inter';
}

.subject-blank {
    display: inline-block;
    min-width: 250px;
    border-bottom: 1px solid #000;
    margin-left: 8px;
    font-family: 'Inter';
}

.student-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    font-family: 'Inter';
    font-weight: 700;
    
}

.student-table th, .student-table td {
    border: 1px solid #000;
    padding: 6px 5px;
    text-align: left;
    vertical-align: middle;
    font-weight: 700;
}
.student-table .header-row th {
    background: #f5f5f5;
    font-weight: 700;
    font-size: 11px;
    width: 20px;
    font-family: 'Inter';
}

.student-name-cell {
    text-align: left;
    font-weight: normal;
    padding-left: 8px;
    font-family: Inter;
}

.sno-col { width: 35px; }
.name-col { width: auto; }
.mark-col { width: 40px;  }
.remark-col { width: 70px; }

/* Sidebar Tables Container */
.sidebar-container {
    margin-top: 15px;
}

.sidebar-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
    margin-bottom: 15px;
}

.sidebar-table th,
.sidebar-table td {
    border: 1px solid #000;
    padding: 5px 6px;
    text-align: center;
}

.sidebar-table .sidebar-title {
    background: #f5f5f5;
    font-weight: 700;
    font-size: 10px;
    padding: 5px;
}

.sidebar-table .label-cell {
    text-align: left;
    font-weight: normal;
}

.value-cell {
    width: 40px;
}

/* Result Summary Table */
.result-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
}

.result-table th,
.result-table td {
    border: 1px solid #000;
    padding: 5px 6px;
    text-align: left;
}

.result-table th {
    background: #f5f5f5;
    font-weight: 700;
    text-align: center;
}

.result-table .label-cell {
    text-align: left;
}

.result-table .value-cell {
    text-align: center;
    width: 60px;
}

/* Two Column Layout */
.two-column {
    display: flex;
    gap: 20px;
    margin-top: 15px;
}

.left-column {
    flex: 1;
}

.right-column {
    flex: 1;
}

/* Grade Row */
.grade-row th {
    background: #f9f9f9;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    padding: 5px 8px;
}

/* ─────────────────────────────────────────────────────────────
   PRINT STYLES
───────────────────────────────────────────────────────────── */
@media print {
    /* Hide screen UI */
    .content-wrapper > div > *:not(#printAllPages),
    .preview-toolbar,
    .page-tabs,
    #filterCard,
    .page-title,
    .slip-screen-wrap,
    nav, header, footer, .sidebar, .main-footer {
        display: none !important;
    }
    
    /* Show print container */
    #printAllPages {
        display: block !important;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    
    /* Page breaks */
    .print-slip-page {
        page-break-after: always;
        page-break-inside: avoid;
    }
    
    .print-slip-page:last-child {
        page-break-after: auto;
    }
    
    /* Slip print styling */
    .slip-outer {
        max-width: 100%;
        margin: 0;
        padding: 10px 15px;
        box-shadow: none;
    }
    
    /* Font sizes for print */
    .school-name { font-size: 24pt !important; }
    .school-address { font-size: 12pt !important; }
    .exam-title { font-size: 14pt !important; }
    .student-table { font-size: 11pt !important; }
    .sidebar-table { font-size: 10pt !important; }
    
    /* Force backgrounds */
    .student-table .header-row th,
    .sidebar-table .sidebar-title,
    .result-table th,
    .grade-row th {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Remove browser print margins */
    @page {
        size: A4;
        margin: 0mm;
    }
    
    body {
        margin: 0;
        padding: 0;
        background: white;
    }
}
</style>

<div class="content-wrapper">
<div class="container-fluid">

    <h4 class="page-title">
        <i class="fas fa-print"></i>
        <span>Student Mark Record Slip</span>
    </h4>

    {{-- FILTER CARD --}}
    <div class="card-custom" id="filterCard">
        <form id="filterForm" method="GET" action="{{ route('student_formate_list') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label><i class="fas fa-calendar-alt text-primary me-1"></i> Session <span class="text-danger">*</span></label>
                    <select name="session_id" class="form-control select2" required>
                        <option value="">– Select Session –</option>
                        @foreach($sessions as $sess)
                            <option value="{{ $sess->id }}" {{ (isset($session_id) && $session_id == $sess->id) ? 'selected' : '' }}>
                                {{ $sess->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label><i class="fas fa-layer-group me-1"></i> Grade</label>
                    <select name="grade_id" id="gradeSelect" class="form-control select2">
                        <option value="all">All Grades</option>
                        @foreach($grades as $g)
                            <option value="{{ $g->id }}" {{ (isset($grade_ids) && $grade_ids == $g->id) ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label><i class="fas fa-users text-info me-1"></i> Section</label>
                    <div id="sectionCheckboxList">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="section_id" value="all" id="sectionAll" checked>
                            <label class="form-check-label" for="sectionAll">All Sections</label>
                        </div>
                    </div>
                </div>

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
                <i class="fas fa-file-alt"></i>
                Preview – {{ $sessionName ?? '' }}
                <span class="preview-page-counter">{{ count($groups) }} page(s)</span>
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
                @include('backend.teacher.partials.slip_page', ['group' => $group])
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
<div id="printAllPages" style="display: none;">
    @if(isset($groups) && count($groups))
        @foreach($groups as $group)
        <div class="print-slip-page">
            @include('backend.teacher.partials.slip_page', ['group' => $group])
        </div>
        @endforeach
    @endif
</div>

<script>
$(document).ready(function() {
    $('#gradeSelect').on('change', function() {
        let gradeId = $(this).val();
        let $box = $('#sectionCheckboxList');
        
        if (!gradeId || gradeId === 'all') {
            $box.html(`<div class="form-check">
                <input class="form-check-input" type="radio" name="section_id" value="all" id="sectionAll" checked>
                <label class="form-check-label" for="sectionAll">All Sections</label>
            </div>`);
            return;
        }
        
        $box.html('<div class="text-muted p-1"><i class="fas fa-spinner fa-spin me-1"></i> Loading...</div>');
        
        $.get("{{ url('admin/get-sections') }}/" + gradeId, function(res) {
            let html = `<div class="form-check">
                <input class="form-check-input" type="radio" name="section_id" value="all" id="sectionAll">
                <label class="form-check-label" for="sectionAll">All Sections</label>
            </div>`;
            
            res.forEach(s => {
                html += `<div class="form-check">
                    <input class="form-check-input" type="radio" name="section_id" value="${s.id}" id="sec_${s.id}">
                    <label class="form-check-label" for="sec_${s.id}">${s.name}</label>
                </div>`;
            });
            
            $box.html(html);
            
            @if(isset($section_ids) && $section_ids !== 'all')
                $box.find('input[value="{{ $section_ids }}"]').prop('checked', true);
            @endif
        }).fail(() => $box.html('<div class="text-danger p-1">Error loading sections</div>'));
    });
    
    let preGrade = $('#gradeSelect').val();
    if (preGrade && preGrade !== 'all') {
        $('#gradeSelect').trigger('change');
    }
});

function showPage(idx) {
    $('.slip-tab-content').removeClass('active');
    $('.page-tab').removeClass('active');
    $('#page_' + idx).addClass('active');
    $('.page-tab').eq(idx).addClass('active');
}

function printAllSlips() {
    let printContainer = document.getElementById('printAllPages');
    printContainer.style.display = 'block';
    
    setTimeout(function() {
        window.print();
        setTimeout(function() {
            printContainer.style.display = 'none';
        }, 500);
    }, 100);
}
</script>

@endsection