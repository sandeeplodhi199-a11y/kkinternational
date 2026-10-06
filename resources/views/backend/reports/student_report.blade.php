@extends('backend.layouts.app')

@section('content')

<style>
/* ── Base badges ──────────────────────────────────────────── */
.badge-success { background:#28a745; color:#fff; padding:5px 10px; border-radius:4px; }
.badge-warning  { background:#ffc107; color:#000; padding:5px 10px; border-radius:4px; }
.table .thead-dark th { color:#fff; background-color:#029b69; border-color:#4d4e4e; }

/* ── Download Excel button ───────────────────────────────── */
.btn-excel {
    background: linear-gradient(135deg,#1D6F42,#217346);
    color: #fff; border: none; padding: 7px 16px; border-radius: 8px;
    font-size: 13px; cursor: pointer; display: inline-flex;
    align-items: center; gap: 6px; text-decoration: none;
    transition: all .3s; vertical-align: middle;
}
.btn-excel:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(29,111,66,.4); color:#fff; text-decoration:none; }
.btn-excel.disabled { opacity:.5; pointer-events:none; cursor:not-allowed; }

/* ── Step Wizard ─────────────────────────────────────────── */
.step-wizard-bar { background:#f8fafc; border-radius:12px; padding:15px 20px; margin-bottom:25px; border:1px solid #e2e8f0; }
.steps-wrapper { display:flex; align-items:center; justify-content:space-between; position:relative; }
.steps-wrapper::before { content:''; position:absolute; top:25px; left:60px; right:60px; height:2px; background:linear-gradient(90deg,#e2e8f0,#cbd5e1,#e2e8f0); z-index:1; }
.step-indicator { position:relative; z-index:2; text-align:center; flex:1; }
.step-number { width:50px; height:50px; background:white; border:2px solid #cbd5e1; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 8px; font-size:18px; font-weight:bold; color:#94a3b8; transition:all .3s; }
.step-name { font-size:12px; font-weight:600; color:#64748b; }
.step-indicator.completed .step-number { background:#029b69; border-color:#029b69; color:white; }
.step-indicator.completed .step-number::after { content:'✓'; font-size:20px; }
.step-indicator.completed .step-name { color:#029b69; }
.step-indicator.active .step-number { border-color:#029b69; color:#029b69; box-shadow:0 0 0 4px rgba(2,155,105,.2); }
.step-indicator.active .step-name { color:#029b69; font-weight:700; }
.step-indicator.skipped .step-number { background:#e2e8f0; border-color:#cbd5e1; color:#94a3b8; }
.step-indicator.skipped .step-number::after { content:'—'; font-size:16px; }
.step-indicator.skipped .step-name { color:#94a3b8; text-decoration: line-through; }
.step-message-box { margin-top:15px; padding:10px 15px; background:#f0fdf4; border-radius:10px; border-left:4px solid #029b69; font-size:13px; }

/* ── Table loader ────────────────────────────────────────── */
.table-loading-overlay { position:relative; }
.table-loading-overlay.loading::before { content:''; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,.85); backdrop-filter:blur(8px); z-index:100; border-radius:12px; }
.table-loader { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); z-index:101; display:none; text-align:center; background:white; padding:30px 40px; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.2); min-width:280px; }
.table-loading-overlay.loading .table-loader { display:block; }
.table-loader img { width:80px; height:80px; object-fit:contain; }
.table-loader-text { font-size:16px; font-weight:600; color:#029b69; margin-top:15px; }
.table-loader-subtext { font-size:12px; color:#64748b; margin-top:8px; }

/* ── Section col hidden when All Grades ─────────────────── */
#section-col.hidden-col { opacity:.45; pointer-events:none; }
#section-col.hidden-col select { background:#f1f5f9; }
</style>

<div class="content-wrapper">
<div class="container-fluid">
<div class="card mt-3">

  <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
    <h4 class="mb-0"><i class="fa fa-users"></i> Student Report</h4>
  </div>

  <div class="card-body">

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
        <span id="stepMessageText">★ Step 1: Select a session first</span>
      </div>
    </div>

    {{-- ── Filter Form ─────────────────────────────────────── --}}
    <form method="GET" action="{{ route('student-report') }}" id="filterForm">
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

        {{-- Grade — with "★ All Grades" option --}}
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

        {{-- Section — hidden/disabled when All Grades --}}
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
              <option value="{{ $st }}" {{ $status == $st ? 'selected' : '' }}>{{ $st }}</option>
            @endforeach
          </select>
        </div>

        {{-- Buttons --}}
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> Fetch Report
          </button>
          <a href="{{ route('student-report') }}" class="btn btn-secondary">
            <i class="fa fa-refresh"></i> Reset
          </a>

          @php
            $canDownload = $session_id && $grade_id && (
                $grade_id === 'all' || $section_id
            ) && count($students) > 0;
          @endphp

          @if($canDownload)
            <a href="{{ route('student-report.download', ['session_id'=>$session_id,'grade_id'=>$grade_id,'section_id'=>$section_id,'status'=>$status]) }}"
               class="btn-excel">
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
          <div class="table-loader-text">Loading Data...</div>
          <div class="table-loader-subtext">Please wait while we fetch the report</div>
        </div>

        <div id="tableContent">

          @php
            $filtersReady = $session_id && $grade_id && ($grade_id === 'all' || $section_id);
          @endphp

          @if($filtersReady)

            @if(count($students) > 0)
              <table class="table table-bordered table-striped" id="studentsTable">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Admission No</th>
                    <th>Roll No</th>
                    <th>Full Name</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                    <th>Gender</th>
                    <th>DOB (AD)</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Session</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Status</th>
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
                      <td>{{ $student->mother_name ?? '—' }}</td>
                      <td>{{ $student->gender ?? '—' }}</td>
                      <td>{{ $student->dob_ad ?? '—' }}</td>
                      <td>{{ $student->phone ?? '—' }}</td>
                      <td>{{ $student->email ?? '—' }}</td>
                      <td>{{ $student->session_name }}</td>
                      <td>{{ $student->grade_name }}</td>
                      <td>{{ $student->section_name ?? '—' }}</td>
                      <td>
                        @if($student->status === 'Active')
                          <span class="badge badge-success">Active</span>
                        @else
                          <span class="badge badge-warning">{{ $student->status }}</span>
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
                <i class="fa fa-info-circle"></i> No students found for the selected filters.
              </div>
            @endif

          @else
            <div class="alert alert-secondary mt-3">
              <i class="fa fa-arrow-up"></i>
              Please select <strong>Session</strong>, <strong>Grade</strong>
              and (if specific grade) <strong>Section</strong>, then click <strong>Fetch Report</strong>.
            </div>
          @endif

        </div>{{-- #tableContent --}}
      </div>{{-- .table-loading-overlay --}}
    </div>

  </div>
</div>
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

        // Step 3 (section) is skipped when All Grades
        var cur;
        if (!session)                          cur = 1;
        else if (!grade)                       cur = 2;
        else if (!allGrade && !section)        cur = 3;
        else                                   cur = 4;

        var msgs = {
            1: '★ Step 1: Select a session first',
            2: '★ Step 2: Now select a grade (or All Grades)',
            3: '★ Step 3: Now select a section (or All Sections)',
            4: '✓ All filters set — click Fetch Report'
        };

        // Step indicators
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

        // Section column — dim + disable when All Grades
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
        // Clear section if no grade or All Grades
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

    // ── Event Listeners ────────────────────────────────────────
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