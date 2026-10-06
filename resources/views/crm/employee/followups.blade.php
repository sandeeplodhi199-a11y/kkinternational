@extends('crm.layouts.master')

@section('title', 'My Follow-ups')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Scheduled Follow-ups</h2>
        <p class="text-xs text-slate-500 font-medium">Calls, product demos and negotiations scheduled on your calendar</p>
    </div>

    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Contact</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4">Discussion Objective</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($followups as $f)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $f->lead ? $f->lead->name : ($f->customer ? $f->customer->name : 'Client') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#fdf0e9] text-[#de7349]">{{ $f->type }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($f->date)->format('d M, Y') }} at {{ $f->time ? substr($f->time, 0, 5) : '10:00' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">{{ $f->notes ?: 'General catchup' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $f->status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $f->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($f->status !== 'Completed')
                                    <button onclick="markDone({{ $f->id }})" class="px-3 py-1 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[10px] transition">
                                        Mark Done &check;
                                    </button>
                                @else
                                    <span class="text-slate-400 text-[11px]">&check; Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">No follow-ups currently scheduled.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $followups->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function markDone(id) {
        fetch(`/crm/admin/followups/${id}/status`, {
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
