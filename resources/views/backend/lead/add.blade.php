@extends('backend.layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="container-fluid py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-0">Add New Lead</h2>
            </div>
            <div class="col-md-4 text-md-right text-center mt-2 mt-md-0">
                <a href="{{ url('admin/lead') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-list"></i> Manage Lead
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
                            <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add Lead</h4>
                            <span>{{ \Carbon\Carbon::now()->format('d-M-Y h:i:s A') }}</span>
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

                        <form method="POST" action="{{ url('admin/Savelead') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Fields -->
                                    <div class="col-md-12">
                                        <div class="row">

                                            <!-- Full Name -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-user text-primary"></i> Full Name <span
                                                            class="text-danger">*</span></strong></label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter Full Name" required>
                                            </div>
                                            <!-- Email -->
                                            <div class="col-md-4 mb-3">
                                                <label for="email"><strong><i class="fas fa-envelope text-primary"></i>
                                                        Email </strong></label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Enter your email">
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-phone text-primary"></i>
                                                        Phone <span class="text-danger">*</span></strong></label>
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Enter phone" required>
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label for="class">
                                                    <strong><i class="fas fa-chalkboard-teacher text-primary"></i>
                                                        Class</strong>
                                                </label>
                                                <input type="text" name="class" id="class" class="form-control"
                                                    placeholder="Enter your Class">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="school_name">
                                                    <strong><i class="fas fa-school text-primary"></i> School
                                                        Name</strong>
                                                </label>
                                                <input type="text" name="school_name" id="school_name"
                                                    class="form-control" placeholder="Enter your School Name">
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-code-course text-primary"></i>
                                                        Course</strong></label>
                                                <select name="course_id" class="form-control select2">
                                                    <option>Select Course</option>
                                                    @foreach ($courses as $cou)
                                                    <option value="{{ $cou->id }}">{{ $cou->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Purpose -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-code-purpose text-primary"></i>
                                                        Purpose</strong></label>
                                                <select name="purpose_id" class="form-control select2">
                                                    <option>Select Purpose</option>
                                                    @foreach ($purposes as $pur)
                                                    <option value="{{ $pur->id }}">{{ $pur->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Gaurdian Phone -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-phone text-primary"></i>
                                                        Gaurdian Phone <span class=""></span></strong></label>
                                                <input type="text" name="gaurdian_phone" class="form-control"
                                                    placeholder="Enter Gaurdian Phone" required>
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-venus-mars text-primary"></i>
                                                        Gender</strong></label>
                                                <select name="gender" class="form-control">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <!-- Description -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-calendar-alt text-primary"></i>
                                                        Description</strong></label>
                                                <input type="text" name="description" id="description"
                                                    class="form-control">
                                            </div>




                                            <!-- Address -->
                                            <div class="col-md-4 mb-3">
                                                <label for="Address"><strong><i class="fas fa-lock text-primary"></i>
                                                        Address <span class=""></span></strong></label>
                                                <input type="text" name="address" id="address" class="form-control"
                                                    placeholder="Enter your Address">

                                            </div>



                                            <!-- Visitied -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-code-visitied text-primary"></i>
                                                        Visitied</strong></label>
                                                <select name="visitied" class="form-control select2">
                                                    <option>Select Visitied</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>

                                                </select>
                                            </div>

                                            <!-- Source -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-code-source text-primary"></i>
                                                        Source</strong></label>
                                                <select name="source_id" class="form-control select2">
                                                    <option>Select Source</option>
                                                    @foreach ($sources as $sou)
                                                    <option value="{{ $sou->id }}">{{ $sou->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-4 mb-3">
                                                <label><strong><i class="fas fa-code-status text-primary"></i>
                                                        Status</strong></label>
                                                <select name="status_id" class="form-control select2">
                                                    <option>Select Status</option>
                                                    @foreach ($status as $sou)
                                                    <option value="{{ $sou->id }}">{{ $sou->name }}</option>
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
                                    <i class="fas fa-save"></i> Save Manager
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection