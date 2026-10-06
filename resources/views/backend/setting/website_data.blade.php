@extends('backend.layouts.app')
@section('content')

<style>
    .website-data-table {
        table-layout: fixed;
        width: 100%;
    }
    .website-data-table th,
    .website-data-table td {
        vertical-align: middle;
        white-space: normal;
        word-break: break-word;
    }
    .website-data-content {
        max-width: 520px;
        max-height: 92px;
        overflow: hidden;
        line-height: 1.5;
        color: #495057;
    }
    .website-data-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .website-data-img {
        height: 48px;
        max-width: 90px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }
</style>

<div class="content-wrapper">
    <div class="row mart10 padd"></div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-building"></i> Website Data Information</h3>
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

                            <form method="POST" action="{{ url('admin/saveWebsitedata') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-horizontal p-0">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-sort-numeric-down"></i> Type</label>
                                                <select class="form-control" name="type" id="typeSelect"
                                                    onchange="toggleFields()">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="Goal">Goal</option>
                                                    <option value="Accomplishment">Accomplishment</option>
                                                    <option value="Oath">Oath</option>
                                                    <option value="Principal Message">Principal Message</option>
                                                    <option value="Chairman Message">Chairman Message</option>
                                                    <option value="Mission">Mission</option>
                                                    <option value="Terms and Condition">Terms and Condition</option>
                                                    <option value="Privacy Policy">Privacy Policy</option>
                                                    <option value="Cancellation & Refund">Cancellation & Refund</option>
                                                    <option value="Academics">Academics</option>
                                                    <option value="Facilities">Facilities</option>
                                                    <option value="Programs">Programs</option>
                                                    <option value="Day Boarding Programs">Day Boarding Programs</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="imageField">
                                            <div class="form-group">
                                                <label><i class="fas fa-image"></i> Image</label>
                                                <input type="file" class="form-control" name="image">
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="contentField">
                                            <div class="form-group">
                                                <label><i class="fas fa-heading"></i> Content</label>
                                                <textarea class="form-control summernote" name="name"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <hr style="border: 2px solid #069;">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            @if ($website_data->total() > 0)
                            <div class="table-responsive p-0">
                                <table class="table table-hover website-data-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">Sno</th>
                                            <th style="width: 180px;">Type</th>
                                            <th>Content</th>
                                            <th style="width: 120px;">Image</th>
                                            <th style="width: 110px;">Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($website_data as $item)
                                        <tr>
                                            <td>{{ $website_data->firstItem() + $loop->index }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>
                                                <div class="website-data-content"
                                                    title="{{ strip_tags($item->name ?? '') }}">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->name ?? ''), 260) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item->image)
                                                <img src="{{ url('public/uploads/' . $item->image) }}"
                                                    alt="{{ strip_tags($item->name ?? $item->type) }}"
                                                    class="website-data-img">
                                                @else
                                                <span class="text-muted">No Image</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->status == 'Active')
                                                <a class="text-warning"
                                                    href="{{ url('admin/update-website-data-status/' . $item->id . '?status=Inactive') }}">
                                                    Active
                                                </a>
                                                @else
                                                <a
                                                    href="{{ url('admin/update-website-data-status/' . $item->id . '?status=Active') }}">
                                                    Inactive
                                                </a>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="website-data-actions">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ url('admin/editWebsitedata/' . $item->id) }}">
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this item?');"
                                                        href="{{ url('admin/deleteWebsitedata/' . $item->id) }}">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="gmz-pagination">
                                {!! $website_data->links('pagination::bootstrap-4') !!}
                            </div>
                            @else
                            <div class="alert alert-warning">{{ __('No data') }}</div>
                            @endif
                        </div>

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
document.addEventListener('DOMContentLoaded', toggleFields);
</script>

@endsection
