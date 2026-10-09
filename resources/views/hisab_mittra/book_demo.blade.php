@extends('hisab_mittra.layouts.master')

@section('title', 'Schedule Your Platform Demo — Hisab Mittra')

@section('content')
<div class="py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Bar: Back Button in Corner & Live Availability Indicator -->
        <div class="mb-6 sm:mb-8 flex items-center justify-between">
            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('hisab.home') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-peri-border hover:border-aqua text-navy hover:text-aqua-dark font-bold text-xs shadow-sm hover:shadow transition-all group">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1 text-xs"></i>
                <span>Back</span>
            </a>

            <div class="hidden sm:flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white border border-peri-border/80 text-xs font-semibold text-navy shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Specialist Available Today &bull; 14-Day Free Access</span>
            </div>
        </div>

        <!-- Full-Page 2-Column Responsive Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Column: Value Proposition & What You Will Experience (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-aqua-soft border border-aqua-border text-aqua-dark font-bold text-[10.5px] uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-calendar-check text-aqua-dark"></i> 1-On-1 Personalized Walkthrough
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-navy tracking-tight leading-tight">
                        Schedule Your Platform Demo
                    </h1>
                    <p class="text-xs sm:text-sm text-navy-muted mt-3 leading-relaxed">
                        Experience how Hisab Mittra unifies Indian HRM, biometric attendance, statutory payroll, and WhatsApp CRM into a single high-performance system tailored to your team.
                    </p>
                </div>

                <!-- 4 Core Pillars of the Demo -->
                <div class="space-y-3.5 pt-2">
                    <div class="p-4 rounded-2xl bg-white/90 border border-peri-border/70 flex items-start gap-3.5 shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-fingerprint"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-navy">Biometric & GPS Attendance Tour</div>
                            <div class="text-[11px] text-navy-muted mt-0.5 leading-normal">
                                See live biometric machine sync, QR kiosk modes, and selfie-geofence attendance for on-field staff.
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/90 border border-peri-border/70 flex items-start gap-3.5 shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-navy">Automated PF, ESI, PT & TDS Payroll</div>
                            <div class="text-[11px] text-navy-muted mt-0.5 leading-normal">
                                1-Click payslip generation, automated overtime & salary deductions, and zero-error EPFO ECR files.
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/90 border border-peri-border/70 flex items-start gap-3.5 shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-comments-dollar"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-navy">WhatsApp CRM & Deals Management</div>
                            <div class="text-[11px] text-navy-muted mt-0.5 leading-normal">
                                Visual lead stages, instant GST quotations, automated WhatsApp reminders, and deal win-loss analytics.
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/90 border border-peri-border/70 flex items-start gap-3.5 shadow-sm">
                        <div class="w-9 h-9 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-file-import"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-navy">1-Day White-Glove Data Migration</div>
                            <div class="text-[11px] text-navy-muted mt-0.5 leading-normal">
                                Free assistance importing your existing employee registers, salary structures, and customer databases.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trust Strip -->
                <div class="p-4 rounded-2xl bg-peri-mist border border-peri-border flex items-center justify-between gap-3 text-xs text-navy font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-aqua-dark text-sm"></i>
                        <span>ISO 27001 &bull; SOC-2 Type II</span>
                    </div>
                    <div class="text-[11px] text-navy-subtle">
                        100% India Hosted
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Demo Booking Form (7 cols) -->
            <div class="lg:col-span-7">
                <div class="glass-card rounded-3xl border border-peri-border shadow-2xl p-6 sm:p-10 relative overflow-hidden bg-white/95">
                    
                    <!-- Background ambient glow accents -->
                    <div class="absolute -top-24 -right-24 w-52 h-52 bg-aqua-soft/50 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -left-24 w-52 h-52 bg-peri-mist rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Header inside card -->
                    <div class="mb-7 relative z-10">
                        <h2 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Reserve Your 1-on-1 Walkthrough</h2>
                        <p class="text-xs text-navy-muted mt-1">Fill in your details below and our senior solutions specialist will guide you.</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3 animate-fade-in relative z-10">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                            <div>
                                <div class="font-bold">Demo Scheduled Successfully!</div>
                                <div class="text-[11px] text-emerald-700 font-normal mt-0.5">{{ session('success') }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Demo Form -->
                    <form action="{{ route('hisab.demo.submit') }}" method="POST" class="space-y-4 relative z-10">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Your Full Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Vikram Malhotra" value="{{ old('name') }}"
                                       class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                @error('name')
                                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Business / Company Name *</label>
                                <input type="text" name="business_name" required placeholder="e.g. Apex Enterprises" value="{{ old('business_name') }}"
                                       class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                @error('business_name')
                                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Work Email Address *</label>
                                <input type="email" name="email" required placeholder="vikram@apexenterprises.in" value="{{ old('email') }}"
                                       class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                @error('email')
                                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">WhatsApp / Phone *</label>
                                <input type="tel" name="phone" required placeholder="+91 97830 55170" value="{{ old('phone') }}"
                                       class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                @error('phone')
                                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Number of Employees *</label>
                                <select name="employee_count" required class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                    <option value="1-15">1 – 15 Employees (Startup / SME)</option>
                                    <option value="16-50" selected>16 – 50 Employees (Growing Business)</option>
                                    <option value="51-200">51 – 200 Employees (Mid-Market)</option>
                                    <option value="200+">200+ Employees (Large Enterprise)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Primary Interest</label>
                                <select name="business_type" class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                    <option value="Full OS Suite">Full All-in-One Suite</option>
                                    <option value="HRM & Attendance">Biometric & GPS Attendance</option>
                                    <option value="Payroll & PF/ESI">Automated Payroll & Compliance</option>
                                    <option value="CRM & Deals">WhatsApp Sales CRM</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Preferred Date</label>
                                <input type="date" name="preferred_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                       class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-navy mb-1.5">Preferred Time Slot</label>
                                <select name="preferred_time" class="w-full text-xs px-4 py-3 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">
                                    <option value="11:00 AM">11:00 AM – 11:45 AM IST</option>
                                    <option value="02:30 PM" selected>02:30 PM – 03:15 PM IST</option>
                                    <option value="04:30 PM">04:30 PM – 05:15 PM IST</option>
                                    <option value="06:00 PM">06:00 PM – 06:45 PM IST</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-navy mb-1.5">Specific Requirements or Questions (Optional)</label>
                            <textarea name="message" rows="2" placeholder="Tell us about your team setup, biometric machines, or custom workflows..." 
                                      class="w-full text-xs p-3.5 rounded-xl border border-peri-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-white outline-none text-navy">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-aqua hover:bg-aqua-hover text-white font-extrabold text-sm tracking-wide shadow-aqua-glow transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                                <i class="fa-solid fa-calendar-check text-sm"></i>
                                <span>Confirm Demo Reservation</span>
                            </button>
                            <p class="text-[11px] text-navy-subtle text-center mt-2.5">
                                🔒 No credit card required. Free 14-day full platform access included.
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
