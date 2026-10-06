@extends('backend.layouts.app')
@section('content')



<div class="content-wrapper">

    <div class="row mart10 padd">
        <div class="col-md-8">
            <form class="row" method="get" action="">
                <div class="col-md-4 no-margin-left">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Keywords"
                            value="{{ $data['keyword'] ?? '' }}">
                    </div>
                </div>

                <div class="col-md-2 no-padding-left">
                    <div class="form-group">
                        <select class="form-control select2" name="r_page">
                            <option value="25">25 Records Per Page</option>
                            <option value="50" {{ ($data['r_page'] ?? '') == '50' ? 'selected' : '' }}>50 Records Per
                                Page</option>
                            <option value="100" {{ ($data['r_page'] ?? '') == '100' ? 'selected' : '' }}>100 Records Per
                                Page</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-1 no-padding-left">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <a class="btn btn-primary btn-sm float-right" href="{{ url('admin/add-users') }}">Add New User</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">User Management</h3>
                        </div>

                        <div class="card-body">

                            @if(Session::has('success'))
                            <div class="alert alert-success">
                                {!! Session::get('success') !!}
                            </div>
                            @endif

                            @if($categories->total() > 0)
                            <div class="table-responsive">
                                <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sno</th>
                                            <!--<th>Hierarchy</th>-->
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Added By</th>
                                            <th>Updated By</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $i = 0; @endphp
                                        @foreach($categories as $cat)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                          
                                <!--            <td>
                                                @php
                                                $manager = $cat->manager_id
                                                ? DB::table('tbl_manager')->where('manager_id',
                                                $cat->manager_id)->first()
                                                : null;

                                                $tl = $cat->tl_id
                                                ? DB::table('tbl_team_leader')->where('tl_id', $cat->tl_id)->first()
                                                : null;

                                                $telecaller = $cat->telecaller_id
                                                ? DB::table('tbl_telecaller')->where('telecaller_id',
                                                $cat->telecaller_id)->first()
                                                : null;
                                                @endphp

                                                @if($manager || $tl || $telecaller)
                                                <div class="d-flex align-items-center flex-wrap gap-1">

                                                  
                                                    @if($manager)
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-user-tie"></i>
                                                        {{ $manager->name }}
                                                    </span>
                                                    @endif

                                                   
                                                    @if($tl)
                                                    <span class="text-muted mx-1">➜</span>
                                                    @endif

                                                   
                                                    @if($tl)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-users-cog"></i>
                                                        {{ $tl->name }}
                                                    </span>
                                                    @endif

                                                   
                                                    @if($telecaller)
                                                    <span class="text-muted mx-1">➜</span>
                                                    @endif

                                                 
                                                    @if($telecaller)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-headset"></i>
                                                        {{ $telecaller->name }}
                                                    </span>
                                                    @endif

                                                </div>
                                                @endif
                                            </td>  -->

                                            <td>{{ $cat->name }}</td>
                                            <td>{{ $cat->email }}</td>
                                            <td>{{ $cat->mobile }}</td>
                                           <td>
                                            @if($cat->type=='admin')
                                                <span class="badge bg-danger">Admin</span>
                                        
                                            @elseif($cat->type=='subadmin')
                                                <span class="badge bg-warning text-dark">Subadmin</span>
                                        
                                            @elseif($cat->type=='teacher')
                                                <span class="badge bg-success">Teacher</span>
                                        
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($cat->type) }}
                                                </span>
                                            @endif
                                        </td>

                                            {{-- Added By --}}
                                            <td>
                                                @php
                                                $addedBy = DB::table('users')
                                                ->where('id', $cat->add_id)
                                                ->where('is_deleted', 0)
                                                ->first();
                                                @endphp

                                                <span class="badge bg-primary">{{ $addedBy->name ?? 'N/A' }}</span>
                                                <span
                                                    class="badge bg-secondary">({{ ucfirst($addedBy->type ?? 'N/A') }})</span>
                                            </td>

                                            {{-- Updated By --}}
                                            <td>
                                                @php
                                                $updatedBy = DB::table('users')
                                                ->where('id', $cat->updated_id)
                                                ->where('is_deleted', 0)
                                                ->first();
                                                @endphp

                                                <span class="badge bg-info">{{ $updatedBy->name ?? 'N/A' }}</span>
                                                <span
                                                    class="badge bg-secondary">({{ ucfirst($updatedBy->type ?? 'N/A') }})</span>
                                            </td>

                                            <td>{{ $cat->created_at }}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <i class="fa fa-ellipsis-v" data-toggle="dropdown"></i>
                                                    <div class="dropdown-menu">
                                                        @php
                                                        $permExplodesub = explode(',', Auth::user()->permission_submenu
                                                        ?? '');
                                                        @endphp
                                                        @if(in_array('6_2', $permExplodesub))
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/edit-permission/'.$cat->id) }}">Permission</a>
                                                        @endif

                                                        @if(in_array('6_3', $permExplodesub))
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/edit-users/'.$cat->id) }}">Edit</a>
                                                        @endif

                                                        @if(in_array('6_4', $permExplodesub))
                                                        <a class="dropdown-item"
                                                            onclick="return confirm('Are you sure?')"
                                                            href="{{ url('admin/delete-users/'.$cat->id) }}">Delete</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="gmz-pagination">
                                {!! $categories->links('pagination::bootstrap-4') !!}
                            </div>
                            @else
                            <div class="alert alert-warning">No data</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection