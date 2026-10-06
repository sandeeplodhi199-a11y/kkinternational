@extends('backend.layouts.app')

@section('content')
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

<style>
* { font-family: "Inter", Arial, sans-serif; }
.badge-transfer { background: #e8f4fd; color: #1a56db; font-size: 0.75rem; padding: 3px 8px; border-radius: 4px; font-weight: 600; }
.action-btn { padding: 4px 10px; font-size: 0.8rem; border-radius: 4px; }
</style>

<div class="content-wrapper">
  <div class="container-fluid py-4">
    <div class="content d-flex flex-column flex-column-fluid">
      <div class="container-xxl">
        <div class="card">

          <div class="card-header border-0 px-6 d-flex align-items-center justify-content-between">
            <div class="card-title">
              <h1 class="my-1">10th Transfer Certificate List</h1>
            </div>
            @if(in_array('transfer_certificate_10th', $permExplodesub))
            <a href="{{ route('transfer.certificate.10th') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus me-1"></i> New Certificate
            </a>
            @endif
          </div>

          <!-- ===== FILTER ===== -->
          <div class="card-body pt-3 pb-0">
            <form method="GET" action="{{ route('transfer.list.10th') }}" class="row g-2 align-items-end">
              <div class="col-md-3">
                <label class="fw-bold fs-6 mb-1">Date From</label>
                <input type="date" name="date_from" class="form-control form-control-solid"
                  value="{{ request('date_from') }}" />
              </div>
              <div class="col-md-3">
                <label class="fw-bold fs-6 mb-1">Date To</label>
                <input type="date" name="date_to" class="form-control form-control-solid"
                  value="{{ request('date_to') }}" />
              </div>
              <div class="col-md-4">
                <label class="fw-bold fs-6 mb-1">Search</label>
                <input type="text" name="search" class="form-control form-control-solid"
                  placeholder="Name / Admission No / Symbol No"
                  value="{{ request('search') }}" />
              </div>
              <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                  <i class="fas fa-search me-1"></i> Search
                </button>
                <a href="{{ route('transfer.list.10th') }}" class="btn btn-light flex-fill">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </form>
          </div>

          <!-- ===== TABLE ===== -->
          <div class="card-body pt-4">
            <div class="table-responsive">
              <table class="table table-bordered table-hover align-middle" id="transferTable">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>S.No.</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Admission No</th>
                    <th>Symbol No</th>
                    <th>Exam Year</th>
                    <th>GPA</th>
                    <th>Issue Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($transfers as $key => $row)
                  <tr>
                    <td>{{ $i + $key + 1 }}</td>
                    <td>{{ $row->serial_no ?? '-' }}</td>
                    <td>
                      <span class="fw-bold">{{ $row->student_name ?? '-' }}</span><br>
                      <small class="text-muted">{{ $row->mother_name ?? '' }}</small>
                    </td>
                    <td>{{ $row->father_name ?? '-' }}</td>
                    <td>{{ $row->admission_no ?? '-' }}</td>
                    <td>{{ $row->symbol_no ?? '-' }}</td>
                    <td>{{ $row->exam_year ?? '-' }}</td>
                    <td>
                      @if($row->gpa)
                        <span class="badge-transfer">{{ $row->gpa }}</span>
                      @else
                        -
                      @endif
                    </td>
                    <td>{{ $row->issue_date ?? '-' }}</td>
                    <td>
                      <div class="d-flex gap-1">
                          @if(in_array('4_6', $permExplodesub))

                        <a href="{{ route('transfer.edit.10th', $row->id) }}"
                           class="btn btn-sm btn-warning action-btn" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        @endif
                       
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="10" class="text-center text-muted py-4">No records found.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Count -->
            <div class="text-muted small mt-2">
              Total: <strong>{{ $transfers->count() }}</strong> record(s)
            </div>

          </div><!-- /card-body -->
        </div><!-- /card -->
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#transferTable').DataTable({
        paging: false,
        searching: false,
        info: false,
        order: [],
    });
});
</script>
@endsection