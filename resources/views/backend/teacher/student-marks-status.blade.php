@extends('backend.layouts.app')

@section('content')

<style>

.subject-box{
display:inline-block;
background:#f5f5f5;
border:1px solid #ddd;
padding:3px 8px;
margin:2px;
border-radius:20px;
font-size:12px;
}

.subject-wrap{
line-height:28px;
}

.badge-success{
background:#28a745;
padding:7px 12px;
}

.badge-warning{
background:#ffc107;
color:#000;
padding:7px 12px;
}

.table .thead-dark th {
    color: #fff;
    background-color: #029b69;
    border-color: #4d4e4e;
}


.action-buttons-cell {
    white-space: nowrap;
}

.btn-marksheet {
    background: linear-gradient(135deg, #029b69, #0284c7);
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-marksheet:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(2, 155, 105, 0.3);
    color: white;
}

.btn-marksheet i {
    font-size: 12px;
}

.dropdown-btn {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    min-width: 160px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 10px;
    overflow: hidden;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    font-size: 13px;
    transition: all 0.2s ease;
}

.btn.btn-primary {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    padding: 7px;
    display: inline-block;
}

.dropdown-content a:hover {
    background-color: #f5f5f5;
}

.dropdown-btn:hover .dropdown-content {
    display: block;
}

/* Step Wizard Styles */
.step-wizard-bar {
    background: #f8fafc;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 25px;
    border: 1px solid #e2e8f0;
}

.steps-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.steps-wrapper::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 60px;
    right: 60px;
    height: 2px;
    background: linear-gradient(90deg, #e2e8f0, #cbd5e1, #e2e8f0);
    z-index: 1;
}

.step-indicator {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}

.step-number {
    width: 50px;
    height: 50px;
    background: white;
    border: 2px solid #cbd5e1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    font-size: 18px;
    font-weight: bold;
    color: #94a3b8;
    transition: all 0.3s ease;
}

.step-name {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
}

.step-indicator.completed .step-number {
    background: #029b69;
    border-color: #029b69;
    color: white;
    position: relative;
}

.step-indicator.completed .step-number::after {
    content: '✓';
    font-size: 20px;
}

.step-indicator.completed .step-name {
    color: #029b69;
}

.step-indicator.active .step-number {
    border-color: #029b69;
    color: #029b69;
    background: white;
    box-shadow: 0 0 0 4px rgba(2, 155, 105, 0.2);
}

.step-indicator.active .step-name {
    color: #029b69;
    font-weight: 700;
}

.step-message-box {
    margin-top: 15px;
    padding: 10px 15px;
    background: #f0fdf4;
    border-radius: 10px;
    border-left: 4px solid #029b69;
}

/* Table Blur Loader Styles - Enhanced */
.table-loading-overlay {
    position: relative;
}

.table-loading-overlay.loading {
    position: relative;
}

.table-loading-overlay.loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    z-index: 100;
    border-radius: 12px;
    transition: all 0.3s ease;
}

/* Blur Loader Specific Styles */
.table-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 101;
    display: none;
    text-align: center;
    background: white;
    padding: 30px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    min-width: 280px;
}

.table-loading-overlay.loading .table-loader {
    display: block;
}

.table-loader-animation {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
}

.table-loader-animation img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}

.table-loader-text {
    font-size: 16px;
    font-weight: 600;
    color: #029b69;
    margin-top: 15px;
}

.table-loader-subtext {
    font-size: 12px;
    color: #64748b;
    margin-top: 8px;
}

/* Original Loader Styles (kept for backward compatibility) */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loader-overlay.active {
    opacity: 1;
    visibility: visible;
}

.loader-container {
    background: white;
    border-radius: 20px;
    padding: 40px 50px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: scaleIn 0.3s ease;
    min-width: 350px;
}

@keyframes scaleIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.loader-animation {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
}

.loader-animation .circle {
    position: absolute;
    border: 4px solid transparent;
    border-radius: 50%;
    animation: rotate var(--duration) linear infinite;
}

.loader-animation .circle:nth-child(1) {
    width: 80px;
    height: 80px;
    border-top-color: #029b69;
    border-left-color: #029b69;
    --duration: 1s;
}

.loader-animation .circle:nth-child(2) {
    width: 60px;
    height: 60px;
    top: 10px;
    left: 10px;
    border-right-color: #ffc107;
    border-bottom-color: #ffc107;
    --duration: 1.5s;
}

.loader-animation .circle:nth-child(3) {
    width: 40px;
    height: 40px;
    top: 20px;
    left: 20px;
    border-top-color: #17a2b8;
    border-right-color: #17a2b8;
    --duration: 0.8s;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.loader-progress {
    margin: 25px 0 20px;
}

.progress-bar-container {
    width: 100%;
    height: 4px;
    background: #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #029b69, #28a745);
    width: 0%;
    transition: width 0.1s linear;
    border-radius: 4px;
}

/* Modal Styles */
.marksheet-modal {
    display: none;
    position: fixed;
    z-index: 10001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.8);
    overflow: auto;
}

.marksheet-modal-content {
    background-color: white;
    margin: 2% auto;
    padding: 0;
    width: 95%;
    max-width: 1100px;
    border-radius: 15px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: modalopen 0.3s ease;
}

@keyframes modalopen {
    from { opacity: 0; transform: translateY(-50px); }
    to { opacity: 1; transform: translateY(0); }
}

.marksheet-modal-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, #029b69, #0284c7);
    color: white;
    border-radius: 15px 15px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.marksheet-modal-body {
    padding: 20px;
    max-height: 80vh;
    overflow-y: auto;
    background: #f4f6f9;
}

.marksheet-modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #e2e8f0;
    text-align: right;
    background: white;
    border-radius: 0 0 15px 15px;
}

