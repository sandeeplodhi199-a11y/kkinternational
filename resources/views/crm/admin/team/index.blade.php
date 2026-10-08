@extends('crm.layouts.master')

@section('title', 'All Employees')

@section('content')
<div class="space-y-4">

    <!-- Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">

        <!-- Top Header: Title & Add Employee Button -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-users text-[#4f46e5] text-base"></i>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">All Employees</h2>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Auto Refresh Widget -->
                <div class="inline-flex items-center gap-1.5 p-0.5 bg-white border border-slate-200/90 rounded-full shadow-xs crm-auto-refresh-widget transition hover:border-emerald-400">
                    <button type="button" onclick="window.HMCrmStore && window.HMCrmStore.toggleAutoRefresh ? window.HMCrmStore.toggleAutoRefresh(event) : null" title="Click to Refresh Immediately" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full hover:bg-slate-50 text-slate-700 text-xs font-bold transition active:scale-95 cursor-pointer">
                        <span class="relative flex h-2 w-2">
                            <span class="auto-refresh-ping animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="auto-refresh-dot relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <i class="auto-refresh-icon fa-solid fa-arrows-rotate text-[11px] text-slate-400 transition-transform"></i>
                        <span class="auto-refresh-label text-[11px] font-bold">Auto Refresh: <strong class="text-emerald-700 font-black">ON</strong></span>
                        <span class="auto-refresh-timer px-1.5 py-0.2 rounded-full bg-emerald-100 text-emerald-800 font-mono text-[10px] font-black">10s</span>
                    </button>
                    <button type="button" onclick="window.HMCrmStore && window.HMCrmStore.toggleAutoRefreshState ? window.HMCrmStore.toggleAutoRefreshState(event) : null" title="Toggle Auto Refresh ON/OFF" class="w-6 h-6 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center text-[10px] transition cursor-pointer">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </div>

                <a href="{{ route('crm.admin.team.create') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold shadow-sm transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add Employee</span>
                </a>
            </div>
        </div>

        <!-- Table Controls: Show Entries & Search -->
        <div class="flex items-center justify-between flex-wrap gap-4 pb-2">
            <!-- Left: Page length -->
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span>Show</span>
                <select id="perPageSelect" onchange="applyFilters()" 
                        class="bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>entries</span>
            </div>

            <!-- Right: Search -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Search:</span>
                <div class="relative">
                    <input type="text" id="searchInput" value="{{ request('search') }}" 
                           placeholder="" 
                           onkeyup="if(event.key === 'Enter') applyFilters()"
                           class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48 sm:w-56">
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-400 uppercase text-[10px] font-bold tracking-wider">
                        <th class="py-3 px-4 w-12 text-slate-400">#</th>
                        <th class="py-3 px-4 text-slate-400">NAME</th>
                        <th class="py-3 px-4 text-slate-400">EMAIL</th>
                        <th class="py-3 px-4 text-slate-400">PHONE NO.</th>
                        <th class="py-3 px-4 text-slate-400 text-center">TOTAL LEADS</th>
                        <th class="py-3 px-4 text-slate-400 text-center">TOTAL DEMOS</th>
                        <th class="py-3 px-4 text-slate-400">REMARKS</th>
                        <th class="py-3 px-4 text-slate-400 text-center">STATUS</th>
                        <th class="py-3 px-4 text-slate-400 text-center w-32">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($employees as $index => $emp)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <!-- Col 1: # -->
                            <td class="py-3.5 px-4 font-bold text-slate-400 text-xs">
                                {{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}
                            </td>

                            <!-- Col 2: Name -->
                            <td class="py-3.5 px-4 font-bold text-slate-800 text-xs whitespace-nowrap">
                                {{ $emp->name }}
                            </td>

                            <!-- Col 3: Email -->
                            <td class="py-3.5 px-4 text-slate-600 text-xs whitespace-nowrap">
                                {{ $emp->email }}
                            </td>

                            <!-- Col 4: Phone -->
                            <td class="py-3.5 px-4 text-slate-600 text-xs whitespace-nowrap">
                                {{ $emp->phone ?: '+91 98765 00000' }}
                            </td>

                            <!-- Col 5: Total Leads -->
                            <td class="py-3.5 px-4 font-bold text-slate-800 text-xs text-center whitespace-nowrap">
                                {{ $emp->leads_count ?? 0 }}
                            </td>

                            <!-- Col 6: Total Demos -->
                            <td class="py-3.5 px-4 font-bold text-slate-800 text-xs text-center whitespace-nowrap">
                                {{ ($emp->demos_count ?? 0) ?: ($emp->demos ? $emp->demos->count() : 0) }}
                            </td>

                            <!-- Col 7: Remarks -->
                            <td class="py-3.5 px-4 text-slate-500 text-xs max-w-xs truncate">
                                {{ $emp->remarks ?: '-' }}
                            </td>

                            <!-- Col 8: Status -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($emp->status === 'Active')
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-[#e8f5e9] text-[#2e7d32] border border-[#a5d6a7]">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Col 9: Actions (Orange Edit, Cyan Demo, Red Delete) -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <!-- Orange Edit Button -->
                                    <a href="{{ route('crm.admin.team.edit', $emp->id) }}" 
                                       class="w-7 h-7 rounded-lg bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center transition shadow-sm active:scale-95" 
                                       title="Edit Employee">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                    </a>

                                    <!-- Cyan Demo Button -->
                                    <a href="{{ route('crm.admin.demos.index', ['assigned_to' => $emp->id]) }}" 
                                       class="w-7 h-7 rounded-lg bg-[#06b6d4] hover:bg-[#0891b2] text-white flex items-center justify-center transition shadow-sm active:scale-95" 
                                       title="Schedule / View Demos">
                                        <i class="fa-solid fa-calendar-days text-[11px]"></i>
                                    </a>

                                    <!-- Red Trash Button -->
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $emp->id }}', '{{ addslashes($emp->name) }}')" 
                                            class="w-7 h-7 rounded-lg bg-[#ef4444] hover:bg-[#dc2626] text-white flex items-center justify-center transition shadow-sm active:scale-95" 
                                            title="Delete">
                                        <i class="fa-solid fa-trash text-[11px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-10 text-slate-400 text-xs">
                                <i class="fa-solid fa-user-slash text-2xl text-slate-300 mb-2 block"></i>
                                <span>No employees found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bottom Controls & Pagination -->
        <div class="flex items-center justify-between flex-wrap gap-4 pt-3 border-t border-slate-100 text-xs text-slate-500">
            <!-- Showing info -->
            <div>
                Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} entries
            </div>

            <!-- Pagination Buttons -->
            <div>
                @if ($employees->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($employees->onFirstPage())
                            <span class="px-3 py-1.5 text-xs text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $employees->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Previous</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                            @if ($page == $employees->currentPage())
                                <span class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 border border-indigo-600 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($employees->hasMorePages())
                            <a href="{{ $employees->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Next</a>
                        @else
                            <span class="px-3 py-1.5 text-xs text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>

    </div>

</div>

<!-- Modal: Add Employee -->
<div id="addEmpModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 border border-slate-100">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <h3 class="font-black text-base text-slate-800">Add New Employee</h3>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('crm.admin.team.store') }}" method="POST" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                <input type="text" name="name" required placeholder="e.g. Rahul Sharma" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                <input type="email" name="email" required placeholder="e.g. rahul@hisabmittra.com" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                <input type="text" name="phone" placeholder="e.g. +91 98765 43210" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Designation</label>
                    <input type="text" name="designation" placeholder="Field Representative" value="Field Representative" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Default: 12345678" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 transition">
                    Save Employee
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteEmpForm" method="POST" action="" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function applyFilters() {
        const perPage = document.getElementById('perPageSelect').value;
        const search = document.getElementById('searchInput').value;
        
        let url = new URL(window.location.href);
        if (perPage) url.searchParams.set('per_page', perPage);
        else url.searchParams.delete('per_page');

        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');

        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    function openAddModal() {
        document.getElementById('addEmpModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addEmpModal').classList.add('hidden');
    }

    function confirmDelete(id, name) {
        if (confirm('Are you sure you want to delete employee "' + name + '"?')) {
            const form = document.getElementById('deleteEmpForm');
            form.action = '/crm/admin/team/' + id;
            form.submit();
        }
    }
</script>
@endsection
