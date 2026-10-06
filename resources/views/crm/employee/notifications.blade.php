@extends('crm.layouts.master')

@section('title', 'My Notifications')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto pb-10">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-[#155242] flex items-center justify-center font-bold">
                <i class="fa-solid fa-bell text-base"></i>
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-900">My Notifications</h2>
                <p class="text-xs text-slate-500 font-medium">Real-time alerts for your assigned leads, tasks, and follow-ups</p>
            </div>
        </div>

        <a href="{{ route('crm.employee.dashboard') }}" class="px-3.5 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition">
            <i class="fa-solid fa-gauge text-xs"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <!-- Category Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('crm.employee.notifications', ['tab' => 'all']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? 'all') === 'all' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <span>All</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? 'all') === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['all'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.employee.notifications', ['tab' => 'lead']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'lead' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Leads</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'lead' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['lead'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.employee.notifications', ['tab' => 'followup']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'followup' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-calendar-check text-xs"></i>
            <span>Follow-ups</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'followup' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['followup'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.employee.notifications', ['tab' => 'task']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'task' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-list-check text-xs"></i>
            <span>Tasks</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'task' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['task'] ?? 0 }}</span>
        </a>
    </div>

    <!-- Notification Cards List -->
    <div class="space-y-3">
        @forelse($notifications as $n)
            <div class="p-4 sm:p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex items-start sm:items-center justify-between gap-4 transition hover:border-slate-300">
                <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shrink-0 {{ $n->icon_style }}">
                        <i class="{{ $n->icon }} text-base"></i>
                    </div>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $n->icon_style }}">
                                {{ $n->type_label }}
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400">
                                {{ $n->created_at ? $n->created_at->diffForHumans() : 'Recently' }}
                            </span>
                        </div>

                        <h4 class="text-sm font-black text-slate-900 mt-1 leading-snug">
                            {{ $n->title }}
                        </h4>

                        <p class="text-xs text-slate-600 mt-1 font-medium leading-relaxed break-words">
                            {{ $n->message }}
                        </p>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="shrink-0 self-center">
                    @php
                        $targetUrl = route('crm.employee.dashboard');
                        if (str_contains($n->type, 'lead')) {
                            $targetUrl = route('crm.employee.leads');
                        } elseif (str_contains($n->type, 'customer')) {
                            $targetUrl = route('crm.employee.customers');
                        } elseif (str_contains($n->type, 'followup')) {
                            $targetUrl = route('crm.employee.followups');
                        } elseif (str_contains($n->type, 'task')) {
                            $targetUrl = route('crm.employee.tasks');
                        } elseif (str_contains($n->type, 'deal')) {
                            $targetUrl = route('crm.employee.deals');
                        }
                    @endphp
                    <a href="{{ $targetUrl }}" class="text-xs font-bold px-3.5 py-2 rounded-2xl bg-slate-900 hover:bg-[#155242] text-white shadow-sm transition active:scale-95 flex items-center gap-1.5 cursor-pointer">
                        <span>View</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl font-bold">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <h3 class="text-base font-black text-slate-800">No notifications found</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    You have no new alerts in this view.
                </p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="pt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
