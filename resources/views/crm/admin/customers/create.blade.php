@extends('crm.layouts.master')

@section('title', 'Add New Customer')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.customers.index') }}" class="hover:text-blue-600 transition">Customers</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Add Customer</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-building-user"></i>
                </span>
                <span>Add Customer Account</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Register verified client accounts, billing information, and assign dedicated relationship managers.
            </p>
        </div>

        <a href="{{ route('crm.admin.customers.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Customers</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.customers.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Client Identification -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-id-badge text-blue-600 text-xs"></i>
                        <span>Primary Client Identification</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Full Name / Contact Person *</label>
                        <input type="text" name="name" required placeholder="e.g. Ramesh Chandra" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Company / Legal Business Entity</label>
                        <input type="text" name="company" placeholder="e.g. Chandra Enterprises Pvt Ltd" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Phone Number</label>
                        <input type="text" name="phone" placeholder="+91 98290 11223" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Email Address</label>
                        <input type="email" name="email" placeholder="contact@chandraenterprises.com" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- Billing Address & Location -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-blue-600 text-xs"></i>
                        <span>Address & Location Details</span>
                    </h3>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Billing & Delivery Address</label>
                    <textarea name="address" rows="2" placeholder="Full street, city, pin code..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                </div>
            </div>

            <!-- Management & Lifecycle Status -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-blue-600 text-xs"></i>
                        <span>Account Assignment & Status</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Account Manager / Representative</label>
                        <select name="assigned_to" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">Unassigned</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Customer Status *</label>
                        <select name="status" required class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Active" selected>Active Client</option>
                            <option value="Inactive">Inactive / Suspended</option>
                            <option value="Lead">Prospective Customer</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Operational Notes -->
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Account Notes & Terms</label>
                <textarea name="notes" rows="3" placeholder="Credit terms, special billing conditions, preferences..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.customers.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shadow-md shadow-blue-600/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Customer</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
