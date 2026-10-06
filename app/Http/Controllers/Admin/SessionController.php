<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class SessionController extends Controller
{
  
    public function index()
    {
        return redirect()->route('admin.session.view');
    }

    public function view(Request $request)
{
    $data['menu'] = "categorys";
    $data['submenu'] = "session_view";

    $keyword = $request->keyword;
    $data['keyword'] = $keyword;

    $r_page = $request->r_page ?? 25;
    $data['r_page'] = $r_page;

    $query = Session::where('is_deleted', 0);

    if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
    }

    
         $page = $query->orderBy('orders_by', 'asc')->paginate($data['r_page'])->withQueryString();
      
      $user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];


    
    $users = User::pluck('name', 'id');

    return view('backend.session.all', compact('data', 'page', 'users','permExplodesub'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

    
    public function add()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "session_add";

       
        return view('backend.session.add', compact('data'));
    }

  
   public function save(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    $user = Auth::user();

    if (Session::where('name', $request->name)->exists()) {
        return back()->with('error', 'Session name already exists.');
    }

    $session = new Session();
    $session->name = $request->name;
    $session->orders_by = $request->orders_by ?? 0;
    $session->status = 'Active';
    $session->is_deleted = 0;
    $session->add_id = $user->id ?? 0;

    
   

    $session->save();

    $session->id_hash = md5($session->id);
    $session->save();

    return back()->with('success', 'Session added successfully.');
}
  
    public function edit($id_hash)
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "session_view";

      
        $page = Session::where('id_hash', $id_hash)->first();

        if (!$page) {
            return back()->with('error', 'Session not found.');
        }

       
        return view('backend.session.edit', compact('data', 'page'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = Auth::user();

        $exists = Session::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Session name already exists.');
        }

        $page = Session::find($request->id);

        if (!$page) {
            return back()->with('error', 'Session not found.');
        }

        $page->name = $request->name;
        $page->orders_by = $request->orders_by ?? 0;
        $page->update_id = $user->id ?? 0;

       

        $page->save();

        return back()->with('success', 'Session updated successfully.');
    }
    
   
    public function delete($id)
    {
        $session = Session::find($id);

        if (!$session) {
            return back()->with('error', 'Session not found.');
        }

        $session->is_deleted = 1;
        $session->save();

        return back()->with('success', 'Session deleted successfully.');
    }

    
    public function session(Request $request, $id)
    {
        $session = Session::find($id);

        if (!$session) {
            return back()->with('error', 'Session not found.');
        }

        $session->status = $request->status;
        $session->save();

        return back()->with('success', 'Status updated successfully.');
    }
}