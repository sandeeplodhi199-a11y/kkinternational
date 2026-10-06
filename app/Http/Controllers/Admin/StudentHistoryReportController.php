<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\SimpleXlsx;

class StudentHistoryReportController extends Controller
{
    // ─────────────────────────────────────────────────────────
    // GET  admin/student-history-report
    // ─────────────────────────────────────────────────────────
    public function student_history_report(Request $request)
    {
        $data['menu']    = 'students';
        $data['submenu'] = 'student_history_report';

        $session_id = $request->session_id;
        $grade_id   = $request->grade_id;    // 'all' or specific id
        $section_id = $request->section_id;  // 'all' or specific id (only when grade != 'all')
        $status     = $request->status;      // '' (all) or specific status

        // Current (latest) session ID
        $currentSessionId = DB::table('tbl_session')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->value('id');

        // Sessions except current
        $sessions = DB::table('tbl_session')
            ->where('is_deleted', 0)
            ->where('id', '!=', $currentSessionId)
            ->orderBy('id', 'DESC')
            ->get();

        // Grades
        $grades = DB::table('tbl_grade')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get();

        // Sections — only when a specific grade is selected
        $sections = collect();
        if ($grade_id && $grade_id !== 'all') {
            $sections = DB::table('tbl_section')
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->whereRaw('FIND_IN_SET(?, grade_id)', [$grade_id])
                ->orderBy('name')
                ->get();
        }

        // Determine if filters are sufficient to fetch:
        // session + grade required always
        // if specific grade → section also required
        // if all grades → section skipped
        $canFetch = false;
        if ($session_id && $grade_id) {
            if ($grade_id === 'all') {
                $canFetch = true;
            } elseif ($section_id) {
                $canFetch = true;
            }
        }

        $students = collect();
        if ($canFetch) {
            $query = DB::table('tbl_promotion_log as pl')
                ->join('tbl_admission as a', 'a.id', '=', 'pl.student_id')
                ->leftJoin('tbl_session as s',   's.id',   '=', 'pl.from_session_id')
                ->leftJoin('tbl_grade as g',     'g.id',   '=', 'pl.from_grade_id')
                ->leftJoin('tbl_section as sec', 'sec.id', '=', 'pl.from_section_id')
                ->select(
                    'a.id',
                    'a.admission_no',
                    'a.roll_number',
                    'a.first_name',
                    'a.middle_name',
                    'a.last_name',
                    'a.nickname',
                    'a.father_name',
                    'a.mother_name',
                    'a.phone',
                    'a.contact',
                    'a.email',
                    'a.gender',
                    'a.dob_ad',
                    'a.dob_bs',
                    'a.blood_group',
                    'a.nationality',
                    'a.religion',
                    'a.ethnicity',
                    'a.mother_tongue',
                    'a.address',
                    'a.city',
                    'a.state',
                    'a.pincode',
                    'a.iemis_no',
                    'a.admission_date',
                    'a.status',
                    's.name   as session_name',
                    'g.name   as grade_name',
                    'sec.name as section_name'
                )
                ->where('a.is_deleted', 0)
                ->where('pl.from_session_id', $session_id);

            // Grade filter
            if ($grade_id !== 'all') {
                $query->where('pl.from_grade_id', $grade_id);

                // Section filter — only for specific grade
                if ($section_id && $section_id !== 'all') {
                    $query->where('pl.from_section_id', $section_id);
                }
            }

            // Status filter
            if ($status) {
                $query->where('a.status', $status);
            }

            $students = $query
                ->orderBy('g.name')
                ->orderBy('sec.name')
                ->orderBy('a.roll_number')
                ->get();
        }

        return view('backend.reports.student_history_report', compact(
            'students',
            'sessions', 'grades', 'sections',
            'session_id', 'grade_id', 'section_id', 'status',
            'data'
        ));
    }

