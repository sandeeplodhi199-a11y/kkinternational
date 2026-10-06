<div class="slip-outer" style="width:100%;">

  {{-- HEADER: Logo LEFT + School Info RIGHT --}}
<table style="width:100%; border:none; margin-bottom:14px;">
    <tr>
        <td style="border:none; width:100px; vertical-align:middle; text-align:left;">
            <img src="https://www.kkinternationalschool.org/public/uploads/202606011816kk_logo.jpeg" 
                 alt="KK School Logo" 
                 style="width:90px; height:90px; object-fit:contain; border-radius:50%;">
        </td>
       <td style="border:none; text-align:right; vertical-align:middle;">
    <div class="school-name" style="font-size:28px;">K.K. International School</div>
    <div class="school-address" style="font-size:14px;">Dharan-15, Sunsari, Nepal</div>
    <div style="display:flex; align-items:flex-end; justify-content:flex-end; gap:0;">
        <div style="flex:1;border-bottom: 1px solid #000;margin-bottom: 24px;margin-left: 200px;"></div>
        <div style="text-align:right;">
            <div class="exam-title" style="white-space:nowrap; font-size:16px;">TERMINAL/UNIT EXAMINATION</div>
            <div class="exam-subtitle" style="font-size:14px;">Marks Record Slip</div>
        </div>
    </div>
</td>
    </tr>
</table>

    {{-- SUBJECT LINE --}}
    <div class="subject-line" style="text-align:center;margin: 12px 0px 16px 0;font-size: 14px;font-weight: 700;font-family: 'Inter'; font-weight: 700;margin-right: -434px;">
        <strong>Subject:</strong>
        <span style="display:inline-block; min-width:320px; border-bottom:1px solid #000;">&nbsp;</span>
    </div>

    {{-- MAIN CONTENT: Student Table LEFT + Right Panel RIGHT --}}
    <table style="width:100%; border-collapse:collapse; border:none;">
        <tr style="vertical-align:top;">

            {{-- LEFT: Student Table --}}
            <td style="border:none; padding-right:20px;">
                <table class="student-table" style="width:100%; table-layout:fixed;">
                    <colgroup>
                        <col style="width:55px;">
                        <col style="width:170px;">
                        <col style="width:100px;">
                        <col style="width:100px;">
                        <col style="width:100px;">
                        <col style="width:170px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="6" style="text-align:center; font-size:14px; font-weight:700; border:1px solid #000; padding:12px; background:#f5f5f5;">
                                GRADE: {{ strtoupper($group['grade_name']) }} &nbsp;|&nbsp; SECTION :{{ strtoupper($group['section_name']) }}
                            </th>
                        </tr>
                        <tr class="header-row">
                            <th class="sno-col" rowspan="2" style="font-size:13px; padding:10px;">S.N.</th>
                            <th class="name-col" rowspan="2" style="font-size:13px; padding:10px;">STUDENT NAME</th>
                            <th colspan="3" style="border:1px solid #000; padding:12px; font-size:14px; text-align:center;">MARKS OBTAINED</th>
                            <th class="remark-col" rowspan="2" style="font-size:13px; padding:10px;">REMARKS</th>
                        </tr>
                        <tr class="header-row">
                            <th class="mark-col" style="font-size:13px; padding:12px;">TH</th>
                            <th class="mark-col" style="font-size:13px; padding:12px;">PR</th>
                            <th class="mark-col" style="font-size:13px; padding:12px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group['students'] as $idx => $st)
                        <tr>
                            <td style="text-align:center; border:1px solid #000; padding:11px 6px; font-size:14px; height:44px;">{{ $idx + 1 }}</td>
                            <td class="student-name-cell" style="border:1px solid #000; padding:11px 10px; font-size:14px; height:44px;">{{ strtoupper(trim($st->student_name)) }}</td>
                            <td style="border:1px solid #000; padding:11px; height:44px;"></td>
                            <td style="border:1px solid #000; padding:11px; height:44px;"></td>
                            <td style="border:1px solid #000; padding:11px; height:44px;"></td>
                            <td style="border:1px solid #000; padding:11px; height:44px;"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            {{-- RIGHT PANEL: Subject Marks Details + Result Summary --}}
            <td style="border:none; width:380px; vertical-align:top;">

                {{-- Subject Marks Details --}}
                <table style="width:100%;border-collapse:collapse;font-size:13px;margin-bottom:24px;table-layout:fixed;">
                    <colgroup>
                        <col style="width:auto;">
                        <col style="width:110px;">
                        <col style="width:110px;">
                    </colgroup>
                    <tr>
                        <th colspan="3" style="border:1px solid #000; padding:13px; background:#f5f5f5; font-weight:700; font-size:13px; text-align:center;font-family: 'Inter'; font-weight: 700;">
                            SUBJECT MARKS DETAILS
                        </th>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:42px;"></td>
                        <td style="border:1px solid #000; padding:13px; text-align:center; font-weight:700; font-family: 'Inter'; font-weight: 700; height:42px;">TH</td>
                        <td style="border:1px solid #000; padding:13px; text-align:center; font-weight:700; font-family: 'Inter'; font-weight: 700; height:42px;">PR</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">FULL MARKS</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">PASS MARKS</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                </table>

                {{-- Result Summary --}}
                <table style="width:100%;border-collapse:collapse;font-size:13px;font-family: 'Inter';font-weight: 700;table-layout:fixed;">
                    <colgroup>
                        <col style="width:auto;">
                        <col style="width:120px;">
                    </colgroup>
                    <tr>
                        <th colspan="2" style="border:1px solid #000; padding:13px; background:#f5f5f5; font-weight:700; font-size:13px; text-align:center; font-family: 'Inter'; font-weight: 700;">
                            RESULT SUMMARY
                        </th>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">HIGHEST SCORE</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">LOWEST SCORE</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">NO. OF PASSED STUDENTS</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;padding:13px 15px;font-size:13px;font-family: 'Inter';font-weight: 700;height:44px;">NO. OF FAILED STUDENTS</td>
                        <td style="border:1px solid #000; padding:13px; font-family: 'Inter'; font-weight: 700; height:44px;"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</div>