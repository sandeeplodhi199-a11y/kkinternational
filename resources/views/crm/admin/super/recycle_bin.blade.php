@extends('crm.layouts.master')

@section('title', 'Recycle Bin & Trash Recovery')

@section('content')
<div class="space-y-6">

        <!-- Top Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-trash-arrow-up text-emerald-600 text-2xl"></i>
                <span>Recycle Bin &amp; Trash Recovery</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Accidentally or maliciously deleted leads, deals, customers, follow-ups, and team records can be safely restored with 1-click.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap shrink-0">
            @if($totalTrash > 0)
                <form action="{{ route('crm.admin.super.recycle_bin.restore_all', ['type' => $type]) }}" method="POST" onsubmit="return confirm('Restore all items in this view?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition active:scale-95 flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Restore All</span>
                    </button>
                </form>

                <form action="{{ route('crm.admin.super.recycle_bin.empty', ['type' => $type]) }}" method="POST" onsubmit="return confirm('WARNING: Permanently purge all records in this view? This cannot be undone.');">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-bold text-xs shadow-xs transition active:scale-95 flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Empty Trash</span>
                    </button>
                </form>
            @endif

            <span class="px-4 py-2 rounded-xl bg-slate-900 text-white font-black text-xs shadow-xs flex items-center gap-1.5">
                <i class="fa-solid fa-recycle text-emerald-400 text-xs"></i>
                <span>{{ $totalTrash }} Items in Bin</span>
            </span>
        </div>
    </div>

    <!-- Filter Category Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-bold [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        <a href="?type=all" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'all' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>All Trash</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'all' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $totalTrash }}</span>
        </a>

        <a href="?type=leads" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'leads' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Leads</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'leads' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['leads'] ?? 0 }}</span>
        </a>

        <a href="?type=customers" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'customers' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Customers</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'customers' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['customers'] ?? 0 }}</span>
        </a>

        <a href="?type=deals" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'deals' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Deals</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'deals' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['deals'] ?? 0 }}</span>
        </a>

        <a href="?type=quotations" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'quotations' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Quotations</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'quotations' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['quotations'] ?? 0 }}</span>
        </a>

        <a href="?type=followups" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'followups' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Follow-ups</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'followups' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['followups'] ?? 0 }}</span>
        </a>

        <a href="?type=tasks" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'tasks' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Tasks</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'tasks' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['tasks'] ?? 0 }}</span>
        </a>

        <a href="?type=demos" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'demos' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Demos</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'demos' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['demos'] ?? 0 }}</span>
        </a>

        <a href="?type=payments" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'payments' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Payments</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'payments' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['payments'] ?? 0 }}</span>
        </a>

        <a href="?type=employees" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'employees' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Team</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'employees' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['employees'] ?? 0 }}</span>
        </a>

        <a href="?type=products" class="px-4 py-2 rounded-xl border transition shrink-0 flex items-center gap-2 {{ $type === 'products' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span>Products</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $type === 'products' ? 'bg-white/20 text-white font-black' : 'bg-slate-100 text-slate-600 font-bold' }}">{{ $counts['products'] ?? 0 }}</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="crm-card border border-slate-200 overflow-hidden bg-white rounded-3xl shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-extrabold text-[11px] uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-4/12">ITEM / ENTITY</th>
                        <th class="py-3.5 px-4 w-1/12 text-center">MODULE</th>
                        <th class="py-3.5 px-4 w-3/12">DETAILS / INFO</th>
                        <th class="py-3.5 px-4 w-2/12">DELETED AT</th>
                        <th class="py-3.5 px-4 w-2/12 text-right">RESTORE / PURGE</th>
                        <th class="py-3 px-4">ITEM / ENTITY</th>
                        <th class="py-3 px-4">MODULE</th>
                        <th class="py-3 px-4">DETAILS / INFO</th>
                        <th class="py-3 px-4">DELETED AT</th>
                        <th class="py-3 px-4 text-right">RESTORE / PURGE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-bold">
                    {{-- 1. Trashed Leads --}}
                    @foreach($deletedLeads as $lead)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $lead->name }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $lead->company ?: 'Individual' }} • {{ $lead->lead_code }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-orange-100 text-orange-800">Lead</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">{{ $lead->phone ?: ($lead->email ?: '—') }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $lead->deleted_at ? $lead->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'lead', 'id' => $lead->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'lead', 'id' => $lead->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 2. Trashed Customers --}}
                    @foreach($deletedCustomers as $cust)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $cust->name }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $cust->company ?: 'Account' }} • {{ $cust->customer_code }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-800">Customer</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">{{ $cust->phone ?: ($cust->email ?: '—') }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $cust->deleted_at ? $cust->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'customer', 'id' => $cust->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'customer', 'id' => $cust->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 3. Trashed Deals --}}
                    @foreach($deletedDeals as $deal)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $deal->title }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">Value: ₹{{ number_format($deal->value) }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800">Deal</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">Stage: {{ $deal->stage }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $deal->deleted_at ? $deal->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'deal', 'id' => $deal->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'deal', 'id' => $deal->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 4. Trashed Quotations --}}
                    @foreach($deletedQuotations as $quote)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $quote->quotation_no }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $quote->customer_name }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800">Quotation</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">₹{{ number_format($quote->grand_total) }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $quote->deleted_at ? $quote->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'quotation', 'id' => $quote->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'quotation', 'id' => $quote->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 5. Trashed Follow-ups --}}
                    @foreach($deletedFollowups as $f)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">Follow-up: {{ $f->type }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $f->notes ?: 'Scheduled' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">Follow-up</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">{{ $f->date }} {{ $f->time }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $f->deleted_at ? $f->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'followup', 'id' => $f->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'followup', 'id' => $f->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 6. Trashed Tasks --}}
                    @foreach($deletedTasks as $t)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $t->title }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $t->description ?: 'CRM Task' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-violet-100 text-violet-800">Task</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">Due: {{ $t->due_date }} • {{ $t->priority }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $t->deleted_at ? $t->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'task', 'id' => $t->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'task', 'id' => $t->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 7. Trashed Demos --}}
                    @foreach($deletedDemos as $demo)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $demo->title }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $demo->notes ?: 'Product Walkthrough' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-cyan-100 text-cyan-800">Demo</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">{{ $demo->date }} {{ $demo->time }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $demo->deleted_at ? $demo->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'demo', 'id' => $demo->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'demo', 'id' => $demo->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 8. Trashed Payments --}}
                    @foreach($deletedPayments as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $p->payment_no }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $p->payment_method }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">Payment</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">₹{{ number_format($p->amount) }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $p->deleted_at ? $p->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'payment', 'id' => $p->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'payment', 'id' => $p->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 9. Trashed Employees --}}
                    @foreach($deletedEmployees as $emp)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $emp->name }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $emp->designation }} • {{ $emp->employee_code }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800">Team</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">{{ $emp->email }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $emp->deleted_at ? $emp->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'employee', 'id' => $emp->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'employee', 'id' => $emp->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- 10. Trashed Products --}}
                    @foreach($deletedProducts as $prod)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $prod->name }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold">{{ $prod->code ?: 'Item' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-teal-100 text-teal-800">Product</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-mono">₹{{ number_format($prod->price) }} • {{ $prod->category }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $prod->deleted_at ? $prod->deleted_at->diffForHumans() : 'Recently' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.recycle_bin.restore', ['type' => 'product', 'id' => $prod->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-rotate-left text-xs"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('crm.admin.super.recycle_bin.force', ['type' => 'product', 'id' => $prod->id]) }}" method="POST" onsubmit="return confirm('Permanently destroy this record? Cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Purge
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($totalTrash == 0)
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 font-bold">
                                <i class="fa-solid fa-trash-can text-slate-300 text-3xl mb-2 block"></i>
                                Recycle Bin is empty. No deleted records found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
