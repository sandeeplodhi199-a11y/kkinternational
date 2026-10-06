@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">

    <div class="row mart10 padd">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/chapter')}}">Manage Chapter</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Edit Chapter</h3>
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

                    <form method="post" action="{{ route('chapter.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $page->id }}">

                        <div class="row">

                            <!-- Grade -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Grade</label>
                                   <select name="grade_id" id="grade_id" class="form-control select2" required>
                                        <option value="">Select Grade</option>
                                        @foreach($grade as $gra)
                                            <option value="{{ $gra->id }}" 
                                                {{ $page->grade_id == $gra->id ? 'selected' : '' }}>
                                                {{ $gra->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Subject</label>
                                
                                <select name="subject_id" id="subject_id" class="form-control select2" required>
                                    <option value="">Select Subject</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chapter No</label>
                                    <input type="number" name="chapter_no" class="form-control"
                                        value="{{ $page->chapter_no }}" required>
                                </div>
                            </div>
                            
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>No Of Pages</label>
                                    <input type="number" name="no_of_pages" class="form-control"
                                        value="{{ $page->no_of_pages }}" required>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    var selected_subject = "{{ $page->subject_id ?? '' }}";
    var selected_grade = "{{ $page->grade_id ?? '' }}";

    
    function loadSubjects(grade_id, selected_subject = '') {
        if (grade_id != '') {
            $.ajax({
                url: '/admin/get-subjects/' + grade_id,
                type: 'GET',
                success: function(response) {

                    $('#subject_id').empty();
                    $('#subject_id').append('<option value="">Select Subject</option>');

                    $.each(response, function(key, value) {

                        var selected = (value.id == selected_subject) ? 'selected' : '';

                        $('#subject_id').append(
                            '<option value="'+value.id+'" '+selected+'>'+value.name+'</option>'
                        );
                    });
                }
            });
        }
    }

   
    if (selected_grade != '') {
        loadSubjects(selected_grade, selected_subject);
    }

   
    $('#grade_id').on('change', function() {
        var grade_id = $(this).val();
        loadSubjects(grade_id);
    });

});
</script>

@endsection