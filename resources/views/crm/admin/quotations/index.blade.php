@extends('crm.layouts.master')

@section('title', 'Quotation Builder')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto pb-16">

    <!-- TOP HEADER -->
    <div class="flex items-center justify-between flex-wrap gap-4 no-print">
        <div>
            <h1 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <span>Quotation Builder</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Build, preview and generate official HisabMittra quotations with dynamic GST calculations</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="printQuotationDoc()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print text-xs text-amber-400"></i>
                <span>Print Quotation</span>
            </button>
            <button type="button" onclick="downloadQuotationPdf()" class="px-4 py-2 rounded-xl bg-[#0e6f66] hover:bg-[#0b5a53] text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-file-pdf text-xs"></i>
                <span>Download PDF</span>
            </button>
        </div>
    </div>

    <!-- 1. QUOTATION BUILDER FORM CONTAINER (Exact match to Images) -->
    <div class="bg-white border border-slate-200/90 shadow-sm rounded-2xl p-5 sm:p-7 no-print">
        <form id="quotationBuilderForm" onsubmit="event.preventDefault(); updateQuotationPreview();">

            <!-- Section 1 Header: Quotation Details -->
            <div class="flex items-center gap-2 text-sm font-bold text-slate-800 pb-3 mb-4 border-b border-slate-100">
                <i class="fa-solid fa-user text-indigo-600 text-xs"></i>
                <span>Quotation Details</span>
            </div>

            <!-- Load from Lead Row -->
            <div class="mb-4">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Load from Lead</label>
                <div class="relative">
                    <select id="builder-lead-select" onchange="onLeadSelected(this)" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none appearance-none pr-8">
                        <option value="">-- Select Existing Lead --</option>
                        @if(isset($customers) && $customers->count())
                            <optgroup label="Active Accounts">
                                @foreach($customers as $c)
                                    <option value="cust_{ $c->id }"
                                        data-name="{ $c->name }"
                                        data-company="{ $c->company }"
                                        data-phone="{ $c->phone }"
                                        data-email="{ $c->email }"
                                        data-address="{ $c->address }">
                                        { $c->name } ({ $c->company ?: 'Client' })
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(isset($leads) && $leads->count())
                            <optgroup label="Prospect Leads">
                                @foreach($leads as $l)
                                    <option value="lead_{ $l->id }"
                                        data-name="{ $l->name }"
                                        data-company="{ $l->company }"
                                        data-phone="{ $l->phone }"
                                        data-email="{ $l->email }"
                                        data-address="{ $l->address }">
                                        { $l->name } ({ $l->company ?: 'Prospect' })
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Customer Details: 3 Columns Row 1 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-3.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Customer Name</label>
                    <input type="text" id="builder-customer-name" value="" placeholder="Customer Name" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Company/Firm</label>
                    <input type="text" id="builder-company" value="" placeholder="Company/Firm" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Customer GSTIN</label>
                    <input type="text" id="builder-gstin" value="" placeholder="Customer GSTIN" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <!-- Customer Details: 3 Columns Row 2 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-3.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Mobile Number</label>
                    <input type="text" id="builder-phone" value="" placeholder="Mobile Number" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Email ID</label>
                    <input type="email" id="builder-email" value="" placeholder="Email ID" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Place of Supply (State)</label>
                    <input type="text" id="builder-pos" value="08-RAJASTHAN" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <!-- Billing Address Row -->
            <div class="mb-4">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Billing Address</label>
                <input type="text" id="builder-address" value="" placeholder="Billing Address" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Quotation Meta: Vertical Stack on Left -->
            <div class="space-y-3 max-w-sm mb-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Quotation No.</label>
                    <input type="text" id="builder-quote-no" value="MHSB/26-27/001" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Quotation Date</label>
                    <input type="text" id="builder-quote-date" value="08 Oct 2026" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Validity</label>
                    <input type="text" id="builder-validity" value="23 Oct 2026" oninput="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Document Type</label>
                    <div class="relative">
                        <select id="builder-doc-type" onchange="updateQuotationPreview()" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-medium text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none appearance-none pr-8">
                            <option value="Quotation" selected>Quotation</option>
                            <option value="Proforma Invoice">Proforma Invoice</option>
                            <option value="Estimate">Estimate</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Line Items Header & Add Button -->
            <div class="pt-5 border-t border-slate-100 mb-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2 text-sm font-bold text-slate-800">
                        <i class="fa-solid fa-users text-indigo-600 text-xs"></i>
                        <span>Line Items</span>
                    </div>
                    <button type="button" onclick="addLineItemRow()" class="px-3.5 py-1.5 rounded-lg bg-[#4f46e5] hover:bg-[#4338ca] text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Add Item</span>
                    </button>
                </div>

                <!-- Line Items Table -->
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left text-xs border-collapse" id="builder-items-table">
                        <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 text-[11px]">
                            <tr>
                                <th class="py-2.5 px-3 min-w-[280px]">Description</th>
                                <th class="py-2.5 px-3 w-28">SAC/HSN</th>
                                <th class="py-2.5 px-3 w-32">Base Rate (₹)</th>
                                <th class="py-2.5 px-3 w-28">Discount (%)</th>
                                <th class="py-2.5 px-3 w-20 text-center">Qty</th>
                                <th class="py-2.5 px-3 w-16 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="builder-items-tbody" class="divide-y divide-slate-100">
                            <!-- Injected dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Checkboxes Row (matching reference image) -->
            <div class="flex items-center gap-6 flex-wrap mb-4 py-2">
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-medium text-slate-700">
                    <input type="checkbox" id="builder-apply-gst" checked onchange="updateQuotationPreview()" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span>Apply GST (18%)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-medium text-slate-700">
                    <input type="checkbox" id="builder-inclusive-gst" onchange="updateQuotationPreview()" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span>Inclusive GST</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-medium text-slate-700">
                    <input type="checkbox" id="builder-is-igst" checked onchange="updateQuotationPreview()" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span>Is IGST?</span>
                </label>
            </div>

            <!-- Notes Row (exact content matching reference image) -->
            <div class="mb-5">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Notes (Bottom left)</label>
                <textarea id="builder-notes" rows="5" oninput="updateQuotationPreview()" class="w-full text-xs p-3 rounded-xl border border-indigo-200 font-mono text-slate-700 leading-relaxed focus:ring-2 focus:ring-indigo-500 focus:outline-none">License: Valid for 1 year; for internal business use only
