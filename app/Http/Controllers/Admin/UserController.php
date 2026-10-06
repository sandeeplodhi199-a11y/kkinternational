<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller{
  public function index(){
    $this->users();
  }

  // === users management --------
  public function users(Request $request){

  

    $data['menu'] = "users";
    $data['submenu'] = "users";

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
        $categories = User::where('name', 'like', '%'.$keyword.'%')
        
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
     
      $categories = User::orderBy('id', 'asc')
      ->whereNotIn('type', ['admin'])  
      ->where('is_deleted', 0)
      ->paginate($r_page);

  
  $categories->appends(['r_page' => $r_page]);
  

    }

    return view('backend.users.view',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }


  public function add_users(){
    $data['menu'] = "users";
    $data['submenu'] = "users";
    

    return view('backend.users.add', compact("data"));
  }

  public function saveUsers(Request $request){
    $request->validate([
        'name' => 'required',
    ]);


    $emailExist = User::where('email', $request->email)
    ->where('type', 'subadmin')
    ->first();

  if ($emailExist) {
      return redirect()->back()->with('error', 'Email already exists for a Subadmin. So you cannot add this user.');
  }

  $mobileExist = User::where('mobile', $request->mobile)
      ->where('type', 'subadmin')
      ->first();

  if ($mobileExist) {
      return redirect()->back()->with('error', 'Mobile already exists for a Subadmin. So you cannot add this user.');
  }

   $user = Auth::user();

    $category = new User;
    $category->name = $request->name;
    $category->email = $request->email;
    $category->mobile = $request->mobile;
  
    $category->password = Hash::make($request->password);
    $category->type = "subadmin";
    $category->is_deleted = 0;
    $category->add_id = $user->id;
    $category->save();

    return redirect()->back()->with('success', 'User has been Save successfully.'); 
  }

  public function editUsers($id_hash){
  $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('6_4', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
  
      $data['menu'] = "users";
      $data['submenu'] = "users";

      $category = User::where('id', $id_hash)->first();
    
      return view('backend.users.edit', compact("data", "category"));
  }

  public function updateUsers(Request $request)
{
    $request->validate([
        'name' => 'required',
    ]);

   
    $types = ['admin', 'subadmin', 'manager', 'tl', 'telecaller'];

   
    // $emailExist = User::where('email', $request->email)
    //     ->whereIn('type', $types)
    //     ->where('id', '<>', (int)$request->id)
    //     ->first();

    // if ($emailExist) {
    //     return redirect()->back()
    //         ->withInput()
    //         ->with('error', 'Email already exists for another user.');
    // }

    // $mobileExist = User::where('mobile', $request->mobile)
    //     ->whereIn('type', $types)
    //     ->where('id', '<>', (int)$request->id)
    //     ->first();

    // if ($mobileExist) {
    //     return redirect()->back()
    //         ->withInput()
    //         ->with('error', 'Mobile already exists for another user.');
    // }

    $user = Auth::user();

    $category = User::findOrFail($request->id);
    $category->name       = $request->name;
    $category->email      = $request->email;
    $category->mobile     = $request->mobile;
    $category->updated_id = $user->id;

    if (!empty($request->password)) {
        $category->password = Hash::make($request->password);
    }

    $category->save();

    return redirect()->back()->with('success', 'User has been Updated successfully.');
}



  public function deleteUsers($id){
 
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('6_3', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $catUpd = User::find($id);
   
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'User has been Deleted successfully.');
  }

  public function del_users(Request $request){

  

    $data['menu'] = "users";
    $data['submenu'] = "del_users";

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
        $categories = User::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '1')
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
        $categories = User::latest()->WHERE('is_deleted', '1')->paginate($r_page);
        $categories->appends(['r_page' => $r_page]);
    }

    return view('backend.users.del',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function restoreUsers($id){
    $catUpd = User::find($id);
    $catUpd->is_deleted = 0;
    $catUpd->save();
    return redirect()->back()->with('success', 'User has been Restore successfully.');
  }


  // ====
    public function editPermission ($id_hash){
      $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('6_2', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

        $data['menu'] = "users";
        $data['submenu'] = "";

        $category = User::where('id', $id_hash)->first();
        return view('backend.users.edit_permission', compact("data", "category"));
    }

    public function updatePermission(Request $request){

     
      $checkbox = "";
      if($request->has('permission_menu')){
          foreach($request->permission_menu as $chk){
              $checkbox .= $chk; 
              $checkbox .= ",";
          }
          $checkbox = rtrim($checkbox, ","); 
      }
  
      $checkboxsub = "";
      if($request->has('permission_submenu')){
          foreach($request->permission_submenu as $chk){
              $checkboxsub .= $chk; 
              $checkboxsub .= ",";
          }
          $checkboxsub = rtrim($checkboxsub, ","); 
      }
  
      $category = User::find($request->id);
      if($category){
          $category->permission_menu = $checkbox;
          $category->permission_submenu = $checkboxsub;
          $category->save();
      }
  
      return redirect()->back()->with('success', 'User has been Updated successfully.');
  }
  
    public function get_today_company_count($id)
    {
      $today = date('Y-m-d');
      echo $todCompany = DB::table('tbl_company')
          ->WHERE('add_id', $id)
          ->where('created_at', 'like', '%' . $today . '%')
          ->count();
    }

    public function get_all_company_count($id)
    {
      echo $todCompany = DB::table('tbl_company')->WHERE('add_id', $id)->count();
    }

    public function get_today_company_count_update($id)
    {
      $today = date('Y-m-d');
      echo $todCompany = DB::table('tbl_company')
          ->WHERE('update_id', $id)
          ->where('updated_at', 'like', '%' . $today . '%')
          ->count();
    }

    public function get_all_company_count_update($id)
    {
      echo $todCompany = DB::table('tbl_company')->WHERE('update_id', $id)->count();
    }

    public function get_today_city_count($id)
    {
      $today = date('Y-m-d');
      echo $todCompany = DB::table('tbl_city')
            ->WHERE('update_id', $id)
            ->where('updated_at', 'like', '%' . $today . '%')
            ->count();
    }

    public function get_all_city_count($id)
    {
      echo $todCompany = DB::table('tbl_city')->WHERE('update_id', $id)->count();
    }







    public function manager_users(Request $request){

  

    $data['menu'] = "users";
    $data['submenu'] = "manager_users";

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
        $categories = User::where('name', 'like', '%'.$keyword.'%')
        
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
      $categories = User::orderBy('id', 'asc') 
      ->whereIn('type', [ 'manager'])
      ->where('is_deleted', 0)
      ->paginate($r_page);
  
  $categories->appends(['r_page' => $r_page]);
  

    }

    return view('backend.users.manager_view',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }





  public function tl_users(Request $request){

  

    $data['menu'] = "users";
    $data['submenu'] = "tl_users";

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
        $categories = User::where('name', 'like', '%'.$keyword.'%')
        
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
      $categories = User::orderBy('id', 'asc') // or any other column
      ->whereIn('type', [ 'tl'])
      ->where('is_deleted', 0)
      ->paginate($r_page);
  
  $categories->appends(['r_page' => $r_page]);
  

    }

    return view('backend.users.tl_view',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }



  public function telecaller_users(Request $request){

  

    $data['menu'] = "users";
    $data['submenu'] = "telecaller_users";

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
        $categories = User::where('name', 'like', '%'.$keyword.'%')
        
        ->latest()
        ->paginate($r_page);
        $categories->appends(['keyword' => $keyword]);
        $categories->appends(['r_page' => $r_page]);
    } else {
      $categories = User::orderBy('id', 'asc') // or any other column
      ->whereIn('type', [ 'telecaller'])
      ->where('is_deleted', 0)
      ->paginate($r_page);
  
  $categories->appends(['r_page' => $r_page]);
  

    }

    return view('backend.users.telecaller_view',compact('data', 'categories'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

}
