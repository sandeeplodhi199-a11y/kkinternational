@extends('crm.layouts.master')

@section('title', 'Security, Session Monitor & Access Control')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Security, Sessions & IP Access Control</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Monitor active employee devices, enforce IP whitelisting, remote force-logout, and contact number masking.
            </p>
        </div>
    </div>

    <!-- Security Policies Form -->
    <div class="crm-card p-6 border border-slate-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-black text-sm">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <div>
                    <h3 class="text-base font-black text-slate-900">Security Governance Policies</h3>
                    <p class="text-xs font-bold text-slate-600">Enforce data protection rules across all client records</p>
                </div>
            </div>
        </div>

        <form action="{{ route('crm.admin.super.security.save') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Policy 1: Contact Masking -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-900">Customer Phone & Email Masking</h4>
                        <p class="text-[11px] font-bold text-slate-600 mt-0.5">Mask client contact numbers (e.g. +91 98765 *****) for non-admin employees to prevent data leakage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="security_mask_contact_info" value="1" {{ $maskContact == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                    </label>
                </div>

                <!-- Policy 2: 2FA Enforcement -->
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-900">Enforce Two-Factor Authentication (2FA)</h4>
                        <p class="text-[11px] font-bold text-slate-600 mt-0.5">Require OTP verification upon employee login from unrecognized devices</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="security_enforce_2fa" value="1" {{ $enforce2fa == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                    </label>
                </div>

            </div>

            <!-- IP Whitelist Field -->
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-network-wired text-slate-500"></i>
                    <span>Allowed IP Whitelist (Optional)</span>
                    <span class="text-[10px] text-slate-500 font-semibold">(Comma separated, leave empty to permit all networks)</span>
                </label>
                <input type="text" name="security_ip_whitelist" value="{{ $ipWhitelist }}" placeholder="e.g. 127.0.0.1, 103.21.244.10, 182.74.88.1" class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-black shadow-md transition cursor-pointer">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Update Security Parameters
                </button>
            </div>
        </form>
    </div>

    <!-- Active User Sessions Monitor Table -->
    <div class="crm-card border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xs font-black">
                    <i class="fa-solid fa-desktop"></i>
                </span>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Active Logged-In Sessions (Live)</h3>
                    <p class="text-xs font-bold text-slate-600">Currently active browser connections and remote device tracking</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                {{ $sessions->count() }} Connected
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 font-black text-[11px] uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4">USER</th>
                        <th class="py-3 px-4">DEVICE & BROWSER</th>
                        <th class="py-3 px-4">IP ADDRESS</th>
                        <th class="py-3 px-4">LOCATION</th>
                        <th class="py-3 px-4">LAST ACTIVITY</th>
                        <th class="py-3 px-4 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-bold">
                    @forelse($sessions as $sess)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $sess->user_name }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">User #{{ $sess->user_id }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-800">
                                <i class="fa-solid fa-laptop text-slate-400 mr-1.5"></i>
                                {{ $sess->device }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-black text-slate-800">{{ $sess->ip_address }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $sess->location }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ \Carbon\Carbon::parse($sess->last_activity)->diffForHumans() }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('crm.admin.super.security.session.revoke', $sess->id) }}" method="POST" onsubmit="return confirm('Force terminate session for {{ $sess->user_name }}?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-[11px] font-black transition cursor-pointer inline-flex items-center gap-1">
                                        <i class="fa-solid fa-power-off text-xs"></i> Force Logout
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 text-xs font-bold">No active sessions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
