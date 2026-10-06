@extends('crm.layouts.master')

@section('title', 'Products & Services Catalog')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Products & Services Catalog</h2>
            <p class="text-xs text-slate-500 font-medium">Enterprise software tiers, recurring subscriptions, and professional services</p>
        </div>
        <a href="{{ route('crm.admin.products.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add Offering</span>
        </a>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($products as $p)
            <div class="crm-card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700">
                            {{ $p->category }}
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                            {{ $p->status }}
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-800 mb-1">{{ $p->name }}</h3>
                    <p class="text-xs text-slate-400 font-mono mb-3">{{ $p->code }}</p>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed font-medium">
                        {{ $p->description ?: 'No detailed description.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Standard Price</span>
                        <span class="text-lg font-black text-slate-900">₹{{ number_format($p->price, 2) }}</span>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500">+ {{ $p->tax_rate }}% GST</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 crm-card">
                No products or services registered.
            </div>
        @endforelse
    </div>

    <!-- Modal: Add Product -->
    <div id="add-prod-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add Product / Service Offering</h3>
                <button type="button" onclick="document.getElementById('add-prod-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.products.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Item Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Enterprise Cloud CRM License" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Item Code</label>
                        <input type="text" name="code" placeholder="e.g. PRD-CRM-ENT" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category *</label>
                        <select name="category" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Software">Software</option>
                            <option value="Service">Professional Service</option>
                            <option value="Subscription">Subscription</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Base Price (₹) *</label>
                        <input type="number" name="price" required value="75000" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" value="18" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>
                <input type="hidden" name="status" value="Active">
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-prod-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Offering</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
