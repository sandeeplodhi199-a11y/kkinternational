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
        $selectedYear = $request->get('year');
        $selectedMonth = $request->get('month');

        $query = CrmPayment::with(['customer', 'quotation'])->latest();
        $kpiQuery = CrmPayment::query();

        if (!empty($selectedYear)) {
            $query->whereYear('payment_date', $selectedYear);
            $kpiQuery->whereYear('payment_date', $selectedYear);
        }
        if (!empty($selectedMonth)) {
            $query->whereMonth('payment_date', $selectedMonth);
            $kpiQuery->whereMonth('payment_date', $selectedMonth);
        }

        $payments = $query->paginate(10)->withQueryString();
        $totalReceived = (clone $kpiQuery)->where('status', 'Paid')->sum('amount');
        $totalPending = (clone $kpiQuery)->where('status', 'Pending')->sum('amount');
        $customers = CrmCustomer::all();
        $quotations = CrmQuotation::all();

        return view('crm.admin.payments.index', compact('payments', 'totalReceived', 'totalPending', 'customers', 'quotations', 'selectedYear', 'selectedMonth'));
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
