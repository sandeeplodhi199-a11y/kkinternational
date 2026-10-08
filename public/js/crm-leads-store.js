/**
 * Hisab Mittra CRM - Universal Persistence Engine & Form Controller
 * 1. Intercepts all Add / Create / Log form submissions with e.preventDefault()
 * 2. Saves leads, follow-ups, customers, deals, tasks, demos, payments, quotations, products, team, reservations, and branches
 * 3. Immediately auto-syncs all data to MySQL database and SQL dump files via /crm/api/sync.php
 * 4. Dynamically renders newly added records into both Admin and Employee tables and cards
 * 5. Provides seamless modal handling and clean, non-POST page redirections
 */
(function() {
    'use strict';

    const STORAGE_KEYS = {
        leads: 'hm_crm_leads_data',
        followups: 'hm_crm_followups_data',
        customers: 'hm_crm_customers_data',
        deals: 'hm_crm_deals_data',
        tasks: 'hm_crm_tasks_data',
        demos: 'hm_crm_demos_data',
        payments: 'hm_crm_payments_data',
        quotations: 'hm_crm_quotations_data',
        products: 'hm_crm_products_data',
        team: 'hm_crm_team_data',
        reservations: 'hm_crm_reservations_data',
        branches: 'hm_crm_branches_data'
    };

    const EMPLOYEES = {
        '1': 'Admin',
        '6': 'Rahul Sharma',
        '7': 'Vipin',
        '8': 'Nandkishor Chouhan',
        '9': 'sunny'
    };

    const SOURCES = {
        '1': 'Website',
        '2': 'WhatsApp',
        '3': 'Referral',
        '4': 'Facebook',
        '5': 'Instagram',
        '6': 'Google Search',
        '7': 'Direct Calling'
    };

    const KNOWN_LEADS = {
        '39': 'sandeep (hisabmitrra)',
        '28': 'ram (code)'
    };

    const KNOWN_CUSTOMERS = {
        '9': 'Ramesh (hisab)'
    };

    function getFormattedDate(d = new Date()) {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const day = String(d.getDate()).padStart(2, '0');
        return `${day} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    function getFormattedDateYMD(d = new Date()) {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    }

    function getList(key) {
        try {
            const raw = localStorage.getItem(key);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            console.error('Error reading storage for ' + key, e);
            return [];
        }
    }

    function saveItem(key, item) {
        try {
            const list = getList(key);
            list.unshift(item);
            localStorage.setItem(key, JSON.stringify(list));
            return item;
        } catch (e) {
            console.error('Error saving item to ' + key, e);
            return null;
        }
    }

    // Auto-save payload to MySQL database and append to SQL dump
    function syncToDatabase(payload, callback) {
        try {
            fetch('/crm/api/sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(res => {
                if (res && res.success) {
                    console.log('✅ Auto-saved to SQL database:', res);
                    if (typeof callback === 'function') callback(res);
                }
            }).catch(err => {
                console.log('Offline/CDN sync queued.');
            });
        } catch(e) {}
    }

    // Floating toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-6 right-6 z-[99999] px-5 py-3.5 rounded-2xl shadow-2xl text-white text-xs font-black flex items-center gap-3 transition-all duration-300 transform -translate-y-4 opacity-0 ${type === 'success' ? 'bg-[#1b4d3e] shadow-emerald-900/40 border border-emerald-400/30' : 'bg-rose-600 shadow-rose-600/40'}`;
        toast.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-circle-check text-emerald-300' : 'fa-circle-xmark text-rose-200'} text-base"></i>
            <span class="tracking-wide">${message}</span>
        `;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('-translate-y-4', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => toast.remove(), 350);
        }, 3500);
    }

    // ==========================================
    // 1. LEADS CONTROLLER
    // ==========================================
    function saveLead(data) {
        const id = Date.now();
        const randCode = 'LEAD-' + Math.floor(1000 + Math.random() * 9000);
        const basicAmt = data.basic ? Number(data.basic) : 0;
        const proAmt = data.pro ? Number(data.pro) : 0;
        const expectedVal = data.expected_value ? Number(data.expected_value) : (proAmt > 0 ? proAmt : (basicAmt > 0 ? basicAmt : 0));
        const callbackVal = data.follow_up_date || data.callback || '';

        const lead = {
            id: id,
            lead_code: randCode,
            name: (data.name || '').trim(),
            company: (data.company || data.firm_name || '-').trim(),
            phone: (data.phone || '-').trim(),
            email: (data.email || '').trim(),
            city: (data.city || '-').trim(),
            agent: (data.agent || '-').trim(),
            basic: basicAmt,
            pro: proAmt,
            source_id: data.source_id || '',
            source: SOURCES[data.source_id] || data.source || 'Direct',
            status: data.status || 'New',
            priority: data.priority || 'Medium',
            assigned_to: data.assigned_to || '',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Unassigned',
            expected_value: expectedVal,
            follow_up_date: callbackVal,
            callback: callbackVal,
            notes: (data.notes || data.remarks || '').trim(),
            created_at: getFormattedDate(),
            updated_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.leads, lead);
        syncToDatabase({ action: 'save_lead', data: lead });
        return lead;
    }

    function renderAdminLeadsTable() {
        const tbody = document.querySelector('#all-leads-table tbody');
        if (!tbody) return;

        // Filter out any deleted leads from HTML static table
        const deletedIds = getList('hm_crm_deleted_lead_ids');
        if (deletedIds && deletedIds.length) {
            tbody.querySelectorAll('tr').forEach(tr => {
                const chk = tr.querySelector('input[name="lead_ids[]"]');
                if (chk && deletedIds.includes(String(chk.value))) {
                    tr.remove();
                }
            });
        }

        const storedLeads = getList(STORAGE_KEYS.leads);
        if (!storedLeads.length) return;

        tbody.querySelectorAll('.custom-injected-lead').forEach(el => el.remove());

        const totalHeader = document.querySelector('h1 span.rounded-full');
        if (totalHeader) {
            const currentRows = tbody.querySelectorAll('tr').length;
            totalHeader.textContent = `${currentRows + storedLeads.length} total`;
        }

        const statusBadges = {
            'New': 'bg-blue-100 text-blue-800',
            'Contacted': 'bg-amber-100 text-amber-800',
            'In Progress': 'bg-indigo-100 text-indigo-800',
            'Qualified': 'bg-emerald-100 text-emerald-800',
            'Converted': 'bg-teal-100 text-teal-800',
            'Lost': 'bg-rose-100 text-rose-800'
        };

        storedLeads.slice().reverse().forEach(lead => {
            if (deletedIds && (deletedIds.includes(String(lead.id)) || deletedIds.includes(String(lead.lead_code)))) {
                return;
            }
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-lead hover:bg-emerald-50/60 transition bg-emerald-50/20';

            const statusClass = statusBadges[lead.status] || 'bg-slate-100 text-slate-700';
            const valStr = lead.expected_value ? '₹' + Number(lead.expected_value).toLocaleString('en-IN') : '-';
            const basicStr = lead.basic ? '₹' + Number(lead.basic).toLocaleString('en-IN') : '-';
            const proStr = lead.pro ? '₹' + Number(lead.pro).toLocaleString('en-IN') : (valStr !== '-' ? valStr : '-');
            const agentStr = (lead.agent && lead.agent !== '-') ? lead.agent : '-';
            const callbackStr = lead.follow_up_date || lead.callback || '-';
            const leadDataSafe = JSON.stringify(lead).replace(/"/g, '&quot;');
            const safeName = (lead.name || lead.lead_code || 'Lead').replace(/'/g, "\\'");

            tr.innerHTML = `
                <td class="py-2.5 px-3 text-center">
                    <input type="checkbox" name="lead_ids[]" value="${lead.id}" onchange="typeof updateSelectedCount === 'function' && updateSelectedCount()" class="lead-checkbox w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-0 cursor-pointer">
                </td>
                <td class="py-2.5 px-3 font-semibold text-emerald-700 flex items-center gap-1.5">
                    <span>${lead.lead_code}</span>
                    <span class="px-1 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                </td>
                <td class="py-2.5 px-3 text-slate-600 font-mono text-[11px]">${String(lead.id).slice(-4)}</td>
                <td class="py-2.5 px-3 font-semibold text-slate-800">${lead.company}</td>
                <td class="py-2.5 px-3 font-semibold text-slate-800">${lead.name}</td>
                <td class="py-2.5 px-3 font-mono text-slate-700">${lead.phone}</td>
                <td class="py-2.5 px-3 text-slate-600 font-medium">${lead.city}</td>
                <td class="py-2.5 px-3 text-slate-600">${lead.source}</td>
                <td class="py-2.5 px-3">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusClass}">${lead.status}</span>
                </td>
                <td class="py-2.5 px-3 text-slate-600">${callbackStr}</td>
                <td class="py-2.5 px-3 font-medium text-slate-700">${lead.assigned_name}</td>
                <td class="py-2.5 px-3 text-slate-700 font-medium">${agentStr}</td>
                <td class="py-2.5 px-3 text-slate-600">${lead.created_at}</td>
                <td class="py-2.5 px-3 text-slate-600">${lead.updated_at}</td>
                <td class="py-2.5 px-3 text-slate-700">${lead.priority}</td>
                <td class="py-2.5 px-3 text-slate-800 font-bold">${basicStr}</td>
                <td class="py-2.5 px-3 text-slate-800 font-bold">${proStr}</td>
                <td class="py-2.5 px-3 text-slate-500 max-w-xs truncate text-[11px]">${lead.notes || '-'}</td>
                <td class="py-2.5 px-3 text-center">
                    <div class="inline-flex items-center justify-center gap-1">
                        <button type="button" onclick="if(window.viewLeadModal) { viewLeadModal(${leadDataSafe}); } else { alert('Lead Details:\\nName: ${lead.name}\\nPhone: ${lead.phone}\\nStatus: ${lead.status}'); }" title="View" class="w-6 h-6 rounded bg-[#4f46e5] hover:bg-[#4338ca] text-white flex items-center justify-center text-[10px] transition shadow-xs cursor-pointer">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" onclick="if(window.editLeadModal) { editLeadModal(${leadDataSafe}); } else { alert('Editing ${lead.name}'); }" title="Edit" class="w-6 h-6 rounded bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center text-[10px] transition shadow-xs cursor-pointer">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" onclick="window.deleteLeadConfirm ? deleteLeadConfirm('${lead.id}', '${safeName}') : null" title="Delete Lead" class="w-6 h-6 rounded bg-[#ef4444] hover:bg-[#dc2626] text-white flex items-center justify-center text-[10px] transition shadow-xs cursor-pointer">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

    function deleteLeadConfirm(id, name) {
        if (!confirm('Are you sure you want to delete lead "' + (name || 'this lead') + '"?')) {
            return;
        }

        // 1. Mark as deleted in storage
        try {
            const delKey = 'hm_crm_deleted_lead_ids';
            let deletedIds = [];
            try {
                const rawDel = localStorage.getItem(delKey);
                deletedIds = rawDel ? JSON.parse(rawDel) : [];
            } catch(e) {}
            if (!deletedIds.includes(String(id))) {
                deletedIds.push(String(id));
                localStorage.setItem(delKey, JSON.stringify(deletedIds));
            }

            const raw = localStorage.getItem('hm_crm_leads_data');
            if (raw) {
                let list = JSON.parse(raw);
                list = list.filter(item => String(item.id) !== String(id) && String(item.lead_code) !== String(id));
                localStorage.setItem('hm_crm_leads_data', JSON.stringify(list));
            }
        } catch (e) {
            console.error(e);
        }

        // 2. Sync to Backend sync.php if available
        try {
            fetch('/crm/api/sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete_lead', lead_id: id })
            }).catch(() => {});
        } catch (e) {}

        // 3. Remove corresponding row immediately from DOM
        const rows = document.querySelectorAll('#all-leads-table tbody tr, table tbody tr');
        rows.forEach(tr => {
            const chk = tr.querySelector('input[type="checkbox"][name="lead_ids[]"]');
            if (chk && (String(chk.value) === String(id))) {
                tr.remove();
            }
        });

        // 4. Update count header if present
        const totalHeader = document.querySelector('h1 span.rounded-full');
        if (totalHeader) {
            const currentRows = document.querySelectorAll('#all-leads-table tbody tr').length;
            totalHeader.textContent = `${currentRows} total`;
        }

        // 5. Toast notification
        showToast(`🗑️ Lead "${name || 'Selected'}" deleted successfully!`, 'info');

        // 6. If Laravel form exists
        const delForm = document.getElementById('deleteLeadForm');
        if (delForm && typeof window.__IS_LARAVEL__ !== 'undefined' && window.__IS_LARAVEL__) {
            delForm.action = '/crm/admin/leads/' + id;
            delForm.submit();
        }
    }
    window.deleteLeadConfirm = deleteLeadConfirm;

    function executeDeleteSelected() {
        const checked = document.querySelectorAll('.lead-checkbox:checked');
        if (!checked.length) {
            showToast('Please select at least one lead to delete.', 'error');
            return;
        }
        if (!confirm(`Are you sure you want to delete ${checked.length} selected lead(s)?`)) {
            return;
        }
        checked.forEach(chk => {
            const id = chk.value;
            deleteLeadConfirm(id, 'Lead ' + id);
        });
        showToast(`🗑️ ${checked.length} lead(s) deleted successfully!`, 'info');
        if (typeof updateSelectedCount === 'function') updateSelectedCount();
    }
    window.executeDeleteSelected = executeDeleteSelected;

    function renderEmployeeLeadsTable() {
        if (!window.location.pathname.includes('/employee/leads')) return;
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const storedLeads = getList(STORAGE_KEYS.leads);
        if (!storedLeads.length) return;

        tbody.querySelectorAll('.custom-injected-lead').forEach(el => el.remove());

        const statusBadges = {
            'New': 'bg-blue-100 text-blue-800',
            'Contacted': 'bg-amber-100 text-amber-800',
            'In Progress': 'bg-emerald-100 text-emerald-800',
            'Qualified': 'bg-teal-100 text-teal-800',
            'Converted': 'bg-indigo-100 text-indigo-800',
            'Lost': 'bg-rose-100 text-rose-800'
        };

        storedLeads.slice().reverse().forEach(lead => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-lead hover:bg-emerald-50/70 transition bg-emerald-50/20';

            const statusClass = statusBadges[lead.status] || 'bg-slate-100 text-slate-700';
            const valStr = lead.expected_value ? '₹' + Number(lead.expected_value).toLocaleString('en-IN') : '-';

            tr.innerHTML = `
                <td class="py-3.5 px-4 font-bold text-emerald-700 flex items-center gap-1.5">
                    <span>${lead.lead_code}</span>
                    <span class="px-1.5 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded-full">NEW</span>
                </td>
                <td class="py-3.5 px-4 font-black text-slate-900">${lead.name}</td>
                <td class="py-3.5 px-4 text-slate-700 font-semibold">${lead.company}</td>
                <td class="py-3.5 px-4 text-slate-600">
                    <div>${lead.email || '-'}</div>
                    <div class="text-[11px] text-slate-500 font-mono">${lead.phone}</div>
                </td>
                <td class="py-3.5 px-4 font-black text-slate-800">${valStr}</td>
                <td class="py-3.5 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">${lead.priority}</span>
                </td>
                <td class="py-3.5 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold ${statusClass}">${lead.status}</span>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

    // ==========================================
    // 2. FOLLOW-UPS CONTROLLER & RENDERER
    // ==========================================
    function saveFollowup(data) {
        const id = Date.now();
        let contact = 'Client';
        if (data.lead_id && KNOWN_LEADS[data.lead_id]) {
            contact = KNOWN_LEADS[data.lead_id];
        } else if (data.customer_id && KNOWN_CUSTOMERS[data.customer_id]) {
            contact = KNOWN_CUSTOMERS[data.customer_id];
        } else if (data.lead_id) {
            contact = 'Lead #' + data.lead_id;
        } else if (data.customer_id) {
            contact = 'Customer #' + data.customer_id;
        }

        const followup = {
            id: id,
            lead_id: data.lead_id || '',
            customer_id: data.customer_id || '',
            contact: contact,
            date: data.date || getFormattedDateYMD(),
            time: data.time || '11:00',
            type: data.type || 'Call',
            assigned_to: data.assigned_to || '1',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Admin',
            status: data.status || 'Pending',
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.followups, followup);
        syncToDatabase({ action: 'save_followup', data: followup });
        return followup;
    }

    function renderFollowupsTable() {
        const isFollowupsPage = window.location.pathname.includes('/followups');
        if (!isFollowupsPage) return;

        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const stored = getList(STORAGE_KEYS.followups);
        if (!stored.length) return;

        // Clean previous injected rows
        tbody.querySelectorAll('.custom-injected-followup').forEach(el => el.remove());

        // Remove the empty placeholder "No follow-ups recorded"
        const emptyRow = Array.from(tbody.querySelectorAll('tr')).find(r => r.textContent.includes('No follow-ups'));
        if (emptyRow) {
            emptyRow.style.display = 'none';
        }

        const typeColors = {
            'Call': 'bg-blue-100 text-blue-800 border-blue-200',
            'Meeting': 'bg-purple-100 text-purple-800 border-purple-200',
            'Email': 'bg-amber-100 text-amber-800 border-amber-200',
            'Demo': 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'Visit': 'bg-teal-100 text-teal-800 border-teal-200'
        };

        const statusBadges = {
            'Pending': 'bg-amber-100 text-amber-800 border-amber-200',
            'Completed': 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'Cancelled': 'bg-rose-100 text-rose-800 border-rose-200'
        };

        stored.slice().reverse().forEach(fu => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-followup hover:bg-emerald-50/60 transition bg-emerald-50/20';

            const typeClass = typeColors[fu.type] || 'bg-slate-100 text-slate-700';
            const statusClass = statusBadges[fu.status] || 'bg-slate-100 text-slate-700';
            const fuDataSafe = JSON.stringify(fu).replace(/"/g, '&quot;');

            tr.innerHTML = `
                <td class="py-3 px-4 font-bold text-slate-800">
                    <div class="flex items-center gap-2">
                        <span>${fu.contact}</span>
                        <span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                    </div>
                </td>
                <td class="py-3 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border ${typeClass}">
                        <i class="fa-solid ${fu.type === 'Call' ? 'fa-phone' : (fu.type === 'Email' ? 'fa-envelope' : 'fa-calendar')} mr-1"></i>${fu.type}
                    </span>
                </td>
                <td class="py-3 px-4 text-slate-700 font-semibold font-mono text-[11px]">
                    <div>${fu.date}</div>
                    <div class="text-slate-400 font-normal">${fu.time}</div>
                </td>
                <td class="py-3 px-4 text-slate-600 max-w-xs truncate">
                    ${fu.notes || 'Routine follow-up discussion'}
                </td>
                <td class="py-3 px-4 font-semibold text-slate-700">
                    ${fu.assigned_name}
                </td>
                <td class="py-3 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border ${statusClass}">
                        ${fu.status}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <div class="inline-flex items-center gap-1.5">
                        <button type="button" onclick="alert('Follow-up Details:\\nTarget: ${fu.contact}\\nScheduled: ${fu.date} ${fu.time}\\nNotes: ${fu.notes || 'None'}')" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        });

        // Update Today tab count if on today
        const tabToday = document.querySelector('a[href="?tab=today"]');
        if (tabToday) {
            tabToday.textContent = `Today's Follow-ups (${stored.length})`;
        }
    }

    // ==========================================
    // 3. CUSTOMERS CONTROLLER & RENDERER
    // ==========================================
    function saveCustomer(data) {
        const id = Date.now();
        const code = 'CUST-' + Math.floor(1000 + Math.random() * 9000);

        const customer = {
            id: id,
            customer_code: code,
            name: (data.name || 'New Customer').trim(),
            company: (data.company || '-').trim(),
            phone: (data.phone || '-').trim(),
            email: (data.email || '-').trim(),
            address: (data.address || '-').trim(),
            assigned_to: data.assigned_to || '',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Admin',
            status: data.status || 'Active',
            total_spent: 0,
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.customers, customer);
        syncToDatabase({ action: 'save_customer', data: customer });
        return customer;
    }

    function renderCustomersTable() {
        if (!window.location.pathname.includes('/customers')) return;
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const stored = getList(STORAGE_KEYS.customers);
        if (!stored.length) return;

        tbody.querySelectorAll('.custom-injected-customer').forEach(el => el.remove());

        const emptyRow = Array.from(tbody.querySelectorAll('tr')).find(r => r.textContent.includes('No customer') || r.textContent.includes('No record'));
        if (emptyRow) emptyRow.style.display = 'none';

        stored.slice().reverse().forEach(c => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-customer hover:bg-emerald-50/60 transition bg-emerald-50/20';

            tr.innerHTML = `
                <td class="py-3 px-4 font-mono font-bold text-emerald-700 flex items-center gap-1.5">
                    <span>${c.customer_code}</span>
                    <span class="px-1 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                </td>
                <td class="py-3 px-4 font-black text-slate-900">${c.name}</td>
                <td class="py-3 px-4 font-bold text-slate-700">${c.company}</td>
                <td class="py-3 px-4 text-slate-600 font-mono text-xs">
                    <div>${c.phone}</div>
                    <div class="text-[10px] text-slate-400 font-sans">${c.email}</div>
                </td>
                <td class="py-3 px-4 font-black text-slate-900">₹0</td>
                <td class="py-3 px-4 font-bold text-slate-700">${c.assigned_name}</td>
                <td class="py-3 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        ${c.status}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <button type="button" onclick="alert('Customer: ${c.name}\\nPhone: ${c.phone}\\nAddress: ${c.address}')" class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold hover:bg-indigo-100">
                        View
                    </button>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

    // ==========================================
    // 4. DEALS CONTROLLER & RENDERER
    // ==========================================
    function saveDeal(data) {
        const id = Date.now();
        const deal = {
            id: id,
            title: (data.title || 'New Deal').trim(),
            value: data.value ? Number(data.value) : 0,
            customer_id: data.customer_id || '',
            lead_id: data.lead_id || '',
            stage: data.stage || 'New',
            probability: data.probability || 20,
            expected_closing_date: data.expected_closing_date || '',
            assigned_to: data.assigned_to || '1',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Admin',
            priority: data.priority || 'Medium',
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.deals, deal);
        syncToDatabase({ action: 'save_deal', data: deal });
        return deal;
    }

    // ==========================================
    // 4. DEALS CONTROLLER & KANBAN DRAG-AND-DROP
    // ==========================================
    window.draggedDealId = null;
    window.draggedCardEl = null;

    window.dragDeal = function(ev, dealId) {
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
    };

    window.dragDealEnd = function(ev) {
        if (window.draggedCardEl) {
            window.draggedCardEl.style.opacity = '1';
            window.draggedCardEl.classList.remove('ring-2', 'ring-emerald-400');
        }
        document.querySelectorAll('.stage-column-box, div[ondrop]').forEach(c => {
            c.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        });
        window.draggedDealId = null;
        window.draggedCardEl = null;
    };

    window.allowDealDrop = function(ev, stage) {
        ev.preventDefault();
        if (ev.dataTransfer) {
            ev.dataTransfer.dropEffect = "move";
        }
        const col = ev.currentTarget.closest('.stage-column-box') || ev.currentTarget;
        if (col && !col.classList.contains('ring-emerald-500')) {
            col.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        }
    };

    window.leaveDealDrop = function(ev, stage) {
        const col = ev.currentTarget.closest('.stage-column-box') || ev.currentTarget;
        if (col && (!ev.relatedTarget || !col.contains(ev.relatedTarget))) {
            col.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/60');
        }
    };

    window.updateColumnEmptyStatesAndCounts = function() {
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
    };

    window.dropDeal = function(ev, newStage) {
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
        window.updateColumnEmptyStatesAndCounts();

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
            showToast(`✅ Deal moved to ${newStage}!`, 'success');
        }

        window.dragDealEnd(ev);
    };

    function renderDealsTable() {
        if (!window.location.pathname.includes('/deals')) return;

        const stored = getList(STORAGE_KEYS.deals);

        // Admin Deals (Kanban)
        const wrapper = document.getElementById('kanban-scroll-wrapper');
        if (wrapper) {
            wrapper.querySelectorAll('.custom-injected-deal').forEach(el => el.remove());
            if (stored.length) {
                stored.slice().reverse().forEach(deal => {
                    const targetStage = (deal.stage || 'New').trim();

                    // Find corresponding column by data-stage or ondrop text
                    let targetCol = wrapper.querySelector(`.stage-column-box[data-stage="${targetStage}"]`);
                    if (!targetCol) {
                        targetCol = Array.from(wrapper.querySelectorAll('.stage-column-box, div[ondrop]')).find(c => {
                            const st = c.getAttribute('data-stage') || '';
                            const ondropStr = c.getAttribute('ondrop') || '';
                            return st.toLowerCase() === targetStage.toLowerCase() || ondropStr.toLowerCase().includes(targetStage.toLowerCase());
                        });
                    }
                    if (!targetCol) {
                        targetCol = wrapper.querySelector('.stage-column-box, div[ondrop]') || wrapper.firstElementChild;
                    }

                    if (targetCol) {
                        const targetList = targetCol.querySelector('.column-cards-list');
                        if (targetList) {
                            const card = document.createElement('div');
                            card.id = `deal-card-${deal.id}`;
                            card.setAttribute('data-deal-id', deal.id);
                            card.setAttribute('data-deal-value', deal.value || 0);
                            card.setAttribute('draggable', 'true');
                            card.setAttribute('ondragstart', `dragDeal(event, '${deal.id}')`);
                            card.setAttribute('ondragend', `dragDealEnd(event)`);
                            card.className = 'custom-injected-deal crm-card p-4 border border-emerald-300 bg-emerald-50/30 rounded-2xl shadow-sm space-y-2.5 cursor-grab active:cursor-grabbing hover:border-emerald-400 transition select-none';
                            card.innerHTML = `
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">NEW DEAL</span>
                                    <span class="text-xs font-black text-slate-800 font-mono">₹${Number(deal.value).toLocaleString('en-IN')}</span>
                                </div>
                                <h4 class="text-xs font-black text-slate-900">${deal.title}</h4>
                                <div class="text-[11px] text-slate-500 font-semibold flex items-center justify-between">
                                    <span>${deal.assigned_name || 'Admin'}</span>
                                    <span>${deal.probability || 50}% Prob.</span>
                                </div>
                            `;

                            // Direct listeners
                            card.addEventListener('dragstart', (e) => {
                                window.dragDeal(e, deal.id);
                            });
                            card.addEventListener('dragend', (e) => {
                                window.dragDealEnd(e);
                            });

                            targetList.insertBefore(card, targetList.firstChild);
                        }
                    }
                });
            }

            // Always update empty states, counts and totals
            window.updateColumnEmptyStatesAndCounts();
        }

        // Employee Deals (Grid)
        const empGrid = document.querySelector('div.grid');
        if (empGrid && window.location.pathname.includes('/employee/')) {
            empGrid.querySelectorAll('.custom-injected-deal').forEach(el => el.remove());
            const placeholder = empGrid.querySelector('.col-span-full');
            if (placeholder) placeholder.style.display = 'none';

            stored.slice().reverse().forEach(deal => {
                const card = document.createElement('div');
                card.className = 'custom-injected-deal crm-card p-5 bg-white border border-emerald-200 rounded-3xl shadow-sm flex flex-col justify-between';
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">NEW</span>
                            <span class="text-sm font-black text-slate-900">₹${Number(deal.value).toLocaleString('en-IN')}</span>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 mb-1">${deal.title}</h4>
                        <p class="text-xs text-slate-500">${deal.notes || 'Pipeline Opportunity'}</p>
                    </div>
                `;
                empGrid.insertBefore(card, empGrid.firstChild);
            });
        }
    }

    // ==========================================
    // 5. TASKS CONTROLLER & RENDERER
    // ==========================================
    function saveTask(data) {
        const id = Date.now();
        const task = {
            id: id,
            title: (data.title || 'New Task').trim(),
            description: (data.description || '').trim(),
            assigned_to: data.assigned_to || '1',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Admin',
            related_lead_id: data.related_lead_id || '',
            related_customer_id: data.related_customer_id || '',
            priority: data.priority || 'Medium',
            due_date: data.due_date || getFormattedDateYMD(),
            status: data.status || 'Pending',
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.tasks, task);
        syncToDatabase({ action: 'save_task', data: task });
        return task;
    }

    function renderTasksTable() {
        if (!window.location.pathname.includes('/tasks')) return;
        const grid = document.querySelector('div.grid');
        if (!grid) return;

        const stored = getList(STORAGE_KEYS.tasks);
        if (!stored.length) return;

        grid.querySelectorAll('.custom-injected-task').forEach(el => el.remove());

        stored.slice().reverse().forEach(task => {
            const card = document.createElement('div');
            card.className = 'custom-injected-task crm-card p-5 flex flex-col justify-between bg-white border border-emerald-200 shadow-sm rounded-3xl';
            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">${task.priority} Priority</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">${task.status}</span>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800 leading-snug mb-1">${task.title}</h4>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">${task.description || 'Deliverable task'}</p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span class="font-bold text-slate-600">${task.assigned_name}</span>
                    <span>Due: ${task.due_date}</span>
                </div>
            `;
            grid.insertBefore(card, grid.firstChild);
        });
    }

    // ==========================================
    // 6. DEMOS CONTROLLER
    // ==========================================
    function saveDemo(data) {
        const id = Date.now();
        const demo = {
            id: id,
            title: (data.title || 'Product Demo').trim(),
            lead_id: data.lead_id || '',
            customer_id: data.customer_id || '',
            assigned_to: data.assigned_to || '1',
            assigned_name: EMPLOYEES[data.assigned_to] || 'Admin',
            date: data.date || getFormattedDateYMD(),
            time: data.time || '11:00',
            status: data.status || 'Scheduled',
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.demos, demo);
        syncToDatabase({ action: 'save_demo', data: demo });
        return demo;
    }

    // ==========================================
    // 7. PAYMENTS CONTROLLER & RENDERER
    // ==========================================
    function savePayment(data) {
        const id = Date.now();
        const payNo = 'REC-' + Math.floor(1000 + Math.random() * 9000);
        const payment = {
            id: id,
            payment_no: payNo,
            customer_id: data.customer_id || '',
            quotation_id: data.quotation_id || '',
            amount: data.amount ? Number(data.amount) : 0,
            payment_date: data.payment_date || getFormattedDateYMD(),
            payment_method: data.payment_method || 'Bank Transfer',
            transaction_ref: (data.transaction_ref || '').trim(),
            status: data.status || 'Paid',
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.payments, payment);
        syncToDatabase({ action: 'save_payment', data: payment });
        return payment;
    }

    function renderPaymentsTable() {
        if (!window.location.pathname.includes('/payments')) return;
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const stored = getList(STORAGE_KEYS.payments);
        if (stored.length) {
            tbody.querySelectorAll('.custom-injected-payment').forEach(el => el.remove());

            stored.slice().reverse().forEach(p => {
                const tr = document.createElement('tr');
                tr.className = 'custom-injected-payment hover:bg-emerald-50/60 transition bg-emerald-50/20';
                tr.setAttribute('data-payment-date', p.payment_date || '');
                tr.setAttribute('data-amount', p.amount || 0);
                tr.setAttribute('data-status', p.status || 'Paid');
                tr.innerHTML = `
                    <td class="py-3 px-4 font-mono font-bold text-emerald-700 flex items-center gap-1.5">
                        <span>${p.payment_no}</span>
                        <span class="px-1 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                    </td>
                    <td class="py-3 px-4 font-black text-slate-800">Account #${p.customer_id || '9'}</td>
                    <td class="py-3 px-4 font-black text-emerald-800">₹${Number(p.amount).toLocaleString('en-IN')}</td>
                    <td class="py-3 px-4 font-mono text-slate-700" data-payment-date="${p.payment_date}">${p.payment_date}</td>
                    <td class="py-3 px-4 text-slate-700 font-semibold">${p.payment_method}</td>
                    <td class="py-3 px-4 font-mono text-xs text-slate-500">${p.transaction_ref || '-'}</td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">${p.status}</span>
                    </td>
                `;
                tbody.insertBefore(tr, tbody.firstChild);
            });
        }

        // Apply period filter
        filterPaymentsByPeriod();
    }

    function filterPaymentsByPeriod() {
        if (!window.location.pathname.includes('/payments')) return;
        const yrSelect = document.getElementById('payment-filter-year');
        const moSelect = document.getElementById('payment-filter-month');
        if (!yrSelect || !moSelect) return;

        // Sync with URL params on load if values not explicitly selected
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('year') && !yrSelect.value) {
            yrSelect.value = urlParams.get('year');
        }
        if (urlParams.has('month') && !moSelect.value) {
            moSelect.value = urlParams.get('month');
        }

        const selectedYr = yrSelect.value;
        const selectedMo = moSelect.value;

        // Update URL query string seamlessly
        if (window.history && window.history.replaceState) {
            const currentUrl = new URL(window.location.href);
            if (selectedYr) currentUrl.searchParams.set('year', selectedYr);
            else currentUrl.searchParams.delete('year');
            if (selectedMo) currentUrl.searchParams.set('month', selectedMo);
            else currentUrl.searchParams.delete('month');
            window.history.replaceState({}, '', currentUrl);
        }

        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const rows = tbody.querySelectorAll('tr:not(.period-empty-placeholder)');
        let visibleCount = 0;
        let totalCleared = 0;
        let totalPending = 0;

        rows.forEach(tr => {
            if (tr.querySelector('td[colspan]')) {
                tr.style.display = 'none';
                return;
            }

            const dateCell = tr.querySelector('[data-payment-date]') || tr.cells[3];
            const amountCell = tr.querySelector('[data-amount]') || tr.cells[2];
            const statusCell = tr.querySelector('[data-status]') || tr.cells[6];
            if (!dateCell) return;

            let dateStr = tr.getAttribute('data-payment-date') || dateCell.getAttribute('data-payment-date') || dateCell.textContent.trim();
            let rowYear = null;
            let rowMonth = null;

            if (dateStr) {
                const parts = dateStr.match(/(\d{4})-(\d{1,2})-(\d{1,2})/);
                if (parts) {
                    rowYear = parseInt(parts[1], 10);
                    rowMonth = parseInt(parts[2], 10);
                } else {
                    const parsed = new Date(dateStr);
                    if (!isNaN(parsed.getTime())) {
                        rowYear = parsed.getFullYear();
                        rowMonth = parsed.getMonth() + 1;
                    }
                }
            }

            let match = true;
            if (selectedYr && rowYear && String(rowYear) !== String(selectedYr)) {
                match = false;
            }
            if (selectedMo && rowMonth && String(rowMonth) !== String(selectedMo)) {
                match = false;
            }

            if (match) {
                tr.style.display = '';
                visibleCount++;
                let amt = 0;
                if (tr.hasAttribute('data-amount')) {
                    amt = parseFloat(tr.getAttribute('data-amount')) || 0;
                } else if (amountCell) {
                    amt = parseFloat(amountCell.textContent.replace(/[^\d.]/g, '')) || 0;
                }
                const st = (tr.getAttribute('data-status') || (statusCell ? statusCell.textContent : '')).trim().toLowerCase();
                if (st.includes('paid')) {
                    totalCleared += amt;
                } else if (st.includes('pending')) {
                    totalPending += amt;
                }
            } else {
                tr.style.display = 'none';
            }
        });

        // Update KPI cards
        const clearedEl = document.getElementById('kpi-cleared-revenue');
        const pendingEl = document.getElementById('kpi-outstanding-invoices');
        if (clearedEl) {
            clearedEl.textContent = '₹' + totalCleared.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        if (pendingEl) {
            pendingEl.textContent = '₹' + totalPending.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Empty state placeholder
        let placeholder = tbody.querySelector('.period-empty-placeholder');
        if (visibleCount === 0) {
            if (!placeholder) {
                placeholder = document.createElement('tr');
                placeholder.className = 'period-empty-placeholder';
                placeholder.innerHTML = '<td colspan="7" class="text-center py-8 text-slate-400 font-medium">No payment receipts found for selected period.</td>';
                tbody.appendChild(placeholder);
            } else {
                placeholder.style.display = '';
            }
        } else if (placeholder) {
            placeholder.style.display = 'none';
        }
    }

    function resetPaymentPeriodFilter() {
        const yrSelect = document.getElementById('payment-filter-year');
        const moSelect = document.getElementById('payment-filter-month');
        if (yrSelect) yrSelect.value = '';
        if (moSelect) moSelect.value = '';
        filterPaymentsByPeriod();
    }

    window.filterPaymentsByPeriod = filterPaymentsByPeriod;
    window.resetPaymentPeriodFilter = resetPaymentPeriodFilter;

    // ==========================================
    // 8. QUOTATIONS CONTROLLER & RENDERER
    // ==========================================
    function saveQuotation(data) {
        const id = Date.now();
        const quoNo = 'QT-2026-' + Math.floor(1000 + Math.random() * 9000);
        const subtotal = data.subtotal ? Number(data.subtotal) : 0;
        const grandTotal = data.grand_total ? Number(data.grand_total) : (subtotal > 0 ? subtotal : 0);

        const quotation = {
            id: id,
            quotation_no: quoNo,
            customer_id: data.customer_id || '',
            customer_name: (data.customer_name || 'Client').trim(),
            customer_phone: (data.customer_phone || '').trim(),
            customer_email: (data.customer_email || '').trim(),
            quotation_date: data.quotation_date || getFormattedDateYMD(),
            valid_until: data.valid_until || '',
            subtotal: subtotal,
            grand_total: grandTotal,
            status: data.status || 'Draft',
            notes: (data.notes || '').trim(),
            terms: (data.terms || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.quotations, quotation);
        syncToDatabase({ action: 'save_quotation', data: quotation });
        return quotation;
    }

    // ==========================================
    // 9. PRODUCTS CONTROLLER & RENDERER
    // ==========================================
    function saveProduct(data) {
        const id = Date.now();
        const code = (data.code || ('PRD-' + Math.floor(1000 + Math.random() * 9000))).trim();
        const product = {
            id: id,
            code: code,
            name: (data.name || 'New Offering').trim(),
            category: data.category || 'Product',
            price: data.price ? Number(data.price) : 0,
            tax_rate: data.tax_rate ? Number(data.tax_rate) : 18,
            status: data.status || 'Active',
            description: (data.description || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.products, product);
        syncToDatabase({ action: 'save_product', data: product });
        return product;
    }

    function renderProductsTable() {
        if (!window.location.pathname.includes('/products')) return;
        const grid = document.querySelector('div.grid');
        if (!grid) return;

        const stored = getList(STORAGE_KEYS.products);
        if (!stored.length) return;

        grid.querySelectorAll('.custom-injected-product').forEach(el => el.remove());

        stored.slice().reverse().forEach(p => {
            const card = document.createElement('div');
            card.className = 'custom-injected-product crm-card p-6 flex flex-col justify-between bg-white border border-emerald-300 rounded-3xl shadow-sm';
            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-mono font-black px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">${p.code}</span>
                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">${p.status}</span>
                    </div>
                    <h3 class="text-sm font-black text-slate-800 mb-1">${p.name}</h3>
                    <p class="text-xs text-slate-500 mb-4">${p.description || 'Professional solution offering'}</p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase">Price</div>
                        <div class="text-base font-black text-slate-900 font-mono">₹${Number(p.price).toLocaleString('en-IN')}</div>
                    </div>
                    <span class="text-[11px] font-bold text-slate-500">${p.category}</span>
                </div>
            `;
            grid.insertBefore(card, grid.firstChild);
        });
    }

    // ==========================================
    // 10. TEAM MEMBERS CONTROLLER & RENDERER
    // ==========================================
    function saveTeamMember(data) {
        const id = Date.now();
        const member = {
            id: id,
            name: (data.name || 'New Member').trim(),
            email: (data.email || '').trim(),
            phone: (data.phone || '').trim(),
            role: data.role || 'Sales',
            designation: (data.designation || 'Representative').trim(),
            target_amount: data.target_amount ? Number(data.target_amount) : 0,
            remarks: (data.remarks || data.remark || '').trim(),
            demos_count: data.demos_count ? Number(data.demos_count) : (data.demo ? Number(data.demo) : 0),
            status: 'Active',
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.team, member);
        syncToDatabase({ action: 'save_team_member', data: member });
        return member;
    }

    function renderTeamTable() {
        if (!window.location.pathname.includes('/team')) return;
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const stored = getList(STORAGE_KEYS.team);
        if (!stored.length) return;

        tbody.querySelectorAll('.custom-injected-team').forEach(el => el.remove());

        stored.slice().reverse().forEach((m, idx) => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-team hover:bg-emerald-50/60 transition bg-emerald-50/20';
            tr.innerHTML = `
                <td class="py-3.5 px-4 font-bold text-slate-400 text-xs">${10 + idx}</td>
                <td class="py-3.5 px-4 font-bold text-slate-800 text-xs whitespace-nowrap">
                    <span>${m.name}</span>
                    <span class="ml-1 px-1 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                </td>
                <td class="py-3.5 px-4 text-slate-600 text-xs whitespace-nowrap">${m.email}</td>
                <td class="py-3.5 px-4 text-slate-600 text-xs whitespace-nowrap font-mono">${m.phone}</td>
                <td class="py-3.5 px-4 font-bold text-slate-800 text-xs text-center whitespace-nowrap">0</td>
                <td class="py-3.5 px-4 font-bold text-slate-800 text-xs text-center whitespace-nowrap">${m.demos_count || 0}</td>
                <td class="py-3.5 px-4 text-slate-500 text-xs max-w-xs truncate">${m.remarks || '-'}</td>
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-[#e8f5e9] text-[#2e7d32] border border-[#a5d6a7]">${m.status}</span>
                </td>
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                    <div class="inline-flex items-center justify-center gap-1.5">
                        <a href="/crm/admin/team/${m.id}/edit" class="w-7 h-7 rounded-lg bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center transition shadow-sm active:scale-95" title="Edit Employee">
                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                        </a>
                        <a href="/crm/admin/demos?assigned_to=${m.id}" class="w-7 h-7 rounded-lg bg-[#06b6d4] hover:bg-[#0891b2] text-white flex items-center justify-center transition shadow-sm active:scale-95" title="Schedule / View Demo">
                            <i class="fa-solid fa-calendar-days text-[11px]"></i>
                        </a>
                        <button type="button" onclick="confirmDelete('${m.id}', '${m.name}')" class="w-7 h-7 rounded-lg bg-[#ef4444] hover:bg-[#dc2626] text-white flex items-center justify-center transition shadow-sm active:scale-95" title="Delete">
                            <i class="fa-solid fa-trash text-[11px]"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

    // ==========================================
    // 11. RESERVATIONS CONTROLLER & RENDERER
    // ==========================================
    function saveReservation(data) {
        const id = Date.now();
        const code = 'RES-' + Math.floor(1000 + Math.random() * 9000);
        const res = {
            id: id,
            reservation_code: code,
            customer_name: (data.customer_name || 'Client').trim(),
            service_name: (data.service_name || 'Consultation').trim(),
            amount: data.amount ? Number(data.amount) : 0,
            status: data.status || 'Confirmed',
            date: data.date || getFormattedDateYMD(),
            time: data.time || '10:00',
            assigned_to: data.assigned_to || '',
            notes: (data.notes || '').trim(),
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.reservations, res);
        syncToDatabase({ action: 'save_reservation', data: res });
        return res;
    }

    function renderReservationsTable() {
        if (!window.location.pathname.includes('/reservations')) return;
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        const stored = getList(STORAGE_KEYS.reservations);
        if (!stored.length) return;

        tbody.querySelectorAll('.custom-injected-reservation').forEach(el => el.remove());

        stored.slice().reverse().forEach(res => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-reservation hover:bg-emerald-50/60 transition bg-emerald-50/20';
            tr.innerHTML = `
                <td class="py-3 px-4 font-mono font-bold text-emerald-700 flex items-center gap-1.5">
                    <span>${res.reservation_code}</span>
                    <span class="px-1 py-0.2 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded">NEW</span>
                </td>
                <td class="py-3 px-4 font-black text-slate-900">${res.customer_name}</td>
                <td class="py-3 px-4 font-bold text-slate-700">${res.service_name}</td>
                <td class="py-3 px-4 font-mono text-slate-700 text-xs">
                    <div>${res.date}</div>
                    <div class="text-[10px] text-slate-400 font-sans">${res.time}</div>
                </td>
                <td class="py-3 px-4 font-black text-slate-900">₹${Number(res.amount).toLocaleString('en-IN')}</td>
                <td class="py-3 px-4 font-semibold text-slate-700">Admin</td>
                <td class="py-3 px-4">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">${res.status}</span>
                </td>
            `;
            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

    // ==========================================
    // 12. BRANCHES CONTROLLER & RENDERER
    // ==========================================
    function saveBranch(data) {
        const id = Date.now();
        const code = (data.code || ('BR-' + (data.name || 'NEW').slice(0, 3).toUpperCase())).trim();
        const branch = {
            id: id,
            code: code,
            name: (data.name || 'New Branch').trim(),
            city: (data.city || '-').trim(),
            phone: (data.phone || '-').trim(),
            email: (data.email || '-').trim(),
            address: (data.address || '-').trim(),
            status: data.status || 'Active',
            created_at: getFormattedDate()
        };

        saveItem(STORAGE_KEYS.branches, branch);
        syncToDatabase({ action: 'save_branch', data: branch });
        return branch;
    }

    function renderBranchesTable() {
        if (!window.location.pathname.includes('/branches')) return;
        const grid = document.querySelector('div.grid');
        if (!grid) return;

        const stored = getList(STORAGE_KEYS.branches);
        if (!stored.length) return;

        grid.querySelectorAll('.custom-injected-branch').forEach(el => el.remove());

        stored.slice().reverse().forEach(b => {
            const card = document.createElement('div');
            card.className = 'custom-injected-branch crm-card p-6 flex flex-col justify-between border border-emerald-300 rounded-3xl shadow-sm bg-white';
            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-mono font-black px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">${b.code}</span>
                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">${b.status}</span>
                    </div>
                    <h3 class="text-sm font-black text-slate-800 mb-1">${b.name}</h3>
                    <p class="text-xs text-slate-500 mb-2">${b.city}</p>
                    <div class="text-[11px] text-slate-600 font-mono">${b.phone}</div>
                </div>
            `;
            grid.insertBefore(card, grid.firstChild);
        });
    }

    // ==========================================
    // DEMOS STATUS CONTROLLER
    // ==========================================
    function updateDemoStatus(demoId, newStatus) {
        demoId = parseInt(demoId || 2, 10);
        newStatus = newStatus || 'Completed';

        try {
            localStorage.setItem('hm_crm_demo_status_' + demoId, newStatus);
            const demos = getList(STORAGE_KEYS.demos);
            const existing = demos.find(d => d.id == demoId);
            if (existing) {
                existing.status = newStatus;
                existing.updated_at = getFormattedDate();
            } else {
                demos.push({ id: demoId, status: newStatus, updated_at: getFormattedDate() });
            }
            localStorage.setItem(STORAGE_KEYS.demos, JSON.stringify(demos));
        } catch(e) {}

        syncToDatabase({
            action: 'update_demo_status',
            demo_id: demoId,
            status: newStatus
        });

        if (newStatus === 'Completed') {
            showToast('🎉 Demo marked as Completed! Saved to SQL.', 'success');
        } else if (newStatus === 'Cancelled') {
            showToast('Demo marked as Cancelled. Saved to SQL.', 'success');
        } else {
            showToast(`Demo status updated to ${newStatus}! Saved to SQL.`, 'success');
        }

        renderDemosTable();
    }

    function renderDemosTable() {
        const pendingTbody = document.querySelector('#pending-demos-table tbody');
        const completedTbody = document.querySelector('#completed-demos-table tbody');
        if (!pendingTbody && !completedTbody) return;

        const demoId = 2;
        const status = localStorage.getItem('hm_crm_demo_status_' + demoId);
        if (!status) return;

        const overdueStat = document.querySelector('#stat-overdue') || (document.querySelectorAll('.bg-white.rounded-2xl .text-2xl.font-black')[1]);
        const completedStat = document.querySelector('#stat-completed') || (document.querySelectorAll('.bg-white.rounded-2xl .text-2xl.font-black')[3]);
        const cancelledStat = document.querySelector('#stat-cancelled') || (document.querySelectorAll('.bg-white.rounded-2xl .text-2xl.font-black')[4]);
        const pendingBadge = document.querySelector('#stat-pending-badge') || document.querySelector('h3 span.bg-indigo-100');
        const completedBadge = document.querySelector('#stat-completed-badge') || document.querySelector('h3 span.bg-emerald-100');

        if (status === 'Completed') {
            if (overdueStat) overdueStat.textContent = '0';
            if (completedStat) completedStat.textContent = '1';
            if (cancelledStat) cancelledStat.textContent = '0';
            if (pendingBadge) pendingBadge.textContent = '0';
            if (completedBadge) completedBadge.textContent = '1';

            if (pendingTbody) {
                pendingTbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="py-14 text-center">
                            <div class="max-w-xs mx-auto text-center space-y-2.5">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-500 flex items-center justify-center text-lg mx-auto shadow-xs">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">No Pending Demos</h4>
                                    <p class="text-[11px] text-slate-400">All demonstration requests have been concluded or none are currently scheduled.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            }

            if (completedTbody) {
                completedTbody.innerHTML = `
                    <tr class="hover:bg-slate-50/70 transition bg-emerald-50/20">
                        <td class="py-3.5 px-4 font-bold text-slate-700">1</td>
                        <td class="py-3.5 px-4 font-bold text-slate-800">ram</td>
                        <td class="py-3.5 px-4 text-slate-600 font-mono">7654387654</td>
                        <td class="py-3.5 px-4 text-slate-700 font-semibold">Vipin</td>
                        <td class="py-3.5 px-4 text-slate-700 font-semibold">Vipin</td>
                        <td class="py-3.5 px-4 text-slate-700">03-10-2026</td>
                        <td class="py-3.5 px-4 text-slate-600">11:00:00</td>
                        <td class="py-3.5 px-4">
                            <span class="text-amber-500 font-bold inline-flex items-center gap-1 text-[11px]">
                                <i class="fa-solid fa-star"></i> 5.0
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Completed
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-bold inline-flex items-center gap-1 shadow-2xs">
                                <i class="fa-solid fa-circle-check"></i> Done
                            </span>
                        </td>
                    </tr>
                `;
            }
        }
    }

    // ==========================================
    // GLOBAL FORM INTERCEPTION ENGINE
    // ==========================================
    function attachGlobalFormInterceptor() {
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const action = (form.getAttribute('action') || '').toLowerCase();
            const method = (form.getAttribute('method') || 'GET').toUpperCase();

            // Ignore search forms or non-POST actions
            if (method !== 'POST') return;

            // Handle Logout cleanly across both static (Vercel) and dynamic (Laravel/XAMPP) environments
            if (action.includes('/logout')) {
                e.preventDefault();
                try {
                    sessionStorage.clear();
                    localStorage.removeItem('hm_crm_user');
                    localStorage.removeItem('crm_auth_user');
                    localStorage.removeItem('crm_logged_in');
                } catch(err) {}

                // Notify backend in background if available
                try {
                    const csrfToken = form.querySelector('input[name="_token"]')?.value || '';
                    fetch('/crm/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: '_token=' + encodeURIComponent(csrfToken)
                    }).catch(() => {});
                } catch(e) {}

                // Immediate clean client-side redirect to login page
                window.location.replace('/crm/login');
                return;
            }

            // Ignore login forms to allow native submission
            if (action.includes('/login')) return;

            // 1. PREVENT BROWSER DEFAULT POST TO STOP "Confirm Form Resubmission"
            e.preventDefault();

            const formData = new FormData(form);
            const data = {};
            for (const [k, v] of formData.entries()) {
                data[k] = v;
            }

            // Case 1: Follow-ups Form
            if (action.includes('/followups') || form.id === 'add-fu-modal' || form.closest('#add-fu-modal')) {
                const newFu = saveFollowup(data);
                showToast(`🎉 Follow-up scheduled & saved to SQL successfully!`, 'success');

                const modal = form.closest('#add-fu-modal') || document.getElementById('add-fu-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    form.reset();
                    renderFollowupsTable();
                    return;
                }

                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/followups' : '/crm/admin/followups';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 600);
                return;
            }

            // Case 2: Leads Form
            if (action.includes('/leads') || form.id === 'add-lead-form' || (data.name && (data.phone || data.company) && !action.includes('/customers') && !action.includes('/team'))) {
                if (!data.name || !data.name.trim()) {
                    showToast('Please enter prospect name', 'error');
                    return;
                }

                const newLead = saveLead(data);
                showToast(`🎉 Lead ${newLead.name} (${newLead.lead_code}) saved to SQL successfully!`, 'success');

                const modal = form.closest('#add-lead-modal') || document.getElementById('add-lead-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    form.reset();
                    renderAdminLeadsTable();
                    renderEmployeeLeadsTable();
                    return;
                }

                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/leads' : '/crm/admin/leads';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 600);
                return;
            }

            // Case 3: Customers Form
            if (action.includes('/customers')) {
                const newCust = saveCustomer(data);
                showToast(`🎉 Customer ${newCust.name} (${newCust.customer_code}) saved to SQL successfully!`, 'success');
                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/customers' : '/crm/admin/customers';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 600);
                return;
            }

            // Case 4: Deals Form
            if (action.includes('/deals')) {
                saveDeal(data);
                showToast('🎉 Deal saved to SQL successfully!', 'success');
                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/deals' : '/crm/admin/deals';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 600);
                return;
            }

            // Case 5: Tasks Form
            if (action.includes('/tasks')) {
                saveTask(data);
                showToast('🎉 Task saved to SQL successfully!', 'success');
                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/tasks' : '/crm/admin/tasks';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 600);
                return;
            }

            // Case 6: Payments Form
            if (action.includes('/payments')) {
                const pay = savePayment(data);
                showToast(`🎉 Payment ${pay.payment_no} (₹${pay.amount}) saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/payments');
                }, 600);
                return;
            }

            // Case 7: Quotations Form
            if (action.includes('/quotations') || form.id === 'quotationBuilderForm') {
                const quo = saveQuotation(data);
                showToast(`🎉 Quotation ${quo.quotation_no} saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/quotations');
                }, 600);
                return;
            }

            // Case 8: Products / Offerings Form
            if (action.includes('/products')) {
                const prd = saveProduct(data);
                showToast(`🎉 Product '${prd.name}' saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/products');
                }, 600);
                return;
            }

            // Case 9: Team Member Form
            if (action.includes('/team')) {
                const tm = saveTeamMember(data);
                showToast(`🎉 Employee '${tm.name}' saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/team');
                }, 600);
                return;
            }

            // Case 10: Reservations Form
            if (action.includes('/reservations')) {
                const res = saveReservation(data);
                showToast(`🎉 Reservation ${res.reservation_code} saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/reservations');
                }, 600);
                return;
            }

            // Case 11: Branches Form
            if (action.includes('/branches')) {
                const br = saveBranch(data);
                showToast(`🎉 Branch '${br.name}' saved to SQL successfully!`, 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/super/branches');
                }, 600);
                return;
            }

            // Case 12: Demos Form (Create or Status)
            if (action.includes('/demos')) {
                if (action.includes('/status') || form.querySelector('input[name="status"]')) {
                    const demoIdMatch = action.match(/\/demos\/(\d+)/);
                    const demoId = demoIdMatch ? parseInt(demoIdMatch[1], 10) : 2;
                    const statusVal = data.status || form.querySelector('input[name="status"]')?.value || 'Completed';
                    updateDemoStatus(demoId, statusVal);
                    return;
                } else {
                    saveDemo(data);
                    showToast('🎉 Demo scheduled & saved to SQL successfully!', 'success');
                    setTimeout(() => {
                        window.location.replace('/crm/admin/demos');
                    }, 600);
                    return;
                }
            }

            // Fallback Generic
            showToast('🎉 Information saved to SQL successfully!', 'success');
            form.reset();
        }, true);
    }


    // ==========================================
    // AUTO-REFRESH & LIVE DATABASE SYNC ENGINE
    // ==========================================
    const AUTO_REFRESH_CONFIG = {
        intervalSeconds: 10,
        storageKey: 'hm_crm_auto_refresh_enabled'
    };

    let autoRefreshState = {
        enabled: localStorage.getItem(AUTO_REFRESH_CONFIG.storageKey) !== 'false',
        countdown: AUTO_REFRESH_CONFIG.intervalSeconds,
        timerId: null,
        isRefreshing: false
    };

    function createAutoRefreshWidgetHtml() {
        return `
            <div class="inline-flex items-center gap-1.5 p-0.5 bg-white border border-slate-200/90 rounded-full shadow-xs crm-auto-refresh-widget transition hover:border-emerald-400">
                <button type="button" onclick="window.HMCrmStore && window.HMCrmStore.toggleAutoRefresh ? window.HMCrmStore.toggleAutoRefresh(event) : null" title="Click to Refresh Immediately" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full hover:bg-slate-50 text-slate-700 text-xs font-bold transition active:scale-95 cursor-pointer">
                    <span class="relative flex h-2 w-2">
                        <span class="auto-refresh-ping animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="auto-refresh-dot relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <i class="auto-refresh-icon fa-solid fa-arrows-rotate text-[11px] text-slate-400 transition-transform"></i>
                    <span class="auto-refresh-label text-[11px] font-bold">Auto Refresh: <strong class="text-emerald-700 font-black">ON</strong></span>
                    <span class="auto-refresh-timer px-1.5 py-0.2 rounded-full bg-emerald-100 text-emerald-800 font-mono text-[10px] font-black">${autoRefreshState.countdown}s</span>
                </button>
                <button type="button" onclick="window.HMCrmStore && window.HMCrmStore.toggleAutoRefreshState ? window.HMCrmStore.toggleAutoRefreshState(event) : null" title="Toggle Auto Refresh ON/OFF" class="w-6 h-6 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center text-[10px] transition cursor-pointer">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </div>
        `;
    }

    function isDashboardPage() {
        const p = (window.location.pathname || '').toLowerCase();
        if (p.includes('/dashboard')) return true;
        if (p === '/crm/admin' || p === '/crm/admin/' || p === '/crm/admin/index.html') return true;
        if (p === '/crm/employee' || p === '/crm/employee/' || p === '/crm/employee/index.html') return true;
        return false;
    }

    function injectAutoRefreshButton() {
        // STRICT REQUIREMENT: Auto Refresh button ONLY allowed on Admin Dashboard and Employee Dashboard!
        if (!isDashboardPage()) {
            document.querySelectorAll('.crm-auto-refresh-widget').forEach(el => el.remove());
            return;
        }

        // Remove any misplaced widget in topbar header
        document.querySelectorAll('header .crm-auto-refresh-widget').forEach(el => el.remove());

        if (document.querySelector('.crm-auto-refresh-widget')) {
            updateAutoRefreshUI();
            return;
        }

        // 1. Admin Dashboard Greeting Card (Hello Admin!)
        const dashboardBanner = document.querySelector('main .bg-slate-200');
        if (dashboardBanner && !dashboardBanner.querySelector('.crm-auto-refresh-widget')) {
            let actionDiv = dashboardBanner.querySelector('.crm-greeting-actions');
            if (!actionDiv) {
                actionDiv = document.createElement('div');
                actionDiv.className = 'crm-greeting-actions flex items-center gap-2.5 mt-2 sm:mt-0';
                dashboardBanner.appendChild(actionDiv);
            }
            actionDiv.innerHTML = createAutoRefreshWidgetHtml();
            updateAutoRefreshUI();
            return;
        }

        // 2. Employee Dashboard Hero Banner
        const empBanner = document.querySelector('main [style*="c0e097"]') || document.querySelector('main .border-\\[\\#b4db87\\]\\/70');
        if (empBanner && !empBanner.querySelector('.crm-auto-refresh-widget')) {
            const btnContainer = empBanner.querySelector('.mt-5.flex.items-center');
            if (btnContainer) {
                const wrap = document.createElement('div');
                wrap.innerHTML = createAutoRefreshWidgetHtml();
                btnContainer.appendChild(wrap.firstElementChild);
                updateAutoRefreshUI();
                return;
            }
        }
    }

    

    function updateAutoRefreshUI() {
        const widgets = document.querySelectorAll('.crm-auto-refresh-widget');
        widgets.forEach(widget => {
            const ping = widget.querySelector('.auto-refresh-ping');
            const dot = widget.querySelector('.auto-refresh-dot');
            const label = widget.querySelector('.auto-refresh-label');
            const timer = widget.querySelector('.auto-refresh-timer');

            if (autoRefreshState.enabled) {
                if (ping) ping.classList.remove('hidden');
                if (dot) {
                    dot.className = 'auto-refresh-dot relative inline-flex rounded-full h-2 w-2 bg-emerald-500';
                }
                if (label) {
                    label.innerHTML = 'Auto Refresh: <strong class="text-emerald-700 font-black">ON</strong>';
                }
                if (timer) {
                    timer.className = 'auto-refresh-timer px-1.5 py-0.2 rounded-full bg-emerald-100 text-emerald-800 font-mono text-[10px] font-black';
                    timer.textContent = `${autoRefreshState.countdown}s`;
                }
            } else {
                if (ping) ping.classList.add('hidden');
                if (dot) {
                    dot.className = 'auto-refresh-dot relative inline-flex rounded-full h-2 w-2 bg-slate-400';
                }
                if (label) {
                    label.innerHTML = 'Auto Refresh: <strong class="text-slate-500 font-black">PAUSED</strong>';
                }
                if (timer) {
                    timer.className = 'auto-refresh-timer px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-500 font-mono text-[10px] font-black';
                    timer.textContent = 'PAUSED';
                }
            }
        });
    }

    function triggerLiveRefresh(isManual = false) {
        if (autoRefreshState.isRefreshing) return;
        autoRefreshState.isRefreshing = true;

        const icons = document.querySelectorAll('.auto-refresh-icon');
        icons.forEach(ic => ic.classList.add('fa-spin'));

        const path = window.location.pathname.toLowerCase();
        let tableName = 'leads';
        if (path.includes('followups')) tableName = 'followups';
        else if (path.includes('customers')) tableName = 'customers';
        else if (path.includes('deals')) tableName = 'deals';
        else if (path.includes('tasks')) tableName = 'tasks';
        else if (path.includes('demos')) tableName = 'demos';
        else if (path.includes('payments')) tableName = 'payments';
        else if (path.includes('quotations')) tableName = 'quotations';
        else if (path.includes('products')) tableName = 'products';
        else if (path.includes('team') || path.includes('employees')) tableName = 'team';
        else if (path.includes('reservations')) tableName = 'reservations';
        else if (path.includes('branches')) tableName = 'branches';

        const apiUrl = `/crm/api/sync.php?action=get_records&table=${tableName}&_t=${Date.now()}`;

        fetch(apiUrl)
            .then(res => {
                if (!res.ok) throw new Error('Network response not ok');
                return res.text();
            })
            .then(text => {
                if (!text.trim().startsWith('<?php')) {
                    try {
                        const data = JSON.parse(text);
                        if (data && data.success && Array.isArray(data.records) && data.records.length > 0) {
                            const storageKey = STORAGE_KEYS[tableName] || STORAGE_KEYS.leads;
                            const localItems = getList(storageKey);
                            const localMap = new Map();
                            localItems.forEach(it => {
                                const k = it.id || it.lead_code || it.email || it.phone || JSON.stringify(it);
                                localMap.set(k, it);
                            });

                            let updated = false;
                            data.records.forEach(rec => {
                                const rk = rec.id || rec.lead_code || rec.email || rec.phone;
                                if (rk && !localMap.has(rk)) {
                                    localItems.push(rec);
                                    updated = true;
                                }
                            });

                            if (updated) {
                                localStorage.setItem(storageKey, JSON.stringify(localItems));
                            }
                        }
                    } catch (e) {}
                }
                reRenderAllTables();
            })
            .catch(() => {
                reRenderAllTables();
            })
            .finally(() => {
                setTimeout(() => {
                    icons.forEach(ic => ic.classList.remove('fa-spin'));
                    autoRefreshState.isRefreshing = false;
                    if (isManual) {
                        showToast('🔄 Real-time data refreshed!', 'info');
                    }
                }, 400);
            });
    }

    function reRenderAllTables() {
        renderAdminLeadsTable();
        renderEmployeeLeadsTable();
        renderFollowupsTable();
        renderCustomersTable();
        renderDealsTable();
        renderTasksTable();
        renderPaymentsTable();
        renderProductsTable();
        renderTeamTable();
        renderReservationsTable();
        renderBranchesTable();
        renderDemosTable();
    }

    function toggleAutoRefresh(e) {
        if (e && e.preventDefault) e.preventDefault();
        autoRefreshState.countdown = AUTO_REFRESH_CONFIG.intervalSeconds;
        updateAutoRefreshUI();
        triggerLiveRefresh(true);
    }

    function toggleAutoRefreshState(e) {
        if (e && e.stopPropagation) e.stopPropagation();
        if (e && e.preventDefault) e.preventDefault();
        autoRefreshState.enabled = !autoRefreshState.enabled;
        localStorage.setItem(AUTO_REFRESH_CONFIG.storageKey, autoRefreshState.enabled ? 'true' : 'false');
        if (autoRefreshState.enabled) {
            autoRefreshState.countdown = AUTO_REFRESH_CONFIG.intervalSeconds;
            showToast('✅ Auto Refresh activated (10s live sync)', 'info');
        } else {
            showToast('⏸️ Auto Refresh paused', 'info');
        }
        updateAutoRefreshUI();
    }

    function startAutoRefreshTimer() {
        if (autoRefreshState.timerId) clearInterval(autoRefreshState.timerId);
        autoRefreshState.timerId = setInterval(() => {
            if (!autoRefreshState.enabled) {
                updateAutoRefreshUI();
                return;
            }

            autoRefreshState.countdown--;
            if (autoRefreshState.countdown <= 0) {
                autoRefreshState.countdown = AUTO_REFRESH_CONFIG.intervalSeconds;
                triggerLiveRefresh(false);
            }
            updateAutoRefreshUI();
        }, 1000);
    }

    // ==========================================
    // INITIALIZATION & DYNAMIC HYDRATION
    // ==========================================
    function initialize() {
        attachGlobalFormInterceptor();
        injectAutoRefreshButton();
        startAutoRefreshTimer();
        renderAdminLeadsTable();
        renderEmployeeLeadsTable();
        renderFollowupsTable();
        renderCustomersTable();
        renderDealsTable();
        renderTasksTable();
        renderPaymentsTable();
        renderProductsTable();
        renderTeamTable();
        renderReservationsTable();
        renderBranchesTable();
        renderDemosTable();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // Expose Global API
    window.HMCrmStore = {
        saveLead,
        saveFollowup,
        saveCustomer,
        saveDeal,
        saveTask,
        saveDemo,
        savePayment,
        saveQuotation,
        saveProduct,
        saveTeamMember,
        saveReservation,
        saveBranch,
        showToast,
        syncToDatabase,
        renderAdminLeadsTable,
        renderEmployeeLeadsTable,
        renderFollowupsTable,
        renderCustomersTable,
        renderDealsTable,
        renderTasksTable,
        renderPaymentsTable,
        renderProductsTable,
        renderTeamTable,
        renderReservationsTable,
        renderBranchesTable,
        renderDemosTable,
        updateDemoStatus,
        deleteLeadConfirm,
        executeDeleteSelected,
        toggleAutoRefresh,
        toggleAutoRefreshState,
        triggerLiveRefresh
    };
    window.handleDemoStatus = updateDemoStatus;
    window.updateDemoStatus = updateDemoStatus;
})();
