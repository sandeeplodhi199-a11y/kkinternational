@extends('backend.layouts.app')

@section('content')
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css">

<style>
.fv-row .required:after { content: "*"; color: red; margin-left: 4px; }
.gender-btn-group .btn  { border-radius: 4px !important; font-size: 0.85rem; }

.print-content { position: sticky; top: 30px; }
.print-area    { transform: scale(0.52); transform-origin: top center; }

.certificate-sheet-10th {
    width: 335mm;
    height: 216mm;
    position: relative;
    background-color: #fff;
    background-size: 100% 100% !important;
    background-repeat: no-repeat;
    margin: 0 auto;
    box-sizing: border-box;
    font-family: "Inter", "Calibri", Arial, sans-serif;
    overflow: hidden;
    margin-left: -238px;
}

.cert-sno-line {
    position: absolute;
    top: 236px;
    left: 56px;
    font-size: 20px;
    font-weight: 700;
    color: #111;
    font-family: "Inter", Arial, sans-serif;
}

.cert-title-row {
    position: absolute;
    top: 97px;
    left: 130px;
    right: 30px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.cert-title-dash {
    flex: 1;
    height: 3px;
    background: #1a56db;
    border-radius: 2px;
}
.cert-title-text {
    font-size: 0.92rem;
    font-weight: 900;
    color: #1a56db;
    text-transform: uppercase;
    letter-spacing: 2px;
    white-space: nowrap;
}

.cert-body-text {
    position: absolute;
    top: 280px;
    left: 50px;
    right: 49px;
    bottom: 48px;
    font-size: 20px;
    line-height: 1.62;
    font-family: "Inter", Arial, sans-serif;
    color: #111;
    text-align: justify;
    overflow: hidden;
}

.cert-body-text p   { margin: 0 0 3px 0; }
.cert-body-text .hl { font-weight: 700; }

.cert-reg-block {
    margin-top: 7px;
    font-size: 21px;
    line-height: 1.2;
}
.cert-reg-block table td:first-child {
    width: 118px;
    font-weight: 600;
    font-size: 18px;
    font-family: "Inter", Arial, sans-serif;
    white-space: nowrap;
}
.cert-reg-block table td:nth-child(2) { width: 14px; font-weight: 700; }

.cert-footer-names {
    position: absolute;
    bottom: 89px;
    left: 77px;
    right: 49px;
    display: flex;
    justify-content: space-between;
}
.cert-footer-name-col {
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    min-width: 100px;
    font-family: "Inter", Arial, sans-serif;
}

table { border: 0px solid #ccc; }

.span.hl.footer {
    font-size: 15px !important;
    font-family: "Inter", Arial, sans-serif !important;
}

@media screen {
    .certificate-sheet-10th { box-shadow: 0 1mm 4mm rgba(0,0,0,.25); }
}
@media print {
    body * { visibility: hidden; }
    .print-area, .print-area * { visibility: visible; }
    .print-area {
        position: absolute; top: 0; left: 0;
        width: 100%; margin: 0; transform: scale(1);
    }
    .certificate-sheet-10th { margin: 0; box-shadow: none; }
    .card-footer, .card-header, .col-6:first-child { display: none !important; }
    .col-6:last-child { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
}
</style>

<div class="content-wrapper">
  <div class="container-fluid py-4">
    <div class="content d-flex flex-column flex-column-fluid">
      <div class="container-xxl">
        <div class="card">

          <div class="card-header border-0 px-6">
            <div class="card-title">
              <h1 class="my-1">10th Grade Transfer / Character Certificate</h1>
            </div>
          </div>

          <div class="card-body pt-0">
            <div class="row">

              <!-- ========== FORM ========== -->
              <div class="col-6">
                <div class="row g-3">

                  <input type="hidden" id="transfer_id" value="{{ $transfer->id         ?? ($student->id ?? '') }}">
                  <input type="hidden" id="student_id"  value="{{ $transfer->student_id ?? ($student->id ?? '') }}">

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Serial Number</label>
                    <input type="text" id="sn" class="form-control form-control-solid"
                      placeholder="174/2082-083"
                      value="{{ $transfer->serial_no ?? ($student->id ?? '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Registration / Admission No</label>
                    <input type="text" id="admissionNo" class="form-control form-control-solid"
                      placeholder="821102650024"
                      value="{{ $transfer->admission_no ?? ($student->admission_no ?? '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Symbol No</label>
                    <input type="text" id="symbolNo" class="form-control form-control-solid"
                      placeholder="01011074 'L'"
                      value="{{ $transfer->symbol_no ?? '' }}" />
                  </div>

                  {{-- ✅ NEW: IEMIS No field --}}
                  <div class="col-6">
                    <label class="fw-bold fs-6 mb-1">IEMIS No</label>
                    <input type="text" id="iemisNo" class="form-control form-control-solid"
                      placeholder="IEMIS Number"
                      value="{{ $transfer->iemis_no ?? '' }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Gender</label>
                    <div class="d-flex gap-2 gender-btn-group mt-1">
                      <button type="button" id="btnHe"  class="btn btn-sm flex-fill" onclick="setGender('male')">👦 He (Male)</button>
                      <button type="button" id="btnShe" class="btn btn-sm flex-fill" onclick="setGender('female')">👧 She (Female)</button>
                    </div>
                    <input type="hidden" id="gender" value="{{ $transfer->gender ?? ($student->gender ?? 'male') }}" />
                  </div>

                  <div class="col-12">
                    <label class="required fw-bold fs-6 mb-1">Student Full Name</label>
                    <input type="text" id="studentName" class="form-control form-control-solid"
                      placeholder="NAMAN SHAH"
                      value="{{ $transfer->student_name ?? (isset($student) ? trim(implode(' ', array_filter([$student->first_name ?? '', $student->middle_name ?? '', $student->last_name ?? '']))) : '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Father's Name</label>
                    <input type="text" id="fatherName" class="form-control form-control-solid"
                      placeholder="MANOJ SHAH"
                      value="{{ $transfer->father_name ?? ($student->father_name ?? '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Mother's Name</label>
                    <input type="text" id="motherName" class="form-control form-control-solid"
                      placeholder="NITU GUPTA"
                      value="{{ $transfer->mother_name ?? ($student->mother_name ?? '') }}" />
                  </div>

                  <div class="col-3">
                    <label class="fw-bold fs-6 mb-1">Ward No</label>
                    <input type="text" id="wardNo" class="form-control form-control-solid"
                      placeholder="01"
                      value="{{ $transfer->ward_no ?? ($student->address ?? '') }}" />
                  </div>

                  <div class="col-5">
                    <label class="fw-bold fs-6 mb-1">City / Municipality</label>
                    <input type="text" id="city" class="form-control form-control-solid"
                      placeholder="Dharan Sub Metropolitan City"
                      value="{{ $transfer->city ?? ($student->city ?? 'Dharan Sub Metropolitan City') }}" />
                  </div>

                  <div class="col-4">
                    <label class="fw-bold fs-6 mb-1">District</label>
                    <input type="text" id="district" class="form-control form-control-solid"
                      placeholder="Sunsari"
                      value="{{ $transfer->district ?? ($student->pincode ?? 'Sunsari') }}" />
                  </div>

                  <div class="col-4">
                    <label class="fw-bold fs-6 mb-1">Province</label>
                    <input type="text" id="province" class="form-control form-control-solid"
                      placeholder="Koshi"
                      value="{{ $transfer->province ?? ($student->state ?? 'Koshi') }}" />
                  </div>

                  <div class="col-4">
                    <label class="fw-bold fs-6 mb-1">Country</label>
                    <input type="text" id="country" class="form-control form-control-solid"
                      placeholder="Nepal"
                      value="{{ $transfer->country ?? 'Nepal' }}" />
                  </div>

                  <div class="col-4">
                    <label class="required fw-bold fs-6 mb-1">Exam Year (A.D.)</label>
                    <input type="text" id="examYear" class="form-control form-control-solid"
                      placeholder="2026"
                      value="{{ $transfer->exam_year ?? date('Y') }}" />
                  </div>

                  <div class="col-4">
                    <label class="fw-bold fs-6 mb-1">GPA</label>
                    <input type="text" id="gpa" class="form-control form-control-solid"
                      placeholder="3.58"
                      value="{{ $transfer->gpa ?? '' }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Date of Birth (BS)</label>
                    <input type="text" id="dobBS" class="form-control form-control-solid nepali-date"
                      placeholder="2067-10-20"
                      value="{{ $transfer->dob_bs ?? ($student->dob_bs ?? '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Date of Birth (AD)</label>
                    <input type="date" id="dobAD" class="form-control form-control-solid"
                      value="{{ $transfer->dob_ad ?? ($student->dob_ad ?? '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Date of Issue</label>
                    <input type="text" id="issueDate" class="form-control form-control-solid nepali-date"
                      placeholder="2082-01-30"
                      value="{{ $transfer->issue_date ?? (isset($student->transfer_date) ? $student->transfer_date : '') }}" />
                  </div>

                  <div class="col-6">
                    <label class="required fw-bold fs-6 mb-1">Principal Name</label>
                    <input type="text" id="principalName" class="form-control form-control-solid"
                      placeholder="Harischandra Budhathoki"
                      value="{{ $transfer->principal_name ?? 'Harischandra Budhathoki' }}" />
                  </div>

                  <div class="col-6">
                    <label class="fw-bold fs-6 mb-1">Prepared By</label>
                    <input type="text" id="preparedBy" class="form-control form-control-solid"
                      placeholder="Staff Name"
                      value="{{ $transfer->prepared_by ?? '' }}" />
                  </div>

                  <div class="col-6">
                    <label class="fw-bold fs-6 mb-1">School Seal </label>
                    <input type="text" id="schoolSeal" class="form-control form-control-solid"
                      placeholder="K.K. International School"
                      value="{{ $transfer->school_seal ?? '' }}" />
                  </div>

                </div>
              </div><!-- /form -->

              <!-- ========== PREVIEW ========== -->
              <div class="col-6">
                <div class="print-content">
                  <div class="print-area">
                    <div class="certificate-sheet-10th"
                         style="background-image: url('{{ url('public/10th_cer.jpeg') }}');">

                      <div class="cert-sno-line">S.No.: <span id="previewSN"></span></div>

                      <div class="cert-body-text" id="certBody"></div>

                      <div class="cert-footer-names">
                        <div class="cert-footer-name-col" id="previewPreparedBy"></div>
                        <div class="cert-footer-name-col" id="previewSchoolSeal"></div>
                        <div class="cert-footer-name-col" id="previewPrincipalName"></div>
                      </div>

                    </div>
                  </div>
                </div>
              </div><!-- /preview -->

            </div>
          </div>

          <div class="card-footer">
            <button class="btn btn-primary" id="printBtn">
              <i class="fas fa-save me-1"></i> Save &amp; Print Certificate
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function setGender(g) {
    $('#gender').val(g);
    if (g === 'male') {
        $('#btnHe').removeClass('btn-light-danger btn-light-primary').addClass('btn-primary text-white');
        $('#btnShe').removeClass('btn-danger text-white').addClass('btn-light-danger');
    } else {
        $('#btnShe').removeClass('btn-light-danger').addClass('btn-danger text-white');
        $('#btnHe').removeClass('btn-primary text-white').addClass('btn-light-primary');
    }
    updatePreview();
}

function updatePreview() {
    var g = $('#gender').val() || 'male';
    var isMale = (g === 'male');
    var mrMrs = isMale ? 'Mr.' : 'Ms.';
    var heShe = isMale ? 'He' : 'She';
    var hisHer = isMale ? 'His' : 'Her';
    var himHer = isMale ? 'him' : 'her';
    var sonDau = isMale ? 'son' : 'daughter';

    var sn            = $('#sn').val()            || '';
    var studentName   = $('#studentName').val()   || '___________';
    var fatherName    = $('#fatherName').val()    || '___________';
    var motherName    = $('#motherName').val()    || '___________';
    var wardNo        = $('#wardNo').val()         || '__';
    var city          = $('#city').val()           || 'Dharan Sub Metropolitan City';
    var district      = $('#district').val()      || 'Sunsari';
    var province      = $('#province').val()      || 'Koshi';
    var country       = $('#country').val()       || 'Nepal';
    var examYear      = $('#examYear').val()      || '____';
    var gpa           = $('#gpa').val()            || '____';
    var dobBS         = $('#dobBS').val()          || '____-__-__';
    var dobAD         = $('#dobAD').val()          || '____-__-__';
    var admissionNo   = $('#admissionNo').val()   || '___________';
    var symbolNo      = $('#symbolNo').val()      || '___________';
    var iemisNo       = $('#iemisNo').val()        || '';            // ✅ IEMIS
    var issueDate     = $('#issueDate').val()      || '___________';

    // ✅ FIX: No fallback default — blank stays blank in preview
    var principalName = $('#principalName').val() || '';
    var preparedBy    = $('#preparedBy').val()    || '';
    var schoolSeal    = $('#schoolSeal').val()    || '';

    var html = '<p>This is to certify that <span class="hl">' + mrMrs + ' ' + studentName.toUpperCase() + '</span>, '
        + sonDau + ' of Mr. <span class="hl">' + fatherName.toUpperCase() + '</span>'
        + ' and Mrs. <span class="hl">' + motherName.toUpperCase() + '</span>,'
        + ' an inhabitant of ward number-' + wardNo + ', ' + city + ', District ' + district
        + ', Province ' + province + ', ' + country + ' was a bona fide student of this school. '
        + heShe + ' has passed the Secondary Education Examination conducted by the National Examinations Board'
        + ' in Grade 10 held in the year <span class="hl">' + examYear + '</span> A.D.'
        + ' with <span class="hl">' + gpa + '</span> GPA.</p>'
        + '<p>' + hisHer + ' date of birth according to the school record is'
        + ' <span class="hl">' + dobBS + '</span> B.S. / <span class="hl">' + dobAD + '</span> A.D.</p>'
        + '<p>' + heShe + ' actively participated in co-curricular and sports activities of the school.</p>'
        + '<p>' + heShe + ' bears a good moral Character.</p>'
        + '<p>We wish ' + himHer + ' the very best for the future.</p>'
        + '<div class="cert-reg-block"><table>' // Fixed: properly concatenated table opening
        + '<tr><td>IEMIS No.</td><td>:</td><td><span class="hl footer">' + iemisNo + '</span></td></tr>'
        + '<tr><td>Registration No.</td><td>:</td><td><span class="hl footer">' + admissionNo + '</span></td></tr>'
        + '<tr><td>Symbol No.</td><td>:</td><td><span class="hl footer">' + symbolNo + '</span></td></tr>'
        + '<tr><td>Date of Issue</td><td>:</td><td><span class="hl footer">' + issueDate + '</span></td></tr>'
        + '</table></div>'; // Fixed closing tag

    $('#certBody').html(html);
    $('#previewSN').text(sn);

    // ✅ FIX: blank principal stays blank in footer preview
    $('#previewPrincipalName').text(principalName);
    $('#previewPreparedBy').text(preparedBy);
    $('#previewSchoolSeal').text(schoolSeal);
}

$(document).ready(function () {
    $('.nepali-date').nepaliDatePicker({
        language: "english", readOnlyInput: true, ndpYear: true, ndpMonth: true,
        onChange: function () { updatePreview(); }
    });

    // ✅ iemisNo added to input listener
    $('#sn,#admissionNo,#symbolNo,#iemisNo,#studentName,#fatherName,#motherName,#wardNo,#city,#district,#province,#country,#examYear,#gpa,#principalName,#preparedBy,#schoolSeal')
        .on('input', updatePreview);
    $('#dobAD').on('change', updatePreview);
    $('.nepali-date').on('change', updatePreview);
    setGender($('#gender').val() || 'male');
    updatePreview();
});

$('#printBtn').on('click', function () {
    var transfer_id = $('#transfer_id').val();
    var student_id  = $('#student_id').val();
    var postData = {
        _token:         '{{ csrf_token() }}',
        serial_no:      $('#sn').val(),
        admission_no:   $('#admissionNo').val(),
        symbol_no:      $('#symbolNo').val(),
        iemis_no:       $('#iemisNo').val(),       // ✅ IEMIS save
        student_name:   $('#studentName').val(),
        father_name:    $('#fatherName').val(),
        mother_name:    $('#motherName').val(),
        gender:         $('#gender').val(),
        ward_no:        $('#wardNo').val(),
        city:           $('#city').val(),
        district:       $('#district').val(),
        province:       $('#province').val(),
        country:        $('#country').val(),
        exam_year:      $('#examYear').val(),
        gpa:            $('#gpa').val(),
        dob_bs:         $('#dobBS').val(),
        dob_ad:         $('#dobAD').val(),
        issue_date:     $('#issueDate').val(),
        principal_name: $('#principalName').val(),
        prepared_by:    $('#preparedBy').val(),
        school_seal:    $('#schoolSeal').val(),
    };
    if (transfer_id && transfer_id.trim() !== '') postData.id = transfer_id;
    if (student_id  && student_id.trim()  !== '') postData.student_id = student_id;

    $.ajax({
        url:  '{{ route("transfer.certificate.10th.save") }}',
        type: 'POST',
        data: postData,
        success: function (res) {
            if (res.status) {
                Swal.fire({ icon: 'success', title: res.message, timer: 1500, showConfirmButton: false });
                if (res.data && res.data.id)         $('#transfer_id').val(res.data.id);
                if (res.data && res.data.student_id) $('#student_id').val(res.data.student_id);
                setTimeout(openPrintWindow, 700);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong!';
            Swal.fire('Error', msg, 'error');
        }
    });
});

function openPrintWindow() {
    var certHtml = document.querySelector('.certificate-sheet-10th').outerHTML;
    var pw = window.open('', '_blank', 'width=1200,height=850');
    pw.document.write('<!DOCTYPE html>'
        + '<html><head>'
        + '<meta charset="utf-8"/>'
        + '<title>10th Transfer Certificate</title>'
        + '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />'
        + '<style>'
        + '*{margin:0;padding:0;box-sizing:border-box;font-family:"Inter",Arial,sans-serif}'
        + 'html,body{width:297mm;height:210mm;overflow:hidden;background:#fff}'
        + '.certificate-sheet-10th{width:297mm;height:210mm;background-size:100% 100%!important;background-repeat:no-repeat;position:relative;overflow:hidden}'
        + ' .cert-sno-line {'
        + '   position: absolute;'
        + '   top: 236px;'
        + '   left: 56px;'
        + '   font-size: 20px;'
        + '   font-weight: 700;'
        + '   color: #111;'
        + '   font-family: "Inter", Arial, sans-serif;'
        + ' }'
        + '.cert-body-text{position:absolute;top:280px;left:50px;right:49px;bottom:48px;font-size:20px;line-height:1.62;font-family:"Inter",Arial,sans-serif;color:#111;text-align:justify;overflow:hidden}'
        + '.cert-body-text p{margin:0 0 3px 0}'
        + '.cert-body-text .hl{font-weight:700}'
        + '.cert-reg-block{margin-top:7px;font-size:21px;line-height:1.2;font-family:"Inter",Arial,sans-serif}'
        + '.cert-reg-block table td:first-child{width:118px;font-weight:600;font-size:18px;font-family:"Inter",Arial,sans-serif;  white-space: nowrap;}'
        + '.cert-reg-block table td:nth-child(2){width:14px;font-weight:700}'
        + '.cert-footer-names{position:absolute;bottom:89px;left:77px;right:49px;display:flex;justify-content:space-between}'
        + '.cert-footer-name-col{text-align:center;font-size:20px;font-weight:600;min-width:100px;font-family:"Inter",Arial,sans-serif}'
        + '@media print{@page{size:297mm 210mm;margin:0}html,body{width:297mm;height:210mm}}'
        + '</style>'
        + '</head><body>'
        + certHtml
        + '<script>window.onload=function(){window.print();window.onafterprint=function(){window.close()}};<\/script>'
        + '</body></html>'
    );
    pw.document.close();
}
</script>
@endsection