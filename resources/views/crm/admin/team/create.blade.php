@extends('crm.layouts.master')

@section('title', 'Onboard New Employee')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.team.index') }}" class="hover:text-blue-600 transition">Team Management</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Onboard Staff</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-shield"></i>
                </span>
                <span>Onboard Employee / Representative</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Create user login credentials, assign operational departments, sales targets, and security role.
            </p>
        </div>

        <a href="{{ route('crm.admin.team.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Team</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.team.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Personal & Login Credentials -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-blue-600 text-xs"></i>
                        <span>Profile & Login Credentials</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Full Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Anand Verma" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Work Email (Login ID) *</label>
                        <input type="email" name="email" required placeholder="anand@hisabmittra.com" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Phone Number</label>
                        <input type="text" name="phone" placeholder="+91 98765 00000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Account Password</label>
                        <input type="password" name="password" placeholder="Default: 12345678" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <p class="text-[11px] text-slate-500 font-semibold mt-1">Default password: <strong class="text-blue-600 font-bold">12345678</strong> (Blank chhodne par yahi set hoga).</p>
                    </div>
                </div>
            </div>

            <!-- Role, Department & Designation -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-sitemap text-blue-600 text-xs"></i>
                        <span>Department & Operational Role</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Department</label>
                        <select name="department_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">-- Choose Department --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Designation Title</label>
                        <input type="text" name="designation" placeholder="e.g. Senior Account Executive" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Security Role *</label>
                        <select name="role" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Sales" selected>Sales Executive</option>
                            <option value="Manager">Regional Manager</option>
                            <option value="Telecaller">Telecaller / Inbound</option>
                            <option value="Support">Support Specialist</option>
                            <option value="Admin">Administrator</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Targets & Joining Date -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-bullseye text-blue-600 text-xs"></i>
                        <span>Target Performance & Joining</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Monthly Revenue Target (₹)</label>
                        <input type="number" step="0.01" name="target_amount" placeholder="e.g. 500000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Joining Date</label>
                        <input type="date" name="joining_date" value="{{ date('Y-m-d') }}" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.team.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shadow-md shadow-blue-600/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Onboard Employee</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
