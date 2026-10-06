<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "department_view";

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
        $page = Department::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Department::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

    return view('backend.department.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "categorys";
    $data['submenu'] = "department_add";

    return view('backend.department.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

   

    $page = new Department;
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->status = 'Active';
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";
    $page->save();

    $insertedId = $page->id;

    $pageUpd = Department::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Department has been Save successfully.'); 
  }



  public function edit($id_hash){
     $user = Auth::user();
     $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_23', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
      $data['menu'] = "categorys";
      $data['submenu'] = "department_view";

      $page = Department::where('id_hash', $id_hash)->first();
      return view('backend.department.edit', compact("data", "page"));
  }

  public function update(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    $page = new Department;
    $page = Department::find($request->id);
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->save();

    return redirect()->back()->with('success', 'Department has been Updated successfully.');
  }

 
  public function delete($id){
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_24', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Department::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Department has been Deleted successfully.');
  }
  

       public function Department(Request $request, $id)
{
    $cat = Department::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Department not found.');
    }
}


}