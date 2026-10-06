<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\ManagerExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function manager(Request $request)
    {
      $user = Auth::user();

        $data['menu']    = 'teams';
        $data['submenu'] = 'manager';

        $r_page = $request->get('r_page', 25);
        $data['r_page'] = $r_page;
        
         if($user->type == 'admin'){
            $managers = Manager::where('is_deleted', 0);
                }else{
            $managers = Manager::where('is_deleted', 0)->where('manager_id', $user->manager_id);
                }

        if ($request->filled('name')) {
            $managers->where('name', 'like', '%' . $request->name . '%');
            $data['name'] = $request->name;
        }

         if ($request->filled('email')) {
            $managers->where('email', 'like', '%' . $request->email . '%');
            $data['email'] = $request->email;
        }
        if ($request->filled('phone')) {
            $managers->where('phone', 'like', '%' . $request->phone . '%');
            $data['phone'] = $request->phone;
        }

        if ($request->filled('gender')) {
            $managers->where('gender', $request->gender);
            $data['gender'] = $request->gender;
        }

       

        if ($request->filled('dob_from')) {
            $managers->whereDate('dob', '>=', $request->dob_from);
            $data['dob_from'] = $request->dob_from;
        }

        if ($request->filled('dob_to')) {
            $managers->whereDate('dob', '<=', $request->dob_to);
            $data['dob_to'] = $request->dob_to;
        }

        if ($request->filled('date_from')) {
            $managers->whereDate('created_at', '>=', $request->date_from);
            $data['date_from'] = $request->date_from;
        }

        if ($request->filled('date_to')) {
            $managers->whereDate('created_at', '<=', $request->date_to);
            $data['date_to'] = $request->date_to;
        }

        $managers = $managers->orderBy('id', 'DESC')->paginate($r_page);
        $managers->appends($request->all());

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();

        return view('backend.manager.manager', compact('data', 'managers', 'branches'))
            ->with('i', (request()->input('page', 1) - 1) * $r_page);
    }

    public function add_manager()
    {
        $data['menu']    = 'teams';
        $data['submenu'] = 'manager';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();

        return view('backend.manager.add', compact('data', 'branches'));
    }

    public function saveManager(Request $request)
{
    $request->validate([
        'name' => 'required',
    ]);

    $user = Auth::user();

    // Unique checks
    if (!$this->check_unique_email_edit('email', $request->email, $request->id)) {
        return redirect()->back()->with('error', 'Manager email already exists.');
    }

    if (!$this->check_unique_phone_edit('phone', $request->phone, $request->id)) {
        return redirect()->back()->with('error', 'Manager phone already exists.');
    }

    // Generate new manager ID
    $lastManager = Manager::orderBy('id', 'desc')->first();
    $lastNumber  = $lastManager ? (int) str_replace('MAN', '', $lastManager->manager_id) : 0;
    $newManagerId = 'MAN' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

    // Save Manager
    $manager = new Manager();
    $manager->manager_id = $newManagerId;
    $manager->name       = $request->name;
    $manager->email      = $request->email;
    $manager->phone      = $request->phone;
    $manager->gender     = $request->gender;
    $manager->dob        = $request->dob;
    $manager->status     = 'Active';
    $manager->password   = Hash::make($request->password);
    $manager->state      = $request->state;
    $manager->city       = $request->city;
    $manager->add_id     = $user->id;
    $manager->branch_id  = $request->branch_id;

   
    if ($file = $request->file('image')) {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $path     = base_path('resources/views/backend/manager/uploads');

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $filename);
        $manager->image = $filename;
    }

    $manager->save();

   
    $manager->id_hash = md5($manager->id);
    $manager->save();

   
    $userRecord = new User();
    $userRecord->name = $manager->name;
    $userRecord->email = $manager->email;
    $userRecord->mobile = $manager->phone;
    $userRecord->manager_id = $manager->manager_id;
    $userRecord->password = Hash::make($request->password); 
    $userRecord->is_deleted = 0;
    $userRecord->add_id     = $user->id;
    $userRecord->branch_id  = $request->branch_id;
    $userRecord->type = 'manager';

    
    if ($file) { 
        $userRecord->image = $filename;
    }

    $userRecord->save();

    return redirect()->back()->with('success', 'Manager added successfully.');
}


    public function edit_manager($id_hash)
    {

        $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('4_3', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

        $data['menu']    = 'teams';
        $data['submenu'] = 'manager';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();

        $manager = Manager::where('id_hash', $id_hash)->first();

        return view('backend.manager.edit', compact('data', 'manager', 'branches'));
    }

   public function updatemanager(Request $request)
{
  
    $request->validate([
        'name' => 'required',
    ]);

    $user = Auth::user();

    
    $isUniqueEmail = $this->check_unique_email_edit('email', $request->email, $request->id);
    if (!$isUniqueEmail) {
        return redirect()->back()->with('error', 'Manager email already exists.');
    }

    
    $isUniquePhone = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
    if (!$isUniquePhone) {
        return redirect()->back()->with('error', 'Manager phone already exists.');
    }

    $manager = Manager::find($request->id);

    if (!$manager) {
        return redirect()->back()->with('error', 'Manager not found.');
    }

    $file = null;

    
    $manager->name       = $request->name;
    $manager->email      = $request->email;
    $manager->phone      = $request->phone;
    $manager->gender     = $request->gender;
    $manager->dob        = $request->dob;
    $manager->status     = 'Active';
    if (!empty($request->password)) {
        $manager->password = Hash::make($request->password);
    }
    $manager->state      = $request->state;
    $manager->city       = $request->city;
    $manager->updated_id = $user->id;
    $manager->branch_id  = $request->branch_id;

   
    if ($file = $request->file('image')) {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $path     = base_path('resources/views/backend/manager/uploads');

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!empty($manager->image)) {
            $oldImagePath = $path . '/' . $manager->image;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $file->move($path, $filename);
        $manager->image = $filename;
    }

    $manager->save();

     
    $userRecord = User::where('manager_id', $manager->manager_id)->where('email', $manager->email)->where('type', 'manager')->first();
   

    if ($userRecord) {
        $userRecord->name   = $manager->name;
        $userRecord->email  = $manager->email;
        $userRecord->mobile = $manager->phone;

        if (!empty($request->password)) {
            $userRecord->password = Hash::make($request->password);
        }

        $userRecord->is_deleted = 0;
        $userRecord->type       = 'manager';
        $userRecord->updated_id = $user->id;

        if ($file) {
            $userRecord->image = $filename;
        }

        $userRecord->save();
    }

    return redirect()->back()->with('success', 'Manager updated successfully.');
}


    public function deleteManager($id)
    {
        $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('4_4', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
        $manager = Manager::find($id);
        if ($manager) {
            $manager->is_deleted = 1;
            $manager->save();
            return redirect()->back()->with('success', 'Manager deleted successfully.');
        }

        return redirect()->back()->with('error', 'Manager not found.');
    }

    public function updatemanagerStatus(Request $request, $id)
    {
        $manager = Manager::find($id);
        if ($manager) {
            $manager->status = $request->status;
            $manager->save();
            return redirect()->back()->with('success', 'Status updated successfully.');
        }

        return redirect()->back()->with('error', 'Manager not found.');
    }

  public function export(Request $request)
{
    return Excel::download(new ManagerExport($request), 'managers.xlsx');
}




    // Helper functions
    public function check_unique_name($key, $value)
    {
        return !Manager::where($key, $value)->exists();
    }

    public function check_unique($key, $value)
    {
        $check = Manager::where($key, $value)->first();
        if (!empty($check)) {
            $value .= '1';
            return $this->check_unique($key, $value);
        }

        return $value;
    }

    public function check_unique_name_edit($key, $value, $id)
    {
        return !Manager::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_email_edit($key, $value, $id)
    {
        return !Manager::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_phone_edit($key, $value, $id)
    {
        return !Manager::where($key, $value)->where('id', '!=', $id)->exists();
    }
}