@extends('backend.layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
.content-wrapper { background: #f4f6f9; }

.card-custom {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.page-title { font-weight: 600; color: #2c3e50; }

.section-box {
    padding: 12px 18px;
    border-radius: 8px;
    font-weight: 500;
    margin-bottom: 15px;
    color: #fff;
}
.from-box { background: #4f46e5; }
.to-box   { background: #16a34a; }

label { font-weight: 500; color: #374151; }

.form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 4px;
}
.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79,70,229,0.1);
}
.form-control:disabled {
    background: #f3f4f6;
    cursor: not-allowed;
    opacity: 0.6;
}

.table { border-radius: 10px; overflow: hidden; }
.table thead { background: #111827; color: #fff; }
.table tbody tr:hover { background: #f9fafb; }

.btn-main {
    background: #16a34a;
    color: #fff;
    padding: 10px 25px;
    border-radius: 8px;
    border: none;
    font-weight: 500;
}
.btn-main:hover { background: #15803d; }

.empty-state { animation: fadeIn 0.4s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.select-all { font-weight: 500; }
</style>

<div class="content-wrapper">
    <div class="container-fluid mt-4">

        @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <h4 class="page-title mb-4">🎓 Student Promotion Panel</h4>

        <div class="card-custom">
            <form method="POST" action="{{ url('admin/student-promote') }}">
                @csrf

                <div class="row">

                    <!-- ── FROM ───────────────────────────────────── -->
                    <div class="col-md-12">
                        <div class="section-box from-box">From (Current Class)</div>
                    </div>

                    <div class="col-md-4">
                        <label>Session</label>
                        <select id="from_session" name="from_session" class="form-control">
                            <option value="">Select</option>
                            @foreach($session as $sess)
                            <option value="{{ $sess->id }}">{{ $sess->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Grade</label>
                        <select id="from_grade" name="from_grade" class="form-control">
                            <option value="">Select</option>
                            <option value="all">All Grades</option>
                            @foreach($grade as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Section</label>
                        <select id="from_section" name="from_section" class="form-control">
                            <option value="">Select</option>
                        </select>
                    </div>

                    <!-- ── TO ────────────────────────────────────── -->
                    <div class="col-md-12 mt-4">
                        <div class="section-box to-box">Promote To (Next Class)</div>
                    </div>

                    <div class="col-md-4">
                        <label>Session</label>
                        <select name="session_id" class="form-control" required>
                            <option value="">Select</option>
                            @foreach($session as $sess)
                            <option value="{{ $sess->id }}">{{ $sess->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Grade</label>
                        <select name="grade_id" id="to_grade" class="form-control" required>
                            <option value="">Select</option>
                            @foreach($grade as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Section</label>
                        <select name="section_id" id="to_section" class="form-control" required>
                            <option value="">Select</option>
                        </select>
                    </div>

                </div>

                <!-- ── STUDENTS ──────────────────────────────────── -->
                <div class="mt-4">
                    <div class="mb-2 select-all">
                        <input type="checkbox" id="select_all"> Select All Students
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Admission No</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="student_list">
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center py-5 empty-state">
                                            <div style="font-size:60px;">📚</div>
                                            <h5 style="color:#374151;font-weight:600;">No Students Found</h5>
                                            <p style="color:#6b7280;">Select Session, Grade & Section to load students</p>
                                            <span class="badge bg-light text-dark px-3 py-2" style="border:1px solid #e5e7eb;">🔍 No data available</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button class="btn-main">🚀 Promote Selected Students</button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
$(document).ready(function () {

    /* ── helpers ──────────────────────────────────────── */

    function emptyState(msg) {
        msg = msg || 'Select Session, Grade & Section to load students';
        return `
        <tr>
          <td colspan="6">
            <div class="text-center py-5 empty-state">
              <div style="font-size:60px;">📚</div>
              <h5 style="color:#374151;font-weight:600;">No Students Found</h5>
              <p style="color:#6b7280;">${msg}</p>
              <span class="badge bg-light text-dark px-3 py-2" style="border:1px solid #e5e7eb;">🔍 No data available</span>
            </div>
          </td>
        </tr>`;
    }

    function loadSections(grade_id, target) {
        if (grade_id && grade_id !== 'all') {
            $.get("{{ url('admin/get-sections') }}/" + grade_id, function (data) {
                $(target).html('<option value="">Select</option>');
                $.each(data, function (i, v) {
                    $(target).append('<option value="' + v.id + '">' + v.name + '</option>');
                });
            });
        } else {
            $(target).html('<option value="">Select</option>');
        }
    }

    function loadStudents() {
        let session_id = $('#from_session').val();
        let grade_id   = $('#from_grade').val();
        let section_id = $('#from_section').val();

        /* Minimum required: session + grade */
        if (!session_id || !grade_id) {
            $('#student_list').html(emptyState());
            return;
        }

        /* If grade is specific (not "all"), section must also be chosen */
        if (grade_id !== 'all' && !section_id) {
            $('#student_list').html(emptyState('Select a Section to load students'));
            return;
        }

        $.get("{{ url('admin/get-students') }}", {
            session_id : session_id,
            grade_id   : grade_id,   // "all" or specific id
            section_id : section_id  // "" when grade = all
        }, function (data) {

            let html = '';

            if (data.length) {
                $.each(data, function (i, s) {
                    html += `
                    <tr>
                      <td><input type="checkbox" name="student_ids[]" class="student_checkbox" value="${s.id}"></td>
                      <td>${s.admission_no}</td>
                      <td>${s.student_name}</td>
                      <td>${s.grade_name   ?? '-'}</td>
                      <td>${s.section_name ?? '-'}</td>
                      <td>
                        <span class="badge ${s.status === 'Active' ? 'bg-success' : 'bg-secondary'}">
                          ${s.status}
                        </span>
                      </td>
                    </tr>`;
                });
            } else {
                html = emptyState('No matching students found');
            }

            $('#student_list').html(html);
            // reset select-all
            $('#select_all').prop('checked', false);
        });
    }

    /* ── FROM: Grade change ───────────────────────────── */
    $('#from_grade').change(function () {
        let grade_id = $(this).val();

        if (grade_id === 'all') {
            // disable & clear section
            $('#from_section')
                .html('<option value="">All Sections</option>')
                .prop('disabled', true);
        } else {
            // re-enable and load sections
            $('#from_section').prop('disabled', false);
            loadSections(grade_id, '#from_section');
        }

        loadStudents();
    });

    /* ── FROM: Session / Section / Status change ─────── */
    $('#from_section, #from_session').change(function () {
        loadStudents();
    });

    /* ── TO: Grade change (load to-sections) ─────────── */
    $('#to_grade').change(function () {
        loadSections($(this).val(), '#to_section');
    });

    /* ── Select All ───────────────────────────────────── */
    $(document).on('change', '#select_all', function () {
        $('.student_checkbox').prop('checked', this.checked);
    });

    /* ── Individual checkbox desyncs Select All ───────── */
    $(document).on('change', '.student_checkbox', function () {
        let total   = $('.student_checkbox').length;
        let checked = $('.student_checkbox:checked').length;
        $('#select_all').prop('checked', total > 0 && total === checked);
    });

});
</script>

@endsection