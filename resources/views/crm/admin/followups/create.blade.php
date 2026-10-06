@extends('crm.layouts.master')

@section('title', 'Schedule Client Follow-up')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.followups.index') }}" class="hover:text-emerald-700 transition">Follow-ups</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Schedule Follow-up</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-plus"></i>
                </span>
                <span>Schedule Client Follow-up</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Set up automated reminders, scheduled calls, client meetings, or product demos.
            </p>
        </div>

        <a href="{{ route('crm.admin.followups.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Follow-ups</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.followups.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Client / Lead Information Section -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-tag text-emerald-600 text-xs"></i>
                        <span>Client or Lead Target</span>
                    </h3>
                    <span class="text-[11px] font-bold text-slate-500">Select either Lead or Customer</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Related Lead</label>
                        <select name="lead_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">Select Lead...</option>
                            @foreach($leads as $l)
                                <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company ?: 'No Company' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Related Customer</label>
                        <select name="customer_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">Select Customer...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company ?: 'Account' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Schedule Timing & Details Section -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-clock text-emerald-600 text-xs"></i>
                        <span>Timing & Interaction Mode</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Date *</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Time</label>
                        <input type="time" name="time" value="11:30" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Type *</label>
                        <select name="type" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Call" selected>Call</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Email">Email</option>
                            <option value="Demo">Demo</option>
                            <option value="Visit">Site Visit</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Assignment & Status -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-check text-emerald-600 text-xs"></i>
                        <span>Representative & Current Status</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Assign Rep</label>
                        <select name="assigned_to" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">-- Choose Employee --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $emp->name === 'Admin' ? 'selected' : '' }}>{{ $emp->name }} ({{ $emp->role ?? 'Sales' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Status</label>
                        <select name="status" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Pending" selected>Pending</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Agenda & Meeting Notes -->
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Agenda / Meeting Note</label>
                <textarea name="notes" rows="4" placeholder="Detail discussion topics, proposal objectives, callback reminder..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.followups.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-[#1b4d3e] hover:bg-[#2d6a4f] text-white text-xs font-black shadow-md shadow-emerald-900/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Schedule</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
