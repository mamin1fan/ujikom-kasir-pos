<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Product Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">



                <flux:modal name="add-product" class="md:w-96">
                    <form action="{{ route('super-admin.barang.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">

                            <flux:heading size="lg">Add Product</flux:heading>

                            <flux:input name="barcode" label="Barcode" />

                            <flux:input name="nama" label="Nama Produk" />

                            <flux:select name="id_kelompok_kategori" label="Kelompok Kategori">
                                <option value="">Pilih Kelompok</option>
                                @foreach ($kelompok_kategori as $item)
                                    <option value="{{ $item->id_kelompok }}">
                                        {{ $item->nama_kelompok }}
                                    </option>
                                @endforeach
                            </flux:select>

                            <flux:select name="id_kategori" label="Kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->nama }}</option>
                                @endforeach
                            </flux:select>

                            <flux:select name="id_supplier" label="Pilih Supplier">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </flux:select>

                            <flux:input name="satuan" label="Satuan" placeholder="pcs / box / unit" />

                            <flux:input name="harga_beli" label="Harga Beli" type="number" />

                            <flux:input name="harga_jual" label="Harga Jual" type="number" />

                            <flux:input name="stok" label="Stok" type="number" />

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" variant="primary">
                                    Simpan
                                </flux:button>
                            </div>

                        </div>
                    </form>
                </flux:modal>

                <!-- Single Edit Modal -->
                <flux:modal name="edit-product" class="md:w-96">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">

                            <flux:heading size="lg">Edit Product</flux:heading>

                            <flux:input name="barcode" label="Barcode" id="edit_barcode" />

                            <flux:input name="nama" label="Nama Produk" id="edit_nama" />

                            <flux:select name="id_kelompok_kategori" label="Kelompok Kategori"
                                id="edit_id_kelompok_kategori">
                                <option value="">Pilih Kelompok</option>
                                @foreach ($kelompok_kategori as $row)
                                    <option value="{{ $row->id_kelompok }}">
                                        {{ $row->nama_kelompok }}
                                    </option>
                                @endforeach
                            </flux:select>

                            <flux:select name="id_kategori" label="Kategori" id="edit_id_kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->id_kategori }}">{{ $row->nama }}</option>
                                @endforeach
                            </flux:select>

                            <flux:select name="id_supplier" label="Pilih Supplier" id="edit_id_supplier">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </flux:select>

                            <flux:input name="satuan" label="Satuan" id="edit_satuan" placeholder="pcs / box / unit" />

                            <flux:input name="harga_beli" label="Harga Beli" type="number" id="edit_harga_beli" />

                            <flux:input name="harga_jual" label="Harga Jual" type="number" id="edit_harga_jual" />

                            <flux:input name="stok" label="Stok" type="number" id="edit_stok" />

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" variant="primary">
                                    Update
                                </flux:button>
                            </div>

                        </div>
                    </form>
                </flux:modal>

                <!-- Hidden trigger for edit modal -->
                <flux:modal.trigger name="edit-product" id="edit-modal-trigger" style="display:none;">
                </flux:modal.trigger>

                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-4">

                    <!-- Search -->
                    <form method="GET" action="{{ route('super-admin.barang.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search product..."
                            class="w-64 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </form>

                    <!-- Add Button -->
                    <flux:modal.trigger name="add-product">
                        <a
                            class="px-4 py-2 bg-indigo-600 text-white cursor-pointer rounded-lg hover:bg-indigo-700 transition">
                            + Add Product
                        </a>
                    </flux:modal.trigger>

                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>


                        <!-- Example Row -->
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($barang as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <!-- Nama -->
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $item->nama }}
                                    </td>

                                    <!-- Kategori (relasi) -->
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $item->kategori->nama ?? '-' }}
                                    </td>

                                    <!-- Harga Jual -->
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    </td>

                                    <!-- Stok -->
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $item->stok }}
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex gap-2">
                                            <button
                                                onclick="editProduct({{ json_encode(['id_barang' => $item->id_barang, 'barcode' => $item->barcode, 'nama' => $item->nama, 'id_kelompok_kategori' => $item->id_kelompok_kategori, 'id_kategori' => $item->id_kategori, 'id_supplier' => $item->id_supplier, 'satuan' => $item->satuan, 'harga_beli' => $item->harga_beli, 'harga_jual' => $item->harga_jual, 'stok' => $item->stok]) }})"
                                                class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm transition">
                                                Edit
                                            </button>

                                            <button type="button" onclick="confirmDelete({{ $item->id_barang }})"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm transition">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">
                                        Data barang belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            function confirmDelete(id) {

                Swal.fire({
                    title: 'Yakin hapus data?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        fetch('{{ route('super-admin.barang.destroy', ':id') }}'.replace(':id', id), {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                            .then(response => {
                                if (response.ok) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data berhasil dihapus',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload(); // reload halaman
                                    });

                                } else {
                                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                                }
                            });

                    }

                });
            }

            function editProduct(data) {
                document.getElementById('edit_barcode').value = data.barcode;
                document.getElementById('edit_nama').value = data.nama;
                document.getElementById('edit_id_kelompok_kategori').value = data.id_kelompok_kategori;
                document.getElementById('edit_id_kategori').value = data.id_kategori;
                document.getElementById('edit_id_supplier').value = data.id_supplier;
                document.getElementById('edit_satuan').value = data.satuan;
                document.getElementById('edit_harga_beli').value = data.harga_beli;
                document.getElementById('edit_harga_jual').value = data.harga_jual;
                document.getElementById('edit_stok').value = data.stok;
                document.getElementById('editForm').action = '{{ route('super-admin.barang.update', ':id') }}'.replace(
                    ':id',
                    data.id_barang);
                // Buka modal
                if (window.Flux && window.Flux.showModal) {
                    window.Flux.showModal('edit-product');
                } else {
                    // Fallback: klik trigger tersembunyi
                    document.getElementById('edit-modal-trigger').click();
                }
            }
        </script>
    @endpush
</x-app-layout>
