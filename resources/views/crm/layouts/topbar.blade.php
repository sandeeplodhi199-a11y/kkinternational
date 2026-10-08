@php
    $currentUser = Auth::user();
    $currentEmp = $currentUser ? (\App\Models\Crm\CrmEmployee::where('user_id', $currentUser->id)->first() ?? 
                  \App\Models\Crm\CrmEmployee::where('email', $currentUser->email)->first()) : null;
    $unreadNotifications = \App\Models\Crm\CrmNotification::where('is_read', false)->count();

    $isAdminRole = Request::is('crm/admin*') || ($currentUser && $currentUser->type === 'crm_admin');
    $isEmployeeArea = Request::is('crm/employee*') || (!$isAdminRole && $currentEmp);
    $displayName = $isAdminRole ? 'Admin' : ($currentUser ? $currentUser->name : 'User');
    $displayEmail = $currentUser ? $currentUser->email : '';
    $notificationsUrl = $isEmployeeArea ? route('crm.employee.notifications') : route('crm.admin.system.notifications');
    $dashboardFallbackUrl = $isEmployeeArea ? route('crm.employee.dashboard') : route('crm.admin.dashboard');
@endphp

<header class="bg-transparent px-4 md:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-30">
    <!-- Left: Page Back Button, Website Link & Mobile Toggle -->
    <div class="flex items-center gap-3">
        <!-- Page Back Button (20% enlarged) -->
        <button type="button" 
                onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ $dashboardFallbackUrl }}'; }" 
                title="Go Back" 
                class="flex items-center gap-2 px-4.5 py-2.5 rounded-2xl bg-white border border-white/90 text-slate-700 hover:text-blue-600 hover:bg-slate-50 shadow-sm transition shrink-0 cursor-pointer active:scale-95 group">
            <i class="fa-solid fa-arrow-left text-sm transition-transform group-hover:-translate-x-0.5"></i>
            <span class="text-sm font-bold hidden sm:inline">Back</span>
        </button>

        <button type="button" onclick="toggleSidebar()" class="md:hidden text-slate-700 hover:text-blue-600 p-2.5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Center/Right: Search Input, Notification Bell, User Profile Pill -->
    <div class="flex items-center gap-3.5 ml-auto">
        <!-- Functional Inline Search Bar with Live Results Dropdown -->
        <div class="relative w-56 sm:w-72 md:w-96" id="topbar-search-container">
            <form action="{{ Request::is('crm/employee*') ? route('crm.employee.leads') : route('crm.admin.search') }}" method="GET" class="relative w-full" id="topbar-search-form">
                <div class="w-full bg-white border border-slate-200/90 focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/20 rounded-2xl px-4 py-2.5 flex items-center gap-2.5 shadow-sm transition">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm shrink-0"></i>
                    <input type="text" 
                           id="topbar-search-input" 
                           name="q" 
                           autocomplete="off" 
                           value="{{ request('q', request('search', '')) }}"
                           placeholder="Search leads, deals, customers..." 
                           class="w-full text-sm font-bold text-slate-900 placeholder-slate-400 bg-transparent outline-none">
                    
                    <!-- Clear Button -->
                    <button type="button" id="clear-search-btn" onclick="clearTopSearch()" class="hidden text-slate-400 hover:text-slate-700 text-xs px-1 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </form>

            <!-- Inline Live Search Dropdown Result Panel -->
            <div id="inline-search-dropdown" class="absolute right-0 top-full mt-2 w-80 sm:w-96 md:w-[440px] bg-white rounded-3xl shadow-2xl border border-slate-200 z-50 p-4 text-slate-900 hidden max-h-[460px] overflow-y-auto">
                <div id="inline-search-loading" class="hidden text-center py-6 text-xs text-slate-600 font-bold">
                    <i class="fa-solid fa-circle-notch fa-spin text-orange-500 text-base mb-1.5 block mx-auto"></i>
                    Searching CRM records...
                </div>
                <div id="inline-search-content" class="space-y-3 text-xs">
                    <div class="text-center py-4 text-slate-500 font-bold">Type to search leads, customers, deals, quotations...</div>
                </div>
            </div>
        </div>

        <!-- Notification Bell with Quick Badge & Dropdown Preview -->
        <div class="relative group">
            <a href="{{ $notificationsUrl }}" title="Notifications" class="relative w-11 h-11 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-700 hover:text-emerald-700 hover:border-emerald-300 transition cursor-pointer">
                <i class="fa-regular fa-bell text-lg"></i>
                @if($unreadNotifications > 0)
                    <span class="absolute -top-1 -right-1 min-w-[20px] h-[20px] px-1 rounded-full bg-rose-500 text-white font-black text-[11px] flex items-center justify-center shadow-sm">
                        {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                    </span>
                @endif
            </a>

            <!-- Quick Notification Dropdown Preview -->
            <div class="absolute right-0 mt-2 w-80 sm:w-96 bg-white border border-slate-100 rounded-3xl shadow-2xl py-3 hidden group-hover:block transition z-50">
                <div class="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-800">Notifications</h4>
                        <p class="text-[10px] text-slate-400">{{ $unreadNotifications }} unread alerts</p>
                    </div>
                    <a href="{{ $notificationsUrl }}" class="text-[11px] font-bold text-[#155242] hover:underline">
                        View All &rarr;
                    </a>
                </div>

                <div class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                    @forelse(\App\Models\Crm\CrmNotification::latest()->limit(5)->get() as $quickN)
                        @php
                            $quickTarget = $notificationsUrl;
                            if ($isEmployeeArea) {
                                if (str_contains($quickN->type, 'lead')) $quickTarget = route('crm.employee.leads');
                                elseif (str_contains($quickN->type, 'customer')) $quickTarget = route('crm.employee.customers');
                                elseif (str_contains($quickN->type, 'followup')) $quickTarget = route('crm.employee.followups');
                                elseif (str_contains($quickN->type, 'task')) $quickTarget = route('crm.employee.tasks');
                                elseif (str_contains($quickN->type, 'deal')) $quickTarget = route('crm.employee.deals');
                            } else {
                                $quickTarget = $quickN->link ?: $notificationsUrl;
                            }
                        @endphp
                        <a href="{{ $quickTarget }}" class="p-3 hover:bg-slate-50 flex items-start gap-2.5 transition block">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ $quickN->icon_style }}">
                                <i class="{{ $quickN->icon }} text-xs"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-1">
                                    <h5 class="text-xs font-bold text-slate-800 truncate">{{ $quickN->title }}</h5>
                                    <span class="text-[9px] text-slate-400 shrink-0">{{ $quickN->created_at ? $quickN->created_at->diffForHumans(null, true) : '' }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $quickN->message }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="py-6 text-center text-xs text-slate-400">
                            No notifications
                        </div>
                    @endforelse
                </div>

                <div class="px-4 pt-2 border-t border-slate-100 text-center">
                    <a href="{{ $notificationsUrl }}" class="text-xs font-bold text-slate-700 hover:text-[#155242] inline-block py-1">
                        Go to Notification Center &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Dropdown Pill (20% enlarged) -->
        <div class="relative group">
            <button class="flex items-center gap-2.5 p-1.5 pr-3.5 rounded-2xl bg-white border border-white/80 shadow-sm hover:border-slate-200 transition cursor-pointer">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold text-sm flex items-center justify-center shadow-inner">
                    {{ strtoupper(substr($displayName, 0, 1)) }}
                </div>
                <div class="hidden sm:block text-left pr-1">
                    <div class="text-sm font-bold text-slate-800 leading-tight">{{ $displayName }}</div>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-700 transition"></i>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-3xl shadow-xl py-2 hidden group-hover:block transition z-50">
                <div class="px-4 py-2 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-800">{{ $displayName }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ $displayEmail }}</p>
                </div>
                @if(Request::is('crm/admin*'))
                    <a href="{{ route('crm.admin.system.settings') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-sliders text-slate-400"></i> System Settings
                    </a>
                @else
                    <a href="{{ route('crm.employee.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-user text-slate-400"></i> My Profile
                    </a>
                @endif
                <form action="{{ route('crm.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket text-rose-400"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

