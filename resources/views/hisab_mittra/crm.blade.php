@extends('hisab_mittra.layouts.master')

@section('title', 'Sales CRM & Visual Deal Pipeline — Hisab Mittra Enterprise Suite')
@section('meta_description', 'Accelerate Indian B2B sales with Hisab Mittra: Omnichannel Lead Ingestion, Visual Drag-and-Drop Kanban Pipeline, Official WhatsApp CRM, and 60-Second GST Quotations.')

@section('content')
<div class="py-12 sm:py-20 bg-transparent">

    <!-- ========================================================================= -->
    <!-- 1. HERO SECTION -->
    <!-- ========================================================================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl mb-16 sm:mb-20">
        
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-navy text-[12px] font-extrabold uppercase tracking-wider mb-4 shadow-sm motion-fade-in">
            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
            High-Velocity Revenue & Sales Engine
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy leading-[1.15] motion-reveal">
            Turn Inquiries into Closed Deals with <br>
            <span class="font-sans not-italic font-extrabold text-black">India's Smartest Sales CRM</span>
        </h1>
        
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-3xl mx-auto font-medium motion-reveal delay-100">
            Eliminate forgotten follow-ups, lost quotations, and unorganized sales reps. Auto-capture leads from WhatsApp, Google/Meta Ads, and IndiaMART, track deals across visual Kanban stages, and dispatch GST quotations in 60 seconds.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 motion-reveal delay-200">
            <a href="{{ route('crm.login') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold text-sm shadow-xl shadow-blue-600/30 transition-all flex items-center justify-center gap-2.5">
                <i class="fa-solid fa-bolt"></i>
                <span>Access Live CRM Panel &rarr;</span>
            </a>
            
            <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-100 text-black font-extrabold text-sm border border-slate-200 shadow-sm transition-all flex items-center justify-center gap-2.5 hover:border-slate-300">
                <i class="fa-regular fa-calendar-check text-blue-600"></i>
                <span>Book a Guided CRM Walkthrough</span>
            </button>
        </div>

        <!-- Real-Time Sales Metrics Strip -->
        <div class="mt-12 p-4 rounded-2xl bg-white border border-slate-200 shadow-lg grid grid-cols-2 md:grid-cols-4 gap-4 text-left motion-reveal delay-300">
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="₹1.8 Cr+">₹1.8 Cr+</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Active Pipeline Tracked</div>
                <div class="text-[11px] text-slate-500">Live deal forecasting</div>
            </div>
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="68.4%">68.4%</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Average Win Rate</div>
                <div class="text-[11px] text-slate-500">Industry benchmark 41%</div>
            </div>
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="3.2x">3.2x</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Faster Deal Closure</div>
                <div class="text-[11px] text-slate-500">Via auto-follow-up alerts</div>
            </div>
            <div class="p-3">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="98.2%">98.2%</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">WhatsApp Open Rate</div>
                <div class="text-[11px] text-slate-500">Official Meta Cloud API</div>
            </div>
        </div>

    </div>


    <!-- ========================================================================= -->
    <!-- 2. INTERACTIVE KANBAN DEAL PIPELINE SIMULATOR -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold mb-2 border border-blue-200">
                <i class="fa-solid fa-diagram-project"></i> VISUAL PIPELINE VELOCITY
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-black tracking-tight">
                Interactive Visual Deal Pipeline
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 font-medium">
                Move deals smoothly across stages, track probability, and forecast quarterly revenue with real-time velocity analytics.
            </p>
        </div>

        <!-- Interactive Board Container -->
        <div class="p-6 sm:p-10 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
            
            <!-- Top Controls Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5 mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <h3 class="font-extrabold text-sm text-white">Q3 Enterprise Pipeline &bull; Target: ₹1.2 Cr</h3>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Click "Advance Stage" on any deal card to simulate live stage velocity</p>
                </div>

                <!-- Filter Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto scrollbar-none">
                    <button onclick="filterDeals('all')" class="deal-filter-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-600 text-white transition-colors" data-filter="all">All Deals (14)</button>
                    <button onclick="filterDeals('high')" class="deal-filter-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-filter="high">High Value (&gt;₹10L)</button>
                    <button onclick="filterDeals('closing')" class="deal-filter-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-filter="closing">Closing This Week</button>
                </div>
            </div>

            <!-- Kanban Columns Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                
                <!-- Column 1: New Qualified Leads -->
                <div class="p-4 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex flex-col justify-between" id="col-new">
                    <div>
                        <div class="flex items-center justify-between mb-3 border-b border-slate-700/60 pb-2">
                            <span class="font-extrabold text-blue-400 uppercase tracking-wider text-[11px]">1. New Leads (2)</span>
                            <span class="text-[11px] font-bold text-slate-300">₹16.5L</span>
                        </div>

                        <div class="space-y-3" id="cards-col-new">
                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-slate-700 hover:border-blue-400 transition-all shadow-sm" data-id="1" data-val="450000" data-closing="false">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/20 text-blue-300 font-bold">Google Ads</span>
                                    <span class="text-[10px] text-slate-400">Owner: RS</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Apex Supply Chain</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹4,50,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-slate-400">50% Win Prob</span>
                                    <button onclick="advanceDeal(1, 'demo')" class="px-2 py-0.5 rounded bg-blue-600 hover:bg-blue-500 text-white font-bold transition-colors">
                                        Advance &rarr;
                                    </button>
                                </div>
                            </div>

                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-slate-700 hover:border-blue-400 transition-all shadow-sm" data-id="2" data-val="1200000" data-closing="true">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold">IndiaMART 🔥</span>
                                    <span class="text-[10px] text-slate-400">Owner: PK</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Sunrise Infrastructure</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹12,00,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-amber-400 font-bold">Hot Lead</span>
                                    <button onclick="advanceDeal(2, 'demo')" class="px-2 py-0.5 rounded bg-blue-600 hover:bg-blue-500 text-white font-bold transition-colors">
                                        Advance &rarr;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Demo & Proposal Sent -->
                <div class="p-4 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex flex-col justify-between" id="col-demo">
                    <div>
                        <div class="flex items-center justify-between mb-3 border-b border-slate-700/60 pb-2">
                            <span class="font-extrabold text-purple-400 uppercase tracking-wider text-[11px]">2. Proposal (2)</span>
                            <span class="text-[11px] font-bold text-slate-300">₹24.8L</span>
                        </div>

                        <div class="space-y-3" id="cards-col-demo">
                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-slate-700 hover:border-purple-400 transition-all shadow-sm" data-id="3" data-val="850000" data-closing="true">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-purple-500/20 text-purple-300 font-bold">WhatsApp Direct</span>
                                    <span class="text-[10px] text-slate-400">Owner: VK</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Zenith Healthcare</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹8,50,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-slate-400">Quote v2 Sent</span>
                                    <button onclick="advanceDeal(3, 'negotiation')" class="px-2 py-0.5 rounded bg-purple-600 hover:bg-purple-500 text-white font-bold transition-colors">
                                        Advance &rarr;
                                    </button>
                                </div>
                            </div>

                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-slate-700 hover:border-purple-400 transition-all shadow-sm" data-id="4" data-val="1630000" data-closing="false">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/20 text-blue-300 font-bold">Website Form</span>
                                    <span class="text-[10px] text-slate-400">Owner: RS</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Kapoor Steels Ltd</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹16,30,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-slate-400">Demo Complete</span>
                                    <button onclick="advanceDeal(4, 'negotiation')" class="px-2 py-0.5 rounded bg-purple-600 hover:bg-purple-500 text-white font-bold transition-colors">
                                        Advance &rarr;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Negotiation & Contract -->
                <div class="p-4 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex flex-col justify-between" id="col-negotiation">
                    <div>
                        <div class="flex items-center justify-between mb-3 border-b border-slate-700/60 pb-2">
                            <span class="font-extrabold text-amber-400 uppercase tracking-wider text-[11px]">3. Negotiation (1)</span>
                            <span class="text-[11px] font-bold text-slate-300">₹18.0L</span>
                        </div>

                        <div class="space-y-3" id="cards-col-negotiation">
                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-slate-700 hover:border-amber-400 transition-all shadow-sm" data-id="5" data-val="1800000" data-closing="true">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold">Strategic Enterprise</span>
                                    <span class="text-[10px] text-slate-400">Owner: PK</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Bharat Retail Co</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹18,00,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-amber-400 font-bold">90% Win Prob</span>
                                    <button onclick="advanceDeal(5, 'won')" class="px-2 py-0.5 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-colors">
                                        Close Won 🏆
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 4: Closed / Won -->
                <div class="p-4 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex flex-col justify-between" id="col-won">
                    <div>
                        <div class="flex items-center justify-between mb-3 border-b border-slate-700/60 pb-2">
                            <span class="font-extrabold text-emerald-400 uppercase tracking-wider text-[11px]">4. Closed Won (1)</span>
                            <span class="text-[11px] font-bold text-slate-300">₹16.5L</span>
                        </div>

                        <div class="space-y-3" id="cards-col-won">
                            <div class="deal-card p-3 rounded-xl bg-slate-900 border border-emerald-500/60 hover:border-emerald-400 transition-all shadow-sm" data-id="6" data-val="1650000" data-closing="false">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold">PO Received</span>
                                    <span class="text-[10px] text-slate-400">Owner: RS</span>
                                </div>
                                <div class="font-extrabold text-white text-xs mt-1.5">Tata Commercial Dealer</div>
                                <div class="text-xs font-extrabold text-emerald-400 mt-0.5">₹16,50,000</div>
                                <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-slate-800 text-[10px]">
                                    <span class="text-emerald-400 font-extrabold">100% WON</span>
                                    <span class="text-slate-400">GST Invoice Ready</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Follow-up Reminder Banner -->
            <div class="mt-6 pt-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-bell text-amber-400 animate-bounce"></i>
                    <span>Next scheduled WhatsApp reminder: <strong>Kapoor Steels Ltd</strong> today at 04:00 PM</span>
                </span>
                <span class="text-emerald-400 font-bold">Automated Activity Reminders Synced</span>
            </div>

        </div>

    </section>


    <!-- ========================================================================= -->
    <!-- 3. 4-STAGE OMNICHANNEL SALES ARCHITECTURE -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600">STRUCTURED PIPELINE FLOW</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-black tracking-tight mt-1">
                The 4-Stage High-Conversion Sales Funnel
            </h2>
            <p class="text-slate-600 text-sm mt-2 font-medium">From raw inquiry to revenue in your bank account, automated every step of the way.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-md hover:border-blue-300 transition-all space-y-3">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-extrabold text-sm">01</span>
                    <i class="fa-solid fa-bullseye text-blue-600 text-base"></i>
                </div>
                <h3 class="text-base font-extrabold text-black">Omnichannel Capture</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Auto-ingest incoming leads from your Website, WhatsApp Business chats, Google/Meta Ads, and IndiaMART with sub-second API webhooks.
                </p>
                <div class="text-[11px] font-bold text-blue-600">Zero manual lead entry</div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-md hover:border-blue-300 transition-all space-y-3">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-extrabold text-sm">02</span>
                    <i class="fa-solid fa-route text-purple-600 text-base"></i>
                </div>
                <h3 class="text-base font-extrabold text-black">Auto Lead Routing</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Equitably route leads using round-robin logic, state pin-codes, or deal values to the right sales executive with instant WhatsApp & app notifications.
                </p>
                <div class="text-[11px] font-bold text-purple-600">&lt;5 min response time</div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-md hover:border-blue-300 transition-all space-y-3">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-extrabold text-sm">03</span>
                    <i class="fa-solid fa-file-invoice text-amber-600 text-base"></i>
                </div>
                <h3 class="text-base font-extrabold text-black">WhatsApp Quotations</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Create clean GST-compliant quotations in 60 seconds and deliver them directly to the client's WhatsApp with a 1-click Razorpay payment link.
                </p>
                <div class="text-[11px] font-bold text-amber-600">98% client open rates</div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-md hover:border-blue-300 transition-all space-y-3">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-extrabold text-sm">04</span>
                    <i class="fa-solid fa-trophy text-emerald-600 text-base"></i>
                </div>
                <h3 class="text-base font-extrabold text-black">Deal Closed & Won</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Automatically convert closed deals into active customer accounts, create ledger entries, and alert the customer onboarding team.
                </p>
                <div class="text-[11px] font-bold text-emerald-600">Seamless finance sync</div>
            </div>

        </div>

    </section>


    <!-- ========================================================================= -->
    <!-- 4. OFFICIAL META WHATSAPP CRM & SHARED TEAM INBOX -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="p-8 sm:p-14 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-extrabold mb-3">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>OFFICIAL META CLOUD API</span>
                </div>
                
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    WhatsApp CRM with 98% Read Rates
                </h2>
                
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Indian customers rarely check corporate emails. Hisab Mittra embeds official WhatsApp Cloud API directly inside your sales workflow: send automated follow-up reminders, quotation PDFs, payment receipts, and meeting invites.
                </p>

                <div class="space-y-3.5 text-xs sm:text-sm font-semibold text-black">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Shared Multi-Agent Team Inbox</strong>
                            <span class="text-slate-600 font-normal text-xs">Multiple sales reps manage conversations from one verified business WhatsApp number with internal private notes.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">1-Click Quotation Dispatch from Lead Card</strong>
                            <span class="text-slate-600 font-normal text-xs">Dispatch formatted proposals directly from the deal view with automated read-receipt tracking and expiry timers.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Zero Client Data Loss on Private Phones</strong>
                            <span class="text-slate-600 font-normal text-xs">Sales representatives no longer take client chats onto personal WhatsApp, keeping company IP 100% secure.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="button" onclick="openDemoModal()" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition-all inline-flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>See WhatsApp CRM in Action</span>
                    </button>
                </div>
            </div>

            <!-- Right Modern WhatsApp Chat Console Mockup -->
            <div class="lg:col-span-6">
                <div class="max-w-md mx-auto rounded-3xl bg-slate-900 border-4 border-slate-800 shadow-2xl overflow-hidden text-slate-900 font-sans">
                    
                    <!-- WhatsApp Green Header -->
                    <div class="bg-[#075E54] text-white p-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-emerald-800 flex items-center justify-center font-bold text-xs text-white shadow">
                                <i class="fa-solid fa-building text-sm"></i>
                            </div>
                            <div>
                                <div class="font-extrabold text-xs flex items-center gap-1.5">
                                    <span>Rohit Sharma (Apex Logistics)</span>
                                    <i class="fa-solid fa-circle-check text-[11px] text-emerald-300"></i>
                                </div>
                                <div class="text-[10px] text-emerald-100 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Deal: ₹4.5L &bull; Stage: Proposal
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-white text-xs">
                            <i class="fa-solid fa-phone cursor-pointer"></i>
                            <i class="fa-solid fa-ellipsis-vertical cursor-pointer"></i>
                        </div>
                    </div>

                    <!-- Chat Message Area -->
                    <div class="bg-[#ECE5DD] p-4 space-y-3 min-h-[300px] text-xs">
                        
                        <!-- Client Inquiry -->
                        <div class="flex justify-start">
                            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] border border-slate-200/60">
                                <p class="text-slate-800 font-medium">Hi Team, we reviewed the software specs. Can you send the commercial quote for 45 branch locations?</p>
                                <span class="text-[9px] text-slate-400 block text-right mt-1">10:30 AM</span>
                            </div>
                        </div>

                        <!-- CRM Auto-Dispatched Quotation -->
                        <div class="flex justify-end">
                            <div class="bg-[#DCF8C6] p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[90%] border border-emerald-200/60">
                                <p class="text-slate-900 font-semibold">Namaste Rohit ji! 🙏</p>
                                <p class="text-slate-700 text-[11px] mt-1">Here is the customized enterprise proposal #QT-2026-0084 for your 45 branch locations:</p>
                                
                                <div class="mt-2 p-2.5 rounded-xl bg-white/95 border border-slate-200 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-file-pdf text-rose-600 text-lg"></i>
                                        <div>
                                            <div class="text-[11px] font-extrabold text-slate-800">Proposal_Apex_45Branches.pdf</div>
                                            <div class="text-[9px] text-slate-500">Value: ₹4,50,000 + GST</div>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-download text-emerald-700 text-xs"></i>
                                </div>

                                <div class="mt-2">
                                    <a href="javascript:void(0)" class="w-full py-1.5 px-3 rounded-lg bg-emerald-600 text-white font-extrabold text-[11px] text-center block transition-colors shadow-sm">
                                        View Proposal & Pay Advance (UPI) &rarr;
                                    </a>
                                </div>
                                <span class="text-[9px] text-slate-500 block text-right mt-1.5">10:32 AM &bull; <i class="fa-solid fa-check-double text-blue-600"></i> Read by client (10:34 AM)</span>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Chat Bar -->
                    <div class="bg-slate-100 p-2.5 flex items-center gap-2 border-t border-slate-200 text-slate-500 text-xs">
                        <i class="fa-regular fa-face-smile cursor-pointer"></i>
                        <input type="text" disabled placeholder="Type a message or select quick template..." class="w-full px-3 py-1.5 rounded-full bg-white text-[11px] border border-slate-200">
                        <i class="fa-solid fa-paper-plane text-emerald-600 cursor-pointer"></i>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 5. FREQUENTLY ASKED QUESTIONS (ACCORDION) -->
    <!-- ========================================================================= -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="text-center mb-12">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">FREQUENTLY ASKED QUESTIONS</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-black tracking-tight mt-1">
                Frequently Asked Questions About Hisab Mittra CRM
            </h2>
        </div>

        <div class="space-y-3.5">
            
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Can we import our existing leads and customer history from Excel or Zoho/HubSpot?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Yes. Hisab Mittra offers a 1-click CSV/Excel smart import wizard that auto-maps column headers for contacts, deal sizes, historical notes, and previous stages. Our migration engineers also assist you with free end-to-end database transfer from legacy CRMs.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>How does automated round-robin lead distribution work?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    When a lead arrives from your website, Google Ads, or WhatsApp, Hisab Mittra evaluates your configured rules: geographical pin-codes, product categories, or active executive availability. It then assigns the lead instantly, triggering mobile push and WhatsApp alerts to the assigned rep.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Can sales executives see each other's deals and client contact numbers?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    No, unless you want them to. Hisab Mittra provides granular role-based access control (RBAC). Sales executives only see deals assigned to them, while sales managers view team pipelines, and administrators maintain complete 360-degree organizational visibility.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Is WhatsApp Business API included or does it require third-party tools like Wati/Interakt?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Hisab Mittra features native, official Meta Cloud API integration. You do NOT need expensive third-party wrappers like Wati or Interakt. You connect your official WhatsApp Business number directly inside Hisab Mittra, saving ₹3,000–₹8,000/month per user.
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 6. BOTTOM HIGH-CONVERTING CTA -->
    <!-- ========================================================================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="p-8 sm:p-14 rounded-3xl bg-slate-900 text-white text-center shadow-2xl border border-slate-800">
            <div class="max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4 border border-blue-500/30">
                    <i class="fa-solid fa-rocket"></i> Close More Deals with Less Manual Effort
                </span>
                
                <h3 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Equip Your Sales Team with India's Premier CRM.
                </h3>
                
                <p class="mt-4 text-sm sm:text-base text-slate-300 leading-relaxed font-medium">
                    Join over 2,400+ Indian businesses driving higher revenue and zero lost follow-ups with Hisab Mittra.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('crm.login') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold text-sm shadow-xl shadow-blue-600/30 transition-all flex items-center justify-center gap-2.5">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Start Using Live CRM Today</span>
                    </a>
                    
                    <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 active:scale-95 text-white font-extrabold text-sm border border-white/20 transition-all flex items-center justify-center gap-2.5">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Book a 1-on-1 Demo</span>
                    </button>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Free data import assistance</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Official Meta API verification</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> 14-day risk-free trial</span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Vanilla Interactive JavaScript for CRM Page -->
