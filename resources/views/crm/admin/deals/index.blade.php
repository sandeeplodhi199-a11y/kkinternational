@extends('crm.layouts.master')

@section('title', 'Sales Pipeline')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Sales Deals Pipeline</h2>
            <p class="text-xs text-slate-500 font-medium">
                Active Pipeline Value: <span class="active-pipeline-value-display font-bold text-slate-800">₹{{ number_format($totalPipelineValue) }}</span> &bull; Won Deals: <span class="won-deals-value-display font-bold text-emerald-800">₹{{ number_format($wonValue) }}</span>
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
            <div class="stage-column-box w-72 shrink-0 flex flex-col bg-[#f4f7f2] rounded-3xl p-3 border border-[#e4eae1] transition-all"
                 data-stage="{{ $stage }}"
                 ondragover="allowDealDrop(event, '{{ $stage }}')"
                 ondragleave="leaveDealDrop(event, '{{ $stage }}')"
                 ondrop="dropDeal(event, '{{ $stage }}')">
                
                <!-- Stage Header -->
                <div class="flex items-center justify-between px-2 py-1.5 mb-1">
                    <h3 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $stage === 'Won' ? 'bg-emerald-500' : ($stage === 'Lost' ? 'bg-rose-500' : 'bg-blue-500') }}"></span>
                        <span class="stage-name-text">{{ $stage }}</span>
                    </h3>
                    <span class="stage-count-badge text-[11px] font-bold px-2 py-0.5 rounded-full bg-white text-slate-600 shadow-sm border border-slate-200">
                        {{ count($kanban[$stage]) }}
                    </span>
                </div>
                <div class="stage-total-val px-2 text-[10px] font-bold text-slate-400 mb-3" data-raw-total="{{ $stageTotals[$stage] }}">
                    ₹{{ number_format($stageTotals[$stage]) }}
                </div>

                <!-- Deal Cards -->
                <div class="column-cards-list flex-1 space-y-3 overflow-y-auto max-h-[580px] pr-1"
                     ondragover="allowDealDrop(event, '{{ $stage }}')"
                     ondrop="dropDeal(event, '{{ $stage }}')">
                    @forelse($kanban[$stage] as $deal)
                        <div id="deal-card-{{ $deal->id }}"
                             data-deal-id="{{ $deal->id }}"
                             data-deal-value="{{ $deal->value }}"
                             draggable="true"
                             ondragstart="dragDeal(event, {{ $deal->id }})"
                             ondragend="dragDealEnd(event)"
                             class="crm-card p-4 cursor-grab active:cursor-grabbing hover:border-blue-300 transition select-none">
                            
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
                        <div class="empty-stage-placeholder py-8 text-center text-[11px] text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">
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
    window.draggedDealId = null;
    window.draggedCardEl = null;

    function dragDeal(ev, dealId) {
        window.draggedDealId = String(dealId);
        window.draggedCardEl = ev.target.closest('[draggable="true"]') || ev.target;
        if (ev.dataTransfer) {
            ev.dataTransfer.setData("text/plain", String(dealId));
            ev.dataTransfer.effectAllowed = "move";
        }
        if (window.draggedCardEl) {
            window.draggedCardEl.style.opacity = '0.4';
            window.draggedCardEl.classList.add('ring-2', 'ring-emerald-400');
        }
    }

    function dragDealEnd(ev) {
        if (window.draggedCardEl) {
            window.draggedCardEl.style.opacity = '1';
            window.draggedCardEl.classList.remove('ring-2', 'ring-emerald-400');
        }
        document.querySelectorAll('.stage-column-box, div[ondrop]').forEach(c => {
            c.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        });
        window.draggedDealId = null;
        window.draggedCardEl = null;
    }

    function allowDealDrop(ev, stage) {
        ev.preventDefault();
        if (ev.dataTransfer) {
            ev.dataTransfer.dropEffect = "move";
        }
        const col = ev.currentTarget.closest('.stage-column-box') || ev.currentTarget;
        if (col && !col.classList.contains('ring-emerald-500')) {
            col.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        }
    }

    function leaveDealDrop(ev, stage) {
        const col = ev.currentTarget.closest('.stage-column-box') || ev.currentTarget;
        if (col && (!ev.relatedTarget || !col.contains(ev.relatedTarget))) {
            col.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        }
    }

    function updateColumnEmptyStatesAndCounts() {
        const board = document.getElementById('kanban-scroll-wrapper');
        if (!board) return;

        let totalPipeline = 0;
        let wonTotal = 0;

        const columns = board.querySelectorAll('.stage-column-box, div[ondrop]');
        columns.forEach(col => {
            const list = col.querySelector('.column-cards-list');
            if (!list) return;

            const cards = list.querySelectorAll('.crm-card[draggable="true"], .custom-injected-deal');
            const placeholder = list.querySelector('.empty-stage-placeholder, div.border-dashed');

            if (cards.length > 0) {
                if (placeholder) placeholder.style.display = 'none';
            } else {
                if (placeholder) placeholder.style.display = 'block';
            }

            // Update badge count
            const countBadge = col.querySelector('.stage-count-badge, span.rounded-full.border');
            if (countBadge) {
                countBadge.textContent = cards.length;
            }

            // Calculate total value for this stage
            let stageTotal = 0;
            cards.forEach(card => {
                const valAttr = card.getAttribute('data-deal-value');
                if (valAttr) {
                    stageTotal += Number(valAttr) || 0;
                } else {
                    const priceSpan = card.querySelector('.font-mono, span.font-extrabold, .text-slate-800');
                    if (priceSpan) {
                        const num = parseFloat(priceSpan.textContent.replace(/[^0-9.]/g, '')) || 0;
                        stageTotal += num;
                    }
                }
            });

            const totalEl = col.querySelector('.stage-total-val, div.text-\\[10px\\].font-bold, div[class*="text-slate-400 mb-3"]');
            if (totalEl) {
                totalEl.textContent = '₹' + Math.round(stageTotal).toLocaleString('en-IN');
            }

            totalPipeline += stageTotal;
            const stageName = (col.getAttribute('data-stage') || '').toLowerCase();
            if (stageName === 'won') {
                wonTotal += stageTotal;
            }
        });

        // Top Header pipeline value
        const activePipelines = document.querySelectorAll('.active-pipeline-value-display');
        activePipelines.forEach(el => {
            el.textContent = '₹' + Math.round(totalPipeline).toLocaleString('en-IN');
        });
        const wonDisplays = document.querySelectorAll('.won-deals-value-display');
        wonDisplays.forEach(el => {
            el.textContent = '₹' + Math.round(wonTotal).toLocaleString('en-IN');
        });
    }

    function dropDeal(ev, newStage) {
        ev.preventDefault();
        const col = ev.currentTarget.closest('.stage-column-box') || ev.currentTarget;
        if (col) {
            col.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        }

        const dealId = window.draggedDealId || (ev.dataTransfer ? ev.dataTransfer.getData("text/plain") : null);
        if (!dealId) return;

        // 1. Locate the card element
        const card = document.getElementById('deal-card-' + dealId) || 
                     document.querySelector(`[data-deal-id="${dealId}"]`) ||
                     window.draggedCardEl;
        if (!card) return;

        // 2. Locate target column
        const board = document.getElementById('kanban-scroll-wrapper');
        if (!board) return;

        let targetCol = board.querySelector(`.stage-column-box[data-stage="${newStage}"]`);
        if (!targetCol) {
            targetCol = Array.from(board.querySelectorAll('.stage-column-box, div[ondrop]')).find(c => {
                const st = c.getAttribute('data-stage') || '';
                const ondropStr = c.getAttribute('ondrop') || '';
                return st.toLowerCase() === newStage.toLowerCase() || ondropStr.toLowerCase().includes(newStage.toLowerCase());
            });
        }
        if (!targetCol) return;

        const targetList = targetCol.querySelector('.column-cards-list');
        if (!targetList) return;

        // 3. Move Card in DOM immediately
        targetList.insertBefore(card, targetList.firstChild);

        // 4. Update empty state placeholders and count totals
        updateColumnEmptyStatesAndCounts();

        // 5. Update stage in localStorage
        try {
            const raw = localStorage.getItem('hm_crm_deals_data');
            if (raw) {
                const stored = JSON.parse(raw);
                let changed = false;
                stored.forEach(d => {
                    if (String(d.id) === String(dealId)) {
                        d.stage = newStage;
                        if (newStage === 'Won') d.probability = 100;
                        if (newStage === 'Lost') d.probability = 0;
                        changed = true;
                    }
                });
                if (changed) {
                    localStorage.setItem('hm_crm_deals_data', JSON.stringify(stored));
                }
            }
        } catch(e) { console.error('LocalStorage update error', e); }

        // 6. Backend Sync (Non-blocking)
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrf && !isNaN(dealId)) {
            fetch(`/crm/admin/deals/${dealId}/stage`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ stage: newStage })
            }).catch(e => console.log('Laravel sync ignored'));
        }

        if (typeof syncToDatabase === 'function') {
            syncToDatabase({ action: 'update_deal_stage', id: dealId, stage: newStage });
        }

        if (typeof showToast === 'function') {
            showToast(`Deal moved to ${newStage}!`, 'success');
        }

        dragDealEnd(ev);
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
            if (e.target.closest('button, a, input, select, textarea, [draggable="true"], .crm-card, .custom-injected-deal')) {
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
