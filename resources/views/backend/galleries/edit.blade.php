@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
  <div class="row mart10 padd"><div class="col-md-8"></div><div class="col-md-4"><a class="btn btn-primary btn-sm float-right" href="{{ url('admin/galleries') }}">Manage Gallery Images</a></div></div>
  <section class="content"><div class="container-fluid"><div class="row"><div class="col-12"><div class="card card-primary card-outline"><div class="card-header"><h3 class="card-title">Edit Gallery Image</h3></div><div class="card-body">
    @if (Session::has('success'))<div class="alert alert-success">{!! Session::get('success') !!}</div>@endif @if (Session::has('error'))<div class="alert alert-danger">{!! Session::get('error') !!}</div>@endif @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <form method="post" action="{{ url('admin/updateGallery') }}" enctype="multipart/form-data"><input type="hidden" name="id" value="{{ $category->id }}"><input type="hidden" name="old_image" value="{{ $category->image }}">{{ csrf_field() }}<div class="row">
      <div class="col-md-4"><div class="form-group"><label>Gallery Category</label><select class="form-control select2" name="category_id" required><option value="">-- Select Category --</option>@foreach($galleryCategories as $galleryCategory)<option value="{{ $galleryCategory->id }}" {{ old('category_id', $category->category_id) == $galleryCategory->id ? 'selected' : '' }}>{{ $galleryCategory->name }}</option>@endforeach</select></div></div>
      <div class="col-md-4"><div class="form-group"><label>Image Name</label><input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required></div></div>
      <div class="col-md-4"><div class="form-group"><label>Image</label><input type="file" class="form-control" name="image"></div><p class="custom-text" style="color:red;">Image Size Should be 410 x 361 px</p></div>
      <div class="col-md-4"><div class="form-group"><label>Status</label><select class="form-control select2" name="status"><option value="Active">Active</option><option value="InActive" {{ $category->staus == 'InActive' ? 'selected' : '' }}>InActive</option></select></div></div>
      <div class="col-md-6"><img src="{{ url('public/uploads/'.$category->image) }}" width="100" height="60" class="img-fluid" alt="Gallery"></div>
      <div class="col-md-12"><input type="submit" class="btn btn-primary" value="Submit"></div>
    </div></form>
  </div><div class="card-footer"></div></div></div></div></div></section>
</div>
@endsection
