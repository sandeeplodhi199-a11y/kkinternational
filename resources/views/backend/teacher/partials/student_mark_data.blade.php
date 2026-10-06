{{-- student_mark_data.blade.php --}}
@php
    $subjects  = $group['subjects'];
    $students  = $group['students'];
    $grandFull = $group['grand_full_marks'] ?? 0;
    $examLabel = strtoupper($group['exam_name'] ?? 'EXAMINATION');

    $subColCount = 0;
    foreach ($subjects as $sub) {
        $subColCount += ($sub->full_practical > 0) ? 2 : 1;
    }

    // 5 fixed right: Sub.Tot + Obt.Tot + Rank + GPA + Grade
    $fixedRight = 5;
    // 2 fixed left: SN + Name
    $fixedLeft  = 2;
    $totalCols  = $fixedLeft + $subColCount + $fixedRight;
@endphp

<div style="font-family:Arial,sans-serif;font-size:11px;overflow-x:auto;">
<table style="border-collapse:collapse;width:100%;table-layout:fixed;">
<colgroup>
    <col style="width:18px;">
    <col style="width:55px;">
    @foreach($subjects as $sub)
        @php $hasPr = ($sub->full_practical > 0); @endphp
        <col style="width:20px;">
        @if($hasPr)<col style="width:20px;">@endif
    @endforeach
    <col style="width:24px;">
    <col style="width:24px;">
    <col style="width:20px;">
    <col style="width:26px;">
    <col style="width:22px;">
</colgroup>

<thead>

    {{-- ROW 1: Exam name spans ALL columns --}}
    <tr>
        <th colspan="{{ $totalCols }}"
            style="border:1px solid #000;padding:2px 4px;text-align:center;
                   font-weight:700;font-size:11px;white-space:nowrap;overflow:hidden; ">
            {{ $examLabel }}
        </th>
    </tr>

    {{-- SUB-ROW A: SN(rowspan3) + Name(rowspan3) + Grade + Section + SectionVal + remaining --}}
    {{-- Total cells this row must produce = $totalCols                                      --}}
    {{-- SN and Name use rowspan so they count here; visible new cells = totalCols - 0       --}}
    {{-- But SN+Name are rendered here so: 2(sn+name) + 3(grade,sec,secval) + remA = totalCols --}}
    {{-- remA = totalCols - 5                                                                --}}
    <tr>
        <th rowspan="3"
            style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:11px;vertical-align:middle;">
            SN
        </th>
        <th rowspan="3"
            style="border:1px solid #000;padding:2px 2px;text-align:left;
                   font-weight:700;font-size:11px;vertical-align:middle;overflow:hidden;">
            Name
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:left;
                   font-weight:700;font-size:11px;white-space:nowrap;overflow:hidden;">
             {{ strtoupper($group['grade_name']) }}
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:left;
                   font-weight:700;font-size:11px;white-space:nowrap;">
            Section
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:11px;">
            {{ strtoupper($group['section_name']) }}
        </th>
        @php
            // In SUB-ROW A: SN(1) + Name(1) + Grade(1) + Section(1) + SectionVal(1) = 5 cells placed
            // remaining = totalCols - 5
            $remA = $totalCols - 5;
        @endphp
        @if($remA > 0)
        <th colspan="{{ $remA }}" style="border:1px solid #000;padding:2px 2px;"></th>
        @endif
    </tr>

    {{-- SUB-ROW B: Subject names + $fixedRight empty cells --}}
    {{-- SN+Name already consumed by rowspan, so cells here = totalCols - 2 --}}
    {{-- subColCount + fixedRight = totalCols - 2 ✓                         --}}
    <tr>
        @foreach($subjects as $sub)
            @php $hasPr = ($sub->full_practical > 0); @endphp
            <th colspan="{{ $hasPr ? 2 : 1 }}"
                style="border:1px solid #000;padding:2px 2px;text-align:center;
                       font-weight:700;font-size:9px;overflow:hidden;word-break:break-word;">
                {{ strtoupper($sub->subject_name) }}
                :TH:{{ (int)$sub->full_theory }}@if($hasPr)|PR:{{ (int)$sub->full_practical }}@endif
            </th>
        @endforeach
        @php $ri = 0; @endphp
        @while($ri < $fixedRight)
            <th style="border:1px solid #000;padding:2px 2px;"></th>
            @php $ri++; @endphp
        @endwhile
    </tr>

    {{-- SUB-ROW C: TH/PR per subject + Sub.Tot + Obt.Tot + Rank + GPA + Grade --}}
    {{-- SN+Name consumed by rowspan, cells here = totalCols - 2 ✓             --}}
    <tr>
        @foreach($subjects as $sub)
            @php $hasPr = ($sub->full_practical > 0); @endphp
            <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                       font-weight:700;font-size:9px;white-space:nowrap;">
                TH
            </th>
            @if($hasPr)
            <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                       font-weight:700;font-size:9px;white-space:nowrap;">
                PR
            </th>
            @endif
        @endforeach
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:9px;white-space:nowrap;">
            Sub.Tot
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:9px;white-space:nowrap;">
            Obt.Tot
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:9px;">
            Rank
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:9px;white-space:nowrap;">
            GPA
        </th>
        <th style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-weight:700;font-size:9px;white-space:nowrap;">
            Grade
        </th>
    </tr>

