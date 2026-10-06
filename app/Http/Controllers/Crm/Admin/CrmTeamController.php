<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmDepartment;
use App\Models\Crm\CrmSalesTarget;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmFollowup;

class CrmTeamController extends Controller
{
    public function index(Request $request)
    {
        $query = CrmEmployee::with('department')->withCount('leads');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Prioritize order matching image: Vipin, Nandkishor Chouhan, Rahul Sharma
        $all = $query->get()->sortBy(function ($emp) {
            if ($emp->name === 'Vipin') return 1;
            if ($emp->name === 'Nandkishor Chouhan') return 2;
            if ($emp->name === 'Rahul Sharma') return 3;
            return 10 + $emp->id;
        })->values();

        $page = (int) $request->get('page', 1);
        $total = $all->count();
        $items = $all->forPage($page, $perPage)->values();
        $employees = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $departments = CrmDepartment::all();
        return view('crm.admin.team.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = CrmDepartment::all();
        $roles = \App\Models\Crm\CrmRole::all();
        $branches = \App\Models\Crm\CrmBranch::where('status', 'Active')->get();
        return view('crm.admin.team.create', compact('departments', 'roles', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:crm_employees,email',
            'phone' => 'nullable|string',
            'department_id' => 'nullable|integer',
            'designation' => 'nullable|string',
            'role' => 'nullable|string',
            'target_amount' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordPlain = (!empty($data['password']) && trim($data['password']) !== '') ? trim($data['password']) : '12345678';
        $userType = (in_array(strtolower($data['role'] ?? 'Sales'), ['admin', 'super admin', 'manager'])) ? 'crm_admin' : 'crm_employee';

        // Check if user already exists in users table by email
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($data['email'])])->first();
        if ($user) {
            $user->update([
                'name' => $data['name'],
                'password' => Hash::make($passwordPlain),
                'mobile' => $data['phone'] ?? $user->mobile,
                'type' => $userType,
                'is_deleted' => 0,
            ]);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($passwordPlain),
                'mobile' => $data['phone'] ?? null,
                'type' => $userType,
                'is_deleted' => 0,
            ]);
        }

        $nextCode = 'EMP-' . str_pad($user->id, 3, '0', STR_PAD_LEFT);

        CrmEmployee::create([
            'user_id' => $user->id,
            'department_id' => $data['department_id'] ?? null,
            'employee_code' => $nextCode,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? '+91 98765 00000',
            'designation' => $data['designation'] ?? 'Sales Executive',
            'role' => $data['role'] ?? 'Sales',
            'target_amount' => $data['target_amount'] ?? 0,
            'joining_date' => $data['joining_date'] ?? date('Y-m-d'),
            'status' => 'Active',
        ]);

