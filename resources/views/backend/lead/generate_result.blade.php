@extends('backend.layouts.app')
@section('content')

<style>
/* ===== PAGE & TYPOGRAPHY ===== */
:root{
    --primary-1: #2f54eb;
    --primary-2: #1536b7;
    --bg-grad-1: #f6f9ff;
    --card-bg: rgba(255,255,255,0.96);
    --muted: #6b7280;
    --glass-border: rgba(45,66,137,0.08);
    --accent: linear-gradient(90deg,var(--primary-1),var(--primary-2));
}

body {
    background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);
    font-family: Inter, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1f2a44;
}
.content-wrapper { padding: 30px 14px; }

/* ===== PREMIUM CARD ===== */
.card-modern {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--glass-border);
    box-shadow: 0 12px 40px rgba(31,42,68,0.08);
    overflow: hidden;
}

/* HEADER */
.card-header-modern {
    background: var(--accent);
    padding: 20px 22px;
    color: #fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
}
.card-header-modern h5 { margin:0; font-size:18px; font-weight:700; letter-spacing:0.2px; }
.card-header-modern .sub { opacity:0.92; font-size:13px; font-weight:500; }

/* FORM BASICS */
.form-control { height:44px !important; border-radius:10px !important; box-shadow: none !important; border:1px solid #e8eefc !important; padding:8px 10px; }
label { font-weight:600; font-size:13px; margin-bottom:6px; display:block; color:#233153; }

/* SECTION TITLE */
.section-title {
    display:flex; align-items:center; gap:12px;
    font-size:15px; font-weight:800;
    padding:10px 12px; margin:14px 0 10px;
    border-left: 5px solid rgba(47,84,235,0.95);
    background: linear-gradient(180deg, rgba(248,251,255,0.8), rgba(255,255,255,0.6));
    border-radius: 10px;
    color: #16325c;
}

/* ===== SUBJECT BOX (REDUCED HEIGHT FOR COMPACT PREMIUM LOOK) ===== */
/* Reduced padding and min-height to make section shorter but keep premium feel */
.subject-box {
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(246,250,255,0.95));
    border-radius: 12px;
    padding: 10px 12px;             /* reduced padding */
    margin-bottom: 12px;
    border: 1px solid rgba(34,67,147,0.05);
    box-shadow: 0 8px 22px rgba(28,71,179,0.05);
    transition: transform .15s cubic-bezier(.2,.9,.3,1), box-shadow .15s;
    min-height: 64px;               /* lowered min-height (was 92px) */
    display:flex;
    align-items:center;
    gap:12px;
}
.subject-box:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(28,71,179,0.07); }

/* left icon / checkbox area */
.subject-box .left {
    width:46px; min-width:46px; height:46px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    background: linear-gradient(180deg, rgba(47,84,235,0.10), rgba(47,84,235,0.04));
    border: 1px solid rgba(47,84,235,0.05);
}
.subject-box .left input[type="checkbox"] { transform:scale(1.06); }

