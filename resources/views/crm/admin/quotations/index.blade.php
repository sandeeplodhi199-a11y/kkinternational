@extends('crm.layouts.master')

@section('title', 'Quotation Builder')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <span>Tools</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <span class="text-slate-800">Quotation Builder</span>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-file-invoice text-emerald-700 text-xl"></i>
                <span>Quotation Builder</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Configure client details, dynamic itemized pricing, taxes, and generate professional PDF proposals.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="togglePastQuotes()" class="px-4 py-2 rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 font-semibold text-xs transition shadow-sm inline-flex items-center gap-2">
                <i class="fa-solid fa-list-check text-slate-500"></i>
                <span>Past Quotations ({{ $quotations->total() }})</span>
            </button>
            <a href="{{ route('crm.admin.tools.billing-calculator') }}" class="px-4 py-2 rounded-full border border-emerald-600/30 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-calculator"></i>
                <span>Pricing Calculator</span>
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER (Exact recreation of user reference Image 2) -->
    <div class="crm-card p-6 md:p-8 bg-white border border-[#e7ece4] shadow-md rounded-3xl">
        <form action="{{ route('crm.admin.quotations.store') }}" method="POST" id="quotationBuilderForm">
            @csrf

            <!-- Form Title Header -->
            <div class="pb-4 mb-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-regular fa-file-lines text-indigo-600"></i>
                    <span>New Quotation</span>
                </h3>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Draft &bull; Live Estimator
                </span>
            </div>

            <!-- ROW 1: Select Client / Lead Dropdown -->
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Client / Lead</label>
                <select id="clientSelector" onchange="handleClientSelect(this)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="" selected>-- Select Existing Client or Inbound Lead --</option>
                    <optgroup label="Active Clients">
                        @foreach($customers as $c)
                            <option value="cust_{{ $c->id }}" 
                                    data-type="customer"
                                    data-id="{{ $c->id }}"
                                    data-name="{{ $c->name }}" 
                                    data-phone="{{ $c->phone }}" 
                                    data-email="{{ $c->email }}" 
                                    data-company="{{ $c->company }}">
                                {{ $c->name }} ({{ $c->company }}) — Active Client
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Prospect Leads">
                        @foreach($leads as $l)
                            <option value="lead_{{ $l->id }}" 
                                    data-type="lead"
                                    data-name="{{ $l->name }}" 
                                    data-phone="{{ $l->phone }}" 
                                    data-email="{{ $l->email }}" 
                                    data-company="{{ $l->company }}">
                                {{ $l->name }} ({{ $l->company ?: 'Prospect' }}) — Lead [{{ $l->status }}]
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                <input type="hidden" name="customer_id" id="hiddenCustomerId">
            </div>

            <!-- ROW 2: 3 Columns Grid (Quotation Number, Quotation Date, Valid Until Date) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Quotation Number *</label>
                    <input type="text" name="quotation_no" id="quotationNoInput" value="{{ $quoteNo }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Quotation Date *</label>
                    <input type="date" name="quotation_date" id="quotationDateInput" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Valid Until Date</label>
                    <input type="date" name="valid_until" id="validUntilInput" value="{{ date('Y-m-d', strtotime('+15 days')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <!-- ROW 3: 3 Columns Grid (Client Name, Client Phone, Client Email) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Client Name / Contact Person *</label>
                    <input type="text" name="customer_name" id="clientNameInput" required placeholder="e.g. Devendra Patel" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Client Phone</label>
                    <input type="text" name="customer_phone" id="clientPhoneInput" placeholder="e.g. +91 98765 43210" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Client Email</label>
                    <input type="email" name="customer_email" id="clientEmailInput" placeholder="e.g. client@company.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <!-- ROW 4: Full Width (Client Billing Address) -->
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Client Billing Address</label>
                <input type="text" name="client_address" id="clientAddressInput" placeholder="e.g. Plot 42, GIDC Industrial Area, Ahmedabad, Gujarat - 382445" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- ROW 5: 3 Columns Grid (Payment Terms, Currency, Quotation Title) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Payment Terms</label>
                    <input type="text" name="payment_terms" id="paymentTermsInput" value="50% Advance, 50% on Delivery" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Currency</label>
                    <select name="currency" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="INR" selected>INR (₹) - Indian Rupee</option>
                        <option value="USD">USD ($) - US Dollar</option>
                        <option value="EUR">EUR (€) - Euro</option>
                        <option value="GBP">GBP (£) - British Pound</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Quotation Title / Subject</label>
                    <input type="text" name="quotation_title" id="quotationTitleInput" value="Enterprise CRM & Cloud ERP Implementation Proposal" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <!-- SECTION: LINE ITEMS (Exact matching table in Image 2 with purple/indigo + Add Item button) -->
            <div class="pt-4 border-t border-slate-100 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-600"></i>
                        <span>Line Items</span>
                    </h4>
                    <button type="button" onclick="addLineItem()" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-sm inline-flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add Item</span>
                    </button>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                    <table class="w-full text-left text-xs" id="itemsTable">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-[10.5px] font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-3">Item Name</th>
                                <th class="p-3 w-32">Unit Price (₹)</th>
                                <th class="p-3 w-20">Quantity</th>
                                <th class="p-3 w-24">Discount (%)</th>
                                <th class="p-3 w-24">Tax (%)</th>
                                <th class="p-3 w-32 text-right">Total (₹)</th>
                                <th class="p-3 w-14 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="itemsTableBody">
                            <!-- Pre-populated Default Row 1 (as seen in Image 2) -->
                            <tr class="item-row hover:bg-slate-50/50 transition">
                                <td class="p-2.5">
                                    <input type="text" name="items[0][item_name]" value="Enterprise Cloud CRM Subscription (Annual)" required placeholder="Item description / service name" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.01" name="items[0][unit_price]" value="150000" min="0" oninput="calculateRowTotal(this)" class="item-price w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-right focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="1" name="items[0][quantity]" value="1" min="1" oninput="calculateRowTotal(this)" class="item-qty w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.1" name="items[0][discount]" value="5" min="0" max="100" oninput="calculateRowTotal(this)" class="item-disc w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.1" name="items[0][tax_rate]" value="18" min="0" max="50" oninput="calculateRowTotal(this)" class="item-tax w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5 text-right font-bold text-slate-800">
                                    <span class="row-total">₹168,150.00</span>
                                </td>
                                <td class="p-2.5 text-center">
                                    <button type="button" onclick="removeItemRow(this)" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition mx-auto">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Pre-populated Default Row 2 (as seen in Image 2) -->
                            <tr class="item-row hover:bg-slate-50/50 transition">
                                <td class="p-2.5">
                                    <input type="text" name="items[1][item_name]" value="Custom ERP Data Migration & Onboarding" required placeholder="Item description / service name" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.01" name="items[1][unit_price]" value="42000" min="0" oninput="calculateRowTotal(this)" class="item-price w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-right focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="1" name="items[1][quantity]" value="1" min="1" oninput="calculateRowTotal(this)" class="item-qty w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.1" name="items[1][discount]" value="0" min="0" max="100" oninput="calculateRowTotal(this)" class="item-disc w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5">
                                    <input type="number" step="0.1" name="items[1][tax_rate]" value="18" min="0" max="50" oninput="calculateRowTotal(this)" class="item-tax w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                                </td>
                                <td class="p-2.5 text-right font-bold text-slate-800">
                                    <span class="row-total">₹49,560.00</span>
                                </td>
                                <td class="p-2.5 text-center">
                                    <button type="button" onclick="removeItemRow(this)" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition mx-auto">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ROW 6: Checkboxes (Exact match to Image 2 below table) -->
            <div class="flex items-center gap-6 flex-wrap mb-6 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-semibold text-slate-700">
                    <input type="checkbox" id="checkGst" checked onchange="calculateGrandTotals()" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <span>Include GST (18%)</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-semibold text-slate-700">
                    <input type="checkbox" id="checkDelivery" checked class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <span>Delivery Terms</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-semibold text-slate-700">
                    <input type="checkbox" id="checkBank" checked class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <span>Bank Details</span>
                </label>
            </div>

            <!-- ROW 7: Terms & Conditions + Financial Calculation Summary Box (2 columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
                <!-- Left: Terms & Conditions -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Terms & Conditions</label>
                    <textarea name="terms" id="termsTextarea" rows="6" class="w-full p-3 rounded-2xl border border-slate-200 text-xs font-medium text-slate-700 bg-white leading-relaxed focus:ring-2 focus:ring-indigo-500 focus:outline-none">1. Prices quoted are valid for 15 days from the date of quotation.
2. Payment: 50% advance along with Purchase Order, balance 50% upon delivery/milestone completion.
3. Standard onboarding and deployment timeline: 7 to 10 working days.
4. Applicable GST @ 18% extra unless explicitly specified in line items.</textarea>
                </div>

                <!-- Right: Financial Summary Breakdown Box -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 pb-2 border-b border-slate-200 flex items-center justify-between">
                        <span>Commercial Summary</span>
                        <span class="font-mono text-indigo-600">INR (₹)</span>
                    </h5>

                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <span>Items Subtotal:</span>
                        <span class="font-semibold text-slate-800" id="summarySubtotal">₹192,000.00</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-rose-600">
                        <span>Total Discount Applied:</span>
                        <span class="font-semibold" id="summaryDiscount">-₹7,500.00</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <span>Net Taxable Value:</span>
                        <span class="font-semibold text-slate-800" id="summaryTaxable">₹184,500.00</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <span>GST / Taxes (18%):</span>
                        <span class="font-semibold text-slate-800" id="summaryTax">₹33,210.00</span>
                    </div>

                    <div class="pt-3 border-t border-slate-300 flex items-center justify-between">
                        <span class="text-sm font-extrabold text-slate-800">Grand Total:</span>
                        <span class="text-xl font-black text-indigo-700" id="summaryGrandTotal">₹217,710.00</span>
                    </div>
                </div>
            </div>

            <!-- ROW 8: Action Buttons Bar -->
            <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                <button type="button" onclick="document.getElementById('quotationBuilderForm').reset(); calculateGrandTotals();" class="px-5 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">
                    <i class="fa-solid fa-arrow-rotate-left mr-1.5"></i> Reset Form
                </button>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-7 py-3 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-md inline-flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Save & Generate Quotation</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- COLLAPSIBLE: PAST QUOTATIONS HISTORY TABLE -->
    <div id="pastQuotationsSection" class="hidden crm-card p-6 bg-white border border-[#e7ece4] rounded-3xl animate-fade-in">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Past Commercial Quotations</h3>
                <p class="text-xs text-slate-500">Previously generated proposals and status tracking</p>
            </div>
            <button type="button" onclick="togglePastQuotes()" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                &times; Close
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Quotation #</th>
                        <th class="py-3 px-4">Recipient Client</th>
                        <th class="py-3 px-4">Issue Date</th>
                        <th class="py-3 px-4">Valid Until</th>
                        <th class="py-3 px-4">Grand Total</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($quotations as $q)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                <a href="{{ route('crm.admin.quotations.show', $q->id) }}" class="text-indigo-600 hover:underline">
                                    {{ $q->quotation_no }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $q->customer_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $q->customer_email }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ \Carbon\Carbon::parse($q->quotation_date)->format('d M, Y') }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $q->valid_until ? \Carbon\Carbon::parse($q->valid_until)->format('d M, Y') : '15 Days' }}</td>
                            <td class="py-3.5 px-4 font-extrabold text-slate-900">₹{{ number_format($q->grand_total, 2) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $q->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('crm.admin.quotations.show', $q->id) }}" class="p-1.5 rounded-lg text-slate-600 hover:text-indigo-700 hover:bg-indigo-50 transition" title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('crm.admin.quotations.print', $q->id) }}" target="_blank" class="p-1.5 rounded-lg text-slate-600 hover:text-blue-700 hover:bg-blue-50 transition" title="Print">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a href="{{ route('crm.admin.quotations.pdf', $q->id) }}" class="p-1.5 rounded-lg text-slate-600 hover:text-amber-700 hover:bg-amber-50 transition" title="PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-slate-400">No previous quotations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let rowIndex = 2;

    function handleClientSelect(select) {
        const option = select.options[select.selectedIndex];
        if (!option || !option.value) return;

        const name = option.getAttribute('data-name') || '';
        const phone = option.getAttribute('data-phone') || '';
        const email = option.getAttribute('data-email') || '';
        const company = option.getAttribute('data-company') || '';
        const custId = option.getAttribute('data-id') || '';

        document.getElementById('clientNameInput').value = name;
        document.getElementById('clientPhoneInput').value = phone;
        document.getElementById('clientEmailInput').value = email;
        document.getElementById('clientAddressInput').value = company ? (company + ', India') : '';
        document.getElementById('hiddenCustomerId').value = custId;
    }

    function addLineItem() {
        const tbody = document.getElementById('itemsTableBody');
        const tr = document.createElement('tr');
        tr.className = 'item-row hover:bg-slate-50/50 transition';
        tr.innerHTML = `
            <td class="p-2.5">
                <input type="text" name="items[${rowIndex}][item_name]" required placeholder="Item description / service name" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-indigo-500 focus:outline-none">
            </td>
            <td class="p-2.5">
                <input type="number" step="0.01" name="items[${rowIndex}][unit_price]" value="10000" min="0" oninput="calculateRowTotal(this)" class="item-price w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-right focus:ring-1 focus:ring-indigo-500 focus:outline-none">
            </td>
            <td class="p-2.5">
                <input type="number" step="1" name="items[${rowIndex}][quantity]" value="1" min="1" oninput="calculateRowTotal(this)" class="item-qty w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
            </td>
            <td class="p-2.5">
                <input type="number" step="0.1" name="items[${rowIndex}][discount]" value="0" min="0" max="100" oninput="calculateRowTotal(this)" class="item-disc w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
            </td>
            <td class="p-2.5">
                <input type="number" step="0.1" name="items[${rowIndex}][tax_rate]" value="18" min="0" max="50" oninput="calculateRowTotal(this)" class="item-tax w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 text-center focus:ring-1 focus:ring-indigo-500 focus:outline-none">
            </td>
            <td class="p-2.5 text-right font-bold text-slate-800">
                <span class="row-total">₹11,800.00</span>
            </td>
            <td class="p-2.5 text-center">
                <button type="button" onclick="removeItemRow(this)" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition mx-auto">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        rowIndex++;
        calculateGrandTotals();
    }

    function removeItemRow(btn) {
        const tbody = document.getElementById('itemsTableBody');
        if (tbody.querySelectorAll('.item-row').length <= 1) {
            alert('Quotation must contain at least one line item.');
            return;
        }
        btn.closest('tr').remove();
        calculateGrandTotals();
    }

    function calculateRowTotal(input) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const disc = parseFloat(row.querySelector('.item-disc').value) || 0;
        const tax = parseFloat(row.querySelector('.item-tax').value) || 0;

        const gross = price * qty;
        const discAmount = gross * (disc / 100);
        const taxable = Math.max(0, gross - discAmount);
        const taxAmount = taxable * (tax / 100);
        const total = taxable + taxAmount;

        row.querySelector('.row-total').innerText = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        calculateGrandTotals();
    }

    function calculateGrandTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;
        const isGstEnabled = document.getElementById('checkGst').checked;

        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const disc = parseFloat(row.querySelector('.item-disc').value) || 0;
            let tax = parseFloat(row.querySelector('.item-tax').value) || 0;
            if (!isGstEnabled) tax = 0;

            const gross = price * qty;
            const discAmount = gross * (disc / 100);
            const taxable = Math.max(0, gross - discAmount);
            const taxAmount = taxable * (tax / 100);
            const lineTotal = taxable + taxAmount;

            subtotal += gross;
            totalDiscount += discAmount;
            totalTax += taxAmount;

            row.querySelector('.row-total').innerText = '₹' + lineTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        });

        const netTaxable = Math.max(0, subtotal - totalDiscount);
        const grandTotal = netTaxable + totalTax;

        document.getElementById('summarySubtotal').innerText = '₹' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summaryDiscount').innerText = '-₹' + totalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summaryTaxable').innerText = '₹' + netTaxable.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summaryTax').innerText = '₹' + totalTax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summaryGrandTotal').innerText = '₹' + grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function togglePastQuotes() {
        const sec = document.getElementById('pastQuotationsSection');
        sec.classList.toggle('hidden');
        if (!sec.classList.contains('hidden')) {
            sec.scrollIntoView({ behavior: 'smooth' });
        }
    }

    document.addEventListener('DOMContentLoaded', calculateGrandTotals);
</script>
@endpush
@endsection
