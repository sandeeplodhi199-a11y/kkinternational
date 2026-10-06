<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Slip #{{ $mainPayment->trans_id }}</title>

    <style>
        @page {
            size: 210mm 148mm; /* A5 Landscape */
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .slip-container {
            position: relative;
            width: 210mm;
            height: 148mm;
        }

        .slip-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 148mm;
            z-index: 0;
        }

        /* Dynamic data */
        .field {
            position: absolute;
            z-index: 1;
            font-size: 10pt;
            color: #000;
        }

        /* Example positions — adjust to fit your template */
        .student-name { top: 40mm; left: 20mm; font-weight: bold; }
        .enrollment-no { top: 44mm; left: 20mm; }
        .address { top: 48mm; left: 20mm; width: 80mm; }
        .phone { top: 60mm; left: 20mm; }
        .email { top: 64mm; left: 20mm; }

        .transaction-id { top: 40mm; left: 140mm; font-weight: bold; }
        .date { top: 44mm; left: 140mm; }

        /* Payment table example */
        .payment-table {
            position: absolute;
            top: 80mm;
            left: 10mm;
            width: 190mm;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
        }

        .footer { position: absolute; bottom: 15mm; left: 0; width: 100%; text-align: center; font-size: 9pt; }
    </style>
</head>

<body>
<div class="slip-container">

    <!-- Background template -->
    <img src="{{ url('public/uploads/'.$slip_payment) }}" class="slip-bg" alt="Slip Template">

    <!-- Dynamic Fields -->
    <div class="field student-name">{{ $student->name }}</div>
    <div class="field enrollment-no">Enrollment No: {{ $mainPayment->enrollment_no }}</div>
    <div class="field address">{{ $student->address }}, {{ $student->city }}, {{ $student->state }} - {{ $student->pincode }}</div>
    <div class="field phone">Phone: {{ $student->phone }}</div>
    <div class="field email">Email: {{ $student->email }}</div>

    <div class="field transaction-id">Transaction ID: {{ $mainPayment->trans_id }}</div>
    <div class="field date">Date: {{ \Carbon\Carbon::parse($mainPayment->created_at)->format('d M Y') }}</div>

    <!-- Payment Table -->
    <table class="payment-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Course Name</th>
            <th>Due Date</th>
            <th>Mode</th>
            <th>Description</th>
            <th>Paid Date</th>
            <th>Amount (₹)</th>
        </tr>
        </thead>
        <tbody>
        @php
            $courseName = DB::table('tbl_course')->where('id', $student->course_id)->value('name');
        @endphp
        @foreach($payments as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $courseName }}</td>
                <td>{{ $p->installment_date_during_payment ?? '-' }}</td>
                <td>{{ $p->pay_mode }}</td>
                <td>{{ $p->pay_desc ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->pay_date)->format('d M Y') }}</td>
                <td>{{ number_format($p->pay_amount, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">Grand Total</td>
            <td><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
        </tr>
        </tfoot>
    </table>

    <div class="footer">Thank you for your payment.</div>

</div>
</body>
</html>