</thead>

<tbody>
    @forelse($students as $idx => $st)
    <tr>
        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:11px;font-weight:700;">
            {{ $idx + 1 }}
        </td>
        <td style="border:1px solid #000;padding:2px 2px;text-align:left;
                   font-size:11px;font-weight:600;overflow:hidden;word-break:break-word;">
            {{ strtoupper(trim($st->student_name)) }}
        </td>

        @php $obtainedTotal = 0; @endphp

        @foreach($subjects as $sub)
            @php
                $hasPr     = ($sub->full_practical > 0);
                $thMark    = $st->marks[$sub->subject_id]['th'] ?? '';
                $prMark    = $hasPr ? ($st->marks[$sub->subject_id]['pr'] ?? '') : '';
                $thDisplay = (is_numeric($thMark) && $thMark !== '') ? (int)(float)$thMark : $thMark;
                $prDisplay = (is_numeric($prMark) && $prMark !== '') ? (int)(float)$prMark : $prMark;

                if ($thMark !== 'AB' && $thMark !== 'Ab' && $thMark !== 'A' && is_numeric($thMark))
                    $obtainedTotal += (float)$thMark;
                if ($hasPr && $prMark !== 'AB' && $prMark !== 'Ab' && $prMark !== 'A' && is_numeric($prMark))
                    $obtainedTotal += (float)$prMark;
            @endphp
            <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                       font-size:11px;font-weight:700;
                @if($thMark === 'AB' || $thMark === 'Ab' || $thMark === 'A') color:#dc2626; @endif">
                {{ $thDisplay }}
            </td>
            @if($hasPr)
            <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                       font-size:11px;font-weight:700;
                @if($prMark === 'AB' || $prMark === 'Ab' || $prMark === 'A') color:#dc2626; @endif">
                {{ $prDisplay }}
            </td>
            @endif
        @endforeach

        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:11px;font-weight:700;">
            {{ (int)($st->subject_full_total ?? $grandFull) }}
        </td>
        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:11px;font-weight:700;">
            {{ $obtainedTotal > 0 ? (int)$obtainedTotal : '' }}
        </td>
        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:11px;font-weight:700;
            @if(($st->rank ?? '-') === '-') color:#dc2626; @endif">
            {{ $st->rank ?? '-' }}
        </td>
        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:10px;font-weight:700;
            @if(($st->gpa_value ?? '-') === '-') color:#dc2626; @endif">
            {{ $st->gpa_value ?? '-' }}
        </td>
        <td style="border:1px solid #000;padding:2px 2px;text-align:center;
                   font-size:10px;font-weight:700;
            @if(($st->gpa_grade ?? 'NG') === 'NG' || ($st->gpa_grade ?? '-') === '-') color:#dc2626; @endif">
            {{ $st->gpa_grade ?? '-' }}
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="{{ $totalCols }}"
            style="border:1px solid #000;text-align:center;padding:8px;
                   color:#888;font-size:11px;">
            No students found.
        </td>
    </tr>
    @endforelse
</tbody>

</table>
</div>
