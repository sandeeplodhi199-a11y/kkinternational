<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LevelController extends Controller
{
  
    public function index()
    {
        return redirect()->route('admin.level.view');
    }

  public function view(Request $request)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "level_view";

    $data['keyword'] = $request->keyword;
    $data['r_page'] = $request->r_page ?? 25;

    $query = Level::where('is_deleted', 0);

    if (!empty($request->keyword)) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

 $page = $query->orderBy('orders_by', 'asc')
              ->paginate($data['r_page'])
              ->withQueryString();
    
    
    $user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];


    $users = User::pluck('name', 'id');
    
    
    

    return view('backend.level.all', compact('data', 'page', 'users','permExplodesub'))
        ->with('i', (request()->input('page', 1) - 1) * $data['r_page']);
}

    // ================= ADD =================
    public function add()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "level_add";

        return view('backend.level.add', compact('data'));
    }

  
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = Auth::user();

      
        if (Level::where('name', $request->name)->exists()) {
            return back()->with('error', 'Level name already exists.');
        }

        $level = new Level();
        $level->name = $request->name;
        $level->orders_by = $request->orders_by ?? 0;
        $level->status = 'Active';
        $level->is_deleted = 0;
        $level->add_id = $user->id ?? 0;
        $level->save();

        // Generate hash
        $level->id_hash = md5($level->id);
        $level->save();

        return back()->with('success', 'Level added successfully.');
    }

  
    public function edit($id_hash)
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "level_view";

      
        $page = Level::where('id_hash', $id_hash)->first();

        if (!$page) {
            return back()->with('error', 'Level not found.');
        }

        return view('backend.level.edit', compact('data', 'page'));
    }

  
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = Auth::user();

      
        $exists = Level::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Level name already exists.');
        }

        $page = Level::find($request->id);

        if (!$page) {
            return back()->with('error', 'Level not found.');
        }

        $page->name = $request->name;
        $page->orders_by = $request->orders_by ?? 0;
        $page->update_id = $user->id ?? 0;
        $page->save();

        return back()->with('success', 'Level updated successfully.');
    }

   
    public function delete($id)
    {
        $level = Level::find($id);

        if (!$level) {
            return back()->with('error', 'Level not found.');
        }

        $level->is_deleted = 1;
        $level->save();

        return back()->with('success', 'Level deleted successfully.');
    }

    
    public function status(Request $request, $id)
    {
        $level = Level::find($id);

        if (!$level) {
            return back()->with('error', 'Level not found.');
        }

        $level->status = $request->status;
        $level->save();

        return back()->with('success', 'Status updated successfully.');
    }
}