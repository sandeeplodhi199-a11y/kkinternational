@extends('crm.layouts.master')

@section('title', 'Tasks Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Task Management</h2>
            <p class="text-xs text-slate-500 font-medium">Assign, track, and complete sales follow-up assignments</p>
        </div>
        <a href="{{ route('crm.admin.tasks.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md shadow-emerald-900/10 flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add New Task</span>
        </a>
    </div>

    <!-- Filter Tabs (Prompt requirement: Today, Upcoming, Overdue, Completed) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="?status=all" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $status === 'all' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            All ({{ $counts['all'] }})
        </a>
        <a href="?status=today" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $status === 'today' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Today's Tasks ({{ $counts['today'] }})
        </a>
        <a href="?status=upcoming" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $status === 'upcoming' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Upcoming ({{ $counts['upcoming'] }})
        </a>
        <a href="?status=overdue" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $status === 'overdue' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Overdue ({{ $counts['overdue'] }})
        </a>
        <a href="?status=completed" class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $status === 'completed' ? 'bg-[#1b4d3e] text-white shadow-sm' : 'bg-white text-slate-600 border border-[#e7ece4]' }}">
            Completed ({{ $counts['completed'] }})
        </a>
    </div>

    <!-- Tasks Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($tasks as $t)
            <div class="crm-card p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $t->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : ($t->priority === 'High' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                            {{ $t->priority }} Priority
                        </span>
                        <select onchange="updateTaskStatus({{ $t->id }}, this.value)" class="text-[10px] font-bold py-1 px-2 rounded-full border border-slate-200 bg-slate-50 focus:outline-none">
                            <option value="Pending" {{ $t->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ $t->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ $t->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <h4 class="text-sm font-bold text-slate-800 leading-snug mb-1">
                        {{ $t->title }}
                    </h4>
                    <p class="text-xs text-slate-500 mb-3 line-clamp-2 leading-relaxed font-medium">
                        {{ $t->description ?: 'No detailed instructions provided.' }}
                    </p>

                    @if($t->lead || $t->customer)
                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 mb-3 text-[11px] text-slate-600">
                            <span class="text-slate-400 font-semibold">Related:</span> 
                            <span class="font-bold text-slate-800">{{ $t->lead ? $t->lead->name : $t->customer->name }}</span>
                        </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">
                        <i class="fa-regular fa-calendar text-[10px] mr-1"></i> Due {{ $t->due_date ? \Carbon\Carbon::parse($t->due_date)->format('d M') : 'None' }}
                    </span>
                    <span class="font-bold text-slate-700">
                        {{ $t->assignedEmployee ? explode(' ', $t->assignedEmployee->name)[0] : 'Unassigned' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 crm-card">
                <i class="fa-solid fa-list-check text-4xl mb-2 text-slate-300 block"></i>
                No tasks found in this view.
            </div>
        @endforelse
    </div>

    <!-- Modal: Add Task -->
    <div id="add-task-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add New Task</h3>
                <button type="button" onclick="document.getElementById('add-task-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Task Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Follow up on contract signature" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Due Date *</label>
                        <input type="date" name="due_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Priority</label>
                        <select name="priority" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assign Representative</label>
                        <select name="assigned_to" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Unassigned</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-task-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateTaskStatus(taskId, status) {
        fetch(`/crm/admin/tasks/${taskId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
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
