@extends('crm.layouts.master')

@section('title', 'My Customers')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">My Retained Customers</h2>
        <p class="text-xs text-slate-500 font-medium">Accounts under your direct account management</p>
    </div>

    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100 text-slate-700 uppercase text-[10px] font-black tracking-wider">
                        <th class="py-3 px-4">Account Code</th>
                        <th class="py-3 px-4">Customer Name</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Email / Phone</th>
                        <th class="py-3 px-4">Total Spend</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">{{ $c->customer_code }}</td>
                            <td class="py-3.5 px-4 font-black text-slate-900">{{ $c->name }}</td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $c->company ?: 'Individual' }}</td>
                            @php
                                $maskPhone = \App\Http\Controllers\Crm\CrmAuthController::employeeHasPermission('leads.mask_phone');
                                $phoneDisplay = $c->phone;
                                if ($maskPhone && !empty($c->phone)) {
                                    $digits = preg_replace('/\D/', '', $c->phone);
                                    $phoneDisplay = strlen($digits) >= 4 ? substr($digits, 0, 2) . '******' . substr($digits, -2) : '******';
                                }
                            @endphp
                            <td class="py-3.5 px-4 text-slate-600">
                                @if($c->email && $c->phone)
                                    <div>{{ $c->email }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $phoneDisplay }}</div>
                                @elseif($c->phone)
                                    <span class="font-mono">{{ $phoneDisplay }}</span>
                                @else
                                    {{ $c->email ?: '—' }}
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-black text-emerald-800">₹{{ number_format($c->total_spent) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $c->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg mx-auto">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                    <h4 class="text-xs font-black text-slate-800">No Customers Assigned Yet</h4>
                                    <p class="text-[11px] font-semibold text-slate-500">Converted client accounts under your portfolio will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
