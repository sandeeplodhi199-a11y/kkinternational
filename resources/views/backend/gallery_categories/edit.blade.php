@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row mart10 padd">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{ url('admin/gallery-categories') }}">Manage Gallery Category</a>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header"><h3 class="card-title">Edit Gallery Category</h3></div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            <form method="post" action="{{ url('admin/updateGalleryCategory') }}" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Category Image</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            @if($category->image)
                                                <img src="{{ url('public/uploads/'.$category->image) }}" alt="{{ $category->name }}" style="width: 90px; height: 60px; object-fit: cover; margin-top: 10px; border-radius: 6px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Active">Active</option>
                                                <option value="InActive" {{ $category->status == 'InActive' ? 'selected' : '' }}>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
