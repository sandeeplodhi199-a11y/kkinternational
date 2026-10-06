<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\SimpleXlsx;

class StudentReportController extends Controller
{
    const STATUSES = ['Active', 'Inactive', 'Absconding', 'Left', 'Transfer'];

    // ─────────────────────────────────────────────────────────
    // GET  admin/student-report
    // ─────────────────────────────────────────────────────────
    public function student_report(Request $request)
    {
        $data['menu']    = 'students';
        $data['submenu'] = 'student_report';

        $session_id = $request->session_id;
        $grade_id   = $request->grade_id;    // 'all' or specific id
        $section_id = $request->section_id;  // 'all' or specific id (only used when grade_id != 'all')
        $status     = $request->status;      // '' (all) or specific status

        // Sessions
        $sessions = DB::table('tbl_session')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();

        // Grades
        $grades = DB::table('tbl_grade')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get();

        // Sections — only when a specific grade is selected (not 'all')
        $sections = collect();
        if ($grade_id && $grade_id !== 'all') {
            $sections = DB::table('tbl_section')
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->whereRaw('FIND_IN_SET(?, grade_id)', [$grade_id])
                ->orderBy('name')
                ->get();
        }

        // Determine if we have enough filters to fetch students:
        // - session must be selected
        // - grade must be selected (all or specific)
        // - if specific grade → section must also be selected (all or specific)
        // - if all grades → section is skipped, fetch directly
        $canFetch = false;
        if ($session_id && $grade_id) {
            if ($grade_id === 'all') {
                $canFetch = true;               // section not needed
            } elseif ($section_id) {
                $canFetch = true;               // specific grade needs section
            }
        }

        $students = collect();
        if ($canFetch) {
            $query = DB::table('tbl_admission')
                ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
                ->leftJoin('tbl_grade',   'tbl_grade.id',   '=', 'tbl_admission.grade_id')
                ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
                ->select(
                    'tbl_admission.id',
                    'tbl_admission.admission_no',
                    'tbl_admission.roll_number',
                    'tbl_admission.first_name',
                    'tbl_admission.middle_name',
                    'tbl_admission.last_name',
                    'tbl_admission.father_name',
                    'tbl_admission.mother_name',
                    'tbl_admission.phone',
                    'tbl_admission.contact',
                    'tbl_admission.email',
                    'tbl_admission.gender',
                    'tbl_admission.dob_ad',
                    'tbl_admission.dob_bs',
                    'tbl_admission.blood_group',
                    'tbl_admission.nationality',
                    'tbl_admission.religion',
                    'tbl_admission.ethnicity',
                    'tbl_admission.mother_tongue',
                    'tbl_admission.address',
                    'tbl_admission.city',
                    'tbl_admission.state',
                    'tbl_admission.pincode',
                    'tbl_admission.iemis_no',
                    'tbl_admission.nickname',
                    'tbl_admission.admission_date',
                    'tbl_admission.status',
                    'tbl_session.name as session_name',
                    'tbl_grade.name   as grade_name',
                    'tbl_section.name as section_name'
                )
                ->where('tbl_admission.is_deleted', 0)
                ->where('tbl_admission.session_id', $session_id);

            // Grade filter
            if ($grade_id !== 'all') {
                $query->where('tbl_admission.grade_id', $grade_id);

                // Section filter (only applicable for specific grade)
                if ($section_id && $section_id !== 'all') {
                    $query->where('tbl_admission.section_id', $section_id);
                }
            }
            // grade_id === 'all' → no grade/section filter at all

            // Status filter
            if ($status) {
                $query->where('tbl_admission.status', $status);
            }

            $students = $query
                ->orderBy('tbl_grade.name')
                ->orderBy('tbl_section.name')
                ->orderBy('tbl_admission.roll_number')
                ->get();
        }

        return view('backend.reports.student_report', compact(
            'students',
            'sessions', 'grades', 'sections',
            'session_id', 'grade_id', 'section_id', 'status',
            'data'
        ));
    }

