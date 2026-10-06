@extends('backend.layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <h4 class="page-title">
            <i class="fas fa-chart-line"></i>
            <span>Student Marks Status Show</span>
        </h4>
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Student Marks Details</h4>
                    <a href="{{ route('student.marks.index', ['exam_id' => $exam_id, 'session_id' => $student->session_id, 'grade_id' => $student->grade_id, 'section_id' => $student->section_id]) }}" class="btn btn-light btn-sm float-end">Back to List</a>
                </div>
                <div class="card-body">
                    <!-- Student Info -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5>Student Information</h5>
                                <div class="row">
                                    <div class="col-md-3"><strong>Name:</strong> {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</div>
                                    <div class="col-md-3"><strong>Admission No:</strong> {{ $student->admission_no }}</div>
                                    <div class="col-md-3"><strong>Roll No:</strong> {{ $student->roll_number ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Exam:</strong> {{ $exam->exam_name ?? '-' }}</div>
                                    <div class="col-md-3"><strong>Session:</strong> {{ $student->session_name }}</div>
                                    <div class="col-md-3"><strong>Grade:</strong> {{ $student->grade_name }}</div>
                                    <div class="col-md-3"><strong>Section:</strong> {{ $student->section_name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h3>{{ $marksData['total_subjects'] }}</h3>
                                    <p>Total Subjects</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h3>{{ $marksData['completed_count'] }}</h3>
                                    <p>Completed Subjects</p>
                                    <small>Have both Max & Obtained Marks</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h3>{{ $marksData['pending_count'] }}</h3>
                                    <p>Pending Subjects</p>
                                    <small>Missing Max or Obtained Marks</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h3>{{ $marksData['overall_percentage'] }}%</h3>
                                    <p>Overall Percentage</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Change Exam -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label>Change Exam</label>
                            <select id="exam_selector" class="form-control">
                                @foreach($exams as $examOption)
                                    <option value="{{ $examOption->id }}" {{ $exam_id == $examOption->id ? 'selected' : '' }}>
                                        {{ $examOption->exam_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Completed Subjects -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5>Completed Subjects ({{ $marksData['completed_count'] }})</h5>
                                    <small>Subjects with both Max & Obtained Marks</small>
                                </div>
                                <div class="card-body">
                                    @if(count($marksData['completed_subjects']) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject</th>
                                                        <th>Obtained</th>
                                                        <th>Max</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach($marksData['completed_subjects'] as $subject)
                                                        <tr>
                                                            <td>{{ $counter++ }}</td>
                                                            <td>{{ $subject['name'] }}</td>
                                                            <td>{{ $subject['obtained'] }}</td>
                                                            <td>{{ $subject['max'] }}</td>
                                                            <td>{{ $subject['percentage'] }}%</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="table-active">
                                                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                                        <td><strong>{{ $marksData['obtained_total'] }}</strong></td>
                                                        <td><strong>{{ $marksData['total_marks'] }}</strong></td>
                                                        <td><strong>{{ $marksData['overall_percentage'] }}%</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">No completed subjects found.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pending Subjects -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h5>Pending Subjects ({{ $marksData['pending_count'] }})</h5>
                                    <small>Subjects missing Max or Obtained Marks</small>
                                </div>
                                <div class="card-body">
                                    @if(count($marksData['pending_subjects']) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach($marksData['pending_subjects'] as $subject)
                                                        <tr>
                                                            <td>{{ $counter++ }}</td>
                                                            <td>{{ $subject['name'] }}</td>
                                                            <td><span class="badge bg-danger">{{ $subject['status'] }}</span></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary enter-marks-btn" 
                                                                        data-subject-id="{{ $subject['subject_id'] }}"
                                                                        data-subject-name="{{ $subject['name'] }}">
                                                                    Enter Marks
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-success">All subjects completed! ✓</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Overall Status -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            @if($marksData['is_complete'])
                                <div class="alert alert-success">
                                    <strong>✓ Complete!</strong> All subjects have both max marks and obtained marks entered.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <strong>⚠ Pending!</strong> {{ $marksData['pending_count'] }} subject(s) missing max marks or obtained marks.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enter Marks Modal -->
<div class="modal fade" id="enterMarksModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Enter Marks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="enterMarksForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="subject_id" id="subject_id">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="session_id" value="{{ $student->session_id }}">
                    <input type="hidden" name="grade_id" value="{{ $student->grade_id }}">
                    <input type="hidden" name="section_id" value="{{ $student->section_id }}">
                    <input type="hidden" name="exam_id" value="{{ $exam_id }}">
                    
                    <div class="mb-3">
                        <label>Subject Name</label>
                        <input type="text" id="subject_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Max Marks</label>
                        <input type="number" name="max_mark" class="form-control" step="any" required>
                    </div>
                    <div class="mb-3">
                        <label>Obtained Marks</label>
                        <input type="number" name="obtained_mark" class="form-control" step="any" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Marks</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('exam_selector').addEventListener('change', function() {
        var examId = this.value;
        var studentId = {{ $student->id }};
        window.location.href = "/admin/student-marks-status/" + studentId + "/" + examId;
    });
    
    // Enter marks functionality
    document.querySelectorAll('.enter-marks-btn').forEach(button => {
        button.addEventListener('click', function() {
            const subjectId = this.dataset.subjectId;
            const subjectName = this.dataset.subjectName;
            
            document.getElementById('subject_id').value = subjectId;
            document.getElementById('subject_name').value = subjectName;
            
            const modal = new bootstrap.Modal(document.getElementById('enterMarksModal'));
            modal.show();
        });
    });
    
    document.getElementById('enterMarksForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("student.marks.enter") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Marks saved successfully!');
                location.reload();
            } else {
                alert('Error saving marks: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error saving marks');
        });
    });
</script>

@endsection