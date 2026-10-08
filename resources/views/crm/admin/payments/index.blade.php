@extends('crm.layouts.master')

@section('title', 'Payment Collections')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Payments & Collections</h2>
            <p class="text-xs text-slate-500 font-medium">Record incoming wire transfers, UPI payments and track pending balances</p>
        </div>
        <div class="flex items-center flex-wrap gap-3">
            <!-- Year & Month Filter Dropdowns -->
            <form id="payment-period-filter-form" method="GET" action="{{ route('crm.admin.payments.index') }}" class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-200/90 shadow-xs">
                <i class="fa-solid fa-calendar-days text-emerald-600 text-xs"></i>
                
                <!-- Year Dropdown -->
                <div class="flex items-center gap-1">
                    <label for="payment-filter-year" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Year:</label>
                    <select name="year" id="payment-filter-year" onchange="document.getElementById('payment-period-filter-form').submit()" class="text-xs font-bold text-slate-700 bg-transparent border-none outline-none cursor-pointer focus:ring-0 py-0.5 pr-2">
                        <option value="">All Years</option>
                        @php
                            $currentYear = (int)date('Y');
                            $years = range($currentYear + 1, $currentYear - 3);
                        @endphp
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ (string)($selectedYear ?? '') === (string)$yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                <span class="text-slate-300">|</span>

                <!-- Month Dropdown -->
                <div class="flex items-center gap-1">
                    <label for="payment-filter-month" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Month:</label>
                    <select name="month" id="payment-filter-month" onchange="document.getElementById('payment-period-filter-form').submit()" class="text-xs font-bold text-slate-700 bg-transparent border-none outline-none cursor-pointer focus:ring-0 py-0.5 pr-2">
                        <option value="">All Months</option>
                        @php
                            $months = [
                                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                            ];
                        @endphp
                        @foreach($months as $mNum => $mName)
                            <option value="{{ $mNum }}" {{ (string)($selectedMonth ?? '') === (string)$mNum ? 'selected' : '' }}>{{ $mName }}</option>
                        @endforeach
                    </select>
                </div>

                @if(!empty($selectedYear) || !empty($selectedMonth))
                    <a href="{{ route('crm.admin.payments.index') }}" title="Clear Filters" class="ml-1 text-slate-400 hover:text-rose-500 text-xs transition">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('crm.admin.payments.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Record Payment</span>
            </a>
        </div>
    </div>

    <!-- KPI Summary Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="crm-card p-5">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Cleared Revenue</span>
            <div id="kpi-cleared-revenue" class="text-2xl font-black text-emerald-800">₹{{ number_format($totalReceived, 2) }}</div>
            <span class="text-[11px] text-slate-400 mt-1 block">Successfully reconciled</span>
        </div>
        <div class="crm-card p-5">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Outstanding Invoices</span>
            <div id="kpi-outstanding-invoices" class="text-2xl font-black text-rose-700">₹{{ number_format($totalPending, 2) }}</div>
            <span class="text-[11px] text-slate-400 mt-1 block">Pending client transfer</span>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Receipt #</th>
                        <th class="py-3 px-4">Customer Account</th>
                        <th class="py-3 px-4">Amount Paid</th>
                        <th class="py-3 px-4">Payment Date</th>
                        <th class="py-3 px-4">Channel / Method</th>
                        <th class="py-3 px-4">Transaction Ref</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($payments as $p)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $p->payment_no }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $p->customer ? $p->customer->name : 'Commercial Account' }}
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-[#1b4d3e]">₹{{ number_format($p->amount, 2) }}</td>
                            <td class="py-3.5 px-4 text-slate-600" data-payment-date="{{ $p->payment_date }}">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M, Y') }}</td>
                            <td class="py-3.5 px-4 text-slate-700">{{ $p->payment_method }}</td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">{{ $p->transaction_ref ?: '—' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $p->status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400">No payment receipts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $payments->links() }}
        </div>
    </div>

    <!-- Modal: Record Payment -->
    <div id="add-payment-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Record Received Payment</h3>
                <button type="button" onclick="document.getElementById('add-payment-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.payments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Customer</label>
                        <select name="customer_id" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Select Account...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Amount (₹) *</label>
                        <input type="number" name="amount" required value="50000" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Date *</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Bank Transfer">Bank Transfer (NEFT/RTGS)</option>
                            <option value="UPI">UPI / QR Code</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Reference / UTR #</label>
                        <input type="text" name="transaction_ref" placeholder="e.g. HDFC8890213" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Notes</label>
                    <textarea name="notes" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-payment-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
