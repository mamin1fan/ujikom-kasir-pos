<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.transaksi-pembelian.index') }}"
                    class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Transaksi Pembelian Baru</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Restok barang dari supplier</p>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        .pb * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .pb-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .dark .pb-card {
            background: #1e2533;
            border-color: #2d3748;
        }

        .supplier-card {
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all .15s;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dark .supplier-card {
            background: #1e2533;
            border-color: #374151;
        }

        .supplier-card:hover {
            border-color: #10b981;
            background: #f0fdf4;
            transform: translateY(-1px);
        }

        .dark .supplier-card:hover {
            background: #052e16;
            border-color: #059669;
        }

        .supplier-card.selected {
            border-color: #10b981;
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, .15);
        }

        .dark .supplier-card.selected {
            background: #052e16;
        }

        .pb-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .dark .pb-label {
            color: #9ca3af;
        }

        .pb-input {
            padding: 9px 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            background: #f9fafb;
            color: #111827;
            outline: none;
        }

        .dark .pb-input {
            background: #111827;
            border-color: #374151;
            color: #e5e7eb;
        }

        .pb-input:focus {
            border-color: #10b981;
        }

        .restok-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .restok-table thead {
            background: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .dark .restok-table thead {
            background: #151c2c;
        }

        .restok-table th {
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #9ca3af;
            text-align: left;
        }

        .barang-row td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .barang-row td {
            border-bottom-color: #242f45;
        }

        .barang-row:hover td {
            background: #f0fdf4 !important;
        }

        .dark .barang-row:hover td {
            background: #052e16 !important;
        }

        .restok-input,
        .harga-input {
            padding: 6px 10px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            background: #f9fafb;
        }

        .dark .restok-input,
        .dark .harga-input {
            background: #1a2236;
            border-color: #374151;
            color: #e5e7eb;
        }

        .restok-input:focus,
        .harga-input:focus {
            border-color: #10b981;
        }

        .restok-input.has-value {
            border-color: #10b981;
            font-weight: 600;
            background: #f0fdf4;
        }

        .dark .restok-input.has-value {
            background: #052e16;
        }

        .summary-bar {
            background: #fff;
            border-top: 1.5px solid #e5e7eb;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, .06);
        }

        .dark .summary-bar {
            background: #1e2533;
            border-top-color: #2d3748;
        }
    </style>

    <div class="py-8 pb">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.transaksi-pembelian.store') }}" method="POST" id="formPembelian">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- PILIH SUPPLIER -->
                    <div class="lg:col-span-4">
                        <div class="pb-card p-6 sticky top-6">
                            <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4">Pilih Supplier</h3>

                            <div class="relative mb-5">
                                <input type="text" id="search-supplier" oninput="filterSupplier()"
                                    placeholder="Cari supplier..."
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-900 focus:outline-none focus:border-emerald-400">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <div class="grid grid-cols-1 gap-3 max-h-[520px] overflow-y-auto pr-1" id="supplier-grid">
                                @foreach($supplier as $s)
                                    <div class="supplier-card cursor-pointer select-none"
                                        onclick="selectSupplier({{ $s->id_supplier }}, '{{ addslashes($s->nama) }}')"
                                        id="scard-{{ $s->id_supplier }}" data-nama="{{ strtolower($s->nama) }}">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center flex-shrink-0">
                                            <span
                                                class="text-sm font-bold text-emerald-600">{{ strtoupper(substr($s->nama, 0, 2)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm truncate">{{ $s->nama }}</p>
                                            <p class="text-xs text-gray-400 truncate">{{ $s->telepon ?? '-' }}</p>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center flex-shrink-0 transition-all"
                                            id="scheck-{{ $s->id_supplier }}">
                                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 hidden"
                                                id="sdot-{{ $s->id_supplier }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="id_supplier" id="id_supplier_hidden" required>
                        </div>
                    </div>

                    <!-- TANGGAL & TABEL -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="pb-card p-6">
                            <label class="pb-label">Tanggal Faktur</label>
                            <input type="date" name="tanggal_faktur" value="{{ date('Y-m-d') }}" class="pb-input w-full"
                                required>
                        </div>

                        <div class="pb-card overflow-hidden" id="barang-section" style="display: none;">
                            <div class="px-6 py-4 border-b flex items-center justify-between">
                                <div>
                                    <p class="font-semibold" id="supplier-name-display">Pilih supplier terlebih dahulu
                                    </p>
                                    <p class="text-xs text-gray-400">Isi jumlah restok dan harga beli</p>
                                </div>
                                <div class="relative w-72">
                                    <input type="text" id="search-barang" onkeyup="filterBarang()"
                                        placeholder="Cari nama barang..."
                                        class="w-full pl-9 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-900">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <div style="max-height: 520px; overflow-y: auto;">
                                <table class="restok-table">
                                    <thead>
                                        <tr>
                                            <th style="width:35%">Nama Barang</th>
                                            <th class="text-center" style="width:10%">Satuan</th>
                                            <th class="text-center" style="width:12%">Stok Saat Ini</th>
                                            <th class="text-center" style="width:13%">Jumlah Restok</th>
                                            <th class="text-right" style="width:15%">Harga Beli</th>
                                            <th class="text-right" style="width:17%">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-barang" class="divide-y"></tbody>
                                </table>
                            </div>

                            <div class="summary-bar">
                                <div class="flex gap-8">
                                    <div>
                                        <p class="text-xs text-gray-400">Item direstok</p>
                                        <p class="text-2xl font-bold" id="total-item-count">0</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Total Pembelian</p>
                                        <p class="text-2xl font-bold text-emerald-600" id="grand-total">Rp 0</p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <a href="{{ route('admin.transaksi-pembelian.index') }}"
                                        class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 border border-gray-200 rounded-xl">
                                        Batal
                                    </a>
                                    <button type="button" onclick="submitForm()" id="btn-submit"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2.5 rounded-xl font-semibold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simpan Pembelian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const barangPerSupplier = @json($barangPerSupplier ?? []);
            let selectedSupplierId = null;

            function selectSupplier(id, nama) {
                document.querySelectorAll('.supplier-card').forEach(c => c.classList.remove('selected'));
                document.querySelectorAll('[id^="sdot-"]').forEach(d => d.classList.add('hidden'));

                document.getElementById('scard-' + id).classList.add('selected');
                document.getElementById('sdot-' + id).classList.remove('hidden');

                document.getElementById('id_supplier_hidden').value = id;
                selectedSupplierId = id;

                document.getElementById('supplier-name-display').textContent = 'Restok dari: ' + nama;

                renderBarang(id);
                document.getElementById('barang-section').style.display = 'block';
            }

            function renderBarang(supplierId) {
                const tbody = document.getElementById('tbody-barang');
                const items = barangPerSupplier[supplierId] || [];
                tbody.innerHTML = '';

                if (items.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center py-20 text-gray-400">Tidak ada barang untuk supplier ini</td></tr>`;
                    return;
                }

                items.forEach((b, index) => {
                    const rowIndex = index + 1;
                    const row = document.createElement('tr');
                    row.className = 'barang-row';
                    row.setAttribute('data-nama', (b.nama || '').toLowerCase());

                    row.innerHTML = `
                    <td>
                        <input type="hidden" name="details[${rowIndex}][id_barang]" value="${b.id_barang}">
                        <p class="font-medium">${b.nama || ''}</p>
                    </td>
                    <td class="text-center text-sm font-medium satuan-cell">
                        <input type="hidden" name="details[${rowIndex}][satuan]" value="${b.satuan ?? 'pcs'}">
                        <p class="font-medium">${b.satuan ?? 'pcs'}</p>
                    </td>
                    <td class="text-center text-sm">${b.stok ?? 0} pcs</td>
                    <td class="text-center">
                        <input type="number" name="details[${rowIndex}][jumlah]" 
                               class="restok-input w-20" min="0" value="0" 
                               oninput="onQtyChange(this)">
                    </td>
                    <td class="text-right">
                        <input type="number" name="details[${rowIndex}][harga_beli]" 
                               class="harga-input w-32" min="0" value="${Number(b.harga_beli) || 0}" 
                               oninput="hitungTotal()">
                    </td>
                    <td class="text-right font-semibold text-emerald-600 subtotal-cell">Rp 0</td>
                `;

                    tbody.appendChild(row);
                });

                hitungTotal();
            }
            function onQtyChange(input) {
                const row = input.closest('tr');
                if (parseFloat(input.value) > 0) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
                hitungTotal();
            }

            function hitungTotal() {
                let grandTotal = 0, itemCount = 0;

                document.querySelectorAll('.barang-row').forEach(row => {
                    const qty = parseFloat(row.querySelector('input[name*="[jumlah]"]').value) || 0;
                    const harga = parseFloat(row.querySelector('input[name*="[harga_beli]"]').value) || 0;
                    const subtotal = qty * harga;

                    row.querySelector('.subtotal-cell').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    grandTotal += subtotal;
                    if (qty > 0) itemCount++;
                });

                document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
                document.getElementById('total-item-count').textContent = itemCount;
            }

            function filterSupplier() {
                const q = document.getElementById('search-supplier').value.toLowerCase().trim();
                document.querySelectorAll('#supplier-grid .supplier-card').forEach(card => {
                    card.style.display = card.getAttribute('data-nama').includes(q) ? '' : 'none';
                });
            }

            function filterBarang() {
                const q = document.getElementById('search-barang').value.toLowerCase().trim();
                document.querySelectorAll('#tbody-barang .barang-row').forEach(row => {
                    row.style.display = row.getAttribute('data-nama').includes(q) ? '' : 'none';
                });
            }
            function submitForm() {
                if (!selectedSupplierId) {
                    Swal.fire({ title: 'Perhatian', text: 'Pilih supplier terlebih dahulu!', icon: 'warning' });
                    return;
                }

                let hasItem = false;
                let detailData = [];

                document.querySelectorAll('.barang-row').forEach(row => {
                    const idInput = row.querySelector('input[name*="[id_barang]"]');
                    const qtyInput = row.querySelector('input[name*="[jumlah]"]');
                    const hargaInput = row.querySelector('input[name*="[harga_beli]"]');
                    const satuanCell = row.querySelector('input[name*="[satuan]"]');
             

                    const jumlah = parseFloat(qtyInput ? qtyInput.value : 0) || 0;
                    const harga_beli = parseFloat(hargaInput ? hargaInput.value : 0) || 0;
                    const satuanText = satuanCell ? satuanCell.value : null;

                    if (jumlah > 0 && idInput) {
                        hasItem = true;
                        detailData.push({
                            id_barang: idInput.value,
                            jumlah: jumlah,
                            harga_beli: harga_beli,
                            satuan: (satuanText && satuanText !== '-') ? satuanText : null
                        });
                    }
                });

                if (!hasItem) {
                    Swal.fire({ title: 'Perhatian', text: 'Minimal restok 1 barang!', icon: 'warning' });
                    return;
                }

                // Debug log (ini yang paling penting sekarang)
                console.log('%c✅ Data yang akan dikirim:', 'color: lime; font-weight: bold', {
                    id_supplier: selectedSupplierId,
                    details: detailData
                });

                Swal.fire({
                    title: 'Simpan Transaksi Pembelian?',
                    text: 'Stok barang akan ditambahkan secara otomatis',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const btn = document.getElementById('btn-submit');
                        if (btn) {
                            btn.innerHTML = 'Menyimpan...';
                            btn.disabled = true;
                        }
                        document.getElementById('formPembelian').submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>