@extends('backend.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row mart10 padd"></div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-building"></i>Edit Footer Information</h3>

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
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! \Session::get('error') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif


                            <form method="post" action="{{url('admin/SaveeditFooter')}}" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $footer->id }}">
                                <div class="form-horizontal p-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-heading"></i> Footer Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $footer->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-link"></i> Footer Link</label>
                                                <input type="text" class="form-control" name="link"
                                                    value="{{ $footer->link }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-sort-numeric-down"></i> Footer Sequence</label>
                                                <input type="text" class="form-control" name="sequence"
                                                    value="{{ $footer->sequence }}">
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="border: 2px solid #069;">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">




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