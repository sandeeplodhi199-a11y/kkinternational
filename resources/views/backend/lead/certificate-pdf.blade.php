<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student Certificate</title>

<style>
@page { size: A4 portrait; margin: 0; }

body{
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    margin: 0;
    line-height: 1.6;
}

/* Background */
.bg-wrapper{
    position: fixed;
    inset: 0;
    z-index: -1;
}
.bg-wrapper img{
    width: 100%;
    height: 100%;
}

/* Content */
.content{
    padding: 55mm 25mm 25mm 25mm;
    text-align: center;
}

/* Header */
.header{
    margin-bottom: 35px;
}
.header .sr{
    text-align: left;
    font-weight: bold;
    font-size: 11px;
}

/* Main text */
h2{
    margin: 18px 0 14px;
    font-size: 22px;
    letter-spacing: 1px;
}

.course{
    font-size: 20px;
    font-weight: bold;
    margin: 16px 0;
}

p{
    margin: 10px 0;
    font-size: 14px;
}

/* RESULT BOX */
.result-box{
    margin: 40px auto 0;
    width: 65%;
    border: 2px solid #000;
    padding: 16px 22px;
    text-align: left;
}

.result-row{
    display: table;
    width: 100%;
    font-size: 14px;
    margin: 8px 0;
}

.result-row span{
    display: table-cell;
}

.result-row .label{
    width: 60%;
    font-weight: bold;
}

.result-row .value{
    width: 40%;
    text-align: right;
}
</style>
</head>

<body>

<div class="bg-wrapper">
    <img src="{{ public_path('uploads/'.$certificate) }}" alt="Certificate Background">
</div>

<div class="content">

    <!-- HEADER -->
    <div class="header">
        <div class="sr">SR No: {{ $certificate_no }}</div>
    </div>

    <p>
        This is to certify that
    </p>

    <h2>{{ strtoupper($student->name) }}</h2>

    <p>
        bearing Enrollment Number
        <strong>{{ $student->enrollment_no }}</strong>,
        has successfully completed and fulfilled all the academic requirements
        prescribed for the course mentioned below.
    </p>

    <p>
        The candidate has completed the course of
    </p>

    <div class="course">{{ $course->name }}</div>

    <p>
        during the academic session
        <strong>{{ $final->session_start }}</strong>.
    </p>

    <p>
        The overall academic performance of the candidate has been evaluated
        in accordance with the examination rules and regulations of the institution,
        and the result is declared as follows:
    </p>

    <!-- RESULT DETAILS -->
    <div class="result-box">

        <div class="result-row">
            <span class="label">Total Percentage Obtained</span>
            <span class="value">{{ $percentage }} %</span>
        </div>

        <div class="result-row">
            <span class="label">Grade Awarded</span>
            <span class="value">
                {{ $grade->grade_name ?? $grade->grade ?? 'N/A' }}
            </span>
        </div>

        <div class="result-row">
            <span class="label">Remarks</span>
            <span class="value">
                {{ $grade->remark ?? 'N/A' }}
            </span>
        </div>

    </div>

</div>

</body>
</html>
