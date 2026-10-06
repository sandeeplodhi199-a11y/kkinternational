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
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Home Setting Management</h3>

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

                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

                            <form method="post" action="{{url('admin/saveHome')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="1">
                                <div class="form-horizontal p-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="home1"
                                                    value="{{$setting->home1}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="home2"
                                                    value="{{$setting->home2}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="home3"
                                                    value="{{$setting->home3}}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa fa-align-left"></i></span>
                                                </div>
                                                <textarea class="form-control"
                                                    name="home4">{{$setting->home4}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="border: 2px solid #069;">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="home5"
                                                    value="{{$setting->home5}}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa fa-align-left"></i></span>
                                                </div>
                                                <textarea class="form-control"
                                                    name="home6">{{$setting->home6}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home7">
                                                <input type="hidden" name="home7_old" value="{{$setting->home7}}">
                                                <br>
                                                <img src="{{url('public/uploads/'.$setting->home7)}}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="border: 2px solid #069;">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="home8"
                                                    value="{{$setting->home8}}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa fa-align-left"></i></span>
                                                </div>
                                                <textarea class="form-control"
                                                    name="home9">{{$setting->home9}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home10">
                                                <input type="hidden" name="home10_old" value="{{$setting->home10}}">
                                                <br>
                                                <img src="{{url('public/uploads/'.$setting->home10)}}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="border: 2px solid #069;">

                                    <div class="col-md-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            <input type="text" name="home11" class="form-control"
                                                value="{{$setting->home11}}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            <input type="text" name="home12" class="form-control"
                                                value="{{$setting->home12}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="home13" class="form-control mb-2"
                                                    value="{{ $setting->home13 }}">
                                                <input type="text" name="home14" class="form-control"
                                                    value="{{ $setting->home14 }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="home15" class="form-control mb-2"
                                                    value="{{ $setting->home15 }}">
                                                <input type="text" name="home16" class="form-control"
                                                    value="{{ $setting->home16 }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="home17" class="form-control mb-2"
                                                    value="{{ $setting->home17 }}">
                                                <input type="text" name="home18" class="form-control"
                                                    value="{{ $setting->home18 }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="home19" class="form-control mb-2"
                                                    value="{{ $setting->home19 }}">
                                                <input type="text" name="home20" class="form-control"
                                                    value="{{ $setting->home20 }}">
                                            </div>
                                        </div>
                                    </div>


                                    <hr style="border: 2px solid #069;">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home21">
                                                <input type="hidden" name="home21_old" value="{{ $setting->home21 }}">
                                                <br>
                                                <img src="{{ url('public/uploads/' . $setting->home21) }}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home22">
                                                <input type="hidden" name="home22_old" value="{{ $setting->home22 }}">
                                                <br>
                                                <img src="{{ url('public/uploads/' . $setting->home22) }}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home23">
                                                <input type="hidden" name="home23_old" value="{{ $setting->home23 }}">
                                                <br>
                                                <img src="{{ url('public/uploads/' . $setting->home23) }}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home24">
                                                <input type="hidden" name="home24_old" value="{{ $setting->home24 }}">
                                                <br>
                                                <img src="{{ url('public/uploads/' . $setting->home24) }}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><i class="fa fa-image"></i> Upload Image</label>
                                                <input type="file" name="home25">
                                                <input type="hidden" name="home25_old" value="{{ $setting->home25 }}">
                                                <br>
                                                <img src="{{ url('public/uploads/' . $setting->home25) }}"
                                                    style="width: 150px; height: 150px; object-fit: cover;">>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            <input type="text" name="home26" class="form-control"
                                                value="{{$setting->home26}}">
                                        </div>
                                    </div>
                                </div>

                                <hr style="border: 2px solid #069;">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            <input type="text" name="home27" class="form-control"
                                                value="{{$setting->home27}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            <input type="text" name="home28" class="form-control"
                                                value="{{$setting->home28}}">
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