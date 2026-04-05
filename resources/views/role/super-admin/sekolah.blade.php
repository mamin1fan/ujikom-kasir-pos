<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Management Sekolah
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Modal Tambah Sekolah --}}
        <flux:modal name="tambah-sekolah" class="md:w-96">
            <form method="POST" action="{{ route('super-admin.sekolah.store') }}">
                @csrf

                <div class="space-y-4">
                    <flux:heading size="lg">Tambah Sekolah Baru</flux:heading>

                    <flux:input name="nama_sekolah" label="Nama Sekolah" placeholder="Masukkan nama sekolah" required />

                    <flux:input name="alamat_sekolah" label="Alamat" placeholder="Alamat kota sekolah" required />

                    <flux:input name="website" label="Website" placeholder="https://example.com" />

                    <div class="flex">
                        <flux:spacer />
                        <flux:button type="submit" variant="primary">
                            Simpan
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:modal>

        <flux:modal name="edit-sekolah" class="md:w-96">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_sekolah" id="edit_id_sekolah">

                <div class="space-y-4">

                    <flux:heading size="lg">Edit Sekolah</flux:heading>

                    <flux:input name="nama_sekolah" label="Nama Sekolah" id="edit_nama_sekolah" required />

                    <flux:input name="alamat_sekolah" label="Alamat" id="edit_alamat" required />

                    <flux:input name="website" label="Website" id="edit_website" />

                    <div class="flex">
                        <flux:spacer />
                        <flux:button type="submit" variant="primary">
                            Update
                        </flux:button>
                    </div>

                </div>
            </form>
        </flux:modal>
        <flux:modal.trigger name="edit-sekolah" id="edit-sekolah-trigger" style="display:none;">
        </flux:modal.trigger>
        <flux:modal.trigger name="tambah-sekolah" id="tambah-sekolah-trigger" style="display:none;">
        </flux:modal.trigger>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                {{-- 🔥 RIBBON HEADER (STATS) --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 
                bg-gradient-to-r from-indigo-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 
                p-4 rounded-xl">

                    {{-- TITLE --}}
                    <div>
                        <h3 class="font-semibold text-lg">Management Sekolah</h3>
                        <p class="text-xs text-gray-500">Monitoring semua sekolah dalam satu tempat</p>
                    </div>

                    {{-- STATS --}}
                    <div class="flex gap-3 text-sm">

                        <div>
                            <p class="text-gray-500">Total</p>
                            <p class="font-bold text-indigo-600 text-lg">
                                {{ $sekolahs->count() }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Aktif</p>
                            <p class="font-bold text-green-600 text-lg">
                                {{ $sekolahs->where('is_active', 1)->count() }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Non Aktif</p>
                            <p class="font-bold text-red-600 text-lg">
                                {{ $sekolahs->where('is_active', 0)->count() }}
                            </p>
                        </div>

                    </div>

                </div>
                {{-- 🔍 SEARCH + BUTTON --}}
                <div class="flex flex-col md:flex-row md:justify-between gap-4 mt-4">

                    <input type="text" placeholder="Cari sekolah..." readonly
                        class="cursor-not-allowed w-full md:w-1/3 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">

                    <button onclick="tambahSekolah()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        + Tambah Sekolah
                    </button>

                </div>


                {{-- Table Sekolah --}}
                <div class="overflow-x-auto mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                        @foreach ($sekolahs as $item)
                                                <div
                                                    class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow p-5 
                                                                        hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col">

                                                    {{-- 🔥 HEADER --}}
                                                    <div class="flex justify-between items-start mb-3">
                                                        <div>
                                                            <h3 class="text-lg font-semibold group-hover:text-indigo-600 transition">
                                                                {{ $item->nama_sekolah }}
                                                            </h3>
                                                            <p class="text-xs text-gray-400">
                                                                {{ $item->alamat_sekolah }}
                                                            </p>
                                                        </div>

                                                        <div>
                                                            @if ($item->is_active)
                                                                <span class="flex items-center gap-1 text-green-500 text-xs font-medium">
                                                                    ● Aktif
                                                                </span>
                                                            @else
                                                                <span class="flex items-center gap-1 text-red-500 text-xs font-medium">
                                                                    ● Offline
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- 🔥 MINI STATS --}}
                                                    <div class="grid grid-cols-3 gap-3 my-4 text-center">

                                                        <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                                            <p class="text-xs text-gray-400">User</p>
                                                            <p class="font-bold">{{ $item->users_count ?? 0 }}</p>
                                                        </div>

                                                        <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                                            <p class="text-xs text-gray-400">Transaksi</p>
                                                            <p class="font-bold">{{ $item->transaksi_count ?? 0 }}</p>
                                                        </div>

                                                        <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                                            <p class="text-xs text-gray-400">Hari Ini</p>
                                                            <p class="font-bold">{{ $item->today_transaksi ?? 0 }}</p>
                                                        </div>

                                                    </div>

                                                    {{-- 🌐 WEBSITE --}}
                                                    <div class="text-xs text-gray-500 mb-4 truncate">
                                                        @if ($item->website)
                                                            🌐 {{ $item->website }}
                                                        @else
                                                            Tidak ada website
                                                        @endif
                                                    </div>

                                                    {{-- 🔥 ACTION --}}
                                                    <div class="mt-auto flex justify-between items-center">

                                                        <div class="flex gap-2">

                                                            {{-- EDIT --}}
                                                            <button onclick="editSekolah(this)" data-sekolah='@json($item)'
                                                                class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                                                Edit
                                                            </button>

                                                            {{-- STATUS --}}
                                                            <form action="{{ route('super-admin.sekolah.status', $item->id_sekolah) }}"
                                                                method="POST" class="form-toggle">
                                                                @csrf
                                                                @method('PUT')

                                                                <input type="hidden" name="is_active" value="{{ $item->is_active ? 0 : 1 }}">

                                                                <button class="px-3 py-1 text-xs text-white rounded
                                                                                {{ $item->is_active ? 'bg-red-600' : 'bg-green-600' }}">
                                                                    {{ $item->is_active ? 'Off' : 'On' }}
                                                                </button>
                                                            </form>

                                                        </div>

                                                        {{-- 🔥 CTA UTAMA --}}
                                                        <a href="{{ route('super-admin.pantau', $item->id_sekolah) }}"
                                                            class="px-4 py-1 text-xs bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                            👁 Pantau
                                                        </a>

                                                    </div>


                                                    {{-- 🔥 HOVER OVERLAY --}}
                                                    <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition
                            bg-gradient-to-br from-indigo-500/5 to-transparent pointer-events-none"></div>


                                                </div>


                        @endforeach

                    </div>
                </div>

            </div>

        </div>
    </div>
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                if (window.Flux && window.Flux.showModal) {
                    window.Flux.showModal('tambah-sekolah');
                } else {
                    document.getElementById('tambah-sekolah-trigger').click();
                }
            });
        </script>
    @endif
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function tambahSekolah() {
                if (window.Flux && window.Flux.showModal) {
                    window.Flux.showModal('tambah-sekolah');
                } else {
                    document.getElementById('tambah-sekolah-trigger').click();
                }
            }

            function editSekolah(button) {
                const data = JSON.parse(button.getAttribute('data-sekolah'));

                document.getElementById('edit_id_sekolah').value = data.id_sekolah;
                document.getElementById('edit_nama_sekolah').value = data.nama_sekolah;
                document.getElementById('edit_alamat').value = data.alamat_sekolah;
                document.getElementById('edit_website').value = data.website ?? '';

                document.getElementById('editForm').action =
                    "{{ route('super-admin.sekolah.update', ':id') }}".replace(':id', data.id_sekolah);

                if (window.Flux && window.Flux.showModal) {
                    window.Flux.showModal('edit-sekolah');
                } else {
                    document.getElementById('edit-sekolah-trigger').click();
                }
            }

            // Tambahkan konfirmasi SweetAlert untuk toggle active
            document.querySelectorAll('form.inline').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // hentikan submit default
                    const isActiveInput = this.querySelector('input[name="is_active"]');
                    const actionText = isActiveInput.value == 1 ? 'Activate' : 'Deactivate';

                    Swal.fire({
                        title: `Apakah Anda yakin ingin ${actionText} sekolah ini?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // submit form jika user konfirmasi
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>