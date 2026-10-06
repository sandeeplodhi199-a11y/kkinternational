@extends('crm.layouts.master')

@section('title', 'Lead Profile - ' . $lead->name)

@section('content')
<div class="space-y-6">
    <!-- Header Breadcrumb & Actions -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.leads.index') }}" class="w-9 h-9 rounded-full bg-white border border-[#e7ece4] flex items-center justify-center text-slate-600 hover:text-slate-900 shadow-sm transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">{{ $lead->name }}</h2>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800">
                        {{ $lead->status }}
                    </span>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-bold {{ $lead->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700' }}">
                        {{ $lead->priority }} Priority
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium">{{ $lead->lead_code }} &bull; {{ $lead->company ?: 'Individual' }} &bull; Added {{ $lead->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Quick Reassign Form -->
            <form action="{{ route('crm.admin.leads.assign', $lead->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <select name="assigned_to" onchange="this.form.submit()" class="text-xs font-semibold py-2 px-3 rounded-full bg-white border border-[#e7ece4] focus:outline-none shadow-sm text-slate-700">
                    <option value="">Assign To...</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $lead->assigned_to == $emp->id ? 'selected' : '' }}>
                            Assigned: {{ $emp->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('crm.admin.quotations.create') }}?lead_id={{ $lead->id }}&name={{ urlencode($lead->name) }}" class="px-4 py-2 rounded-full bg-[#de7349] text-white text-xs font-bold hover:bg-[#cb6336] transition shadow-sm">
                + Create Quotation
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Prospect Profile Card -->
        <div class="space-y-6">
            <div class="crm-card p-6">
                <div class="text-center pb-5 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-[#1b4d3e] to-[#2d6a4f] text-white font-black text-2xl flex items-center justify-center mx-auto mb-3 shadow-md shadow-emerald-900/10">
                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">{{ $lead->name }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ $lead->company ?: 'Independent Lead' }}</p>
                    <div class="mt-3 text-lg font-black text-[#1b4d3e]">
                        ₹{{ number_format($lead->expected_value) }} <span class="text-xs font-normal text-slate-400">Deal Value</span>
                    </div>
                </div>

                <div class="py-4 space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium flex items-center gap-2"><i class="fa-regular fa-envelope"></i> Email</span>
                        <span class="font-bold text-slate-800">{{ $lead->email ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium flex items-center gap-2"><i class="fa-solid fa-phone"></i> Phone</span>
                        <span class="font-bold text-slate-800">{{ $lead->phone ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium flex items-center gap-2"><i class="fa-solid fa-user-tie"></i> Assigned Rep</span>
                        <span class="font-bold text-slate-800">{{ $lead->assignedEmployee ? $lead->assignedEmployee->name : 'Unassigned' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left"></i> Next Follow-up</span>
                        <span class="font-bold text-slate-800">{{ $lead->follow_up_date ? \Carbon\Carbon::parse($lead->follow_up_date)->format('d M, Y') : 'None scheduled' }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold text-slate-700 mb-1">Prospect Notes</h4>
                    <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-2xl border border-slate-100 italic leading-relaxed">
                        {{ $lead->notes ?: 'No initial discovery notes attached.' }}
                    </p>
                </div>
            </div>

            <!-- Quick Schedule Followup Card -->
            <div class="crm-card p-5">
                <h4 class="text-xs font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="fa-regular fa-calendar-plus text-[#de7349]"></i>
                    <span>Log New Follow-up</span>
                </h4>
                <form action="{{ route('crm.admin.followups.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    <input type="hidden" name="assigned_to" value="{{ $lead->assigned_to }}">
                    <input type="hidden" name="status" value="Pending">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">Time</label>
                            <input type="time" name="time" value="11:00" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Type</label>
                        <select name="type" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Call">Phone Call</option>
                            <option value="Meeting">Zoom Meeting</option>
                            <option value="Email">Email Communication</option>
                            <option value="Demo">Product Demo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Discussion Agenda</label>
                        <textarea name="notes" rows="2" placeholder="Topics to cover..." class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2 rounded-xl bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition">
                        Schedule Follow-up
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Activities Timeline & Tabs (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Scheduled Follow-ups -->
            <div class="crm-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800">Scheduled Follow-ups</h3>
                    <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold">{{ count($lead->followups) }} total</span>
                </div>
                <div class="space-y-3">
                    @forelse($lead->followups as $fu)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-white text-emerald-800 flex items-center justify-center font-bold shadow-sm">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $fu->type }}: {{ $fu->notes ?: 'General discussion' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($fu->date)->format('d M, Y') }} at {{ $fu->time }}</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $fu->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $fu->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No follow-ups recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="crm-card p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Activity Timeline & Audit Trail</h3>
                <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200">
                    @forelse($lead->activities as $act)
                        <div class="flex items-start gap-3 relative">
                            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] shrink-0 z-10 shadow-sm">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div class="flex-1 bg-white p-3.5 rounded-2xl border border-slate-100 text-xs">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $act->type) }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $act->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-600">{{ $act->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-start gap-3 relative">
                            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] shrink-0 z-10">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div class="flex-1 bg-white p-3.5 rounded-2xl border border-slate-100 text-xs">
                                <span class="font-bold text-slate-800">Lead Created</span>
                                <p class="text-slate-500">Record initialized on {{ $lead->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
