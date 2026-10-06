<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "course_view";

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

    if(!empty($keyword)){
        $page = Course::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Course::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

    return view('backend.course.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "categorys";
    $data['submenu'] = "course_add";

    return view('backend.course.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

           $user = Auth::user();


    $page = new Course;
    $page->name = $request->name;
    $page->code = $request->code;
    $page->amount = $request->amount;
    $page->duration = $request->duration;
    $page->no_of_exam = $request->no_of_exam;
    $page->orders_by = $request->orders_by;
    $page->type = $request->type;
    $page->status = 'Active';
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";
    $page->add_id     = $user->id;

    $page->save();

    $insertedId = $page->id;

    $pageUpd = Course::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Course has been Save successfully.'); 
  }



  public function edit($id_hash){

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_31', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
      $data['menu'] = "categorys";
      $data['submenu'] = "course_view";

      $page = Course::where('id_hash', $id_hash)->first();
      return view('backend.course.edit', compact("data", "page"));
  }

  public function update(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

            $user = Auth::user();

    $page = new Course;
    $page = Course::find($request->id);
    $page->name = $request->name;
    $page->code = $request->code;
    $page->amount = $request->amount;
    $page->duration = $request->duration;
    $page->no_of_exam = $request->no_of_exam;
    $page->orders_by = $request->orders_by;
    $page->type = $request->type;

    $page->updated_id = $user->id;

    $page->save();

    return redirect()->back()->with('success', 'Course has been Updated successfully.');
  }

 
  public function delete($id){
     $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_32', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Course::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Course has been Deleted successfully.');
  }
  

       public function Course(Request $request, $id)
{
    $cat = Course::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Course not found.');
    }
}


}