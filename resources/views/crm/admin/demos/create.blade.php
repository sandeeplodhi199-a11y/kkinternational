@extends('crm.layouts.master')

@section('title', 'Schedule Product Demo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.demos.index') }}" class="hover:text-cyan-600 transition">Demos & Presentations</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Schedule Demo</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-600 border border-cyan-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </span>
                <span>Schedule Product Demo</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Book live solution walkthroughs, assign product specialists, and prepare demonstration agendas.
            </p>
        </div>

        <a href="{{ route('crm.admin.demos.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Demos</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.demos.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Demo Information -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-display text-cyan-600 text-xs"></i>
                        <span>Presentation Title & Client Target</span>
                    </h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Demo Presentation Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Technical Architecture & Product Walkthrough" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Target Lead (Inbound)</label>
                            <select name="lead_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                <option value="">-- Select Inbound Lead --</option>
                                @foreach($leads as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company ?: 'Lead' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Existing Client / Account</label>
                            <select name="customer_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                <option value="">-- Select Existing Customer --</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company ?: 'Account' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Date, Time & Specialist -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-cyan-600 text-xs"></i>
                        <span>Presentation Schedule & Specialist</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Demo Date *</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Demo Time *</label>
                        <input type="time" name="time" value="14:00" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Assigned Specialist *</label>
                        <select name="assigned_to" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">Choose Staff...</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status & Notes -->
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Booking Status</label>
                        <select name="status" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="Scheduled" selected>Scheduled</option>
                            <option value="Pending">Pending Confirmation</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Presentation Agenda & Key Feature Focus</label>
                    <textarea name="notes" rows="3" placeholder="Modules to showcase, prospect business pain points, custom slides needed..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500"></textarea>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.demos.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-black shadow-md shadow-cyan-600/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Schedule Demo</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
