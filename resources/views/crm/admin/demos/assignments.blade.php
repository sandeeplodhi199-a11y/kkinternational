@extends('crm.layouts.master')

@section('title', 'Demo Assignments')

@section('content')
<div class="space-y-5">

    <!-- Top 5 KPI Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
        <!-- 1. Total Demos -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#ede9fe] text-[#6366f1] flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-video"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 leading-tight">{{ $totalDemos }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Demos</div>
            </div>
        </div>

        <!-- 2. Pending / Unassigned -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#ffe4e6] text-[#f43f5e] flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 leading-tight">{{ $pendingDemos }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Pending Demos</div>
            </div>
        </div>

        <!-- 3. Scheduled / Upcoming -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#fef3c7] text-[#d97706] flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 leading-tight">{{ $scheduledDemos }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Scheduled Demos</div>
            </div>
        </div>

        <!-- 4. Completed Demos -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 leading-tight">{{ $completedDemos }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Completed Demos</div>
            </div>
        </div>

        <!-- 5. Cancelled Demos -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#fee2e2] text-[#ef4444] flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-calendar-xmark"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-800 leading-tight">{{ $cancelledDemos }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Cancelled Demos</div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-indigo-600 text-xs"></i>
                <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Filter Criteria</h4>
            </div>
            @if(request('employee_id') || request('status') || request('from_date') || request('to_date'))
                <a href="{{ route('crm.admin.demos.assignments') }}" class="text-[11px] font-semibold text-rose-600 hover:underline">
                    Reset Filter
                </a>
            @else
                <span class="text-[11px] font-semibold text-slate-400">All Records</span>
            @endif
        </div>

        <form method="GET" action="{{ route('crm.admin.demos.assignments') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <!-- Rep Filter -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Sales Representative</label>
                <select name="employee_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- From Date -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                       class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- To Date -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                       class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Filter Button -->
            <div>
                <button type="submit" class="w-full bg-[#4f46e5] hover:bg-[#4338ca] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-1.5 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Section 1: Scheduled Demos -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-[#4f46e5] overflow-hidden">
        <!-- Header -->
        <div class="bg-[#f5f3ff] border-b border-indigo-100/70 px-5 py-3.5 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-calendar-check text-[#4f46e5] text-sm"></i>
                <h3 class="font-bold text-sm text-slate-800">Scheduled Demos</h3>
                <span class="bg-[#4f46e5] text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $scheduledDemosList->count() }}</span>
            </div>

            <button type="button" onclick="openScheduleModal()" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Schedule Demo</span>
            </button>
        </div>

        <!-- Body Table / Empty State -->
        @if($scheduledDemosList->isEmpty())
            <div class="py-12 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-calendar-xmark text-slate-300 text-3xl mb-2"></i>
                <p class="text-xs font-semibold text-slate-400">No scheduled demos</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50/70 text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100 tracking-wider">
                        <tr>
                            <th class="py-3 px-4">Demo Title</th>
                            <th class="py-3 px-4">Prospect / Client</th>
                            <th class="py-3 px-4">Assigned Rep</th>
                            <th class="py-3 px-4">Date & Time</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($scheduledDemosList as $demo)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800">{{ $demo->title }}</div>
                                    <span class="text-[10px] text-slate-400">ID: #DM-{{ $demo->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($demo->customer)
                                        <div class="font-bold text-slate-800">{{ $demo->customer->name }}</div>
                                        <span class="text-[10px] text-slate-400">{{ $demo->customer->company }}</span>
                                    @elseif($demo->lead)
                                        <div class="font-bold text-slate-800">{{ $demo->lead->name }}</div>
                                        <span class="text-[10px] text-slate-400">{{ $demo->lead->company }}</span>
                                    @else
                                        <span class="text-slate-400">General Prospect</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($demo->assignedEmployee)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            {{ $demo->assignedEmployee->name }}
                                        </span>
                                    @else
                                        <span class="text-amber-600 font-bold">Unassigned</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800">{{ date('d M Y', strtotime($demo->date)) }}</div>
                                    <span class="text-[11px] text-slate-400">{{ $demo->time }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        {{ $demo->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Section 2: Completed Demos -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-[#10b981] overflow-hidden">
        <!-- Header -->
        <div class="bg-[#ecfdf5] border-b border-emerald-100/70 px-5 py-3.5 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-[#10b981] text-sm"></i>
                <h3 class="font-bold text-sm text-slate-800">Completed Demos</h3>
                <span class="bg-[#10b981] text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $completedDemosList->count() }}</span>
            </div>

            <button type="button" onclick="window.print()" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#10b981] hover:bg-[#059669] text-white text-xs font-bold shadow-sm transition active:scale-95">
                <i class="fa-solid fa-file-excel text-xs"></i>
                <span>Export</span>
            </button>
        </div>

        <!-- Body Table / Empty State -->
        @if($completedDemosList->isEmpty())
            <div class="py-12 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-check-double text-slate-300 text-3xl mb-2"></i>
                <p class="text-xs font-semibold text-slate-400">No completed demos found</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50/70 text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100 tracking-wider">
                        <tr>
                            <th class="py-3 px-4">Demo Title</th>
                            <th class="py-3 px-4">Prospect / Client</th>
                            <th class="py-3 px-4">Assigned Rep</th>
                            <th class="py-3 px-4">Date & Time</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Feedback / Outcome</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($completedDemosList as $demo)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800">{{ $demo->title }}</div>
                                    <span class="text-[10px] text-slate-400">ID: #DM-{{ $demo->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($demo->customer)
                                        <div class="font-bold text-slate-800">{{ $demo->customer->name }}</div>
                                        <span class="text-[10px] text-slate-400">{{ $demo->customer->company }}</span>
                                    @elseif($demo->lead)
                                        <div class="font-bold text-slate-800">{{ $demo->lead->name }}</div>
                                        <span class="text-[10px] text-slate-400">{{ $demo->lead->company }}</span>
                                    @else
                                        <span class="text-slate-400">General Prospect</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $demo->assignedEmployee ? $demo->assignedEmployee->name : 'Staff' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800">{{ date('d M Y', strtotime($demo->date)) }}</div>
                                    <span class="text-[11px] text-slate-400">{{ $demo->time }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Completed
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ $demo->notes ?: 'Successfully delivered product walkthrough.' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<!-- Schedule Demo Modal -->
<div id="scheduleDemoModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 border border-slate-100">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
                <h3 class="font-black text-base text-slate-800">Schedule Product Demo</h3>
            </div>
            <button type="button" onclick="closeScheduleModal()" class="text-slate-400 hover:text-slate-600 text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('crm.admin.demos.store') }}" class="space-y-3.5">
            @csrf
            <input type="hidden" name="status" value="Scheduled">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Demo Title *</label>
                <input type="text" name="title" required placeholder="e.g. Enterprise CRM Walkthrough" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assign Sales Rep *</label>
                    <select name="assigned_to" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Rep</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Related Lead / Customer</label>
                    <select name="lead_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">General Prospect</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->name }} ({{ $lead->company }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Demo Date *</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Time *</label>
                    <input type="time" name="time" required value="11:00" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Link / Instructions</label>
                <textarea name="notes" rows="2" placeholder="e.g. Google Meet or Zoom link, focus on analytics feature" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeScheduleModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 transition">
                    Schedule Demo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openScheduleModal() {
        document.getElementById('scheduleDemoModal').classList.remove('hidden');
    }
    function closeScheduleModal() {
        document.getElementById('scheduleDemoModal').classList.add('hidden');
    }
</script>
@endsection
