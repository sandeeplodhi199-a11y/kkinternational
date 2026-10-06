@extends('hisab_mittra.layouts.master')

@section('title', 'Transparent Pricing & Plans — Hisab Mittra')

@section('content')
<div class="py-12 sm:py-20 overflow-hidden bg-transparent">
    <!-- Header & Hero -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl mb-12">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4 motion-reveal">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Transparent & Predictable Pricing</span>
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-black motion-reveal delay-100">
            Transparent Plans for Every 
            <span class="font-sans not-italic font-extrabold text-black block sm:inline">Indian Business</span>
        </h1>
        
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto motion-reveal delay-200">
            Zero setup fees. Zero hidden charges. All plans include automated PF/ESI compliance, WhatsApp Cloud API, cloud backups, and dedicated onboarding assistance.
        </p>

        <!-- Interactive Billing Frequency Switcher with Smooth Slide & Confetti Badge -->
        <div class="mt-8 inline-flex items-center p-1.5 rounded-2xl bg-white border border-slate-200 shadow-md relative motion-reveal delay-300">
            <button type="button" id="toggle-monthly" onclick="setBilling('monthly')" class="relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 hover:text-black">
                Monthly Billing
            </button>
            <button type="button" id="toggle-annual" onclick="setBilling('annual')" class="relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-blue-600 text-white shadow-md flex items-center gap-2">
                <span>Annual Billing</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500 text-white font-extrabold uppercase tracking-wide animate-pulse">Save 20%</span>
            </button>
        </div>

        <p class="mt-3 text-xs text-slate-500 flex items-center justify-center gap-2">
            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
            <span>14-day free trial on all plans • No credit card required • Cancel anytime</span>
        </p>

        <!-- Interactive Team Size Recommender Slider -->
        <div class="mt-10 p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-soft-elevation max-w-2xl mx-auto text-left motion-reveal delay-400">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                <label for="team-size-slider" class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <i class="fa-solid fa-users text-blue-600"></i>
                    <span>Find the right plan for your team size:</span>
                </label>
                <span id="team-size-display" class="px-3 py-1 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 font-extrabold text-sm">
                    45 Employees
                </span>
            </div>
            
            <input type="range" id="team-size-slider" min="5" max="350" step="5" value="45" 
                   oninput="onTeamSizeSlide(this.value)" 
                   class="w-full h-2.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600 focus:outline-none transition-all">
            
            <div class="flex justify-between text-[11px] text-slate-400 font-semibold mt-2">
                <span>5 (MSME)</span>
                <span>50 (Growth)</span>
                <span>150 (Business)</span>
                <span>350+ (Enterprise)</span>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs">
                <span class="text-slate-600">Recommended based on your team:</span>
                <span id="recommended-plan-badge" class="font-extrabold text-blue-600 bg-blue-100/70 px-3 py-1 rounded-lg flex items-center gap-1.5 transition-all">
                    <span>Growth Plan (Mid-Market)</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Swipe Instructions & Navigation on Mobile/Tablet -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 flex items-center justify-between lg:hidden">
        <span class="text-xs font-semibold text-slate-500 flex items-center gap-1.5">
            <i class="fa-solid fa-arrows-left-right text-blue-500 animate-pulse"></i>
            Swipe or use arrows to view all 4 plans
        </span>
        <div class="flex items-center gap-2">
            <button type="button" onclick="scrollCarousel('left')" class="w-8 h-8 rounded-full bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-700 active:scale-90 transition">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button type="button" onclick="scrollCarousel('right')" class="w-8 h-8 rounded-full bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-700 active:scale-90 transition">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>

    <!-- 4 Pricing Cards with 3D Tilt, Click Feedback & Swipe Physics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div id="pricing-carousel" 
             class="flex lg:grid lg:grid-cols-4 gap-6 overflow-x-auto lg:overflow-visible snap-x snap-mandatory pb-6 pt-3 px-1 no-scrollbar select-none cursor-grab active:cursor-grabbing scroll-smooth"
             style="scrollbar-width: none; -ms-overflow-style: none;">
            
            <!-- Plan 1: Starter -->
            <div id="card-starter" 
                 onclick="selectPlanCard('starter')"
                 onmousemove="handle3DTilt(event, this)" 
                 onmouseleave="reset3DTilt(this)"
                 class="pricing-interactive-card min-w-[290px] sm:min-w-[320px] lg:min-w-0 snap-center p-7 rounded-3xl bg-white border-2 border-slate-200 shadow-soft-elevation flex flex-col justify-between relative transition-all duration-300 hover:shadow-2xl overflow-hidden cursor-pointer group">
                
                <!-- Dynamic Luminous Sheen following cursor -->
                <div class="card-sheen pointer-events-none absolute -inset-full opacity-0 transition-opacity duration-300 bg-radial-gradient"></div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-500">Starter</span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">MSME</span>
                    </div>

                    <h3 class="text-2xl font-black text-black">Small Teams</h3>
                    <p class="text-xs text-slate-500 mt-1 min-h-[32px]">Essential payroll, attendance, and leave management for startups & small firms.</p>
                    
                    <div class="my-6 p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-colors group-hover:bg-blue-50/40">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-black plan-price" data-monthly="1899" data-annual="1499">₹1,499</span>
                            <span class="text-xs text-slate-500 font-semibold">/ month</span>
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-1 billing-period-note">
                            Billed annually (₹17,988/yr)
                        </div>
                    </div>

                    <div class="text-xs font-bold text-black uppercase tracking-wider mb-3">Included Capabilities:</div>
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-bold text-black">Up to 25 Employees</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span>Mobile GPS & Selfie Face Attendance</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span>Indian PF, ESI & PT Payroll Calc</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span>Leave Policy & Holiday Calendar</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span>Automated PDF Payslips on Email</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-slate-400">
                            <i class="fa-solid fa-circle-xmark text-slate-300 text-sm"></i>
                            <span>Sales CRM & Lead Pipeline</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-slate-400">
                            <i class="fa-solid fa-circle-xmark text-slate-300 text-sm"></i>
                            <span>Official WhatsApp Green Tick API</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-5 border-t border-slate-100">
                    <button type="button" onclick="event.stopPropagation(); startPlanTrial('starter')" class="w-full py-3.5 rounded-2xl border-2 border-slate-300 hover:border-blue-600 bg-white hover:bg-blue-50/50 text-black font-extrabold text-xs text-center transition-all shadow-sm active:scale-95 flex items-center justify-center gap-2">
                        <span>Start 14-Day Free Trial</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                    <span class="block text-center text-[10px] text-slate-400 font-semibold mt-2">Zero setup fee • Immediate access</span>
                </div>
            </div>

            <!-- Plan 2: Growth (Featured / Most Popular) -->
            <div id="card-growth" 
                 onclick="selectPlanCard('growth')"
                 onmousemove="handle3DTilt(event, this)" 
                 onmouseleave="reset3DTilt(this)"
                 class="pricing-interactive-card min-w-[290px] sm:min-w-[320px] lg:min-w-0 snap-center p-7 rounded-3xl bg-gradient-to-b from-blue-50/60 via-white to-white border-2 border-blue-600 shadow-2xl relative flex flex-col justify-between transition-all duration-300 lg:-translate-y-3 cursor-pointer group ring-4 ring-blue-600/10">
                
                <!-- Most Popular Pulsing Pill -->
                <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-blue-600 text-white text-[10px] font-black uppercase tracking-wider shadow-lg flex items-center gap-1.5">
                    <i class="fa-solid fa-fire text-amber-300 animate-bounce"></i>
                    <span>Most Popular Across India</span>
                </span>

                <!-- Dynamic Luminous Sheen -->
                <div class="card-sheen pointer-events-none absolute -inset-full opacity-0 transition-opacity duration-300 bg-radial-gradient"></div>

                <div>
                    <div class="flex items-center justify-between mb-2 mt-1">
                        <span class="text-xs font-black uppercase tracking-wider text-blue-700">Growth</span>
                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800">Best Value</span>
                    </div>

                    <h3 class="text-2xl font-black text-black">Mid-Market</h3>
                    <p class="text-xs text-slate-500 mt-1 min-h-[32px]">All-in-one solution for growing companies scaling workforce and revenue.</p>
                    
                    <div class="my-6 p-4 rounded-2xl bg-blue-50/80 border border-blue-200 transition-colors">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-blue-700 plan-price" data-monthly="4299" data-annual="3499">₹3,499</span>
                            <span class="text-xs text-blue-900 font-semibold">/ month</span>
                        </div>
                        <div class="text-[11px] text-blue-600 font-semibold mt-1 billing-period-note">
                            Billed annually (₹41,988/yr)
                        </div>
                    </div>

                    <div class="text-xs font-bold text-black uppercase tracking-wider mb-3 flex items-center justify-between">
                        <span>Everything in Starter, Plus:</span>
                    </div>
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-extrabold text-black">Up to 100 Employees</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-semibold text-slate-900">QR Kiosk & Geofenced Attendance</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-semibold text-slate-900">Automated TDS & Yearly Bonus Engine</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-semibold text-slate-900">Sales CRM with Kanban Pipelines</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-semibold text-slate-900">Official WhatsApp Cloud Automated Alerts</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span class="font-semibold text-slate-900">GST E-Invoicing & PDF Quotations</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-600 text-sm"></i>
                            <span>Priority WhatsApp & Call Support (2h SLA)</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-5 border-t border-blue-100">
                    <button type="button" onclick="event.stopPropagation(); startPlanTrial('growth')" class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs text-center transition-all shadow-xl shadow-blue-500/25 active:scale-95 flex items-center justify-center gap-2">
                        <span>Start 14-Day Free Trial</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                    <span class="block text-center text-[10px] text-blue-600 font-bold mt-2">✦ Free Assisted Setup & Data Import ✦</span>
                </div>
            </div>

            <!-- Plan 3: Business -->
            <div id="card-business" 
                 onclick="selectPlanCard('business')"
                 onmousemove="handle3DTilt(event, this)" 
                 onmouseleave="reset3DTilt(this)"
                 class="pricing-interactive-card min-w-[290px] sm:min-w-[320px] lg:min-w-0 snap-center p-7 rounded-3xl bg-white border-2 border-slate-200 shadow-soft-elevation flex flex-col justify-between relative transition-all duration-300 hover:shadow-2xl overflow-hidden cursor-pointer group">
                
                <!-- Dynamic Luminous Sheen -->
                <div class="card-sheen pointer-events-none absolute -inset-full opacity-0 transition-opacity duration-300 bg-radial-gradient"></div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-500">Business</span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">Multi-Location</span>
                    </div>

                    <h3 class="text-2xl font-black text-black">Multi-Branch</h3>
                    <p class="text-xs text-slate-500 mt-1 min-h-[32px]">Built for retail chains, manufacturing plants, and multi-location firms.</p>
                    
                    <div class="my-6 p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-colors group-hover:bg-blue-50/40">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-black plan-price" data-monthly="8499" data-annual="6999">₹6,999</span>
                            <span class="text-xs text-slate-500 font-semibold">/ month</span>
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-1 billing-period-note">
                            Billed annually (₹83,988/yr)
                        </div>
                    </div>

                    <div class="text-xs font-bold text-black uppercase tracking-wider mb-3">Everything in Growth, Plus:</div>
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-bold text-black">Up to 250 Employees</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-semibold text-slate-900">Biometric Machine Sync (eSSL/ZKTeco)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-semibold text-slate-900">Multi-Branch & Shift Roster Control</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-semibold text-slate-900">Advanced Inventory & Ledger Sync</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-semibold text-slate-900">WhatsApp Green Tick Official Sender</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span class="font-semibold text-slate-900">Granular Role-Based Access Control (RBAC)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            <span>24/7 Dedicated Account Manager</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-5 border-t border-slate-100">
                    <button type="button" onclick="event.stopPropagation(); startPlanTrial('business')" class="w-full py-3.5 rounded-2xl border-2 border-slate-300 hover:border-blue-600 bg-white hover:bg-blue-50/50 text-black font-extrabold text-xs text-center transition-all shadow-sm active:scale-95 flex items-center justify-center gap-2">
                        <span>Deploy Business Plan</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                    <span class="block text-center text-[10px] text-slate-400 font-semibold mt-2">Hardware integration support included</span>
                </div>
            </div>

            <!-- Plan 4: Enterprise -->
            <div id="card-enterprise" 
                 onclick="selectPlanCard('enterprise')"
                 onmousemove="handle3DTilt(event, this)" 
                 onmouseleave="reset3DTilt(this)"
                 class="pricing-interactive-card min-w-[290px] sm:min-w-[320px] lg:min-w-0 snap-center p-7 rounded-3xl bg-slate-900 text-white border-2 border-slate-800 shadow-2xl flex flex-col justify-between relative transition-all duration-300 hover:shadow-2xl overflow-hidden cursor-pointer group">
                
                <!-- Dynamic Luminous Sheen -->
                <div class="card-sheen pointer-events-none absolute -inset-full opacity-0 transition-opacity duration-300 bg-radial-gradient"></div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black uppercase tracking-wider text-blue-400">Enterprise</span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300">Custom Suite</span>
                    </div>

                    <h3 class="text-2xl font-black text-white">Corporate</h3>
                    <p class="text-xs text-slate-400 mt-1 min-h-[32px]">Customized infrastructure, dedicated hosting, and enterprise-grade SLAs.</p>
                    
                    <div class="my-6 p-4 rounded-2xl bg-slate-800/80 border border-slate-700/80 transition-colors">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-white">Custom</span>
                            <span class="text-xs text-slate-400 font-medium">tailored pricing</span>
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-1">
                            Annual contracts • Custom billing terms
                        </div>
                    </div>

                    <div class="text-xs font-bold text-white uppercase tracking-wider mb-3">Enterprise Architecture:</div>
                    <ul class="space-y-3 text-xs text-slate-300">
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span class="font-bold text-white">Unlimited Employees & Branches</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span>Dedicated Cloud Database & Isolated VPC</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span>Custom SAP, Oracle & Tally Connectors</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span>White-label Portal & Custom Domain</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span>Dedicated Solution Architect & On-site Ops</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span class="font-bold text-white">99.98% Guaranteed Uptime SLA</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-blue-400 text-sm"></i>
                            <span>Annual Security Audits & ISO 27001</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-5 border-t border-slate-800">
                    <button type="button" onclick="event.stopPropagation(); startPlanTrial('enterprise')" class="w-full py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-black font-extrabold text-xs text-center transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                        <span>Talk to Enterprise Sales</span>
                        <i class="fa-solid fa-headset text-[10px]"></i>
                    </button>
                    <span class="block text-center text-[10px] text-slate-400 font-semibold mt-2">Custom MSA & SLA contracts</span>
                </div>
            </div>

        </div>

        <!-- Carousel Pagination Dots for Mobile/Swipe -->
        <div class="flex items-center justify-center gap-2 mt-4 lg:hidden">
            <button onclick="scrollToCardIndex(0)" class="carousel-dot w-6 h-2 rounded-full bg-slate-300 transition-all duration-300" aria-label="Starter Plan"></button>
            <button onclick="scrollToCardIndex(1)" class="carousel-dot w-6 h-2 rounded-full bg-blue-600 transition-all duration-300" aria-label="Growth Plan"></button>
            <button onclick="scrollToCardIndex(2)" class="carousel-dot w-6 h-2 rounded-full bg-slate-300 transition-all duration-300" aria-label="Business Plan"></button>
            <button onclick="scrollToCardIndex(3)" class="carousel-dot w-6 h-2 rounded-full bg-slate-300 transition-all duration-300" aria-label="Enterprise Plan"></button>
        </div>
    </div>

    <!-- Interactive Selected Plan Summary Banner (Sticky on interaction) -->
    <div id="selected-plan-banner" class="max-w-4xl mx-auto px-4 sm:px-6 mb-16 transition-all duration-500">
        <div class="p-5 sm:p-6 rounded-3xl bg-white border-2 border-blue-500/40 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center text-xl shrink-0">
                    <i id="selected-plan-icon" class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Your Active Selection</div>
                    <h4 id="selected-plan-name" class="text-lg font-black text-black">Growth Plan (Mid-Market)</h4>
                    <p id="selected-plan-desc" class="text-xs text-slate-500">Ideal for 26 - 100 staff with WhatsApp, CRM, and biometric integration.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="text-right hidden md:block">
                    <div id="selected-plan-price-display" class="text-xl font-black text-blue-700">₹3,499 / mo</div>
                    <div class="text-[10px] text-slate-400 font-semibold">+ GST applicable</div>
                </div>
                <button type="button" id="selected-plan-btn" onclick="openDemoModal()" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-lg shadow-blue-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span>Confirm & Start 14-Day Free Trial</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Interactive ROI & Cost-Savings Calculator -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 motion-reveal">
        <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-br from-slate-900 to-slate-950 text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Live ROI Calculator</span>
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        See how much time & money Hisab Mittra saves you.
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-400 leading-relaxed">
                        Manual Excel attendance, paper payslips, and compliance penalties cost Indian SMEs an average of ₹18,000+ per month in wasted overhead.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <div class="flex justify-between text-xs font-bold text-slate-300 mb-1.5">
                                <span>Total Employees:</span>
                                <span id="roi-emp-label" class="text-emerald-400 font-extrabold">50 Staff</span>
                            </div>
                            <input type="range" id="roi-emp-slider" min="10" max="300" step="5" value="50" oninput="calculateROI()" class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-bold text-slate-300 mb-1.5">
                                <span>HR Hours Spent on Payroll & Attendance/mo:</span>
                                <span id="roi-hours-label" class="text-emerald-400 font-extrabold">24 Hours</span>
                            </div>
                            <input type="range" id="roi-hours-slider" min="6" max="60" step="2" value="24" oninput="calculateROI()" class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm text-center">
                        <div class="text-slate-400 text-[11px] font-bold uppercase tracking-wider">Time Saved Monthly</div>
                        <div id="roi-time-saved" class="text-3xl font-black text-white mt-2">21 Hours</div>
                        <div class="text-[10px] text-emerald-400 font-bold mt-1">87% automation speedup</div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm text-center">
                        <div class="text-slate-400 text-[11px] font-bold uppercase tracking-wider">Estimated Savings</div>
                        <div id="roi-money-saved" class="text-3xl font-black text-emerald-400 mt-2">₹19,400</div>
                        <div class="text-[10px] text-slate-400 font-medium mt-1">In staff hours & penalties</div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm text-center">
                        <div class="text-slate-400 text-[11px] font-bold uppercase tracking-wider">Estimated ROI</div>
                        <div id="roi-multiplier" class="text-3xl font-black text-blue-400 mt-2">5.5x</div>
                        <div class="text-[10px] text-slate-400 font-medium mt-1">Software investment return</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comprehensive Capability Comparison Matrix with Categorized Accordions -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 motion-reveal">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                Side-by-Side Breakdown
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-black">Compare Full Platform Capabilities</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-xl mx-auto">
                Detailed feature matrix across Starter, Growth, Business, and Enterprise tiers.
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-soft-elevation overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left border-collapse">
                    <!-- Sticky Plan Headers -->
                    <thead class="bg-slate-50/90 backdrop-blur-sm border-b border-slate-200 text-slate-800 sticky top-0 z-20">
                        <tr>
                            <th class="p-4 sm:p-5 font-bold text-sm text-black w-2/5">Capabilities & Specifications</th>
                            <th class="p-4 sm:p-5 font-bold text-center w-[15%]">
                                <span class="block text-black font-extrabold text-sm">Starter</span>
                                <span class="text-[10px] text-slate-400 font-semibold">₹1,499/mo</span>
                            </th>
                            <th class="p-4 sm:p-5 font-bold text-center w-[15%] bg-blue-50/60 border-x border-blue-100">
                                <span class="block text-blue-700 font-extrabold text-sm">Growth 🔥</span>
                                <span class="text-[10px] text-blue-600 font-semibold">₹3,499/mo</span>
                            </th>
                            <th class="p-4 sm:p-5 font-bold text-center w-[15%]">
                                <span class="block text-black font-extrabold text-sm">Business</span>
                                <span class="text-[10px] text-slate-400 font-semibold">₹6,999/mo</span>
                            </th>
                            <th class="p-4 sm:p-5 font-bold text-center w-[15%]">
                                <span class="block text-black font-extrabold text-sm">Enterprise</span>
                                <span class="text-[10px] text-slate-400 font-semibold">Custom</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        
                        <!-- Category 1: Capacity & Infrastructure -->
                        <tr class="bg-slate-100/60 font-black text-black text-xs uppercase tracking-wider">
                            <td colspan="5" class="py-3 px-5 flex items-center gap-2">
                                <i class="fa-solid fa-server text-blue-600"></i>
                                <span>Core Capacity & Users</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Active Employee Limit</td>
                            <td class="p-4 text-center font-bold">Up to 25</td>
                            <td class="p-4 text-center font-black text-blue-700 bg-blue-50/30 border-x border-blue-100">Up to 100</td>
                            <td class="p-4 text-center font-bold">Up to 250</td>
                            <td class="p-4 text-center font-black text-emerald-600">Unlimited</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Branch / Office Locations</td>
                            <td class="p-4 text-center">1 Location</td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100">Up to 3 Branches</td>
                            <td class="p-4 text-center font-bold">Up to 15 Branches</td>
                            <td class="p-4 text-center font-black text-emerald-600">Unlimited</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Cloud Storage & Backups</td>
                            <td class="p-4 text-center">5 GB Cloud</td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100">25 GB Cloud</td>
                            <td class="p-4 text-center">100 GB Cloud</td>
                            <td class="p-4 text-center font-black text-emerald-600">Dedicated Instance</td>
                        </tr>

                        <!-- Category 2: Attendance & Time-Tracking -->
                        <tr class="bg-slate-100/60 font-black text-black text-xs uppercase tracking-wider">
                            <td colspan="5" class="py-3 px-5 flex items-center gap-2">
                                <i class="fa-solid fa-fingerprint text-blue-600"></i>
                                <span>Attendance & Geofencing</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Mobile Selfie Face Recognition</td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">GPS Radius Geofencing (100m - 500m)</td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Tablet & Front-Desk QR Kiosk Mode</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Biometric Machine Integration (eSSL/ZKTeco/Matrix)</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center text-slate-300 bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>

                        <!-- Category 3: Payroll & Indian Statutory Compliance -->
                        <tr class="bg-slate-100/60 font-black text-black text-xs uppercase tracking-wider">
                            <td colspan="5" class="py-3 px-5 flex items-center gap-2">
                                <i class="fa-solid fa-indian-rupee-sign text-blue-600"></i>
                                <span>Payroll & Indian Tax Compliance</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Automated EPF (12%) & ESIC (0.75%/3.25%) ECR Export</td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Professional Tax (PT) & State Compliance Rules</td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">TDS (Section 192) & Form 16 Part B Generation</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>

                        <!-- Category 4: CRM & WhatsApp Automation -->
                        <tr class="bg-slate-100/60 font-black text-black text-xs uppercase tracking-wider">
                            <td colspan="5" class="py-3 px-5 flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                <span>Sales Pipeline & WhatsApp Cloud API</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Visual Kanban Deal Pipeline CRM</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">WhatsApp Cloud API Automated Payslips & Lead Followups</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Official WhatsApp Business Green Tick Assistance</td>
                            <td class="p-4 text-center text-slate-300"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center text-slate-300 bg-blue-50/30 border-x border-blue-100"><i class="fa-solid fa-minus"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                            <td class="p-4 text-center"><i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i></td>
                        </tr>

                        <!-- Category 5: Support & SLA -->
                        <tr class="bg-slate-100/60 font-black text-black text-xs uppercase tracking-wider">
                            <td colspan="5" class="py-3 px-5 flex items-center gap-2">
                                <i class="fa-solid fa-headset text-blue-600"></i>
                                <span>Support & Security SLAs</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Support Channels</td>
                            <td class="p-4 text-center">Email (24h SLA)</td>
                            <td class="p-4 text-center font-bold text-blue-700 bg-blue-50/30 border-x border-blue-100">WhatsApp & Chat (2h SLA)</td>
                            <td class="p-4 text-center font-bold">24/7 Phone & Priority</td>
                            <td class="p-4 text-center font-black text-emerald-600">Dedicated Account Manager</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-black">Uptime SLA Guarantee</td>
                            <td class="p-4 text-center">99.5%</td>
                            <td class="p-4 text-center bg-blue-50/30 border-x border-blue-100">99.9%</td>
                            <td class="p-4 text-center font-bold">99.95%</td>
                            <td class="p-4 text-center font-black text-emerald-600">99.98% Financially Backed</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Trust Badges & Guarantee Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 motion-reveal">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-sm">
                <i class="fa-solid fa-lock text-2xl text-blue-600 mb-2"></i>
                <div class="text-xs font-bold text-black">AES-256 Encryption</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Bank-grade data security</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-sm">
                <i class="fa-solid fa-file-invoice text-2xl text-emerald-600 mb-2"></i>
                <div class="text-xs font-bold text-black">GST ITC Invoices</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Claim full 18% GST credit</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-sm">
                <i class="fa-solid fa-arrows-rotate text-2xl text-amber-500 mb-2"></i>
                <div class="text-xs font-bold text-black">Instant Data Migration</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Excel/Tally free import</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-sm">
                <i class="fa-solid fa-calendar-check text-2xl text-indigo-600 mb-2"></i>
                <div class="text-xs font-bold text-black">14 Days Risk-Free</div>
                <div class="text-[11px] text-slate-500 mt-0.5">No questions asked refund</div>
            </div>
        </div>
    </div>

    <!-- Frequently Asked Questions Accordion -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 motion-reveal">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-black">Frequently Asked Pricing Questions</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Everything you need to know about billing, onboarding, and subscription terms.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-all">
                <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left font-bold text-sm text-black flex items-center justify-between gap-4">
                    <span>Can I upgrade or downgrade my plan later?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    Yes, absolutely! You can upgrade your plan at any time as your workforce expands. Any unused balance on your current subscription will be prorated automatically and credited toward your new tier.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-all">
                <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left font-bold text-sm text-black flex items-center justify-between gap-4">
                    <span>Is there any setup fee or onboarding cost?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    No! There are zero hidden fees or setup charges. Our onboarding team provides full assistance including employee Excel master import, attendance policy setup, and biometric device configuration at no extra cost.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-all">
                <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left font-bold text-sm text-black flex items-center justify-between gap-4">
                    <span>How does WhatsApp Cloud API billing work?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    The software integration with Meta WhatsApp Cloud API is pre-included in Growth, Business, and Enterprise plans. Meta's standard utility message charges (approx ₹0.30 - ₹0.80 per conversation) are directly billed to your Meta Business Manager without any markup.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-all">
                <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left font-bold text-sm text-black flex items-center justify-between gap-4">
                    <span>Do you provide GST compliant tax invoices?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    Yes. During checkout or billing setup, enter your 15-digit GSTIN number. We automatically issue GST-compliant tax invoices so your enterprise can claim 100% Input Tax Credit (ITC).
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-all">
                <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left font-bold text-sm text-black flex items-center justify-between gap-4">
                    <span>What happens after the 14-day free trial ends?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    Your account remains intact with all your imported employees and historical data. You can choose to activate your preferred plan or contact our sales team. We do not automatically charge any credit cards.
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom High-Impact CTA Banner -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 motion-reveal">
        <div class="p-8 sm:p-12 rounded-3xl bg-blue-600 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="relative z-10 max-w-xl text-center md:text-left">
                <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                    Ready to digitize your workforce operations?
                </h3>
                <p class="mt-3 text-sm text-blue-100 leading-relaxed">
                    Join 1,200+ Indian manufacturers, healthcare clinics, retail chains, and corporate offices who trust Hisab Mittra daily.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs font-semibold text-blue-100">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-300"></i> 14-Day Free Trial</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-300"></i> Quick 15-Minute Setup</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-300"></i> Cancel Anytime</span>
                </div>
            </div>

            <div class="relative z-10 flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
                <button type="button" onclick="openDemoModal()" class="px-8 py-4 rounded-2xl bg-white hover:bg-slate-100 text-black font-extrabold text-sm shadow-xl active:scale-95 transition-all text-center">
                    Schedule Live Interactive Demo
                </button>
                <a href="tel:+919876543210" class="px-6 py-4 rounded-2xl bg-blue-700 hover:bg-blue-800 text-white font-extrabold text-sm border border-blue-400/40 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-phone"></i>
                    <span>+91 98765 43210</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    // =========================================================================
    // DYNAMIC MOTION & 3D TILT ENGINE FOR PRICING CARDS
    // =========================================================================
    let currentBilling = 'annual';
    let activePlanId = 'growth';

    // 3D Tilt calculation on mousemove
    function handle3DTilt(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        
        // Gentle tilt degrees max +/- 7deg
        const rotateX = ((centerY - y) / centerY) * 7;
        const rotateY = ((x - centerX) / centerX) * 7;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.025, 1.025, 1.025)`;
        
        // Dynamic sheen effect tracking cursor
        const sheen = card.querySelector('.card-sheen');
        if (sheen) {
            sheen.style.opacity = '1';
            sheen.style.background = `radial-gradient(circle 280px at ${x}px ${y}px, rgba(59, 130, 246, 0.15), transparent 70%)`;
        }
    }

    // Reset 3D Tilt on mouseleave
    function reset3DTilt(card) {
        // Retain standard transform
        if (card.id === 'card-growth' && window.innerWidth >= 1024) {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1) translateY(-12px)';
        } else {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        }
        
        const sheen = card.querySelector('.card-sheen');
        if (sheen) {
            sheen.style.opacity = '0';
        }
    }

    // =========================================================================
    // CARD CLICK SELECTION & FEEDBACK
    // =========================================================================
    const planMeta = {
        'starter': {
            name: 'Starter Plan (Small Teams)',
            desc: 'Best for 1-25 employees starting automated attendance and payroll.',
            icon: 'fa-rocket',
            priceMonthly: '₹1,899 / mo',
            priceAnnual: '₹1,499 / mo',
            badge: 'Starter Plan'
        },
        'growth': {
            name: 'Growth Plan (Mid-Market)',
            desc: 'Ideal for 26 - 100 staff with WhatsApp, CRM, and biometric kiosk.',
            icon: 'fa-crown',
            priceMonthly: '₹4,299 / mo',
            priceAnnual: '₹3,499 / mo',
            badge: 'Growth Plan (Recommended)'
        },
        'business': {
            name: 'Business Plan (Multi-Branch)',
            desc: 'Multi-location operations with physical hardware biometric sync.',
            icon: 'fa-building-shield',
            priceMonthly: '₹8,499 / mo',
            priceAnnual: '₹6,999 / mo',
            badge: 'Business Plan'
        },
        'enterprise': {
            name: 'Enterprise Corporate Suite',
            desc: 'Custom dedicated cloud, SAP integrations, and enterprise SLA.',
            icon: 'fa-shield-halved',
            priceMonthly: 'Custom Quote',
            priceAnnual: 'Custom Quote',
            badge: 'Enterprise Plan'
        }
    };

    function selectPlanCard(planId) {
        activePlanId = planId;
        const allCards = document.querySelectorAll('.pricing-interactive-card');
        
        allCards.forEach(c => {
            c.classList.remove('ring-4', 'ring-blue-600', 'border-blue-600');
            // Reset base styles
            if (c.id !== 'card-enterprise' && c.id !== 'card-growth') {
                c.classList.add('border-slate-200');
            }
        });

        const selectedCard = document.getElementById('card-' + planId);
        if (selectedCard) {
            // Spring click feedback bounce
            selectedCard.style.transform = 'scale(0.97)';
            setTimeout(() => {
                reset3DTilt(selectedCard);
            }, 150);

            selectedCard.classList.add('ring-4', 'ring-blue-600/30', 'border-blue-600');
        }

        // Update Selected Plan Banner
        const data = planMeta[planId];
        if (data) {
            document.getElementById('selected-plan-name').textContent = data.name;
            document.getElementById('selected-plan-desc').textContent = data.desc;
            document.getElementById('selected-plan-icon').className = 'fa-solid ' + data.icon;
            document.getElementById('selected-plan-price-display').textContent = currentBilling === 'annual' ? data.priceAnnual : data.priceMonthly;
            document.getElementById('selected-plan-btn').innerHTML = `<span>Select ${data.name.split(' ')[0]} Plan & Start Trial</span> <i class="fa-solid fa-arrow-right"></i>`;
        }
    }

    function startPlanTrial(planKey) {
        selectPlanCard(planKey);
        window.location.href = "{{ route('hisab.demo') }}?plan=" + encodeURIComponent(planKey) + "&billing=" + currentBilling;
    }

    // =========================================================================
    // BILLING TOGGLE (MONTHLY / ANNUAL) WITH NUMBER COUNT-UP
    // =========================================================================
    function setBilling(type) {
        currentBilling = type;
        const toggleMonthly = document.getElementById('toggle-monthly');
        const toggleAnnual = document.getElementById('toggle-annual');
        const priceEls = document.querySelectorAll('.plan-price');
        const noteEls = document.querySelectorAll('.billing-period-note');

        if (type === 'monthly') {
            toggleMonthly.className = "relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-blue-600 text-white shadow-md";
            toggleAnnual.className = "relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 hover:text-black flex items-center gap-2";
            
            noteEls.forEach(note => {
                note.textContent = "Billed monthly (Cancel anytime)";
            });

            priceEls.forEach(el => {
                const target = parseInt(el.getAttribute('data-monthly'), 10);
                if (!isNaN(target)) {
                    animateCountUp(el, target);
                }
            });
        } else {
            toggleAnnual.className = "relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-blue-600 text-white shadow-md flex items-center gap-2";
            toggleMonthly.className = "relative z-10 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 hover:text-black";
            
            noteEls[0].textContent = "Billed annually (₹17,988/yr)";
            noteEls[1].textContent = "Billed annually (₹41,988/yr)";
            noteEls[2].textContent = "Billed annually (₹83,988/yr)";

            priceEls.forEach(el => {
                const target = parseInt(el.getAttribute('data-annual'), 10);
                if (!isNaN(target)) {
                    animateCountUp(el, target);
                }
            });
        }

        // Update selected plan banner price
        const data = planMeta[activePlanId];
        if (data) {
            document.getElementById('selected-plan-price-display').textContent = currentBilling === 'annual' ? data.priceAnnual : data.priceMonthly;
        }
    }

    // Number count-up animation
    function animateCountUp(el, target) {
        const start = parseInt(el.textContent.replace(/[^\d]/g, ''), 10) || 0;
        const duration = 400;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(start + (target - start) * easeOut);
            el.textContent = '₹' + current.toLocaleString('en-IN');

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        requestAnimationFrame(update);
    }

    // =========================================================================
    // TEAM SIZE RECOMMENDER SLIDER
    // =========================================================================
    function onTeamSizeSlide(value) {
        document.getElementById('team-size-display').textContent = value + (value >= 350 ? '+ Employees' : ' Employees');
        const badge = document.getElementById('recommended-plan-badge');

        let targetPlan = 'growth';
        if (value <= 25) {
            targetPlan = 'starter';
            badge.innerHTML = `<span>Starter Plan (Small Teams)</span>`;
            badge.className = "font-extrabold text-emerald-700 bg-emerald-100/70 px-3 py-1 rounded-lg flex items-center gap-1.5 transition-all";
        } else if (value <= 100) {
            targetPlan = 'growth';
            badge.innerHTML = `<span>Growth Plan (Mid-Market)</span>`;
            badge.className = "font-extrabold text-blue-700 bg-blue-100/70 px-3 py-1 rounded-lg flex items-center gap-1.5 transition-all";
        } else if (value <= 250) {
            targetPlan = 'business';
            badge.innerHTML = `<span>Business Plan (Multi-Branch)</span>`;
            badge.className = "font-extrabold text-indigo-700 bg-indigo-100/70 px-3 py-1 rounded-lg flex items-center gap-1.5 transition-all";
        } else {
            targetPlan = 'enterprise';
            badge.innerHTML = `<span>Enterprise Corporate Suite</span>`;
            badge.className = "font-extrabold text-purple-700 bg-purple-100/70 px-3 py-1 rounded-lg flex items-center gap-1.5 transition-all";
        }

        selectPlanCard(targetPlan);
        
        // Scroll carousel to spotlight card on mobile/touch screens
        if (window.innerWidth < 1024) {
            const cardEl = document.getElementById('card-' + targetPlan);
            if (cardEl) {
                cardEl.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        }
    }

    // =========================================================================
    // HORIZONTAL SWIPE CAROUSEL ENGINE (Touch + Mouse Drag + Dots)
    // =========================================================================
    const carousel = document.getElementById('pricing-carousel');
    const dots = document.querySelectorAll('.carousel-dot');

    function scrollCarousel(direction) {
        if (!carousel) return;
        const scrollAmount = carousel.offsetWidth * 0.85;
        if (direction === 'left') {
            carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    function scrollToCardIndex(index) {
        const cards = carousel.querySelectorAll('.pricing-interactive-card');
        if (cards[index]) {
            cards[index].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    }

    // Update active dot on scroll
    if (carousel) {
        carousel.addEventListener('scroll', () => {
            const scrollLeft = carousel.scrollLeft;
            const cardWidth = carousel.querySelector('.pricing-interactive-card')?.offsetWidth || 300;
            const activeIndex = Math.min(3, Math.max(0, Math.round(scrollLeft / (cardWidth + 24))));

            dots.forEach((dot, idx) => {
                if (idx === activeIndex) {
                    dot.className = "carousel-dot w-6 h-2 rounded-full bg-blue-600 transition-all duration-300";
                } else {
                    dot.className = "carousel-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-300";
                }
            });
        }, { passive: true });

        // Desktop Mouse Click & Drag to Swipe
        let isDown = false;
        let startX;
        let scrollStartLeft;

        carousel.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - carousel.offsetLeft;
            scrollStartLeft = carousel.scrollLeft;
        });

        carousel.addEventListener('mouseleave', () => {
            isDown = false;
        });

        carousel.addEventListener('mouseup', () => {
            isDown = false;
        });

        carousel.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - carousel.offsetLeft;
            const walk = (x - startX) * 1.5; // Swipe sensitivity multiplier
            carousel.scrollLeft = scrollStartLeft - walk;
        });
    }

    // =========================================================================
    // ROI CALCULATOR ENGINE
    // =========================================================================
    function calculateROI() {
        const empCount = parseInt(document.getElementById('roi-emp-slider').value, 10);
        const hoursSpent = parseInt(document.getElementById('roi-hours-slider').value, 10);

        document.getElementById('roi-emp-label').textContent = empCount + ' Staff';
        document.getElementById('roi-hours-label').textContent = hoursSpent + ' Hours';

        // 85% of hours saved via automation
        const hoursSaved = Math.round(hoursSpent * 0.85);
        document.getElementById('roi-time-saved').textContent = hoursSaved + ' Hours';

        // Estimated hourly cost of HR ops & management = ₹450/hr
        // Plus approx ₹150/emp penalty prevention & leakages
        const moneySaved = Math.round((hoursSaved * 450) + (empCount * 120));
        document.getElementById('roi-money-saved').textContent = '₹' + moneySaved.toLocaleString('en-IN');

        // Growth plan baseline = ₹3,499
        const roiMult = (moneySaved / 3499).toFixed(1);
        document.getElementById('roi-multiplier').textContent = roiMult + 'x';
    }

    // =========================================================================
    // FAQ ACCORDION HANDLER
    // =========================================================================
    function toggleFaq(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('i');
        const isOpen = !content.classList.contains('hidden');

        // Close all other FAQs
        document.querySelectorAll('.border.border-slate-200 .hidden').forEach(c => {
            // Keep them closed
        });

        if (isOpen) {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        calculateROI();
        selectPlanCard('growth');
    });
</script>
@endsection
