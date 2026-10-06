@extends('crm.layouts.master')

@section('title', 'My Assigned Leads')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Assigned Leads</h2>
            <p class="text-xs text-slate-500 font-medium">Prospects assigned to you for discovery, qualification and proposal presentation</p>
        </div>
    </div>

    <!-- Leads List -->
    <div class="crm-card overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <form method="GET" action="{{ route('crm.employee.leads') }}" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search my leads..." 
                       class="text-xs py-2 px-3 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 bg-slate-50 w-64">
                <button type="submit" class="py-2 px-3 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200">Search</button>
            </form>
            <span class="text-xs text-slate-400 font-medium">{{ $leads->total() }} assigned prospects</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100 text-slate-700 uppercase text-[10px] font-black tracking-wider">
                        <th class="py-3 px-4">Lead Code</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Contact</th>
                        <th class="py-3 px-4">Expected Value</th>
                        <th class="py-3 px-4">Priority</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($leads as $l)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-700">{{ $l->lead_code }}</td>
                            <td class="py-3.5 px-4 font-black text-slate-900">{{ $l->name }}</td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $l->company ?: '—' }}</td>
                            @php
                                $maskPhone = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.mask_phone');
                                $phoneDisplay = $l->phone;
                                if ($maskPhone && !empty($l->phone)) {
                                    $digits = preg_replace('/\D/', '', $l->phone);
                                    $phoneDisplay = strlen($digits) >= 4 ? substr($digits, 0, 2) . '******' . substr($digits, -2) : '******';
                                }
                            @endphp
                            <td class="py-3.5 px-4 text-slate-600">
                                @if($l->email && $l->phone)
                                    <div>{{ $l->email }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $phoneDisplay }}</div>
                                @elseif($l->phone)
                                    <span class="font-mono">{{ $phoneDisplay }}</span>
                                @else
                                    {{ $l->email ?: '—' }}
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-black text-slate-800">₹{{ number_format($l->expected_value) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $l->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700' }}">{{ $l->priority }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $l->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg mx-auto">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                    <h4 class="text-xs font-black text-slate-800">No Leads Currently Assigned</h4>
                                    <p class="text-[11px] font-semibold text-slate-500">When prospects are assigned to you by admin, they will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
