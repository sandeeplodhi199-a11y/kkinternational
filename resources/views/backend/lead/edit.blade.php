@extends('backend.layouts.app')

@section('content')




<div class="content-wrapper">
    <!-- Page Header -->
    <div class="container-fluid py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-0">Edit Manager</h2>
            </div>
            <div class="col-md-4 text-md-right text-center mt-2 mt-md-0">
                <a href="{{ url('admin/manager') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-list"></i> Manage Manager
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Manager</h4>
                            <small>{{ \Carbon\Carbon::now()->format('d-M-Y h:i:s A') }}</small>
                        </div>
                        <br>
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                        </div>
                        @endif


                        @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            {!! \Session::get('error') !!}
                        </div>
                        @endif


                        <form method="POST" action="{{ url('admin/Updatelead') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $lead->id ?? '' }}">

                            <div class="card-body">
                                <div class="row">


                                    <!-- Right Form Fields -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <!-- Name -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-user text-primary"></i> Name <span
                                                            class="text-danger">*</span></strong></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $lead->name ?? '') }}" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-envelope text-primary"></i>
                                                        Email</strong></label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email', $lead->email ?? '') }}">
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-phone text-primary"></i> Phone <span
                                                            class="text-danger">*</span></strong></label>
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ old('phone', $lead->phone ?? '') }}" required>
                                            </div>

                                            <!-- Class -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-chalkboard-teacher text-primary"></i>
                                                        Class</strong></label>
                                                <input type="text" name="class" class="form-control"
                                                    value="{{ old('class', $lead->class ?? '') }}"
                                                    placeholder="Enter your Class">
                                            </div>

                                            <!-- School Name -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-school text-primary"></i> School
                                                        Name</strong></label>
                                                <input type="text" name="school_name" class="form-control"
                                                    value="{{ old('school_name', $lead->school_name ?? '') }}"
                                                    placeholder="Enter your School Name">
                                            </div>

                                            <!-- Course -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-book text-primary"></i>
                                                        Course</strong></label>
                                                <select name="course_id" class="form-control select2">
                                                    <option value="">Select Course</option>
                                                    @foreach ($courses as $cou)
                                                    <option value="{{ $cou->id }}"
                                                        {{ (old('course_id', $lead->course_id ?? '') == $cou->id) ? 'selected' : '' }}>
                                                        {{ $cou->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Guardian Phone -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-phone text-primary"></i> Guardian
                                                        Phone</strong></label>
                                                <input type="text" name="gaurdian_phone" class="form-control"
                                                    value="{{ old('gaurdian_phone', $lead->gaurdian_phone ?? '') }}"
                                                    placeholder="Enter Guardian Phone">
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-venus-mars text-primary"></i>
                                                        Gender</strong></label>
                                                <select name="gender" class="form-control">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ (old('gender', $lead->gender ?? '') == 'Male') ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ (old('gender', $lead->gender ?? '') == 'Female') ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="Other"
                                                        {{ (old('gender', $lead->gender ?? '') == 'Other') ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                            </div>

                                            <!-- Description -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-calendar-alt text-primary"></i>
                                                        Description</strong></label>
                                                <input type="text" name="description" class="form-control"
                                                    value="{{ old('description', $lead->description ?? '') }}">
                                            </div>

                                            <!-- Address -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-map-marker-alt text-primary"></i>
                                                        Address</strong></label>
                                                <input type="text" name="address" class="form-control"
                                                    value="{{ old('address', $lead->address ?? '') }}"
                                                    placeholder="Enter your Address">
                                            </div>

                                            <!-- Visited -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-eye text-primary"></i>
                                                        Visited</strong></label>
                                                <select name="visitied" class="form-control select2">
                                                    <option value="">Select Visited</option>
                                                    <option value="yes"
                                                        {{ (old('visitied', $lead->visitied ?? '') == 'yes') ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="no"
                                                        {{ (old('visitied', $lead->visitied ?? '') == 'no') ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>

                                            <!-- Purpose -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-bullseye text-primary"></i>
                                                        Purpose</strong></label>
                                                @php $selectedPurposes = old('purpose_id', explode(',',
                                                $lead->purpose_id ?? '')); @endphp
                                                <select name="purpose_id" class="form-control select2">
                                                    <option value="">Select Purpose</option>
                                                    @foreach ($purposes as $purpose)
                                                    <option value="{{ $purpose->id }}"
                                                        {{ in_array($purpose->id, (array)$selectedPurposes) ? 'selected' : '' }}>
                                                        {{ $purpose->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Source -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-source text-primary"></i>
                                                        Source</strong></label>
                                                @php $selectedSources = explode(',', $lead->source_id ?? ''); @endphp
                                                <select name="source_id" class="form-control select2">
                                                    <option value="">Select Source</option>
                                                    @foreach ($sources as $source)
                                                    <option value="{{ $source->id }}"
                                                        {{ in_array($source->id, $selectedSources) ? 'selected' : '' }}>
                                                        {{ $source->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-tasks text-primary"></i>
                                                        Status</strong></label>
                                                @php $selectedStatus = explode(',', $lead->status_id ?? ''); @endphp
                                                <select name="status_id" class="form-control select2">
                                                    <option value="">Select Status</option>
                                                    @foreach ($status as $sta)
                                                    <option value="{{ $sta->id }}"
                                                        {{ in_array($sta->id, $selectedStatus) ? 'selected' : '' }}>
                                                        {{ $sta->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Manager
                                </button>
                                <a href="{{ url('admin/manager-list') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>





<script>
document.addEventListener("DOMContentLoaded", function() {
    // Image preview
    const imageInput = document.getElementById("image");
    const previewImage = document.getElementById("preview-image");

    imageInput.addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // DOB → Age auto-calc
    const dobInput = document.getElementById("dob");
    const ageInput = document.getElementById("age");

    dobInput.addEventListener("change", function() {
        const dob = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        ageInput.value = age >= 0 ? age : '';
    });
});
</script>



@endsection