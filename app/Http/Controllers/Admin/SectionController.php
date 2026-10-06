<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
  
    public function index()
    {
        return redirect()->route('admin.section.view');
    }

    public function view(Request $request)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "section_view";

    $keyword = $request->keyword;
    $data['keyword'] = $keyword;

    $r_page = $request->r_page ?? 25;
    $data['r_page'] = $r_page;

    $query = Section::where('is_deleted', 0);

    if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
    }

      $page = $query->orderBy('orders_by', 'asc')->paginate($data['r_page'])->withQueryString();
      
      $user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];


    
    $users = User::pluck('name', 'id');

    return view('backend.section.all', compact('data', 'page', 'users','permExplodesub'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

    
    public function add()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "section_add";

      $grade = DB::table('tbl_grade')
    ->where('is_deleted', 0)
    ->where('status', 'Active')
    ->orderBy('orders_by', 'ASC')
    ->get();
    
  
        return view('backend.section.add', compact('data', 'grade'));
    }

  
   public function save(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    $user = Auth::user();

    if (Section::where('name', $request->name)->exists()) {
        return back()->with('error', 'Section name already exists.');
    }

    $section = new Section();
    $section->name = $request->name;
    $section->orders_by = $request->orders_by ?? 0;
    $section->status = 'Active';
    $section->is_deleted = 0;
    $section->add_id = $user->id ?? 0;

    
    if (is_array($request->grade_id)) {
        $section->grade_id = implode(',', $request->grade_id);
    } else {
        $section->grade_id = $request->grade_id;
    }

    $section->save();

    $section->id_hash = md5($section->id);
    $section->save();

    return back()->with('success', 'Section added successfully.');
}
  
    public function edit($id_hash)
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "section_view";

      
        $page = Section::where('id_hash', $id_hash)->first();

        if (!$page) {
            return back()->with('error', 'Section not found.');
        }

         $grade = DB::table('tbl_grade')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderBy('orders_by', 'ASC')
            ->get();

        return view('backend.section.edit', compact('data', 'page', 'grade'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = Auth::user();

        $exists = Section::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Section name already exists.');
        }

        $page = Section::find($request->id);

        if (!$page) {
            return back()->with('error', 'Section not found.');
        }

        $page->name = $request->name;
        $page->orders_by = $request->orders_by ?? 0;
        $page->update_id = $user->id ?? 0;

        if (is_array($request->grade_id)) {
            $page->grade_id = implode(',', $request->grade_id);
        } else {
            $page->grade_id = $request->grade_id;
        }

        $page->save();

        return back()->with('success', 'Section updated successfully.');
    }
    
   
    public function delete($id)
    {
        $section = Section::find($id);

        if (!$section) {
            return back()->with('error', 'Section not found.');
        }

        $section->is_deleted = 1;
        $section->save();

        return back()->with('success', 'Section deleted successfully.');
    }

    
    public function section(Request $request, $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return back()->with('error', 'Section not found.');
        }

        $section->status = $request->status;
        $section->save();

        return back()->with('success', 'Status updated successfully.');
    }
}