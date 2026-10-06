@extends('backend.layouts.app')

@section('content')
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet"
    href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css">

<style>
/* Custom Styles */
.aside .aside-menu .menu>.menu-item {
    margin-bottom: unset;
}

.table.gy-5 td,
.table.gy-5 th {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.btn.btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    height: calc(0.5em + 1.55rem + 2px);
    width: calc(0.5em + 1.55rem + 2px);
}

a.badge:hover {
    color: white;
}

.btn-spinner-border {
    --bs-spinner-width: 1rem;
    --bs-spinner-height: 1rem;
}

.pointer {
    cursor: pointer;
}

.btn .svg-icon {
    margin: 0;
}

.image-input .image-input-wrapper {
    width: 120px;
    height: 120px;
    border-radius: .95rem;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
}

.print-content {
    position: sticky;
    top: 50px;
}

.print-area {
    transform: scale(.55);
    transform-origin: top center;
}

.print-area .certificate-sheet {
    height: 297mm;
    width: 210mm;
    position: relative;
    background-size: 100% 100% !important;
    background-repeat: no-repeat;
    margin: 0 auto;
}

.single-certificate {
    height: 100%;
    width: 100%;
    background-size: 100% 100%;
    font-family: "Arial Narrow", Helvetica, sans-serif;
    position: relative;
}

.single-certificate * {
    font-family: "Arial Narrow", Helvetica, sans-serif;
}

.certificate-head {
    position: absolute;
    text-align: center;
    width: 100%;
    top: 130px;
    left: 0;
}

.certificate-head .certificate-title {
    font-size: 2rem;
    text-transform: uppercase;
    font-weight: bolder;
    text-align: center;
}

.certificate-contents {
    z-index: 5;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bolder;
    position: absolute;
    font-size: 1.1rem;
    width: 100%;
    top: 280px;
    left: 0;
    display: flex;
    justify-content: center;
}

.certificate-contents .content-data {
    width: 85%;
    text-transform: uppercase;
    font-size: 1.1rem;
}

.certificate-contents .content-data td {
    padding-bottom: 8px;
}

.certificate-contents .content-data .content-title {
    width: 320px;
    display: inline-block;
}

.certificate-contents .content-data .content-value::before {
    content: ":";
    padding-right: 5px;
}

.signature {
    position: absolute;
    bottom: 60px;
    right: 80px;
    text-align: center;
    text-transform: uppercase;
    font-weight: bolder;
    font-size: 1.1rem;
}

@media screen {
    body {
        background: #e0e0e0;
    }

    .print-area .certificate-sheet {
        background: white;
        box-shadow: 0 0.5mm 2mm rgba(0, 0, 0, 0.3);
        margin: 5mm auto;
    }
}

@media print {
    body * {
        visibility: hidden;
    }

    .print-area,
    .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0;
        transform: scale(1);
    }

    .print-area .certificate-sheet {
        margin: 0;
        box-shadow: none;
    }

    .card-footer,
    .card-header,
    .col-6:first-child {
        display: none;
    }

    .col-6:last-child {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

.custom-bg-header {
    background-image: url('https://kkinternationalschool.org/storage/6/331008408_732822508522939_6267815551310343921_n.jpg') !important;
    background-position: 100%;
    background-repeat: no-repeat;
    background-size: 100%;
    position: relative;
}

.custom-bg-header::before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: #2C294B88;
    z-index: 0;
}

.custom-bg-header .header-container {
    z-index: 2;
}

