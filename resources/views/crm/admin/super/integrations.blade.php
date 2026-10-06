@extends('crm.layouts.master')

@section('title', 'Third-Party Integrations & API Hub')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Integrations & API Hub</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Connect official WhatsApp Cloud API, B2B lead sources (IndiaMART, Justdial), SMS gateways, and Razorpay.
            </p>
        </div>
    </div>


    <form action="{{ route('crm.admin.super.integrations.save') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- 1. WhatsApp Cloud API -->
            <div class="crm-card p-6 border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-base">
                            <i class="fa-brands fa-whatsapp"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Official WhatsApp Cloud API</h3>
                            <p class="text-[11px] font-bold text-slate-500">Meta Graph API for verified green-tick templates</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">Direct Meta</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Phone Number ID</label>
                        <input type="text" name="whatsapp_phone_number_id" value="{{ $settings['whatsapp_phone_number_id'] ?? '' }}" placeholder="e.g. 10984567290123" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Permanent Access Token (System User)</label>
                        <input type="password" name="whatsapp_access_token" value="{{ $settings['whatsapp_access_token'] ?? '' }}" placeholder="EAAGm0PX4ZC..." class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Default Notification Template Name</label>
                        <input type="text" name="whatsapp_template_name" value="{{ $settings['whatsapp_template_name'] ?? 'crm_lead_notification' }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 2. IndiaMART & Justdial Lead Sync -->
            <div class="crm-card p-6 border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-base">
                            <i class="fa-solid fa-shop"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">B2B Portals (IndiaMART & Justdial)</h3>
                            <p class="text-[11px] font-bold text-slate-500">Automated pull sync for buyer buy-leads</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-800">Auto Pull</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">IndiaMART Mobile Key</label>
                        <input type="text" name="indiamart_api_key" value="{{ $settings['indiamart_api_key'] ?? '' }}" placeholder="mkey_XXXXXXXXXXXX" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">IndiaMART CRM Key</label>
                        <input type="password" name="indiamart_crm_key" value="{{ $settings['indiamart_crm_key'] ?? '' }}" placeholder="crm_key_XXXXXXXXXXXX" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Justdial Lead Push API Token</label>
                        <input type="text" name="justdial_api_key" value="{{ $settings['justdial_api_key'] ?? '' }}" placeholder="jd_tok_XXXXXXXXXXXX" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- 3. SMS Gateway (DLT Approved) -->
            <div class="crm-card p-6 border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-black text-base">
                            <i class="fa-solid fa-comment-sms"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">SMS Gateway (Fast2SMS / MSG91)</h3>
                            <p class="text-[11px] font-bold text-slate-500">DLT registered transactional SMS alert routing</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800">DLT</span>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-black text-slate-800 mb-1">Provider</label>
                            <select name="sms_provider" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-black text-slate-900">
                                <option value="MSG91" {{ ($settings['sms_provider'] ?? '') === 'MSG91' ? 'selected' : '' }}>MSG91 Enterprise</option>
                                <option value="Fast2SMS" {{ ($settings['sms_provider'] ?? '') === 'Fast2SMS' ? 'selected' : '' }}>Fast2SMS</option>
                                <option value="Textlocal" {{ ($settings['sms_provider'] ?? '') === 'Textlocal' ? 'selected' : '' }}>Textlocal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-800 mb-1">DLT Sender ID (6 Chars)</label>
                            <input type="text" name="sms_sender_id" value="{{ $settings['sms_sender_id'] ?? 'KKINTL' }}" placeholder="KKINTL" maxlength="6" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-bold uppercase text-slate-900">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">SMS Auth Key / Token</label>
                        <input type="password" name="sms_auth_key" value="{{ $settings['sms_auth_key'] ?? '' }}" placeholder="Enter SMS authorization key..." class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono text-xs font-bold text-slate-900">
                    </div>
                </div>
            </div>

            <!-- 4. Payment Gateway (Razorpay) -->
            <div class="crm-card p-6 border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-base">
                            <i class="fa-solid fa-credit-card"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Payment Gateway (Razorpay)</h3>
                            <p class="text-[11px] font-bold text-slate-500">Collect quotation payments & generate payment links</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800">INR Direct</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Razorpay Key ID</label>
                        <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? '' }}" placeholder="rzp_live_XXXXXXXXXXXX" class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-800 mb-1">Razorpay Key Secret</label>
                        <input type="password" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? '' }}" placeholder="Enter razorpay secret..." class="w-full text-xs p-2.5 rounded-xl border border-slate-300 font-mono text-xs font-bold text-slate-900">
                    </div>
                </div>
            </div>

        </div>

        <div class="pt-6 flex justify-end">
            <button type="submit" class="px-7 py-3 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black shadow-lg shadow-orange-500/25 hover:from-orange-600 hover:to-amber-600 transition cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>Save All Integration Gateways</span>
            </button>
        </div>
    </form>

</div>
@endsection
