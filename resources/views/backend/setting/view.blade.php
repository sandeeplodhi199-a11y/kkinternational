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
                        <h3 class="card-title"><i class="fas fa-building"></i> Company Information</h3>

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

                        <form method="post" action="{{url('admin/saveCompany')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="1">
                            <div class="form-horizontal p-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-heading"></i> Title</label>
                                            <input type="text" class="form-control" name="setting20" value="{{$setting->setting20}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-building"></i> Company Name</label>
                                            <input type="text" class="form-control" name="setting21" value="{{$setting->setting21}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-file-invoice-dollar"></i> Company GST</label>
                                            <input type="text" class="form-control" name="setting22" value="{{$setting->setting22}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-clock"></i> Opening Hours</label>
                                            <input type="text" class="form-control" name="setting23" value="{{$setting->setting23}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="setting33"><i class="fas fa-image"></i> Logo</label>
                                            <input type="file" class="form-control-file" name="setting33" id="setting33">
                                            <input type="hidden" name="setting33_old" value="{{$setting->setting33}}">
                                            <br>
                                            @if(!empty($setting->setting33))
                                                <img src="{{ url('public/uploads/'.$setting->setting33) }}" alt="Current Logo" style="max-width: 80px;">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-envelope"></i> Email</label>
                                            <input type="email" class="form-control" name="setting24" value="{{$setting->setting24}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-phone-alt"></i> Phone</label>
                                            <input type="text" class="form-control" name="setting25" value="{{$setting->setting25}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-phone"></i> Landline Number</label>
                                            <input type="text" class="form-control" name="setting26" value="{{$setting->setting26}}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><i class="fas fa-map-marker-alt"></i> Address</label>
                                            <textarea class="form-control" name="setting27" rows="3">{{$setting->setting27}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><i class="fas fa-flag"></i> State</label>
                                            <input type="text" class="form-control" name="setting28" value="{{$setting->setting28}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><i class="fas fa-city"></i> City</label>
                                            <input type="text" class="form-control" name="setting29" value="{{$setting->setting29}}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><i class="fas fa-mail-bulk"></i> Pin Code</label>
                                            <input type="text" class="form-control" name="setting30" value="{{$setting->setting30}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-id-card"></i> PAN</label>
                                            <input type="text" class="form-control" name="setting31" value="{{$setting->setting31}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-barcode"></i> SAC Code</label>
                                            <input type="text" class="form-control" name="setting32" value="{{$setting->setting32}}">
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