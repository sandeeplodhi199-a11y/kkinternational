<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['menu']    = 'dashboard';
        $data['submenu'] = '';

        $user = Auth::user();

        if ($user->type === 'teacher') {
            return $this->teacherDashboard($data, $user);
        }

        $today = Carbon::today();
        $year  = $today->year;

        /* ─────────────────────────────────────────────
         | ACTIVE SESSION — fetched first so $sid is
         | available for all tbl_admission queries below.
         | tbl_admission.session_id is VARCHAR so we
         | cast to string to avoid type-mismatch.
         ───────────────────────────────────────────── */
        $activeSession = DB::table('tbl_session')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderByDesc('id')
            ->first();

        // (string) cast because tbl_admission.session_id = varchar(255)
        $sid = $activeSession ? (string) $activeSession->id : null;

        /* ─────────────────────────────────────────────
         | CORE COUNTERS
         ───────────────────────────────────────────── */
        $activeStudents = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $inactiveStudents = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->whereIn('status', ['Inactive', 'Left', 'Absconding', 'Transfer'])
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $newStudentsMonth = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->whereMonth('created_at', $today->month)
            ->whereYear('created_at', $year)
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $newStudentsToday = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->whereDate('created_at', $today)
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $activeTeachers = DB::table('tbl_teacher')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->count();

        // FIX: Use BINARY-safe case-insensitive gender matching via LOWER()
        // Also count NULL/empty as neither gender to avoid wrong totals
        $maleStudents = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->whereNotNull('gender')
            ->where('gender', '!=', '')
            ->whereRaw("LOWER(TRIM(gender)) = 'male'")
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $femaleStudents = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->whereNotNull('gender')
            ->where('gender', '!=', '')
            ->whereRaw("LOWER(TRIM(gender)) = 'female'")
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        // FIX: Students with gender not filled — shown separately in dashboard
        $genderUnknownStudents = DB::table('tbl_admission')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('gender')->orWhere('gender', '');
            })
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->count();

        $maleTeachers = DB::table('tbl_teacher')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->whereNotNull('gender')
            ->where('gender', '!=', '')
            ->whereRaw("LOWER(TRIM(gender)) = 'male'")
            ->count();

        $femaleTeachers = DB::table('tbl_teacher')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->whereNotNull('gender')
            ->where('gender', '!=', '')
            ->whereRaw("LOWER(TRIM(gender)) = 'female'")
            ->count();

        $marksEntries   = DB::table('tbl_student_marks')->where('is_deleted', 0)->count();
        $markedStudents = DB::table('tbl_student_marks')->where('is_deleted', 0)->distinct('student_id')->count('student_id');
        $transferCerts  = DB::table('tbl_transfer_certificate')->count();
        $promotions     = DB::table('tbl_promotion_log')->count();
        $grades         = DB::table('tbl_grade')->where('is_deleted', 0)->count();
        $sections       = DB::table('tbl_section')->where('is_deleted', 0)->count();
        $sessions       = DB::table('tbl_session')->where('is_deleted', 0)->count();
        $subjects       = DB::table('tbl_subject')->where('is_deleted', 0)->count();
        $totalChapters  = DB::table('tbl_chapter')->where('is_deleted', 0)->where('status', 'Active')->count();
        $exams          = DB::table('tbl_exam')->where('is_deleted', 0)->count();

        /* ─────────────────────────────────────────────
         | TODAY'S ACTIVITY STATS
         ───────────────────────────────────────────── */
        $marksToday = DB::table('tbl_student_marks')
            ->where('is_deleted', 0)
            ->whereDate('created_at', $today)
            ->count();

        $transfersToday = DB::table('tbl_transfer_certificate')
            ->whereDate('created_at', $today)
            ->count();

        /* ─────────────────────────────────────────────
         | MONTHLY CHART DATA
         ───────────────────────────────────────────── */
        $monthlyStudentsRaw = DB::table('tbl_admission')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('is_deleted', 0)
            ->when($sid, fn($q) => $q->where('session_id', $sid))
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyMarksRaw = DB::table('tbl_student_marks')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('is_deleted', 0)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyTransfersRaw = DB::table('tbl_transfer_certificate')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        $monthly_students  = [];
        $monthly_marks     = [];
        $monthly_transfers = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthly_students[]  = $monthlyStudentsRaw[$i]  ?? 0;
            $monthly_marks[]     = $monthlyMarksRaw[$i]     ?? 0;
            $monthly_transfers[] = $monthlyTransfersRaw[$i] ?? 0;
        }

        /* ─────────────────────────────────────────────
         | GRADE DISTRIBUTION
         | FIX: Removed hard limit(14) — show all grades
         ───────────────────────────────────────────── */
        $gradeDistribution = DB::table('tbl_admission')
            ->leftJoin('tbl_grade', 'tbl_admission.grade_id', '=', 'tbl_grade.id')
            ->selectRaw("COALESCE(tbl_grade.name, CONCAT('Grade ', tbl_admission.grade_id)) as grade_name, COUNT(*) as total")
            ->where('tbl_admission.is_deleted', 0)
            ->where('tbl_admission.status', 'Active')
            ->when($sid, fn($q) => $q->where('tbl_admission.session_id', $sid))
            ->groupBy('tbl_admission.grade_id', 'tbl_grade.name')
            ->orderBy('tbl_grade.orders_by')
            ->get();

        /* ─────────────────────────────────────────────
         | EXAM PERFORMANCE (avg marks per exam)
         ───────────────────────────────────────────── */
        $examPerformance = DB::table('tbl_student_marks')
            ->join('tbl_exam', 'tbl_student_marks.exam_id', '=', 'tbl_exam.id')
            ->selectRaw('
                tbl_exam.exam_name,
                ROUND(AVG(tbl_student_marks.obtained_mark), 2) as avg_marks,
                ROUND(AVG(CASE WHEN tbl_student_marks.max_mark > 0 THEN tbl_student_marks.max_mark ELSE NULL END), 2) as avg_max,
                COUNT(DISTINCT tbl_student_marks.student_id) as student_count
            ')
            ->where('tbl_student_marks.is_deleted', 0)
            ->where('tbl_exam.is_deleted', 0)
            ->groupBy('tbl_student_marks.exam_id', 'tbl_exam.exam_name')
            ->orderByDesc('student_count')
            ->limit(6)
            ->get();

        /* ─────────────────────────────────────────────
         | GENDER CHART DATA
         ───────────────────────────────────────────── */
        $genderData = [
            'male_students'           => $maleStudents,
            'female_students'         => $femaleStudents,
            'gender_unknown_students' => $genderUnknownStudents,
            'male_teachers'           => $maleTeachers,
            'female_teachers'         => $femaleTeachers,
        ];

        /* ─────────────────────────────────────────────
         | SUBJECT WISE MARKS (Top subjects by entries)
         ───────────────────────────────────────────── */
        $subjectMarks = DB::table('tbl_student_marks')
            ->join('tbl_subject', 'tbl_student_marks.subject_id', '=', 'tbl_subject.id')
            ->selectRaw('tbl_subject.name as subject_name, COUNT(*) as total_entries')
            ->where('tbl_student_marks.is_deleted', 0)
            ->groupBy('tbl_student_marks.subject_id', 'tbl_subject.name')
            ->orderByDesc('total_entries')
            ->limit(10)
            ->get();

        /* ─────────────────────────────────────────────
         | RECENT STUDENTS
         ───────────────────────────────────────────── */
        $recentStudents = DB::table('tbl_admission')
            ->leftJoin('tbl_grade',   'tbl_admission.grade_id',   '=', 'tbl_grade.id')
            ->leftJoin('tbl_section', 'tbl_admission.section_id', '=', 'tbl_section.id')
            ->select(
                'tbl_admission.id',
                'tbl_admission.first_name',
                'tbl_admission.middle_name',
                'tbl_admission.last_name',
                'tbl_admission.admission_no',
                'tbl_admission.status',
                'tbl_admission.created_at',
                'tbl_grade.name as grade_name',
                'tbl_section.name as section_name'
            )
            ->where('tbl_admission.is_deleted', 0)
            ->when($sid, fn($q) => $q->where('tbl_admission.session_id', $sid))
            ->orderByDesc('tbl_admission.created_at')
            ->limit(8)
            ->get();

        /* ─────────────────────────────────────────────
         | RECENT TEACHERS
         ───────────────────────────────────────────── */
        $recentTeachers = DB::table('tbl_teacher')
            ->select('id_hash', 'teacher_id', 'name', 'gender', 'phone', 'status', 'created_at')
            ->where('is_deleted', 0)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        /* ─────────────────────────────────────────────
         | RECENT MARKS
         | FIX: Added NULLIF for avg_percent calculation safety
         ───────────────────────────────────────────── */
        $recentMarks = DB::table('tbl_student_marks')
            ->leftJoin('tbl_admission', 'tbl_student_marks.student_id', '=', 'tbl_admission.id')
            ->leftJoin('tbl_exam',      'tbl_student_marks.exam_id',    '=', 'tbl_exam.id')
            ->selectRaw("
                tbl_student_marks.student_id,
                TRIM(CONCAT_WS(' ',
                    NULLIF(tbl_admission.first_name,''),
                    NULLIF(tbl_admission.middle_name,''),
                    NULLIF(tbl_admission.last_name,'')
                )) as student_name,
                tbl_exam.exam_name,
                COUNT(tbl_student_marks.id) as subjects,
                ROUND(
                    AVG(
                        CASE
                            WHEN tbl_student_marks.max_mark > 0
                            THEN (tbl_student_marks.obtained_mark / tbl_student_marks.max_mark) * 100
                            ELSE NULL
                        END
                    ), 1
                ) as avg_percent,
                MAX(tbl_student_marks.updated_at) as updated_at
            ")
            ->where('tbl_student_marks.is_deleted', 0)
            ->groupBy(
                'tbl_student_marks.student_id',
                'tbl_student_marks.exam_id',
                'tbl_admission.first_name',
                'tbl_admission.middle_name',
                'tbl_admission.last_name',
                'tbl_exam.exam_name'
            )
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        /* ─────────────────────────────────────────────
         | SECTION WISE STUDENT COUNT
         | FIX 1: Removed limit(10) — was cutting off 32 out of 42 combos
         | FIX 2: Order by grade orders_by first, then section name
         |        so results are logically grouped by class
         ───────────────────────────────────────────── */
        $sectionWise = DB::table('tbl_admission')
            ->leftJoin('tbl_grade',   'tbl_admission.grade_id',   '=', 'tbl_grade.id')
            ->leftJoin('tbl_section', 'tbl_admission.section_id', '=', 'tbl_section.id')
            ->selectRaw("
                tbl_admission.grade_id,
                tbl_admission.section_id,
                COALESCE(tbl_grade.name, CONCAT('Grade ', tbl_admission.grade_id)) as grade_name,
                COALESCE(tbl_section.name, CONCAT('Sec ', tbl_admission.section_id)) as section_name,
                CONCAT(
                    COALESCE(tbl_grade.name, CONCAT('Grade ', tbl_admission.grade_id)),
                    ' - ',
                    COALESCE(tbl_section.name, CONCAT('Sec ', tbl_admission.section_id))
                ) as label,
                COUNT(*) as total
            ")
            ->where('tbl_admission.is_deleted', 0)
            ->where('tbl_admission.status', 'Active')
            ->when($sid, fn($q) => $q->where('tbl_admission.session_id', $sid))
            ->groupBy(
                'tbl_admission.grade_id',
                'tbl_admission.section_id',
                'tbl_grade.name',
                'tbl_section.name',
                'tbl_grade.orders_by'
            )
            ->orderBy('tbl_grade.orders_by')
            ->orderBy('tbl_section.orders_by')
            ->orderBy('tbl_section.name')
            ->get();

        /* ─────────────────────────────────────────────
         | TEACHER ASSIGNMENT STATUS
         ───────────────────────────────────────────── */
        $teacherAssigned = DB::table('tbl_teacher_assign')
            ->distinct('teacher_id')
            ->count('teacher_id');

        $teacherUnassigned = max(0, $activeTeachers - $teacherAssigned);

        /* ─────────────────────────────────────────────
         | SYLLABUS PROGRESS
         ───────────────────────────────────────────── */
        $completedChapters = 0;
        if (Schema::hasTable('tbl_teacher_chapter_status')) {
            $completedChapters = DB::table('tbl_teacher_chapter_status')
                ->where('status', 'completed')
                ->distinct('chapter_id')
                ->count('chapter_id');
        }
        $syllabusProgress = $totalChapters > 0
            ? round(($completedChapters / $totalChapters) * 100)
            : 0;

        /* ─────────────────────────────────────────────
         | PACK DASHBOARD ARRAY
         ───────────────────────────────────────────── */
        $dashboard = [
            'active_students'          => $activeStudents,
            'inactive_students'        => $inactiveStudents,
            'new_students_month'       => $newStudentsMonth,
            'new_students_today'       => $newStudentsToday,
            'teachers'                 => $activeTeachers,
            'teacher_assigned'         => $teacherAssigned,
            'teacher_unassigned'       => $teacherUnassigned,
            'grades'                   => $grades,
            'sections'                 => $sections,
            'sessions'                 => $sessions,
            'subjects'                 => $subjects,
            'chapters'                 => $totalChapters,
            'completed_chapters'       => $completedChapters,
            'syllabus_progress'        => $syllabusProgress,
            'exams'                    => $exams,
            'marks_entries'            => $marksEntries,
            'marked_students'          => $markedStudents,
            'marks_today'              => $marksToday,
            'transfer_certificates'    => $transferCerts,
            'transfers_today'          => $transfersToday,
            'promotions'               => $promotions,
            'male_students'            => $maleStudents,
            'female_students'          => $femaleStudents,
            'gender_unknown_students'  => $genderUnknownStudents,
        ];

        return view('dashboard', compact(
            'data',
            'dashboard',
            'activeSession',
            'gradeDistribution',
            'sectionWise',
            'examPerformance',
            'subjectMarks',
            'genderData',
            'monthly_students',
            'monthly_marks',
            'monthly_transfers',
            'recentStudents',
            'recentTeachers',
            'recentMarks'
        ));
    }

    /* ─────────────────────────────────────────────
     | HELPER: active count
     ───────────────────────────────────────────── */
    private function activeCount(string $table): int
    {
        return DB::table($table)
            ->where('is_deleted', 0)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 'Active');
            })
            ->count();
    }

    /* ─────────────────────────────────────────────
     | TEACHER DASHBOARD (FIXED)
     ───────────────────────────────────────────── */
    private function teacherDashboard(array $data, $user)
    {
        $teacher = DB::table('tbl_teacher')
            ->where('teacher_id', $user->teacher_id)
            ->where('is_deleted', 0)
            ->first();

        $activeSession = DB::table('tbl_session')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderByDesc('id')
            ->first();

        // (string) cast because tbl_admission.session_id = varchar(255)
        $sid = $activeSession ? (string) $activeSession->id : null;

        $assignments        = collect();
        $teacherRecentMarks = collect();
        $teacherCoverages   = collect();
        $teacherStats = [
            'classes'            => 0,
            'sections'           => 0,
            'subjects'           => 0,
            'students'           => 0,
            'chapters'           => 0,
            'completed_chapters' => 0,
            'chapter_progress'   => 0,
            'marks_entries'      => 0,
            'coverage_plans'     => 0,
        ];

        if ($teacher) {
            $assignments = DB::table('tbl_teacher_assign as ta')
                ->leftJoin('tbl_grade as g',    'g.id',   '=', 'ta.grade_id')
                ->leftJoin('tbl_section as sec', 'sec.id', '=', 'ta.section_id')
                ->leftJoin('tbl_subject as sub', 'sub.id', '=', 'ta.subject_id')
                ->where('ta.teacher_id', $teacher->id)
                ->select(
                    'ta.grade_id', 'ta.section_id', 'ta.subject_id',
                    'g.name as grade_name',
                    'sec.name as section_name',
                    'sub.name as subject_name'
                )
                ->distinct()
                ->orderBy('g.orders_by')
                ->orderBy('sec.name')
                ->orderBy('sub.name')
                ->get();

            $chapterAssignments = $assignments
                ->unique(fn($a) => ($a->grade_id ?? '') . '-' . ($a->subject_id ?? ''))
                ->values();

            // tbl_admission student count — scoped to current session
            $studentQuery = DB::table('tbl_admission')
                ->where('is_deleted', 0)
                ->where('status', 'Active')
                ->when($sid, fn($q) => $q->where('session_id', $sid));

            $this->applyAssignmentScope($studentQuery, $assignments, [
                'tbl_admission.grade_id'   => 'grade_id',
                'tbl_admission.section_id' => 'section_id',
            ]);

            $chapterQuery = DB::table('tbl_chapter')
                ->where('is_deleted', 0)
                ->where('status', 'Active');
            $this->applyAssignmentScope($chapterQuery, $chapterAssignments, [
                'tbl_chapter.grade_id'   => 'grade_id',
                'tbl_chapter.subject_id' => 'subject_id',
            ]);

            $marksQuery = DB::table('tbl_student_marks')->where('is_deleted', 0);
            $this->applyAssignmentScope($marksQuery, $assignments, [
                'tbl_student_marks.grade_id'   => 'grade_id',
                'tbl_student_marks.section_id' => 'section_id',
                'tbl_student_marks.subject_id' => 'subject_id',
            ]);

            $completedChapters = 0;
            if (Schema::hasTable('tbl_teacher_chapter_status')) {
                $completedChapters = DB::table('tbl_teacher_chapter_status')
                    ->where('teacher_id', $teacher->id)
                    ->where('status', 'completed')
                    ->distinct('chapter_id')
                    ->count('chapter_id');
            }
            $totalChapters = (clone $chapterQuery)->distinct('id')->count('id');

            // FIX: Coverage plans — tbl_teacher doesn't have grade_id column.
            // Use teacher's assignment grade_ids instead.
            $assignedGradeIds   = $assignments->pluck('grade_id')->filter()->unique()->values()->toArray();
            $assignedSubjectIds = $assignments->pluck('subject_id')->filter()->unique()->values()->toArray();

            $coveragePlans = 0;
            if (Schema::hasTable('tbl_exam_syllabus_coverages') && !empty($assignedGradeIds)) {
                $coveragePlans = DB::table('tbl_exam_syllabus_coverages')
                    ->whereIn('grade_id', $assignedGradeIds)
                    ->when(!empty($assignedSubjectIds), fn($q) => $q->whereIn('subject_id', $assignedSubjectIds))
                    ->count();
            }

            $teacherStats = [
                'classes'            => $assignments->pluck('grade_id')->filter()->unique()->count(),
                'sections'           => $assignments->pluck('section_id')->filter()->unique()->count(),
                'subjects'           => $assignments->pluck('subject_id')->filter()->unique()->count(),
                'students'           => $studentQuery->distinct('tbl_admission.id')->count('tbl_admission.id'),
                'chapters'           => $totalChapters,
                'completed_chapters' => $completedChapters,
                'chapter_progress'   => $totalChapters > 0
                    ? round(($completedChapters / $totalChapters) * 100, 1)
                    : 0,
                'marks_entries'      => $marksQuery->count(),
                'coverage_plans'     => $coveragePlans,
            ];

            $teacherRecentMarksQuery = DB::table('tbl_student_marks as m')
                ->leftJoin('tbl_admission as a', 'm.student_id', '=', 'a.id')
                ->leftJoin('tbl_exam as e',      'm.exam_id',    '=', 'e.id')
                ->leftJoin('tbl_subject as s',   'm.subject_id', '=', 's.id')
                ->selectRaw("
                    m.student_id,
                    TRIM(CONCAT_WS(' ',
                        NULLIF(a.first_name,''),
                        NULLIF(a.middle_name,''),
                        NULLIF(a.last_name,'')
                    )) as student_name,
                    e.exam_name,
                    s.name as subject_name,
                    m.obtained_mark,
                    m.max_mark,
                    m.updated_at
                ")
                ->where('m.is_deleted', 0);

            $this->applyAssignmentScope($teacherRecentMarksQuery, $assignments, [
                'm.grade_id'   => 'grade_id',
                'm.section_id' => 'section_id',
                'm.subject_id' => 'subject_id',
            ]);

            $teacherRecentMarks = $teacherRecentMarksQuery
                ->orderByDesc('m.updated_at')
                ->limit(8)
                ->get();

            // Syllabus coverages — scoped to teacher's assigned grades & subjects
            if (Schema::hasTable('tbl_exam_syllabus_coverages') && !empty($assignedGradeIds)) {
                $coverages = DB::table('tbl_exam_syllabus_coverages as c')
                    ->join('tbl_session as se', 'se.id', '=', 'c.session_id')
                    ->join('tbl_exam as e',     'e.id',  '=', 'c.exam_id')
                    ->join('tbl_grade as g',    'g.id',  '=', 'c.grade_id')
                    ->join('tbl_subject as s',  's.id',  '=', 'c.subject_id')
                    ->select(
                        'se.name as session_name',
                        'e.exam_name',
                        'g.name as grade_name',
                        's.name as subject_name',
                        'c.selected_chapter_ids',
                        'c.covered_pages',
                        'c.total_pages',
                        'c.coverage_percent',
                        'c.created_at',
                        'c.updated_at'
                    )
                    ->whereIn('c.grade_id', $assignedGradeIds)
                    ->when(!empty($assignedSubjectIds), fn($q) => $q->whereIn('c.subject_id', $assignedSubjectIds))
                    ->orderByDesc('c.updated_at')
                    ->limit(8)
                    ->get();

                $teacherCoverages = $coverages->map(function ($coverage) {
                    // FIX: selected_chapter_ids may be comma-separated OR JSON-encoded
                    $raw = $coverage->selected_chapter_ids ?? '';
                    if (str_starts_with(trim($raw), '[')) {
                        // JSON array
                        $chapterIds = array_filter(json_decode($raw, true) ?? []);
                    } else {
                        $chapterIds = array_filter(explode(',', $raw));
                    }
                    $chapterIds = array_map('intval', $chapterIds);

                    if (!empty($chapterIds)) {
                        $chapters = DB::table('tbl_chapter')
                            ->whereIn('id', $chapterIds)
                            ->where('is_deleted', 0)
                            ->select('id', 'chapter_no', 'name')
                            ->orderBy('chapter_no')
                            ->get();

                        $coverage->chapters      = $chapters;
                        $coverage->chapter_count = count($chapterIds);
                        $coverage->chapter_names = $chapters->pluck('name')->implode(', ');
                        $coverage->chapter_range = $chapters->isNotEmpty()
                            ? 'Ch. ' . $chapters->first()->chapter_no . ' – ' . $chapters->last()->chapter_no
                            : 'No chapters';
                        $coverage->first_chapter = $chapters->first()->chapter_no ?? 'N/A';
                        $coverage->last_chapter  = $chapters->last()->chapter_no  ?? 'N/A';
                    } else {
                        $coverage->chapters      = collect();
                        $coverage->chapter_count = 0;
                        $coverage->chapter_names = 'No chapters selected';
                        $coverage->chapter_range = 'N/A';
                        $coverage->first_chapter = 'N/A';
                        $coverage->last_chapter  = 'N/A';
                    }

                    // FIX: Ensure coverage_percent is always numeric (never null)
                    $coverage->coverage_percent = (int) ($coverage->coverage_percent ?? 0);

                    return $coverage;
                });
            }
        }

        return view('dashboard', compact(
            'data', 'teacher', 'activeSession', 'assignments',
            'teacherStats', 'teacherRecentMarks', 'teacherCoverages'
        ));
    }

    /* ─────────────────────────────────────────────
     | HELPER: Apply assignment scope to query
     ───────────────────────────────────────────── */
    private function applyAssignmentScope($query, $assignments, array $columns): void
    {
        if ($assignments->isEmpty()) {
            $query->whereRaw('1 = 0');
            return;
        }
        $query->where(function ($scope) use ($assignments, $columns) {
            foreach ($assignments as $assignment) {
                $scope->orWhere(function ($row) use ($assignment, $columns) {
                    foreach ($columns as $column => $property) {
                        $value = $assignment->{$property} ?? null;
                        if ($value !== null) {
                            $row->where($column, $value);
                        }
                    }
                });
            }
        });
    }

    /* ─────────────────────────────────────────────
     | VOICE / SEARCH API
     ───────────────────────────────────────────── */
    public function voiceSearch()
    {
        $query = trim((string) request()->query('query', ''));
        if ($query === '') return response()->json([]);

        $results = [];

        $students = DB::table('tbl_admission')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'admission_no')
            ->where('is_deleted', 0)
            ->where(function ($q) use ($query) {
                $q->where('first_name',    'like', "%{$query}%")
                  ->orWhere('middle_name', 'like', "%{$query}%")
                  ->orWhere('last_name',   'like', "%{$query}%")
                  ->orWhere('admission_no','like', "%{$query}%");
            })
            ->limit(6)
            ->get();

        foreach ($students as $s) {
            $results[] = [
                'name' => trim(
                    ($s->first_name  ?? '') . ' ' .
                    ($s->middle_name ?? '') . ' ' .
                    ($s->last_name   ?? '')
                ),
                'type' => 'Student',
                'url'  => url('admin/student-edit/' . ($s->id ?? '')),
            ];
        }

        if (Auth::user()->type !== 'teacher') {
            $teachers = DB::table('tbl_teacher')
                ->select('id_hash', 'teacher_id', 'name')
                ->where('is_deleted', 0)
                ->where(function ($q) use ($query) {
                    $q->where('name',        'like', "%{$query}%")
                      ->orWhere('teacher_id', 'like', "%{$query}%");
                })
                ->limit(4)
                ->get();

            foreach ($teachers as $t) {
                $results[] = [
                    'name' => $t->name ?? '',
                    'type' => 'Teacher',
                    'url'  => url('admin/edit-teacher/' . ($t->id_hash ?? '')),
                ];
            }
        }

        return response()->json($results);
    }
}