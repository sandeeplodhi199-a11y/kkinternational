@extends('crm.layouts.master')

@section('title', 'Edit Employee - ' . $employee->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.team.index') }}" class="hover:text-blue-600 transition">Team Management</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-900 font-extrabold">Edit Employee</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-pen"></i>
                </span>
                <span>Edit Employee: {{ $employee->name }}</span>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-mono">{{ $employee->employee_code ?: 'EMP-' . $employee->id }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                Update account details, operational department, permissions, role, and sales targets.
            </p>
        </div>

        <a href="{{ route('crm.admin.team.index') }}" class="px-4 py-2.5 rounded-2xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Team</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="crm-card p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-3xl">
        <form action="{{ route('crm.admin.team.update', $employee->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                        <input type="text" name="name" value="{{ old('name', $employee->name) }}" required placeholder="e.g. Anand Verma" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Work Email (Login ID) *</label>
                        <input type="email" name="email" value="{{ old('email', $employee->email) }}" required placeholder="anand@kkinternational.com" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" placeholder="+91 98765 00000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Reset Password <span class="text-slate-400 font-normal">(Leave blank to keep existing)</span></label>
                        <input type="password" name="password" placeholder="New password (min 6 characters)" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- Role, Department & Designation -->
            <div>
                <div class="pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-sitemap text-blue-600 text-xs"></i>
                        <span>Department, Role & Status</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Department</label>
                        <select name="department_id" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">-- Choose Department --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Designation Title</label>
                        <input type="text" name="designation" value="{{ old('designation', $employee->designation) }}" placeholder="e.g. Senior Account Executive" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Security Role *</label>
                        <select name="role" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Sales" {{ old('role', $employee->role) == 'Sales' ? 'selected' : '' }}>Sales Executive</option>
                            <option value="Manager" {{ old('role', $employee->role) == 'Manager' ? 'selected' : '' }}>Regional Manager</option>
                            <option value="Telecaller" {{ old('role', $employee->role) == 'Telecaller' ? 'selected' : '' }}>Telecaller / Inbound</option>
                            <option value="Support" {{ old('role', $employee->role) == 'Support' ? 'selected' : '' }}>Support Specialist</option>
                            <option value="Admin" {{ old('role', $employee->role) == 'Admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Account Status *</label>
                        <select name="status" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <input type="number" step="0.01" name="target_amount" value="{{ old('target_amount', $employee->target_amount) }}" placeholder="e.g. 500000" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-black text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Joining Date</label>
                        <input type="date" name="joining_date" value="{{ old('joining_date', $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('Y-m-d') : date('Y-m-d')) }}" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('crm.admin.team.index') }}" class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-black transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-black shadow-md shadow-amber-500/20 transition cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Update Employee</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
