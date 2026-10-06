@extends('crm.layouts.master')

@section('title', 'Record Payment')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.payments.index') }}" class="hover:text-emerald-700 transition">Payments</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Record Payment</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-receipt"></i>
                </span>
                <span>Record Client Payment Receipt</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Post customer transactions, link quotation invoices, and log transaction references.
            </p>
        </div>

        <a href="{{ route('crm.admin.payments.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Payments</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.payments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Client & Quotation Information -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-emerald-600 text-xs"></i>
                        <span>Client & Quotation Matching</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Paying Customer *</label>
                        <select name="customer_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">-- Direct Customer Account --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company ?: 'Client' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Related Quotation / Invoice (Optional)</label>
                        <select name="quotation_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono text-xs font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">-- No Quotation Linked --</option>
                            @foreach($quotations as $q)
                                <option value="{{ $q->id }}">{{ $q->quotation_no }} &bull; ₹{{ number_format($q->grand_total) }} ({{ $q->customer_name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Transaction Value & Method -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-emerald-600 text-xs"></i>
                        <span>Financial Parameters</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Amount Paid (₹) *</label>
                        <input type="number" step="0.01" name="amount" required placeholder="e.g. 75000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Payment Date *</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Payment Method *</label>
                        <select name="payment_method" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Bank Transfer (NEFT/RTGS)">Bank Transfer (NEFT/RTGS)</option>
                            <option value="UPI / QR Code">UPI / QR Code</option>
                            <option value="Razorpay">Razorpay Online</option>
                            <option value="Cheque">Bank Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit / Debit Card</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Transaction Reference & Settlement Status -->
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Transaction ID / UTR / Cheque #</label>
                        <input type="text" name="transaction_ref" placeholder="e.g. UTR20261002987654" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Settlement Status</label>
                        <select name="status" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Paid" selected>Paid / Cleared</option>
                            <option value="Pending">Pending Clearance</option>
                            <option value="Failed">Failed / Bounced</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Payment Remarks / Account Memo</label>
                <textarea name="notes" rows="3" placeholder="Tax deducted, milestone installment 1 of 2, payment bank branch..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.payments.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-md shadow-emerald-600/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Record Payment</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
