@extends('backend.layouts.app')

@section('content')







<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->



    <div class="row mart10 padd">

        <div class="col-md-8">

        </div>

        <div class="col-md-4">

            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/subject')}}">Manage Subject</a>

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

                            <h3 class="card-title">Add Subject</h3>



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



                            <form  action="{{ route('saveSubject') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">

                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Grade</label>
                                            <select class="form-control select2" name="class[]" id="class-dropdown" multiple style="width: 100%;">
                                                <option value="0" disabled>Select Grade</option>
                                                @foreach ($class as $cla)
                                                    <option value="{{$cla->id}}">{{$cla->name}}</option>
                                                @endforeach
                                            </select>

                                            
                                        </div>
                                    </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Subject name">
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" class="form-control" name="slug" placeholder="Enter Subject slug">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject Duration</label>
                                        <input type="text" class="form-control" name="subject_duration" placeholder="e.g., Enter subject months">
                                    </div>
                                </div> -->

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject Semester</label>
                                        <select class="form-control" name="semester">
                                            <option value="" selected disabled>Select Semester</option>
                                          
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">Semester {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div> -->

                                

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject Image</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div> -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Order By</label>
                                        <input type="number" class="form-control" name="orders_by" placeholder="Enter order">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject Type</label>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="is_optional"
                                                name="is_optional" value="1" {{ old('is_optional') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_optional">Optional Subject</label>
                                        </div>
                                    </div>
                                </div>

                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2" name="status" style="width: 100%;">
                                            <option value="Active">Active</option>
                                            <option value="InActive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
    <!--
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subject Description</label>
                                        <textarea class="form-control summernote" name="content" placeholder="Enter Subject description"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" placeholder="Enter meta title">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" placeholder="Enter meta keywords">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" name="meta_description" placeholder="Enter meta description"></textarea>
                                    </div>
                                </div> -->

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