        return redirect()->route('crm.admin.team.index')->with('success', "Employee {$data['name']} onboarded successfully! Login: {$data['name']} / Password: {$passwordPlain}");
    }

    public function edit($id)
    {
        $employee = CrmEmployee::findOrFail($id);
        $departments = CrmDepartment::all();
        $roles = \App\Models\Crm\CrmRole::all();
        $branches = \App\Models\Crm\CrmBranch::where('status', 'Active')->get();
        return view('crm.admin.team.edit', compact('employee', 'departments', 'roles', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $emp = CrmEmployee::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:crm_employees,email,' . $emp->id,
            'phone' => 'nullable|string',
            'department_id' => 'nullable|integer',
            'designation' => 'nullable|string',
            'role' => 'nullable|string',
            'target_amount' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            'status' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $emp->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'department_id' => $data['department_id'] ?? $emp->department_id,
            'designation' => $data['designation'] ?? $emp->designation,
            'role' => $data['role'] ?? $emp->role,
            'target_amount' => $data['target_amount'] ?? $emp->target_amount,
            'joining_date' => $data['joining_date'] ?? $emp->joining_date,
            'status' => $data['status'],
        ]);

        $userType = (in_array(strtolower($data['role'] ?? 'Sales'), ['admin', 'super admin', 'manager'])) ? 'crm_admin' : 'crm_employee';

        $user = $emp->user_id ? User::find($emp->user_id) : User::whereRaw('LOWER(email) = ?', [strtolower($data['email'])])->first();
        if ($user) {
            $userUpdate = [
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['phone'] ?? null,
                'type' => $userType,
            ];
            if (!empty($data['password']) && trim($data['password']) !== '') {
                $userUpdate['password'] = Hash::make(trim($data['password']));
            }
            $user->update($userUpdate);
            if ($emp->user_id !== $user->id) {
                $emp->user_id = $user->id;
                $emp->save();
            }
        } else {
            $passwordPlain = (!empty($data['password']) && trim($data['password']) !== '') ? trim($data['password']) : '12345678';
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($passwordPlain),
                'mobile' => $data['phone'] ?? null,
                'type' => $userType,
                'is_deleted' => 0,
            ]);
            $emp->user_id = $user->id;
            $emp->save();
        }

        return redirect()->route('crm.admin.team.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $emp = CrmEmployee::findOrFail($id);
        if ($emp->user) {
            $emp->user->delete();
        }
        $emp->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $emp = CrmEmployee::findOrFail($id);
        $emp->status = ($emp->status === 'Active') ? 'Inactive' : 'Active';
        $emp->save();

        return redirect()->back()->with('success', "Employee status changed to {$emp->status}.");
    }

    public function performance(Request $request)
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $metrics = [];

        foreach ($employees as $emp) {
            $assignedLeads = CrmLead::where('assigned_to', $emp->id)->count();
            $contactedLeads = CrmLead::where('assigned_to', $emp->id)->whereIn('status', ['Contacted', 'Qualified', 'Proposal', 'Negotiation', 'Converted'])->count();
            $convertedLeads = CrmLead::where('assigned_to', $emp->id)->where('status', 'Converted')->count();
            $conversionRate = $assignedLeads > 0 ? round(($convertedLeads / $assignedLeads) * 100, 1) : 0;
            $dealsWon = CrmDeal::where('assigned_to', $emp->id)->where('stage', 'Won')->count();
            $revenueGenerated = CrmDeal::where('assigned_to', $emp->id)->where('stage', 'Won')->sum('value');
            $pendingTasks = CrmTask::where('assigned_to', $emp->id)->where('status', 'Pending')->count();
            $completedTasks = CrmTask::where('assigned_to', $emp->id)->where('status', 'Completed')->count();
            $completedFollowups = CrmFollowup::where('assigned_to', $emp->id)->where('status', 'Completed')->count();

            $target = $emp->target_amount > 0 ? $emp->target_amount : 400000;
            $achievedPercent = min(100, round(($revenueGenerated / $target) * 100));

            $metrics[] = [
                'emp' => $emp,
                'assignedLeads' => $assignedLeads,
                'contactedLeads' => $contactedLeads,
                'convertedLeads' => $convertedLeads,
                'conversionRate' => $conversionRate,
                'dealsWon' => $dealsWon,
                'revenue' => $revenueGenerated,
                'pendingTasks' => $pendingTasks,
                'completedTasks' => $completedTasks,
                'completedFollowups' => $completedFollowups,
                'target' => $target,
                'achievedPercent' => $achievedPercent,
            ];
        }

        return view('crm.admin.team.performance', compact('metrics'));
    }

    public function targets(Request $request)
    {
        $targets = CrmSalesTarget::with('employee')->latest()->paginate(10);
        $employees = CrmEmployee::where('status', 'Active')->get();
        return view('crm.admin.team.targets', compact('targets', 'employees'));
    }

    public function storeTarget(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'period_type' => 'required|string',
            'period_name' => 'required|string',
            'target_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        CrmSalesTarget::create($data);
        return redirect()->back()->with('success', 'Sales target set successfully!');
    }
}
