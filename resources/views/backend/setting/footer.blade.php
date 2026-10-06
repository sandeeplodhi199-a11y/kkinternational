@extends('backend.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row mart10 padd"></div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-building"></i> Footer Information</h3>

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
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! \Session::get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            @if (\Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! \Session::get('error') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif


                            <form method="post" action="{{url('admin/saveFooter')}}" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="1">
                                <div class="form-horizontal p-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-heading"></i> Footer Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-link"></i> Footer Link</label>
                                                <input type="text" class="form-control" name="link">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-sort-numeric-down"></i> Footer Sequence</label>
                                                <input type="text" class="form-control" name="sequence">
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="border: 2px solid #069;">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">


                            @if($footers->total() > 0)
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="1">Sno</th>
                                            <th>Footer Name</th>
                                            <th>Footer Link</th>
                                            <th>Footer Sequence</th>
                                            <th>Status</th>
                                            <th width="1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($footers as $foot)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $foot->name }}</td>
                                            <td>{{ $foot->link }}</td>
                                            <td>{{ $foot->sequence }}</td>

                                            <td>
                                                @php if($foot->status == 'Active'){ @endphp
                                                <a class="text-warning"
                                                    href="{{ url('admin/update-footer-status/'.$foot->id.'?status=Inactive') }}">Active</a>
                                                @php } else { @endphp
                                                <a
                                                    href="{{ url('admin/update-footer-status/'.$foot->id.'?status=Active') }}">Inactive</a>
                                                @php } @endphp
                                            </td>
                                          @if(in_array('2_7', $permExplodesub) || in_array('2_8', $permExplodesub))

                                        <td>
                                            <div class="dropdown">
                                                <i class="fa fa-ellipsis-v side-el" data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false"></i>
                                        
                                                <div class="dropdown-menu">
                                        
                                                    @if(in_array('2_7', $permExplodesub))
                                                        <a class="dropdown-item"
                                                           href="{{ url('admin/editFooter/' . $foot->id) }}">
                                                            Edit
                                                        </a>
                                                    @endif
                                        
                                                    @if(in_array('2_8', $permExplodesub))
                                                        <a class="dropdown-item"
                                                           onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ url('admin/deleteFooter/' . $foot->id) }}">
                                                            Delete
                                                        </a>
                                                    @endif
                                        
                                                </div>
                                            </div>
                                        </td>
                                        
                                        @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="gmz-pagination">
                                {!! $footers->links('pagination::bootstrap-4') !!}
                            </div>

                            @else
                            <div class="alert alert-warning">{{__('No data')}}</div>
                            @endif
                        </div>

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