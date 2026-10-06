@extends('backend.layouts.app')

@section('content')

<style>
  .assign-wrap{
display:flex;
flex-wrap:wrap;
gap:4px;
max-width:500px;
}

.grade-box{
display:inline-block;
background:#f7f7f7;
border:1px solid #ddd;
padding:2px 6px;
border-radius:5px;
font-size:11px;
line-height:1.2;
}

.sec-badge{
background:#17a2b8;
padding:1px 4px;
font-size:10px;
margin:0 1px;
}

.sub-text{
font-size:10px;
font-weight:600;
}

table td{
vertical-align:top;
padding:6px !important;
}

.assign-scroll{
max-height:120px;   /* row fixed */
overflow-y:auto;
padding-right:5px;
line-height:1.4;
font-size:13px;
}

.btn.btn-primary {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 31px;
    padding: 7px;
    display: inline-block;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">

         @php
                    $user = Auth::user();
                @endphp
                     
                        @if($user->type !== 'teacher')
        <div class="row align-items-end mb-4">
            <form method="get" class="mb-4 w-100">
                <div class="card shadow-sm">
                    <div class="card-body py-3 px-3">
                        <div class="row g-2">

                            <div class="col-md-2">
                                <label><small><strong>Name</strong></small></label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                       value="{{ request('name') }}">
                            </div>

                            <div class="col-md-2">
                                <label><small><strong>Email</strong></small></label>
                                <input type="text" name="email" class="form-control form-control-sm"
                                       value="{{ request('email') }}">
                            </div>

                            <div class="col-md-2">
                                <label><small><strong>Phone</strong></small></label>
                                <input type="text" name="phone" class="form-control form-control-sm"
                                       value="{{ request('phone') }}">
                            </div>

                            <div class="col-md-2">
                                <label><small><strong>Gender</strong></small></label>
                                <select name="gender" class="form-control form-control-sm">
                                    <option value="">-- Gender --</option>
                                    <option value="Male" {{ request('gender')=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ request('gender')=='Female'?'selected':'' }}>Female</option>
                                    <option value="Other" {{ request('gender')=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label><small><strong>DOB From</strong></small></label>
                                <input type="date" name="dob_from" class="form-control form-control-sm"
                                       value="{{ request('dob_from') }}">
                            </div>

                            <div class="col-md-2">
                                <label><small><strong>DOB To</strong></small></label>
                                <input type="date" name="dob_to" class="form-control form-control-sm"
                                       value="{{ request('dob_to') }}">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-info btn-sm w-100">Filter</button>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <a href="{{ url('admin/add-teacher') }}" class="btn btn-success btn-sm w-100">
                                    + Add Teacher
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <!-- ================= TABLE ================= -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Teacher Overview</h5>
            </div>

            <div class="card-body p-0">

                @if($teachers->count())

                <div class="table-responsive">
                    <table id="tablesearchfilter" class="table table-bordered table-striped table-hover mb-0">

                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th  width="300">Action</th>
                                <th>Teacher ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th width="1000">Assign Details</th>
                                <th>Image</th>
                                <!--<th>State</th>-->
                                <th>Status</th>
                                <th>Date</th>
                            
                            </tr>
                        </thead>

                        <tbody>

                         
                       @php $i = 1; @endphp
                            

                            @foreach($teachers as $t)
                            <tr>

                              <td>{{ $i++ }}</td>
                           <td style="width:350px;">
                                
                                @if(in_array('5_3', $permExplodesub))

                                <a href="{{ url('admin/edit-teacher/'.$t->id_hash) }}"
                                   class="btn btn-sm btn-primary">Edit</a>
                               
                                @endif
                                
                                  @if(in_array('5_10', $permExplodesub))

                                <a href="{{ url('admin/teacher/chapter-status/'.$t->id) }}"
                                   class="btn btn-sm btn-success">Chapter Status</a>
                               
                                @endif
                                
                                @if(in_array('5_4', $permExplodesub))

                                 @if($user->type !== 'teacher')
                                    <a href="{{ url('admin/delete-teacher/'.$t->id) }}"
                                       onclick="return confirm('Delete?')"
                                       class="btn btn-sm btn-danger">Delete</a>
                                        @endif
                                        @endif
                                </td>

                                <td>{{ $t->teacher_id }}</td>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->email }}</td>
                                <td>{{ $t->phone }}</td>
                                <td style="width:450px;">
                                @php
                                $assign = $assignData[$t->id] ?? collect();
                                $grades = $assign->groupBy('grade_name');
                                @endphp
                                
                                <div class="assign-scroll">
                                @forelse($grades as $grade=>$items)
                                    <div class="mb-1">
                                        <b class="text-primary">{{ $grade }}:</b>
                                
                                        @foreach($items->groupBy('section_name') as $section=>$secItems)
                                            <span class="badge bg-info">{{ $section }}</span>
                                            {{ $secItems->pluck('subject_name')->implode(', ') }}
                                            @if(!$loop->last) | @endif
                                        @endforeach
                                    </div>
                                @empty
                                N/A
                                @endforelse
                                </div>
</td>

                                <td>
                                    @if($t->image)
                                        <img src="{{ url('public/teacher/uploads/'.$t->image) }}"
                                             style="height:40px;width:40px;border-radius:50%;">
                                    @endif
                                </td>

                                <!--<td>{{ $t->state }}</td>-->

                                <td>
                                    <span class="badge bg-success">{{ $t->status }}</span>
                                </td>

                                <td>{{ date('d M Y', strtotime($t->created_at)) }}</td>
                                
                                  @php
                                    $user = Auth::user();
                                @endphp
                                     
                                       

                               
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

              

                @else
                    <div class="p-3 text-center">No Data Found</div>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection