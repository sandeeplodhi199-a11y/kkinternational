@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row mart10 padd mb-2">
        <div class="col-md-8">
            <h4><i class="fas fa-calendar-plus text-primary"></i> Add Follow Up</h4>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ url('admin/leadmaster') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-users-cog"></i> Manage Lead
            </a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">

                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {!! Session::get('success') !!}
                    </div>
                    @endif

                    <!-- Add Follow Up Form -->
                    <form method="POST" action="{{ url('admin/saveFollowUp') }}">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">-- Select Status --</option>
                                    @foreach($leadStatus as $sta)
                                    <option value="{{ $sta->id }}">{{ $sta->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Follow Up Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="follow_date" class="form-control" required>

                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Comment</label>
                                <textarea name="comment" class="form-control" rows="3"
                                    placeholder="Write your comment..."></textarea>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Add Follow Up
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Follow-up Table -->
                    @if ($followup->total() > 0)
                    <div class="table-responsive mt-4">
                      <table class="table table-bordered table-hover">
    <thead class="thead-danger text-white bg-danger">
        <tr>
            <th>#</th>
            <th>Followed Up By</th>
            <th>Remark</th>
            <th>Next Follow Up Date & Time</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($followup->sortBy('follow_date') as $index => $cat)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                @php
                    $getFollowBy = DB::table('users')->where('id', $cat->follow_by)->value('name');
                @endphp
                <span class="badge badge-primary p-2">{{ $getFollowBy }}</span>
            </td>

            <td>
                <span class="badge badge-info p-2">{{ $cat->comment }}</span>
            </td>

            <td>
                {{ \Carbon\Carbon::parse($cat->follow_date)->format('d F Y, g:i A') }}
            </td>

            <td class="text-center">
                <a href="{{ url('admin/delete-followup/' . $cat->id) }}"
                   onclick="return confirm('Are you sure you want to delete this follow-up?')"
                   class="btn btn-sm btn-outline-danger"
                   title="Delete Follow Up">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


                    </div>

                    <div class="mt-3">
                        {!! $followup->links('pagination::bootstrap-4') !!}
                    </div>
                    @else
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-circle"></i> No follow-ups found.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Font Awesome Tooltip Support -->
@push('scripts')
<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endpush

@endsection