.btn-print-marksheet {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-close-modal {
    background: #64748b;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    margin-left: 10px;
}

/* Bulk Actions */
.bulk-actions {
    margin-bottom: 15px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.bulk-actions .btn-group {
    display: flex;
    gap: 10px;
}

.btn-bulk {
    background: linear-gradient(135deg, #029b69, #0284c7);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.btn-bulk:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-bulk:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(2, 155, 105, 0.3);
}

.checkbox-select-all {
    transform: scale(1.2);
    cursor: pointer;
}

.validation-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    min-width: 320px;
    background: white;
    border-radius: 12px;
    padding: 12px 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: slideInRight 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    border-left: 4px solid;
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

/* Subject name tooltip/popup styles - FIXED VERSION */
.subject-info {
    cursor: pointer;
    border-bottom: 1px dashed #999;
    position: relative;
    display: inline-block;
}

.subject-tooltip {
    visibility: hidden;
    background-color: #333;
    color: #fff;
    text-align: left;
    border-radius: 8px;
    padding: 8px 12px;
    position: absolute;
    z-index: 1000;
    bottom: 125%;
    left: 0;
    min-width: 200px;
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 12px;
    font-weight: normal;
    white-space: normal;
    word-wrap: break-word;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    pointer-events: auto;
}

/* Keep tooltip visible when hovering over subject-info OR the tooltip itself */
.subject-info:hover .subject-tooltip,
.subject-tooltip:hover {
    visibility: visible;
    opacity: 1;
}

/* Add a small gap between text and tooltip to prevent flickering */
.subject-info::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 10px;
    background: transparent;
}

.subject-list {
    max-height: 200px;
    overflow-y: auto;
}

.subject-list-item {
    padding: 3px 0;
    border-bottom: 1px solid #444;
}

.subject-list-item:last-child {
    border-bottom: none;
}

/* Column styles for subject names */
.subjects-column {
    min-width: 180px;
}

.subject-completed {
    color: #28a745;
}

.subject-pending {
    color: #ffc107;
}

/* Responsive table styles */
@media (max-width: 768px) {
    .subjects-column {
        min-width: 150px;
    }
}

/* Table container animation */
.table-container {
    transition: all 0.3s ease;
}
</style>

<div class="content-wrapper">
<div class="container-fluid">

<div class="card mt-3">
<div class="card-header bg-primary text-white">
<h4 class="mb-0">Student Marks Grade 1 To Grade 10 & Parental Guidance Status</h4>
</div>
<div class="card-body">

<!-- Step Wizard Bar -->
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
        <div class="step-indicator" data-step="3">
            <div class="step-number">3</div>
            <div class="step-name">Section</div>
        </div>
        <div class="step-indicator" data-step="4">
            <div class="step-number">4</div>
            <div class="step-name">Exam</div>
        </div>
    </div>
    <div class="step-message-box" id="stepMessage">
        <i class="fa fa-info-circle"></i>
        <span class="step-message-text" id="stepMessageText">★ Step 1: Select a session first</span>
    </div>
</div>

<form method="GET" action="{{ route('student.marks.index') }}" id="filterForm">
<div class="row align-items-end">
<div class="col-md-2">
<label>Session <span class="text-danger">*</span></label>
<select name="session_id" class="form-control filter-input step-field select2" data-step="1">
<option value="">Select Session</option>
@foreach($sessions as $session)
<option value="{{$session->id}}" {{$session_id==$session->id ? 'selected' : ''}}>{{$session->name}}</option>
@endforeach
</select>
</div>
<div class="col-md-2">
<label>Grade <span class="text-danger">*</span></label>
<select name="grade_id" id="grade_id" class="form-control filter-input step-field select2" data-step="2">
<option value="">Select Grade</option>
@foreach($grades as $grade)
<option value="{{$grade->id}}" {{$grade_id==$grade->id ? 'selected' : ''}}>{{$grade->name}}</option>
@endforeach
</select>
</div>
<div class="col-md-2">
<label>Section <span class="text-danger">*</span></label>
<select name="section_id" id="section_id" class="form-control filter-input step-field select2" data-step="3">
<option value="">Select Section</option>
@if(!empty($sections))
@foreach($sections as $section)
<option value="{{$section->id}}" {{$section_id==$section->id ? 'selected' : ''}}>{{$section->name}}</option>
@endforeach
@endif
</select>
</div>
<div class="col-md-2">
<label>Exam <span class="text-danger">*</span></label>
<select name="exam_id" class="form-control filter-input step-field select2" data-step="4">
<option value="">Select Exam</option>
@foreach($exams as $exam)
<option value="{{$exam->id}}" {{$exam_id==$exam->id ? 'selected' : ''}}>{{$exam->exam_name}}</option>
@endforeach
</select>
</div>
<div class="col-md-4">
<button type="submit" class="btn btn-primary" id="fetchReportBtn"><i class="fa fa-search"></i> Fetch Report</button>
<a href="{{ route('student.marks.index') }}" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
</div>
</div>
</form>

<div class="table-responsive mt-4">
    <div class="table-container" id="tableContainer">
        <!-- Table Loader Overlay -->
        <div class="table-loading-overlay" id="tableLoadingOverlay">
            <div class="table-loader">
                <div class="table-loader-animation">
                    <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading...">
                </div>
                <div class="table-loader-text">Loading Data...</div>
                <div class="table-loader-subtext">Please wait while we fetch the marks status</div>
            </div>
            <div id="tableContent">
                @if($exam_id && $section_id && $grade_id && $session_id)
                    @if(count($students) > 0)
                    <div class="bulk-actions">
                        <div>
                            <input type="checkbox" id="selectAllCheckbox" class="checkbox-select-all">
                            <label for="selectAllCheckbox" style="margin-left: 5px;">Select All</label>
                            <span id="selectedCount" style="margin-left: 10px; color: #029b69; font-weight: bold;"></span>
                        </div>
                        <div class="btn-group">
                            <button type="button" id="bulkMarksheetBtn" class="btn-bulk" disabled>
                                <i class="fa fa-file-alt"></i> Generate Marksheets
                            </button>
                            <button type="button" id="bulkPrintBtn" class="btn-bulk" disabled>
                                <i class="fa fa-print"></i> Bulk Print
                            </button>
                      
                        </div>
                    </div>
                    @endif

                    <table class="table table-bordered table-striped" id="studentsTable">
                    <thead class="thead-dark">
                    <tr>
                    <th style="width: 30px;"><input type="checkbox" id="selectAllCheckboxTable" class="checkbox-select-all"></th>
                    <th>#</th>
                    <th>Admission No</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th class="subjects-column">Total Subjects</th>
                    <th class="subjects-column">Completed</th>
                    <th class="subjects-column">Pending</th>
                    <th>Status</th>
                    <th>Marksheet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i=1; @endphp
                    @foreach($students as $student)
                    @php $rowData=$studentsData[$student->id]??null; @endphp
                    <tr>
                    <td style="text-align: center;">
                        <input type="checkbox" class="student-checkbox" 
                               data-student-id="{{$student->id}}" 
                               data-student-name="{{$student->first_name}} {{$student->last_name}}"
                               {{ ($rowData && ($rowData['can_generate_marksheet'] ?? false)) ? '' : 'disabled' }}>
                    </td>
                    <td>{{$i++}}</td>
                    <td>{{$student->admission_no}}</td>
                    <td>{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}<br><small class="text-muted">Roll: {{$student->roll_number ?? 'N/A'}}</small></td>
                    <td>{{$student->grade_name}}</td>
                    <td>{{$student->section_name ?? '-'}}</td>
                    
                    <!-- Total Subjects with Names -->
                   <td class="subjects-column">
                        @if($rowData)
                            <div class="subject-info">
                                <b>{{$rowData['total_subjects']}} Subjects</b>
                                <div class="subject-tooltip">
                                    <strong>Included Subjects:</strong>
                                    <div class="subject-list">
                                        @foreach($rowData['total_subject_names'] as $subjectName)
                                            <div class="subject-list-item">📚 {{$subjectName}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if(isset($rowData['excluded_count']) && $rowData['excluded_count'] > 0)
                            <div style="margin-top:4px;">
                                <span style="display:inline-block;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;border-radius:20px;padding:2px 8px;font-size:10px;font-weight:700;position:relative;" class="subject-info">
                                    ✗ {{$rowData['excluded_count']}} Excluded
                                    <div class="subject-tooltip">
                                        <strong style="color:#fca5a5;">Excluded from Marks:</strong>
                                        <div class="subject-list">
                                            @foreach($rowData['excluded_subjects'] as $excName)
                                                <div class="subject-list-item">✗ {{$excName}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </span>
                            </div>
                            @endif
                        @endif
                    </td>
                    
                    <!-- Completed Subjects with Names -->
                    <td class="subjects-column">
                        @if($rowData)
                            @if($rowData['completed_count'] > 0)
                                <div class="subject-info subject-completed">
                                    <b class="text-success">{{$rowData['completed_count']}} Subjects</b>
                                    <div class="subject-tooltip">
                                        <strong>Completed Subjects:</strong>
                                        <div class="subject-list">
                                            @foreach($rowData['completed_subjects'] as $subjectName)
                                                <div class="subject-list-item">✅ {{$subjectName}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <b class="text-muted">0 Subjects</b>
                            @endif
                        @endif
                    </td>
                    
                    <!-- Pending Subjects with Names -->
                    <td class="subjects-column">
                        @if($rowData)
                            @if(($rowData['required_pending_count'] ?? 0) > 0)
                                <div class="subject-info subject-pending">
                                    <b class="text-warning">{{$rowData['required_pending_count']}} Pending</b>
                                    <div class="subject-tooltip">
                                        <strong>Compulsory Pending:</strong>
                                        <div class="subject-list">
                                            @foreach($rowData['required_pending_subjects'] as $subjectName)
                                                <div class="subject-list-item">⏳ {{$subjectName}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(($rowData['optional_pending_count'] ?? 0) > 0)
                                <div class="subject-info" style="display:block;margin-top:4px;color:#0284c7;">
                                    <b>{{$rowData['optional_pending_count']}} Optional Pending</b>
                                    <div class="subject-tooltip">
                                        <strong>Optional Pending Subjects:</strong>
                                        <div class="subject-list">
                                            @foreach($rowData['optional_pending_subjects'] as $subjectName)
                                                <div class="subject-list-item">{{$subjectName}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($rowData['pending_count'] == 0)
                                <b class="text-muted">0 Subjects</b>
                            @endif
                        @endif
                    </td>
                    
                    <td>
                        @if($rowData)
                            @if(($rowData['can_generate_marksheet'] ?? false) && ($rowData['optional_pending_count'] ?? 0) > 0)
                                <span class="badge badge-info">Optional Pending</span>
                            @else
                            @if($rowData['is_complete'])
                                <span class="badge badge-success">✓ Complete</span>
                            @else
                                <span class="badge badge-warning">⏳ Pending</span>
                            @endif
                            @endif
                        @endif
                    </td>
                    <td class="action-buttons-cell">
                        @if($rowData && ($rowData['can_generate_marksheet'] ?? false))
                        <div class="dropdown-btn">
                            <button class="btn-marksheet" onclick="generateMarksheet({{$student->id}}, {{$exam_id}})">
                                <i class="fa fa-file-alt"></i> Marksheet
                            </button>
                            <div class="dropdown-content">
                                <a href="javascript:void(0)" onclick="generateMarksheet({{$student->id}}, {{$exam_id}})"><i class="fa fa-eye"></i> View Marksheet</a>
                                <a href="javascript:void(0)" onclick="printMarksheet({{$student->id}}, {{$exam_id}})"><i class="fa fa-print"></i> Print Marksheet</a>
                            </div>
                        </div>
                        @else
                        <button class="btn btn-secondary btn-sm" disabled style="opacity:0.5;"><i class="fa fa-lock"></i> Not Available</button>
                        @endif
                    </td>
                    </tr>
                    @endforeach
                    @if(count($students)==0)
                    <tr><td colspan="12" class="text-center">No students found for selected criteria</td></tr>
                    @endif
                    </tbody>
                    </table>
                @else
                <div class="alert alert-info mt-4"><i class="fa fa-info-circle"></i> Please select Session, Grade, Section, and Exam to view marks status</div>
                @endif
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- Marksheet Modal -->
<div id="marksheetModal" class="marksheet-modal">
    <div class="marksheet-modal-content">
        <div class="marksheet-modal-header">
            <h3><i class="fa fa-file-alt"></i> Student Marksheet</h3>
            <span class="close-marksheet-modal">&times;</span>
        </div>
        <div class="marksheet-modal-body" id="marksheetModalBody">
            <div style="text-align: center; padding: 50px;"><i class="fa fa-spinner fa-pulse fa-3x"></i><p>Loading marksheet...</p></div>
        </div>
        <div class="marksheet-modal-footer">
            <button class="btn-print-marksheet" id="printMarksheetBtn"><i class="fa fa-print"></i> Print</button>
            <button class="btn-close-modal" id="closeModalBtn"><i class="fa fa-times"></i> Close</button>
        </div>
    </div>
</div>

<!-- Full Page Loader (kept for backward compatibility) -->
<div class="loader-overlay" id="loaderOverlay">
    <div class="loader-container">
        <div class="loader-animation"><div class="circle"></div><div class="circle"></div><div class="circle"></div></div>
        <div class="loader-progress"><div class="progress-bar-container"><div class="progress-bar-fill" id="progressFill"></div></div></div>
        <div class="loader-message">
            <div class="loader-main-text" id="loaderMainText"><i class="fa fa-spinner fa-pulse"></i> Fetching Your Report</div>
            <div class="loader-sub-text" id="loaderSubText">Please wait while we prepare your marks status</div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Global variables
let currentStudentId = null;
let currentExamId = null;
let isLoading = false;

$(function(){
    // Initially hide the table loader if content is already loaded
    if($('#tableContent').children().length > 0) {
        $('#tableLoadingOverlay').removeClass('loading');
    } else {
        // If no content but filters are selected, show loader
        if(hasFiltersSelected()) {
            showTableLoader();
        }
    }
    
    // Initialize bulk actions
    initializeBulkActions();
    
    // Step wizard functions
    function updateStepWizard() {
        var session = $('select[name="session_id"]').val();
        var grade = $('#grade_id').val();
        var section = $('#section_id').val();
        var exam = $('select[name="exam_id"]').val();
        
        var currentStep = 1;
        if(session && session !== '') currentStep = 2;
        if(grade && grade !== '') currentStep = 3;
        if(section && section !== '') currentStep = 4;
        if(exam && exam !== '') currentStep = 5;
        
        $('.step-indicator').each(function() {
            var step = parseInt($(this).data('step'));
            $(this).removeClass('active completed');
            if(step < currentStep) $(this).addClass('completed');
            else if(step === currentStep) $(this).addClass('active');
        });
    }
    
    function loadSections(grade_id, selected = ''){
        if(grade_id && grade_id !== ''){
            $('#section_id').html('<option>Loading...</option>');
            $.ajax({
                url: "{{ route('get-sections-by-grade') }}",
                type: 'GET',
                data: { grade_id: grade_id },
                success: function(res){
                    var html = '<option value="">Select Section</option>';
                    if(res && res.length > 0){
                        $.each(res, function(i, row){
                            var sel = (selected == row.id) ? 'selected' : '';
                            html += '<option '+sel+' value="'+row.id+'">'+row.name+'</option>';
                        });
                    } else {
                        html = '<option value="">No sections available</option>';
                    }
                    $('#section_id').html(html);
                    updateStepWizard();
                },
                error: function(){
                    $('#section_id').html('<option value="">Error loading sections</option>');
                }
            });
        } else {
            $('#section_id').html('<option value="">Select Section</option>');
            updateStepWizard();
        }
    }
    
    $('#grade_id').change(function(){
        var gradeId = $(this).val();
        if(gradeId && gradeId !== '') loadSections(gradeId);
        else $('#section_id').html('<option value="">Select Section</option>');
        updateStepWizard();
    });
    
    $('.step-field').on('change', updateStepWizard);
    
    $('select[name="exam_id"]').on('change', function(){
        updateStepWizard();
        var examId = $(this).val();
        var sessionId = $('select[name="session_id"]').val();
        var gradeId = $('#grade_id').val();
        var sectionId = $('#section_id').val();
        if(examId && sessionId && gradeId && sectionId) {
            showTableLoader();
            $('#filterForm').submit();
        }
    });
    
    // Handle form submission with loader
    $('#filterForm').on('submit', function(e){
        if(!hasFiltersSelected()) {
            e.preventDefault();
            showToast('Selection Required', 'Please select Session, Grade, Section, and Exam', 'error');
            return;
        }
        showTableLoader();
    });
    
    // Handle Fetch Report button click
    $('#fetchReportBtn').on('click', function(e) {
        if(!hasFiltersSelected()) {
            e.preventDefault();
            showToast('Selection Required', 'Please select Session, Grade, Section, and Exam', 'error');
            return false;
        }
        showTableLoader();
        return true;
    });
    
    @if($grade_id) loadSections("{{$grade_id}}", "{{$section_id ?? ''}}"); @endif
    updateStepWizard();
});

// Function to show table blur loader
function showTableLoader() {
    $('#tableLoadingOverlay').addClass('loading');
}

// Function to hide table blur loader
function hideTableLoader() {
    $('#tableLoadingOverlay').removeClass('loading');
}

// Show loader when page is loading/refreshing
$(window).on('load', function() {
    if($('#tableContent').children().length > 0) {
        hideTableLoader();
    }
});

// Hide loader when page is fully loaded
$(document).ready(function() {
    setTimeout(function() {
        if($('#tableContent').children().length > 0 && !hasFiltersSelected()) {
            hideTableLoader();
        }
    }, 500);
});

// Listen for AJAX start and stop events
$(document).ajaxStart(function() {
    if(hasFiltersSelected()) {
        showTableLoader();
    }
}).ajaxStop(function() {
    setTimeout(function() {
        hideTableLoader();
        initializeBulkActions();
        updateSelectedCount();
    }, 300);
});

// Initialize bulk actions function
function initializeBulkActions() {
    
    $(document).off('click', '#selectAllCheckbox, #selectAllCheckboxTable');
    $(document).off('change', '#selectAllCheckbox, #selectAllCheckboxTable');
    
    $(document).on('click', '#selectAllCheckbox, #selectAllCheckboxTable', function(e) {
        var isChecked = $(this).prop('checked');
        $('.student-checkbox:enabled').prop('checked', isChecked);
        updateSelectedCount();
    });
    
    $(document).off('change', '.student-checkbox');
    $(document).on('change', '.student-checkbox', function() {
        updateSelectedCount();
    });
    
    // Bulk Generate Button — UNCHANGED
    $(document).off('click', '#bulkMarksheetBtn');
    $(document).on('click', '#bulkMarksheetBtn', function() {
        let selectedStudents = getSelectedStudents();
        let examId = {{ $exam_id ?? 0 }};
        
        if(selectedStudents.length === 0) {
            showToast('No Selection', 'Please select at least one student', 'error');
            return;
        }
        
        if(selectedStudents.length === 1) {
            generateMarksheet(selectedStudents[0].id, examId);
        } else {
            let message = 'Generate marksheets for ' + selectedStudents.length + ' students?\n\n';
            selectedStudents.slice(0, 5).forEach(function(s) {
                message += '• ' + s.name + '\n';
            });
            if(selectedStudents.length > 5) message += '... and ' + (selectedStudents.length - 5) + ' more';
            
            if(confirm(message)) {
                showToast('Bulk Generation', 'Opening ' + selectedStudents.length + ' marksheets', 'info');
                selectedStudents.forEach(function(student, index) {
                    setTimeout(function() {
                        generateMarksheet(student.id, examId);
                    }, index * 500);
                });
            }
        }
    });
    
    // ── Bulk Print Button — UPDATED: single window, pagewise marksheets ──
    $(document).off('click', '#bulkPrintBtn');
    $(document).on('click', '#bulkPrintBtn', function() {
        let selectedStudents = getSelectedStudents();
        let examId = {{ $exam_id ?? 0 }};
        
        if(selectedStudents.length === 0) {
            showToast('No Selection', 'Please select at least one student', 'error');
            return;
        }
        
        if(selectedStudents.length === 1) {
            // Single student — existing behaviour unchanged
            printMarksheet(selectedStudents[0].id, examId);
        } else {
            // Multiple students — ek hi window, pagewise separated
            let studentIds = selectedStudents.map(function(s) { return s.id; }).join(',');
            let bulkUrl = '/student-marksheet/bulk-print?student_ids=' + studentIds + '&exam_id=' + examId;
            
            if(confirm('Print marksheets for ' + selectedStudents.length + ' students in a single window?')) {
                showToast('Bulk Print', 'Opening ' + selectedStudents.length + ' marksheets in one window...', 'success');
                window.open(bulkUrl, '_blank');
            }
        }
    });
}

// Helper function to check if filters are selected
function hasFiltersSelected() {
    var session = $('select[name="session_id"]').val();
    var grade = $('#grade_id').val();
    var section = $('#section_id').val();
    var exam = $('select[name="exam_id"]').val();
    return (session && session !== '' && grade && grade !== '' && section && section !== '' && exam && exam !== '');
}

// Get selected students
function getSelectedStudents() {
    let selected = [];
    $('.student-checkbox:enabled:checked').each(function() {
        selected.push({
            id: $(this).data('student-id'),
            name: $(this).data('student-name')
        });
    });
    return selected;
}

// Update selected count and button states
function updateSelectedCount() {
    let selectedCount = $('.student-checkbox:enabled:checked').length;
    let totalEnabled = $('.student-checkbox:enabled').length;
    
    $('#selectedCount').text(selectedCount + ' selected');
    
    let allChecked = (selectedCount === totalEnabled && totalEnabled > 0);
    $('#selectAllCheckbox, #selectAllCheckboxTable').prop('checked', allChecked);
    
    if(selectedCount > 0) {
        $('#bulkMarksheetBtn, #bulkPrintBtn').prop('disabled', false);
        $('#bulkMarksheetBtn').html('<i class="fa fa-file-alt"></i> Generate Marksheets (' + selectedCount + ')');
        $('#bulkPrintBtn').html('<i class="fa fa-print"></i> Bulk Print (' + selectedCount + ')');
    } else {
        $('#bulkMarksheetBtn, #bulkPrintBtn').prop('disabled', true);
        $('#bulkMarksheetBtn').html('<i class="fa fa-file-alt"></i> Generate Marksheets');
        $('#bulkPrintBtn').html('<i class="fa fa-print"></i> Bulk Print');
    }
}

// Marksheet Functions — UNCHANGED
function generateMarksheet(studentId, examId) {
    currentStudentId = studentId;
    currentExamId = examId;
    
    $('#marksheetModal').fadeIn(300);
    $('#marksheetModalBody').html('<div style="text-align: center; padding: 50px;"><i class="fa fa-spinner fa-pulse fa-3x"></i><p>Loading marksheet...</p></div>');
    
    $.ajax({
        url: '/student-marksheet/' + studentId + '/' + examId,
        type: 'GET',
        success: function(response) {
            $('#marksheetModalBody').html(response);
        },
        error: function(xhr) {
            $('#marksheetModalBody').html('<div style="text-align: center; padding: 50px; color: red;"><i class="fa fa-exclamation-triangle fa-3x"></i><p>Error loading marksheet. Please try again.</p></div>');
        }
    });
}

function printMarksheet(studentId, examId) {
    var printUrl = '/student-marksheet/print/' + studentId + '/' + examId;
    window.open(printUrl, '_blank');
}

// Modal close
$(document).on('click', '.close-marksheet-modal, #closeModalBtn', function() {
    $('#marksheetModal').fadeOut(300);
    $('#marksheetModalBody').html('');
});

$(document).on('click', '#printMarksheetBtn', function() {
    if(currentStudentId && currentExamId) printMarksheet(currentStudentId, currentExamId);
});

$(window).on('click', function(event) {
    if($(event.target).is('#marksheetModal')) {
        $('#marksheetModal').fadeOut(300);
        $('#marksheetModalBody').html('');
    }
});

// Toast notification
function showToast(title, message, type = 'info') {
    let icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
    let borderColor = type === 'success' ? '#28a745' : (type === 'error' ? '#dc3545' : '#17a2b8');
    
    var toastHtml = '<div class="validation-toast" style="border-left-color: ' + borderColor + '"><div class="toast-icon">' + icon + '</div><div class="toast-content"><div class="toast-title">' + title + '</div><div class="toast-message">' + message + '</div></div></div>';
    $('body').append(toastHtml);
    setTimeout(function() { $('.validation-toast').fadeOut(400, function() { $(this).remove(); }); }, 3000);
}

// Re-initialize after AJAX load
$(document).ajaxComplete(function() {
    initializeBulkActions();
    updateSelectedCount();
    setTimeout(function() {
        hideTableLoader();
    }, 200);
});
</script>

@endsection
