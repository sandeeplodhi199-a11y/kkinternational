@extends('crm.layouts.master')

@section('title', 'Employee Performance Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Employee Performance KPI Center</h2>
            <p class="text-xs text-slate-500 font-medium">Individual conversion rates, deals won, sales target achievement, and task efficiency</p>
        </div>
        <a href="{{ route('crm.admin.team.targets') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-bullseye text-[10px]"></i>
            <span>Manage Quota Targets</span>
        </a>
    </div>

    <!-- Performance Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($metrics as $m)
            <div class="crm-card p-6 flex flex-col justify-between">
                <div>
                    <!-- Header with avatar & name -->
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-800 text-white font-black text-base flex items-center justify-center shrink-0 shadow-md">
                            {{ strtoupper(substr($m['emp']->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">{{ $m['emp']->name }}</h3>
                            <p class="text-xs text-slate-400 font-medium">{{ $m['emp']->designation }}</p>
                        </div>
                        <span class="ml-auto text-xs font-black px-2.5 py-1 rounded-full {{ $m['achievedPercent'] >= 80 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $m['achievedPercent'] }}%
                        </span>
                    </div>

                    <!-- Quota Progress Bar -->
                    <div class="mb-5">
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span>Quota Progress</span>
                            <span class="text-[#1b4d3e]">₹{{ number_format($m['revenue']) }} / ₹{{ number_format($m['target']) }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-[#1b4d3e] to-[#2d6a4f] h-2.5 rounded-full" style="width: {{ $m['achievedPercent'] }}%"></div>
                        </div>
                    </div>

                    <!-- KPI Grid -->
                    <div class="grid grid-cols-2 gap-3 text-xs mb-4">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Leads Assigned</span>
                            <span class="text-base font-black text-slate-800">{{ $m['assignedLeads'] }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Leads Won</span>
                            <span class="text-base font-black text-emerald-800">{{ $m['convertedLeads'] }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Conversion Rate</span>
                            <span class="text-base font-black text-[#de7349]">{{ $m['conversionRate'] }}%</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Deals Won</span>
                            <span class="text-base font-black text-blue-700">{{ $m['dealsWon'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Summary -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Tasks Done: <strong class="text-slate-800">{{ $m['completedTasks'] }}</strong></span>
                    <span>Calls Made: <strong class="text-slate-800">{{ $m['completedFollowups'] }}</strong></span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
