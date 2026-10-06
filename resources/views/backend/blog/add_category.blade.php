@extends('backend.layouts.app')

@section('content')







  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

   

   <div class="row mart10 padd">

        <div class="col-md-8">

        </div>

        <div class="col-md-4">

          <a class="btn btn-primary btn-sm float-right" href="{{url('admin/blog-category')}}">Manage Category</a>

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

                <h3 class="card-title">Add Category</h3>



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

                

                <form method="post" action="{{url('admin/saveBlogCategory')}}" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="row">

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Name</label>

                      <input type="text" class="form-control" name="name">

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Slug</label>

                      <input type="text" class="form-control" name="slug">

                    </div>

                  </div>

                

               
                  <!-- <div class="col-md-6">

                    <div class="form-group">

                      <label>Image</label>

                      <input type="file" class="form-control" name="image" >

                    </div>
             


                  </div> -->

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Status</label>

                      <select class="form-control select2" name="status" style="width: 100%;">

                        <option value="Active">Active</option>

                        <option value="InActive">InActive</option>

                      </select>

                    </div>

                  </div>



                  <div class="col-md-12"></div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Meta Title</label>

                      <input type="text" class="form-control" name="meta_title">

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Meta Keywords</label>

                      <input type="text" class="form-control" name="meta_keywords">

                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group">

                      <label>Meta Description</label>

                      <input type="text" class="form-control" name="meta_description">

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