<script>
    // 1. Interactive Deal Advance Simulation
    function advanceDeal(dealId, targetCol) {
        const card = document.querySelector(`.deal-card[data-id="${dealId}"]`);
        if (!card) return;

        const targetContainer = document.getElementById(`cards-col-${targetCol}`);
        if (!targetContainer) return;

        // Visual animation
        card.style.transform = 'scale(0.95)';
        card.style.opacity = '0.5';

        setTimeout(() => {
            targetContainer.appendChild(card);
            card.style.transform = 'scale(1)';
            card.style.opacity = '1';

            // Update button text based on stage
            const btn = card.querySelector('button');
            if (btn) {
                if (targetCol === 'demo') {
                    btn.textContent = 'Advance →';
                    btn.setAttribute('onclick', `advanceDeal(${dealId}, 'negotiation')`);
                    btn.className = 'px-2 py-0.5 rounded bg-purple-600 hover:bg-purple-500 text-white font-bold transition-colors';
                } else if (targetCol === 'negotiation') {
                    btn.textContent = 'Close Won 🏆';
                    btn.setAttribute('onclick', `advanceDeal(${dealId}, 'won')`);
                    btn.className = 'px-2 py-0.5 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-colors';
                } else if (targetCol === 'won') {
                    btn.remove();
                    const wonBadge = document.createElement('span');
                    wonBadge.className = 'text-emerald-400 font-extrabold';
                    wonBadge.textContent = '100% WON';
                    card.querySelector('.border-t').appendChild(wonBadge);
                }
            }
        }, 200);
    }

    // 2. Interactive Kanban Filter
    function filterDeals(type) {
        document.querySelectorAll('.deal-filter-btn').forEach(btn => {
            if (btn.getAttribute('data-filter') === type) {
                btn.classList.remove('bg-slate-800', 'text-slate-300');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-slate-800', 'text-slate-300');
            }
        });

        document.querySelectorAll('.deal-card').forEach(card => {
            const val = parseInt(card.getAttribute('data-val')) || 0;
            const isClosing = card.getAttribute('data-closing') === 'true';

            if (type === 'all') {
                card.style.display = 'block';
            } else if (type === 'high') {
                card.style.display = val >= 1000000 ? 'block' : 'none';
            } else if (type === 'closing') {
                card.style.display = isClosing ? 'block' : 'none';
            }
        });
    }

    // 3. FAQ Accordion Toggle
    function toggleFaq(card) {
        const content = card.querySelector('.faq-content');
        const icon = card.querySelector('.fa-chevron-down');
        if (content) {
            content.classList.toggle('hidden');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        }
    }
</script>
@endsection
