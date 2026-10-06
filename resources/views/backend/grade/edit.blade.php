@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">

    <div class="row mart10 padd">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/grade')}}">Manage Grade</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Edit Grade</h3>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="post" action="{{ route('grade.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $page->id }}">

                        <div class="row">

                            <!-- Level -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Level</label>
                                    <select name="level_id" class="form-control" required>
                                        <option value="">Select Level</option>
                                        @foreach($level as $lev)
                                            <option value="{{ $lev->id }}" 
                                                {{ $page->level_id == $lev->id ? 'selected' : '' }}>
                                                {{ $lev->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $page->name }}" required>
                                </div>
                            </div>

                            <!-- Order -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Orders By</label>
                                    <input type="number" name="orders_by" class="form-control"
                                        value="{{ $page->orders_by }}" required>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection