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
                        Edit Grade Master Management
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
                    <form method="POST" action="{{ url('admin/grades/update/'. $grade->id) }}">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <input type="text" name="grade_name"
                                        class="form-control"
                                        placeholder="A+ / A / B"
                                        value="{{ $grade->grade_name }}"
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
                                        value="{{ $grade->min_percent }}"
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
                                        value="{{ $grade->max_percent }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <input type="text" name="remark"
                                        class="form-control"
                                        value="{{ $grade->remark }}"
                                        placeholder="Excellent / Good">
                                </div>
                            </div>

                        </div>

                       <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Update Grade
                            </button>
                        </div>

                    </form>

                    <hr>

                   

                </div>
            </div>

        </div>
    </section>
</div>

@endsection
