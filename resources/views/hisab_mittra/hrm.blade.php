@extends('hisab_mittra.layouts.master')

@section('title', 'HRM & Smart Attendance Operating System — Hisab Mittra')
@section('meta_description', 'India’s most advanced HR operating system: AI Face Recognition, GPS Geofenced Mobile Punch, Shift Roster, and 100% Compliant Indian Statutory Payroll (EPFO, ESIC, TDS).')

@section('content')
<div class="py-12 sm:py-20 bg-transparent">

    <!-- ========================================================================= -->
    <!-- 1. HERO SECTION -->
    <!-- ========================================================================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl mb-16 sm:mb-20">
        
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-navy text-[12px] font-extrabold uppercase tracking-wider mb-4 shadow-sm motion-fade-in">
            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
            Next-Gen Indian HR & Payroll Architecture
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy leading-[1.15] motion-reveal">
            The Modern HR Operating System for <br>
            <span class="font-sans not-italic font-extrabold text-black">Indian Enterprises & Fast-Growing Teams</span>
        </h1>
        
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-3xl mx-auto font-medium motion-reveal delay-100">
            Eliminate proxy attendance, chaotic WhatsApp leave requests, and complex PF/ESIC penalties. Unify paperless onboarding, touchless biometric attendance, automated shift rosters, and 100% compliant Indian payroll.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 motion-reveal delay-200">
            <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold text-sm shadow-xl shadow-blue-600/30 transition-all flex items-center justify-center gap-2.5">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Schedule Live HRM Walkthrough</span>
            </button>
            
            <a href="{{ route('crm.login') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-100 text-black font-extrabold text-sm border border-slate-200 shadow-sm transition-all flex items-center justify-center gap-2.5 hover:border-slate-300">
                <i class="fa-solid fa-lock text-blue-600"></i>
                <span>Admin HRM Portal Login &rarr;</span>
            </a>
        </div>

        <!-- Real-time Live Stats Counter Strip -->
        <div class="mt-12 p-4 rounded-2xl bg-white border border-slate-200 shadow-lg grid grid-cols-2 md:grid-cols-4 gap-4 text-left motion-reveal delay-300">
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="145,000+">145,000+</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Daily Punches Verified</div>
                <div class="text-[11px] text-slate-500">Zero proxy error rate</div>
            </div>
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="99.4%">99.4%</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">On-Time Attendance</div>
                <div class="text-[11px] text-slate-500">Auto grace period logic</div>
            </div>
            <div class="p-3 border-r border-slate-100 last:border-none">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="₹480 Cr+">₹480 Cr+</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Statutory Payroll Processed</div>
                <div class="text-[11px] text-slate-500">EPFO & ESIC auto-filed</div>
            </div>
            <div class="p-3">
                <div class="text-2xl sm:text-3xl font-extrabold text-black" data-counter="100%">100%</div>
                <div class="text-xs font-bold text-slate-800 mt-0.5">Indian Labour Law Ready</div>
                <div class="text-[11px] text-slate-500">All 28 state PT slabs</div>
            </div>
        </div>

    </div>


    <!-- ========================================================================= -->
    <!-- 2. INTERACTIVE ATTENDANCE MODES SIMULATOR (DYNAMIC TAB SYSTEM) -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold mb-2 border border-emerald-200">
                <i class="fa-solid fa-fingerprint"></i> ZERO PROXY TRACKING
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-black tracking-tight">
                4 Flexible Ways to Mark Attendance
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 font-medium">
                Configure tailored attendance capture policies across headquarters, retail store networks, manufacturing plants, and mobile field forces.
            </p>
        </div>

        <!-- Interactive Mode Switcher Tabs -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            
            <button onclick="switchAttendanceMode('face')" id="tab-btn-face" class="mode-tab-btn p-4 rounded-2xl bg-white border-2 border-blue-600 shadow-md text-left transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold border border-blue-200">Active Mode</span>
                </div>
                <div class="font-extrabold text-sm text-black">1. AI Face Kiosk</div>
                <p class="text-[11px] text-slate-500 mt-1">Touchless 0.4s face match on any tablet or iPad.</p>
            </button>

            <button onclick="switchAttendanceMode('gps')" id="tab-btn-gps" class="mode-tab-btn p-4 rounded-2xl bg-white border border-slate-200 hover:border-slate-300 shadow-sm text-left transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-location-crosshairs"></i>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">Field Mode</span>
                </div>
                <div class="font-extrabold text-sm text-black">2. GPS Geofenced Mobile</div>
                <p class="text-[11px] text-slate-500 mt-1">Selfie check-in locked strictly within client radius.</p>
            </button>

            <button onclick="switchAttendanceMode('qr')" id="tab-btn-qr" class="mode-tab-btn p-4 rounded-2xl bg-white border border-slate-200 hover:border-slate-300 shadow-sm text-left transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">Fast Lobby</span>
                </div>
                <div class="font-extrabold text-sm text-black">3. Dynamic QR Terminal</div>
                <p class="text-[11px] text-slate-500 mt-1">Rotating cryptographic QR code on TV screen.</p>
            </button>

            <button onclick="switchAttendanceMode('hardware')" id="tab-btn-hardware" class="mode-tab-btn p-4 rounded-2xl bg-white border border-slate-200 hover:border-slate-300 shadow-sm text-left transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">Hardware Sync</span>
                </div>
                <div class="font-extrabold text-sm text-black">4. Biometric Machine API</div>
                <p class="text-[11px] text-slate-500 mt-1">Direct cloud integration with eSSL, ZK, Matrix.</p>
            </button>

        </div>

        <!-- Dynamic Visual Simulator Display Stage -->
        <div class="p-8 sm:p-12 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center min-h-[460px]">
            
            <!-- Left Interactive Screen -->
            <div class="lg:col-span-6 bg-slate-800/90 rounded-2xl p-6 border border-slate-700 text-center relative overflow-hidden" id="attendancePreviewScreen">
                
                <!-- 1. Face Scan Simulation (Default) -->
                <div id="sim-face" class="sim-pane">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span class="text-xs font-extrabold text-emerald-400">AI Kiosk Camera View</span>
                        </div>
                        <span class="text-[11px] font-mono text-slate-300">DLF CyberCity Hub-A</span>
                    </div>

                    <div class="relative w-36 h-36 mx-auto rounded-3xl border-2 border-emerald-400 p-1 flex items-center justify-center bg-slate-900 shadow-xl shadow-emerald-500/10 mb-4">
                        <div class="absolute -top-1.5 -left-1.5 w-4 h-4 border-t-2 border-l-2 border-emerald-400"></div>
                        <div class="absolute -top-1.5 -right-1.5 w-4 h-4 border-t-2 border-r-2 border-emerald-400"></div>
                        <div class="absolute -bottom-1.5 -left-1.5 w-4 h-4 border-b-2 border-l-2 border-emerald-400"></div>
                        <div class="absolute -bottom-1.5 -right-1.5 w-4 h-4 border-b-2 border-r-2 border-emerald-400"></div>
                        <i class="fa-solid fa-user-check text-5xl text-emerald-400"></i>
                    </div>

                    <div class="font-extrabold text-base text-white">Rahul Verma &bull; Senior Lead</div>
                    <div class="text-xs text-emerald-400 font-bold mt-1">Face Match: 99.8% &bull; Liveness PASSED</div>
                    <div class="text-[11px] text-slate-400 mt-1">In-Time Logged: 09:30:15 AM &bull; On Time</div>
                </div>

                <!-- 2. GPS Geofence Simulation -->
                <div id="sim-gps" class="sim-pane hidden">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-400 animate-ping"></span>
                            <span class="text-xs font-extrabold text-blue-400">GPS Geo-Coordinates Locked</span>
                        </div>
                        <span class="text-[11px] font-mono text-slate-300">Accuracy: &plusmn;3 Meters</span>
                    </div>

                    <div class="relative w-36 h-36 mx-auto rounded-full border-4 border-blue-400/40 p-2 flex items-center justify-center bg-slate-900 shadow-xl mb-4">
                        <div class="w-full h-full rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 animate-pulse">
                            <i class="fa-solid fa-map-location-dot text-4xl"></i>
                        </div>
                    </div>

                    <div class="font-extrabold text-base text-white">Ananya Sen &bull; Field Sales Officer</div>
                    <div class="text-xs text-blue-400 font-bold mt-1">Geofence: Mumbai BKC Client Office (Inside 50m)</div>
                    <div class="text-[11px] text-slate-400 mt-1">Selfie Verified with GPS Coordinates Stamped</div>
                </div>

                <!-- 3. Dynamic QR Simulation -->
                <div id="sim-qr" class="sim-pane hidden">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                            <span class="text-xs font-extrabold text-amber-400">Rotating Cryptographic QR</span>
                        </div>
                        <span class="text-[11px] font-mono text-amber-300" id="qrTimer">Refresh in: 4s</span>
                    </div>

                    <div class="w-36 h-36 mx-auto rounded-2xl bg-white p-3 flex items-center justify-center shadow-xl mb-4">
                        <i class="fa-solid fa-qrcode text-slate-900 text-6xl"></i>
                    </div>

                    <div class="font-extrabold text-base text-white">Lobby Fast-Track Turnstile</div>
                    <div class="text-xs text-amber-400 font-bold mt-1">Anti-Screenshot Dynamic Token</div>
                    <div class="text-[11px] text-slate-400 mt-1">Scan via Employee Mobile App to punch within 1 sec</div>
                </div>

                <!-- 4. Hardware Machine Sync Simulation -->
                <div id="sim-hardware" class="sim-pane hidden">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-400 animate-ping"></span>
                            <span class="text-xs font-extrabold text-purple-400">Biometric Machine Cloud Listener</span>
                        </div>
                        <span class="text-[11px] font-mono text-slate-300">Device ID: eSSL-048</span>
                    </div>

                    <div class="w-36 h-36 mx-auto rounded-2xl bg-purple-950/60 border border-purple-500/50 p-3 flex items-center justify-center shadow-xl mb-4">
                        <i class="fa-solid fa-microchip text-purple-400 text-5xl"></i>
                    </div>

                    <div class="font-extrabold text-base text-white">Pune Manufacturing Plant (Gate 2)</div>
                    <div class="text-xs text-purple-400 font-bold mt-1">Cloud Push Protocol Connected</div>
                    <div class="text-[11px] text-slate-400 mt-1">Hardware finger punch synced instantly to cloud roster</div>
                </div>

            </div>

            <!-- Right Details -->
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-400">ENTERPRISE ATTENDANCE ENGINE</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white" id="modeTitle">
                    Sub-Second AI Facial Recognition Kiosk
                </h3>
                <p class="text-sm text-slate-300 leading-relaxed" id="modeDesc">
                    Turn any standard Android tablet or iPad into a smart biometric terminal. Employees simply glance at the screen for instantaneous, touchless check-in. Patented liveness detection prevents proxy punches using photos or recorded videos.
                </p>

                <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                    <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                        <div class="font-extrabold text-white">Zero Hardware Lock-In</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Works on any phone or tablet</div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                        <div class="font-extrabold text-white">Offline Punch Sync</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Stores locally when internet drops</div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                        <div class="font-extrabold text-white">Grace Period & Slabs</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Auto-calculate half-days & late cuts</div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700">
                        <div class="font-extrabold text-white">Direct Payroll Sync</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Feeds salary engine with zero manual work</div>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-3">
                    <button type="button" onclick="openDemoModal()" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-lg transition-all inline-flex items-center gap-2">
                        <span>Book an Attendance Demo</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>

        </div>

    </section>


    <!-- ========================================================================= -->
    <!-- 3. EMPLOYEE LIFECYCLE & PAPERLESS DIGITAL ONBOARDING -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-slate-200 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-id-card"></i>
                    <span>PAPERLESS DIGITAL ONBOARDING</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-black tracking-tight mt-1 mb-4">
                    Day-1 Paperless Onboarding & Statutory KYC Vault
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                    Send digital offer letters, collect Aadhaar, PAN, and cancelled cheques online, and auto-verify documents using government-integrated APIs. Reduce HR onboarding time from 3 days to under 15 minutes.
                </p>

                <div class="space-y-3.5 text-xs sm:text-sm font-semibold text-black">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Instant Aadhaar & PAN NSDL Verification</strong>
                            <span class="text-slate-600 font-normal text-xs">Real-time name matching and active status check to eliminate fake documents and KYC mismatch penalties.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Penny-Drop Bank Account Validation</strong>
                            <span class="text-slate-600 font-normal text-xs">Automated ₹1 bank penny-drop verifies beneficiary account holder name against company records before salary run.</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-black block text-sm font-extrabold">Custom Asset & Laptop Allocation Tracking</strong>
                            <span class="text-slate-600 font-normal text-xs">Maintain digital custody logs of laptops, SIM cards, ID badges, and corporate keys with signature receipts.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right KYC Document Preview Card -->
            <div class="lg:col-span-6">
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                            <span class="text-xs font-extrabold text-white">Digital Onboarding Profile &bull; EMP-092</span>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                            100% KYC Approved
                        </span>
                    </div>

                    <!-- KYC Verified Badges List -->
                    <div class="space-y-2.5 text-xs">
                        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-id-card text-blue-400 text-lg"></i>
                                <div>
                                    <div class="font-extrabold text-white">Aadhaar Card (UIDAI Verified)</div>
                                    <div class="text-[10px] text-slate-400">XXXX-XXXX-8421 &bull; Name: Priya Nair</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Verified
                            </span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-receipt text-purple-400 text-lg"></i>
                                <div>
                                    <div class="font-extrabold text-white">Permanent Account Number (PAN)</div>
                                    <div class="text-[10px] text-slate-400">ABCDE1234F &bull; NSDL Status: Active</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Verified
                            </span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-building-columns text-emerald-400 text-lg"></i>
                                <div>
                                    <div class="font-extrabold text-white">Bank Account (Penny Drop Check)</div>
                                    <div class="text-[10px] text-slate-400">HDFC Bank &bull; A/C: 501004928192 &bull; IFSC: HDFC0000240</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Validated
                            </span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-signature text-amber-400 text-lg"></i>
                                <div>
                                    <div class="font-extrabold text-white">Offer Letter & Non-Disclosure (NDA)</div>
                                    <div class="text-[10px] text-slate-400">Digital e-Sign timestamp: 01 Oct 2026, 11:20 AM</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Signed
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Automatic UAN & ESIC Registration</span>
                        <span class="text-blue-400 font-bold">1-Click Portal Push</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 4. STATUTORY INDIAN PAYROLL AUTOMATION ENGINE -->
    <!-- ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="p-8 sm:p-14 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-800">
            
            <div class="max-w-3xl mb-10">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 text-xs font-extrabold mb-3 border border-indigo-500/30">
                    <i class="fa-solid fa-calculator"></i> 100% INDIAN LABOUR LAW COMPLIANCE
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Automatic Indian Statutory Deductions
                </h2>
                <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed font-medium">
                    Never worry about government inspection notices, late deposit penalties, or calculation errors. Hisab Mittra automates every Indian compliance regulation with instant ECR file export.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs mb-8">
                
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-indigo-400 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-base mb-3">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    <div class="font-extrabold text-white text-sm mb-1.5">EPFO (Provident Fund)</div>
                    <p class="text-slate-400 leading-relaxed mb-3">
                        Computes Employee 12% share and Employer matching split (3.67% EPF + 8.33% EPS) capped as per statutory limits.
                    </p>
                    <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines"></i> Auto ECR Text File Generated
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-indigo-400 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-base mb-3">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div class="font-extrabold text-white text-sm mb-1.5">ESIC Health Insurance</div>
                    <p class="text-slate-400 leading-relaxed mb-3">
                        Auto-calculates 0.75% employee and 3.25% employer share for workers with gross salary up to ₹21,000/month.
                    </p>
                    <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines"></i> Monthly ESIC Return Ready
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-indigo-400 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-base mb-3">
                        <i class="fa-solid fa-map"></i>
                    </div>
                    <div class="font-extrabold text-white text-sm mb-1.5">Professional Tax (PT)</div>
                    <p class="text-slate-400 leading-relaxed mb-3">
                        Pre-configured for Maharashtra, Karnataka, Tamil Nadu, West Bengal, Telangana, Delhi and all 28 states.
                    </p>
                    <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines"></i> State-wise Slabs Auto-Updated
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-indigo-400 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold text-base mb-3">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div class="font-extrabold text-white text-sm mb-1.5">TDS Section 192</div>
                    <p class="text-slate-400 leading-relaxed mb-3">
                        Old vs New tax regime simulator, automated monthly TDS deduction, and 1-click Form 16 Part A & B generation.
                    </p>
                    <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines"></i> Form 24Q Quarterly Return
                    </span>
                </div>

            </div>

            <!-- Direct Bank API Integration Bar -->
            <div class="p-5 rounded-2xl bg-slate-800 border border-slate-700 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-white">Direct Corporate Banking API Integrations</div>
                        <div class="text-[11px] text-slate-400">1-Click direct salary transfer via HDFC, ICICI, SBI, and Axis Bank with multi-factor OTP approval.</div>
                    </div>
                </div>
                <button type="button" onclick="openDemoModal()" class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-xs whitespace-nowrap shadow-md transition-all">
                    See 1-Click Payroll Run
                </button>
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 5. FAQ SECTION ACCORDION -->
    <!-- ========================================================================= -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="text-center mb-12">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">FREQUENTLY ASKED QUESTIONS</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-black tracking-tight mt-1">
                Everything You Need to Know About Hisab Mittra HRM
            </h2>
        </div>

        <div class="space-y-3.5">
            
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>How does AI facial recognition prevent buddy punching and proxy attendance?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Hisab Mittra uses 3D liveness detection AI. It verifies eye blinks and micro-depth facial contours, meaning employees cannot trick the camera using printed photographs, mobile screens, or video recordings. Each verified punch is locked with a timestamp and device ID.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Can our field sales team mark attendance when there is no mobile internet?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Yes! The Hisab Mittra mobile app features offline cryptographic caching. Field executives can punch in with a selfie and GPS location even without internet access. As soon as the device reconnects to 4G/Wi-Fi, all punches sync automatically with tamper-proof timestamps.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Does Hisab Mittra generate government-ready EPFO & ESIC ECR files?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Yes. Once monthly payroll is finalized, a single click exports the official ECR text file formatted exactly to the EPFO Unified Portal specifications, as well as the monthly return file for the ESIC portal. No manual editing in Excel is ever required.
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between font-extrabold text-sm text-black">
                    <span>Can we migrate our existing employee database from Excel or biometric machines?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                </div>
                <div class="faq-content hidden mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed font-medium">
                    Absolutely. Hisab Mittra provides 1-click Excel/CSV bulk import templates for employee master data, historical leave balances, and salary structures. Our onboarding engineering team also assists you with free end-to-end data migration and biometric device API sync.
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
                    <i class="fa-solid fa-shield-halved"></i> 100% Accurate Attendance & Zero Compliance Hassles
                </span>
                
                <h3 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Upgrade to India's Premier HR Operating System.
                </h3>
                
                <p class="mt-4 text-sm sm:text-base text-slate-300 leading-relaxed font-medium">
                    Empower your HR team, delight your employees, and eliminate payroll compliance headaches with Hisab Mittra.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold text-sm shadow-xl shadow-blue-600/30 transition-all flex items-center justify-center gap-2.5">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Book a Guided Product Demo</span>
                    </button>
                    
                    <a href="{{ route('hisab.pricing') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 active:scale-95 text-white font-extrabold text-sm border border-white/20 transition-all flex items-center justify-center gap-2.5">
                        <span>Compare Transparent Pricing</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Free data migration</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> No setup fee</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Dedicated account manager</span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Vanilla Interactive Scripts for HRM Page -->
