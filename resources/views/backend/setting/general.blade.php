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
                            <h3 class="card-title"><i class="fas fa-cogs mr-2"></i>General Settings Management</h3>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ url('admin/saveGeneral') }}" enctype="multipart/form-data" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="1">

                                <!-- BASIC DETAILS -->
                                <div class="card mb-4 shadow-sm border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <i class="fas fa-info-circle mr-2"></i><strong>Basic Details</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-md-4">
                                                <label for="setting1" class="form-label">Top Bar Text</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-bars"></i></span>
                                                    <input type="text" id="setting1" name="setting1" class="form-control" value="{{ $setting->setting1 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting10" class="form-label">Copyright</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-copyright"></i></span>
                                                    <input type="text" id="setting10" name="setting10" class="form-control" value="{{ $setting->setting10 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting11" class="form-label">Popup Image</label>
                                                <input type="file" id="setting11" name="setting11" class="form-control">
                                                <input type="hidden" name="setting11_old" value="{{ $setting->setting11 }}">
                                                <div class="mt-2">
                                                    <img src="{{ url('public/uploads/' . $setting->setting11) }}" class="img-thumbnail" style="max-width: 100px;">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="setting2" class="form-label">Footer About</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-info"></i></span>
                                                    <input type="text" id="setting2" name="setting2" class="form-control" value="{{ $setting->setting2 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="setting3" class="form-label">Footer Heading 1</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                    <input type="text" id="setting3" name="setting3" class="form-control" value="{{ $setting->setting3 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="setting4" class="form-label">Footer Heading 2</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                    <input type="text" id="setting4" name="setting4" class="form-control" value="{{ $setting->setting4 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="setting5" class="form-label">Footer Heading 3</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                    <input type="text" id="setting5" name="setting5" class="form-control" value="{{ $setting->setting5 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="setting_five" class="form-label">Footer Heading 4</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                    <input type="text" id="setting_five" name="setting_five" class="form-control" value="{{ $setting->setting_five }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- EMAIL CONFIGURATION -->
                                <div class="card mb-4 shadow-sm border-success">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-envelope mr-2"></i><strong>Email Configuration</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-md-4">
                                                <label for="setting9" class="form-label">Enquiry From</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" id="setting9" name="setting9" class="form-control" value="{{ $setting->setting9 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting12" class="form-label">Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                                    <input type="email" id="setting12" name="setting12" class="form-control" value="{{ $setting->setting12 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting13" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                    <input type="password" id="setting13" name="setting13" class="form-control" value="{{ $setting->setting13 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting14" class="form-label">SMTP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-server"></i></span>
                                                    <input type="text" id="setting14" name="setting14" class="form-control" value="{{ $setting->setting14 }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="setting15" class="form-label">Port</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-plug"></i></span>
                                                    <input type="text" id="setting15" name="setting15" class="form-control" value="{{ $setting->setting15 }}">
                                                </div>
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
