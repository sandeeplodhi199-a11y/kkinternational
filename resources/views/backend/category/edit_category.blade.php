@extends('backend.layouts.app')

@section('content')


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->



    <div class="row mart10 padd">

        <div class="col-md-8">

        </div>

        <!-- <div class="col-md-4">

            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/class-category')}}">Manage Class Category</a>

        </div> -->

    </div>











    <!-- Main content -->

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <!-- Default box -->

                    <div class="card card-primary card-outline">

                        <div class="card-header">

                            <h3 class="card-title">Edit Class Category</h3>



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

                            @if (\Session::has('error'))
                            <div class="alert alert-success">
                                {!! \Session::get('error') !!}
                            </div>
                            @endif

                            @foreach ($errors->all() as $error)
                            <div class="alert alert-warning">{{ $error }}</div>
                            @endforeach



                            <form method="post" action="{{ url('admin/updateClassCategory') }}"
                                enctype="multipart/form-data">

                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <input type="hidden" name="old_image" value="{{ $category->image }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $category->name }}">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Class Code</label>
                                            <input type="text" class="form-control" name="class_code"
                                                value="{{ $category->class_code }}">
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" class="form-control" name="slug"
                                                value="{{ $category->slug }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading Top</label>
                                            <input type="text" class="form-control" name="heading_top"
                                                value="{{ $category->heading_top }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading Bottom</label>
                                            <input type="text" class="form-control" name="heading_bottom"
                                                value="{{ $category->heading_bottom }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Parent</label>
                                            <select class="form-control select2" name="parent" style="width: 100%;">
                                                <option value="0">Select</option>
                                                @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $category->parent == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="icon"
                                                value="{{ $category->icon }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" style="width: 100%;">
                                                <option value="Active"
                                                    {{ $category->status == 'Active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="InActive"
                                                    {{ $category->status == 'InActive' ? 'selected' : '' }}>InActive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order By</label>
                                            <input type="number" class="form-control" name="orders_by"
                                                value="{{ $category->orders_by }}">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control summernote"
                                                name="content">{{ $category->content }}</textarea>
                                        </div>
                                    </div>

                                    <hr class="col-md-12">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title"
                                                value="{{ $category->meta_title }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea class="form-control"
                                                name="meta_keywords">{{ $category->meta_keywords }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control"
                                                name="meta_description">{{ $category->meta_description }}</textarea>
                                        </div>
                                    </div>

                                    <hr class="col-md-12">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <img src="{{ url('public/uploads/' . $category->image) }}"
                                                class="img-fluid">
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