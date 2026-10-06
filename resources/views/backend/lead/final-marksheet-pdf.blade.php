<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Final Marksheet</title>

<style>
@page { size: A4 portrait; margin: 0; }

body{
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    margin: 0;
}

.bg-wrapper{
    position: fixed;
    inset: 0;
    z-index: -1;
}
.bg-wrapper img{
    width: 100%;
    height: 100%;
}

.content{
    padding: 18mm 18mm 15mm;
}

/* HEADER */
.header{
    display: table;
    width: 100%;
    margin-top: 125px;
}
.header div{
    display: table-cell;
    vertical-align: middle;
}
.header-left{
    width: 30%;
    font-weight: bold;
}
.header-center{
    width: 40%;
    text-align: center;
    font-size: 14px;
    font-weight: bold;
}
.header-right{
    width: 30%;
}

/* INFO */
.info-table{
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}
.info-table td{
    padding: 3px 2px;
}
.info-label{
    width: 20%;
    font-weight: bold;
}
.info-value{
    width: 30%;
}

/* MARKS TABLE */
.marks-table{
    width: 100%;
    border-collapse: collapse;
    margin-top: 6px;
}
.marks-table th,
.marks-table td{
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
    font-size: 9.5px;
}
/* .marks-table th{
    background: #f1f1f1;
} */

.sem-title{
    font-weight: bold;
    font-size: 11px;
    margin-bottom: 4px;
    text-align: center;
}
</style>
</head>

<body>

<div class="bg-wrapper">
    <img src="{{ public_path('uploads/'.$marksheet) }}" alt="Marksheet Background">
</div>

<div class="content">

{{-- ===== HEADER ===== --}}
<div class="header">
    <div class="header-left">
        SR No: {{ $final->final_marksheet_no }} 
        
    </div>

    <div class="header-center">
        {{ $course->course_name ?? '' }}
    </div>

    <div class="header-right"></div>
</div>

{{-- ===== STUDENT INFO ===== --}}
<table class="info-table">
<tr>
    <td class="info-label">Roll No.</td>
    <td class="info-value">{{ $student->roll_number }}</td>
    <td class="info-label">Enrollment No.</td>
    <td class="info-value">{{ $student->enrollment_no }}</td>
</tr>
<tr>
    <td class="info-label">Student Name</td>
    <td class="info-value">{{ $student->name }}</td>
    <td class="info-label">Father Name</td>
    <td class="info-value">{{ $student->fathername }}</td>
</tr>
<tr>
    <td class="info-label">Session</td>
    <td class="info-value">{{ $final->session_start }}</td>
    <td class="info-label">Certificate No:</td>
    <td class="info-value"> {{ $final->final_certificate_no }}</td>
</tr>
</table>

{{-- ===== SEMESTER 2×2 GRID ===== --}}


<table width="100%" cellpadding="4" cellspacing="0" style="margin-top:15px;">
@foreach($results->chunk(2) as $rowSemesters)
<tr>

@foreach($rowSemesters as $examId => $subjects)
<td width="50%" valign="top">

    <div class="sem-title">
        {{ $subjects->first()->exam_name }}
    </div>

    <table class="marks-table">
        <thead>
        <tr>
            <th>SUBJECT</th>
            <th>MAX</th>
            <th>PASS</th>
            <th>OBT</th>
        </tr>
        </thead>
        <tbody>
        @php $semMax = 0; $semObt = 0; @endphp
        @foreach($subjects as $row)
        <tr>
            <td style="text-align:left">{{ $row->subject_name }}</td>
            <td>{{ $row->max_mark }}</td>
            <td>{{ $row->passing_mark }}</td>
            <td>{{ $row->obtained_mark }}</td>
        </tr>
        @php
            $semMax += $row->max_mark;
            $semObt += $row->obtained_mark;
        @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Total</th>
            <th>{{ $semMax }}</th>
            <th>-</th>
            <th>{{ $semObt }}</th>
        </tr>
        </tfoot>
    </table>

   

</td>
@endforeach

@if(count($rowSemesters) < 2)
<td width="50%"></td>
@endif

</tr>
@endforeach
</table>

{{-- ===== FINAL SUMMARY ===== --}}
<h4 style="margin-top:12px;">FINAL RESULT SUMMARY</h4>

<table class="marks-table">
<tr>
    <th>GRAND TOTAL</th>
    <th>OBTAINED</th>
    <th>PERCENTAGE</th>
    <th>GRADE</th>
    <th>REMARK</th>
</tr>
<tr>
    <td>{{ $grandMax }}</td>
    <td>{{ $grandObt }}</td>
    <td>{{ number_format($percentage,2) }}%</td>
    <td>{{ $grade->grade_name ?? 'N/A' }}</td>
    <td>{{ $grade->remark ?? '-' }}</td>
</tr>
</table>

{{-- ===== NOTES ===== --}}
<div style="margin-top:6px;font-size:9px;">
    <p>A.B : Absent in the subject.</p>
    <p>Line below marks indicates failure.</p>
    <p>Minimum passing marks is 70%.</p>
</div>

</div>
</body>
</html>
