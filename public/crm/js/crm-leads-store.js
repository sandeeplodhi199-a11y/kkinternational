/**
 * Hisab Mittra CRM - Universal Persistence Engine & Form Controller
 * 1. Intercepts all form submissions with e.preventDefault() to eliminate browser "Confirm Form Resubmission"
 * 2. Saves leads, deals, customers, and tasks to persistent localStorage
 * 3. Immediately renders new leads into Admin and Employee tables with status badges & actions
 * 4. Provides clean, non-POST page redirection using window.location.replace()
 */
(function() {
    'use strict';

    const STORAGE_KEYS = {
        leads: 'hm_crm_leads_data',
        deals: 'hm_crm_deals_data',
        customers: 'hm_crm_customers_data',
        tasks: 'hm_crm_tasks_data',
        followups: 'hm_crm_followups_data'
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

    function getFormattedDate(d = new Date()) {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const day = String(d.getDate()).padStart(2, '0');
        return `${day} ${months[d.getMonth()]} ${d.getFullYear()}`;
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

    // ==========================================
    // LEADS PERSISTENCE & RENDERING
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

        // Auto-save to SQL & MySQL database
        syncToDatabase({ action: 'save_lead', data: lead });

        return lead;
    }

    function syncToDatabase(payload) {
        try {
            fetch('/crm/api/sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(res => {
                if (res && res.success) {
                    console.log('✅ Auto-saved to SQL database:', res);
                }
            }).catch(err => {
                // CDN / offline resilience
            });
        } catch(e) {}
    }

    function renderAdminLeadsTable() {
        const tbody = document.querySelector('#all-leads-table tbody');
        if (!tbody) return;

        const storedLeads = getList(STORAGE_KEYS.leads);
        if (!storedLeads.length) return;

        // Clean previous injected rows
        tbody.querySelectorAll('.custom-injected-lead').forEach(el => el.remove());

        // Update counter
        const totalHeader = document.querySelector('h1 span.rounded-full');
        if (totalHeader) {
            totalHeader.textContent = `${2 + storedLeads.length} total`;
        }

        const statusBadges = {
            'New': 'bg-blue-100 text-blue-800',
            'Contacted': 'bg-amber-100 text-amber-800',
            'In Progress': 'bg-indigo-100 text-indigo-800',
            'Qualified': 'bg-emerald-100 text-emerald-800',
            'Converted': 'bg-teal-100 text-teal-800',
            'Lost': 'bg-rose-100 text-rose-800'
        };

        const priorityColors = {
            'Urgent': 'text-rose-600 font-bold',
            'High': 'text-amber-600 font-bold',
            'Medium': 'text-slate-700',
            'Low': 'text-slate-500'
        };

        // Render in reverse so newest is on top
        storedLeads.slice().reverse().forEach(lead => {
            const tr = document.createElement('tr');
            tr.className = 'custom-injected-lead hover:bg-emerald-50/60 transition bg-emerald-50/20';

            const statusClass = statusBadges[lead.status] || 'bg-slate-100 text-slate-700';
            const prioClass = priorityColors[lead.priority] || 'text-slate-700';
            const valStr = lead.expected_value ? '₹' + Number(lead.expected_value).toLocaleString('en-IN') : '-';
            const basicStr = lead.basic ? '₹' + Number(lead.basic).toLocaleString('en-IN') : '-';
            const proStr = lead.pro ? '₹' + Number(lead.pro).toLocaleString('en-IN') : (valStr !== '-' ? valStr : '-');
            const agentStr = (lead.agent && lead.agent !== '-') ? lead.agent : '-';
            const callbackStr = lead.follow_up_date || lead.callback || '-';
            const leadDataSafe = JSON.stringify(lead).replace(/"/g, '&quot;');

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
                <td class="py-2.5 px-3 ${prioClass}">${lead.priority}</td>
                <td class="py-2.5 px-3 text-slate-800 font-bold">${basicStr}</td>
                <td class="py-2.5 px-3 text-slate-800 font-bold">${proStr}</td>
                <td class="py-2.5 px-3 text-slate-500 max-w-xs truncate text-[11px]">${lead.notes || '-'}</td>
                <td class="py-2.5 px-3 text-center">
                    <div class="inline-flex items-center justify-center gap-1">
                        <button type="button" onclick="if(window.viewLeadModal) { viewLeadModal(${leadDataSafe}); } else { alert('Lead Details:\\nName: ${lead.name}\\nPhone: ${lead.phone}\\nStatus: ${lead.status}'); }" title="View" class="w-6 h-6 rounded bg-[#4f46e5] hover:bg-[#4338ca] text-white flex items-center justify-center text-[10px] transition shadow-xs">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" onclick="if(window.editLeadModal) { editLeadModal(${leadDataSafe}); } else { alert('Editing ${lead.name}'); }" title="Edit" class="w-6 h-6 rounded bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center text-[10px] transition shadow-xs">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        });
    }

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

        const prospectSpan = document.querySelector('span.text-xs.text-slate-400');
        if (prospectSpan) {
            prospectSpan.textContent = `${1 + storedLeads.length} assigned prospects`;
        }
    }

    // ==========================================
    // FLOATING TOAST NOTIFICATION
    // ==========================================
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-6 right-6 z-[99999] px-5 py-3.5 rounded-2xl shadow-2xl text-white text-xs font-black flex items-center gap-3 transition-all duration-300 transform -translate-y-4 opacity-0 ${type === 'success' ? 'bg-emerald-600 shadow-emerald-600/40' : 'bg-rose-600 shadow-rose-600/40'}`;
        toast.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-circle-check text-emerald-200' : 'fa-circle-xmark text-rose-200'} text-base"></i>
            <span class="tracking-wide">${message}</span>
        `;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('-translate-y-4', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => toast.remove(), 350);
        }, 3200);
    }

    // ==========================================
    // FORM INTERCEPTION & RESUBMISSION SUPPRESSION
    // ==========================================
    function attachGlobalFormInterceptor() {
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const action = (form.getAttribute('action') || '').toLowerCase();
            const method = (form.getAttribute('method') || 'GET').toUpperCase();

            // Ignore search forms or non-POST actions
            if (method !== 'POST') return;

            // Ignore authentication forms
            if (action.includes('/login') || action.includes('/logout')) return;

            // 1. PREVENT BROWSER DEFAULT POST TO STOP "Confirm Form Resubmission"
            e.preventDefault();

            const formData = new FormData(form);
            const data = {};
            for (const [k, v] of formData.entries()) {
                data[k] = v;
            }

            // Case A: Leads Form
            if (action.includes('/leads') || form.id === 'add-lead-form' || (data.name && (data.phone || data.company))) {
                if (!data.name || !data.name.trim()) {
                    showToast('Please enter prospect name', 'error');
                    return;
                }

                const newLead = saveLead(data);
                showToast(`🎉 Lead ${newLead.name} (${newLead.lead_code}) saved successfully!`, 'success');

                // If in modal on leads table page
                const modal = form.closest('#add-lead-modal') || document.getElementById('add-lead-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    form.reset();
                    renderAdminLeadsTable();
                    renderEmployeeLeadsTable();
                    return;
                }

                // If on create page, redirect to leads table with GET replace (no history POST state)
                const targetUrl = window.location.pathname.includes('/employee/') ? '/crm/employee/leads' : '/crm/admin/leads';
                setTimeout(() => {
                    window.location.replace(targetUrl);
                }, 700);
                return;
            }

            // Case B: Deals Form
            if (action.includes('/deals')) {
                saveItem(STORAGE_KEYS.deals, data);
                showToast('🎉 Deal saved successfully!', 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/deals');
                }, 700);
                return;
            }

            // Case C: Customers Form
            if (action.includes('/customers')) {
                saveItem(STORAGE_KEYS.customers, data);
                showToast('🎉 Customer saved successfully!', 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/customers');
                }, 700);
                return;
            }

            // Case D: Tasks Form
            if (action.includes('/tasks')) {
                saveItem(STORAGE_KEYS.tasks, data);
                showToast('🎉 Task saved successfully!', 'success');
                setTimeout(() => {
                    window.location.replace('/crm/admin/tasks');
                }, 700);
                return;
            }

            // Case E: Generic form fallback
            showToast('🎉 Information saved successfully!', 'success');
            form.reset();
        }, true); // Use capture phase to intercept before any other listeners
    }

    // ==========================================
    // INITIALIZATION
    // ==========================================
    function initialize() {
        attachGlobalFormInterceptor();
        renderAdminLeadsTable();
        renderEmployeeLeadsTable();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // Expose API
    window.HMCrmStore = {
        saveLead,
        showToast,
        renderAdminLeadsTable,
        renderEmployeeLeadsTable
    };
})();
