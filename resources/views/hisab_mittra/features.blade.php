@extends('hisab_mittra.layouts.master')

@section('title', 'Platform Features & Enterprise Architecture — Hisab Mittra')
@section('meta_description', 'Explore the 6 integrated enterprise pillars of Hisab Mittra: Core HRM, Biometric Attendance, 1-Click Indian Payroll, Sales CRM, WhatsApp Business Automation, and GST Accounting.')

@section('content')
<div class="py-12 sm:py-20 bg-transparent">
    
    <!-- Hero / Architecture Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl mb-12 sm:mb-16">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-navy text-[12px] font-extrabold uppercase tracking-wider mb-4 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
            Enterprise Business OS Architecture
        </div>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy leading-[1.15]">
            Built for Scale. <br>
            <span class="font-sans not-italic font-extrabold text-black">Engineered for Indian Business.</span>
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto font-medium">
            Discover the six deeply integrated pillars powering modern business operations across India — from biometric attendance and automated payroll to CRM and GST accounting in one unified platform.
        </p>

        <!-- Trust Badges Bar -->
        <div class="mt-8 pt-6 border-t border-slate-200/80 grid grid-cols-2 md:grid-cols-4 gap-4 text-left">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/70 shadow-sm motion-reveal delay-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                    <i class="fa-solid fa-server"></i>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-black" data-counter="99.99%">99.99% Cloud SLA</div>
                    <div class="text-[11px] text-slate-500">Tier-IV Mumbai Datacenter</div>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/70 shadow-sm motion-reveal delay-200">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-black" data-counter="100%">100% Indian Statutory</div>
                    <div class="text-[11px] text-slate-500">EPFO, ESIC, TDS & GST Ready</div>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/70 shadow-sm motion-reveal delay-300">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-black" data-counter="256-Bit">256-Bit Encryption</div>
                    <div class="text-[11px] text-slate-500">ISO 27001 & SOC-2 Compliant</div>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/70 shadow-sm motion-reveal delay-400">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-black" data-counter="<50ms">&lt;50ms Response Speed</div>
                    <div class="text-[11px] text-slate-500">Real-Time Sync</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Jump Module Switcher Pill Bar (Sticky) -->
    <div class="sticky top-20 z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="p-2 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200 shadow-md flex items-center justify-start sm:justify-center gap-1.5 overflow-x-auto scrollbar-none">
            <a href="#module-hrm" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-users text-blue-600"></i> Core HRM
            </a>
            <a href="#module-attendance" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-fingerprint text-emerald-600"></i> Attendance
            </a>
            <a href="#module-payroll" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar text-indigo-600"></i> Payroll
            </a>
            <a href="#module-crm" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-600"></i> Sales CRM
            </a>
            <a href="#module-whatsapp" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp CRM
            </a>
            <a href="#module-accounting" class="module-nav-btn px-3.5 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all duration-200 text-slate-700 hover:text-black hover:bg-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-amber-600"></i> GST Accounting
            </a>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODULE 01: Core HRM & Employee Lifecycle -->
    <!-- ========================================================================= -->
    <section id="module-hrm" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-users"></i>
                    <span>PILLAR 01 &bull; CORE HRM</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    Complete Employee Lifecycle Management
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    From the day an offer letter is accepted to digital paperless onboarding, statutory KYC document verification, and exit settlement, Hisab Mittra maintains your organization's unified system of record.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm mb-2">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <strong class="block text-black font-extrabold text-sm mb-1">Aadhaar & PAN Vault</strong>
                        <span class="text-slate-600 leading-relaxed">Secure 256-bit encrypted statutory KYC document verification and vault.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm mb-2">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <strong class="block text-black font-extrabold text-sm mb-1">Custom Leave Slabs</strong>
                        <span class="text-slate-600 leading-relaxed">Earned, casual, sick, and maternity leaves with automated monthly accrual.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm mb-2">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <strong class="block text-black font-extrabold text-sm mb-1">Department Hierarchies</strong>
                        <span class="text-slate-600 leading-relaxed">Multi-tier manager approval chains for leaves, assets, and expense claims.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm mb-2">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <strong class="block text-black font-extrabold text-sm mb-1">Full & Final Settlement</strong>
                        <span class="text-slate-600 leading-relaxed">Automated gratuity calculation, notice period recovery, and auto no-dues.</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('hisab.hrm') }}" class="inline-flex items-center gap-2 text-sm font-extrabold text-blue-600 hover:text-blue-800 transition-colors">
                        <span>Explore Dedicated HRM Module</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Right Interactive Live Employee Directory Mockup -->
            <div class="lg:col-span-6">
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800 relative overflow-hidden">
                    
                    <!-- Widget Header with Live Search -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 border-b border-slate-800 pb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <h3 class="font-extrabold text-sm text-white">Employee Master Directory</h3>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Real-time sync with biometric & payroll roster</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] px-2.5 py-1 rounded-lg bg-blue-500/20 text-blue-400 font-bold border border-blue-500/30">
                                142 Active Staff
                            </span>
                        </div>
                    </div>

                    <!-- Search Filter Box -->
                    <div class="relative mb-4">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input type="text" id="employeeSearchInput" placeholder="Search by name, role or employee code..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Department Tabs Filter -->
                    <div class="flex items-center gap-2 mb-4 overflow-x-auto scrollbar-none pb-1">
                        <button onclick="filterEmployees('all')" class="emp-tab px-3 py-1 rounded-lg text-[11px] font-bold bg-blue-600 text-white transition-colors" data-dept="all">All (142)</button>
                        <button onclick="filterEmployees('Sales')" class="emp-tab px-3 py-1 rounded-lg text-[11px] font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-dept="Sales">Sales</button>
                        <button onclick="filterEmployees('Tech')" class="emp-tab px-3 py-1 rounded-lg text-[11px] font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-dept="Tech">Tech</button>
                        <button onclick="filterEmployees('HR')" class="emp-tab px-3 py-1 rounded-lg text-[11px] font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-dept="HR">HR & Admin</button>
                        <button onclick="filterEmployees('Accounts')" class="emp-tab px-3 py-1 rounded-lg text-[11px] font-bold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors" data-dept="Accounts">Accounts</button>
                    </div>

                    <!-- Dynamic Employee Cards -->
                    <div id="employeeList" class="space-y-2.5 text-xs max-h-[300px] overflow-y-auto pr-1">
                        
                        <!-- Row 1 -->
                        <div class="emp-item p-3.5 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex items-center justify-between hover:bg-slate-800 transition-colors" data-name="Rohit Sharma" data-dept="Sales">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-md">
                                    RS
                                </div>
                                <div>
                                    <div class="font-extrabold text-white text-xs flex items-center gap-2">
                                        <span>Rohit Sharma</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/20 text-blue-300 font-bold">EMP-001</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">Senior Sales Lead &bull; Gurgaon HQ</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                </span>
                                <div class="text-[10px] text-slate-400 mt-1">CTC: ₹12.5 LPA</div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="emp-item p-3.5 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex items-center justify-between hover:bg-slate-800 transition-colors" data-name="Pooja Kulkarni" data-dept="HR">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-600 text-white font-extrabold flex items-center justify-center text-xs shadow-md">
                                    PK
                                </div>
                                <div>
                                    <div class="font-extrabold text-white text-xs flex items-center gap-2">
                                        <span>Pooja Kulkarni</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-purple-500/20 text-purple-300 font-bold">EMP-004</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">People & Culture Lead &bull; Mumbai Hub</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                </span>
                                <div class="text-[10px] text-slate-400 mt-1">CTC: ₹9.8 LPA</div>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="emp-item p-3.5 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex items-center justify-between hover:bg-slate-800 transition-colors" data-name="Vikram Kumar" data-dept="Accounts">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-600 text-white font-extrabold flex items-center justify-center text-xs shadow-md">
                                    VK
                                </div>
                                <div>
                                    <div class="font-extrabold text-white text-xs flex items-center gap-2">
                                        <span>Vikram Kumar</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold">EMP-012</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">Accounts Specialist &bull; Delhi Office</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 text-[10px] px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-400 font-bold border border-amber-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> On Leave
                                </span>
                                <div class="text-[10px] text-slate-400 mt-1">CTC: ₹8.4 LPA</div>
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="emp-item p-3.5 rounded-2xl bg-slate-800/70 border border-slate-700/80 flex items-center justify-between hover:bg-slate-800 transition-colors" data-name="Aarav Sen" data-dept="Tech">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs shadow-md">
                                    AS
                                </div>
                                <div>
                                    <div class="font-extrabold text-white text-xs flex items-center gap-2">
                                        <span>Aarav Sen</span>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold">EMP-028</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">Full Stack Engineer &bull; Bengaluru</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 text-[10px] px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-400 font-bold border border-blue-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> On Probation
                                </span>
                                <div class="text-[10px] text-slate-400 mt-1">CTC: ₹14.0 LPA</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Live Status Metrics -->
                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Synced with EPFO & ESIC Portals</span>
                        <span class="text-emerald-400 font-bold">100% KYC Verified</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- MODULE 02: Touchless & Multi-Site Attendance (Smart Attendance) -->
    <!-- ========================================================================= -->
    <section id="module-attendance" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Interactive Biometric Kiosk Simulation -->
            <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
                    
                    <!-- Kiosk Screen Top Bar -->
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-400">AI Face Kiosk Online</span>
                        </div>
                        <div id="liveKioskClock" class="font-mono text-xs font-bold text-slate-300">
                            10:45:12 AM &bull; 01 Oct 2026
                        </div>
                    </div>

                    <!-- Face Scanning HUD Box -->
                    <div class="relative bg-slate-800/90 rounded-2xl p-5 border border-slate-700 text-center overflow-hidden mb-4">
                        <!-- Scanning Laser Line Animation -->
                        <div class="absolute inset-x-0 h-0.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent animate-pulse top-1/2"></div>
                        
                        <div class="relative w-24 h-24 mx-auto rounded-2xl border-2 border-emerald-400/80 p-1 flex items-center justify-center bg-slate-900/60 shadow-lg shadow-emerald-500/10 mb-3">
                            <!-- Reticle Corners -->
                            <div class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-emerald-400"></div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 border-t-2 border-r-2 border-emerald-400"></div>
                            <div class="absolute -bottom-1 -left-1 w-3 h-3 border-b-2 border-l-2 border-emerald-400"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-emerald-400"></div>
                            
                            <i class="fa-solid fa-user-check text-3xl text-emerald-400"></i>
                        </div>

                        <div class="font-extrabold text-sm text-white">Face Liveness Verified &bull; 99.8% Match</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Geofence: DLF CyberCity Gurgaon &bull; Anti-Proxy AI Active</div>

                        <!-- Interactive Punch Simulator Button -->
                        <div class="mt-4">
                            <button id="simulatePunchBtn" onclick="simulateLivePunch()" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-slate-950 font-extrabold text-xs shadow-lg shadow-emerald-500/20 transition-all inline-flex items-center gap-2">
                                <i class="fa-solid fa-fingerprint"></i>
                                <span>Simulate Instant Punch</span>
                            </button>
                        </div>
                    </div>

                    <!-- Recent Real-time Punches Stream -->
                    <div class="border-t border-slate-800 pt-3">
                        <div class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                            <span>Live Punch Stream</span>
                            <span class="text-emerald-400 font-bold">Today: 96.4% Present</span>
                        </div>

                        <div id="punchFeed" class="space-y-2 text-xs">
                            <div class="p-2.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[10px]">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-white text-[11px]">Rahul Verma (EMP-001)</div>
                                        <div class="text-[10px] text-slate-400">Face Kiosk &bull; Gurgaon Main Gate</div>
                                    </div>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold">09:28 AM &bull; On Time</span>
                            </div>

                            <div class="p-2.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-[10px]">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-white text-[11px]">Ananya Sen (EMP-019)</div>
                                        <div class="text-[10px] text-slate-400">Mobile GPS Selfie &bull; Mumbai BKC</div>
                                    </div>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-blue-500/20 text-blue-400 font-bold">09:32 AM &bull; In-Field</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Info Column -->
            <div class="lg:col-span-6 order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-fingerprint"></i>
                    <span>PILLAR 02 &bull; ZERO PROXY ATTENDANCE</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    Touchless & Multi-Site Attendance
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Manage multi-location branch shifts, lunch punches, grace periods, and late deductions automatically. Real-time sync with the payroll engine guarantees accurate salary generation with zero manual calculations.
                </p>

                <div class="space-y-3.5 mb-6 text-xs sm:text-sm text-black font-semibold">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Geofenced GPS Mobile Punch</strong>
                            <span class="text-slate-600 font-normal text-xs">Field staff punch in with selfie verification locked strictly within client coordinates.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">AI Facial Kiosk (Zero Hardware Lock-in)</strong>
                            <span class="text-slate-600 font-normal text-xs">Turn any ₹6,000 Android tablet or iPad into an ultra-fast touchless face recognition kiosk.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Auto Shift Roster & Night Allowances</strong>
                            <span class="text-slate-600 font-normal text-xs">Rotational 3-shift scheduling, automated overtime calculation, and grace period rules.</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 text-xs text-emerald-900 flex items-center justify-between">
                    <span class="font-extrabold">Hardware Compatibility:</span>
                    <span class="font-medium text-emerald-800">eSSL, Realtime, ZKTeco, Matrix, BioMax & RFID</span>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- MODULE 03: 1-Click Indian Payroll Engine (Payroll & Tax) -->
    <!-- ========================================================================= -->
    <section id="module-payroll" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>PILLAR 03 &bull; 100% STATUTORY PAYROLL</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    1-Click Indian Payroll Engine
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Hisab Mittra is coded natively for India's complex statutory ecosystem. Automatically calculate employer and employee contributions, state-wise professional tax, and income tax TDS Section 192 with instant bank batch payments.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-indigo-700 font-extrabold text-sm mb-1">EPFO & ESIC Auto-ECR</strong>
                        <span class="text-slate-600 leading-relaxed">Generates government portal compliant text ECR upload files in a single click.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-indigo-700 font-extrabold text-sm mb-1">TDS Section 192</strong>
                        <span class="text-slate-600 leading-relaxed">Old vs New tax regime comparison, declaration proofs, and automated Form 16 Part B.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-indigo-700 font-extrabold text-sm mb-1">State-wise PT Slabs</strong>
                        <span class="text-slate-600 leading-relaxed">Built-in rules for MH, DL, KA, TN, WB, and all states with automated ceiling limits.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-indigo-700 font-extrabold text-sm mb-1">Direct Bank API Payout</strong>
                        <span class="text-slate-600 leading-relaxed">Integrated with HDFC, ICICI, SBI, and Axis Bank for automated salary transfers.</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs font-extrabold text-slate-500">
                    <i class="fa-solid fa-lock text-slate-400"></i>
                    <span>Encrypted salary disbursements with multi-signatory OTP authorization</span>
                </div>
            </div>

            <!-- Right Interactive Dynamic Salary Calculator -->
            <div class="lg:col-span-6">
                <div class="p-6 sm:p-7 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
                    
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Interactive CTC & Pay Slip Engine</h3>
                            <p class="text-[11px] text-slate-400">Move the slider to simulate instant salary calculation</p>
                        </div>
                        <span class="text-[11px] px-2.5 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 font-bold border border-indigo-500/30">
                            FY 2026-27 Slabs
                        </span>
                    </div>

                    <!-- Interactive Gross Salary Range Slider -->
                    <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700 mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-300">Monthly Gross Salary:</span>
                            <span id="sliderGrossDisplay" class="text-lg font-extrabold text-emerald-400">₹80,000</span>
                        </div>
                        <input type="range" id="grossSalarySlider" min="25000" max="250000" step="5000" value="80000" oninput="calculateSalary(this.value)" class="w-full accent-emerald-500 cursor-pointer">
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                            <span>₹25,000</span>
                            <span>₹1,00,000</span>
                            <span>₹2,50,000</span>
                        </div>
                    </div>

                    <!-- Breakdown Table -->
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-800">
                            <span class="text-slate-300">Basic Salary (50%)</span>
                            <span id="basicSalaryVal" class="font-bold text-white">₹40,000</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-800">
                            <span class="text-slate-300">HRA Allowance (25%)</span>
                            <span id="hraSalaryVal" class="font-bold text-white">₹20,000</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-800">
                            <span class="text-slate-300">Special & Performance Allowance</span>
                            <span id="specialSalaryVal" class="font-bold text-white">₹20,000</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-800 text-rose-400">
                            <span>Employee PF Contribution (12% capped)</span>
                            <span id="pfDeductionVal" class="font-bold">-₹1,800</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-800 text-rose-400">
                            <span>Professional Tax (PT)</span>
                            <span id="ptDeductionVal" class="font-bold">-₹200</span>
                        </div>
                        <div class="flex justify-between pt-3 pb-1 text-sm font-extrabold border-t-2 border-slate-700">
                            <span class="text-white">Net Take-Home Salary:</span>
                            <span id="netSalaryVal" class="text-base text-emerald-400 font-extrabold">₹78,000</span>
                        </div>
                    </div>

                    <!-- Live Bank Payout Status -->
                    <div class="mt-5 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px]">
                        <span class="text-slate-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-building-columns text-indigo-400"></i> HDFC Direct Banking API
                        </span>
                        <span class="text-emerald-400 font-bold">1-Click Batch Payout Ready</span>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- MODULE 04: Sales CRM & Visual Deal Pipeline -->
    <!-- ========================================================================= -->
    <section id="module-crm" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Interactive Kanban Board Preview -->
            <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
                    
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Interactive Deal Pipeline Kanban</h3>
                            <p class="text-[11px] text-slate-400">Active pipeline volume: ₹62.4 Lakhs</p>
                        </div>
                        <span class="text-[11px] px-2.5 py-1 rounded-lg bg-blue-500/20 text-blue-300 font-bold border border-blue-500/30">
                            Quarter Q3 Forecast
                        </span>
                    </div>

                    <!-- Kanban Columns Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                        
                        <!-- Column 1: Qualified Leads -->
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-[11px] text-blue-400 uppercase">Qualified (3)</span>
                                <span class="text-[10px] text-slate-400">₹18.5L</span>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-blue-400 transition-colors cursor-pointer">
                                    <div class="font-extrabold text-white text-xs">Zenith Health</div>
                                    <div class="text-[11px] text-emerald-400 font-bold mt-0.5">₹8.5 Lakhs</div>
                                    <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-800 text-[10px] text-slate-400">
                                        <span>70% Win Prob</span>
                                        <span class="text-blue-400 font-bold">Proposal</span>
                                    </div>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-blue-400 transition-colors cursor-pointer">
                                    <div class="font-extrabold text-white text-xs">Apex Logistics</div>
                                    <div class="text-[11px] text-emerald-400 font-bold mt-0.5">₹10.0 Lakhs</div>
                                    <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-800 text-[10px] text-slate-400">
                                        <span>50% Win Prob</span>
                                        <span class="text-slate-300 font-bold">Demo Given</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Negotiation -->
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-[11px] text-amber-400 uppercase">Negotiation (2)</span>
                                <span class="text-[10px] text-slate-400">₹26.4L</span>
                            </div>

                            <div class="space-y-2">
                                <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-amber-400 transition-colors cursor-pointer">
                                    <div class="font-extrabold text-white text-xs">Kapoor Steels</div>
                                    <div class="text-[11px] text-emerald-400 font-bold mt-0.5">₹12.4 Lakhs</div>
                                    <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-800 text-[10px] text-slate-400">
                                        <span>85% Win Prob</span>
                                        <span class="text-amber-400 font-bold">Quote v3</span>
                                    </div>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-amber-400 transition-colors cursor-pointer">
                                    <div class="font-extrabold text-white text-xs">Bharat Retail Co</div>
                                    <div class="text-[11px] text-emerald-400 font-bold mt-0.5">₹14.0 Lakhs</div>
                                    <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-800 text-[10px] text-slate-400">
                                        <span>90% Win Prob</span>
                                        <span class="text-amber-400 font-bold">Final Review</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Won / Closed -->
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-[11px] text-emerald-400 uppercase">Won Deals (1)</span>
                                <span class="text-[10px] text-slate-400">₹17.5L</span>
                            </div>

                            <div class="p-2.5 rounded-xl bg-slate-900 border border-emerald-500/50 hover:border-emerald-400 transition-colors cursor-pointer">
                                <div class="font-extrabold text-white text-xs">Tata Motors Dealer</div>
                                <div class="text-[11px] text-emerald-400 font-bold mt-0.5">₹17.5 Lakhs</div>
                                <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-800 text-[10px] text-slate-400">
                                    <span class="text-emerald-400 font-extrabold">100% WON</span>
                                    <span class="text-slate-300 font-bold">PO Received</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Follow-up Reminder Alert -->
                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-bell text-amber-400"></i> Next follow-up: Kapoor Steels today at 04:00 PM
                        </span>
                        <span class="text-blue-400 font-bold">Auto Reminders Active</span>
                    </div>

                </div>
            </div>

            <!-- Right Info Column -->
            <div class="lg:col-span-6 order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>PILLAR 04 &bull; HIGH-VELOCITY SALES CRM</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    Sales CRM & Visual Deal Pipeline
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Consolidate marketing channels, capture qualified leads automatically from your website and social campaigns, and track deal stages across your entire sales team with automated WhatsApp and email follow-up reminders.
                </p>

                <div class="space-y-3.5 mb-6 text-xs sm:text-sm text-black font-semibold">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Multi-Channel Lead Ingestion</strong>
                            <span class="text-slate-600 font-normal text-xs">Auto-capture from Meta Ads, Google Ads, IndiaMART, TradeIndia, and your website.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Round-Robin Lead Assignment</strong>
                            <span class="text-slate-600 font-normal text-xs">Equitable automatic lead routing to sales representatives based on deal size and territory.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Pipeline Velocity & Forecasting</strong>
                            <span class="text-slate-600 font-normal text-xs">Track bottlenecks, average closing time per stage, and project accurate quarterly cash inflow.</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('hisab.crm') }}" class="inline-flex items-center gap-2 text-sm font-extrabold text-blue-600 hover:text-blue-800 transition-colors">
                        <span>Explore Full CRM Capabilities</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- MODULE 05: WhatsApp CRM & Automated Broadcasts (NEW COMPLETE PILLAR) -->
    <!-- ========================================================================= -->
    <section id="module-whatsapp" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-extrabold mb-3">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>PILLAR 05 &bull; OFFICIAL META CLOUD API</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    WhatsApp CRM & Automated Broadcasts
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Engage your clients and employees on India's #1 communication platform. Execute high-conversion broadcast marketing campaigns, deploy AI auto-reply support bots, and send automated salary slips and attendance alerts directly to WhatsApp.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-emerald-700 font-extrabold text-sm mb-1">Official Meta Green Tick</strong>
                        <span class="text-slate-600 leading-relaxed">Direct WhatsApp Cloud API integration with verified brand identity & zero ban risk.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-emerald-700 font-extrabold text-sm mb-1">1-Click Broadcasts (98% Open)</strong>
                        <span class="text-slate-600 leading-relaxed">Broadcast festival offers, product catalogs, and payment reminders with CTA buttons.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-emerald-700 font-extrabold text-sm mb-1">24/7 AI Smart Bot</strong>
                        <span class="text-slate-600 leading-relaxed">Instant replies to pricing inquiries, brochure downloads, and live meeting scheduling.</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <strong class="block text-emerald-700 font-extrabold text-sm mb-1">Automated HR Delivery</strong>
                        <span class="text-slate-600 leading-relaxed">Instant monthly payslip PDFs and punch-in confirmation messages to employee phones.</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3.5 py-2 rounded-xl border border-emerald-200/80 inline-flex">
                    <i class="fa-solid fa-check-double text-emerald-600"></i>
                    <span>Over 98% average message open rate across Indian corporate campaigns</span>
                </div>
            </div>

            <!-- Right Interactive WhatsApp Phone Simulation Widget -->
            <div class="lg:col-span-6">
                <div class="max-w-md mx-auto rounded-3xl bg-slate-900 border-4 border-slate-800 shadow-2xl overflow-hidden text-slate-900 font-sans">
                    
                    <!-- WhatsApp Top Header -->
                    <div class="bg-[#075E54] text-white p-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-emerald-800 flex items-center justify-center font-bold text-xs text-white shadow">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                            </div>
                            <div>
                                <div class="font-extrabold text-xs flex items-center gap-1.5">
                                    <span>Hisab Mittra Enterprise</span>
                                    <i class="fa-solid fa-circle-check text-[11px] text-emerald-300"></i>
                                </div>
                                <div class="text-[10px] text-emerald-100 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online &bull; Verified Business
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-white text-xs">
                            <i class="fa-solid fa-video cursor-pointer"></i>
                            <i class="fa-solid fa-phone cursor-pointer"></i>
                            <i class="fa-solid fa-ellipsis-vertical cursor-pointer"></i>
                        </div>
                    </div>

                    <!-- Chat Message Area -->
                    <div class="bg-[#ECE5DD] p-4 space-y-3 min-h-[310px] text-xs">
                        
                        <!-- Incoming Client Message -->
                        <div class="flex justify-start">
                            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] border border-slate-200/60">
                                <p class="text-slate-800 font-medium">Hello, we run 3 retail stores in Pune with 85 employees. Can we see a live demo of your Biometric Attendance & Payroll?</p>
                                <span class="text-[9px] text-slate-400 block text-right mt-1">10:14 AM</span>
                            </div>
                        </div>

                        <!-- Auto-Reply Message with Interactive Buttons -->
                        <div class="flex justify-end">
                            <div class="bg-[#DCF8C6] p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[90%] border border-emerald-200/60">
                                <p class="text-slate-900 font-semibold">Namaste! 🙏 Welcome to Hisab Mittra. We'd love to show you the platform in action!</p>
                                <p class="text-slate-700 text-[11px] mt-1.5">Please tap an option below to proceed instantly:</p>
                                
                                <div class="mt-2.5 space-y-1.5">
                                    <button class="w-full py-1.5 px-3 rounded-lg bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold text-[11px] text-center border border-emerald-300 transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <i class="fa-regular fa-calendar-check"></i> Book 15-Min Live Demo
                                    </button>
                                    <button class="w-full py-1.5 px-3 rounded-lg bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold text-[11px] text-center border border-emerald-300 transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <i class="fa-regular fa-file-pdf"></i> Download Features & Pricing PDF
                                    </button>
                                </div>
                                <span class="text-[9px] text-slate-500 block text-right mt-1">10:14 AM &bull; <i class="fa-solid fa-check-double text-blue-600"></i></span>
                            </div>
                        </div>

                        <!-- Automated HR Payslip Delivery -->
                        <div class="flex justify-end">
                            <div class="bg-[#DCF8C6] p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[90%] border border-emerald-200/60">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <i class="fa-solid fa-receipt text-emerald-700 text-sm"></i>
                                    <span class="font-extrabold text-slate-900 text-[11px]">Salary Slip Generated</span>
                                </div>
                                <p class="text-slate-700 text-[11px]">Dear Rahul, your monthly pay slip for September 2026 is attached below.</p>
                                <div class="mt-2 p-2 rounded-xl bg-white/90 border border-slate-200 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-file-pdf text-rose-600 text-base"></i>
                                        <div class="text-[10px] font-bold text-slate-800">PaySlip_Sep26_RS001.pdf</div>
                                    </div>
                                    <i class="fa-solid fa-download text-emerald-700 text-xs"></i>
                                </div>
                                <span class="text-[9px] text-slate-500 block text-right mt-1">10:15 AM &bull; <i class="fa-solid fa-check-double text-blue-600"></i></span>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Chat Bar -->
                    <div class="bg-slate-100 p-2.5 flex items-center gap-2 border-t border-slate-200 text-slate-500 text-xs">
                        <i class="fa-regular fa-face-smile cursor-pointer"></i>
                        <input type="text" disabled placeholder="Type a message..." class="w-full px-3 py-1.5 rounded-full bg-white text-[11px] border border-slate-200">
                        <i class="fa-solid fa-microphone cursor-pointer"></i>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- MODULE 06: GST Invoicing, Accounting & Inventory (NEW COMPLETE PILLAR) -->
    <!-- ========================================================================= -->
    <section id="module-accounting" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 scroll-mt-32">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Interactive GST Invoice Card -->
            <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
                    
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Live GST Tax Invoice Preview</h3>
                            <p class="text-[11px] text-slate-400">IRN & E-Way Bill Ready with Dynamic UPI QR</p>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                            IRN Verified
                        </span>
                    </div>

                    <!-- Realistic Invoice Box -->
                    <div class="bg-slate-800/90 rounded-2xl p-4 border border-slate-700 text-xs space-y-3">
                        <div class="flex justify-between items-start border-b border-slate-700/80 pb-2.5">
                            <div>
                                <div class="font-extrabold text-white text-xs">Hisab Mittra Cloud Solutions Pvt Ltd</div>
                                <div class="text-[10px] text-slate-400">GSTIN: 07AAACH7409R1ZZ &bull; State: 07-Delhi</div>
                            </div>
                            <div class="text-right">
                                <div class="text-emerald-400 font-extrabold text-xs">INV-2026-0891</div>
                                <div class="text-[10px] text-slate-400">Date: 01 Oct 2026</div>
                            </div>
                        </div>

                        <!-- Itemized Table -->
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-slate-300 font-medium">
                                <span>1. Enterprise Business OS License (Annual)</span>
                                <span class="font-bold text-white">₹75,000</span>
                            </div>
                            <div class="text-[10px] text-slate-500">HSN/SAC: 998313 &bull; Qty: 1 &bull; Rate: ₹75,000</div>

                            <div class="flex justify-between text-slate-300 font-medium pt-1">
                                <span>2. AI Face Kiosk Device (Touch Terminal)</span>
                                <span class="font-bold text-white">₹10,000</span>
                            </div>
                            <div class="text-[10px] text-slate-500">HSN/SAC: 847130 &bull; Qty: 2 &bull; Rate: ₹5,000</div>
                        </div>

                        <!-- Tax Calculation Summary -->
                        <div class="border-t border-slate-700/80 pt-2 space-y-1">
                            <div class="flex justify-between text-slate-400 text-[11px]">
                                <span>Taxable Subtotal:</span>
                                <span class="font-bold text-white">₹85,000</span>
                            </div>
                            <div class="flex justify-between text-slate-400 text-[11px]">
                                <span>CGST @ 9%:</span>
                                <span class="font-bold text-white">₹7,650</span>
                            </div>
                            <div class="flex justify-between text-slate-400 text-[11px]">
                                <span>SGST @ 9%:</span>
                                <span class="font-bold text-white">₹7,650</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-700 pt-2 text-sm font-extrabold text-white">
                                <span>Total Invoice Amount:</span>
                                <span class="text-emerald-400 font-extrabold">₹1,00,300</span>
                            </div>
                        </div>

                        <!-- QR Code & Instant UPI Pay Bar -->
                        <div class="mt-3 p-2.5 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-lg bg-white p-1 flex items-center justify-center">
                                    <i class="fa-solid fa-qrcode text-slate-900 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-white">Scan with any UPI App</div>
                                    <div class="text-[10px] text-slate-400">GPay, PhonePe, Paytm, BHIM</div>
                                </div>
                            </div>
                            <button class="px-3 py-1.5 rounded-lg bg-emerald-500 text-slate-950 font-bold text-[10px]">
                                Pay Now
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Direct Sync with GSTN Govt. Portal</span>
                        <span class="text-emerald-400 font-bold">Auto GSTR-1 & 3B Ready</span>
                    </div>

                </div>
            </div>

            <!-- Right Info Column -->
            <div class="lg:col-span-6 order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>PILLAR 06 &bull; GST ACCOUNTING & INVENTORY</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    GST Invoicing, Accounting & Inventory
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Complete financial and inventory control engineered for Indian accounting requirements. Generate professional GST e-invoices, track multi-location warehouse stock, and automate monthly tax reconciliations.
                </p>

                <div class="space-y-3.5 mb-6 text-xs sm:text-sm text-black font-semibold">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Instant E-Invoice & E-Way Bill Generation</strong>
                            <span class="text-slate-600 font-normal text-xs">Direct API handshake with the Govt. IRP portal creates valid IRN barcodes in under 2 seconds.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Multi-Warehouse Inventory Control</strong>
                            <span class="text-slate-600 font-normal text-xs">Track SKU stock movements, batch expiry numbers, minimum stock alert triggers, and inter-godown transfers.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Automated GSTR-1 & 3B Reconciliation</strong>
                            <span class="text-slate-600 font-normal text-xs">Auto-match purchase invoices with GSTR-2B to maximize input tax credit (ITC) and prevent financial leakage.</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-xs text-amber-900 flex items-center justify-between">
                    <span class="font-extrabold">Supported Payment Gateways:</span>
                    <span class="font-medium text-amber-800">Razorpay, Cashfree, UPI QR, NEFT/RTGS & POS</span>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- Bottom High-Impact Enterprise CTA Section -->
    <!-- ========================================================================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-8">
        <div class="p-8 sm:p-14 rounded-3xl bg-slate-900 text-white text-center shadow-2xl relative overflow-hidden border border-slate-800">
            
            <div class="relative z-10 max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4 border border-blue-500/30">
                    <i class="fa-solid fa-rocket"></i> Ready to Modernize Your Operations?
                </span>
                
                <h3 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Deploy India's Most Powerful Business OS Today.
                </h3>
                
                <p class="mt-4 text-sm sm:text-base text-slate-300 leading-relaxed font-medium">
                    Join over 4,500+ Indian enterprises running HR, biometric attendance, statutory payroll, sales CRM, and GST billing on Hisab Mittra.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('hisab.demo') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold text-sm shadow-xl shadow-blue-600/30 transition-all flex items-center justify-center gap-2.5">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Book a 1-on-1 Guided Demo</span>
                    </a>
                    
                    <a href="{{ route('hisab.pricing') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 active:scale-95 text-white font-extrabold text-sm border border-white/20 transition-all flex items-center justify-center gap-2.5">
                        <span>View All Transparent Pricing Plans</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="mt-6 flex items-center justify-center gap-6 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> No credit card required</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> 14-day full feature trial</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Free data migration</span>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Vanilla Dynamic Interactions Script -->
