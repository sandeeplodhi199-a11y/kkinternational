@extends('backend.layouts.app')
@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <div class="row mart10 padd">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
      <a class="btn btn-primary btn-sm float-right" href="{{url('admin/level')}}">Manage Level</a>
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
              <h3 class="card-title">Edit Level</h3>

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
              {{-- ✅ Success Message --}}
@if (\Session::has('success'))
    <div class="alert alert-success">
        {!! \Session::get('success') !!}
    </div>
@endif

{{-- ❌ Error Message --}}
@if (\Session::has('error'))
    <div class="alert alert-danger">
        {!! \Session::get('error') !!}
    </div>
@endif

{{-- ⚠️ Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin-bottom:0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
              <form method="post" action="{{url('admin/updateLevel')}}" enctype="multipart/form-data">
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
                      <label>Orders By</label>
                      <input type="text" class="form-control" name="orders_by" required value="{{$page->orders_by}}">
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