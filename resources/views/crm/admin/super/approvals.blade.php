@extends('crm.layouts.master')

@section('title', 'Financial Approvals & Quotations')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Quotation & Discount Approvals</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-700 font-bold mt-1">
                Quotations exceeding discount allowances or value thresholds require Super Admin verification before dispatch.
            </p>
        </div>
    </div>

    <!-- Approvals Table Card -->
    <div class="crm-card border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-black">
                    <i class="fa-solid fa-stamp"></i>
                </span>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Pending Financial Requests</h3>
                    <p class="text-xs font-bold text-slate-600">Review line items, gross margin, and approve or reject</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300">
                Threshold: >₹5,000 Discount
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 text-slate-700 font-black text-[11px] uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4">QUOTATION #</th>
                        <th class="py-3 px-4">CUSTOMER / ACCOUNT</th>
                        <th class="py-3 px-4">GRAND TOTAL</th>
                        <th class="py-3 px-4">DISCOUNT OFFERED</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4 text-right">SUPER ADMIN ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-bold">
                    @forelse($pendingQuotations as $q)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-mono font-black text-slate-900">
                                <a href="{{ route('crm.admin.quotations.show', $q->id) }}" class="text-blue-600 hover:underline">
                                    {{ $q->quotation_no }}
                                </a>
                                <span class="text-[10px] text-slate-500 block font-sans">{{ $q->quotation_date }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-900">
                                <span class="font-black block">{{ $q->customer_name }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ $q->customer_phone ?: $q->customer_email }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-black text-slate-900 text-sm">
                                ₹{{ number_format($q->grand_total, 2) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-black text-rose-600">
                                    ₹{{ number_format($q->discount_amount, 2) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $q->approval_status === 'Approved' ? 'bg-emerald-100 text-emerald-800' : ($q->approval_status === 'Rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $q->approval_status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('crm.admin.super.approvals.approve', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i class="fa-solid fa-check text-xs"></i> Approve
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal({{ $q->id }}, '{{ $q->quotation_no }}')" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-black text-[11px] transition cursor-pointer flex items-center gap-1">
                                        <i class="fa-solid fa-xmark text-xs"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500 text-xs font-bold">
                                No quotations pending financial approval. All clear!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendingQuotations->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pendingQuotations->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL: REJECT QUOTATION -->
<div id="rejectModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-black text-slate-900">Reject Quotation</h3>
            <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-sm font-bold">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-black text-slate-800 mb-1.5">Reason for Rejection *</label>
                <textarea name="reason" rows="3" required placeholder="Specify why discount is disapproved..." class="w-full text-xs p-3 rounded-2xl border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-black text-slate-700">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-rose-600 text-white text-xs font-black shadow-md hover:bg-rose-700 transition">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id, quoteNo) {
    document.getElementById('rejectForm').action = "/crm/admin/super/approvals/" + id + "/reject";
    document.getElementById('rejectModal').classList.remove('hidden');
}
</script>
@endsection
