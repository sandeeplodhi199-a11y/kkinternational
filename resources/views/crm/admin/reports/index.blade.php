@extends('crm.layouts.master')

@section('title', 'Analytics & Reports Center')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Business Intelligence & Reports</h2>
            <p class="text-xs text-slate-500 font-medium">Cross-functional analysis across revenue, lead funnels, and representative productivity</p>
        </div>
        <a href="{{ route('crm.admin.reports.export') }}?type={{ $reportType }}&start_date={{ $startDate }}&end_date={{ $endDate }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-file-csv text-xs"></i>
            <span>Export CSV Report</span>
        </a>
    </div>

    <!-- Summary KPI Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Generated Leads</span>
            <div class="text-xl font-black text-slate-800 mt-1">{{ $totalLeadsCount }}</div>
            <span class="text-[10px] text-slate-400">In selected date range</span>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Closed Deals Value</span>
            <div class="text-xl font-black text-[#1b4d3e] mt-1">₹{{ number_format($totalDealsWon) }}</div>
            <span class="text-[10px] text-slate-400">Won revenue</span>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Collections Received</span>
            <div class="text-xl font-black text-emerald-800 mt-1">₹{{ number_format($totalCollected) }}</div>
            <span class="text-[10px] text-slate-400">Cleared wire transfers</span>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Completed Tasks</span>
            <div class="text-xl font-black text-blue-700 mt-1">{{ $totalTasksDone }}</div>
            <span class="text-[10px] text-slate-400">Operations executed</span>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="crm-card p-4">
        <form method="GET" action="{{ route('crm.admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-[10px] font-bold text-slate-600 mb-1">Report Module</label>
                <select name="type" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    <option value="leads" {{ $reportType === 'leads' ? 'selected' : '' }}>Lead Performance Report</option>
                    <option value="deals" {{ $reportType === 'deals' ? 'selected' : '' }}>Sales & Deals Report</option>
                    <option value="revenue" {{ $reportType === 'revenue' ? 'selected' : '' }}>Revenue & Payments Report</option>
                    <option value="customers" {{ $reportType === 'customers' ? 'selected' : '' }}>Customer Growth Report</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-600 mb-1">From Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs p-2 rounded-xl border border-slate-200">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-600 mb-1">To Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs p-2 rounded-xl border border-slate-200">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition">
                    Generate Analysis
                </button>
            </div>
        </form>
    </div>

    <!-- Report Table Display -->
    <div class="crm-card overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800 capitalize">{{ $reportType }} Report Output</h3>
            <span class="text-xs text-slate-400 font-medium">{{ count($reportData) }} total rows</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        @if($reportType === 'leads')
                            <th class="py-3 px-4">Lead Code</th>
                            <th class="py-3 px-4">Contact</th>
                            <th class="py-3 px-4">Company</th>
                            <th class="py-3 px-4">Expected Value</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Rep</th>
                        @elseif($reportType === 'revenue' || $reportType === 'payments')
                            <th class="py-3 px-4">Receipt #</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Payment Method</th>
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Status</th>
                        @else
                            <th class="py-3 px-4">Deal Title</th>
                            <th class="py-3 px-4">Customer Account</th>
                            <th class="py-3 px-4">Stage</th>
                            <th class="py-3 px-4">Win Probability</th>
                            <th class="py-3 px-4">Deal Value</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($reportData as $row)
                        <tr class="hover:bg-slate-50/70 transition">
                            @if($reportType === 'leads')
                                <td class="py-3 px-4 font-bold text-slate-700">{{ $row->lead_code }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $row->name }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $row->company }}</td>
                                <td class="py-3 px-4 font-extrabold text-slate-800">₹{{ number_format($row->expected_value) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $row->status }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-600">{{ $row->assignedEmployee ? $row->assignedEmployee->name : 'Unassigned' }}</td>
                            @elseif($reportType === 'revenue' || $reportType === 'payments')
                                <td class="py-3 px-4 font-bold text-slate-700">{{ $row->payment_no }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $row->customer ? $row->customer->name : 'Account' }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $row->payment_method }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $row->payment_date }}</td>
                                <td class="py-3 px-4 font-extrabold text-emerald-800">₹{{ number_format($row->amount, 2) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $row->status }}</span>
                                </td>
                            @else
                                <td class="py-3 px-4 font-bold text-slate-800">{{ $row->title }}</td>
                                <td class="py-3 px-4 text-slate-700">{{ $row->customer ? $row->customer->name : 'Client' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">{{ $row->stage }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-600 font-bold">{{ $row->probability }}%</td>
                                <td class="py-3 px-4 font-extrabold text-[#1b4d3e]">₹{{ number_format($row->value) }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">No records found for the chosen filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
