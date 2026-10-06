@extends('crm.layouts.master')

@section('title', 'Customers Directory')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Customer Management</h2>
            <p class="text-xs text-slate-500 font-medium">Retained client relationships, account histories, and corporate profiles</p>
        </div>
        <a href="{{ route('crm.admin.customers.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md shadow-emerald-900/10 flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add Customer</span>
        </a>
    </div>

    <!-- Customers Table Card -->
    <div class="crm-card overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <form method="GET" action="{{ route('crm.admin.customers.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." 
                       class="text-xs py-2 px-3 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 bg-slate-50 w-64">
                <button type="submit" class="py-2 px-3 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200">Search</button>
            </form>
            <span class="text-xs text-slate-400 font-medium">{{ $customers->total() }} accounts onboarded</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Account Code</th>
                        <th class="py-3 px-4">Client Name</th>
                        <th class="py-3 px-4">Company / Organization</th>
                        <th class="py-3 px-4">Phone / Contact</th>
                        <th class="py-3 px-4">Lifetime Spend</th>
                        <th class="py-3 px-4">Assigned Rep</th>
                        <th class="py-3 px-4">Account Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-700">{{ $c->customer_code }}</td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('crm.admin.customers.show', $c->id) }}" class="font-bold text-slate-900 hover:text-emerald-700">
                                    {{ $c->name }}
                                </a>
                                <div class="text-[11px] text-slate-400">{{ $c->email }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $c->company ?: 'Individual' }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $c->phone ?: '—' }}</td>
                            <td class="py-3.5 px-4 font-extrabold text-emerald-800">₹{{ number_format($c->total_spent) }}</td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $c->assignedEmployee ? $c->assignedEmployee->name : 'Unassigned' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('crm.admin.customers.show', $c->id) }}" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-[11px] font-bold text-slate-700 transition">
                                    360° Profile &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400">No customers registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Modal: Add Customer -->
    <div id="add-cust-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add Customer Record</h3>
                <button type="button" onclick="document.getElementById('add-cust-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.customers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Name *</label>
                        <input type="text" name="name" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company</label>
                        <input type="text" name="company" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Phone</label>
                        <input type="text" name="phone" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assign Rep</label>
                        <select name="assigned_to" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Unassigned</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Office Address</label>
                    <textarea name="address" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-cust-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
