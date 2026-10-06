<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmActivityLog;

class CrmDealController extends Controller
{
    public function index(Request $request)
    {
        $stages = ['New', 'Qualified', 'Proposal', 'Negotiation', 'Won', 'Lost'];
        $kanban = [];
        $stageTotals = [];

        foreach ($stages as $stage) {
            $dealsInStage = CrmDeal::with(['customer', 'assignedEmployee'])->where('stage', $stage)->latest()->get();
            $kanban[$stage] = $dealsInStage;
            $stageTotals[$stage] = $dealsInStage->sum('value');
        }

        $totalPipelineValue = CrmDeal::sum('value');
        $wonValue = CrmDeal::where('stage', 'Won')->sum('value');
        $customers = CrmCustomer::all();
        $employees = CrmEmployee::where('status', 'Active')->get();

        return view('crm.admin.deals.index', compact('stages', 'kanban', 'stageTotals', 'totalPipelineValue', 'wonValue', 'customers', 'employees'));
    }

    public function create()
    {
        $customers = CrmCustomer::all();
        $employees = CrmEmployee::where('status', 'Active')->get();
        return view('crm.admin.deals.create', compact('customers', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'customer_id' => 'nullable|integer',
            'value' => 'required|numeric',
            'stage' => 'nullable|string',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_closing_date' => 'nullable|date',
            'assigned_to' => 'nullable|integer',
            'priority' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($data['stage'])) $data['stage'] = 'New';
        if (!isset($data['probability']) || $data['probability'] === null) $data['probability'] = 50;
        if (empty($data['priority'])) $data['priority'] = 'Medium';

        $deal = CrmDeal::create($data);

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Deals',
            'action' => 'Created',
            'description' => "Deal '{$deal->title}' created for ₹" . number_format($deal->value),
            'ip_address' => $request->ip(),
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "Deal Added: {$deal->title}",
            "Deal added in pipeline at {$deal->stage} stage for ₹" . number_format($deal->value),
            'deal',
            url('/crm/admin/deals'),
            $deal->assigned_to
        );

        return redirect()->route('crm.admin.deals.index')->with('success', 'Deal created in pipeline!');
    }

    public function updateStage(Request $request, $id)
    {
        $request->validate(['stage' => 'required|string']);
        $deal = CrmDeal::findOrFail($id);
        $oldStage = $deal->stage;
        $deal->stage = $request->stage;

        if ($deal->stage === 'Won') {
            $deal->probability = 100;
        } elseif ($deal->stage === 'Lost') {
            $deal->probability = 0;
        }

        $deal->save();

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Deals',
            'action' => 'Stage Moved',
            'description' => "Deal '{$deal->title}' moved from {$oldStage} to {$deal->stage}.",
            'ip_address' => $request->ip(),
        ]);

        if ($deal->stage === 'Won') {
            \App\Models\Crm\CrmNotification::notify(
                "🎉 Deal Won: {$deal->title}",
                "Deal '{$deal->title}' was successfully WON! Revenue: ₹" . number_format($deal->value),
                'deal',
                url('/crm/admin/deals'),
                $deal->assigned_to
            );
        }

        return response()->json(['success' => true, 'message' => "Deal moved to {$deal->stage} successfully!"]);
    }

    public function destroy($id)
    {
        $deal = CrmDeal::findOrFail($id);
        $deal->delete();
        return redirect()->back()->with('success', 'Deal removed.');
    }
}
