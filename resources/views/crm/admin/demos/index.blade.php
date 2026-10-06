@extends('crm.layouts.master')

@section('title', 'Demo Management')

@section('content')
<div class="space-y-5">

    <!-- TOP 5 KPI METRIC CARDS (Image Format) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
        <!-- 1. Pending Demos -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#ede9fe] text-[#6366f1] flex items-center justify-center text-lg shrink-0">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-tight">{{ $pendingDemos }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Pending Demos</div>
            </div>
        </div>

        <!-- 2. Overdue -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#ffe4e6] text-[#f43f5e] flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-tight">{{ $overdueDemos }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Overdue</div>
            </div>
        </div>

        <!-- 3. Today's Demos -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#fef3c7] text-[#d97706] flex items-center justify-center text-lg shrink-0">
                <i class="fa-regular fa-calendar"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-tight">{{ $todayDemos }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Today's Demos</div>
            </div>
        </div>

        <!-- 4. Completed -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-tight">{{ $completedDemos }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Completed</div>
            </div>
        </div>

        <!-- 5. Cancelled -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#fee2e2] text-[#ef4444] flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-800 leading-tight">{{ $cancelledDemos }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- FILTERS CARD (Image Format) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-slate-700 text-xs"></i>
                <h4 class="font-bold text-sm text-slate-800">Filters</h4>
            </div>
            <a href="{{ route('crm.admin.demos.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <i class="fa-solid fa-rotate-right text-slate-400 text-xs"></i>
                <span>Reset</span>
            </a>
        </div>

        <form method="GET" action="{{ route('crm.admin.demos.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            <!-- Search -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Customer or mobile..." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Employee -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Employee</label>
                <select name="employee_id" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="dd-mm-yyyy" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="dd-mm-yyyy" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Filter Button -->
            <div>
                <button type="submit" class="w-full bg-[#4f46e5] hover:bg-[#4338ca] text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow-sm transition flex items-center justify-center gap-1.5 active:scale-98">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- SECTION 1: PENDING DEMOS -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <!-- Header Bar -->
        <div class="bg-slate-50/80 px-5 py-3.5 flex items-center justify-between border-b border-slate-200 flex-wrap gap-2">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xs shadow-xs">
                    <i class="fa-regular fa-clock text-xs"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-slate-800 flex items-center gap-2">
                        <span>Pending Demos</span>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingDemosList->count() }}</span>
                    </h3>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('add-demo-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold shadow-xs transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Schedule Demo</span>
                </button>
                <button type="button" onclick="exportTableToCSV('pending-demos-table', 'pending_demos.csv')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold shadow-xs transition active:scale-95">
                    <i class="fa-solid fa-file-excel text-xs"></i>
                    <span>Export</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="pending-demos-table" class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 font-bold text-[10px] uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">CUSTOMER</th>
                        <th class="py-3 px-4">MOBILE</th>
                        <th class="py-3 px-4">DEMO BY</th>
                        <th class="py-3 px-4">ASSIGNED TO</th>
                        <th class="py-3 px-4">DEMO DATE</th>
                        <th class="py-3 px-4">TIME</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($pendingDemosList as $demo)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-700">{{ $loop->iteration }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $demo->customer ? $demo->customer->name : ($demo->lead ? $demo->lead->name : 'Commercial Account') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono">
                                {{ $demo->customer ? $demo->customer->phone : ($demo->lead ? $demo->lead->phone : '—') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">
                                {{ $demo->assignedEmployee ? $demo->assignedEmployee->name : 'Staff' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">
                                {{ $demo->assignedEmployee ? $demo->assignedEmployee->name : 'Unassigned' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($demo->date)->format('d-m-Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $demo->time }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $demo->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <form method="POST" action="{{ route('crm.admin.demos.status', $demo->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" title="Mark Completed" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-[10px] font-bold transition">
                                            <i class="fa-solid fa-check mr-1"></i> Complete
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('crm.admin.demos.status', $demo->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Cancelled">
                                        <button type="submit" title="Cancel Demo" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-[10px] font-bold transition">
                                            <i class="fa-solid fa-xmark mr-1"></i> Cancel
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-14 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2.5">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-500 flex items-center justify-center text-lg mx-auto shadow-xs">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">No Pending Demos</h4>
                                        <p class="text-[11px] text-slate-400">All demonstration requests have been concluded or none are currently scheduled.</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('add-demo-modal').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm transition inline-flex items-center gap-1.5 active:scale-95">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Schedule Demo</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION 2: COMPLETED DEMOS -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <!-- Header Bar -->
        <div class="bg-slate-50/80 px-5 py-3.5 flex items-center justify-between border-b border-slate-200 flex-wrap gap-2">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xs shadow-xs">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-slate-800 flex items-center gap-2">
                        <span>Completed Demos</span>
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $completedDemosList->count() }}</span>
                    </h3>
                </div>
            </div>

            <button type="button" onclick="exportTableToCSV('completed-demos-table', 'completed_demos.csv')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition active:scale-95">
                <i class="fa-solid fa-file-excel text-xs"></i>
                <span>Export</span>
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="completed-demos-table" class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 font-bold text-[10px] uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">CUSTOMER</th>
                        <th class="py-3 px-4">MOBILE</th>
                        <th class="py-3 px-4">DEMO BY</th>
                        <th class="py-3 px-4">ASSIGNED TO</th>
                        <th class="py-3 px-4">DEMO DATE</th>
                        <th class="py-3 px-4">TIME</th>
                        <th class="py-3 px-4">REVIEW</th>
                        <th class="py-3 px-4">LEAD STATUS</th>
                        <th class="py-3 px-4 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($completedDemosList as $demo)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-700">{{ $loop->iteration }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $demo->customer ? $demo->customer->name : ($demo->lead ? $demo->lead->name : 'Commercial Account') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono">
                                {{ $demo->customer ? $demo->customer->phone : ($demo->lead ? $demo->lead->phone : '—') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">
                                {{ $demo->assignedEmployee ? $demo->assignedEmployee->name : 'Staff' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">
                                {{ $demo->assignedEmployee ? $demo->assignedEmployee->name : 'Staff' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($demo->date)->format('d-m-Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $demo->time }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">
                                {{ $demo->notes ?: '—' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $demo->lead ? $demo->lead->status : ($demo->customer ? $demo->customer->status : 'Interested') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <button type="button" onclick="viewDemoDetails({{ json_encode($demo) }})" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold transition">
                                    <i class="fa-solid fa-eye mr-1"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-14 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-lg mx-auto shadow-xs">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">No Completed Demos Yet</h4>
                                        <p class="text-[11px] text-slate-400">Finished demonstration records, meeting notes, and client reviews will appear here.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Schedule Demo -->
<div id="add-demo-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 animate-fade-in">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Schedule Product Demo</h3>
            </div>
            <button type="button" onclick="document.getElementById('add-demo-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form action="{{ route('crm.admin.demos.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Demo Title *</label>
                <input type="text" name="title" required placeholder="e.g. Enterprise Cloud CRM Presentation" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Select Customer</label>
                    <select name="customer_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">None / General Lead</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Or Select Lead</label>
                    <select name="lead_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">None / New Contact</option>
                        @foreach($leads as $l)
                            <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->company }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Date *</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Time *</label>
                    <input type="time" name="time" value="11:00" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assign Specialist</label>
                    <select name="assigned_to" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select...</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Initial Status</label>
                    <select name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Agenda</label>
                <textarea name="notes" rows="2" placeholder="Key talking points or feature demonstration requirements..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('add-demo-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#4f46e5] text-white text-xs font-bold hover:bg-[#4338ca] shadow-sm transition">Schedule Demo</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: View Demo Details -->
<div id="view-demo-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-800">Demo Details</h3>
            <button type="button" onclick="document.getElementById('view-demo-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <div class="space-y-3 text-xs">
            <div>
                <span class="text-slate-400 font-semibold block">Demo Title:</span>
                <span id="view-title" class="text-slate-800 font-bold text-sm"></span>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Customer / Lead:</span>
                    <span id="view-customer" class="text-slate-700 font-semibold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Phone / Mobile:</span>
                    <span id="view-mobile" class="text-slate-700 font-semibold font-mono"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Assigned Specialist:</span>
                    <span id="view-assigned" class="text-slate-700 font-semibold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Date & Time:</span>
                    <span id="view-datetime" class="text-slate-700 font-semibold"></span>
                </div>
            </div>
            <div>
                <span class="text-slate-400 font-semibold block">Notes / Review:</span>
                <div id="view-notes" class="text-slate-700 bg-slate-50 p-2.5 rounded-xl mt-1 border border-slate-100"></div>
            </div>
        </div>
        <div class="pt-4 flex justify-end">
            <button type="button" onclick="document.getElementById('view-demo-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold">Close</button>
        </div>
    </div>
</div>

<script>
function viewDemoDetails(demo) {
    document.getElementById('view-title').innerText = demo.title || 'Demo Session';
    
    let customerName = 'Commercial Account';
    let customerPhone = '—';
    if (demo.customer) {
        customerName = demo.customer.name;
        customerPhone = demo.customer.phone || '—';
    } else if (demo.lead) {
        customerName = demo.lead.name;
        customerPhone = demo.lead.phone || '—';
    }
    
    document.getElementById('view-customer').innerText = customerName;
    document.getElementById('view-mobile').innerText = customerPhone;
    document.getElementById('view-assigned').innerText = demo.assigned_employee ? demo.assigned_employee.name : (demo.assignedEmployee ? demo.assignedEmployee.name : 'Unassigned');
    document.getElementById('view-datetime').innerText = (demo.date || '') + ' at ' + (demo.time || '');
    document.getElementById('view-notes').innerText = demo.notes || 'No review / feedback entered.';
    
    document.getElementById('view-demo-modal').classList.remove('hidden');
}

function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) {
        alert('No data available to export.');
        return;
    }
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = [];
        const cols = rows[i].querySelectorAll('td, th');
        for (let j = 0; j < cols.length - 1; j++) { // exclude action column
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').trim();
            data = data.replace(/"/g, '""');
            row.push('"' + data + '"');
        }
        if (row.length > 0) csv.push(row.join(','));
    }
    
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
@endsection
