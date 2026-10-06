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
                <h5 class="mb-0">Upcoming Payment Overview</h5>
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

                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>




                                <th>Status</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $index => $student)
                            <tr>

                                <td>{{ $i + $index + 1 }}</td>
                                <td>
                                    <style>
                                    .colorful-balance-card {
                                        background: linear-gradient(135deg, #667eea, #764ba2, #ff6a88);
                                        border-radius: 14px;
                                        padding: 12px 18px;
                                        color: #fff;
                                        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        min-width: 240px;
                                    }

                                    .colorful-balance-info {
                                        line-height: 1.2;
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

                                    .colorful-pay-btn {
                                        background: #fff;
                                        color: #333;
                                        font-weight: 600;
                                        border-radius: 8px;
                                        padding: 6px 14px;
                                        font-size: 13px;
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

                                    @php
                                    // ✅ Sirf wahi installment fetch karo jo student->installment_date se match kare
                                    $inst = $student->installments
                                    ->where('date', \Carbon\Carbon::parse($student->installment_date)->format('Y-m-d'))
                                    ->first();

                                    $paidAmount = $inst->total_receive_amount ?? 0;
                                    $installmentAmount = $inst->amount ?? 0;
                                    $remaining = $installmentAmount - $paidAmount;
                                    $isFullyPaid = $paidAmount >= $installmentAmount;
                                    @endphp

                                    @if($inst)
                                    <div class="colorful-balance-card">
                                        <div class="colorful-balance-info">

                                            <div class="colorful-balance-label">Current Installment</div>
                                            <div class="colorful-balance-amount">
                                                ₹{{ number_format($installmentAmount) }}
                                            </div>

                                            <div class="colorful-balance-label mt-1">Total Balance</div>
                                            <div class="colorful-balance-amount" style="font-size:16px;">
                                                ₹{{ number_format($student->balance_amount ?? 0) }}
                                            </div>

                                            @if($remaining > 0)
                                            <div class="colorful-balance-label mt-1">
                                                Remaining: ₹{{ number_format($remaining) }}
                                            </div>
                                            @endif

                                            @if($isFullyPaid)
                                            <div class="installment-complete-note">
                                                ✅ Installment Fully Paid
                                            </div>
                                            @endif
                                        </div>

                                        @if(($student->balance_amount ?? 0) > 0 && !$isFullyPaid)
                                        <a href="{{ url('admin/pay-installement/' . $student->id) }}"
                                            class="colorful-pay-btn">
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




                                <td>
                                    {{ \Carbon\Carbon::parse($student->installment_date)->format('d-M-Y') }}
                                </td>


                                <td>{{ $student->installment_details ?? 'N/A' }}</td>




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

                                <td>{{ $student->state ?? 'N/A' }}</td>
                                <td>{{ $student->city ?? 'N/A' }}</td>
                                <td>{{ $student->address ?? 'N/A' }}</td>
                                <td>{{ $student->pincode ?? 'N/A' }}</td>






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