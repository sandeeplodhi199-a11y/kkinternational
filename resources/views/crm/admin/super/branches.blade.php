@extends('crm.layouts.master')

@section('title', 'Multi-Branch & Location Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Multi-Branch & Location Management</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Centrally control multiple company entities, regional sales offices, and track aggregated performance.
            </p>
        </div>

        <a href="{{ route('crm.admin.super.branches.create') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black shadow-lg shadow-orange-500/25 hover:from-orange-600 hover:to-amber-600 transition cursor-pointer flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Add New Branch</span>
        </a>
    </div>

    <!-- Branches Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($branches as $b)
            <div class="crm-card p-6 flex flex-col justify-between border border-slate-200 hover:shadow-lg transition">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-600 border border-orange-200 flex items-center justify-center font-black text-sm">
                            <i class="fa-solid fa-building-circle-check"></i>
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $b->status === 'Active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $b->status }}
                        </span>
                    </div>

                    <h3 class="text-base font-black text-slate-900 mb-0.5">{{ $b->name }}</h3>
                    <span class="text-xs font-mono font-black text-orange-600 block mb-2">{{ $b->code }}</span>
                    <p class="text-xs font-bold text-slate-600 mb-4 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                        <span>{{ $b->city ?: 'India' }}</span>
                    </p>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5 text-xs">
                        <div class="flex items-center justify-between font-bold text-slate-700">
                            <span>Phone:</span>
                            <span class="font-black text-slate-900">{{ $b->phone ?: '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between font-bold text-slate-700">
                            <span>Email:</span>
                            <span class="font-black text-slate-900 truncate max-w-[140px]">{{ $b->email ?: '—' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-3 text-xs font-black text-slate-800">
                        <span><strong class="text-orange-600">{{ $b->employees_count }}</strong> Reps</span>
                        <span>&bull;</span>
                        <span><strong class="text-blue-600">{{ $b->leads_count }}</strong> Leads</span>
                    </div>

                    <form action="{{ route('crm.admin.super.branches.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Delete branch {{ $b->name }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition cursor-pointer" title="Delete Branch">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 font-bold crm-card">
                No branches configured yet. Click 'Add New Branch' above.
            </div>
        @endforelse
    </div>

</div>

<!-- MODAL: ADD BRANCH -->
<div id="addBranchModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-black text-slate-900">Add Company Branch</h3>
            <button type="button" onclick="document.getElementById('addBranchModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-sm font-bold">&times;</button>
        </div>
        <form action="{{ route('crm.admin.super.branches.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Branch Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Pune Regional Hub" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Branch Code *</label>
                    <input type="text" name="code" required placeholder="e.g. BR-PUN" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">City / State</label>
                    <input type="text" name="city" placeholder="e.g. Pune, Maharashtra" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Contact Phone</label>
                    <input type="text" name="phone" placeholder="+91 20 45678900" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Office Email</label>
                <input type="email" name="email" placeholder="pune@hisabmittra.com" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Physical Address</label>
                <textarea name="address" rows="2" placeholder="Full office street address..." class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addBranchModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl border border-slate-300 text-xs font-black text-slate-700 hover:bg-slate-50 cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black shadow-md transition cursor-pointer">Save Branch</button>
            </div>
        </form>
    </div>
</div>
@endsection