<script>
    // 1. Attendance Mode Switcher
    const modeData = {
        face: {
            title: "Sub-Second AI Facial Recognition Kiosk",
            desc: "Turn any standard Android tablet or iPad into a smart biometric terminal. Employees simply glance at the screen for instantaneous, touchless check-in. Patented liveness detection prevents proxy punches using photos or recorded videos."
        },
        gps: {
            title: "GPS Geofenced Mobile Punch for Field Teams",
            desc: "Empower sales representatives, delivery staff, and site engineers to check in directly from their smartphones. Punches are geo-tagged with exact latitude/longitude coordinates and validated strictly within authorized client perimeters."
        },
        qr: {
            title: "Rotating Cryptographic QR Code Lobby Terminal",
            desc: "Display a secure dynamic QR code on an office lobby TV monitor or reception screen. The QR code automatically refreshes every few seconds to prevent screenshot sharing, enabling rapid, non-stop employee ingress during morning peak hours."
        },
        hardware: {
            title: "Direct Cloud API Sync for Biometric Hardware",
            desc: "Keep your existing biometric fingerprint and RFID attendance machines (eSSL, ZKTeco, Matrix, Realtime). Our cloud listener API syncs hardware punch logs instantaneously into the Hisab Mittra roster with zero manual pen-drive data transfers."
        }
    };

    function switchAttendanceMode(mode) {
        // Update tab buttons
        document.querySelectorAll('.mode-tab-btn').forEach(btn => {
            btn.classList.remove('border-2', 'border-blue-600', 'shadow-md');
            btn.classList.add('border', 'border-slate-200');
        });
        const activeBtn = document.getElementById('tab-btn-' + mode);
        if (activeBtn) {
            activeBtn.classList.remove('border-slate-200');
            activeBtn.classList.add('border-2', 'border-blue-600', 'shadow-md');
        }

        // Update preview panes
        document.querySelectorAll('.sim-pane').forEach(p => p.classList.add('hidden'));
        const activePane = document.getElementById('sim-' + mode);
        if (activePane) {
            activePane.classList.remove('hidden');
        }

        // Update text details
        const info = modeData[mode];
        if (info) {
            document.getElementById('modeTitle').textContent = info.title;
            document.getElementById('modeDesc').textContent = info.desc;
        }
    }

    // 2. Dynamic QR Refresh Simulator
    let qrSeconds = 5;
    setInterval(() => {
        qrSeconds--;
        if (qrSeconds <= 0) qrSeconds = 5;
        const timerEl = document.getElementById('qrTimer');
        if (timerEl) {
            timerEl.textContent = `Refresh in: ${qrSeconds}s`;
        }
    }, 1000);

    // 3. Interactive FAQ Toggle
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
