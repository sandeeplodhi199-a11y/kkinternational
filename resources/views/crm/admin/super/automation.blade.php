@extends('crm.layouts.master')

@section('title', 'Smart Lead Automation & Routing Rules')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Smart Automation & Lead Routing</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Configure Round-Robin lead allocation, response SLA escalation timers, and 1-click duplicate merger.
            </p>
        </div>
    </div>

    <!-- Main Grid: Rules Form & Duplicate Merger -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left: Automation Settings Form (~60% width) -->
        <div class="lg:col-span-7 crm-card p-6 border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center font-black text-sm">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Routing & Distribution Engine</h3>
                        <p class="text-xs font-bold text-slate-600">Global automated dispatch rules for newly captured leads</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('crm.admin.super.automation.save') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Rule 1: Auto-Assign Toggle -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-900">Auto-Assign Inbound Leads</h4>
                        <p class="text-[11px] font-bold text-slate-600 mt-0.5">Automatically assign new leads received via Webhook, Forms, or IndiaMART</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="auto_lead_assignment" value="1" {{ $autoAssign == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>

                <!-- Rule 2: Round Robin Distribution -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-900">Round-Robin Equal Distribution</h4>
                        <p class="text-[11px] font-bold text-slate-600 mt-0.5">Distribute leads sequentially among active sales representatives in equal batches</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="round_robin_active" value="1" {{ $roundRobin == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>

                <!-- Rule 3: SLA Escalation Timer -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">SLA Response Escalation Timer</h4>
                            <p class="text-[11px] font-bold text-slate-600 mt-0.5">If an assigned rep fails to log an activity/call within this window, alert Super Admin</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-xl bg-rose-100 text-rose-800 text-[10px] font-black border border-rose-200">
                            Breach Alert
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <div>
                            <label class="block text-[10px] font-black text-slate-700 mb-1">Max Untouched Hours</label>
                            <select name="sla_escalation_hours" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-black text-slate-900 bg-white">
                                <option value="1" {{ $slaHours == '1' ? 'selected' : '' }}>1 Hour (Urgent Hot Leads)</option>
                                <option value="2" {{ $slaHours == '2' ? 'selected' : '' }}>2 Hours</option>
                                <option value="4" {{ $slaHours == '4' ? 'selected' : '' }}>4 Hours (Standard)</option>
                                <option value="12" {{ $slaHours == '12' ? 'selected' : '' }}>12 Hours</option>
                                <option value="24" {{ $slaHours == '24' ? 'selected' : '' }}>24 Hours (1 Business Day)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-700 mb-1">Escalation Notification Email</label>
                            <input type="email" name="escalation_email" value="{{ \App\Models\Crm\CrmSetting::get('escalation_email', 'admin@kkinternational.com') }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white">
                        </div>
                    </div>
                </div>

                <!-- Rule 4: Duplicate Lead Action -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-2">
                    <h4 class="text-xs font-black text-slate-900">Inbound Duplicate Handling Policy</h4>
                    <p class="text-[11px] font-bold text-slate-600">Action when a new inquiry arrives with an already registered phone number</p>
                    <div class="grid grid-cols-2 gap-2 pt-1 text-xs font-bold text-slate-800">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                            <input type="radio" name="duplicate_lead_action" value="merge" {{ $duplicateAction === 'merge' ? 'checked' : '' }} class="text-orange-600">
                            <span>Auto-Merge to Existing</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                            <input type="radio" name="duplicate_lead_action" value="create_sub" {{ $duplicateAction === 'create_sub' ? 'checked' : '' }} class="text-orange-600">
                            <span>Create as Sub-Inquiry</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black shadow-md transition cursor-pointer">
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Automation Parameters
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Duplicate Lead Merger Tool (~40% width) -->
        <div class="lg:col-span-5 crm-card p-6 border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-code-merge text-blue-600 text-sm"></i>
                    <h3 class="text-sm font-black text-slate-900">Duplicate Lead Cleaner</h3>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-blue-800 border border-blue-200">
                    Live Analyzer
                </span>
            </div>

            <p class="text-xs text-slate-600 font-bold leading-relaxed">
                Leads sharing the exact same contact phone number across separate inquiries. Click Merge to consolidate remarks, notes, and activity logs into a single master profile.
            </p>

            <div class="space-y-3">
                @forelse($duplicatePhones as $dup)
                    <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                        <div>
                            <div class="font-mono font-black text-xs text-slate-900">{{ $dup->phone }}</div>
                            <span class="text-[11px] font-bold text-rose-600">{{ $dup->total }} Duplicate Inquiries</span>
                        </div>
                        <form action="{{ route('crm.admin.super.automation.merge') }}" method="POST">
                            @csrf
                            <input type="hidden" name="phone" value="{{ $dup->phone }}">
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shadow-sm transition cursor-pointer flex items-center gap-1.5">
                                <i class="fa-solid fa-code-merge text-xs"></i> Merge
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-6 rounded-2xl bg-emerald-50/60 border border-emerald-200 text-center text-xs font-bold text-emerald-800">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg mb-1 block"></i>
                        No duplicate lead conflicts detected! Database is clean.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
