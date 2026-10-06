<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller{
  public function index(){
    $this->videos();
  }
  
  

  // === Video management --------
  public function videos(Request $request){

    $data['menu'] = "video";
    $data['submenu'] = "video";

    $keyword = $request['keyword'];
    $category = $request['category_id'];
    
    $data['keyword'] = $keyword;
    $data['category'] = $category;
    $r_page = $request['r_page'];
    if(!empty($r_page)){
      $r_page = $r_page;
      $data['r_page'] = $r_page;
    } else {
      $r_page = 25;
      $data['r_page'] = 25;
    }
    
    
    $videoCategories = VideoCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();
    
    if(!empty($category)){
      if(!empty($keyword)){
          $categories = Video::with('category')->where('name', 'like', '%'.$keyword.'%')
          ->WHERE('is_deleted', '0')
          ->WHERE('category_id', $category)
          
          ->paginate($r_page);
          $categories->appends(['keyword' => $keyword]);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      } else {
          $categories = Video::with('category')->WHERE('is_deleted', '0')->WHERE('category_id', $category)
                        ->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }  else {
     if (!empty($keyword)) {
    $categories = Video::with('category')->where(function($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('add_date', 'like', '%' . $keyword . '%')
                  ->orWhere('parent', 'like', '%' . $keyword . '%');
        })
        ->where('is_deleted', '0')  // Correct chaining of conditions
        
        ->paginate($r_page);
    
    // Append all parameters at once
    $categories->appends([
        'keyword' => $keyword,
        'r_page' => $r_page,
        'category' => $category
    ]);
}
 else {
          $categories = Video::with('category')->WHERE('is_deleted', '0')->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }
    
    
    $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];

   
    return view('backend.videos.view',compact('data', 'categories','permExplodesub', 'videoCategories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
    
  }

  public function add_video(){
    $data['menu'] = "video";
    $data['submenu'] = "video";

   

    $videoCategories = VideoCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();

    return view('backend.videos.add', compact('data', 'videoCategories'));
  }

  public function saveVideo(Request $request){
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name('name',$request->name, $request->category_id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Video Name Already Available. So can not Add Video!!!'); 
      die();
    }

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
		$uniqSlug = $this->check_unique('slug',$url_title);

    $category = new Video;
    $category->name = $request->name;
    $category->url = $request->url;
    $category->category_id = $request->category_id;
    $category->parent = $request->category_id;
    $category->staus = $request->status;
    $category->add_date = $request->add_date;
    $category->added_by = $request->added_by;
    $category->content = $request->content;
    $category->tags = $request->tags;
    $category->short_content = $request->short_content;
    $category->view = $request->view;
    $category->slug = $uniqSlug;
    $category->is_deleted = "0";
   

    $category->meta_title = $request->meta_title;
    $category->meta_keywords = $request->meta_keywords;
    $category->meta_description = $request->meta_description;

    $category->image_alt = $request->image_alt;
    $category->image_title = $request->image_title;
    $category->image_description = $request->image_description;
    $category->canonical = $request->canonical;

    $category->save();

    $insertedId = $category->id;

    $catUpd = Video::find($insertedId);
    $catUpd->id_hash = md5($insertedId);
    $catUpd->save();

    return redirect()->back()->with('success', 'Video has been Save successfully.'); 
  }

  public function check_unique($key, $value){
      $check = Video::WHERE($key, $value)
              ->first();
      if( !empty($check->id) ){
          $value1 = $value . "1";
          return $this->check_unique($key, $value1);
      } else {
          return $value; 
      }
  }

  public function check_unique_name($key, $value, $parent){
    $check = Video::WHERE($key, $value)
            ->WHERE('category_id', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function editVideo($id_hash){
      $data['menu'] = "video";
      $data['submenu'] = "video";

      $category = Video::with('category')->where('id_hash', $id_hash)->first();
     
      $videoCategories = VideoCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();
     
      return view('backend.videos.edit', compact('data', 'category', 'videoCategories'));
  }

  public function updateVideo(Request $request){
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name1('name',$request->name, $request->category_id,$request->id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Video Name Already Available. So can not Add Video!!!'); 
      die();
    }
    
    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
    $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $category = new Video;
    $category = Video::find($request->id);
    $category->name = $request->name;
    $category->url = $request->url;
    $category->category_id = $request->category_id;
    $category->parent = $request->category_id;
    $category->staus = $request->status;
    $category->add_date = $request->add_date;
    $category->content = $request->content;
    $category->added_by = $request->added_by;
    $category->tags = $request->tags;
    $category->short_content = $request->short_content;
     $category->view = $request->view;
    $category->slug = $uniqSlug;
    
    $category->meta_title = $request->meta_title;
    $category->meta_keywords = $request->meta_keywords;
    $category->meta_description = $request->meta_description;

    $category->image_alt = $request->image_alt;
    $category->image_title = $request->image_title;
    $category->image_description = $request->image_description;
    $category->canonical = $request->canonical;
    
    $category->save();

    return redirect()->back()->with('success', 'Video has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Video::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }
  public function check_unique_name1($key, $value, $parent, $id){
    $check = Video::WHERE($key, $value)
            ->where('id', '!=' , $id)
            ->WHERE('category_id', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function deleteVideo($id){
    $catUpd = Video::find($id);
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'Video has been Deleted successfully.');
  }

  public function del_video(Request $request){

    $data['menu'] = "video";
    $data['sub_menu'] = "del_video";

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
        $categories = Video::with('category')->where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = Video::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }

    return view('backend.videos.del',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreVideo($id){
    $catUpd = Video::find($id);
    $catUpd->is_deleted = 0;
    $catUpd->save();
    return redirect()->back()->with('success', 'Video has been Restore successfully.');
  }



  public function videoPoular(Request $request){
    $id = $request->get('id');
    $popular = $request->get('popular');


    $catUpd = Video::find($id);
    $catUpd->popular = $popular;
    $catUpd->save();
    return redirect()->back()->with('success', 'Video has been Updated Successfully.');


  }
}