/* subject details */
.subject-details { flex:1; display:flex; flex-direction:column; gap:4px; }
.subject-name { font-weight:800; font-size:14px; color:#0f2146; letter-spacing:0.1px; }
.subject-meta { font-size:12px; color:var(--muted); }

/* inputs area */
.subject-inputs { width:220px; display:flex; gap:8px; align-items:center; justify-content:flex-end; }
.subject-inputs .form-control { height:38px !important; border-radius:8px !important; padding:6px 8px; font-size:13px; }

/* helper line under subject */
.subject-helper { font-size:12px; color:#5b6b9b; }

/* smaller note when checked/only-show */
.note-only { font-size:12px; color:#42526e; }

/* STUDENT TABLE / LIST */
.table-students { width:100%; border-collapse: collapse; margin-top:8px; background: #fff; border-radius:10px; overflow:hidden; box-shadow: 0 6px 18px rgba(25,40,90,0.02); }
.table-students th, .table-students td { padding:12px 10px; border-bottom: 1px solid #f2f6ff; text-align:left; vertical-align:middle; font-size:14px; }
.table-students th { background: linear-gradient(180deg, #fbfdff, #ffffff); font-weight:700; color:#233153; }
.obtained-mark { width:140px; }

/* BUTTONS */
.btn-modern {
    background: var(--accent); color:#fff; padding:10px 18px; border-radius:10px;
    border:none; font-weight:700; box-shadow: 0 8px 22px rgba(45,66,137,0.10);
}
.btn-outline-modern {
    border-radius:10px; border:1px solid #e7eefc; background:#fff; padding:8px 14px; font-weight:600;
}

/* HELPER TEXT */
.helper { font-size:12px; color:var(--muted); margin-top:6px; }

/* small responsive tweaks */
@media (max-width: 767px) {
    .subject-inputs { width:100%; justify-content:flex-start; gap:8px; flex-wrap:wrap; }
    .subject-box { min-height:62px; padding:10px; }
    .form-control { height:42px !important; }
}
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">

        <div class="card card-modern border-0">

            <div class="card-header-modern">
                <div>
                    <h5 class="mb-0">Generate Result Overview</h5>
                    <div class="sub" style="opacity:.95; margin-top:4px; font-weight:600;">Premium data-entry UI — clean, deliberate, fast.</div>
                </div>
                <div style="text-align:right;">
                    <small class="sub" style="opacity:.9">All backend fields & endpoints preserved</small>
                </div>
            </div>

            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('save_result') }}" method="post" novalidate>
                    @csrf

                    <div class="row g-4">

                        {{-- TOP CONTROLS --}}
                        <div class="col-md-3">
                            <label for="course_id">Select Course</label>
                            <select id="course_id" class="form-control" name="course_id" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <div class="helper">Choose course to load exams & subjects</div>
                        </div>

                        <div class="col-md-3">
                            <label for="exam_id">Exam</label>
                            <select id="exam_id" class="form-control" name="exam_id" required>
                                <option value="">Select Exam</option>
                            </select>
                            <div class="helper">Exam determines subject set & marks schema</div>
                        </div>

                        <div class="col-md-3">
                            <label for="session_start">Session Start</label>
                            <select id="session_start" class="form-control" name="session_start">
                                <option value="">Select</option>
                                @for($y=2020;$y<=2035;$y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                            <div class="helper">Students filtered by session year</div>
                        </div>

                        <div class="col-md-3">
                            <label for="marks_mode">Marks Mode</label>
                            <select id="marks_mode" class="form-control" name="marks_mode">
                                <option value="manual">Manual</option>
                                <option value="auto">Auto (random range)</option>
                            </select>
                            <div class="helper">Auto - fill marks using a range; Manual - enter per student</div>
                        </div>

                        <div class="col-md-12" id="auto_range_box" style="display:none; margin-top:-6px;">
                            <!-- injected -->
                        </div>

                        {{-- SUBJECT LIST --}}
                        <div class="col-md-12">
                            <div class="section-title">Subject Marks Entry</div>
                            <div id="subjectContainer">
                                <div class="helper">Select a course and exam to load subjects.</div>
                            </div>
                        </div>

                        {{-- STUDENT LIST --}}
                        <div class="col-md-12">
                            <div class="section-title">Student Marks Entry</div>

                            <div id="studentContainer">
                                <div class="helper">Select session start to load students.</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="helper" id="students_count_info">No students loaded.</div>
                                <div>
                                    <button type="button" class="btn btn-outline-modern me-2" id="clear_marks_btn">Clear Marks</button>
                                    <button type="submit" class="btn btn-modern">Submit Results</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- jQuery assumed available -->
<script>
$(document).ready(function(){

    $('select[name="course_id"]').change(function(){
        let id = $(this).val();
        $('#exam_id').html('<option>Loading exams...</option>');
        $.get("{{ url('get-exams-by-course') }}/" + id, function(data){
            let h = '<option value="">Select Exam</option>';
            data.forEach(ex => h += `<option value="${ex.id}">${ex.name}</option>`);
            $('select[name="exam_id"]').html(h);
        }).fail(function(){
            $('#exam_id').html('<option value="">Failed to load</option>');
        });
    });

    
    $('select[name="exam_id"]').change(function(){
        let exam_id = $(this).val();
        let box = $("#subjectContainer").html("<div class='helper'>Loading subjects...</div>");

        $.get("{{ url('get-subjects-by-exam') }}/" + exam_id, function(data){

            if (!data || data.length === 0) {
                return box.html("<div class='helper'>No subjects found for this exam.</div>");
            }

            let html = '<div class="row">';
            $.each(data, function(i, sub){
                html += `
                    <div class="col-md-6">
                        <div class="subject-box subject-row">
                            <div class="left">
                                <input type="checkbox" name="selected_subjects[]" value="${sub.id}" class="subject-check">
                            </div>

                            <div class="subject-details">
                                <div class="subject-name">${sub.name}</div>
                                <div class="subject-helper note-only">Set Max & Passing marks for accurate grading</div>
                            </div>

                            <div class="subject-inputs">
                                <input type="number"
                                    name="max_mark[${sub.id}]"
                                    value="${sub.max_mark ?? ''}"
                                    class="form-control"
                                    placeholder="Max" min="0">
                                <input type="number"
                                    name="passing_mark[${sub.id}]"
                                    value="${sub.passing_mark ?? ''}"
                                    class="form-control"
                                    placeholder="Pass" min="0">
                            </div>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            box.html(html);

        }).fail(function(){
            box.html("<div class='helper'>Failed to load subjects. Try again.</div>");
        });
    });

    /* ONLY SHOW SELECTED SUBJECT WHEN CHECKED */
    $(document).on("change", ".subject-check", function(){
        if ($(this).is(":checked")) {
            $(".subject-row").hide();
            $(this).closest(".subject-row").show();
        } else {
            $(".subject-row").show();
        }
    });

   $("#session_start").change(function(){

    let session = $(this).val();
    let course_id = $("#course_id").val();

    if(!course_id){
        $("#studentContainer").html("<div class='helper'>Please select course first.</div>");
        $("#students_count_info").text('No students loaded.');
        return;
    }

    if(!session){
        $("#studentContainer").html("<div class='helper'>Please select session.</div>");
        $("#students_count_info").text('No students loaded.');
        return;
    }

    $("#studentContainer").html("<div class='helper'>Loading students...</div>");

    $.get("{{ url('get-students-by-session-course') }}", {
        session_start: session,
        course_id: course_id
    }, function(data){

        if (!data || data.length === 0) {
            $("#studentContainer").html("<div class='helper'>No students found for this course & session.</div>");
            $("#students_count_info").text('0 students loaded.');
            return;
        }

        let h = `<table class="table-students">
                    <thead>
                        <tr>
                            <th style="width:48px">#</th>
                            <th>Student</th>
                            <th>Enrollment</th>
                            <th style="width:180px">Marks</th>
                        </tr>
                    </thead>
                    <tbody>`;

        data.forEach((s, idx) => {
            h += `
                <tr>
                    <td>${idx+1}</td>
                    <td><strong>${s.name}</strong></td>
                    <td><small>${s.enrollment_no}</small></td>
                    <td>
                        <input type="number" min="0"
                               class="form-control obtained-mark"
                               name="obtained_mark[${s.id}]"
                               placeholder="Marks">
                    </td>
                </tr>
            `;
        });

        h += `</tbody></table>`;

        $("#studentContainer").html(h);
        $("#students_count_info").text(data.length + ' students loaded.');

    }).fail(function(){
        $("#studentContainer").html("<div class='helper'>Failed to load students. Try again.</div>");
        $("#students_count_info").text('Failed to load.');
    });
});

    /* AUTO FILL MARKS */
    $("#marks_mode").change(function(){
        if($(this).val() === "auto") {
            $("#auto_range_box").html(`
                <div class="card p-3" style="border-radius:12px; border:1px solid #eef4ff; background: linear-gradient(180deg,#fff,#fbfdff);">
                    <label style="font-weight:700">Auto-fill Range</label>
                    <div class="row g-2" style="margin-top:8px;">
                        <div class="col-md-3">
                            <input type="number" id="min_range" class="form-control" placeholder="Min" min="0">
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="max_range" class="form-control" placeholder="Max" min="0">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="helper">Enter a range and marks will be filled randomly into the Marks column for each student.</div>
                        </div>
                    </div>
                </div>
            `).show();
        } else {
            $("#auto_range_box").hide().html('');
        }
    });

    $(document).on("keyup change", "#min_range, #max_range", function(){
        let min = parseInt($("#min_range").val());
        let max = parseInt($("#max_range").val());
        if(isNaN(min) || isNaN(max) || min >= max) return;

        $(".obtained-mark").each(function(){
            $(this).val(Math.floor(Math.random() * (max - min + 1)) + min);
        });
    });

    /* CLEAR MARKS */
    $(document).on('click', '#clear_marks_btn', function(){
        $(".obtained-mark").val('');
    });

});
</script>

@endsection
