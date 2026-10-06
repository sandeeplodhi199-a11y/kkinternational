@extends('crm.layouts.master')

@section('title', 'Search Results - CRM')

@section('content')
<div class="space-y-6">

    <!-- SEARCH HEADER & INPUT BAR -->
    <div class="crm-card p-5 sm:p-7">
        <div class="max-w-3xl">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-magnifying-glass text-orange-500"></i>
                <span>Search Results</span>
                @if(!empty($q))
                    <span class="text-slate-500 font-bold text-base">for "<strong class="text-slate-950 font-black">{{ $q }}</strong>"</span>
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Found <strong class="text-slate-950 font-black">{{ $totalCount }}</strong> matching record{{ $totalCount === 1 ? '' : 's' }} across Leads, Customers, Deals, Quotations & Products.
            </p>

            <!-- Search Form -->
            <form action="{{ route('crm.admin.search') }}" method="GET" class="mt-4 flex items-center gap-2.5">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    <input type="text" 
                           name="q" 
                           value="{{ $q ?? '' }}" 
                           placeholder="Search by name, company, phone, email, lead code..." 
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white shadow-xs transition">
                </div>
                <button type="submit" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-black shadow-md shadow-orange-500/25 transition cursor-pointer flex items-center gap-2 shrink-0">
                    <span>Search</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- FILTER TABS & RESULTS -->
    @if($totalCount > 0)
        <!-- Category Summary Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-bold">
            <a href="#all-results" class="px-3.5 py-2 rounded-xl bg-slate-900 text-white font-black shrink-0 shadow-xs">
                All Results ({{ $totalCount }})
            </a>
            @if($leads->count() > 0)
                <a href="#leads-section" class="px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 hover:border-emerald-500 hover:text-emerald-700 font-black shrink-0 shadow-xs transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Leads ({{ $leads->count() }})</span>
                </a>
            @endif
            @if($customers->count() > 0)
                <a href="#customers-section" class="px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 hover:border-sky-500 hover:text-sky-700 font-black shrink-0 shadow-xs transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    <span>Customers ({{ $customers->count() }})</span>
                </a>
            @endif
            @if($deals->count() > 0)
                <a href="#deals-section" class="px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 hover:border-amber-500 hover:text-amber-700 font-black shrink-0 shadow-xs transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Deals ({{ $deals->count() }})</span>
                </a>
            @endif
            @if($quotations->count() > 0)
                <a href="#quotations-section" class="px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 hover:border-purple-500 hover:text-purple-700 font-black shrink-0 shadow-xs transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span>Quotations ({{ $quotations->count() }})</span>
                </a>
            @endif
            @if($products->count() > 0)
                <a href="#products-section" class="px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 hover:border-orange-500 hover:text-orange-700 font-black shrink-0 shadow-xs transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span>Products ({{ $products->count() }})</span>
                </a>
            @endif
        </div>

        <div id="all-results" class="space-y-6">

            <!-- 1. LEADS RESULTS -->
            @if($leads->count() > 0)
                <div id="leads-section" class="crm-card p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900">Leads</h3>
                                <p class="text-[11px] text-slate-600 font-bold">{{ $leads->count() }} lead{{ $leads->count() === 1 ? '' : 's' }} found</p>
                            </div>
                        </div>
                        <a href="{{ route('crm.admin.leads.index', ['search' => $q]) }}" class="text-xs font-black text-emerald-700 hover:underline">
                            View In Leads Table &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach($leads as $lead)
                            <div class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/50 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <a href="{{ route('crm.admin.leads.show', $lead->id) }}" class="text-xs font-black text-slate-950 group-hover:text-emerald-950 hover:underline block leading-snug">
                                                {{ $lead->name }}
                                            </a>
                                            <div class="text-[11px] text-slate-600 font-bold mt-0.5">{{ $lead->company ?: 'Direct Contact' }}</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                            {{ $lead->status }}
                                        </span>
                                    </div>

                                    <div class="mt-3 space-y-1 text-[11px] font-medium text-slate-700">
                                        @if($lead->phone)
                                            <div class="flex items-center gap-2 font-mono font-bold text-slate-900">
                                                <i class="fa-solid fa-phone text-[10px] text-slate-500"></i>
                                                <span>{{ $lead->phone }}</span>
                                            </div>
                                        @endif
                                        @if($lead->email)
                                            <div class="flex items-center gap-2 truncate">
                                                <i class="fa-regular fa-envelope text-[10px] text-slate-500"></i>
                                                <span class="truncate">{{ $lead->email }}</span>
                                            </div>
                                        @endif
                                        @if($lead->lead_code)
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-hashtag text-[10px] text-slate-500"></i>
                                                <span class="font-mono text-slate-700">{{ $lead->lead_code }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-200/80 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-500">
                                        Assigned: <strong class="text-slate-800">{{ $lead->assignedEmployee->name ?? 'Unassigned' }}</strong>
                                    </span>
                                    <a href="{{ route('crm.admin.leads.show', $lead->id) }}" class="px-3 py-1 rounded-xl bg-white border border-slate-300 hover:border-emerald-500 text-slate-800 hover:text-emerald-800 text-[11px] font-black shadow-2xs transition">
                                        View &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 2. CUSTOMERS RESULTS -->
            @if($customers->count() > 0)
                <div id="customers-section" class="crm-card p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-xs font-black">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900">Customers</h3>
                                <p class="text-[11px] text-slate-600 font-bold">{{ $customers->count() }} customer{{ $customers->count() === 1 ? '' : 's' }} found</p>
                            </div>
                        </div>
                        <a href="{{ route('crm.admin.customers.index') }}" class="text-xs font-black text-sky-700 hover:underline">
                            View All Customers &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach($customers as $customer)
                            <div class="p-4 rounded-2xl bg-slate-50 hover:bg-sky-50/50 border border-slate-200 hover:border-sky-300 transition group flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <a href="{{ route('crm.admin.customers.show', $customer->id) }}" class="text-xs font-black text-slate-950 group-hover:text-sky-950 hover:underline block leading-snug">
                                                {{ $customer->name }}
                                            </a>
                                            <div class="text-[11px] text-slate-600 font-bold mt-0.5">{{ $customer->company ?: 'Individual' }}</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black bg-sky-100 text-sky-800 border border-sky-300 shrink-0">
                                            {{ $customer->customer_code ?: 'ACCOUNT' }}
                                        </span>
                                    </div>

                                    <div class="mt-3 space-y-1 text-[11px] font-medium text-slate-700">
                                        @if($customer->phone)
                                            <div class="flex items-center gap-2 font-mono font-bold text-slate-900">
                                                <i class="fa-solid fa-phone text-[10px] text-slate-500"></i>
                                                <span>{{ $customer->phone }}</span>
                                            </div>
                                        @endif
                                        @if($customer->email)
                                            <div class="flex items-center gap-2 truncate">
                                                <i class="fa-regular fa-envelope text-[10px] text-slate-500"></i>
                                                <span class="truncate">{{ $customer->email }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-200/80 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-500">
                                        Status: <strong class="text-slate-800">{{ $customer->status ?? 'Active' }}</strong>
                                    </span>
                                    <a href="{{ route('crm.admin.customers.show', $customer->id) }}" class="px-3 py-1 rounded-xl bg-white border border-slate-300 hover:border-sky-500 text-slate-800 hover:text-sky-800 text-[11px] font-black shadow-2xs transition">
                                        Profile &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 3. QUOTATIONS RESULTS -->
            @if($quotations->count() > 0)
                <div id="quotations-section" class="crm-card p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-black">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900">Quotations & Proposals</h3>
                                <p class="text-[11px] text-slate-600 font-bold">{{ $quotations->count() }} quotation{{ $quotations->count() === 1 ? '' : 's' }} found</p>
                            </div>
                        </div>
                        <a href="{{ route('crm.admin.quotations.index') }}" class="text-xs font-black text-purple-700 hover:underline">
                            View All Quotations &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach($quotations as $quotation)
                            <div class="p-4 rounded-2xl bg-slate-50 hover:bg-purple-50/50 border border-slate-200 hover:border-purple-300 transition group flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="text-xs font-black text-slate-950 font-mono">{{ $quotation->quotation_no }}</div>
                                            <div class="text-[11px] text-slate-700 font-bold mt-0.5">{{ $quotation->customer_name }}</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 border border-purple-300 shrink-0">
                                            {{ $quotation->status }}
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-base font-black text-slate-900">₹{{ number_format($quotation->grand_total) }}</div>
                                        @if($quotation->customer_phone)
                                            <div class="text-[11px] font-mono text-slate-600 font-bold mt-1">{{ $quotation->customer_phone }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="pt-2 border-t border-slate-200/80 text-right">
                                    <a href="{{ route('crm.admin.quotations.index') }}" class="px-3 py-1 rounded-xl bg-white border border-slate-300 hover:border-purple-500 text-slate-800 hover:text-purple-800 text-[11px] font-black shadow-2xs transition">
                                        Open Quotation &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. PRODUCTS RESULTS -->
            @if($products->count() > 0)
                <div id="products-section" class="crm-card p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center text-xs font-black">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900">Products & Inventory</h3>
                                <p class="text-[11px] text-slate-600 font-bold">{{ $products->count() }} product{{ $products->count() === 1 ? '' : 's' }} found</p>
                            </div>
                        </div>
                        <a href="{{ route('crm.admin.products.index') }}" class="text-xs font-black text-orange-700 hover:underline">
                            View All Products &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach($products as $prod)
                            <div class="p-4 rounded-2xl bg-slate-50 hover:bg-orange-50/50 border border-slate-200 hover:border-orange-300 transition group flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="text-xs font-black text-slate-950">{{ $prod->name }}</div>
                                            <div class="text-[11px] text-slate-600 font-bold mt-0.5">{{ $prod->category ?? 'General' }}</div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black bg-orange-100 text-orange-800 border border-orange-300 shrink-0">
                                            {{ $prod->code ?: 'SKU' }}
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-base font-black text-orange-600">₹{{ number_format($prod->price) }}</div>
                                    </div>
                                </div>
                                <div class="pt-2 border-t border-slate-200/80 text-right">
                                    <a href="{{ route('crm.admin.products.index') }}" class="px-3 py-1 rounded-xl bg-white border border-slate-300 hover:border-orange-500 text-slate-800 hover:text-orange-800 text-[11px] font-black shadow-2xs transition">
                                        View Product &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    @else
        <!-- NO RESULTS FOUND EMPTY STATE -->
        <div class="crm-card p-10 text-center max-w-xl mx-auto space-y-4">
            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900">No matching records found</h3>
                <p class="text-xs text-slate-600 font-bold mt-1">
                    We couldn't find any leads, customers, deals, or products matching "<strong>{{ $q }}</strong>".
                </p>
            </div>
            <div class="text-xs text-slate-500 font-medium bg-slate-50 p-4 rounded-2xl border border-slate-200 text-left space-y-1.5">
                <div class="font-black text-slate-800">Search tips:</div>
                <div>&bull; Check for spelling errors or try fewer keywords.</div>
                <div>&bull; Search by partial phone number (e.g. <strong>98765</strong>).</div>
                <div>&bull; Search by customer code (e.g. <strong>CUST-1001</strong>).</div>
            </div>
            <div class="pt-2">
                <a href="{{ route('crm.admin.dashboard') }}" class="px-5 py-2.5 rounded-2xl bg-slate-900 text-white text-xs font-black hover:bg-slate-800 transition">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
