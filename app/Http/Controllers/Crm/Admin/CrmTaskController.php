<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmCustomer;

class CrmTaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = CrmTask::with(['assignedEmployee', 'lead', 'customer']);

        $today = Carbon::today()->format('Y-m-d');

        if ($status === 'today') {
            $query->whereDate('due_date', $today);
        } elseif ($status === 'upcoming') {
            $query->whereDate('due_date', '>', $today);
        } elseif ($status === 'overdue') {
            $query->whereDate('due_date', '<', $today)->where('status', '!=', 'Completed');
        } elseif ($status === 'completed') {
            $query->where('status', 'Completed');
        } elseif ($status === 'pending') {
            $query->where('status', 'Pending');
        }

        $tasks = $query->orderBy('due_date', 'asc')->paginate(12);

        $counts = [
            'all' => CrmTask::count(),
            'today' => CrmTask::whereDate('due_date', $today)->count(),
            'upcoming' => CrmTask::whereDate('due_date', '>', $today)->count(),
            'overdue' => CrmTask::whereDate('due_date', '<', $today)->where('status', '!=', 'Completed')->count(),
            'completed' => CrmTask::where('status', 'Completed')->count(),
        ];

        $employees = CrmEmployee::where('status', 'Active')->get();
        $leads = CrmLead::latest()->limit(20)->get();
        $customers = CrmCustomer::latest()->limit(20)->get();

        return view('crm.admin.tasks.index', compact('tasks', 'counts', 'status', 'employees', 'leads', 'customers'));
    }

    public function create()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $leads = CrmLead::latest()->get();
        $customers = CrmCustomer::latest()->get();
        return view('crm.admin.tasks.create', compact('employees', 'leads', 'customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|integer',
            'related_lead_id' => 'nullable|integer',
            'related_customer_id' => 'nullable|integer',
            'priority' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'nullable|string',
        ]);

        if (empty($data['priority'])) {
            $data['priority'] = 'Medium';
        }
        if (empty($data['status'])) {
            $data['status'] = 'Pending';
        }

        $task = CrmTask::create($data);

        \App\Models\Crm\CrmNotification::notify(
            "Task Scheduled: {$task->title}",
            ($task->description ? $task->description . " — " : "") . "Due: {$task->due_date} (Priority: {$task->priority}).",
            'task',
            url('/crm/admin/tasks'),
            $task->assigned_to
        );

        return redirect()->route('crm.admin.tasks.index')->with('success', 'Task scheduled successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = CrmTask::findOrFail($id);
        $task->status = $request->input('status');
        $task->save();

        if ($task->status === 'Completed') {
            \App\Models\Crm\CrmNotification::notify(
                "Task Completed: {$task->title}",
                "Task '{$task->title}' has been marked as Completed.",
                'task',
                url('/crm/admin/tasks'),
                $task->assigned_to
            );
        }

        return response()->json(['success' => true, 'message' => 'Task status updated!']);
    }

    public function destroy($id)
    {
        CrmTask::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Task removed.');
    }
}
