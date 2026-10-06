@extends('crm.layouts.master')

@section('title', 'Live Travel Tracking')

@section('content')
<div class="space-y-6">

    <!-- Header & Controls -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <!-- Title & Subtitle -->
        <div>
            <div class="flex items-center gap-2.5">
                <span class="w-3.5 h-3.5 rounded-sm bg-emerald-500 inline-block shadow-sm"></span>
                <h1 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">Live Travel Tracking</h1>
            </div>
            <p class="text-xs text-slate-400 mt-1 font-medium">Real-time travel & location tracking for field sales representatives</p>
        </div>

        <!-- Right Side Filters & Actions -->
        <div class="flex items-center flex-wrap gap-2.5">
            <!-- Date Filter -->
            <div class="relative">
                <input type="date" id="dateFilter" value="{{ $selectedDate }}" onchange="applyFilters()" 
                       class="bg-white border border-slate-200 text-slate-700 font-semibold text-xs rounded-xl px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 hover:border-slate-300 transition cursor-pointer">
            </div>

            <!-- Employee Dropdown Filter -->
            <div class="relative">
                <select id="employeeFilter" onchange="applyFilters()" 
                        class="bg-white border border-slate-200 text-slate-700 font-semibold text-xs rounded-xl px-3.5 py-2 pr-8 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 hover:border-slate-300 transition cursor-pointer appearance-none">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $selectedEmployeeId == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400 text-[10px]">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <!-- Live updates ON Badge -->
            <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200/90 text-emerald-700 text-xs font-bold shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Live updates ON</span>
            </span>

            <!-- Refresh Button -->
            <button type="button" onclick="location.reload()" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-arrows-rotate text-xs"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Employee Travel Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($employees as $index => $emp)
            <div onclick="selectEmployee('{{ $emp->id }}')" 
                 class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition relative border-l-4 border-l-[#4f46e5] cursor-pointer {{ $selectedEmployeeId == $emp->id ? 'ring-2 ring-indigo-500' : '' }}">
                
                <!-- Card Header -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user text-[#4f46e5] text-xs"></i>
                        <h4 class="font-bold text-sm text-slate-800">{{ $emp->name }}</h4>
                    </div>
                    @if($selectedEmployeeId == $emp->id)
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Selected</span>
                    @endif
                </div>

                <!-- 2x2 Metric Grid -->
                <div class="grid grid-cols-2 gap-2">
                    <!-- Visits -->
                    <div class="bg-[#f8fafc] border border-slate-100 rounded-xl p-2.5 text-center">
                        <div class="text-base font-black text-slate-800">{{ $emp->visits ?? 0 }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">VISITS</div>
                    </div>

                    <!-- KM -->
                    <div class="bg-[#f8fafc] border border-slate-100 rounded-xl p-2.5 text-center">
                        <div class="text-base font-black text-[#10b981]">{{ $emp->km ?? 'null' }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">KM</div>
                    </div>

                    <!-- IN TIME -->
                    <div class="bg-[#f8fafc] border border-slate-100 rounded-xl p-2.5 text-center">
                        <div class="text-base font-black text-[#f59e0b]">{{ $emp->in_time ?? 'null' }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">IN TIME</div>
                    </div>

                    <!-- OUT TIME -->
                    <div class="bg-[#f8fafc] border border-slate-100 rounded-xl p-2.5 text-center">
                        <div class="text-base font-black text-[#64748b]">{{ $emp->out_time ?? 'null' }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">OUT TIME</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bottom Section: Assigned Leads & Activity Log -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left: Assigned Leads Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm min-h-[280px] flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-bars-staggered text-[#4f46e5] text-sm"></i>
                    <h3 class="font-bold text-sm text-slate-800">Assigned Leads</h3>
                </div>
                <span class="w-6 h-6 rounded-full bg-indigo-50 text-[#4f46e5] flex items-center justify-center text-xs">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </span>
            </div>

            <!-- Content -->
            @if($assignedLeads->isEmpty())
                <!-- Empty State matching reference image -->
                <div class="flex-1 flex flex-col items-center justify-center text-center py-12">
                    <div class="text-slate-300 text-3xl mb-3">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-400">No tracking data for this day</p>
                </div>
            @else
                <div class="divide-y divide-slate-100 flex-1 overflow-y-auto max-h-[360px]">
                    @foreach($assignedLeads as $lead)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $lead->company_name ?: $lead->contact_person }}</h4>
                                <span class="text-[11px] text-slate-500">{{ $lead->email ?: $lead->phone }}</span>
                            </div>
                            <div class="text-right">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $lead->status ?: 'New' }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">{{ $lead->created_at->format('h:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Activity Log Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm min-h-[280px] flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500 text-sm"></i>
                    <h3 class="font-bold text-sm text-slate-800">Activity Log</h3>
                </div>
                <span class="w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </span>
            </div>

            <!-- Content -->
            @if($activityLogs->isEmpty())
                <!-- Empty State matching reference image -->
                <div class="flex-1 flex flex-col items-center justify-center text-center py-12">
                    <div class="text-slate-300 text-3xl mb-3">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-400">No activity for this day</p>
                </div>
            @else
                <div class="space-y-3 flex-1 overflow-y-auto max-h-[360px]">
                    @foreach($activityLogs as $log)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-slate-800">{{ $log->user_name ?: 'System' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $log->created_at->format('h:i A') }}</span>
                            </div>
                            <p class="text-[11px] text-slate-600">{{ $log->description }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Filter JavaScript -->
<script>
    function applyFilters() {
        const date = document.getElementById('dateFilter').value;
        const employeeId = document.getElementById('employeeFilter').value;
        
        let url = new URL(window.location.href);
        if (date) url.searchParams.set('date', date);
        else url.searchParams.delete('date');

        if (employeeId) url.searchParams.set('employee_id', employeeId);
        else url.searchParams.delete('employee_id');

        window.location.href = url.toString();
    }

    function selectEmployee(empId) {
        const currentEmp = document.getElementById('employeeFilter').value;
        if (currentEmp == empId) {
            document.getElementById('employeeFilter').value = '';
        } else {
            document.getElementById('employeeFilter').value = empId;
        }
        applyFilters();
    }
</script>
@endsection
