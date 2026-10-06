@extends('crm.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">

    <!-- TOP HEADER / GREETING AREA -->
    @php
        $currentHour = (int) \Carbon\Carbon::now(config('app.crm_timezone', 'Asia/Kolkata'))->format('H');
        if ($currentHour >= 5 && $currentHour < 12) {
            $timeGreeting = 'Good Morning,';
            $timeIcon = '👋';
        } elseif ($currentHour >= 12 && $currentHour < 17) {
            $timeGreeting = 'Good Afternoon,';
            $timeIcon = '☀️';
        } elseif ($currentHour >= 17 && $currentHour < 21) {
            $timeGreeting = 'Good Evening,';
            $timeIcon = '🌆';
        } else {
            $timeGreeting = 'Good Night,';
            $timeIcon = '🌙';
        }

        $currentUser = Auth::user();
        $isAdmin = Request::is('crm/admin*') || ($currentUser && $currentUser->type === 'crm_admin');
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100) : 0;
        $collectionRate = ($totalRevenue + $pendingPayments) > 0 ? round(($totalRevenue / ($totalRevenue + $pendingPayments)) * 100) : 71;
    @endphp

    <div class="p-5 sm:p-6 rounded-2xl bg-slate-200 border border-slate-300 shadow-sm">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Hello {{ $isAdmin ? 'Admin' : $currentUser->name }}!
        </h1>
        <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
            Measure How Fast You're Growing Monthly Recurring performance management.
        </p>
    </div>

    <!-- OVERVIEW TITLE -->
    <div class="flex items-center justify-between pt-1">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Overview</h2>
    </div>

    <!-- 1. TOP 7 KPI CARDS (hr.ad Circular Ring Indicator with Bold High-Contrast Text) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-7 gap-4">
        <!-- Card 1: Total Leads (Orange Arc) -->
        <a href="{{ route('crm.admin.leads.index') }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-orange-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-orange-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-orange-500" stroke-width="3.5" stroke-dasharray="78, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↗</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none group-hover:text-orange-600 transition-colors">{{ $totalLeads }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Total Leads</div>
            </div>
        </a>

        <!-- Card 2: Converted Leads (Sky Blue Arc) -->
        <a href="{{ route('crm.admin.leads.index', ['status' => 'Converted']) }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-sky-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-sky-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-sky-500" stroke-width="3.5" stroke-dasharray="65, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↙</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none group-hover:text-sky-600 transition-colors">{{ $convertedLeads }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Converted Leads</div>
            </div>
        </a>

        <!-- Card 3: In Progress (Amber Arc) -->
        <a href="{{ route('crm.admin.leads.index', ['status' => 'In Progress']) }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-amber-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-amber-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-amber-500" stroke-width="3.5" stroke-dasharray="82, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↗</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none group-hover:text-amber-600 transition-colors">{{ $inProgressLeads }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">In Progress</div>
            </div>
        </a>

        <!-- Card 4: Unassigned (Rose Arc) -->
        <a href="{{ route('crm.admin.leads.bulk-assign') }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-rose-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-rose-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-rose-500" stroke-width="3.5" stroke-dasharray="50, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↙</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none group-hover:text-rose-600 transition-colors">{{ $unassignedLeads }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Unassigned</div>
            </div>
        </a>

        <!-- Card 5: Active Employees (Purple Arc) -->
        <a href="{{ route('crm.admin.team.index') }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-purple-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-purple-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-purple-500" stroke-width="3.5" stroke-dasharray="70, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↗</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none group-hover:text-purple-600 transition-colors">{{ $activeEmployees }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Active Team</div>
            </div>
        </a>

        <!-- Card 6: Revenue Received (Emerald Arc) -->
        <a href="{{ route('crm.admin.payments.index') }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-emerald-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-emerald-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-emerald-500" stroke-width="3.5" stroke-dasharray="88, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↗</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-none group-hover:text-emerald-600 transition-colors">₹{{ number_format($totalRevenue) }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Revenue Received</div>
            </div>
        </a>

        <!-- Card 7: Payment Pending (Orange/Amber Arc) -->
        <a href="{{ route('crm.admin.payments.index') }}" class="crm-card p-4 sm:p-5 flex items-center gap-3.5 hover:shadow-lg hover:border-amber-300 transition duration-150 group cursor-pointer block">
            <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-amber-100" stroke-width="3.5" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-amber-500" stroke-width="3.5" stroke-dasharray="60, 100" stroke-linecap="round" stroke="currentColor" fill="none"
                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-black text-slate-900 group-hover:scale-110 transition-transform">↙</span>
                </div>
            </div>
            <div class="min-w-0">
                <div class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-none group-hover:text-amber-600 transition-colors">₹{{ number_format($pendingPayments) }}</div>
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 mt-1.5">Payment Pending</div>
            </div>
        </a>
    </div>

    <!-- 2. MIDDLE SECTION: DUAL-TONE SPLINE CHART & RADIAL SATISFACTION GAUGE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        
        <!-- Large Spline Chart (~65% width) -->
        <div class="lg:col-span-8 crm-card p-5 sm:p-6 flex flex-col justify-between relative overflow-visible">
            <div class="flex items-center justify-between flex-wrap gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-black text-slate-900">Salary & Revenue Statistics</h3>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-600 font-bold"></i>
                </div>

                <!-- Floating Legend / Filter Badge (Exact Reference Style - Bold Texts) -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-3 px-3.5 py-1.5 rounded-2xl bg-slate-100/80 border border-slate-200 text-[11px] font-bold text-slate-700">
                        <span class="font-black text-slate-950" id="chartYearBadge">{{ $periodLabel ?? date('Y') }}</span>
                        <span>Marketing: <strong class="text-slate-950 font-black" id="chartMarketingVal">₹{{ number_format($totalRevenue * 0.4) }}</strong></span>
                        <span>Closed: <strong class="text-orange-600 font-black" id="chartClosedVal">₹{{ number_format($totalRevenue * 0.6) }}</strong></span>
                    </div>

                    <!-- Interactive Sort by Dropdown (Day, Month, Year, Date) -->
                    <div class="relative" id="revenueSortDropdownContainer">
                        <button type="button" 
                                id="revenueSortBtn" 
                                onclick="toggleSortMenu('revenueSortMenu', 'revenueSortChevron', event)" 
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-xs font-black text-slate-900 shadow-xs cursor-pointer transition select-none focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                            <span>Sort by</span>
                            <span id="revenueSortLabelText" class="text-slate-700 font-bold">{{ $sortLabel ?? 'Months' }}</span>
                            <i id="revenueSortChevron" class="fa-solid fa-chevron-down text-[9px] text-slate-700 transition-transform duration-200"></i>
                        </button>

                        <!-- Dropdown Modal Popup -->
                        <div id="revenueSortMenu" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200 z-50 p-4 text-slate-900 transition-all duration-150">
                            <!-- Header with close button -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider">
                                    <i class="fa-solid fa-arrow-down-wide-short text-orange-500"></i>
                                    <span>Sort by Timeframe</span>
                                </div>
                                <button type="button" onclick="closeSortMenu('revenueSortMenu', 'revenueSortChevron')" class="w-6 h-6 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-900 flex items-center justify-center text-xs font-bold transition">
                                    &times;
                                </button>
                            </div>

                            <!-- 4 Category Tabs: DAY, MONTH, YEAR, DATE -->
                            <div class="grid grid-cols-4 gap-1 p-1 bg-slate-100 rounded-2xl my-3 text-[11px] font-black">
                                <button type="button" onclick="switchSortTab('rev', 'day')" id="revTabBtn_day" class="rev-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'day' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Day
                                </button>
                                <button type="button" onclick="switchSortTab('rev', 'month')" id="revTabBtn_month" class="rev-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'month' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Month
                                </button>
                                <button type="button" onclick="switchSortTab('rev', 'year')" id="revTabBtn_year" class="rev-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'year' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Year
                                </button>
                                <button type="button" onclick="switchSortTab('rev', 'date')" id="revTabBtn_date" class="rev-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'date' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Date
                                </button>
                            </div>

                            <!-- TAB CONTENT 1: DAY (दिन) -->
                            <div id="revTabContent_day" class="rev-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'day' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Day-wise Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('day', 'today', 'Day (Today)')" class="p-2.5 rounded-2xl border {{ $period === 'today' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Today</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('d M Y') }}</div>
                                        </div>
                                        <i class="fa-regular fa-sun text-amber-500 text-sm"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'yesterday', 'Day (Yesterday)')" class="p-2.5 rounded-2xl border {{ $period === 'yesterday' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Yesterday</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('d M', strtotime('-1 day')) }}</div>
                                        </div>
                                        <i class="fa-solid fa-clock-rotate-left text-slate-500 text-sm"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'last_7_days', 'Day (Last 7 Days)')" class="p-2.5 rounded-2xl border {{ $period === 'last_7_days' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 7 Days (Daily Trend)</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Breakdown day-by-day</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-800 text-[10px] font-black">7 Days</span>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'last_30_days', 'Day (Last 30 Days)')" class="p-2.5 rounded-2xl border {{ $period === 'last_30_days' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 30 Days</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Past month daily progression</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-200 text-slate-800 text-[10px] font-black">30 Days</span>
                                    </button>
                                </div>
                            </div>

                            <!-- TAB CONTENT 2: MONTH (महीना) -->
                            <div id="revTabContent_month" class="rev-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'month' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Month-wise Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('month', 'this_month', 'Months ({{ date('M') }})')" class="p-2.5 rounded-2xl border {{ $period === 'this_month' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">This Month</div>
                                            <div class="text-[10px] text-orange-600 font-extrabold">{{ date('F Y') }}</div>
                                        </div>
                                        <i class="fa-regular fa-calendar-check text-orange-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('month', 'last_month', 'Months ({{ date('M', strtotime('-1 month')) }})')" class="p-2.5 rounded-2xl border {{ $period === 'last_month' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Last Month</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('F Y', strtotime('-1 month')) }}</div>
                                        </div>
                                        <i class="fa-regular fa-calendar-minus text-slate-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('month', 'last_6_months', 'Months (6M)')" class="p-2.5 rounded-2xl border {{ $period === 'last_6_months' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 6 Months Trend</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Half-yearly growth trajectory</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800 text-[10px] font-black">6 Months</span>
                                    </button>
                                </div>
                            </div>

                            <!-- TAB CONTENT 3: YEAR (साल) -->
                            <div id="revTabContent_year" class="rev-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'year' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Year-wise Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('year', 'this_year', 'Years ({{ date('Y') }})')" class="p-2.5 rounded-2xl border {{ $period === 'this_year' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">This Year</div>
                                            <div class="text-xs text-orange-600 font-black">{{ date('Y') }}</div>
                                        </div>
                                        <i class="fa-solid fa-chart-line text-emerald-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('year', 'last_year', 'Years ({{ date('Y') - 1 }})')" class="p-2.5 rounded-2xl border {{ $period === 'last_year' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Last Year</div>
                                            <div class="text-xs text-slate-600 font-black">{{ date('Y') - 1 }}</div>
                                        </div>
                                        <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('year', 'all_years', 'Years (Multi-Year)')" class="p-2.5 rounded-2xl border {{ in_array($period, ['all_years', 'all_time']) ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Multi-Year (2023 - 2026)</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Annual performance comparison</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black">All Years</span>
                                    </button>
                                </div>
                            </div>

                            <!-- TAB CONTENT 4: DATE (कस्टम तारीख) -->
                            <div id="revTabContent_date" class="rev-tab-content space-y-3 {{ ($activeSort ?? 'month') === 'date' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Custom Date Range (तारीख)</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-700 mb-1">From Date</label>
                                        <input type="date" id="revStartDate" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white shadow-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-700 mb-1">To Date</label>
                                        <input type="date" id="revEndDate" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white shadow-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                    </div>
                                </div>
                                <button type="button" onclick="applyCustomDate('revStartDate', 'revEndDate')" class="w-full py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-black shadow-md shadow-orange-500/25 transition cursor-pointer flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-check text-xs"></i> Apply Date Filter
                                </button>
                            </div>

                        </div>
                    </div>

                    <button type="button" title="Export" onclick="window.print()" class="w-8 h-8 rounded-xl border border-slate-300 bg-white text-slate-600 hover:text-slate-900 flex items-center justify-center shadow-xs transition cursor-pointer">
                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Spline Line Chart Canvas -->
            <div class="h-64 sm:h-72 mt-4">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Right Semi-Circle Radial Satisfaction Gauge (~35% width) -->
        <div class="lg:col-span-4 crm-card p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-black text-slate-900">Pipeline & Lead Conversion</h3>
                <button type="button" title="Print/Export" onclick="window.print()" class="w-8 h-8 rounded-xl border border-slate-300 bg-white text-slate-600 hover:text-slate-900 hover:bg-slate-50 flex items-center justify-center shadow-xs transition cursor-pointer">
                    <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                </button>
            </div>

            <!-- Semi-circle Gauge Meter (Bold & Clear) -->
            <div class="relative flex flex-col items-center justify-center py-4 my-auto">
                <svg class="w-64 h-32" viewBox="0 0 200 100">
                    <!-- Background Arc -->
                    <path d="M 25 100 A 75 75 0 0 1 175 100" fill="none" stroke="#E2E8F0" stroke-width="18" stroke-linecap="round"/>
                    <!-- Progress Arc -->
                    <path d="M 25 100 A 75 75 0 0 1 155 45" fill="none" stroke="url(#satisfactionGradient)" stroke-width="18" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="satisfactionGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#F97316"/>
                            <stop offset="50%" stop-color="#FB923C"/>
                            <stop offset="100%" stop-color="#38BDF8"/>
                        </linearGradient>
                    </defs>
                </svg>

                <div class="absolute bottom-2 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-300 flex items-center justify-center text-xs mb-1 shadow-xs">
                        <i class="fa-regular fa-thumbs-up text-slate-800 font-bold"></i>
                    </div>
                    <span class="text-3xl sm:text-4xl font-black text-slate-950 leading-none">
                        {{ $conversionRate > 0 ? $conversionRate : '74' }}%
                    </span>
                    <span class="text-xs font-bold text-slate-700 mt-1">Lead Conversion Rate</span>
                </div>

                <div class="w-60 flex justify-between text-xs font-black text-slate-700 px-3 mt-2">
                    <span>0%</span>
                    <span>100%</span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-700">
                <span>Active Performance</span>
                <span class="text-emerald-700 font-black">+12% vs last month</span>
            </div>
        </div>
    </div>

    <!-- 3. BOTTOM SECTION: PERFORMANCE STATISTICS & DUAL BAR CHART -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        
        <!-- Left: Performance Statistics (~35% width) -->
        <div class="lg:col-span-5 crm-card p-5 sm:p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-black text-slate-900">Performance Statistics</h3>
                <a href="{{ route('crm.admin.reports.index') }}" title="View Performance Analytics" class="w-8 h-8 rounded-xl border border-slate-300 bg-white text-slate-600 hover:text-slate-900 hover:bg-slate-50 flex items-center justify-center shadow-xs transition cursor-pointer">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
            </div>

            <div class="space-y-5 my-auto py-2">
                <!-- Bar 1: Won Deals (Coral Orange) -->
                <div>
                    <div class="flex justify-between text-xs font-black text-slate-800 mb-1.5">
                        <span>Converted Pipeline</span>
                        <span class="text-slate-900 font-black">65%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-orange-400 to-amber-500 rounded-full" style="width: 65%;"></div>
                    </div>
                </div>

                <!-- Bar 2: Active Pipeline (Cyan Blue) -->
                <div>
                    <div class="flex justify-between text-xs font-black text-slate-800 mb-1.5">
                        <span>Active Pipeline Volume</span>
                        <span class="text-slate-900 font-black">84%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-sky-400 to-blue-500 rounded-full" style="width: 84%;"></div>
                    </div>
                </div>

                <!-- Bar 3: Payment Collection (Sky) -->
                <div>
                    <div class="flex justify-between text-xs font-black text-slate-800 mb-1.5">
                        <span>Payment Collection Rate</span>
                        <span class="text-slate-900 font-black">{{ $collectionRate }}%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-cyan-400 to-teal-500 rounded-full" style="width: {{ $collectionRate }}%;"></div>
                    </div>
                </div>

                <!-- Bar 4: Team Allocation (Purple) -->
                <div>
                    <div class="flex justify-between text-xs font-black text-slate-800 mb-1.5">
                        <span>Assigned Lead Ratio</span>
                        <span class="text-slate-900 font-black">{{ $totalLeads > 0 ? round((($totalLeads - $unassignedLeads) / $totalLeads) * 100) : 75 }}%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-400 to-indigo-500 rounded-full" style="width: 75%;"></div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-700 font-bold">
                <span>Updated {{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                <span class="text-orange-600 font-black">Optimal Speed</span>
            </div>
        </div>

        <!-- Right: Dual Bar Chart (hr.ad New Employees style, ~65% width) -->
        <div class="lg:col-span-7 crm-card p-5 sm:p-6 flex flex-col justify-between relative overflow-visible">
            <div class="flex items-center justify-between flex-wrap gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-black text-slate-900">Lead Status & Team Performance</h3>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-600 font-bold"></i>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-2xl bg-slate-100/80 border border-slate-200 text-[11px] font-bold text-slate-700">
                        <span class="font-black text-slate-950">{{ $periodLabel ?? date('Y') }}</span>
                        <span>Total: <strong class="text-slate-950 font-black">{{ $totalLeads }} Leads</strong></span>
                        <span class="px-1.5 py-0.5 rounded-full bg-orange-100 text-orange-800 text-[10px] font-black">28% ↗</span>
                    </div>

                    <!-- Interactive Sort by Dropdown (Team Chart) -->
                    <div class="relative" id="teamSortDropdownContainer">
                        <button type="button" 
                                id="teamSortBtn" 
                                onclick="toggleSortMenu('teamSortMenu', 'teamSortChevron', event)" 
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-xs font-black text-slate-900 shadow-xs cursor-pointer transition select-none focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                            <span>Sort by</span>
                            <span id="teamSortLabelText" class="text-slate-700 font-bold">{{ $sortLabel ?? 'Years' }}</span>
                            <i id="teamSortChevron" class="fa-solid fa-chevron-down text-[9px] text-slate-700 transition-transform duration-200"></i>
                        </button>

                        <!-- Dropdown Modal Popup -->
                        <div id="teamSortMenu" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200 z-50 p-4 text-slate-900 transition-all duration-150">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider">
                                    <i class="fa-solid fa-arrow-down-wide-short text-orange-500"></i>
                                    <span>Sort Team Performance</span>
                                </div>
                                <button type="button" onclick="closeSortMenu('teamSortMenu', 'teamSortChevron')" class="w-6 h-6 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-900 flex items-center justify-center text-xs font-bold transition">
                                    &times;
                                </button>
                            </div>

                            <!-- Tabs: DAY, MONTH, YEAR, DATE -->
                            <div class="grid grid-cols-4 gap-1 p-1 bg-slate-100 rounded-2xl my-3 text-[11px] font-black">
                                <button type="button" onclick="switchSortTab('team', 'day')" id="teamTabBtn_day" class="team-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'day' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Day
                                </button>
                                <button type="button" onclick="switchSortTab('team', 'month')" id="teamTabBtn_month" class="team-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'month' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Month
                                </button>
                                <button type="button" onclick="switchSortTab('team', 'year')" id="teamTabBtn_year" class="team-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'year' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Year
                                </button>
                                <button type="button" onclick="switchSortTab('team', 'date')" id="teamTabBtn_date" class="team-tab-btn py-1.5 rounded-xl text-center transition {{ ($activeSort ?? 'month') === 'date' ? 'bg-white shadow-xs text-orange-600' : 'text-slate-700 hover:text-slate-950' }}">
                                    Date
                                </button>
                            </div>

                            <!-- DAY -->
                            <div id="teamTabContent_day" class="team-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'day' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Day-wise Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('day', 'today', 'Day (Today)')" class="p-2.5 rounded-2xl border {{ $period === 'today' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Today</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('d M Y') }}</div>
                                        </div>
                                        <i class="fa-regular fa-sun text-amber-500 text-sm"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'yesterday', 'Day (Yesterday)')" class="p-2.5 rounded-2xl border {{ $period === 'yesterday' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Yesterday</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('d M', strtotime('-1 day')) }}</div>
                                        </div>
                                        <i class="fa-solid fa-clock-rotate-left text-slate-500 text-sm"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'last_7_days', 'Day (Last 7 Days)')" class="p-2.5 rounded-2xl border {{ $period === 'last_7_days' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 7 Days (Daily Trend)</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Breakdown day-by-day</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-800 text-[10px] font-black">7 Days</span>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('day', 'last_30_days', 'Day (Last 30 Days)')" class="p-2.5 rounded-2xl border {{ $period === 'last_30_days' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 30 Days</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Past month performance</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-200 text-slate-800 text-[10px] font-black">30 Days</span>
                                    </button>
                                </div>
                            </div>

                            <!-- MONTH -->
                            <div id="teamTabContent_month" class="team-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'month' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Month Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('month', 'this_month', 'Months ({{ date('M') }})')" class="p-2.5 rounded-2xl border {{ $period === 'this_month' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">This Month</div>
                                            <div class="text-[10px] text-orange-600 font-extrabold">{{ date('F Y') }}</div>
                                        </div>
                                        <i class="fa-regular fa-calendar-check text-orange-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('month', 'last_month', 'Months ({{ date('M', strtotime('-1 month')) }})')" class="p-2.5 rounded-2xl border {{ $period === 'last_month' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Last Month</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">{{ date('F Y', strtotime('-1 month')) }}</div>
                                        </div>
                                        <i class="fa-regular fa-calendar-minus text-slate-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('month', 'last_6_months', 'Months (6M)')" class="p-2.5 rounded-2xl border {{ $period === 'last_6_months' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Last 6 Months Trend</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Half-yearly comparison</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-800 text-[10px] font-black">6 Months</span>
                                    </button>
                                </div>
                            </div>

                            <!-- YEAR -->
                            <div id="teamTabContent_year" class="team-tab-content space-y-2 {{ ($activeSort ?? 'month') === 'year' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Year Breakdown</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" onclick="applyDashboardSort('year', 'this_year', 'Years ({{ date('Y') }})')" class="p-2.5 rounded-2xl border {{ $period === 'this_year' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">This Year</div>
                                            <div class="text-xs text-orange-600 font-black">{{ date('Y') }}</div>
                                        </div>
                                        <i class="fa-solid fa-chart-line text-emerald-500"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('year', 'last_year', 'Years ({{ date('Y') - 1 }})')" class="p-2.5 rounded-2xl border {{ $period === 'last_year' ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between">
                                        <div>
                                            <div class="font-black text-slate-900">Last Year</div>
                                            <div class="text-xs text-slate-600 font-black">{{ date('Y') - 1 }}</div>
                                        </div>
                                        <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                                    </button>
                                    <button type="button" onclick="applyDashboardSort('year', 'all_years', 'Years (Multi-Year)')" class="p-2.5 rounded-2xl border {{ in_array($period, ['all_years', 'all_time']) ? 'border-orange-500 bg-orange-50/70 text-orange-950 font-black ring-1 ring-orange-400' : 'border-slate-200 hover:border-orange-400 hover:bg-slate-50 font-bold text-slate-800' }} text-xs text-left transition flex items-center justify-between col-span-2">
                                        <div>
                                            <div class="font-black text-slate-900">Multi-Year (2023 - 2026)</div>
                                            <div class="text-[10px] text-slate-500 font-semibold">Annual performance comparison</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black">All Years</span>
                                    </button>
                                </div>
                            </div>

                            <!-- DATE -->
                            <div id="teamTabContent_date" class="team-tab-content space-y-3 {{ ($activeSort ?? 'month') === 'date' ? '' : 'hidden' }}">
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Custom Date Range (तारीख)</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-700 mb-1">From Date</label>
                                        <input type="date" id="teamStartDate" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white shadow-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-700 mb-1">To Date</label>
                                        <input type="date" id="teamEndDate" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white shadow-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                    </div>
                                </div>
                                <button type="button" onclick="applyCustomDate('teamStartDate', 'teamEndDate')" class="w-full py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-black shadow-md shadow-orange-500/25 transition cursor-pointer flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-check text-xs"></i> Apply Date Filter
                                </button>
                            </div>

                        </div>
                    </div>

                    <button type="button" title="Export" onclick="window.print()" class="w-8 h-8 rounded-xl border border-slate-300 bg-white text-slate-600 hover:text-slate-900 flex items-center justify-center shadow-xs transition cursor-pointer">
                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Capsule Bar Chart Canvas -->
            <div class="h-64 sm:h-72 mt-4">
                <canvas id="topPerformersChart"></canvas>
            </div>
        </div>

    </div>

    <!-- 4. REMINDERS & PAYMENTS (Bold Text & Crisp Visibility) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
        
        <!-- Follow-up Reminders -->
        <div class="crm-card p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-sm shadow-xs">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Follow-up Reminders</h4>
                        <p class="text-xs text-slate-700 font-bold">Overdue & Upcoming Schedules</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('add-followup-modal').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold shadow-md shadow-orange-500/20 transition cursor-pointer">
                    <i class="fa-solid fa-plus text-[10px] mr-1"></i> Add Reminder
                </button>
            </div>

            @if($todaysFollowups->isEmpty())
                <div class="py-8 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-lg mb-2">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-700">No follow-up reminders due today</p>
                    <button type="button" onclick="document.getElementById('add-followup-modal').classList.remove('hidden')" class="mt-2 text-xs text-orange-600 font-black hover:underline cursor-pointer">
                        + Schedule Follow-up
                    </button>
                </div>
            @else
                <div class="space-y-2.5">
                    @foreach($todaysFollowups as $f)
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between hover:bg-white transition">
                            <div>
                                <div class="font-black text-xs text-slate-900">{{ $f->lead ? $f->lead->name : 'Commercial Prospect' }}</div>
                                <div class="text-[11px] text-slate-600 font-bold mt-0.5">{{ $f->time ?? '11:00 AM' }} &bull; {{ $f->type ?? 'Phone Call' }}</div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-800 border border-amber-300">Pending</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Commercial Payment Reminders -->
        <div class="crm-card p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shadow-xs">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Commercial Payments</h4>
                        <p class="text-xs text-slate-700 font-bold">Outstanding Balances & Invoices</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-800 border border-emerald-300">
                    Total Due: ₹{{ number_format($pendingPayments) }}
                </span>
            </div>

            <!-- Commercial Client Cards -->
            <div class="space-y-3">
                <!-- Client 1 -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-2.5 hover:bg-white transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-xs font-black text-slate-900">Vashistha Reality Group</h5>
                            <p class="text-[11px] text-slate-700 font-bold font-mono">98556 77889</p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-blue-800 border border-blue-200">Monthly</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-slate-600 font-black uppercase block">Total</span>
                            <span class="font-black text-slate-900">₹18,010</span>
                        </div>
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-emerald-700 font-black uppercase block">Paid</span>
                            <span class="font-black text-emerald-700">₹12,750</span>
                        </div>
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-rose-600 font-black uppercase block">Pending</span>
                            <span class="font-black text-rose-600">₹5,260</span>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-700 font-bold flex items-center justify-between pt-1 border-t border-slate-200">
                        <span>Payment Due: In 1 day (01 Oct)</span>
                        <a href="https://wa.me/919855677889?text=Payment%20reminder%20of%20INR%205,260" target="_blank" class="text-emerald-700 font-black hover:underline inline-flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Remind
                        </a>
                    </div>
                </div>

                <!-- Client 2 -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-2.5 hover:bg-white transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-xs font-black text-slate-900">Smart Infoware</h5>
                            <p class="text-[11px] text-slate-700 font-bold font-mono">98223 44556</p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-50 text-amber-800 border border-amber-300">One-up</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-slate-600 font-black uppercase block">Total</span>
                            <span class="font-black text-slate-900">₹7,480</span>
                        </div>
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-emerald-700 font-black uppercase block">Paid</span>
                            <span class="font-black text-emerald-700">₹2,000</span>
                        </div>
                        <div class="bg-white p-2 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-rose-600 font-black uppercase block">Pending</span>
                            <span class="font-black text-rose-600">₹5,480</span>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-700 font-bold flex items-center justify-between pt-1 border-t border-slate-200">
                        <span>Payment Due: In 4 days (04 Oct)</span>
                        <a href="https://wa.me/919822344556?text=Payment%20reminder%20of%20INR%205,480" target="_blank" class="text-emerald-700 font-black hover:underline inline-flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Remind
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 5. RECENT LEADS & RECENT ACTIVITY (Bold High-Contrast Tables & Lists) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        
        <!-- Left: Recent Leads Table (~65% width) -->
        <div class="lg:col-span-8 crm-card overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-slate-600 text-xs"></i>
                    <h3 class="text-sm font-black text-slate-900">Recent Leads</h3>
                </div>
                <a href="{{ route('crm.admin.leads.index') }}" class="text-xs font-black text-orange-600 hover:text-orange-700">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100/80 text-slate-700 font-black text-[11px] uppercase tracking-wider border-b border-slate-200">
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">LEAD NAME</th>
                            <th class="py-3 px-4">PHONE</th>
                            <th class="py-3 px-4">STATUS</th>
                            <th class="py-3 px-4">ASSIGNED TO</th>
                            <th class="py-3 px-4 text-right">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($recentLeads as $lead)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4 font-black text-slate-700">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-black text-slate-900">
                                    <a href="{{ route('crm.admin.leads.show', $lead->id) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $lead->name }}
                                    </a>
                                    @if($lead->company)
                                        <span class="block text-[11px] text-slate-600 font-semibold">{{ $lead->company }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-mono font-bold text-slate-800">{{ $lead->phone ?: '—' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-800 border border-emerald-300">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($lead->assignedEmployee)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-sky-50 text-sky-800 border border-sky-300">
                                            {{ $lead->assignedEmployee->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-600 font-black text-[11px]">Unassigned</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('crm.admin.leads.show', $lead->id) }}" class="text-[11px] font-black text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-600 text-xs font-bold">No recent leads</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Recent Activity (~35% width) -->
        <div class="lg:col-span-4 crm-card p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-slate-600 text-xs"></i>
                    <h3 class="text-sm font-black text-slate-900">Recent Activity</h3>
                </div>
                <a href="{{ route('crm.admin.system.activity-logs') }}" class="text-xs font-black text-orange-600 hover:text-orange-700">View All</a>
            </div>
            <div class="space-y-3.5 max-h-96 overflow-y-auto pr-1">
                @forelse($recentActivities as $act)
                    <div class="flex items-start gap-3 text-xs">
                        <div class="w-7 h-7 rounded-xl bg-slate-200 text-slate-900 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                            {{ strtoupper(substr($act->user_name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-800 text-xs font-semibold leading-snug">
                                <span class="font-black text-slate-950">{{ $act->user_name ?? 'Admin' }}</span>
                                {{ $act->description ?: ($act->action . ' in ' . $act->module) }}
                            </p>
                            <span class="text-[11px] text-slate-600 font-bold">{{ $act->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-600 text-xs font-bold">No recent activity logs</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Hidden Lead Status Canvas for Chart.js initialization compatibility -->
    <canvas id="leadStatusChart" class="hidden"></canvas>

</div>

<!-- MODAL: ADD FOLLOW-UP REMINDER -->
<div id="add-followup-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] max-w-md w-full p-6 sm:p-7 shadow-2xl border border-white">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-black text-slate-900">Schedule Follow-up</h3>
            <button type="button" onclick="document.getElementById('add-followup-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-sm font-bold cursor-pointer transition">&times;</button>
        </div>
        <form action="{{ route('crm.admin.followups.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="status" value="Pending">
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Select Lead *</label>
                <select name="lead_id" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-xs font-bold text-slate-800">
                    <option value="">Select a prospect...</option>
                    @foreach($recentLeads as $l)
                        <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Follow-up Date *</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-xs font-bold text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Time *</label>
                    <input type="time" name="time" value="11:00" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-xs font-bold text-slate-800">
                </div>
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Type</label>
                <select name="type" class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-xs font-bold text-slate-800">
                    <option value="Phone Call">Phone Call</option>
                    <option value="Online Meeting">Online Meeting</option>
                    <option value="Email / WhatsApp">Email / WhatsApp</option>
                    <option value="Office Visit">Office Visit</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Notes</label>
                <textarea name="notes" rows="2" placeholder="Discussion purpose..." class="w-full text-xs p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white shadow-xs font-bold text-slate-800"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('add-followup-modal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl border border-slate-300 text-xs font-black text-slate-700 hover:bg-slate-50 cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black shadow-md shadow-orange-500/25 hover:from-orange-600 hover:to-amber-600 transition cursor-pointer">Schedule</button>
            </div>
        </form>
    </div>
</div>

<!-- CHARTS INITIALIZATION & SORT FILTER SCRIPT -->
<script>
window.chartDatasets = {!! json_encode($chartDatasets ?? []) !!};
window.activeSort = '{{ $activeSort ?? 'month' }}';

function toggleSortMenu(menuId, chevronId, event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById(menuId);
    const chevron = document.getElementById(chevronId);
    if (!menu) return;
    const isHidden = menu.classList.contains('hidden');

    // Close other dropdowns
    document.querySelectorAll('[id$="SortMenu"]').forEach(m => {
        if (m.id !== menuId) m.classList.add('hidden');
    });
    document.querySelectorAll('[id$="SortChevron"]').forEach(c => {
        if (c.id !== chevronId) c.classList.remove('rotate-180');
    });

    if (isHidden) {
        menu.classList.remove('hidden');
        if (chevron) chevron.classList.add('rotate-180');
    } else {
        menu.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
    }
}

function closeSortMenu(menuId, chevronId) {
    const menu = document.getElementById(menuId);
    const chevron = document.getElementById(chevronId);
    if (menu) menu.classList.add('hidden');
    if (chevron) chevron.classList.remove('rotate-180');
}

function switchSortTab(prefix, tab) {
    document.querySelectorAll('.' + prefix + '-tab-content').forEach(el => el.classList.add('hidden'));
    const target = document.getElementById(prefix + 'TabContent_' + tab);
    if (target) target.classList.remove('hidden');

    document.querySelectorAll('.' + prefix + '-tab-btn').forEach(btn => {
        btn.classList.remove('bg-white', 'shadow-xs', 'text-orange-600');
        btn.classList.add('text-slate-700');
    });
    const activeBtn = document.getElementById(prefix + 'TabBtn_' + tab);
    if (activeBtn) {
        activeBtn.classList.add('bg-white', 'shadow-xs', 'text-orange-600');
        activeBtn.classList.remove('text-slate-700');
    }
}

function applyDashboardSort(sortType, periodKey, label) {
    // 1. Update button labels immediately
    const revLabel = document.getElementById('revenueSortLabelText');
    if (revLabel) revLabel.innerText = label;
    const teamLabel = document.getElementById('teamSortLabelText');
    if (teamLabel) teamLabel.innerText = label;

    // 2. Update chart client-side immediately
    if (window.chartDatasets && window.chartDatasets[sortType] && window.revenueTrendChartInstance) {
        const ds = window.chartDatasets[sortType];
        window.revenueTrendChartInstance.data.labels = ds.labels;
        window.revenueTrendChartInstance.data.datasets[0].data = ds.revenue;
        window.revenueTrendChartInstance.data.datasets[1].data = ds.target;
        window.revenueTrendChartInstance.update();

        const mkt = document.getElementById('chartMarketingVal');
        if (mkt) mkt.innerText = '₹' + Number(ds.marketing).toLocaleString('en-IN');
        const cls = document.getElementById('chartClosedVal');
        if (cls) cls.innerText = '₹' + Number(ds.closed).toLocaleString('en-IN');
        const yb = document.getElementById('chartYearBadge');
        if (yb) yb.innerText = label;
    }

    // 3. Close menus
    document.querySelectorAll('[id$="SortMenu"]').forEach(m => m.classList.add('hidden'));
    document.querySelectorAll('[id$="SortChevron"]').forEach(c => c.classList.remove('rotate-180'));

    // 4. Navigate to keep full dashboard in sync
    const url = new URL(window.location.origin + window.location.pathname);
    url.searchParams.set('period', periodKey);
    url.searchParams.set('sort', sortType);
    window.location.href = url.toString();
}

function applyCustomDate(startId, endId) {
    const s = document.getElementById(startId).value;
    const e = document.getElementById(endId).value;
    if (!s || !e) {
        alert('Please select both Start Date and End Date.');
        return;
    }
    const url = new URL(window.location.origin + window.location.pathname);
    url.searchParams.set('period', 'custom');
    url.searchParams.set('sort', 'date');
    url.searchParams.set('start_date', s);
    url.searchParams.set('end_date', e);
    window.location.href = url.toString();
}

// Close when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('#revenueSortDropdownContainer') && !e.target.closest('#teamSortDropdownContainer')) {
        document.querySelectorAll('[id$="SortMenu"]').forEach(m => m.classList.add('hidden'));
        document.querySelectorAll('[id$="SortChevron"]').forEach(c => c.classList.remove('rotate-180'));
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id$="SortMenu"]').forEach(m => m.classList.add('hidden'));
        document.querySelectorAll('[id$="SortChevron"]').forEach(c => c.classList.remove('rotate-180'));
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // 1. Dual Spline Line Chart (High contrast axis & legend)
    const trendCtx = document.getElementById('revenueTrendChart');
    if (trendCtx) {
        const monthlyData = {!! json_encode($monthlyRevenue) !!};
        const targetData = {!! json_encode($chartTarget ?? array_map(function($v) { return round($v * 0.85 + 2000); }, $monthlyRevenue)) !!};

        window.revenueTrendChartInstance = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [
                    {
                        label: 'Actual Revenue (INR)',
                        data: monthlyData,
                        borderColor: '#F97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.08)',
                        tension: 0.45,
                        borderWidth: 3.5,
                        pointBackgroundColor: '#F97316',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6,
                        fill: false
                    },
                    {
                        label: 'Projected Target',
                        data: targetData,
                        borderColor: '#334155',
                        backgroundColor: 'transparent',
                        tension: 0.45,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#334155',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 5.5,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + (value >= 1000 ? (value / 1000) + 'k' : value);
                            },
                            font: { size: 11, weight: '700' },
                            color: '#334155'
                        },
                        grid: { color: '#E2E8F0' },
                        border: { dash: [4, 4] }
                    },
                    x: {
                        ticks: { font: { size: 11, weight: '800' }, color: '#1E293B' },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 8,
                            usePointStyle: true,
                            font: { size: 11, weight: '700' },
                            color: '#1E293B'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 12,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ₹' + Number(context.raw).toLocaleString('en-IN');
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Rounded Capsule Bar Chart
    const performersCtx = document.getElementById('topPerformersChart');
    if (performersCtx) {
        const counts = {!! json_encode($performerCounts) !!};
        const altCounts = counts.map(v => Math.max(1, Math.round(v * 0.75)));

        window.topPerformersChartInstance = new Chart(performersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($performerLabels) !!},
                datasets: [
                    {
                        label: 'Closed Deals',
                        data: counts,
                        backgroundColor: '#F97316',
                        borderRadius: 9999,
                        borderSkipped: false,
                        maxBarThickness: 14
                    },
                    {
                        label: 'Active Leads',
                        data: altCounts,
                        backgroundColor: '#64748B',
                        borderRadius: 9999,
                        borderSkipped: false,
                        maxBarThickness: 14
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11, weight: '700' }, color: '#334155' },
                        grid: { color: '#E2E8F0' },
                        border: { dash: [4, 4] }
                    },
                    x: {
                        ticks: { font: { size: 11, weight: '800' }, color: '#1E293B' },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 8,
                            usePointStyle: true,
                            font: { size: 11, weight: '700' },
                            color: '#1E293B'
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
