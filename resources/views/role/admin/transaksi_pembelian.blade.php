<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Transaksi Pembelian
        </h2>
    </x-slot>

    {{-- ================= STYLE ================= --}}
    @push('styles')
        <style>
            .row-hover:hover {
                background: rgba(16, 185, 129, 0.05);
            }

            .badge-status {
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
            }

            .status-success {
                background: #dcfce7;
                color: #166534;
            }

            .status-pending {
                background: #fef3c7;
                color: #92400e;
            }
        </style>
    @endpush

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================= STAT ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- Total Transaksi --}}
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow border border-gray-200 dark:border-gray-700 flex gap-4">
                    <div class="text-2xl">🧾</div>
                    <div>
                        <p class="text-xs text-gray-500">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $pembelian->total() }}
                        </p>
                    </div>
                </div>

                {{-- Total Pembelian --}}
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow border border-gray-200 dark:border-gray-700 flex gap-4">
                    <div class="text-2xl">💰</div>
                    <div>
                        <p class="text-xs text-gray-500">Total Pembelian</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            Rp {{ number_format($pembelian->sum('total_bayar'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Supplier --}}
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow border border-gray-200 dark:border-gray-700 flex gap-4">
                    <div class="text-2xl">🏢</div>
                    <div>
                        <p class="text-xs text-gray-500">Supplier Aktif</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $supplier->count() }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- ================= TABLE ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700">

                {{-- HEADER --}}
                <div class="p-5 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            Daftar Pembelian
                        </h3>
                        <p class="text-xs text-gray-400">
                            Riwayat transaksi masuk
                        </p>
                    </div>

                    <flux:modal.trigger name="add-purchase">
                        <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm">
                            + Tambah Pembelian
                        </button>
                    </flux:modal.trigger>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-xs">#</th>
                                <th class="px-6 py-3 text-xs">Faktur</th>
                                <th class="px-6 py-3 text-xs">Tanggal</th>
                                <th class="px-6 py-3 text-xs">Supplier</th>
                                <th class="px-6 py-3 text-xs">Banyak Barang</th>
                                <th class="px-6 py-3 text-xs">Total</th>
                                <th class="px-6 py-3 text-xs">Status</th>
                                <th class="px-6 py-3 text-xs text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pembelian as $item)
                                <tr class="row-hover">

                                    {{-- NO --}}
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- FAKTUR --}}
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $item->nomor_faktur }}
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $item->tanggal_faktur }}
                                    </td>

                                    {{-- SUPPLIER --}}
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $item->supplier->nama ?? '-' }}
                                    </td>

                                    {{-- BANYAK BARANG --}}
                                    <td class="px-6 py-4 text-sm">
                                        {{ $item->detail_pembelian_count }} item
                                    </td>

                                    {{-- TOTAL --}}
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">
                                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="badge-status 
                                                    {{ $item->status_pembelian == 'selesai' ? 'status-success' : 'status-pending' }}">
                                            {{ ucfirst($item->status_pembelian) }}
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-blue-500 hover:underline">
                                            Detail
                                        </button>

                                        <button onclick="hapus({{ $item->id_pembelian }})"
                                            class="text-red-500 hover:underline ml-3">
                                            Hapus
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-400">
                                        Belum ada transaksi pembelian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4">
                    {{ $pembelian->links() }}
                </div>

            </div>

        </div>
    </div>

    {{-- ================= MODAL ================= --}}
    <flux:modal name="add-purchase" class="md:w-[500px]">

        <form action="{{ route('admin.transaksi-pembelian.store') }}" method="POST">
            @csrf

            <div class="space-y-4">

                <flux:heading size="lg">Tambah Pembelian</flux:heading>

                <flux:input type="date" name="tanggal_faktur" label="Tanggal" />

                <flux:select name="id_supplier" label="Supplier">
                    @foreach($supplier as $s)
                        <option value="{{ $s->id_supplier }}">
                            {{ $s->nama }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:input type="number" name="total_bayar" label="Total Bayar" />

                <flux:input name="note" label="Catatan (opsional)" />

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit">
                        💾 Simpan
                    </flux:button>
                </div>

            </div>
        </form>

    </flux:modal>

    {{-- ================= SCRIPT ================= --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function hapus(id) {
                Swal.fire({
                    title: 'Hapus transaksi?',
                    text: 'Data tidak bisa dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/transaksi-pembelian/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        })
                            .then(res => res.json())
                            .then(() => location.reload())
                    }
                })
            }
        </script>
    @endpush

</x-app-layout>