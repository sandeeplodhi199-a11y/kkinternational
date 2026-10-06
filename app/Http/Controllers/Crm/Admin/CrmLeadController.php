<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmLeadSource;
use App\Models\Crm\CrmLeadStatus;
use App\Models\Crm\CrmLeadActivity;
use App\Models\Crm\CrmActivityLog;
use App\Models\Crm\CrmBranch;

class CrmLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = CrmLead::with(['assignedEmployee', 'source']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('employee_id')) {
            $query->where('assigned_to', $request->employee_id);
        } elseif ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        if ($request->filled('search') || $request->filled('q')) {
            $s = $request->get('search', $request->get('q'));
            $cleanPhone = preg_replace('/[^0-9]/', '', $s);
            $query->where(function ($q) use ($s, $cleanPhone) {
                $q->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('company', 'LIKE', "%{$s}%")
                  ->orWhere('email', 'LIKE', "%{$s}%")
                  ->orWhere('phone', 'LIKE', "%{$s}%")
                  ->orWhere('lead_code', 'LIKE', "%{$s}%");
                if (strlen($cleanPhone) >= 3) {
                    $q->orWhereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ["%{$cleanPhone}%"]);
                }
            });
        }

        $leads = $query->latest('id')->paginate(50);
        $employees = CrmEmployee::where('status', 'Active')->get();
        $sources = CrmLeadSource::all();
        $statuses = CrmLeadStatus::orderBy('order_num')->get();

        return view('crm.admin.leads.index', compact('leads', 'employees', 'sources', 'statuses'));
    }

    public function kanban()
    {
        $stages = ['New', 'Contacted', 'Qualified', 'Proposal', 'Negotiation', 'Converted', 'Lost'];
        $kanban = [];
        foreach ($stages as $stage) {
            $kanban[$stage] = CrmLead::with('assignedEmployee')->where('status', $stage)->latest()->get();
        }
        $employees = CrmEmployee::where('status', 'Active')->get();

        return view('crm.admin.leads.kanban', compact('stages', 'kanban', 'employees'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $lead = CrmLead::findOrFail($id);
        $oldStatus = $lead->status;
        $lead->status = $request->status;
        $lead->save();

        CrmLeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'type' => 'status_change',
            'description' => "Status changed from '{$oldStatus}' to '{$lead->status}'.",
        ]);

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Leads',
            'action' => 'Status Updated',
            'description' => "Lead {$lead->name} status moved to {$lead->status}.",
            'ip_address' => $request->ip(),
        ]);

        if ($lead->status === 'Converted') {
            \App\Models\Crm\CrmNotification::notify(
                "🎉 Lead Converted: {$lead->name}",
                "Lead {$lead->lead_code} ({$lead->name}) has been successfully converted into an active customer!",
                'lead',
                url('/crm/admin/leads/' . $lead->id),
                $lead->assigned_to
            );
        }

        return response()->json(['success' => true, 'message' => 'Lead status updated successfully!']);
    }

    public function create()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $sources = CrmLeadSource::all();
        $statuses = CrmLeadStatus::orderBy('order_num')->get();
        $branches = CrmBranch::where('status', 'Active')->get();

        return view('crm.admin.leads.create', compact('employees', 'sources', 'statuses', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'source_id' => 'nullable|integer',
            'status' => 'required|string',
            'priority' => 'required|string',
            'assigned_to' => 'nullable|integer',
            'expected_value' => 'nullable|numeric',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $data['lead_code'] = 'LEAD-' . rand(1000, 9999);

        // Auto-assign via Round-Robin if unassigned and automation active
        if (empty($data['assigned_to']) && \App\Models\Crm\CrmSetting::get('auto_lead_assignment', '1') == '1' && \App\Models\Crm\CrmSetting::get('round_robin_active', '1') == '1') {
            $data['assigned_to'] = \App\Http\Controllers\Crm\Admin\CrmSuperAdminController::getNextRoundRobinEmployeeId();
        }

        $lead = CrmLead::create($data);

        CrmLeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'type' => 'note',
            'description' => 'Lead created in system.',
        ]);

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Leads',
            'action' => 'Created',
            'description' => "Created lead {$lead->name} ({$lead->lead_code})",
            'ip_address' => $request->ip(),
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "New Lead Created: {$lead->name}",
            "Lead {$lead->lead_code} added. Expected value: ₹" . number_format($lead->expected_value ?? 0) . " (Status: {$lead->status})",
            'lead',
            url('/crm/admin/leads/' . $lead->id),
            $lead->assigned_to
        );

        return redirect()->route('crm.admin.leads.index')->with('success', 'Lead created successfully!');
    }

    public function show($id)
    {
        $lead = CrmLead::with(['assignedEmployee', 'activities', 'followups', 'tasks'])->findOrFail($id);
        $employees = CrmEmployee::where('status', 'Active')->get();
        return view('crm.admin.leads.show', compact('lead', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $lead = CrmLead::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'assigned_to' => 'nullable|integer',
            'expected_value' => 'nullable|numeric',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $lead->update($data);
        return redirect()->back()->with('success', 'Lead details updated successfully!');
    }

    public function destroy($id)
    {
        $lead = CrmLead::findOrFail($id);
        $name = $lead->name;
        $lead->delete();

        return redirect()->route('crm.admin.leads.index')->with('success', "Lead {$name} deleted successfully.");
    }

    public function assign(Request $request, $id)
    {
        $lead = CrmLead::findOrFail($id);
        $lead->assigned_to = $request->input('assigned_to');
        $lead->save();

        $emp = CrmEmployee::find($lead->assigned_to);
        $empName = $emp ? $emp->name : 'Unassigned';

        CrmLeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'type' => 'assignment',
            'description' => "Lead assigned to {$empName}.",
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "Lead Assigned: {$lead->name}",
            "Lead {$lead->lead_code} has been assigned to {$empName}.",
            'lead',
            url('/crm/admin/leads/' . $lead->id),
            $lead->assigned_to
        );

        return redirect()->back()->with('success', "Lead assigned to {$empName} successfully!");
    }

    public function export()
    {
        $leads = CrmLead::with('assignedEmployee')->latest()->get();
        $filename = 'crm_leads_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Lead Code', 'Name', 'Email', 'Phone', 'Company', 'Status', 'Priority', 'Expected Value (INR)', 'Assigned To', 'Created Date']);

            foreach ($leads as $l) {
                fputcsv($file, [
                    $l->lead_code,
                    $l->name,
                    $l->email,
                    $l->phone,
                    $l->company,
                    $l->status,
                    $l->priority,
                    $l->expected_value,
                    $l->assignedEmployee ? $l->assignedEmployee->name : 'Unassigned',
                    $l->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkAssign(Request $request)
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $unassignedCount = CrmLead::whereNull('assigned_to')->count();
        $allCount = CrmLead::count();
        $newCount = CrmLead::where('status', 'New')->count();
        $contactedCount = CrmLead::where('status', 'Contacted')->count();
        $inProgressCount = CrmLead::where('status', 'In Progress')->count();
        $qualifiedCount = CrmLead::where('status', 'Qualified')->count();

        return view('crm.admin.leads.bulk_assign', compact(
            'employees',
            'unassignedCount',
            'allCount',
            'newCount',
            'contactedCount',
            'inProgressCount',
            'qualifiedCount'
        ));
    }

    public function processBulkAssign(Request $request)
    {
        // 1. Auto Assign (round-robin across active employees)
        if ($request->has('auto_assign') && $request->auto_assign == 1) {
            $employees = CrmEmployee::where('status', 'Active')->get();
            if ($employees->isEmpty()) {
                return redirect()->back()->with('error', 'No active sales reps available for auto-assignment.');
            }

            $leadIds = $request->lead_ids;
            if (empty($leadIds)) {
                $leadIds = CrmLead::whereNull('assigned_to')->pluck('id')->toArray();
                if (empty($leadIds)) {
                    $leadIds = CrmLead::pluck('id')->toArray();
                }
            }

            $empCount = $employees->count();
            $assignedCount = 0;

            foreach ($leadIds as $index => $leadId) {
                $emp = $employees[$index % $empCount];
                CrmLead::where('id', $leadId)->update(['assigned_to' => $emp->id]);
                CrmLeadActivity::create([
                    'lead_id' => $leadId,
                    'user_id' => auth()->id(),
                    'type' => 'assignment',
                    'description' => "Auto-assigned to {$emp->name}.",
                ]);
                $assignedCount++;
            }

            CrmActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Admin',
                'module' => 'Leads',
                'action' => 'Auto Assign',
                'description' => "Auto-assigned {$assignedCount} leads across {$empCount} sales reps.",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()->with('success', "Auto-assigned {$assignedCount} leads across {$empCount} sales reps!");
        }

        // 2. Assign All (all matching leads to selected employee)
        if ($request->has('assign_all') && $request->assign_all == 1) {
            $request->validate([
                'assigned_to' => 'required|integer|exists:crm_employees,id',
            ]);

            $employee = CrmEmployee::findOrFail($request->assigned_to);
            $query = CrmLead::query();
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('company', 'like', "%{$search}%");
                });
            }

            $allIds = $query->pluck('id')->toArray();
            $count = CrmLead::whereIn('id', $allIds)->update(['assigned_to' => $employee->id]);

            foreach ($allIds as $leadId) {
                CrmLeadActivity::create([
                    'lead_id' => $leadId,
                    'user_id' => auth()->id(),
                    'type' => 'assignment',
                    'description' => "Assigned to {$employee->name}.",
                ]);
            }

            return redirect()->back()->with('success', "Successfully assigned all {$count} leads to {$employee->name}!");
        }

        // 3. Round-Robin Lead Distribution Form
        if ($request->has('employee_ids')) {
            $request->validate([
                'employee_ids' => 'required|array|min:1',
                'employee_ids.*' => 'integer|exists:crm_employees,id',
            ], [
                'employee_ids.required' => 'Please select at least one employee from the list.',
                'employee_ids.min' => 'Please select at least one employee from the list.',
            ]);

            $pool = $request->get('lead_pool', 'unassigned');
            $query = CrmLead::query();

            if ($pool === 'unassigned') {
                $query->whereNull('assigned_to');
            } elseif ($pool === 'all') {
                // all leads
            } elseif (in_array($pool, ['New', 'Contacted', 'In Progress', 'Qualified', 'Converted', 'Lost'])) {
                $query->where('status', $pool);
            }

            $leadLimit = $request->filled('lead_count') && is_numeric($request->lead_count) && (int)$request->lead_count > 0 
                ? (int)$request->lead_count 
                : null;

            if ($leadLimit) {
                $leads = $query->latest('id')->take($leadLimit)->get();
            } else {
                $leads = $query->latest('id')->get();
            }

            if ($leads->isEmpty()) {
                return redirect()->back()->with('error', 'No leads found in the selected pool to distribute.');
            }

            $employeeIds = $request->employee_ids;
            $empCount = count($employeeIds);
            $totalDistributed = 0;

            foreach ($leads as $index => $lead) {
                $empId = $employeeIds[$index % $empCount];
                $lead->update(['assigned_to' => $empId]);
                $totalDistributed++;

                CrmLeadActivity::create([
                    'lead_id' => $lead->id,
                    'user_id' => auth()->id(),
                    'type' => 'assignment',
                    'description' => "Round-robin distributed to employee ID #{$empId}.",
                ]);
            }

            CrmActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Admin',
                'module' => 'Leads',
                'action' => 'Round-Robin Distribute',
                'description' => "Distributed {$totalDistributed} leads equally among {$empCount} employees.",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()->with('success', "Successfully distributed {$totalDistributed} leads equally among {$empCount} employees!");
        }

        // 4. Manual selection bulk assign
        $request->validate([
            'lead_ids' => 'required|array|min:1',
            'assigned_to' => 'required|integer|exists:crm_employees,id',
        ]);

        $employee = CrmEmployee::findOrFail($request->assigned_to);
        $count = CrmLead::whereIn('id', $request->lead_ids)->update(['assigned_to' => $employee->id]);

        foreach ($request->lead_ids as $leadId) {
            CrmLeadActivity::create([
                'lead_id' => $leadId,
                'user_id' => auth()->id(),
                'type' => 'assignment',
                'description' => "Bulk assigned to {$employee->name}.",
            ]);
        }

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Leads',
            'action' => 'Bulk Assign',
            'description' => "Assigned {$count} leads to employee {$employee->name}.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "Successfully assigned {$count} leads to {$employee->name}!");
    }

    public function upload()
    {
        $totalLeads = CrmLead::count();
        $recentUploaded = CrmLead::latest()->take(8)->get();
        return view('crm.admin.leads.upload', compact('totalLeads', 'recentUploaded'));
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0])) continue;
            CrmLead::create([
                'lead_code' => 'LEAD-' . rand(1000, 9999),
                'name' => $row[0] ?? 'New Lead',
                'email' => !empty($row[1]) ? $row[1] : null,
                'phone' => !empty($row[2]) ? $row[2] : null,
                'company' => !empty($row[3]) ? $row[3] : null,
                'status' => !empty($row[4]) ? $row[4] : 'New',
                'priority' => !empty($row[5]) ? $row[5] : 'Medium',
                'expected_value' => !empty($row[6]) && is_numeric($row[6]) ? $row[6] : 0,
            ]);
            $count++;
        }
        fclose($handle);

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Leads',
            'action' => 'CSV Import',
            'description' => "Uploaded {$count} leads via CSV batch import.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('crm.admin.leads.index')->with('success', "Successfully imported {$count} leads from CSV!");
    }

    public function sampleCsv()
    {
        $filename = 'sample_leads_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Phone', 'Company', 'Status', 'Priority', 'Expected Value']);
            fputcsv($file, ['Aarav Sharma', 'aarav@example.com', '9876543210', 'Sharma Enterprises', 'New', 'High', '45000']);
            fputcsv($file, ['Priya Patel', 'priya@techcorp.in', '9812345678', 'TechCorp India', 'Qualified', 'Medium', '60000']);
            fputcsv($file, ['Rohan Verma', 'rohan@apex.com', '9988776655', 'Apex Solutions', 'New', 'Low', '25000']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
