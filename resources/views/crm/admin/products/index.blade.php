@extends('crm.layouts.master')

@section('title', 'Products & Services Catalog')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Products & Services Catalog</h2>
            <p class="text-xs text-slate-500 font-medium">Enterprise software tiers, recurring subscriptions, and professional services</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('add-prod-modal').classList.remove('hidden')" class="px-5 py-2 rounded-full bg-[#1b4d3e] text-white text-xs font-bold hover:bg-[#2d6a4f] transition shadow-md flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Add Offering</span>
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="products-grid">
        @forelse($products as $p)
            <div class="crm-card p-6 flex flex-col justify-between" id="prod-card-{{ $p->id }}" data-id="{{ $p->id }}" data-code="{{ $p->code }}">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 prod-category-badge">
                            {{ $p->category }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ strtolower($p->status) === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }} prod-status-badge">
                                {{ $p->status }}
                            </span>
                            <!-- Orange Edit Button -->
                            <button type="button" 
                                    onclick="openEditProductModal('{{ $p->id }}', {{ json_encode($p->name) }}, {{ json_encode($p->code) }}, {{ json_encode($p->category) }}, {{ (float)$p->price }}, {{ (float)$p->tax_rate }}, {{ json_encode($p->status) }}, {{ json_encode($p->description ?? '') }})" 
                                    class="w-7 h-7 rounded-lg bg-[#f59e0b] hover:bg-[#d97706] text-white flex items-center justify-center transition shadow-sm active:scale-95 cursor-pointer" 
                                    title="Edit Offering">
                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                            </button>
                            <!-- Red Trash Button -->
                            <button type="button" 
                                    onclick="confirmDeleteProduct('{{ $p->id }}', {{ json_encode($p->name) }}, {{ json_encode($p->code) }})" 
                                    class="w-7 h-7 rounded-lg bg-[#ef4444] hover:bg-[#dc2626] text-white flex items-center justify-center transition shadow-sm active:scale-95 cursor-pointer" 
                                    title="Delete Offering">
                                <i class="fa-solid fa-trash text-[11px]"></i>
                            </button>
                            <!-- Hidden Laravel DELETE Form -->
                            <form id="delete-prod-form-{{ $p->id }}" action="{{ route('crm.admin.products.destroy', $p->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-800 mb-1 prod-name">{{ $p->name }}</h3>
                    <p class="text-xs text-slate-400 font-mono mb-3 prod-code">{{ $p->code }}</p>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed font-medium prod-desc">
                        {{ $p->description ?: 'No detailed description.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Standard Price</span>
                        <span class="text-lg font-black text-slate-900 prod-price">₹{{ number_format($p->price, 2) }}</span>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 prod-tax">+ {{ $p->tax_rate }}% GST</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 crm-card">
                No products or services registered.
            </div>
        @endforelse
    </div>

    <!-- Modal: Add Product -->
    <div id="add-prod-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add Product / Service Offering</h3>
                <button type="button" onclick="document.getElementById('add-prod-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
            </div>
            <form action="{{ route('crm.admin.products.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Item Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Enterprise Cloud CRM License" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Item Code</label>
                        <input type="text" name="code" placeholder="e.g. PRD-CRM-ENT" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category *</label>
                        <select name="category" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                            <option value="Software">Software</option>
                            <option value="Service">Professional Service</option>
                            <option value="Subscription">Subscription</option>
                            <option value="Hardware">Hardware</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Base Price (₹) *</label>
                        <input type="number" name="price" required value="75000" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" value="18" class="w-full text-xs p-2 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full text-xs p-2 rounded-xl border border-slate-200"></textarea>
                </div>
                <input type="hidden" name="status" value="Active">
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-prod-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition">Save Offering</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Product -->
    <div id="edit-prod-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Edit Product / Service Offering</h3>
                </div>
                <button type="button" onclick="closeEditModal()" class="w-7 h-7 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center text-lg leading-none">&times;</button>
            </div>
            <form id="edit-prod-form" action="" method="POST" onsubmit="handleEditProductSubmit(event)" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-prod-id" name="id">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Item Name *</label>
                    <input type="text" id="edit-prod-name" name="name" required placeholder="e.g. Enterprise Cloud CRM License" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Item Code</label>
                        <input type="text" id="edit-prod-code" name="code" placeholder="e.g. PRD-CRM-ENT" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category *</label>
                        <select id="edit-prod-category" name="category" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                            <option value="Software">Software</option>
                            <option value="Service">Professional Service</option>
                            <option value="Subscription">Subscription</option>
                            <option value="Hardware">Hardware</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Base Price (₹) *</label>
                        <input type="number" step="0.01" id="edit-prod-price" name="price" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tax Rate (%)</label>
                        <input type="number" step="0.01" id="edit-prod-tax" name="tax_rate" value="18" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                        <select id="edit-prod-status" name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea id="edit-prod-desc" name="description" rows="2" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-semibold text-slate-600 hover:bg-slate-200 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#1b4d3e] text-xs font-bold text-white hover:bg-[#2d6a4f] transition shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditProductModal(id, name, code, category, price, taxRate, status, description) {
        const modal = document.getElementById('edit-prod-modal');
        if (!modal) return;

        const form = document.getElementById('edit-prod-form');
        if (form) {
            form.action = '/crm/admin/products/' + id;
        }

        const overrides = JSON.parse(localStorage.getItem('hm_crm_products_overrides') || '{}');
        const saved = overrides[String(id)] || (code ? overrides[String(code)] : null) || {};

        document.getElementById('edit-prod-id').value = id || '';
        document.getElementById('edit-prod-name').value = saved.name !== undefined ? saved.name : (name || '');
        document.getElementById('edit-prod-code').value = saved.code !== undefined ? saved.code : (code || '');
        document.getElementById('edit-prod-category').value = saved.category !== undefined ? saved.category : (category || 'Software');
        document.getElementById('edit-prod-price').value = saved.price !== undefined ? saved.price : (price !== undefined ? price : 0);
        document.getElementById('edit-prod-tax').value = saved.tax_rate !== undefined ? saved.tax_rate : (taxRate !== undefined ? taxRate : 18);
        document.getElementById('edit-prod-status').value = saved.status !== undefined ? saved.status : (status || 'Active');
        document.getElementById('edit-prod-desc').value = saved.description !== undefined ? saved.description : (description || '');

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-prod-modal');
        if (modal) modal.classList.add('hidden');
    }

    function updateProductCardInDOM(id, p) {
        const card = document.getElementById('prod-card-' + id) || 
                     (p.code ? document.querySelector(`[data-code="${p.code}"]`) : null) || 
                     document.querySelector(`[data-id="${id}"]`);
        if (!card) return;

        const catBadge = card.querySelector('.prod-category-badge');
        if (catBadge && p.category) catBadge.textContent = p.category;

        const statusBadge = card.querySelector('.prod-status-badge');
        if (statusBadge && p.status) {
            statusBadge.textContent = p.status;
            if (String(p.status).toLowerCase() === 'active') {
                statusBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 prod-status-badge';
            } else {
                statusBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 prod-status-badge';
            }
        }

        const nameEl = card.querySelector('.prod-name');
        if (nameEl && p.name) nameEl.textContent = p.name;

        const codeEl = card.querySelector('.prod-code');
        if (codeEl && p.code) codeEl.textContent = p.code;

        const descEl = card.querySelector('.prod-desc');
        if (descEl && p.description !== undefined) descEl.textContent = p.description || 'No detailed description.';

        const priceEl = card.querySelector('.prod-price');
        if (priceEl && p.price !== undefined) {
            priceEl.textContent = '₹' + Number(p.price).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        const taxEl = card.querySelector('.prod-tax');
        if (taxEl && p.tax_rate !== undefined) {
            taxEl.textContent = `+ ${Number(p.tax_rate).toFixed(2)}% GST`;
        }
    }

    function handleEditProductSubmit(e) {
        const id = document.getElementById('edit-prod-id').value;
        const name = document.getElementById('edit-prod-name').value.trim();
        const code = document.getElementById('edit-prod-code').value.trim();
        const category = document.getElementById('edit-prod-category').value;
        const price = parseFloat(document.getElementById('edit-prod-price').value) || 0;
        const taxRate = parseFloat(document.getElementById('edit-prod-tax').value) || 18;
        const status = document.getElementById('edit-prod-status').value;
        const description = document.getElementById('edit-prod-desc').value.trim();

        const productData = {
            id: id,
            name: name,
            code: code,
            category: category,
            price: price,
            tax_rate: taxRate,
            status: status,
            description: description
        };

        const overrides = JSON.parse(localStorage.getItem('hm_crm_products_overrides') || '{}');
        overrides[String(id)] = productData;
        if (code) overrides[String(code)] = productData;
        localStorage.setItem('hm_crm_products_overrides', JSON.stringify(overrides));

        updateProductCardInDOM(id, productData);

        fetch('/crm/api/sync.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'save_product', data: productData })
        }).catch(() => {});

        // If on static / non-laravel environment, prevent submit and close modal
        if (window.location.pathname.endsWith('.html') || window.location.hostname.includes('vercel.app')) {
            e.preventDefault();
            closeEditModal();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: `Offering "${name}" updated successfully.`,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }
    }

    function confirmDeleteProduct(id, name, code) {
        const doDelete = () => {
            const deletedIds = JSON.parse(localStorage.getItem('hm_crm_deleted_product_ids') || '[]');
            if (!deletedIds.includes(String(id))) deletedIds.push(String(id));
            if (code && !deletedIds.includes(String(code))) deletedIds.push(String(code));
            localStorage.setItem('hm_crm_deleted_product_ids', JSON.stringify(deletedIds));

            let prods = JSON.parse(localStorage.getItem('hm_crm_products_data') || '[]');
            prods = prods.filter(p => String(p.id) !== String(id) && (!code || String(p.code) !== String(code)));
            localStorage.setItem('hm_crm_products_data', JSON.stringify(prods));

            const overrides = JSON.parse(localStorage.getItem('hm_crm_products_overrides') || '{}');
            delete overrides[String(id)];
            if (code) delete overrides[String(code)];
            localStorage.setItem('hm_crm_products_overrides', JSON.stringify(overrides));

            const card = document.getElementById('prod-card-' + id) || 
                         (code ? document.querySelector(`[data-code="${code}"]`) : null) || 
                         document.querySelector(`[data-id="${id}"]`);
            if (card) {
                card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => card.remove(), 300);
            }

            fetch('/crm/api/sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete_product', id: id, code: code, name: name })
            }).catch(() => {});

            const form = document.getElementById('delete-prod-form-' + id);
            if (form && !window.location.pathname.endsWith('.html') && !window.location.hostname.includes('vercel.app')) {
                form.submit();
                return;
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: `"${name}" has been deleted.`,
                    timer: 1800,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Offering?',
                text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    doDelete();
                }
            });
        } else {
            if (confirm(`Are you sure you want to delete "${name}"?`)) {
                doDelete();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const deletedIds = JSON.parse(localStorage.getItem('hm_crm_deleted_product_ids') || '[]');
        deletedIds.forEach(delId => {
            const card = document.getElementById('prod-card-' + delId) || 
                         document.querySelector(`[data-code="${delId}"]`) || 
                         document.querySelector(`[data-id="${delId}"]`);
            if (card) card.remove();
        });

        const overrides = JSON.parse(localStorage.getItem('hm_crm_products_overrides') || '{}');
        Object.keys(overrides).forEach(k => {
            updateProductCardInDOM(k, overrides[k]);
        });
    });
</script>
@endpush
