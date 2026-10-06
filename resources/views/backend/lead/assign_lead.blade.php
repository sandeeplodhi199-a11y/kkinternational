@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row mart10 padd">
        <!-- Filter Form -->
        <div class="col-md-8">
            <form method="GET" action="">
                <div class="row g-2 align-items-center">
                    <!-- Keyword -->
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Keywords"
                            value="{{ request('keyword') }}">
                    </div>

                    <!-- Manager -->
                    <div class="col-md-2">
                        <select name="manager_id" class="form-control select2">
                            <option value="">-- Select Manager --</option>
                            @foreach($managers as $man)
                            <option value="{{ $man->manager_id }}"
                                {{ request('manager_id') == $man->manager_id ? 'selected' : '' }}>
                                {{ $man->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TL -->
                    <div class="col-md-2">
                        <select name="tl_id" class="form-control select2">
                            <option value="">-- Select TL --</option>
                            @foreach($tls as $tl)
                            <option value="{{ $tl->tl_id }}" {{ request('tl_id') == $tl->tl_id ? 'selected' : '' }}>
                                {{ $tl->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Telecaller -->
                    <div class="col-md-2">
                        <select name="telecaller_id" class="form-control select2">
                            <option value="">-- Select Telecaller --</option>
                            @foreach($telecallers as $tele)
                            <option value="{{ $tele->telecaller_id }}"
                                {{ request('telecaller_id') == $tele->telecaller_id ? 'selected' : '' }}>
                                {{ $tele->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Records per page -->
                    <div class="col-md-2">
                        <select class="form-control select2" name="r_page">
                            <option value="25" {{ request('r_page') == 25 ? 'selected' : '' }}>25 Records Per Page
                            </option>
                            <option value="50" {{ request('r_page') == 50 ? 'selected' : '' }}>50 Records Per Page
                            </option>
                            <option value="100" {{ request('r_page') == 100 ? 'selected' : '' }}>100 Records Per Page
                            </option>
                        </select>
                    </div>

                    <!-- Filter button -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Lead Master Button -->
        <div class="col-md-4 text-end">
            <a class="btn btn-primary btn-sm" href="{{ url('admin/add-leadmaster') }}">
                Add New Lead Master
            </a>
        </div>
    </div>

    <!-- Distribute Form -->
    <form method="POST" action="{{ route('admin.leads.distribute') }}">
        @csrf
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                <h3 class="card-title mb-2 mb-md-0">Lead Master Management</h3>


                                <div class="d-flex flex-nowrap align-items-center gap-2">
                                    <!-- Manager -->
                                    <select name="manager_id" id="manager_id" class="form-select select2"
                                        style="width:200px;">
                                        <option value="">-- Select Manager --</option>
                                        @foreach($managers as $man)
                                        <option value="{{ $man->manager_id }}"
                                            {{ request('manager_id') == $man->manager_id ? 'selected' : '' }}>
                                            {{ $man->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <!-- TL -->
                                    <select name="tl_id" id="tl_id" class="form-select select2" style="width:200px;">
                                        <option value="">-- Select TL --</option>
                                    </select>

                                    <!-- Telecaller -->
                                    <select name="telecaller_id" id="telecaller_id" class="form-select select2"
                                        style="width:200px;">
                                        <option value="">-- Select Telecaller --</option>
                                    </select>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success">Distribute Selected Leads</button>
                                </div>

                            </div>

                            <div class="card-body">
                                {{-- success/error messages --}}
                                @if (\Session::has('success'))
                                <div class="alert alert-success">{!! \Session::get('success') !!}</div>
                                @endif

                                {{-- Table --}}
                                @if($page->total() > 0)
                                <div class="table-responsive p-0">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sno</th>
                                                <th><input type="checkbox" id="checkAll"></th>
                                                <th>Assigned By Admin</th>
                                                <th>Assigned To</th>
                                                 <th>Added By</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Gaurdian Phone</th>
                                                <th>Description</th>
                                                <th>Address</th>
                                                <th>Purpose</th>
                                                <th>Lead Status</th>
                                                <th>Lead Source</th>
                                                <th>Added By</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- loop start --}}
                                            @php $i = ($page->currentPage() - 1) * $page->perPage(); @endphp
                                            @foreach ($page as $pgs)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td><input type="checkbox" class="lead-checkbox" name="lead_id[]"
                                                        value="{{ $pgs->id }}"></td>
                                                <td>
                                                    @if ($pgs->assign_to == '1')
                                                    @php
                                                    $manager = $pgs->manager_id ?
                                                    DB::table('tbl_manager')->where('manager_id',
                                                    $pgs->manager_id)->first() : null;
                                                    $tl = $pgs->tl_id ? DB::table('tbl_team_leader')->where('tl_id',
                                                    $pgs->tl_id)->first() : null;
                                                    $telecaller = $pgs->telecaller_id ?
                                                    DB::table('tbl_telecaller')->where('telecaller_id',
                                                    $pgs->telecaller_id)->first() : null;

                                                    $assignedType = null;

                                                    if ($pgs->lead_assign_id) {
                                                    if ($manager && $pgs->lead_assign_id == $manager->manager_id) {
                                                    $assignedType = 'manager';
                                                    } elseif ($tl && $pgs->lead_assign_id == $tl->tl_id) {
                                                    $assignedType = 'tl';
                                                    } elseif ($telecaller && $pgs->lead_assign_id ==
                                                    $telecaller->telecaller_id) {
                                                    $assignedType = 'telecaller';
                                                    }
                                                    }
                                                    @endphp

                                                    @if($manager || $tl || $telecaller)
                                                    <div class="d-inline-flex align-items-center gap-2">

                                                        {{-- Manager --}}
                                                        @if($manager)
                                                        <span
                                                            class="badge @if($assignedType=='manager') bg-warning text-dark @else bg-secondary @endif">
                                                            {{ $manager->name }} (Manager)
                                                        </span>
                                                        @endif

                                                        {{-- TL --}}
                                                        @if($tl)
                                                        <span>→</span>
                                                        <span
                                                            class="badge @if($assignedType=='tl') bg-warning text-dark @else bg-secondary @endif">
                                                            {{ $tl->name }} (TL)
                                                        </span>
                                                        @endif

                                                        {{-- Telecaller --}}
                                                        @if($telecaller)
                                                        <span>→</span>
                                                        <span
                                                            class="badge @if($assignedType=='telecaller') bg-warning text-dark @else bg-secondary @endif">
                                                            {{ $telecaller->name }} (Telecaller)
                                                        </span>
                                                        @endif

                                                    </div>
                                                    @else
                                                    <span class="text-danger">User Not Found</span>
                                                    @endif
                                                    @else
                                                    <span class="text-warning">Not Distribute</span>
                                                    @endif
                                                </td>

                                               
                                            <td>
                                                @php
                                                $assignTo = DB::table('users')->where('id',
                                                $pgs->lead_assign_id)->where('is_deleted', '0')->first();
                                                $badgeClass = $assignTo ?
                                                ['primary','secondary','success','danger','warning','info','dark'][crc32($assignTo->name)%7]
                                                : 'secondary';
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $badgeClass }}">{{ $assignTo->name ?? 'Unknown' }}</span>
                                            </td>


                                            <!-- Added By -->
                                            <td>
                                                @php
                                                $addedBy = DB::table('users')->where('id',
                                                $pgs->add_id)->where('is_deleted', '0')->first();
                                                $badgeClass = $addedBy ?
                                                ['primary','secondary','success','danger','warning','info','dark'][crc32($addedBy->name)%7]
                                                : 'secondary';
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $badgeClass }}">{{ $addedBy->name ?? 'Unknown' }}</span>
                                            </td>




                                                <td>{{ $pgs->name }}</td>
                                                <td>{{ $pgs->phone }}</td>
                                                <td>{{ $pgs->email }}</td>
                                                <td>{{ $pgs->gaurdian_phone }}</td>
                                                <td>{{ $pgs->description }}</td>
                                                <td style="max-width:200px; overflow-x:auto; white-space:nowrap;">
                                                    {{ $pgs->address }}</td>

                                                <!-- Purpose Name -->
                                                <td>
                                                    @php
                                                    $selectedPurposes = explode(',', $pgs->purpose_id ?? '');
                                                    $matchedPurposeNames = $purposes->whereIn('id',
                                                    $selectedPurposes)->pluck('name')->toArray();
                                                    @endphp
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @forelse($matchedPurposeNames as $purposeName)
                                                        <span class="badge bg-info">{{ $purposeName }}</span>
                                                        @empty
                                                        <span class="text-muted">No Purpose</span>
                                                        @endforelse
                                                    </div>
                                                </td>

                                                <!-- Lead Status -->
                                                @php
                                                $badgeColors =
                                                ['primary','secondary','success','danger','warning','info','dark'];
                                                $status =
                                                DB::table('tbl_lead_status')->where('is_deleted','0')->where('id',
                                                $pgs->status_id)->first();
                                                @endphp
                                                <td>
                                                    @if($status)
                                                    <span
                                                        class="badge bg-{{ $badgeColors[crc32($status->status) % count($badgeColors)] }}">{{ $status->status }}</span>
                                                    @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>

                                                <!-- Lead Source -->
                                                @php
                                                $source =
                                                DB::table('tbl_lead_source')->where('is_deleted','0')->where('id',
                                                $pgs->source_id)->first();
                                                @endphp
                                                <td>
                                                    @if($source)
                                                    <span
                                                        class="badge bg-{{ $badgeColors[crc32($source->id) % count($badgeColors)] }}">{{ $source->name }}</span>
                                                    @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>

                                                <!-- Added By -->
                                                <td>
                                                    @php
                                                    $addedBy = DB::table('users')
                                                    ->where('is_deleted','0')
                                                    ->where(function($query) use ($pgs) {
                                                    $query->where('id',$pgs->add_id)
                                                    ->orWhere('manager_id',$pgs->add_id)
                                                    ->orWhere('tl_id',$pgs->add_id)
                                                    ->orWhere('telecaller_id',$pgs->add_id);
                                                    })
                                                    ->first();

                                                    $badgeClass = $addedBy ? $badgeColors[crc32($addedBy->name) %
                                                    count($badgeColors)] : 'secondary';
                                                    $displayName = $addedBy->name ?? 'Unknown';

                                                    $role = 'Unknown';
                                                    if ($addedBy) {
                                                    if ($addedBy->id == $pgs->add_id) $role = 'Admin';
                                                    elseif ($addedBy->manager_id == $pgs->add_id) $role = 'Manager';
                                                    elseif ($addedBy->tl_id == $pgs->add_id) $role = 'TL';
                                                    elseif ($addedBy->telecaller_id == $pgs->add_id) $role =
                                                    'Telecaller';
                                                    else $role = 'Subadmin';
                                                    }
                                                    @endphp

                                                    <span class="badge bg-{{ $badgeClass }}">{{ $displayName }}
                                                        ({{ $role }})</span>
                                                </td>

                                                <td>{{ $pgs->created_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="gmz-pagination mt-3">
                                    {!! $page->links('pagination::bootstrap-4') !!}
                                </div>
                                @else
                                <div class="alert alert-warning">No data found</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

{{-- Scripts --}}
<script>
document.getElementById('checkAll').addEventListener('change', function() {
    document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>

<script>
$(document).ready(function() {
    function loadTL(managerId, selectedTL = null) {
        if (managerId) {
            $.get('{{ route("get.tl", [":id"]) }}'.replace(':id', managerId), function(data) {
                $('#tl_id').empty().append('<option value="">-- Select TL --</option>');
                $('#telecaller_id').empty().append('<option value="">-- Select Telecaller --</option>');
                if (data.length > 0) {
                    $.each(data, function(_, value) {
                        var selected = selectedTL == value.tl_id ? 'selected' : '';
                        $('#tl_id').append('<option value="' + value.tl_id + '" ' + selected +
                            '>' + value.name + '</option>');
                    });
                } else {
                    $('#tl_id').append('<option value="">No result found</option>');
                }
            });
        }
    }

    function loadTelecaller(tlId, selectedTelecaller = null) {
        if (tlId) {
            $.get('{{ route("get.telecaller", [":id"]) }}'.replace(':id', tlId), function(data) {
                $('#telecaller_id').empty().append('<option value="">-- Select Telecaller --</option>');
                if (data.length > 0) {
                    $.each(data, function(_, value) {
                        var selected = selectedTelecaller == value.telecaller_id ? 'selected' :
                            '';
                        $('#telecaller_id').append('<option value="' + value.telecaller_id +
                            '" ' +
                            selected + '>' + value.name + '</option>');
                    });
                } else {
                    $('#telecaller_id').append('<option value="">No result found</option>');
                }
            });
        }
    }

    var selectedManager = '{{ request("manager_id") }}';
    var selectedTL = '{{ request("tl_id") }}';
    var selectedTelecaller = '{{ request("telecaller_id") }}';

    if (selectedManager) loadTL(selectedManager, selectedTL);
    if (selectedTL) loadTelecaller(selectedTL, selectedTelecaller);

    $('#manager_id').on('change', function() {
        loadTL($(this).val());
    });
    $('#tl_id').on('change', function() {
        loadTelecaller($(this).val());
    });
});
</script>
@endsection