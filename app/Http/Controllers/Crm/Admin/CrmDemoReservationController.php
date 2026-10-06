<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmDemo;
use App\Models\Crm\CrmReservation;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmLead;

class CrmDemoReservationController extends Controller
{
    public function demos(Request $request)
    {
        $query = CrmDemo::with(['customer', 'lead', 'assignedEmployee']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('company', 'like', "%{$search}%");
                  })
                  ->orWhereHas('lead', function ($lq) use ($search) {
                      $lq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('company', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('employee_id')) {
            $query->where('assigned_to', $request->employee_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $allDemos = $query->latest('date')->get();

        $pendingDemosList = $allDemos->whereIn('status', ['Pending', 'Scheduled'])->values();
        $completedDemosList = $allDemos->where('status', 'Completed')->values();

        $employees = CrmEmployee::where('status', 'Active')->get();
        $customers = CrmCustomer::all();
        $leads = CrmLead::all();

        $todayDate = now()->toDateString();
        $pendingDemos = CrmDemo::whereIn('status', ['Pending', 'Scheduled'])->count();
        $overdueDemos = CrmDemo::whereIn('status', ['Pending', 'Scheduled'])->whereDate('date', '<', $todayDate)->count();
        $todayDemos = CrmDemo::whereDate('date', $todayDate)->count();
        $completedDemos = CrmDemo::where('status', 'Completed')->count();
        $cancelledDemos = CrmDemo::where('status', 'Cancelled')->count();

        return view('crm.admin.demos.index', compact(
            'pendingDemosList',
            'completedDemosList',
            'employees',
            'customers',
            'leads',
            'pendingDemos',
            'overdueDemos',
            'todayDemos',
            'completedDemos',
            'cancelledDemos'
        ));
    }

    public function createDemo()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $customers = CrmCustomer::all();
        $leads = CrmLead::all();

        return view('crm.admin.demos.create', compact('employees', 'customers', 'leads'));
    }

    public function storeDemo(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'customer_id' => 'nullable|integer',
            'lead_id' => 'nullable|integer',
            'assigned_to' => 'nullable|integer',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($data['status'])) {
            $data['status'] = 'Scheduled';
        }

        $demo = CrmDemo::create($data);

        \App\Models\Crm\CrmNotification::notify(
            "Demo Scheduled: " . ($demo->title ?: 'Product Walkthrough'),
            "Demonstration scheduled for {$demo->date} at {$demo->time}. Status: {$demo->status}.",
            'demo',
            url('/crm/admin/demos'),
            $demo->assigned_to
        );

        return redirect()->route('crm.admin.demos.index')->with('success', 'Demo scheduled successfully!');
    }

    public function reservations(Request $request)
    {
        $reservations = CrmReservation::with(['customer', 'assignedEmployee'])->latest()->paginate(10);
        $employees = CrmEmployee::where('status', 'Active')->get();
        $customers = CrmCustomer::all();

        return view('crm.admin.reservations.index', compact('reservations', 'employees', 'customers'));
    }

    public function createReservation()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        $customers = CrmCustomer::all();

        return view('crm.admin.reservations.create', compact('employees', 'customers'));
    }

    public function storeReservation(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'service_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'assigned_to' => 'nullable|integer',
            'amount' => 'required|numeric',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($data['status'])) {
            $data['status'] = 'Confirmed';
        }

        $data['reservation_code'] = 'RES-' . rand(1000, 9999);
        CrmReservation::create($data);
        return redirect()->route('crm.admin.reservations.index')->with('success', 'Reservation booked successfully!');
    }

    public function demoAssignments(Request $request)
    {
        $query = CrmDemo::with(['customer', 'lead', 'assignedEmployee']);
        if ($request->filled('employee_id')) {
            $query->where('assigned_to', $request->employee_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $allDemos = $query->latest('date')->get();
        $scheduledDemosList = $allDemos->where('status', 'Scheduled')->values();
        $completedDemosList = $allDemos->where('status', 'Completed')->values();

        $employees = CrmEmployee::where('status', 'Active')->get();
        $customers = \App\Models\Crm\CrmCustomer::all();
        $leads = \App\Models\Crm\CrmLead::all();

        $totalDemos = CrmDemo::count();
        $pendingDemos = CrmDemo::whereNull('assigned_to')->orWhere('status', 'Pending')->count();
        $scheduledDemos = CrmDemo::where('status', 'Scheduled')->count();
        $completedDemos = CrmDemo::where('status', 'Completed')->count();
        $cancelledDemos = CrmDemo::where('status', 'Cancelled')->count();

        return view('crm.admin.demos.assignments', compact(
            'scheduledDemosList',
            'completedDemosList',
            'allDemos',
            'employees',
            'customers',
            'leads',
            'totalDemos',
            'pendingDemos',
            'scheduledDemos',
            'completedDemos',
            'cancelledDemos'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $demo = CrmDemo::findOrFail($id);
        $demo->update([
            'status' => $request->get('status', 'Completed'),
            'notes' => $request->filled('notes') ? $request->get('notes') : $demo->notes,
        ]);

        return redirect()->back()->with('success', 'Demo status updated successfully!');
    }

    public function destroyDemo($id)
    {
        $demo = CrmDemo::findOrFail($id);
        $title = $demo->title;
        $demo->delete();
        return redirect()->back()->with('success', "Demo '{$title}' moved to Recycle Bin.");
    }
}
