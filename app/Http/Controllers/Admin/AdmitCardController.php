<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdmitCardController extends Controller
{
    /**
     * Display the admit card generator page
     */
    public function admit_card()
    {
        $data['menu']    = 'categorys1';
        $data['submenu'] = 'admitcard';
        
        $sessions = DB::table('tbl_session')
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get();
            
       $general = DB::table('tbl_general')->where('id',1)->first();        

        return view('backend.admit_card.index', compact('sessions', 'data','general'));
    }

    /**
     * Get grades for a specific session (AJAX)
     */
    public function getGrades($sessionId)
    {
        $grades = DB::table('tbl_grade as g')
            ->join('tbl_admission as a', 'a.grade_id', '=', 'g.id')
            ->where('a.session_id', $sessionId)
            ->where('a.status', 'Active')
            ->where('a.is_deleted', 0)
            ->where('g.status', 'Active')
            ->where('g.is_deleted', 0)
            ->select('g.id', 'g.name')
            ->distinct()
            ->orderBy('g.orders_by')
            ->get();

        return response()->json($grades);
    }

    /**
     * Get sections for a specific grade (AJAX)
     */
    public function getSections($gradeId)
    {
        $sections = DB::table('tbl_section')
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$gradeId])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get(['id', 'name']);

        return response()->json($sections);
    }

    /**
     * Get exams for a specific grade (AJAX)
     */
    public function getExams($gradeId)
    {
        $exams = DB::table('tbl_exam')
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$gradeId])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by')
            ->get(['id', 'exam_name', 'start_date', 'end_date']);

        return response()->json($exams);
    }

    /**
     * Preview students count (AJAX)
     */
    public function previewStudents(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer',
            'grade_id'   => 'required|integer',
            'section_id' => 'required|integer',
            'exam_id'    => 'required|integer',
        ]);

        $count = $this->getStudentsQuery(
            $request->session_id,
            $request->grade_id,
            $request->section_id
        )->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Preview admit cards data (AJAX) — returns students + exam info for JS rendering
     */
    public function previewAdmitCards(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer',
            'grade_id'   => 'required|integer',
            'section_id' => 'required|integer',
            'exam_id'    => 'required|integer',
        ]);

        $exam = DB::table('tbl_exam')
            ->where('id', $request->exam_id)
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$request->grade_id])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        if (!$exam) {
            return response()->json(['error' => 'Exam not found.'], 404);
        }

        $students = $this->getStudentsQuery(
            $request->session_id,
            $request->grade_id,
            $request->section_id
        )->get();

        return response()->json([
            'count'    => $students->count(),
            'exam'     => [
                'name'       => $exam->exam_name,
                'start_date' => $exam->start_date,
                'end_date'   => $exam->end_date,
            ],
            'students' => $students->map(fn($s) => [
                'full_name'    => trim($s->full_name),
                'grade_name'   => $s->grade_name,
                'section_name' => $s->section_name,
                'roll_number'  => $s->roll_number ?? '',
            ])->values(),
        ]);
    }

    /**
     * Download bulk admit cards PDF
     */
    public function downloadAdmitCards(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer',
            'grade_id'   => 'required|integer',
            'section_id' => 'required|integer',
            'exam_id'    => 'required|integer',
        ]);

        $exam = DB::table('tbl_exam')
            ->where('id', $request->exam_id)
            ->whereRaw('FIND_IN_SET(?, grade_id)', [$request->grade_id])
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        if (!$exam) {
            return back()->with('error', 'Exam not found.');
        }

        $grade = DB::table('tbl_grade')
            ->where('id', $request->grade_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        $section = DB::table('tbl_section')
            ->where('id', $request->section_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        $students = $this->getStudentsQuery(
            $request->session_id,
            $request->grade_id,
            $request->section_id
        )->get();
        
        

        if ($students->isEmpty()) {
            return back()->with('error', 'No students found for the selected criteria.');
        }
        
        

        $chunks = $students->chunk(8);
        
        
        $general = DB::table('tbl_general')->where('id',1)->first();      

        $pdf = Pdf::loadView('backend.admit_card.pdf', [
            'chunks'  => $chunks,
            'exam'    => $exam,
            'grade'   => $grade,
            'section' => $section,
            'general'  => $general,
        ])->setPaper('a4', 'portrait')
          ->setOptions([
              'defaultFont'        => 'sans-serif',
              'isRemoteEnabled'    => true,
              'isHtml5ParserEnabled' => true,
          ]);

        $filename = 'Admit_Cards_' . str_replace(' ', '_', $exam->exam_name) . '_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Private helper: Query builder for students
     */
    private function getStudentsQuery($sessionId, $gradeId, $sectionId)
    {
        return DB::table('tbl_admission as a')
            ->join('tbl_grade as g', 'g.id', '=', 'a.grade_id')
            ->join('tbl_section as s', 's.id', '=', 'a.section_id')
            ->where('a.session_id', $sessionId)
            ->where('a.grade_id', $gradeId)
            ->where('a.section_id', $sectionId)
            ->where('a.status', 'Active')
            ->where('a.is_deleted', 0)
            ->where('g.status', 'Active')
            ->where('s.status', 'Active')
            ->select(
                DB::raw("TRIM(CONCAT_WS(' ', a.first_name, a.middle_name, a.last_name)) as full_name"),
                'a.roll_number',
                'a.admission_no',
                'g.name as grade_name',
                's.name as section_name'
            )
            ->orderBy('a.roll_number');
    }
    
    
   public function downloadBlankTemplate()
{
    $general = DB::table('tbl_general')
        ->where('id', 1)
        ->first();
        
      $exam = DB::table('tbl_exam')
    ->where('is_deleted', 0)
    ->where('status', 'Active')
    ->orderByDesc('id')
    ->first();

    $pdf = Pdf::loadView(
            'backend.admit_card.blank_template',
            compact('general','exam') 
        )
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont'          => 'sans-serif',
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
        ]);

    return $pdf->download('Admit_Card_Blank_Template.pdf');
}


}