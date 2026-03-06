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

                {{-- Header Action --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                    {{-- Search --}}
                    <div class="w-full md:w-1/3">
                        <input type="text" placeholder="Cari sekolah..."
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Button Tambah --}}
                    <button type="button" onclick="tambahSekolah()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        + Tambah Sekolah
                    </button>
                </div>

                {{-- Card Statistik --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-indigo-50 dark:bg-gray-700 p-4 rounded-xl shadow">
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Total Sekolah</p>
                        <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $sekolahs->count() }}
                        </h3>
                    </div>

                    <div class="bg-green-50 dark:bg-gray-700 p-4 rounded-xl shadow">
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Sekolah Aktif</p>
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $sekolahs->where('is_active', '1')->count() }}</h3>
                    </div>

                    <div class="bg-red-50 dark:bg-gray-700 p-4 rounded-xl shadow">
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Non Aktif</p>
                        <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $sekolahs->where('is_active', '0')->count() }}</h3>
                    </div>
                </div>

                {{-- Table Sekolah --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Nama Sekolah</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Alamat</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Website</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            {{-- Contoh Data --}}
                            @foreach ($sekolahs as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $item->nama_sekolah }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $item->alamat_sekolah }}</td>
                                    <td class="px-4 py-2 ">
                                        @if ($item->website)
                                            <a href="{{ Str::startsWith($item->website, ['http://', 'https://']) ? $item->website : 'https://' . $item->website }}"
                                                target="_blank" class="text-indigo-600 hover:underline">
                                                {{ $item->website }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-medium">
                                        @if ($item->is_active == 1)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                                                Non Active
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 text-center space-x-2 gap-2 flex justify-center">

                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm transition"
                                            data-sekolah='@json($item)' onclick="editSekolah(this)">
                                            Edit
                                        </button>

                                        {{-- Toggle Active --}}
                                        <form action="{{ route('super-admin.sekolah.status', $item->id_sekolah) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PUT')

                                            @if ($item->is_active == 1)
                                                <input type="hidden" name="is_active" value="0">
                                                <button
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm transition">
                                                    Deactivate
                                                </button>
                                            @else
                                                <input type="hidden" name="is_active" value="1">
                                                <button
                                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm transition">
                                                    Activate
                                                </button>
                                            @endif
                                        </form>

                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
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
                form.addEventListener('submit', function(e) {
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
