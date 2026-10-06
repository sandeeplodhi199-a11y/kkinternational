@extends('crm.layouts.master')

@section('title', 'Add Product / Service')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.products.index') }}" class="hover:text-emerald-700 transition">Products & Services</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">New Item</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-box-open"></i>
                </span>
                <span>Add Product / Service Catalog Item</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Configure billable items, SKU codes, tax percentages, and standard commercial pricing.
            </p>
        </div>

        <a href="{{ route('crm.admin.products.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Products</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.products.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Product Identifiers -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-barcode text-emerald-600 text-xs"></i>
                        <span>Item Identification & Category</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Product / Service Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Enterprise Cloud ERP License (1 Year)" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">SKU / Item Code</label>
                        <input type="text" name="code" placeholder="e.g. ERP-CLOUD-01" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>
            </div>

            <!-- Pricing & Taxation -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-indian-rupee-sign text-emerald-600 text-xs"></i>
                        <span>Commercial Pricing & Taxes</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Category *</label>
                        <select name="category" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Software" selected>Software & SaaS</option>
                            <option value="Service">Professional Service</option>
                            <option value="Consulting">Consulting / Training</option>
                            <option value="Hardware">Hardware / Equipment</option>
                            <option value="Support">Annual Maintenance (AMC)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Base Unit Price (₹) *</label>
                        <input type="number" step="0.01" name="price" required placeholder="e.g. 45000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">GST Tax Rate (%) *</label>
                        <select name="tax_rate" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="18" selected>18% (Standard GST)</option>
                            <option value="12">12% GST</option>
                            <option value="5">5% GST</option>
                            <option value="0">0% (Tax Exempt)</option>
                            <option value="28">28% (Luxury)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Availability & Description -->
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Listing Status *</label>
                        <select name="status" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Active" selected>Active Catalog</option>
                            <option value="Inactive">Discontinued / Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Item Scope & Deliverables Description</label>
                    <textarea name="description" rows="3" placeholder="Full specification, SLA commitments, user seat limitations..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.products.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-black shadow-md shadow-emerald-700/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Product</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
