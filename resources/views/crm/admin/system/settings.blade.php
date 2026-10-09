@extends('crm.layouts.master')

@section('title', 'System Configuration & Settings')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto pb-12">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-sliders text-emerald-600"></i>
                <span>System Configuration &amp; Settings</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-bold mt-1">
                Manage corporate identity, GST tax parameters, quotation defaults, regional formats, and notification alerts.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" form="crm-settings-form" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white text-xs font-black shadow-lg shadow-emerald-700/20 transition cursor-pointer flex items-center gap-2 active:scale-95">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Save All Settings</span>
            </button>
        </div>
    </div>

    <!-- Tab Navigation Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-1.5 shadow-xs flex items-center flex-wrap gap-1">
        <button type="button" onclick="switchSettingsTab('company')" id="tab-btn-company"
                class="settings-tab-btn flex-1 min-w-[140px] px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 bg-emerald-700 text-white shadow-xs">
            <i class="fa-solid fa-building text-xs"></i>
            <span>Company &amp; Brand</span>
        </button>

        <button type="button" onclick="switchSettingsTab('quotation')" id="tab-btn-quotation"
                class="settings-tab-btn flex-1 min-w-[140px] px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100">
            <i class="fa-solid fa-file-invoice text-xs"></i>
            <span>Quotation &amp; Banking</span>
        </button>

        <button type="button" onclick="switchSettingsTab('regional')" id="tab-btn-regional"
                class="settings-tab-btn flex-1 min-w-[140px] px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100">
            <i class="fa-solid fa-globe text-xs"></i>
            <span>Regional &amp; Formats</span>
        </button>

        <button type="button" onclick="switchSettingsTab('alerts')" id="tab-btn-alerts"
                class="settings-tab-btn flex-1 min-w-[140px] px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100">
            <i class="fa-solid fa-bell text-xs"></i>
            <span>Alerts &amp; Security</span>
        </button>
    </div>

    <!-- Main Settings Form -->
    <form id="crm-settings-form" action="{{ route('crm.admin.system.settings.save') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- =================================================================== -->
        <!-- TAB 1: COMPANY & BRAND IDENTITY -->
        <!-- =================================================================== -->
        <div id="tab-content-company" class="settings-tab-content space-y-6">
            
            <div class="crm-card p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-emerald-600"></i>
                            <span>Corporate Identity &amp; Brand Profile</span>
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Appears on invoices, customer proposals, and portal navigation headers.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Primary Brand
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Company Name -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Company / Brand Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'Hisab Mittra' }}" required
                               class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <!-- Company Tagline -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Company Tagline / Slogan</label>
                        <input type="text" name="company_tagline" value="{{ $settings['company_tagline'] ?? 'Smart Solutions, Stronger Business' }}"
                               class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <!-- Official Website -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Official Website URL</label>
                        <input type="url" name="company_website" value="{{ $settings['company_website'] ?? 'https://hisabmittra.com' }}" placeholder="https://..."
                               class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <!-- Company Logo Upload -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Official Brand Logo (PNG / JPG / SVG)</label>
                        <div class="flex items-center gap-3">
                            @if(!empty($settings['company_logo']))
                                <div class="w-12 h-12 rounded-xl border border-slate-200 p-1 bg-white shrink-0 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset($settings['company_logo']) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                                </div>
                            @endif
                            <input type="file" name="company_logo" accept="image/*"
                                   class="w-full text-xs p-2 rounded-2xl border border-slate-300 bg-slate-50 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Tax & Legal Registrations -->
                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">
                            <span>GSTIN / Tax Registration Number</span>
                            <span class="text-[10px] text-slate-400 font-semibold block sm:inline">(Printed on Quotation &amp; Invoices)</span>
                        </label>
                        <input type="text" name="company_gstin" value="{{ $settings['company_gstin'] ?? '08AAAAA0000A1Z5' }}" placeholder="e.g. 08AAAAA0000A1Z5"
                               class="w-full text-xs font-mono font-bold uppercase p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Company PAN Number</label>
                        <input type="text" name="company_pan" value="{{ $settings['company_pan'] ?? 'AAAAA0000A' }}" placeholder="e.g. AAAAA0000A"
                               class="w-full text-xs font-mono font-bold uppercase p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>
                </div>

                <!-- Support Contacts & Registered Address -->
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Official Support Email</label>
                            <input type="email" name="support_email" value="{{ $settings['support_email'] ?? 'hisabmittra@gmail.com' }}"
                                   class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1.5">Support Phone / Helpdesk</label>
                            <input type="text" name="support_phone" value="{{ $settings['support_phone'] ?? '+91 97830 55170' }}"
                                   class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Registered Office Address</label>
                        <textarea name="company_address" rows="2" placeholder="Full postal address for invoices..."
                                  class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">{{ $settings['company_address'] ?? 'Plot No. 12, Industrial Area, Sitapura' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1">City</label>
                            <input type="text" name="company_city" value="{{ $settings['company_city'] ?? 'Jaipur' }}"
                                   class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1">State / Province</label>
                            <input type="text" name="company_state" value="{{ $settings['company_state'] ?? 'Rajasthan' }}"
                                   class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-800 mb-1">Postal / ZIP Code</label>
                            <input type="text" name="company_pincode" value="{{ $settings['company_pincode'] ?? '302022' }}"
                                   class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- =================================================================== -->
        <!-- TAB 2: QUOTATION & BANKING DEFAULTS -->
        <!-- =================================================================== -->
        <div id="tab-content-quotation" class="settings-tab-content space-y-6 hidden">
            
            <!-- Quotation Parameters -->
            <div class="crm-card p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-emerald-600"></i>
                            <span>Quotation &amp; Proposal Defaults</span>
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Automated tax calculation, sequential prefix, and validity parameters.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-50 text-blue-800 border border-blue-200">
                        Sales Rules
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Default GST / Tax Rate (%)</label>
                        <select name="default_tax_rate" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="18" {{ ($settings['default_tax_rate'] ?? '18') == '18' ? 'selected' : '' }}>18% (Standard GST)</option>
                            <option value="12" {{ ($settings['default_tax_rate'] ?? '18') == '12' ? 'selected' : '' }}>12% (Goods / Hardware)</option>
                            <option value="5" {{ ($settings['default_tax_rate'] ?? '18') == '5' ? 'selected' : '' }}>5% (Concessional)</option>
                            <option value="0" {{ ($settings['default_tax_rate'] ?? '18') == '0' ? 'selected' : '' }}>0% (Exempt / SEZ Export)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Quotation Number Prefix</label>
                        <input type="text" name="quotation_prefix" value="{{ $settings['quotation_prefix'] ?? 'QT-' }}" placeholder="QT-"
                               class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Default Validity Period</label>
                        <select name="quotation_validity_days" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="7" {{ ($settings['quotation_validity_days'] ?? '15') == '7' ? 'selected' : '' }}>7 Days</option>
                            <option value="15" {{ ($settings['quotation_validity_days'] ?? '15') == '15' ? 'selected' : '' }}>15 Days (Recommended)</option>
                            <option value="30" {{ ($settings['quotation_validity_days'] ?? '15') == '30' ? 'selected' : '' }}>30 Days</option>
                            <option value="60" {{ ($settings['quotation_validity_days'] ?? '15') == '60' ? 'selected' : '' }}>60 Days</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="block text-xs font-black text-slate-800 mb-1.5">Default Quotation Terms &amp; Conditions</label>
                    <textarea name="quotation_terms" rows="3" placeholder="Standard terms printed at bottom of quotations..."
                              class="w-full text-xs font-medium p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">{{ $settings['quotation_terms'] ?? "1. 50% Advance along with official Purchase Order, balance prior to dispatch.\n2. Goods once sold will not be taken back or exchanged.\n3. All disputes subject to Jaipur jurisdiction only." }}</textarea>
                </div>
            </div>

            <!-- Bank Account Details for Invoices & Payments -->
            <div class="crm-card p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-emerald-600"></i>
                            <span>Corporate Bank Account (For Invoices &amp; RTGS/NEFT)</span>
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">These banking details are printed on dispatch proposals so clients can wire funds.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Payment Wire
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Account Beneficiary Name</label>
                        <input type="text" name="bank_beneficiary_name" value="{{ $settings['bank_beneficiary_name'] ?? 'Hisab Mittra' }}"
                               class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'HDFC Bank Ltd.' }}"
                               class="w-full text-xs font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Bank Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '50200087654321' }}"
                               class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">IFSC Code</label>
                        <input type="text" name="bank_ifsc_code" value="{{ $settings['bank_ifsc_code'] ?? 'HDFC0001234' }}" placeholder="HDFC0001234"
                               class="w-full text-xs font-mono font-bold uppercase p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Account Type</label>
                        <select name="bank_account_type" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="Current Account" {{ ($settings['bank_account_type'] ?? '') == 'Current Account' ? 'selected' : '' }}>Current Account (Corporate)</option>
                            <option value="Savings Account" {{ ($settings['bank_account_type'] ?? '') == 'Savings Account' ? 'selected' : '' }}>Savings Account</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Official UPI ID / VPA</label>
                        <input type="text" name="bank_upi_id" value="{{ $settings['bank_upi_id'] ?? 'hisabmittra@hdfcbank' }}" placeholder="e.g. business@upi"
                               class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>
                </div>
            </div>

        </div>

        <!-- =================================================================== -->
        <!-- TAB 3: REGIONAL & LOCALIZATION FORMATS -->
        <!-- =================================================================== -->
        <div id="tab-content-regional" class="settings-tab-content space-y-6 hidden">
            
            <div class="crm-card p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-earth-asia text-emerald-600"></i>
                            <span>Regional &amp; Localization Parameters</span>
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Timezone synchronization, date-time formats, and currency representations.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-purple-50 text-purple-800 border border-purple-200">
                        Localization
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Currency Symbol & Code -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Currency Symbol</label>
                        <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '₹' }}"
                               class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Currency Code</label>
                        <input type="text" name="currency_code" value="{{ $settings['currency_code'] ?? 'INR' }}" placeholder="INR"
                               class="w-full text-xs font-mono font-bold p-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>

                    <!-- Timezone Selection -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">System Timezone</label>
                        <select name="timezone" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="Asia/Kolkata" {{ ($settings['timezone'] ?? 'Asia/Kolkata') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST +5:30) - India</option>
                            <option value="UTC" {{ ($settings['timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>UTC (Coordinated Universal Time)</option>
                            <option value="Asia/Dubai" {{ ($settings['timezone'] ?? '') === 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (GST +4:00)</option>
                            <option value="America/New_York" {{ ($settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST/EDT)</option>
                            <option value="Europe/London" {{ ($settings['timezone'] ?? '') === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT/BST)</option>
                        </select>
                    </div>

                    <!-- Fiscal Year Start Month -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Fiscal Year Start Month</label>
                        <select name="fiscal_year_start" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="April" {{ ($settings['fiscal_year_start'] ?? 'April') == 'April' ? 'selected' : '' }}>April (Standard Indian Financial Year)</option>
                            <option value="January" {{ ($settings['fiscal_year_start'] ?? '') == 'January' ? 'selected' : '' }}>January (Calendar Year)</option>
                            <option value="July" {{ ($settings['fiscal_year_start'] ?? '') == 'July' ? 'selected' : '' }}>July</option>
                            <option value="October" {{ ($settings['fiscal_year_start'] ?? '') == 'October' ? 'selected' : '' }}>October</option>
                        </select>
                    </div>

                    <!-- Date Format -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Date Display Format</label>
                        <select name="date_format" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="d M Y" {{ ($settings['date_format'] ?? 'd M Y') == 'd M Y' ? 'selected' : '' }}>03 Oct 2026 (d M Y)</option>
                            <option value="d/m/Y" {{ ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>03/10/2026 (d/m/Y)</option>
                            <option value="Y-m-d" {{ ($settings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>2026-10-03 (ISO Standard Y-m-d)</option>
                            <option value="m/d/Y" {{ ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>10/03/2026 (US Format m/d/Y)</option>
                        </select>
                    </div>

                    <!-- Number Format Style -->
                    <div>
                        <label class="block text-xs font-black text-slate-800 mb-1.5">Number &amp; Amount Formatting</label>
                        <select name="number_format_style" class="w-full text-xs font-black p-3 rounded-2xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="indian" {{ ($settings['number_format_style'] ?? 'indian') == 'indian' ? 'selected' : '' }}>Indian Style (₹ 1,00,000 Lakhs / Crores)</option>
                            <option value="international" {{ ($settings['number_format_style'] ?? '') == 'international' ? 'selected' : '' }}>International Style (100,000 Thousands / Millions)</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- =================================================================== -->
        <!-- TAB 4: ALERTS & SECURITY GOVERNANCE -->
        <!-- =================================================================== -->
        <div id="tab-content-alerts" class="settings-tab-content space-y-6 hidden">
            
            <div class="crm-card p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>Automated Alerts &amp; Session Policies</span>
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Control automated notification triggers and portal session lifetime.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-50 text-rose-800 border border-rose-200">
                        Governance
                    </span>
                </div>

                <div class="space-y-4">
                    <!-- Alert 1: New Lead Notification -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Admin Email Alert on Inbound Leads</h4>
                            <p class="text-[11px] font-semibold text-slate-600 mt-0.5">Send immediate notification email to administrator when an inquiry arrives from web forms</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_new_lead_email" value="1" {{ ($settings['notify_new_lead_email'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Alert 2: Customer Welcome Message -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Automated Welcome Message to Leads</h4>
                            <p class="text-[11px] font-semibold text-slate-600 mt-0.5">Dispatch automated acknowledgement email/SMS when lead inquiry is registered</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_welcome_message" value="1" {{ ($settings['notify_welcome_message'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Alert 3: Daily Performance Summary -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Daily Evening Business Digest</h4>
                            <p class="text-[11px] font-semibold text-slate-600 mt-0.5">Send consolidated daily leads, calls, and revenue summary email at 7:00 PM</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_daily_digest" value="1" {{ ($settings['notify_daily_digest'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>

                    <!-- Session Timeout -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Idle Session Inactivity Auto-Logout</h4>
                            <p class="text-[11px] font-semibold text-slate-600 mt-0.5">Terminate user session automatically if no user interaction is detected</p>
                        </div>
                        <div>
                            <select name="session_idle_timeout" class="w-full text-xs font-black p-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="15" {{ ($settings['session_idle_timeout'] ?? '60') == '15' ? 'selected' : '' }}>15 Minutes (High Security)</option>
                                <option value="30" {{ ($settings['session_idle_timeout'] ?? '60') == '30' ? 'selected' : '' }}>30 Minutes</option>
                                <option value="60" {{ ($settings['session_idle_timeout'] ?? '60') == '60' ? 'selected' : '' }}>60 Minutes (Standard)</option>
                                <option value="120" {{ ($settings['session_idle_timeout'] ?? '60') == '120' ? 'selected' : '' }}>2 Hours</option>
                                <option value="0" {{ ($settings['session_idle_timeout'] ?? '60') == '0' ? 'selected' : '' }}>Never (Keep Session Active)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Multi-device login -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black text-slate-900">Allow Concurrent Multi-Device Login</h4>
                            <p class="text-[11px] font-semibold text-slate-600 mt-0.5">Allow employees to stay logged in simultaneously on both Mobile and Laptop</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="allow_multi_login" value="1" {{ ($settings['allow_multi_login'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sticky Save Action Bar -->
        <div class="pt-6 mt-6 border-t border-slate-200 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl shadow-xs">
            <div class="flex items-center gap-2 text-xs text-slate-600 font-bold">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>Configuration changes apply instantly system-wide.</span>
            </div>

            <button type="submit" class="px-8 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white text-xs font-black shadow-lg shadow-emerald-700/25 transition cursor-pointer flex items-center gap-2 active:scale-95">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Save CRM Configuration</span>
            </button>
        </div>
    </form>

</div>

<script>
function switchSettingsTab(tabKey) {
    // Hide all tab contents
    document.querySelectorAll('.settings-tab-content').forEach(el => {
        el.classList.add('hidden');
    });

    // Reset button styles
    document.querySelectorAll('.settings-tab-btn').forEach(btn => {
        btn.classList.remove('bg-emerald-700', 'text-white', 'shadow-xs');
        btn.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
    });

    // Activate selected content & button
    const targetContent = document.getElementById('tab-content-' + tabKey);
    const targetBtn = document.getElementById('tab-btn-' + tabKey);

    if (targetContent) {
        targetContent.classList.remove('hidden');
    }
    if (targetBtn) {
        targetBtn.classList.add('bg-emerald-700', 'text-white', 'shadow-xs');
        targetBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
    }
}
</script>
@endsection
