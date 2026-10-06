@extends('backend.layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Header -->
    <div class="container-fluid py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-0">Bulk Upload</h2>
            </div>
            <!--<div class="col-md-4 text-md-right text-center mt-2 mt-md-0">-->
            <!--    <a href="{{ url('admin/tl') }}" class="btn btn-outline-primary btn-sm">-->
            <!--        <i class="fas fa-list"></i> Manage Bulk Upload-->
            <!--    </a>-->
            <!--</div>-->
        </div>
    </div>

    <!-- Main Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card shadow-sm border-0">

                        <!-- Card Header -->
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-upload"></i> Upload Bulk Data
                            </h4>
                            <span>{{ \Carbon\Carbon::now()->format('d-M-Y h:i:s A') }}</span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <!-- Download Sample -->
                            <div class="mb-3">
                                <a href="{{ asset('public/students_sample.xlsx') }}" 
                                   class="btn btn-success btn-sm" download>
                                    <i class="fas fa-file-excel"></i> Download Sample File
                                </a>
                            </div>

                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <strong>{{ session('success') }}</strong><br>
                                    ✅ Inserted: {{ session('inserted') ?? 0 }} <br>
                                    ⚠️ Skipped (Duplicate): {{ session('skipped') ?? 0 }}
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    ❌ Error: {{ session('error') }}
                                </div>
                            @endif

                            <!-- Form Start -->
                            <form action="{{ route('student_bulk_upload_save') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- Session -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Session</label>
                                            <select name="session_id" class="form-control select2" required>
                                                <option value="">Select Session</option>
                                                @foreach($session as $sess)
                                                    <option value="{{ $sess->id }}">{{ $sess->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Excel/CSV File</label>
                                            <input type="file" 
                                                   name="file" 
                                                   class="form-control" 
                                                   accept=".xlsx,.csv" 
                                                   required>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">
                                            Upload
                                        </button>
                                    </div>

                                </div>
                            </form>
                            <!-- Form End -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@endsection