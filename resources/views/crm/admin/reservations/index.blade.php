@extends('crm.layouts.master')

@section('title', 'Service Bookings & Reservations')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Reservations & Bookings</h2>
            <p class="text-xs text-slate-500 font-medium">Onsite corporate training, VIP onboarding, and consulting reservations</p>
        </div>
        <a href="{{ route('crm.admin.reservations.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>New Reservation</span>
        </a>
    </div>

    <!-- Reservations Table -->
    <div class="crm-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#fbfdfa] text-slate-400 uppercase text-[10px] font-bold">
                        <th class="py-3 px-4">Booking Ref</th>
                        <th class="py-3 px-4">Client Name</th>
                        <th class="py-3 px-4">Service Reserved</th>
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4">Booking Fee</th>
                        <th class="py-3 px-4">Assigned Consultant</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($reservations as $r)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-700">{{ $r->reservation_code }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $r->customer_name }}</td>
                            <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $r->service_name }}</td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($r->date)->format('d M, Y') }} at {{ $r->time }}
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-emerald-800">₹{{ number_format($r->amount) }}</td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $r->assignedEmployee ? $r->assignedEmployee->name : 'Unassigned' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                                    {{ $r->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2.5">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-lg mx-auto shadow-xs">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">No Bookings Found</h4>
                                        <p class="text-[11px] text-slate-400">There are no upcoming consulting sessions or service reservations.</p>
                                    </div>
                                    <a href="{{ route('crm.admin.reservations.create') }}" class="px-3.5 py-1.5 rounded-xl bg-[#1b4d3e] hover:bg-[#2d6a4f] text-white text-xs font-bold shadow-sm transition inline-flex items-center gap-1.5 active:scale-95">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>New Reservation</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $reservations->links() }}
        </div>
    </div>

    <!-- Modal: Add Reservation -->
    <div id="add-res-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add Service Reservation</h3>
                <button type="button" onclick="document.getElementById('add-res-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.reservations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Customer / Client *</label>
                        <input type="text" name="customer_name" required placeholder="e.g. Royal Grand Hotels" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Service *</label>
                        <input type="text" name="service_name" required placeholder="e.g. CRM Workshop" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Date *</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Time *</label>
                        <input type="time" name="time" value="10:00" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Amount (₹) *</label>
                        <input type="number" name="amount" value="50000" required class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assign Consultant</label>
                        <select name="assigned_to" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                        <option value="Confirmed">Confirmed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Booking Notes</label>
                    <textarea name="notes" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-res-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
