@extends('backend.layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .content-wrapper {
        background: #f4f6f9;
        min-height: calc(100vh - 120px);
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
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }
    
    .subject-card {
        background: white;
        border-radius: 15px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .subject-header {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        padding: 15px 20px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .subject-header:hover {
        background: linear-gradient(135deg, #2d3a4e, #1a2332);
    }
    
    .subject-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    
    .progress-section {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .progress-bar-custom {
        height: 30px;
        border-radius: 15px;
        overflow: hidden;
        background: #e2e8f0;
    }
    
    .progress-bar-completed {
        background: linear-gradient(90deg, #10b981, #059669);
        transition: width 0.5s ease;
    }
    
    .progress-bar-inprogress {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    
    .chapter-table {
        padding: 20px;
        display: none;
    }
    
    .chapter-table table {
        margin-bottom: 0;
    }
    
    .badge-completed {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge-inprogress {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge-notstarted {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .chart-container {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
    
    .btn-export {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 10px 25px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }
    
    .select2-container--default .select2-selection--single {
        border-radius: 10px;
        border: none;
        height: 42px;
        padding: 5px;
    }
    
    .overall-progress {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
    }
    
    .overall-progress .stat-value {
        color: white;
    }
    
    .overall-progress .stat-label {
        color: rgba(255,255,255,0.9);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid mt-4">
        <h4 class="page-title">
            <i class="fas fa-chart-line me-2"></i>
            Teacher Chapter Progress Report
        </h4>

        <div id="loadingOverlay" class="loading-overlay">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-pulse fa-3x text-primary"></i>
                <p class="mt-2">Loading Report...</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-card">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label><i class="fas fa-chalkboard-teacher me-2"></i>Select Teacher *</label>
                    <select id="teacher_id" class="form-control select2" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label><i class="fas fa-calendar-alt me-2"></i>Select Session *</label>
                    <select id="session_id" class="form-control select2" required>
                        <option value="">-- Select Session --</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label><i class="fas fa-layer-group me-2"></i>Filter by Grade (Optional)</label>
                    <select id="grade_id" class="form-control select2">
                        <option value="">-- All Grades --</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-end">
                    <button type="button" id="generateReportBtn" class="btn btn-light" style="border-radius: 10px; padding: 10px 30px;">
                        <i class="fas fa-chart-bar me-2"></i>Generate Report
                    </button>
                    <button type="button" id="exportReportBtn" class="btn btn-export ms-2" style="display: none;">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Report Container -->
        <div id="reportContainer" style="display: none;"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let mainChart = null;
let subjectCharts = [];

$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: 'Select option'
    });
    
    $('#generateReportBtn').on('click', function() {
        let teacherId = $('#teacher_id').val();
        let sessionId = $('#session_id').val();
        
        if (!teacherId) {
            showToast('Please select a teacher', 'error');
            return;
        }
        if (!sessionId) {
            showToast('Please select a session', 'error');
            return;
        }
        
        generateReport();
    });
    
    $('#exportReportBtn').on('click', function() {
        let teacherId = $('#teacher_id').val();
        let sessionId = $('#session_id').val();
        let gradeId = $('#grade_id').val();
        
        window.location.href = "{{ url('admin/teacher-chapter-progress-export') }}?teacher_id=" + teacherId + "&session_id=" + sessionId + "&grade_id=" + gradeId;
    });
});

function generateReport() {
    showLoading();
    
    let teacherId = $('#teacher_id').val();
    let sessionId = $('#session_id').val();
    let gradeId = $('#grade_id').val();
    
    $.ajax({
        url: "{{ url('admin/teacher-chapter-progress-data') }}",
        method: 'GET',
        data: {
            teacher_id: teacherId,
            session_id: sessionId,
            grade_id: gradeId
        },
        success: function(response) {
            if (response.success) {
                renderReport(response);
                $('#exportReportBtn').show();
            } else {
                showToast(response.error || 'Error loading report', 'error');
            }
            hideLoading();
        },
        error: function(xhr) {
            hideLoading();
            showToast('Error generating report', 'error');
        }
    });
}

function renderReport(data) {
    let html = `
        <div class="fade-in">
            <!-- Teacher Info -->
            <div class="overall-progress">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-2"><i class="fas fa-chalkboard-teacher me-2"></i>${data.teacher_name}</h3>
                        <p class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Overall Progress Report</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="stat-value">${data.overall.completion_percentage}%</div>
                        <div class="stat-label">Overall Completion</div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-value">${data.overall.total_chapters}</div>
                        <div class="stat-label">Total Chapters</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">${data.overall.completed_chapters}</div>
                        <div class="stat-label">Completed Chapters</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-value">${data.overall.in_progress_chapters}</div>
                        <div class="stat-label">In Progress</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #64748b, #475569); color: white;">
                            <i class="fas fa-hourglass"></i>
                        </div>
                        <div class="stat-value">${data.overall.not_started_chapters}</div>
                        <div class="stat-label">Not Started</div>
                    </div>
                </div>
            </div>
            
            <!-- Pages Statistics -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-value">${data.overall.total_pages}</div>
                        <div class="stat-label">Total Pages</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-value">${data.overall.completed_pages}</div>
                        <div class="stat-label">Completed Pages</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-value">${data.overall.completion_percentage}%</div>
                        <div class="stat-label">Pages Completion Rate</div>
                    </div>
                </div>
            </div>
            
            <!-- Main Chart -->
            <div class="chart-container">
                <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Overall Progress Chart</h5>
                <canvas id="overallChart" style="max-height: 300px;"></canvas>
            </div>
    `;
    
    // Subject-wise reports
    if (data.data.length > 0) {
        html += `<h4 class="mt-4 mb-3"><i class="fas fa-folder-open me-2"></i>Subject-wise Detailed Report</h4>`;
        
        data.data.forEach((subject, index) => {
            let statusColor = subject.completion_percentage >= 80 ? '#10b981' : 
                             (subject.completion_percentage >= 50 ? '#f59e0b' : '#ef4444');
            
            html += `
                <div class="subject-card">
                    <div class="subject-header" onclick="toggleSubject(${index})">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="subject-title">
                                    <i class="fas fa-book me-2"></i>
                                    ${subject.subject_name}
                                </div>
                                <small class="text-white-50">
                                    ${subject.grade_name} - ${subject.section_name}
                                </small>
                            </div>
                            <div class="col-md-3">
                                <div class="progress-bar-custom">
                                    <div class="progress-bar-completed" style="width: ${subject.completion_percentage}%; height: 30px; line-height: 30px; padding-left: 10px; color: white;">
                                        ${subject.completion_percentage}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <i class="fas fa-check-circle me-1"></i> ${subject.completed_chapters}/${subject.total_chapters} Chapters
                            </div>
                            <div class="col-md-2">
                                <i class="fas fa-file-alt me-1"></i> ${subject.completed_pages}/${subject.total_pages} Pages
                            </div>
                            <div class="col-md-1 text-end">
                                <i class="fas fa-chevron-down" id="toggleIcon_${index}"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-section">
                        <canvas id="chart_${index}" style="max-height: 200px;"></canvas>
                    </div>
                    
                    <div class="chapter-table" id="subjectTable_${index}">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th>Chapter No.</th>
                                        <th>Chapter Name</th>
                                        <th>Pages</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${subject.chapters.map(chapter => `
                                        <tr>
                                            <td>${chapter.chapter_no}</td>
                                            <td>${escapeHtml(chapter.chapter_name)}</td>
                                            <td>${chapter.pages}</td>
                                            <td>
                                                <span class="badge-${chapter.status === 'completed' ? 'completed' : (chapter.status === 'in_progress' ? 'inprogress' : 'notstarted')}">
                                                    ${chapter.status === 'completed' ? '<i class="fas fa-check-circle"></i> Completed' : 
                                                      (chapter.status === 'in_progress' ? '<i class="fas fa-chart-line"></i> In Progress' : 
                                                       '<i class="fas fa-hourglass"></i> Not Started')}
                                                </span>
                                            </td>
                                            <td>${escapeHtml(chapter.remarks) || '-'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        html += `<div class="alert alert-info">No data available for selected criteria</div>`;
    }
    
    $('#reportContainer').html(html).fadeIn();
    
    // Initialize Overall Chart
    const ctx = document.getElementById('overallChart').getContext('2d');
    if (mainChart) mainChart.destroy();
    
    mainChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Not Started'],
            datasets: [{
                data: [data.overall.completed_pages, data.overall.in_progress_pages, data.overall.not_started_pages],
                backgroundColor: ['#10b981', '#f59e0b', '#64748b'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12, weight: 'bold' },
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} pages (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // Initialize subject charts
    subjectCharts.forEach(chart => {
        if (chart) chart.destroy();
    });
    subjectCharts = [];
    
    data.data.forEach((subject, index) => {
        const canvas = document.getElementById(`chart_${index}`);
        if (canvas) {
            const ctx2 = canvas.getContext('2d');
            const chart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Completed', 'In Progress', 'Not Started'],
                    datasets: [{
                        label: 'Pages',
                        data: [subject.completed_pages, subject.in_progress_pages, subject.not_started_pages],
                        backgroundColor: ['#10b981', '#f59e0b', '#64748b'],
                        borderRadius: 10,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw} pages`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Number of Pages', font: { weight: 'bold' } }
                        }
                    }
                }
            });
            subjectCharts.push(chart);
        }
    });
}

function toggleSubject(index) {
    $('#subjectTable_' + index).slideToggle(300);
    let icon = $('#toggleIcon_' + index);
    if (icon.hasClass('fa-chevron-down')) {
        icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
    } else {
        icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
    }
}

function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const toast = `
        <div class="toast-notification" style="position: fixed; top: 20px; right: 20px; z-index: 10000; background: ${bgColor}; color: white; border-radius: 12px; padding: 15px 20px; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); animation: slideIn 0.3s ease;">
            <i class="fas ${icon} me-2"></i>
            <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
        </div>
    `;
    $('body').append(toast);
    setTimeout(() => {
        $('.toast-notification').fadeOut(300, function() { $(this).remove(); });
    }, 3000);
}

function showLoading() {
    $('#loadingOverlay').fadeIn(200);
}

function hideLoading() {
    $('#loadingOverlay').fadeOut(200);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Add animation keyframes
$('head').append(`
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
`);
</script>

@endsection