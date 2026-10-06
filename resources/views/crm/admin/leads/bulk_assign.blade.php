@extends('crm.layouts.master')

@section('title', 'Distribute Leads (Round-Robin)')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- LEFT PANEL: Distribute Leads Form (Exact Image Format) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-5">
            <!-- Header -->
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <i class="fa-solid fa-shuffle text-slate-700 text-sm"></i>
                <h2 class="text-sm font-bold text-slate-800">Distribute Leads (Round-Robin)</h2>
            </div>

            <!-- Information Alert Box -->
            <div class="bg-[#f0f9ff] border border-blue-200/70 rounded-xl p-3.5 text-xs text-[#0369a1] flex items-center gap-2.5">
                <i class="fa-solid fa-circle-info text-[#0284c7] text-sm shrink-0"></i>
                <span>This tool will take a pool of leads and distribute them equally among the employees you select below.</span>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('crm.admin.leads.bulk-assign.post') }}" id="distributeForm" class="space-y-4">
                @csrf

                <!-- 1. Select Lead Pool -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Select Lead Pool</label>
                    <select name="lead_pool" id="lead_pool" onchange="calculateDistribution()" required class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">— Select Pool —</option>
                        <option value="unassigned" data-count="{{ $unassignedCount }}" data-label="All Unassigned Leads">All Unassigned Leads ({{ $unassignedCount }})</option>
                        <option value="all" data-count="{{ $allCount }}" data-label="All Leads">All Leads ({{ $allCount }})</option>
                        <option value="New" data-count="{{ $newCount }}" data-label="New Leads">New Leads ({{ $newCount }})</option>
                        <option value="Contacted" data-count="{{ $contactedCount }}" data-label="Contacted Leads">Contacted Leads ({{ $contactedCount }})</option>
                        <option value="In Progress" data-count="{{ $inProgressCount }}" data-label="In Progress Leads">In Progress Leads ({{ $inProgressCount }})</option>
                        <option value="Qualified" data-count="{{ $qualifiedCount }}" data-label="Qualified Leads">Qualified Leads ({{ $qualifiedCount }})</option>
                    </select>
                </div>

                <!-- 2. Number of Leads to Distribute -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Number of Leads to Distribute</label>
                    <input type="number" min="1" name="lead_count" id="lead_count" oninput="calculateDistribution()" placeholder="e.g. 100 (Leave empty to assign all matching)" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-[11px] text-slate-400 mt-1">If you select 3 employees and enter 90 leads, each will get 30.</p>
                </div>

                <!-- 3. Select Employees -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-slate-700">Select Employees</label>
                        <button type="button" onclick="toggleSelectAllEmployees()" id="select-all-btn" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">Select All</button>
                    </div>

                    <div class="border border-slate-200 rounded-xl p-4 bg-white">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($employees as $emp)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer select-none hover:text-slate-900">
                                    <input type="checkbox" name="employee_ids[]" value="{{ $emp->id }}" data-name="{{ $emp->name }}" onchange="calculateDistribution()" class="emp-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                    <span>{{ $emp->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 4. Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-5 rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold transition shadow-sm flex items-center justify-center gap-2 active:scale-98">
                        <i class="fa-solid fa-bolt text-xs"></i>
                        <span>Distribute Leads</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT PANEL: Distribution Summary Card (Exact Image Format) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm self-start">
            <!-- Header -->
            <div class="bg-[#ecfdf5] border-b border-emerald-100/80 px-4 py-3 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-emerald-600 text-sm"></i>
                <h3 class="font-bold text-xs text-emerald-800">Distribution Summary</h3>
            </div>

            <!-- Body: Empty State -->
            <div id="summary-empty" class="p-8 text-center text-xs text-slate-400">
                Select options on the left to see how leads will be distributed.
            </div>

            <!-- Body: Live Calculated Preview -->
            <div id="summary-content" class="p-5 space-y-4 hidden text-xs">
                <div class="space-y-2 pb-3 border-b border-slate-100">
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Selected Pool:</span>
                        <span id="summary-pool" class="font-bold text-slate-800">-</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Available in Pool:</span>
                        <span id="summary-pool-count" class="font-bold text-slate-800">0</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Leads to Distribute:</span>
                        <span id="summary-distribute-count" class="font-bold text-indigo-600 text-sm">0</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Selected Employees:</span>
                        <span id="summary-emp-count" class="font-bold text-slate-800">0</span>
                    </div>
                </div>

                <!-- Per Employee Calculation -->
                <div class="bg-indigo-50/70 border border-indigo-100 rounded-xl p-3 text-center">
                    <span class="text-[11px] text-indigo-700 font-semibold block">Distribution Estimate</span>
                    <div id="summary-per-emp" class="text-lg font-black text-indigo-900 mt-0.5">~ 0 leads / rep</div>
                </div>

                <!-- Breakdown of reps -->
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Recipient Breakdown</span>
                    <ul id="summary-emp-list" class="divide-y divide-slate-100 max-h-48 overflow-y-auto pr-1"></ul>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
