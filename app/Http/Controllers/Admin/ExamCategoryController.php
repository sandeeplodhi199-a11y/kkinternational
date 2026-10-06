<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamCategoryController extends Controller{

  public function index(){
    $this->category();
  }

  public function exam(Request $request)
  {
    $data['menu']    = "categorys1";
    $data['submenu'] = "exam";

    $keyword = $request->keyword;
    $r_page  = $request->r_page ?? 25;

    $data['keyword'] = $keyword;
    $data['r_page']  = $r_page;

    $query = DB::table('tbl_exam')->where('is_deleted', 0);

    if($keyword){
      $query->where('exam_name', 'like', '%'.$keyword.'%');
    }

    $categories = $query
      ->orderBy('id', 'DESC')
      ->paginate($r_page)
      ->appends(['keyword' => $keyword, 'r_page' => $r_page]);

    $examIds = $categories->pluck('id')->toArray();

   $examMappings = DB::table('tbl_exam_subject_marks as esm')
  ->join('tbl_grade as g', 'g.id', '=', 'esm.grade_id')
  ->join('tbl_subject as s', 's.id', '=', 'esm.subject_id')
  ->whereIn('esm.exam_id', $examIds)
  ->where('esm.is_deleted', 0)
  ->select(
    'esm.exam_id',
    'esm.grade_id',
    'g.name as grade_name',
    'g.orders_by as grade_order',    
    's.name as subject_name',
    's.orders_by as subject_order',  
    'esm.marks',
    'esm.practical_marks',
    'esm.is_included'
  )
  ->orderBy('g.orders_by', 'ASC')   
  ->orderBy('s.orders_by', 'ASC')   
  ->get()
  ->groupBy('exam_id');

    $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];

    return view('backend.exam.exam', compact(
      'data', 'categories', 'examMappings', 'permExplodesub'
    ))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add_exam(){
    $data['menu']    = "categorys1";
    $data['submenu'] = "exam1";
    $grade = Grade::where('is_deleted', '0')->where('status', 'Active')->orderBy('orders_by', 'ASC')->get();
    return view('backend.exam.add_exam', compact("data", "grade"));
  }

  public function saveExam(Request $request)
  {
    $request->validate(['exam_name' => 'required']);

    DB::beginTransaction();

    try {

      $user = Auth::user();

      $exam = new Exam();
      $exam->exam_name                 = $request->exam_name;
      $exam->status                    = $request->status;
      $exam->orders_by                 = $request->orders_by;
      $exam->start_date                = $request->start_date;
      $exam->marksheet_publish_date                = $request->marksheet_publish_date;
      $exam->end_date                  = $request->end_date;
      $exam->theory_passing_percent    = $request->theory_passing_percent;
      $exam->practical_passing_percent = $request->practical_passing_percent;
      $exam->grade_id                  = implode(',', $request->grade_id);
      $exam->add_id                    = $user->id;
      $exam->is_deleted                = 0;
      $exam->save();

      $exam->id_hash = md5($exam->id);
      $exam->save();

      foreach($request->grade_id as $row => $gradeId){

        if(!isset($request->subject_id[$row])) continue;

   
      
        $includedForRow     = $request->is_included[$row]     ?? [];
        $theoryForRow       = $request->theory_marks[$row]    ?? [];
        $practicalForRow    = $request->practical_marks[$row] ?? [];

        foreach($request->subject_id[$row] as $subjectId => $val){

          $isIncluded     = isset($includedForRow[$subjectId]) ? 1 : 0;
          $marks          = (isset($theoryForRow[$subjectId])    && $theoryForRow[$subjectId]    !== '') ? $theoryForRow[$subjectId]    : null;
          $practicalMarks = (isset($practicalForRow[$subjectId]) && $practicalForRow[$subjectId] !== '') ? $practicalForRow[$subjectId] : null;

          DB::table('tbl_exam_subject_marks')->insert([
            'exam_id'         => $exam->id,
            'grade_id'        => $gradeId,
            'subject_id'      => $subjectId,
            'marks'           => $marks,
            'practical_marks' => $practicalMarks,
            'is_included'     => $isIncluded,
            'is_deleted'      => 0,
            'created_at'      => now(),
            'updated_at'      => now(),
          ]);
        }
      }

      DB::commit();
      return back()->with('success', 'Exam Created Successfully');

    } catch(\Exception $e){
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }

  public function check_unique1111($key, $value){
    $check = Exam::where($key, $value)->first();
    if(!empty($check->id)){
      $value1 = $value . "1";
      return $this->check_unique($key, $value1);
    } else {
      return $value;
    }
  }

  public function check_unique_name1111($key, $value, $parent){
    $check = Exam::where($key, $value)->where('parent', $parent)->first();
    if(!empty($check->id)){
      return false;
    } else {
      return true;
    }
  }

  public function editExam($id_hash)
  {
    $data['menu']    = "categorys";
    $data['submenu'] = "exam";

    $exam = Exam::where('id_hash', $id_hash)->firstOrFail();

    $grade = Grade::where('is_deleted', 0)
      ->where('status', 'Active')
      ->orderBy('orders_by', 'ASC')
      ->get();

    $mapped = DB::table('tbl_exam_subject_marks as esm')
      ->join('tbl_subject as s', 's.id', '=', 'esm.subject_id')
      ->where('esm.exam_id', $exam->id)
      ->where('esm.is_deleted', 0)
      ->select('esm.*', 's.name as subject_name')
      ->get()
      ->groupBy('grade_id');

    return view('backend.exam.edit_exam', compact('data', 'exam', 'grade', 'mapped'));
  }

  public function updateExam(Request $request)
  {
    $request->validate(['exam_name' => 'required']);

    DB::beginTransaction();

    try {

      $user = Auth::user();

      $exam = Exam::findOrFail($request->id);
      $exam->exam_name                 = $request->exam_name;
      $exam->status                    = $request->status;
      $exam->orders_by                 = $request->orders_by;
      $exam->start_date                = $request->start_date;
      $exam->end_date                  = $request->end_date;
       $exam->marksheet_publish_date                = $request->marksheet_publish_date;
      $exam->theory_passing_percent    = $request->theory_passing_percent;
      $exam->practical_passing_percent = $request->practical_passing_percent;
      $exam->grade_id                  = implode(',', $request->grade_id);
      $exam->update_id                 = $user->id;
      $exam->save();

      DB::table('tbl_exam_subject_marks')->where('exam_id', $exam->id)->delete();

      foreach($request->grade_id as $row => $gradeId){

        if(!isset($request->subject_id[$row])) continue;

        /*
         * ALL three arrays keyed by subject_id — no sequential mismatch.
         */
        $includedForRow  = $request->is_included[$row]     ?? [];
        $theoryForRow    = $request->theory_marks[$row]    ?? [];
        $practicalForRow = $request->practical_marks[$row] ?? [];

        foreach($request->subject_id[$row] as $subjectId => $val){

          $isIncluded     = isset($includedForRow[$subjectId]) ? 1 : 0;
          $marks          = (isset($theoryForRow[$subjectId])    && $theoryForRow[$subjectId]    !== '') ? $theoryForRow[$subjectId]    : null;
          $practicalMarks = (isset($practicalForRow[$subjectId]) && $practicalForRow[$subjectId] !== '') ? $practicalForRow[$subjectId] : null;

          DB::table('tbl_exam_subject_marks')->insert([
            'exam_id'         => $exam->id,
            'grade_id'        => $gradeId,
            'subject_id'      => $subjectId,
            'marks'           => $marks,
            'practical_marks' => $practicalMarks,
            'is_included'     => $isIncluded,
            'is_deleted'      => 0,
            'created_at'      => now(),
            'updated_at'      => now(),
          ]);
        }
      }

      DB::commit();
      return back()->with('success', 'Exam Updated Successfully');

    } catch(\Exception $e){
      DB::rollback();
      return back()->with('error', $e->getMessage());
    }
  }

  public function deleteExam($id)
  {
    DB::beginTransaction();
    try {
      $exam = Exam::find($id);
      if(!$exam){
        return redirect()->back()->with('error', 'Exam not found');
      }
      $exam->is_deleted = 1;
      $exam->save();
      DB::table('tbl_exam_subject_marks')->where('exam_id', $id)->update(['is_deleted' => 1]);
      DB::commit();
      return redirect()->back()->with('success', 'Exam deleted successfully');
    } catch(\Exception $e){
      DB::rollback();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

}