<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM Suite') | Hisab Mittra CRM</title>
    <link rel="icon" type="image/png" href="/images/hisab-mittra-icon.png">
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Google Fonts: Plus Jakarta Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f7f4',
                            100: '#dcece5',
                            200: '#bfdcd0',
                            300: '#94c6b3',
                            400: '#5da790',
                            500: '#0e6f66',
                            600: '#0b5a53',
                            700: '#084d47',
                            800: '#063c37',
                            900: '#042b27',
                        },
                        sage: {
                            50: '#f5faf7',
                            100: '#eaf4ee',
                            200: '#d8eade',
                            300: '#c2decb',
                            400: '#a3cdb2',
                            500: '#80b894',
                            600: '#619e78',
                            700: '#4c7f5f',
                            800: '#3d654d',
                            900: '#335340',
                        },
                        coachTeal: {
                            light: '#138b80',
                            DEFAULT: '#0e6f66',
                            dark: '#084d47',
                            deep: '#063934',
                        },
                        amberAccent: {
                            50: '#fdf6f0',
                            100: '#fbeee2',
                            500: '#e27a4e',
                            600: '#cb6336',
                        },
                        canvas: '#eaf2ee',
                        cardBorder: '#dcece5',
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 & Feather Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #F8F9FD;
            background-image: 
                radial-gradient(circle 900px at 15% 0%, rgba(254, 215, 226, 0.45) 0%, rgba(255, 241, 242, 0.20) 40%, transparent 70%),
                radial-gradient(circle 850px at 85% 10%, rgba(254, 215, 170, 0.35) 0%, rgba(255, 247, 237, 0.18) 40%, transparent 70%),
                radial-gradient(circle 950px at 50% 50%, rgba(243, 232, 255, 0.30) 0%, rgba(250, 245, 255, 0.15) 50%, transparent 75%),
                radial-gradient(circle 1000px at 85% 90%, rgba(254, 215, 226, 0.35) 0%, rgba(255, 241, 242, 0.15) 50%, transparent 75%),
                linear-gradient(135deg, #FDF8F9 0%, #F9F7FB 50%, #F5F7FC 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1E293B;
        }

        /* hr.ad Modern Surface Cards */
        .crm-card, .hrad-card {
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px -5px rgba(226, 232, 240, 0.65), 0 2px 8px -2px rgba(15, 23, 42, 0.03);
            transition: all 0.2s ease-in-out;
        }
        .crm-card:hover, .hrad-card:hover {
            box-shadow: 0 15px 35px -5px rgba(203, 213, 225, 0.75), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
        }

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Sidebar scrollbar */
        .sidebar-dark-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-dark-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-dark-scroll::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 9999px;
        }
        .sidebar-dark-scroll::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }

        /* hr.ad Sidebar Navigation Items (Bold & High Contrast) */
        .sidebar-dark-item {
            color: #0F172A;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            margin: 3px 12px;
            border-radius: 0.85rem;
            transition: all 0.18s ease-in-out;
            text-decoration: none;
            cursor: pointer;
            letter-spacing: -0.01em;
        }
        .sidebar-dark-item span {
            color: #0F172A;
            font-weight: 700;
        }
        .sidebar-dark-item i {
            color: #475569;
            font-size: 15px;
            width: 20px;
            text-align: center;
            transition: all 0.18s ease-in-out;
            flex-shrink: 0;
        }
        .sidebar-dark-item:hover {
            background-color: #F1F5F9;
            color: #000000;
        }
        .sidebar-dark-item:hover span {
            color: #000000;
            font-weight: 800;
        }
        .sidebar-dark-item:hover i {
            color: #2563EB;
        }
        .sidebar-dark-item-active {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 0.85rem !important;
            box-shadow: 0 8px 20px -3px rgba(37, 99, 235, 0.35) !important;
            padding-left: 16px !important;
        }
        .sidebar-dark-item-active span {
            color: #ffffff !important;
            font-weight: 800 !important;
        }
        .sidebar-dark-item-active i {
            color: #ffffff !important;
        }

        /* hr.ad Table Styling */
        table thead th {
            background-color: #F8FAFC !important;
            color: #64748B !important;
            border-color: #F1F5F9 !important;
        }
        table tbody tr {
            border-color: #F8FAFC !important;
        }
        table tbody tr:hover {
            background-color: #F8FAFC/70 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden text-slate-800">

    <!-- Collapsible / Responsive Mobile Backdrop -->
    <div id="mobile-sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/30 z-40 hidden md:hidden transition-opacity"></div>

    <!-- LEFT SIDEBAR (LeadPro Clean White Theme) -->
    <aside id="main-sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-64 h-full bg-white border-r border-slate-200/80 flex flex-col overflow-hidden select-none shadow-sm transition-all duration-300 transform -translate-x-full md:translate-x-0">
        @if(Request::is('crm/employee*'))
            @include('crm.layouts.employee_sidebar')
        @else
            @include('crm.layouts.admin_sidebar')
        @endif
    </aside>
    <script>
        // Immediate sidebar scroll restoration prior to page paint to eliminate visual jumping
        (function() {
            try {
                var nav = document.getElementById('sidebar-nav');
                if (nav) {
                    var saved = sessionStorage.getItem('crm_sidebar_scroll_pos');
                    if (saved !== null) {
                        nav.scrollTop = parseInt(saved, 10);
                    }
                }
            } catch(e) {}
        })();
    </script>

    <!-- MAIN WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50/60 backdrop-blur-[2px]">
        
        @if(session('impersonated_by_admin'))
            <div class="bg-gradient-to-r from-rose-600 via-rose-700 to-amber-600 text-white px-4 py-2.5 flex items-center justify-between shadow-lg z-40 select-none">
                <div class="flex items-center gap-2.5 text-xs font-black">
                    <i class="fa-solid fa-user-secret text-sm"></i>
                    <span>SUPER ADMIN IMPERSONATION: Currently viewing CRM as <strong>{{ session('impersonated_employee_name', 'Employee') }}</strong> ({{ session('impersonated_employee_role', 'Employee') }})</span>
                </div>
                <a href="{{ route('crm.leave-impersonate') }}" class="px-3.5 py-1 rounded-xl bg-white text-rose-700 hover:bg-rose-50 text-xs font-black shadow-md transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Return to Super Admin
                </a>
            </div>
        @endif

        <!-- TOPBAR -->
        @include('crm.layouts.topbar')

        <!-- MAIN SCROLLABLE CONTENT AREA -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-bold shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="ml-auto text-rose-500 hover:text-rose-700">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Core Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Global Keyboard Shortcut: Ctrl + K or / to focus Topbar Search Input
        document.addEventListener('keydown', function(e) {
            const searchInput = document.getElementById('topbar-search-input');
            if (!searchInput) return;

            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            } else if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            } else if (e.key === 'Escape') {
                closeInlineSearch();
            }
        });

        // Inline Live Search Controller
        const topSearchInput = document.getElementById('topbar-search-input');
        const inlineDropdown = document.getElementById('inline-search-dropdown');
        const inlineContent = document.getElementById('inline-search-content');
        const inlineLoading = document.getElementById('inline-search-loading');
        const clearSearchBtn = document.getElementById('clear-search-btn');

        let searchDebounceTimeout = null;

        if (topSearchInput) {
            topSearchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    performLiveSearch(this.value.trim());
                }
            });

            topSearchInput.addEventListener('input', function() {
                const query = this.value.trim();

                if (clearSearchBtn) {
                    if (query.length > 0) {
                        clearSearchBtn.classList.remove('hidden');
                    } else {
                        clearSearchBtn.classList.add('hidden');
                    }
                }

                if (query.length < 2) {
                    closeInlineSearch();
                    return;
                }

                clearTimeout(searchDebounceTimeout);
                searchDebounceTimeout = setTimeout(() => {
                    performLiveSearch(query);
                }, 250);
            });
        }

        let currentSearchController = null;

        function performLiveSearch(query) {
            if (!inlineDropdown || !inlineContent) return;

            const isAdmin = {{ Request::is('crm/admin*') ? 'true' : 'false' }};
            const searchUrl = isAdmin ? '/crm/admin/search?q=' + encodeURIComponent(query) : '/crm/employee/leads?search=' + encodeURIComponent(query);

            inlineDropdown.classList.remove('hidden');
            if (inlineLoading) inlineLoading.classList.remove('hidden');
            inlineContent.innerHTML = '';

            if (currentSearchController) {
                currentSearchController.abort();
            }
            currentSearchController = new AbortController();

            fetch('/crm/global-search?ajax=1&q=' + encodeURIComponent(query), {
                signal: currentSearchController.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('HTTP ' + res.status);
                    }
                    return res.json();
                })
                .then(data => {
                    if (inlineLoading) inlineLoading.classList.add('hidden');

                    let html = '';

                    // 1. Leads
                    if (data.leads && data.leads.length > 0) {
                        html += `
                            <div class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5 text-emerald-700">
                                    <i class="fa-solid fa-bullseye text-emerald-500"></i> Leads (${data.leads.length})
                                </span>
                            </div>
                        `;
                        data.leads.forEach(l => {
                            html += `
                                <a href="${l.url}" class="flex items-center justify-between p-2 rounded-2xl hover:bg-emerald-50/70 border border-transparent hover:border-emerald-200 transition group mb-1">
                                    <div class="truncate pr-2">
                                        <div class="font-black text-slate-900 group-hover:text-emerald-950 text-xs">${l.name}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold truncate flex items-center gap-2">
                                            <span>${l.company || 'Direct Contact'}</span>
                                            ${l.phone ? `<span class="font-mono text-slate-600 font-bold">• ${l.phone}</span>` : ''}
                                        </div>
                                    </div>
                                    <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">${l.status}</span>
                                </a>
                            `;
                        });
                    }

                    // 2. Customers
                    if (data.customers && data.customers.length > 0) {
                        html += `
                            <div class="text-[10px] font-black uppercase tracking-wider text-slate-400 mt-2.5 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5 text-sky-700">
                                    <i class="fa-solid fa-building text-sky-500"></i> Customers (${data.customers.length})
                                </span>
                            </div>
                        `;
                        data.customers.forEach(c => {
                            html += `
                                <a href="${c.url}" class="flex items-center justify-between p-2 rounded-2xl hover:bg-sky-50/70 border border-transparent hover:border-sky-200 transition group mb-1">
                                    <div class="truncate pr-2">
                                        <div class="font-black text-slate-900 group-hover:text-sky-950 text-xs">${c.name}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold truncate flex items-center gap-2">
                                            <span>${c.company || 'Account'}</span>
                                            ${c.phone ? `<span class="font-mono text-slate-600 font-bold">• ${c.phone}</span>` : ''}
                                        </div>
                                    </div>
                                    <span class="text-[9px] font-mono font-black px-1.5 py-0.5 rounded bg-sky-100 text-sky-800 border border-sky-300 shrink-0">${c.code || 'Account'}</span>
                                </a>
                            `;
                        });
                    }

                    // 3. Deals
                    if (data.deals && data.deals.length > 0) {
                        html += `
                            <div class="text-[10px] font-black uppercase tracking-wider text-slate-400 mt-2.5 mb-1.5 flex items-center gap-1.5 text-amber-700">
                                <i class="fa-solid fa-handshake text-amber-500"></i> Deals (${data.deals.length})
                            </div>
                        `;
                        data.deals.forEach(d => {
                            html += `
                                <a href="${d.url}" class="flex items-center justify-between p-2 rounded-2xl hover:bg-amber-50/70 border border-transparent hover:border-amber-200 transition group mb-1">
                                    <div class="truncate pr-2">
                                        <div class="font-black text-slate-900 group-hover:text-amber-950 text-xs">${d.title}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold">${d.stage || 'In Progress'}</div>
                                    </div>
                                    <span class="text-xs font-black text-slate-900 shrink-0">₹${d.value}</span>
                                </a>
                            `;
                        });
                    }

                    // 4. Quotations
                    if (data.quotations && data.quotations.length > 0) {
                        html += `
                            <div class="text-[10px] font-black uppercase tracking-wider text-slate-400 mt-2.5 mb-1.5 flex items-center gap-1.5 text-purple-700">
                                <i class="fa-solid fa-file-invoice-dollar text-purple-500"></i> Quotations (${data.quotations.length})
                            </div>
                        `;
                        data.quotations.forEach(qt => {
                            html += `
                                <a href="${qt.url}" class="flex items-center justify-between p-2 rounded-2xl hover:bg-purple-50/70 border border-transparent hover:border-purple-200 transition group mb-1">
                                    <div class="truncate pr-2">
                                        <div class="font-black text-slate-900 group-hover:text-purple-950 text-xs font-mono">${qt.quotation_no}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold truncate">${qt.customer_name}</div>
                                    </div>
                                    <span class="text-xs font-black text-purple-900 shrink-0">₹${qt.amount}</span>
                                </a>
                            `;
                        });
                    }

                    // 5. Products
                    if (data.products && data.products.length > 0) {
                        html += `
                            <div class="text-[10px] font-black uppercase tracking-wider text-slate-400 mt-2.5 mb-1.5 flex items-center gap-1.5 text-orange-700">
                                <i class="fa-solid fa-boxes-stacked text-orange-500"></i> Products (${data.products.length})
                            </div>
                        `;
                        data.products.forEach(p => {
                            html += `
                                <a href="${p.url}" class="flex items-center justify-between p-2 rounded-2xl hover:bg-orange-50/70 border border-transparent hover:border-orange-200 transition group mb-1">
                                    <div class="truncate pr-2">
                                        <div class="font-black text-slate-900 group-hover:text-orange-950 text-xs">${p.name}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold">${p.category || 'General'}</div>
                                    </div>
                                    <span class="text-xs font-black text-orange-600 shrink-0">₹${p.price}</span>
                                </a>
                            `;
                        });
                    }

                    if (!html) {
                        html = `
                            <div class="text-center py-6 text-slate-500">
                                <i class="fa-solid fa-magnifying-glass text-xl text-slate-300 mb-2 block"></i>
                                <span class="text-xs font-black text-slate-800">No records matching "<strong>${query}</strong>"</span>
                                <p class="text-[11px] text-slate-400 font-medium mt-1">Try name, company or phone number</p>
                            </div>
                        `;
                    } else {
                        // Quick Action to View All Results Page
                        html += `
                            <div class="pt-2.5 mt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-medium">Press <kbd class="bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded text-[10px] font-mono font-bold text-slate-800">Enter</kbd></span>
                                <a href="${searchUrl}" class="font-black text-orange-600 hover:text-orange-700 flex items-center gap-1.5 cursor-pointer">
                                    <span>View all ${data.total_count} results</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        `;
                    }

                    inlineContent.innerHTML = html;
                })
                .catch(err => {
                    if (err.name === 'AbortError') return;
                    console.error('Search error:', err);
                    if (inlineLoading) inlineLoading.classList.add('hidden');
                    inlineContent.innerHTML = `
                        <div class="text-center py-4 px-2">
                            <div class="text-xs font-bold text-rose-500 mb-1">Search encountered an issue.</div>
                            <a href="${searchUrl}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 text-orange-700 text-xs font-bold border border-orange-200 hover:bg-orange-100 transition mt-2">
                                <span>View search page directly</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    `;
                });
        }

        function clearTopSearch() {
            if (topSearchInput) {
                topSearchInput.value = '';
                topSearchInput.focus();
            }
            if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
            closeInlineSearch();
        }

        function closeInlineSearch() {
            if (inlineDropdown) inlineDropdown.classList.add('hidden');
        }

        // Close dropdown when clicking anywhere outside the search container
        document.addEventListener('click', function(event) {
            const container = document.getElementById('topbar-search-container');
            if (container && !container.contains(event.target)) {
                closeInlineSearch();
            }
        });

        // =========================================================================
        // SIDEBAR SCROLL PERSISTENCE & AUTO-ALIGN ACTIVE MENU ITEM
        // Prevents sidebar from jumping to the top when navigating or clicking links
        // =========================================================================
        (function() {
            function getNav() {
                return document.getElementById('sidebar-nav');
            }

            function restoreSidebarScroll() {
                var nav = getNav();
                if (!nav) return;

                var savedPos = sessionStorage.getItem('crm_sidebar_scroll_pos');
                if (savedPos !== null && savedPos !== '') {
                    nav.scrollTop = parseInt(savedPos, 10);
                }

                // Ensure the active item is visible in the sidebar viewport
                var active = nav.querySelector('.sidebar-dark-item-active');
                if (active) {
                    var navRect = nav.getBoundingClientRect();
                    var activeRect = active.getBoundingClientRect();
                    var isVisible = (activeRect.top >= navRect.top + 10) && (activeRect.bottom <= navRect.bottom - 10);
                    if (!isVisible) {
                        active.scrollIntoView({ block: 'nearest', behavior: 'instant' });
                        sessionStorage.setItem('crm_sidebar_scroll_pos', nav.scrollTop);
                    }
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', restoreSidebarScroll);
            } else {
                restoreSidebarScroll();
            }
            window.addEventListener('load', restoreSidebarScroll);

            // Continuously save scroll position on user scroll (debounced)
            var scrollDebounce = null;
            document.addEventListener('DOMContentLoaded', function() {
                var nav = getNav();
                if (!nav) return;

                nav.addEventListener('scroll', function() {
                    clearTimeout(scrollDebounce);
                    scrollDebounce = setTimeout(function() {
                        sessionStorage.setItem('crm_sidebar_scroll_pos', nav.scrollTop);
                    }, 40);
                }, { passive: true });

                // Snapshot exact scroll position immediately on link clicks
                nav.addEventListener('click', function(e) {
                    var link = e.target.closest('a');
                    if (link) {
                        sessionStorage.setItem('crm_sidebar_scroll_pos', nav.scrollTop);
                    }
                });

                // Clicking the Brand/Dashboard logo explicitly resets to top (position 0)
                var brandLogo = document.querySelector('#main-sidebar a[href*="dashboard"]');
                if (brandLogo) {
                    brandLogo.addEventListener('click', function() {
                        sessionStorage.setItem('crm_sidebar_scroll_pos', '0');
                    });
                }
            });

            // Save on beforeunload
            window.addEventListener('beforeunload', function() {
                var nav = getNav();
                if (nav) {
                    sessionStorage.setItem('crm_sidebar_scroll_pos', nav.scrollTop);
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
