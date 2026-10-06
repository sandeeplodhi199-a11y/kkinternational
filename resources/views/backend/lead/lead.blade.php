@extends('backend.layouts.app')

@section('content')


<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container-fluid py-4">

        <!-- Filter and Add Button -->
        <div class="row align-items-end mb-4">

            <form method="get" action="" class="mb-4">
                <div class="card shadow-sm">
                    <div class="card-body py-3 px-3">
                        <div class="row g-2">

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Name</strong></small></label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    value="{{ request('name') }}" placeholder="Name">
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Email</strong></small></label>
                                <input type="text" name="email" class="form-control form-control-sm"
                                    value="{{ request('email') }}" placeholder="Email">
                            </div>


                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Phone</strong></small></label>
                                <input type="text" name="phone" class="form-control form-control-sm"
                                    value="{{ request('phone') }}" placeholder="Phone">
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Gender</strong></small></label>
                                <select name="gender" class="form-control form-control-sm">
                                    <option value="">-- Gender --</option>
                                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>





                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Created Date (From)</strong></small></label>
                                <input type="date" name="date_from" class="form-control form-control-sm"
                                    value="{{ request('date_from') }}">
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Created Date (To)</strong></small></label>
                                <input type="date" name="date_to" class="form-control form-control-sm"
                                    value="{{ request('date_to') }}">
                            </div>
                             <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>FollowUp Date</strong></small></label>
                                <input type="date" name="followup_date" class="form-control form-control-sm"
                                    value="{{ request('followup_date') }}">
                            </div>

                            <div class="col-lg-1 col-md-4 col-sm-6">
                                <label><small><strong>Records/Page</strong></small></label>
                                <select name="r_page" class="form-control form-control-sm">
                                    <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 </option>
                                    <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 </option>
                                    <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 </option>
                                </select>
                            </div>

                            <div class="col-lg-1 col-md-4 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-sm btn-info w-100">Apply Filter</button>
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-end">
                                <a href="{{ url('admin/add-lead') }}" class="btn btn-sm btn-success w-100">
                                    <i class="fas fa-plus-circle mr-1"></i> Add Lead
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-end">
                                <a href="{{ route('admin.leads.export', request()->query()) }}"
                                    class="btn btn-sm btn-warning w-100">
                                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                                </a>
                            </div>



                        </div>
                    </div>
                </div>
            </form>






        </div>

        <!-- Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">lead Overview</h5>
            </div>
            <br>
            @if (\Session::has('success'))
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
            @endif


            @if (\Session::has('error'))
            <div class="alert alert-danger">
                {!! \Session::get('error') !!}
            </div>
            @endif

            <div class="card-body p-0">
                @if($leads->total() > 0)

                <div class="table-responsive">
                    <table id="tablesearchfilter" class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>S. No.</th>
                                <th>Admission</th>
                                <!-- <th>Balance Amount</th> -->

                                <th>Lead Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>School Name</th>
                                <th>Class</th>
                                <th>Course</th>
                                <th>Purpose</th>
                                <th>Lead Source</th>
                                <th>Lead Status</th>
                                <th>FollowUp Date & Time</th>
                                <th>FollowUp History</th>
                                <th>Gaurdian Phone</th>
                                <th>Description</th>
                                <th>Address</th>




                                <th>Assigned To</th>
                                <th>Added By</th>
                                <th>Status</th>

                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = ($leads->currentPage() - 1) * $leads->perPage();
                            @endphp
                            @foreach($leads as $bl)
                            <tr>
                                <td>{{ ++$i }}</td>


                                <td>
                                    <style>
                                    .manage-admission-btn {
                                        background: linear-gradient(135deg, #6a11cb, #2575fc);
                                        color: #fff !important;
                                        border: none;
                                        border-radius: 12px;
                                        padding: 9px 16px;
                                        font-size: 13px;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                        text-decoration: none !important;
                                        cursor: pointer;
                                        position: relative;
                                        overflow: hidden;
                                        transition: all 0.35s ease;
                                        box-shadow: 0 4px 14px rgba(37, 117, 252, 0.35);
                                        backdrop-filter: blur(4px);
                                        white-space: nowrap;
                                    }

                                    .manage-admission-btn i {
                                        font-size: 15px;
                                        transition: transform 0.3s ease;
                                    }

                                    .manage-admission-btn:hover i {
                                        transform: rotate(10deg) scale(1.1);
                                    }

                                    .manage-admission-btn:hover {
                                        background: linear-gradient(135deg, #4b6cb7, #182848);
                                        box-shadow: 0 6px 20px rgba(37, 117, 252, 0.6);
                                        transform: translateY(-2px);
                                    }

                                    .manage-admission-btn:before {
                                        content: "";
                                        position: absolute;
                                        top: -50%;
                                        left: -50%;
                                        width: 200%;
                                        height: 200%;
                                        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 10%, transparent 10.01%);
                                        background-size: 10px 10px;
                                        opacity: 0;
                                        transition: opacity 0.3s ease;
                                    }

                                    .manage-admission-btn:hover:before {
                                        opacity: 0.25;
                                    }

                                    .manage-admission-btn:active {
                                        transform: scale(0.96);
                                        box-shadow: 0 2px 8px rgba(37, 117, 252, 0.4);
                                    }

                                    /* Green version for Admitted */
                                    .admitted-btn {
                                        background: linear-gradient(135deg, #00b09b, #96c93d);
                                        box-shadow: 0 4px 14px rgba(0, 176, 155, 0.4);
                                    }

                                    .admitted-btn:hover {
                                        background: linear-gradient(135deg, #43cea2, #185a9d);
                                        box-shadow: 0 6px 20px rgba(0, 176, 155, 0.55);
                                    }

                                    .admitted-btn i {
                                        color: #fff;
                                    }
                                    </style>

                                    @if ($bl->admission_id)
                                    <!-- Admitted button in green gradient -->
                                    <a class="manage-admission-btn admitted-btn">
                                        <i class="fas fa-check-circle"></i> Admitted
                                    </a>
                                    @else
                                    <!-- Manage Admission button in blue gradient -->
                                    <a href="{{ url('admin/add-admission/' . $bl->id) }}" class="manage-admission-btn">
                                        <i class="fas fa-calendar-check"></i> Manage Admission
                                    </a>
                                    @endif
                                </td>

                                <!--

                                    @php
                                    $balance = DB::table('tbl_admission')
                                    ->where('lead_id', $bl->id)
                                    ->select('id', 'balance_amount')
                                    ->first();
                                    @endphp

                                    <td>
                                    <style>
                                    .colorful-balance-card {
                                        background: linear-gradient(135deg, #667eea, #764ba2, #ff6a88);
                                        border-radius: 10px;
                                        padding: 3px 2px;
                                        color: #fff;
                                        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        transition: 0.3s 
                                    ease;
                                        min-width: 260px;
                                        border: 1px solid rgba(255, 255, 255, 0.1);
                                        position: relative;
                                        overflow: hidden;
                                    }
                                    .colorful-balance-card::before {
                                        content: "";
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 150%;
                                        height: 150%;
                                        background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.15), transparent 70%);
                                        transform: rotate(25deg);
                                        z-index: 0;
                                    }

                                    .colorful-balance-info {
                                        z-index: 1;
                                        line-height: 1.3;
                                    }

                                    .colorful-balance-label {
                                        font-size: 12px;
                                        opacity: 0.9;
                                        font-weight: 500;
                                    }

                                    .colorful-balance-amount {
                                        font-size: 20px;
                                        font-weight: 700;
                                    }

                                    /* Active Button */
                                    .colorful-pay-btn {
                                        z-index: 1;
                                        background: #fff;
                                        color: #333;
                                        font-weight: 600;
                                        border-radius: 6px;        /* slightly tighter */
                                        padding: 3px 10px;        /* ✅ HEIGHT REDUCED */
                                        font-size: 12px;          /* slightly smaller text */
                                        line-height: 1.2;        /* ✅ compact vertical spacing */
                                        text-decoration: none;
                                        transition: 0.3s ease;
                                    }

                                    /* Disabled Button */
                                    .disabled-btn {
                                        background: rgba(255, 255, 255, 0.4);
                                        color: #666;
                                        cursor: not-allowed;
                                        pointer-events: none;
                                        margin-left: 14px;
                                    }




                                    .premium-text {
                                        font-size: 15px;
                                        font-weight: 700;
                                        color: #ffd700;
                                    }

                                    .premium-zero {
                                        background: linear-gradient(135deg, #0f172a, #1e293b);
                                        white-space: nowrap;
                                        margin-top: -3px;
                                    }

                                    .premium-subtext {
                                        font-size: 12px;
                                        opacity: 0.85;
                                    }
                                    </style>

                                    {{-- CONDITION START --}}
                                    @if(($balance->balance_amount ?? 0) == 0)

                                    <div class="colorful-balance-card premium-zero">
                                        <div class="colorful-balance-info">
                                            <div class="premium-text">Installment Not Set</div>
                                            <div class="premium-subtext">
                                                Installment amount will be assigned<br>
                                                during the admission process.
                                            </div>
                                        </div>

                                        <span class="colorful-pay-btn disabled-btn">
                                            Pay Disabled
                                        </span>
                                    </div>

                                    @else

                                    <div class="colorful-balance-card">
                                        <div class="colorful-balance-info">
                                            <div class="colorful-balance-label">Balance Amount</div>
                                            <div class="colorful-balance-amount">
                                                ₹{{ number_format($balance->balance_amount ?? 0) }}
                                            </div>
                                        </div>

                                        <a href="{{ url('admin/pay-installement/' . ($balance->id ?? 0)) }}"
                                        class="colorful-pay-btn">
                                            Pay Now
                                        </a>
                                    </div>

                                    @endif
                                    {{-- CONDITION END --}}

                                    </td>


                                -->


                                <td>{{ $bl->lead_id }}</td>
                                <td>{{ $bl->name }}</td>
                                <td>{{ $bl->email }}</td>
                                <td>{{ $bl->phone }}</td>
                                <td>{{ $bl->school_name }}</td>
                                <td>{{ $bl->class }}</td>
                                @php
                                $courseName = DB::table('tbl_course')->where('id', $bl->course_id)->value('name');
                               
                                @endphp

                                <td>{{ $courseName ?? 'N/A' }}</td>

                                <!-- Purpose Name -->
                                <td>
                                    @php
                                    $selectedPurposes = explode(',', $bl->purpose_id ?? '');
                                    $matchedPurposeNames = $purposes->whereIn('id',
                                    $selectedPurposes)->pluck('name')->toArray();
                                    @endphp
                                    <div class="d-flex flex-wrap" style="gap: 6px;">
                                        @forelse($matchedPurposeNames as $purposeName)
                                        <span class="badge"
                                            style="background-color: #17a2b8; color: white; padding: 6px 12px; border-radius: 20px;">
                                            {{ $purposeName }}
                                        </span>
                                        @empty
                                        <span class="text-muted">No Purpose Name Found</span>
                                        @endforelse
                                    </div>
                                </td>

                                <!-- Lead Source -->
                                <td>
                                    @php
                                    $source = DB::table('tbl_lead_source')->where('id',
                                    $bl->source_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $source ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($source->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $source->name ?? 'Unknown' }}</span>
                                </td>

                                <!-- Lead Status -->
                                <td>
                                    @php
                                    $status = DB::table('tbl_lead_status')->where('id',
                                    $bl->status_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $status ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($status->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $status->status ?? 'Unknown' }}</span>
                                </td>

                               <td class="text-center">
                                        @php
                                            $formattedDate = $bl->next_followup_date
                                                ? \Carbon\Carbon::parse($bl->next_followup_date)->format('d F Y, g:i A')
                                                : 'N/A';
                                        @endphp

                                        <span class="badge {{ $bl->next_followup_date ? 'bg-success' : 'bg-danger' }}">
                                            {{ $formattedDate }}
                                        </span>
                                    </td>


                                <td>
                                    <a href="{{ url('admin/add-follow-up/' . $bl->id) }}"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                        <i class="fas fa-calendar-check"></i> Follow Up
                                    </a>
                                </td>

                                <td>
                                    {{ $bl->gaurdian_phone }}
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                        {{ $bl->description }}
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                        {{ $bl->address }}
                                    </div>
                                </td>






                                <!-- Assigned To -->
                                <!-- <td>
                                    @php
                                    $assignTo = DB::table('users')->where('id',
                                    $bl->lead_assign_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $assignTo ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($assignTo->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $assignTo->name ?? 'Unknown' }}</span>
                                </td> -->
                                <td>
                                    @php
                                    $user = Auth::user();

                                    $subadmin = (!empty($bl->add_id))
                                    ? DB::table('users')->where('id', $bl->add_id)->where('type','subadmin')->first()
                                    : null;

                                    $admin = (!empty($bl->add_id))
                                    ? DB::table('users')->where('id', $bl->add_id)->where('type','admin')->first()
                                    : null;

                                    $manager = (!empty($bl->manager_id))
                                    ? DB::table('tbl_manager')->where('manager_id', $bl->manager_id)->first()
                                    : null;

                                    $tl = (!empty($bl->tl_id))
                                    ? DB::table('tbl_team_leader')->where('tl_id', $bl->tl_id)->first()
                                    : null;

                                    $telecaller = (!empty($bl->telecaller_id))
                                    ? DB::table('tbl_telecaller')->where('telecaller_id', $bl->telecaller_id)->first()
                                    : null;

                                    $leadassignManagerId = (!empty($bl->manager_id))
                                    ?
                                    DB::table('users')->where('manager_id',$bl->manager_id)->where('type','manager')->value('id')
                                    : null;

                                    $leadassignTlId = (!empty($bl->tl_id))
                                    ? DB::table('users')->where('tl_id',$bl->tl_id)->where('type','tl')->value('id')
                                    : null;

                                    $leadassignTelecallerId = (!empty($bl->telecaller_id))
                                    ?
                                    DB::table('users')->where('telecaller_id',$bl->telecaller_id)->where('type','telecaller')->value('id')
                                    : null;

                                    $leadassignSubadminId = DB::table('users')->where('type','subadmin')->value('id');
                                    $leadassignAdminId = DB::table('users')->where('type','admin')->value('id');

                                    $assignedType = null;

                                    // ----------- ASSIGNED TYPE DETECTION ------------
                                    if (!empty($bl->lead_assign_id)) {

                                    if ($leadassignManagerId && $bl->lead_assign_id == $leadassignManagerId) {
                                    $assignedType = 'manager';
                                    }
                                    elseif ($leadassignTlId && $bl->lead_assign_id == $leadassignTlId) {
                                    $assignedType = 'tl';
                                    }
                                    elseif ($leadassignTelecallerId && $bl->lead_assign_id == $leadassignTelecallerId) {
                                    $assignedType = 'telecaller';
                                    }

                                    // Subadmin & Admin special — they show alone
                                    elseif ($leadassignSubadminId && $bl->lead_assign_id == $leadassignSubadminId) {
                                    $assignedType = 'subadmin';
                                    }
                                    elseif ($leadassignAdminId && $bl->lead_assign_id == $leadassignAdminId) {
                                    $assignedType = 'admin';
                                    }
                                    }

                                    @endphp

                                    @if($user->type === 'admin' || $user->type === $assignedType)

                                    <div class="d-inline-flex align-items-center gap-2">

                                        {{-- SUBADMIN special case (single output only) --}}
                                        @if($assignedType == 'subadmin' && $subadmin)
                                        <span class="badge bg-secondary">{{ $subadmin->name }} (Subadmin)</span>
                                        @endif

                                        {{-- ADMIN special case (single output only) --}}
                                        @if($assignedType == 'admin' && $admin)
                                        <span class="badge bg-dark">{{ $admin->name }} (Admin)</span>
                                        @endif


                                        {{-- If assignedType is manager / tl / telecaller, show CHAIN only --}}
                                        @if(in_array($assignedType, ['manager','tl','telecaller']))

                                        @if($manager)
                                        <span
                                            class="badge {{ $assignedType=='manager'?'bg-warning text-dark':'bg-primary' }}">
                                            {{ $manager->name }} (Manager)
                                        </span>
                                        @endif

                                        @if($tl)
                                        <span>→</span>
                                        <span
                                            class="badge {{ $assignedType=='tl'?'bg-warning text-dark':'bg-success' }}">
                                            {{ $tl->name }} (TL)
                                        </span>
                                        @endif

                                        @if($telecaller)
                                        <span>→</span>
                                        <span
                                            class="badge {{ $assignedType=='telecaller'?'bg-warning text-dark':'bg-info text-dark' }}">
                                            {{ $telecaller->name }} (Telecaller)
                                        </span>
                                        @endif

                                        @endif

                                    </div>
                                    @endif
                                </td>





                                <!-- Added By -->
                                <td>
                                    @php
                                    $addedBy = DB::table('users')->where('id',
                                    $bl->add_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $addedBy ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($addedBy->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $addedBy->name ?? 'Unknown' }}</span>
                                </td>


                                <td>
                                    @if($bl->status === 'Active')
                                    <a class="badge badge-success"
                                        href="{{ url('admin/update-lead-status/'.$bl->id.'?status=Inactive') }}">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </a>
                                    @else
                                    <a class="badge badge-danger"
                                        href="{{ url('admin/update-lead-status/'.$bl->id.'?status=Active') }}">
                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                    </a>
                                    @endif
                                </td>




                                <td>{{ $bl->created_at->format('d M, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            id="actionMenu{{ $bl->id_hash }}" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="actionMenu{{ $bl->id_hash }}">
                                            @php
                                            $permExplodesub = explode(',', Auth::user()->permission_submenu
                                            ?? '');
                                            @endphp
                                            @if(in_array('6_3', $permExplodesub))
                                            <a class="dropdown-item" href="{{ url('admin/edit-lead/'.$bl->id_hash) }}">
                                                <i class="fas fa-edit mr-2 text-primary"></i> Edit
                                            </a>
                                            @endif

                                            @if(in_array('6_4', $permExplodesub))
                                            <a class="dropdown-item text-danger"
                                                href="{{ url('admin/delete-lead/'.$bl->id) }}"
                                                onclick="return confirm('Are you sure you want to delete this item?');">
                                                <i class="fas fa-trash-alt mr-2"></i> Delete
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="gmz-pagination p-3">
                    {!! $leads->links('pagination::bootstrap-4') !!}
                </div>
                @else
                <div class="alert alert-warning m-3">No data found</div>
                @endif
            </div>
        </div>
    </div>
</div>




@endsection