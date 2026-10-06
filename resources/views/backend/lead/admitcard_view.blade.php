<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admit Card</title>

<style>
@page{
    size: A5 portrait;
    margin: 0;
}

html, body{
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: Arial, sans-serif;
    font-size: 12px;
    -webkit-print-color-adjust: exact;
}

/* ===== FULL A5 BACKGROUND ===== */
.bg-wrapper{
    position: fixed;
    inset: 0;
    z-index: -1;
}
.bg-wrapper img{
    width: 100%;
    height: 100%;
    object-fit: contain;   /* FULL IMAGE – NO CUT */
}

/* ===== CONTENT STRICTLY INSIDE A5 WIDTH ===== */
.content-box{
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);

    width: 148mm;          /* 🔥 EXACT A5 WIDTH */
    height: 210mm;         /* 🔥 EXACT A5 HEIGHT */

    z-index: 5;

    /* 🔥 SAFE INNER AREA – ADJUST ONLY THIS */
    padding-top: 72mm;
    padding-left: 16mm;
    padding-right: 16mm;
    padding-bottom: 18mm;

    box-sizing: border-box;
    overflow: hidden;
}

/* ===== TABLES FIX ===== */
table{
    width: 100%;
    max-width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
    table-layout: fixed;
}

table th, table td{
    border: 1px solid #555;
    padding: 6px;
    font-size: 12px;
    word-wrap: break-word;
}

/* Student Info */
.info-table td.label{
    font-weight: bold;
    width: 25%;
}
.info-table td.value{
    width: 25%;
}

/* Subject Table */
.subject-table th,
.subject-table td{
    text-align: center;
}
</style>
</head>

<body>

<!-- BACKGROUND -->
 <div class="bg-wrapper">
        <img src="{{ asset('public/uploads/'.$admitcard) }}" alt="Admitcard Background">
    </div>
    
<!-- CONTENT -->
<div class="content-box">

    <!-- STUDENT INFO -->
    <table class="info-table">
        <tr>
            <td class="label">Name</td>
            <td class="value">{{ $student->name }}</td>
            <td class="label">Phone</td>
            <td class="value">{{ $student->phone }}</td>
        </tr>
        <tr>
            <td class="label">Course</td>
            <td class="value">{{ $courseName }}</td>
            <td class="label">Enrollment No</td>
            <td class="value">{{ $student->enrollment_no }}</td>
        </tr>
        <tr>
            <td class="label">Session</td>
            <td class="value">{{ $admit->session_start }}</td>
            <td class="label">Exam</td>
            <td class="value">{{ $examName }}</td>
        </tr>
    </table>

    <!-- SUBJECT TABLE -->
    <table class="subject-table">
        <tr>
            <th>#</th>
            <th>Subject Name</th>
            <th>Exam Date</th>
        </tr>

        @foreach($subjects as $i => $sub)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td style="text-align:left">{{ $sub->name }}</td>
            <td>{{ date('d-m-Y', strtotime($sub->exam_date)) }}</td>
        </tr>
        @endforeach
    </table>

</div>

</body>
</html>
