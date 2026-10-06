@extends('backend.layouts.app')
@section('content')


<style>
    table.dataTable.table-striped>tbody>tr:nth-of-type(2n+1) {
    background-color: transparent;
    white-space: nowrap;
}
</style>
<div class="content-wrapper">
    <div class="container-fluid py-4">

        <!-- Filter Form -->
        <form method="get" action="" class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-2 align-items-end">

                        {{-- Date From --}}
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Date (From)</strong></small></label>
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                value="{{ request('date_from') }}">
                        </div>

                        {{-- Date To --}}
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Date (To)</strong></small></label>
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                value="{{ request('date_to') }}">
                        </div>

                        {{-- Records per page --}}
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Records/Page</strong></small></label>
                            <select name="r_page" class="form-control form-control-sm">
                                <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 Records/Page
                                </option>
                                <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 Records/Page
                                </option>
                                <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 Records/Page
                                </option>
                            </select>
                        </div>

                        {{-- Apply Filter --}}
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <button type="submit" class="btn btn-sm btn-info w-100">
                                <i class="fas fa-filter me-1"></i> Apply Filter
                            </button>
                        </div>

                        {{-- Reset Button --}}
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="" class="btn btn-sm btn-secondary w-100">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>

                        {{-- Export Excel --}}
                        <!-- <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('admin.leads.export', request()->query()) }}"
                                class="btn btn-sm btn-warning w-100">
                                <i class="fas fa-file-excel me-1"></i> Export Excel
                            </a>
                        </div> -->

                    </div>
                </div>
            </div>
        </form>

        <!-- Student Wise Admitcard Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Student Wise Admitcard Overview</h5>
            </div>
            <br>

            <div class="card-body p-0">
                @if(session('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger m-3">{{ session('error') }}</div>
                @endif

                @if($students->total() > 0)


                <div class="table-responsive">
                    <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>

                                <th>Download Admitcard</th>

                                <th>Enrollment Number</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>

                                <th>Qualification</th>
                                <th>Board</th>
                                <th>Session</th>

                                <th>Course</th>
                                <th>Duration</th>


                                <th>Updated At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $index => $student)
                            <tr>

                                <td>{{ $i + $index + 1 }}</td>



                                <td>
                                    <style>
                                    .btn-premium {
                                        color: #fff !important;
                                        border: none;
                                        border-radius: 10px;
                                        padding: 8px 15px;
                                        font-size: 13px;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        justify-content: center;
                                        gap: 8px;
                                        text-decoration: none !important;
                                        position: relative;
                                        overflow: hidden;
                                        transition: all 0.35s ease;
                                        backdrop-filter: blur(6px);
                                        letter-spacing: 0.3px;
                                    }

                                    /* ===== Premium Gradient Variants ===== */
                                    .btn-green {
                                        background: linear-gradient(135deg, #00c97c, #1dbf73);
                                        box-shadow: 0 6px 18px rgba(0, 201, 124, 0.35);
                                    }

                                    .btn-green:hover {
                                        background: linear-gradient(135deg, #1dbf73, #00c97c);
                                        box-shadow: 0 10px 24px rgba(0, 201, 124, 0.45);
                                        transform: translateY(-3px);
                                    }

                                    .btn-blue {
                                        background: linear-gradient(135deg, #00b4db, #0083b0);
                                        box-shadow: 0 6px 18px rgba(0, 131, 176, 0.35);
                                    }

                                    .btn-blue:hover {
                                        background: linear-gradient(135deg, #0083b0, #00b4db);
                                        box-shadow: 0 10px 24px rgba(0, 131, 176, 0.45);
                                        transform: translateY(-3px);
                                    }

                                    .btn-red {
                                        background: linear-gradient(135deg, #ff416c, #ff4b2b);
                                        box-shadow: 0 6px 18px rgba(255, 65, 108, 0.35);
                                    }

                                    .btn-red:hover {
                                        background: linear-gradient(135deg, #ff4b2b, #ff416c);
                                        box-shadow: 0 10px 24px rgba(255, 65, 108, 0.45);
                                        transform: translateY(-3px);
                                    }

                                    /* ===== Shine Ripple Effect ===== */
                                    .btn-premium::after {
                                        content: "";
                                        position: absolute;
                                        top: -50%;
                                        left: -50%;
                                        width: 200%;
                                        height: 200%;
                                        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
                                        transform: translate(-50%, -50%) scale(0);
                                        transition: transform 0.45s ease;
                                    }

                                    .btn-premium:hover::after {
                                        transform: translate(-50%, -50%) scale(1);
                                    }

                                    /* ===== Icons ===== */
                                    .btn-premium i {
                                        font-size: 14px;
                                    }

                                    /* ===== Flexbox for alignment ===== */
                                    .btn-wrapper {
                                        display: flex;
                                        flex-wrap: nowrap;
                                        gap: 10px;
                                        justify-content: center;
                                        align-items: center;
                                        white-space: nowrap;
                                    }
                                    </style>

                                    <div class="btn-wrapper">



                                        @if($student->hasAdmitCard)
                                        <a href="{{ url('admin/admit-card-view/'.$student->id) }}"
                                            class="btn-premium btn-blue mt-2" onclick="downloadPDF({{ $student->id }})"
                                            target="_blank">
                                            <i class="fas fa-id-card"></i> View & Download Admit Card
                                        </a>
                                        <script>
                                        function downloadPDF(id) {
                                            let url = "{{ url('admin/admit-card-download') }}/" + id;
                                            setTimeout(() => {
                                                window.open(url, "_blank");
                                            }, 800);
                                        }
                                        </script>
                                        @else
                                        <span class="badge badge-warning mt-2">
                                            Admit Card not visible.
                                        </span>
                                        @endif



                                    </div>
                                </td>




                                <td>{{ $student->enrollment_no ?? 'N/A' }}</td>

                                <td>{{ strtoupper($student->name ?? 'N/A') }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td>{{ $student->email ?? 'N/A' }}</td>

                                <td>{{ $student->high_quali ?? 'N/A' }}</td>
                                <td>{{ $student->board ?? 'N/A' }}</td>
                                <td>{{ $student->session_start ?? 'N/A' }} - {{ $student->session_end ?? 'N/A' }}</td>

                                @php
                                $courseName = DB::table('tbl_course')->where('id', $student->course_id)->value('name');
                                @endphp

                                <td
                                    style="background-color: #f0f8ff; color: #1e90ff; font-weight: bold; text-align: center; padding: 8px; border-radius: 5px;">
                                    {{ $courseName ?? 'N/A' }}
                                </td>

                                <td>{{ $student->duration ?? 'N/A' }}</td>




                                <td>{{ $student->updated_at ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>

                <div class="p-3">
                    {!! $students->links('pagination::bootstrap-4') !!}
                </div>
                @else
                <div class="alert alert-warning m-3">No records found.</div>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection