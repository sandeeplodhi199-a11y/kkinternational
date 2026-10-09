<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Crm\CrmQuotation;
use App\Models\Crm\CrmQuotationItem;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmProduct;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmSetting;
use App\Models\Crm\CrmActivityLog;

class CrmQuotationController extends Controller
{
    public function index(Request $request)
    {
        $customers = CrmCustomer::all();
        $leads = CrmLead::all();
        $products = CrmProduct::where('status', 'Active')->get();
        $quoteNo = 'QT-' . date('Y') . '-' . str_pad(rand(10, 9999), 4, '0', STR_PAD_LEFT);
        $quotations = CrmQuotation::with(['customer', 'items'])->latest()->paginate(10);

        return view('crm.admin.quotations.index', compact('customers', 'leads', 'products', 'quoteNo', 'quotations'));
    }

    public function create()
    {
        return redirect()->route('crm.admin.quotations.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'quotation_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        $subtotal = 0;
        $totalDiscount = 0;
        $totalTax = 0;

        foreach ($request->items as $item) {
            $qty = floatval($item['quantity'] ?? 1);
            $price = floatval($item['unit_price'] ?? 0);
            $discPct = floatval($item['discount'] ?? 0);
            $taxPct = floatval($item['tax_rate'] ?? 18);

            $lineGross = $qty * $price;
            $lineDisc = $lineGross * ($discPct / 100);
            $lineTaxable = max(0, $lineGross - $lineDisc);
            $lineTax = $lineTaxable * ($taxPct / 100);

            $subtotal += $lineGross;
            $totalDiscount += $lineDisc;
            $totalTax += $lineTax;
        }

        $taxable = max(0, $subtotal - $totalDiscount);
        $grandTotal = $taxable + $totalTax;

        $quotation = CrmQuotation::create([
            'quotation_no' => $request->quotation_no ?: ('QT-' . date('Y') . '-' . rand(1000, 9999)),
            'customer_id' => $request->customer_id ?: null,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'quotation_date' => $request->quotation_date,
            'valid_until' => $request->valid_until,
            'subtotal' => $subtotal,
            'discount_type' => 'amount',
            'discount_rate' => 0,
            'discount_amount' => $totalDiscount,
            'tax_amount' => $totalTax,
            'grand_total' => $grandTotal,
            'notes' => $request->notes,
            'terms' => $request->terms,
            'status' => ($totalDiscount > 5000) ? 'Pending Approval' : 'Sent',
            'approval_status' => ($totalDiscount > 5000) ? 'Pending' : 'Approved',
            'created_by' => auth()->id(),
        ]);

        foreach ($request->items as $item) {
            $qty = floatval($item['quantity'] ?? 1);
            $price = floatval($item['unit_price'] ?? 0);
            $discPct = floatval($item['discount'] ?? 0);
            $taxPct = floatval($item['tax_rate'] ?? 18);

            $lineGross = $qty * $price;
            $lineDisc = $lineGross * ($discPct / 100);
            $lineTaxable = max(0, $lineGross - $lineDisc);
            $lineTax = $lineTaxable * ($taxPct / 100);
            $lineTotal = $lineTaxable + $lineTax;

            CrmQuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $item['product_id'] ?? null,
                'item_name' => $item['item_name'],
                'description' => $item['description'] ?? null,
                'quantity' => $qty,
                'unit_price' => $price,
                'tax_rate' => $taxPct,
                'total' => $lineTotal,
            ]);
        }

        CrmActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'module' => 'Quotations',
            'action' => 'Created',
            'description' => "Quotation #{$quotation->quotation_no} generated for ₹" . number_format($quotation->grand_total),
            'ip_address' => $request->ip(),
        ]);

        \App\Models\Crm\CrmNotification::notify(
            "Quotation Generated: {$quotation->quotation_no}",
            "Quotation created for {$quotation->customer_name} — Total: ₹" . number_format($quotation->grand_total) . " (Status: {$quotation->status}).",
            'quotation',
            url('/crm/admin/quotations/' . $quotation->id),
            null
        );

        return redirect()->route('crm.admin.quotations.show', $quotation->id)->with('success', 'Quotation created successfully!');
    }

    public function show($id)
    {
        $quotation = CrmQuotation::with('items')->findOrFail($id);
        $settings = [
            'company_name' => CrmSetting::get('company_name', 'Emedley Cloud CRM'),
            'company_tagline' => CrmSetting::get('company_tagline', 'Enterprise Solutions'),
            'support_email' => CrmSetting::get('support_email', 'billing@emedleycrm.com'),
            'support_phone' => CrmSetting::get('support_phone', '+91 97830 55170'),
        ];
        return view('crm.admin.quotations.show', compact('quotation', 'settings'));
    }

    public function printView($id)
    {
        $quotation = CrmQuotation::with('items')->findOrFail($id);
        $settings = [
            'company_name' => CrmSetting::get('company_name', 'Emedley Cloud CRM'),
            'company_tagline' => CrmSetting::get('company_tagline', 'Enterprise Solutions'),
            'support_email' => CrmSetting::get('support_email', 'billing@emedleycrm.com'),
            'support_phone' => CrmSetting::get('support_phone', '+91 97830 55170'),
        ];
        return view('crm.admin.quotations.print', compact('quotation', 'settings'));
    }

    public function downloadPdf($id)
    {
        $quotation = CrmQuotation::with('items')->findOrFail($id);
        $settings = [
            'company_name' => CrmSetting::get('company_name', 'Emedley Cloud CRM'),
            'company_tagline' => CrmSetting::get('company_tagline', 'Enterprise Solutions'),
            'support_email' => CrmSetting::get('support_email', 'billing@emedleycrm.com'),
            'support_phone' => CrmSetting::get('support_phone', '+91 97830 55170'),
        ];
        $pdf = Pdf::loadView('crm.admin.quotations.pdf', compact('quotation', 'settings'));
        return $pdf->download("Quotation_{$quotation->quotation_no}.pdf");
    }

    public function billingCalculator()
    {
        $products = CrmProduct::where('status', 'Active')->get();
        $customers = CrmCustomer::all();
        return view('crm.admin.tools.billing_calculator', compact('products', 'customers'));
    }

    public function destroy($id)
    {
        $quotation = CrmQuotation::findOrFail($id);
        $no = $quotation->quotation_no;
        $quotation->delete();
        return redirect()->route('crm.admin.quotations.index')->with('success', "Quotation {$no} moved to Recycle Bin.");
    }
}
