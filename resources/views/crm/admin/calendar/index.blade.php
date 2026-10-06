@extends('crm.layouts.master')

@section('title', 'Corporate Schedule & Calendar')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Sales Calendar & Events</h2>
            <p class="text-xs text-slate-500 font-medium">Unified calendar showing client demos, follow-up calls, tasks and VIP bookings</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full bg-amber-50 text-amber-800">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Follow-ups
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Tasks
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-800">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Demos
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full bg-purple-50 text-purple-800">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Bookings
            </span>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="crm-card p-6">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100 flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <h3 class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold">Today</span>
            </div>
            <div class="text-xs font-medium text-slate-400">
                Showing all events across team calendars
            </div>
        </div>

        <!-- Events List by Date -->
        <div class="space-y-3">
            @forelse($events as $ev)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-[#f8faf8] border border-slate-100 hover:border-slate-300 transition text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-white font-bold shrink-0" style="background-color: {{ $ev['color'] }}">
                            <i class="fa-regular fa-calendar-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $ev['title'] }}</div>
                            <div class="text-slate-400 font-medium text-[11px] mt-0.5">
                                {{ \Carbon\Carbon::parse($ev['date'])->format('l, d F Y') }} at {{ $ev['time'] }}
                            </div>
                        </div>
                    </div>

                    <span class="text-xs font-bold px-3 py-1 rounded-full text-white" style="background-color: {{ $ev['color'] }}">
                        {{ $ev['type'] }}
                    </span>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400">
                    <i class="fa-regular fa-calendar-xmark text-4xl mb-2 text-slate-300 block"></i>
                    No upcoming events scheduled on the calendar.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
