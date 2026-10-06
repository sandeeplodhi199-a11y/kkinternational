<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ExamController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "exam_view";

    $keyword = $request['keyword'];
    $data['keyword'] = $keyword;
    $r_page = $request['r_page'];
    if(!empty($r_page)){
      $r_page = $r_page;
      $data['r_page'] = $r_page;
    } else {
      $r_page = 25;
      $data['r_page'] = 25;
    }

    if (!empty($keyword)) {

    $page = Exam::where('is_deleted', 0)
        ->where('name', 'like', '%' . $keyword . '%')
        ->orderBy('orders_by', 'asc')
        ->paginate($r_page)
        ->appends([
            'keyword' => $keyword,
            'r_page' => $r_page
        ]);

} else {

    $page = Exam::where('is_deleted', 0)
        ->orderBy('orders_by', 'asc')
        ->paginate($r_page)
        ->appends([
            'r_page' => $r_page
        ]);
}
    return view('backend.exam.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "categorys";
    $data['submenu'] = "exam_add";

    $courses = DB::table('tbl_course')->where('is_deleted',0)->where('status','Active')->get();

    return view('backend.exam.add', compact("data","courses"));
  }

  public function save(Request $request)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'course_id' => 'required|exists:tbl_course,id',
        'slug' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

   
    $course = Course::find($request->course_id);
    if (!$course) {
        return redirect()->back()->with('error', 'Selected course not found.');
    }

   
    $allowedExams = $course->no_of_exam ?? null;
    $existingExams = Exam::where('course_id', $course->id)->where('is_deleted', 0)->count();

    if ($allowedExams && $existingExams >= $allowedExams) {
        return redirect()->back()->with('error', "Exam limit reached for this course. You can create only {$allowedExams} exams.");
    }


     $isUnique = $this->check_unique_name('name', $request->name);
    if (!$isUnique) {
        return redirect()->back()->with('error', 'Exam name already exists. Cannot add duplicate Exam.');
    }


      if (!empty($request->slug)) {
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
    }


    $uniqueSlug = $this->check_unique('slug', $url_title);

    
    $exam = new Exam();
    $exam->name = $request->name;
    $exam->slug = $uniqueSlug;
    $exam->course_id = $course->id;
    $exam->orders_by = $request->orders_by ?? $course->orders_by ?? 0;
    $exam->status = 'Active';
    $exam->is_deleted = 0;
    $exam->add_id = $user->id;

    $exam->save();

   
    $exam->id_hash = md5($exam->id);
    $exam->save();

 
    return redirect()->back()->with('success', 'Exam has been saved successfully!');
}



public function check_unique_name($key, $value)
{
    return !Exam::where($key, $value)->exists();
}

public function check_unique($key, $value)
{
    $check = Exam::where($key, $value)->first();
    if (!empty($check)) {
        
        $value .= '1';
        return $this->check_unique($key, $value);
    } else {
        return $value;
    }
}



public function edit($id_hash){

     $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_35', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $data['menu'] = "categorys";
    $data['submenu'] = "exam_view";

    $page = Exam::where('id_hash', $id_hash)->first();

    $courses = DB::table('tbl_course')->where('is_deleted',0)->where('status','Active')->get();

    return view('backend.exam.edit', compact("data", "page","courses"));
}

public function update(Request $request){
 
    $request->validate([
        'name' => 'required',
    ]);


     $isUnique = $this->check_unique_name_edit('name', $request->name, $request->id);
    if($isUnique == false){
        return redirect()->back()->with('error', 'Exam Name Already Available. So can not Add Exam!!!'); 
    }

    if(!empty($request->slug)){
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
       
    }

    $uniqueSlug = $this->check_uniqslug_edit('slug', $url_title, $request->id);

   

    $course = Course::find($request->course_id);
    if (!$course) {
        return redirect()->back()->with('error', 'Selected course not found.');
    }

    $allowedExams = $course->no_of_exam ?? null;
    $existingExams = Exam::where('course_id', $course->id)->where('is_deleted', 0)->count();

    if ($allowedExams && $existingExams >= $allowedExams) {
        return redirect()->back()->with('error', "Exam limit reached for this course. You can create only {$allowedExams} exams.");
    }

   
    $user = Auth::user();

    $page = Exam::find($request->id);
    $page->name = $request->name;
    $page->slug = $uniqueSlug;
    $page->course_id = $course->id;
    $page->orders_by = $request->orders_by ?? $course->orders_by ?? 0;
    $page->updated_id = $user->id;

    $page->save();

    return redirect()->back()->with('success', 'Exam has been Updated successfully.');
}

public function check_unique_name_edit($key, $value, $id){
    return !Exam::where($key, $value)->where('id', '!=', $id)->exists();
}

public function check_uniqslug_edit($key, $value, $id){
    $check = Exam::where($key, $value)
        ->where('id', '!=' , $id)
        ->first();
        
    if(!empty($check)){
        $value1 = $value . "1";
        return $this->check_uniqslug_edit($key, $value1, $id);
    } else {
        return $value; 
    }
}

 
  public function delete($id){
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_36', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Exam::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Exam has been Deleted successfully.');
  }
  

       public function Exam(Request $request, $id)
{
    $cat = Exam::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Exam not found.');
    }
}


}