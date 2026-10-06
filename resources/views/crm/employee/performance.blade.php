@extends('crm.layouts.master')

@section('title', 'My Performance')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Sales Performance & Quota</h2>
        <p class="text-xs text-slate-500 font-medium">Tracking conversion milestones, closed revenue and activity volume</p>
    </div>

    <!-- Quota Card -->
    <div class="crm-card p-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Quarterly Target Progress</h3>
                <p class="text-xs text-slate-500">Target quota: ₹{{ number_format($target) }}</p>
            </div>
            <span class="text-xl font-black text-emerald-800">{{ $achievedPercent }}%</span>
        </div>

        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden mb-2">
            <div class="bg-gradient-to-r from-[#1b4d3e] to-[#2d6a4f] h-3 rounded-full" style="width: {{ $achievedPercent }}%"></div>
        </div>
        <div class="flex justify-between text-xs text-slate-400 font-medium">
            <span>₹{{ number_format($revenue) }} Achieved</span>
            <span>₹{{ number_format(max(0, $target - $revenue)) }} Remaining</span>
        </div>
    </div>

    <!-- Stats Matrix -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Assigned Leads</span>
            <div class="text-xl font-black text-slate-800 mt-1">{{ $leadsAssigned }}</div>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Won Conversions</span>
            <div class="text-xl font-black text-emerald-800 mt-1">{{ $leadsConverted }}</div>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Conversion Rate</span>
            <div class="text-xl font-black text-[#de7349] mt-1">{{ $conversionRate }}%</div>
        </div>
        <div class="crm-card p-4">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Completed Calls</span>
            <div class="text-xl font-black text-blue-700 mt-1">{{ $followupsCompleted }}</div>
        </div>
    </div>
</div>
@endsection
