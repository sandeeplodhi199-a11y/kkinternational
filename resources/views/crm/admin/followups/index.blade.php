@extends('crm.layouts.master')

@section('title', 'Follow-up Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Follow-up Management</h2>
            <p class="text-xs text-slate-500 font-medium">Timely reminders, scheduled client calls, meetings and demos</p>
        </div>
        <a href="{{ route('crm.admin.followups.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Log Follow-up</span>
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="?tab=today" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $tab === 'today' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Today's Follow-ups ({{ $counts['today'] }})
        </a>
        <a href="?tab=upcoming" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $tab === 'upcoming' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Upcoming ({{ $counts['upcoming'] }})
        </a>
        <a href="?tab=overdue" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $tab === 'overdue' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Overdue ({{ $counts['overdue'] }})
        </a>
        <a href="?tab=completed" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $tab === 'completed' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Completed ({{ $counts['completed'] }})
        </a>
    </div>

    <!-- Followups List -->
    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Contact / Lead</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4">Agenda / Discussion</th>
                        <th class="py-3 px-4">Assigned Rep</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($followups as $f)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">
                                    {{ $f->lead ? $f->lead->name : ($f->customer ? $f->customer->name : 'Commercial Contact') }}
                                </div>
                                <div class="text-[11px] text-slate-400">
                                    {{ $f->lead ? $f->lead->company : ($f->customer ? $f->customer->company : '') }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#fdf0e9] text-[#de7349]">
                                    {{ $f->type }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($f->date)->format('d M, Y') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $f->time ? substr($f->time, 0, 5) : '10:00 AM' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">{{ $f->notes ?: 'Follow up discussion' }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                {{ $f->assignedEmployee ? $f->assignedEmployee->name : 'Unassigned' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $f->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : ($f->status === 'Overdue' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $f->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($f->status !== 'Completed')
                                    <button onclick="markFollowupDone({{ $f->id }})" class="px-3 py-1 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold transition">
                                        Mark Done &check;
                                    </button>
                                @else
                                    <span class="text-slate-400 text-[11px]">&check; Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400">No follow-ups recorded in this category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $followups->links() }}
        </div>
    </div>

    <!-- Modal: Add Followup -->
    <div id="add-fu-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Schedule Client Follow-up</h3>
                <button type="button" onclick="document.getElementById('add-fu-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.followups.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Related Lead</label>
                        <select name="lead_id" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Select Lead...</option>
                            @foreach($leads as $l)
                                <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Related Customer</label>
                        <select name="customer_id" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Select Customer...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Date *</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Time</label>
                        <input type="time" name="time" value="11:30" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Type *</label>
                        <select name="type" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Call">Call</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Email">Email</option>
                            <option value="Demo">Demo</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assign Rep</label>
                        <select name="assigned_to" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Agenda / Meeting Note</label>
                    <textarea name="notes" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-fu-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function markFollowupDone(fuId) {
        fetch(`/crm/admin/followups/${fuId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: 'Completed' })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
</script>
@endpush
