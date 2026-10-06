@extends('hisab_mittra.layouts.master')

@section('title', 'About Us — Hisab Mittra Technologies')

@section('content')
<div class="py-16 sm:py-24">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl mb-16">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-aqua-soft border border-aqua-border text-navy text-[11px] font-bold uppercase tracking-wider mb-3">
            Our Purpose & Vision
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy">
            Empowering Indian Enterprises to 
            <span class="font-sans not-italic font-extrabold text-black">Scale with Confidence</span>
        </h1>
        <p class="mt-4 text-base text-navy-muted leading-relaxed">
            Hisab Mittra was founded with one clear conviction: Indian businesses shouldn't have to juggle five fragmented foreign tools to run everyday HR, payroll, attendance, and sales.
        </p>
    </div>

    <!-- Story Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-aqua-border/60 shadow-luxury-card grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-4 text-xs sm:text-sm text-navy-muted leading-relaxed">
                <h2 class="text-2xl font-bold text-navy">The Problem We Solved</h2>
                <p>
                    Most business software sold in India was built for Western companies. It fails at Indian realities: complex state-wise Professional Tax slabs, mandatory Provident Fund ECR formats, ESIC wage thresholds, multi-shift factory rosters, and WhatsApp-driven sales communication.
                </p>
                <p>
                    We built Hisab Mittra from the ground up for Indian founders, CFOs, and HR leaders who demand simplicity, 100% legal compliance, and extreme operational reliability.
                </p>
                <div class="pt-2 flex items-center gap-6">
                    <div>
                        <div class="text-2xl font-black text-aqua-dark">2021</div>
                        <div class="text-[11px] text-navy-muted">Founded in Gurugram</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-aqua-dark">2,400+</div>
                        <div class="text-[11px] text-navy-muted">Active Indian Clients</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-aqua-dark">45,000+</div>
                        <div class="text-[11px] text-navy-muted">Daily Check-Ins</div>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-mint border border-aqua-border/60 space-y-4">
                <h3 class="text-base font-bold text-navy">Our Core Principles</h3>
                <div class="space-y-3 text-xs">
                    <div class="p-3 bg-white rounded-xl border border-aqua-border/40">
                        <strong class="text-aqua-dark block font-bold mb-0.5">1. Indian Statutory Accuracy First</strong>
                        <span class="text-navy-muted">Every PF, ESI, PT, and TDS calculation must be mathematically and legally flawless.</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-aqua-border/40">
                        <strong class="text-aqua-dark block font-bold mb-0.5">2. Built for Real Indian Workplaces</strong>
                        <span class="text-navy-muted">Zero complex setups. A factory supervisor or store manager can use it without IT assistance.</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-aqua-border/40">
                        <strong class="text-aqua-dark block font-bold mb-0.5">3. Bank-Grade Security & Indian Data Residency</strong>
                        <span class="text-navy-muted">100% of your company and employee records are stored in MeitY-certified Indian cloud servers.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
