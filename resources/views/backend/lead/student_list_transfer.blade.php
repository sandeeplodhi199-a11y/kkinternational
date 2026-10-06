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
                <h5 class="mb-0">Student Transfer List Overview</h5>
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
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Admission No</th>
                                <th>IEMIS No</th>
                                <th>Full Name</th>
                                <th>Nickname</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>DOB (BS)</th>
                                <th>DOB (AD)</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Session</th>
                                <th>Grade</th>
                                <th>Section</th>
                                <th>Gender</th>
                                <th>Blood Group</th>
                                <th>Nationality</th>
                                <th>Photo</th>
                                <th>Ethnicity</th>
                                <th>Mother Tongue</th>
                                <th>Contact</th>
                                <th>Religion</th>
                                <th>Status</th>
                                <th>Admission Date</th>
                                <th>Added By</th>
                                <th>Updated By</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <style>
                        .btn-sm {
                            border-radius: 20px;
                            padding: 5px 12px;
                            font-size: 12px;
                        }
                        </style>
                        <tbody class="text-center">
                            @foreach($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                @php
                                $isTransferred = ($student->status === 'Transfer');
                                @endphp

                                <td>
                                    <div class="d-flex flex-column align-items-center gap-2">

                                        <!-- Row 1 -->
                                        <div class="d-flex gap-2">

                                            <!-- View/Edit (Always Clickable) -->
                                            
                                              @if(in_array('3_4', $permExplodesub))
                                            <a href="{{ url('admin/student-edit/' . $student->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-user-graduate"></i> View
                                            </a>
                                            @endif
                                           

                                            <!-- Transfer Certificate (Disable if transferred) -->
                                            <!-- <a href="{{ $isTransferred ? 'javascript:void(0)' : url('admin/transfer-certificate?id=' . $student->id) }}"
                                                class="btn btn-sm btn-info {{ $isTransferred ? 'disabled' : '' }}"
                                                style="{{ $isTransferred ? 'pointer-events:none; opacity:0.6;' : '' }}">
                                                <i class="fas fa-exchange-alt"></i> Transfer
                                            </a> -->

                                        </div>

                                        <!-- Row 2 -->
                                        <div>
                                               @if(in_array('3_6', $permExplodesub))

                                            <!-- ID Card (Always Clickable) -->
                                            <a href="{{ url('admin/student-id-card/' . $student->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-id-card"></i> ID Card
                                            </a>
                                            @endif

                                        </div>

                                    </div>
                                </td>
                                <td>{{ $student->admission_no ?? 'N/A' }}</td>
                                <td>{{ $student->iemis_no ?? 'N/A' }}</td>
                                <td>{{ trim($student->first_name.' '.$student->middle_name.' '.$student->last_name) ?: 'N/A' }}
                                </td>
                                <td>{{ $student->nickname ?? 'N/A' }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td>{{ $student->email ?? 'N/A' }}</td>
                                <td>{{ $student->dob_bs ?? 'N/A' }}</td>
                                <td>{{ $student->dob_ad ?? 'N/A' }}</td>
                                <td>{{ $student->state ?? 'N/A' }}</td>
                                <td>{{ $student->city ?? 'N/A' }}</td>
                                <td>{{ $student->address ?? 'N/A' }}</td>
                                <td>{{ $student->pincode ?? 'N/A' }}</td>

                                <td>{{ $student->session_name ?? 'N/A' }}</td>
                                <td>{{ $student->grade_name ?? 'N/A' }}</td>
                                <td>{{ $student->section_name ?? 'N/A' }}</td>

                                <td>{{ $student->gender ?? 'N/A' }}</td>
                                <td>{{ $student->blood_group ?? 'N/A' }}</td>
                                <td>{{ $student->nationality ?? 'N/A' }}</td>

                                <td>
                                    @if($student->photo)
                                    <img src="{{ asset('public/uploads/'.$student->photo) }}" alt="Photo"
                                        class="img-thumbnail" style="width:60px; height:auto;">
                                    @else
                                    N/A
                                    @endif
                                </td>

                                <td>{{ $student->ethnicity ?? 'N/A' }}</td>
                                <td>{{ $student->mother_tongue ?? 'N/A' }}</td>
                                <td>{{ $student->contact ?? 'N/A' }}</td>
                                <td>{{ $student->religion ?? 'N/A' }}</td>
                                <td>
                                    @php
                                    $statusColors = [
                                    'Active' => 'success',
                                    'Inactive' => 'secondary',
                                    'Absconding' => 'warning',
                                    'Left' => 'danger',
                                    'Transfer' => 'info'
                                    ];

                                    $currentStatus = !empty($student->status) ? trim($student->status) : 'Inactive';
                                    $badgeColor = $statusColors[$currentStatus] ?? 'secondary';
                                    @endphp

                                    <span class="badge badge-{{ $badgeColor }}">
                                        <i
                                            class="fas {{ $currentStatus === 'Active' ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ ucfirst(strtolower($currentStatus)) }}
                                    </span>
                                </td>
                                <td>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d-M-Y') : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                    $addedBy = DB::table('users')->where('id',
                                    $student->add_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $addedBy ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($addedBy->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $addedBy->name ?? 'Unknown' }}</span>
                                </td>

                                <td>
                                    @php
                                    $updatedBy = DB::table('users')->where('id',
                                    $student->updated_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $updatedBy ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($updatedBy->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $updatedBy->name ?? 'Unknown' }}</span>
                                </td>



                                <td>{{ $student->created_at ?? 'N/A' }}</td>
                                <td>{{ $student->updated_at ?? 'N/A' }}</td>

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