Support: Available during business hours only.
Restrictions: Resale, redistribution, or modification of the software is strictly prohibited.
Refund Policy: No refund policy is there.
Contact: support@hisabmittra.com | +91 9783055170 | www.hisabmittra.com</textarea>
            </div>

        </form>
    </div>

    <!-- 2. OFFICIAL LIVE QUOTATION PREVIEW DOCUMENT (Exact Recreation of Image) -->
    <div id="quotation-print-container" class="bg-white border border-slate-300 shadow-xl rounded-xl p-8 sm:p-12 max-w-[850px] mx-auto text-slate-900 font-sans print:shadow-none print:border-none print:p-0 print:m-0 print:max-w-none">

        <!-- Top Header: Quotation Title, Company Details & Logo -->
        <div class="flex items-start justify-between pb-3">
            <div>
                <h1 class="text-3xl font-black text-[#e88d00] tracking-wide uppercase mb-1" id="preview-doc-title">QUOTATION</h1>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">HISABMITTRA</h2>
                <div class="text-[11.5px] text-slate-700 leading-snug font-medium mt-1">
                    <div>Hans Bhawan, B-148, Rana Sanga Marg</div>
                    <div>Mobile: +91 9783055170</div>
                    <div>Email: support@hisabmittra.com</div>
                    <div>Website: www.hisabmittra.com</div>
                    <div>GSTIN: <strong>08AATFH4878A1Z0</strong> &nbsp; PAN: <strong>AATFH4878A</strong></div>
                </div>
            </div>
            <div class="text-right">
                <img src="/crm/images/hisab-mittra-logo.png" alt="HisabMittra" class="h-14 sm:h-16 object-contain inline-block">
            </div>
        </div>

        <!-- Meta Strip: Quotation #, Quotation Date, Validity -->
        <div class="border-y-2 border-slate-900 py-1.5 px-3 my-4 flex items-center justify-between text-xs font-bold text-slate-900 flex-wrap gap-2">
            <div>Quotation #: <span id="preview-quote-no" class="font-bold">MHSB/26-27/001</span></div>
            <div>Quotation Date: <span id="preview-quote-date">08 Oct 2026</span></div>
            <div>Validity: <span id="preview-validity">23 Oct 2026</span></div>
        </div>

        <!-- 3-Column Customer & Dispatch Info -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-[11px] text-slate-800 pb-3 mb-1">
            <div>
                <div class="font-bold text-slate-900 text-xs mb-0.5">Customer Details:</div>
                <div id="preview-customer-name" class="font-bold text-slate-900"></div>
                <div id="preview-company-name" class="font-semibold text-slate-800"></div>
                <div>GSTIN: <span id="preview-gstin"></span></div>
                <div>Ph: <span id="preview-phone"></span></div>
                <div class="mt-1">Place of Supply:</div>
                <div id="preview-pos" class="font-bold text-slate-900">08-RAJASTHAN</div>
            </div>
            <div>
                <div class="font-bold text-slate-900 text-xs mb-0.5">Billing Address:</div>
                <div id="preview-address" class="leading-relaxed"></div>
            </div>
            <div>
                <div class="font-bold text-slate-900 text-xs mb-0.5">Dispatch From:</div>
                <div class="font-bold text-slate-900">HISABMITTRA</div>
                <div class="leading-relaxed">Hans Bhawan, B-148, Rana Sanga Marg</div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="overflow-x-auto border-t-2 border-[#1e3a8a] mb-2">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="border-b border-[#1e3a8a] text-[#1e3a8a] font-bold text-[11px]">
                    <tr>
                        <th class="py-2 px-2 w-8 text-center">#</th>
                        <th class="py-2 px-2">Item</th>
                        <th class="py-2 px-2 text-right">Rate / Item</th>
                        <th class="py-2 px-2 text-center w-12">Qty</th>
                        <th class="py-2 px-2 text-right">Taxable Value</th>
                        <th class="py-2 px-2 text-right">Tax Amount</th>
                        <th class="py-2 px-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody id="preview-items-body" class="divide-y divide-slate-100 text-[11px]">
                    <!-- Injected dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Totals & Summary Block -->
        <div class="flex items-start justify-between flex-wrap gap-4 pt-3 border-t border-slate-200 text-xs">
            <div class="font-bold text-slate-700 text-xs">
                Total Items / Qty : <span id="preview-total-items-qty">2 / 5</span>
            </div>
            <div class="w-72 space-y-1 text-xs">
                <div class="flex justify-between text-slate-800">
                    <span class="font-bold">Taxable Amount</span>
                    <span class="font-bold" id="preview-taxable-amount">₹ 12,036.20</span>
                </div>
                <div class="flex justify-between text-slate-800" id="preview-tax-breakdown-row">
                    <span class="font-bold" id="preview-tax-label">IGST 18.0%</span>
                    <span class="font-bold" id="preview-tax-amount">₹ 2,166.52</span>
                </div>
                <div class="flex justify-between text-slate-800">
                    <span class="font-bold">Round Off</span>
                    <span class="font-bold" id="preview-roundoff">0.28</span>
                </div>
                <div class="border-y border-[#e88d00] py-1 flex justify-between items-center text-base font-black text-[#1e3a8a]">
                    <span>Total &nbsp;-</span>
                    <span id="preview-grand-total">₹ 14,203.00</span>
                </div>
                <div class="flex justify-between text-slate-700 text-xs pt-0.5">
                    <span class="font-bold">Total Discount</span>
                    <span class="font-bold" id="preview-total-discount">₹ 3,249.40</span>
                </div>
            </div>
        </div>

        <!-- Total In Words -->
        <div class="text-[11px] text-slate-700 font-medium italic mt-3 pb-3 border-b border-slate-200">
            Total amount (in words): <strong class="text-slate-900 not-italic" id="preview-amount-words">INR Fourteen Thousand Two Hundred And Three Rupees Only.</strong>
        </div>

        <!-- HSN/SAC Summary Table -->
        <div class="my-4 overflow-x-auto">
            <table class="w-full text-left text-[11px] border-y-2 border-[#1e3a8a]">
                <thead class="text-[#1e3a8a] font-bold border-b border-[#1e3a8a]">
                    <tr>
                        <th class="py-1 px-3">HSN/SAC</th>
                        <th class="py-1 px-3 text-right">Taxable Value</th>
                        <th class="py-1 px-3 text-center">Integrated Tax</th>
                        <th class="py-1 px-3 text-right">Amount</th>
                        <th class="py-1 px-3 text-right">Total Tax</th>
                    </tr>
                </thead>
                <tbody id="preview-hsn-body">
                    <!-- Dynamic HSN rows -->
                </tbody>
            </table>
        </div>

                <!-- Footer: Bank Details, EXACT QR Code, EXACT Seal & Signature (matching user uploaded reference) -->
        <div class="quotation-footer-container border-t-2 border-[#1e3a8a] pt-3 mt-4" style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-start; width: 100%; gap: 14px;">
            <!-- 1. Left: EXACT QR Code Block (Matching user uploaded Image) -->
            <div class="quotation-qr-col" style="flex: 0 0 160px; width: 160px; text-align: center;">
                <img src="/crm/images/hisab-mittra-qr-col.png?v=2" alt="HisabMittra UPI QR & Bank" class="quotation-qr-img" style="width: 155px; height: auto; object-fit: contain; display: block; margin: 0 auto; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </div>

            <!-- 2. Middle: Bank Details (Matching user uploaded reference) -->
            <div class="quotation-bank-col" style="flex: 1 1 auto; padding: 0 12px; font-size: 11px; line-height: 1.55; color: #1e293b;">
                <div style="font-weight: 800; font-size: 12.5px; color: #0f172a; margin-bottom: 6px;">Bank Details:</div>
                <table style="border-collapse: collapse; width: 100%; font-size: 11px; line-height: 1.55;">
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; width: 85px; font-weight: 500;">Company:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">HISABMITTRA</td>
                    </tr>
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; font-weight: 500;">Bank:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">IDFC FIRST Bank</td>
                    </tr>
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; font-weight: 500;">Account #:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">10296073180</td>
                    </tr>
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; font-weight: 500;">IFSC Code:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">IDFB0043413</td>
                    </tr>
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; font-weight: 500;">SWIFT Code:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">IDFBINBBMUM</td>
                    </tr>
                    <tr>
                        <td style="padding: 1.5px 8px 1.5px 0; color: #64748b; font-weight: 500;">Branch:</td>
                        <td style="padding: 1.5px 0; font-weight: 700; color: #0f172a;">JAIPUR - PRATAP NAGAR BRANCH</td>
                    </tr>
                </table>
            </div>

            <!-- 3. Right: EXACT Official Seal Stamp & Signature Block (Matching user uploaded Image) -->
            <div class="quotation-sign-col" style="flex: 0 0 210px; width: 210px; text-align: center;">
                <img src="/crm/images/hisab-mittra-seal-sign-exact.png" alt="For HISABMITTRA - Authorized Signatory" class="quotation-seal-img" style="width: 195px; height: auto; max-height: 145px; object-fit: contain; display: block; margin: 0 auto; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </div>
        </div>

        <!-- Bottom Notes (exact recreation of Image 1) -->
        <div class="quotation-notes-block mt-4 pt-3 border-t border-slate-200 text-[11px] text-slate-800 leading-relaxed">
            <strong class="text-slate-900 block mb-1 text-xs">Notes:</strong>
            <div id="preview-notes" class="whitespace-pre-line text-slate-800 font-medium">License: Valid for 1 year; for internal business use only.
