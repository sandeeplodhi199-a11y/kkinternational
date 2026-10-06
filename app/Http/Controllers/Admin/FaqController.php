<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class FaqController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "faq";
    $data['submenu'] = "faq";

    $keyword = $request['keyword'];
    $data['keyword'] = $keyword;
    $r_page = $request['r_page'];
    if(!empty($r_page)){
      $data['r_page'] = $r_page;
    } else {
      $r_page = 25;
      $data['r_page'] = 25;
    }

    if(!empty($keyword)){
        $page = Faq::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->orderBy('orders_by', 'ASC')
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Faq::WHERE('is_deleted', '0')->orderBy('orders_by', 'ASC')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }
    
    $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];


    return view('backend.faq.all',compact('data', 'page','permExplodesub'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "faq";
    $data['submenu'] = "faq";

    return view('backend.faq.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
		$uniqSlug = $this->check_unique('slug',$url_title);

    $page = new Faq;
    $page->name = $request->name;
    $page->slug = $uniqSlug;
    $page->type = $request->type;
    $page->content = $request->content;
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";
    $page->save();

    $insertedId = $page->id;

    $pageUpd = Faq::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Faq has been Save successfully.'); 
  }

  public function check_unique($key, $value){
    $check = Faq::WHERE($key, $value)
            ->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique($key, $value1);
    } else {
        return $value; 
    }
  }

  public function edit($id_hash){
      $data['menu'] = "faq";
      $data['submenu'] = "faq";

      $page = Faq::where('id_hash', $id_hash)->first();
      return view('backend.faq.edit', compact("data", "page"));
  }

  public function update(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
    $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $page = new Faq;
    $page = Faq::find($request->id);
    $page->name = $request->name;
    $page->type = $request->type;
    $page->slug = $uniqSlug;
    $page->content = $request->content;
    $page->save();

    return redirect()->back()->with('success', 'Faq has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Faq::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }

  public function delete($id){
    $pageUpd = Faq::find($id);
    if ($pageUpd) {
      $pageUpd->is_deleted = "1";
      $pageUpd->save();
    }
   
    
    return redirect()->back()->with('success', 'Faq has been Deleted successfully.');
  }


  public function faq_up($count, $id){
    $category = new Faq;
    $category = Faq::find($id);
    $category->orders_by = $count;
    $category->save();

    return redirect()->back()->with('success', 'Faq Order has been Updated successfully.');
  }
  
}
