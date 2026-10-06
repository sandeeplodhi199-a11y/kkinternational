@extends('crm.layouts.master')

@section('title', 'Create Operational Task')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.tasks.index') }}" class="hover:text-amber-600 transition">Tasks</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">New Task</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-list-check"></i>
                </span>
                <span>Create Task & Assignment</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Delegate action items to staff, specify deadlines, and bind to relevant leads or customer records.
            </p>
        </div>

        <a href="{{ route('crm.admin.tasks.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Tasks</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.tasks.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Task Title & Target -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-amber-600 text-xs"></i>
                        <span>Task Definition & Linkage</span>
                    </h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Task Title / Action Item *</label>
                        <input type="text" name="title" required placeholder="e.g. Prepare revised product catalog and quote for ABC Corp" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Link to Lead (Optional)</label>
                            <select name="related_lead_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="">-- No Lead Associated --</option>
                                @foreach($leads as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company ?: 'Lead' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Link to Customer (Optional)</label>
                            <select name="related_customer_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="">-- No Customer Associated --</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company ?: 'Account' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Priority, Due Date & Assignee -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-clock text-amber-600 text-xs"></i>
                        <span>Scheduling & Responsibility</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Assignee *</label>
                        <select name="assigned_to" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">Unassigned</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $emp->name === 'Admin' ? 'selected' : '' }}>{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Due Date *</label>
                        <input type="date" name="due_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Priority *</label>
                        <select name="priority" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Detailed Task Description / Execution Checklist</label>
                <textarea name="description" rows="3" placeholder="Provide instructions, required attachments, or delivery milestones..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.tasks.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-black shadow-md shadow-amber-500/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Task</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
