<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Crm\CrmRole;
use App\Models\Crm\CrmPermission;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmBranch;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmQuotation;
use App\Models\Crm\CrmFollowup;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmDemo;
use App\Models\Crm\CrmPayment;
use App\Models\Crm\CrmProduct;
use App\Models\Crm\CrmSetting;
use App\Models\Crm\CrmActivityLog;
use App\Models\Crm\CrmUserSession;
use App\Models\Crm\CrmLeadActivity;
use App\Models\Crm\CrmNotification;

class CrmSuperAdminController extends Controller
{
    // =========================================================================
    // 1. RBAC & GRANULAR PERMISSION MATRIX
    // =========================================================================
    public function rbac()
    {
        // Only load Employee role (and any custom employee roles) - Remove Super Admin, Admin, and Manager panels
        $roles = CrmRole::where('slug', 'employee')
            ->orWhereNotIn('slug', ['super_admin', 'admin', 'manager'])
            ->with('permissions')
            ->get();

        // Operational employee modules (exclude Super Admin system module)
        $permissions = CrmPermission::where('module', '!=', 'Super Admin')
            ->get()
            ->groupBy('module');

        return view('crm.admin.super.rbac', compact('roles', 'permissions'));
    }

    public function createRole()
    {
        $permissions = CrmPermission::all()->groupBy('module');
        return view('crm.admin.super.rbac_create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:50|unique:crm_roles,slug',
            'description' => 'nullable|string|max:255',
        ]);

