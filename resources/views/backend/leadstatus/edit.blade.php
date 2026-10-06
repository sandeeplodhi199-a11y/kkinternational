@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="row mart10 padd">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/leadstatus')}}">Manage Status</a>
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
                            <h3 class="card-title">Edit Status</h3>

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

                            <form method="post" action="{{url('admin/updateLeadstatus')}}"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$page->id}}">

                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{$page->name}}">
                                        </div>
                                    </div>


                                    <!-- Orders By -->
                                    <div class="col-md-4">
                                        <label>Orders By</label>
                                        <input type="text" name="orders_by" class="form-control"
                                            value="{{ isset($page) ? $page->orders_by : '' }}" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <label>Status Type</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="Done"
                                                {{ isset($page) && $page->status == 'Done' ? 'selected' : '' }}>Done
                                            </option>
                                            <option value="Cancel"
                                                {{ isset($page) && $page->status == 'Cancel' ? 'selected' : '' }}>Cancel
                                            </option>
                                            <option value="Need CB"
                                                {{ isset($page) && $page->status == 'Need CB' ? 'selected' : '' }}>Need
                                                CB</option>
                                        </select>
                                    </div>





                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
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