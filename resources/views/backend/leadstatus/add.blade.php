@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="row mart10 padd">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/leadstatus')}}">Manage status</a>
        </div>
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Create Status</h3>

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
                            <!------------------------>
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                            @endif

                            <form method="POST" action="{{ url('admin/saveLeadstatus') }}" enctype="multipart/form-data"
                                class="card shadow-sm p-4">
                                @csrf


                                <div class="row">
                                    <!-- Name -->
                                    <div class="col-md-4 mb-4">
                                        <label for="name" class="form-label fw-semibold">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter status name" required>
                                    </div>

                                    <!-- Order By -->
                                    <div class="col-md-4 mb-4">
                                        <label for="orders_by" class="form-label fw-semibold">Order By</label>
                                        <input type="number" class="form-control" name="orders_by" id="orders_by"
                                            placeholder="e.g., 1">
                                    </div>

                                    <!-- Status Dropdown -->
                                    <div class="col-md-4 mb-4">
                                        <label for="status" class="form-label fw-semibold">Status Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select form-control" name="status" id="status" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="Done">Done</option>
                                            <option value="Cancel">Cancel</option>
                                            <option value="Need CB" selected>Need CB</option>
                                        </select>
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-md-12 text-end">
                                        <button type="submit"
                                            class="btn btn-primary px-5 py-2 fw-semibold">Submit</button>
                                    </div>
                                </div>
                            </form>


                            <!-------------------------->


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                        <!-- /.card-footer-->
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