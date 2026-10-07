<div class="flex flex-col h-full bg-white select-none">
    <!-- Brand Logo (HisabMittra) -->
    <div class="px-5 py-4 border-b border-slate-100/80">
        <a href="{{ route('crm.employee.dashboard') }}" class="flex items-center group py-0.5">
            <img src="/images/hisab-mittra-logo.png" onerror="this.onerror=null; this.src='/crm/images/hisab-mittra-logo.png';" alt="HisabMittra" class="h-10 sm:h-11 w-auto max-w-[210px] object-contain transition-transform group-hover:scale-102">
        </a>
    </div>

    <!-- Navigation Menu (hr.ad Modern Aesthetic - Bold & High Legibility) -->
    <nav id="sidebar-nav" class="flex-1 overflow-y-auto sidebar-dark-scroll py-3 space-y-1">
        <!-- 1. SECTION: MAIN -->
        <div class="px-6 pt-2 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Main
        </div>

        <a href="{{ route('crm.employee.dashboard') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.dashboard') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>My Dashboard</span>
        </a>

        @php
            $canLeads = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.view');
            $canCustomers = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('customers.view');
            $canDeals = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('deals.view');
            $canTasks = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('tasks.manage');
            $canFollowups = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('followups.manage');
            $canPerformance = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('team.view');
        @endphp

        @if($canLeads || $canCustomers || $canDeals || $canTasks || $canFollowups)
        <!-- 2. SECTION: WORKSPACE -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Workspace
        </div>
        @endif

        @if($canLeads)
        <a href="{{ route('crm.employee.leads') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.leads*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-user-tag"></i>
            <span>My Leads</span>
        </a>
        @endif

        @if($canCustomers)
        <a href="{{ route('crm.employee.customers') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.customers*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>My Customers</span>
        </a>
        @endif

        @if($canDeals)
        <a href="{{ route('crm.employee.deals') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.deals*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-handshake"></i>
            <span>My Deals</span>
        </a>
        @endif

        @if($canTasks)
        <a href="{{ route('crm.employee.tasks') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.tasks*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-list-check"></i>
            <span>My Tasks</span>
        </a>
        @endif

        @if($canFollowups)
        <a href="{{ route('crm.employee.followups') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.followups*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>My Follow-ups</span>
        </a>
        @endif

        <a href="{{ route('crm.employee.calendar') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.calendar*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-calendar-days"></i>
            <span>My Calendar</span>
        </a>

        @if($canPerformance)
        <a href="{{ route('crm.employee.performance') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.performance*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>My Performance</span>
        </a>
        @endif

        <a href="{{ route('crm.employee.profile') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.employee.profile*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-id-card"></i>
            <span>My Profile</span>
        </a>
    </nav>

    <!-- Bottom Widget & Logout -->
    <div class="p-4 border-t border-slate-100 bg-white space-y-3">
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-slate-700 shadow-xs">
            <span class="text-[10px] uppercase font-black tracking-wider text-blue-600">Quota Target</span>
            <div class="text-xs font-black text-slate-800 mt-0.5">₹4.2L / ₹5.0L</div>
            <div class="w-full bg-slate-200 rounded-full h-1.5 mt-1.5 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-1.5 rounded-full" style="width: 84%"></div>
            </div>
            <p class="text-[9px] mt-1 text-slate-500 font-semibold">84% achieved this month</p>
        </div>

        <form action="{{ route('crm.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl border border-rose-200/80 bg-rose-50/70 text-rose-600 text-xs font-black hover:bg-rose-100/80 hover:text-rose-700 transition duration-150 cursor-pointer">
                <i class="fa-solid fa-power-off text-xs text-rose-500"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</div>