    // ─────────────────────────────────────────────────────────
    // GET  admin/student-report/download
    // ─────────────────────────────────────────────────────────
    public function student_report_download(Request $request)
    {
        $session_id = $request->session_id;
        $grade_id   = $request->grade_id;
        $section_id = $request->section_id;
        $status     = $request->status;

        // Minimum: session + grade required
        if (!$session_id || !$grade_id) {
            return redirect()->route('student-report')
                ->with('error', 'Please select Session and Grade before downloading.');
        }
        // If specific grade, section is also required
        if ($grade_id !== 'all' && !$section_id) {
            return redirect()->route('student-report')
                ->with('error', 'Please select a Section before downloading.');
        }

        // Labels
        $sessionName = DB::table('tbl_session')->where('id', $session_id)->value('name') ?? 'All';

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
        $query = DB::table('tbl_admission')
            ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
            ->leftJoin('tbl_grade',   'tbl_grade.id',   '=', 'tbl_admission.grade_id')
            ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
            ->select(
                'tbl_admission.admission_no',
                'tbl_admission.roll_number',
                'tbl_admission.first_name',
                'tbl_admission.middle_name',
                'tbl_admission.last_name',
                'tbl_admission.father_name',
                'tbl_admission.mother_name',
                'tbl_admission.phone',
                'tbl_admission.contact',
                'tbl_admission.email',
                'tbl_admission.gender',
                'tbl_admission.dob_ad',
                'tbl_admission.dob_bs',
                'tbl_admission.blood_group',
                'tbl_admission.nationality',
                'tbl_admission.religion',
                'tbl_admission.ethnicity',
                'tbl_admission.mother_tongue',
                'tbl_admission.address',
                'tbl_admission.city',
                'tbl_admission.state',
                'tbl_admission.pincode',
                'tbl_admission.iemis_no',
                'tbl_admission.nickname',
                'tbl_admission.admission_date',
                'tbl_admission.status',
                'tbl_session.name as session_name',
                'tbl_grade.name   as grade_name',
                'tbl_section.name as section_name'
            )
            ->where('tbl_admission.is_deleted', 0)
            ->where('tbl_admission.session_id', $session_id);

        if ($grade_id !== 'all') {
            $query->where('tbl_admission.grade_id', $grade_id);
            if ($section_id && $section_id !== 'all') {
                $query->where('tbl_admission.section_id', $section_id);
            }
        }

        if ($status) {
            $query->where('tbl_admission.status', $status);
        }

        $students = $query
            ->orderBy('tbl_grade.name')
            ->orderBy('tbl_section.name')
            ->orderBy('tbl_admission.roll_number')
            ->get();

        // Excel headers
        $headers = [
            '#', 'Admission No', 'Roll No',
            'First Name', 'Middle Name', 'Last Name', 'Full Name', 'Nickname',
            'Father Name', 'Mother Name',
            'Gender', 'DOB (AD)', 'DOB (BS)', 'Blood Group',
            'Phone', 'Contact', 'Email',
            'Nationality', 'Religion', 'Ethnicity', 'Mother Tongue',
            'Address', 'City', 'State', 'Pincode',
            'IEMIS No', 'Admission Date',
            'Session', 'Grade', 'Section', 'Status',
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
                $s->session_name   ?? '',
                $s->grade_name     ?? '',
                $s->section_name   ?? '',
                $s->status         ?? '',
            ];
        }

        $xlsx = new SimpleXlsx();
        $xlsx->addSheet('Student Report', $rows, $headers, [
            'title'   => 'Student Report  |  Session: ' . $sessionName
                       . '  |  Grade: ' . $gradeName
                       . '  |  Section: ' . $sectionName
                       . '  |  Status: ' . $statusLabel,
            'summary' => 'Total Students: ' . count($students),
        ]);

        $filename = 'Student_Report_'
            . str_replace([' ', '/'], '_', $sessionName) . '_'
            . str_replace([' ', '/'], '_', $gradeName)   . '_'
            . str_replace([' ', '/'], '_', $sectionName) . '_'
            . str_replace([' ', '/'], '_', $statusLabel) . '_'
            . date('Ymd_His') . '.xlsx';

        return $xlsx->download($filename);
    }
}