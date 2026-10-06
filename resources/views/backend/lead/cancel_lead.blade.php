@extends('backend.layouts.app')

@section('content')


<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container-fluid py-4">

        <!-- Filter and Add Button -->
        <div class="row align-items-end mb-4">

            <form method="get" action="" class="mb-4">
                <div class="card shadow-sm">
                    <div class="card-body py-3 px-3">
                        <div class="row g-2">

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Name</strong></small></label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    value="{{ request('name') }}" placeholder="Name">
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Email</strong></small></label>
                                <input type="text" name="email" class="form-control form-control-sm"
                                    value="{{ request('email') }}" placeholder="Email">
                            </div>


                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Phone</strong></small></label>
                                <input type="text" name="phone" class="form-control form-control-sm"
                                    value="{{ request('phone') }}" placeholder="Phone">
                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <label><small><strong>Gender</strong></small></label>
                                <select name="gender" class="form-control form-control-sm">
                                    <option value="">-- Gender --</option>
                                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>





                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Date (From)</strong></small></label>
                                <input type="date" name="date_from" class="form-control form-control-sm"
                                    value="{{ request('date_from') }}">
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label><small><strong>Date (To)</strong></small></label>
                                <input type="date" name="date_to" class="form-control form-control-sm"
                                    value="{{ request('date_to') }}">
                            </div>

                            <div class="col-lg-1 col-md-4 col-sm-6">
                                <label><small><strong>Records/Page</strong></small></label>
                                <select name="r_page" class="form-control form-control-sm">
                                    <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 </option>
                                    <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 </option>
                                    <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 </option>
                                </select>
                            </div>

                            <div class="col-lg-1 col-md-4 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-sm btn-info w-100">Apply Filter</button>
                            </div>

                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-end">
                                <a href="{{ url('admin/add-lead') }}" class="btn btn-sm btn-success w-100">
                                    <i class="fas fa-plus-circle mr-1"></i> Add Lead
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-end">
                                <a href="{{ route('admin.leads.export', request()->query()) }}"
                                    class="btn btn-sm btn-warning w-100">
                                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                                </a>
                            </div>



                        </div>
                    </div>
                </div>
            </form>






        </div>

        <!-- Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cancel Lead Overview</h5>
            </div>
            <br>
            @if (\Session::has('success'))
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
            @endif


            @if (\Session::has('error'))
            <div class="alert alert-danger">
                {!! \Session::get('error') !!}
            </div>
            @endif

            <div class="card-body p-0">
                @if($leads->total() > 0)

                <div class="table-responsive">
                    <table id="tablesearchfilter" class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>S. No.</th>

                                <th>Lead Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>

                                <th>Gaurdian Phone</th>
                                <th>Description</th>
                                <th>Address</th>


                                <th>Purpose</th>
                                <th>Lead Source</th>
                                <th>Lead Status</th>

                                <th>Assigned To</th>
                                <th>Added By</th>
                                <th>Status</th>

                                <th>Date Added</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = ($leads->currentPage() - 1) * $leads->perPage();
                            @endphp
                            @foreach($leads as $bl)
                            <tr>
                                <td>{{ ++$i }}</td>






                                <td>{{ $bl->lead_id }}</td>
                                <td>{{ $bl->name }}</td>
                                <td>{{ $bl->email }}</td>
                                <td>{{ $bl->phone }}</td>

                                <td>
                                    {{ $bl->gaurdian_phone }}
                                </td>
                                <td>
                                    {{ $bl->description }}
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                        {{ $bl->address }}
                                    </div>
                                </td>


                                <!-- Purpose Name -->
                                <td>
                                    @php
                                    $selectedPurposes = explode(',', $bl->purpose_id ?? '');
                                    $matchedPurposeNames = $purposes->whereIn('id',
                                    $selectedPurposes)->pluck('name')->toArray();
                                    @endphp
                                    <div class="d-flex flex-wrap" style="gap: 6px;">
                                        @forelse($matchedPurposeNames as $purposeName)
                                        <span class="badge"
                                            style="background-color: #17a2b8; color: white; padding: 6px 12px; border-radius: 20px;">
                                            {{ $purposeName }}
                                        </span>
                                        @empty
                                        <span class="text-muted">No Purpose Name Found</span>
                                        @endforelse
                                    </div>
                                </td>

                                <!-- Lead Source -->
                                <td>
                                    @php
                                    $source = DB::table('tbl_lead_source')->where('id',
                                    $bl->source_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $source ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($source->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $source->name ?? 'Unknown' }}</span>
                                </td>

                                <!-- Lead Status -->
                                <td>
                                    @php
                                    $status = DB::table('tbl_lead_status')->where('id',
                                    $bl->status_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $status ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($status->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $status->status ?? 'Unknown' }}</span>
                                </td>



                                <!-- Assigned To -->
                                <td>
                                    @php
                                    $assignTo = DB::table('users')->where('id',
                                    $bl->lead_assign_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $assignTo ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($assignTo->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $assignTo->name ?? 'Unknown' }}</span>
                                </td>


                                <!-- Added By -->
                                <td>
                                    @php
                                    $addedBy = DB::table('users')->where('id',
                                    $bl->add_id)->where('is_deleted', '0')->first();
                                    $badgeClass = $addedBy ?
                                    ['primary','secondary','success','danger','warning','info','dark'][crc32($addedBy->name)%7]
                                    : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $addedBy->name ?? 'Unknown' }}</span>
                                </td>


                                <td>
                                    @if($bl->status === 'Active')
                                    <a class="badge badge-success"
                                        href="{{ url('admin/update-lead-status/'.$bl->id.'?status=Inactive') }}">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </a>
                                    @else
                                    <a class="badge badge-danger"
                                        href="{{ url('admin/update-lead-status/'.$bl->id.'?status=Active') }}">
                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                    </a>
                                    @endif
                                </td>




                                <td>{{ $bl->created_at->format('d M, Y') }}</td>
                            

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="gmz-pagination p-3">
                    {!! $leads->links('pagination::bootstrap-4') !!}
                </div>
                @else
                <div class="alert alert-warning m-3">No data found</div>
                @endif
            </div>
        </div>
    </div>
</div>




@endsection