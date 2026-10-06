<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admit Card PDF</title>

    <style>
    @page {
        margin: 0;
        size: A5 portrait;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        font-family: Arial, sans-serif;
        -webkit-print-color-adjust: exact;
    }

    .bg-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .bg-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .content-box {
        position: absolute;
        z-index: 5;
        width: 100%;
        height: 100%;
        padding: 205px 20px 30px 20px;
        box-sizing: border-box;
    }



    /* TABLE STYLE (LEFT SHIFT APPLIED) */
    table {
        width: 90%;
        margin: 0 5% 15px 1%;

        border-collapse: collapse;
        font-size: 12px;
        background: transparent;
        border: 1px solid rgba(0, 0, 0, 0.4);
    }

    table th,
    table td {
        padding: 10px 8px;
        color: #111;
        border: 1px solid rgba(0, 0, 0, 0.4);
    }

    .subject-table th {
        font-weight: 700;
        text-align: center;
    }

    /* 2-Column Info Table */
    .info-table td.label {
        font-weight: 700;
        width: 25%;
    }

    .info-table td.value {
        width: 25%;
        font-weight: 500;
    }
    </style>

</head>

<body>


    <div class="bg-wrapper">
        <img src="{{ public_path('uploads/'.$admitcard) }}" alt="Admitcard Background">
    </div>

    <div class="content-box">

        <!-- STUDENT INFORMATION 2-COLUMN TABLE -->
        <table class="info-table">
            <tr>
                <td class="label">Name</td>
                <td class="value">{{ $student->name }}</td>

                <td class="label">Phone</td>
                <td class="value">{{ $student->phone }}</td>
            </tr>

            <tr>
                <td class="label">Course Name</td>
                <td class="value">{{ $courseName }}</td>

                <td class="label">Enrollment No</td>
                <td class="value">{{ $student->enrollment_no }}</td>
            </tr>

            <tr>
                <td class="label">Session</td>
                <td class="value">{{ $admit->session_start }}</td>

                <td class="label">Exam Name</td>
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
                <td>{{ $sub->name }}</td>
                <td>{{ date('d-m-Y', strtotime($sub->exam_date)) }}</td>
            </tr>
            @endforeach
        </table>

    </div>

</body>

</html>