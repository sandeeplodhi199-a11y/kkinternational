@extends('crm.layouts.master')

@section('title', 'All Leads')

@section('content')
<div class="space-y-4">

    <!-- 1. TOP FILTERS BAR (Exact Image 2 Format) -->
    <div class="bg-white rounded-xl border border-slate-200/80 p-4 shadow-sm">
        <form method="GET" action="{{ route('crm.admin.leads.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
            <!-- Search -->
            <div class="lg:col-span-6">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or mobile..." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Status -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status</label>
                <select name="status" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Contacted" {{ request('status') == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Qualified" {{ request('status') == 'Qualified' ? 'selected' : '' }}>Qualified</option>
                    <option value="Converted" {{ request('status') == 'Converted' ? 'selected' : '' }}>Converted</option>
                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Lost</option>
                </select>
            </div>

            <!-- Employee -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Employee</label>
                <select name="employee_id" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ (request('employee_id') == $emp->id || request('assigned_to') == $emp->id) ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 bg-[#4f46e5] hover:bg-[#4338ca] text-white font-bold text-xs px-4 py-2 rounded-lg shadow-sm transition flex items-center justify-center gap-1.5 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Filter</span>
                </button>
                <a href="{{ route('crm.admin.leads.index') }}" class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-semibold text-xs px-3 py-2 rounded-lg flex items-center justify-center gap-1 transition shadow-xs">
                    <i class="fa-solid fa-xmark text-xs"></i>
                    <span>Clear</span>
                </a>
            </div>
        </form>
    </div>

    <!-- 2. HEADER BAR (Title, View Switcher & Primary Actions) -->
    <div class="flex items-center justify-between flex-wrap gap-3 pt-1">
        <!-- Left: Leads Count & View Switcher -->
        <div class="flex items-center flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <i class="fa-solid fa-list-ul text-xs"></i>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                        <span>Leads</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $leads->total() ?? $leads->count() }} total
                        </span>
                    </h1>
                </div>
            </div>

        </div>

        <!-- Right: Primary Actions (Export & Add Lead) -->
        <div class="flex items-center gap-2">
            <button type="button" onclick="exportTableToCSV('all-leads-table', 'all_leads.csv')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-xs transition active:scale-95">
                <i class="fa-solid fa-file-excel text-emerald-600 text-xs"></i>
                <span>Export</span>
            </button>
            <a href="{{ route('crm.admin.leads.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#10b981] hover:bg-[#059669] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add Lead</span>
            </a>
        </div>
    </div>

    <!-- 3. BULK ASSIGNMENT TOOLBAR -->
    <div class="bg-white rounded-xl border border-slate-200/80 p-3 shadow-xs flex items-center justify-between flex-wrap gap-2.5">
        <div class="flex items-center flex-wrap gap-2">
            <!-- Select Employee Dropdown -->
            <select id="action-employee-select" class="bg-white border border-slate-300 rounded-lg px-3 py-1.5 text-xs text-slate-700 font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-xs">
                <option value="">— Select Employee —</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>

            <!-- Assign Selected -->
            <button type="button" onclick="executeAssign('selected')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-user-check text-xs"></i>
                <span>Assign Selected</span>
                <span id="selected-count-badge" class="bg-white/25 text-white text-[10px] font-black px-1.5 py-0.2 rounded-full">0</span>
            </button>

            <!-- Delete Selected -->
            <button type="button" onclick="executeDeleteSelected()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ef4444] hover:bg-[#dc2626] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-trash text-xs"></i>
                <span>Delete Selected</span>
            </button>

            <!-- Assign All -->
            <button type="button" onclick="executeAssign('all')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#f59e0b] hover:bg-[#d97706] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-users text-xs"></i>
                <span>Assign All ({{ $leads->total() ?? $leads->count() }})</span>
            </button>

            <!-- Auto Assign -->
            <button type="button" onclick="executeAssign('auto')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#8b5cf6] hover:bg-[#7c3aed] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                <span>Auto Assign</span>
            </button>
        </div>

        <div class="text-[11px] font-medium text-slate-400 hidden sm:block">
            Select checkboxes to assign in bulk
        </div>
    </div>

    <!-- 4. DATA TABLE -->
    <form id="bulkActionForm" method="POST" action="{{ route('crm.admin.leads.bulk-assign.post') }}">
        @csrf
        <input type="hidden" name="assigned_to" id="form-assigned-to">
        <input type="hidden" name="assign_all" id="form-assign-all" value="0">
        <input type="hidden" name="auto_assign" id="form-auto-assign" value="0">

        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="all-leads-table" class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 font-bold text-[10px] uppercase tracking-wider border-b border-t border-slate-200">
                            <th class="py-2.5 px-3 w-8 text-center">
                                <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)" class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-0 cursor-pointer">
                            </th>
                            <th class="py-2.5 px-3">#</th>
                            <th class="py-2.5 px-3">ID</th>
                            <th class="py-2.5 px-3">FIRM NAME</th>
                            <th class="py-2.5 px-3">CONTACT</th>
                            <th class="py-2.5 px-3">PHONE</th>
                            <th class="py-2.5 px-3">CITY</th>
                            <th class="py-2.5 px-3">SRC</th>
                            <th class="py-2.5 px-3">RESPONSE</th>
                            <th class="py-2.5 px-3">CALLBACK</th>
                            <th class="py-2.5 px-3">EMP</th>
                            <th class="py-2.5 px-3">AGENT</th>
                            <th class="py-2.5 px-3">CREATED</th>
                            <th class="py-2.5 px-3">UPDATED</th>
                            <th class="py-2.5 px-3">PRIORITY</th>
                            <th class="py-2.5 px-3">BASIC</th>
                            <th class="py-2.5 px-3">PRO</th>
                            <th class="py-2.5 px-3">REMARKS</th>
                            <th class="py-2.5 px-3 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($leads as $lead)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-2.5 px-3 text-center">
                                    <input type="checkbox" name="lead_ids[]" value="{{ $lead->id }}" onchange="updateSelectedCount()" class="lead-checkbox w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-0 cursor-pointer">
                                </td>
                                <td class="py-2.5 px-3 font-semibold text-slate-700">
                                    {{ $lead->lead_code ? str_replace(['LEAD-', 'LD-'], '', $lead->lead_code) : (1000 + $lead->id) }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->id }}
                                </td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    {{ $lead->company ?: '-' }}
                                </td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    {{ $lead->name }}
                                </td>
                                <td class="py-2.5 px-3 font-mono text-slate-700">
                                    {{ $lead->phone ?: '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->city ?? ($lead->address ?? '-') }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->source ? $lead->source->name : '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->status ?: '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->follow_up_date ? \Carbon\Carbon::parse($lead->follow_up_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="py-2.5 px-3 font-medium text-slate-700">
                                    {{ $lead->assignedEmployee ? $lead->assignedEmployee->name : 'Unassigned' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-700 font-medium">
                                    {{ $lead->agent ?: '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->created_at ? $lead->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $lead->updated_at ? $lead->updated_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-700 font-bold">
                                    {{ $lead->priority ?: '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-800 font-bold">
                                    {{ $lead->basic ? '₹' . number_format($lead->basic, 2) : '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-800 font-bold">
                                    {{ $lead->pro ? '₹' . number_format($lead->pro, 2) : ($lead->expected_value ? '₹' . number_format($lead->expected_value, 2) : '-') }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-500 max-w-xs truncate text-[11px]">
                                    {{ $lead->notes ? Str::limit($lead->notes, 30) : '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    <div class="inline-flex items-center justify-center gap-1">
                                        <!-- View (Purple) -->
                                        <button type="button" onclick="viewLeadModal({{ json_encode($lead) }})" title="View" class="w-6 h-6 rounded bg-[#4f46e5] hover:bg-[#4338ca] text-white flex items-center justify-center text-[10px] transition shadow-xs">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <!-- Edit (Orange) -->
                                        <button type="button" onclick="editLeadModal({{ json_encode($lead) }})" title="Edit" class="w-6 h-6 rounded bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center text-[10px] transition shadow-xs">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <!-- Schedule (Cyan) -->
                                        <button type="button" onclick="scheduleLeadModal({{ json_encode($lead) }})" title="Schedule Demo" class="w-6 h-6 rounded bg-[#06b6d4] hover:bg-[#0891b2] text-white flex items-center justify-center text-[10px] transition shadow-xs">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </button>
                                        <!-- Delete (Red) -->
                                        <button type="button" onclick="deleteLeadConfirm('{{ $lead->id }}', '{{ addslashes($lead->name) }}')" title="Delete Lead" class="w-6 h-6 rounded bg-[#ef4444] hover:bg-[#dc2626] text-white flex items-center justify-center text-[10px] transition shadow-xs cursor-pointer">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="19" class="py-16 text-center">
                                    <div class="max-w-sm mx-auto text-center space-y-3">
                                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl mx-auto shadow-xs">
                                            <i class="fa-solid fa-users text-indigo-500"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-slate-800">No Leads Found</h3>
                                            <p class="text-xs text-slate-500 mt-1">There are currently no leads in the database or matching your filters.</p>
                                        </div>
                                        <div class="pt-2 flex items-center justify-center gap-2">
                                            <a href="{{ route('crm.admin.leads.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition inline-flex items-center gap-1.5 active:scale-95">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                                <span>Add First Lead</span>
                                            </a>
                                            @if(request()->anyFilled(['search', 'status', 'employee_id']))
                                                <a href="{{ route('crm.admin.leads.index') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                                                    Reset Filters
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($leads->hasPages())
                <div class="p-3 border-t border-slate-100">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </form>

</div>

<!-- MODAL: ADD LEAD -->
<div id="add-lead-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-600"></i>
                <span>Add New Lead</span>
            </h3>
            <button type="button" onclick="document.getElementById('add-lead-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">&times;</button>
        </div>
        <form action="{{ route('crm.admin.leads.store') }}" method="POST" class="space-y-3.5">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contact Name * (CONTACT)</label>
                    <input type="text" name="name" required placeholder="e.g. John Doe" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Company / Firm (FIRM NAME)</label>
                    <input type="text" name="company" placeholder="e.g. Acme Industries" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number * (PHONE)</label>
                    <input type="text" name="phone" required placeholder="e.g. +91 98765 43210" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">City / Location (CITY)</label>
                    <input type="text" name="city" placeholder="e.g. Jaipur, Rajasthan" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="e.g. user@example.com" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Source (SRC)</label>
                    <select name="source_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                        <option value="">Direct / Walk-in</option>
                        @foreach($sources as $src)
                            <option value="{{ $src->id }}">{{ $src->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Response / Status * (RESPONSE)</label>
                    <select name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                        <option value="New" selected>New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Converted">Converted</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Priority (PRIORITY)</label>
                    <select name="priority" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assign Sales Rep (EMP)</label>
                    <select name="assigned_to" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Unassigned</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Agent / Caller (AGENT)</label>
                    <input type="text" name="agent" placeholder="e.g. Agent Name" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Callback Date (CALLBACK)</label>
                    <input type="date" name="follow_up_date" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Basic Plan (₹) (BASIC)</label>
                    <input type="number" step="0.01" name="basic" placeholder="e.g. 5000" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pro Plan (₹) (PRO)</label>
                    <input type="number" step="0.01" name="pro" placeholder="e.g. 15000" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Remarks / Notes (REMARKS)</label>
                <textarea name="notes" rows="2" placeholder="Initial conversation or inquiry details..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('add-lead-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#10b981] hover:bg-[#059669] text-white text-xs font-bold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Lead</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: VIEW LEAD -->
<div id="view-lead-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-address-card text-indigo-600"></i>
                <span>Lead Full Details</span>
            </h3>
            <button type="button" onclick="document.getElementById('view-lead-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">&times;</button>
        </div>
        <div class="space-y-3 text-xs">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Contact Name (CONTACT):</span>
                    <span id="view-name" class="text-slate-800 font-bold text-sm"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Firm / Company (FIRM NAME):</span>
                    <span id="view-company" class="text-slate-800 font-bold text-sm"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Phone / Mobile (PHONE):</span>
                    <span id="view-phone" class="text-slate-700 font-semibold font-mono"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">City / Location (CITY):</span>
                    <span id="view-city" class="text-slate-700 font-semibold"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Status (RESPONSE):</span>
                    <span id="view-status" class="text-slate-700 font-semibold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Priority (PRIORITY):</span>
                    <span id="view-priority" class="text-slate-700 font-semibold"></span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Assigned Staff (EMP):</span>
                    <span id="view-emp" class="text-slate-700 font-semibold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Telecaller / Agent (AGENT):</span>
                    <span id="view-agent" class="text-slate-700 font-semibold"></span>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <span class="text-slate-400 font-semibold block">Basic (BASIC):</span>
                    <span id="view-basic" class="text-slate-800 font-bold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Pro (PRO):</span>
                    <span id="view-pro" class="text-slate-800 font-bold"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Callback (CALLBACK):</span>
                    <span id="view-callback" class="text-slate-700 font-semibold"></span>
                </div>
            </div>
            <div>
                <span class="text-slate-400 font-semibold block">Remarks (REMARKS):</span>
                <div id="view-remarks" class="text-slate-700 bg-slate-50 p-2.5 rounded-xl mt-1 border border-slate-100 whitespace-pre-wrap"></div>
            </div>
        </div>
        <div class="pt-4 flex justify-end">
            <button type="button" onclick="document.getElementById('view-lead-modal').classList.add('hidden')" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold cursor-pointer">Close</button>
        </div>
    </div>
</div>

<!-- MODAL: EDIT LEAD -->
<div id="edit-lead-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                <span>Edit Lead Details</span>
            </h3>
            <button type="button" onclick="document.getElementById('edit-lead-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">&times;</button>
        </div>
        <form id="editLeadForm" method="POST" class="space-y-3.5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contact Name *</label>
                    <input type="text" id="edit-name" name="name" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Firm Name</label>
                    <input type="text" id="edit-company" name="company" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone</label>
                    <input type="text" id="edit-phone" name="phone" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">City</label>
                    <input type="text" id="edit-city" name="city" placeholder="City name" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" id="edit-email" name="email" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status (RESPONSE)</label>
                    <select id="edit-status" name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Converted">Converted</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Priority</label>
                    <select id="edit-priority" name="priority" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigned To (EMP)</label>
                    <select id="edit-assigned-to" name="assigned_to" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Unassigned</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Agent (AGENT)</label>
                    <input type="text" id="edit-agent" name="agent" placeholder="Agent Name" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Callback Date</label>
                    <input type="date" id="edit-callback" name="follow_up_date" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Basic Plan (₹) (BASIC)</label>
                    <input type="number" step="0.01" id="edit-basic" name="basic" placeholder="Basic Amount" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pro Plan (₹) (PRO)</label>
                    <input type="number" step="0.01" id="edit-pro" name="pro" placeholder="Pro Amount" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-bold">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Remarks (REMARKS)</label>
                <textarea id="edit-notes" name="notes" rows="2" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('edit-lead-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#f59e0b] hover:bg-[#d97706] text-white text-xs font-bold shadow-sm transition cursor-pointer">Update Lead</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: SCHEDULE DEMO / CALLBACK -->
<div id="schedule-lead-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-800">Schedule Demo / Meeting</h3>
            <button type="button" onclick="document.getElementById('schedule-lead-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form action="{{ route('crm.admin.demos.store') }}" method="POST" class="space-y-3.5">
            @csrf
            <input type="hidden" id="sched-lead-id" name="lead_id">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Demo Title *</label>
                <input type="text" id="sched-title" name="title" required placeholder="e.g. Solution Walkthrough" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                    <select id="sched-assigned-to" name="assigned_to" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Staff...</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Agenda</label>
                <textarea name="notes" rows="2" placeholder="Discussion agenda..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('schedule-lead-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#06b6d4] hover:bg-[#0891b2] text-white text-xs font-bold shadow-sm transition">Schedule Demo</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSelectAll(master) {
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    checkboxes.forEach(cb => cb.checked = master.checked);
    updateSelectedCount();
}

function updateSelectedCount() {
    const count = document.querySelectorAll('.lead-checkbox:checked').length;
    document.getElementById('selected-count-badge').innerText = count;
}

function executeAssign(mode) {
    const empSelect = document.getElementById('action-employee-select');
    const form = document.getElementById('bulkActionForm');
    const formEmp = document.getElementById('form-assigned-to');
    const formAssignAll = document.getElementById('form-assign-all');
    const formAutoAssign = document.getElementById('form-auto-assign');

    formAssignAll.value = "0";
    formAutoAssign.value = "0";

    if (mode === 'auto') {
        formAutoAssign.value = "1";
        form.submit();
        return;
    }

    if (!empSelect.value) {
        alert('Please select an employee from the dropdown first.');
        empSelect.focus();
        return;
    }

    formEmp.value = empSelect.value;

    if (mode === 'selected') {
        const checkedCount = document.querySelectorAll('.lead-checkbox:checked').length;
        if (checkedCount === 0) {
            alert('Please select at least one lead from the table checkboxes.');
            return;
        }
        form.submit();
    } else if (mode === 'all') {
        if (confirm('Are you sure you want to assign ALL filtered leads to ' + empSelect.options[empSelect.selectedIndex].text + '?')) {
            formAssignAll.value = "1";
            form.submit();
        }
    }
}

function viewLeadModal(lead) {
    document.getElementById('view-name').innerText = lead.name || '-';
    document.getElementById('view-company').innerText = lead.company || '-';
    document.getElementById('view-phone').innerText = lead.phone || '-';
    if (document.getElementById('view-city')) document.getElementById('view-city').innerText = lead.city || '-';
    document.getElementById('view-status').innerText = lead.status || '-';
    document.getElementById('view-priority').innerText = lead.priority || '-';
    if (document.getElementById('view-emp')) {
        document.getElementById('view-emp').innerText = lead.assigned_name || (lead.assigned_employee ? lead.assigned_employee.name : (lead.assignedEmployee ? lead.assignedEmployee.name : 'Unassigned'));
    }
    document.getElementById('view-agent').innerText = lead.agent || '-';
    if (document.getElementById('view-callback')) document.getElementById('view-callback').innerText = lead.follow_up_date || lead.callback || '-';
    if (document.getElementById('view-basic')) document.getElementById('view-basic').innerText = lead.basic ? ('₹' + Number(lead.basic).toLocaleString('en-IN')) : '-';
    if (document.getElementById('view-pro')) document.getElementById('view-pro').innerText = lead.pro ? ('₹' + Number(lead.pro).toLocaleString('en-IN')) : (lead.expected_value ? ('₹' + Number(lead.expected_value).toLocaleString('en-IN')) : '-');
    document.getElementById('view-remarks').innerText = lead.notes || 'No remarks available.';
    document.getElementById('view-lead-modal').classList.remove('hidden');
}

function editLeadModal(lead) {
    document.getElementById('edit-name').value = lead.name || '';
    document.getElementById('edit-phone').value = lead.phone || '';
    document.getElementById('edit-email').value = lead.email || '';
    document.getElementById('edit-company').value = lead.company || '';
    if (document.getElementById('edit-city')) document.getElementById('edit-city').value = lead.city || '';
    document.getElementById('edit-status').value = lead.status || 'New';
    document.getElementById('edit-priority').value = lead.priority || 'Medium';
    document.getElementById('edit-assigned-to').value = lead.assigned_to || '';
    if (document.getElementById('edit-agent')) document.getElementById('edit-agent').value = lead.agent || '';
    if (document.getElementById('edit-callback')) document.getElementById('edit-callback').value = lead.follow_up_date || lead.callback || '';
    if (document.getElementById('edit-basic')) document.getElementById('edit-basic').value = lead.basic || '';
    if (document.getElementById('edit-pro')) document.getElementById('edit-pro').value = lead.pro || (lead.expected_value || '');
    document.getElementById('edit-notes').value = lead.notes || '';
    document.getElementById('editLeadForm').action = "/crm/admin/leads/" + lead.id;
    document.getElementById('edit-lead-modal').classList.remove('hidden');
}

function scheduleLeadModal(lead) {
    document.getElementById('sched-lead-id').value = lead.id;
    document.getElementById('sched-title').value = "Demo presentation for " + (lead.company || lead.name);
    document.getElementById('sched-assigned-to').value = lead.assigned_to || '';
    document.getElementById('schedule-lead-modal').classList.remove('hidden');
}

function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) return;
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = [];
        const cols = rows[i].querySelectorAll('td, th');
        // skip checkbox (col 0) and action (last col)
        for (let j = 1; j < cols.length - 1; j++) {
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

function deleteLeadConfirm(id, name) {
    if (!confirm('Are you sure you want to delete lead "' + (name || id) + '"?')) {
        return;
    }
    const form = document.getElementById('deleteLeadForm');
    form.action = "/crm/admin/leads/" + id;
    form.submit();
}

function executeDeleteSelected() {
    const checked = document.querySelectorAll('.lead-checkbox:checked');
    if (!checked.length) {
        alert('Please select at least one lead from the table checkboxes.');
        return;
    }
    if (!confirm('Are you sure you want to delete ' + checked.length + ' selected lead(s)?')) {
        return;
    }
    const container = document.getElementById('bulk-delete-inputs');
    container.innerHTML = '';
    checked.forEach(chk => {
        const inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'lead_ids[]';
        inp.value = chk.value;
        container.appendChild(inp);
    });
    document.getElementById('bulkDeleteForm').submit();
}
</script>

<form id="deleteLeadForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<form id="bulkDeleteForm" method="POST" action="{{ route('crm.admin.leads.bulk-delete') }}" class="hidden">
    @csrf
    <div id="bulk-delete-inputs"></div>
</form>
@endsection
