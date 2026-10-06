<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admit Cards - 8 Per Page</title>
<style>
/* RESET & BASE */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #fff;
    font-size: 8.8pt;
    margin: 0;
    padding: 0;
}

/* PAGE CONTAINER - A4 dimensions */
.page {
    width: 210mm;
    margin: 0 auto;
    padding: 2mm 0 0 0;
    background: #fff;
}

/* Add page break between pages */
.page-break {
    page-break-before: always;
}

/* Outer table: 2 columns per row */
.outer {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.outer td.cc {
    width: 50%;
    padding: 0 2mm 4mm 2mm;
    vertical-align: top;
}

/* CARD STYLES */
.card {
    width: 100%;
    border-collapse: collapse;
    border: 1pt solid #b0bcd4;
    background: #fff;
    break-inside: avoid;
    page-break-inside: avoid;
}

/* Header area */
.hdr-td {
    border-bottom: 1pt solid #c8d4e8;
    padding: 0;
}
.hdr-inner {
    width: 100%;
    border-collapse: collapse;
}
.logo-cell {
    width: 17mm;
    padding: 1.8mm 1mm 1.8mm 2mm;
    vertical-align: middle;
    text-align: center;
}
.logo-cell img {
    width: 13mm;
    height: 13mm;
    display: block;
    margin: 0 auto;
}
.logo-fallback {
    width: 13mm;
    height: 13mm;
    background: #1a3a6b;
    color: #fff;
    font-size: 4.8pt;
    font-weight: 900;
    text-align: center;
    line-height: 1.2;
    display: table;
    border-radius: 50%;
}
.logo-fallback span {
    display: table-cell;
    vertical-align: middle;
}
.info-cell {
    padding: 1.8mm 2mm 1.8mm 1mm;
    vertical-align: middle;
    text-align: center;
}
.tagline {
    font-size: 5.2pt;
    color: #666;
    font-style: italic;
    margin-bottom: 0.6mm;
}
.sname {
    font-size: 8.5pt;
    font-weight: 900;
    color: #111;
    line-height: 1.1;
}
.saddr {
    font-size: 5.2pt;
    color: #555;
    margin-top: 0.5mm;
}

/* Banner */
.banner {
    background: #1a3a6b;
    color: #fff;
    text-align: center;
    font-size: 7pt;
    font-weight: 900;
    letter-spacing: 0.2em;
    padding: 1.5mm 0;
    display: block;
}

/* Body center */
.body-center {
    padding: 2mm 6mm 1.8mm 6mm;
    text-align: center;
}
.ename {
    text-align: center;
    font-size: 7.2pt;
    font-weight: 900;
    color: #111;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.4mm;
}
.edate {
    text-align: center;
    font-size: 6.2pt;
    color: #444;
    margin-bottom: 1.8mm;
}

/* Info table */
.itbl {
    width: auto;
    border-collapse: collapse;
    margin: 0 auto;
}
.itbl td {
    font-size: 7.2pt;
    padding: 0.6mm 0;
    color: #111;
    vertical-align: middle;
    margin-left : 10px;
}
.lb {
    width: 12.5mm;
    font-weight: 400;
    color: #333;
    white-space: nowrap;
    text-align: left;
}
.cl {
    width: 4.5mm;
    text-align: center;
    color: #444;
}
.vl {
    font-weight: 700;
    color: #111;
    min-width: 27mm;
    text-align: left;
}

/* Signature strip */
.sig-td {
    border-top: 0.6pt solid #ccd4e4;
    padding: 1.8mm 3.5mm 2.2mm 3.5mm;
    vertical-align: bottom;
}
.stbl {
    width: 100%;
    border-collapse: collapse;
}
.stbl td {
    text-align: center;
    width: 50%;
    padding: 0;
    vertical-align: bottom;
}
.stbl td img {
    display: block;
    height: 7mm;
    margin: 0 auto 0.8mm;
    max-width: 24mm;
}
.sline {
    width: 60%;
    border: none;
    border-top: 0.7pt solid #555;
    margin: 0 auto 0.8mm;
    display: block;
    height: 0;
    font-size: 0;
}
.slbl {
    font-size: 5.2pt;
    color: #444;
    letter-spacing: 0.06em;
    display: block;
    text-align: center;
    text-transform: uppercase;
}

/* Empty placeholder */
.empty {
    width: 100%;
    border-collapse: collapse;
    border: 1pt dashed #c4cee4;
    background: #f5f7fc;
    height: 62mm;
    text-align: center;
    vertical-align: middle;
}
.empty td {
    text-align: center;
    vertical-align: middle;
    font-size: 7.5pt;
    color: #888;
}

/* Print optimization */
@media print {
    body {
        margin: 0;
        padding: 0;
    }
    .page {
        margin: 0;
        padding: 0;
        width: 100%;
    }
    .card {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>

@php
    // Handle input data - for blank template, $students will be empty or null
    $allStudents = $students ?? [];
    if(empty($allStudents) && isset($chunks)) {
        $allStudents = collect();
        foreach($chunks as $chunkGroup) {
            foreach($chunkGroup as $student) {
                $allStudents->push($student);
            }
        }
    }
    
    $studentArray = is_array($allStudents) ? $allStudents : $allStudents->toArray();
    $total = count($studentArray);
    
    // If this is a blank template download (no students), create 8 empty slots
    if ($total == 0) {
        $pages = [];
        // Create one page with 8 null entries (empty cards)
        $emptyPage = [];
        for ($i = 0; $i < 8; $i++) {
            $emptyPage[] = null;
        }
        $pages[] = $emptyPage;
    } else {
        // Group students into pages of exactly 8 cards
        $pages = [];
        for ($i = 0; $i < $total; $i += 8) {
            $pageCards = array_slice($studentArray, $i, 8);
            while (count($pageCards) < 8) {
                $pageCards[] = null;
            }
            $pages[] = $pageCards;
        }
    }
    
    // Helper to safely get student property
    function getStudentProp($student, $prop, $default = 'N/A') {
        if (!$student) return $default;
        if (is_object($student)) {
            return property_exists($student, $prop) ? $student->$prop : $default;
        }
        return $student[$prop] ?? $default;
    }
@endphp

@foreach($pages as $pageIndex => $pageCards)
<div class="page" @if($pageIndex > 0) style="page-break-before: always;" @endif>
    <table class="outer" cellpadding="0" cellspacing="0">
        <tbody>
            @for($row = 0; $row < 4; $row++)
            <tr>
                @for($col = 0; $col < 2; $col++)
                    @php
                        $cardIndex = ($row * 2) + $col;
                        $student = $pageCards[$cardIndex] ?? null;
                    @endphp
                    <td class="cc">
                        @if($student)
                        <table class="card" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td class="hdr-td">
                                        <table class="hdr-inner" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="logo-cell">
                                                    @php
    $logoPath = url('public/uploads/' . ($general->company_logo ?? ''));
  
  @endphp

  @if(!empty($general->company_logo))
                                                        <img src="{{ $logoPath }}" alt="Logo">
                                                    @else
                                                        <div class="logo-fallback"><span>K.K.<br>INT</span></div>
                                                    @endif
                                                </td>
                                                <td class="info-cell">
                                                    <div class="tagline">{{ $general->school_title }}</div>
                                                    <div class="sname">{{ $general->school_name }}</div>
                                                    <div class="saddr">{{ $general->school_address }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0;"><div class="banner">ADMIT CARD</div></td>
                                </tr>
                                <tr>
                                    <td style="padding:0;">
                                        <div class="body-center">
                                            <div class="ename">{{ getStudentProp($student, 'exam_name', $exam->exam_name ?? 'ANNUAL EXAMINATION') }}</div>
                                            <div class="edate">
                                                ({{ getStudentProp($student, 'start_date', $exam->start_date ?? '2025-04-01') }} - {{ getStudentProp($student, 'end_date', $exam->end_date ?? '2025-04-20') }})
                                            </div>
                                            <table class="itbl" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="lb">Name</td>
                                                    <td class="cl">:</td>
                                                    <td class="vl">{{ trim(getStudentProp($student, 'full_name', 'N/A')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="lb">Grade</td>
                                                    <td class="cl">:</td>
                                                    <td class="vl">{{ getStudentProp($student, 'grade_name', 'N/A') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="lb">Section</td>
                                                    <td class="cl">:</td>
                                                    <td class="vl">{{ getStudentProp($student, 'section_name', 'N/A') }}</td>
                                                </tr>
                                                @php $roll = getStudentProp($student, 'roll_number', ''); @endphp
                                                @if(!empty($roll) && $roll != 'N/A')
                                                <tr>
                                                    <td class="lb"></td>
                                                    <td class="cl"></td>
                                                    <td class="vl"></td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sig-td">
                                        <table class="stbl" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                      @php
    $exam_controller_sign = url('public/uploads/' . ($general->exam_controller_sign ?? ''));
  
  @endphp

  @if(!empty($general->exam_controller_sign))
                                                        <img src="{{ $exam_controller_sign }}" alt="Exam Controller Sig">
                                                    @else
                                                        <span class="sline"></span>
                                                    @endif
                                                    <span class="slbl">Exam Controller</span>
                                                </td>
                                                <td>
                                                      @php
    $principal_sign = url('public/uploads/' . ($general->principal_sign ?? ''));
  
  @endphp

  @if(!empty($general->principal_sign))
                                                        <img src="{{ $principal_sign }}" alt="Principal Sig">
                                                    @else
                                                        <span class="sline"></span>
                                                    @endif
                                                    <span class="slbl">Principal</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="empty" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </td>
                @endfor
            </tr>
            @endfor
        </tbody>
    </table>
</div>
@endforeach

</body>
</html>