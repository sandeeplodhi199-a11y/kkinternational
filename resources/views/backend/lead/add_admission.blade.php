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
            <h4><i class="fas fa-calendar-plus text-primary"></i> Add Admission</h4>
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

                    {{-- Display Session Error --}}
                    @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    {{-- Display Session Success --}}
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif


                    <form method="POST" action="{{ url('admin/saveAdmission') }}" id="admissionForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id ?? '' }}">
                        <input type="hidden" name="enrollment_no" value="{{ $admission->enrollment_no ?? '' }}">
                        <input type="hidden" name="admission_id" value="{{ $admission->id ?? '' }}">

                        <div class="row">

                            <!-- Show Lead Info -->
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-info">
                                    Converting Lead: <strong>{{ $lead->name ?? 'N/A' }}</strong>
                                    (Phone: {{ $lead->phone ?? 'N/A' }}, Email: {{ $lead->email ?? 'N/A' }})
                                </div>
                            </div>

                            <!-- Basic Details -->
                            <div class="section-header mt-4">Basic Details</div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Student Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" required name="name"
                                        value="{{ old('name', $admission->name ?? $lead->name ?? '') }}">
                                </div>
                            </div>




                            
                      
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Enrollment No</label>
                                    <input type="text" class="form-control" value="{{ $admission->enrollment_no ?? '' }}" name="enrollment_no"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}"
                                        value="{{ old('phone', $admission->phone ?? $lead->phone ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $admission->email ?? $lead->email ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Father Name</label>
                                    <input type="text" class="form-control" name="fathername"
                                        value="{{ old('fathername', $admission->fathername ?? $lead->fathername ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mother Name</label>
                                    <input type="text" class="form-control" name="mother_name"
                                        value="{{ old('mother_name', $admission->mother_name ?? $lead->mother_name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Father Mobile</label>
                                    <input type="tel" class="form-control" name="father_phone" pattern="[0-9]{10}"
                                        value="{{ old('father_phone', $admission->father_phone ?? $lead->father_phone ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DOB</label>
                                    <input type="date" class="form-control" name="dob"
                                        value="{{ old('dob', $admission->dob ?? $lead->dob ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Aadhar No.</label>
                                    <input type="text" class="form-control" name="aadhar"
                                        value="{{ old('aadhar', $admission->aadhar ?? $lead->aadhar ?? '') }}">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="section-header mt-4">Address</div>

                            <div class="col-md-2 mb-3">
                                <label><strong>State</strong></label>
                                <select name="state" class="form-control">
                                    <option value="">-- Select State --</option>
                                    @foreach([
                                    'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa',
                                    'Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala',
                                    'Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland',
                                    'Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura',
                                    'Uttar Pradesh','Uttarakhand','West Bengal','Delhi','Jammu and Kashmir','Ladakh'
                                    ] as $state)
                                    <option value="{{ $state }}"
                                        {{ old('state', $admission->state ?? $lead->state ?? '') == $state ? 'selected' : '' }}>
                                        {{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label><strong>City</strong></label>
                                <input type="text" name="city" class="form-control" placeholder="Enter City"
                                    value="{{ old('city', $admission->city ?? $lead->city ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" name="pincode"
                                        value="{{ old('pincode', $admission->pincode ?? $lead->pincode ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ old('address', $admission->address ?? $lead->address ?? '') }}">
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="section-header mt-4">Education</div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Highest Qualification</label>
                                    <input type="text" class="form-control" name="high_quali"
                                        value="{{ old('high_quali', $admission->high_quali ?? $lead->high_quali ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Board</label>
                                    <input type="text" class="form-control" name="board"
                                        value="{{ old('board', $admission->board ?? $lead->board ?? '') }}">
                                </div>
                            </div>

                                @php
                            $currentYear = date('Y');
                            $startYear = 2020; 
                            $endYear = 2035;
                            @endphp

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Session Start</label>
                                    <select name="session_start" id="session_start" class="form-control" >
                                        <option value="">Select Start Year</option>
                                        @for($year = $startYear; $year <= $endYear; $year++) <option
                                            value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Session End</label>
                                    <select name="session_end" id="session_end" class="form-control" >
                                        <option value="">Select End Year</option>
                                        {{-- End years dynamically filled via JS --}}
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Main Subject</label>
                                    <input type="text" class="form-control" name="main_subject"
                                        value="{{ old('main_subject', $admission->main_subject ?? $lead->main_subject ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mark Obtain</label>
                                    <input type="text" class="form-control" name="mark_obtain"
                                        value="{{ old('mark_obtain', $admission->mark_obtain ?? $lead->mark_obtain ?? '') }}">
                                </div>
                            </div>
@php
$photo       = $admission->photo ?? '';
$idproof     = $admission->id_proof ?? '';
$certificate = $admission->certificate ?? '';
@endphp


<div class="section-header mt-4">Documentation</div>

<div class="row">

    <!-- Photo -->
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-sm-12">Photo</label>
            <div class="col-sm-12">

                <input type="file" name="photo" id="photoInput" accept="image/*">
                <small class="text-muted d-block mt-1">Allowed: JPG, PNG | Max size: 2MB</small>

                <img id="photoPreview"
                     src="{{ !empty($photo) ? asset('public/uploads/'.$photo) : '#' }}"
                     class="img-thumbnail mt-2"
                     style="width:120px; {{ !empty($photo) ? '' : 'display:none;' }}">
            </div>
        </div>
    </div>

    <!-- ID Proof -->
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-sm-12">ID Proof</label>
            <div class="col-sm-12">

                <input type="file" name="id_proof" id="idProofInput" accept="image/*">
                <small class="text-muted d-block mt-1">Upload Aadhar / PAN / DL</small>

                <img id="idProofPreview"
                     src="{{ !empty($idproof) ? asset('public/uploads/'.$idproof) : '#' }}"
                     class="img-thumbnail mt-2"
                     style="width:120px; {{ !empty($idproof) ? '' : 'display:none;' }}">
            </div>
        </div>
    </div>

    <!-- Certificate PDF -->
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-sm-12">Certificate (PDF)</label>
            <div class="col-sm-12">

                <input type="file" name="certificate" id="certificateInput" accept="application/pdf">
                <small class="text-muted d-block mt-1">Only PDF | Max 5MB</small>

                {{-- Existing PDF View / Download --}}
                @if(!empty($certificate))
                    <a href="{{ asset('public/uploads/'.$certificate) }}" target="_blank"
                       class="btn btn-info btn-sm mt-2">
                        View Certificate
                    </a>
                @endif

                {{-- Live Uploaded PDF Name --}}
                <p id="certificatePreview"
                   class="text-info mt-2"
                   style="display:none;">
                </p>
            </div>
        </div>
    </div>

</div>



                            <!-- Course -->
                            <div class="section-header mt-4">Course</div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Course</label>
                                    <select class="form-control" name="course_id" id="course_id">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $cou)
                                        <option value="{{ $cou->id }}"
                                            {{ old('course_id', $admission->course_id ?? '') == $cou->id ? 'selected' : '' }}>
                                            {{ $cou->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Duration(In Months)</label>
                                    <input type="text" class="form-control" name="duration" readonly
                                        id="course_duration" value="{{ old('duration', $admission->duration ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Course Fees</label>
                                    <input type="text" class="form-control course_fee" name="course_fees" readonly
                                        value="{{ old('course_fees', $admission->course_fees ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Discount Course Fees</label>
                                    <input type="text" class="form-control" name="discount_fees" id="discount_fees"
                                        value="{{ old('discount_fees', $admission->discount_fees ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Branch</label>
                                    <select class="form-control" name="branch_id" id="branch_id">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $bran)
                                        <option value="{{ $bran->id }}"
                                            {{ old('branch_id', $admission->branch_id ?? '') == $bran->id ? 'selected' : '' }}>
                                            {{ $bran->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Batch</label>
                                    <select class="form-control" name="batch_id" id="batch_id">
                                        <option value="">Select Batch</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Admission Date</label>
                                    <input type="date" class="form-control" name="admission_date"
                                        value="{{ old('admission_date', $admission->admission_date ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Net Chargeable Amount</label>
                                    <input type="text" class="form-control" id="net_chargeable_amount"
                                        name="net_chargeable_amount" readonly
                                        value="{{ old('net_chargeable_amount', $admission->net_chargeable_amount ?? '') }}">
                                </div>
                            </div>

                            <!-- Initial Payment Section -->
                            <div class="section-header mt-4">Initial Payment Section</div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Initial Pay Amount</label>
                                    <input type="text" class="form-control" id="initial_pay" name="initial_pay"
                                        value="{{ old('initial_pay', $admission->initial_pay ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Initial Pay Mode</label>
                                    <select class="form-control" id="initial_pay_mode" name="initial_pay_mode">
                                        <option value="">-- Select Mode --</option>
                                        @foreach(['Cash','Online','Bank Transfer','UPI','Cheque'] as $mode)
                                        <option value="{{ $mode }}"
                                            {{ old('initial_pay_mode', $admission->initial_pay_mode ?? '') == $mode ? 'selected' : '' }}>
                                            {{ $mode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Initial Pay Date</label>
                                    <input type="date" class="form-control" id="initial_pay_date"
                                        name="initial_pay_date"
                                        value="{{ old('initial_pay_date', $admission->initial_pay_date ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Balance Amount</label>
                                    <input type="text" class="form-control" id="balance_amount" name="balance_amount"
                                        readonly value="{{ old('balance_amount', $admission->balance_amount ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="pay_initial_desc"
                                        placeholder="Enter Description"
                                        value="{{ old('pay_initial_desc', $admission->pay_initial_desc ?? '') }}">
                                </div>
                            </div>

                            <div class="section-header mt-4">Installment Amount</div>
                            <div id="installment_wrapper">

                                @forelse($InstallmentPaymentAdmission as $inst)
                                <div class="row installment_row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Amount</label>
                                            <input type="number" class="form-control installment_amount"
                                                name="installment_amount[]" value="{{ $inst->amount }}"
                                                placeholder="Enter Amount">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Date</label>
                                            <input type="date" class="form-control" name="installment_date[]"
                                                value="{{ $inst->date }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="installment_desc[]"
                                                value="{{ $inst->desc }}" placeholder="Enter Description">
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-success add_more w-100">+</button>
                                    </div>
                                </div>
                                @empty
                                <!-- Default row when no data -->
                                <div class="row installment_row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Amount</label>
                                            <input type="number" class="form-control installment_amount"
                                                name="installment_amount[]" placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Installment Date</label>
                                            <input type="date" class="form-control" name="installment_date[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="installment_desc[]"
                                                placeholder="Enter Description">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-success add_more w-100">+</button>
                                    </div>
                                </div>
                                @endforelse

                            </div>


                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Total Installment Amount</label>
                                    <input type="text" class="form-control" name="total_installment"
                                        id="total_installment" readonly
                                        value="{{ old('total_installment', $inst->total_installment ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    // ===== AUTO SELECT BRANCH & BATCH ON EDIT =====
    let selectedBranchId = "{{ old('branch_id', $admission->branch_id ?? '') }}";
    let selectedBatchId  = "{{ old('batch_id', $admission->batch_id ?? '') }}";

    // If branch already selected (Edit Mode) → Load batches automatically
    if (selectedBranchId) {
        loadBatches(selectedBranchId, selectedBatchId);
    }

    // ===== Course Details Fetch =====
    $('#course_id').on('change', function() {
        var courseId = $(this).val();
        if (courseId) {
            $.ajax({
                url: "{{ route('get.course.details') }}",
                type: "POST",
                data: {
                    id: courseId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#course_duration').val(response.duration || '');
                    $('.course_fee').val(response.amount || '');
                    calculateFinalFees();
                }
            });
        } else {
            $('#course_duration').val('');
            $('.course_fee').val('');
            calculateFinalFees();
        }
    });

    // ===== Branch → Batch Fetch =====
    $('#branch_id').on('change', function() {
        var branchId = $(this).val();
        loadBatches(branchId); // Batch dropdown load
    });

    // Reusable function to load batches
    function loadBatches(branchId, selectedBatch = null) {
        var batchDropdown = $('#batch_id').html('<option value="">Select Batch</option>');
        if (branchId) {
            $.ajax({
                url: "{{ route('get.batches.by.branch') }}",
                type: "POST",
                data: {
                    branch_id: branchId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(i, batch) {
                            batchDropdown.append('<option value="' + batch.id + '"' +
                                (selectedBatch == batch.id ? ' selected' : '') +
                                '>' + batch.name + '</option>');
                        });
                    } else {
                        batchDropdown.append('<option value="">No Batch Found</option>');
                    }
                }
            });
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    function calculateFinalFees() {
        let courseFee = parseFloat(document.querySelector('.course_fee').value) || 0;
        let discount = parseFloat(document.getElementById('discount_fees').value) || 0;
        let advance = parseFloat(document.getElementById('initial_pay').value) || 0;
        let finalAmount = courseFee - discount;
        let balance = finalAmount - advance;
        document.getElementById('net_chargeable_amount').value = finalAmount.toFixed(2);
        document.getElementById('balance_amount').value = balance.toFixed(2);
        calculateTotalInstallment(); // recalc installment on fee change
    }

    document.getElementById('discount_fees').addEventListener('input', calculateFinalFees);
    document.getElementById('initial_pay').addEventListener('input', calculateFinalFees);
    document.querySelector('.course_fee').addEventListener('input', calculateFinalFees);

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add_more')) {
            let clone = e.target.closest('.installment_row').cloneNode(true);
            clone.querySelectorAll('input').forEach(i => i.value = '');
            clone.querySelector('button').classList.remove('btn-success', 'add_more');
            clone.querySelector('button').classList.add('btn-danger', 'remove_row');
            clone.querySelector('button').innerText = '-';
            document.getElementById('installment_wrapper').appendChild(clone);
        }

        if (e.target.classList.contains('remove_row')) {
            e.target.closest('.installment_row').remove();
            calculateTotalInstallment();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('installment_amount')) {
            calculateTotalInstallment();
        }
    });

    function calculateTotalInstallment() {
        let total = 0;
        document.querySelectorAll('.installment_amount').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total_installment').value = total.toFixed(2);
    }

    // ✅ Auto calculate when page loads (Important line)
    calculateTotalInstallment();

    // === Prevent Submit if installments != balance ===
    document.getElementById('admissionForm').addEventListener('submit', function(e) {
        let balance = parseFloat(document.getElementById('balance_amount').value) || 0;
        let totalInstallment = parseFloat(document.getElementById('total_installment').value) || 0;
        if (balance !== totalInstallment) {
            e.preventDefault();
            alert('Total Installment Amount must be equal to Balance Amount (' + balance.toFixed(2) + ')');
        }
    });

});
</script>



<script>
$("#session_start").on("change", function() {
    let startYear = parseInt($(this).val());
    let endDropdown = $("#session_end");

    endDropdown.empty(); 
    endDropdown.append(`<option value="">Select End Year</option>`);

    for (let year = startYear; year <= 2035; year++) {
        endDropdown.append(`<option value="${year}">${year}</option>`);
    }
});
</script>
<script>
    // Photo Preview
    document.getElementById('photoInput').addEventListener('change', function(e){
        previewImage(e, 'photoPreview', ['image/jpeg', 'image/png']);
    });

    // ID Proof Preview
    document.getElementById('idProofInput').addEventListener('change', function(e){
        previewImage(e, 'idProofPreview', ['image/jpeg', 'image/png']);
    });

    // Image preview function
    function previewImage(event, previewId, allowedTypes = []) {
        let file = event.target.files[0];
        if(file && (allowedTypes.length === 0 || allowedTypes.includes(file.type))){
            let reader = new FileReader();
            reader.onload = function(){
                let img = document.getElementById(previewId);
                img.src = reader.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            // Hide preview if file not allowed
            document.getElementById(previewId).style.display = 'none';
        }
    }

    // Certificate PDF Name Preview
    document.getElementById('certificateInput').addEventListener('change', function(e){
        let file = e.target.files[0];
        let preview = document.getElementById('certificatePreview');
        if(file && file.type === 'application/pdf'){
            preview.innerText = "Selected: " + file.name;
            preview.style.display = 'block';
        } else {
            preview.innerText = '';
            preview.style.display = 'none';
        }
    });
</script>



@endsection