<div class="flex flex-col h-full bg-white select-none">
    <!-- Brand Logo (HisabMittra) -->
    <div class="px-5 py-4 border-b border-slate-100/80">
        <a href="{{ route('crm.admin.dashboard') }}" class="flex items-center group py-0.5">
            <img src="/images/hisab-mittra-logo.png" onerror="this.onerror=null; this.src='/crm/images/hisab-mittra-logo.png';" alt="HisabMittra" class="h-10 sm:h-11 w-auto max-w-[210px] object-contain transition-transform group-hover:scale-102">
        </a>
    </div>

    <!-- Navigation Menu (hr.ad Modern Aesthetic - Bold & High Legibility) -->
    <nav id="sidebar-nav" class="flex-1 overflow-y-auto sidebar-dark-scroll py-3 space-y-1">

        <!-- 1. SECTION: MAIN -->
        <div class="px-6 pt-2 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Main
        </div>

        <!-- Dashboard -->
        <a href="{{ route('crm.admin.dashboard') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.dashboard') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <!-- 2. SECTION: CRM & PIPELINE -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            CRM & Pipeline
        </div>

        <!-- All Leads -->
        <a href="{{ route('crm.admin.leads.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.leads.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-list-ul"></i>
            <span>All Leads</span>
        </a>

        <!-- Deals -->
        <a href="{{ route('crm.admin.deals.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.deals.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-handshake"></i>
            <span>Deals & Pipeline</span>
        </a>

        <!-- Customers -->
        <a href="{{ route('crm.admin.customers.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.customers.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-building"></i>
            <span>Customers</span>
        </a>

        <!-- Quotations -->
        <a href="{{ route('crm.admin.quotations.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.quotations.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>Quotations & Proposals</span>
        </a>

        <!-- 3. SECTION: OPERATIONS -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Operations
        </div>

        <!-- Follow-ups -->
        <a href="{{ route('crm.admin.followups.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.followups.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Follow-ups</span>
        </a>

        <!-- Tasks -->
        <a href="{{ route('crm.admin.tasks.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.tasks.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-list-check"></i>
            <span>Tasks</span>
        </a>

        <!-- Demos -->
        <a href="{{ route('crm.admin.demos.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.demos.index') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Demos</span>
        </a>

        <!-- Reservations -->
        <a href="{{ route('crm.admin.reservations.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.reservations.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-book-open"></i>
            <span>Reservations</span>
        </a>

        <!-- Bulk Assign -->
        <a href="{{ route('crm.admin.leads.bulk-assign') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.leads.bulk-assign*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-shuffle"></i>
            <span>Bulk Assign</span>
        </a>

        <!-- Upload Leads -->
        <a href="{{ route('crm.admin.leads.upload') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.leads.upload*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-file-arrow-up"></i>
            <span>Upload Leads</span>
        </a>

        <!-- 4. SECTION: FINANCE & PRODUCTS -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Finance & Products
        </div>

        <!-- Payments -->
        <a href="{{ route('crm.admin.payments.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.payments.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-credit-card"></i>
            <span>Payments & Collections</span>
        </a>

        <!-- Products -->
        <a href="{{ route('crm.admin.products.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.products.*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Products & Services</span>
        </a>

        <!-- Billing Calculator -->
        <a href="{{ route('crm.admin.tools.billing-calculator') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.tools.billing-calculator*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-calculator"></i>
            <span>Billing Calculator</span>
        </a>

        <!-- 5. SECTION: TEAM -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Team Management
        </div>

        <!-- Employees -->
        <a href="{{ route('crm.admin.team.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.team.index') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Employees</span>
        </a>

        <!-- Sales Targets -->
        <a href="{{ route('crm.admin.team.targets') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.team.targets*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-bullseye"></i>
            <span>Sales Targets</span>
        </a>

        <!-- Performance -->
        <a href="{{ route('crm.admin.team.performance') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.team.performance*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-trophy"></i>
            <span>Team Performance</span>
        </a>

        <!-- 6. SECTION: ANALYTICS & REPORTS -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Analytics & Logs
        </div>

        <!-- Master Reports -->
        <a href="{{ route('crm.admin.reports.index') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.reports.index') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Reports & Analytics</span>
        </a>

        <!-- Demo Assignments -->
        <a href="{{ route('crm.admin.demos.assignments') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.demos.assignments*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Demo Assignments</span>
        </a>

        <!-- Export Leads -->
        <a href="{{ route('crm.admin.leads.export') }}" 
           class="sidebar-dark-item hover:text-blue-600">
            <i class="fa-solid fa-file-excel"></i>
            <span>Export Leads (.xlsx)</span>
        </a>

        <!-- Activity Logs -->
        <a href="{{ route('crm.admin.system.activity-logs') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.system.activity-logs*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Activity Logs</span>
        </a>

        <!-- Live Tracking -->
        <a href="{{ route('crm.admin.system.live-tracking') }}" 
           class="sidebar-dark-item hover:text-blue-600 {{ Request::routeIs('crm.admin.system.live-tracking*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-tower-broadcast text-rose-500 animate-pulse"></i>
            <span>Live Tracking</span>
        </a>

        <!-- 7. SECTION: SUPER ADMIN GOVERNANCE -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            Super Admin
        </div>

        <!-- RBAC Matrix -->
        <a href="{{ route('crm.admin.super.rbac') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.super.rbac*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-shield-halved text-rose-500"></i>
            <span>RBAC Matrix</span>
        </a>


        <!-- Recycle Bin -->
        <a href="{{ route('crm.admin.super.recycle_bin') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.super.recycle_bin*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-trash-can text-rose-500"></i>
            <span>Recycle Bin</span>
        </a>

        <!-- Financial Approvals -->
        <a href="{{ route('crm.admin.super.approvals') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.super.approvals*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-stamp text-emerald-600"></i>
            <span>Financial Approvals</span>
        </a>


        <!-- 8. SECTION: SYSTEM -->
        <div class="px-6 pt-4 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500">
            System Settings
        </div>

        <!-- Settings -->
        <a href="{{ route('crm.admin.system.settings') }}" 
           class="sidebar-dark-item {{ Request::routeIs('crm.admin.system.settings*') ? 'sidebar-dark-item-active' : '' }}">
            <i class="fa-solid fa-gear"></i>
            <span>System Settings</span>
        </a>
    </nav>

    <!-- Bottom Sign Out -->
    <div class="p-4 border-t border-slate-100 bg-white">
        <form action="{{ route('crm.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl border border-rose-200/80 bg-rose-50/70 text-rose-600 text-xs font-black hover:bg-rose-100/80 hover:text-rose-700 transition duration-150 cursor-pointer">
                <i class="fa-solid fa-power-off text-xs text-rose-500"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</div>
