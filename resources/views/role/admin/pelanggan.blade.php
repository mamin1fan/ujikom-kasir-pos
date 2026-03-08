<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Kelola Pelanggan
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

                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                        👥
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase">Total Pelanggan</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $total_pelanggan }}
                        </p>
                    </div>

                </div>
            </div>


            {{-- ================= TABLE ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border">

                <div class="px-6 py-4 border-b flex justify-between items-center">

                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Daftar Pelanggan
                        </h3>

                        <p class="text-xs text-gray-400">
                            Kelola data pelanggan toko
                        </p>
                    </div>

                    <flux:modal.trigger name="add-pelanggan">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-xl">
                            + Tambah Pelanggan
                        </button>
                    </flux:modal.trigger>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Nama
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Kelompok
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Telepon
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Alamat
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">
                                    Aksi
                                </th>

                            </tr>
                        </thead>


                        <tbody class="divide-y">

                            @forelse ($pelanggan as $item)

                                                            <tr class="table-row-hover">

                                                                <td class="px-6 py-4 text-sm text-gray-400">
                                                                    {{ $pelanggan->firstItem() + $loop->index }}
                                                                </td>

                                                                <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white">
                                                                    {{ $item->nama_pelanggan }}
                                                                </td>

                                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                                    {{ $item->kelompok->nama_kelompok ?? '-' }}
                                                                </td>

                                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                                    {{ $item->telepon }}
                                                                </td>

                                                                <td class="px-6 py-4 text-xs-truncate text-gray-500">
                                                                    {{ $item->alamat }}
                                                                </td>

                                                                <td class="px-6 py-4">

                                                                    <div class="flex justify-center gap-2">

                                                                        <button class="btn-icon btn-edit" onclick="openEditModal(
                                {{ $item->id_pelanggan }},
                                '{{ addslashes($item->nama_pelanggan) }}',
                                '{{ $item->id_kelompok_pelanggan }}',
                                '{{ $item->telepon }}',
                                '{{ addslashes($item->alamat) }}'
                                )">
                                                                            ✏️ Edit
                                                                        </button>

                                                                        <button class="btn-icon btn-delete" onclick="confirmDelete(
                                {{ $item->id_pelanggan }},
                                '{{ addslashes($item->nama_pelanggan) }}'
                                )">
                                                                            🗑️ Hapus
                                                                        </button>

                                                                    </div>

                                                                </td>

                                                            </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-16 text-gray-400">
                                        Belum ada pelanggan
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if ($pelanggan->hasPages())

                    <div class="px-6 py-4 border-t">
                        {{ $pelanggan->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>


    {{-- ================= MODAL ADD ================= --}}
    <flux:modal name="add-pelanggan" class="md:w-[420px]">

        <form action="{{ route('admin.pelanggan.store') }}" method="POST">
            @csrf

            <div class="space-y-4">

                <flux:heading size="lg">
                    Tambah Pelanggan
                </flux:heading>

                <flux:input name="nama_pelanggan" label="Nama Pelanggan" />

                <flux:select name="id_kelompok_pelanggan" label="Kelompok Pelanggan">

                    @foreach($kelompok as $k)

                        <option value="{{ $k->id_kelompok_pelanggan }}">
                            {{ $k->nama_kelompok }}
                        </option>

                    @endforeach

                </flux:select>

                <flux:input name="telepon" label="Telepon" />

                <flux:textarea name="alamat" label="Alamat" />

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
    <flux:modal name="edit-pelanggan" class="md:w-[420px]">

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">

                <flux:heading size="lg">
                    Edit Pelanggan
                </flux:heading>

                <flux:input id="edit_nama" name="nama_pelanggan" label="Nama Pelanggan" />

                <flux:select id="edit_kelompok" name="id_kelompok_pelanggan" label="Kelompok">

                    @foreach($kelompok as $k)

                        <option value="{{ $k->id_kelompok_pelanggan }}">
                            {{ $k->nama_kelompok }}
                        </option>

                    @endforeach

                </flux:select>

                <flux:input id="edit_telepon" name="telepon" label="Telepon" />

                <flux:textarea id="edit_alamat" name="alamat" label="Alamat" />

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

    <flux:modal.trigger name="edit-pelanggan" id="edit-modal-trigger" style="display:none;"></flux:modal.trigger>


    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            const ROUTES = {
                update: '{{ route('admin.pelanggan.update', ':id') }}',
                destroy: '{{ route('admin.pelanggan.destroy', ':id') }}'
            };

            function openEditModal(id, nama, kelompok, telepon, alamat) {

                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_kelompok').value = kelompok;
                document.getElementById('edit_telepon').value = telepon;
                document.getElementById('edit_alamat').value = alamat;

                document.getElementById('editForm').action =
                    ROUTES.update.replace(':id', id);

                if (window.Flux?.showModal) {
                    Flux.showModal('edit-pelanggan');
                } else {
                    document.getElementById('edit-modal-trigger').click();
                }

            }


            function confirmDelete(id, nama) {

                Swal.fire({
                    title: `Hapus "${nama}" ?`,
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
                                    title: 'Gagal',
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