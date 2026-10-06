@extends('backend.layouts.app')
@section('content')

<style>
.content-wrapper {
    background: #f4f6f9;
    min-height: calc(100vh - 120px);
    padding: 20px;
}
.card-custom {
    background: #fff; border-radius: 20px; padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}
.card-custom:hover { box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
.page-title {
    font-weight: 700;
    background: linear-gradient(135deg, #1e293b, #4f46e5);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    display: flex; align-items: center; gap: 12px; font-size: 1.6rem; margin-bottom: 20px;
}
.filter-box {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 16px; padding: 20px; margin-bottom: 25px; border: 1px solid #e2e8f0;
}
.filter-box label {
    font-weight: 600; font-size: 13px; color: #475569; margin-bottom: 8px;
    display: flex; align-items: center; gap: 6px;
}
.form-control, select.form-control {
    border-radius: 12px; border: 2px solid #e2e8f0;
    padding: 1px 14px; transition: all 0.2s ease; font-size: 17px;
}
.form-control:focus, select.form-control:focus {
    border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); outline: none;
}
.btn-filter {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff; padding: 8px 25px; border-radius: 12px; border: none;
    transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
    font-weight: 500; margin-top: 25px;
}
.btn-filter:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }
.btn-reset {
    background: linear-gradient(135deg, #64748b, #475569);
    color: #fff; padding: 8px 25px; border-radius: 12px; border: none;
    transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
    font-weight: 500; margin-left: 10px; text-decoration: none;
}
.btn-reset:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); color: white; }
.table { border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.table thead { background: #534ce7; color: #fff; }
.table thead th {
    padding: 14px 12px; font-weight: 600; font-size: 13px;
    letter-spacing: 0.3px; border-bottom: none; white-space: nowrap;
}
.table tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; }
.table tbody tr:hover { background: #f8fafc; }
.badge-pass    { background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-fail    { background: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-excellent{ background: #3b82f6; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-absent  { background: #6b7280; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
.icon-primary { color: #4f46e5; } .icon-success { color: #16a34a; } .icon-warning { color: #f59e0b; }
.icon-info    { color: #3b82f6; } .icon-purple  { color: #8b5cf6; } .icon-pink    { color: #ec4899; }
@media (max-width: 768px) {
    .table-responsive { font-size: 12px; }
    .btn-filter, .btn-reset { width: 100%; margin-top: 10px; margin-left: 0; }
    .filter-box .row > div { margin-bottom: 15px; }
}
a.btn.btn-sm { color: white; background: #ef4444; font-size: 14px; font-weight: 700; }
.btn-sm:hover { color: white; background: #dc2626; }
.card-body.d-flex.flex-wrap.align-items-center.gap-2 { background: #fff0dc; }
.marks-cell { font-size: 13px; }
.marks-value { font-weight: 500; }
.marks-max { color: #6c757d; font-size: 11px; }
.marks-percentage { font-size: 11px; color: #4f46e5; font-weight: 600; margin-top: 2px; }
.roll-number { display: block; font-size: 10px; color: #6c757d; margin-top: 2px; }
.filter-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
.filter-badge i { margin-right: 5px; font-size: 11px; }
.active-filters-section { background: #fff0dc; border-left: 4px solid #f59e0b; }

/* Subject summary box */
.subject-summary-box {
    margin-top: 6px;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #86efac;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 11px;
    line-height: 1.8;
}
.subject-summary-box .s-total { color:#0284c7; font-weight:700; }
.subject-summary-box .s-inc   { color:#16a34a; font-weight:700; }
.subject-summary-box .s-exc   { color:#dc2626; font-weight:700; }
.subject-summary-box .s-names { color:#6b7280; font-size:10px; display:block; margin-left:14px; }
</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <h4 class="page-title">
            <i class="fas fa-chart-line"></i>
            <span>Student Marks List</span>
        </h4>

        <!-- Filter Section -->
        <div class="filter-box">
            <form method="GET" action="{{ route('student-marks-list') }}" id="filterForm">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label><i class="fas fa-calendar-alt icon-info"></i> Session</label>
                        <select name="session_id" class="form-control select2" id="session_filter">
                            <option value="">All Sessions</option>
                            @forelse($sessions ?? [] as $session)
                                <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                    {{ $session->name }}
                                </option>
                            @empty
                                <option value="" disabled>No sessions available</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-layer-group icon-purple"></i> Grade</label>
                        <select name="grade_id" class="form-control select2" id="grade_filter">
                            <option value="">All Grades</option>
                            @forelse($grades ?? [] as $grade)
                                <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                    {{ $grade->name }}
                                </option>
                            @empty
                                <option value="" disabled>No grades available</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-users icon-primary"></i> Section</label>
                        <select name="section_id" class="form-control select2" id="section_filter">
                            <option value="">All Sections</option>
                            @if(request('grade_id') && isset($sectionsList) && $sectionsList->count() > 0)
                                @foreach($sectionsList as $section)
                                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Select grade first</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-file-alt icon-success"></i> Exam</label>
                        <select name="exam_id" class="form-control select2" id="exam_filter">
                            <option value="">All Exams</option>
                            @forelse($exams ?? [] as $exam)
                                <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->exam_name }}
                                </option>
                            @empty
                                <option value="" disabled>No exams available</option>
                            @endforelse
                        </select>
                    </div>

                    {{-- Subject filter + included/excluded summary --}}
                    <div class="col-md-2">
                        <label><i class="fas fa-book icon-pink"></i> Subject</label>
                        <select name="subject_id" class="form-control select2" id="subject_filter">
                            <option value="">All Subjects</option>
                            @if(request('exam_id') && request('grade_id') && request('section_id') && isset($subjects) && $subjects->count() > 0)
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_id ?? $subject->id }}"
                                        {{ request('subject_id') == ($subject->subject_id ?? $subject->id) ? 'selected' : '' }}>
                                        {{ $subject->subject_name ?? $subject->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Select exam, grade &amp; section first</option>
                            @endif
                        </select>

                        {{-- ✅ Included / Excluded summary — shows when exam + grade selected --}}
                        @if(request('exam_id') && request('grade_id'))
                            @php
                                $summarySubjects = DB::table('tbl_exam_subject_marks as esm')
                                    ->join('tbl_subject as s', 's.id', '=', 'esm.subject_id')
                                    ->where('esm.exam_id', request('exam_id'))
                                    ->where('esm.grade_id', request('grade_id'))
                                    ->where('esm.is_deleted', 0)
                                    ->select('s.name as subject_name', 'esm.is_included')
                                    ->orderBy('esm.is_included', 'DESC')
                                    ->orderBy('s.name')
                                    ->get();

                                $sTotal    = $summarySubjects->count();
                                $sIncluded = $summarySubjects->where('is_included', 1)->count();
                                $sExcluded = $summarySubjects->where('is_included', 0)->count();
                                $sExcNames = $summarySubjects->where('is_included', 0)->pluck('subject_name')->implode(', ');
                            @endphp

                            @if($sTotal > 0)
                            <div class="subject-summary-box">
                                <div><i class="fas fa-book-open" style="color:#0284c7;"></i> Total: <span class="s-total">{{ $sTotal }}</span> subjects</div>
                                <div><i class="fas fa-check-circle" style="color:#16a34a;"></i> <span class="s-inc">{{ $sIncluded }}</span> Included</div>
                                @if($sExcluded > 0)
                                <div>
                                    <i class="fas fa-times-circle" style="color:#dc2626;"></i> <span class="s-exc">{{ $sExcluded }}</span> Excluded
                                    <span class="s-names">{{ $sExcNames }}</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        @endif
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-search"></i> Filter Results
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if(request()->anyFilled(['session_id', 'grade_id', 'section_id', 'exam_id', 'subject_id']))
        <div class="card shadow-sm mb-3 border-0 active-filters-section">
            <div class="card-body py-3 px-4">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="me-2">
                        <i class="fas fa-filter text-warning"></i>
                        <strong class="ms-1">Active Filters:</strong>
                    </div>

                    @if(request('session_id'))
                        <span class="filter-badge" style="background:#dbeafe;color:#1e40af;">
                            <i class="fas fa-calendar-alt"></i>
                            Session: {{ $sessions->where('id', request('session_id'))->first()->name ?? 'N/A' }}
                        </span>
                    @endif
                    @if(request('grade_id'))
                        <span class="filter-badge" style="background:#dcfce7;color:#166534;">
                            <i class="fas fa-layer-group"></i>
                            Grade: {{ $grades->where('id', request('grade_id'))->first()->name ?? 'N/A' }}
                        </span>
                    @endif
                    @if(request('section_id'))
                        <span class="filter-badge" style="background:#fed7aa;color:#92400e;">
                            <i class="fas fa-users"></i>
                            Section: {{ $sectionsList->where('id', request('section_id'))->first()->name ?? 'N/A' }}
                        </span>
                    @endif
                    @if(request('exam_id'))
                        <span class="filter-badge" style="background:#fee2e2;color:#991b1b;">
                            <i class="fas fa-file-alt"></i>
                            Exam: {{ $exams->where('id', request('exam_id'))->first()->exam_name ?? 'N/A' }}
                        </span>
                    @endif
                    @if(request('subject_id'))
                        <span class="filter-badge" style="background:#e0e7ff;color:#3730a3;">
                            <i class="fas fa-book"></i>
                            Subject: @php
                                $subjectName = '';
                                if(isset($subjects)) {
                                    $foundSubject = $subjects->where('subject_id', request('subject_id'))->first();
                                    if(!$foundSubject) $foundSubject = $subjects->where('id', request('subject_id'))->first();
                                    $subjectName = $foundSubject->subject_name ?? $foundSubject->name ?? 'N/A';
                                }
                            @endphp
                            {{ $subjectName }}
                        </span>
                    @endif

                    <div class="ms-auto">
                        <a href="{{ route('student-marks-list') }}" class="btn btn-sm" style="background:#ef4444;color:white;">
                            <i class="fas fa-times-circle me-1"></i> Clear All Filters
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Marks Table -->
        <div class="card-custom">
            <div class="table-responsive">
                <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Admission No</th>
                            <th width="15%">Student Name</th>
                            <th width="8%">Session</th>
                            <th width="8%">Grade</th>
                            <th width="8%">Section</th>
                            <th width="10%">Exam</th>
                            <th width="10%">Subject</th>
                            <th width="12%">Theory</th>
                            <th width="12%">Practical</th>
                            <th width="8%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($studentMarks) && $studentMarks->count() > 0)
                            @foreach($studentMarks as $key => $mark)
                                @php
                                    $theoryPercentage = $mark->max_mark > 0 ? ($mark->obtained_mark / $mark->max_mark) * 100 : 0;
                                    $isTheoryAbsent   = isset($mark->is_absent_theory) && $mark->is_absent_theory == 1;
                                    $practicalPercentage = $mark->max_practical_mark > 0 ? ($mark->obtained_practical_mark / $mark->max_practical_mark) * 100 : 0;
                                    $isPracticalAbsent   = isset($mark->is_absent_practical) && $mark->is_absent_practical == 1;

                                    if ($isTheoryAbsent)          { $resultClass = 'badge-absent';    $resultText = 'Absent'; }
                                    elseif ($theoryPercentage >= 75){ $resultClass = 'badge-excellent'; $resultText = 'Excellent'; }
                                    elseif ($theoryPercentage >= 40){ $resultClass = 'badge-pass';      $resultText = 'Pass'; }
                                    else                           { $resultClass = 'badge-fail';      $resultText = 'Fail'; }

                                    $fullName = trim(implode(' ', array_filter([
                                        $mark->first_name ?? '', $mark->middle_name ?? '', $mark->last_name ?? ''
                                    ])));
                                    if (empty($fullName)) $fullName = 'N/A';
                                @endphp
                                <tr>
                                    <td>{{ ($studentMarks->currentPage() - 1) * $studentMarks->perPage() + $loop->iteration }}</td>
                                    <td><strong>{{ $mark->admission_no ?? 'N/A' }}</strong></td>
                                    <td>
                                        {{ $fullName }}
                                        @if($mark->roll_number)
                                            <small style="display:block;font-size:10px;color:#6c757d;margin-top:2px;">Roll: {{ $mark->roll_number }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $mark->session_name ?? '-' }}</td>
                                    <td>{{ $mark->grade_name   ?? '-' }}</td>
                                    <td>{{ $mark->section_name ?? '-' }}</td>
                                    <td>{{ $mark->exam_name    ?? '-' }}</td>
                                    <td>{{ $mark->subject_name ?? '-' }}</td>

                                    <!-- Theory -->
                                    <td class="marks-cell">
                                        @if($isTheoryAbsent)
                                            <span class="badge-absent">ABSENT</span>
                                            <div class="marks-value">0.00 / {{ number_format($mark->max_mark, 2) }}</div>
                                        @else
                                            <div class="marks-value">
                                                <strong>{{ number_format($mark->obtained_mark, 2) }}</strong>
                                                <span class="marks-max">/ {{ number_format($mark->max_mark, 2) }}</span>
                                            </div>
                                            <div class="marks-percentage">{{ number_format($theoryPercentage, 1) }}%</div>
                                        @endif
                                    </td>

                                    <!-- Practical -->
                                    <td class="marks-cell">
                                        @if($isPracticalAbsent)
                                            <span class="badge-absent">ABSENT</span>
                                            <div class="marks-value">0.00 / {{ number_format($mark->max_practical_mark ?? 0, 2) }}</div>
                                        @else
                                            <div class="marks-value">
                                                <strong>{{ number_format($mark->obtained_practical_mark ?? 0, 2) }}</strong>
                                                <span class="marks-max">/ {{ number_format($mark->max_practical_mark ?? 0, 2) }}</span>
                                            </div>
                                            @if(($mark->max_practical_mark ?? 0) > 0)
                                                <div class="marks-percentage">{{ number_format($practicalPercentage, 1) }}%</div>
                                            @endif
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td><span class="{{ $resultClass }}">{{ $resultText }}</span></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center text-muted py-5">
                                    <i class="fas fa-database fa-3x mb-3 d-block"></i>
                                    <h5>No marks records found</h5>
                                    <p class="text-muted">Please try different filters or add marks first.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if(isset($studentMarks) && $studentMarks->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $studentMarks->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
               .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

function loadSections(gradeId, selectedSectionId = null) {
    if (gradeId && gradeId !== '') {
        let sd = $('#section_filter');
        sd.html('<option value="">Loading sections...</option>').prop('disabled', true);
        $.ajax({
            url: "{{ url('admin/get-sections-by-grade') }}", type: "GET",
            data: { grade_id: gradeId }, dataType: 'json',
            success: function(response) {
                sd.empty().prop('disabled', false).append('<option value="">All Sections</option>');
                if (response && response.length > 0) {
                    $.each(response, function(key, section) {
                        let sel = (selectedSectionId && selectedSectionId == section.id) ? 'selected' : '';
                        sd.append(`<option value="${section.id}" ${sel}>${escapeHtml(section.name)}</option>`);
                    });
                } else {
                    sd.append('<option value="" disabled>No sections available for this grade</option>');
                }
                let examId = $('#exam_filter').val(), newSectionId = sd.val();
                if (examId && gradeId && newSectionId) loadSubjects(examId, gradeId, newSectionId, null);
                else $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
            },
            error: function() { sd.html('<option value="">Error loading sections</option>').prop('disabled', false); }
        });
    } else {
        $('#section_filter').empty().append('<option value="">All Sections</option>').prop('disabled', false);
        $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
    }
}

function loadSubjects(examId, gradeId, sectionId, selectedSubjectId = null) {
    if (examId && gradeId && sectionId) {
        let sd = $('#subject_filter');
        sd.html('<option value="">Loading subjects...</option>').prop('disabled', true);
        $.ajax({
            url: "{{ url('admin/get-exam-subjects') }}", type: "GET",
            data: { exam_id: examId, grade_id: gradeId, section_id: sectionId }, dataType: 'json',
            success: function(response) {
                sd.empty().prop('disabled', false).append('<option value="">All Subjects</option>');
                if (response && response.length > 0) {
                    $.each(response, function(key, subject) {
                        let sel = (selectedSubjectId && selectedSubjectId == subject.subject_id) ? 'selected' : '';
                        sd.append(`<option value="${subject.subject_id}" ${sel}>${escapeHtml(subject.subject_name)}</option>`);
                    });
                } else {
                    sd.append('<option value="" disabled>No subjects assigned</option>');
                }
            },
            error: function() { sd.html('<option value="">Error loading subjects</option>').prop('disabled', false); }
        });
    } else {
        $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
    }
}

$(document).ready(function() {
    let initialGrade   = "{{ request('grade_id') }}";
    let initialSection = "{{ request('section_id') }}";
    let initialExam    = "{{ request('exam_id') }}";
    let initialSubject = "{{ request('subject_id') }}";

    if (initialGrade) loadSections(initialGrade, initialSection);

    if (initialExam && initialGrade && initialSection) {
        setTimeout(function() { loadSubjects(initialExam, initialGrade, initialSection, initialSubject); }, 500);
    }

    $('#grade_filter').on('change', function() {
        let gradeId = $(this).val(), examId = $('#exam_filter').val(), sectionId = $('#section_filter').val();
        loadSections(gradeId, sectionId);
        if (examId && gradeId && sectionId) loadSubjects(examId, gradeId, sectionId, null);
        else $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
    });

    $('#section_filter').on('change', function() {
        let sectionId = $(this).val(), examId = $('#exam_filter').val(), gradeId = $('#grade_filter').val();
        if (examId && gradeId && sectionId) loadSubjects(examId, gradeId, sectionId, null);
        else $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
    });

    $('#exam_filter').on('change', function() {
        let examId = $(this).val(), gradeId = $('#grade_filter').val(), sectionId = $('#section_filter').val();
        if (examId && gradeId && sectionId) loadSubjects(examId, gradeId, sectionId, null);
        else $('#subject_filter').html('<option value="">All Subjects</option>').prop('disabled', false);
    });

    $('#filterForm').on('submit', function() {
        $('.btn-filter').html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    });
});
</script>

@endsection