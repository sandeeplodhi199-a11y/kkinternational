<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
  
    public function index()
    {
        return redirect()->route('admin.grade.view');
    }

 public function view(Request $request)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "grade_view";

    $data['keyword'] = $request->keyword;
    $data['r_page'] = $request->r_page ?? 25;

    $query = Grade::where('is_deleted', 0);

    if (!empty($request->keyword)) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

$user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];

    $page = $query->orderBy('orders_by', 'asc')->paginate($data['r_page'])->withQueryString();

    $users = User::pluck('name', 'id');

    return view('backend.grade.all', compact('data', 'page', 'users','permExplodesub'))
        ->with('i', (request()->input('page', 1) - 1) * $data['r_page']);
}

   
    public function add()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "grade_add";

          $level = DB::table('tbl_level')->where('is_deleted',0)->where('status','Active')->get();
         
         $level = DB::table('tbl_level')->where('is_deleted',0)->where('status','Active')->orderBy('orders_by', 'ASC')->get();
        
        return view('backend.grade.add', compact('data','level'));
    }

  
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = Auth::user();

      
        if (Grade::where('name', $request->name)->exists()) {
            return back()->with('error', 'Grade name already exists.');
        }

        $grade = new Grade();
        $grade->name = $request->name;
        $grade->orders_by = $request->orders_by ?? 0;
        $grade->status = 'Active';
        $grade->is_deleted = 0;
        $grade->add_id = $user->id ?? 0;
        $grade->level_id = $request->level_id;
        $grade->save();

      
        $grade->id_hash = md5($grade->id);
        $grade->save();

        return back()->with('success', 'Grade added successfully.');
    }

 public function edit($id_hash)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "grade_view";

    $page = Grade::where('id_hash', $id_hash)->first();

    if (!$page) {
        return back()->with('error', 'Grade not found.');
    }

   $level = DB::table('tbl_level')->where('is_deleted',0)->where('status','Active')->orderBy('orders_by', 'ASC')->get();
        

    return view('backend.grade.edit', compact('data', 'page', 'level'));
}


public function update(Request $request)
{
    $request->validate([
        'name' => 'required',
        'orders_by' => 'required|numeric',
        'level_id' => 'required'
    ]);

    $user = Auth::user();

    // Duplicate check
    $exists = Grade::where('name', $request->name)
        ->where('level_id', $request->level_id)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'Grade name already exists.');
    }

    $page = Grade::find($request->id);

    if (!$page) {
        return back()->with('error', 'Grade not found.');
    }

    $page->name = $request->name;
    $page->orders_by = $request->orders_by;
    $page->level_id = $request->level_id;
    $page->update_id = $user->id ?? 0;

    $page->save();

    return back()->with('success', 'Grade updated successfully.');
}
   
    public function delete($id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return back()->with('error', 'Grade not found.');
        }

        $grade->is_deleted = 1;
        $grade->save();

        return back()->with('success', 'Grade deleted successfully.');
    }

    
    public function grade(Request $request, $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return back()->with('error', 'Grade not found.');
        }

        $grade->status = $request->status;
        $grade->save();

        return back()->with('success', 'Status updated successfully.');
    }
}