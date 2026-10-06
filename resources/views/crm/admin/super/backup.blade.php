@extends('crm.layouts.master')

@section('title', 'System Health & 1-Click Database Backup')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Database Backup & System Health</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Generate immediate JSON/SQL snapshot backups of CRM tables and inspect live diagnostic application logs.
            </p>
        </div>

        <a href="{{ route('crm.admin.super.backup.download') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-black shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center gap-2">
            <i class="fa-solid fa-download text-xs"></i>
            <span>1-Click Download DB Backup</span>
        </a>
    </div>

    <!-- DB Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="crm-card p-5 border border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block mb-1">Total CRM Records</span>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalRows) }}</div>
            <span class="text-[11px] font-bold text-emerald-600 mt-1 block">Live in MySQL Database</span>
        </div>
        <div class="crm-card p-5 border border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block mb-1">Tables Protected</span>
            <div class="text-2xl font-black text-blue-600">{{ count($tableStats) }} Tables</div>
            <span class="text-[11px] font-bold text-slate-500 mt-1 block">Full relational schema</span>
        </div>
        <div class="crm-card p-5 border border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block mb-1">Database Engine</span>
            <div class="text-2xl font-black text-purple-600">MySQL 8.0+</div>
            <span class="text-[11px] font-bold text-slate-500 mt-1 block">InnoDB UTF8MB4</span>
        </div>
        <div class="crm-card p-5 border border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block mb-1">Backup Format</span>
            <div class="text-2xl font-black text-emerald-700">JSON & SQL</div>
            <span class="text-[11px] font-bold text-slate-500 mt-1 block">Instant download payload</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Table Breakdown (~40% width) -->
        <div class="lg:col-span-5 crm-card p-6 border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-table-list text-slate-700 text-sm"></i>
                    <h3 class="text-sm font-black text-slate-900">Table Row Counts</h3>
                </div>
                <span class="text-[11px] font-bold text-slate-500">Live Status</span>
            </div>

            <div class="space-y-2 max-h-[460px] overflow-y-auto pr-1">
                @foreach($tableStats as $stat)
                    <div class="p-2.5 rounded-xl border border-slate-200 bg-slate-50/70 flex items-center justify-between text-xs font-bold">
                        <span class="font-mono text-slate-800">{{ $stat['table'] }}</span>
                        <span class="font-black text-slate-950 px-2 py-0.5 rounded-lg bg-white border border-slate-200">
                            {{ number_format($stat['rows']) }} rows
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- System Logs Viewer (~60% width) -->
        <div class="lg:col-span-7 crm-card p-6 border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-terminal text-orange-500 text-sm"></i>
                    <h3 class="text-sm font-black text-slate-900">Application Diagnostic Logs (Latest)</h3>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-slate-100 text-slate-700">
                    Live Stream
                </span>
            </div>

            <div class="bg-slate-950 text-slate-200 rounded-2xl p-4 font-mono text-[11px] max-h-[460px] overflow-y-auto space-y-2">
                @forelse($recentLogs as $logLine)
                    <div class="border-b border-slate-900/80 pb-1.5 break-all leading-snug">
                        @if(str_contains($logLine, '.ERROR'))
                            <span class="px-1.5 py-0.2 rounded bg-rose-600 text-white font-bold text-[9px] mr-1">ERROR</span>
                        @elseif(str_contains($logLine, '.WARNING'))
                            <span class="px-1.5 py-0.2 rounded bg-amber-600 text-white font-bold text-[9px] mr-1">WARN</span>
                        @else
                            <span class="px-1.5 py-0.2 rounded bg-slate-700 text-slate-300 font-bold text-[9px] mr-1">INFO</span>
                        @endif
                        <span class="text-slate-300">{{ $logLine }}</span>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500">
                        No error logs recorded. System is operating at peak health!
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
