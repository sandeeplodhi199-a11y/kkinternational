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
                                <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 Records/Page</option>
                                <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 Records/Page</option>
                                <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 Records/Page</option>
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

                    </div>
                </div>
            </div>
        </form>

        <!-- Payment Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Payment Overview</h5>
            </div>
            <br>

            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger m-3">{{ session('error') }}</div>
                @endif

                @if($payments->total() > 0)
                <div class="table-responsive">
                    <table id="tablesearchfilter" class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>S. No.</th>
                                <th>Admission ID</th>
                                <th>Installment ID</th>
                                <th>Transection ID</th>
                                <th>Enrollment No</th>
                                <th>Student Name</th>
                                <th>Student Phone</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Course Name</th>
                                <th>Pay Amount</th>
                                <th>Pay Mode</th>
                                <th>Pay Desc</th>
                                <th>Pay Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $index => $payment)
                                <tr>
                                    <td>{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>

                                    <td>{{ $payment->admission_id }}</td>
                                    <td>{{ $payment->installment_ids }}</td>
                                    <td>{{ $payment->trans_id }}</td>
                                    <td>{{ $payment->enrollment_no }}</td>

                                    @php
                                        $studentData = DB::table('tbl_admission')
                                            ->where('enrollment_no', $payment->enrollment_no)
                                            ->select('name', 'phone', 'fathername', 'mother_name', 'course_id')
                                            ->first();

                                        $courseName = DB::table('tbl_course')
                                            ->where('id', $studentData->course_id ?? 0)
                                            ->value('name');

                                        // Count how many installments in this payment
                                        $installmentCount = 0;
                                        if (!empty($payment->installment_ids)) {
                                            $installmentCount = count(explode(',', $payment->installment_ids));
                                        }
                                    @endphp

                                    <td>{{ $studentData->name ?? 'N/A' }}</td>
                                    <td>{{ $studentData->phone ?? 'N/A' }}</td>
                                    <td>{{ $studentData->fathername ?? 'N/A' }}</td>
                                    <td>{{ $studentData->mother_name ?? 'N/A' }}</td>

                                    <td>
                                        <span style="background: linear-gradient(90deg, #f7c94b, #ffb347); color:#fff; font-weight:600; padding:2px 10px; border-radius:15px; font-size:14px; white-space:nowrap; box-shadow:0 1px 3px rgba(0,0,0,0.2);">
                                            {{ $courseName ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <style>
                                        .premium-td {
                                            text-align: center;
                                            padding: 8px 10px;
                                        }
                                        .premium-amount {
                                            display: block;
                                            font-weight: 700;
                                            font-size: 17px;
                                            color: #2c3e50;
                                            background: linear-gradient(90deg, #e3f2fd, #e8f5e9);
                                            padding: 6px 12px;
                                            border-radius: 8px;
                                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                                            margin-bottom: 6px;
                                        }
                                        .premium-info {
                                            font-size: 13px;
                                            color: #555;
                                            margin-bottom: 6px;
                                            font-weight: 600;
                                        }
                                        .colorful-pay-btn {
                                            background: linear-gradient(90deg, #6a11cb, #2575fc);
                                            color: #fff !important;
                                            padding: 6px 12px;
                                            font-size: 13px;
                                            font-weight: 600;
                                            border-radius: 6px;
                                            text-decoration: none;
                                            transition: 0.3s ease;
                                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
                                            display: inline-block;
                                        }
                                        .colorful-pay-btn:hover {
                                            background: linear-gradient(90deg, #2575fc, #6a11cb);
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                                        }
                                    </style>

                                    <td class="premium-td">
                                        <span class="premium-amount">
                                            ₹{{ number_format($payment->total_amount, 2) }}
                                        </span>
                                        <div class="premium-info">
                                            Payment for {{ $installmentCount }}
                                            {{ $installmentCount == 1 ? 'Installment' : 'Installments' }}
                                        </div>

                                        <a href="{{ route('admin.pay_slip', [
                                            'id' => $payment->id,
                                            'admission_id' => $payment->admission_id,
                                            'installment_id' => $payment->installment_ids
                                        ]) }}" class="colorful-pay-btn">
                                            <i class="fas fa-download me-1"></i> Download Slip
                                        </a>

                                        @php
                                            $viewLink = route('admin.pay_slip', [
                                                'id' => $payment->id,
                                                'admission_id' => $payment->admission_id,
                                                'installment_id' => $payment->installment_ids
                                            ]);

                                            $rawNumber = $studentData->phone ?? '';
                                            $cleanNumber = preg_replace('/\D/', '', $rawNumber);
                                            if (substr($cleanNumber, 0, 2) !== '91') {
                                                $cleanNumber = '91' . $cleanNumber;
                                            }
                                            $encodedMessage = urlencode("Dear {$studentData->name},\nHere is your payment slip:\n{$viewLink}\n\nThank you!");
                                        @endphp

                                        @if($cleanNumber)
                                            <a href="https://wa.me/{{ $cleanNumber }}?text={{ $encodedMessage }}"
                                                target="_blank"
                                                class="colorful-pay-btn"
                                                style="background:linear-gradient(90deg,#25D366,#128C7E);margin-top:5px;">
                                                <i class="fab fa-whatsapp"></i> Share Slip
                                            </a>
                                        @endif
                                    </td>

                                    <td>{{ $payment->pay_mode }}</td>
                                    <td>{{ $payment->pay_desc }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->pay_date)->format('d-M-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {!! $payments->links('pagination::bootstrap-4') !!}
                </div>
                @else
                    <div class="alert alert-warning m-3">No records found.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
