@extends('backend.layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .table thead th {
        background: #228b22;
        color: #fff;
        text-wrap: nowrap;
    }
    .content-wrapper { background: #f4f6f9; min-height: calc(100vh - 120px); }

    .card-custom {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .page-title { 
        font-weight: 700; 
        background: linear-gradient(135deg, #1e293b, #4f46e5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
    }

    .filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }

    .filter-card label {
        color: white;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .filter-card select, .filter-card .form-control {
        border-radius: 10px;
        border: none;
        padding: 10px;
    }

    .chapter-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .chapter-table table {
        margin-bottom: 0;
    }

    .chapter-table thead {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
    }

    .chapter-table thead th {
        padding: 15px;
        font-weight: 600;
        font-size: 13px;
        border: none;
    }

    .chapter-table tbody tr {
        transition: all 0.2s;
        border-bottom: 1px solid #e2e8f0;
    }

    .chapter-table tbody tr:hover {
        background: #f8fafc;
    }

    .chapter-table td {
        padding: 15px;
        vertical-align: middle;
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        border: none;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-save:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-log {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        border: none;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-log:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }

    .remark-input {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 6px 10px;
        font-size: 12px;
    }

    .status-select {
        width: 140px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        background: white;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
    }

    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .select2-container--default .select2-selection--single {
        border-radius: 10px;
        border: none;
        height: 42px;
        padding: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
    }

    .chapter-no {
        font-weight: 700;
        color: #4f46e5;
        background: #eef2ff;
        display: inline-block;
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        border-radius: 10px;
        margin-right: 10px;
    }

    .chapter-name {
        font-weight: 600;
        color: #1e293b;
    }

    .info-message {
        background: #e0f2fe;
        border-left: 4px solid #0284c7;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
    }

    .last-updated {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 5px;
        white-space: nowrap;
    }
    
    .pages-badge {
        background: #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 8px;
        display: inline-block;
    }

    /* DataTable Customization */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 10px 20px;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 12px;
        margin-left: 8px;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 4px 8px;
        margin: 0 5px;
    }
    
    .dataTables_wrapper .paginate_button {
        padding: 6px 12px !important;
        margin: 0 2px !important;
        border-radius: 8px !important;
    }
    
    .dataTables_wrapper .paginate_button.current {
        background: linear-gradient(135deg, #667eea, #764ba2) !important;
        color: white !important;
        border: none !important;
    }

    /* Premium Logs Styling */
    .logs-container {
        padding: 10px;
    }
    
    .log-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .log-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #4f46e5, #10b981, #f59e0b);
    }
    
    .log-item-premium {
        position: relative;
        margin-bottom: 25px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: 1px solid rgba(79, 70, 229, 0.1);
    }
    
    .log-item-premium:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-color: rgba(79, 70, 229, 0.3);
    }
    
    .log-dot {
        position: absolute;
        left: -24px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .log-dot.completed { background: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
    .log-dot.in_progress { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2); }
    .log-dot.not_started { background: #94a3b8; box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.2); }
    
    .log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }
    
    .status-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge-premium i {
        font-size: 14px;
    }
    
    .status-badge-premium.completed {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
    }
    
    .status-badge-premium.in_progress {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
    }
    
    .status-badge-premium.not_started {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        box-shadow: 0 2px 10px rgba(100, 116, 139, 0.3);
    }
    
    .log-date {
        color: #64748b;
        font-size: 12px;
        font-weight: 500;
    }
    
    .log-date i {
        margin-right: 5px;
        color: #4f46e5;
    }
    
    .log-change {
        background: #fef3c7;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        color: #d97706;
        display: inline-block;
        margin: 10px 0;
    }
    
    .log-remarks {
        background: #f1f5f9;
        padding: 10px 15px;
        border-radius: 10px;
        margin: 10px 0;
        border-left: 3px solid #4f46e5;
    }
    
    .log-remarks i {
        color: #4f46e5;
        margin-right: 8px;
    }
    
    .log-user {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e2e8f0;
    }
    
    .user-avatar {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: 600;
    }
    
    .user-name {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .user-role {
        font-size: 10px;
        color: #94a3b8;
    }
    
    .empty-logs {
        text-align: center;
        padding: 50px 20px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 15px;
    }
    
    .empty-logs i {
        font-size: 60px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .log-item-premium-new {
        animation: slideInRight 0.5s ease;
    }

    @media (max-width: 768px) {
        .chapter-table {
            overflow-x: auto;
        }
        .chapter-table table {
            min-width: 800px;
        }
    }
    
    
    
    .dataTables_wrapper .dataTables_length select {
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    padding: 7px 19px;
    margin: 0 5px;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid mt-4">
        <h4 class="page-title">
            <i class="fas fa-book-open me-2"></i>
            Teacher Chapter Status Management
            <small class="text-muted ms-2">Teacher: {{ $teacher->name }}</small>
        </h4>

        <div id="toastContainer"></div>
        <div id="loadingOverlay" class="loading-overlay">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-pulse fa-3x text-primary"></i>
                <p class="mt-2">Loading...</p>
            </div>
        </div>

        <div class="card-custom">
            <div class="filter-card">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label><i class="fas fa-calendar-alt me-2"></i>Session *</label>
                        <select id="session_id" class="form-control select2" required>
                            <option value="">Select Session</option>
                            @foreach($session as $sess)
                                <option value="{{ $sess->id }}">{{ $sess->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label><i class="fas fa-layer-group me-2"></i>Grade *</label>
                        <select id="grade_id" class="form-control select2" required>
                            <option value="">Select Grade</option>
                            @foreach($grade as $g)
                                @if(in_array($g->id, array_keys($selectedMap)))
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label><i class="fas fa-users me-2"></i>Section *</label>
                        <select id="section_id" class="form-control select2" required disabled>
                            <option value="">Select Grade First</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label><i class="fas fa-book me-2"></i>Subject *</label>
                        <select id="subject_id" class="form-control select2" required disabled>
                            <option value="">Select Section First</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="info-message" id="infoMessage">
                <i class="fas fa-info-circle me-2"></i>
                <span id="infoMessageText">Please select all filters to view chapters</span>
            </div>

            <div id="chaptersContainer">
                <div class="chapter-table" style="display: none;">
                    <form id="chapterStatusForm">
                        @csrf
                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                        <input type="hidden" name="session_id" id="form_session_id">
                        <input type="hidden" name="grade_id" id="form_grade_id">
                        <input type="hidden" name="section_id" id="form_section_id">
                        <input type="hidden" name="subject_id" id="form_subject_id">
                        
                        <div class="table-responsive">
                            <table id="chaptersDataTable" class="table table-bordered table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="8%">Chapter No.</th>
                                        <th width="30%">Chapter Name</th>
                                        <th width="15%">Status</th>
                                        <th width="30%">Remarks</th>
                                        <th width="10%">Last Updated</th>
                                        <th width="7%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="chaptersTableBody">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Premium Logs Modal -->
<div class="modal fade" id="logsModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #007bff, #0e996f); color: white; border: none;">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-history me-2"></i>
                        Chapter Status History
                    </h5>
                    <small id="logChapterName" class="text-white-50"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background: #f8fafc; padding: 20px;">
                <div id="logsContent" class="logs-container"></div>
            </div>
            <div class="modal-footer" style="background: white;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let dataTable = null;

$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2').select2({
        width: '100%',
        placeholder: 'Select option'
    });

    let selectedFilters = {
        session_id: null,
        grade_id: null,
        section_id: null,
        subject_id: null
    };

    let sectionsData = @json($selectedMap);
    let teacherId = {{ $teacher->id }};

    function showToast(message, type = 'success') {
        const bgColor = type === 'success' ? '#10b981' : '#ef4444';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const toast = `
            <div class="toast-notification" style="background: ${bgColor}; color: white; border-radius: 12px; padding: 15px 20px; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                <i class="fas ${icon} me-2"></i>
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
            </div>
        `;
        $('#toastContainer').append(toast);
        setTimeout(() => {
            $('.toast-notification').first().fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }

    function showLoading() {
        $('#loadingOverlay').fadeIn(200);
    }

    function hideLoading() {
        $('#loadingOverlay').fadeOut(200);
    }

    function updateInfoMessage() {
        if (!selectedFilters.session_id) {
            $('#infoMessageText').text('Please select a session to continue');
            $('#infoMessage').show();
            return false;
        } else if (!selectedFilters.grade_id) {
            $('#infoMessageText').text('Please select a grade to continue');
            $('#infoMessage').show();
            return false;
        } else if (!selectedFilters.section_id) {
            $('#infoMessageText').text('Please select a section to continue');
            $('#infoMessage').show();
            return false;
        } else if (!selectedFilters.subject_id) {
            $('#infoMessageText').text('Please select a subject to view chapters');
            $('#infoMessage').show();
            return false;
        } else {
            $('#infoMessage').hide();
            return true;
        }
    }

    // Destroy DataTable if exists
    function destroyDataTable() {
        if (dataTable) {
            dataTable.destroy();
            dataTable = null;
        }
    }

    // Initialize DataTable
    function initDataTable() {
        destroyDataTable();
        dataTable = $('#chaptersDataTable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "lengthChange": true,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "zeroRecords": "No matching data found",
                "info": "Showing _START_ to _END_ of _TOTAL_ data",
                "infoEmpty": "No data available",
                "infoFiltered": "(filtered from _MAX_ total data)"
            },
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                   '<"row"<"col-sm-12"tr>>' +
                   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "responsive": true
        });
    }

    $('#session_id').on('change', function() {
        selectedFilters.session_id = $(this).val();
        $('#form_session_id').val(selectedFilters.session_id);
        $('#grade_id').val('').trigger('change');
        $('#section_id').empty().append('<option value="">Select Grade First</option>').prop('disabled', true);
        $('#subject_id').empty().append('<option value="">Select Section First</option>').prop('disabled', true);
        $('.chapter-table').hide();
        destroyDataTable();
        updateInfoMessage();
    });

    $('#grade_id').on('change', function() {
        selectedFilters.grade_id = $(this).val();
        $('#form_grade_id').val(selectedFilters.grade_id);
        
        if (!selectedFilters.grade_id) {
            $('#section_id').empty().append('<option value="">Select Grade First</option>').prop('disabled', true);
            $('#subject_id').empty().append('<option value="">Select Section First</option>').prop('disabled', true);
            $('.chapter-table').hide();
            destroyDataTable();
            updateInfoMessage();
            return;
        }

        showLoading();
        $.ajax({
            url: "{{ url('admin/get-sections') }}/" + selectedFilters.grade_id,
            method: 'GET',
            success: function(sections) {
                let sectionOptions = '<option value="">Select Section</option>';
                sections.forEach(function(section) {
                    if (sectionsData[selectedFilters.grade_id] && sectionsData[selectedFilters.grade_id][section.id]) {
                        sectionOptions += `<option value="${section.id}">${section.name}</option>`;
                    }
                });
                $('#section_id').html(sectionOptions).prop('disabled', false);
                $('#section_id').trigger('change.select2');
                hideLoading();
            },
            error: function() {
                hideLoading();
                showToast('Error loading sections', 'error');
            }
        });
        
        $('#subject_id').empty().append('<option value="">Select Section First</option>').prop('disabled', true);
        $('.chapter-table').hide();
        destroyDataTable();
        updateInfoMessage();
    });

    $('#section_id').on('change', function() {
        selectedFilters.section_id = $(this).val();
        $('#form_section_id').val(selectedFilters.section_id);
        
        if (!selectedFilters.section_id || !selectedFilters.grade_id) {
            $('#subject_id').empty().append('<option value="">Select Section First</option>').prop('disabled', true);
            $('.chapter-table').hide();
            destroyDataTable();
            updateInfoMessage();
            return;
        }

        let subjectIds = sectionsData[selectedFilters.grade_id]?.[selectedFilters.section_id] || [];
        
        if (subjectIds.length === 0) {
            $('#subject_id').empty().append('<option value="">No subjects assigned</option>').prop('disabled', true);
            $('.chapter-table').hide();
            destroyDataTable();
            updateInfoMessage();
            return;
        }

        showLoading();
        $.ajax({
            url: "{{ url('admin/get-subjects-by-ids') }}",
            method: 'GET',
            data: { ids: subjectIds },
            success: function(subjects) {
                let subjectOptions = '<option value="">Select Subject</option>';
                subjects.forEach(function(subject) {
                    subjectOptions += `<option value="${subject.id}">${subject.name}</option>`;
                });
                $('#subject_id').html(subjectOptions).prop('disabled', false);
                $('#subject_id').trigger('change.select2');
                hideLoading();
            },
            error: function() {
                hideLoading();
                showToast('Error loading subjects', 'error');
            }
        });
        
        $('.chapter-table').hide();
        destroyDataTable();
        updateInfoMessage();
    });

    $('#subject_id').on('change', function() {
        selectedFilters.subject_id = $(this).val();
        $('#form_subject_id').val(selectedFilters.subject_id);
        
        if (!selectedFilters.subject_id) {
            $('.chapter-table').hide();
            destroyDataTable();
            updateInfoMessage();
            return;
        }
        
        if (updateInfoMessage()) {
            loadChapters();
        }
    });

    function loadChapters() {
        if (!selectedFilters.subject_id || !selectedFilters.session_id || 
            !selectedFilters.grade_id || !selectedFilters.section_id) {
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: "{{ url('admin/teacher/get-chapters') }}/" + selectedFilters.subject_id + "/" + selectedFilters.grade_id,
            method: 'GET',
            success: function(chapters) {
                if (chapters.length === 0) {
                    $('#chaptersTableBody').html('<tr><td colspan="6" class="text-center">No chapters found for this subject</td></tr>');
                    $('.chapter-table').show();
                    destroyDataTable();
                    hideLoading();
                    return;
                }
                loadExistingStatus(chapters);
            },
            error: function() {
                hideLoading();
                showToast('Error loading chapters', 'error');
            }
        });
    }

    function loadExistingStatus(chapters) {
        let url = "{{ url('admin/teacher/get-chapter-status') }}/" + 
                  teacherId + "/" + 
                  selectedFilters.session_id + "/" + 
                  selectedFilters.grade_id + "/" + 
                  selectedFilters.section_id + "/" + 
                  selectedFilters.subject_id;
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(statuses) {
                renderChaptersTable(chapters, statuses);
                hideLoading();
            },
            error: function() {
                renderChaptersTable(chapters, {});
                hideLoading();
            }
        });
    }

    function renderChaptersTable(chapters, existingStatuses) {
        let html = '';
        
        chapters.forEach(function(chapter) {
            let status = existingStatuses[chapter.id] ? existingStatuses[chapter.id].status : 'not_started';
            let remarks = existingStatuses[chapter.id] ? existingStatuses[chapter.id].remarks : '';
            let lastUpdated = existingStatuses[chapter.id] && existingStatuses[chapter.id].updated_at ? 
                             new Date(existingStatuses[chapter.id].updated_at).toLocaleString() : 'Not updated';
            
            html += `
                <tr>
                    <td>
                        <div>
                            <span class="chapter-no">${chapter.chapter_no}</span>
                            ${chapter.no_of_pages ? `<span class="pages-badge"><i class="fas fa-file-alt me-1"></i>${chapter.no_of_pages}p</span>` : ''}
                        </div>
                    </td>
                    <td><span class="chapter-name">${escapeHtml(chapter.name)}</span></td>
                    <td>
                        <select name="chapter_status[${chapter.id}]" class="status-select" data-chapter-id="${chapter.id}" style="width: 140px;">
                            <option value="not_started" ${status == 'not_started' ? 'selected' : ''}>📖 Not Started</option>
                            <option value="in_progress" ${status == 'in_progress' ? 'selected' : ''}>⚡ In Progress</option>
                            <option value="completed" ${status == 'completed' ? 'selected' : ''}>✅ Completed</option>
                        </select>
                    </td>
                    <td><input type="text" name="remarks[${chapter.id}]" class="remark-input" value="${escapeHtml(remarks)}" placeholder="Optional remarks..." style="width: 100%;"></td>
                    <td><div class="last-updated"><i class="fas fa-clock me-1"></i>${lastUpdated}</div></td>
                    <td>
                        <button type="button" class="btn-save" id="save_btn_${chapter.id}" onclick="saveSingleChapter(${chapter.id})" style="margin-right: 5px;">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="button" class="btn-log" onclick="viewLogs(${chapter.id}, '${escapeHtml(chapter.name)}')">
                            <i class="fas fa-history"></i> Logs
                        </button>
                    </td>
                </tr>
            `;
        });
        
        $('#chaptersTableBody').html(html);
        $('.chapter-table').show();
        
        // Initialize DataTable after rendering
        initDataTable();
        
        // Color status selects based on value
        $('.status-select').each(function() {
            let val = $(this).val();
            if (val === 'completed') {
                $(this).css('background-color', '#ecfdf5');
                $(this).css('border-color', '#6ee7b7');
            } else if (val === 'in_progress') {
                $(this).css('background-color', '#fffbeb');
                $(this).css('border-color', '#fcd34d');
            } else {
                $(this).css('background-color', '#f1f5f9');
                $(this).css('border-color', '#cbd5e1');
            }
        });
        
        // Handle status change color update
        $(document).on('change', '.status-select', function() {
            let val = $(this).val();
            if (val === 'completed') {
                $(this).css('background-color', '#ecfdf5');
                $(this).css('border-color', '#6ee7b7');
            } else if (val === 'in_progress') {
                $(this).css('background-color', '#fffbeb');
                $(this).css('border-color', '#fcd34d');
            } else {
                $(this).css('background-color', '#f1f5f9');
                $(this).css('border-color', '#cbd5e1');
            }
        });
    }

    // Save single chapter
    window.saveSingleChapter = function(chapterId) {
        let status = $(`select[name="chapter_status[${chapterId}]"]`).val();
        let remarks = $(`input[name="remarks[${chapterId}]"]`).val();
        
        let formData = new FormData();
        formData.append('teacher_id', teacherId);
        formData.append('session_id', selectedFilters.session_id);
        formData.append('grade_id', selectedFilters.grade_id);
        formData.append('section_id', selectedFilters.section_id);
        formData.append('subject_id', selectedFilters.subject_id);
        formData.append(`chapter_status[${chapterId}]`, status);
        if (remarks) formData.append(`remarks[${chapterId}]`, remarks);
        
        let saveBtn = $(`#save_btn_${chapterId}`);
        saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i> Saving...');
        
        $.ajax({
            url: "{{ url('admin/teacher/save-chapter-status') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showToast('Chapter status updated successfully!', 'success');
                    loadChapters();
                } else {
                    showToast(response.message, 'error');
                    saveBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save');
                }
            },
            error: function(xhr) {
                let message = 'Error saving chapter status';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showToast(message, 'error');
                saveBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save');
            }
        });
    };

    // View premium colorful logs
    window.viewLogs = function(chapterId, chapterName) {
        let url = "{{ url('admin/teacher/get-chapter-logs') }}/" + 
                  teacherId + "/" + 
                  selectedFilters.session_id + "/" + 
                  selectedFilters.grade_id + "/" + 
                  selectedFilters.section_id + "/" + 
                  selectedFilters.subject_id + "/" + 
                  chapterId;
        
        $('#logChapterName').text(chapterName);
        showLoading();
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(logs) {
                let logsHtml = '<div class="log-timeline">';
                
                if (logs.length === 0) {
                    logsHtml = `
                        <div class="empty-logs">
                            <i class="fas fa-history"></i>
                            <h5 class="mt-3">No History Available</h5>
                            <p class="text-muted">No status changes have been recorded for this chapter yet.</p>
                        </div>
                    `;
                } else {
                    logs.forEach(function(log, index) {
                        let statusClass = log.new_status;
                        let statusIcon = log.new_status === 'completed' ? 'fa-check-circle' : 
                                        (log.new_status === 'in_progress' ? 'fa-chart-line' : 'fa-hourglass-start');
                        let statusText = log.new_status === 'completed' ? 'Completed' : 
                                        (log.new_status === 'in_progress' ? 'In Progress' : 'Not Started');
                        
                        let changeHtml = '';
                        if (log.old_status && log.old_status !== log.new_status) {
                            let oldStatusText = log.old_status === 'completed' ? 'Completed' : 
                                               (log.old_status === 'in_progress' ? 'In Progress' : 'Not Started');
                            changeHtml = `
                                <div class="log-change">
                                    <i class="fas fa-exchange-alt me-1"></i>
                                    Status changed from ${oldStatusText} to ${statusText}
                                </div>
                            `;
                        } else if (!log.old_status && index === logs.length - 1) {
                            changeHtml = `
                                <div class="log-change">
                                    <i class="fas fa-plus-circle me-1"></i>
                                    Initial status set to ${statusText}
                                </div>
                            `;
                        }
                        
                        logsHtml += `
                            <div class="log-item-premium log-item-premium-new" style="animation-delay: ${index * 0.1}s">
                                <div class="log-dot ${log.new_status}"></div>
                                <div class="log-header">
                                    <div class="status-badge-premium ${log.new_status}">
                                        <i class="fas ${statusIcon}"></i>
                                        <span>${statusText}</span>
                                    </div>
                                    <div class="log-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        ${log.formatted_date}
                                    </div>
                                </div>
                                ${changeHtml}
                                ${log.remarks ? `
                                    <div class="log-remarks">
                                        <i class="fas fa-comment-dots"></i>
                                        <strong>Remarks:</strong> ${escapeHtml(log.remarks)}
                                    </div>
                                ` : ''}
                                <div class="log-user">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="user-name">${escapeHtml(log.updated_by_name)}</div>
                                        <div class="user-role">Updated by</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }
                
                logsHtml += '</div>';
                $('#logsContent').html(logsHtml);
                $('#logsModal').modal('show');
                hideLoading();
            },
            error: function() {
                hideLoading();
                showToast('Error loading logs', 'error');
            }
        });
    };

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    updateInfoMessage();
});
</script>

@endsection