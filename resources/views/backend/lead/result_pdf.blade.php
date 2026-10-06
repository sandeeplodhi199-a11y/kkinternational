<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student Result</title>

<style>
/* ===== PAGE SIZE CHANGE ONLY ===== */
@page { size: A4 portrait; margin: 0; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    margin: 0;
}

.bg-wrapper {
    position: fixed;
    inset: 0;
    z-index: -1;
}
.bg-wrapper img {
    width: 100%;
    height: 100%;
}

.content {
    padding: 18mm 20mm 15mm;
}

/* ===== HEADER ===== */
.header {
    display: table;
    width: 100%;
    margin-top: 100px;
}

.header-left,
.header-center,
.header-right {
    display: table-cell;
    vertical-align: middle;
}

.header-left {
    width: 25%;
    font-weight: bold;
}

.header-center {
    width: 50%;
    text-align: center;
}

.header-center .title {
    color: red;
    font-weight: bold;
    font-size: 15px;
}

.header-center .course {
    font-size: 15px;
    font-weight: bold;
    margin-top: 60px;
    margin-right: 110px;
    white-space: nowrap;
}

.header-right {
    width: 25%;
    text-align: right;
}

/* ===== STUDENT INFO ===== */
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 50px;
}
.info-table td {
    padding: 4px 2px;
    vertical-align: top;
}
.info-label {
    width: 22%;
    font-weight: bold;
}
.info-value {
    width: 28%;
}

/* ===== MARKS TABLE ===== */
.marks-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 50px;
}
.marks-table th,
.marks-table td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
}

.pass { font-weight: bold; }
.fail { font-weight: bold; }
</style>

</head>

<body>


<div class="bg-wrapper">
    <img src="{{ public_path('uploads/'.$marksheet) }}" alt="Marksheet Background">
</div>

<div class="content">

<!-- ===== HEADER ===== -->
<div class="header">
   <div class="header-left">
    SR No. {{ $results->first()->marksheet_no }}
</div>



    <div class="header-center">
        <div class="course">{{ strtoupper($student->course_name) }}</div>
      

    </div>
    
    
</div>

 <h2 style="text-align:center;">
    {{ $results->first()->exam_name }} 
</h2>


<!-- ===== STUDENT INFO ===== -->
<table class="info-table">
<tr>
    <td class="info-label">Roll No.</td>
    <td class="info-value">{{ $student->roll_number }}</td>

    <td class="info-label">Enrollment No.</td>
    <td class="info-value">{{ $student->enrollment_no }}</td>
</tr>

<tr>
    <td class="info-label">Student Name.</td>
    <td class="info-value">{{ $student->name }}</td>

    <td class="info-label">Father Name.</td>
    <td class="info-value">{{ $student->fathername }}</td>
</tr>

<tr>
    <td class="info-label">Session.</td>
    <td class="info-value">{{ $results->first()->session_start }}</td>

    <td class="info-label">Branch Address.</td>
    @php 
    $branchName = DB::table('tbl_branch')->where('id',$student->branch_id)->pluck('name')->first();
    @endphp
    <td class="info-value">{{ $branchName }}</td>
</tr>
</table>

<!-- ===== MARKS TABLE ===== -->
<table class="marks-table">
<thead>
<tr>
    <th>SUBJECT DETAIL</th>
    <th>MAX. MARKS</th>
    <th>PASS MARKS</th>
    <th>OBT. MARKS</th>
    <th>TOTAL MARKS</th>
</tr>
</thead>

<tbody>
@foreach($results as $row)
<tr>
    <td>{{ strtoupper($row->subject_name) }}</td>
    <td>{{ $row->max_mark }}</td>
    <td>{{ $row->passing_mark }}</td>
    <td>{{ $row->obtained_mark }}</td>
    <td>{{ $row->obtained_mark }}</td>
</tr>
@endforeach
</tbody>

<tfoot>
<tr>
    <th>TOTAL MARKS</th>
    <th>{{ $totalMax }}</th>
    <th>{{ $totalPass }}</th>
    <th>{{ $totalObt }}</th>
    <th>{{ $totalObt }}</th>
</tr>
</tfoot>
</table>

<!-- ===== NOTES ===== -->
<div style="margin-top:8px;font-size:10px;">
    <p>A.B: Absent in the subject.</p>
    <p>Line below the marks indicates failure in the paper.</p>
    <p>Minimum Passing Marks is 70% in all subject.</p>
    <p>For more details about the marks sheet over leaf</p>
</div>

</div>

</body>
</html>
