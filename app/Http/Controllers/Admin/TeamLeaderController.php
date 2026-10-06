<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamLeader;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\TeamLeaderExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TeamLeaderController extends Controller
{
   public function tl(Request $request)
{
      $user = Auth::user();
   

    $data['menu']    = 'teams';
    $data['submenu'] = 'team_leader';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;


         if($user->type == 'admin'){
           $tls = TeamLeader::where('is_deleted', 0);

         }elseif($user->type == 'subadmin'){
        $tls = TeamLeader::where('is_deleted', 0)->where('add_id', $user->add_id);
         }
         elseif($user->type == 'manager'){
        $tls = TeamLeader::where('is_deleted', 0)->where('manager_id', $user->manager_id);
         }elseif($user->type == 'tl'){
        $tls = TeamLeader::where('is_deleted', 0)->where('tl_id', $user->tl_id);
         }
         elseif($user->type == 'telecaller'){
        $tls = TeamLeader::where('is_deleted', 0)->where('telecaller_id', $user->telecaller_id);
         }

    

    if ($request->filled('name')) {
        $tls->where('name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $tls->where('email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $tls->where('phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $tls->where('gender', $request->gender);
        $data['gender'] = $request->gender;
    }

    if ($request->filled('dob_from')) {
        $tls->whereDate('dob', '>=', $request->dob_from);
        $data['dob_from'] = $request->dob_from;
    }

    if ($request->filled('dob_to')) {
        $tls->whereDate('dob', '<=', $request->dob_to);
        $data['dob_to'] = $request->dob_to;
    }

    if ($request->filled('date_from')) {
        $tls->whereDate('created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $tls->whereDate('created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $tls = $tls->orderBy('id', 'DESC')->paginate($r_page);
    $tls->appends($request->all());

    $branches = Branch::where('is_deleted', '0')
                      ->where('status', 'Active')
                      ->orderBy('id', 'DESC')
                      ->get();

    $managers = Manager::where('is_deleted', '0')
    ->where('status', 'Active')
    ->orderBy('id', 'DESC')
    ->get();

    return view('backend.tl.tl', compact('data', 'tls', 'branches','managers'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

    public function add_tl()
    {
        $data['menu']    = 'teams';
        $data['submenu'] = 'tl';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
                          
    $managers = Manager::where('is_deleted', '0')
    ->where('status', 'Active')
    ->orderBy('id', 'DESC')
    ->get();

        return view('backend.tl.add', compact('data', 'branches','managers'));
    }





    public function getManagersByBranch(Request $request)
{
    //   $user = Auth::user();

    $branch_id = $request->branch_id;

    $managers = Manager::where('branch_id', $branch_id)
                ->where('is_deleted', 0)
                // ->where('add_id', $user->id)
                ->get(['manager_id', 'name']);

    return response()->json($managers);
}


    public function saveTL(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();

        $isUniqueEmail = $this->check_unique_email_edit('email', $request->email, $request->id);
        if (!$isUniqueEmail) {
            return redirect()->back()->with('error', 'Team Leader email already exists.');
        }

        $isUniquePhone = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
        if (!$isUniquePhone) {
            return redirect()->back()->with('error', 'Team Leader phone already exists.');
        }

        $lastTL = TeamLeader::orderBy('id', 'desc')->first();
        $lastNumber  = $lastTL ? (int) str_replace('TL', '', $lastTL->tl_id) : 0;
        $newTLId = 'TL' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $tl = new TeamLeader();
        $tl->tl_id = $newTLId;
        $tl->name       = $request->name;
        $tl->email      = $request->email;
        $tl->phone      = $request->phone;
        $tl->gender     = $request->gender;
        $tl->dob        = $request->dob;
        $tl->status     = 'Active';
        $tl->password   = Hash::make($request->password);
        $tl->state      = $request->state;
        $tl->city       = $request->city;
        $tl->add_id     = $user->id;
        $tl->branch_id  = $request->branch_id;
        $tl->manager_id  = $request->manager_id;
        
        if ($file = $request->file('image')) {
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $path     = base_path('resources/views/backend/tl/uploads');

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);
            $tl->image = $filename;
        }

        $tl->save();

        // Update id_hash
        $tl->id_hash = md5($tl->id);
        $tl->save();


        $userRecord = new User();
        $userRecord->name = $tl->name;
        $userRecord->email = $tl->email;
        $userRecord->mobile = $tl->phone;
        $userRecord->tl_id = $tl->tl_id;
        $userRecord->password = Hash::make($request->password); 
        $userRecord->is_deleted = 0;
        $userRecord->type = 'tl';
        $userRecord->add_id     = $user->id;
        $userRecord->branch_id  = $request->branch_id;
        $userRecord->manager_id  = $request->manager_id;

        
        if ($file) { 
            $userRecord->image = $filename;
        }

        $userRecord->save();

        return redirect()->back()->with('success', 'Team Leader added successfully.');
    }

    public function edit_tl($id_hash)
    {
        $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('4_7', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

        $data['menu']    = 'teams';
        $data['submenu'] = 'tl';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
        $managers = Manager::where('is_deleted', '0')
            ->where('status', 'Active')
            ->orderBy('id', 'DESC')
            ->get();


        $tl = TeamLeader::where('id_hash', $id_hash)->first();


        return view('backend.tl.edit', compact('data', 'tl', 'branches','managers'));
    }

    public function updatetl(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();

        $isUniqueEmail = $this->check_unique_email_edit('email', $request->email, $request->id);
        if (!$isUniqueEmail) {
            return redirect()->back()->with('error', 'Team Leader email already exists.');
        }

        $isUniquePhone = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
        if (!$isUniquePhone) {
            return redirect()->back()->with('error', 'Team Leader phone already exists.');
        }

        $tl = TeamLeader::find($request->id);

        if ($tl) {
            $tl->name       = $request->name;
            $tl->email      = $request->email;
            $tl->phone      = $request->phone;
            $tl->gender     = $request->gender;
            $tl->dob        = $request->dob;
            $tl->status     = 'Active';
            $tl->password   = Hash::make($request->password);
            $tl->state      = $request->state;
            $tl->city       = $request->city;
            $tl->updated_id = $user->id;
            $tl->branch_id  = $request->branch_id;
            $tl->manager_id  = $request->manager_id;


            if ($file = $request->file('image')) {
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $path     = base_path('resources/views/backend/tl/uploads');

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                if (!empty($tl->image)) {
                    $oldImagePath = $path . '/' . $tl->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file->move($path, $filename);
                $tl->image = $filename;
            }

            $tl->save();


            
   
            $userRecord = User::where('manager_id', $tl->manager_id)
            ->where('tl_id', $tl->tl_id)
            ->where('email', $tl->email)
            ->where('type', 'tl')
            ->first();

            if ($userRecord) {
                $userRecord->name   = $tl->name;
                $userRecord->email  = $tl->email;
                $userRecord->mobile = $tl->phone;

                if (!empty($request->password)) {
                    $userRecord->password = Hash::make($request->password);
                }

                $userRecord->is_deleted = 0;
                $userRecord->updated_id = $user->id;
                $userRecord->type       = 'tl';


                if (isset($filename)) {
                    $userRecord->image = $filename;
                }

                $userRecord->save();
            }

            return redirect()->back()->with('success', 'Team Leader updated successfully.');
        }

        return redirect()->back()->with('error', 'Team Leader not found.');
    }

    public function deleteTL($id)
    
    {
        $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('4_8', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
        $tl = TeamLeader::find($id);
        if ($tl) {
            $tl->is_deleted = 1;
            $tl->save();
            return redirect()->back()->with('success', 'Team Leader deleted successfully.');
        }

        return redirect()->back()->with('error', 'Team Leader not found.');
    }

    public function updatetlStatus(Request $request, $id)
    {
        $tl = TeamLeader::find($id);
        if ($tl) {
            $tl->status = $request->status;
            $tl->save();
            return redirect()->back()->with('success', 'Status updated successfully.');
        }

        return redirect()->back()->with('error', 'Team Leader not found.');
    }

  public function export(Request $request)
{
    return Excel::download(new TeamLeaderExport($request), 'tls.xlsx');
}




    // Helper functions
    public function check_unique_name($key, $value)
    {
        return !TeamLeader::where($key, $value)->exists();
    }

    public function check_unique($key, $value)
    {
        $check = TeamLeader::where($key, $value)->first();
        if (!empty($check)) {
            $value .= '1';
            return $this->check_unique($key, $value);
        }

        return $value;
    }

    public function check_unique_name_edit($key, $value, $id)
    {
        return !TeamLeader::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_email_edit($key, $value, $id)
    {
        return !TeamLeader::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_phone_edit($key, $value, $id)
    {
        return !TeamLeader::where($key, $value)->where('id', '!=', $id)->exists();
    }
}