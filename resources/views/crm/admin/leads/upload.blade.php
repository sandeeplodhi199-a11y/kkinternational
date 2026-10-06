@extends('crm.layouts.master')

@section('title', 'Upload Leads (CSV)')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('crm.admin.leads.index') }}" class="hover:text-emerald-700">Leads Management</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <span class="text-slate-800">CSV Bulk Upload</span>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-file-arrow-up text-emerald-700 text-xl"></i>
                <span>Upload & Import Leads</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Quickly import hundreds of prospective leads from CSV files into your CRM database.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.leads.sample-csv') }}" class="px-4 py-2 rounded-full border border-emerald-600 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold text-xs transition inline-flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-download"></i>
                <span>Download Sample CSV</span>
            </a>
            <a href="{{ route('crm.admin.leads.index') }}" class="px-4 py-2 rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 font-semibold text-xs transition">
                Back to Leads
            </a>
        </div>
    </div>

    <!-- Upload Card -->
    <div class="crm-card p-6 md:p-8">
        <form action="{{ route('crm.admin.leads.upload.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Drag & Drop Zone -->
            <div id="dropZone" class="border-2 border-dashed border-[#cbd5e1] hover:border-emerald-600 rounded-3xl p-8 md:p-12 text-center transition cursor-pointer bg-slate-50/50 hover:bg-emerald-50/30">
                <input type="file" name="csv_file" id="csvFileInput" accept=".csv,text/csv" required class="hidden" onchange="handleFileSelect(this)">
                
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 mx-auto flex items-center justify-center text-2xl mb-4 shadow-sm">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                
                <h3 class="text-base font-bold text-slate-800 mb-1" id="fileSelectedTitle">
                    Click to browse or drag & drop CSV file
                </h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4" id="fileSelectedSub">
                    Supports standard CSV format with comma delimiters. Max file size: 5MB.
                </p>

                <button type="button" onclick="document.getElementById('csvFileInput').click()" class="px-5 py-2.5 rounded-full bg-[#1b4d3e] text-white font-bold text-xs hover:bg-[#153e32] transition shadow-md">
                    Choose CSV File
                </button>
            </div>

            <!-- CSV Formatting Guide -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <h4 class="text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i>
                    <span>Required CSV Column Order</span>
                </h4>
                <div class="flex items-center gap-2 overflow-x-auto text-[11px] font-mono text-slate-600 pb-1">
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold text-emerald-700">Name</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold">Email</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold">Phone</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold">Company</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold">Status</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold">Priority</span>
                    <span>&rarr;</span>
                    <span class="px-2 py-1 bg-white border border-slate-200 rounded font-semibold text-amber-700">Expected Value</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <button type="submit" class="px-7 py-3 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md inline-flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload & Process Leads Now</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Recently Uploaded Leads -->
    <div class="crm-card p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
            <span>Recently Added Leads ({{ $recentUploaded->count() }})</span>
        </h3>
        <div class="divide-y divide-slate-100 text-xs">
            @forelse($recentUploaded as $rl)
                <div class="py-2.5 flex items-center justify-between">
                    <div>
                        <span class="font-bold text-slate-800">{{ $rl->name }}</span>
                        <span class="text-slate-400 text-[10px] ml-2 font-mono">{{ $rl->lead_code }}</span>
                        <span class="text-slate-500 block text-[11px]">{{ $rl->company ?: 'Individual' }} • {{ $rl->phone ?: $rl->email }}</span>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">{{ $rl->status }}</span>
                        <span class="text-slate-400 text-[10px] block mt-0.5">{{ $rl->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-xs py-4 text-center">No leads uploaded yet.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('fileSelectedTitle').innerText = 'Selected: ' + file.name;
            document.getElementById('fileSelectedSub').innerText = 'File size: ' + (file.size / 1024).toFixed(1) + ' KB. Ready to upload.';
            document.getElementById('dropZone').classList.add('border-emerald-600', 'bg-emerald-50/40');
        }
    }
</script>
@endpush
@endsection
