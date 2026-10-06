@extends('backend.layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.section-header {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 5px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}
</style>

<div class="content-wrapper">
    <div class="row mart10 padd mb-2">
        <div class="col-md-8">
            <h4><i class="fas fa-calendar-plus text-primary"></i> Pay Installment Amount</h4>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ url('admin/leadmaster') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-users-cog"></i> Manage Lead
            </a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">

                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {!! Session::get('success') !!}
                    </div>
                    @endif

                    @if (Session::has('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> {!! Session::get('error') !!}
                    </div>
                    @endif

                    <style>
                    /* ===== Premium Animated Checkbox Design ===== */
                    .premium-checkbox {
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        cursor: pointer;
                        font-weight: 500;
                        position: relative;
                    }

                    .premium-checkbox input[type="checkbox"] {
                        appearance: none;
                        -webkit-appearance: none;
                        width: 22px;
                        height: 22px;
                        border: 2px solid #888;
                        border-radius: 6px;
                        background: linear-gradient(135deg, #f0f0f0, #ffffff);
                        position: relative;
                        cursor: pointer;
                        transition: all 0.3s ease;
                    }

                    .premium-checkbox input[type="checkbox"]:checked {
                        background: linear-gradient(135deg, #00b09b, #96c93d);
                        border-color: #00b09b;
                    }

                    .premium-checkbox input[type="checkbox"]::after {
                        content: "";
                        position: absolute;
                        top: 3px;
                        left: 7px;
                        width: 6px;
                        height: 12px;
                        border: solid white;
                        border-width: 0 2px 2px 0;
                        opacity: 0;
                        transform: scale(0.8) rotate(45deg);
                        transition: all 0.3s ease;
                    }

                    .premium-checkbox input[type="checkbox"]:checked::after {
                        opacity: 1;
                        transform: scale(1) rotate(45deg);
                    }

                    /* ===== Premium Animated Border for Installment Row ===== */
                    @keyframes premium-glow {
                        0% {
                            box-shadow: 0 0 10px #00b09b, inset 0 0 10px #96c93d;
                            border-color: #00b09b;
                        }

                        50% {
                            box-shadow: 0 0 25px #96c93d, inset 0 0 15px #00b09b;
                            border-color: #96c93d;
                        }

                        100% {
                            box-shadow: 0 0 10px #00b09b, inset 0 0 10px #96c93d;
                            border-color: #00b09b;
                        }
                    }

                    .installment_row {
                        border: 2px solid #ccc;
                        border-radius: 10px;
                        background: #fff;
                        transition: all 0.3s ease;
                    }

                    .installment_row.active-glow {
                        animation: premium-glow 2s infinite alternate;
                        border-width: 5px;
                    }

                    #total_installment {
                        background: #f8f9fa;
                        font-weight: bold;
                        text-align: center;
                    }

                    #payment {
                        font-weight: 600;
                        color: #0b6b3a;
                    }
                    </style>

                    <form method="POST" action="{{ url('admin/saveInstallmentPay') }}" id="admissionForm">
                        @csrf

                        <input type="hidden" name="enrollment_no" value="{{ $admission->enrollment_no ?? '' }}">
                        <input type="hidden" name="admission_id" value="{{ $admission->id ?? '' }}">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-info">
                                    Pay Installment Amount: <strong>{{ $admission->name ?? 'N/A' }}</strong>
                                    (Enrollment No: {{ $admission->enrollment_no ?? 'N/A' }}, Phone:
                                    {{ $admission->phone ?? 'N/A' }}, Email: {{ $admission->email ?? 'N/A' }}) <br><br>
                                    Total Balance Amount :- <strong>{{ $admission->balance_amount ?? 'N/A' }}</strong>
                                </div>
                            </div>

                            <div class="section-header mt-4">Installment Amount</div>

                            <div id="installment_wrapper">
                                @foreach($InstallmentPaymentAdmission as $index => $inst)
                                @php
                                // Calculate remaining balance logic
                                $paidAmount = $inst->total_receive_amount ?? 0;
                                $installmentAmount = $inst->amount ?? 0;
                                $remaining = $installmentAmount - $paidAmount;

                                // Determine status
                                $isFullyPaid = $paidAmount >= $installmentAmount;
                                $isPartialPaid = $paidAmount > 0 && !$isFullyPaid;
                                @endphp

                                <div class="row installment_row align-items-end p-2 mb-2 shadow-sm {{ $isFullyPaid ? 'bg-light' : '' }}"
                                    style="{{ $isFullyPaid ? 'opacity:0.6; pointer-events:none;' : '' }}">

                                    <input type="hidden" name="installment_id" value="{{ $inst->id }}">

                                    <div class="col-md-1 text-center">
                                        <label class="premium-checkbox">
                                            <input type="checkbox" class="installment_check"
                                                data-amount="{{ $isFullyPaid ? 0 : $remaining }}"
                                                {{ $isFullyPaid ? 'disabled' : '' }}>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Amount</label>
                                            <input type="number" class="form-control installment_amount"
                                                name="installment_amount[]" value="{{ $installmentAmount }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Date</label>
                                            <input type="date" class="form-control" name="installment_date[]"
                                                value="{{ $inst->date }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="installment_desc[]"
                                                value="{{ $inst->desc }}" placeholder="Enter Description" readonly>
                                        </div>
                                    </div>

                                    {{-- ✅ Payment Status Section --}}
                                    <div class="col-md-12 mt-2">
                                        @if($isFullyPaid)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle"></i> Already Paid
                                            (₹{{ number_format($paidAmount,2) }})
                                        </span>
                                        @elseif($isPartialPaid)
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-hourglass-half"></i> Partially Paid — Remaining
                                            ₹{{ number_format($remaining,2) }}
                                        </span>
                                        @else
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-info-circle"></i> Pending —
                                            ₹{{ number_format($installmentAmount,2) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>


                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Total Installment Amount</label>
                                    <input type="text" class="form-control" name="total_installment"
                                        id="total_installment" readonly>
                                </div>
                            </div>

                            <div class="section-header mt-4"> Payment Section</div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pay Amount</label>
                                    <input type="text" class="form-control" id="payment" name="payment">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pay Mode</label>
                                    <select class="form-control" id="pay_mode" name="pay_mode">
                                        <option value="">-- Select Mode --</option>
                                        @foreach(['Cash','Online','Bank Transfer','UPI','Cheque'] as $mode)
                                        <option value="{{ $mode }}">{{ $mode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pay Date</label>
                                    <input type="date" class="form-control" id="pay_date" name="pay_date">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="pay_desc"
                                        placeholder="Enter Description">
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('.installment_check');
                        const rows = document.querySelectorAll('.installment_row');
                        const totalInstallmentField = document.getElementById('total_installment');
                        const paymentField = document.getElementById('payment');
                        const form = document.getElementById('admissionForm');

                        // ✅ Sequential glow animation
                        function updateGlowSequence() {
                            rows.forEach(r => r.classList.remove('active-glow'));
                            for (let i = 0; i < checkboxes.length; i++) {
                                const amount = parseFloat(checkboxes[i].getAttribute('data-amount')) || 0;
                                if (!checkboxes[i].checked && amount > 0) {
                                    rows[i].classList.add('active-glow');
                                    break;
                                }
                            }
                        }

                        // ✅ Update total payment
                        function updateTotal() {
                            let total = 0;
                            checkboxes.forEach(chk => {
                                const amount = parseFloat(chk.getAttribute('data-amount')) || 0;
                                if (chk.checked) total += amount;
                            });
                            totalInstallmentField.value = total.toFixed(2);
                            paymentField.value = total.toFixed(2);
                            updateGlowSequence();
                        }

                        // ✅ Add or remove hidden inputs dynamically (LIVE)
                        function syncHiddenInputs() {
                            // Remove old hidden fields
                            document.querySelectorAll('.hidden-installment-id').forEach(el => el.remove());

                            // Add new hidden fields for checked checkboxes
                            checkboxes.forEach((chk, index) => {
                                if (chk.checked) {
                                    const instId = rows[index].querySelector(
                                        'input[name="installment_id"]').value;
                                    const hidden = document.createElement('input');
                                    hidden.type = 'hidden';
                                    hidden.name = 'installment_ids[]';
                                    hidden.value = instId;
                                    hidden.classList.add('hidden-installment-id');
                                    form.appendChild(hidden);
                                }
                            });
                        }

                        // ✅ Event Listeners
                        checkboxes.forEach(chk => {
                            chk.addEventListener('change', function() {
                                updateTotal();
                                syncHiddenInputs();
                            });
                        });

                        // ✅ On form submit, ensure sync is done once more
                        form.addEventListener('submit', function() {
                            syncHiddenInputs();
                        });

                        updateGlowSequence();
                    });
                    </script>

                </div>
            </div>
        </div>
    </section>

</div>

@endsection