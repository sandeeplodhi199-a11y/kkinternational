@extends('crm.layouts.master')

@section('title', 'Create Custom Security Role')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.super.rbac') }}" class="hover:text-rose-600 transition">RBAC Governance</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">New Custom Role</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <span>Create Custom Security Role</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Define role identifier, operational boundaries, and grant granular action-level access permissions.
            </p>
        </div>

        <a href="{{ route('crm.admin.super.rbac') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Roles & Permissions</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.super.rbac.role.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Role Identifiers -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-id-badge text-rose-600 text-xs"></i>
                        <span>Role Details & Internal Slug</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Role Display Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Regional Branch Manager" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Role Slug (Unique Code) *</label>
                        <input type="text" name="slug" required placeholder="e.g. branch_manager" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Description & Scope of Duties</label>
                    <textarea name="description" rows="2" placeholder="Brief summary of duties and operational permissions for this role..." class="w-full text-xs p-3.5 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                </div>
            </div>

            <!-- Granular Permissions Matrix -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-key text-rose-600 text-xs"></i>
                        <span>Select Granted Action Permissions</span>
                    </h3>
                    <button type="button" onclick="document.querySelectorAll('.perm-checkbox').forEach(c => c.checked = true)" class="text-xs font-bold text-rose-600 hover:underline">
                        Select All
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($permissions as $moduleName => $perms)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                <span class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                                    <i class="fa-solid fa-folder text-orange-500 text-xs"></i>
                                    {{ $moduleName }}
                                </span>
                                <span class="text-[10px] font-black text-slate-500">{{ $perms->count() }} Actions</span>
                            </div>

                            <div class="space-y-2">
                                @foreach($perms as $p)
                                    <label class="flex items-start gap-2.5 cursor-pointer text-xs select-none">
                                        <input type="checkbox" name="permissions[]" value="{{ $p->id }}" class="perm-checkbox w-4 h-4 mt-0.5 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                        <div>
                                            <span class="font-black text-slate-900 block leading-tight">{{ $p->name }}</span>
                                            <span class="text-[10px] font-mono text-slate-500">{{ $p->slug }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.super.rbac') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-gradient-to-r from-rose-600 to-purple-600 hover:from-rose-700 hover:to-purple-700 text-white text-xs font-black shadow-md shadow-rose-600/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Create Role & Assign Rights</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
