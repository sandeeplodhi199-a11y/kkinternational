@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <div class="row mart10 padd">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
      <a class="btn btn-primary btn-sm float-right" href="{{url('admin/faq')}}">Manage Faq</a>
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
              <h3 class="card-title">Edit Faq</h3>

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

              <form method="post" action="{{url('admin/updateFaq')}}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{$page->id}}">

                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" required value="{{$page->name}}">
                    </div>
                  </div>




                <!--  <div class="col-md-6">
                    <div class="form-group">
                      <label>Slug</label>
                      <input type="text" class="form-control" name="slug" value="{{$page->slug}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type">
                        <option value="{{$page->type}}">{{$page->type}}</option>

                        <option value="Faq Student">Faq Student</option>
                        <option value="Visa Assistance">Visa Assistance</option>
                        <option value="Industrial Training">Industrial Training</option>
                        <option value="Corporate Training">Corporate Training</option>
                      </select>
                    </div>
                  </div>  -->

                  

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Details</label>
                      <textarea class="form-control summernote" name="content">{{$page->content}}</textarea>
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








@endsection