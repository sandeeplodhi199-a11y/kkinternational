@extends('crm.layouts.master')

@section('title', 'My Tasks')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Assigned Tasks</h2>
        <p class="text-xs text-slate-500 font-medium">To-do items, customer follow-ups and deliverable milestones</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($tasks as $t)
            <div class="crm-card p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $t->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700' }}">
                            {{ $t->priority }} Priority
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $t->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $t->status }}
                        </span>
                    </div>

                    <h4 class="text-sm font-bold text-slate-800 leading-snug mb-1">{{ $t->title }}</h4>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">{{ $t->description ?: 'No additional notes.' }}</p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Due: <strong>{{ $t->due_date ? \Carbon\Carbon::parse($t->due_date)->format('d M') : 'None' }}</strong></span>
                    @if($t->status !== 'Completed')
                        <button onclick="updateTaskStatus({{ $t->id }}, 'Completed')" class="px-2.5 py-1 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                            Mark Done &check;
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 crm-card">
                No tasks currently pending.
            </div>
        @endforelse
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
