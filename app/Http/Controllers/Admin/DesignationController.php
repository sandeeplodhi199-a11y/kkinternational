<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesignationController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "designation_view";

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
        $page = Designation::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Designation::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

    return view('backend.designation.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "categorys";
    $data['submenu'] = "designation_add";

    return view('backend.designation.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

   

    $page = new Designation;
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->status = 'Active';
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";
    $page->save();

    $insertedId = $page->id;

    $pageUpd = Designation::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Designation has been Save successfully.'); 
  }



  public function edit($id_hash){
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_19', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
      $data['menu'] = "categorys";
      $data['submenu'] = "designation_view";

      $page = Designation::where('id_hash', $id_hash)->first();
      return view('backend.designation.edit', compact("data", "page"));
  }

  public function update(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    $page = new Designation;
    $page = Designation::find($request->id);
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->save();

    return redirect()->back()->with('success', 'Designation has been Updated successfully.');
  }

 
  public function delete($id){

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_20', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Designation::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Designation has been Deleted successfully.');
  }
  

       public function Designation(Request $request, $id)
{
    $cat = Designation::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Designation not found.');
    }
}


}