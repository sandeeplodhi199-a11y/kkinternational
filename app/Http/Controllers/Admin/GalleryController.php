<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller{
  public function index(){
    $this->galleries();
  }
  
  

  // === Gallery management --------
  public function galleries(Request $request){

    $data['menu'] = "gallery";
    $data['submenu'] = "gallery";

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
    
    
    $galleryCategories = GalleryCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();
    
    if(!empty($category)){
      if(!empty($keyword)){
          $categories = Gallery::with('category')->where('name', 'like', '%'.$keyword.'%')
          ->WHERE('is_deleted', '0')
          ->WHERE('category_id', $category)
          
          ->paginate($r_page);
          $categories->appends(['keyword' => $keyword]);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      } else {
          $categories = Gallery::with('category')->WHERE('is_deleted', '0')->WHERE('category_id', $category)
                        ->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }  else {
     if (!empty($keyword)) {
    $categories = Gallery::with('category')->where(function($query) use ($keyword) {
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
          $categories = Gallery::with('category')->WHERE('is_deleted', '0')->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }
    
    
    $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];

  

    return view('backend.galleries.view',compact('data', 'categories','permExplodesub', 'galleryCategories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
    
  }

  public function add_gallery(){
    $data['menu'] = "gallery";
    $data['submenu'] = "gallery";

    $galleryCategories = GalleryCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();

    return view('backend.galleries.add', compact('data', 'galleryCategories'));
  }

  public function saveGallery(Request $request){
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name('name',$request->name, $request->category_id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Gallery Name Already Available. So can not Add Gallery!!!'); 
      die();
    }

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
		$uniqSlug = $this->check_unique('slug',$url_title);

    $category = new Gallery;
    $category->name = $request->name;
    $category->category_id = $request->category_id;
    $category->parent = optional(GalleryCategory::find($request->category_id))->name;
    $category->staus = $request->status;
    $category->add_date = $request->add_date;
    $category->added_by = $request->added_by;
    $category->content = $request->content;
    $category->tags = $request->tags;
    $category->short_content = $request->short_content;
    $category->view = $request->view;
    $category->slug = $uniqSlug;
    $category->is_deleted = "0";
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      $category->image = $filename;
    }

    $category->meta_title = $request->meta_title;
    $category->meta_keywords = $request->meta_keywords;
    $category->meta_description = $request->meta_description;

    $category->image_alt = $request->image_alt;
    $category->image_title = $request->image_title;
    $category->image_description = $request->image_description;
    $category->canonical = $request->canonical;

    $category->save();

    $insertedId = $category->id;

    $catUpd = Gallery::find($insertedId);
    $catUpd->id_hash = md5($insertedId);
    $catUpd->save();

    return redirect()->back()->with('success', 'Gallery has been Save successfully.'); 
  }

  public function check_unique($key, $value){
      $check = Gallery::WHERE($key, $value)
              ->first();
      if( !empty($check->id) ){
          $value1 = $value . "1";
          return $this->check_unique($key, $value1);
      } else {
          return $value; 
      }
  }

  public function check_unique_name($key, $value, $parent){
    $check = Gallery::WHERE($key, $value)
            ->WHERE('category_id', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function editGallery($id_hash){
      $data['menu'] = "gallery";
      $data['submenu'] = "gallery";

      $category = Gallery::with('category')->where('id_hash', $id_hash)->first();
     
      $galleryCategories = GalleryCategory::where('is_deleted', 0)->where('status', 'Active')->orderBy('name')->get();
     
      return view('backend.galleries.edit', compact('data', 'category', 'galleryCategories'));
  }

  public function updateGallery(Request $request){
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name1('name',$request->name, $request->category_id,$request->id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Gallery Name Already Available. So can not Add Gallery!!!'); 
      die();
    }
    
    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
    $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $category = new Gallery;
    $category = Gallery::find($request->id);
    $category->name = $request->name;
    $category->category_id = $request->category_id;
    $category->parent = optional(GalleryCategory::find($request->category_id))->name;
    $category->staus = $request->status;
    $category->add_date = $request->add_date;
    $category->content = $request->content;
    $category->added_by = $request->added_by;
    $category->tags = $request->tags;
    $category->short_content = $request->short_content;
     $category->view = $request->view;
    $category->slug = $uniqSlug;
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $category->image = $filename;
      } else {
        $category->image = $request->old_image;
      }
      
    }

    $category->meta_title = $request->meta_title;
    $category->meta_keywords = $request->meta_keywords;
    $category->meta_description = $request->meta_description;

    $category->image_alt = $request->image_alt;
    $category->image_title = $request->image_title;
    $category->image_description = $request->image_description;
    $category->canonical = $request->canonical;
    
    $category->save();

    return redirect()->back()->with('success', 'Gallery has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Gallery::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }
  public function check_unique_name1($key, $value, $parent, $id){
    $check = Gallery::WHERE($key, $value)
            ->where('id', '!=' , $id)
            ->WHERE('category_id', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function deleteGallery($id){
    $catUpd = Gallery::find($id);
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'Gallery has been Deleted successfully.');
  }

  public function del_gallery(Request $request){

    $data['menu'] = "gallery";
    $data['sub_menu'] = "del_gallery";

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
        $categories = Gallery::with('category')->where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = Gallery::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }

    return view('backend.galleries.del',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreGallery($id){
    $catUpd = Gallery::find($id);
    $catUpd->is_deleted = 0;
    $catUpd->save();
    return redirect()->back()->with('success', 'Gallery has been Restore successfully.');
  }



  public function galleryPoular(Request $request){
    $id = $request->get('id');
    $popular = $request->get('popular');


    $catUpd = Gallery::find($id);
    $catUpd->popular = $popular;
    $catUpd->save();
    return redirect()->back()->with('success', 'Gallery has been Updated Successfully.');


  }
}


