@extends('crm.layouts.master')

@section('title', 'Customer 360° Profile - ' . $customer->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.customers.index') }}" class="w-9 h-9 rounded-full bg-white border border-[#e7ece4] flex items-center justify-center text-slate-600 hover:text-slate-900 shadow-sm transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">{{ $customer->name }}</h2>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800">
                        {{ $customer->status }} Account
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium">{{ $customer->customer_code }} &bull; {{ $customer->company }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('crm.admin.quotations.create') }}?customer_id={{ $customer->id }}&name={{ urlencode($customer->name) }}" class="px-4 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-sm">
                + Create Quotation
            </a>
        </div>
    </div>

    <!-- 360 Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Info Card -->
        <div class="crm-card p-6 space-y-4">
            <div class="text-center pb-4 border-b border-slate-100">
                <div class="w-16 h-16 rounded-3xl bg-blue-600 text-white font-black text-2xl flex items-center justify-center mx-auto mb-3 shadow-md shadow-blue-900/10">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h3 class="text-base font-bold text-slate-800">{{ $customer->name }}</h3>
                <p class="text-xs text-slate-500 font-medium">{{ $customer->company }}</p>
                <div class="mt-3 text-lg font-black text-emerald-800">
                    ₹{{ number_format($customer->total_spent) }} <span class="text-xs font-normal text-slate-400">Total Spend</span>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Email:</span>
                    <span class="font-bold text-slate-800">{{ $customer->email ?: '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Phone:</span>
                    <span class="font-bold text-slate-800">{{ $customer->phone ?: '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Assigned Rep:</span>
                    <span class="font-bold text-slate-800">{{ $customer->assignedEmployee ? $customer->assignedEmployee->name : 'Unassigned' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Billing Address:</span>
                    <p class="p-2.5 rounded-xl bg-slate-50 text-slate-700 font-medium leading-relaxed">{{ $customer->address ?: 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Right: Quotations, Payments & Deals Tabs (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Deals & Opportunities -->
            <div class="crm-card p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Associated Deals & Pipeline</h3>
                <div class="space-y-2">
                    @forelse($customer->deals as $deal)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $deal->title }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $deal->expected_closing_date ? 'Closing: ' . $deal->expected_closing_date : '' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-slate-800">₹{{ number_format($deal->value) }}</span>
                                <span class="text-[10px] block px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 mt-1">{{ $deal->stage }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No active deals found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Quotations & Invoices -->
            <div class="crm-card p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Quotations & Proformas</h3>
                <div class="space-y-2">
                    @forelse($customer->quotations as $q)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $q->quotation_no }}</span>
                                <span class="text-[11px] text-slate-400 block">Date: {{ $q->quotation_date }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-extrabold text-slate-800">₹{{ number_format($q->grand_total) }}</span>
                                <a href="{{ route('crm.admin.quotations.show', $q->id) }}" class="px-2.5 py-1 rounded-full bg-white border border-slate-200 font-bold text-slate-700 hover:text-emerald-800">View</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No quotations generated yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Payments History -->
            <div class="crm-card p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Payments History</h3>
                <div class="space-y-2">
                    @forelse($customer->payments as $p)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $p->payment_no }} ({{ $p->payment_method }})</span>
                                <span class="text-[11px] text-slate-400 block">{{ $p->payment_date }}</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-emerald-800">₹{{ number_format($p->amount) }}</span>
                                <span class="text-[10px] font-bold text-emerald-600 block">{{ $p->status }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No payment history recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
