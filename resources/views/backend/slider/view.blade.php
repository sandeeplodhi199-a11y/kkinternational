@extends('backend.layouts.app')

@section('content')







  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

   

   <div class="row mart10 padd">

        <div class="col-md-8">

          

        </div>

      



        <div class="col-md-4">

          <a class="btn btn-primary btn-sm float-right" href="{{url('admin/add-slider')}}">Add New Slider</a>

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

                <h3 class="card-title">Slider Management</h3>



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

                @if (\Session::has('success'))

                    <div class="alert alert-success">

                        {!! \Session::get('success') !!}

                    </div>

                @endif

                

                <div class="table-responsive p-0">

                  <table class="table table-hover text-nowrap1">

                    <thead>

                      <tr>

                        <th> Url</th>

                        <th> Image</th>
                        <th> Button Name</th>
                        <th> Button Url</th>
                        <th> Title</th>
                        <th> Description</th>

                        <th> OrderBy</th>

                        <th width="1">Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      @foreach ($slider as $slid)

                      <tr>

                       

                        <td>{{$slid->name}}</td>

                        <td><img src="{{url('public/uploads/'.$slid->image)}}" style="width: 150px;"></td>

                        <td>{{$slid->image_alt}}</td>
                        <td>{{$slid->name}}</td>
                        <td>{{$slid->image_title}}</td>
                        <td>{{$slid->image_description}}</td>
                        <td>{{$slid->order_by}}</td>

                        <td>  



                          <div class="dropdown">

                            <i class="fa fa-ellipsis-v side-el " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item" href="{{url('admin/edit-slider')}}/{{$slid->id}}">Edit</a>

                                <a onclick="return confirm('Are you sure you want to delete this item?');" class="dropdown-item" href="{{url('admin/delete-slider')}}/{{$slid->id}}"">Delete</a>

                            </div>

                          </div>

                        </td>

                       



                      </tr>

                      @endforeach



                      



                    </tbody>

                  </table>

                </div>

               



                

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