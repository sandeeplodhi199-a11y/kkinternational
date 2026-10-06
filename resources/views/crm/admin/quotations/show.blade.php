@extends('crm.layouts.master')

@section('title', 'Quotation #' . $quotation->quotation_no)

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header Actions -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.quotations.index') }}" class="w-9 h-9 rounded-full bg-white border border-[#e7ece4] flex items-center justify-center text-slate-600 hover:text-slate-900 shadow-sm transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Proposal {{ $quotation->quotation_no }}</h2>
                <span class="text-xs text-slate-500">Issued to {{ $quotation->customer_name }} on {{ $quotation->quotation_date }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.quotations.print', $quotation->id) }}" target="_blank" class="px-4 py-2 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-print text-slate-500"></i>
                <span>Print</span>
            </a>
            <a href="{{ route('crm.admin.quotations.pdf', $quotation->id) }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-download text-xs"></i>
                <span>Download PDF</span>
            </a>
        </div>
    </div>

    <!-- Official Quotation Document Box -->
    <div class="crm-card p-8 md:p-12 space-y-8 bg-white border border-slate-200">
        <!-- Top Letterhead -->
        <div class="flex items-start justify-between pb-6 border-b border-slate-100 flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-xl bg-[#1b4d3e] text-white flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-shapes"></i>
                    </div>
                    <span class="text-lg font-black text-slate-800">{{ $settings['company_name'] }}</span>
                </div>
                <p class="text-xs text-slate-500">{{ $settings['company_tagline'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $settings['support_email'] }} &bull; {{ $settings['support_phone'] }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-black uppercase tracking-widest text-[#de7349] block">Commercial Quotation</span>
                <span class="text-xl font-black text-slate-800">{{ $quotation->quotation_no }}</span>
                <div class="text-xs text-slate-500 mt-1">Date: <span class="font-bold text-slate-700">{{ $quotation->quotation_date }}</span></div>
                <div class="text-xs text-slate-500">Valid: <span class="font-bold text-slate-700">{{ $quotation->valid_until ?: '15 Days' }}</span></div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="grid grid-cols-2 gap-6 text-xs">
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider block mb-1">Prepared For</span>
                <div class="font-extrabold text-sm text-slate-800">{{ $quotation->customer_name }}</div>
                <div class="text-slate-600 mt-0.5">{{ $quotation->customer_email }}</div>
                <div class="text-slate-600">{{ $quotation->customer_phone }}</div>
            </div>
            <div class="text-right">
                <span class="text-slate-400 font-bold uppercase tracking-wider block mb-1">Payment Terms</span>
                <div class="text-slate-700 font-semibold">Net 15 Days &bull; Bank Transfer / UPI</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Status: <span class="font-bold text-emerald-700">{{ $quotation->status }}</span></div>
            </div>
        </div>

        <!-- Table of Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-2.5">Item & Description</th>
                        <th class="py-2.5 text-center">Qty</th>
                        <th class="py-2.5 text-right">Unit Price</th>
                        <th class="py-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($quotation->items as $item)
                        <tr>
                            <td class="py-3">
                                <div class="font-bold text-slate-800">{{ $item->item_name }}</div>
                            </td>
                            <td class="py-3 text-center text-slate-700 font-bold">{{ $item->quantity }}</td>
                            <td class="py-3 text-right text-slate-700">₹{{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-3 text-right font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals & Notes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
            <div class="text-xs space-y-3">
                @if($quotation->notes)
                    <div>
                        <span class="font-bold text-slate-700 block mb-1">Notes:</span>
                        <p class="text-slate-500 leading-relaxed">{{ $quotation->notes }}</p>
                    </div>
                @endif
                @if($quotation->terms)
                    <div>
                        <span class="font-bold text-slate-700 block mb-1">Terms:</span>
                        <p class="text-slate-500 leading-relaxed whitespace-pre-line">{{ $quotation->terms }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-2 text-xs max-w-xs ml-auto w-full">
                <div class="flex justify-between text-slate-600 font-medium">
                    <span>Subtotal:</span>
                    <span class="font-bold">₹{{ number_format($quotation->subtotal, 2) }}</span>
                </div>
                @if($quotation->discount_amount > 0)
                    <div class="flex justify-between text-rose-700 font-medium">
                        <span>Discount:</span>
                        <span class="font-bold">- ₹{{ number_format($quotation->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-slate-600 font-medium">
                    <span>GST (18%):</span>
                    <span class="font-bold">₹{{ number_format($quotation->tax_amount, 2) }}</span>
                </div>
                <div class="pt-3 border-t border-slate-200 flex justify-between font-black text-slate-900 text-sm">
                    <span>Grand Total:</span>
                    <span class="text-[#1b4d3e]">₹{{ number_format($quotation->grand_total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
