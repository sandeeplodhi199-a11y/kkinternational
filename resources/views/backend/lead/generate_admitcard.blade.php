@extends('backend.layouts.app')
@section('content')

<style>
/* ----------- PAGE DESIGN (SUPER ATTRACTIVE) ----------- */

body {
    background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
}

.card-modern {
    backdrop-filter: blur(12px);
    background: rgba(255, 255, 255, 0.85);
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transition: 0.3s ease-in-out;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.card-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.12);
}

.card-header-modern {
    background: linear-gradient(135deg, #4e73df, #224abe);
    padding: 20px;
    border-radius: 16px 16px 0 0;
    color: white;
}

.card-header-modern h5 {
    font-weight: 700;
    letter-spacing: .5px;
}

/* INPUTS */
.form-control,
.select2-container--default .select2-selection--single {
    height: 46px !important;
    border-radius: 10px !important;
    border: 1px solid #d5d9df !important;
    font-size: 15px;
}

label {
    font-weight: 600;
    font-size: 14px;
    color: #394b59;
}

/* SECTION TITLE */
.section-title {
    font-size: 19px;
    font-weight: 700;
    margin-top: 25px;
    margin-bottom: 12px;
    padding-left: 12px;
    border-left: 5px solid #4e73df;
    color: #2c3e50;
}

/* SUBJECT BOX */
.subject-box {
    background: #f7f9fc;
    border-radius: 12px;
    padding: 15px 18px;
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    border: 1px solid #e3e6f0;
    transition: 0.25s;
}

.subject-box:hover {
    background: #eef2ff;
    border-color: #c7d2fe;
    transform: translateX(4px);
}

.subject-name {
    font-weight: 600;
    font-size: 16px;
}

/* NO SUBJECT MESSAGE */
.no-subject-box {
    background: rgba(255, 255, 255, 0.65);
    border: 1px solid rgba(200, 200, 255, 0.4);
    padding: 25px;
    border-radius: 14px;
    text-align: center;
    margin-top: 10px;
    margin-bottom: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(6px);
    animation: fadeIn 0.5s ease-in-out;
}

.no-subject-icon {
    font-size: 45px;
    color: #4e73df;
    opacity: 0.8;
}

.no-subject-text {
    font-size: 18px;
    font-weight: 700;
    color: #2f3e5c;
    margin-top: 8px;
}

.no-subject-subtext {
    font-size: 14px;
    color: #6c757d;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(6px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* SUBMIT BUTTON */
.btn-modern {
    padding: 12px 30px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    background: linear-gradient(135deg, #4e73df, #224abe);
    border: none;
    transition: 0.3s;
}

.btn-modern:hover {
    background: linear-gradient(135deg, #224abe, #1b2d6e);
    transform: scale(1.05);
    color: white;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">

        <div class="card card-modern border-0">

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admitcard_list') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                    + Manage Admit Card
                </a>
            </div>
            <div class="card-header-modern">
                <h5 class="mb-0">Generate AdmitCard Overview</h5>
            </div>

            <div class="card-body p-4">

                {{-- Alerts --}}
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('save_admitcard') }}" method="post">

                    @csrf

                    <div class="row g-4">

                        {{-- Course --}}
                        <div class="col-md-3">
                            <label>Select Course</label>
                            <select class="form-control select2" name="course_id" required>
                                <option value="" selected disabled>Select Course</option>
                                @foreach($courses as $cou)
                                <option value="{{ $cou->id }}">{{ $cou->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Exam --}}
                        <div class="col-md-3">
                            <label>Exam Type</label>
                            <select class="form-control select2" name="exam_id" required>
                                <option value="" disabled selected>Select Exam</option>
                            </select>
                        </div>

                        {{-- Session Start --}}
                        <div class="col-md-3">
                            <label>Session Start</label>
                            <select name="session_start" id="session_start" class="form-control" required>
                                <option value="">Select Start Year</option>
                                @for($year=2020;$year<=2035;$year++) <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <label>Status</label>
                            <select class="form-control select2" name="status" required>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>

                        {{-- SUBJECT AREA --}}
                        <div class="col-md-12">
                            <div class="section-title">Subject Exam Dates</div>
                            <div id="subjectContainer"></div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="col-md-12 text-end mt-3">
                            <button type="submit" class="btn btn-modern">
                                Submit
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {

    $('select[name="course_id"]').on('change', function() {

        var course_id = $(this).val();


        $('select[name="exam_id"]').html('<option selected disabled>Select Exam</option>');
        $('select[name="exam_id"]').prop('disabled', true);

        $("#subjectContainer").html(`
        <div class="no-subject-box">
            <div class="no-subject-icon">📘</div>
            <div class="no-subject-text">Please select an exam</div>
            <div class="no-subject-subtext">Exam list will appear after choosing a course.</div>
        </div>
    `);


        if (course_id) {
            $.ajax({
                url: "{{ url('get-exams-by-course') }}/" + course_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    var examSelect = $('select[name="exam_id"]');
                    examSelect.prop('disabled', false);

                    if (data.length === 0) {
                        examSelect.html('<option>No Exams Found</option>');
                    } else {
                        examSelect.html('<option disabled selected>Select Exam</option>');
                        $.each(data, function(key, value) {
                            examSelect.append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                    }
                }
            });
        }
    });


    $('select[name="exam_id"]').on('change', function() {

        var exam_id = $(this).val();
        var box = $("#subjectContainer");
        box.html("");

        if (exam_id) {
            $.ajax({
                url: "{{ url('get-subjects-by-exam') }}/" + exam_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    if (data.length === 0) {

                        box.html(`
                            <div class="no-subject-box">
                                <div class="no-subject-icon">📘</div>
                                <div class="no-subject-text">No Subjects Available</div>
                                <div class="no-subject-subtext">
                                    The selected exam doesn't have subjects mapped yet.<br>
                                    Please contact the administrator.
                                </div>
                            </div>
                        `);

                    } else {

                        let html = "";

                        $.each(data, function(_, sub) {
                            html += `
                                <div class="subject-box row">
                                    <div class="col-md-6 subject-name">${sub.name}</div>
                                    <div class="col-md-6">
                                        <input type="date" name="subject_date[${sub.id}]" class="form-control" required>
                                    </div>
                                </div>
                            `;
                        });

                        box.html(html);
                    }
                }
            });
        }
    });

});
</script>

@endsection