@extends('crm.layouts.master')

@section('title', 'My Calendar')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Sales Calendar</h2>
        <p class="text-xs text-slate-500 font-medium">Personal schedule of scheduled client meetings, follow-ups and due tasks</p>
    </div>

    <div class="crm-card p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-4">{{ \Carbon\Carbon::now()->format('F Y') }} &bull; My Engagements</h3>
        <div class="space-y-3">
            @forelse($events as $ev)
                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl flex items-center justify-center text-white font-bold" style="background-color: {{ $ev['color'] }}">
                            <i class="fa-regular fa-clock text-xs"></i>
                        </span>
                        <div>
                            <div class="font-bold text-slate-800">{{ $ev['title'] }}</div>
                            <div class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($ev['date'])->format('d M, Y') }} at {{ $ev['time'] }}</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full text-white" style="background-color: {{ $ev['color'] }}">{{ $ev['type'] }}</span>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-6 text-center">No calendar items scheduled.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
