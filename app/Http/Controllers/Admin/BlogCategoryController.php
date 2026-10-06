<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller{
  public function index(){
    $this->category();
  }

  // === Category management --------
  public function category(Request $request){

    $data['menu'] = "blog";
    $data['submenu'] = "category";

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
        $categories = BlogCategory::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->orderBy('orders_by', 'ASC')
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = BlogCategory::WHERE('is_deleted', '0')->orderBy('orders_by', 'ASC')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }
    
     $user = auth()->user();
     $permExplodesub = explode(',', $user->permission_submenu ?? '');
   

    return view('backend.blog.category',compact('data', 'categories','permExplodesub'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add_category(){
    $data['menu'] = "blog";
    $data['submenu'] = "category";

    $categories = BlogCategory::latest()->WHERE('is_deleted', '0')->WHERE('staus', 'Active')->paginate(1000);

    return view('backend.blog.add_category', compact("data", "categories"));
  }

  public function saveCategory(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name('name',$request->name, $request->parent);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Category Name Already Available. So can not Add Category!!!'); 
      die();
    }

    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
		$uniqSlug = $this->check_unique('slug',$url_title);

    $category = new BlogCategory;
    $category->name = $request->name;
    $category->parent = $request->parent;
    $category->staus = $request->status;
    $category->icon = $request->icon;
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

    $catUpd = BlogCategory::find($insertedId);
    $catUpd->id_hash = md5($insertedId);
    $catUpd->save();

    return redirect()->back()->with('success', 'Category has been Save successfully.'); 
  }

  public function check_unique($key, $value){
      $check = BlogCategory::WHERE($key, $value)
              ->first();
      if( !empty($check->id) ){
          $value1 = $value . "1";
          return $this->check_unique($key, $value1);
      } else {
          return $value; 
      }
  }

  public function check_unique_name($key, $value, $parent){
    $check = BlogCategory::WHERE($key, $value)
            ->WHERE('parent', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function editCategory($id_hash){
      $data['menu'] = "blog";
      $data['submenu'] = "category";

      $category = BlogCategory::where('id_hash', $id_hash)->first();
      $categories = BlogCategory::latest()->WHERE('is_deleted', '0')->WHERE('staus', 'Active')->paginate(1000);
      return view('backend.blog.edit_category', compact("data", "category", "categories"));
  }

  public function updateCategory(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    // Check If Already Name Exists ---
    $uniqSlug = $this->check_unique_name1('name',$request->name, $request->parent,$request->id);
    if($uniqSlug == false){
      return redirect()->back()->with('error', 'Category Name Already Available. So can not Add Category!!!'); 
      die();
    }
    
    // Slug Name--
    if( !empty($request->slug)){
			$url_title = Str::slug($request->slug);
		} else{
			$url_title = Str::slug($request->name);
		}
    $uniqSlug = $this->check_unique1('slug',$url_title,$request->id);

    $category = new BlogCategory;
    $category = BlogCategory::find($request->id);
    $category->name = $request->name;
    $category->parent = $request->parent;
    $category->staus = $request->status;
    $category->icon = $request->icon;
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

    return redirect()->back()->with('success', 'Category has been Updated successfully.');
  }

  public function check_unique1($key, $value, $id){
    $check = BlogCategory::WHERE($key, $value)
            ->where('id', '!=' , $id)->first();
    if( !empty($check->id) ){
        $value1 = $value . "1";
        return $this->check_unique1($key, $value1, $id);
    } else {
        return $value; 
    }
  }
  public function check_unique_name1($key, $value, $parent, $id){
    $check = BlogCategory::WHERE($key, $value)
            ->where('id', '!=' , $id)
            ->WHERE('parent', $parent)->first();
    if( !empty($check->id) ){
        return false;
    } else {
        return true; 
    }
  }

  public function deleteCategory($id){
    $catUpd = BlogCategory::find($id);
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'Category has been Deleted successfully.');
  }

  public function del_category(Request $request){

    $data['menu'] = "blog";
    $data['submenu'] = "del_category";

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
        $categories = BlogCategory::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = BlogCategory::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }

    return view('backend.blog.category_del',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreCategory($id){
    $catUpd = BlogCategory::find($id);
    $catUpd->is_deleted = 0;
    $catUpd->save();
    return redirect()->back()->with('success', 'Category has been Restore successfully.');
  }

   // ==== Up Down
   public function category_up($count, $id){
    $category = new BlogCategory;
    $category = BlogCategory::find($id);
    $category->orders_by = $count;
    $category->save();

    return redirect()->back()->with('success', 'Category Order has been Updated successfully.');
  }
}
