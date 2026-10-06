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
            <h4><i class="fas fa-calendar-plus text-primary"></i>
                {{ isset($student) ? 'Edit Admission' : 'Add Admission' }}</h4>
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

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> Please fix the following errors:
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Display Session Messages --}}
                    @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ url('admin/student-save') }}" id="admissionForm"
                        enctype="multipart/form-data">
                        @csrf
                        @if(isset($student))
                        <input type="hidden" name="id" value="{{ $student->id }}">
                        @endif

                        <div class="row">

                            <!-- Basic Details -->
                            <div class="section-header mt-4">Basic Details</div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required
                                        value="{{ old('first_name', $student->first_name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name"
                                        value="{{ old('middle_name', $student->middle_name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" required
                                        value="{{ old('last_name', $student->last_name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Session</label>
                                    <select name="session_id" class="form-control select2" required>
                                        @foreach($session as $sess)
                                        <option value="{{ $sess->id }}"
                                            {{ (old('session_id', $student->session_id ?? '') == $sess->id) ? 'selected' : '' }}>
                                            {{ $sess->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Grade</label>
                                    <select class="form-control" name="grade_id" id="grade_id" required>
                                        <option value="">Select Grade</option>
                                        @foreach($grade as $gra)
                                        <option value="{{ $gra->id }}"
                                            {{ (old('grade_id', $student->grade_id ?? '') == $gra->id) ? 'selected' : '' }}>
                                            {{ $gra->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Section</label>
                                    <select class="form-control" name="section_id" id="section_id" required>
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Admission No</label>
                                    <input type="text" class="form-control" name="admission_no"
                                        value="{{ old('admission_no', $student->admission_no ?? '') }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>School Admission Number</label>
                                    <input type="text" class="form-control" name="school_admission_no"
                                        value="{{ old('school_admission_no', $student->school_admission_no ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Admission Date</label>
                                    <input type="date" class="form-control" name="admission_date"
                                        value="{{ old('admission_date', isset($student) && $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>IEMIS No</label>
                                    <input type="text" class="form-control" name="iemis_no"
                                        value="{{ old('iemis_no', $student->iemis_no ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nickname</label>
                                    <input type="text" class="form-control" name="nickname"
                                        value="{{ old('nickname', $student->nickname ?? '') }}">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Father Name  <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="father_name" required
                                        value="{{ old('father_name', $student->father_name ?? '') }}">
                                </div>
                            </div>


                                   <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mother Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mother_name" required
                                        value="{{ old('mother_name', $student->mother_name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}"
                                        value="{{ old('phone', $student->phone ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $student->email ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <input type="file" name="photo" id="photoInput" accept="image/*">
                                    <small class="text-muted d-block mt-1">Allowed: JPG, PNG | Max size: 2MB</small>
                                    @if(isset($student) && $student->photo)
                                    <img id="photoPreview" class="img-thumbnail mt-2" style="width:120px;"
                                        src="{{ asset('public/uploads/'.$student->photo) }}">
                                    @else
                                    <img id="photoPreview" class="img-thumbnail mt-2" style="display:none; width:120px;"
                                        src="#">
                                    @endif
                                </div>
                            </div>
                            <!-- BS Date -->
                            <div class="col-md-4">
                                <label class="required fw-bold fs-6 mb-2">Date of Birth (BS)</label>
                                <input id="nepaliDate" type="text" name="dob_bs"
                                    class="form-control form-control-solid nepali-date" placeholder="YYYY-MM-DD"
                                    value="{{ old('dob_bs', $student->dob_bs ?? '') }}">
                            </div>

                            <!-- AD Date -->
                            <div class="col-md-4">
                                <label class="required fw-bold fs-6 mb-2">Date of Birth (AD)</label>
                                <input type="date" id="englishDate" name="dob_ad"
                                    class="form-control form-control-solid"
                                    value="{{ old('dob_ad', $student->dob_ad ?? '') }}">
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" required>
                                        <option value="" disabled>Select Gender</option>
                                        <option value="Male"
                                            {{ (old('gender', $student->gender ?? '') == 'Male') ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="Female"
                                            {{ (old('gender', $student->gender ?? '') == 'Female') ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Other"
                                            {{ (old('gender', $student->gender ?? '') == 'Other') ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <input type="text" class="form-control" name="blood_group"
                                        value="{{ old('blood_group', $student->blood_group ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nationality</label>
                                    <input type="text" class="form-control" name="nationality"
                                        value="{{ old('nationality', $student->nationality ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ethnicity</label>
                                    <input type="text" class="form-control" name="ethnicity"
                                        value="{{ old('ethnicity', $student->ethnicity ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mother Tongue</label>
                                    <input type="text" class="form-control" name="mother_tongue"
                                        value="{{ old('mother_tongue', $student->mother_tongue ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" class="form-control" name="contact"
                                        value="{{ old('contact', $student->contact ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Religion</label>
                                    <input type="text" class="form-control" name="religion"
                                        value="{{ old('religion', $student->religion ?? '') }}">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="section-header mt-4">Address</div>

                            <div class="col-md-2 mb-3">
                                <label>State</label>
                                <select name="state" class="form-control">
                                    <option value="">-- Select State --</option>
                                    @foreach([
                                    'Andhra Pradesh','Arunachal
                                    Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal
                                    Pradesh','Jharkhand','Karnataka','Kerala','Madhya
                                    Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil
                                    Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West
                                    Bengal','Delhi','Jammu and Kashmir','Ladakh'
                                    ] as $state)
                                    <option value="{{ $state }}"
                                        {{ (old('state', $student->state ?? '') == $state) ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter City"
                                    value="{{ old('city', $student->city ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" name="pincode"
                                        value="{{ old('pincode', $student->pincode ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ old('address', $student->address ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>
                                    Submit</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Nepali Datepicker CSS & JS -->
<link rel="stylesheet"
    href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css">
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js">
</script>

<script>
$(document).ready(function() {

    // =============================
    // 1️⃣ Load Sections Based on Grade
    // =============================
    function loadSections(selectedGrade, selectedSection = null) {
        if (selectedGrade) {
            $.ajax({
                url: "{{ url('admin/get-sections') }}/" + selectedGrade,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    $('#section_id').empty().append('<option value="">Select Section</option>');

                    $.each(data, function(key, value) {
                        let selected = (selectedSection == value.id) ? 'selected' : '';
                        $('#section_id').append(
                            '<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>'
                        );
                    });
                }
            });
        } else {
            $('#section_id').empty().append('<option value="">Select Section</option>');
        }
    }

    // =============================
    // 2️⃣ On Grade Change
    // =============================
    $('#grade_id').on('change', function() {
        loadSections($(this).val());
    });

    // =============================
    // 3️⃣ Edit Time Auto Load
    // =============================
    @if(isset($student))
        setTimeout(function() {
            loadSections("{{ $student->grade_id }}", "{{ $student->section_id }}");
        }, 200);
    @endif


    // =============================
    // 4️⃣ Photo Preview
    // =============================
    function previewImage(input, previewId) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    }

    $('#photoInput').change(function() {
        previewImage(this, 'photoPreview');
    });


    // =============================
    // 5️⃣ Nepali Datepicker
    // =============================
    $('#nepaliDate').nepaliDatePicker({
        language: "english",
        readOnlyInput: true,
        ndpYear: true,
        ndpMonth: true,
        onChange: function() {
            convertBS2AD();
        }
    });

    // Prefill BS
    var prefilledBS = $('#nepaliDate').val();
    if (prefilledBS) {
        $('#nepaliDate').nepaliDatePicker('setDate', prefilledBS);
    }

    // Prefill AD
    var prefilledAD = $('#englishDate').val();
    if (prefilledAD) {
        $('#englishDate').val(prefilledAD);
    }

    // AD → BS
    $('#englishDate').on('change', function() {
        convertAD2BS();
    });

});


// =============================
// 6️⃣ Conversion Functions
// =============================

// AD → BS
function convertAD2BS() {
    let englishDate = $('#englishDate').val();
    if (englishDate !== '') {
        let dateArray = englishDate.split('-');

        let bsDate = NepaliFunctions.AD2BS({
            year: parseInt(dateArray[0]),
            month: parseInt(dateArray[1]),
            day: parseInt(dateArray[2])
        });

        let bsVal = bsDate.year + '-' +
            String(bsDate.month).padStart(2, '0') + '-' +
            String(bsDate.day).padStart(2, '0');

        $('#nepaliDate').val(bsVal);
    }
}

// BS → AD
function convertBS2AD() {
    let nepaliDate = $('#nepaliDate').val();

    if (nepaliDate !== '') {
        let dateArray = nepaliDate.split('-');

        let adDate = NepaliFunctions.BS2AD({
            year: parseInt(dateArray[0]),
            month: parseInt(dateArray[1]),
            day: parseInt(dateArray[2])
        });

        let adVal = adDate.year + '-' +
            String(adDate.month).padStart(2, '0') + '-' +
            String(adDate.day).padStart(2, '0');

        $('#englishDate').val(adVal);
    }
}
</script>
@endsection