    // ─────────────────────────────────────────────────────────
    // GET  admin/student-history-report/download
    // ─────────────────────────────────────────────────────────
    public function student_history_report_download(Request $request)
    {
        $session_id = $request->session_id;
        $grade_id   = $request->grade_id;
        $section_id = $request->section_id;
        $status     = $request->status;

        if (!$session_id || !$grade_id) {
            return redirect()->route('student-history-report')
                ->with('error', 'Please select Session and Grade before downloading.');
        }
        if ($grade_id !== 'all' && !$section_id) {
            return redirect()->route('student-history-report')
                ->with('error', 'Please select a Section before downloading.');
        }

        // Labels
        $sessionName = DB::table('tbl_session')->where('id', $session_id)->value('name') ?? 'Unknown';

        if ($grade_id === 'all') {
            $gradeName   = 'All Grades';
            $sectionName = 'All Sections';
        } else {
            $gradeName   = DB::table('tbl_grade')->where('id', $grade_id)->value('name') ?? '';
            $sectionName = $section_id === 'all'
                ? 'All Sections'
                : (DB::table('tbl_section')->where('id', $section_id)->value('name') ?? '');
        }

        $statusLabel = $status ?: 'All';

        // Fetch students
        $query = DB::table('tbl_promotion_log as pl')
            ->join('tbl_admission as a', 'a.id', '=', 'pl.student_id')
            ->leftJoin('tbl_session as s',   's.id',   '=', 'pl.from_session_id')
            ->leftJoin('tbl_grade as g',     'g.id',   '=', 'pl.from_grade_id')
            ->leftJoin('tbl_section as sec', 'sec.id', '=', 'pl.from_section_id')
            ->select(
                'a.admission_no',
                'a.roll_number',
                'a.first_name',
                'a.middle_name',
                'a.last_name',
                'a.nickname',
                'a.father_name',
                'a.mother_name',
                'a.phone',
                'a.contact',
                'a.email',
                'a.gender',
                'a.dob_ad',
                'a.dob_bs',
                'a.blood_group',
                'a.nationality',
                'a.religion',
                'a.ethnicity',
                'a.mother_tongue',
                'a.address',
                'a.city',
                'a.state',
                'a.pincode',
                'a.iemis_no',
                'a.admission_date',
                'a.status',
                's.name   as session_name',
                'g.name   as grade_name',
                'sec.name as section_name'
            )
            ->where('a.is_deleted', 0)
            ->where('pl.from_session_id', $session_id);

        if ($grade_id !== 'all') {
            $query->where('pl.from_grade_id', $grade_id);
            if ($section_id && $section_id !== 'all') {
                $query->where('pl.from_section_id', $section_id);
            }
        }

        if ($status) {
            $query->where('a.status', $status);
        }

        $students = $query
            ->orderBy('g.name')
            ->orderBy('sec.name')
            ->orderBy('a.roll_number')
            ->get();

        $headers = [
            '#',
            'Admission No', 'Roll No',
            'First Name', 'Middle Name', 'Last Name', 'Full Name', 'Nickname',
            'Father Name', 'Mother Name',
            'Gender', 'DOB (AD)', 'DOB (BS)', 'Blood Group',
            'Phone', 'Contact', 'Email',
            'Nationality', 'Religion', 'Ethnicity', 'Mother Tongue',
            'Address', 'City', 'State', 'Pincode',
            'IEMIS No', 'Admission Date', 'Current Status',
            'Session', 'Grade', 'Section',
        ];

        $rows = [];
        $i    = 1;
        foreach ($students as $s) {
            $fullName = trim(($s->first_name ?? '') . ' ' . ($s->middle_name ?? '') . ' ' . ($s->last_name ?? ''));
            $rows[] = [
                $i++,
                $s->admission_no   ?? '',
                $s->roll_number    ?? 'N/A',
                $s->first_name     ?? '',
                $s->middle_name    ?? '',
                $s->last_name      ?? '',
                $fullName,
                $s->nickname       ?? '',
                $s->father_name    ?? '',
                $s->mother_name    ?? '',
                $s->gender         ?? '',
                $s->dob_ad         ?? '',
                $s->dob_bs         ?? '',
                $s->blood_group    ?? '',
                $s->phone          ?? '',
                $s->contact        ?? '',
                $s->email          ?? '',
                $s->nationality    ?? '',
                $s->religion       ?? '',
                $s->ethnicity      ?? '',
                $s->mother_tongue  ?? '',
                $s->address        ?? '',
                $s->city           ?? '',
                $s->state          ?? '',
                $s->pincode        ?? '',
                $s->iemis_no       ?? '',
                $s->admission_date ?? '',
                $s->status         ?? '',
                $s->session_name   ?? '',
                $s->grade_name     ?? '',
                $s->section_name   ?? '',
            ];
        }

        $xlsx = new SimpleXlsx();
        $xlsx->addSheet('Historical Student Report', $rows, $headers, [
            'title'   => 'Historical Student Report'
                       . '  |  Session: ' . $sessionName
                       . '  |  Grade: '   . $gradeName
                       . '  |  Section: ' . $sectionName
                       . '  |  Status: '  . $statusLabel,
            'summary' => 'Total Students: ' . count($students),
        ]);

        $filename = 'Historical_Report_'
            . str_replace([' ', '/'], '_', $sessionName) . '_'
            . str_replace([' ', '/'], '_', $gradeName)   . '_'
            . str_replace([' ', '/'], '_', $sectionName) . '_'
            . str_replace([' ', '/'], '_', $statusLabel) . '_'
            . date('Ymd_His') . '.xlsx';

        return $xlsx->download($filename);
    }
}