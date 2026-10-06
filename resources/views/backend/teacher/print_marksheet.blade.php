<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter';
            background: white;
            padding: 10px;
        }

        /* ── Outer wrapper ── */
        .marksheet-wrapper {
            position: relative;
            z-index: 1;
            max-width: 860px;
            margin: 0 auto;
            /*border: 3px solid #cc0000;*/
            padding: 3px;
            background: white;
        }
        .marksheet-inner {
            /*border: 1px solid #cc0000;*/
            padding: 12px 15px;
            margin-top: 100px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            position: relative;
        }
        .header-logo {
            width: 75px;
            height: 75px;
            flex-shrink: 0;
            margin-right: 10px;
        }
        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .header-center {
            flex: 1;
            text-align: center;
        }
        .header-tagline {
            font-size: 10px;
            font-style: italic;
            color: #333;
        }
        .header-school-name {
            font-size: 28px;
            font-weight: bold;
            color: #cc0000;
            font-family: 'Inter';
            letter-spacing: 1px;
            line-height: 1.1;
        }
        .header-school-name .kk {
            font-style: italic;
        }
        .header-address {
            font-size: 10px;
            color: #333;
            margin-top: 2px;
        }
        .header-right {
            position: absolute;
            right: 0;
            top: 0;
            font-size: 10px;
            text-align: right;
        }
        .header-right .phone-icon {
            font-size: 11px;
        }

        
       .exam-title {
            text-align: center;
            font-size: 29px;
            font-weight: bold;
            /* text-decoration: underline; */
            margin-top: -28px;
            margin-bottom: 41px;
            font-family: 'Inter';
        }
       
       .report-title {
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            margin-top: 3px;
            letter-spacing: 2px;
            margin-top: 15px;
            margin-bottom: 27px;
            font-family: 'Inter';
        }

      .student-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #000;
    padding: 5px 8px;
    margin: 10px 0 8px 0;
    font-size: 15px;
    font-weight: 600;
    background: white;
    font-family: 'Inter';
}

        /* ── Marks Table ── */
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            font-family: 'Inter';
        }
       
       .marks-table th, .marks-table td {
            border: 1px solid #000;
            padding: 4px 3px;
            text-align: center;
            vertical-align: middle;
            font-family: 'Inter';
            font-size: 13px;
            font-weight: 600;
        }
       
       .marks-table th {
        font-weight: 600;
        background: white;
        font-size: 9.5px;
        font-family: 'Inter';
        font-size: 13px;
    }
       
        .marks-table .subject-cell {
            text-align: left;
            padding-left: 8px;
            text-align: center;
        }
        .marks-table .th-header {
            border-bottom: 1px solid #000;
        }
        /* sub-header row TH | PR */
       
      .marks-table .sub-header th {
    font-size: 13px;
    padding: 4px;
    font-weight: 600;
}
        /* Failed subject styling */
        .failed-subject {
            background-color: #ffe6e6;
        }
        .fail-text {
            color: #cc0000;
            font-weight: bold;
        }
        .fail-grade {
            color: #cc0000;
            font-weight: bold;
        }

        /* ── Grade summary row (GPA box) ── */
        .grade-summary-section {
            margin-top: 8px;
            font-size: 9.5px;
        }
      
        .gpa-box {
            border: 2px solid #000;
            padding: 4px 10px;
            font-weight: 600 !important;
            font-size: 13px;
            text-align: center;
            white-space: nowrap;
        }
        .absent-expelled-row {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            /*font-style: italic;*/
            margin-top: 4px;
            padding: 0 2px;
        }

        /* ── Grade Description Tables ── */
        .grade-desc-section {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .grade-desc-table {
            flex: 1;
            border-collapse: collapse;
            font-size: 13px;
            font-family: 'Inter';
            font-weight: 600;
        }
        .grade-desc-table th, .grade-desc-table td {
            border: 2px solid #000;
            padding: 3px 8px;
            text-align: left;
            font-weight: 600;
        }
        .grade-desc-table th {
            font-weight: bold;
            background: white;
            text-align: center;
        }
       
        .footer {
            margin-top: 100px;
            /*margin-bottom: 110px;*/
        }
        .footer-signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .sign-block {
            text-align: center;
            font-size: 9px;
            width: 180px;
        }
      
      .sign-block .sign-line {
        border-top: 2px solid #000;
        padding-top: 3px;
        margin-top: 20px;
        line-height: 1.5;
        font-weight: 600;
        font-size: 13px;
        font-family: 'Inter';
        margin-left: -17px;
    }
      
        
        .footer-center {
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Inter';
}
        
       .footer-center .result-date-label {
    border-top: 2px solid #000;
    padding-top: 3px;
    /* margin-top: 18px; */
    font-weight: bold;
    margin-bottom: 22px;
}

        @media print {
            body { padding: 0; margin: 0; }
            .marksheet-wrapper { border-width: 3px; }
        }
    </style>
    
     <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
</head>
<body onload="window.print()">

    <div class="marksheet-wrapper">
        <div class="marksheet-inner">
          
            <div class="exam-title">{{ $exam->exam_name }} </div>
            <div class="report-title">PROGRESS REPORT</div>

            {{-- ── STUDENT INFO ── --}}
            <div class="student-info-row">
                <span>NAME : {{ strtoupper($student->first_name . ' ' . ($student->middle_name ? $student->middle_name . ' ' : '') . $student->last_name) }}</span>
                <span>GRADE : {{ $grade->name ?? '' }}</span>
                <span>SECTION : {{ $section->name ?? '' }}</span>
            </div>

            {{-- ── MARKS TABLE ── --}}
            <table class="marks-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width:30px">S.N.</th>
                        <th rowspan="2" style="width:160px; text-align:center; padding-left:8px;">SUBJECTS</th>
                        <th colspan="2">FULL MARKS</th>
                        <th colspan="2">OBTAINED MARKS</th>
                        <th rowspan="2">TOTAL</th>
                        <th rowspan="2">GRADE POINT<br>(GP)</th>
                        <th rowspan="2">GRADES</th>
                    </tr>
                    <tr class="sub-header">
                        <th>TH</th>
                        <th>PR</th>
                        <th>TH</th>
                        <th>PR</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Flag to track if ANY subject has NG grade (failure)
                        $hasAnyNg = false;
                        $subjectGpTotal = 0;
                        $subjectGpCount = 0;
                        $subjectsData = [];
                    @endphp
                    @foreach($subjects as $index => $subject)
                        @php
                            $thMark    = $subject->obtained_mark ?? 0;
                            $prMark    = $subject->obtained_practical_mark ?? 0;
                            $thMax     = $subject->max_mark ?? 0;
                            $prMax     = $subject->max_practical_mark ?? 0;
                            $isTheoryAbsent = (bool) ($subject->is_absent_theory ?? false);
                            $isPracticalAbsent = $prMax > 0 && (bool) ($subject->is_absent_practical ?? false);
                            $totalObt  = $thMark + $prMark;
                            $totalMax  = $thMax + $prMax;
                            $pct       = $totalMax > 0 ? ($totalObt / $totalMax) * 100 : 0;
                            
                            // Calculate individual percentages
                            $theoryPct = $thMax > 0 ? ($thMark / $thMax) * 100 : 100;
                            $practicalPct = $prMax > 0 ? ($prMark / $prMax) * 100 : 100;
                            
                            // Check failures dynamically from exam settings
                            $theoryPassingPercent = $exam->theory_passing_percent ?? 35;
                            $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
                            
                            $isTheoryFailed = $isTheoryAbsent
                                || ($thMax > 0 && $theoryPct < $theoryPassingPercent);
                            $isPracticalFailed = $isPracticalAbsent
                                || ($prMax > 0 && $practicalPct < $practicalPassingPercent);
                            $isSubjectFailed = $isTheoryFailed || $isPracticalFailed;
                            
                            // Calculate grade - agar fail hai to 'NG' warna normal calculation
                            if ($isSubjectFailed) {
                                $gr = 'NG';
                                $gp = 0;
                                $hasAnyNg = true;   // Set flag if any subject fails
                            } else {
                                if ($pct >= 90)      { $gp = 4.0; $gr = 'A+'; }
                                elseif ($pct >= 80)  { $gp = 3.6; $gr = 'A';  }
                                elseif ($pct >= 70)  { $gp = 3.2; $gr = 'B+'; }
                                elseif ($pct >= 60)  { $gp = 2.8; $gr = 'B';  }
                                elseif ($pct >= 50)  { $gp = 2.4; $gr = 'C+'; }
                                elseif ($pct >= 40)  { $gp = 2.0; $gr = 'C';  }
                                elseif ($pct >= 33)  { $gp = 1.6; $gr = 'D';  }
                                else                 { $gp = 0;   $gr = 'NG'; $hasAnyNg = true; }
                            }

                            if ($totalMax > 0) {
                                $subjectGpTotal += $gp;
                                $subjectGpCount++;
                            }
                            
                            // Store subject data for later use (if needed)
                            $subjectsData[] = [
                                'index' => $index,
                                'thMark' => $thMark,
                                'prMark' => $prMark,
                                'thMax' => $thMax,
                                'prMax' => $prMax,
                                'totalObt' => $totalObt,
                                'totalMax' => $totalMax,
                                'pct' => $pct,
                                'isTheoryFailed' => $isTheoryFailed,
                                'isPracticalFailed' => $isPracticalFailed,
                                'isSubjectFailed' => $isSubjectFailed,
                                'gr' => $gr,
                                'gp' => $gp,
                                'subject_name' => $subject->subject_name
                            ];
                        @endphp
                        <tr class="{{ $isSubjectFailed ? 'failed-subject' : '' }}">
                            <td>{{ $index + 1 }}</td>
                            <td class="subject-cell">{{ strtoupper($subject->subject_name) }}</td>
                            <td>{{ $thMax > 0 ? $thMax : '-' }}</td>
                            <td>{{ $prMax > 0 ? $prMax : '-' }}</td>
                            <td class="{{ $isTheoryFailed ? 'fail-text' : '' }}">{{ $isTheoryAbsent ? 'AB' : ($thMark > 0 ? $thMark : '-') }}</td>
                            <td class="{{ $isPracticalFailed ? 'fail-text' : '' }}">{{ $isPracticalAbsent ? 'AB' : ($prMark > 0 ? $prMark : '-') }}</td>
                            <td>{{ number_format($totalObt, 0) }}</td>
                            <td>{{ number_format($gp, 1) }}</td>
                            <td class="{{ $isSubjectFailed ? 'fail-grade' : '' }}" style="font-weight:bold">{{ $gr }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ── GRADE SUMMARY (GPA box) ── --}}
            @php
                if (!$hasAnyNg && $subjectGpCount > 0) {
                    $gpaVal = round($subjectGpTotal / $subjectGpCount, 2);
                    if ($gpaVal >= 3.61 && $gpaVal <= 4.00)     { $gpaGrade = 'A+'; }
                    elseif ($gpaVal >= 3.21 && $gpaVal <= 3.60) { $gpaGrade = 'A';  }
                    elseif ($gpaVal >= 2.81 && $gpaVal <= 3.20) { $gpaGrade = 'B+'; }
                    elseif ($gpaVal >= 2.41 && $gpaVal <= 2.80) { $gpaGrade = 'B';  }
                    elseif ($gpaVal >= 2.01 && $gpaVal <= 2.40) { $gpaGrade = 'C+'; }
                    elseif ($gpaVal >= 1.61 && $gpaVal <= 2.00) { $gpaGrade = 'C';  }
                    elseif ($gpaVal >= 1.60)                    { $gpaGrade = 'D';  }
                    else                                        { $gpaGrade = 'NG'; }
                } else {
                    $gpaVal = 0;
                    $gpaGrade = 'NG';
                }
                
                // Apply new logic: if any subject has NG, GPA display should be dash "-"
                $displayGpaValue = $hasAnyNg ? '-' : number_format($gpaVal, 2);
                $displayGpaGrade = $hasAnyNg ? '' : '(' . $gpaGrade . ')';
            @endphp

            <style>
                .grade-summary-section{
                    width:100%;
                    margin-top:17px;
                    font-family:'Inter';
                    font-size:13px;
                    font-weight:normal;
                }
                .grade-summary-table{
                    width:100%;
                    border-collapse:collapse;
                    border:1px solid #000;
                }
                .grade-summary-table td{
                    border:2px solid #000;
                    padding:4px 6px;
                    vertical-align:middle;
                    font-weight:600;
                }
                .label-cell{
                    width:120px;
                    text-align:center;
                }
                .grades-values{
                    padding:0 !important;
                }
                .grade-row{
                    display:flex;
                }
                .grade-row span {
                    flex: 1;
                    text-align: center;
                    border-right: 1px solid #000;
                    padding: 4px 0;
                    /* font-weight: normal; */
                    max-width: 40px;
                }
                .grade-row span:last-child{
                    border-right:none;
                }
                .gpa-cell{
                    width:350px;
                    /*padding:0 !important;*/
                }
                .gpa-box{
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    height:100%;
                    font-weight:600;
                    width: 100px;
                }
                .absent-expelled-row{
                    margin-top:10px;
                    display:flex;
                    justify-content:space-between;
                    font-size:13px;
                    font-weight:600;
                    font-family:'Inter';
                }
            </style>

            <div class="grade-summary-section">
                <table class="grade-summary-table">
                    <tr>
                        <td class="label-cell">GRADES</td>
                        <td class="grades-values">
                            <div class="grade-row">
                                <span>A+</span>
                                <span>A</span>
                                <span>B+</span>
                                <span>B</span>
                                <span>C+</span>
                                <span>C</span>
                                <span>D</span>
                                <span>NG</span>
                            </div>
                        </td>
                        <td rowspan="2" class="gpa-cell">
                            <div class="gpa-box">
                                GPA   <span> {{ $displayGpaValue }} {{ $displayGpaGrade }} </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-cell">GRADE POINTS</td>
                        <td class="grades-values">
                            <div class="grade-row">
                                <span>4.0</span>
                                <span>3.6</span>
                                <span>3.2</span>
                                <span>2.8</span>
                                <span>2.4</span>
                                <span>2.0</span>
                                <span>1.6</span>
                                <span>-</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="absent-expelled-row">
                    <span>*AB: ABSENT</span>
                    <span>*EXP: EXPELLED</span>
                    <!--<span style="color:#cc0000;">*Theory Pass: {{ $exam->theory_passing_percent ?? 35 }}% | Practical Pass: {{ $exam->practical_passing_percent ?? 40 }}%</span>-->
                </div>
            </div>

            {{-- ── GRADE DESCRIPTION TABLES ── --}}
            <div class="grade-desc-section">
                <table class="grade-desc-table">
                    <thead>
                        <tr>
                            <th>GRADES</th>
                            <th>GRADE DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="text-align:start">A+</td><td>OUTSTANDING</td></tr>
                        <tr><td style="text-align:start">A</td><td>EXCELLENT</td></tr>
                        <tr><td style="text-align:start">B+</td><td>VERY GOOD</td></tr>
                        <tr><td style="text-align:start">B</td><td>GOOD</td></tr>
                    </tbody>
                </table>
                <table class="grade-desc-table">
                    <thead>
                        <tr>
                            <th>GRADES</th>
                            <th>GRADE DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="text-align:start">C+</td><td>ABOVE AVERAGE</td></tr>
                        <tr><td style="text-align:start">C</td><td>AVERAGE</td></tr>
                        <tr><td style="text-align:start">D</td><td>NEEDS IMPROVEMENT</td></tr>
                        <tr><td style="text-align:start">NG</td><td>NOT GRADED</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- ── FOOTER SIGNATURES ── --}}
            <div class="footer">
                <div class="footer-signatures">
                    <div class="sign-block">
                       <div class="sign-line">
                            <!--SUNILA MOKTAN-->
                             
                            <br>GRADE EDUCATOR
                        </div>
                    </div>
                    <div class="footer-center">
                       
                           {{ $exam->marksheet_publish_date }}
                             <div class="result-date-label">
                            RESULT DATE
                        </div>
                    </div>
                    <div class="sign-block">
                        
                           @php
    $principal_sign = url('public/uploads/' . ($general->principal_sign ?? ''));
  
  @endphp
  <img src="{{ $principal_sign }}" alt="Principal Sig" width="100">
                            <div class="sign-line">
                                 HARISCHANDRA BUDHATHOKI <br>
                            PRINCIPAL
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- marksheet-inner --}}
    </div>{{-- marksheet-wrapper --}}

</body>
</html>
