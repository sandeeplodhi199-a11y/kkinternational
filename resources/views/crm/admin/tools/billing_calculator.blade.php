@extends('crm.layouts.master')

@section('title', 'Billing Calculator')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <span>Tools</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <span class="text-slate-800">Financial Tools</span>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-calculator text-emerald-700 text-xl"></i>
                <span>CRM Billing & Pricing Calculator</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Calculate customized enterprise pricing, user licenses, add-ons, taxes, and discounts instantly.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.quotations.create') }}" class="px-5 py-2.5 rounded-full bg-[#1b4d3e] text-white font-bold text-xs hover:bg-[#153e32] transition shadow-sm inline-flex items-center gap-2">
                <i class="fa-solid fa-file-invoice"></i>
                <span>New Quotation</span>
            </a>
        </div>
    </div>

    <!-- Calculator Interactive Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Configuration Inputs -->
        <div class="lg:col-span-2 space-y-5">
            <div class="crm-card p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-700"></i>
                    <span>Plan & User License Configuration</span>
                </h3>

                <div class="space-y-4">
                    <!-- Base Product / Package Selection -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Primary Plan / Product</label>
                        <select id="baseProductSelect" onchange="calculatePricing()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @foreach($products as $prod)
                                <option value="{{ $prod->price }}" data-name="{{ $prod->name }}">{{ $prod->name }} — ₹{{ number_format($prod->price, 0) }} / user</option>
                            @endforeach
                            <option value="9999" data-name="Enterprise CRM Annual License" selected>Enterprise CRM Suite — ₹9,999 / user</option>
                            <option value="4999" data-name="Professional Growth Edition">Professional Growth Edition — ₹4,999 / user</option>
                            <option value="1999" data-name="Starter CRM Cloud">Starter CRM Cloud — ₹1,999 / user</option>
                        </select>
                    </div>

                    <!-- User License Seats Range Slider -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-bold text-slate-700">Number of User Seats / Licenses</label>
                            <span class="text-xs font-black text-emerald-700 px-2.5 py-0.5 rounded-md bg-emerald-50 border border-emerald-200" id="seatCountBadge">10 Seats</span>
                        </div>
                        <input type="range" id="seatSlider" min="1" max="100" value="10" oninput="updateSeatCount(this.value)" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-700">
                        <div class="flex justify-between text-[10px] text-slate-400 font-semibold mt-1">
                            <span>1 User</span>
                            <span>25 Users</span>
                            <span>50 Users</span>
                            <span>100+ Users</span>
                        </div>
                    </div>

                    <!-- Add-on Modules (Checkboxes) -->
                    <div class="pt-2">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Optional Add-on Enterprise Modules</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <label class="p-3 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-emerald-50/30 transition">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addonWhatsapp" value="4500" onchange="calculatePricing()" class="addon-check w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">WhatsApp CRM API</span>
                                        <span class="text-[10px] text-slate-400">Automated messaging</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-700">+₹4,500</span>
                            </label>

                            <label class="p-3 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-emerald-50/30 transition">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addonCloud" value="6000" onchange="calculatePricing()" class="addon-check w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">Dedicated 1TB Cloud</span>
                                        <span class="text-[10px] text-slate-400">High-speed file storage</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-700">+₹6,000</span>
                            </label>

                            <label class="p-3 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-emerald-50/30 transition">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addonAmc" value="8500" onchange="calculatePricing()" class="addon-check w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">24/7 Priority SLA</span>
                                        <span class="text-[10px] text-slate-400">Dedicated engineer</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-700">+₹8,500</span>
                            </label>

                            <label class="p-3 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-emerald-50/30 transition">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addonBi" value="5000" onchange="calculatePricing()" class="addon-check w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">Advanced BI & AI Funnel</span>
                                        <span class="text-[10px] text-slate-400">Predictive conversions</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-700">+₹5,000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Discount Slider / Input -->
                    <div class="pt-2 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Billing Term</label>
                            <select id="billingTermSelect" onchange="calculatePricing()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 bg-white">
                                <option value="1">Annual (1 Year) — Standard</option>
                                <option value="2">2-Year Multi-Year (5% Term Discount)</option>
                                <option value="3">3-Year Enterprise (10% Term Discount)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Negotiated Discount (%)</label>
                            <input type="number" id="discountPercentInput" value="5" min="0" max="50" oninput="calculatePricing()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Real-time Invoice / Quote Preview -->
        <div class="space-y-4">
            <div class="crm-card p-6 bg-slate-900 text-white relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <span class="text-xs font-bold tracking-wider uppercase text-emerald-400">Pricing Breakdown</span>
                    <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-900/60 text-emerald-300 font-mono">INR ₹</span>
                </div>

                <div class="space-y-2.5 text-xs text-slate-300">
                    <div class="flex justify-between">
                        <span>Base License Subtotal:</span>
                        <span class="font-bold text-white" id="outBaseSubtotal">₹99,990</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Add-on Modules:</span>
                        <span class="font-bold text-white" id="outAddonsSubtotal">₹0</span>
                    </div>

                    <div class="flex justify-between text-rose-400">
                        <span>Discount Applied:</span>
                        <span class="font-bold" id="outDiscount">-₹4,999</span>
                    </div>

                    <div class="flex justify-between pt-2 border-t border-slate-800 text-slate-300">
                        <span>Taxable Amount:</span>
                        <span class="font-bold text-white" id="outTaxable">₹94,991</span>
                    </div>

                    <div class="flex justify-between text-slate-400">
                        <span>GST / Taxes (18%):</span>
                        <span class="font-bold text-slate-300" id="outGst">₹17,098</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t-2 border-slate-700/80 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Net Payable Total</span>
                        <span class="text-2xl font-black text-amber-300" id="outGrandTotal">₹1,12,089</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('crm.admin.quotations.create') }}" class="w-full py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span>Create Official Quotation</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateSeatCount(val) {
        document.getElementById('seatCountBadge').innerText = val + ' Seats';
        calculatePricing();
    }

    function calculatePricing() {
        const basePrice = parseFloat(document.getElementById('baseProductSelect').value) || 0;
        const seats = parseInt(document.getElementById('seatSlider').value) || 1;
        const baseSubtotal = basePrice * seats;

        let addonTotal = 0;
        document.querySelectorAll('.addon-check:checked').forEach(el => {
            addonTotal += parseFloat(el.value) || 0;
        });

        const grossTotal = baseSubtotal + addonTotal;
        const discountPct = parseFloat(document.getElementById('discountPercentInput').value) || 0;
        const discountAmount = grossTotal * (discountPct / 100);
        const taxable = Math.max(0, grossTotal - discountAmount);
        const gst = taxable * 0.18;
        const grandTotal = taxable + gst;

        document.getElementById('outBaseSubtotal').innerText = '₹' + Math.round(baseSubtotal).toLocaleString('en-IN');
        document.getElementById('outAddonsSubtotal').innerText = '₹' + Math.round(addonTotal).toLocaleString('en-IN');
        document.getElementById('outDiscount').innerText = '-₹' + Math.round(discountAmount).toLocaleString('en-IN');
        document.getElementById('outTaxable').innerText = '₹' + Math.round(taxable).toLocaleString('en-IN');
        document.getElementById('outGst').innerText = '₹' + Math.round(gst).toLocaleString('en-IN');
        document.getElementById('outGrandTotal').innerText = '₹' + Math.round(grandTotal).toLocaleString('en-IN');
    }

    document.addEventListener('DOMContentLoaded', calculatePricing);
</script>
@endpush
@endsection
