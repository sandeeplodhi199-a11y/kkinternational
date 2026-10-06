<?php

namespace App\Http\Controllers\Crm\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmFollowup;
use App\Models\Crm\CrmPayment;
use App\Models\Crm\CrmQuotation;
use App\Models\Crm\CrmDemo;
use App\Models\Crm\CrmReservation;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmNotification;
use App\Models\Crm\CrmSalesTarget;

class CrmEmployeeDashboardController extends Controller
{
    protected function getEmployeeId()
    {
        $user = Auth::user();
        $emp = CrmEmployee::where('user_id', $user->id)->first();
        if (!$emp) {
            // fallback by email or default first employee
            $emp = CrmEmployee::where('email', $user->email)->first() ?? CrmEmployee::first();
        }
        return $emp ? $emp->id : 1;
    }

    public function dashboard(Request $request)
    {
        $empId = $this->getEmployeeId();
        $employee = CrmEmployee::find($empId);
        $today = Carbon::today()->format('Y-m-d');

        // Strictly assigned records
        $myTotalLeads = CrmLead::where('assigned_to', $empId)->count();
        $myNewLeads = CrmLead::where('assigned_to', $empId)->where('status', 'New')->count();
        $myConvertedLeads = CrmLead::where('assigned_to', $empId)->where('status', 'Converted')->count();
        $myCustomers = CrmCustomer::where('assigned_to', $empId)->count();
        $myDealsCount = CrmDeal::where('assigned_to', $empId)->count();
        $myRevenue = CrmDeal::where('assigned_to', $empId)->where('stage', 'Won')->sum('value');

        $todaysFollowups = CrmFollowup::where('assigned_to', $empId)->whereDate('date', $today)->where('status', 'Pending')->get();
        $pendingTasks = CrmTask::where('assigned_to', $empId)->where('status', 'Pending')->orderBy('due_date', 'asc')->limit(5)->get();

        $target = $employee->target_amount > 0 ? $employee->target_amount : 500000;
        $targetAchieved = min(100, round(($myRevenue / $target) * 100));

        // My Lead status distribution
        $statusCounts = [
            'New' => CrmLead::where('assigned_to', $empId)->where('status', 'New')->count(),
            'Contacted' => CrmLead::where('assigned_to', $empId)->where('status', 'Contacted')->count(),
            'Qualified' => CrmLead::where('assigned_to', $empId)->where('status', 'Qualified')->count(),
            'Proposal' => CrmLead::where('assigned_to', $empId)->where('status', 'Proposal')->count(),
            'Negotiation' => CrmLead::where('assigned_to', $empId)->where('status', 'Negotiation')->count(),
            'Converted' => $myConvertedLeads,
            'Lost' => CrmLead::where('assigned_to', $empId)->where('status', 'Lost')->count(),
        ];

        $recentLeads = CrmLead::where('assigned_to', $empId)->latest()->limit(5)->get();

        return view('crm.employee.dashboard', compact(
            'employee', 'myTotalLeads', 'myNewLeads', 'myConvertedLeads',
            'myCustomers', 'myDealsCount', 'myRevenue', 'todaysFollowups',
            'pendingTasks', 'target', 'targetAchieved', 'statusCounts', 'recentLeads'
        ));
    }

