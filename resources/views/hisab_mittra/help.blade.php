@extends('hisab_mittra.layouts.master')

@section('title', 'Help Center & Documentation — Hisab Mittra')

@section('content')
<div class="py-16 sm:py-24">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl mb-16">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-aqua-soft border border-aqua-border text-navy text-[11px] font-bold uppercase tracking-wider mb-3">
            Customer Support & Setup Guides
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy">
            How Can We 
            <span class="font-sans not-italic font-extrabold text-black">Assist You?</span>
        </h1>
        <p class="mt-4 text-base text-navy-muted leading-relaxed">
            Search our setup guides, statutory compliance documentation, and video walkthroughs.
        </p>
    </div>

    <!-- 6 Help Categories -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-lg">
                    <i class="fa-solid fa-play"></i>
                </div>
                <h3 class="text-base font-bold text-navy">Quick Setup Guide</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Setting up your company master, branch offices, and adding your first 50 employees in under 10 minutes.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">Read Walkthrough &rarr;</a>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-peri-mist text-navy flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <h3 class="text-base font-bold text-navy">Payroll & PF/ESI Rules</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Configuring state Professional Tax slabs, EPF wage thresholds, ESIC contribution splits, and generating monthly ECR files.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">View Tax Compliance &rarr;</a>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-peri-mist text-navy flex items-center justify-center text-lg">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <h3 class="text-base font-bold text-navy">Face & Biometric Setup</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Connecting external eSSL / ZKTeco biometric devices or mounting a tablet kiosk for touchless face recognition.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">Hardware Documentation &rarr;</a>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-aqua-soft text-aqua-dark flex items-center justify-center text-lg">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="text-base font-bold text-navy">WhatsApp Cloud API</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Connecting your Meta WhatsApp Business number, creating approved quotation templates, and automated follow-ups.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">API Integration Guide &rarr;</a>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-peri-mist text-navy flex items-center justify-center text-lg">
                    <i class="fa-solid fa-file-excel"></i>
                </div>
                <h3 class="text-base font-bold text-navy">Data Import & Export</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Bulk importing staff from Excel, downloading attendance registers, and exporting sales pipeline records.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">CSV Templates & Download &rarr;</a>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation space-y-3">
                <div class="w-10 h-10 rounded-xl bg-peri-mist text-navy flex items-center justify-center text-lg">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-base font-bold text-navy">Roles & Security</h3>
                <p class="text-xs text-navy-muted leading-relaxed">Configuring granular permissions for Super Admin, HR Managers, Branch Supervisors, and Sales Executives.</p>
                <a href="javascript:void(0)" class="text-xs font-bold text-aqua-dark hover:underline block">Security Settings &rarr;</a>
            </div>

        </div>
    </div>
</div>
@endsection
