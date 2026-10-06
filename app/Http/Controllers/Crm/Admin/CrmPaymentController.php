<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmPayment;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmQuotation;
use App\Models\Crm\CrmActivityLog;

class CrmPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = CrmPayment::with(['customer', 'quotation'])->latest()->paginate(10);
        $totalReceived = CrmPayment::where('status', 'Paid')->sum('amount');
        $totalPending = CrmPayment::where('status', 'Pending')->sum('amount');
        $customers = CrmCustomer::all();
        $quotations = CrmQuotation::all();

        return view('crm.admin.payments.index', compact('payments', 'totalReceived', 'totalPending', 'customers', 'quotations'));
    }

    public function create()
    {
        $customers = CrmCustomer::all();
        $quotations = CrmQuotation::all();
        return view('crm.admin.payments.create', compact('customers', 'quotations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|integer',
            'quotation_id' => 'nullable|integer',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_ref' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($data['status'])) {
            $data['status'] = 'Paid';
        }

        $data['payment_no'] = 'PAY-' . rand(1000, 9999);
        $payment = CrmPayment::create($data);

        // Update customer total spent
        if ($payment->customer_id && $payment->status === 'Paid') {
            CrmCustomer::where('id', $payment->customer_id)->increment('total_spent', $payment->amount);
        }

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Payments',
            'action' => 'Payment Recorded',
            'description' => "Recorded payment {$payment->payment_no} for ₹" . number_format($payment->amount),
            'ip_address' => $request->ip(),
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "Payment Received: " . $payment->payment_no,
            "Payment of ₹" . number_format($payment->amount) . " received via " . $payment->payment_method . " (Status: {$payment->status}).",
            'payment',
            url('/crm/admin/payments'),
            null
        );

        return redirect()->route('crm.admin.payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function destroy($id)
    {
        $payment = CrmPayment::findOrFail($id);
        $no = $payment->payment_no;
        $payment->delete();
        return redirect()->back()->with('success', "Payment {$no} moved to Recycle Bin.");
    }
}
