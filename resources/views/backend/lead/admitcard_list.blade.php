@extends('backend.layouts.app')
@section('content')

<style>
.alert-custom {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 14px 22px;
    border-radius: 10px;
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    animation: slideIn 0.5s ease-out;
}

.alert-success-custom {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.alert-error-custom {
    background: linear-gradient(135deg, #dc3545, #a71d2a);
}

@keyframes slideIn {
    from {
        transform: translateX(120%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}


.no-record-box {
    text-align: center;
    padding: 45px 20px;
    color: #555;
    animation: fadeIn 0.6s ease-out;
}

.no-record-box i {
    font-size: 48px;
    color: #d62839;
    margin-bottom: 8px;
}

.no-record-box h5 {
    font-weight: 700;
    margin-bottom: 3px;
    font-size: 20px;
}

.no-record-box p {
    font-size: 14px;
    color: #777;
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }

    to {
        opacity: 0;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>


<style>
/* ---------- CARD TABLE ---------- */
.table-modern {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* ---------- PARENT ROW STYLE ---------- */
.parent-row {
    background: #fdf4f5 !important;
    /* Light pink theme */
}

.parent-row:hover {
    background: #fae1e4 !important;
}

/* ---------- CHILD ROW STYLE ---------- */
.subject-row {
    background: #f1f6ff !important;
    /* Soft sky blue */
}

/* ---------- CUSTOM HEADER ---------- */
.table-modern thead th {
    background: #d62839 !important;
    color: white !important;
    font-size: 15px;
    letter-spacing: 0.3px;
    font-weight: 600;
}

.table-modern td,
.table-modern th {
    padding: 12px;
    vertical-align: middle;
}

/* ---------- BUTTONS ---------- */

.btn-view {
    background: linear-gradient(135deg, #4e73df, #2f52c5);
    color: white;
    border-radius: 50px;
    padding: 6px 18px;
    font-weight: 600;
    border: none;
    transition: 0.3s;
}

.btn-view:hover {
    background: linear-gradient(135deg, #2f52c5, #1e3aa8);
    transform: translateY(-2px);
    color: #fff;
}

.btn-delete {
    background: linear-gradient(135deg, #ff5a5a, #cc0000);
    color: white !important;
    border-radius: 50px;
    padding: 6px 18px;
    font-weight: 600;
    border: none;
    transition: 0.3s;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #cc0000, #990000);
    transform: translateY(-2px);
    color: #fff !important;
}

/* ---------- SUBJECT BOX TABLE ---------- */
.subject-box {
    background: white;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
}

.subject-box thead tr {
    background: #4e73df !important;
    color: white;
}

.subject-box tbody tr:hover {
    background: #e8edff !important;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4><b>Admit Card List</b></h4>
            <a href="{{ route('generate_admitcard') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                + Add New Admit Card
            </a>
        </div>

        @if(session('success'))
        <div class="alert-custom alert-success-custom" id="successMsg">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error-custom" id="errorMsg">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
        @endif


        <div class="card table-modern">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Course</th>
                        <th>Exam</th>
                        <th>Session Start</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>


                    @if($admitcards->count() == 0)
                    <tr>
                        <td colspan="7">
                            <div class="no-record-box" id="noRecordMsg">
                                <i class="fas fa-folder-open"></i>
                                <h5>No Admit Card Records Found</h5>
                                <p>Please add a new admit card to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endif

                    {{-- Your foreach loop --}}
                    @foreach($admitcards as $key => $ac)
                    <tr class="text-center parent-row">
                        <td>{{ $key + 1 }}</td>
                        <td><b>{{ $ac->course_name }}</b></td>
                        <td>{{ $ac->exam_name }}</td>
                        <td>{{ $ac->session_start }}</td>

                        <td>
                            @if($ac->status == 'Active')
                            <span class="badge bg-success px-3 py-2">Active</span>
                            @else
                            <span class="badge bg-secondary px-3 py-2">Inactive</span>
                            @endif
                        </td>

                        <td>{{ date('d M Y', strtotime($ac->created_at)) }}</td>

                        <td class="text-center">
                            <!-- View Subjects Button -->
                            <button type="button" class="btn btn-sm btn-gradient-primary me-2"
                                onclick="toggleSubjects({{ $ac->id }})" style="transition: transform 0.2s;">
                                <i class="fas fa-book-open me-1"></i> View Subjects
                            </button>

                            <!-- Delete Button -->
                            <a href="{{ url('admin/delete-admitcard/'.$ac->id) }}"
                                class="btn btn-sm btn-gradient-danger me-2"
                                onclick="return confirm('Are you sure you want to delete this admit card?');"
                                style="transition: transform 0.2s;">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </a>

                            <!-- View Admit Card Button -->
                            <a href="{{ route('viewadmitcard_studentwise') }}" target="_blank"
                                class="btn btn-sm btn-gradient-success" style="transition: transform 0.2s;">
                                <i class="fas fa-id-card me-1"></i> View AdmitCard
                            </a>


                        </td>

                        <!-- Custom Styles -->
                        <style>
                        .btn-gradient-primary {
                            background: linear-gradient(45deg, #4e73df, #224abe);
                            color: #fff;
                            border: none;
                        }

                        .btn-gradient-primary:hover {
                            transform: scale(1.05);
                            background: linear-gradient(45deg, #224abe, #4e73df);
                            color: #fff;
                        }

                        .btn-gradient-danger {
                            background: linear-gradient(45deg, #e74a3b, #c82333);
                            color: #fff;
                            border: none;
                        }

                        .btn-gradient-danger:hover {
                            transform: scale(1.05);
                            background: linear-gradient(45deg, #c82333, #e74a3b);
                            color: #fff;
                        }

                        .btn-gradient-success {
                            background: linear-gradient(45deg, #1cc88a, #17a673);
                            color: #fff;
                            border: none;
                        }

                        .btn-gradient-success:hover {
                            transform: scale(1.05);
                            background: linear-gradient(45deg, #17a673, #1cc88a);
                            color: #fff;
                        }
                        </style>

                    </tr>

                    <tr id="subjects_row_{{ $ac->id }}" class="subject-row" style="display:none;">
                        <td colspan="7" id="subjects_box_{{ $ac->id }}">
                            <p class="text-center py-3">Loading...</p>
                        </td>
                    </tr>

                    @endforeach

                </tbody>


            </table>
        </div>

    </div>
</div>


<script>
function toggleSubjects(id) {

    let row = $("#subjects_row_" + id);
    let box = $("#subjects_box_" + id);

    if (row.is(":visible")) {
        row.hide();
        return;
    }

    $("tr[id^='subjects_row_']").hide();

    row.show();
    box.html("<p class='text-center py-3 fw-bold text-primary'>Loading...</p>");

    $.ajax({
        url: "{{ url('admin/get-admitcard-subjects') }}/" + id,
        type: "GET",
        success: function(data) {

            if (data.length === 0) {
                box.html(`
                    <div class="text-center text-danger fw-bold py-3">
                        No subjects found for this Admit Card.
                    </div>
                `);
                return;
            }

            let html = `
                <div class="subject-box">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Subject</th>
                            <th>Exam Date</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            $.each(data, function(index, row) {
                html += `
                    <tr class="text-center">
                        <td>${row.subject_name}</td>
                        <td>${row.exam_date}</td>
                    </tr>
                `;
            });

            html += `</tbody></table></div>`;

            box.html(html);
        }
    });
}
</script>




<script>
setTimeout(() => {
    let successMsg = document.getElementById('successMsg');
    let errorMsg = document.getElementById('errorMsg');

    if (successMsg) {
        successMsg.style.transition = "0.6s";
        successMsg.style.opacity = "0";
        setTimeout(() => successMsg.remove(), 600);
    }

    if (errorMsg) {
        errorMsg.style.transition = "0.6s";
        errorMsg.style.opacity = "0";
        setTimeout(() => errorMsg.remove(), 600);
    }
}, 5000);
</script>


@endsection