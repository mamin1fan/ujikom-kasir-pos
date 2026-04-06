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


                {{-- Table Sekolah (UI yang sudah di-upgrade total) --}}
<div class="overflow-x-auto mt-4">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($sekolahs as $item)
                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden border border-gray-100 dark:border-gray-700">

                    {{-- Top accent + Header --}}
                    <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                        {{-- School Avatar + Name --}}
                        <div class="flex items-center gap-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-xl font-semibold rounded-2xl flex-shrink-0 shadow-inner">
                                {{ strtoupper(substr($item->nama_sekolah, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                    {{ $item->nama_sekolah }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                                    {{ $item->alamat_sekolah }}
                                </p>
                            </div>
                        </div>

                        {{-- Status Badge (super clean) --}}
                        @if ($item->is_active)
                            <span class="inline-flex items-center gap-x-1.5 px-3 py-1 rounded-3xl text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-3xl text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400">
                                Tidak Aktif
                            </span>
                        @endif
                    </div>

                    {{-- Mini Stats (modern & clean) --}}
                    <div class="px-6 py-5 grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="text-center">
                            <div class="flex items-center justify-center mx-auto w-8 h-8 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-2xl mb-2">
                                <!-- User Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 01-5.356-1.857M12 20v-2a3 3 0 00-3-3H6a3 3 0 00-3 3v2m-6-2a3 3 0 013-3m0 0a3 3 0 013-3" />
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">User</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white mt-0.5">{{ $item->users_count ?? 0 }}</p>
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center mx-auto w-8 h-8 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl mb-2">
                                <!-- Transaksi Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3" />
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Transaksi</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white mt-0.5">{{ $item->transaksi_count ?? 0 }}</p>
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center mx-auto w-8 h-8 bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 rounded-2xl mb-2">
                                <!-- Hari Ini Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2" />
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Hari Ini</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white mt-0.5">{{ $item->today_transaksi ?? 0 }}</p>
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="px-6 py-4 text-sm">
                        @if ($item->website)
                            <a href="{{ $item->website }}" target="_blank" 
                               class="flex items-center gap-x-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 4.01V8" />
                                </svg>
                                <span class="truncate">{{ $item->website }}</span>
                            </a>
                        @else
                            <span class="flex items-center gap-x-2 text-gray-400 dark:text-gray-500 text-sm italic">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 4.01V8" />
                                </svg>
                                Belum ada website
                            </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto px-6 py-5 bg-gray-50 dark:bg-gray-900 flex items-center justify-between border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-x-2">
                            {{-- Edit --}}
                            <button onclick="editSekolah(this)" 
                                    data-sekolah='@json($item)'
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 rounded-2xl transition-colors flex items-center gap-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </button>

                            {{-- Toggle Status --}}
                            <form action="{{ route('super-admin.sekolah.status', $item->id_sekolah) }}" method="POST" class="form-toggle">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{ $item->is_active ? 0 : 1 }}">
                                <button type="submit"
                                        class="px-5 py-2.5 text-sm font-medium rounded-2xl transition-colors
                                        {{ $item->is_active
            ? 'bg-red-500 hover:bg-red-600 text-white'
            : 'bg-emerald-500 hover:bg-emerald-600 text-white' }}">
                                    {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>

                        {{-- Pantau Button (premium look) --}}
                        <a href="{{ route('super-admin.pantau', $item->id_sekolah) }}"
                           class="inline-flex items-center gap-x-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-3xl transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 16.477 5 20.268 7.943 21.542 12 20.268 16.057 16.477 19 12 19 7.523 19 3.732 16.057 2.458 12z" />
                            </svg>
                            Pantau
                        </a>
                    </div>

                    {{-- Subtle hover overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 pointer-events-none transition rounded-3xl"></div>
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