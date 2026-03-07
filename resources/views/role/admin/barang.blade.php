<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Product Management
        </h2>
    </x-slot>

    {{-- ===================== STYLES ===================== --}}
    @push('styles')
        <style>
            .product-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .table-row-hover:hover {
                background-color: rgba(99, 102, 241, 0.05);
                transition: background-color 0.15s ease;
            }

            .badge-stock-low {
                background: #fee2e2;
                color: #dc2626;
            }

            .badge-stock-ok {
                background: #dcfce7;
                color: #16a34a;
            }

            .badge-stock-mid {
                background: #fef3c7;
                color: #d97706;
            }

            .btn-icon {
                width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                font-size: 14px;
            }

            .btn-edit {
                background: #fef3c7;
                color: #d97706;
            }

            .btn-edit:hover {
                background: #fde68a;
                color: #b45309;
            }

            .btn-delete {
                background: #fee2e2;
                color: #dc2626;
            }

            .btn-delete:hover {
                background: #fecaca;
                color: #b91c1c;
            }

            .modal-overlay {
                animation: fadeIn 0.2s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .search-input:focus {
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
                border-color: #6366f1;
                outline: none;
            }
        </style>
    @endpush

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================== STAT CARDS ===================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- Total Produk --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-xl">
                        📦
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $barang->total() }}</p>
                    </div>
                </div>

                {{-- Stok Menipis --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 text-xl">
                        ⚠️
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok Menipis</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $barang->getCollection()->where('stok', '<', 10)->count() }}
                        </p>
                    </div>
                </div>

                {{-- Kategori --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 text-xl">
                        🏷️
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $kategori->count() }}</p>
                    </div>
                </div>

            </div>

            {{-- ===================== MAIN TABLE CARD ===================== --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">

                {{-- Header Bar --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Daftar Produk</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Kelola semua produk toko Anda</p>
                    </div>

                    <div class="flex items-center gap-3">

                        {{-- Search --}}
                        <form method="GET" action="{{ route('admin.barang.index') }}">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari produk..."
                                    class="search-input pl-9 pr-4 py-2 text-sm rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white w-52 transition">
                            </div>
                        </form>

                        {{-- Add Button --}}
                        <flux:modal.trigger name="add-product">
                            <button
                                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                                <span class="text-base leading-none">+</span>
                                Tambah Produk
                            </button>
                        </flux:modal.trigger>

                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Produk</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kategori</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Supplier</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Harga Beli</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Harga Jual</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Stok</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($barang as $index => $item)
                                                        <tr class="table-row-hover" title="Dibuat {{ $item->created_at }}">

                                                            {{-- Nomor --}}
                                                            <td class="px-6 py-4 text-sm text-gray-400">
                                                                {{ $barang->firstItem() + $loop->index }}
                                                            </td>

                                                            {{-- Nama + Barcode --}}
                                                            <td class="px-6 py-4">
                                                                <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $item->nama }}
                                                                </div>
                                                                <div class="text-xs text-gray-400 mt-0.5">
                                                                    {{ $item->barcode ?? '-' }}
                                                                </div>
                                                            </td>

                                                            {{-- Kategori --}}
                                                            <td class="px-6 py-4">
                                                                <span
                                                                    class="inline-block text-xs bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 px-2.5 py-1 rounded-full font-medium">
                                                                    {{ $item->kategori->nama ?? '-' }}
                                                                </span>
                                                            </td>

                                                            {{-- Harga Beli --}}
                                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                                                Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                                            </td>

                                                            {{-- Harga Jual --}}
                                                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">
                                                                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                                            </td>

                                                            {{-- Stok --}}
                                                            <td class="px-6 py-4">
                                                                <@php
                                                                $stockClass = $item->stok < 10 
                                                                    ? 'badge-stock-low' 
                                                                    : ($item->stok < 30 ? 'badge-stock-mid' : 'badge-stock-ok');
                                                                @endphp

                                                                <span class="inline-block text-xs px-2.5 py-1 rounded-full font-semibold {{ $stockClass }}">
                                                                    {{ $item->stok }} {{ $item->satuan }}
                                                                </span>
                                                            </td>

                                                            {{-- Aksi --}}
                                                            <td class="px-6 py-4">
                                                                <div class="flex items-center justify-center gap-2">

                                                                    {{-- Edit --}}
                                                                    <button class="btn-icon btn-edit" onclick="openEditModal({{ json_encode([
                                                                        'id_barang' => $item->id_barang,
                                                                        'barcode' => $item->barcode,
                                                                        'nama' => $item->nama,
                                                                        'id_kelompok_kategori' => $item->id_kelompok_kategori,
                                                                        'id_kategori' => $item->id_kategori,
                                                                        'id_supplier' => $item->id_supplier,
                                                                        'satuan' => $item->satuan,
                                                                        'harga_beli' => $item->harga_beli,
                                                                        'harga_jual' => $item->harga_jual,
                                                                        'stok' => $item->stok,
                                                                    ]) }})">
                                                                        ✏️ Edit
                                                                    </button>

                                                                    {{-- Delete --}}
                                                                    <button class="btn-icon btn-delete"
                                                                        onclick="confirmDelete({{ $item->id_barang }}, '{{ addslashes($item->nama) }}')">
                                                                        🗑️ Hapus
                                                                    </button>

                                                                </div>
                                                            </td>

                                                        </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-16">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <span class="text-4xl">📭</span>
                                            <p class="text-sm font-medium">Belum ada data produk</p>
                                            <p class="text-xs">Klik tombol "Tambah Produk" untuk mulai menambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($barang->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $barang->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ===================== MODAL: ADD PRODUCT ===================== --}}
    <flux:modal name="add-product" class="md:w-[480px]">
        <form action="{{ route('admin.barang.store') }}" method="POST">
            @csrf
            <div class="space-y-4 p-1">

                <div class="mb-2">
                    <flux:heading size="lg">Tambah Produk Baru</flux:heading>
                    <p class="text-xs text-gray-400 mt-1">Isi semua informasi produk dengan benar</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="barcode" label="Barcode" />
                    <flux:input name="satuan" label="Satuan" placeholder="pcs / box / unit" />
                </div>

                <flux:input name="nama" label="Nama Produk" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:select name="id_kelompok_kategori" label="Kelompok Kategori">
                        <option value="">Pilih Kelompok</option>
                        @foreach ($kelompok_kategori as $item)
                            <option value="{{ $item->id_kelompok }}">{{ $item->nama_kelompok }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select name="id_kategori" label="Kategori">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id_kategori }}">{{ $item->nama }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <flux:select name="id_supplier" label="Supplier">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="harga_beli" label="Harga Beli" type="number" />
                    <flux:input name="harga_jual" label="Harga Jual" type="number" />
                </div>

                <flux:input name="stok" label="Stok Awal" type="number" />

                <div class="flex justify-end gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">💾 Simpan Produk</flux:button>
                </div>

            </div>
        </form>
    </flux:modal>

    {{-- ===================== MODAL: EDIT PRODUCT ===================== --}}
    <flux:modal name="edit-product" class="md:w-[480px]">
        <form id="editProductForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4 p-1">

                <div class="mb-2">
                    <flux:heading size="lg">Edit Produk</flux:heading>
                    <p class="text-xs text-gray-400 mt-1">Perbarui informasi produk</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="barcode" label="Barcode" id="edit_barcode" />
                    <flux:input name="satuan" label="Satuan" id="edit_satuan" placeholder="pcs / box / unit" />
                </div>

                <flux:input name="nama" label="Nama Produk" id="edit_nama" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:select name="id_kelompok_kategori" label="Kelompok Kategori" id="edit_id_kelompok_kategori">
                        <option value="">Pilih Kelompok</option>
                        @foreach ($kelompok_kategori as $row)
                            <option value="{{ $row->id_kelompok }}">{{ $row->nama_kelompok }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select name="id_kategori" label="Kategori" id="edit_id_kategori">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $row)
                            <option value="{{ $row->id_kategori }}">{{ $row->nama }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <flux:select name="id_supplier" label="Supplier" id="edit_id_supplier">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="harga_beli" label="Harga Beli" type="number" id="edit_harga_beli" />
                    <flux:input name="harga_jual" label="Harga Jual" type="number" id="edit_harga_jual" />
                </div>

                <flux:input name="stok" label="Stok" type="number" id="edit_stok" />

                <div class="flex justify-end gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">✅ Update Produk</flux:button>
                </div>

            </div>
        </form>
    </flux:modal>

    {{-- Hidden trigger for edit modal --}}
    <flux:modal.trigger name="edit-product" id="edit-modal-trigger" style="display:none;"></flux:modal.trigger>

    {{-- ===================== SCRIPTS ===================== --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Flash Messages --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                });
            </script>
        @endif

        <script>
            // ===================== CONSTANTS =====================
            const ROUTES = {
                update: '{{ route('admin.barang.update', ':id') }}',
                destroy: '{{ route('admin.barang.destroy', ':id') }}',
            };

            const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ===================== OPEN EDIT MODAL =====================
            function openEditModal(data) {
                const fields = {
                    edit_barcode: data.barcode,
                    edit_nama: data.nama,
                    edit_id_kelompok_kategori: data.id_kelompok_kategori,
                    edit_id_kategori: data.id_kategori,
                    edit_id_supplier: data.id_supplier,
                    edit_satuan: data.satuan,
                    edit_harga_beli: data.harga_beli,
                    edit_harga_jual: data.harga_jual,
                    edit_stok: data.stok,
                };

                // Populate form fields
                Object.entries(fields).forEach(([id, value]) => {
                    const el = document.getElementById(id);
                    if (el) el.value = value ?? '';
                });

                // Set form action URL
                document.getElementById('editProductForm').action =
                    ROUTES.update.replace(':id', data.id_barang);

                // Open modal via Flux or fallback trigger
                if (window.Flux?.showModal) {
                    window.Flux.showModal('edit-product');
                } else {
                    document.getElementById('edit-modal-trigger').click();
                }
            }

            // ===================== DELETE CONFIRMATION =====================
            function confirmDelete(id, name) {
                Swal.fire({
                    title: `Hapus "${name}"?`,
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then(({ isConfirmed }) => {
                    if (!isConfirmed) return;

                    fetch(ROUTES.destroy.replace(':id', id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                        },
                        body: JSON.stringify({ _method: 'DELETE' }),
                    })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false,
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', 'Gagal menghapus data', 'error');
                            }
                        })
                        .catch(() => Swal.fire('Error', 'Terjadi kesalahan jaringan', 'error'));
                });
            }
        </script>
    @endpush
</x-app-layout>