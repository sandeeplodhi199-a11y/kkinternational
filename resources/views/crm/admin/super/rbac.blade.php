@extends('crm.layouts.master')

@section('title', 'Employee Roles & Permission Matrix')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-user-shield text-emerald-600 text-2xl"></i>
                <span>Employee Permission Configuration</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-bold mt-1">
                Yaha se permissions ON/OFF karne par directly employee panel ke features allow ya restrict ho jayenge.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                <span>Live Role-Based Access Control</span>
            </span>
        </div>
    </div>

        <!-- Active Roles Overview Cards (Compact & Clean) -->
    <div class="flex items-center flex-wrap gap-3">
        @foreach($roles as $role)
            <div class="crm-card p-3 sm:p-3.5 border border-emerald-200 bg-emerald-50/20 rounded-2xl max-w-sm shadow-xs">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200 font-black text-xs flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-tie"></i>
                        </span>
                        <div>
                            <h3 class="text-xs font-black text-slate-900 leading-tight">{{ $role->name }} Role</h3>
                            <span class="text-[10px] font-mono text-slate-400">{{ $role->slug }}</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 shrink-0">
                        {{ $role->permissions->count() }} Active Rights
                    </span>
                </div>
                <p class="text-[11px] font-medium text-slate-600 leading-tight">
                    Applies directly to assigned portal employees (Vipin, Rahul, Nandkishor, sunny, etc.).
                </p>
                <div class="pt-2 border-t border-emerald-200/60 mt-2 flex items-center justify-between text-[11px]">
                    <span class="font-bold text-slate-400 text-[10px] uppercase tracking-wider">Access Scope:</span>
                    <span class="font-black text-emerald-700 text-[10px] tracking-wider">EMPLOYEE PORTAL</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Permission Matrix Form (Only Employee Role) -->
    @foreach($roles as $role)
        <div class="crm-card p-6 border border-slate-200 shadow-sm rounded-3xl">
            <form id="rbac-form-{{ $role->id }}" action="{{ route('crm.admin.super.rbac.update', $role->id) }}" method="POST">
                @csrf
                
                <!-- Card Header with Select All / Deselect All Controls -->
                <div class="flex items-center justify-between pb-5 border-b border-slate-200 mb-6 flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center font-black text-base shadow-sm">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900">{{ $role->name }} Operations & Permission Matrix</h3>
                            <p class="text-xs font-semibold text-slate-500 mt-0.5">Check or uncheck boxes below and click Save to immediately update employee access rights.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="selectAllPermissions('rbac-form-{{ $role->id }}', true)" 
                                class="px-3.5 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-check-double text-emerald-600 text-[11px]"></i>
                            <span>Select All</span>
                        </button>
                        <button type="button" onclick="selectAllPermissions('rbac-form-{{ $role->id }}', false)" 
                                class="px-3.5 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-xmark text-rose-500 text-[11px]"></i>
                            <span>Deselect All</span>
                        </button>
                    </div>
                </div>

                <!-- Granular Module Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissions as $moduleName => $perms)
                        <div class="p-4 rounded-2xl border border-slate-200/90 bg-slate-50/50 space-y-3 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                <span class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                                    @if($moduleName === 'Leads')
                                        <i class="fa-solid fa-user-tag text-orange-500 text-xs"></i>
                                    @elseif($moduleName === 'Deals')
                                        <i class="fa-solid fa-handshake text-purple-500 text-xs"></i>
                                    @elseif($moduleName === 'Customers')
                                        <i class="fa-solid fa-users text-blue-500 text-xs"></i>
                                    @elseif($moduleName === 'Quotations')
                                        <i class="fa-solid fa-file-invoice text-emerald-500 text-xs"></i>
                                    @elseif($moduleName === 'Payments')
                                        <i class="fa-solid fa-credit-card text-teal-500 text-xs"></i>
                                    @elseif($moduleName === 'Operations')
                                        <i class="fa-solid fa-list-check text-rose-500 text-xs"></i>
                                    @else
                                        <i class="fa-solid fa-folder-tree text-indigo-500 text-xs"></i>
                                    @endif
                                    <span>{{ $moduleName }} Module</span>
                                </span>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-600">
                                    {{ $perms->count() }} Actions
                                </span>
                            </div>

                            <div class="space-y-2.5 pt-1">
                                @foreach($perms as $p)
                                    @php
                                        $isChecked = $role->permissions->contains('id', $p->id);
                                    @endphp
                                    <label class="flex items-start gap-3 p-2 rounded-xl hover:bg-white transition cursor-pointer select-none border border-transparent hover:border-slate-200/60">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $p->id }}" 
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="perm-checkbox w-4 h-4 mt-0.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                        <div class="flex-1">
                                            <span class="font-bold text-xs text-slate-900 block leading-tight">{{ $p->name }}</span>
                                            <span class="text-[10px] font-mono font-semibold text-slate-400 block mt-0.5">{{ $p->slug }}</span>
                                            @if($p->slug === 'leads.mask_phone')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                                    Privacy: Hides full phone number from employee
                                                </span>
                                            @elseif($p->slug === 'leads.view')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-600">
                                                    Required to access "My Leads" &amp; view leads on dashboard
                                                </span>
                                            @elseif($p->slug === 'deals.view')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-600">
                                                    Required to access "My Deals" &amp; pipeline
                                                </span>
                                            @elseif($p->slug === 'customers.view')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-600">
                                                    Required to access "My Customers" directory
                                                </span>
                                            @elseif($p->slug === 'tasks.manage')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-600">
                                                    Required to access "My Tasks"
                                                </span>
                                            @elseif($p->slug === 'followups.manage')
                                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-600">
                                                    Required to access "My Follow-ups"
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Save Action Bar -->
                <div class="pt-6 mt-6 border-t border-slate-200 flex items-center justify-between flex-wrap gap-4 bg-slate-50/50 p-4 rounded-2xl">
                    <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold">
                        <i class="fa-solid fa-circle-info text-blue-500"></i>
                        <span>Changes apply immediately across all employee logins upon saving.</span>
                    </div>

                    <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-black shadow-lg shadow-emerald-600/25 transition-all duration-150 active:scale-98 flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Save Employee Permissions</span>
                    </button>
                </div>
            </form>
        </div>
    @endforeach

</div>

<script>
    function selectAllPermissions(formId, checkState) {
        const form = document.getElementById(formId);
        if (!form) return;
        const checkboxes = form.querySelectorAll('.perm-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = checkState;
        });
    }
</script>
@endsection
