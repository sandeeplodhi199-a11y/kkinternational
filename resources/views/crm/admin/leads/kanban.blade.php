@extends('crm.layouts.master')

@section('title', 'Lead Kanban Kanban')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Lead Kanban Board</h2>
            <p class="text-xs text-slate-500 font-medium">Drag and drop leads across stages to update conversion status</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('crm.admin.leads.index') }}" class="px-3 py-1.5 rounded-xl border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Back to Leads</span>
            </a>

            <a href="{{ route('crm.admin.leads.create') }}" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Add Lead</span>
            </a>

            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                <i class="fa-solid fa-bolt mr-1 text-[#de7349]"></i> Live Sync Enabled
            </span>
        </div>
    </div>

    <!-- Kanban Board Columns -->
    <div id="kanban-scroll-wrapper" class="flex gap-4 overflow-x-auto pb-6 min-h-[650px] cursor-grab select-none">
        @foreach($stages as $stage)
            <div class="w-72 shrink-0 flex flex-col bg-[#f4f7f2] rounded-3xl p-3 border border-[#e4eae1]" 
                 ondragover="allowDrop(event)" 
                 ondrop="drop(event, '{{ $stage }}')">
                
                <!-- Stage Header -->
                <div class="flex items-center justify-between px-2 py-1.5 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $stage === 'Converted' ? 'bg-emerald-500' : ($stage === 'Lost' ? 'bg-rose-500' : 'bg-[#de7349]') }}"></span>
                        <h3 class="text-xs font-bold text-slate-800">{{ $stage }}</h3>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-white text-slate-600 shadow-sm border border-slate-200">
                        {{ count($kanban[$stage]) }}
                    </span>
                </div>

                <!-- Column Cards -->
                <div class="column-cards-list flex-1 space-y-3 overflow-y-auto max-h-[580px] pr-1">
                    @forelse($kanban[$stage] as $lead)
                        <div id="lead-card-{{ $lead->id }}" 
                             draggable="true" 
                             ondragstart="drag(event, {{ $lead->id }})"
                             class="crm-card p-4 cursor-grab active:cursor-grabbing hover:border-emerald-300 transition relative group">
                            
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <span class="text-[10px] font-bold text-slate-400">{{ $lead->lead_code }}</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $lead->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $lead->priority }}
                                </span>
                            </div>

                            <a href="{{ route('crm.admin.leads.show', $lead->id) }}" class="block font-bold text-xs text-slate-800 hover:text-emerald-700 mb-1">
                                {{ $lead->name }}
                            </a>
                            <div class="text-[11px] text-slate-500 mb-3 truncate font-medium">
                                {{ $lead->company ?: 'Individual Prospect' }}
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-extrabold text-slate-800">₹{{ number_format($lead->expected_value) }}</span>
                                <div class="flex items-center gap-1.5" title="{{ $lead->assignedEmployee ? $lead->assignedEmployee->name : 'Unassigned' }}">
                                    <div class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[10px] flex items-center justify-center">
                                        {{ $lead->assignedEmployee ? strtoupper(substr($lead->assignedEmployee->name, 0, 1)) : '?' }}
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium truncate max-w-[80px]">
                                        {{ $lead->assignedEmployee ? explode(' ', $lead->assignedEmployee->name)[0] : 'Unassigned' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-[11px] text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">
                            Drag leads here
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    let draggedLeadId = null;

    function drag(ev, leadId) {
        draggedLeadId = leadId;
        ev.dataTransfer.setData("text", leadId);
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drop(ev, newStage) {
        ev.preventDefault();
        if (!draggedLeadId) return;

        // Perform AJAX request to update status
        fetch(`/crm/admin/leads/${draggedLeadId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStage })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to update stage');
            }
        })
        .catch(err => console.error(err));
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
            // Don't drag-scroll if clicking interactive elements
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
            } else if (e.clientX > rect.right - edgeThreshold) {
                board.scrollLeft += 16;
            }
        });
    });
</script>
@endpush
