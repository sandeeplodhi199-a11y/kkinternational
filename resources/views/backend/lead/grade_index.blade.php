@extends('backend.layouts.app')
@section('content')

<style>
    .table .thead-light th {
    color: #000000;
    background-color: #0080ff;
    border-color: #dee2e6;
}
</style>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">

            {{-- HEADER --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>
                        <i class="fas fa-graduation-cap text-primary"></i>
                       Add Grade Master Management
                    </h4>
                </div>
            </div>  

            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- ADD GRADE FORM --}}
                    <form method="POST" action="{{ route('grades.store') }}">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <input type="text" name="grade_name"
                                        class="form-control"
                                        placeholder="A+ / A / B"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Min Percentage</label>
                                    <input type="number" step="0.01"
                                        name="min_percent"
                                        class="form-control"
                                        placeholder="70"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Max Percentage</label>
                                    <input type="number" step="0.01"
                                        name="max_percent"
                                        class="form-control"
                                        placeholder="79.99"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <input type="text" name="remark"
                                        class="form-control"
                                        placeholder="Excellent / Good">
                                </div>
                            </div>

                        </div>

                       <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Grade
                            </button>
                        </div>

                    </form>

                    <hr>

                    {{-- GRADE LIST --}}
                    @if($grades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Grade</th>
                                    <th>Min %</th>
                                    <th>Max %</th>
                                    <th>Remark</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grades as $g)
                                <tr>
                                    <td><strong>{{ $g->grade_name }}</strong></td>
                                    <td>{{ $g->min_percent }}</td>
                                    <td>{{ $g->max_percent }}</td>
                                    <td>{{ $g->remark }}</td>
                                    <td>
                                          @php
                                            $permExplodesub = explode(',', Auth::user()->permission_submenu ?? '');
                                            @endphp
                                            @if(in_array('2_46', $permExplodesub))
                                        <a href="{{ route('grades.edit',$g->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                            @endif

                                            @if(in_array('2_47', $permExplodesub))
                                        <a href="{{ route('grades.delete',$g->id) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this grade?')">
                                            Delete
                                        </a>
                                         @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-3">
                        {{ $grades->links('pagination::bootstrap-4') }}
                    </div>

                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        No grades found.
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </section>
</div>

@endsection
