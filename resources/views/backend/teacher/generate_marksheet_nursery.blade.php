@extends('backend.layouts.app')
@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .marksheet-page {
        position: relative;
        max-width: 900px;
        margin: 20px auto;
    }
    .marksheet-wrapper {
        position: relative;
        z-index: 1;
        border: 3px solid #cc0000;
        padding: 3px;
        background: white;
        box-shadow: 0 2px 12px rgba(0,0,0,0.12);
    }
    .marksheet-inner {
        border: 1px solid #cc0000;
        padding: 14px 16px;
        margin-top: 200px;
    }

    /* ── Header ── */
    .ms-header { display: flex; align-items: center; margin-bottom: 6px; position: relative; }
    .ms-logo { width: 75px; height: 75px; flex-shrink: 0; margin-right: 12px; }
    .ms-logo img { width: 100%; height: 100%; object-fit: contain; }
    .ms-header-center { flex: 1; text-align: center; }
    .ms-tagline { font-size: 10px; font-style: italic; color: #333; font-family: 'Times New Roman', serif; }
    .ms-school-name { font-size: 28px; font-weight: bold; color: #cc0000; font-family: 'Times New Roman', serif; letter-spacing: 1px; line-height: 1.1; }
    .ms-address { font-size: 10px; color: #333; margin-top: 2px; font-family: 'Times New Roman', serif; }
    .ms-exam-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-top: 8px; font-family: 'Times New Roman', serif; }
    .ms-report-title { text-align: center; font-size: 13px; font-weight: bold; letter-spacing: 2px; margin-top: 3px; font-family: 'Times New Roman', serif; }

    /* ── Student Info ── */
    .ms-student-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #000;
        padding: 5px 8px;
        margin: 10px 0 8px 0;
        font-size: 11px;
        font-weight: bold;
        font-family: 'Times New Roman', serif;
    }

    /* ── Marks Table (Letter Grades — Nursery) ── */
    .ms-marks-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        font-family: 'Times New Roman', serif;
    }
    .ms-marks-table th,
    .ms-marks-table td {
        border: 1px solid #000;
        padding: 4px 3px;
        text-align: center;
        vertical-align: middle;
    }
    .ms-marks-table th { font-weight: bold; background: white; font-size: 9.5px; }
    .ms-marks-table .sub-th { font-size: 9px; padding: 2px; }
    .ms-marks-table .subject-cell { text-align: left; padding-left: 8px; }

    /* Failed subject */
    .failed-subject { background-color: #ffe6e6; }
    .fail-text { color: #cc0000; font-weight: bold; }
    .fail-grade { color: #cc0000; font-weight: bold; }

    /* ── Extra Activities Section ── */
    .ms-extra-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        font-family: 'Times New Roman', serif;
        margin-top: 5px;
    }
    .ms-extra-table td {
        border: 1px solid #000;
        padding: 4px 8px;
        font-size: 9.5px;
        font-weight: bold;
        vertical-align: middle;
    }
    .ms-extra-table .activity-name {
        text-align: left;
        font-weight: bold;
        width: 40%;
    }
    .ms-extra-table .activity-grade {
        text-align: center;
        font-weight: bold;
        width: 10%;
    }

    /* ── Grade Summary ── */
    .ms-grade-summary { margin-top: 8px; font-size: 9.5px; font-family: 'Times New Roman', serif; }
    .ms-grade-summary-table { width: 100%; border-collapse: collapse; }
    .ms-grade-summary-table td { border: 1px solid #000; padding: 3px 6px; vertical-align: middle; }
    .ms-label { font-weight: bold; width: 95px; }
    .ms-grades-val { letter-spacing: 3px; }
    .ms-gpa-box { border: 1px solid #000; padding: 5px 10px; font-weight: bold; font-size: 12px; text-align: center; white-space: nowrap; }
    .ms-absent-row { display: flex; justify-content: space-between; font-size: 9px; font-style: italic; margin-top: 4px; padding: 0 2px; }

    /* ── Grade Description ── */
    .ms-grade-desc-section { display: flex; gap: 15px; margin-top: 10px; }
    .ms-grade-desc-table { flex: 1; border-collapse: collapse; font-size: 10px; font-family: 'Times New Roman', serif; }
    .ms-grade-desc-table th, .ms-grade-desc-table td { border: 1px solid #000; padding: 3px 8px; text-align: left; }
    .ms-grade-desc-table th { font-weight: bold; text-align: center; background: white; }

    /* ── Footer ── */
    .ms-footer { margin-top: 100px; }
    .ms-footer-row { display: flex; justify-content: space-between; align-items: flex-end; }
    .ms-sign-block { text-align: center; font-size: 9px; width: 180px; font-family: 'Times New Roman', serif; }
    .ms-sign-block .ms-sign-line { border-top: 1px solid #000; padding-top: 3px; margin-top: 22px; font-weight: bold; font-size: 9.5px; line-height: 1.5; }
    .ms-footer-center { text-align: center; font-size: 9px; font-family: 'Times New Roman', serif; }
    .ms-footer-center .ms-date-line { border-top: 1px solid #000; padding-top: 3px; margin-top: 22px; font-weight: bold; }

    /* ── Action Buttons ── */
    .ms-action-btns { text-align: center; margin-top: 25px; padding-top: 18px; border-top: 1px solid #ddd; }
    .ms-btn { display: inline-block; padding: 9px 20px; margin: 0 5px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; text-decoration: none; }
    .ms-btn-primary { background: #3498db; color: white; }
    .ms-btn-secondary { background: #95a5a6; color: white; }
    .ms-btn:hover { opacity: 0.88; }

    @media print {
        .ms-action-btns { display: none; }
        .marksheet-page { margin: 0; }
        .marksheet-wrapper { box-shadow: none; }
    }
</style>

<div class="marksheet-page">
    <div class="marksheet-wrapper">
        <div class="marksheet-inner">

            <div class="ms-exam-title">{{ $exam->exam_name }}</div>
            <div class="ms-report-title">PROGRESS REPORT</div>

            {{-- ── STUDENT INFO ── --}}
            <div class="ms-student-info">
                <span>NAME : {{ strtoupper($student->first_name . ' ' . ($student->middle_name ? $student->middle_name . ' ' : '') . $student->last_name) }}</span>
                <span>GRADE : {{ $grade->name ?? '' }}</span>
                <span>SECTION : {{ $section->name ?? '' }}</span>
            </div>

            {{-- ── MARKS TABLE (Letter Grades Only — Nursery Format) ── --}}
            <table class="ms-marks-table">
                <thead>
                    <tr>
                        <th style="width:30px">S.N.</th>
                        <th style="width:180px; text-align:left; padding-left:8px;">LEARNING AREAS</th>
                        <th>GRADE POINT<br>(GP)</th>
                        <th>GRADES OBTAINED</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $hasAnyNg = false;
                    $totalGP = 0;
                    $subjectCount = 0;
                @endphp

                @foreach($subjects as $index => $subject)
                @php
                    $thMark  = $subject->obtained_mark ?? 0;
                    $prMark  = $subject->obtained_practical_mark ?? 0;
                    $thMax   = $subject->max_mark ?? 0;
                    $prMax   = $subject->max_practical_mark ?? 0;
                    $isTheoryAbsent = (bool) ($subject->is_absent_theory ?? false);
                    $isPracticalAbsent = $prMax > 0 && (bool) ($subject->is_absent_practical ?? false);

                    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
                    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;

                    $theoryPct    = $thMax > 0 ? ($thMark / $thMax) * 100 : 100;
                    $practicalPct = $prMax > 0 ? ($prMark / $prMax) * 100 : 100;

                    $isTheoryFailed = $isTheoryAbsent
                        || ($thMax > 0 && $theoryPct < $theoryPassingPercent);
                    $isPracticalFailed = $isPracticalAbsent
                        || ($prMax > 0 && $practicalPct < $practicalPassingPercent);
                    $isSubjectFailed   = $isTheoryFailed || $isPracticalFailed;

                    // TH letter grade
                    $thGrade = '-';
                    if ($thMax > 0) {
                        if ($isTheoryAbsent)       { $thGrade = 'AB'; }
                        elseif ($isTheoryFailed)   { $thGrade = 'NG'; }
                        elseif ($theoryPct >= 90)  { $thGrade = 'A+'; }
                        elseif ($theoryPct >= 80)  { $thGrade = 'A'; }
                        elseif ($theoryPct >= 70)  { $thGrade = 'B+'; }
                        elseif ($theoryPct >= 60)  { $thGrade = 'B'; }
                        elseif ($theoryPct >= 50)  { $thGrade = 'C+'; }
                        elseif ($theoryPct >= 40)  { $thGrade = 'C'; }
                        elseif ($theoryPct >= 33)  { $thGrade = 'D'; }
                        else                        { $thGrade = 'NG'; }
                    }

                    // PR letter grade
                    $prGrade = '-';
                    if ($prMax > 0) {
                        if ($isPracticalAbsent)        { $prGrade = 'AB'; }
                        elseif ($isPracticalFailed)    { $prGrade = 'NG'; }
                        elseif ($practicalPct >= 90)   { $prGrade = 'A+'; }
                        elseif ($practicalPct >= 80)   { $prGrade = 'A'; }
                        elseif ($practicalPct >= 70)   { $prGrade = 'B+'; }
                        elseif ($practicalPct >= 60)   { $prGrade = 'B'; }
                        elseif ($practicalPct >= 50)   { $prGrade = 'C+'; }
                        elseif ($practicalPct >= 40)   { $prGrade = 'C'; }
                        elseif ($practicalPct >= 33)   { $prGrade = 'D'; }
                        else                            { $prGrade = 'NG'; }
                    }

                    $totalObt = $thMark + $prMark;
                    $totalMax = $thMax + $prMax;
                    $pct      = $totalMax > 0 ? ($totalObt / $totalMax) * 100 : 0;

                    if ($isSubjectFailed) {
                        $gr = 'NG'; $gp = 0; $hasAnyNg = true;
                    } else {
                        if ($pct >= 90)     { $gp = 4.0; $gr = 'A+'; }
                        elseif ($pct >= 80) { $gp = 3.6; $gr = 'A'; }
                        elseif ($pct >= 70) { $gp = 3.2; $gr = 'B+'; }
                        elseif ($pct >= 60) { $gp = 2.8; $gr = 'B'; }
                        elseif ($pct >= 50) { $gp = 2.4; $gr = 'C+'; }
                        elseif ($pct >= 40) { $gp = 2.0; $gr = 'C'; }
                        elseif ($pct >= 33) { $gp = 1.6; $gr = 'D'; }
                        else                 { $gp = 0;   $gr = 'NG'; $hasAnyNg = true; }
                    }

                    if ($totalMax > 0) {
                        $totalGP += $gp;
                        $subjectCount++;
                    }
                @endphp
                <tr class="{{ $isSubjectFailed ? 'failed-subject' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td class="subject-cell">{{ strtoupper($subject->subject_name) }}</td>
                    <td>{{ number_format($gp, 1) }}</td>
                    <td class="{{ $isSubjectFailed ? 'fail-grade' : '' }}" style="font-weight:bold">{{ $gr }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

           <!--
            <table class="ms-extra-table">
                <tr>
                    <td class="activity-name">ENGLISH RHYMES</td>
                    <td class="activity-grade">A</td>
                    <td class="activity-name">NEPALI RHYMES</td>
                    <td class="activity-grade">A</td>
                </tr>
                <tr>
                    <td class="activity-name">COLOURING</td>
                    <td class="activity-grade">A+</td>
                    <td class="activity-name">MOTOR SKILLS</td>
                    <td class="activity-grade">A</td>
                </tr>
            </table>  -->

            {{-- ── GRADE SUMMARY + GPA ── --}}
            @php
                if ($subjectCount > 0) {
                    $gpaVal = round($totalGP / $subjectCount, 2);
                    if ($hasAnyNg)                              { $gpaGrade = 'NG'; }
                    elseif ($gpaVal >= 3.61 && $gpaVal <= 4.00) { $gpaGrade = 'A+'; }
                    elseif ($gpaVal >= 3.21 && $gpaVal <= 3.60) { $gpaGrade = 'A';  }
                    elseif ($gpaVal >= 2.81 && $gpaVal <= 3.20) { $gpaGrade = 'B+'; }
                    elseif ($gpaVal >= 2.41 && $gpaVal <= 2.80) { $gpaGrade = 'B';  }
                    elseif ($gpaVal >= 2.01 && $gpaVal <= 2.40) { $gpaGrade = 'C+'; }
                    elseif ($gpaVal >= 1.61 && $gpaVal <= 2.00) { $gpaGrade = 'C';  }
                    elseif ($gpaVal >= 1.60)                    { $gpaGrade = 'D';  }
                    else                                        { $gpaGrade = 'NG'; }
                } else {
                    $gpaVal = 0; $gpaGrade = 'NG';
                }
            @endphp

            <div class="ms-grade-summary">
                <table class="ms-grade-summary-table">
                    <tr>
                        <td class="ms-label">GRADES</td>
                        <td class="ms-grades-val">A+&nbsp;&nbsp;A&nbsp;&nbsp;B+&nbsp;&nbsp;B&nbsp;&nbsp;C+&nbsp;&nbsp;C&nbsp;&nbsp;D&nbsp;&nbsp;NG</td>
                        <td rowspan="2" style="width:145px; text-align:center;">
                            <div class="ms-gpa-box">
                                GPA {{ number_format($gpaVal, 2) }} ({{ $gpaGrade }})
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ms-label">GRADE POINTS</td>
                        <td class="ms-grades-val">4.0&nbsp;&nbsp;3.6&nbsp;&nbsp;3.2&nbsp;&nbsp;2.8&nbsp;&nbsp;2.4&nbsp;&nbsp;2.0&nbsp;&nbsp;1.6&nbsp;&nbsp;0</td>
                    </tr>
                </table>
                <div class="ms-absent-row">
                    <span>*AB: ABSENT</span>
                    <span>*EXP: EXPELLED</span>
                </div>
            </div>

            {{-- ── GRADE DESCRIPTION TABLES ── --}}
            <div class="ms-grade-desc-section">
                <table class="ms-grade-desc-table">
                    <thead><tr><th>GRADES</th><th>GRADE DESCRIPTION</th></tr></thead>
                    <tbody>
                        <tr><td style="text-align:center">A+</td><td>OUTSTANDING</td></tr>
                        <tr><td style="text-align:center">A</td><td>EXCELLENT</td></tr>
                        <tr><td style="text-align:center">B+</td><td>VERY GOOD</td></tr>
                        <tr><td style="text-align:center">B</td><td>GOOD</td></tr>
                    </tbody>
                </table>
                <table class="ms-grade-desc-table">
                    <thead><tr><th>GRADES</th><th>GRADE DESCRIPTION</th></tr></thead>
                    <tbody>
                        <tr><td style="text-align:center">C+</td><td>ABOVE AVERAGE</td></tr>
                        <tr><td style="text-align:center">C</td><td>AVERAGE</td></tr>
                        <tr><td style="text-align:center">D</td><td>NEEDS IMPROVEMENT</td></tr>
                        <tr><td style="text-align:center">NG</td><td>NOT GRADED</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- ── FOOTER ── --}}
            <div class="ms-footer">
                <div class="ms-footer-row">
                    <div class="ms-sign-block">
                        <div class="ms-sign-line">GRADE EDUCATOR</div>
                    </div>
                    <div class="ms-footer-center">
                        <div class="ms-date-line">   {{ $exam->marksheet_publish_date }}<br>RESULT DATE</div>
                    </div>
                    <div class="ms-sign-block">
                         @php
    $principal_sign = url('public/uploads/' . ($general->principal_sign ?? ''));
  
  @endphp
  <img src="{{ $principal_sign }}" alt="Principal Sig"  width="100" >
                        <div class="ms-sign-line">HARISCHANDRA BUDHATHOKI<br>PRINCIPAL</div>
                    </div>
                </div>
            </div>

        </div>{{-- marksheet-inner --}}
    </div>{{-- marksheet-wrapper --}}

    {{-- ── ACTION BUTTONS ── --}}
    <div class="ms-action-btns">
        <a href="{{ route('student.marksheet.nursery.print', [$student->id, $exam->id]) }}"
           class="ms-btn ms-btn-primary" target="_blank">
            <i class="fas fa-print"></i> Print Marksheet
        </a>
        <a href="{{ route('student.marks.nursery.index') }}" class="ms-btn ms-btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

</div>{{-- marksheet-page --}}
@endsection
