<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherSyllabusController extends Controller
{
    /**
     * Main syllabus coverage page
     */
    public function syllabus_coverage()
    {
        $user = Auth::user();
        $data['menu']    = 'teachers1';
        $data['submenu'] = 'syllabus_coverage';

        $session = DB::table('tbl_session')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get();

        $teacherTblId = null;
        $grade        = collect();

        if ($user->type == 'teacher') {
            $userRecord = DB::table('users')
                ->where('id', $user->id)
                ->where('is_deleted', 0)
                ->first();

            if ($userRecord && $userRecord->teacher_id) {
                $teacherCode = $userRecord->teacher_id;

                $teacherRecord = DB::table('tbl_teacher')
                    ->where('teacher_id', $teacherCode)
                    ->where('is_deleted', 0)
                    ->first();

                if ($teacherRecord) {
                    $teacherTblId = $teacherRecord->id;

                    $gradeIds = DB::table('tbl_teacher_assign')
                        ->where('teacher_id', $teacherTblId)
                        ->pluck('grade_id')
                        ->unique()
                        ->toArray();

                    if (!empty($gradeIds)) {
                        $grade = DB::table('tbl_grade')
                            ->whereIn('id', $gradeIds)
                            ->where('status', 'Active')
                            ->where('is_deleted', 0)
                            ->orderBy('orders_by')
                            ->get();
                    }
                }
            }
        } else {
            $grade = DB::table('tbl_grade')
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->orderBy('orders_by')
                ->get();
        }

        return view('backend.teacher.syllabus_coverage',
            compact('data', 'session', 'grade', 'teacherTblId'));
    }

    /**
     * Get exams for a specific grade
     */
    public function getExams_syllabus($grade_id)
    {
        $exams = DB::table('tbl_exam')
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$grade_id])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->select('id', 'exam_name')
            ->get();

        return response()->json($exams);
    }

    /**
     * Get grades assigned to a teacher
     */
    public function getTeacherGrades($teacher_tbl_id)
    {
        $gradeIds = DB::table('tbl_teacher_assign')
            ->where('teacher_id', $teacher_tbl_id)
            ->pluck('grade_id')
            ->unique()
            ->toArray();

        $grades = DB::table('tbl_grade')
            ->whereIn('id', $gradeIds)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->select('id', 'name')
            ->get();

        return response()->json($grades);
    }

    /**
     * Get subjects for syllabus coverage (respects teacher assignments)
     */
    public function getSyllabusCoverageSubjects(Request $request)
    {
        $request->validate([
            'exam_id'  => 'required|integer',
            'grade_id' => 'required|integer'
        ]);

        $subjectIds = DB::table('tbl_exam_subject_marks')
            ->where('exam_id',  $request->exam_id)
            ->where('grade_id', $request->grade_id)
            ->where('is_deleted', 0)
            ->pluck('subject_id')
            ->unique()
            ->toArray();

        if (empty($subjectIds)) {
            return response()->json([]);
        }

        $user = Auth::user();

        if ($user->type == 'teacher') {
            $userRecord = DB::table('users')
                ->where('id', $user->id)
                ->where('is_deleted', 0)
                ->first();

            if ($userRecord && $userRecord->teacher_id) {
                $teacherRecord = DB::table('tbl_teacher')
                    ->where('teacher_id', $userRecord->teacher_id)
                    ->where('is_deleted', 0)
                    ->first();

                if ($teacherRecord) {
                    $teacherSubjectIds = DB::table('tbl_teacher_assign')
                        ->where('teacher_id', $teacherRecord->id)
                        ->where('grade_id',   $request->grade_id)
                        ->pluck('subject_id')
                        ->toArray();

                    $subjectIds = array_values(array_intersect($subjectIds, $teacherSubjectIds));
                } else {
                    return response()->json([]);
                }
            } else {
                return response()->json([]);
            }
        }

        if (empty($subjectIds)) {
            return response()->json([]);
        }

        $subjects = DB::table('tbl_subject')
            ->whereIn('id', $subjectIds)
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$request->grade_id])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->select('id', 'name as subject_name')
            ->orderBy('name')
            ->get();

        return response()->json($subjects);
    }

    /**
     * Get chapters for grade + subject
     */
  public function getChapters(Request $request)
{
    $request->validate([
        'grade_id'   => 'required|integer',
        'subject_id' => 'required|integer'
    ]);

    $chapters = DB::table('tbl_chapter')
        ->where('grade_id', $request->grade_id)
        ->where('subject_id', $request->subject_id)
        ->where('status', 'Active')
        ->where('is_deleted', 0)
        ->orderByRaw('CAST(chapter_no AS UNSIGNED) ASC')
        ->select('id', 'name', 'chapter_no', 'no_of_pages')
        ->get()
        ->map(function ($item) {
            $item->chapter_no = str_pad($item->chapter_no, 2, '0', STR_PAD_LEFT);
            return $item;
        });

    return response()->json($chapters);
}

    /**
     * Get existing coverage record
     */
    public function getSyllabusCoverageExisting(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer',
            'grade_id'   => 'required|integer',
            'exam_id'    => 'required|integer',
            'subject_id' => 'required|integer'
        ]);

        $rec = DB::table('tbl_exam_syllabus_coverages')
            ->where('session_id', $request->session_id)
            ->where('grade_id',   $request->grade_id)
            ->where('exam_id',    $request->exam_id)
            ->where('subject_id', $request->subject_id)
            ->first();

        return response()->json($rec ?? (object)[]);
    }

    /**
     * Save or update coverage record
     */
    public function saveSyllabusCoverage(Request $request)
    {
        $request->validate([
            'session_id'           => 'required|integer',
            'grade_id'             => 'required|integer',
            'exam_id'              => 'required|integer',
            'subject_id'           => 'required|integer',
            'selected_chapter_ids' => 'required|string',
            'covered_pages'        => 'required|integer|min:0',
            'total_pages'          => 'required|integer|min:1',
            'coverage_percent'     => 'required|integer|min:0|max:100'
        ]);

        $user = Auth::user();

        if ($user->type == 'teacher') {
            $userRecord = DB::table('users')
                ->where('id', $user->id)
                ->where('is_deleted', 0)
                ->first();

            if (!$userRecord || !$userRecord->teacher_id) {
                return response()->json(['success' => false, 'message' => 'Teacher not found!'], 404);
            }

            $teacherRecord = DB::table('tbl_teacher')
                ->where('teacher_id', $userRecord->teacher_id)
                ->where('is_deleted', 0)
                ->first();

            if (!$teacherRecord) {
                return response()->json(['success' => false, 'message' => 'Teacher record not found!'], 404);
            }

            $isAssigned = DB::table('tbl_teacher_assign')
                ->where('teacher_id', $teacherRecord->id)
                ->where('grade_id',   $request->grade_id)
                ->where('subject_id', $request->subject_id)
                ->exists();

            if (!$isAssigned) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to add coverage for this grade/subject!'
                ], 403);
            }
        }

        // Validate chapter IDs belong to this grade + subject
        $chapterIds = array_filter(array_map('intval', explode(',', $request->selected_chapter_ids)));

        if (empty($chapterIds)) {
            return response()->json(['success' => false, 'message' => 'No chapters selected!'], 400);
        }

        $validCount = DB::table('tbl_chapter')
            ->whereIn('id', $chapterIds)
            ->where('grade_id',   $request->grade_id)
            ->where('subject_id', $request->subject_id)
            ->count();

        if ($validCount !== count($chapterIds)) {
            return response()->json(['success' => false, 'message' => 'Invalid chapters selected!'], 400);
        }

        $existing = DB::table('tbl_exam_syllabus_coverages')
            ->where('session_id', $request->session_id)
            ->where('grade_id',   $request->grade_id)
            ->where('exam_id',    $request->exam_id)
            ->where('subject_id', $request->subject_id)
            ->first();

        $payload = [
            'selected_chapter_ids' => implode(',', $chapterIds),
            'covered_pages'        => $request->covered_pages,
            'total_pages'          => $request->total_pages,
            'coverage_percent'     => $request->coverage_percent,
            'update_id'            => $user->id,
            'updated_at'           => now(),
        ];

        if ($existing) {
            DB::table('tbl_exam_syllabus_coverages')
                ->where('id', $existing->id)
                ->update($payload);

            return response()->json([
                'success'   => true,
                'message'   => '✅ Syllabus coverage updated successfully!',
                'is_update' => true
            ]);
        } else {
            DB::table('tbl_exam_syllabus_coverages')->insert(array_merge($payload, [
                'session_id' => $request->session_id,
                'grade_id'   => $request->grade_id,
                'exam_id'    => $request->exam_id,
                'subject_id' => $request->subject_id,
                'add_id'     => $user->id,
                'created_at' => now(),
            ]));

            return response()->json([
                'success'   => true,
                'message'   => '✅ Syllabus coverage saved successfully!',
                'is_update' => false
            ]);
        }
    }

    /**
     * Get report data with teacher filter
     */
    public function getSyllabusCoverageReport(Request $request)
    {
        $user = Auth::user();

        $q = DB::table('tbl_exam_syllabus_coverages as c')
            ->join('tbl_grade as g',   'g.id', '=', 'c.grade_id')
            ->join('tbl_exam as e',    'e.id', '=', 'c.exam_id')
            ->join('tbl_subject as s', 's.id', '=', 'c.subject_id')
            ->leftJoin('users as u_add', 'u_add.id', '=', 'c.add_id')
            ->leftJoin('users as u_upd', 'u_upd.id', '=', 'c.update_id')
            ->select(
                'g.name as grade_name',
                'e.exam_name',
                's.name as subject_name',
                'c.selected_chapter_ids',
                'c.covered_pages',
                'c.total_pages',
                'c.coverage_percent',
                DB::raw("CASE
                    WHEN c.add_id = c.update_id OR c.update_id IS NULL THEN u_add.name
                    ELSE CONCAT(u_add.name, ' → ', u_upd.name)
                END as mapped_by")
            );

        if ($user->type == 'teacher') {
            $userRecord = DB::table('users')
                ->where('id', $user->id)
                ->where('is_deleted', 0)
                ->first();

            if ($userRecord && $userRecord->teacher_id) {
                $teacherRecord = DB::table('tbl_teacher')
                    ->where('teacher_id', $userRecord->teacher_id)
                    ->where('is_deleted', 0)
                    ->first();

                if ($teacherRecord) {
                    $userIds = DB::table('users')
                        ->where('teacher_id', $userRecord->teacher_id)
                        ->where('is_deleted', 0)
                        ->pluck('id')
                        ->toArray();

                    if (!empty($userIds)) {
                        $q->whereIn('c.add_id', $userIds);
                    } else {
                        return response()->json([]);
                    }
                } else {
                    return response()->json([]);
                }
            } else {
                return response()->json([]);
            }
        }

        if ($request->filled('session_id')) $q->where('c.session_id', $request->session_id);
        if ($request->filled('grade_id'))   $q->where('c.grade_id',   $request->grade_id);
        if ($request->filled('exam_id'))    $q->where('c.exam_id',    $request->exam_id);

        $result = $q->orderBy('g.name')
            ->orderBy('e.exam_name')
            ->orderBy('s.name')
            ->get();

        // Attach chapter names for display
        $result->transform(function ($row) {
            if (!empty($row->selected_chapter_ids)) {
                $ids = array_filter(array_map('intval', explode(',', $row->selected_chapter_ids)));
                $chapters = DB::table('tbl_chapter')
                    ->whereIn('id', $ids)
                    ->orderBy('chapter_no')
                    ->get(['chapter_no', 'name']);
                $row->chapters_display = $chapters
                    ->map(fn($c) => "Ch {$c->chapter_no} - {$c->name}")
                    ->implode(' | ');
            } else {
                $row->chapters_display = '—';
            }
            return $row;
        });

        return response()->json($result);
    }
}