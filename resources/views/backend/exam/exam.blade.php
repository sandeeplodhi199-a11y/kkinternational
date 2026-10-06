@extends('backend.layouts.app')
@section('content')

<style>
.content-wrapper { background: #f0f4ff; padding: 20px 0 35px; }

/* ── Toolbar ── */
.top-toolbar {
    background: #fff;
    border-radius: 16px;
    padding: 16px 22px;
    box-shadow: 0 4px 20px rgba(37,99,235,.08);
    margin-bottom: 20px;
}
.search-box {
    height: 44px;
    border-radius: 11px;
    border: 2px solid #e2e8f0;
    font-size: 14px;
    padding: 0 14px;
    transition: border-color .2s;
}
.search-box:focus { border-color: #2563eb; outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.filter-btn {
    height: 44px;
    padding: 0 22px;
    border-radius: 11px;
    font-weight: 600;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    border: none;
    color: #fff;
    font-size: 14px;
}
.add-exam-btn {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    padding: 11px 22px;
    border-radius: 11px;
    font-weight: 700;
    font-size: 14px;
    color: #fff;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(22,163,74,.25);
    transition: all .2s;
}
.add-exam-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(22,163,74,.35); color: #fff; }

/* ── Main card ── */
.main-card { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,.07); }
.card-header-bar {
    background: linear-gradient(135deg, #1e3a8a, #2563eb, #4f46e5);
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card-header-bar h4 { margin: 0; color: #fff; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
.header-badge { background: rgba(255,255,255,.18); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }

/* ── Table ── */
.exam-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.exam-table thead th {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #e2e8f0;
    padding: 13px 14px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    white-space: nowrap;
    border-bottom: 3px solid #2563eb;
}
.exam-table tbody tr { transition: background .15s; border-bottom: 1px solid #f1f5f9; }
.exam-table tbody tr:hover { background: #f8faff; }
.exam-table td { padding: 13px 14px; font-size: 13px; vertical-align: top; color: #334155; }

/* ── Exam name ── */
.exam-name-pill { font-weight: 700; font-size: 14px; color: #1e293b; }

/* ── Grade tags ── */
.grade-list { display: flex; flex-wrap: wrap; gap: 5px; max-width: 160px; }
.grade-tag {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #fff;
    white-space: nowrap;
}

/* ── Subject Mapping Box — KEY FIX ── */
.mapping-box {
    max-height: 220px;
    overflow-y: auto;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #fafbff;
    padding: 0;
    width: 100%;
    min-width: 320px;
}
.mapping-box::-webkit-scrollbar { width: 5px; }
.mapping-box::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
.mapping-box::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
.mapping-box::-webkit-scrollbar-thumb:hover { background: #2563eb; }

/* Grade accordion header inside mapping box */
.grade-accordion-btn {
    width: 100%;
    text-align: left;
    padding: 8px 12px;
    background: linear-gradient(135deg, #eff6ff, #e0e7ff);
    border: none;
    border-bottom: 1px solid #e2e8f0;
    cursor: pointer;
    font-size: 12px;
    font-weight: 700;
    color: #1e40af;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background .2s;
}
.grade-accordion-btn:hover { background: linear-gradient(135deg, #dbeafe, #c7d2fe); }
.grade-accordion-btn .arrow { font-size: 10px; transition: transform .2s; }
.grade-accordion-btn.open .arrow { transform: rotate(90deg); }

.grade-accordion-body {
    padding: 8px 12px 10px;
    border-bottom: 1px solid #f1f5f9;
    display: none;
}
.grade-accordion-body.open { display: block; }

/* subject count badge on header */
.grade-subject-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    font-weight: 600;
}
.cnt-inc { color: #166534; background: #dcfce7; padding: 1px 7px; border-radius: 20px; }
.cnt-exc { color: #991b1b; background: #fee2e2; padding: 1px 7px; border-radius: 20px; }

.subject-row { display: flex; flex-wrap: wrap; gap: 4px; }
.subject-chip {
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e40af;
    font-weight: 500;
}
.chip-excluded {
    background: #fff1f2;
    border-color: #fecdd3;
    color: #be123c;
    text-decoration: line-through;
    opacity: .8;
}

/* mapping expand/collapse toggle */
.mapping-toggle {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #2563eb;
    cursor: pointer;
    margin-top: 6px;
    background: none;
    border: none;
    padding: 0;
}
.mapping-toggle:hover { color: #1d4ed8; }
.mapping-count-chips { display: flex; gap: 5px; margin-top: 4px; flex-wrap: wrap; }
.map-summary-chip {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}
.map-sum-grade { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.map-sum-inc   { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.map-sum-exc   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ── Date pills ── */
.date-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}
.date-start  { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.date-end    { background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa; }
.date-pub    { background: #f5f3ff; color: #4c1d95; border: 1px solid #ddd6fe; }
.date-none   { color: #94a3b8; font-size: 12px; }

/* ── Order ── */
.order-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px; height: 34px;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 800;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #3730a3;
    box-shadow: 0 2px 6px rgba(79,70,229,.2);
}

/* ── Status ── */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}
.status-active   { background: #dcfce7; color: #166534; }
.status-inactive { background: #fee2e2; color: #991b1b; }
.status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
.status-active .status-dot   { background: #16a34a; }
.status-inactive .status-dot { background: #dc2626; }

/* ── Action buttons ── */
.action-wrap { display: flex; flex-direction: column; gap: 6px; }
.btn-edit {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #fff; border: none; text-decoration: none; transition: all .2s;
}
.btn-edit:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37,99,235,.3); color: #fff; }
.btn-del {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff; border: none; text-decoration: none; transition: all .2s;
}
.btn-del:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(220,38,38,.3); color: #fff; }

/* ── Row number ── */
.row-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 8px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    font-size: 12px; font-weight: 700; color: #475569;
}

/* ── Empty state ── */
.empty-state { padding: 60px 20px; text-align: center; color: #94a3b8; }
.empty-state i { font-size: 48px; margin-bottom: 14px; color: #cbd5e1; }
</style>

<div class="content-wrapper">
<div class="container-fluid">

{{-- Toolbar --}}
<div class="top-toolbar">
    <div class="row align-items-center">
        <div class="col-md-8">
            <form class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="keyword"
                        value="{{ $data['keyword'] }}"
                        class="form-control search-box"
                        placeholder="🔍  Search Exam...">
                </div>
                <div class="col-md-3">
                    <button class="btn filter-btn w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ url('admin/add-exam') }}" class="add-exam-btn">
                <i class="fas fa-plus-circle"></i> Add New Exam
            </a>
        </div>
    </div>
</div>

{{-- Main card --}}
<div class="main-card">

    <div class="card-header-bar">
        <h4><i class="fas fa-graduation-cap"></i> Manage Exams</h4>
        @if($categories->count())
            <span class="header-badge">{{ $categories->total() }} Total</span>
        @endif
    </div>

    <div class="card-body p-0">

        @if($categories->count())
        <div class="table-responsive">
        <table class="exam-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:150px;"><i class="fas fa-file-alt me-1"></i> Exam Name</th>
                    <th style="width:170px;"><i class="fas fa-layer-group me-1"></i> Grades</th>
                    <th><i class="fas fa-book me-1"></i> Subject Mapping</th>
                    <th style="width:115px;"><i class="fas fa-calendar-plus me-1"></i> Start</th>
                    <th style="width:115px;"><i class="fas fa-calendar-minus me-1"></i> End</th>
                    <th style="width:115px;"><i class="fas fa-calendar-check me-1"></i> Publish</th>
                    <th style="width:60px; text-align:center;"><i class="fas fa-sort-numeric-up me-1"></i></th>
                    <th style="width:90px;"><i class="fas fa-toggle-on me-1"></i> Status</th>
                    @if(in_array('2_23', $permExplodesub) || in_array('2_24', $permExplodesub))
                    <th style="width:90px;"><i class="fas fa-cogs me-1"></i></th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $cat)

                @php
                    $grades = isset($examMappings[$cat->id])
                        ? $examMappings[$cat->id]->groupBy('grade_id')
                        : collect();

                    // summary counts
                    $totalGrades = $grades->count();
                    $totalInc = 0; $totalExc = 0;
                    foreach($grades as $rows){
                        foreach($rows as $r){
                            if($r->is_included) $totalInc++; else $totalExc++;
                        }
                    }
                    $uid = 'map_'.$cat->id;
                @endphp

                <tr>
                    <td><span class="row-num">{{ ++$i }}</span></td>

                    {{-- Exam Name --}}
                    <td>
                        <div class="exam-name-pill">
                            <i class="fas fa-clipboard-list me-1" style="color:#2563eb;font-size:11px;"></i>
                            {{ $cat->exam_name }}
                        </div>
                    </td>

                    {{-- Grades --}}
                    <td>
                        @if($grades->count())
                        <div class="grade-list">
                            @foreach($grades as $gid => $rows)
                                <span class="grade-tag">{{ $rows->first()->grade_name }}</span>
                            @endforeach
                        </div>
                        @else
                            <span class="date-none">—</span>
                        @endif
                    </td>

                    {{-- Subject Mapping — scrollable box + accordion --}}
                    <td>
                        @if($grades->count())

                        {{-- Summary chips shown always --}}
                        <div class="mapping-count-chips">
                            <span class="map-summary-chip map-sum-grade">
                                <i class="fas fa-layer-group" style="font-size:9px;"></i> {{ $totalGrades }} Grades
                            </span>
                            <span class="map-summary-chip map-sum-inc">
                                ✓ {{ $totalInc }} Included
                            </span>
                            @if($totalExc > 0)
                            <span class="map-summary-chip map-sum-exc">
                                ✗ {{ $totalExc }} Excluded
                            </span>
                            @endif
                        </div>

                        {{-- Toggle button --}}
                        <button class="mapping-toggle" onclick="toggleMapping('{{ $uid }}', this)">
                            <i class="fas fa-chevron-down" id="icon_{{ $uid }}" style="font-size:10px;"></i>
                            Show Details
                        </button>

                        {{-- Scrollable mapping box — hidden by default --}}
                        <div class="mapping-box mt-2" id="{{ $uid }}" style="display:none;">
                            @foreach($grades as $gid => $rows)
                                @php
                                    $gInc = $rows->where('is_included',1)->count();
                                    $gExc = $rows->where('is_included',0)->count();
                                    $gUid = $uid.'_g'.$gid;
                                @endphp
                                <button class="grade-accordion-btn open" onclick="toggleGrade('{{ $gUid }}', this)">
                                    <span>
                                        <i class="fas fa-angle-right me-1"></i>
                                        {{ $rows->first()->grade_name }}
                                    </span>
                                    <span class="grade-subject-count">
                                        <span class="cnt-inc">✓ {{ $gInc }}</span>
                                        @if($gExc > 0)
                                        <span class="cnt-exc">✗ {{ $gExc }}</span>
                                        @endif
                                        <span class="arrow">❯</span>
                                    </span>
                                </button>
                                <div class="grade-accordion-body open" id="{{ $gUid }}">
                                    <div class="subject-row">
                                        @foreach($rows as $row)
                                            @if($row->is_included)
                                                <span class="subject-chip" title="T:{{ $row->marks }} / P:{{ $row->practical_marks }}">
                                                    {{ $row->subject_name }}
                                                    <span style="color:#93c5fd;font-size:9px;">({{ $row->marks }}/{{ $row->practical_marks }})</span>
                                                </span>
                                            @else
                                                <span class="subject-chip chip-excluded" title="Excluded">
                                                    {{ $row->subject_name }} ✗
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @else
                            <span class="date-none">No subjects mapped</span>
                        @endif
                    </td>

                    {{-- Start Date --}}
                    <td>
                        @if($cat->start_date)
                            <span class="date-pill date-start">
                                <i class="fas fa-play-circle" style="font-size:9px;"></i>
                                {{ date('d M Y', strtotime($cat->start_date)) }}
                            </span>
                        @else <span class="date-none">—</span> @endif
                    </td>

                    {{-- End Date --}}
                    <td>
                        @if($cat->end_date)
                            <span class="date-pill date-end">
                                <i class="fas fa-stop-circle" style="font-size:9px;"></i>
                                {{ date('d M Y', strtotime($cat->end_date)) }}
                            </span>
                        @else <span class="date-none">—</span> @endif
                    </td>

                    {{-- Publish Date --}}
                    <td>
                        @if(isset($cat->marksheet_publish_date) && $cat->marksheet_publish_date)
                            <span class="date-pill date-pub">
                                <i class="fas fa-calendar-check" style="font-size:9px;"></i>
                                {{ date('d M Y', strtotime($cat->marksheet_publish_date)) }}
                            </span>
                        @else <span class="date-none">—</span> @endif
                    </td>

                    {{-- Order --}}
                    <td style="text-align:center;">
                        <span class="order-pill">{{ $cat->orders_by }}</span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($cat->status == 'Active')
                            <span class="status-pill status-active">
                                <span class="status-dot"></span> Active
                            </span>
                        @else
                            <span class="status-pill status-inactive">
                                <span class="status-dot"></span> Inactive
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    @if(in_array('8_3', $permExplodesub) || in_array('8_4', $permExplodesub))
                    <td>
                        <div class="action-wrap">
                            @if(in_array('8_3', $permExplodesub))
                            <a href="{{ url('admin/edit-exam/'.$cat->id_hash) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @endif
                            @if(in_array('8_4', $permExplodesub))
                            <a href="{{ url('admin/delete-exam/'.$cat->id) }}"
                               onclick="return confirm('Delete this exam?')"
                               class="btn-del">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                            @endif
                        </div>
                    </td>
                    @endif

                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        <div class="px-4 py-3">
            {{ $categories->links('pagination::simple-default') }}
        </div>

        @else
        <div class="empty-state">
            <i class="fas fa-inbox d-block"></i>
            <p style="font-size:16px;font-weight:600;margin:0;">No exams found</p>
            <small style="color:#cbd5e1;">Try adjusting your search or add a new exam</small>
        </div>
        @endif

    </div>
</div>

</div>
</div>

<script>
/* Toggle the whole mapping box */
function toggleMapping(uid, btn) {
    var box  = document.getElementById(uid);
    var icon = document.getElementById('icon_' + uid);
    var isHidden = box.style.display === 'none';

    box.style.display  = isHidden ? 'block'       : 'none';
    icon.className     = isHidden ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
    btn.innerHTML      = (isHidden ? '<i class="fas fa-chevron-up" id="icon_' + uid + '" style="font-size:10px;"></i> Hide Details'
                                   : '<i class="fas fa-chevron-down" id="icon_' + uid + '" style="font-size:10px;"></i> Show Details');
}

/* Toggle individual grade inside box */
function toggleGrade(uid, btn) {
    var body = document.getElementById(uid);
    var isOpen = body.classList.contains('open');
    if (isOpen) {
        body.classList.remove('open');
        btn.classList.remove('open');
    } else {
        body.classList.add('open');
        btn.classList.add('open');
    }
}
</script>

@endsection