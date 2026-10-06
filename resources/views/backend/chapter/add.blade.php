@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="row mart10 padd">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/chapter')}}">Manage Chapter</a>
        </div>
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Add Chapter</h3>

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
                            <!------------------------>
                          
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                            @endif

                        
                            @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                {!! \Session::get('error') !!}
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin-bottom:0;">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/saveChapter')}}" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <div class="row">

                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Grade</label>
                                        <select name="grade_id" id="grade_id" class="form-control select2" required>
                                            <option value="">Select Grade</option>
                                            @foreach($grade as $gra)
                                                <option value="{{ $gra->id }}">
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chapter No </label>
                                            <input type="number" class="form-control" name="chapter_no">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No of Pages </label>
                                            <input type="number" class="form-control" name="no_of_pages">
                                        </div>
                                    </div>




                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-------------------------->


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




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#grade_id').on('change', function() {
    var grade_id = $(this).val();

    if (grade_id != '') {
        $.ajax({
            url: '/admin/get-subjects/' + grade_id,
            type: 'GET',
            success: function(response) {

                $('#subject_id').empty();
                $('#subject_id').append('<option value="">Select Subject</option>');

                $.each(response, function(key, value) {
                    $('#subject_id').append(
                        '<option value="'+value.id+'">'+value.name+'</option>'
                    );
                });
            }
        });
    } else {
        $('#subject_id').empty();
        $('#subject_id').append('<option value="">Select Subject</option>');
    }
});
</script>

@endsection