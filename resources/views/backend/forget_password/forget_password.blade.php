@extends('backend.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row mt-3"></div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fas fa-cogs mr-2"></i>Password Settings Management</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (\Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! \Session::get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif
                            @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                {!! \Session::get('error') !!}
                            </div>
                            @endif

                            <form method="post" action="{{ url('admin/update-forget-password') }}"
                                enctype="multipart/form-data" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <!-- BASIC DETAILS -->
                                <div class="card mb-4 shadow-sm border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <i class="fas fa-info-circle mr-2"></i><strong>Password Details</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                          <div class="col-md-6">
                                                <label for="password" class="form-label">New Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-bars"></i></span>
                                                    <input type="text" id="password" name="password" class="form-control" value="{{ old('password') }}">
                                                </div>
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cpassword" class="form-label">Confirm Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-bars"></i></span>
                                                    <input type="text" id="cpassword" name="cpassword" class="form-control" value="{{ old('cpassword') }}">
                                                </div>
                                                @error('cpassword')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>



                                        </div>
                                    </div>
                                </div>


                                <div class="text-center mb-5">
                                    <button type="submit" class="btn btn-lg btn-primary px-5">
                                        <i class="fas fa-save me-2"></i> Submit
                                    </button>
                                </div>

                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <!-- Optional footer -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection