@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <div class="row mart10 padd">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
      <a class="btn btn-primary btn-sm float-right" href="{{url('admin/events')}}">Manage Events</a>
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
              <h3 class="card-title">Edit Events</h3>

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

              <form method="post" action="{{url('admin/updateEvents')}}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{$page->id}}">

                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" required value="{{$page->name}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Slug</label>
                      <input type="text" class="form-control" name="slug" value="{{$page->slug}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Event Date</label>
                      <input type="date" class="form-control" name="event_date" required value="{{$page->event_date}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Event Time</label>
                      <input type="text" class="form-control" name="event_time" required value="{{$page->event_time}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Conduct By</label>
                      <input type="text" class="form-control" name="conduct_by" required value="{{$page->conduct_by}}">
                    </div>
                  </div>

                  
                  <div class="col-md-6">

                    <div class="form-group">

                      <label>Image</label>

                      <input type="file" class="form-control" name="image">

                    </div>
                    <p class="custom-text" style="color: red;">Image Size Should be 1300 × 703 px</p>

                  </div>

                




                  <div class="col-md-6">

                    <div class="form-group">

                      <label>Status</label>

                      <select class="form-control select2" name="status" style="width: 100%;">

                        <option value="Active">Active</option>

                        <option <?php if ($page->staus == 'InActive') {
                                  echo "selected";
                                } ?> value="InActive">InActive</option>

                      </select>

                    </div>

                  </div>



                  <div class="col-md-12">

                    <div class="form-group">

                      <label>Short Content</label>

                      <input type="text" class="form-control" name="short_content" value="<?= $page->short_content; ?>">

                    </div>

                  </div>





                  <div class="col-md-12">

                    <div class="form-group">

                      <label>Content</label>

                      <textarea name="content" class="summernote"><?= $page->content; ?></textarea>

                    </div>

                  </div>

                  <hr class="col-md-12">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="meta_title" value="{{$page->meta_title}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Meta Keywords</label>
                      <input type="text" class="form-control" name="meta_keywords" value="{{$page->meta_keywords}}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Meta Description</label>
                      <input type="text" class="form-control" name="meta_description" value="{{$page->meta_description}}">
                    </div>
                  </div>

                  <div class="col-md-12"></div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Image Alt Tag</label>
                      <input type="text" class="form-control" name="image_alt" value="{{$page->image_alt}}" >
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Image Title</label>
                      <input type="text" class="form-control" name="image_title" value="{{$page->image_title}}" >
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Image Description</label>
                      <input type="text" class="form-control" name="image_description" value="{{$page->image_description}}" >
                    </div>
                  </div>

                 

                  <div class="col-md-6">

                    <div class="form-group">

                      <img src="{{url('public/uploads/'.$page->image)}}" width="100px" height="50px" class="img-fluid">

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