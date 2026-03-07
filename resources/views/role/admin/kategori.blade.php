<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Category Management
        </h2>
    </x-slot>

    @push('styles')
        <style>
            .table-row-hover:hover {
                background-color: rgba(99, 102, 241, 0.05);
            }

            .btn-icon {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: .75rem;
                font-weight: 500;
                padding: 5px 12px;
                border-radius: 8px;
                cursor: pointer;
            }

            .btn-edit {
                background: #fef3c7;
                color: #d97706;
            }

            .btn-delete {
                background: #fee2e2;
                color: #dc2626;
            }

            .text-xs-truncate {
                max-width: 150px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    @endpush

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================= STAT CARD ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-5 flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                        🏷️
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $total_kategori }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- ================= TABLE ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border">

                <div class="px-6 py-4 border-b flex justify-between items-center">

                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Daftar Kategori
                        </h3>
                        <p class="text-xs text-gray-400">
                            Kelola semua kategori produk
                        </p>
                    </div>

                    <flux:modal.trigger name="add-category">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-xl">
                            + Tambah Kategori
                        </button>
                    </flux:modal.trigger>

                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelompok</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Created By</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Updated By</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Updated At</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($kategori as $item)
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 text-sm text-gray-400">
                                        {{ $kategori->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $item->nama }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $item->kelompok->nama_kelompok }}
                                    </td>

                                    <td class="px-6 py-4 text-xs-truncate text-gray-500">
                                        {{ $item->creator->username ?? 'System' }}
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        {{ $item->created_at ? $item->created_at->format('d M Y • H:i') : '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-xs-truncate text-gray-500">
                                        {{ $item->updater->username ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        {{ $item->updated_at ? $item->updated_at->format('d M Y • H:i') : '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button class="btn-icon btn-edit"
                                                onclick="openEditModal({{ $item->id_kategori }}, '{{ addslashes($item->nama) }}', {{ $item->kelompok->id_kelompok }})">
                                                ✏️ Edit
                                            </button>

                                            <button class="btn-icon btn-delete"
                                                onclick="confirmDelete({{ $item->id_kategori }}, '{{ addslashes($item->nama) }}')">
                                                🗑️ Hapus
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-16 text-gray-400">
                                        Belum ada kategori
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($kategori->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $kategori->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    {{-- ================= MODAL ADD ================= --}}
    <flux:modal name="add-category" class="md:w-[420px]">

        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <div class="space-y-4">

                <flux:heading size="lg">
                    Tambah Kategori
                </flux:heading>

                <flux:select name="id_kelompok_kategori" label="Kelompok Kategori">
                    <option value="">Pilih Kelompok</option>
                    @foreach ($kelompok_kategori as $item)
                        <option value="{{ $item->id_kelompok }}">{{ $item->nama_kelompok }}</option>
                    @endforeach
                </flux:select>

                <flux:input name="nama" label="Nama Kategori" />

                <div class="flex justify-end gap-2">

                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Batal
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit">
                        Simpan
                    </flux:button>

                </div>

            </div>

        </form>

    </flux:modal>



    {{-- ================= MODAL EDIT ================= --}}
    <flux:modal name="edit-category" class="md:w-[420px]">

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">

                <flux:heading size="lg">
                    Edit Kategori
                </flux:heading>

                <flux:select name="id_kelompok_kategori" label="Kelompok Kategori" id="edit_id_kelompok_kategori">
                    <option value="">Pilih Kelompok</option>
                    @foreach ($kelompok_kategori as $item)
                        <option value="{{ $item->id_kelompok }}">{{ $item->nama_kelompok }}</option>
                    @endforeach
                </flux:select>

                <flux:input name="nama" label="Nama Kategori" id="edit_nama" />

                <div class="flex justify-end gap-2">

                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Batal
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit">
                        Update
                    </flux:button>

                </div>

            </div>

        </form>

    </flux:modal>

    <flux:modal.trigger name="edit-category" id="edit-modal-trigger" style="display:none;"></flux:modal.trigger>



    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            const ROUTES = {
                update: '{{ route('admin.kategori.update', ':id') }}',
                destroy: '{{ route('admin.kategori.destroy', ':id') }}'
            };

            function openEditModal(id, nama, id_kelompok, nama_kelompok) {

                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_id_kelompok_kategori').value = id_kelompok;


                document.getElementById('editForm').action =
                    ROUTES.update.replace(':id', id);

                if (window.Flux?.showModal) {
                    Flux.showModal('edit-category');
                } else {
                    document.getElementById('edit-modal-trigger').click();
                }

            }



            function confirmDelete(id, nama) {

                Swal.fire({
                    title: `Hapus "${nama}" ?`,
                    text: "Kategori yang masih memiliki produk tidak dapat dihapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then(result => {

                    if (!result.isConfirmed) return;

                    fetch(ROUTES.destroy.replace(':id', id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    })
                        .then(async res => {

                            const data = await res.json();

                            if (!res.ok) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Tidak bisa dihapus',
                                    text: data.message
                                });

                                return;
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());

                        });

                });

            }
        </script>

    @endpush

</x-app-layout>