<script>
    // 1. Live Kiosk Clock Updater
    function updateKioskClock() {
        const clockEl = document.getElementById('liveKioskClock');
        if (!clockEl) return;
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
        const dateStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        clockEl.innerHTML = `${timeStr} &bull; ${dateStr}`;
    }
    setInterval(updateKioskClock, 1000);
    updateKioskClock();

    // 2. Interactive Punch Simulator
    const samplePunchNames = ['Suresh Nair', 'Meenakshi Iyer', 'Deepak Verma', 'Kavita Joshi', 'Amitabh Roy'];
    const sampleDepts = ['Tech', 'Operations', 'Finance', 'Logistics', 'Marketing'];
    let punchIndex = 0;

    function simulateLivePunch() {
        const feed = document.getElementById('punchFeed');
        if (!feed) return;

        const name = samplePunchNames[punchIndex % samplePunchNames.length];
        const dept = sampleDepts[punchIndex % sampleDepts.length];
        punchIndex++;

        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

        const newPunch = document.createElement('div');
        newPunch.className = 'p-2.5 rounded-xl bg-emerald-950/60 border border-emerald-500/80 flex items-center justify-between transition-all duration-300 transform scale-95 opacity-0';
        newPunch.innerHTML = `
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-emerald-500 text-slate-950 flex items-center justify-center font-bold text-[10px]">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <div class="font-extrabold text-white text-[11px]">${name} (${dept})</div>
                    <div class="text-[10px] text-emerald-300">Face Verified &bull; DLF CyberCity Gate 1</div>
                </div>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500 text-slate-950 font-extrabold animate-pulse">${timeStr} &bull; Just Now</span>
        `;

        feed.insertBefore(newPunch, feed.firstChild);

        // Animate entrance
        requestAnimationFrame(() => {
            newPunch.classList.remove('scale-95', 'opacity-0');
            newPunch.classList.add('scale-100', 'opacity-100');
        });

        // Limit feed items to 3
        if (feed.children.length > 3) {
            feed.removeChild(feed.lastChild);
        }
    }

    // 3. Dynamic Salary Engine Calculator
    function calculateSalary(grossVal) {
        const gross = parseFloat(grossVal) || 80000;
        
        // Slabs calculation
        const basic = Math.round(gross * 0.50);
        const hra = Math.round(gross * 0.25);
        const special = Math.round(gross - basic - hra);
        
        // Employee PF: 12% of basic, capped at 1800 if basic > 15000
        const pf = Math.min(1800, Math.round(basic * 0.12));
        const pt = 200; // standard state PT
        
        const net = gross - pf - pt;

        // Update displays
        document.getElementById('sliderGrossDisplay').textContent = '₹' + gross.toLocaleString('en-IN');
        document.getElementById('basicSalaryVal').textContent = '₹' + basic.toLocaleString('en-IN');
        document.getElementById('hraSalaryVal').textContent = '₹' + hra.toLocaleString('en-IN');
        document.getElementById('specialSalaryVal').textContent = '₹' + special.toLocaleString('en-IN');
        document.getElementById('pfDeductionVal').textContent = '-₹' + pf.toLocaleString('en-IN');
        document.getElementById('ptDeductionVal').textContent = '-₹' + pt.toLocaleString('en-IN');
        document.getElementById('netSalaryVal').textContent = '₹' + net.toLocaleString('en-IN');
    }

    // 4. Live Employee Directory Filter & Search
    function filterEmployees(dept) {
        const tabs = document.querySelectorAll('.emp-tab');
        tabs.forEach(t => {
            if (t.getAttribute('data-dept') === dept) {
                t.classList.remove('bg-slate-800', 'text-slate-300');
                t.classList.add('bg-blue-600', 'text-white');
            } else {
                t.classList.remove('bg-blue-600', 'text-white');
                t.classList.add('bg-slate-800', 'text-slate-300');
            }
        });

        const items = document.querySelectorAll('.emp-item');
        items.forEach(item => {
            const itemDept = item.getAttribute('data-dept');
            if (dept === 'all' || itemDept === dept) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.getElementById('employeeSearchInput')?.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        const items = document.querySelectorAll('.emp-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name')?.toLowerCase() || '';
            const dept = item.getAttribute('data-dept')?.toLowerCase() || '';
            if (name.includes(query) || dept.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endsection
