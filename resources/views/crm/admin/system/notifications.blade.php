@extends('crm.layouts.master')

@section('title', 'Notification Center')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto pb-10">
    <!-- Header with Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-[#155242] flex items-center justify-center font-bold">
                    <i class="fa-solid fa-bell text-base"></i>
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900">Notification Center</h2>
                    <p class="text-xs text-slate-500 font-medium">Real-time alerts for lead assignments, due follow-ups, and received payments</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 flex-wrap">
            <form action="{{ route('crm.admin.system.notifications.sync') }}" method="POST">
                @csrf
                <button type="submit" 
                        title="Sync with latest CRM leads, follow-ups, and payments" 
                        class="px-3.5 py-2 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs flex items-center gap-2 shadow-sm transition active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-arrows-rotate text-emerald-600 text-xs"></i>
                    <span>Sync Events</span>
                </button>
            </form>

            @if(($counts['unread'] ?? 0) > 0)
                <form action="{{ route('crm.admin.system.notifications.mark-read') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="px-3.5 py-2 rounded-2xl bg-emerald-600 hover:bg-[#155242] text-white font-bold text-xs flex items-center gap-2 shadow-sm transition active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-check-double text-xs"></i>
                        <span>Mark All Read</span>
                    </button>
                </form>
            @endif

            @if(($counts['all'] ?? 0) > 0)
                <form action="{{ route('crm.admin.system.notifications.clear-all') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all notification history?');">
                    @csrf
                    <button type="submit" 
                            class="px-3 py-2 rounded-2xl bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs flex items-center gap-1.5 shadow-sm transition active:scale-95 cursor-pointer">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                        <span>Clear All</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'all']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? 'all') === 'all' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <span>All</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? 'all') === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['all'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'unread']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'unread' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <span>Unread</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'unread' ? 'bg-rose-500 text-white' : 'bg-rose-100 text-rose-700' }}">{{ $counts['unread'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'lead']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'lead' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Leads</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'lead' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['lead'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'followup']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'followup' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-calendar-check text-xs"></i>
            <span>Follow-ups</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'followup' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['followup'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'task']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'task' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-list-check text-xs"></i>
            <span>Tasks & Demos</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'task' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['task'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'payment']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'payment' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-indian-rupee-sign text-xs"></i>
            <span>Payments & Deals</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'payment' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['payment'] ?? 0 }}</span>
        </a>

        <a href="{{ route('crm.admin.system.notifications', ['tab' => 'system']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ ($tab ?? '') === 'system' ? 'bg-[#155242] text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            <i class="fa-solid fa-shield-halved text-xs"></i>
            <span>System</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($tab ?? '') === 'system' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['system'] ?? 0 }}</span>
        </a>
    </div>

    <!-- Notification Cards List -->
    <div class="space-y-3">
        @forelse($notifications as $n)
            <div class="p-4 sm:p-5 rounded-3xl bg-white border {{ !$n->is_read ? 'border-emerald-300 bg-emerald-50/20 shadow-md ring-1 ring-emerald-500/10' : 'border-slate-200/80 shadow-sm' }} flex items-start sm:items-center justify-between gap-4 transition hover:border-slate-300">
                <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                    <!-- Icon Avatar -->
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shrink-0 {{ $n->icon_style }}">
                        <i class="{{ $n->icon }} text-base"></i>
                    </div>

                    <!-- Notification Body -->
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $n->icon_style }}">
                                {{ $n->type_label }}
                            </span>
                            @if(!$n->is_read)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-rose-500 text-white uppercase tracking-wider animate-pulse">
                                    NEW
                                </span>
                            @endif
                            <span class="text-[11px] font-semibold text-slate-400">
                                {{ $n->created_at ? $n->created_at->diffForHumans() : 'Just now' }}
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

                <!-- Right Action Links -->
                <div class="flex items-center gap-2 shrink-0 self-center">
                    @if($n->link)
                        <a href="{{ $n->link }}" class="text-xs font-bold px-3.5 py-2 rounded-2xl bg-slate-900 hover:bg-[#155242] text-white shadow-sm transition active:scale-95 flex items-center gap-1.5 cursor-pointer">
                            <span>View</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif

                    <form action="{{ route('crm.admin.system.notifications.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Remove this notification?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                title="Dismiss notification" 
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl font-bold">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <h3 class="text-base font-black text-slate-800">No notifications in this view</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    There are no current alerts matching this filter. Click below to synchronize all recent CRM leads, follow-ups, and demo bookings.
                </p>
                <div class="mt-4">
                    <form action="{{ route('crm.admin.system.notifications.sync') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 rounded-2xl bg-[#155242] text-white font-bold text-xs shadow-sm hover:bg-emerald-800 transition active:scale-95 cursor-pointer inline-flex items-center gap-2">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span>Sync Real-Time Alerts</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="pt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
