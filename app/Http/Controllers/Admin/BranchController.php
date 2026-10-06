<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BranchController extends Controller
{
    public function index(){
        $this->branch();
    }

   public function branch(Request $request){
    $data['menu']  = "categorys";
    $data['submenu']  = "branch";

    $keywords = $request['keyword'];
    $data['keyword'] = $keywords;
    $r_page = $request['r_page'];

    if (!empty($r_page)) {
        $r_page = $r_page;
        $data['r_page'] = $r_page;
    } else {
        $r_page = 25;
        $data['r_page'] = 25;
    }

    if (!empty($keywords)) {
        $branches = Branch::where('name', 'like', '%' . $keywords . '%')
            ->where('is_deleted', '0')
            ->latest()
            ->paginate($r_page);

        $branches->appends(['keyword' => $keywords]);
        $branches->appends(['r_page' => $r_page]);
    } else {
        $branches = Branch::latest()
            ->where('is_deleted', '0')
            ->paginate($r_page);

        $branches->appends(['r_page' => $r_page]);
    }

    

    return view('backend.branch.branch', compact('data', 'branches'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

public function add_branch(){

    $data['menu'] = "categorys";
    $data['submenu'] = "add_branch";


    return view('backend.branch.add', compact('data'));
}

public function saveBranch(Request $request)
{

 
    
    $request->validate([
        'name' => 'required'
    ]);


    $user = Auth::user();

 
    $isUnique = $this->check_unique_name('name', $request->name);
    if (!$isUnique) {
        return redirect()->back()->with('error', 'Branch name already exists. Cannot add duplicate branch.');
    }

  
    if (!empty($request->slug)) {
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
    }


    $uniqueSlug = $this->check_unique('slug', $url_title);


    $branch = new Branch();
    $branch->name = $request->name;
    $branch->slug = $uniqueSlug;
    $branch->orders_by = $request->orders_by;
    $branch->status = $request->status;
    $branch->add_id = $user->id;

if ($file = $request->file('image')) {
    $filename = date('YmdHi') . $file->getClientOriginalName();
    $path = base_path('resources/views/backend/branch/uploads');

    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $file->move($path, $filename);
    $branch->image = $filename;
}



    $branch->save();

    $lastinsertedId = $branch->id;
    $branchUpdate = Branch::find($lastinsertedId);

    $branchUpdate->id_hash = md5($lastinsertedId);
    $branchUpdate->save();

    return redirect()->back()->with('success', 'Branch added successfully.');
}

public function check_unique_name($key, $value)
{
    return !Branch::where($key, $value)->exists();
}

public function check_unique($key, $value)
{
    $check = Branch::where($key, $value)->first();
    if (!empty($check)) {
        
        $value .= '1';
        return $this->check_unique($key, $value);
    } else {
        return $value;
    }
}


public function edit_branch($id_hash){
    $data['menu'] = "categorys";
    $data['submenu'] = "branch";

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_3', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

    $branch = Branch::where('id_hash', $id_hash)->first();

    return view('backend.branch.edit', compact('data', 'branch'));
}

public function Updatebranch(Request $request){
    $request->validate([
        'name' => 'required'
    ]);

    $user = Auth::user();

    $isUnique = $this->check_unique_name_edit('name', $request->name, $request->id);
    if($isUnique == false){
        return redirect()->back()->with('error', 'Branch Name Already Available. So can not Add Branch!!!'); 
    }

    if(!empty($request->slug)){
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
    }

    $uniqueSlug = $this->check_uniqslug_edit('slug', $url_title, $request->id);

    $branch = Branch::find($request->id);
    if($branch){
        $branch->name = $request->name;
        $branch->slug = $uniqueSlug;
        $branch->orders_by = $request->orders_by;
        $branch->updated_id = $user->id;

       
        if ($file = $request->file('image')) {
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $path = base_path('resources/views/backend/branch/uploads');

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

           
            if (!empty($branch->image)) {
                $oldImagePath = $path . '/' . $branch->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

           
            $file->move($path, $filename);
            $branch->image = $filename;
        }

        $branch->save();

       return redirect()->back()->with('success', 'Branch updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Branch not found.');
    }
}


public function check_unique_name_edit($key, $value, $id){
    return !Branch::where($key, $value)->where('id', '!=', $id)->exists();
}

public function check_uniqslug_edit($key, $value, $id){
    $check = Branch::where($key, $value)
        ->where('id', '!=' , $id)
        ->first();
        
    if(!empty($check)){
        $value1 = $value . "1";
        return $this->check_uniqslug_edit($key, $value1, $id);
    } else {
        return $value; 
    }
}


  public function deleteBranch($id){

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_4', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
   
    $branchUpd = Branch::find($id);
    $branchUpd->is_deleted = 1;
    $branchUpd->save();
    return redirect()->back()->with('success', 'Branch has been Deleted successfully.');
  }

  public function updateBranchStatus(Request $request, $id)
{
    
    $branch = Branch::find($id);
    if ($branch) {
        $branch->status = $request->status;
        $branch->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Branch not found.');
    }
}


}