Support: Available during business hours only.
Restrictions: Resale, redistribution, or modification of the software is strictly prohibited.
Refund Policy: No refund policy is there.
Contact: support@hisabmittra.com | +91 9783055170 | www.hisabmittra.com</div>
        </div>

    </div>

</div>

<!-- PRINT STYLES -->
<style>
@media print {
    @page {
        size: A4 portrait;
        margin: 5mm 8mm 5mm 8mm;
    }
    *, *::before, *::after {
        box-sizing: border-box !important;
    }
    html, body {
        width: 100% !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
        color: #0f172a !important;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        overflow: visible !important;
    }
    aside, header, nav, .no-print, [onclick*="toggleSidebar"], .crm-auto-refresh-widget {
        display: none !important;
    }
    main {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow: visible !important;
    }
    #quotation-print-container {
        display: block !important;
        position: relative !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
        padding: 4mm 6mm !important;
        box-shadow: none !important;
        border: none !important;
        background: #ffffff !important;
        overflow: visible !important;
        page-break-inside: auto !important;
    }
    .quotation-footer-container {
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        width: 100% !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        margin-top: 10px !important;
        padding-top: 6px !important;
        border-top: 2px solid #1e3a8a !important;
    }
    .quotation-qr-col {
        display: block !important;
        flex: 0 0 150px !important;
        width: 150px !important;
        text-align: center !important;
    }
    .quotation-qr-col img, .quotation-qr-img {
        display: block !important;
        width: 145px !important;
        max-width: 145px !important;
        height: auto !important;
        margin: 0 auto !important;
        image-rendering: -webkit-optimize-contrast !important;
    }
    .quotation-bank-col {
        display: block !important;
        flex: 1 1 auto !important;
        padding: 0 12px !important;
    }
    .quotation-sign-col {
        display: block !important;
        flex: 0 0 210px !important;
        width: 210px !important;
        text-align: center !important;
    }
    .quotation-sign-col img, .quotation-seal-img {
        display: block !important;
        width: 195px !important;
        max-width: 195px !important;
        height: auto !important;
        margin: 0 auto !important;
        image-rendering: -webkit-optimize-contrast !important;
    }
    .quotation-notes-block {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        margin-top: 8px !important;
        padding-top: 6px !important;
    }
}
</style>

