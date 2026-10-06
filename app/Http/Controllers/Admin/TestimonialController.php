<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestimonialController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "testimonial";
    $data['submenu'] = "testimonial";

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
        $page = Testimonial::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Testimonial::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

    $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];

    return view('backend.testimonial.all',compact('data', 'page','permExplodesub'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "testimonial";
    $data['submenu'] = "testimonial";

    return view('backend.testimonial.add', compact("data"));
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

    $page = new Testimonial;
    $page->name = $request->name;
    $page->heading  = $request->heading;
    $page->sub_heading  = $request->sub_heading;
    $page->slug = $uniqSlug;
    $page->rating = $request->rating;
    $page->content = $request->content;
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      $page->image = $filename;
    }
    $page->is_deleted = "0";
    $page->id_hash = "id_hash";

    $page->image_alt = $request->image_alt;
    $page->image_title = $request->image_title;
    $page->image_description = $request->image_description;

    $page->save();

    $insertedId = $page->id;

    $pageUpd = Testimonial::find($insertedId);
    $pageUpd->id_hash = md5($insertedId);
    $pageUpd->save();

    return redirect()->back()->with('success', 'Testimonial has been Save successfully.'); 
  }

  public function check_unique($key, $value){
    $check = Testimonial::WHERE($key, $value)
            ->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique($key, $value1);
    } else {
        return $value; 
    }
  }

  public function edit($id_hash){
      $data['menu'] = "testimonial";
      $data['submenu'] = "testimonial";

      $page = Testimonial::where('id_hash', $id_hash)->first();
      return view('backend.testimonial.edit', compact("data", "page"));
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

    $page = new Testimonial;
    $page = Testimonial::find($request->id);
    $page->name = $request->name;
    $page->heading  = $request->heading;
    $page->slug = $uniqSlug;
    $page->rating = $request->rating;
    $page->content = $request->content;
    $page->sub_heading  = $request->sub_heading;
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      $page->image = $filename;
    }
    $page->image_alt = $request->image_alt;
    $page->image_title = $request->image_title;
    $page->image_description = $request->image_description;
    
    $page->save();

    return redirect()->back()->with('success', 'Testimonial has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Testimonial::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }

  public function delete($id){
    
    $certificate = Testimonial::find($id);
    
    
    if ($certificate) 
      // Perform the deletion
      $certificate->delete();
      


    return redirect()->back()->with('success', 'Testimonial has been Deleted successfully.');
  }
  
}