.fv-row .required:after {
    content: "*";
    color: red;
    margin-left: 4px;
}
</style>
<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container-fluid py-4">

        <!-- Filter and Add Button -->
        <div class="row align-items-end mb-4">
            <div id="kt_header" class="header py-6 py-lg-0 custom-bg-header" data-kt-sticky="true"
                data-kt-sticky-name="header" data-kt-sticky-offset="{lg: '300px'}">
                <div class="header-offset"></div>
            </div>

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="container-xxl" id="kt_content_container">
                    <div class="card" id="certificateCard">
                        <div class="card-header border-0 px-6">
                            <div class="card-title">
                                <h1 class="d-flex align-items-center position-relative my-1">Student Character
                                    Certificate</h1>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <!-- Form Column -->
                                <div class="col-6">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Serial Number</label>
                                                <input type="text" id="sn" class="form-control form-control-solid"
                                                    placeholder="Serial Number" value="{{ $student->id ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Admission Number</label>
                                                <input type="text" id="admissionNo"
                                                    class="form-control form-control-solid"
                                                    placeholder="Admission Number"
                                                    value="{{ $student->admission_no ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Student Name</label>
                                                <input type="text" id="studentName"
                                                    class="form-control form-control-solid" placeholder="Student Name"
                                                    value="{{ trim(implode(' ', array_filter([optional($student)->first_name, optional($student)->middle_name, optional($student)->last_name]))) }}" />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Father's Name</label>
                                                <input type="text" id="fatherName"
                                                    class="form-control form-control-solid" placeholder="Father's Name"
                                                    value="{{ $student->father_name ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Mother's Name</label>
                                                <input type="text" id="motherName"
                                                    class="form-control form-control-solid" placeholder="Mother's Name"
                                                    value="{{ $student->mother_name ?? '' }}" />
                                            </div>
                                        </div>

                                        <!-- Date of Admission -->
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Date of Admission
                                                            (BS)</label>
                                                        <input type="text" id="admissionDateBS"
                                                            class="form-control form-control-solid nepali-date"
                                                            placeholder="YYYY-MM-DD"
                                                            value="{{ isset($student->admission_date) ? $student->admission_date : '' }}" />
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Date of Admission
                                                            (AD)</label>
                                                        <input type="date" id="admissionDateAD"
                                                            class="form-control form-control-solid"
                                                            value="{{ isset($student->admission_date) ? \Carbon\Carbon::parse($student->admission_date)->format('Y-m-d') : '' }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Date of Birth
                                                            (BS)</label>
                                                        <input type="text" id="dobBS"
                                                            class="form-control form-control-solid nepali-date"
                                                            placeholder="YYYY-MM-DD"
                                                            value="{{ $student->dob_bs ?? '' }}" />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Date of Birth
                                                            (AD)</label>
                                                        <input type="date" id="dobAD"
                                                            class="form-control form-control-solid"
                                                            value="{{ $student->dob_ad ?? '' }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Last Grade</label>
                                                <input type="text" id="lastGrade"
                                                    class="form-control form-control-solid" placeholder="Last Grade"
                                                    value="{{ $student->last_grade ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Is Promoted ?</label>
                                                <select id="isPromoted" class="form-control form-control-solid">
                                                    <option value="Yes"
                                                        {{ ($student->is_promoted ?? '') == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ ($student->is_promoted ?? '') == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="fv-row mb-7">
                                                <label class="fw-bold fs-6 mb-2">Promoted Grade</label>
                                                <input type="text" id="promotedGrade"
                                                    class="form-control form-control-solid" placeholder="Promoted Grade"
                                                    value="{{ $student->promoted_grade ?? '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Dues Cleared?</label>
                                                <select id="duesPaid" class="form-control form-control-solid">
                                                    <option value="Yes"
                                                        {{ ($student->dues_paid ?? '') == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ ($student->dues_paid ?? '') == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">GAMES PLAYED/EXTRA-CURRICULAR
                                                    ACTIVITIES</label>
                                                <input type="text" id="eca" class="form-control form-control-solid"
                                                    placeholder="Games/Extra-curricular activities"
                                                    value="{{ $student->eca ?? 'PARTICIPATED IN ECA/CCA' }}" />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">General
                                                    Characteristics</label>
                                                <input type="text" id="generalChar"
                                                    class="form-control form-control-solid"
                                                    placeholder="General Characteristics"
                                                    value="{{ $student->general_character ?? 'Good' }}" />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Reason for Leaving
                                                    School</label>
                                                <input type="text" id="reason" class="form-control form-control-solid"
                                                    placeholder="Reason for leaving"
                                                    value="{{ $student->reason ?? 'Personal' }}" />
                                            </div>
                                        </div>

                                        <!-- Issue Date -->
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Issue Date
                                                            (BS)</label>
                                                        <input type="text" id="issueDateBS"
                                                            class="form-control form-control-solid nepali-date"
                                                            placeholder="YYYY-MM-DD"
                                                            value="{{ $student->issue_date_bs ?? '' }}" />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Issue Date
                                                            (AD)</label>
                                                        <input type="date" id="issueDateAD"
                                                            class="form-control form-control-solid"
                                                            value="{{ $student->issue_date_ad ?? '' }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Preview Column -->
                                <div class="col-6">
                                    <div class="print-content">
                                        <div class="print-area">
                                            <div class="certificate-sheet" id="certificateSheet"
                                                style="background-image: url('https://www.kkinternationalschool.org/id-card/kk-letter.jpg')">
                                                <div class="single-certificate">
                                                    <div class="certificate-head">
                                                        <p class="certificate-title">Transfer / Character <br />
                                                            certificate</p>
                                                    </div>
                                                    <div class="certificate-contents">
                                                        <table class="content-data">
                                                            <tr>
                                                                <td style="padding-bottom: 30px"><span class="SN">S.No.
                                                                        : </span><span id="previewSN"></span></td>
                                                                <td style="padding-bottom: 30px"><span
                                                                        class="AN">Admission No: </span><span
                                                                        id="previewAdmissionNo"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">Name of Student</span>
                                                                </td>
                                                                <td><span class="content-value"
                                                                        id="previewStudentName"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">FATHER'S NAME</span>
                                                                </td>
                                                                <td><span class="content-value"
                                                                        id="previewFatherName"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">MOTHER'S NAME</span>
                                                                </td>
                                                                <td><span class="content-value"
                                                                        id="previewMotherName"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">DATE OF ADMISSION IN
                                                                        SCHOOL</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewAdmissionDate"> B.S. <span
                                                                            id="previewAdmissionDateBS"></span> (A.D.
                                                                        <span
                                                                            id="previewAdmissionDateAD"></span>)</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">DATE OF BIRTH</span>
                                                                </td>
                                                                <td><span class="content-value" id="previewDob"> B.S.
                                                                        <span id="previewDobBS"></span> (A.D. <span
                                                                            id="previewDobAD"></span>)</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">GRADE IN WHICH STUDENT
                                                                        LAST STUDIED</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewLastGrade"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">WHETHER QUALIFIED FOR
                                                                        PROMOTION TO NEXT CLASS</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewIsPromoted">Yes</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">IF SO, TO WHICH
                                                                        CLASS</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewPromotedGrade"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">ARE SCHOOL DUES
                                                                        PAID</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewDuesPaid">Yes</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">GAMES
                                                                        PLAYED/EXTRA-CURRICULAR ACTIVITIES</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewEca">PARTICIPATED IN ECA/CCA</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">GENERAL
                                                                        CHARACTER/CONDUCT</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewGeneralChar">Good</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">REASON FOR LEAVING
                                                                        SCHOOL</span></td>
                                                                <td><span class="content-value"
                                                                        id="previewReason">Personal</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="content-title">DATE OF ISSUE OF
                                                                        TRANSFER CERTIFICATE</span></td>
                                                                <td><span class="content-value" id="previewIssueDate">
                                                                        B.S. <span id="previewIssueDateBS"></span> (A.D.
                                                                        <span id="previewIssueDateAD"></span>)</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="signature">
                                                        <p>_____________________________ <br /> Harischandra Budhathoki
                                                            <br />Principal
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="printBtn">Print Certificate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Initialize Nepali Date Pickers
$(document).ready(function() {
    // Initialize all nepali date pickers
    $('.nepali-date').nepaliDatePicker({
        language: "english",
        readOnlyInput: true,
        ndpYear: true,
        ndpMonth: true,
        onChange: function() {
            // Trigger update on change
            updatePreview();
        }
    });

    // Bind all input events
    $('#sn, #admissionNo, #studentName, #fatherName, #motherName, #lastGrade, #promotedGrade, #eca, #generalChar, #reason')
        .on('input', updatePreview);
    $('#isPromoted, #duesPaid').on('change', updatePreview);
    $('#admissionDateAD, #dobAD, #issueDateAD').on('change', function() {
        // When AD date changes, update BS date if needed (simplified)
        updatePreview();
    });


    $('.nepali-date').on('change', updatePreview);

    // Initial preview update
    updatePreview();
});

function updatePreview() {
    // Get all values
    let sn = $('#sn').val() || '';
    let admissionNo = $('#admissionNo').val() || '';
    let studentName = $('#studentName').val() || '';
    let fatherName = $('#fatherName').val() || '';
    let motherName = $('#motherName').val() || '';
    let lastGrade = $('#lastGrade').val() || '';
    let isPromoted = $('#isPromoted').val() || 'Yes';
    let promotedGrade = $('#promotedGrade').val() || '';
    let duesPaid = $('#duesPaid').val() || 'Yes';
    let eca = $('#eca').val() || 'PARTICIPATED IN ECA/CCA';
    let generalChar = $('#generalChar').val() || 'Good';
    let reason = $('#reason').val() || 'Personal';

    let admissionDateBS = $('#admissionDateBS').val() || '';
    let admissionDateAD = $('#admissionDateAD').val() || '';
    let dobBS = $('#dobBS').val() || '';
    let dobAD = $('#dobAD').val() || '';
    let issueDateBS = $('#issueDateBS').val() || '';
    let issueDateAD = $('#issueDateAD').val() || '';

    // Update preview spans
    $('#previewSN').text(sn);
    $('#previewAdmissionNo').text(admissionNo);
    $('#previewStudentName').text(studentName);
    $('#previewFatherName').text(fatherName);
    $('#previewMotherName').text(motherName);
    $('#previewLastGrade').text(lastGrade);
    $('#previewIsPromoted').text(isPromoted);
    $('#previewPromotedGrade').text(promotedGrade);
    $('#previewDuesPaid').text(duesPaid);
    $('#previewEca').text(eca);
    $('#previewGeneralChar').text(generalChar);
    $('#previewReason').text(reason);

    $('#previewAdmissionDateBS').text(admissionDateBS);
    $('#previewAdmissionDateAD').text(admissionDateAD);
    $('#previewDobBS').text(dobBS);
    $('#previewDobAD').text(dobAD);
    $('#previewIssueDateBS').text(issueDateBS);
    $('#previewIssueDateAD').text(issueDateAD);

    // Update combined fields
    $('#previewAdmissionDate').html(` B.S. ${admissionDateBS || ''} (A.D. ${admissionDateAD || ''})`);
    $('#previewDob').html(` B.S. ${dobBS || ''} (A.D. ${dobAD || ''})`);
    $('#previewIssueDate').html(` B.S. ${issueDateBS || ''} (A.D. ${issueDateAD || ''})`);
}

$('#printBtn').on('click', function() {

    // ================== AJAX START ==================
    let student_id = $('#sn').val();

    $.ajax({
        url: "{{ route('transfer.certificate.save') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",

            student_id: student_id,
            serial_no: student_id,

            admission_no: $('#admissionNo').val(),
            student_name: $('#studentName').val(),
            father_name: $('#fatherName').val(),
            mother_name: $('#motherName').val(),

            admission_date_bs: $('#admissionDateBS').val(),
            admission_date_ad: $('#admissionDateAD').val(),

            dob_bs: $('#dobBS').val(),
            dob_ad: $('#dobAD').val(),

            last_grade: $('#lastGrade').val(),
            is_promoted: $('#isPromoted').val(),
            promoted_grade: $('#promotedGrade').val(),
            dues_paid: $('#duesPaid').val(),

            eca: $('#eca').val(),
            general_character: $('#generalChar').val(),
            reason: $('#reason').val(),

            issue_date_bs: $('#issueDateBS').val(),
            issue_date_ad: $('#issueDateAD').val()
        },

        success: function(res) {

            if (res.status) {

                Toast.fire({
                    icon: 'success',
                    title: res.message
                });

                // ✅ 1. URL same rakho (id ho ya na ho)
                let currentUrl = window.location.href;

                // ✅ 2. delay ke baad reload (print disturb nahi hoga)
                setTimeout(function() {
                    window.location.href = currentUrl;
                }, 1500);

            } else {

                Toast.fire({
                    icon: 'error',
                    title: res.message
                });

            }

        },

        error: function(err) {
            console.log(err);
        }
    });
    // ================== AJAX END ==================


    // ================== AAPKA ORIGINAL PRINT CODE (UNCHANGED) ==================
    let printContent = $('.print-area').clone();
    let originalTitle = document.title;
    let printWindow = window.open('', '_blank', 'width=1000,height=700');
    printWindow.document.write(`
            <html>
                <head>
                    <title>Character Certificate</title>
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        body { font-family: "Arial Narrow", Helvetica, sans-serif; background: white; }
                        .print-area { transform: scale(1); margin: 0 auto; }
                        .certificate-sheet {
                            height: 297mm;
                            width: 210mm;
                            background-size: 100% 100% !important;
                            background-repeat: no-repeat;
                            position: relative;
                            margin: 0 auto;
                        }
                        .single-certificate { height: 100%; width: 100%; position: relative; }
                        .certificate-head {
                            position: absolute;
                            text-align: center;
                            width: 100%;
                            top: 130px;
                            left: 0;
                        }
                        .certificate-head .certificate-title {
                            font-size: 2rem;
                            text-transform: uppercase;
                            font-weight: bolder;
                        }
                        .certificate-contents {
                            position: absolute;
                            font-size: 1.1rem;
                            width: 100%;
                            top: 280px;
                            left: 0;
                            display: flex;
                            justify-content: center;
                        }
                        .certificate-contents .content-data {
                            width: 85%;
                            text-transform: uppercase;
                        }
                        .certificate-contents .content-data td {
                            padding-bottom: 8px;
                        }
                        .certificate-contents .content-data .content-title {
                            width: 320px;
                            display: inline-block;
                        }
                        .certificate-contents .content-data .content-value::before {
                            content: ":";
                            padding-right: 5px;
                        }
                        .signature {
                            position: absolute;
                            bottom: 60px;
                            right: 80px;
                            text-align: center;
                            text-transform: uppercase;
                            font-weight: bolder;
                            font-size: 1.1rem;
                        }
                        @media print {
                            body { margin: 0; padding: 0; }
                            .certificate-sheet { margin: 0; box-shadow: none; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent.html()}
                    <script>
                        window.onload = function() { 
                            window.print(); 
                            window.onafterprint = function() { window.close(); }; 
                        }
                    <\/script>
                </body>
            </html>
        `);
    printWindow.document.close();
});

// Toast setup
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});
</script>
@endsection