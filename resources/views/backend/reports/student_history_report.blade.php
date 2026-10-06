@extends('backend.layouts.app')

@section('content')

<style>
/* ── Badges ──────────────────────────────────────────────── */
.badge-success   { background:#28a745; color:#fff; padding:4px 9px; border-radius:4px; font-size:11px; }
.badge-warning   { background:#ffc107; color:#000; padding:4px 9px; border-radius:4px; font-size:11px; }
.badge-danger    { background:#dc3545; color:#fff; padding:4px 9px; border-radius:4px; font-size:11px; }
.badge-secondary { background:#6c757d; color:#fff; padding:4px 9px; border-radius:4px; font-size:11px; }
.badge-info      { background:#17a2b8; color:#fff; padding:4px 9px; border-radius:4px; font-size:11px; }
.table .thead-dark th { color:#fff; background-color:#6f42c1; border-color:#5a32a3; }

/* ── Excel button ────────────────────────────────────────── */
.btn-excel {
    background: linear-gradient(135deg,#1D6F42,#217346);
    color:#fff; border:none; padding:7px 16px; border-radius:8px;
    font-size:13px; cursor:pointer; display:inline-flex;
    align-items:center; gap:6px; text-decoration:none;
    transition:all .3s; vertical-align:middle;
}
.btn-excel:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(29,111,66,.4); color:#fff; text-decoration:none; }
.btn-excel.disabled { opacity:.5; pointer-events:none; cursor:not-allowed; }

/* ── Info banner ─────────────────────────────────────────── */
.history-banner {
    background: linear-gradient(135deg,#667eea,#764ba2);
    color:#fff; border-radius:12px; padding:14px 20px;
    margin-bottom:20px; display:flex; align-items:center; gap:12px;
}
.history-banner i  { font-size:24px; opacity:.9; }
.history-banner h5 { margin:0; font-size:15px; font-weight:700; }
.history-banner p  { margin:0; font-size:12px; opacity:.85; }

/* ── Step Wizard ─────────────────────────────────────────── */
.step-wizard-bar { background:#f8fafc; border-radius:12px; padding:15px 20px; margin-bottom:25px; border:1px solid #e2e8f0; }
.steps-wrapper { display:flex; align-items:center; justify-content:space-between; position:relative; }
.steps-wrapper::before { content:''; position:absolute; top:25px; left:60px; right:60px; height:2px; background:linear-gradient(90deg,#e2e8f0,#cbd5e1,#e2e8f0); z-index:1; }
.step-indicator { position:relative; z-index:2; text-align:center; flex:1; }
.step-number { width:50px; height:50px; background:white; border:2px solid #cbd5e1; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 8px; font-size:18px; font-weight:bold; color:#94a3b8; transition:all .3s; }
.step-name { font-size:12px; font-weight:600; color:#64748b; }
.step-indicator.completed .step-number { background:#6f42c1; border-color:#6f42c1; color:white; }
.step-indicator.completed .step-number::after { content:'✓'; font-size:20px; }
.step-indicator.completed .step-name { color:#6f42c1; }
.step-indicator.active .step-number { border-color:#6f42c1; color:#6f42c1; box-shadow:0 0 0 4px rgba(111,66,193,.2); }
.step-indicator.active .step-name { color:#6f42c1; font-weight:700; }
.step-indicator.skipped .step-number { background:#e2e8f0; border-color:#cbd5e1; color:#94a3b8; }
.step-indicator.skipped .step-number::after { content:'—'; font-size:16px; }
.step-indicator.skipped .step-name { color:#94a3b8; text-decoration:line-through; }
.step-message-box { margin-top:15px; padding:10px 15px; background:#f3f0ff; border-radius:10px; border-left:4px solid #6f42c1; font-size:13px; }

/* ── Table loader ────────────────────────────────────────── */
.table-loading-overlay { position:relative; }
.table-loading-overlay.loading::before { content:''; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,.85); backdrop-filter:blur(8px); z-index:100; border-radius:12px; }
.table-loader { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); z-index:101; display:none; text-align:center; background:white; padding:30px 40px; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.2); min-width:280px; }
.table-loading-overlay.loading .table-loader { display:block; }
.table-loader img { width:80px; height:80px; object-fit:contain; }
.table-loader-text { font-size:16px; font-weight:600; color:#6f42c1; margin-top:15px; }
.table-loader-subtext { font-size:12px; color:#64748b; margin-top:8px; }

/* ── Class cell ──────────────────────────────────────────── */
.class-info { color:#6f42c1; font-weight:600; font-size:12px; }

/* ── Section col dimmed when All Grades ──────────────────── */
#section-col.hidden-col { opacity:.45; pointer-events:none; }
#section-col.hidden-col select { background:#f1f5f9; }
</style>

<div class="content-wrapper">
<div class="container-fluid">
<div class="card mt-3">

  {{-- Card Header --}}
  <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap"
       style="background:linear-gradient(135deg,#667eea,#764ba2); gap:8px;">
    <h4 class="mb-0"><i class="fa fa-history"></i> Historical Student Report</h4>
  </div>

  <div class="card-body">

    <div class="history-banner">
      <i class="fa fa-info-circle"></i>
      <div>
        <h5>Previous Session Student Data</h5>
        <p>Select the <strong>Session, Grade and Section</strong> where the student <strong>was enrolled before promotion</strong>. Records will be fetched from the promotion log.</p>
      </div>
    </div>

    {{-- ── Step Wizard ────────────────────────────────────── --}}
    <div class="step-wizard-bar">
      <div class="steps-wrapper">
        <div class="step-indicator" data-step="1">
          <div class="step-number">1</div>
          <div class="step-name">Session</div>
        </div>
        <div class="step-indicator" data-step="2">
          <div class="step-number">2</div>
          <div class="step-name">Grade</div>
        </div>
        <div class="step-indicator" data-step="3" id="sectionStep">
          <div class="step-number">3</div>
          <div class="step-name">Section</div>
        </div>
      </div>
      <div class="step-message-box">
        <i class="fa fa-info-circle"></i>
        <span id="stepMessageText">★ Step 1: First select the session</span>
      </div>
    </div>

    {{-- ── Filter Form ─────────────────────────────────────── --}}
    <form method="GET" action="{{ route('student-history-report') }}" id="filterForm">
      <div class="row align-items-end">

        {{-- Session --}}
        <div class="col-md-2">
          <label>Session <span class="text-danger">*</span></label>
          <select name="session_id" id="session_id" class="form-control" data-step="1">
            <option value="">Select Session</option>
            @foreach($sessions as $s)
              <option value="{{ $s->id }}" {{ $session_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Grade — with "★ All Grades" --}}
        <div class="col-md-2">
          <label>Grade <span class="text-danger">*</span></label>
          <select name="grade_id" id="grade_id" class="form-control" data-step="2">
            <option value="">Select Grade</option>
            <option value="all" {{ $grade_id === 'all' ? 'selected' : '' }}>★ All Grades</option>
            @foreach($grades as $g)
              <option value="{{ $g->id }}" {{ $grade_id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Section — hidden/dimmed when All Grades --}}
        <div class="col-md-2" id="section-col">
          <label>Section <span class="text-danger" id="section-required">*</span></label>
          <select name="section_id" id="section_id" class="form-control" data-step="3">
            <option value="">Select Section</option>
            @if($grade_id && $grade_id !== 'all')
              <option value="all" {{ $section_id === 'all' ? 'selected' : '' }}>★ All Sections</option>
              @foreach($sections as $sec)
                <option value="{{ $sec->id }}" {{ $section_id == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
              @endforeach
            @endif
          </select>
        </div>

        {{-- Status --}}
        <div class="col-md-2">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="">★ All Status</option>
            @foreach(['Active', 'Inactive', 'Absconding', 'Left', 'Transfer'] as $st)
              <option value="{{ $st }}" {{ ($status ?? '') == $st ? 'selected' : '' }}>{{ $st }}</option>
            @endforeach
          </select>
        </div>

        {{-- Buttons --}}
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> Fetch History
          </button>
          <a href="{{ route('student-history-report') }}" class="btn btn-secondary">
            <i class="fa fa-refresh"></i> Reset
          </a>

          @php
            $canDownload = $session_id && $grade_id && (
                $grade_id === 'all' || $section_id
            ) && count($students) > 0;
          @endphp

          @if($canDownload)
            <a href="{{ route('student-history-report.download', [
                  'session_id' => $session_id,
                  'grade_id'   => $grade_id,
                  'section_id' => $section_id,
                  'status'     => $status,
               ]) }}" class="btn-excel">
              <i class="fa fa-file-excel-o"></i> Download Excel
            </a>
          @else
            <span class="btn-excel disabled" title="Select filters and fetch report first">
              <i class="fa fa-file-excel-o"></i> Download Excel
            </span>
          @endif
        </div>

      </div>
    </form>

    {{-- ── Table ───────────────────────────────────────────── --}}
    <div class="table-responsive mt-4">
      <div class="table-loading-overlay" id="tableLoadingOverlay">

        <div class="table-loader">
          <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading...">
          <div class="table-loader-text">Loading History...</div>
          <div class="table-loader-subtext">Fetching records...</div>
        </div>

        <div id="tableContent">

          @php
            $filtersReady = $session_id && $grade_id && ($grade_id === 'all' || $section_id);
          @endphp

          @if($filtersReady)

            @if(count($students) > 0)
              <table class="table table-bordered table-striped table-sm" id="studentsTable">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Admission No</th>
                    <th>Roll No</th>
                    <th>Full Name</th>
                    <th>Father Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Class (Historical)</th>
                    <th>Current Status</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i = 1; @endphp
                  @foreach($students as $student)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $student->admission_no }}</td>
                      <td>{{ $student->roll_number ?? 'N/A' }}</td>
                      <td>
                        {{ trim($student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name) }}
                        @if($student->nickname)
                          <br><small class="text-muted">"{{ $student->nickname }}"</small>
                        @endif
                      </td>
                      <td>{{ $student->father_name ?? '—' }}</td>
                      <td>{{ $student->gender ?? '—' }}</td>
                      <td>{{ $student->phone ?? '—' }}</td>
                      <td>
                        <span class="class-info">
                          {{ $student->session_name ?? '—' }}<br>
                          {{ $student->grade_name ?? '—' }} / {{ $student->section_name ?? '—' }}
                        </span>
                      </td>
                      <td>
                        @php $st = $student->status; @endphp
                        @if($st === 'Active')
                          <span class="badge badge-success">Active</span>
                        @elseif($st === 'Inactive')
                          <span class="badge badge-secondary">Inactive</span>
                        @elseif($st === 'Left')
                          <span class="badge badge-danger">Left</span>
                        @elseif($st === 'Transfer')
                          <span class="badge badge-info">Transfer</span>
                        @elseif($st === 'Absconding')
                          <span class="badge badge-warning">Absconding</span>
                        @else
                          <span class="badge badge-secondary">{{ $st }}</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <p class="text-muted text-right mt-1" style="font-size:12px;">
                Total: <strong>{{ count($students) }}</strong> students
              </p>

            @else
              <div class="alert alert-info mt-3">
                <i class="fa fa-info-circle"></i>
                No records found for this session / grade / section.
                <br><small class="text-muted">Either no student was enrolled or the filters are incorrect.</small>
              </div>
            @endif

          @else
            <div class="alert alert-secondary mt-3">
              <i class="fa fa-arrow-up"></i>
              Select <strong>Session</strong>, <strong>Grade</strong> and (if specific grade) <strong>Section</strong>
              — where the student <em>was previously enrolled</em> — then click <strong>Fetch History</strong>.
            </div>
          @endif

        </div>{{-- #tableContent --}}
      </div>{{-- .table-loading-overlay --}}
    </div>

  </div>{{-- .card-body --}}
</div>{{-- .card --}}
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {

    // ── Loader ─────────────────────────────────────────────────
    function showLoader() { $('#tableLoadingOverlay').addClass('loading'); }
    function hideLoader() { $('#tableLoadingOverlay').removeClass('loading'); }
    if ($('#tableContent').children().length) hideLoader();
    $('#filterForm').on('submit', showLoader);

    // ── Step Wizard ────────────────────────────────────────────
    function updateWizard() {
        var session  = $('#session_id').val();
        var grade    = $('#grade_id').val();
        var section  = $('#section_id').val();
        var allGrade = (grade === 'all');

        var cur;
        if (!session)                    cur = 1;
        else if (!grade)                 cur = 2;
        else if (!allGrade && !section)  cur = 3;
        else                             cur = 4;

        var msgs = {
            1: '★ Step 1: First select the session',
            2: '★ Step 2: Now select the grade (or All Grades)',
            3: '★ Step 3: Now select the section (or All Sections)',
            4: '✓ Everything is set — Click Fetch History'
        };

        $('.step-indicator').each(function () {
            var s = parseInt($(this).data('step'));
            $(this).removeClass('active completed skipped');

            if (s === 3 && allGrade) {
                $(this).addClass('skipped');
            } else if (s < cur) {
                $(this).addClass('completed');
            } else if (s === cur) {
                $(this).addClass('active');
            }
        });

        $('#stepMessageText').text(msgs[Math.min(cur, 4)]);

        // Dim + disable section col when All Grades
        if (allGrade) {
            $('#section-col').addClass('hidden-col');
            $('#section_id').val('').prop('disabled', true);
            $('#section-required').hide();
        } else {
            $('#section-col').removeClass('hidden-col');
            $('#section_id').prop('disabled', false);
            $('#section-required').show();
        }
    }

    // ── Dynamic Sections via AJAX ──────────────────────────────
    function loadSections(gradeId, selected) {
        if (!gradeId || gradeId === 'all') {
            $('#section_id').html('<option value="">Select Section</option>');
            updateWizard();
            return;
        }
        $('#section_id').html('<option>Loading…</option>');
        $.get("{{ route('get-sections-by-grade') }}", { grade_id: gradeId }, function (res) {
            var html = '<option value="">Select Section</option>'
                     + '<option value="all"' + (selected === 'all' ? ' selected' : '') + '>★ All Sections</option>';
            if (res && res.length) {
                $.each(res, function (i, row) {
                    html += '<option value="' + row.id + '"'
                          + (selected == row.id ? ' selected' : '')
                          + '>' + row.name + '</option>';
                });
            } else {
                html += '<option value="" disabled>No sections available</option>';
            }
            $('#section_id').html(html);
            updateWizard();
        }).fail(function () {
            $('#section_id').html('<option value="">Error loading sections</option>');
            updateWizard();
        });
    }

    // ── Events ─────────────────────────────────────────────────
    $('#grade_id').on('change', function () {
        loadSections($(this).val(), '');
    });

    $('#session_id, #section_id').on('change', updateWizard);

    // Pre-load sections on page reload after fetch
    @if($grade_id && $grade_id !== 'all')
        loadSections("{{ $grade_id }}", "{{ $section_id ?? '' }}");
    @else
        updateWizard();
    @endif

});
</script>

@endsection