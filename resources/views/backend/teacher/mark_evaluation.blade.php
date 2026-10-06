@extends('backend.layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
.content-wrapper { background: #f4f6f9; min-height: calc(100vh - 120px); overflow-x: auto; }

/* Animations & Transitions */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes skeleton-pulse {
    0% { background-color: #e0e0e0; }
    50% { background-color: #f0f0f0; }
    100% { background-color: #e0e0e0; }
}

.skeleton-box {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    border-radius: 8px;
    height: 40px;
    margin-bottom: 10px;
    animation: skeleton-pulse 1.5s infinite;
}

.skeleton-text {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    height: 20px;
    border-radius: 4px;
    margin-bottom: 8px;
    animation: skeleton-pulse 1.5s infinite;
}

.card-custom {
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.card-custom:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.page-title { 
    font-weight: 700; 
    background: linear-gradient(135deg, #1e293b, #4f46e5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.6rem;
}

.section-list, .subject-list, .exam-list {
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.2s ease;
    max-height: 150px;
    overflow-y: auto;
    border: 1px solid #e2e8f0;
}

.section-list:hover, .subject-list:hover, .exam-list:hover {
    border-color: #4f46e5;
    background: #ffffff;
}

.step-suggestion {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-left: 5px solid #f59e0b;
    padding: 14px 20px;
    border-radius: 14px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
    color: #dc3545;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.step-suggestion i {
    font-size: 1.3rem;
}

/* Table Container */
.table-responsive-custom {
    overflow-x: auto;
    margin: 0 -1px;
    border-radius: 16px;
}

.table {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    min-width: 1200px;
    width: 100%;
}

.table thead {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    color: #fff;
}

.table thead th {
    padding: 14px 12px;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.3px;
    border-bottom: none;
    white-space: nowrap;
}

.table thead th i {
    margin-right: 8px;
    opacity: 0.9;
}

.table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background: #f8fafc;
}

.table td {
    padding: 12px 10px;
    vertical-align: middle;
    font-size: 13px;
}

.btn-main {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff;
    padding: 12px 30px;
    border-radius: 40px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 15px;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.btn-main:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
}

.btn-main:disabled {
    background: linear-gradient(135deg, #94a3b8, #64748b);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-secondary-custom {
    background: linear-gradient(135deg, #64748b, #475569);
    color: #fff;
    padding: 12px 30px;
    border-radius: 40px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 15px;
}

.btn-secondary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
}

.is-invalid {
    border-color: #dc2626 !important;
    background-color: #fef2f2 !important;
}

.error-message {
    color: #dc2626;
    font-size: 11px;
    margin-top: 5px;
    display: block;
    font-weight: 500;
}

/* Theory Mark Styles (Blue Theme) - INCREASED WIDTH */
.max-mark {
    width: 100px;
    background: linear-gradient(135deg, #0284c7, #0369a1);
    border: none;
    border-radius: 10px;
    padding: 10px 12px;
    font-weight: 600;
    color: #ffffff;
    text-align: center;
    font-size: 14px;
}

.obtain-mark-input {
    width: 140px;
    border-radius: 10px;
    border: 2px solid #7dd3fc;
    padding: 10px 12px;
    transition: all 0.2s ease;
    background: #ffffff;
    font-size: 14px;
}

.obtain-mark-input:focus {
    border-color: #0284c7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
    background: #f0f9ff;
}

.obtain-mark-input:read-only {
    background-color: #e0f2fe;
    cursor: not-allowed;
    opacity: 0.7;
}

/* Practical Mark Styles (Pink Theme) - INCREASED WIDTH */
.max-practical-mark {
    width: 100px;
    background: linear-gradient(135deg, #d5972d, #3a22d6);
    border: none;
    border-radius: 10px;
    padding: 10px 12px;
    font-weight: 600;
    color: #ffffff;
    text-align: center;
    font-size: 14px;
}

.obtain-practical-mark-input {
    width: 140px;
    border-radius: 10px;
    border: 2px solid #fbcfe8;
    padding: 10px 12px;
    transition: all 0.2s ease;
    background: #ffffff;
    font-size: 14px;
}

.obtain-practical-mark-input:focus {
    border-color: #db2777;
    outline: none;
    box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.1);
    background: #fdf2f8;
}

.obtain-practical-mark-input:read-only {
    background-color: #fce7f3;
    cursor: not-allowed;
    opacity: 0.7;
}

/* Header styling */
.theory-header {
    background: linear-gradient(135deg, #0284c7, #0369a1) !important;
}

.practical-header {
    background: linear-gradient(135deg, #ffb700, #1405ff) !important;
}

.mark-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 8px;
}

.theory-badge {
    background: #0284c7;
    color: white;
}

.practical-badge {
    background: #db2777;
    color: white;
}

.error-message-field-theory, .error-message-field-practical {
    color: #dc2626;
    font-size: 10px;
    margin-top: 4px;
    display: none;
    font-weight: 500;
}

.form-check {
    padding: 10px 14px;
    margin: 0;
    border-radius: 10px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.form-check:hover {
    background: #eef2ff;
}

.form-check-input {
    cursor: pointer;
    accent-color: #4f46e5;
    width: 16px;
    height: 16px;
}

.form-check-label {
    cursor: pointer;
    margin-left: 22px;
    color: #334155;
    font-weight: 500;
    font-size: 13px;
    margin-top: -22px;
}

label {
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.3px;
}

.form-control, select.form-control {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
    font-size: 14px;
    padding: 10px 12px;
}

.form-control:focus, select.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
}

.icon-primary { color: #4f46e5; }
.icon-success { color: #16a34a; }
.icon-warning { color: #dc3545; }
.icon-info { color: #3b82f6; }
.icon-purple { color: #8b5cf6; }
.icon-pink { color: #db2777; }

.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    background: white;
    padding: 3px 20px;
    border-radius: 60px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #e2e8f0;
    color: #64748b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.step-item.active .step-number {
    background: linear-gradient(135deg, #16a34a, #16a34a);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    transform: scale(1.05);
}

.step-item.completed .step-number {
    background: #10b981;
    color: white;
}

.step-item span {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
}

.step-item.active span {
    color: #16a34a;
}

.step-connector {
    width: 60px;
    height: 2px;
    background: #e2e8f0;
    margin: 0 10px;
    margin-bottom: 25px;
}

.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .step-connector {
        width: 20px;
    }
    .step-number {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    .step-item span {
        font-size: 10px;
    }
}

.section-list {
    height: 80px;      
    overflow-y: auto;   
}

/* Student name styling */
.student-name {
    font-weight: 600;
    color: #1e293b;
}

.admission-no {
    font-family: monospace;
    font-size: 12px;
    color: #64748b;
}

/* Absent Checkbox Styles */
.absent-checkbox {
    margin-left: 8px;
    transform: scale(1.1);
    accent-color: #dc3545;
    cursor: pointer;
}

.absent-label {
    font-size: 11px;
    font-weight: 500;
    color: #dc3545;
    margin-left: 4px;
    cursor: pointer;
}

.mark-input-disabled {
    background-color: #f1f5f9 !important;
    cursor: not-allowed;
    opacity: 0.6;
}

/* ── NEW: Subject summary banner ── */
.subject-summary-banner {
    margin-top: 8px;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #86efac;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    line-height: 1.8;
    display: none;
}
.subject-summary-banner .s-total { color:#0284c7; font-weight:700; }
.subject-summary-banner .s-inc   { color:#16a34a; font-weight:700; }
.subject-summary-banner .s-exc   { color:#dc2626; font-weight:700; }
.subject-summary-banner .s-names { color:#6b7280; font-size:11px; display:block; margin-left:14px; }

</style>

<div class="content-wrapper">
    <div class="container-fluid mt-4">
        <h4 class="page-title mb-4">
            <i class="fas fa-graduation-cap"></i>
            <span>Students Mark Evaluation</span>
        </h4>
        
        <div id="toastContainer"></div>

        <div class="step-progress">
            <div class="step-item" id="step1">
                <div class="step-number">1</div>
                <span>Session</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" id="step2">
                <div class="step-number">2</div>
                <span>Grade</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" id="step3">
                <div class="step-number">3</div>
                <span>Section</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" id="step4">
                <div class="step-number">4</div>
                <span>Exam</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" id="step5">
                <div class="step-number">5</div>
                <span>Subject</span>
            </div>
        </div>

        <div id="stepSuggestion" class="step-suggestion" style="display: none;">
            <i class="fas fa-lightbulb icon-warning"></i> 
            <span id="suggestionText">Please select a grade to continue</span>
        </div>

        <div class="card-custom">
            <form id="markEvaluationForm" method="POST">
                @csrf
                <input type="hidden" name="selected_subject" id="selected_subject">
                <input type="hidden" name="selected_exam" id="selected_exam">
                <input type="hidden" name="selected_session" id="selected_session">
                <input type="hidden" name="selected_grade" id="selected_grade">
                <input type="hidden" name="selected_section" id="selected_section">

                <div class="row">
                    <div class="col-md-3">
                        <label><i class="fas fa-calendar-alt icon-info"></i> Session <span class="text-danger">*</span></label>
                        <select id="from_session" class="form-control select2" required>
                            <option value="">📅 Select Session</option>
                            @foreach($session as $sess)
                                <option value="{{ $sess->id }}">{{ $sess->name }}</option>
                            @endforeach
                        </select>
                        <div class="error-message" id="sessionError"></div>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-layer-group icon-purple"></i> Grade <span class="text-danger">*</span></label>
                        <select class="form-control grade-select select2" required>
                            <option value="">⭐ Select Grade</option>
                            @foreach($grade as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <div class="error-message" id="gradeError"></div>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-users icon-primary"></i> Section <span class="text-danger">*</span></label>
                        <div class="section-list border p-2" id="sectionList"></div>
                        <div class="error-message" id="sectionError"></div>
                    </div>

                    <div class="col-md-2">
                        <label><i class="fas fa-file-alt icon-success"></i> Exam <span class="text-danger">*</span></label>
                        <div class="exam-list border p-2" id="examList"></div>
                        <div class="error-message" id="examError"></div>
                    </div>

                    <div class="col-md-3">
                        <label><i class="fas fa-book icon-pink"></i> Subject <span class="text-danger">*</span></label>
                        <div class="subject-list border p-2" id="subjectList"></div>

                        {{-- ✅ NEW: Subject summary banner --}}
                        <div class="subject-summary-banner" id="subjectSummaryBanner">
                            <div><i class="fas fa-book-open" style="color:#0284c7;"></i> Total: <span class="s-total" id="sTotal">0</span> subjects</div>
                            <div><i class="fas fa-check-circle" style="color:#16a34a;"></i> <span class="s-inc" id="sInc">0</span> Included for marks</div>
                            <div id="sExcRow" style="display:none;">
                                <i class="fas fa-times-circle" style="color:#dc2626;"></i>
                                <span class="s-exc" id="sExc">0</span> Excluded
                                <span class="s-names" id="sExcNames"></span>
                            </div>
                        </div>

                        <div class="error-message" id="subjectError"></div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="table-responsive-custom">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> S.No</th>
                                    <th><i class="fas fa-id-card"></i> Admission No</th>
                                    <th><i class="fas fa-layer-group"></i> Grade</th>
                                    <th><i class="fas fa-users"></i> Section</th>
                                    <th><i class="fas fa-user-graduate"></i> Student Name</th>
                                    <th><i class="fas fa-book-open"></i> Subject</th>
                                    <th class="theory-header">
                                        <i class="fas fa-chart-line"></i> Max Theory Mark
                                    </th>
                                    <th class="practical-header" id="practicalHeader">
                                        <i class="fas fa-flask"></i> Max Practical Mark
                                    </th>
                                    <th class="theory-header">
                                        <i class="fas fa-pen-alt"></i> Obtain Theory Mark
                                    </th>
                                    <th class="practical-header" id="obtainPracticalHeader">
                                        <i class="fas fa-microscope"></i> Obtain Practical Mark
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="student_list">
                                 <tr>
                                    <td colspan="10" class="text-center text-danger py-5">
                                        <i class="fas fa-info-circle me-2"></i> Please complete all steps to view students
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn-main" id="submitBtn" disabled>
                        <i class="fas fa-save"></i> Save Marks
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Debug AJAX requests
    $(document).ajaxError(function(event, xhr, settings, error) {
        console.error("AJAX Error:", settings.url, error);
        console.log("Response:", xhr.responseText);
    });

    let formState = {
        session_id: '',
        grade_id: '',
        section_id: '',
        exam_id: '',
        subject_id: '',
        subject_name: '',
        is_optional: false,
        max_mark: null,
        max_practical_mark: null,
        has_practical: false
    };

    let existingMarksData = {};

    function showToast(message, type = 'success') {
        const bgColor = type === 'success' ? '#10b981' : '#ef4444';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const toast = `
            <div class="toast-notification" style="background: ${bgColor}; color: white; border-radius: 12px; padding: 15px 20px; margin-bottom: 10px;">
                <i class="fas ${icon} me-2"></i>
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
            </div>
        `;
        $('#toastContainer').append(toast);
        setTimeout(() => {
            $('.toast-notification').first().fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }

    function updateStepProgress() {
        $('.step-item').removeClass('active completed');
        
        if (formState.session_id) {
            $('#step1').addClass('completed');
        } else {
            $('#step1').addClass('active');
            return;
        }
        
        if (formState.grade_id) {
            $('#step2').addClass('completed');
        } else {
            $('#step2').addClass('active');
            return;
        }
        
        if (formState.section_id) {
            $('#step3').addClass('completed');
        } else {
            $('#step3').addClass('active');
            return;
        }
        
        if (formState.exam_id) {
            $('#step4').addClass('completed');
        } else {
            $('#step4').addClass('active');
            return;
        }
        
        if (formState.subject_id) {
            $('#step5').addClass('completed');
        } else {
            $('#step5').addClass('active');
            return;
        }
    }

    function updateSuggestion() {
        let suggestion = '';

        if (!formState.session_id) {
            suggestion = '📌 Step 1: Select a session first';
        } else if (!formState.grade_id) {
            suggestion = '📌 Step 2: Select a grade';
        } else if (!formState.section_id) {
            suggestion = '📌 Step 3: Choose a section from the options below';
        } else if (!formState.exam_id) {
            suggestion = '📌 Step 4: Select an exam to load subjects';
        } else if (!formState.subject_id) {
            suggestion = '📌 Step 5: Pick a subject to enable mark entry';
        } else {
            let studentCount = $('#student_list tr:not(:has(td[colspan]))').length;
            if (studentCount === 0) {
                suggestion = '⚠️ No students found. Please check your selection.';
            } else {
                suggestion = '✅ All steps complete! You can now enter marks and submit.';
            }
        }

        $('#suggestionText').text(suggestion);
        $('#stepSuggestion').fadeIn(300);
        updateStepProgress();
        
        let allValid = formState.session_id && formState.grade_id && formState.section_id && 
                       formState.exam_id && formState.subject_id;
        $('#submitBtn').prop('disabled', !allValid);
    }

    function showSkeleton(containerId, type = 'list') {
        let html = '';
        if (type === 'list') {
            for (let i = 0; i < 3; i++) {
                html += `<div class="skeleton-box" style="height: 35px; margin-bottom: 8px;"></div>`;
            }
        } else if (type === 'table') {
            for (let i = 0; i < 3; i++) {
                html += `<tr><td colspan="10"><div class="skeleton-text" style="height: 50px;"></div></td></tr>`;
            }
        }
        $('#' + containerId).html(html);
    }

    function loadExistingMarks() {
        if (!formState.exam_id || !formState.subject_id || !formState.session_id || 
            !formState.grade_id || !formState.section_id) {
            return;
        }

        $.get("{{ url('admin/get-student-marks') }}", {
            exam_id: formState.exam_id,
            subject_id: formState.subject_id,
            session_id: formState.session_id,
            grade_id: formState.grade_id,
            section_id: formState.section_id
        }, function(marks) {
            existingMarksData = marks;

            $('.obtain-mark-input, .obtain-practical-mark-input')
                .val('')
                .prop('disabled', false)
                .removeClass('mark-input-disabled');
            $('.absent-checkbox, .remove-marks-checkbox').prop('checked', false);
            $('[id^="remove_marks_wrap_"]').hide();
            
            // Populate theory marks and absent status
            $('.obtain-mark-input').each(function() {
                let studentId = $(this).attr('name').match(/\d+/)[0];
                if (marks[studentId]) {
                    if (marks[studentId].is_absent_theory) {
                        $(this).val('');
                        $(this).prop('disabled', true);
                        $(`#absent_theory_${studentId}`).prop('checked', true);
                    } else {
                        $(this).val(marks[studentId].obtained_mark);
                        $(`#absent_theory_${studentId}`).prop('checked', false);
                        $(this).prop('disabled', false);
                    }

                    if (formState.is_optional) {
                        $(`#remove_marks_wrap_${studentId}`).show();
                    }
                }
            });
            
            // Populate practical marks and absent status (only if has practical)
            if (formState.has_practical) {
                $('.obtain-practical-mark-input').each(function() {
                    let studentId = $(this).attr('name').match(/\d+/)[0];
                    if (marks[studentId]) {
                        if (marks[studentId].is_absent_practical) {
                            $(this).val('');
                            $(this).prop('disabled', true);
                            $(`#absent_practical_${studentId}`).prop('checked', true);
                        } else {
                            $(this).val(marks[studentId].obtained_practical_mark);
                            $(`#absent_practical_${studentId}`).prop('checked', false);
                            $(this).prop('disabled', false);
                        }
                    }
                });
            }
        }).fail(function(error) {
            console.error("Error loading existing marks:", error);
        });
    }

    // ── NEW: Load subject summary (total / included / excluded) ──
    function loadSubjectSummary() {
        if (!formState.exam_id || !formState.grade_id) {
            $('#subjectSummaryBanner').hide();
            return;
        }
        $.get("{{ url('admin/get-exam-subject-summary') }}", {
            exam_id:  formState.exam_id,
            grade_id: formState.grade_id
        }, function(res) {
            if (res.total > 0) {
                $('#sTotal').text(res.total);
                $('#sInc').text(res.included);
                $('#sExc').text(res.excluded);
                if (res.excluded > 0) {
                    let excNames = res.subjects
                        .filter(s => s.is_included == 0)
                        .map(s => s.subject_name)
                        .join(', ');
                    $('#sExcNames').text('(' + excNames + ')');
                    $('#sExcRow').show();
                } else {
                    $('#sExcRow').hide();
                }
                $('#subjectSummaryBanner').slideDown(300);
            } else {
                $('#subjectSummaryBanner').hide();
            }
        });
    }

    // Function to load subjects based on grade, section, and exam
    // ── CHANGED: only is_included=1 subjects come from API ──
    function loadSubjects() {
        if (!formState.grade_id || !formState.exam_id) {
            return;
        }
        
        showSkeleton('subjectList', 'list');
        
        $.get("{{ url('admin/get-exam-subjects') }}", {
            exam_id: formState.exam_id,
            grade_id: formState.grade_id,
            section_id: formState.section_id || ''
        }, function(res) {
            let html = '';
            if (res.length === 0) {
                html = '<div class="text-muted p-2"><i class="fas fa-ban me-2"></i>No subjects found</div>';
            } else {
                res.forEach(function(item) {
                    // Check if subject has practical marks
                    let hasPractical = item.has_practical && item.practical_marks > 0;
                    let practicalBadge = hasPractical ? `<span class="mark-badge practical-badge">P:${item.practical_marks}</span>` : '<span class="mark-badge practical-badge" style="background:#94a3b8;">Not Applicable</span>';
                    
                    html += `<div class="form-check">
                                <input type="radio" name="subject_id" class="subject-radio" 
                                    data-theory-mark="${item.marks}" 
                                    data-practical-mark="${item.practical_marks}"
                                    data-has-practical="${hasPractical}"
                                    data-is-optional="${item.is_optional ? 1 : 0}"
                                    data-subject-name="${item.subject_name}"
                                    value="${item.subject_id}" id="subject_${item.subject_id}">
                                <label class="form-check-label" for="subject_${item.subject_id}">
                                    <i class="fas fa-book icon-pink me-1"></i>${item.subject_name} 
                                    <span class="mark-badge theory-badge">T:${item.marks}</span>
                                    ${practicalBadge}
                                </label>
                            </div>`;
                });
            }
            $('#subjectList').fadeOut(150, function() {
                $(this).html(html).fadeIn(300);
            });

            // ── NEW: load summary after subjects load ──
            loadSubjectSummary();

        }).fail(function(error) {
            console.error("Error loading subjects:", error);
            $('#subjectList').html('<div class="text-danger p-2">Error loading subjects</div>');
        });
    }

    $('#from_session').on('change', function() {
        formState.session_id = $(this).val();
        $('#selected_session').val(formState.session_id);
        
        if (!formState.session_id) {
            updateSuggestion();
            return;
        }
        
        $('.grade-select').val('').trigger('change');
        $('#sectionList, #examList, #subjectList').html('');
        $('#subjectSummaryBanner').hide(); // ── NEW ──
        $('#student_list').html('<tr><td colspan="10" class="text-center"><i class="fas fa-arrow-up me-2"></i>Please select grade first</td></tr>');
        formState.grade_id = formState.section_id = formState.exam_id = formState.subject_id = '';
        formState.subject_name = '';
        formState.is_optional = false;
        formState.max_mark = null;
        formState.max_practical_mark = null;
        formState.has_practical = false;
        updateSuggestion();
    });

    $(document).on('change', '.grade-select', function() {
        let grade_id = $(this).val();
        
        if (!grade_id) {
            formState.grade_id = '';
            updateSuggestion();
            return;
        }
        
        formState.grade_id = grade_id;
        $('#selected_grade').val(formState.grade_id);
        formState.section_id = formState.exam_id = formState.subject_id = '';
        formState.subject_name = '';
        formState.is_optional = false;
        formState.max_mark = null;
        formState.max_practical_mark = null;
        formState.has_practical = false;
        
        showSkeleton('sectionList', 'list');
        showSkeleton('examList', 'list');
        $('#subjectList, #student_list').html('');
        $('#subjectSummaryBanner').hide(); // ── NEW ──
        
        $.get("{{ url('admin/get-sections') }}/" + grade_id, function(res) {
            let html = '';
            if (res.length === 0) {
                html = '<div class="text-muted text-center p-2"><i class="fas fa-ban me-2"></i>No sections available</div>';
            } else {
                res.forEach(function(item) {
                    html += `<div class="form-check">
                                <input type="radio" name="section_id" class="section-radio" value="${item.id}" id="section_${item.id}">
                                <label class="form-check-label" for="section_${item.id}">
                                    <i class="fas fa-users icon-primary me-1"></i>${item.name}
                                </label>
                            </div>`;
                });
            }
            $('#sectionList').fadeOut(150, function() {
                $(this).html(html).fadeIn(300);
            });
        }).fail(function(error) {
            console.error("Error loading sections:", error);
            $('#sectionList').html('<div class="text-danger text-center p-2">Error loading sections</div>');
        });
        
        $.get("{{ url('admin/get-exams') }}/" + grade_id, function(res) {
            let html = '';
            if (res.length === 0) {
                html = '<div class="text-muted text-center p-2"><i class="fas fa-ban me-2"></i>No exams available</div>';
            } else {
                res.forEach(function(item) {
                    html += `<div class="form-check">
                                <input type="radio" name="exam_id" class="exam-radio" value="${item.id}" id="exam_${item.id}">
                                <label class="form-check-label" for="exam_${item.id}">
                                    <i class="fas fa-file-alt icon-success me-1"></i>${item.exam_name}
                                </label>
                            </div>`;
                });
            }
            $('#examList').fadeOut(150, function() {
                $(this).html(html).fadeIn(300);
            });
        }).fail(function(error) {
            console.error("Error loading exams:", error);
            $('#examList').html('<div class="text-danger text-center p-2">Error loading exams</div>');
        });
        
        updateSuggestion();
    });
    
    $(document).on('change', '.section-radio', function() {
        formState.section_id = $(this).val();
        $('#selected_section').val(formState.section_id);
        
        // IMPORTANT: When section changes, reload subjects (if exam is selected)
        if (formState.exam_id) {
            loadSubjects();
        }
        
        if (!formState.exam_id) {
            $('#student_list').html('<tr><td colspan="10" class="text-center text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Please select an exam first</td></tr>');
            updateSuggestion();
            return;
        }
        
        loadStudents();
        updateSuggestion();
    });
    
    $(document).on('change', '.exam-radio', function() {
        formState.exam_id = $(this).val();
        $('#selected_exam').val(formState.exam_id);
        
        // Load subjects based on grade, section, and exam
        loadSubjects();
        
        if (formState.section_id) {
            loadStudents();
        }
        
        updateSuggestion();
    });
    
    $(document).on('change', '.subject-radio', function() {
        let newSubjectName = $(this).data('subject-name');
        let newMaxMark = $(this).data('theory-mark');
        let newMaxPracticalMark = $(this).data('practical-mark');
        let newSubjectId = $(this).val();
        let hasPractical = $(this).data('has-practical');
        let isOptional = Number($(this).data('is-optional')) === 1;
        
        formState.subject_name = newSubjectName;
        formState.max_mark = newMaxMark;
        formState.max_practical_mark = newMaxPracticalMark;
        formState.subject_id = newSubjectId;
        formState.has_practical = hasPractical;
        formState.is_optional = isOptional;
        
        $('#selected_subject').val(formState.subject_id);
        
        // ALWAYS show practical columns - don't hide them
        $('#practicalHeader, #obtainPracticalHeader').show();
        $('.practical-col').show();
        
        // Update the text in Max Practical Mark header based on has_practical
        if (!hasPractical || formState.max_practical_mark <= 0) {
            $('#practicalHeader').html('<i class="fas fa-flask"></i> Practical Status');
            $('#obtainPracticalHeader').html('<i class="fas fa-microscope"></i> Remarks');
        } else {
            $('#practicalHeader').html('<i class="fas fa-flask"></i> Max Practical Mark');
            $('#obtainPracticalHeader').html('<i class="fas fa-microscope"></i> Obtain Practical Mark');
        }
        
        // Re-render student list to show subject selection
        if (formState.section_id && formState.exam_id) {
            loadStudents();
        }
        
        updateSuggestion();
    });
    
    // Handler for Theory Absent Checkbox
    $(document).on('change', 'input[id^="absent_theory_"]', function() {
        let studentId = $(this).attr('id').split('_')[2];
        let $theoryInput = $(`input[name="obtain_mark[${studentId}]"]`);
        
        if ($(this).is(':checked')) {
            $theoryInput.val('').prop('disabled', true).addClass('mark-input-disabled');
            $theoryInput.removeClass('is-invalid');
            $theoryInput.siblings('.error-message-field-theory').hide();
        } else {
            $theoryInput.prop('disabled', false).removeClass('mark-input-disabled');
            if ($theoryInput.val() !== '') {
                $theoryInput.trigger('input');
            }
        }
    });
    
    // Handler for Practical Absent Checkbox (only if has practical)
    $(document).on('change', 'input[id^="absent_practical_"]', function() {
        let studentId = $(this).attr('id').split('_')[2];
        let $practicalInput = $(`input[name="obtain_practical_mark[${studentId}]"]`);
        
        if ($(this).is(':checked')) {
            $practicalInput.val('').prop('disabled', true).addClass('mark-input-disabled');
            $practicalInput.removeClass('is-invalid');
            $practicalInput.siblings('.error-message-field-practical').hide();
        } else {
            $practicalInput.prop('disabled', false).removeClass('mark-input-disabled');
            if ($practicalInput.val() !== '') {
                $practicalInput.trigger('input');
            }
        }
    });

    $(document).on('change', '.remove-marks-checkbox', function() {
        let studentId = $(this).data('student-id');
        let shouldRemove = $(this).is(':checked');
        let $row = $(this).closest('tr');

        $row.find('.obtain-mark-input, .obtain-practical-mark-input, .absent-checkbox')
            .prop('disabled', shouldRemove);

        if (!shouldRemove) {
            loadExistingMarks();
        }
    });
    
    function loadStudents() {
        if (!formState.section_id || !formState.grade_id || !formState.session_id || !formState.exam_id) {
            console.log("Missing required fields for loading students");
            return;
        }
        
        console.log("Loading students with params:", {
            session_id: formState.session_id,
            grade_id: formState.grade_id,
            section_id: formState.section_id
        });
        
        showSkeleton('student_list', 'table');
        
        $.get("{{ url('admin/get-students') }}", {
            session_id: formState.session_id,
            grade_id: formState.grade_id,
            section_id: formState.section_id
        }, function(res) {
            console.log("Students response:", res);
            
            let html = '';
            let hasPractical = (formState.has_practical && formState.max_practical_mark > 0);
            
            // Check if response is valid and has data
            if (res && Array.isArray(res) && res.length > 0) {
                res.forEach(function(st, index) {
                    let isSubjectSelected = formState.subject_id && formState.max_mark;
                    let readonlyAttr = isSubjectSelected ? '' : 'readonly';
                    let readonlyClass = isSubjectSelected ? '' : 'bg-light';
                    let theoryPlaceholder = isSubjectSelected ? '✏️ Enter theory marks' : '🔒 Select subject first';
                    
                    let theoryAbsentHtml = '';
                    let removeMarksHtml = '';
                    let practicalAbsentHtml = '';
                    let practicalContent = '';
                    let maxPracticalValue = '';
                    
                    if (isSubjectSelected) {
                        theoryAbsentHtml = `<div class="mt-1">
                            <input type="checkbox" id="absent_theory_${st.id}" name="absent_theory[${st.id}]" class="absent-checkbox" value="1">
                            <label for="absent_theory_${st.id}" class="absent-label">Absent</label>
                        </div>`;

                        if (formState.is_optional) {
                            removeMarksHtml = `<div class="mt-2" id="remove_marks_wrap_${st.id}" style="display:none;">
                                <input type="checkbox" id="remove_marks_${st.id}" name="remove_marks[${st.id}]"
                                    class="remove-marks-checkbox" data-student-id="${st.id}" value="1">
                                <label for="remove_marks_${st.id}" class="absent-label">
                                    Remove optional marks
                                </label>
                            </div>`;
                        }
                    }
                    
                    // Determine Practical column content based on has_practical
                    if (hasPractical) {
                        // Has practical marks - show input field with max value
                        maxPracticalValue = formState.max_practical_mark;
                        let practicalPlaceholder = isSubjectSelected ? '🔬 Enter practical marks' : '🔒 Select subject first';
                        
                        if (isSubjectSelected) {
                            practicalAbsentHtml = `<div class="mt-1">
                                <input type="checkbox" id="absent_practical_${st.id}" name="absent_practical[${st.id}]" class="absent-checkbox" value="1">
                                <label for="absent_practical_${st.id}" class="absent-label">Absent</label>
                            </div>`;
                        }
                        
                        practicalContent = `
                            <input type="number" name="obtain_practical_mark[${st.id}]" class="form-control obtain-practical-mark-input ${readonlyClass}" 
                                step="any" min="0" max="${formState.max_practical_mark || ''}" ${readonlyAttr} 
                                placeholder="${practicalPlaceholder}" style="width:140px;">
                            ${practicalAbsentHtml}
                            <span class="error-message-field-practical" style="display:none;"></span>
                        `;
                    } else {
                        // No practical marks - show "Not Applicable" in both max and obtain columns
                        maxPracticalValue = 'N/A';
                        practicalContent = `
                            <input type="hidden" name="obtain_practical_mark[${st.id}]" value="0">
                            <div class="text-muted text-center" style="padding: 8px; background: #f8f9fa; border-radius: 8px;">
                                <i class="fas fa-ban me-1"></i> Not Applicable
                            </div>
                        `;
                    }
                    
                    html += `<tr style="animation: fadeInUp 0.3s ease ${index * 0.05}s both;">
                        <td>${index + 1}</td>
                        <td><span class="admission-no">${st.admission_no || 'N/A'}</span></td>
                        <td>${st.grade_name || 'N/A'}</td>
                        <td>${st.section_name || 'N/A'}</td>
                        <td><span class="student-name">${st.student_name || st.name || 'N/A'}</span></td>
                        <td class="subject-col">${isSubjectSelected ? `<i class="fas fa-book-open icon-pink me-1"></i>${formState.subject_name}` : '<i class="fas fa-minus-circle text-muted"></i> -'}</td>
                        <td><input type="number" class="form-control max-mark" readonly value="${formState.max_mark || ''}"></td>
                        <td class="practical-col">
                            ${maxPracticalValue === 'N/A' ? 
                                `<div class="text-muted text-center" style="padding: 8px; background: #f8f9fa; border-radius: 8px;">
                                    <i class="fas fa-ban me-1"></i> Not Applicable
                                </div>` : 
                                `<input type="number" class="form-control max-practical-mark" readonly value="${maxPracticalValue}">`
                            }
                        </td>
                        <td>
                            <input type="number" name="obtain_mark[${st.id}]" class="form-control obtain-mark-input ${readonlyClass}" 
                                step="any" min="0" max="${formState.max_mark || ''}" ${readonlyAttr} 
                                placeholder="${theoryPlaceholder}" style="width:140px;">
                            ${theoryAbsentHtml}
                            ${removeMarksHtml}
                            <span class="error-message-field-theory" style="display:none;"></span>
                        </td>
                        <td class="practical-col">
                            ${practicalContent}
                        </td>
                      </tr>`;
                });
            } else {
                html = `<tr>
                    <td colspan="10" class="text-center text-danger py-4">
                        <i class="fas fa-users-slash me-2"></i>⚠️ No students found for the selected criteria
                    </td>
                </tr>`;
            }
            
            $('#student_list').fadeOut(150, function() {
                $(this).html(html).fadeIn(300);
                
                // If subject is selected, setup the input validations
                if (formState.subject_id && formState.max_mark && res && res.length > 0) {
                    $('.max-mark').val(formState.max_mark);
                    
                    // Setup theory mark inputs
                    $('.obtain-mark-input').each(function() {
                        $(this).prop('readonly', false).removeClass('bg-light');
                        $(this).attr('max', formState.max_mark);
                        $(this).attr('placeholder', '✏️ Enter theory marks');
                        
                        $(this).off('input').on('input', function() {
                            let studentId = $(this).attr('name').match(/\d+/)[0];
                            if ($(`#absent_theory_${studentId}`).is(':checked')) {
                                $(this).val('');
                                $(this).prop('disabled', true);
                                return;
                            }
                            
                            let val = $(this).val();
                            if (val === '' || val === null) {
                                $(this).removeClass('is-invalid');
                                $(this).siblings('.error-message-field-theory').hide();
                            } else {
                                let numVal = parseFloat(val);
                                if (isNaN(numVal) || numVal < 0) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.error-message-field-theory').html('<i class="fas fa-times-circle me-1"></i>Valid number (0-' + formState.max_mark + ')').show();
                                } else if (numVal > formState.max_mark) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.error-message-field-theory').html('<i class="fas fa-exclamation-triangle me-1"></i>Cannot exceed ' + formState.max_mark).show();
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.error-message-field-theory').hide();
                                }
                            }
                        });
                    });
                    
                    // Setup practical mark inputs (only if has practical)
                    if (hasPractical) {
                        $('.obtain-practical-mark-input').each(function() {
                            $(this).prop('readonly', false).removeClass('bg-light');
                            $(this).attr('max', formState.max_practical_mark);
                            $(this).attr('placeholder', '🔬 Enter practical marks');
                            
                            $(this).off('input').on('input', function() {
                                let studentId = $(this).attr('name').match(/\d+/)[0];
                                if ($(`#absent_practical_${studentId}`).is(':checked')) {
                                    $(this).val('');
                                    $(this).prop('disabled', true);
                                    return;
                                }
                                
                                let val = $(this).val();
                                if (val === '' || val === null) {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.error-message-field-practical').hide();
                                } else {
                                    let numVal = parseFloat(val);
                                    if (isNaN(numVal) || numVal < 0) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.error-message-field-practical').html('<i class="fas fa-times-circle me-1"></i>Valid number (0-' + formState.max_practical_mark + ')').show();
                                    } else if (numVal > formState.max_practical_mark) {
                                        $(this).addClass('is-invalid');
                                        $(this).siblings('.error-message-field-practical').html('<i class="fas fa-exclamation-triangle me-1"></i>Cannot exceed ' + formState.max_practical_mark).show();
                                    } else {
                                        $(this).removeClass('is-invalid');
                                        $(this).siblings('.error-message-field-practical').hide();
                                    }
                                }
                            });
                        });
                    }
                    
                    // Load existing marks if any
                    loadExistingMarks();
                }
            });
            
            updateSuggestion();
        }).fail(function(xhr, status, error) {
            console.error("Error loading students:", error);
            console.log("Response text:", xhr.responseText);
            $('#student_list').html(`<tr><td colspan="10" class="text-center text-danger py-4">
                <i class="fas fa-exclamation-triangle me-2"></i>Error loading students. Please try again.
            </td></tr>`);
            updateSuggestion();
        });
    }
    
    $('#markEvaluationForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!formState.subject_id) {
            showToast('Please select a subject before submitting', 'error');
            return false;
        }
        
        let hasError = false;
        let hasAnyMark = false;
        
        // Validate theory marks (only for non-absent students)
        $('.obtain-mark-input').each(function() {
            let studentId = $(this).attr('name').match(/\d+/)[0];
            let isRemoving = $(`#remove_marks_${studentId}`).is(':checked');
            let isAbsent = $(`#absent_theory_${studentId}`).is(':checked');

            if (isRemoving) {
                return;
            }
            
            if (!isAbsent) {
                let val = $(this).val();
                let max = $(this).attr('max');
                
                if (val !== '' && val !== null) {
                    hasAnyMark = true;
                    let numVal = parseFloat(val);
                    if (isNaN(numVal) || numVal < 0) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.error-message-field-theory').html('<i class="fas fa-times-circle me-1"></i>Valid number (0-' + max + ')').show();
                        hasError = true;
                    } else if (numVal > parseFloat(max)) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.error-message-field-theory').html('<i class="fas fa-exclamation-triangle me-1"></i>Cannot exceed ' + max).show();
                        hasError = true;
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).siblings('.error-message-field-theory').hide();
                    }
                }
            } else {
                $(this).val('');
            }
        });
        
        // Validate practical marks (only if subject has practical marks and student is not absent)
        let hasPractical = (formState.has_practical && formState.max_practical_mark > 0);
        if (hasPractical) {
            $('.obtain-practical-mark-input').each(function() {
                let studentId = $(this).attr('name').match(/\d+/)[0];
                let isRemoving = $(`#remove_marks_${studentId}`).is(':checked');
                let isAbsent = $(`#absent_practical_${studentId}`).is(':checked');

                if (isRemoving) {
                    return;
                }
                
                if (!isAbsent) {
                    let val = $(this).val();
                    let max = $(this).attr('max');
                    
                    if (val !== '' && val !== null) {
                        hasAnyMark = true;
                        let numVal = parseFloat(val);
                        if (isNaN(numVal) || numVal < 0) {
                            $(this).addClass('is-invalid');
                            $(this).siblings('.error-message-field-practical').html('<i class="fas fa-times-circle me-1"></i>Valid number (0-' + max + ')').show();
                            hasError = true;
                        } else if (numVal > parseFloat(max)) {
                            $(this).addClass('is-invalid');
                            $(this).siblings('.error-message-field-practical').html('<i class="fas fa-exclamation-triangle me-1"></i>Cannot exceed ' + max).show();
                            hasError = true;
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).siblings('.error-message-field-practical').hide();
                        }
                    }
                } else {
                    $(this).val('');
                }
            });
        }
        
        if (hasError) {
            showToast('Please fix validation errors before submitting', 'error');
            return false;
        }
        
        let formData = $(this).serialize();
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i> Saving...');
        
        $.ajax({
            url: "{{ url('admin/save-student-marks') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    loadExistingMarks();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function(xhr) {
                let message = 'Error saving marks';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showToast(message, 'error');
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Marks');
            }
        });
        
        return false;
    });
    
    updateSuggestion();
});
</script>

@endsection
