<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Crm\CrmFollowup;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmCustomer;

class CrmFollowupController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'today');
        $today = Carbon::today()->format('Y-m-d');

        $query = CrmFollowup::with(['assignedEmployee', 'lead', 'customer']);

        if ($tab === 'today') {
            $query->whereDate('date', $today);
        } elseif ($tab === 'upcoming') {
            $query->whereDate('date', '>', $today);
        } elseif ($tab === 'overdue') {
            $query->whereDate('date', '<', $today)->where('status', 'Pending');
        } elseif ($tab === 'completed') {
            $query->where('status', 'Completed');
        }

        $followups = $query->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);

        $counts = [
            'today' => CrmFollowup::whereDate('date', $today)->count(),
            'upcoming' => CrmFollowup::whereDate('date', '>', $today)->count(),
            'overdue' => CrmFollowup::whereDate('date', '<', $today)->where('status', 'Pending')->count(),
            'completed' => CrmFollowup::where('status', 'Completed')->count(),
        ];

        $employees = CrmEmployee::where('status', 'Active')->get();
        $leads = CrmLead::latest()->limit(20)->get();
        $customers = CrmCustomer::latest()->limit(20)->get();

        return view('crm.admin.followups.index', compact('followups', 'counts', 'tab', 'employees', 'leads', 'customers'));
    }

    public function create()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $leads = CrmLead::latest()->get();
        $customers = CrmCustomer::latest()->get();

        return view('crm.admin.followups.create', compact('employees', 'leads', 'customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_id' => 'nullable|integer',
            'customer_id' => 'nullable|integer',
            'assigned_to' => 'nullable|integer',
            'date' => 'required|date',
            'time' => 'nullable',
            'type' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if (empty($data['status'])) {
            $data['status'] = 'Pending';
        }

        if (empty($data['assigned_to']) && !empty($data['lead_id'])) {
            $lead = CrmLead::find($data['lead_id']);
            if ($lead && $lead->assigned_to) {
                $data['assigned_to'] = $lead->assigned_to;
            }
        }

        $followup = CrmFollowup::create($data);

        \App\Models\Crm\CrmNotification::notify(
            "Follow-up Scheduled (" . ($followup->type ?: 'Call') . ")",
            "Follow-up scheduled for " . $followup->date . ($followup->time ? " at " . $followup->time : "") . ". Notes: " . ($followup->notes ?: 'Pending client discussion.'),
            'followup',
            url('/crm/admin/followups'),
            $followup->assigned_to
        );

        return redirect()->route('crm.admin.followups.index')->with('success', 'Follow-up created successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $f = CrmFollowup::findOrFail($id);
        $f->status = $request->input('status');
        $f->save();

        if ($f->status === 'Completed') {
            \App\Models\Crm\CrmNotification::notify(
                "Follow-up Completed",
                "Follow-up via {$f->type} on {$f->date} has been marked as Completed.",
                'followup',
                url('/crm/admin/followups'),
                $f->assigned_to
            );
        }

        return response()->json(['success' => true, 'message' => 'Follow-up marked as ' . $f->status]);
    }

    public function destroy($id)
    {
        CrmFollowup::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Follow-up removed.');
    }
}
