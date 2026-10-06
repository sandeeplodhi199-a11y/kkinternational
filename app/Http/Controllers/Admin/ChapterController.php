<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
  
    public function index()
    {
        return redirect()->route('admin.chapter.view');
    }


public function view(Request $request)
{
    $data['menu']    = "categorys";
    $data['submenu'] = "view_chapter";
    $data['keyword']    = $request->keyword;
    $data['r_page']     = $request->r_page ?? 25;
    $data['filter_grade']   = $request->filter_grade;      // ← NEW
    $data['filter_subject'] = $request->filter_subject;    // ← NEW

    $query = Chapter::where('tbl_chapter.is_deleted', 0);

    $user = auth()->user();

    /* ── Teacher restriction (unchanged) ── */
    if ($user->type == 'teacher') {
        $teacherMain = DB::table('tbl_teacher')
            ->where('teacher_id', $user->teacher_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        if ($teacherMain) {
            $assignments = DB::table('tbl_teacher_assign')
                ->where('teacher_id', $teacherMain->id)
                ->select('grade_id', 'subject_id')
                ->get();

            if ($assignments->isNotEmpty()) {
                $values = $assignments->map(function ($a) {
                    return "({$a->grade_id}, {$a->subject_id})";
                })->implode(',');
                $query->whereRaw("(tbl_chapter.grade_id, tbl_chapter.subject_id) IN ($values)");
            } else {
                $query->whereRaw("1 = 0");
            }
        } else {
            $query->whereRaw("1 = 0");
        }
    }

    /* ── Keyword filter (unchanged) ── */
    if (!empty($data['keyword'])) {
        $query->where('tbl_chapter.name', 'like', '%' . $data['keyword'] . '%');
    }

    /* ── Grade filter (NEW) ── */
    if (!empty($data['filter_grade'])) {
        $query->where('tbl_chapter.grade_id', $data['filter_grade']);
    }

    /* ── Subject filter (NEW) ── */
    if (!empty($data['filter_subject'])) {
        $query->where('tbl_chapter.subject_id', $data['filter_subject']);
    }

    $permExplodesub = $user->permission_submenu
        ? explode(",", $user->permission_submenu)
        : [];

    $page = $query
        ->join('tbl_grade', 'tbl_chapter.grade_id', '=', 'tbl_grade.id')
        ->orderBy('tbl_grade.name')
        ->orderBy('tbl_chapter.chapter_no')
        ->select('tbl_chapter.*')
        ->paginate($data['r_page'])
        ->withQueryString();

    $users = User::pluck('name', 'id');

    /* ── Dropdown data for filters (NEW) ── */
    $allGrades   = DB::table('tbl_grade')  ->where('is_deleted', 0)->pluck('name', 'id');
    $allSubjects = DB::table('tbl_subject')->where('is_deleted', 0)->pluck('name', 'id');
  

    return view('backend.chapter.all', compact(
        'data', 'page', 'users', 'permExplodesub',
        'allGrades', 'allSubjects'                 // ← pass to blade
    ))->with('i', (request()->input('page', 1) - 1) * $data['r_page']);
}
   
    public function add()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "add_chapter";

          $grade = DB::table('tbl_grade')->where('is_deleted',0)->orderBy('orders_by')->where('status','Active')->get();
        return view('backend.chapter.add', compact('data','grade'));
    }

  
 public function save(Request $request)
{
    $request->validate([
        'name' => 'required',
        'grade_id' => 'required'
    ]);

    $user = Auth::user();

   
    $exists = Chapter::where('name', $request->name)
        ->where('grade_id', $request->grade_id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'This chapter name already exists in the selected grade.');
    }

    $chapter = new Chapter();
    $chapter->name = $request->name;
    $chapter->chapter_no = $request->chapter_no ?? 0;
    $chapter->status = 'Active';
    $chapter->is_deleted = 0;
    $chapter->add_id = $user->id ?? 0;
    $chapter->grade_id = $request->grade_id;
    $chapter->subject_id = $request->subject_id;
    $chapter->no_of_pages = $request->no_of_pages;
    $chapter->save();

    $chapter->id_hash = md5($chapter->id);
    $chapter->save();

    return back()->with('success', 'Chapter added successfully.');
}

 public function edit($id_hash)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "view_chapter";

    $page = Chapter::where('id_hash', $id_hash)->first();

    if (!$page) {
        return back()->with('error', 'Chapter not found.');
    }

    $grade = DB::table('tbl_grade')
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->orderBy('orders_by')
        ->get();

    return view('backend.chapter.edit', compact('data', 'page', 'grade'));
}


public function update(Request $request)
{
    $request->validate([
        'name' => 'required',
        'chapter_no' => 'required|numeric',
        'grade_id' => 'required'
    ]);

    $user = Auth::user();

    
    $exists = Chapter::where('name', $request->name)
        ->where('grade_id', $request->grade_id)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'This chapter name already exists in the selected grade.');
    }

    $page = Chapter::find($request->id);

    if (!$page) {
        return back()->with('error', 'Chapter not found.');
    }

    $page->name = $request->name;
    $page->chapter_no = $request->chapter_no;
    $page->grade_id = $request->grade_id;
    $page->subject_id = $request->subject_id;
    $page->no_of_pages = $request->no_of_pages;
    $page->update_id = $user->id ?? 0;

    $page->save();

    return back()->with('success', 'Chapter updated successfully.');
}

    public function delete($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return back()->with('error', 'Chapter not found.');
        }

        $chapter->is_deleted = 1;
        $chapter->save();

        return back()->with('success', 'Chapter deleted successfully.');
    }

    
    public function Chapter(Request $request, $id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return back()->with('error', 'Chapter not found.');
        }

        $chapter->status = $request->status;
        $chapter->save();

        return back()->with('success', 'Status updated successfully.');
    }
}