let allSelected = false;

function toggleSelectAllEmployees() {
    allSelected = !allSelected;
    const checkboxes = document.querySelectorAll('.emp-checkbox');
    checkboxes.forEach(cb => cb.checked = allSelected);
    document.getElementById('select-all-btn').innerText = allSelected ? 'Deselect All' : 'Select All';
    calculateDistribution();
}

function calculateDistribution() {
    const poolSelect = document.getElementById('lead_pool');
    const selectedOption = poolSelect.options[poolSelect.selectedIndex];
    const countInput = document.getElementById('lead_count');
    const checkedEmps = document.querySelectorAll('.emp-checkbox:checked');

    const emptyBox = document.getElementById('summary-empty');
    const contentBox = document.getElementById('summary-content');

    if (!poolSelect.value && checkedEmps.length === 0) {
        emptyBox.classList.remove('hidden');
        contentBox.classList.add('hidden');
        return;
    }

    emptyBox.classList.add('hidden');
    contentBox.classList.remove('hidden');

    const poolLabel = selectedOption ? (selectedOption.getAttribute('data-label') || 'None') : '-';
    const availablePool = selectedOption ? parseInt(selectedOption.getAttribute('data-count') || '0', 10) : 0;
    
    let toDistribute = availablePool;
    if (countInput.value && parseInt(countInput.value, 10) > 0) {
        toDistribute = Math.min(parseInt(countInput.value, 10), availablePool);
    }

    const empCount = checkedEmps.length;
    const perEmp = empCount > 0 ? Math.floor(toDistribute / empCount) : 0;
    const remainder = empCount > 0 ? (toDistribute % empCount) : 0;

    document.getElementById('summary-pool').innerText = poolLabel;
    document.getElementById('summary-pool-count').innerText = availablePool;
    document.getElementById('summary-distribute-count').innerText = toDistribute;
    document.getElementById('summary-emp-count').innerText = empCount;
    document.getElementById('summary-per-emp').innerText = empCount > 0 ? `~ ${perEmp} leads / rep` : 'Select employees';

    const empList = document.getElementById('summary-emp-list');
    empList.innerHTML = '';

    if (empCount === 0) {
        empList.innerHTML = '<li class="py-2 text-slate-400 text-center">No employees selected</li>';
    } else {
        checkedEmps.forEach((cb, index) => {
            const extra = index < remainder ? 1 : 0;
            const allocated = perEmp + extra;
            const li = document.createElement('li');
            li.className = 'py-1.5 flex items-center justify-between text-slate-700 font-medium';
            li.innerHTML = `<span>${cb.getAttribute('data-name')}</span><span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full text-[10px]">${allocated} leads</span>`;
            empList.appendChild(li);
        });
    }
}
</script>
@endsection
