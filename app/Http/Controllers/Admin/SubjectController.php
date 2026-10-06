<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller{
  public function index(){
    $this->subject();
  }

  // === Subject management --------
  public function subject(Request $request)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "subject1";

    $keyword = $request->keyword;
    $r_page  = $request->r_page ?? 25;

    $data['keyword'] = $keyword;
    $data['r_page']  = $r_page;

    // MAIN QUERY
    $query = Subject::where('is_deleted', '0');

    // SEARCH FILTER
    if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
    }

    // PAGINATION (FIXED)
    $subjects =$query->orderBy('orders_by', 'asc')
        ->paginate($r_page)
        ->appends($request->all());
        
        
        
        $user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];


    return view('backend.subject.subject', compact('data', 'subjects','permExplodesub'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

  public function add_subject(){

   

   
    $data['menu'] = "categorys";
    $data['submenu'] = "subject";
    

    $class = Grade::WHERE('is_deleted', '0')->WHERE('status', 'Active')->orderBy('orders_by', 'ASC')->get();

    return view('backend.subject.add_subject', compact("data", "class"));
  }

  public function saveSubject(Request $request){
    
    // dd($request);

   
    $request->validate([
        'name' => 'required',
    ]);


    $user = Auth::user();

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name('name',$request->name, $request->grade_id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Subject Name Already Available. So can not Add Subject!!!'); 
      die();
    }

    // Slug Name--
    // if( !empty($request->slug)){
		// 	$url_title = Str::slug($request->slug);
		// } else{
		// 	$url_title = Str::slug($request->name);
		// }
		// $uniqSlug = $this->check_unique('slug',$url_title);

    $subject = new Subject;
    $subject->name = $request->name;
    $subject->is_optional = $request->boolean('is_optional');

    // $subject->subject_duration = $request->subject_duration;
    // $subject->semester = $request->semester;
    $subject->status = $request->status;
    // $subject->slug = $uniqSlug;
    $subject->add_id = $user->id;
    $subject->is_deleted = "0";
    // if($request->file('image')){
    //   $file= $request->file('image');
    //   $filename= date('YmdHi').$file->getClientOriginalName();
    //   $file-> move(public_path('uploads'), $filename);
    //   $subject->image = $filename;
    // }

    $subject->orders_by = $request->orders_by;


    $subject->grade_id = implode(',', $request->class);
    // $subject->meta_title = $request->meta_title;
    // $subject->meta_keywords = $request->meta_keywords;
    // $subject->meta_description = $request->meta_description;
    // $subject->content = $request->content;

    $subject->save();

    $insertedId = $subject->id;

    $subject_upd = Subject::find($insertedId);
    $subject_upd->id_hash = md5($insertedId);
    $subject_upd->save();

    return redirect()->back()->with('success', 'Subject has been Save successfully.'); 
  }

  public function check_unique($key, $value){
      $check = Subject::WHERE($key, $value)
              ->first();
      if( !empty($check->id) ){
          $value1 = $value . "1";
          return $this->check_unique($key, $value1);
      } else {
          return $value; 
      }
  }

  public function check_unique_name($key, $value, $grade_id){
    $check = Subject::WHERE($key, $value)
            ->WHERE('grade_id', $grade_id)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function editSubject($id_hash){

      $data['menu'] = "categorys";
      $data['submenu'] = "subject";
      

      $subject = Subject::where('id_hash', $id_hash)->first();
    
      $class = Grade::WHERE('is_deleted', '0')->WHERE('status', 'Active')->orderBy('orders_by', 'ASC')->get();




      return view('backend.subject.edit_subject', compact("data", "subject", "class"));
  }

  public function updateSubject(Request $request){


    $request->validate([
        'name' => 'required',
    ]);


    $user = Auth::user();

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name1('name',$request->name, $request->grade_id,$request->id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Subject Name Already Available. So can not Add Subject!!!'); 
      die();
    }
    
    // Slug Name--
    // if( !empty($request->slug)){
		// 	$url_title = Str::slug($request->slug);
		// } else{
		// 	$url_title = Str::slug($request->name);
		// }
    // $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $subject = new Subject;
    $subject = Subject::find($request->id);
    $subject->name = $request->name;
    $subject->is_optional = $request->boolean('is_optional');
    $subject->grade_id = implode(',', $request->class);

    // $subject->subject_duration = $request->subject_duration;
    // $subject->semester = $request->semester;
    $subject->status = $request->status;
    // $subject->icon = $request->icon;
    $subject->update_id = $user->id;
    // $subject->slug = $uniqSlug;
    // if($request->file('image')){
    //   $file= $request->file('image');
    //   $filename= date('YmdHi').$file->getClientOriginalName();
    //   $file-> move(public_path('uploads'), $filename);
    //   if(!empty($filename)){
    //     $subject->image = $filename;
    //   } else {
    //     $subject->image = $request->old_image;
    //   }
      
    // }

    $subject->orders_by = $request->orders_by;

    // $subject->meta_title = $request->meta_title;
    // $subject->meta_keywords = $request->meta_keywords;
    // $subject->meta_description = $request->meta_description;
    // $subject->content = $request->content;
    $subject->save();

    return redirect()->back()->with('success', 'Subject has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Subject::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }
  public function check_unique_name1($key, $value, $grade_id, $id){
    $check = Subject::WHERE($key, $value)
            ->where('id', '!=' , $id)
            ->WHERE('grade_id', $grade_id)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function deleteSubject($id){
    $subject_upd = Subject::find($id);
    $subject_upd->is_deleted = 1;
    $subject_upd->save();
    return redirect()->back()->with('success', 'Subject has been Deleted successfully.');
  }

  public function del_subject(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "del_subject";

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
        $subjects = Subject::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $subjects->appends(['keyword' => $keyword]);
        $subjects->appends(['r_page' => $r_page]);
    } else {
        $subjects = Subject::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $subjects->appends(['r_page' => $r_page]);
    }

    return view('backend.subject.subject_del',compact('data', 'subjects'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreSubject($id){
    $subject_upd = Subject::find($id);
    $subject_upd->is_deleted = 0;
    $subject_upd->save();
    return redirect()->back()->with('success', 'Subject has been Restore successfully.');
  }
}
