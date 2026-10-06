@extends('backend.layouts.app')

@section('content')
<style>
/* ===== Buttons ===== */
.btn-group-sm>.btn,
.btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
    margin-left: 200px !important;
    background-color: #3d956e;
    color: white;
}

/* ===== Background Wrapper ===== */
.payment-bg-wrapper {
    position: relative;
    min-height: 100vh;
    background-image: url('{{ url("assets/frontend/assets/imgs/banner/banner-13.png") }}'); /* 🔹 Change image path if needed */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 40px 0;
}

/* Subtle overlay for readability */
.payment-bg-wrapper::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.85); /* white overlay with transparency */
    z-index: 0;
    backdrop-filter: blur(2px);
}

/* Keep all content above overlay */
.payment-container {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: auto;
}

/* ===== General Styling ===== */
body {
    background: #f7f9fc;
}

.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: linear-gradient(135deg, #007bff, #00c6ff);
    color: #fff;
    padding: 1rem 1.5rem;
    border-bottom: none;
}

.card-header h4,
.card-header h5 {
    margin: 0;
    font-weight: 600;
}

.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table thead {
    background: #007bff;
    color: #fff;
    border-radius: 10px;
}

.table thead th {
    text-align: center;
    padding: 10px;
    font-weight: 600;
}

.table tbody tr {
    background: #fff;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.table tbody tr:hover {
    background: #f1f6ff;
    transform: scale(1.01);
}

.table td {
    vertical-align: middle;
    text-align: center;
    padding: 10px;
}

.badge-type {
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 12px;
}

.badge-initial {
    background: #28a745;
    color: #fff;
}

.badge-installment {
    background: #ffc107;
    color: #000;
}

.highlight-row {
    background: #e8f5e9 !important;
}

.table-success {
    background: #e8fce8 !important;
    font-weight: 600;
    color: #28a745;
}

h4.text-primary {
    font-weight: 700;
    border-left: 5px solid #007bff;
    padding-left: 10px;
}

h5.text-info {
    font-weight: 600;
    color: #007bff !important;
}

.table-danger {
    background: #ffe8e8 !important;
    font-weight: 600;
    color: #dc3545;
}

/* Print button floating */
.print-btn {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    padding: 12px 15px;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    z-index: 1000;
}
.print-btn:hover {
    background: #0056b3;
}
</style>

<div class="payment-bg-wrapper">
    <div class="container payment-container mt-4">
        <h4 class="mb-3 text-primary">Payment History</h4>

        {{-- ===== Student Details Card ===== --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-money-check-alt me-2"></i> Student Details
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-light btn-sm shadow-sm">
                        <i class="fas fa-print text-primary"></i> Print
                    </button>

                    <button class="btn btn-success btn-sm shadow-sm" onclick="sharePaymentHistory()">
                        <i class="fab fa-whatsapp"></i> Share on WhatsApp
                    </button>

                    <a href="{{ url('admin/payment-history-share/' . $admission->id) }}"
                        class="btn btn-danger btn-sm shadow-sm">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
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
                        <th>Course Discount</th>
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
        </div>

        {{-- ===== Payment History Card ===== --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5><i class="fas fa-money-check-alt me-2"></i> Payment History</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
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

                        @foreach ($initialPayments as $payment)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><span class="badge badge-type badge-initial">Initial Payment</span></td>
                            <td><strong>₹{{ number_format($payment->pay_amount, 2) }}</strong></td>
                            <td>{{ $payment->pay_mode }}</td>
                            <td>{{ $payment->pay_desc }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pay_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y h:i A') }}</td>
                        </tr>
                        @endforeach

                        @foreach ($installmentPayments as $payment)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><span class="badge badge-type badge-installment">Installment</span></td>
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
    </div>
</div>

{{-- Floating print button --}}
<button class="print-btn" onclick="window.print()" title="Print">
    <i class="fas fa-print"></i>
</button>

<script>
function sharePaymentHistory() {
    const studentId = "{{ $admission->id }}";
    const studentName = "{{ $admission->name }}";
    const studentPhone = "{{ $admission->phone }}"; // student phone number
    const shareUrl = "{{ url('admin/payment-history-share') }}/" + studentId;

    // remove non-digit characters and ensure country code (India = 91)
    let phone = studentPhone.replace(/\D/g, '');
    if (!phone.startsWith('91')) {
        phone = '91' + phone;
    }

    // create message
    const message = `📄 Payment History of ${studentName}\n\nYou can download your payment details here:\n${shareUrl}`;

    // open WhatsApp directly to student's chat
    const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}
</script>
@endsection
