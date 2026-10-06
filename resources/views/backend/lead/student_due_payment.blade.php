@extends('backend.layouts.app')
@section('content')

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

        <!-- Student Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Due Payment Overview</h5>
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
                                <th>Balance Amount</th>

     <th>Installment Date</th>
                            <th>Installment Details</th>
                            
                            <th>Installment Status</th>



                                <th>Enrollment Number</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>Father Phone</th>
                                <th>DOB</th>
                                <th>Aadhar</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Qualification</th>
                                <th>Board</th>
                                <th>Session</th>
                                <th>Main Subject</th>
                                <th>Marks Obtained</th>
                                <th>Course</th>
                                <th>Duration</th>
                                <th>Course Fees</th>
                                <th>Discount Fees</th>
                                <th>Net Chargeable Amount</th>
                                <th>Admission Date</th>


                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Initial Pay</th>
                                <th>Initial Pay Mode</th>
                                <th>Initial Pay Date</th>
                                <th>Pay Initial Desc</th>
                                <th>Installment Received</th>

                                <th>Balance Amount</th>

                                <th>Status</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $index => $student)
                            <tr>

                                <td>{{ $i + $index + 1 }}</td>
<style>
.colorful-balance-card {
    background: linear-gradient(135deg, #667eea, #764ba2, #ff6a88);
    border-radius: 14px;
    padding: 10px 16px;
    color: #fff;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-width: 220px;
}
.colorful-balance-info { line-height: 1.2; }
.colorful-balance-label { font-size: 11px; opacity: 0.9; font-weight: 500; }
.colorful-balance-amount { font-size: 18px; font-weight: 700; }
.colorful-pay-btn {
    background: #fff;
    color: #333;
    font-weight: 600;
    border-radius: 6px;
    padding: 5px 12px;
    font-size: 12px;
    text-decoration: none;
}
.colorful-pay-btn.disabled {
    background: #ccc;
    color: #666;
    pointer-events: none;
}
.installment-complete-note {
    margin-top: 4px;
    font-size: 11px;
    font-weight: 600;
    color: #00ffcc;
}
</style>

                             <td>
    @php
        // Get current due installment (the same installment row already selected in query)
        $inst = $student->installments
            ->where('date', \Carbon\Carbon::parse($student->installment_date)->format('Y-m-d'))
            ->first();

        $paidAmount = $inst->total_receive_amount ?? 0;
        $installmentAmount = $inst->amount ?? 0;
        $remaining = $installmentAmount - $paidAmount;
        $isFullyPaid = ($remaining <= 0);
    @endphp

    @if($inst)
        <div class="colorful-balance-card">
            <div class="colorful-balance-info">

                <div class="colorful-balance-label">Current Installment</div>
                <div class="colorful-balance-amount">₹{{ number_format($installmentAmount) }}</div>

                <div class="colorful-balance-label mt-1">Remaining</div>
                <div class="colorful-balance-amount" style="font-size:15px;">
                    ₹{{ number_format($remaining) }}
                </div>

                @if($isFullyPaid)
                <div class="installment-complete-note">✔ Fully Paid</div>
                @endif
            </div>

            @if(!$isFullyPaid)
                <a href="{{ url('admin/pay-installement/' . $student->id) }}" class="colorful-pay-btn">
                    Pay Now
                </a>
            @else
                <span class="colorful-pay-btn disabled">Paid</span>
            @endif
        </div>
    @else
        <span class="text-muted">No installment found</span>
    @endif
</td>



                   
 {{-- ✅ INSTALLMENT DATE --}}
    <td>
        {{ \Carbon\Carbon::parse($student->installment_date)->format('d-M-Y') }}
    </td>

    {{-- ✅ INSTALLMENT DESCRIPTION --}}
    <td>{{ $student->installment_details ?? 'N/A' }}</td>

   

    {{-- ✅ INSTALLMENT STATUS --}}
    <td>
        @if($student->final_status)
            <span class="badge badge-primary">Paid</span>
        @else
            <span class="badge badge-danger">Pending</span>
        @endif
    </td>



                                <td>{{ $student->enrollment_no ?? 'N/A' }}</td>

                                <td>{{ strtoupper($student->name ?? 'N/A') }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td>{{ $student->email ?? 'N/A' }}</td>
                                <td>{{ $student->fathername ?? 'N/A' }}</td>
                                <td>{{ $student->mother_name ?? 'N/A' }}</td>
                                <td>{{ $student->father_phone ?? 'N/A' }}</td>
                                <td>{{ $student->dob ?? 'N/A' }}</td>
                                <td>{{ $student->aadhar ?? 'N/A' }}</td>
                                <td>{{ $student->state ?? 'N/A' }}</td>
                                <td>{{ $student->city ?? 'N/A' }}</td>
                                <td>{{ $student->address ?? 'N/A' }}</td>
                                <td>{{ $student->pincode ?? 'N/A' }}</td>
                                <td>{{ $student->high_quali ?? 'N/A' }}</td>
                                <td>{{ $student->board ?? 'N/A' }}</td>
                                <td>{{ $student->session ?? 'N/A' }}</td>
                                <td>{{ $student->main_subject ?? 'N/A' }}</td>
                                <td>{{ $student->mark_obtain ?? 'N/A' }}</td>

                                {{-- Get Course Name --}}
                                @php
                                $courseName = DB::table('tbl_course')->where('id', $student->course_id)->value('name');
                                $branchName = DB::table('tbl_branch')->where('id', $student->branch_id)->value('name');
                                $batchName = DB::table('tbl_batch')->where('id', $student->batch_id)->value('name');

                                @endphp

                                <td>{{ $courseName ?? 'N/A' }}</td>
                                <td>{{ $student->duration ?? 'N/A' }}</td>
                                <td>₹{{ number_format($student->course_fees ?? 0, 2) }}</td>
                                <td>₹{{ number_format($student->discount_fees ?? 0, 2) }}</td>
                                <td>₹{{ number_format($student->net_chargeable_amount ?? 0, 2) }}</td>
                                <td>
                                    @if($student->admission_date)
                                    {{ \Carbon\Carbon::parse($student->admission_date)->format('d-M-Y') }}
                                    @else
                                    N/A
                                    @endif
                                </td>

                                <td>{{ $branchName ?? 'N/A' }}</td>
                                <td>{{ $batchName ?? 'N/A' }}</td>



                                <td>₹{{ number_format($student->initial_pay ?? 0, 2) }}</td>
                                <td>{{ ucfirst($student->initial_pay_mode ?? 'N/A') }}</td>
                                <td>{{ $student->initial_pay_date ?? 'N/A' }}</td>
                                <td>{{ $student->pay_initial_desc ?? 'N/A' }}</td>
                                <td>{{ $student->installment_receive ?? 'N/A' }}</td>

                                <td>₹{{ number_format($student->balance_amount ?? 0, 2) }}</td>




                                <td>
                                    @if($student->status === 'Active')
                                    <a class="badge badge-success"
                                        href="{{ url('admin/update-lead-status/'.$student->id.'?status=Inactive') }}">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </a>
                                    @else
                                    <a class="badge badge-danger"
                                        href="{{ url('admin/update-lead-status/'.$student->id.'?status=Active') }}">
                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                    </a>
                                    @endif
                                </td>



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