<!-- JAVASCRIPT: Dynamic Quotation Controller & Calculations -->
<script>
const DEFAULT_NOTES_TEXT = `License: Valid for 1 year; for internal business use only
Support: Available during business hours only.
Restrictions: Resale, redistribution, or modification of the software is strictly prohibited.
Refund Policy: No refund policy is there.
Contact: support@hisabmittra.com | +91 9783055170 | www.hisabmittra.com`;

// Initial line items data matching user reference
let lineItemsData = [
    {
        description: "Basic Unlimited Plan for 1 Year",
        sac: "998314",
        rate: 7150,
        discount: 17,
        qty: 1
    },
    {
        description: "Professional Attendance and Payroll System",
        sac: "998314",
        rate: 2033.9,
        discount: 25,
        qty: 4
    }
];

// Helper: Convert Number to Indian Rupees Words
function inWords(num) {
    num = Math.round(num);
    const a = ['', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Eighteen ', 'Nineteen '];
    const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    
    if ((num = num.toString()).length > 9) return 'Overflow';
    let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return '';
    let str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'And ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str.trim() ? 'INR ' + str.trim() + ' Rupees Only.' : 'INR Zero Rupees Only.';
}

// Render Builder Form Items Table
function renderBuilderItems() {
    const tbody = document.getElementById('builder-items-tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    lineItemsData.forEach((item, index) => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50/50 transition';
        tr.innerHTML = `
            <td class="py-2 px-3">
                <input type="text" value="${item.description}" oninput="updateItemField(${index}, 'description', this.value)" placeholder="Item Description" class="w-full text-xs p-1.5 rounded-lg border border-slate-200 font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </td>
            <td class="py-2 px-3">
                <input type="text" value="${item.sac}" oninput="updateItemField(${index}, 'sac', this.value)" class="w-full text-xs p-1.5 rounded-lg border border-slate-200 font-mono text-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </td>
            <td class="py-2 px-3">
                <input type="number" step="any" value="${item.rate}" oninput="updateItemField(${index}, 'rate', parseFloat(this.value)||0)" class="w-full text-xs p-1.5 rounded-lg border border-slate-200 text-right font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </td>
            <td class="py-2 px-3">
                <input type="number" step="any" value="${item.discount}" oninput="updateItemField(${index}, 'discount', parseFloat(this.value)||0)" class="w-full text-xs p-1.5 rounded-lg border border-slate-200 text-center font-semibold text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </td>
            <td class="py-2 px-3 text-center">
                <input type="number" step="1" min="1" value="${item.qty}" oninput="updateItemField(${index}, 'qty', parseInt(this.value, 10)||1)" class="w-16 mx-auto text-xs p-1.5 rounded-lg border border-slate-200 text-center font-bold text-slate-800 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </td>
            <td class="py-2 px-3 text-center">
                <button type="button" onclick="removeItemRow(${index})" class="w-7 h-7 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center text-xs transition mx-auto cursor-pointer" title="Delete Item">
                    <i class="fa-solid fa-trash-can text-[11px]"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function updateItemField(index, field, value) {
    if (lineItemsData[index]) {
        lineItemsData[index][field] = value;
        updateQuotationPreview();
    }
}

function addLineItemRow() {
    lineItemsData.push({
        description: "New CRM Service Module",
        sac: "998314",
        rate: 2000,
        discount: 0,
        qty: 1
    });
    renderBuilderItems();
    updateQuotationPreview();
}

function removeItemRow(index) {
    if (lineItemsData.length > 1) {
        lineItemsData.splice(index, 1);
        renderBuilderItems();
        updateQuotationPreview();
    } else {
        alert("At least one line item is required in the quotation.");
    }
}

// Handle Auto-filling from Lead selector
function onLeadSelected(selectEl) {
    if (!selectEl || selectEl.selectedIndex <= 0) return;
    const opt = selectEl.options[selectEl.selectedIndex];
    
    const name = opt.getAttribute('data-name') || '';
    const company = opt.getAttribute('data-company') || '';
    const phone = opt.getAttribute('data-phone') || '';
    const email = opt.getAttribute('data-email') || '';
    const address = opt.getAttribute('data-address') || '';

    if (name) document.getElementById('builder-customer-name').value = name;
    if (company) document.getElementById('builder-company').value = company;
    if (phone) document.getElementById('builder-phone').value = phone;
    if (email) document.getElementById('builder-email').value = email;
    if (address) document.getElementById('builder-address').value = address;

    updateQuotationPreview();
}

// Reset Form Function matching reference Image 2
function resetQuotationForm() {
    document.getElementById('quotationBuilderForm').reset();
    document.getElementById('builder-customer-name').value = '';
    document.getElementById('builder-company').value = '';
    document.getElementById('builder-gstin').value = '';
    document.getElementById('builder-phone').value = '';
    document.getElementById('builder-email').value = '';
    document.getElementById('builder-address').value = '';
    document.getElementById('builder-pos').value = '08-RAJASTHAN';
    document.getElementById('builder-quote-no').value = 'MHSB/26-27/001';
    document.getElementById('builder-quote-date').value = '08 Oct 2026';
    document.getElementById('builder-validity').value = '23 Oct 2026';
    document.getElementById('builder-doc-type').value = 'Quotation';
    document.getElementById('builder-notes').value = DEFAULT_NOTES_TEXT;
    document.getElementById('builder-apply-gst').checked = true;
    document.getElementById('builder-inclusive-gst').checked = false;
    document.getElementById('builder-is-igst').checked = true;

    lineItemsData = [
        {
            description: "Basic Unlimited Plan for 1 Year",
            sac: "998314",
            rate: 7150,
            discount: 17,
            qty: 1
        },
        {
            description: "Professional Attendance and Payroll System",
            sac: "998314",
            rate: 2033.9,
            discount: 25,
            qty: 4
        }
    ];

    renderBuilderItems();
    updateQuotationPreview();
}

// Master Function: Recalculate everything and update the preview document below
function updateQuotationPreview() {
    // 1. Sync Text Fields
    const custName = document.getElementById('builder-customer-name').value.trim();
    const company = document.getElementById('builder-company').value.trim();
    const gstin = document.getElementById('builder-gstin').value.trim();
    const phone = document.getElementById('builder-phone').value.trim();
    const pos = document.getElementById('builder-pos').value.trim();
    const address = document.getElementById('builder-address').value.trim();
    const quoteNo = document.getElementById('builder-quote-no').value.trim();
    const quoteDate = document.getElementById('builder-quote-date').value.trim();
    const validity = document.getElementById('builder-validity').value.trim();
    const docType = document.getElementById('builder-doc-type').value.trim();
    const notes = document.getElementById('builder-notes').value.trim();

    const applyGst = document.getElementById('builder-apply-gst').checked;
    const isIgst = document.getElementById('builder-is-igst').checked;

    document.getElementById('preview-doc-title').textContent = docType.toUpperCase();
    document.getElementById('preview-quote-no').textContent = quoteNo || 'MHSB/26-27/001';
    document.getElementById('preview-quote-date').textContent = quoteDate || '08 Oct 2026';
    document.getElementById('preview-validity').textContent = validity || '23 Oct 2026';

    document.getElementById('preview-customer-name').textContent = custName;
    document.getElementById('preview-company-name').textContent = company;
    document.getElementById('preview-gstin').textContent = gstin;
    document.getElementById('preview-phone').textContent = phone;
    document.getElementById('preview-pos').textContent = pos || '08-RAJASTHAN';
    document.getElementById('preview-address').textContent = address;
    document.getElementById('preview-notes').textContent = notes || DEFAULT_NOTES_TEXT;

    // 2. Line Items Calculations
    const previewItemsTbody = document.getElementById('preview-items-body');
    previewItemsTbody.innerHTML = '';

    let totalQty = 0;
    let totalTaxable = 0;
    let totalTaxAmount = 0;
    let totalDiscountAmount = 0;
    const hsnGroups = {};

    lineItemsData.forEach((item, idx) => {
        const baseRate = parseFloat(item.rate) || 0;
        const discPercent = parseFloat(item.discount) || 0;
        const qty = parseInt(item.qty, 10) || 1;
        const sac = item.sac || '998314';

        // Calculation
        const unitDiscount = baseRate * (discPercent / 100);
        const discountedRate = baseRate - unitDiscount;
        const lineTaxable = discountedRate * qty;
        const lineDiscount = unitDiscount * qty;

        const taxRate = applyGst ? 18 : 0;
        const lineTax = lineTaxable * (taxRate / 100);
        const lineTotal = lineTaxable + lineTax;

        totalQty += qty;
        totalTaxable += lineTaxable;
        totalTaxAmount += lineTax;
        totalDiscountAmount += lineDiscount;

        // Group by HSN/SAC
        if (!hsnGroups[sac]) {
            hsnGroups[sac] = { taxable: 0, tax: 0 };
        }
        hsnGroups[sac].taxable += lineTaxable;
        hsnGroups[sac].tax += lineTax;

        // Render Row
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50/60 transition';
        tr.innerHTML = `
            <td class="py-2.5 px-2 text-center font-bold text-slate-700">${idx + 1}</td>
            <td class="py-2.5 px-2">
                <div class="font-bold text-slate-900 leading-tight">${item.description}</div>
                <div class="text-[10px] text-slate-500 mt-0.5">SAC: ${sac}</div>
            </td>
            <td class="py-2.5 px-2 text-right">
                <div class="font-bold text-slate-900">${discountedRate.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                ${discPercent > 0 ? `<div class="text-[10px] text-slate-400 line-through">${baseRate.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} (-${discPercent}%)</div>` : ''}
            </td>
            <td class="py-2.5 px-2 text-center font-bold text-slate-800">${qty}</td>
            <td class="py-2.5 px-2 text-right font-bold text-slate-900">${lineTaxable.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td class="py-2.5 px-2 text-right text-slate-700 font-medium">
                ${applyGst ? `${lineTax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} (18%)` : '₹0.00 (0%)'}
            </td>
            <td class="py-2.5 px-2 text-right font-extrabold text-slate-900">${lineTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        `;
        previewItemsTbody.appendChild(tr);
    });

    // 3. Totals Summary
    const unroundedTotal = totalTaxable + totalTaxAmount;
    const roundedGrandTotal = Math.round(unroundedTotal);
    const roundOff = +(roundedGrandTotal - unroundedTotal).toFixed(2);

    document.getElementById('preview-total-items-qty').textContent = `${lineItemsData.length} / ${totalQty}`;
    document.getElementById('preview-taxable-amount').textContent = `₹ ${totalTaxable.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    
    const taxLabel = isIgst ? 'IGST 18.0%' : 'CGST 9% + SGST 9%';
    document.getElementById('preview-tax-label').textContent = applyGst ? taxLabel : 'Tax (0%)';
    document.getElementById('preview-tax-amount').textContent = `₹ ${totalTaxAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    document.getElementById('preview-roundoff').textContent = roundOff >= 0 ? `${roundOff.toFixed(2)}` : `${roundOff.toFixed(2)}`;
    document.getElementById('preview-grand-total').textContent = `₹ ${roundedGrandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    document.getElementById('preview-total-discount').textContent = `₹ ${totalDiscountAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    // In Words
    document.getElementById('preview-amount-words').textContent = inWords(roundedGrandTotal);

    // 4. HSN Table
    const hsnTbody = document.getElementById('preview-hsn-body');
    hsnTbody.innerHTML = '';
    let totalHsnTaxable = 0;
    let totalHsnTax = 0;

    Object.keys(hsnGroups).forEach(sacKey => {
        const group = hsnGroups[sacKey];
        totalHsnTaxable += group.taxable;
        totalHsnTax += group.tax;

        const htr = document.createElement('tr');
        htr.className = 'border-b border-slate-100';
        htr.innerHTML = `
            <td class="py-1 px-3 font-mono font-bold text-slate-800">${sacKey}</td>
            <td class="py-1 px-3 text-right font-medium text-slate-900">${group.taxable.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td class="py-1 px-3 text-center text-slate-700 font-medium">${applyGst ? '18%' : '0%'}</td>
            <td class="py-1 px-3 text-right font-medium text-slate-900">${group.tax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td class="py-1 px-3 text-right font-bold text-slate-900">${group.tax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        `;
        hsnTbody.appendChild(htr);
    });

    const totHtr = document.createElement('tr');
    totHtr.className = 'font-bold bg-slate-50 text-slate-900';
    totHtr.innerHTML = `
        <td class="py-1 px-3 font-black">TOTAL</td>
        <td class="py-1 px-3 text-right font-bold">${totalHsnTaxable.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        <td class="py-1 px-3 text-center"></td>
        <td class="py-1 px-3 text-right font-bold">${totalHsnTax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        <td class="py-1 px-3 text-right font-bold">${totalHsnTax.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
    `;
    hsnTbody.appendChild(totHtr);
}

    function printQuotationDoc() {
        window.print();
    }

    function downloadQuotationPdf() {
        const el = document.getElementById('quotation-print-container');
        if (!el) {
            window.print();
            return;
        }
        const quoteNo = (document.getElementById('preview-quote-no') ? document.getElementById('preview-quote-no').textContent.trim() : 'MHSB-001');
        const filename = 'Quotation-' + quoteNo.replace(/[^a-zA-Z0-9_-]/g, '_') + '.pdf';

        if (window.html2pdf) {
            const opt = {
                margin: [4, 6, 4, 6],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, letterRendering: true, logging: false },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(el).save().catch(err => {
                console.warn('html2pdf fallback to print:', err);
                window.print();
            });
        } else {
            window.print();
        }
    }

// Initialize on Load
document.addEventListener('DOMContentLoaded', function() {
    renderBuilderItems();
    updateQuotationPreview();
});
</script>
@endsection
