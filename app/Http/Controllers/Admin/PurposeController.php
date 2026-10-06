<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purpose;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurposeController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "categorys";
    $data['submenu'] = "purpose_view";

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
        $page = Purpose::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Purpose::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

    return view('backend.purpose.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "categorys";
    $data['submenu'] = "purpose_add";

    return view('backend.purpose.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

   

    $page = new Purpose;
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->status = 'Active';
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";
    $page->save();

    $insertedId = $page->id;

    $pageUpd = Purpose::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Purpose has been Save successfully.'); 
  }



  public function edit($id_hash){

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_27', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
      $data['menu'] = "categorys";
      $data['submenu'] = "purpose_view";

      $page = Purpose::where('id_hash', $id_hash)->first();
      return view('backend.purpose.edit', compact("data", "page"));
  }

  public function update(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    $page = new Purpose;
    $page = Purpose::find($request->id);
    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->save();

    return redirect()->back()->with('success', 'Purpose has been Updated successfully.');
  }

 
  public function delete($id){
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_28', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Purpose::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Purpose has been Deleted successfully.');
  }
  

       public function Purpose(Request $request, $id)
{
    $cat = Purpose::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Purpose not found.');
    }
}


}