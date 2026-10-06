@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row mart10 padd"></div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-building"></i> Edit Website Data</h3>
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
                            @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! Session::get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! Session::get('error') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            <form method="POST" action="{{ url('admin/SaveeditWebsitedata') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $website_data->id }}">

                                <div class="form-horizontal p-0">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-sort-numeric-down"></i> Type</label>
                                                <select class="form-control" name="type" id="typeSelect"
                                                    onchange="toggleFields()">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="Goal"
                                                        {{ $website_data->type == 'Goal'                    ? 'selected' : '' }}>
                                                        Goal</option>
                                                    <option value="Accomplishment"
                                                        {{ $website_data->type == 'Accomplishment'          ? 'selected' : '' }}>
                                                        Accomplishment</option>
                                                    <option value="Oath"
                                                        {{ $website_data->type == 'Oath'                    ? 'selected' : '' }}>
                                                        Oath</option>
                                                    <option value="Principal Message"
                                                        {{ $website_data->type == 'Principal Message'       ? 'selected' : '' }}>
                                                        Principal Message</option>
                                                    <option value="Chairman Message"
                                                        {{ in_array($website_data->type, ['Chairman Message', 'Director Message']) ? 'selected' : '' }}>
                                                        Chairman Message</option>
                                                    <option value="Mission"
                                                        {{ $website_data->type == 'Mission'                 ? 'selected' : '' }}>
                                                        Mission</option>
                                                    <option value="Terms and Condition"
                                                        {{ $website_data->type == 'Terms and Condition'     ? 'selected' : '' }}>
                                                        Terms and Condition</option>
                                                    <option value="Privacy Policy"
                                                        {{ $website_data->type == 'Privacy Policy'          ? 'selected' : '' }}>
                                                        Privacy Policy</option>
                                                    <option value="Cancellation & Refund"
                                                        {{ $website_data->type == 'Cancellation & Refund'   ? 'selected' : '' }}>
                                                        Cancellation & Refund</option>

                                                         <option value="Academics"
                                                        {{ in_array($website_data->type, ['Academics', 'Academic']) ? 'selected' : '' }}>
                                                        Academics</option>

                                                         <option value="Facilities"
                                                        {{ $website_data->type == 'Facilities'   ? 'selected' : '' }}>
                                                        Facilities</option>

                                                         <option value="Programs"
                                                        {{ $website_data->type == 'Programs'   ? 'selected' : '' }}>
                                                        Programs</option>
                                                    <option value="Day Boarding Programs"
                                                        {{ $website_data->type == 'Day Boarding Programs' ? 'selected' : '' }}>
                                                        Day Boarding Programs</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6" id="imageField">
                                            <div class="form-group">
                                                <label><i class="fas fa-image"></i> Image</label>
                                                <input type="file" class="form-control" name="image">
                                                @if ($website_data->image)
                                                <div class="mt-2">
                                                    <img src="{{ url('public/uploads/' . $website_data->image) }}"
                                                        alt="{{ $website_data->name }}"
                                                        style="height: 60px; width: auto;">
                                                    <small class="d-block text-muted">Current image</small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="contentField">
                                            <div class="form-group">
                                                <label><i class="fas fa-heading"></i> Content</label>
                                                <textarea class="form-control summernote"
                                                    name="name">{{ $website_data->name }}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <hr style="border: 2px solid #069;">
                                    <input type="submit" value="Update" class="btn btn-primary">
                                    <a href="{{ url('admin/website/data') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
function toggleFields() {
    var type = document.getElementById('typeSelect').value;
    var imageField   = document.getElementById('imageField');
    var contentField = document.getElementById('contentField');

    var onlyImage    = ['Accomplishment'];
    var onlyTextarea = ['Terms and Condition', 'Privacy Policy', 'Cancellation & Refund'];

    if (onlyImage.includes(type)) {
        // Sirf Image dikhao
        imageField.style.display   = 'block';
        contentField.style.display = 'none';
        contentField.querySelector('textarea').removeAttribute('required');
    } else if (onlyTextarea.includes(type)) {
        // Sirf Textarea dikhao
        imageField.style.display   = 'none';
        contentField.style.display = 'block';
    } else {
        // Dono dikhao (default)
        imageField.style.display   = 'block';
        contentField.style.display = 'block';
    }
}
// Edit page par existing saved type ke hisaab se load hote hi apply ho
document.addEventListener('DOMContentLoaded', toggleFields);
</script>


@endsection
