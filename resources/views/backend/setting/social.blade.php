@extends('backend.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row mart10 padd"></div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-share-alt me-2"></i>Social Media Settings Management
                            </h3>
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
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                            @endif

                            <form method="post" action="{{ url('admin/saveMedia') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="1">

                                <!-- SOCIAL MEDIA DETAILS -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <strong><i class="fas fa-network-wired me-2"></i>Social Media Details</strong>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label><i
                                                        class="fab fa-facebook-f text-primary me-2"></i>Facebook</label>
                                                <input type="text" class="form-control" name="facebook"
                                                    value="{{ $setting->facebook }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label><i
                                                        class="fab fa-instagram text-danger me-2"></i>Instagram</label>
                                                <input type="text" class="form-control" name="instagram"
                                                    value="{{ $setting->instagram }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label><i class="fab fa-twitter text-info me-2"></i>Twitter</label>
                                                <input type="text" class="form-control" name="twitter"
                                                    value="{{ $setting->twitter }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label><i class="fab fa-youtube text-danger me-2"></i>Youtube</label>
                                                <input type="text" class="form-control" name="youtube"
                                                    value="{{ $setting->youtube }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label><i class="fab fa-linkedin text-primary me-2"></i>LinkedIn</label>
                                                <input type="text" class="form-control" name="linkdin"
                                                    value="{{ $setting->linkdin }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label><i class="fab fa-whatsapp text-success me-2"></i>Whatsapp</label>
                                                <input type="text" class="form-control" name="whatsapp"
                                                    value="{{ $setting->whatsapp }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-lg btn-primary px-5">
                                        <i class="fas fa-save me-2"></i>Submit
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer"></div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection