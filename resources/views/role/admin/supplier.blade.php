<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Supplier Management
        </h2>
    </x-slot>

    @push('styles')
        <style>
            .table-row-hover:hover {
                background-color: rgba(99, 102, 241, 0.05);
                transition: background-color .15s ease;
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
            }

            .btn-delete {
                background: #fee2e2;
                color: #dc2626;
            }

            .btn-delete:hover {
                background: #fecaca;
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

            {{-- STAT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">

                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-xl">
                        🏢
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">
                            Total Supplier
                        </p>

                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $suppliers->total() }}
                        </p>
                    </div>

                </div>

            </div>



            {{-- TABLE --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">

                {{-- HEADER --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">

                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Daftar Supplier
                        </h3>

                        <p class="text-xs text-gray-400">
                            Kelola supplier toko
                        </p>
                    </div>

                    <div class="flex gap-3">

                        <form method="GET">

                            <div class="relative">

                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    🔍
                                </span>

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari supplier..."
                                    class="search-input pl-9 pr-4 py-2 text-sm rounded-xl border border-gray-200 w-52">

                            </div>

                        </form>

                        <flux:modal.trigger name="add-supplier">
                            <button
                                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl">
                                + Tambah Supplier
                            </button>
                        </flux:modal.trigger>

                    </div>

                </div>



                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead>

                            <tr class="bg-gray-50 dark:bg-gray-700/50">

                                <th class="px-6 py-3 text-xs">#</th>

                                <th class="px-6 py-3 text-xs text-left">
                                    Nama Supplier
                                </th>

                                <th class="px-6 py-3 text-xs text-left">
                                    No Telepon
                                </th>

                                <th class="px-6 py-3 text-xs text-left">
                                    Alamat
                                </th>

                                <th class="px-6 py-3 text-xs text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y">

                            @forelse($suppliers as $item)

                                                        <tr class="table-row-hover">

                                                            <td class="px-6 py-4 text-sm text-gray-400">
                                                                {{ $suppliers->firstItem() + $loop->index }}
                                                            </td>

                                                            <td class="px-6 py-4 text-sm font-medium">
                                                                {{ $item->nama }}
                                                            </td>

                                                            <td class="px-6 py-4 text-sm">
                                                                {{ $item->no_telepon ?? '-' }}
                                                            </td>

                                                            <td class="px-6 py-4 text-sm">
                                                                {{ $item->alamat_supplier ?? '-' }}
                                                            </td>

                                                            <td class="px-6 py-4">

                                                                <div class="flex justify-center gap-2">

                                                                    <button class="btn-icon btn-edit" onclick="openEditModal({{ json_encode([
                                    'id_supplier' => $item->id_supplier,
                                    'nama' => $item->nama,
                                    'no_telepon' => $item->no_telepon,
                                    'alamat_supplier' => $item->alamat_supplier,

                                    'creator' => $item->creator->username ?? 'system',

                                    'created_at' => $item->created_at
                                        ? $item->created_at->format('d M Y') . ' • ' . $item->created_at->diffForHumans()
                                        : '-'
                                ]) }})">

                                                                        ✏️

                                                                    </button>


                                                                    <button class="btn-icon btn-delete"
                                                                        onclick="confirmDelete({{ $item->id_supplier }}, '{{ addslashes($item->nama) }}')">

                                                                        🗑️

                                                                    </button>

                                                                </div>

                                                            </td>

                                                        </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-16 text-gray-400">

                                        <div class="flex flex-col items-center gap-2">

                                            <span class="text-4xl">📭</span>

                                            <p class="text-sm">
                                                Belum ada supplier
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>



                @if($suppliers->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $suppliers->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>



    {{-- ADD SUPPLIER --}}
    <flux:modal name="add-supplier" class="md:w-[480px]">

        <form action="{{ route('admin.supplier.store') }}" method="POST">
            @csrf

            <div class="space-y-4">

                <flux:heading size="lg">
                    Tambah Supplier
                </flux:heading>

                <flux:input name="nama" label="Nama Supplier" />

                <flux:input name="no_telepon" label="No Telepon" />

                <flux:textarea name="alamat_supplier" label="Alamat" />

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



    {{-- EDIT SUPPLIER --}}
    <flux:modal name="edit-supplier" class="md:w-[480px]">

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">

                <flux:heading size="lg">
                    Edit Supplier
                </flux:heading>

                <flux:input name="nama" label="Nama Supplier" id="edit_nama" />

                <flux:input name="no_telepon" label="No Telepon" id="edit_no_telepon" />

                <flux:textarea name="alamat_supplier" label="Alamat" id="edit_alamat" />


                <div class="pt-3 border-t text-xs text-gray-400 space-y-1">

                    <div>
                        Created by :
                        <span id="edit_creator" class="text-gray-600 dark:text-gray-300">
                            -
                        </span>
                    </div>

                    <div>
                        Created at :
                        <span id="edit_created_at" class="text-gray-600 dark:text-gray-300">
                            -
                        </span>
                    </div>

                </div>


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



    <flux:modal.trigger name="edit-supplier" id="edit-trigger" style="display:none"></flux:modal.trigger>



    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            const ROUTES = {
                update: '{{ route("admin.supplier.update", ":id") }}',
                destroy: '{{ route("admin.supplier.destroy", ":id") }}'
            }


            function openEditModal(data) {

                document.getElementById('edit_nama').value = data.nama ?? ''
                document.getElementById('edit_no_telepon').value = data.no_telepon ?? ''
                document.getElementById('edit_alamat').value = data.alamat_supplier ?? ''

                document.getElementById('edit_creator').innerText = data.creator ?? '-'
                document.getElementById('edit_created_at').innerText = data.created_at ?? '-'

                document.getElementById('editForm').action =
                    ROUTES.update.replace(':id', data.id_supplier)

                document.getElementById('edit-trigger').click()

            }


            function confirmDelete(id, name) {

                Swal.fire({
                    title: `Hapus ${name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then(result => {

                    if (result.isConfirmed) {

                        fetch(
                            ROUTES.destroy.replace(':id', id),
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({ _method: 'DELETE' })
                            }
                        ).then(() => location.reload())

                    }

                })

            }

        </script>

    @endpush

</x-app-layout>