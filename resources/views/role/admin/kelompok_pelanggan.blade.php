<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Kelompok Pelanggan
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
                        <p class="text-xs text-gray-500 uppercase">Total Kelompok</p>

                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $total_kelompok }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- ================= TABLE ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border">

                <div class="px-6 py-4 border-b flex justify-between items-center">

                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Daftar Kelompok Pelanggan
                        </h3>

                        <p class="text-xs text-gray-400">
                            Kelola kelompok pelanggan toko
                        </p>
                    </div>

                    <flux:modal.trigger name="add-kelompok">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-xl">
                            + Tambah Kelompok
                        </button>
                    </flux:modal.trigger>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Nama Kelompok
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Jumlah Pelanggan
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y">

                            @forelse ($kelompok as $item)

                                <tr class="table-row-hover">

                                    <td class="px-6 py-4 text-sm text-gray-400">
                                        {{ $kelompok->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $item->nama_kelompok }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->pelanggan_count }} pelanggan
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <button class="btn-icon btn-edit" onclick="openEditModal(
                                                                                {{ $item->id_kelompok_pelanggan }},
                                                                                '{{ addslashes($item->nama_kelompok) }}'
                                                                                )">
                                                ✏️ Edit
                                            </button>

                                            <button class="btn-icon btn-delete" onclick="confirmDelete(
                                                                            {{ $item->id_kelompok_pelanggan }},
                                                                            '{{ addslashes($item->nama_kelompok) }}',
                                                                            {{ $item->pelanggan_count }}
                                                                            )">
                                                🗑️ Hapus
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center py-16 text-gray-400">
                                        Belum ada kelompok pelanggan
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if ($kelompok->hasPages())

                    <div class="px-6 py-4 border-t">
                        {{ $kelompok->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>


    {{-- ================= MODAL ADD ================= --}}
    <flux:modal name="add-kelompok" class="md:w-[420px]">

        <form action="{{ route('admin.kelompok.pelanggan.store') }}" method="POST">
            @csrf

            <div class="space-y-4">

                <flux:heading size="lg">
                    Tambah Kelompok Pelanggan
                </flux:heading>

                <flux:input name="nama_kelompok" label="Nama Kelompok" />


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
    <flux:modal name="edit-kelompok" class="md:w-[420px]">

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">

                <flux:heading size="lg">
                    Edit Kelompok Pelanggan
                </flux:heading>

                <flux:input id="edit_nama_kelompok" name="nama_kelompok" label="Nama Kelompok" />

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

    <flux:modal.trigger name="edit-kelompok" id="edit-modal-trigger" style="display:none;"></flux:modal.trigger>


    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            const ROUTES = {
                update: '{{ route('admin.kelompok.pelanggan.update', ':id') }}',
                destroy: '{{ route('admin.kelompok.pelanggan.destroy', ':id') }}'
            };

            function openEditModal(id, nama) {

                document.getElementById('edit_nama_kelompok').value = nama;

                document.getElementById('editForm').action =
                    ROUTES.update.replace(':id', id);

                if (window.Flux?.showModal) {
                    Flux.showModal('edit-kelompok');
                } else {
                    document.getElementById('edit-modal-trigger').click();
                }

            }

            function confirmDelete(id, nama, pelangganCount) {

                // 🔴 jika masih ada relasi pelanggan
                if (pelangganCount > 0) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak bisa dihapus',
                        html: `
                    Kelompok <b>${nama}</b> masih memiliki 
                    <b>${pelangganCount} pelanggan</b>.<br><br>
                    Hapus atau pindahkan pelanggan terlebih dahulu.
                `
                    });

                    return;
                }

                // jika aman dihapus
                let timer = 5;

                Swal.fire({
                    title: `Hapus "${nama}" ?`,
                    html: `
                <div style="font-size:14px">
                    <p style="margin-bottom:8px">
                        ⚠️ Data ini akan <b>dihapus permanen</b> dan tidak bisa dikembalikan.
                    </p>

                    <p style="color:#ef4444">
                        Tombol hapus akan aktif dalam <b id="countdown">5</b> detik
                    </p>
                </div>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus Permanen',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    didOpen: () => {

                        const confirmBtn = Swal.getConfirmButton();
                        confirmBtn.disabled = true;

                        const interval = setInterval(() => {

                            timer--;

                            document.getElementById('countdown').textContent = timer;

                            if (timer <= 0) {

                                confirmBtn.disabled = false;
                                clearInterval(interval);

                            }

                        }, 1000);

                    }

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