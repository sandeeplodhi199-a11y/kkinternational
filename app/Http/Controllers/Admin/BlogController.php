<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller{
  public function index(){
    $this->blogs();
  }
  
  

  // === Blog management --------
  public function blogs(Request $request){

  

    $data['menu'] = "blog";
    $data['submenu'] = "blog";

    $keyword = $request['keyword'];
    $category = $request['parent'];
    
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
    
    if(!empty($category)){
      if(!empty($keyword)){
          $categories = Blog::where('name', 'like', '%'.$keyword.'%')
          ->WHERE('is_deleted', '0')
          ->WHERE('parent', $category)
          
          ->paginate($r_page);
          $categories->appends(['keyword' => $keyword]);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      } else {
          $categories = Blog::WHERE('is_deleted', '0')
                        
                        ->WHERE('parent', $category)
                        ->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }  else {
     if (!empty($keyword)) {
    $categories = Blog::where(function($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('add_date', 'like', '%' . $keyword . '%');
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
          $categories = Blog::WHERE('is_deleted', '0')
                      
                        ->paginate($r_page);
          $categories->appends(['r_page' => $r_page]);
          $categories->appends(['category' => $category]);
      }
    }
    
    
      $user = auth()->user();

    $permExplodesub = $user->permission_submenu
      ? explode(",", $user->permission_submenu)
      : [];

    
    
     $categories1 = BlogCategory::latest()->WHERE('is_deleted', '0')->WHERE('staus', 'Active')->paginate(1000);

    return view('backend.blogs.view',compact('data', 'categories','categories1','permExplodesub'))->with('i', (request()->input('page', 1) - 1) * $r_page);
    
  }



  

  public function add_blog(){
    $data['menu'] = "blog";
    $data['submenu'] = "blog";

    $categories = BlogCategory::latest()->WHERE('is_deleted', '0')->WHERE('staus', 'Active')->paginate(1000);
    

    return view('backend.blogs.add', compact("data", "categories"));
  }

  public function saveBlog(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name('name',$request->name, $request->parent);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Blog Name Already Available. So can not Add Blog!!!'); 
      die();
    }

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
		$uniqSlug = $this->check_unique('slug',$url_title);

    $category = new Blog;
    $category->name = $request->name;
    $category->parent = $request->parent;
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

    $catUpd = Blog::find($insertedId);
    $catUpd->id_hash = md5($insertedId);
    $catUpd->save();

    return redirect()->back()->with('success', 'Blog has been Save successfully.'); 
  }

  public function check_unique($key, $value){
      $check = Blog::WHERE($key, $value)
              ->first();
      if( !empty($check->id) ){
          $value1 = $value . "1";
          return $this->check_unique($key, $value1);
      } else {
          return $value; 
      }
  }

  public function check_unique_name($key, $value, $parent){
    $check = Blog::WHERE($key, $value)
            ->WHERE('parent', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function editBlog($id_hash){
      $data['menu'] = "blog";
      $data['submenu'] = "blog";

      $category = Blog::where('id_hash', $id_hash)->first();
      $categories = BlogCategory::latest()->WHERE('is_deleted', '0')->WHERE('staus', 'Active')->paginate(1000);
      return view('backend.blogs.edit', compact("data", "category", "categories"));
  }

  public function updateBlog(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name1('name',$request->name, $request->parent,$request->id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Blog Name Already Available. So can not Add Blog!!!'); 
      die();
    }
    
    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
    $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $category = new Blog;
    $category = Blog::find($request->id);
    $category->name = $request->name;
    $category->parent = $request->parent;
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

    return redirect()->back()->with('success', 'Blog has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = Blog::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }
  public function check_unique_name1($key, $value, $parent, $id){
    $check = Blog::WHERE($key, $value)
            ->where('id', '!=' , $id)
            ->WHERE('parent', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function deleteBlog($id){
    $catUpd = Blog::find($id);
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'Blog has been Deleted successfully.');
  }

  public function del_blog(Request $request){

    $data['menu'] = "blog";
    $data['submenu'] = "del_blog";

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
        $categories = Blog::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = Blog::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }

    return view('backend.blogs.del',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreBlog($id){
    $catUpd = Blog::find($id);
    $catUpd->is_deleted = 0;
    $catUpd->save();
    return redirect()->back()->with('success', 'Blog has been Restore successfully.');
  }



  public function blogPoular(Request $request){
    $id = $request->get('id');
    $popular = $request->get('popular');


    $catUpd = Blog::find($id);
    $catUpd->popular = $popular;
    $catUpd->save();
    return redirect()->back()->with('success', 'Blog has been Updated Successfully.');


  }
}


