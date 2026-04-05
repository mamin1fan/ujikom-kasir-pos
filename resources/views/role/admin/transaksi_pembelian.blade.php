<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 flex items-center gap-3">
                <span class="text-emerald-600">📦</span>
                Transaksi Pembelian
            </h2>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 rounded-2xl flex items-center gap-1">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    Barang Masuk (+ Stok)
                </span>
            </div>
        </div>
    </x-slot>

    {{-- ================= STYLE ================= --}}
    @push('styles')
        <style>
            .row-hover:hover {
                background: linear-gradient(to right, rgba(16, 185, 129, 0.08), transparent);
                transition: all 0.2s ease;
            }

            .badge-status {
                padding: 6px 14px;
                border-radius: 9999px;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.5px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .status-success {
                background: #10b981;
                color: white;
            }

            .status-pending {
                background: #f59e0b;
                color: white;
            }

            .modal-content {
                animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            @keyframes modalPop {
                0% { transform: scale(0.95); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }
        </style>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- STAT CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">🧾</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transaksi Pembelian</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-1">{{ $pembelian->total() }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">💰</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pembelian</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-1">
                            Rp {{ number_format($pembelian->sum('total_bayar'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">🏬</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Supplier Aktif</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-1">{{ $supplier->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-white">Daftar Pembelian</h3>
                        <p class="text-sm text-gray-500">Transaksi masuk • Stok bertambah otomatis</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input id="search-input" type="text" placeholder="Cari faktur / supplier..." 
                                   class="w-72 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 focus:border-emerald-500 rounded-2xl px-5 py-3 text-sm outline-none"
                                   onkeyup="filterTable()">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">🔎</div>
                        </div>

                        <select id="status-filter" onchange="filterTable()" class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-2xl px-5 py-3 text-sm outline-none">
                            <option value="">Semua Status</option>
                            <option value="selesai">✅ Selesai</option>
                            <option value="pending">⏳ Pending</option>
                        </select>

                        <flux:modal.trigger name="add-purchase">
                            <button onclick="resetModal()" 
                                    class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 transition-all text-white px-6 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-lg shadow-emerald-500/30">
                                <span class="text-xl">+</span> Pembelian Baru
                            </button>
                        </flux:modal.trigger>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="pembelian-table" class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/70 sticky top-0">
                            <tr>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-left">#</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-left">No. Faktur</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-left">Supplier</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-left">Jumlah Item</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-right">Total</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-medium text-gray-500 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($pembelian as $item)
                                <tr class="row-hover">
                                    <td class="px-6 py-5 text-sm text-gray-400 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-5 text-sm font-semibold text-gray-800 dark:text-white">{{ $item->nomor_faktur }}</td>
                                    <td class="px-6 py-5 text-sm text-gray-600 dark:text-gray-300">{{ $item->tanggal_faktur }}</td>
                                    <td class="px-6 py-5 text-sm text-gray-700 dark:text-gray-200">{{ $item->supplier->nama ?? '—' }}</td>
                                    <td class="px-6 py-5 text-sm">
                                        <span class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-2xl text-xs font-medium">
                                            {{ $item->detail_pembelian_count }} item
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-semibold text-right text-gray-900 dark:text-white">
                                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="badge-status {{ $item->status_pembelian == 'selesai' ? 'status-success' : 'status-pending' }}">
                                            {{ ucfirst($item->status_pembelian) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex items-center justify-center gap-4 text-sm">
                                            <button onclick="lihatDetail({{ $item->id_pembelian }})" class="flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-medium">👁️ Detail</button>
                                            <button onclick="hapus({{ $item->id_pembelian }})" class="flex items-center gap-1 text-red-500 hover:text-red-600 font-medium">🗑️ Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-16 text-center">
                                        <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-3xl flex items-center justify-center mb-4 text-4xl">📦</div>
                                        <p class="text-gray-400 font-medium">Belum ada transaksi pembelian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    {{ $pembelian->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MODAL PEMBELIAN (Fokus UX Transaksi Masuk) ================= --}}
    <flux:modal name="add-purchase" class="max-w-4xl modal-content">

        <form action="{{ route('admin.transaksi-pembelian.store') }}" method="POST" id="formTambahPembelian">
            @csrf

            <div class="px-8 py-6 space-y-8">
                <flux:heading size="xl" class="flex items-center gap-3">
                    <span class="text-3xl">🛒</span>
                    Transaksi Pembelian Baru
                </flux:heading>

                <div class="grid grid-cols-2 gap-6">
                    <flux:input type="date" name="tanggal_faktur" label="Tanggal Faktur" required />

                    <flux:select id="id_supplier" name="id_supplier" label="Pilih Supplier" 
                                 onchange="loadBarangBySupplier(this.value)" required>
                        <option value="">— Pilih Supplier —</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </flux:select>
                </div>

                {{-- RINCIAN BARANG DINAMIS --}}
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <flux:heading size="md">Barang dari Supplier Terpilih</flux:heading>
                        <button type="button" onclick="addItemRow()" 
                                class="flex items-center gap-2 bg-white dark:bg-gray-700 hover:bg-emerald-50 border border-gray-300 dark:border-gray-600 px-5 py-2 rounded-2xl text-sm font-medium text-emerald-700">
                            <span class="text-xl">+</span> Tambah Barang
                        </button>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="text-left px-6 py-4 text-xs font-medium text-gray-500">Nama Barang</th>
                                    <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 w-32">Jumlah</th>
                                    <th class="text-left px-6 py-4 text-xs font-medium text-gray-500 w-40">Harga Beli / Unit</th>
                                    <th class="text-right px-6 py-4 text-xs font-medium text-gray-500">Subtotal</th>
                                    <th class="w-12"></th>
                                </tr>
                            </thead>
                            <tbody id="items-body" class="divide-y divide-gray-100 dark:divide-gray-700"></tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-6 items-baseline gap-4">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span id="grand-total-display" class="text-4xl font-bold text-emerald-600">Rp 0</span>
                        <input type="hidden" id="total_bayar" name="total_bayar" value="0">
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t">
                    <button type="button" class="btn btn-secondary px-8" data-modal-close>Batal</button>
                    <button type="submit" onclick="handleSubmit(event)" 
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-10 py-3 rounded-2xl font-semibold flex items-center gap-2">
                        💾 Simpan & Tambah Stok
                    </button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- ================= SCRIPT ================= --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            let currentBarangList = []   // akan diisi via AJAX sesuai supplier
            let itemCounter = 0

            // ================= LOAD BARANG BERDASARKAN SUPPLIER =================
            async function loadBarangBySupplier(supplierId) {
                if (!supplierId) {
                    currentBarangList = []
                    document.getElementById('items-body').innerHTML = ''
                    itemCounter = 0
                    return
                }

                try {
                    const res = await fetch(`/admin/barang/by-supplier/${supplierId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    const data = await res.json()

                    currentBarangList = data  // format: [{id, nama, harga_beli}, ...]
                    document.getElementById('items-body').innerHTML = ''
                    itemCounter = 0

                    Swal.fire({
                        icon: 'success',
                        title: 'Barang dimuat',
                        text: `${data.length} barang dari supplier ini siap dipilih`,
                        timer: 1200,
                        showConfirmButton: false
                    })
                } catch (e) {
                    console.error(e)
                    Swal.fire('Error', 'Gagal memuat barang dari supplier', 'error')
                }
            }

            // ================= TAMBAH BARIS BARANG =================
            function addItemRow() {
                if (currentBarangList.length === 0) {
                    Swal.fire('Pilih Supplier Dulu', 'Barang hanya muncul setelah supplier dipilih', 'info')
                    return
                }

                itemCounter++
                const tbody = document.getElementById('items-body')

                const rowHTML = `
                <tr class="item-row" id="row-${itemCounter}">
                    <td class="px-6 py-4">
                        <select name="id_barang[]" class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl px-4 py-3 text-sm focus:border-emerald-500 outline-none"
                                onchange="calculateRow(${itemCounter})">
                            <option value="">— Pilih Barang —</option>
                            ${currentBarangList.map(b => `
                                <option value="${b.id}" data-harga="${b.harga_beli || 0}">
                                    ${b.nama}
                                </option>`).join('')}
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <input type="number" name="jumlah[]" value="1" min="1"
                               class="w-28 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl px-4 py-3 text-center text-sm focus:border-emerald-500 outline-none"
                               oninput="calculateRow(${itemCounter})">
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                            <input type="number" name="harga_beli[]" value="0" 
                                   class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl pl-9 pr-4 py-3 text-sm focus:border-emerald-500 outline-none"
                                   oninput="calculateRow(${itemCounter})">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-800 dark:text-white" id="subtotal-${itemCounter}">
                        Rp 0
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" onclick="removeRow(${itemCounter})" class="text-red-400 hover:text-red-600 text-xl">✕</button>
                    </td>
                </tr>`

                tbody.insertAdjacentHTML('beforeend', rowHTML)
                calculateGrandTotal()
            }

            function calculateRow(rowId) {
                const row = document.getElementById(`row-${rowId}`)
                if (!row) return

                const select = row.querySelector('select')
                const qtyInput = row.querySelector('input[name="jumlah[]"]')
                const hargaInput = row.querySelector('input[name="harga_beli[]"]')
                const subtotalEl = document.getElementById(`subtotal-${rowId}`)

                let harga = parseFloat(hargaInput.value) || 0

                // Ambil harga default dari data barang jika belum diisi
                if (select.value && harga === 0) {
                    const option = select.options[select.selectedIndex]
                    harga = parseFloat(option.dataset.harga) || 0
                    hargaInput.value = harga
                }

                const qty = parseFloat(qtyInput.value) || 0
                const subtotal = qty * harga

                subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID')
                calculateGrandTotal()
            }

            function removeRow(rowId) {
                const row = document.getElementById(`row-${rowId}`)
                if (row) row.remove()
                calculateGrandTotal()
            }

            function calculateGrandTotal() {
                let total = 0
                document.querySelectorAll('#items-body td[id^="subtotal-"]').forEach(el => {
                    const val = parseFloat(el.textContent.replace(/[^0-9]/g, '')) || 0
                    total += val
                })

                document.getElementById('grand-total-display').textContent = 'Rp ' + total.toLocaleString('id-ID')
                document.getElementById('total_bayar').value = total
            }

            function resetModal() {
                currentBarangList = []
                document.getElementById('items-body').innerHTML = ''
                itemCounter = 0
                document.getElementById('grand-total-display').textContent = 'Rp 0'
                document.getElementById('total_bayar').value = 0
                // Reset supplier select juga
                const supplierSelect = document.getElementById('id_supplier')
                if (supplierSelect) supplierSelect.value = ''
            }

            function handleSubmit(e) {
                if (document.querySelectorAll('#items-body tr').length === 0) {
                    e.preventDefault()
                    Swal.fire('Oops!', 'Tambahkan minimal 1 barang untuk transaksi pembelian', 'warning')
                }
            }

            // Filter table (search + status)
            function filterTable() {
                const search = document.getElementById('search-input').value.toLowerCase().trim()
                const status = document.getElementById('status-filter').value
                const rows = document.querySelectorAll('#pembelian-table tbody tr')

                rows.forEach(row => {
                    if (row.cells.length < 3) return
                    const faktur = row.cells[1].textContent.toLowerCase()
                    const supplier = row.cells[3].textContent.toLowerCase()
                    const statusText = row.cells[6].textContent.toLowerCase()

                    const matchSearch = !search || faktur.includes(search) || supplier.includes(search)
                    const matchStatus = !status || statusText.includes(status)

                    row.style.display = (matchSearch && matchStatus) ? '' : 'none'
                })
            }

            function lihatDetail(id) {
                Swal.fire('Detail Transaksi', `ID Pembelian #${id}<br><br>Detail lengkap & barang yang dibeli akan ditampilkan di halaman terpisah.`, 'info')
                // window.location.href = `/admin/transaksi-pembelian/${id}`
            }

            function hapus(id) {
                Swal.fire({
                    title: 'Hapus transaksi pembelian?',
                    text: 'Stok tidak akan dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/admin/transaksi-pembelian/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        }).then(() => location.reload())
                    }
                })
            }

            console.log('%c✅ UI Transaksi Pembelian sudah difokuskan: Pilih Supplier → Barang muncul otomatis → Beli = Stok bertambah', 'color:#10b981; font-weight:bold')
        </script>
    @endpush
</x-app-layout>