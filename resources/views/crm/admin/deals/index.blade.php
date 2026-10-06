@extends('crm.layouts.master')

@section('title', 'Sales Pipeline')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Sales Deals Pipeline</h2>
            <p class="text-xs text-slate-500 font-medium">
                Active Pipeline Value: <span class="font-bold text-slate-800">₹{{ number_format($totalPipelineValue) }}</span> &bull; Won Deals: <span class="font-bold text-emerald-800">₹{{ number_format($wonValue) }}</span>
            </p>
        </div>
        <a href="{{ route('crm.admin.deals.create') }}" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md shadow-emerald-900/10 flex items-center gap-2">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add Deal</span>
        </a>
    </div>

    <!-- Deals Board -->
    <div id="kanban-scroll-wrapper" class="flex gap-4 overflow-x-auto pb-6 min-h-[650px] cursor-grab select-none">
        @foreach($stages as $stage)
            <div class="w-72 shrink-0 flex flex-col bg-[#f4f7f2] rounded-3xl p-3 border border-[#e4eae1]"
                 ondragover="allowDealDrop(event)"
                 ondrop="dropDeal(event, '{{ $stage }}')">
                
                <!-- Stage Header -->
                <div class="flex items-center justify-between px-2 py-1.5 mb-1">
                    <h3 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $stage === 'Won' ? 'bg-emerald-500' : ($stage === 'Lost' ? 'bg-rose-500' : 'bg-blue-500') }}"></span>
                        <span>{{ $stage }}</span>
                    </h3>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-white text-slate-600 shadow-sm border border-slate-200">
                        {{ count($kanban[$stage]) }}
                    </span>
                </div>
                <div class="px-2 text-[10px] font-bold text-slate-400 mb-3">
                    ₹{{ number_format($stageTotals[$stage]) }}
                </div>

                <!-- Deal Cards -->
                <div class="column-cards-list flex-1 space-y-3 overflow-y-auto max-h-[580px] pr-1">
                    @forelse($kanban[$stage] as $deal)
                        <div id="deal-card-{{ $deal->id }}"
                             draggable="true"
                             ondragstart="dragDeal(event, {{ $deal->id }})"
                             class="crm-card p-4 cursor-grab active:cursor-grabbing hover:border-blue-300 transition">
                            
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <span class="text-xs font-extrabold text-[#1b4d3e]">₹{{ number_format($deal->value) }}</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">
                                    {{ $deal->probability }}% Win
                                </span>
                            </div>

                            <h4 class="font-bold text-xs text-slate-800 leading-tight mb-1">
                                {{ $deal->title }}
                            </h4>
                            <div class="text-[11px] text-slate-500 mb-3 truncate">
                                {{ $deal->customer ? $deal->customer->name : 'Commercial Account' }}
                            </div>

                            <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                <span class="text-slate-400 font-medium">
                                    <i class="fa-regular fa-clock text-[10px] mr-1"></i>
                                    {{ $deal->expected_closing_date ? \Carbon\Carbon::parse($deal->expected_closing_date)->format('d M') : 'Open' }}
                                </span>
                                <span class="font-semibold text-slate-700">
                                    {{ $deal->assignedEmployee ? explode(' ', $deal->assignedEmployee->name)[0] : 'Unassigned' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-[11px] text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">
                            No deals in {{ $stage }}
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal: Add Deal -->
    <div id="add-deal-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add Sales Deal to Pipeline</h3>
                <button type="button" onclick="document.getElementById('add-deal-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <form action="{{ route('crm.admin.deals.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deal Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Apex Logistics CRM Upgrade" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Customer / Account</label>
                        <select name="customer_id" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Select Account...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->company }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deal Value (₹) *</label>
                        <input type="number" name="value" required value="200000" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Stage</label>
                        <select name="stage" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            @foreach($stages as $st)
                                <option value="{{ $st }}">{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Win Prob (%)</label>
                        <input type="number" name="probability" value="40" min="0" max="100" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Priority</label>
                        <select name="priority" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Medium">Medium</option>
                            <option value="High" selected>High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Expected Closing Date</label>
                        <input type="date" name="expected_closing_date" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assign Representative</label>
                        <select name="assigned_to" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="">Unassigned</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-deal-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let draggedDealId = null;

    function dragDeal(ev, dealId) {
        draggedDealId = dealId;
        ev.dataTransfer.setData("text", dealId);
    }

    function allowDealDrop(ev) {
        ev.preventDefault();
    }

    function dropDeal(ev, newStage) {
        ev.preventDefault();
        if (!draggedDealId) return;

        fetch(`/crm/admin/deals/${draggedDealId}/stage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ stage: newStage })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }

    // =========================================================================
    // MOUSE DRAG-TO-SCROLL (PAN) & AUTO-SCROLL
    // =========================================================================
    document.addEventListener('DOMContentLoaded', function () {
        const board = document.getElementById('kanban-scroll-wrapper');
        if (!board) return;

        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;
        let isCardDragging = false;

        document.addEventListener('dragstart', (e) => {
            if (e.target.closest('[draggable="true"]')) {
                isCardDragging = true;
            }
        });

        document.addEventListener('dragend', () => {
            isCardDragging = false;
            isDown = false;
            board.classList.remove('cursor-grabbing');
            board.classList.add('cursor-grab');
        });

        board.addEventListener('mousedown', (e) => {
            if (isCardDragging) return;
            if (e.target.closest('button, a, input, select, textarea, [draggable="true"]')) {
                return;
            }

            isDown = true;
            board.classList.add('cursor-grabbing');
            board.classList.remove('cursor-grab');
            startX = e.pageX - board.offsetLeft;
            scrollLeft = board.scrollLeft;
        });

        window.addEventListener('mouseup', () => {
            if (isDown) {
                isDown = false;
                board.classList.remove('cursor-grabbing');
                board.classList.add('cursor-grab');
            }
        });

        board.addEventListener('mouseleave', () => {
            if (isDown) {
                isDown = false;
                board.classList.remove('cursor-grabbing');
                board.classList.add('cursor-grab');
            }
        });

        board.addEventListener('mousemove', (e) => {
            if (!isDown || isCardDragging) return;
            e.preventDefault();
            const x = e.pageX - board.offsetLeft;
            const walk = (x - startX) * 1.6;
            board.scrollLeft = scrollLeft - walk;
        });

        // Mouse Wheel Horizontal Scroll
        board.addEventListener('wheel', (e) => {
            const cardList = e.target.closest('.column-cards-list');
            const canScrollVertical = cardList && (cardList.scrollHeight > cardList.clientHeight);
            
            if (!canScrollVertical && e.deltaY !== 0) {
                e.preventDefault();
                board.scrollLeft += e.deltaY * 1.2;
            }
        }, { passive: false });

        // Auto-scroll when dragging a card near left or right edge
        board.addEventListener('dragover', (e) => {
            const rect = board.getBoundingClientRect();
            const edgeThreshold = 100;
            if (e.clientX < rect.left + edgeThreshold) {
                board.scrollLeft -= 16;
            } else if (rect.right - e.clientX < edgeThreshold) {
                board.scrollLeft += 16;
            }
        });
    });
</script>
@endpush
