@extends('hisab_mittra.layouts.master')

@section('title', 'Insights & Guides — Hisab Mittra Knowledge Hub')

@section('content')
<div class="py-16 sm:py-24">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl mb-16">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-aqua-soft border border-aqua-border text-navy text-[11px] font-bold uppercase tracking-wider mb-3">
            Knowledge & Best Practices
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-navy">
            The Playbook for 
            <span class="font-sans not-italic font-extrabold text-black">Indian Business Growth</span>
        </h1>
        <p class="mt-4 text-base text-navy-muted leading-relaxed">
            Practical insights on Indian statutory compliance, biometric workforce management, and WhatsApp-driven sales workflows.
        </p>
    </div>

    <!-- Articles Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($posts as $post)
                <div class="p-8 rounded-3xl bg-white border border-aqua-border/60 shadow-soft-elevation hover:shadow-luxury-card transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between text-xs text-navy-muted mb-3">
                            <span class="px-3 py-0.5 rounded-full bg-aqua-soft text-aqua-dark font-bold text-[10px] uppercase tracking-wider">
                                {{ $post['category'] }}
                            </span>
                            <span>{{ $post['read_time'] }} &bull; {{ $post['date'] }}</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-navy group-hover:text-aqua-dark transition-colors mb-3 leading-snug">
                            {{ $post['title'] }}
                        </h2>
                        <p class="text-xs sm:text-sm text-navy-muted leading-relaxed">
                            {{ $post['excerpt'] }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-mint flex items-center justify-between text-xs">
                        <span class="font-bold text-navy">{{ $post['author'] }}</span>
                        <a href="javascript:void(0)" onclick="alert('Full whitepaper available in the resource center.')" class="font-bold text-aqua-dark hover:underline flex items-center gap-1">
                            <span>Read Guide</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
