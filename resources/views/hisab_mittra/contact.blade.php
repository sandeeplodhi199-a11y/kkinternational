@extends('hisab_mittra.layouts.master')

@section('title', 'Contact Sales & Support — Hisab Mittra')

@section('content')
<div class="py-16 sm:py-24">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl mb-16">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-aqua-soft border border-aqua-border text-navy text-[11px] font-bold uppercase tracking-wider mb-3">
            Get in Touch
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy">
            We’re Here to Help You 
            <span class="font-sans not-italic font-extrabold text-black">Modernize</span>
        </h1>
        <p class="mt-4 text-base text-navy-muted leading-relaxed">
            Have questions about our enterprise plans, biometric attendance hardware integration, or statutory payroll migration? Reach our advisory team.
        </p>
    </div>

    <!-- Contact Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Info Cards (1 col) -->
            <div class="space-y-4">
                <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3 class="text-sm font-bold text-navy">Direct Sales Hotline</h3>
                    <p class="text-xs text-navy-muted">Mon–Sat from 09:30 AM to 07:00 PM IST</p>
                    <a href="tel:+919783055170" class="text-xs font-bold text-aqua-dark block hover:underline">+91 97830 55170</a>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-aqua-soft text-navy flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h3 class="text-sm font-bold text-navy">Enterprise Support</h3>
                    <p class="text-xs text-navy-muted">Guaranteed response within 2 hours</p>
                    <a href="mailto:support@hisabmittra.com" class="text-xs font-bold text-aqua-dark block hover:underline">support@hisabmittra.com</a>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-peri-mist text-navy flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="text-sm font-bold text-navy">Headquarters</h3>
                    <p class="text-xs text-navy-muted leading-relaxed">
                        Level 8, Tower B, DLF Cyber City, Phase III, Gurugram, Haryana &bull; 122002<br>
                        Bengaluru Office: Indiranagar, 100ft Road, Bengaluru, Karnataka &bull; 560038
                    </p>
                </div>
            </div>

            <!-- Right Interactive Form (2 cols) -->
            <div class="lg:col-span-2 p-8 sm:p-10 rounded-3xl bg-white border border-aqua-border/70 shadow-luxury-card">
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <h3 class="text-xl font-bold text-navy mb-1">Send a Message to Enterprise Sales</h3>
                <p class="text-xs text-navy-muted mb-6">Fill in your requirements and an enterprise specialist will get in touch with you shortly.</p>

                <form action="{{ route('hisab.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-navy mb-1">Full Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Vikram Malhotra" 
                                   class="w-full text-xs px-4 py-3 rounded-xl border border-aqua-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-mint outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy mb-1">Business / Company Name *</label>
                            <input type="text" name="company" required placeholder="e.g. Apex Enterprises" 
                                   class="w-full text-xs px-4 py-3 rounded-xl border border-aqua-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-mint outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-navy mb-1">Work Email Address *</label>
                            <input type="email" name="email" required placeholder="vikram@apexenterprises.in" 
                                   class="w-full text-xs px-4 py-3 rounded-xl border border-aqua-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-mint outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy mb-1">WhatsApp / Phone Number *</label>
                            <input type="tel" name="phone" required placeholder="+91 97830 55170" 
                                   class="w-full text-xs px-4 py-3 rounded-xl border border-aqua-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-mint outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy mb-1">How can our platform assist you? *</label>
                        <textarea name="message" rows="4" required placeholder="Tell us about your team size, current software, or specific requirements (e.g. Biometric Attendance, Payroll calculation, WhatsApp CRM)..." 
                                  class="w-full text-xs p-4 rounded-xl border border-aqua-border focus:border-aqua focus:ring-2 focus:ring-aqua/20 bg-mint outline-none"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-8 py-3.5 rounded-xl bg-aqua hover:bg-aqua-hover text-aqua-dark font-bold text-xs tracking-wide shadow-aqua-glow transition-all duration-200">
                            Submit Inquiry &rarr;
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
