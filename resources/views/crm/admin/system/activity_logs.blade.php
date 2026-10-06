@extends('crm.layouts.master')

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-4">

    <!-- Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">

        <!-- Top Table Controls -->
        <div class="flex items-center justify-between flex-wrap gap-4 pb-2">
            <!-- Left: Page length -->
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span>Show</span>
                <select id="perPageSelect" onchange="applyFilters()" 
                        class="bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>entries</span>
            </div>

            <!-- Right: Search -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Search:</span>
                <div class="relative">
                    <input type="text" id="searchInput" value="{{ request('search') }}" 
                           placeholder="" 
                           onkeyup="if(event.key === 'Enter') applyFilters()"
                           class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48 sm:w-56">
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-400 uppercase text-[10px] font-bold tracking-wider">
                        <th class="py-3 px-3 w-12 text-slate-400">#</th>
                        <th class="py-3 px-3 w-24 text-slate-400">TIME</th>
                        <th class="py-3 px-3 w-28 text-slate-400">ACTION</th>
                        <th class="py-3 px-3 text-slate-400">ACTIVITY DETAILS</th>
                        <th class="py-3 px-3 w-32 text-slate-400">IP ADDRESS</th>
                        <th class="py-3 px-3 w-48 text-slate-400">DATE & TIME</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($logs as $log)
                        @php
                            // Calculate human-friendly elapsed time
                            $diffSec = max(1, now()->diffInSeconds($log->created_at));
                            if ($diffSec < 60) {
                                $timeAgo = $diffSec . ' sec';
                            } elseif ($diffSec < 3600) {
                                $timeAgo = floor($diffSec / 60) . ' min';
                            } elseif ($diffSec < 86400) {
                                $timeAgo = floor($diffSec / 3600) . ' hours';
                            } else {
                                $timeAgo = floor($diffSec / 86400) . ' days';
                            }

                            // Format description with highlighted tags matching the screenshot
                            $desc = e($log->description);
                            // Highlight quotation numbers like #QT-2026-TEST
                            $desc = preg_replace('/(#QT-[A-Z0-9\-]+)/i', '<span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200 mx-1">$1</span>', $desc);
                            // Highlight currency like ₹106,200 or ₹10,750
                            $desc = preg_replace('/(₹[\d,]+)/u', '<span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mx-1">$1</span>', $desc);
                            // Highlight lead names in 'Created lead: Name'
                            $desc = preg_replace('/Created lead:\s*(.+)$/i', 'Created lead: <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200 mx-1">$1</span>', $desc);
                            // Highlight payment recipients
                            $desc = preg_replace('/to\s+([A-Za-z\s]+)$/i', 'to <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 mx-1">$1</span>', $desc);

                            $isLogin = strtolower($log->action) === 'login';
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <!-- Column 1: ID -->
                            <td class="py-3 px-3 font-bold text-slate-400 text-xs">{{ $log->id }}</td>

                            <!-- Column 2: Time Ago -->
                            <td class="py-3 px-3 font-bold text-slate-800 text-xs whitespace-nowrap">{{ $timeAgo }}</td>

                            <!-- Column 3: Action Badge -->
                            <td class="py-3 px-3 whitespace-nowrap">
                                @if($isLogin)
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-[#e0f7fa] text-[#00838f] border border-[#80deea]">
                                        Login
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-[#f3e8ff] text-[#7e22ce] border border-[#d8b4fe]">
                                        Action
                                    </span>
                                @endif
                            </td>

                            <!-- Column 4: Activity Details -->
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-2">
                                    @if($isLogin)
                                        <i class="fa-solid fa-user text-indigo-600 text-xs"></i>
                                        <span class="font-bold text-slate-900">{{ $log->user_name }}</span>
                                    @else
                                        <i class="fa-solid fa-circle-dot text-indigo-400 text-[10px]"></i>
                                        <div class="text-slate-700 leading-snug">
                                            {!! $desc !!}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Column 5: IP Address -->
                            <td class="py-3 px-3 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[11px] font-mono font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $log->ip_address ?: '127.0.0.1' }}
                                </span>
                            </td>

                            <!-- Column 6: Date & Time -->
                            <td class="py-3 px-3 text-slate-500 text-xs whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-slate-400 text-xs"></i>
                                    <span>{{ $log->created_at->format('d-m-Y H:i:s') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-400 text-xs">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-clock-rotate-left text-2xl text-slate-300 mb-2"></i>
                                    <span>No activity logs found.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bottom Controls & Pagination -->
        <div class="flex items-center justify-between flex-wrap gap-4 pt-3 border-t border-slate-100 text-xs text-slate-500">
            <!-- Showing info -->
            <div>
                Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
            </div>

            <!-- Pagination Buttons -->
            <div>
                @if ($logs->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($logs->onFirstPage())
                            <span class="px-3 py-1.5 text-xs text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Previous</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <span class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 border border-indigo-600 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Next</a>
                        @else
                            <span class="px-3 py-1.5 text-xs text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>

    </div>

</div>

<!-- Filter JavaScript -->
<script>
    function applyFilters() {
        const perPage = document.getElementById('perPageSelect').value;
        const search = document.getElementById('searchInput').value;
        
        let url = new URL(window.location.href);
        if (perPage) url.searchParams.set('per_page', perPage);
        else url.searchParams.delete('per_page');

        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');

        url.searchParams.delete('page'); // Reset to page 1 on new filter
        window.location.href = url.toString();
    }
</script>
@endsection
