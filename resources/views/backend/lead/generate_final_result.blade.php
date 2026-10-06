@extends('backend.layouts.app')
@section('content')

<style>
:root {
    --primary: #2f54eb;
    --bg: #f4f7ff;
    --card: #ffffff;
    --text: #1f2a44;
    --muted: #6b7280;
}

body {
    background: var(--bg);
    font-family: Inter, Segoe UI, Arial, sans-serif;
    color: var(--text);
}

.content-wrapper {
    padding: 25px
}

.card-ui {
    background: var(--card);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    overflow: hidden;
}

.card-ui-header {
    background: linear-gradient(90deg, #2f54eb, #1d39c4);
    padding: 18px 22px;
    color: #fff;
}

.card-ui-header h5 {
    margin: 0;
    font-weight: 700
}

label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
}

.form-control {
    height: 42px;
    border-radius: 10px;
    border: 1px solid #e3e9ff;
}

.section-title {
    font-weight: 700;
    font-size: 15px;
    margin: 18px 0 10px;
    padding-left: 10px;
    border-left: 4px solid var(--primary);
}

.table-ui {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
}

.table-ui th {
    background: #f6f8ff;
    font-weight: 700;
}

.table-ui th,
.table-ui td {
    padding: 12px;
    border-bottom: 1px solid #eef2ff;
}

.btn-primary-ui {
    background: linear-gradient(90deg, #2f54eb, #1d39c4);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 700;
}

.helper {
    font-size: 12px;
    color: var(--muted);
}
</style>

<div class="content-wrapper">
    <div class="container-fluid">

        <div class="card-ui">

            <div class="card-ui-header">
                <h5>Generate Final Result</h5>
            </div>

            <div class="card-body p-4">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif


                <form method="POST" action="{{ route('save_generate_final_result') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Course</label>
                            <select id="course_id" class="form-control" name="course_id" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Session Start</label>
                            <select id="session_start" class="form-control" name="session_start" required>
                                <option value="">Select</option>
                                @for($y=2020;$y<=2035;$y++) <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                            </select>
                            <div class="helper">Students load automatically</div>
                        </div>
                    </div>

                    <div class="section-title">Select Students</div>

                    <div id="studentContainer">
                        <div class="helper">Select course & session to load students.</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="helper" id="students_count_info">No students loaded.</span>
                        <button type="submit" class="btn btn-primary-ui">
                            Generate Result
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
$(function() {

    $("#session_start").change(function() {

        let session = $(this).val();
        let course = $("#course_id").val();

        if (!course || !session) {
            $("#studentContainer").html("<div class='helper'>Select course & session.</div>");
            return;
        }

        $("#studentContainer").html("<div class='helper'>Loading students...</div>");

        $.get("{{ url('get-students-by-session-course') }}", {
            session_start: session,
            course_id: course
        }, function(data) {

            if (!data || data.length === 0) {
                $("#studentContainer").html("<div class='helper'>No students found.</div>");
                $("#students_count_info").text("0 students loaded");
                return;
            }

            let html = `
        <table class="table-ui">
            <thead>
                <tr>
                    <th style="width:40px">
                        <input type="checkbox" id="select_all_students">
                    </th>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Enrollment</th>
                </tr>
            </thead>
            <tbody>`;

            data.forEach((s, i) => {
                html += `
            <tr>
                <td>
                    <input type="checkbox"
                           class="student-check"
                           name="selected_students[]"
                           value="${s.id}">
                </td>
                <td>${i+1}</td>
                <td><strong>${s.name}</strong></td>
                <td>${s.enrollment_no}</td>
            </tr>`;
            });

            html += `</tbody></table>`;

            $("#studentContainer").html(html);
            $("#students_count_info").text(data.length + " students loaded");

        });

    });

    /* SELECT ALL */
    $(document).on("change", "#select_all_students", function() {
        $(".student-check").prop("checked", this.checked);
    });

    /* SINGLE CHECK */
    $(document).on("change", ".student-check", function() {
        let total = $(".student-check").length;
        let checked = $(".student-check:checked").length;
        $("#select_all_students").prop("checked", total === checked);
    });

});
</script>

@endsection