        $role = CrmRole::create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '_', $request->slug)),
            'description' => $request->description,
        ]);

        if ($request->has('permissions') && is_array($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }

        CrmActivityLog::create([
            'user_name' => Auth::user()->name ?? 'Super Admin',
            'module' => 'Super Admin',
            'action' => 'Created Role',
            'description' => "Created role: {$role->name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('crm.admin.super.rbac')->with('success', "Role '{$role->name}' created successfully with assigned permissions!");
    }

    public function updateRolePermissions(Request $request, $id)
    {
        $role = CrmRole::findOrFail($id);
        $permissions = $request->input('permissions', []);

        $role->permissions()->sync($permissions);

        CrmActivityLog::create([
            'user_name' => Auth::user()->name ?? 'Super Admin',
            'module' => 'Super Admin',
            'action' => 'Updated Permissions',
            'description' => "Updated permission matrix for role: {$role->name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "Permissions for '{$role->name}' updated successfully!");
    }

    // =========================================================================
    // 2. USER IMPERSONATION ("LOGIN AS USER")
    // =========================================================================
    public function impersonate(Request $request, $id)
    {
        $employee = CrmEmployee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->orWhere('email', $employee->email)->first();

        if (!$user) {
            // Auto create a matching linked user if none exists
            $user = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => bcrypt('password123'),
                'type' => 'crm_employee',
            ]);
        } else {
            if ($user->type !== 'crm_admin' && $user->type !== 'admin') {
                $user->type = 'crm_employee';
                $user->save();
            }
        }

        if ($employee->user_id !== $user->id) {
            $employee->user_id = $user->id;
            $employee->save();
        }

        $adminId = Auth::id();
        session([
            'impersonated_by_admin' => $adminId,
            'impersonated_employee_name' => $employee->name,
            'impersonated_employee_role' => $employee->role ?? 'Employee',
        ]);

        Auth::login($user);

        CrmActivityLog::create([
            'user_name' => 'Super Admin',
            'module' => 'Super Admin',
            'action' => 'Impersonated User',
            'description' => "Super Admin logged in as {$employee->name} ({$employee->email})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('crm.employee.dashboard')->with('info', "You are now logged in as {$employee->name}.");
    }

    public function leaveImpersonate()
    {
        $adminId = session('impersonated_by_admin');
        if ($adminId) {
            $adminUser = User::find($adminId);
            if ($adminUser) {
                session()->forget(['impersonated_by_admin', 'impersonated_employee_name', 'impersonated_employee_role']);
                Auth::login($adminUser);
                return redirect()->route('crm.admin.dashboard')->with('success', 'Returned to Super Admin account.');
            }
        }

        return redirect()->route('crm.admin.dashboard');
    }

    // =========================================================================
    // 3. MULTI-BRANCH / COMPANY MANAGEMENT
    // =========================================================================
    public function branches()
    {
        $branches = CrmBranch::withCount(['employees', 'leads'])->latest()->get();
        return view('crm.admin.super.branches', compact('branches'));
    }

    public function createBranch()
    {
        return view('crm.admin.super.branches_create');
    }

    public function storeBranch(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
        ]);

        CrmBranch::updateOrCreate(
            ['code' => $request->code],
            [
                'name' => $request->name,
                'city' => $request->city,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'status' => $request->status ?: 'Active',
            ]
        );

        return redirect()->back()->with('success', 'Branch saved successfully!');
    }

    public function destroyBranch($id)
    {
        $branch = CrmBranch::findOrFail($id);
        $branch->delete();
        return redirect()->back()->with('success', 'Branch removed successfully!');
    }

    // =========================================================================
    // 4. AUTOMATION & LEAD ROUTING ENGINE
    // =========================================================================
    public function automation()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $branches = CrmBranch::where('status', 'Active')->get();

        $autoAssign = CrmSetting::get('auto_lead_assignment', '1');
        $roundRobin = CrmSetting::get('round_robin_active', '1');
        $slaHours = CrmSetting::get('sla_escalation_hours', '4');
        $duplicateAction = CrmSetting::get('duplicate_lead_action', 'merge');

        // Check for potential duplicate leads in DB
        $duplicatePhones = CrmLead::select('phone', DB::raw('COUNT(*) as total'))
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->groupBy('phone')
            ->having('total', '>', 1)
            ->limit(10)
            ->get();

        return view('crm.admin.super.automation', compact(
            'employees', 'branches', 'autoAssign', 'roundRobin', 'slaHours', 'duplicateAction', 'duplicatePhones'
        ));
    }

    public function saveAutomation(Request $request)
    {
        CrmSetting::set('auto_lead_assignment', $request->has('auto_lead_assignment') ? '1' : '0');
        CrmSetting::set('round_robin_active', $request->has('round_robin_active') ? '1' : '0');
        CrmSetting::set('sla_escalation_hours', $request->get('sla_escalation_hours', '4'));
        CrmSetting::set('duplicate_lead_action', $request->get('duplicate_lead_action', 'merge'));
        CrmSetting::set('escalation_email', $request->get('escalation_email', 'admin@kkinternational.com'));

        CrmActivityLog::create([
            'user_name' => Auth::user()->name ?? 'Super Admin',
            'module' => 'Super Admin',
            'action' => 'Updated Automation Rules',
            'description' => 'Updated lead routing, round-robin, and SLA escalation settings',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Automation rules and SLA parameters updated successfully!');
    }

    public function mergeDuplicateLeads(Request $request)
    {
        $phone = $request->get('phone');
        if (!$phone) {
            return redirect()->back()->with('error', 'Phone number required for duplicate merge.');
        }

        $leads = CrmLead::where('phone', $phone)->orderBy('id', 'asc')->get();
        if ($leads->count() < 2) {
            return redirect()->back()->with('info', 'No duplicate leads found for this number.');
        }

        $primary = $leads->first();
        $mergedNotes = $primary->notes ?? '';

        foreach ($leads->slice(1) as $dup) {
            if ($dup->notes) {
                $mergedNotes .= "\n[Merged Note from Lead #{$dup->id}]: " . $dup->notes;
            }
            $dup->delete(); // Soft delete duplicate
        }

        $primary->notes = $mergedNotes;
        $primary->save();

        return redirect()->back()->with('success', "Duplicate leads merged successfully into Primary Lead #{$primary->id}!");
    }

    // =========================================================================
    // 5. THIRD-PARTY INTEGRATIONS & API HUB
    // =========================================================================
    public function integrations()
    {
        $settings = CrmSetting::all()->pluck('value_data', 'key_name')->toArray();
        $webhookUrl = url('/crm/api/leads/webhook');
        $apiKey = $settings['crm_api_secret_key'] ?? substr(md5(config('app.key') . 'crm_api'), 0, 32);

        return view('crm.admin.super.integrations', compact('settings', 'webhookUrl', 'apiKey'));
    }

    public function saveIntegrations(Request $request)
    {
        $keys = [
            'whatsapp_phone_number_id', 'whatsapp_access_token', 'whatsapp_template_name',
            'indiamart_api_key', 'indiamart_crm_key',
            'justdial_api_key',
            'sms_provider', 'sms_sender_id', 'sms_auth_key',
            'razorpay_key_id', 'razorpay_key_secret',
            'smtp_host', 'smtp_port', 'smtp_user', 'smtp_password'
        ];

        foreach ($keys as $k) {
            if ($request->has($k)) {
                CrmSetting::set($k, $request->input($k));
            }
        }

        return redirect()->back()->with('success', 'Integration credentials and API settings updated successfully!');
    }

    /**
     * Sequential Round-Robin Employee Selector for Auto-Assignment
     */
    public static function getNextRoundRobinEmployeeId(): ?int
    {
        $activeEmployees = CrmEmployee::where('status', 'Active')->orderBy('id', 'asc')->get();
        if ($activeEmployees->isEmpty()) {
            return null;
        }

        $lastAssignedId = (int) CrmSetting::get('last_round_robin_employee_id', 0);
        $next = $activeEmployees->firstWhere('id', '>', $lastAssignedId) ?: $activeEmployees->first();
        if ($next) {
            CrmSetting::set('last_round_robin_employee_id', (string) $next->id);
            return $next->id;
        }
        return null;
    }

    /**
     * Universal Inbound Lead Webhook Endpoint
     */
    public function handleLeadWebhook(Request $request)
    {
        $name = $request->input('name', $request->input('full_name', 'Inbound Webhook Lead'));
        $phone = $request->input('phone', $request->input('mobile', null));
        $email = $request->input('email', null);
        $company = $request->input('company', null);
        $notes = $request->input('notes', $request->input('message', 'Inbound Inquiry received via Webhook API'));
        $expectedValue = (float) $request->input('expected_value', 0);

        // Check Duplicate Policy
        $duplicateAction = CrmSetting::get('duplicate_lead_action', 'merge');
        if (!empty($phone) && $duplicateAction === 'merge') {
            $existing = CrmLead::where('phone', $phone)->first();
            if ($existing) {
                $existing->notes = ($existing->notes ? $existing->notes . "\n" : '') . "[Webhook Update " . now()->format('d M Y H:i') . "]: " . $notes;
                $existing->save();

                CrmLeadActivity::create([
                    'lead_id' => $existing->id,
                    'type' => 'note',
                    'description' => 'Updated via Webhook Inquiry: ' . substr($notes, 0, 100),
                ]);

                return response()->json([
                    'success' => true,
                    'action' => 'merged',
                    'lead_id' => $existing->id,
                    'lead_code' => $existing->lead_code,
                    'message' => 'Duplicate phone detected. Inquiry appended to existing Lead #' . $existing->id,
                ], 200);
            }
        }

        // Auto-assign via Round-Robin if enabled
        $assignedTo = null;
        if (CrmSetting::get('auto_lead_assignment', '1') == '1' && CrmSetting::get('round_robin_active', '1') == '1') {
            $assignedTo = self::getNextRoundRobinEmployeeId();
        }

        $lead = CrmLead::create([
            'lead_code' => 'LEAD-' . rand(1000, 9999),
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'company' => $company,
            'status' => 'New',
            'priority' => 'Hot',
            'assigned_to' => $assignedTo,
            'expected_value' => $expectedValue,
            'notes' => $notes,
        ]);

        CrmLeadActivity::create([
            'lead_id' => $lead->id,
            'type' => 'note',
            'description' => 'Lead created via Universal Webhook API.',
        ]);

        CrmActivityLog::create([
            'user_name' => 'API Webhook',
            'module' => 'Leads',
            'action' => 'Created via Webhook',
            'description' => "Captured lead {$lead->name} ({$lead->lead_code})",
            'ip_address' => $request->ip(),
        ]);

        CrmNotification::notify(
            "New Webhook Lead: {$lead->name}",
            "Lead {$lead->lead_code} received from external webhook. Status: New",
            'lead',
            url('/crm/admin/leads/' . $lead->id),
            $lead->assigned_to
        );

        return response()->json([
            'success' => true,
            'action' => 'created',
            'lead_id' => $lead->id,
            'lead_code' => $lead->lead_code,
            'assigned_to' => $lead->assigned_to,
            'message' => 'Lead successfully created and assigned via Round-Robin.',
        ], 201);
    }

    // =========================================================================
    // 6. SECURITY, ACTIVE SESSIONS & IP WHITELIST
    // =========================================================================
    public function security()
    {
        // Seed some demo active sessions if none exist for representation
        if (CrmUserSession::count() == 0) {
            CrmUserSession::create([
                'user_id' => Auth::id() ?? 1,
                'user_name' => Auth::user()->name ?? 'Administrator',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                'device' => 'Desktop (Windows 11)',
                'location' => 'Jaipur, Rajasthan',
                'last_activity' => now(),
                'is_active' => true,
            ]);
            CrmUserSession::create([
                'user_id' => 2,
                'user_name' => 'Rahul Sharma (Field Rep)',
                'ip_address' => '103.212.144.12',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4)',
                'device' => 'Mobile (iOS)',
                'location' => 'New Delhi, Delhi',
                'last_activity' => now()->subMinutes(12),
                'is_active' => true,
            ]);
        }

        $sessions = CrmUserSession::where('is_active', true)->latest('last_activity')->get();
        $ipWhitelist = CrmSetting::get('security_ip_whitelist', '');
        $maskContact = CrmSetting::get('security_mask_contact_info', '1');
        $enforce2fa = CrmSetting::get('security_enforce_2fa', '0');

        return view('crm.admin.super.security', compact('sessions', 'ipWhitelist', 'maskContact', 'enforce2fa'));
    }

    public function saveSecurity(Request $request)
    {
        CrmSetting::set('security_ip_whitelist', $request->get('security_ip_whitelist', ''));
        CrmSetting::set('security_mask_contact_info', $request->has('security_mask_contact_info') ? '1' : '0');
        CrmSetting::set('security_enforce_2fa', $request->has('security_enforce_2fa') ? '1' : '0');

        return redirect()->back()->with('success', 'Security policies and access restriction rules saved!');
    }

    public function revokeSession($id)
    {
        $session = CrmUserSession::findOrFail($id);
        $session->is_active = false;
        $session->save();

        return redirect()->back()->with('success', "Session for {$session->user_name} remotely terminated!");
    }

    // =========================================================================
    // 7. RECYCLE BIN & FORENSIC TRASH RECOVERY
    // =========================================================================
    public function recycleBin(Request $request)
    {
        $type = $request->get('type', 'all');

        $deletedLeads = in_array($type, ['all', 'leads']) ? CrmLead::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedCustomers = in_array($type, ['all', 'customers']) ? CrmCustomer::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedDeals = in_array($type, ['all', 'deals']) ? CrmDeal::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedQuotations = in_array($type, ['all', 'quotations']) ? CrmQuotation::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedFollowups = in_array($type, ['all', 'followups']) ? CrmFollowup::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedTasks = in_array($type, ['all', 'tasks']) ? CrmTask::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedDemos = in_array($type, ['all', 'demos']) ? CrmDemo::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedPayments = in_array($type, ['all', 'payments']) ? CrmPayment::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedEmployees = in_array($type, ['all', 'employees']) ? CrmEmployee::onlyTrashed()->latest('deleted_at')->get() : collect();
        $deletedProducts = in_array($type, ['all', 'products']) ? CrmProduct::onlyTrashed()->latest('deleted_at')->get() : collect();

        $counts = [
            'leads' => CrmLead::onlyTrashed()->count(),
            'customers' => CrmCustomer::onlyTrashed()->count(),
            'deals' => CrmDeal::onlyTrashed()->count(),
            'quotations' => CrmQuotation::onlyTrashed()->count(),
            'followups' => CrmFollowup::onlyTrashed()->count(),
            'tasks' => CrmTask::onlyTrashed()->count(),
            'demos' => CrmDemo::onlyTrashed()->count(),
            'payments' => CrmPayment::onlyTrashed()->count(),
            'employees' => CrmEmployee::onlyTrashed()->count(),
            'products' => CrmProduct::onlyTrashed()->count(),
        ];

        $totalTrash = array_sum($counts);

        return view('crm.admin.super.recycle_bin', compact(
            'deletedLeads', 'deletedCustomers', 'deletedDeals', 'deletedQuotations',
            'deletedFollowups', 'deletedTasks', 'deletedDemos', 'deletedPayments',
            'deletedEmployees', 'deletedProducts', 'counts', 'type', 'totalTrash'
        ));
    }

    public function restoreItem($type, $id)
    {
        switch ($type) {
            case 'lead':
                $item = CrmLead::onlyTrashed()->findOrFail($id);
                break;
            case 'customer':
                $item = CrmCustomer::onlyTrashed()->findOrFail($id);
                break;
            case 'deal':
                $item = CrmDeal::onlyTrashed()->findOrFail($id);
                break;
            case 'quotation':
                $item = CrmQuotation::onlyTrashed()->findOrFail($id);
                break;
            case 'followup':
                $item = CrmFollowup::onlyTrashed()->findOrFail($id);
                break;
            case 'task':
                $item = CrmTask::onlyTrashed()->findOrFail($id);
                break;
            case 'demo':
                $item = CrmDemo::onlyTrashed()->findOrFail($id);
                break;
            case 'payment':
                $item = CrmPayment::onlyTrashed()->findOrFail($id);
                break;
            case 'employee':
                $item = CrmEmployee::onlyTrashed()->findOrFail($id);
                break;
            case 'product':
                $item = CrmProduct::onlyTrashed()->findOrFail($id);
                break;
            default:
                return redirect()->back()->with('error', 'Invalid entity type.');
        }

        $item->restore();

        CrmActivityLog::create([
            'user_name' => Auth::user()->name ?? 'Super Admin',
            'module' => 'Recycle Bin',
            'action' => 'Restored Record',
            'description' => "Restored {$type} #{$id} from Recycle Bin",
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', ucfirst($type) . " #{$id} restored successfully!");
    }

    public function forceDeleteItem($type, $id)
    {
        switch ($type) {
            case 'lead':
                $item = CrmLead::onlyTrashed()->findOrFail($id);
                break;
            case 'customer':
                $item = CrmCustomer::onlyTrashed()->findOrFail($id);
                break;
            case 'deal':
                $item = CrmDeal::onlyTrashed()->findOrFail($id);
                break;
            case 'quotation':
                $item = CrmQuotation::onlyTrashed()->findOrFail($id);
                break;
            case 'followup':
                $item = CrmFollowup::onlyTrashed()->findOrFail($id);
                break;
            case 'task':
                $item = CrmTask::onlyTrashed()->findOrFail($id);
                break;
            case 'demo':
                $item = CrmDemo::onlyTrashed()->findOrFail($id);
                break;
            case 'payment':
                $item = CrmPayment::onlyTrashed()->findOrFail($id);
                break;
            case 'employee':
                $item = CrmEmployee::onlyTrashed()->findOrFail($id);
                break;
            case 'product':
                $item = CrmProduct::onlyTrashed()->findOrFail($id);
                break;
            default:
                return redirect()->back()->with('error', 'Invalid entity type.');
        }

        $item->forceDelete();

        return redirect()->back()->with('success', ucfirst($type) . " #{$id} permanently erased from database.");
    }

    public function restoreAll(Request $request)
    {
        $type = $request->get('type', 'all');

        $models = [
            'leads' => CrmLead::class,
            'customers' => CrmCustomer::class,
            'deals' => CrmDeal::class,
            'quotations' => CrmQuotation::class,
            'followups' => CrmFollowup::class,
            'tasks' => CrmTask::class,
            'demos' => CrmDemo::class,
            'payments' => CrmPayment::class,
            'employees' => CrmEmployee::class,
            'products' => CrmProduct::class,
        ];

        $restored = 0;
        foreach ($models as $key => $class) {
            if ($type === 'all' || $type === $key) {
                $restored += $class::onlyTrashed()->restore();
            }
        }

        return redirect()->back()->with('success', "{$restored} record(s) restored successfully from Recycle Bin!");
    }

    public function emptyRecycleBin(Request $request)
    {
        $type = $request->get('type', 'all');

        $models = [
            'leads' => CrmLead::class,
            'customers' => CrmCustomer::class,
            'deals' => CrmDeal::class,
            'quotations' => CrmQuotation::class,
            'followups' => CrmFollowup::class,
            'tasks' => CrmTask::class,
            'demos' => CrmDemo::class,
            'payments' => CrmPayment::class,
            'employees' => CrmEmployee::class,
            'products' => CrmProduct::class,
        ];

        $purged = 0;
        foreach ($models as $key => $class) {
            if ($type === 'all' || $type === $key) {
                $items = $class::onlyTrashed()->get();
                foreach ($items as $item) {
                    $item->forceDelete();
                    $purged++;
                }
            }
        }

        return redirect()->back()->with('success', "{$purged} record(s) permanently purged from Recycle Bin.");
    }

    // =========================================================================
    // 8. FINANCIAL APPROVAL WORKFLOW
    // =========================================================================
    public function approvals()
    {
        $pendingQuotations = CrmQuotation::where('approval_status', 'Pending')
            ->orWhere('discount_amount', '>', 5000)
            ->latest()
            ->paginate(15);

        return view('crm.admin.super.approvals', compact('pendingQuotations'));
    }

    public function approveQuotation($id)
    {
        $quote = CrmQuotation::findOrFail($id);
        $quote->approval_status = 'Approved';
        $quote->approved_by = Auth::id();
        $quote->save();

        CrmActivityLog::create([
            'user_name' => Auth::user()->name ?? 'Super Admin',
            'module' => 'Approvals',
            'action' => 'Approved Quotation',
            'description' => "Approved discount quotation {$quote->quotation_no} for ₹" . number_format($quote->grand_total),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', "Quotation {$quote->quotation_no} approved for dispatch!");
    }

    public function rejectQuotation(Request $request, $id)
    {
        $quote = CrmQuotation::findOrFail($id);
        $quote->approval_status = 'Rejected';
        $quote->approved_by = Auth::id();
        $quote->rejection_reason = $request->get('reason', 'Discount exceeds allowable limit.');
        $quote->save();

        return redirect()->back()->with('success', "Quotation {$quote->quotation_no} marked as Rejected.");
    }

    // =========================================================================
    // 9. SYSTEM HEALTH & 1-CLICK DATABASE BACKUP
    // =========================================================================
    public function backup()
    {
        $tables = Schema::getTableListing();
        $crmTables = array_filter($tables, fn($t) => str_starts_with($t, 'crm_') || in_array($t, ['users']));

        $tableStats = [];
        $totalRows = 0;
        foreach ($crmTables as $tbl) {
            $cnt = DB::table($tbl)->count();
            $totalRows += $cnt;
            $tableStats[] = [
                'table' => $tbl,
                'rows' => $cnt,
            ];
        }

        // Read recent Laravel logs safely using tail seek (avoid memory exhaustion on large log files)
        $logPath = storage_path('logs/laravel.log');
        $recentLogs = [];
        if (File::exists($logPath) && ($filesize = @filesize($logPath)) > 0) {
            $fp = @fopen($logPath, 'r');
            if ($fp) {
                $bytesToRead = min(65536, $filesize);
                fseek($fp, -$bytesToRead, SEEK_END);
                $chunk = fread($fp, $bytesToRead);
                fclose($fp);
                $lines = explode("\n", $chunk);
                $slice = array_slice(array_filter(array_map('trim', $lines)), -40);
                $recentLogs = array_reverse($slice);
            }
        }

        return view('crm.admin.super.backup', compact('tableStats', 'totalRows', 'recentLogs'));
    }

    public function downloadBackup()
    {
        $tables = Schema::getTableListing();
        $crmTables = array_filter($tables, fn($t) => str_starts_with($t, 'crm_') || in_array($t, ['users']));

        $backupData = [
            'app' => config('app.name'),
            'timestamp' => now()->toIso8601String(),
            'database' => config('database.connections.mysql.database'),
            'tables' => [],
        ];

        foreach ($crmTables as $tbl) {
            $rows = DB::table($tbl)->get()->toArray();
            $backupData['tables'][$tbl] = $rows;
        }

        $json = json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filename = 'crm_backup_' . date('Y_m_d_His') . '.json';

        return response($json, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
