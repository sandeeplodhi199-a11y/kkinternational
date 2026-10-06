@extends('backend.layouts.app')
@section('content')

<style>
:root {
    --primary: #2563eb;
    --bg: #f4f7fb;
    --card: #ffffff;
    --text: #1f2937;
}

body {
    background: var(--bg);
    color: var(--text)
}

.card-ui {
    background: var(--card);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .08)
}

.card-header-ui {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: #fff;
    padding: 18px 24px
}

.card-header-ui h5 {
    margin: 0;
    font-weight: 700
}

label {
    font-size: 13px;
    font-weight: 600
}

.form-control-sm {
    border-radius: 10px
}

.table thead th {
    background: #eef2ff;
    color: #1e3a8a;
    font-size: 13px;
    text-transform: uppercase;
    text-align: center
}

.table tbody td {
    vertical-align: middle;
    font-size: 14px
}

.table-hover tbody tr:hover {
    background: #f1f5ff
}

.btn-premium {
    color: #fff !important;
    border-radius: 10px;
    padding: 7px 14px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap
}

.btn-blue {
    background: linear-gradient(135deg, #0ea5e9, #2563eb)
}

.btn-final {
    background: linear-gradient(135deg, #22c55e, #16a34a)
}

.badge-soft {
    background: #fde68a;
    color: #92400e;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
    white-space: nowrap
}

.result-scroll {
    display: flex;
    flex-wrap: nowrap;
    gap: 10px;
    overflow-x: auto;
    max-width: 360px;
    padding-bottom: 6px
}

.result-scroll::-webkit-scrollbar {
    height: 6px
}

.result-scroll::-webkit-scrollbar-thumb {
    background: #c7d2fe;
    border-radius: 10px
}
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">

        {{-- FILTER (UNCHANGED) --}}
        <form method="get" class="mb-4">
            <div class="card-ui">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2"><label>Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2"><label>Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2"><label>Records/Page</label>
                            <select name="r_page" class="form-control form-control-sm">
                                <option value="25" {{ request('r_page')==25?'selected':'' }}>25</option>
                                <option value="50" {{ request('r_page')==50?'selected':'' }}>50</option>
                                <option value="100" {{ request('r_page')==100?'selected':'' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-2"><button class="btn btn-info btn-sm w-100"><i class="fas fa-filter"></i>
                                Apply</button></div>
                        <div class="col-md-2"><a href="" class="btn btn-secondary btn-sm w-100"><i
                                    class="fas fa-undo"></i> Reset</a></div>
                    </div>
                </div>
            </div>
        </form>

        @if(session('error'))
        <div class="alert alert-danger m-3"><i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}</div>
        @endif

        <div class="card-ui">
            <div class="card-header-ui">
                <h5>Student Wise Results Overview</h5>
            </div>
            <div class="card-body p-0">

                @if($students->total()>0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Semesterwise</th>
                                <th>Marksheet / Certificate</th>
                                <th>Enrollment</th>
                                <th>Name</th>
                                <th>Session</th>
                                <th>Course</th>
                                <th>Updated</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $index=>$student)
                            <tr>
                                <td class="text-center">{{ $i+$index+1 }}</td>

                                {{-- SEMESTERWISE --}}
                                <td>
                                    <div class="result-scroll">
                                        @if(isset($results[$student->id]))
                                        @foreach($results[$student->id] as $exam)
                                        <a href="{{ route('result.download',[
                                            'student_id'=>$student->id,
                                            'exam_id'=>$exam->exam_id,
                                            'marksheet_no'=>DB::table('tbl_results')
                                            ->where('student_id',$student->id)
                                            ->where('exam_id',$exam->exam_id)
                                            ->orderByDesc('marksheet_no')
                                            ->value('marksheet_no')
                                            ]) }}" class="btn-premium btn-blue">
                                            <i class="fas fa-file-pdf"></i> {{ $exam->exam_name }}
                                        </a>
                                        @endforeach
                                        @else
                                        <span class="badge-soft">Semester Result Not Generated</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- FINAL + CERTIFICATE --}}
                                <td>
                                    <div class="result-scroll">

                                        @if(
                                        !isset($studentsWithResults[$student->id]) ||
                                        $studentsWithResults[$student->id]
                                        ->where('course_id',$student->course_id)
                                        ->where('session_start',$student->session_start)
                                        ->count()==0
                                        )
                                        <span class="badge-soft">Final Locked (Semester Pending)</span>

                                        @elseif(
                                        !isset($finalResults[$student->id]) ||
                                        $finalResults[$student->id]
                                        ->where('course_id',$student->course_id)
                                        ->where('session_start',$student->session_start)
                                        ->count()==0
                                        )
                                        <span class="badge-soft">Final Marksheet Not Generated</span>

                                        @else
                                        <a href="{{ route('final.marksheet.download',[$student->id,$student->course_id,$student->session_start]) }}"
                                            class="btn-premium btn-final"><i class="fas fa-award"></i> Final
                                            Marksheet</a>

                                        <a href="{{ route('certificate.download',[$student->id,$student->course_id,$student->session_start]) }}"
                                            class="btn-premium btn-blue"><i class="fas fa-certificate"></i>
                                            Certificate</a>
                                        @endif

                                    </div>
                                </td>

                                <td>{{ $student->enrollment_no }}</td>
                                <td class="fw-bold">{{ strtoupper($student->name) }}</td>
                                <td>{{ $student->session_start }} - {{ $student->session_end }}</td>
                                @php $course=DB::table('tbl_course')->where('id',$student->course_id)->value('name');
                                @endphp
                                <td class="text-primary fw-bold">{{ $course }}</td>
                                <td>{{ $student->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">{!! $students->links('pagination::bootstrap-4') !!}</div>
                @else
                <div class="alert alert-warning m-3">No records found.</div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection