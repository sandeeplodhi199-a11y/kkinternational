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
                        <input type="text" name="keyword" class="form-control" placeholder="Keywords"
                            value="<?=$data['keyword'];?>">
                    </div>
                </div>
            <!--    <div class="col-md-2 no-padding-left">
                    <div class="form-group">
                        <select class="form-control select2" name="r_page">
                            <option value="25"> 25 Records Per Page</option>
                            <option <?php if($data['r_page'] == '50'){ echo "selected"; } ?> value="50"> 50 Records Per
                                Page</option>
                            <option <?php if($data['r_page'] == '100'){ echo "selected"; } ?> value="100"> 100 Records
                                Per Page</option>
                        </select>
                    </div>
                </div> -->

                <div class="col-md-1 no-padding-left">
                    <div class="form-group ">
                        <button type="submit" class="btn btn-primary"> Filter</button>
                    </div>
                </div>
            </form>
        </div>



        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{url('admin/add-grade')}}">Add New Grade</a>
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
                            <h3 class="card-title">Grade Management</h3>

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
                            <div class="table-responsive">
                                 <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sno</th>
                                            <th>ID</th>
                                            <th>Level Name</th>
                                            <th>Name</th>

                                            <th>Order By</th>
                                            <th>Status</th>
                                            <th>Is Deleted</th>
                                            <th>Added By</th>
                                            <th>Update By</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($page as $pgs)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $pgs->id }}</td>
                                            <td>
                                                @php
                                                $levelName = DB::table('tbl_level')
                                                ->where('id', $pgs->level_id)
                                                ->value('name');
                                                @endphp

                                                {{ $levelName }}
                                            </td>
                                            <td>{{ $pgs->name }}</td>

                                            <td>{{ $pgs->orders_by }}</td>

                                            <td>
                                                @if($pgs->status == 'Active')
                                                <a class="text-success"
                                                    href="{{ url('admin/grade/'.$pgs->id.'?status=Inactive') }}">
                                                    Active
                                                </a>
                                                @else
                                                <a class="text-danger"
                                                    href="{{ url('admin/grade/'.$pgs->id.'?status=Active') }}">
                                                    Inactive
                                                </a>
                                                @endif
                                            </td>

                                            <td>{{ $pgs->is_deleted }}</td>
                                            @php
                                            $colors =
                                            ['bg-primary','bg-success','bg-danger','bg-warning','bg-info','bg-dark'];
                                            @endphp

                                            <td>
                                                @if(isset($users[$pgs->add_id]))
                                                @php $color = $colors[array_rand($colors)]; @endphp
                                                <span class="badge {{ $color }}">
                                                    {{ $users[$pgs->add_id] }}
                                                </span>
                                                @else
                                                <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if(isset($users[$pgs->update_id]))
                                                @php $color = $colors[array_rand($colors)]; @endphp
                                                <span class="badge {{ $color }}">
                                                    {{ $users[$pgs->update_id] }}
                                                </span>
                                                @else
                                                <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $pgs->created_at }}</td>
                                            <td>{{ $pgs->updated_at }}</td>
                                            
                                            @if(in_array('2_7', $permExplodesub) || in_array('2_8', $permExplodesub))

                                            <td>
                                                <div class="dropdown">
                                                    <i class="fa fa-ellipsis-v" data-toggle="dropdown"></i>

                                                    <div class="dropdown-menu">
                                                        

                                                        @if(in_array('2_7', $permExplodesub))
                                                        <a class="dropdown-item"
                                                            href="{{url('admin/edit-grade/'.$pgs->id_hash)}}">Edit</a>
                                                        @endif

                                                        @if(in_array('2_8', $permExplodesub))
                                                        <a onclick="return confirm('Are you sure?')"
                                                            class="dropdown-item"
                                                            href="{{url('admin/delete-grade/'.$pgs->id)}}">Delete</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            @endif
                                        </tr>
                                        <?php ++$i; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                         <div class="gmz-pagination">
                                {{ $page->links('pagination::simple-default') }}
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