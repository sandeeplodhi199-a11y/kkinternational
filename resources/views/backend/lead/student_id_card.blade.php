<!DOCTYPE html>
<html>
<head>
    <title>ID Card</title>

    <style>
        /* PAGE SIZE SMALLER NOW */
        @page { size: 360px 520px; margin: 0; }

        html, body {
            margin: 0;
            padding: 0;
            width: 360px;
            height: 520px;  /* 600 → 520 */
            font-family: Arial, Helvetica, sans-serif;
        }

        .id-card {
            position: relative;
            width: 360px;
            height: 520px; /* 600 → 520 */
        }

        .id-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Validity Left Top */
        .valid-top {
            position: absolute;
            top: 60px;  /* adjusted for new height */
            left: 20px;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            z-index: 99;
            background: rgba(255,255,255,0.85);
            padding: 6px 10px;
            border-radius: 6px;
        }

        /* QR Top Right */
        .qr-top {
            position: absolute;
            top: 60px;
            right: 20px;
            z-index: 99;
        }

        .qr-top img {
            width: 70px;
            height: 70px;
        }

        /* CONTENT AREA SHIFTED UP A BIT */
        .content {
            position: absolute;
            inset: 0;
            padding: 145px 22px 20px; /* 180 → 145 for compact design */
            text-align: center;
        }

        .img-box {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #1A237E;
            margin: 0 auto 12px;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .details {
            background: rgba(255,255,255,0.92);
            border-radius: 12px;
            padding: 10px 12px;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        td {
            padding: 5px;
            width: 50%;
            vertical-align: top;
        }

        .label {
            font-size: 11px;
            font-weight: 600;
            color: #1A237E;
        }

        .value {
            font-size: 13px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="id-card">

    <img src="{{ public_path('uploads/'.$id_card) }}" class="id-bg">
    

    <!-- Validity -->
    <div class="valid-top">
        Valid Till : {{ now()->addYear()->format('d-M-Y') }}
    </div>

    <!-- QR Code -->
    <div class="qr-top">
        <img src="{{ $qrCode }}">
    </div>

    @php
        $courseName = DB::table('tbl_course')->where('id', $student->course_id)->value('name');
        $branchName = DB::table('tbl_branch')->where('id', $student->branch_id)->value('name');
    @endphp

    <div class="content">

        <div class="img-box">
            <img src="{{ public_path('uploads/'.$student->photo) }}">
        </div>

        <div class="student-name">{{ strtoupper($student->name) }}</div>

        <div class="details">
            <table>
                <tr>
                    <td>
                        <div class="label">Enrollment</div>
                        <div class="value">{{ $student->enrollment_no }}</div>
                    </td>
                    <td>
                        <div class="label">Phone</div>
                        <div class="value">{{ $student->phone ?? 'N/A' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Course</div>
                        <div class="value">{{ $courseName ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="label">Branch</div>
                        <div class="value">{{ $branchName ?? 'N/A' }}</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</div>

</body>
</html>
