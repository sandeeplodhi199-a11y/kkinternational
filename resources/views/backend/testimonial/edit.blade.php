@extends('backend.layouts.app')

@section('content')







  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

   

   <div class="row mart10 padd">

        <div class="col-md-8">

        </div>

        <div class="col-md-4">

          <a class="btn btn-primary btn-sm float-right" href="{{url('admin/testimonial')}}">Manage Testimonial</a>

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

                <h3 class="card-title">Edit Testimonial</h3>



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

                

                <form method="post" action="{{url('admin/updateTestimonial')}}" enctype="multipart/form-data">

                <input type="hidden" name="id" value="{{$page->id}}">

               

                {{ csrf_field() }}

                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">

                      <label>Name</label>

                      <input type="text" class="form-control" name="name" required value="{{$page->name}}">

                    </div>

                  </div>



                <!--  <div class="col-md-4">

                    <div class="form-group">

                      <label>Heading</label>

                      <input type="text" class="form-control" name="heading" required value="{{$page->heading}}">

                    </div>

                  </div>



                   <div class="col-md-6">

                    <div class="form-group">

                      <label>Sub Heading</label>

                      <input type="text" class="form-control" name="sub_heading" required value="{{$page->sub_heading}}">

                    </div>

                  </div>





                  <div class="col-md-6">

                    <div class="form-group">

                      <label>Slug</label>

                      <input type="text" class="form-control" name="slug" value="{{$page->slug}}">

                    </div>

                  </div> -->



                  <div class="col-md-6">

                    <div class="form-group">

                      <label>Ratings</label>

                      <input type="number" class="form-control" name="rating" required value="{{$page->rating}}">

                    </div>

                  </div> 

 <!--

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Image</label>

                      <input type="file" class="form-control" name="image"   >

                    </div>
                    <p class="custom-text" style="color: red;">Image Size Should be 60 × 60 px</p>

                  </div>
-->




                  <div class="col-md-12">

                    <div class="form-group">

                      <label>Details</label>

                      <textarea class="form-control" name="content">{{$page->content}}</textarea>

                    </div>

                  </div>


                <!--  <div class="col-md-4">
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
                  </div> -->

                  

                  <div class="col-md-12">

                    <div class="form-group">

                      <input type="submit" class="btn btn-primary" value="Submit">

                    </div>

                  </div>



                  <div class="col-md-2">

                    <div class="form-group">

                     <img src="{{url('public/uploads/'.$page->image)}}" style="max-width: 100%;" />

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