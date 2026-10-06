@extends('backend.layouts.app')

@section('content')







  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

   

   <div class="row mart10 padd">

        <div class="col-md-8">

          <form class="row" method="get" action="">

            <div class="col-md-4 no-margin-left">

                <div class="form-group">

                    <input type="text" name="keyword" class="form-control" placeholder="Keywords" value="<?=$data['keyword'];?>">

                </div>

              </div>

              <div class="col-md-2 no-padding-left">

                <div class="form-group">

                  <select class="form-control select2" name="r_page">

                    <option value="25"> 25 Records Per Page</option>

                    <option <?php if($data['r_page'] == '50'){ echo "selected"; } ?> value="50"> 50 Records Per Page</option>

                    <option <?php if($data['r_page'] == '100'){ echo "selected"; } ?> value="100"> 100 Records Per Page</option>

                  </select>

                </div>

              </div>



              <div class="col-md-1 no-padding-left">

                <div class="form-group " >

                    <button type="submit" class="btn btn-primary" > Filter</button> 

                </div>

              </div>

            </form>

        </div>

        


 @if(in_array('12_2', $permExplodesub))


        <div class="col-md-4">

          <a class="btn btn-primary btn-sm float-right" href="{{url('admin/add-testimonial')}}">Add New Testimonial</a>

        </div>
        
        @endif

     

   </div>





    





    <!-- Main content -->

    <section class="content">

      <div class="container-fluid">

        <div class="row">

          <div class="col-12">

            <!-- Default box -->

            <div class="card card-primary card-outline">

              <div class="card-header">

                <h3 class="card-title">Testimonials Management</h3>



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

                @if($page->total() > 0)

                <div class="table-responsive p-0">

                  <table class="table table-hover text-nowrap1">

                    <thead>

                      <tr>

                        <th>Sno</th>

                        <th> Name</th>

                        <!-- <th> Heading</th> -->

                        <!-- <th> Sub Heading</th> -->

                        <th>Rating</th>

                        <!-- <th>Image</th> -->

                        <th>Content</th>

                        <th>Date Added</th>

                        <th width="1">Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      @foreach ($page as $pgs)

                      <tr>

                        <td>{{$i+1}}</td>

                        <td>{{$pgs->name}}</td>

                        <!-- <td>{{$pgs->heading}}</td> -->

                        <!-- <td>{{$pgs->sub_heading}}</td> -->

                        <td>{{$pgs->rating}}</td>

                        <!-- <td><img src="{{url('public/uploads/'.$pgs->image)}}" style="max-width: 80px;" /></td> -->

                        <td>@php echo $pgs->content; @endphp</td>

                        <td>{{$pgs->created_at}}</td>

                        <td>  



                          <div class="dropdown">

                            <i class="fa fa-ellipsis-v side-el " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                 @if(in_array('12_3', $permExplodesub))

                                <a class="dropdown-item" href="{{url('admin/edit-testimonial/')}}/{{$pgs->id_hash}}">Edit</a>
                                @endif
                                
                                 @if(in_array('12_4', $permExplodesub))
                                 

                                <a onclick="return confirm('Are you sure you want to delete this item?');" class="dropdown-item" href="{{url('admin/delete-testimonial')}}/{{$pgs->id}}">Delete</a>
@endif
                            </div>

                          </div>

                        </td>



                      </tr>

                      <?php ++$i; ?>

                      @endforeach



                      



                    </tbody>

                  </table>

                </div>

                <div class="gmz-pagination">

                    {!! $page->links('pagination::bootstrap-4') !!}

                </div>



                @else

                    <div class="alert alert-warning">{{__('No data')}}</div>

                @endif

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