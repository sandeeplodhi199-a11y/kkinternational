@extends('crm.layouts.master')

@section('title', 'My Profile')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Employee Profile</h2>
        <p class="text-xs text-slate-500 font-medium">Personal details, assigned role, quota & system credentials</p>
    </div>

    <!-- Header Profile Card -->
    <div class="crm-card p-6 md:p-8">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#1b4d3e] to-[#2d6a4f] flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-emerald-900/10">
                {{ substr($employee->name ?? $user->name ?? 'E', 0, 1) }}
            </div>
            <div class="flex-1 text-center sm:text-left space-y-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">{{ $employee->name ?? $user->name }}</h3>
                        <p class="text-sm font-semibold text-emerald-800">{{ $employee->designation ?? 'Sales Executive' }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/50 w-fit mx-auto sm:mx-0">
                        <span class="w-2 h-2 rounded-full bg-emerald-700 mr-1.5 animate-pulse"></span>
                        {{ ucfirst($employee->status ?? 'Active') }}
                    </span>
                </div>
                <div class="pt-2 flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        ID: <strong class="text-slate-700">{{ $employee->employee_code ?? 'EMP-' . str_pad($employee->id ?? 1, 3, '0', STR_PAD_LEFT) }}</strong>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Dept: <strong class="text-slate-700">{{ $employee->department->name ?? 'Direct Sales & Enterprise' }}</strong>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Joined: <strong class="text-slate-700">{{ $employee->created_at ? $employee->created_at->format('M d, Y') : 'Recent' }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="crm-card p-6 space-y-4">
            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contact Details
            </h4>
            <div class="space-y-3 text-xs">
                <div>
                    <label class="text-slate-400 font-semibold block">Official Work Email</label>
                    <span class="text-slate-700 font-medium">{{ $employee->email ?? $user->email }}</span>
                </div>
                <div>
                    <label class="text-slate-400 font-semibold block">Direct Phone / Mobile</label>
                    <span class="text-slate-700 font-medium">{{ $employee->phone ?? '+91 98765 43210' }}</span>
                </div>
                <div>
                    <label class="text-slate-400 font-semibold block">Panel Role</label>
                    <span class="text-emerald-800 font-bold bg-emerald-50 px-2 py-0.5 rounded text-[11px]">Sales Representative / Employee</span>
                </div>
            </div>
        </div>

        <div class="crm-card p-6 space-y-4">
            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Sales Target & Quota
            </h4>
            <div class="space-y-3 text-xs">
                <div>
                    <label class="text-slate-400 font-semibold block">Monthly Sales Quota</label>
                    <span class="text-slate-800 font-bold text-base">₹{{ number_format($employee->target_amount ?? 500000) }}</span>
                </div>
                <div>
                    <label class="text-slate-400 font-semibold block">Access Scope</label>
                    <span class="text-slate-600">Assigned Leads, Personal Follow-ups & Deals</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('crm.employee.performance') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-950 transition-colors">
                        View Detailed Performance
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
