@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="container-fluid py-4">

        <!-- Filter Form -->
        <form method="get" action="" class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-2 align-items-end">


                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Date (From)</strong></small></label>
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                value="{{ request('date_from') }}">
                        </div>


                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Date (To)</strong></small></label>
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                value="{{ request('date_to') }}">
                        </div>

                   <!--     <div class="col-lg-2 col-md-4 col-sm-6">
                            <label class="form-label mb-0"><small><strong>Records/Page</strong></small></label>
                            <select name="r_page" class="form-control form-control-sm">
                                <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 Records/Page
                                </option>
                                <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 Records/Page
                                </option>
                                <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 Records/Page
                                </option>
                            </select>
                        </div> -->


                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <button type="submit" class="btn btn-sm btn-info w-100">
                                <i class="fas fa-filter me-1"></i> Apply Filter
                            </button>
                        </div>


                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="" class="btn btn-sm btn-secondary w-100">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </form>

        <!-- Student Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Student Overview</h5>
            </div>
            <br>

            <div class="card-body p-0">
                @if(session('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger m-3">{{ session('error') }}</div>
                @endif

               

                <div class="table-responsive">
                                       <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">

                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Admission</th>
                                <th>Parents</th>
                                <th>DOB</th>
                                <th>Admission Date</th>
                                <th>Grade</th>
                                <th>Promotion</th>
                                <th>Dues</th>
                                <th>Character</th>
                                <th>Reason</th>
                                <th>Issue Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transfers as $key => $row)
                            <tr>
                                <td>{{ $i + $key + 1 }}</td>

                                <!-- Student -->
                                <td>
                                    <strong>{{ $row->student_name }}</strong><br>
                                    <small>ID: {{ $row->student_id ?? 'N/A' }}</small>
                                </td>

                                <!-- Admission -->
                                <td>
                                    {{ $row->admission_no }}<br>
                                    <small>SN: {{ $row->serial_no ?? 'N/A' }}</small>
                                </td>

                                <!-- Parents -->
                                <td>
                                    <small>F: {{ $row->father_name }}</small><br>
                                    <small>M: {{ $row->mother_name }}</small>
                                </td>

                                <!-- DOB -->
                                <td>
                                    <small>BS: {{ $row->dob_bs }}</small><br>
                                    <small>AD: {{ $row->dob_ad }}</small>
                                </td>

                                <!-- Admission Date -->
                                <td>
                                    <small>BS: {{ $row->admission_date_bs }}</small><br>
                                    <small>AD: {{ $row->admission_date_ad }}</small>
                                </td>

                                <!-- Grade -->
                                <td>{{ $row->last_grade }}</td>

                                <!-- Promotion -->
                                <td>
                                    {{ $row->is_promoted }} → <br>
                                    <strong>{{ $row->promoted_grade }}</strong>
                                </td>

                                <!-- Dues -->
                                <td>{{ $row->dues_paid }}</td>

                                <!-- Character -->
                                <td>{{ $row->general_character }}</td>

                                <!-- Reason -->
                                <td>{{ $row->reason }}</td>

                                <!-- Issue Date -->
                                <td>
                                    <small>BS: {{ $row->issue_date_bs }}</small><br>
                                    <small>AD: {{ $row->issue_date_ad }}</small>
                                </td>

                              @if(in_array('4_3', $permExplodesub))

                                <td>
                                    <a href="{{ url('admin/transfer-edit/'.$row->id) }}" title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                </td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            
            </div>
        </div>
    </div>
</div>



@endsection