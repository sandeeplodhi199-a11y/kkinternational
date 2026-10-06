@extends('crm.layouts.master')

@section('title', 'My Active Deals')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Sales Opportunities</h2>
        <p class="text-xs text-slate-500 font-medium">Deals you are currently negotiating and driving toward closure</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($deals as $deal)
            <div class="crm-card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-400">Deal Opportunity</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">{{ $deal->stage }}</span>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800 mb-1 leading-snug">{{ $deal->title }}</h3>
                    <p class="text-xs text-slate-500 mb-4">{{ $deal->customer ? $deal->customer->name : 'Commercial Prospect' }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deal Value</span>
                        <span class="text-base font-black text-[#1b4d3e]">₹{{ number_format($deal->value) }}</span>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                        {{ $deal->probability }}% Win
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 crm-card">
                No active deals assigned to you.
            </div>
        @endforelse
    </div>
</div>
@endsection
