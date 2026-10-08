@extends('hisab_mittra.layouts.master')

@section('title', 'Hisab Mittra — One Intelligent Platform for Your Entire Business')

@section('content')
<div class="overflow-hidden">

    <!-- 1. HERO SECTION -->
    <section class="relative min-h-screen flex items-start overflow-hidden bg-navy">
        <!-- Background Office Image covering Hero -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none -z-0">
            <div class="w-full h-full bg-no-repeat bg-cover bg-center" 
                 style="background-image: linear-gradient(180deg, rgba(10, 18, 40, 0.22) 0%, rgba(10, 18, 40, 0.38) 100%), url('/images/hero-bg.jpg?v={{ time() }}'); background-position: center 30%;">
            </div>
        </div>

        <div class="relative z-10 max-w-4xl ml-0 lg:ml-8 xl:ml-16 px-4 sm:px-6 text-left w-full pt-36 pb-16">
            
            <!-- Main Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.85)] max-w-2xl leading-[1.14]">
                One CRM to Manage Your 
                <span class="font-sans not-italic font-extrabold text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.85)]">Leads, Sales & Customers</span>
            </h1>

            <!-- Subheading -->
            <p class="mt-5 text-sm sm:text-base text-slate-100 drop-shadow-[0_1px_6px_rgba(0,0,0,0.9)] max-w-xl leading-relaxed font-medium">
                Manage your leads, customers, sales and team from one powerful platform. Stay organized, save time and grow your business.
            </p>

            <!-- CTA Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row items-start sm:items-center justify-start gap-4">
                <a href="{{ route('hisab.pricing') }}" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-gradient-to-r from-aqua to-aqua-hover hover:from-aqua-hover hover:to-aqua text-white font-extrabold text-sm tracking-wide shadow-aqua-glow transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2.5">
                    <span>Start Free Trial</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-navy font-bold text-sm transition-all duration-300 shadow-soft-elevation flex items-center justify-center gap-2.5 hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fa-solid fa-play text-aqua-dark text-xs"></i>
                    <span>Explore Live Platform</span>
                </button>
            </div>



        </div>
    </section>



    <!-- 3. SIX CORE MODULES (Interactive Overview Grid) -->
    <section class="pt-16 pb-8 sm:pt-20 sm:pb-10 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-4xl mx-auto mb-16">

                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-navy">
                    Work Smarter. Manage Better <br>
                    <span class="font-sans not-italic font-bold text-black block mt-2 text-xl sm:text-2xl">Everything Your Business Needs, Connected in One Place</span>
                </h2>
                <p class="mt-4 text-sm sm:text-base text-navy-muted">
                    Eliminate 5+ disjointed software subscriptions. Hisab Mittra unifies your people, payroll, attendance, customer deals, and books into a single high-performance cockpit.
                </p>
            </div>

            <!-- 6 Module Cards -->
            <!-- 6 Module Cards (Compact Square Shape) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                
                <!-- 1. HR Management -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-hrm.jpg" alt="Human Resource Management" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-solid fa-users-gear text-aqua-dark"></i> HRM
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">1. Human Resource Management</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Centralize employee lifecycle from onboarding and digital KYC to performance appraisals and document vaults.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> Digital Employee Records & KYC</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> Leave Policies & Role Hierarchies</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.hrm') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore HRM Details</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 2. Attendance & Biometrics -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-attendance.jpg" alt="Touchless Attendance System" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-solid fa-id-card-clip text-aqua-dark"></i> Attendance
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">2. Touchless Attendance System</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Eliminate buddy punching with AI face recognition, GPS geofenced check-ins, and hardware biometric machine sync.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> AI Face Recognition with Liveness</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> GPS Geofencing for Field Sales</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.hrm') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore Attendance Modes</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Automated Payroll -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-payroll.jpg" alt="Indian Payroll & Tax Compliance" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-solid fa-money-check-dollar text-aqua-dark"></i> Payroll
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">3. Indian Payroll & Compliance</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Run payroll in 3 minutes with automated Basic, HRA, PF (12%), ESI, and TDS deductions plus 1-click payslips.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> 100% Indian Labour Law Compliant</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> ECR EPFO & ESIC Ready Reports</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.hrm') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore Payroll Features</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. CRM & Sales Pipeline -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-crm.jpg" alt="CRM & Deal Pipeline" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-solid fa-diagram-project text-aqua-dark"></i> CRM Pipeline
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">4. CRM & Deal Pipeline</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Never lose leads again with visual drag-and-drop Kanban pipelines, automated follow-up reminders, and sales targets.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> Interactive Kanban Deal Stages</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> Auto-Lead Capture & Tracking</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.crm') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore CRM Suite</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 5. WhatsApp & Omnichannel Communication -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-whatsapp.jpg" alt="WhatsApp & Email Integration" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp CRM
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">5. WhatsApp & Email Integration</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Send instant quotations, payment links, and follow-ups directly on WhatsApp with official Meta Business API templates.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> 1-Click WhatsApp Quotations</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> Automated Follow-up Trigger Bots</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.crm') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore Communication</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 6. Accounting & Business Management -->
                <div class="rounded-none bg-white border border-peri-border/60 shadow-soft-elevation hover:shadow-luxury-card hover:border-aqua/40 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                    <div class="relative h-36 sm:h-40 w-full overflow-hidden bg-slate-100">
                        <img src="/images/modules/module-accounting.jpg" alt="Accounting, Billing & Inventory" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2.5 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/95 backdrop-blur text-navy text-[11px] font-bold shadow-sm">
                                <i class="fa-solid fa-scale-balanced text-aqua-dark"></i> Billing & GST
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-base font-bold text-navy mb-1">6. Accounting, Billing & Inventory</h3>
                            <p class="text-xs text-navy-muted leading-relaxed mb-2.5 line-clamp-2">
                                Create professional GST invoices, track expenses, manage inventory stock alerts, and monitor real-time P&L statements.
                            </p>
                            <ul class="space-y-1 text-xs text-navy-body font-medium">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> GST e-Invoicing & Gateways</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark text-[10px]"></i> SKU Inventory with Low Stock Alerts</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-3 border-t border-peri-border/60">
                            <a href="{{ route('hisab.features') }}" class="text-xs font-bold text-aqua-dark hover:text-aqua-dark flex items-center justify-between">
                                <span>Explore Accounting</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
 
    <!-- VIDEO SHOWCASE SECTION -->
    <section class="pt-6 pb-16 sm:pt-8 sm:pb-20 bg-transparent overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Heading -->
            <div class="text-center mb-10 sm:mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-blue-700 tracking-tight mb-3">
                    See Your Business. Smarter.
                </h2>
                <p class="text-base sm:text-lg text-navy-body font-semibold max-w-2xl mx-auto">
                    Real-time visibility across employees, attendance, CRM and business operations.
                </p>
            </div>

            <!-- Centered Video Frame -->
            <div class="max-w-5xl mx-auto">

                <!-- Video Card Frame -->
                <div class="relative w-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-slate-200/80 bg-slate-900 aspect-[16/10] sm:aspect-[16/9]">

                    <!-- Video (Full clean screen visibility) -->
                    <video id="showcase-video"
                        class="w-full h-full object-cover block"
                        autoplay loop muted playsinline preload="auto">
                        <source src="/videos/demo-video.mp4" type="video/mp4">
                        <source src="/videos/demo-video-backup.mp4" type="video/mp4">
                    </video>

                    <!-- Audio toggle floating at bottom right -->
                    <button type="button" onclick="toggleShowcaseMute();" class="absolute bottom-4 right-4 z-20 w-9 h-9 rounded-full bg-black/60 hover:bg-black/80 text-white backdrop-blur flex items-center justify-center transition-all shadow-md" title="Mute / Unmute">
                        <i id="showcase-mute-icon" class="fa-solid fa-volume-xmark text-xs"></i>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <script>
        function toggleShowcaseMute() {
            const v = document.getElementById('showcase-video');
            const muteIcon = document.getElementById('showcase-mute-icon');
            if (v) {
                v.muted = !v.muted;
                if (muteIcon) {
                    muteIcon.className = v.muted ? 'fa-solid fa-volume-xmark text-xs' : 'fa-solid fa-volume-high text-xs';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const v = document.getElementById('showcase-video');
            if (v) {
                v.muted = true;
                const tryPlay = function() {
                    const p = v.play();
                    if (p !== undefined) {
                        p.catch(function() {
                            v.muted = true;
                            v.play().catch(function() {});
                        });
                    }
                };
                tryPlay();
                v.parentElement.addEventListener('click', function(e) {
                    if (e.target.closest('button')) return;
                    if (v.paused) v.play();
                });
            }
        });
    </script>

    <!-- 4. HRM & ATTENDANCE SPLIT SPOTLIGHT -->
    <section class="relative py-20 sm:py-28 bg-no-repeat bg-cover bg-center overflow-hidden border-y border-blue-100" style="background-image: url('/images/attendance-bg.png?v={{ time() }}');">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                
                <!-- Left Details -->
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold uppercase tracking-wider">
                        Next-Gen Attendance
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-navy tracking-tight leading-tight">
                        Attendance That Works Smarter. <br>
                        <span class="font-sans not-italic font-extrabold text-black block mt-2 text-2xl sm:text-4xl">Accurate Tracking. Zero Proxy. Complete Control.</span>
                    </h2>
                    <p class="text-sm sm:text-base text-navy-muted leading-relaxed">
                        Whether your staff works in an office, a multi-story showroom, a factory floor, or out in the field, Hisab Mittra provides verified, tamper-proof attendance marking.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2" id="attendance-feature-tabs">
                        <!-- Tab 0: AI Face Recognition -->
                        <div onclick="setAttendanceSlide(0)" id="att-tab-0" class="p-4 rounded-2xl bg-white border-2 border-blue-600 shadow-md cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group">
                            <div class="text-blue-700 font-bold text-sm mb-1 flex items-center justify-between">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-camera"></i> AI Face Recognition</span>
                                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse att-indicator"></span>
                            </div>
                            <p class="text-xs text-navy-muted">Sub-second facial match via mobile camera or tablet kiosk with anti-spoofing.</p>
                        </div>

                        <!-- Tab 1: GPS Geofencing -->
                        <div onclick="setAttendanceSlide(1)" id="att-tab-1" class="p-4 rounded-2xl bg-white/85 backdrop-blur-sm border-2 border-transparent hover:border-blue-200 shadow-sm cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group">
                            <div class="text-navy font-bold text-sm mb-1 flex items-center justify-between">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-crosshairs"></i> GPS Geofencing</span>
                                <span class="w-2 h-2 rounded-full bg-transparent att-indicator"></span>
                            </div>
                            <p class="text-xs text-navy-muted">Set authorized geographical radiuses for field sales executives and branch offices.</p>
                        </div>

                        <!-- Tab 2: Dynamic QR Kiosk -->
                        <div onclick="setAttendanceSlide(2)" id="att-tab-2" class="p-4 rounded-2xl bg-white/85 backdrop-blur-sm border-2 border-transparent hover:border-blue-200 shadow-sm cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group">
                            <div class="text-navy font-bold text-sm mb-1 flex items-center justify-between">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-qrcode"></i> Dynamic QR Kiosk</span>
                                <span class="w-2 h-2 rounded-full bg-transparent att-indicator"></span>
                            </div>
                            <p class="text-xs text-navy-muted">Rotating QR code displayed at reception that employees scan to mark entry in 2 seconds.</p>
                        </div>

                        <!-- Tab 3: Biometric Machine Sync -->
                        <div onclick="setAttendanceSlide(3)" id="att-tab-3" class="p-4 rounded-2xl bg-white/85 backdrop-blur-sm border-2 border-transparent hover:border-blue-200 shadow-sm cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group">
                            <div class="text-navy font-bold text-sm mb-1 flex items-center justify-between">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-fingerprint"></i> Biometric Machine Sync</span>
                                <span class="w-2 h-2 rounded-full bg-transparent att-indicator"></span>
                            </div>
                            <p class="text-xs text-navy-muted">Seamlessly connects with existing Essl, Realtime, and ZKTeco biometric devices.</p>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="{{ route('hisab.hrm') }}" class="px-6 py-3 rounded-xl bg-aqua text-aqua-dark font-bold text-xs hover:bg-aqua-hover transition shadow-aqua-glow">
                            Learn More About HRM &rarr;
                        </a>
                        <button type="button" onclick="openDemoModal()" class="px-6 py-3 rounded-xl border border-peri-border bg-white text-navy font-bold text-xs hover:bg-aqua-soft transition">
                            Book Live Attendance Demo
                        </button>
                    </div>
                </div>

                <!-- Right Visual: Dynamic 4-Feature Attendance Showcase Slider -->
                <div class="relative" id="attendance-slider-container">
                    <div class="p-5 sm:p-6 rounded-3xl bg-white/95 backdrop-blur-md border-2 border-blue-200/80 shadow-2xl relative overflow-hidden">
                        
                        <!-- Card Header -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-peri-border/40">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-aqua text-aqua-dark flex items-center justify-center text-xs font-black shadow-sm">
                                    HM
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-navy" id="att-header-title">Employee Mobile Kiosk</div>
                                    <div class="text-[10px] text-navy-subtle" id="att-header-subtitle">Geo-Verified Active Session</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 border border-emerald-200 text-emerald-800 text-[10px] font-bold" id="att-header-badge">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-[9px]"></i> Location Verified
                            </span>
                        </div>

                        <!-- SLIDER SCREEN CONTAINER (Holds the 4 feature screens) -->
                        <div class="relative h-64 sm:h-72 w-full rounded-2xl overflow-hidden bg-slate-900 shadow-md select-none group">
                            
                            <!-- SLIDE 0: AI Face Recognition -->
                            <div id="att-slide-0" class="att-slide absolute inset-0 transition-all duration-500 opacity-100 pointer-events-auto">
                                <img src="/images/rahul-verma-attendance.jpg" alt="Rahul Verma - Executive Sales" class="w-full h-full object-cover object-top">
                                
                                <!-- Scanner Top HUD Pills -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md text-white text-[10px] font-bold flex items-center gap-1.5 shadow">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> AI Face Match
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1 shadow">
                                        <i class="fa-solid fa-check"></i> 99.8% Match
                                    </span>
                                </div>

                                <!-- Face Scan Target Frame -->
                                <div class="absolute top-10 left-1/2 -translate-x-1/2 w-28 h-28 border-2 border-emerald-400/90 rounded-2xl pointer-events-none flex items-center justify-center">
                                    <div class="absolute -top-1 -left-1 w-3 h-3 border-t-2 border-l-2 border-emerald-300"></div>
                                    <div class="absolute -top-1 -right-1 w-3 h-3 border-t-2 border-r-2 border-emerald-300"></div>
                                    <div class="absolute -bottom-1 -left-1 w-3 h-3 border-b-2 border-l-2 border-emerald-300"></div>
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 border-b-2 border-r-2 border-emerald-300"></div>
                                </div>

                                <!-- Bottom Employee Tag Overlay -->
                                <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/80 via-black/50 to-transparent text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold flex items-center gap-1.5">
                                                <span>Good Morning, Rahul Verma</span>
                                                <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                                            </div>
                                            <div class="text-[10px] text-slate-300">Executive Sales &bull; EMP-0042</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] text-emerald-300 font-semibold flex items-center gap-1 justify-end">
                                                <i class="fa-solid fa-location-dot"></i> Gurugram HQ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 1: GPS Geofencing (Realistic Photo) -->
                            <div id="att-slide-1" class="att-slide absolute inset-0 transition-all duration-500 opacity-0 pointer-events-none">
                                <img src="/images/attendance/gps-attendance.jpg" alt="GPS Geofence Field Attendance" class="w-full h-full object-cover object-center">
                                
                                <!-- Top HUD Pills -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1.5 shadow">
                                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span> GPS Geofence Verified
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md text-blue-300 text-[10px] font-bold flex items-center gap-1 shadow">
                                        <i class="fa-solid fa-satellite-dish"></i> ± 2.4m Radius
                                    </span>
                                </div>

                                <!-- Center subtle target indicator -->
                                <div class="absolute top-8 right-6 w-24 h-24 rounded-full border-2 border-emerald-400/80 bg-emerald-500/10 pointer-events-none flex items-center justify-center animate-pulse">
                                    <span class="px-2 py-0.5 rounded-full bg-black/70 text-[9px] font-bold text-emerald-300">50m Range OK</span>
                                </div>

                                <!-- Bottom Employee Tag Overlay -->
                                <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/85 via-black/50 to-transparent text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold flex items-center gap-1.5">
                                                <span>Priya Sharma</span>
                                                <span class="px-1.5 py-0.5 rounded bg-emerald-500/90 text-[9px] font-black">Authorized</span>
                                            </div>
                                            <div class="text-[10px] text-slate-300">Field Sales Manager &bull; EMP-0108</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] text-emerald-300 font-semibold flex items-center gap-1 justify-end">
                                                <i class="fa-solid fa-location-dot"></i> DLF Cyber City, Gurugram
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 2: Dynamic QR Kiosk (Realistic Photo) -->
                            <div id="att-slide-2" class="att-slide absolute inset-0 transition-all duration-500 opacity-0 pointer-events-none">
                                <img src="/images/attendance/qr-kiosk.jpg" alt="Dynamic QR Kiosk Reception" class="w-full h-full object-cover object-center">
                                
                                <!-- Top HUD Pills -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <span class="px-2.5 py-1 rounded-lg bg-blue-600/90 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1.5 shadow">
                                        <i class="fa-solid fa-shield-halved"></i> Anti-Spoof Dynamic QR
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md text-amber-300 text-[10px] font-bold flex items-center gap-1 shadow">
                                        <i class="fa-solid fa-rotate animate-spin"></i> Refresh in <span id="qr-countdown">12</span>s
                                    </span>
                                </div>

                                <!-- Bottom Employee Tag Overlay -->
                                <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/85 via-black/50 to-transparent text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold flex items-center gap-1.5">
                                                <span>Reception Kiosk Tablet #01</span>
                                                <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                                            </div>
                                            <div class="text-[10px] text-slate-300">Tower Reception Desk &bull; Scan in 1.4s</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] text-cyan-300 font-semibold flex items-center gap-1 justify-end">
                                                <i class="fa-solid fa-qrcode"></i> Dynamic Token Active
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 3: Biometric Machine Sync (Realistic Photo) -->
                            <div id="att-slide-3" class="att-slide absolute inset-0 transition-all duration-500 opacity-0 pointer-events-none">
                                <img src="/images/attendance/biometric-sync.jpg" alt="Biometric Hardware Sync" class="w-full h-full object-cover object-center">
                                
                                <!-- Top HUD Pills -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1.5 shadow">
                                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span> 3 Devices Synced
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md text-slate-200 text-[10px] font-bold flex items-center gap-1 shadow">
                                        <i class="fa-solid fa-server text-blue-400"></i> eSSL / ZKTeco Bridge
                                    </span>
                                </div>


                                <!-- Bottom Status Tag -->
                                <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/85 via-black/50 to-transparent text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold flex items-center gap-1.5">
                                                <span>Zero Data Loss Protocol</span>
                                                <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                                            </div>
                                            <div class="text-[10px] text-slate-300">Offline memory buffer &bull; Real-time payroll push</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] text-emerald-300 font-semibold flex items-center gap-1 justify-end">
                                                <i class="fa-solid fa-bolt"></i> 100% Synced
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subtle Dot Indicators (Bottom Center) -->
                            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 bg-black/50 backdrop-blur px-2.5 py-1 rounded-full pointer-events-none">
                                <span class="att-dot w-3 h-1.5 rounded-full bg-blue-500 transition-all"></span>
                                <span class="att-dot w-1.5 h-1.5 rounded-full bg-white/40 transition-all"></span>
                                <span class="att-dot w-1.5 h-1.5 rounded-full bg-white/40 transition-all"></span>
                                <span class="att-dot w-1.5 h-1.5 rounded-full bg-white/40 transition-all"></span>
                            </div>

                        </div>

                        <!-- Dynamic Shift Timings & Metrics (Updates per slide) -->
                        <div class="grid grid-cols-2 gap-3 mt-3.5">
                            <div class="p-3 rounded-xl bg-white border border-peri-border/60 text-left shadow-sm">
                                <div class="text-[10px] text-navy-subtle" id="att-metric1-label">Check-In Time</div>
                                <div class="text-sm font-extrabold text-navy" id="att-metric1-value">09:12 AM</div>
                                <div class="text-[9px] text-emerald-700 font-bold" id="att-metric1-sub">On Schedule</div>
                            </div>
                            <div class="p-3 rounded-xl bg-white border border-peri-border/60 text-left shadow-sm">
                                <div class="text-[10px] text-navy-subtle" id="att-metric2-label">Working Hours</div>
                                <div class="text-sm font-extrabold text-navy" id="att-metric2-value">7h 48m</div>
                                <div class="text-[9px] text-aqua-dark font-bold" id="att-metric2-sub">Standard Shift</div>
                            </div>
                        </div>

                        <!-- Live Notification Pill (Updates per slide) -->
                        <div class="mt-3.5 p-3 rounded-xl bg-white border border-peri-border/60 flex items-center gap-3 text-xs shadow-sm" id="att-footer-alert">
                            <i id="att-footer-icon" class="fa-brands fa-whatsapp text-emerald-600 text-lg"></i>
                            <div class="text-[11px] text-navy leading-tight">
                                <span class="font-bold" id="att-footer-tag">WhatsApp Alert:</span>
                                <span id="att-footer-msg">Check-in recorded and confirmed with Branch Manager.</span>
                            </div>
                        </div>

                    </div>
                </div>

                <script>
                    const attendanceSlidesData = [
                        {
                            headerTitle: 'Employee Mobile Kiosk',
                            headerSubtitle: 'AI Face-Verified Active Session',
                            headerBadge: '<i class="fa-solid fa-circle-check text-emerald-600 text-[9px]"></i> Face Match Verified',
                            m1Label: 'Check-In Time',
                            m1Val: '09:12 AM',
                            m1Sub: 'On Schedule',
                            m2Label: 'Working Hours',
                            m2Val: '7h 48m',
                            m2Sub: 'Standard Shift',
                            footerIcon: 'fa-brands fa-whatsapp text-emerald-600 text-lg',
                            footerTag: 'WhatsApp Alert:',
                            footerMsg: 'Check-in recorded and confirmed with Branch Manager.'
                        },
                        {
                            headerTitle: 'GPS Field Territory Tracker',
                            headerSubtitle: 'Geo-Radius Boundary Verified',
                            headerBadge: '<i class="fa-solid fa-location-dot text-emerald-600 text-[9px]"></i> 14m to Office Center',
                            m1Label: 'Field Punch In',
                            m1Val: '09:35 AM',
                            m1Sub: 'Authorized Territory',
                            m2Label: 'GPS Accuracy',
                            m2Val: '± 2.4 meters',
                            m2Sub: 'High-Precision Lock',
                            footerIcon: 'fa-solid fa-location-crosshairs text-blue-600 text-lg',
                            footerTag: 'Geofence Guard:',
                            footerMsg: 'Entry validated within designated 50m DLF Cyber Hub radius.'
                        },
                        {
                            headerTitle: 'Lobby Tablet QR Kiosk',
                            headerSubtitle: 'Anti-Spoof Rolling Token Active',
                            headerBadge: '<i class="fa-solid fa-shield-halved text-blue-600 text-[9px]"></i> Dynamic QR Live',
                            m1Label: 'Today Kiosk Scans',
                            m1Val: '348 Employees',
                            m1Sub: 'Zero Touch entry',
                            m2Label: 'Entry Speed',
                            m2Val: '1.4 Seconds',
                            m2Sub: 'Sub-second Processing',
                            footerIcon: 'fa-solid fa-qrcode text-blue-600 text-lg',
                            footerTag: 'Dynamic QR Security:',
                            footerMsg: 'QR token auto-refreshes every 15s to completely stop photo proxy.'
                        },
                        {
                            headerTitle: 'Biometric Machine Cloud Bridge',
                            headerSubtitle: 'eSSL & ZKTeco Hardware Synced',
                            headerBadge: '<i class="fa-solid fa-server text-emerald-600 text-[9px]"></i> 3 Devices Online',
                            m1Label: 'Live Sync Latency',
                            m1Val: '< 180ms',
                            m1Sub: 'Realtime Cloud Push',
                            m2Label: 'Hardware Uptime',
                            m2Val: '99.99%',
                            m2Sub: 'Offline Buffer Ready',
                            footerIcon: 'fa-solid fa-fingerprint text-purple-600 text-lg',
                            footerTag: 'Hardware Bridge:',
                            footerMsg: 'Biometric punches push straight into salary calculations with zero human entry.'
                        }
                    ];

                    let currentAttendanceSlide = 0;
                    let attendanceSlideTimer = null;

                    function setAttendanceSlide(index) {
                        currentAttendanceSlide = (index + attendanceSlidesData.length) % attendanceSlidesData.length;
                        
                        // Update slides visibility
                        for (let i = 0; i < 4; i++) {
                            const slide = document.getElementById('att-slide-' + i);
                            const tab = document.getElementById('att-tab-' + i);
                            const dots = document.querySelectorAll('.att-dot');
                            
                            if (slide) {
                                if (i === currentAttendanceSlide) {
                                    slide.classList.remove('opacity-0', 'pointer-events-none');
                                    slide.classList.add('opacity-100', 'pointer-events-auto');
                                } else {
                                    slide.classList.remove('opacity-100', 'pointer-events-auto');
                                    slide.classList.add('opacity-0', 'pointer-events-none');
                                }
                            }

                            // Update Tab Styles
                            if (tab) {
                                const ind = tab.querySelector('.att-indicator');
                                const title = tab.querySelector('div > span:first-child');
                                if (i === currentAttendanceSlide) {
                                    tab.className = 'p-4 rounded-2xl bg-white border-2 border-blue-600 shadow-md cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group';
                                    if (title) title.parentElement.className = 'text-blue-700 font-bold text-sm mb-1 flex items-center justify-between';
                                    if (ind) ind.className = 'w-2 h-2 rounded-full bg-blue-600 animate-pulse att-indicator';
                                } else {
                                    tab.className = 'p-4 rounded-2xl bg-white/85 backdrop-blur-sm border-2 border-transparent hover:border-blue-200 shadow-sm cursor-pointer transition-all duration-300 hover:scale-[1.02] relative group';
                                    if (title) title.parentElement.className = 'text-navy font-bold text-sm mb-1 flex items-center justify-between';
                                    if (ind) ind.className = 'w-2 h-2 rounded-full bg-transparent att-indicator';
                                }
                            }

                            // Update Dots
                            if (dots && dots[i]) {
                                if (i === currentAttendanceSlide) {
                                    dots[i].className = 'att-dot w-4 h-2 rounded-full bg-blue-500 transition-all';
                                } else {
                                    dots[i].className = 'att-dot w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all';
                                }
                            }
                        }

                        // Update dynamic texts
                        const data = attendanceSlidesData[currentAttendanceSlide];
                        const titleEl = document.getElementById('att-header-title');
                        const subEl = document.getElementById('att-header-subtitle');
                        const badgeEl = document.getElementById('att-header-badge');
                        const m1Label = document.getElementById('att-metric1-label');
                        const m1Val = document.getElementById('att-metric1-value');
                        const m1Sub = document.getElementById('att-metric1-sub');
                        const m2Label = document.getElementById('att-metric2-label');
                        const m2Val = document.getElementById('att-metric2-value');
                        const m2Sub = document.getElementById('att-metric2-sub');
                        const fIcon = document.getElementById('att-footer-icon');
                        const fTag = document.getElementById('att-footer-tag');
                        const fMsg = document.getElementById('att-footer-msg');

                        if (titleEl) titleEl.innerText = data.headerTitle;
                        if (subEl) subEl.innerText = data.headerSubtitle;
                        if (badgeEl) badgeEl.innerHTML = data.headerBadge;
                        if (m1Label) m1Label.innerText = data.m1Label;
                        if (m1Val) m1Val.innerText = data.m1Val;
                        if (m1Sub) m1Sub.innerText = data.m1Sub;
                        if (m2Label) m2Label.innerText = data.m2Label;
                        if (m2Val) m2Val.innerText = data.m2Val;
                        if (m2Sub) m2Sub.innerText = data.m2Sub;
                        if (fIcon) fIcon.className = data.footerIcon;
                        if (fTag) fTag.innerText = data.footerTag;
                        if (fMsg) fMsg.innerText = data.footerMsg;
                    }

                    function stepAttendanceSlide(dir) {
                        setAttendanceSlide(currentAttendanceSlide + dir);
                        restartAttendanceAutoTimer();
                    }

                    function startAttendanceAutoTimer() {
                        clearInterval(attendanceSlideTimer);
                        attendanceSlideTimer = setInterval(() => {
                            setAttendanceSlide(currentAttendanceSlide + 1);
                        }, 4000);
                    }

                    function restartAttendanceAutoTimer() {
                        startAttendanceAutoTimer();
                    }

                    // Countdown simulation for QR Code
                    let qrSeconds = 12;
                    setInterval(() => {
                        const el = document.getElementById('qr-countdown');
                        if (el) {
                            qrSeconds = qrSeconds <= 1 ? 15 : qrSeconds - 1;
                            el.innerText = qrSeconds;
                        }
                    }, 1000);

                    // Initialize immediately
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', () => {
                            startAttendanceAutoTimer();
                        });
                    } else {
                        startAttendanceAutoTimer();
                    }
                </script>

            </div>
        </div>
    </section>

    <!-- 5. PRICING PREVIEW SECTION -->
    <section class="py-20 sm:py-28 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-peri-mist border border-peri-border text-navy text-[11px] font-bold uppercase tracking-wider mb-3">
                Transparent Pricing
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-navy">
                Predictable Plans. <br>
                <span class="font-sans not-italic font-extrabold text-black">Massive ROI for Every Stage.</span>
            </h2>
            <p class="mt-4 text-sm sm:text-base text-navy-muted max-w-2xl mx-auto">
                No hidden implementation fees. All plans include automated statutory updates, cloud backups, and dedicated onboarding support.
            </p>

            <!-- Pricing Cards (3 Tiers) -->
            <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-8 text-left max-w-5xl mx-auto">
                
                <!-- Starter Tier -->
                <div class="p-8 rounded-3xl bg-white border border-peri-border/70 shadow-soft-elevation flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-navy-subtle mb-1">Starter</div>
                        <h4 class="text-xl font-bold text-navy">Small Teams</h4>
                        <p class="text-xs text-navy-muted mt-1">Ideal for growing firms up to 25 employees.</p>
                        
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-black text-navy">₹1,499</span>
                            <span class="text-xs text-navy-subtle">/ month billed annually</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-navy-body">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Up to 25 Employees</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> AI Face & Mobile Attendance</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Automated PF & ESI Payroll</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Standard Leave Management</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> PDF Payslip Generation</li>
                        </ul>
                    </div>

                    <div class="mt-8 pt-6 border-t border-peri-border">
                        <a href="{{ route('hisab.pricing') }}" class="w-full py-3 rounded-xl border border-peri-border hover:border-aqua text-navy hover:text-aqua-dark font-bold text-xs text-center block transition">
                            Select Starter Plan
                        </a>
                    </div>
                </div>

                <!-- Growth Tier (Featured) -->
                <div class="p-8 rounded-3xl bg-white border-2 border-aqua shadow-luxury-card relative flex flex-col justify-between transform md:-translate-y-2">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-aqua text-aqua-dark text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                        Most Popular
                    </div>

                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-aqua-dark mb-1">Growth & CRM</div>
                        <h4 class="text-xl font-bold text-navy">Mid-Market Companies</h4>
                        <p class="text-xs text-navy-muted mt-1">For businesses scaling teams, sales & branches.</p>
                        
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-black text-aqua-dark">₹3,499</span>
                            <span class="text-xs text-navy-subtle">/ month billed annually</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-navy-body font-medium">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Up to 100 Employees</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Full HRM & Shift Rostering</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Visual Deal Pipeline & Leads CRM</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Official WhatsApp Messaging</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Invoicing & Quotations Tool</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Priority Support & Training</li>
                        </ul>
                    </div>

                    <div class="mt-8 pt-6 border-t border-peri-border">
                        <a href="{{ route('hisab.pricing') }}" class="w-full py-3.5 rounded-xl bg-aqua hover:bg-aqua-hover text-aqua-dark font-extrabold text-xs text-center block transition shadow-aqua-glow">
                            Start 14-Day Free Trial
                        </a>
                    </div>
                </div>

                <!-- Enterprise Tier -->
                <div class="p-8 rounded-3xl bg-white border border-peri-border/70 shadow-soft-elevation flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-navy-subtle mb-1">Enterprise</div>
                        <h4 class="text-xl font-bold text-navy">Custom Organization</h4>
                        <p class="text-xs text-navy-muted mt-1">For multi-location corporate groups & retail chains.</p>
                        
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-black text-navy">Custom</span>
                            <span class="text-xs text-navy-subtle">tailored to your scale</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-navy-body">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Unlimited Employees & Branches</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Custom ERP & Biometric API Sync</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Multi-GST Entity Management</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> Dedicated Account Manager</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-aqua-dark"></i> 99.98% SLA Guarantee</li>
                        </ul>
                    </div>

                    <div class="mt-8 pt-6 border-t border-peri-border">
                        <button type="button" onclick="openDemoModal()" class="w-full py-3 rounded-xl border border-peri-border hover:border-aqua text-navy hover:text-aqua-dark font-bold text-xs text-center block transition">
                            Talk to Enterprise Sales
                        </button>
                    </div>
                </div>

            </div>

            <div class="mt-10">
                <a href="{{ route('hisab.pricing') }}" class="text-xs font-bold text-aqua-dark hover:underline">
                    View Complete Feature Comparison Matrix &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 7. FINAL CALL-TO-ACTION BANNER -->
    <section class="py-16 sm:py-24 bg-no-repeat bg-cover bg-center text-center relative overflow-hidden border-t border-blue-100" style="background-image: url('/images/cta-bg.png?v={{ time() }}');">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blue-100/90 text-blue-700 text-[11px] font-bold uppercase tracking-wider mb-4 border border-blue-200 shadow-sm">
                Start In Under 5 Minutes
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-navy">
                Modernize Your Entire Business Today.
            </h2>
            <p class="mt-4 text-sm sm:text-lg text-slate-600 max-w-2xl mx-auto font-medium">
                Join 2,400+ forward-thinking Indian businesses running on Hisab Mittra. Experience the speed and clarity of unified business management.
            </p>

            <div class="mt-9 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('hisab.pricing') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-sm transition shadow-lg shadow-blue-500/25 active:scale-95">
                    Start Your 14-Day Free Trial
                </a>
                <button type="button" onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-300/80 text-navy font-bold text-sm transition shadow-sm active:scale-95">
                    Schedule 1-on-1 Demo Walkthrough
                </button>
            </div>
        </div>
    </section>

</div>
@endsection
