@extends('crm.layouts.master')

@section('title', 'Employee Dashboard')

@section('content')
@php
    $canLeads = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.view');
    $canCustomers = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('customers.view');
    $canDeals = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('deals.view');
    $canTasks = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('tasks.manage');
    $canFollowups = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('followups.manage');
    $maskPhone = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.mask_phone');
@endphp
<div class="space-y-6">

    <!-- Top Hero Banner for Employee with Exact Uploaded Light Shade -->
    <div class="p-6 md:p-8 rounded-3xl shadow-sm relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border border-[#b4db87]/70" style="background: linear-gradient(135deg, #c0e097 0%, #cde7a7 30%, #daf0be 65%, #ebf8d9 100%);">
        <!-- Subtle decorative glow -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-white/60 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-lime-100/50 blur-3xl pointer-events-none"></div>

        <div class="max-w-xl z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md text-[11px] font-extrabold tracking-wider uppercase mb-3 text-emerald-900 border border-emerald-900/15 shadow-xs">
                <i class="fa-solid fa-id-badge text-emerald-700"></i>
                <span>Representative Workspace &bull; {{ $employee->designation ?: 'Sales Representative' }}</span>
            </span>
            <h2 class="text-2xl md:text-3xl font-black leading-tight tracking-tight text-slate-900 mb-2">
                My Pipeline Performance &amp; Target Velocity
            </h2>
            <p class="text-xs md:text-sm text-slate-800 leading-relaxed font-semibold">
                You have closed <strong class="text-emerald-900 font-black">₹{{ number_format($myRevenue) }}</strong> in deals this quarter. Focus on today's scheduled follow-ups to maximize quota achievement.
            </p>
            <div class="mt-5 flex items-center flex-wrap gap-3">
                @if($canFollowups)
                <a href="{{ route('crm.employee.followups') }}" class="px-5 py-2.5 rounded-full bg-white text-emerald-900 font-black text-xs hover:bg-emerald-50 transition shadow-md inline-flex items-center gap-2 border border-emerald-200/80 active:scale-95">
                    <i class="fa-solid fa-phone text-[11px] text-emerald-700"></i>
                    <span>Today's Follow-ups ({{ count($todaysFollowups) }})</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
                @endif
                @if($canLeads)
                <a href="{{ route('crm.employee.leads') }}" class="px-5 py-2.5 rounded-full bg-white/70 hover:bg-white text-slate-800 font-extrabold text-xs transition border border-emerald-300/80 shadow-sm active:scale-95 inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-users text-[11px] text-emerald-700"></i>
                    <span>My Leads ({{ $myTotalLeads }})</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Right Quota Card -->
        <div class="hidden md:flex items-center justify-center pr-4 z-10 shrink-0">
            <div class="w-40 h-40 rounded-3xl bg-white/85 backdrop-blur-md border border-white/90 flex flex-col items-center justify-center p-4 text-center shadow-md">
                <i class="fa-solid fa-trophy text-3xl text-amber-500 mb-2 drop-shadow-xs"></i>
                <span class="text-xs font-black text-slate-700 tracking-wide uppercase">My Quota</span>
                <span class="text-2xl font-black text-emerald-900 leading-tight mt-0.5">{{ $targetAchieved }}%</span>
                <span class="text-[11px] font-bold text-slate-600 mt-1">₹{{ number_format($myRevenue / 1000) }}K / ₹{{ number_format($target / 1000) }}K</span>
            </div>
        </div>
    </div>

    <!-- Employee Metric Cards (Dynamically shown based on RBAC permissions) -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @if($canLeads)
        <!-- 1. My Total Leads -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-user-tag"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">Assigned</span>
            </div>
            <p class="text-xs font-bold text-slate-700">My Total Leads</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ $myTotalLeads }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Active prospects</span>
        </div>

        <!-- 2. New Leads -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Fresh</span>
            </div>
            <p class="text-xs font-bold text-slate-700">New Inbound</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ $myNewLeads }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Awaiting first call</span>
        </div>

        <!-- 3. Converted Leads -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-700 border border-teal-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-teal-100 text-teal-800 border border-teal-200">Won</span>
            </div>
            <p class="text-xs font-bold text-slate-700">Converted Leads</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ $myConvertedLeads }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Successfully closed</span>
        </div>
        @endif

        @if($canCustomers)
        <!-- 4. My Customers -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-building"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-200">Retained</span>
            </div>
            <p class="text-xs font-bold text-slate-700">My Customers</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ $myCustomers }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Assigned accounts</span>
        </div>
        @endif

        @if($canDeals)
        <!-- 5. My Deals -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 border border-purple-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-purple-100 text-purple-800 border border-purple-200">Pipeline</span>
            </div>
            <p class="text-xs font-bold text-slate-700">My Deals</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ $myDealsCount }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Active proposals</span>
        </div>

        <!-- 6. My Revenue -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Closed</span>
            </div>
            <p class="text-xs font-bold text-slate-700">My Revenue</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">₹{{ number_format($myRevenue) }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Won deal total</span>
        </div>
        @endif

        @if($canFollowups)
        <!-- 7. Today's Follow-ups -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">Calls</span>
            </div>
            <p class="text-xs font-bold text-slate-700">Today's Follow-ups</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ count($todaysFollowups) }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Scheduled for today</span>
        </div>
        @endif

        @if($canTasks)
        <!-- 8. Pending Tasks -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 flex items-center justify-center text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 border border-rose-200">Due</span>
            </div>
            <p class="text-xs font-bold text-slate-700">Pending Tasks</p>
            <div class="text-2xl font-black text-slate-900 mt-0.5 leading-tight">{{ count($pendingTasks) }}</div>
            <span class="text-[11px] font-semibold text-slate-500 mt-1 block">Urgent deliverables</span>
        </div>
        @endif
    </div>

    <!-- Charts & Action Lists -->
    @if($canLeads || $canFollowups || $canTasks)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if($canLeads)
        <!-- My Pipeline Distribution (2 cols) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 {{ ($canFollowups || $canTasks) ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-black text-slate-900">My Sales Pipeline Status</h3>
                    <p class="text-xs font-semibold text-slate-600 mt-0.5">Breakdown of leads currently in progress</p>
                </div>
                <a href="{{ route('crm.employee.leads') }}" class="text-xs font-black text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition">
                    <span>View My Leads</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="h-64">
                <canvas id="empPipelineChart"></canvas>
            </div>
        </div>
        @endif

        @if($canFollowups || $canTasks)
        <!-- Today's Action Items (1 col) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between {{ $canLeads ? '' : 'lg:col-span-3' }}">
            <div>
                <div class="pb-2 border-b border-slate-100 mb-4">
                    <h3 class="text-base font-black text-slate-900">Today's Action Items</h3>
                    <p class="text-xs font-semibold text-slate-600 mt-0.5">High-priority deliverables due today</p>
                </div>

                <div class="space-y-3">
                    @forelse($todaysFollowups as $fu)
                        <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-white text-amber-600 border border-amber-200 flex items-center justify-center font-bold shadow-xs">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-black text-slate-900">{{ $fu->lead ? $fu->lead->name : 'Client Follow-up' }}</div>
                                    <div class="text-[11px] font-semibold text-slate-600 font-mono mt-0.5">{{ $fu->time ? substr($fu->time, 0, 5) : '10:00' }}</div>
                                </div>
                            </div>
                            <a href="{{ route('crm.employee.followups') }}" class="text-[11px] font-black px-3 py-1 rounded-lg bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs transition">Done</a>
                        </div>
                    @empty
                        @forelse($pendingTasks as $task)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-black text-slate-900 truncate max-w-[170px]">{{ $task->title }}</div>
                                    <div class="text-[11px] font-semibold text-slate-600 mt-0.5">Due: {{ $task->due_date }}</div>
                                </div>
                                <span class="text-[10px] font-black px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-200">{{ $task->priority }}</span>
                            </div>
                        @empty
                            <div class="py-10 text-center space-y-2.5">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-lg mx-auto shadow-xs">
                                    <i class="fa-solid fa-check-double"></i>
                                </div>
                                <p class="text-xs font-black text-slate-800">All Daily Follow-ups Completed!</p>
                                <p class="text-[11px] font-semibold text-slate-500 max-w-[200px] mx-auto">No pending follow-ups or urgent tasks due for today.</p>
                            </div>
                        @endforelse
                    @endforelse
                </div>
            </div>

            <!-- Progress box -->
            <div class="mt-6 pt-4 border-t border-slate-100">
                <div class="flex justify-between text-xs font-black text-slate-800 mb-1.5">
                    <span>Quarterly Quota</span>
                    <span class="text-emerald-700 font-black">{{ $targetAchieved }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-[#1b4d3e] h-2.5 rounded-full transition-all duration-500" style="width: {{ min($targetAchieved, 100) }}%"></div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($canLeads)
    <!-- Recent Assigned Leads -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <div>
                <h3 class="text-base font-black text-slate-900">My Recent Assigned Prospects</h3>
                <p class="text-xs font-semibold text-slate-600 mt-0.5">Directly assigned for qualification and negotiation</p>
            </div>
            <a href="{{ route('crm.employee.leads') }}" class="text-xs font-black text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition">
                <span>View All Leads</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 uppercase text-[10px] font-black tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4">Lead Code</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Expected Value</th>
                        <th class="py-3 px-4">Priority</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentLeads as $l)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">{{ $l->lead_code }}</td>
                            <td class="py-3.5 px-4 font-black text-slate-900">{{ $l->name }}</td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $l->company ?: '—' }}</td>
                            <td class="py-3.5 px-4 font-black text-emerald-800">₹{{ number_format($l->expected_value) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $l->priority === 'Urgent' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    {{ $l->priority }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $l->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg mx-auto">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <h4 class="text-xs font-black text-slate-800">No Prospects Assigned Yet</h4>
                                    <p class="text-[11px] font-semibold text-slate-500">Newly assigned inbound leads will appear here for qualification.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
@if($canLeads)
<script>
    const elPipe = document.getElementById('empPipelineChart');
    if (elPipe) {
        const ctxEmpPipe = elPipe.getContext('2d');
        new Chart(ctxEmpPipe, {
            type: 'bar',
            data: {
                labels: @json(array_keys($statusCounts)),
                datasets: [{
                    label: 'Assigned Leads',
                    data: @json(array_values($statusCounts)),
                    backgroundColor: ['#10b981', '#6366f1', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#ef4444'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        grid: { color: '#e2e8f0' }, 
                        ticks: { color: '#334155', font: { weight: 'bold', size: 11 }, stepSize: 1, precision: 0 },
                        beginAtZero: true
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { color: '#1e293b', font: { weight: 'bold', size: 11 } } 
                    }
                }
            }
        });
    }
</script>
@endif
@endpush
