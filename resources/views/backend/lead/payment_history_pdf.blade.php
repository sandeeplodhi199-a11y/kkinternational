<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment History - {{ $admission->name }}</title>

    <style>
        /* ====== REMOVE ALL PDF MARGINS ====== */
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        /* ====== FULL PAGE BACKGROUND (DOMPDF Compatible) ====== */
        .slip-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 794px;     /* A4 PDF width in px */
            height: 1123px;   /* A4 PDF height in px */
            z-index: -1;
        }

        .payment-container {
            padding: 20px 25px;
            position: relative;
            z-index: 2;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            padding: 10px 15px;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            padding: 8px 15px;
            border-radius: 10px;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: #007bff;
            color: #fff;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        .badge-type {
            font-size: 0.85rem;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        .badge-initial {
            background: #28a745;
            color: #fff;
        }

        .badge-installment {
            background: #ffc107;
            color: #000;
        }

        .table-success {
            background: #e8fce8 !important;
            font-weight: 600;
            color: #28a745;
        }

        .table-danger {
            background: #ffe8e8 !important;
            font-weight: 600;
            color: #dc3545;
        }
    </style>

</head>

<body>

    <!-- FULL PAGE BACKGROUND IMAGE -->
    <img src="{{ url('public/uploads/' . $payment_history) }}" class="slip-bg" alt="Slip Background">

    <div class="payment-container">

        {{-- Student Details --}}
        <div class="card">
            <div class="card-header">
                <h5>Student Details</h5>
            </div>

            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>{{ $admission->name }}</td>
                    <th>Enrollment No</th>
                    <td>{{ $admission->enrollment_no }}</td>
                </tr>

                <tr>
                    <th>Course Name</th>
                    @php
                        $courseName = DB::table('tbl_course')->where('id', $admission->course_id)->value('name');
                    @endphp
                    <td>{{ $courseName }}</td>

                    <th>Duration</th>
                    <td>{{ $admission->duration }}</td>
                </tr>

                <tr>
                    <th>Course Fees</th>
                    <td>₹{{ number_format($admission->course_fees, 2) }}</td>
                    <th>Discount</th>
                    <td>₹{{ number_format($admission->discount_fees, 2) }}</td>
                </tr>

                <tr>
                    <th>Net Chargeable</th>
                    <td colspan="3"><strong>₹{{ number_format($admission->net_chargeable_amount, 2) }}</strong></td>
                </tr>

                <tr class="table-success">
                    <th>Total Paid</th>
                    <td colspan="3"><strong>₹{{ number_format($total_paid, 2) }}</strong></td>
                </tr>

                <tr class="table-danger">
                    <th>Pending Payment</th>
                    <td colspan="3"><strong>₹{{ number_format($admission->balance_amount ?? 0, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Payment History --}}
        <div class="card">
            <div class="card-header">
                <h5>Payment History</h5>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Payment Type</th>
                        <th>Pay Amount (₹)</th>
                        <th>Pay Mode</th>
                        <th>Description</th>
                        <th>Pay Date</th>
                        <th>Created At</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $i = 1;
                        $initialPayments = $payments->where('installment_id', 'Initial');
                        $installmentPayments = $payments->where('installment_id', '!=', 'Initial');
                    @endphp

                    {{-- Initial Payment --}}
                    @foreach ($initialPayments as $payment)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><span class="badge-type badge-initial">Initial Payment</span></td>
                            <td><strong>₹{{ number_format($payment->pay_amount, 2) }}</strong></td>
                            <td>{{ $payment->pay_mode }}</td>
                            <td>{{ $payment->pay_desc }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pay_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y h:i A') }}</td>
                        </tr>
                    @endforeach

                    {{-- Installments --}}
                    @foreach ($installmentPayments as $payment)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><span class="badge-type badge-installment">Installment</span></td>
                            <td><strong>₹{{ number_format($payment->pay_amount, 2) }}</strong></td>
                            <td>{{ $payment->pay_mode }}</td>
                            <td>{{ $payment->pay_desc }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pay_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y h:i A') }}</td>
                        </tr>
                    @endforeach

                    @if($payments->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center text-muted">No payments found.</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>

    </div>

</body>

</html>