    public function myLeads(Request $request)
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.view')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to view Leads.');
        }

        $empId = $this->getEmployeeId();
        $query = CrmLead::where('assigned_to', $empId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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

        $leads = $query->latest()->paginate(10);
        return view('crm.employee.leads', compact('leads'));
    }

    public function myCustomers(Request $request)
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('customers.view')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to view Customers.');
        }

        $empId = $this->getEmployeeId();
        $customers = CrmCustomer::where('assigned_to', $empId)->latest()->paginate(10);
        return view('crm.employee.customers', compact('customers'));
    }

    public function myDeals(Request $request)
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('deals.view')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to view Deals.');
        }

        $empId = $this->getEmployeeId();
        $deals = CrmDeal::where('assigned_to', $empId)->latest()->paginate(10);
        return view('crm.employee.deals', compact('deals'));
    }

    public function myTasks(Request $request)
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('tasks.manage')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to manage Tasks.');
        }

        $empId = $this->getEmployeeId();
        $tasks = CrmTask::where('assigned_to', $empId)->latest()->paginate(10);
        return view('crm.employee.tasks', compact('tasks'));
    }

    public function myFollowups(Request $request)
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('followups.manage')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to manage Follow-ups.');
        }

        $empId = $this->getEmployeeId();
        $followups = CrmFollowup::where('assigned_to', $empId)->latest()->paginate(10);
        return view('crm.employee.followups', compact('followups'));
    }

    public function myCalendar()
    {
        $empId = $this->getEmployeeId();
        $events = [];

        foreach (CrmFollowup::where('assigned_to', $empId)->get() as $fu) {
            $events[] = [
                'id' => 'fu_' . $fu->id,
                'title' => 'Followup: ' . ($fu->notes ?: 'Scheduled Call'),
                'date' => $fu->date,
                'time' => $fu->time ? substr($fu->time, 0, 5) : '10:00',
                'type' => 'Followup',
                'color' => '#f59e0b',
            ];
        }

        foreach (CrmTask::where('assigned_to', $empId)->get() as $t) {
            $events[] = [
                'id' => 't_' . $t->id,
                'title' => 'Task: ' . $t->title,
                'date' => $t->due_date,
                'time' => '17:00',
                'type' => 'Task',
                'color' => '#3b82f6',
            ];
        }

        return view('crm.employee.calendar', compact('events'));
    }

    public function myPerformance()
    {
        if (!\App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('team.view')) {
            return redirect()->route('crm.employee.dashboard')->with('error', 'Access Denied: You do not have permission to view Performance Analytics.');
        }

        $empId = $this->getEmployeeId();
        $employee = CrmEmployee::find($empId);

        $leadsAssigned = CrmLead::where('assigned_to', $empId)->count();
        $leadsContacted = CrmLead::where('assigned_to', $empId)->whereIn('status', ['Contacted', 'Qualified', 'Proposal', 'Negotiation', 'Converted'])->count();
        $leadsConverted = CrmLead::where('assigned_to', $empId)->where('status', 'Converted')->count();
        $conversionRate = $leadsAssigned > 0 ? round(($leadsConverted / $leadsAssigned) * 100, 1) : 0;
        $dealsWon = CrmDeal::where('assigned_to', $empId)->where('stage', 'Won')->count();
        $revenue = CrmDeal::where('assigned_to', $empId)->where('stage', 'Won')->sum('value');
        $tasksCompleted = CrmTask::where('assigned_to', $empId)->where('status', 'Completed')->count();
        $followupsCompleted = CrmFollowup::where('assigned_to', $empId)->where('status', 'Completed')->count();

        $target = $employee->target_amount > 0 ? $employee->target_amount : 500000;
        $achievedPercent = min(100, round(($revenue / $target) * 100));

        return view('crm.employee.performance', compact(
            'employee', 'leadsAssigned', 'leadsContacted', 'leadsConverted', 'conversionRate',
            'dealsWon', 'revenue', 'tasksCompleted', 'followupsCompleted', 'target', 'achievedPercent'
        ));
    }

    public function myProfile()
    {
        $empId = $this->getEmployeeId();
        $employee = CrmEmployee::with('department')->find($empId);
        $user = Auth::user();
        return view('crm.employee.profile', compact('employee', 'user'));
    }

    public function notifications(Request $request)
    {
        $empId = $this->getEmployeeId();

        $query = CrmNotification::where(function ($q) use ($empId) {
            $q->where('user_id', $empId)
              ->orWhereNull('user_id');
        });

        $tab = $request->get('tab', 'all');
        if ($tab === 'unread') {
            $query->where('is_read', false);
        } elseif ($tab === 'lead') {
            $query->whereIn('type', ['lead', 'customer']);
        } elseif ($tab === 'followup') {
            $query->where('type', 'followup');
        } elseif ($tab === 'task') {
            $query->whereIn('type', ['task', 'demo']);
        }

        $counts = [
            'all' => CrmNotification::where(function ($q) use ($empId) {
                $q->where('user_id', $empId)->orWhereNull('user_id');
            })->count(),
            'unread' => CrmNotification::where(function ($q) use ($empId) {
                $q->where('user_id', $empId)->orWhereNull('user_id');
            })->where('is_read', false)->count(),
            'lead' => CrmNotification::where(function ($q) use ($empId) {
                $q->where('user_id', $empId)->orWhereNull('user_id');
            })->whereIn('type', ['lead', 'customer'])->count(),
            'followup' => CrmNotification::where(function ($q) use ($empId) {
                $q->where('user_id', $empId)->orWhereNull('user_id');
            })->where('type', 'followup')->count(),
            'task' => CrmNotification::where(function ($q) use ($empId) {
                $q->where('user_id', $empId)->orWhereNull('user_id');
            })->whereIn('type', ['task', 'demo'])->count(),
        ];

        $notifications = $query->latest('id')->paginate(15)->withQueryString();

        return view('crm.employee.notifications', compact('notifications', 'counts', 'tab'));
    }
}
