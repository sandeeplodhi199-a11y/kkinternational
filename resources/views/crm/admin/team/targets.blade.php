@extends('crm.layouts.master')

@section('title', 'Sales Quota Targets')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Sales Targets & Quotas</h2>
            <p class="text-xs text-slate-500 font-medium">Monthly, quarterly and annual sales expectations with progress tracking</p>
        </div>
        <button onclick="document.getElementById('add-target-modal').classList.remove('hidden')" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Set New Target</span>
        </button>
    </div>

    <!-- Targets Table -->
    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Sales Representative</th>
                        <th class="py-3 px-4">Period</th>
                        <th class="py-3 px-4">Target Amount</th>
                        <th class="py-3 px-4">Achieved Amount</th>
                        <th class="py-3 px-4">Remaining</th>
                        <th class="py-3 px-4">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($targets as $t)
                        @php
                            $pct = $t->target_amount > 0 ? min(100, round(($t->achieved_amount / $t->target_amount) * 100)) : 0;
                            $rem = max(0, $t->target_amount - $t->achieved_amount);
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $t->employee ? $t->employee->name : 'Representative' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                <span class="font-bold">{{ $t->period_name }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $t->period_type }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">₹{{ number_format($t->target_amount) }}</td>
                            <td class="py-3.5 px-4 font-extrabold text-emerald-800">₹{{ number_format($t->achieved_amount) }}</td>
                            <td class="py-3.5 px-4 text-slate-500">₹{{ number_format($rem) }}</td>
                            <td class="py-3.5 px-4 w-44">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-[#1b4d3e] h-2 rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-700">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">No targets configured.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $targets->links() }}
        </div>
    </div>

    <!-- Modal: Set Target -->
    <div id="add-target-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Assign Sales Quota</h3>
                <button type="button" onclick="document.getElementById('add-target-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.team.targets.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Representative *</label>
                    <select name="user_id" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Period Type *</label>
                        <select name="period_type" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Period Label *</label>
                        <input type="text" name="period_name" value="October 2026" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Quota (₹) *</label>
                    <input type="number" name="target_amount" value="500000" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Start Date *</label>
                        <input type="date" name="start_date" value="{{ date('Y-m-01') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">End Date *</label>
                        <input type="date" name="end_date" value="{{ date('Y-m-t') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-target-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Assign Quota</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
