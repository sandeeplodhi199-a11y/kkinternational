@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row mart10 padd">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{ url('admin/add-video-category') }}">Add Video Category</a>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header"><h3 class="card-title">Video Category</h3></div>
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success">{!! Session::get('success') !!}</div>
                            @endif
                            @if($categories->total() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Status</th>
                                                <th>Videos</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $index => $cat)
                                                <tr>
                                                    <td>{{ $categories->firstItem() + $index }}</td>
                                                    <td>
                                                        @if($cat->image)
                                                            <img src="{{ url('public/uploads/'.$cat->image) }}" alt="{{ $cat->name }}" style="width: 70px; height: 48px; object-fit: cover; border-radius: 6px;">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $cat->name }}</td>
                                                    <td>{{ $cat->slug }}</td>
                                                    <td>{{ $cat->status }}</td>
                                                    <td>{{ $cat->videos()->where('is_deleted', 0)->count() }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ url('admin/edit-video-category/'.$cat->id) }}">Edit</a>
                                                        <a class="btn btn-sm btn-danger" href="{{ url('admin/delete-video-category/'.$cat->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {!! $categories->links('pagination::bootstrap-4') !!}
                            @else
                                <div class="alert alert-warning">No category found.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
