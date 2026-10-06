<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmActivityLog;

class CrmCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = CrmCustomer::with('assignedEmployee');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('company', 'LIKE', "%{$s}%")
                  ->orWhere('email', 'LIKE', "%{$s}%")
                  ->orWhere('phone', 'LIKE', "%{$s}%")
                  ->orWhere('customer_code', 'LIKE', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(10);
        $employees = CrmEmployee::where('status', 'Active')->get();

        return view('crm.admin.customers.index', compact('customers', 'employees'));
    }

    public function create()
    {
        $employees = CrmEmployee::where('status', 'Active')->get();
        return view('crm.admin.customers.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'assigned_to' => 'nullable|integer',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $data['customer_code'] = 'CUST-' . rand(1000, 9999);
        $customer = CrmCustomer::create($data);

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Customers',
            'action' => 'Created',
            'description' => "Customer {$customer->name} ({$customer->company}) created.",
            'ip_address' => $request->ip(),
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "New Customer Onboarded: {$customer->name}",
            "Customer {$customer->customer_code} from '{$customer->company}' registered. Contact: {$customer->phone}.",
            'customer',
            url('/crm/admin/customers/' . $customer->id),
            $customer->assigned_to
        );

        return redirect()->route('crm.admin.customers.index')->with('success', 'Customer added successfully!');
    }

    public function show($id)
    {
        $customer = CrmCustomer::with(['assignedEmployee', 'deals', 'quotations', 'payments', 'followups', 'tasks'])->findOrFail($id);
        $employees = CrmEmployee::where('status', 'Active')->get();
        return view('crm.admin.customers.show', compact('customer', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $customer = CrmCustomer::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'assigned_to' => 'nullable|integer',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $customer->update($data);
        return redirect()->back()->with('success', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        $customer = CrmCustomer::findOrFail($id);
        $name = $customer->name;
        $customer->delete();
        return redirect()->route('crm.admin.customers.index')->with('success', "Customer {$name} deleted successfully.");
    }
}
