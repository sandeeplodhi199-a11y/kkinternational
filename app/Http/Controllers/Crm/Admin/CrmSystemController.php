<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmActivityLog;
use App\Models\Crm\CrmNotification;
use App\Models\Crm\CrmSetting;
use App\Models\Crm\CrmRole;

class CrmSystemController extends Controller
{
    public function activityLogs(Request $request)
    {
        $query = CrmActivityLog::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('action', $request->get('type'));
        }

        $perPage = (int) $request->get('per_page', 25);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $logs = $query->latest('id')->paginate($perPage)->withQueryString();

        return view('crm.admin.system.activity_logs', compact('logs'));
    }

    public function notifications(Request $request)
    {
        // Auto-sync if notifications are empty
        if (CrmNotification::count() === 0) {
            CrmNotification::syncSystemNotifications();
        }

        $tab = $request->get('tab', 'all');
        $query = CrmNotification::query();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sq) use ($q) {
                $sq->where('title', 'like', "%{$q}%")
                   ->orWhere('message', 'like', "%{$q}%");
            });
        }

        if ($tab === 'unread') {
            $query->where('is_read', false);
        } elseif ($tab === 'lead') {
            $query->whereIn('type', ['lead', 'customer']);
        } elseif ($tab === 'followup') {
            $query->where('type', 'followup');
        } elseif ($tab === 'task') {
            $query->whereIn('type', ['task', 'demo']);
        } elseif ($tab === 'payment') {
            $query->whereIn('type', ['payment', 'deal', 'quotation']);
        } elseif ($tab === 'system') {
            $query->whereIn('type', ['system', 'warning', 'info']);
        }

        $counts = [
            'all' => CrmNotification::count(),
            'unread' => CrmNotification::where('is_read', false)->count(),
            'lead' => CrmNotification::whereIn('type', ['lead', 'customer'])->count(),
            'followup' => CrmNotification::where('type', 'followup')->count(),
            'task' => CrmNotification::whereIn('type', ['task', 'demo'])->count(),
            'payment' => CrmNotification::whereIn('type', ['payment', 'deal', 'quotation'])->count(),
            'system' => CrmNotification::whereIn('type', ['system', 'warning', 'info'])->count(),
        ];

        $notifications = $query->latest('id')->paginate(15)->withQueryString();

        return view('crm.admin.system.notifications', compact('notifications', 'counts', 'tab'));
    }

    public function markAllNotificationsRead()
    {
        CrmNotification::where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function deleteNotification($id)
    {
        CrmNotification::destroy($id);
        return redirect()->back()->with('success', 'Notification removed.');
    }

    public function clearAllNotifications()
    {
        CrmNotification::truncate();
        return redirect()->back()->with('success', 'Notification history cleared.');
    }

    public function syncNotifications()
    {
        CrmNotification::syncSystemNotifications();
        return redirect()->back()->with('success', 'Notifications synced with all CRM events.');
    }

    public function roles()
    {
        try {
            $roles = CrmRole::all();
            if ($roles->isEmpty()) {
                $roles = collect([
                    (object) ['id' => 1, 'name' => 'CRM Super Administrator', 'slug' => 'super_admin', 'description' => 'Complete system-wide unrestricted access across all leads, deals, payments, targets, settings, and user administration.'],
                    (object) ['id' => 2, 'name' => 'Sales Manager', 'slug' => 'sales_manager', 'description' => 'Team-level deals tracking, deal approvals, lead reassignments, quotation validation, and performance KPI monitoring.'],
                    (object) ['id' => 3, 'name' => 'Sales Executive', 'slug' => 'sales_executive', 'description' => 'Direct lead progression, followup reminders, deal stage transitions, client communication, and personal target reporting.'],
                    (object) ['id' => 4, 'name' => 'Operations & Field Agent', 'slug' => 'operations_agent', 'description' => 'Live route tracking, on-site demo reservations, customer onboarding, visit notes, and verified field check-ins.']
                ]);
            }
        } catch (\Throwable $e) {
            $roles = collect([
                (object) ['id' => 1, 'name' => 'CRM Super Administrator', 'slug' => 'super_admin', 'description' => 'Complete system-wide unrestricted access across all leads, deals, payments, targets, settings, and user administration.'],
                (object) ['id' => 2, 'name' => 'Sales Manager', 'slug' => 'sales_manager', 'description' => 'Team-level deals tracking, deal approvals, lead reassignments, quotation validation, and performance KPI monitoring.'],
                (object) ['id' => 3, 'name' => 'Sales Executive', 'slug' => 'sales_executive', 'description' => 'Direct lead progression, followup reminders, deal stage transitions, client communication, and personal target reporting.'],
                (object) ['id' => 4, 'name' => 'Operations & Field Agent', 'slug' => 'operations_agent', 'description' => 'Live route tracking, on-site demo reservations, customer onboarding, visit notes, and verified field check-ins.']
            ]);
        }
        return view('crm.admin.system.roles', compact('roles'));
    }

    public function settings()
    {
        $settings = CrmSetting::all()->pluck('value_data', 'key_name')->toArray();
        return view('crm.admin.system.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        // Handle file upload for company_logo
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $uploadDir = public_path('uploads/crm');
            if (!\Illuminate\Support\Facades\File::exists($uploadDir)) {
                \Illuminate\Support\Facades\File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'crm_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            CrmSetting::set('company_logo', 'uploads/crm/' . $filename);
        }

        $inputs = $request->except(['_token', 'company_logo']);

        // Checkbox toggles default to 0 if not present in request
        $toggleKeys = [
            'notify_new_lead_email',
            'notify_welcome_message',
            'notify_daily_digest',
            'allow_multi_login'
        ];
        foreach ($toggleKeys as $tk) {
            if (!$request->has($tk)) {
                $inputs[$tk] = '0';
            }
        }

        foreach ($inputs as $key => $val) {
            CrmSetting::set($key, is_array($val) ? json_encode($val) : (string) $val);
        }

        return redirect()->back()->with('success', 'System configuration & corporate settings updated successfully!');
    }

    public function liveTracking(Request $request)
    {
        // Ensure reference employees from format design exist
        $referenceEmployees = [
            ['name' => 'Rahul Sharma', 'email' => 'rahul.sharma@hisabmittra.com', 'employee_code' => 'EMP-006', 'designation' => 'Field Executive'],
            ['name' => 'Vipin', 'email' => 'vipin@hisabmittra.com', 'employee_code' => 'EMP-007', 'designation' => 'Field Representative'],
            ['name' => 'Nandkishor Chouhan', 'email' => 'nandkishor@hisabmittra.com', 'employee_code' => 'EMP-008', 'designation' => 'Area Sales Manager'],
        ];

        foreach ($referenceEmployees as $ref) {
            \App\Models\Crm\CrmEmployee::firstOrCreate(
                ['name' => $ref['name']],
                array_merge($ref, [
                    'status' => 'Active',
                    'role' => 'Sales',
                    'phone' => '+91 98765 00000',
                ])
            );
        }

        $selectedDate = $request->get('date', date('Y-m-d'));
        $selectedEmployeeId = $request->get('employee_id');

        // Fetch employees with prioritization for reference layout: Rahul Sharma, Vipin, Nandkishor Chouhan
        $employees = \App\Models\Crm\CrmEmployee::all()->sortBy(function ($emp) {
            if ($emp->name === 'Rahul Sharma') return 1;
            if ($emp->name === 'Vipin') return 2;
            if ($emp->name === 'Nandkishor Chouhan') return 3;
            return 10 + $emp->id;
        })->values();

        // Assign metrics for each employee
        foreach ($employees as $emp) {
            $emp->visits = \App\Models\Crm\CrmLead::where('assigned_to', $emp->id)->whereDate('created_at', $selectedDate)->count();
            $emp->km = 'null';
            $emp->in_time = 'null';
            $emp->out_time = 'null';
        }

        // Assigned leads for selected employee or date
        $leadQuery = \App\Models\Crm\CrmLead::query();
        if ($selectedEmployeeId) {
            $leadQuery->where('assigned_to', $selectedEmployeeId);
        } else {
            // When all employees, check if there are leads created today
            $leadQuery->whereDate('created_at', $selectedDate);
        }
        $assignedLeads = $leadQuery->latest()->get();

        // Activity logs
        $activityQuery = CrmActivityLog::query();
        if ($selectedDate) {
            $activityQuery->whereDate('created_at', $selectedDate);
        }
        if ($selectedEmployeeId) {
            $empObj = $employees->firstWhere('id', $selectedEmployeeId);
            if ($empObj) {
                $activityQuery->where(function ($q) use ($empObj) {
                    $q->where('user_name', $empObj->name)
                      ->orWhere('description', 'like', "%{$empObj->name}%");
                });
            }
        }
        $activityLogs = $activityQuery->latest()->get();

        return view('crm.admin.system.live_tracking', compact(
            'employees',
            'selectedDate',
            'selectedEmployeeId',
            'assignedLeads',
            'activityLogs'
        ));
    }
}
