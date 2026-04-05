{{-- resources/views/super-admin/restore/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Restore Data
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola data terhapus · Soft delete manager</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- DANGER BANNER --}}
            <div class="flex items-start gap-3 bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <p class="text-sm text-red-700 dark:text-red-300">
                    Halaman ini mengelola <strong class="font-medium">data terhapus (soft delete)</strong>.
                    Aksi <strong class="font-medium">Hapus Permanen</strong> bersifat irreversible —
                    data beserta seluruh relasinya (transaksi, laporan, detail) akan hilang selamanya dari database.
                </p>
            </div>

            {{-- TABS --}}
            @php $type = request()->segment(3); @endphp
            <div class="flex gap-1.5 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl w-fit flex-wrap">
                @foreach ([
                    'barang'    => 'Barang',
                    'kategori'  => 'Kategori',
                    'pelanggan' => 'Pelanggan',
                    'pembelian' => 'Pembelian',
                    'penjualan' => 'Penjualan',
                    'supplier'  => 'Supplier',
                ] as $key => $label)
                <a href="{{ route('super-admin.restore.'.$key) }}"
                   class="px-4 py-2 rounded-lg text-sm transition
                       {{ $type === $key
                           ? 'bg-white dark:bg-gray-900 font-medium text-gray-900 dark:text-gray-100 shadow-sm border border-gray-200 dark:border-gray-700'
                           : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">

                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $type }} terhapus</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $data->total() }} item · Restore untuk mengembalikan, atau Hapus Permanen untuk menghapus selamanya</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider w-2/5">Nama / ID</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Dihapus pada</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($data as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-5 py-3">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{ $item->{$displayName} ?? $item->name ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5 font-mono">ID: {{ $item->{$keyName} }}</p>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $item->deleted_at->translatedFormat('d M Y, H:i') }}
                                    <div class="text-gray-400 mt-0.5">{{ $item->deleted_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1.5 text-xs bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-full px-2.5 py-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
                                        Terhapus
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- RESTORE --}}
                                        <form method="POST" action="{{ route('super-admin.restore.restore', [$type, $item->{$keyName}]) }}">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300 border border-green-200 dark:border-green-800 hover:bg-green-100 dark:hover:bg-green-900 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9"/>
                                                </svg>
                                                Restore
                                            </button>
                                        </form>

                                        {{-- FORCE DELETE --}}
                                        <button type="button"
                                            onclick="showDeleteModal(
                                                '{{ addslashes($item->{$displayName} ?? $item->name ?? '-') }}',
                                                '{{ $type }}',
                                                '{{ $item->{$keyName} }}',
                                                '{{ route('super-admin.restore.forceDelete', [$type, $item->{$keyName}]) }}'
                                            )"
                                            class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300 border border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Permanen
                                        </button>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center">
                                    <div class="flex flex-direction-column items-center justify-center gap-2 text-gray-400">
                                        <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-sm">Tidak ada data terhapus di kategori ini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $data->links() }}
                </div>

            </div>

        </div>
    </div>

    {{-- FORCE DELETE MODAL --}}
    <div id="fd-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 w-full max-w-md mx-4 overflow-hidden">

            {{-- Header merah --}}
            <div class="bg-red-50 dark:bg-red-950 border-b border-red-200 dark:border-red-800 px-5 py-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-red-200 dark:bg-red-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-800 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-red-800 dark:text-red-200">Hapus Permanen — Tidak Dapat Dibatalkan</p>
                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">Data akan dihapus dari database selamanya</p>
                </div>
            </div>

            <div class="p-5 space-y-4">

                {{-- Item info --}}
                <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-xl p-3.5">
                    <p class="text-xs text-red-500 dark:text-red-400 mb-1">Data yang akan dihapus</p>
                    <p class="text-sm font-medium text-red-900 dark:text-red-100" id="fd-name">—</p>
                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5" id="fd-meta">—</p>
                </div>

                {{-- Warning relasi --}}
                <div class="bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 rounded-xl p-3.5">
                    <p class="text-xs font-medium text-amber-800 dark:text-amber-200 mb-2.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Data berelasi yang ikut terhapus:
                    </p>
                    <ul class="space-y-1.5" id="fd-relations">
                        {{-- diisi JS sesuai tipe --}}
                    </ul>
                </div>

                {{-- Konfirmasi ketik --}}
                <div class="space-y-1.5">
                    <p class="text-xs text-red-600 dark:text-red-400">
                        Ketik <code class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-1.5 py-0.5 rounded font-mono font-medium">HAPUS</code> untuk mengaktifkan tombol
                    </p>
                    <input type="text" id="fd-input" autocomplete="off"
                        placeholder="Ketik HAPUS di sini..."
                        oninput="fdCheckInput(this)"
                        class="w-full px-3 py-2.5 border border-red-200 dark:border-red-700 rounded-lg text-sm bg-red-50 dark:bg-red-950 text-red-900 dark:text-red-100 placeholder-red-300 font-mono focus:outline-none focus:ring-2 focus:ring-red-300 dark:focus:ring-red-700 transition">
                </div>

                {{-- Timer bar --}}
                <div>
                    <div class="w-full bg-red-100 dark:bg-red-900 rounded-full h-1.5 overflow-hidden">
                        <div id="fd-timer-bar" class="h-full bg-red-400 dark:bg-red-500 rounded-full transition-all duration-100"></div>
                    </div>
                    <p class="text-xs text-red-500 dark:text-red-400 text-right mt-1" id="fd-timer-label">Tunggu 5 detik...</p>
                </div>

            </div>

            <div class="px-5 py-3.5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex gap-2 justify-end">
                <button onclick="fdClose()" type="button"
                    class="px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Batal
                </button>
                <form id="fd-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="fd-btn" disabled
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition
                            bg-red-500 text-white border border-red-500
                            disabled:opacity-40 disabled:cursor-not-allowed
                            enabled:hover:bg-red-700 enabled:hover:border-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span id="fd-btn-text">Tunggu timer...</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        Swal.fire({ icon:'success', title:'Berhasil!', text:"{{ session('success') }}", timer:2000, showConfirmButton:false });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({ icon:'error', title:'Gagal!', text:"{{ session('error') }}" });
    </script>
    @endif

    <script>
    const TIMER_SEC = 5;
    const KEYWORD   = 'HAPUS';
    const RELATIONS = {
        barang:    ['Semua detail transaksi penjualan yang memuat item ini','Semua detail pembelian terkait item ini','Laporan stok yang merujuk item ini'],
        kategori:  ['Semua barang dalam kategori ini (jika ada)','Kelompok kategori terkait'],
        pelanggan: ['Riwayat seluruh transaksi penjualan pelanggan ini','Data piutang terkait'],
        pembelian: ['Semua detail item dalam pembelian ini','Jurnal atau catatan keuangan terkait'],
        penjualan: ['Semua detail item dalam transaksi ini','Struk/nota yang sudah dicetak','Data rekap harian terkait'],
        supplier:  ['Riwayat pembelian dari supplier ini','Kontak dan data dokumen supplier'],
    };

    let fdTimerInterval = null;
    let fdTimerDone = false;
    let fdInputOk   = false;

    function showDeleteModal(name, type, id, action) {
        document.getElementById('fd-name').textContent = name + ' (ID: ' + id + ')';
        document.getElementById('fd-meta').textContent = 'Jenis: ' + type.charAt(0).toUpperCase() + type.slice(1);
        document.getElementById('fd-form').action = action;
        document.getElementById('fd-input').value = '';
        document.getElementById('fd-input').classList.remove('border-green-400','bg-green-50','dark:bg-green-950','dark:border-green-700');

        const rel = RELATIONS[type] || [];
        document.getElementById('fd-relations').innerHTML = rel.map(r =>
            `<li class="flex items-start gap-2 text-xs text-amber-700 dark:text-amber-300">
                <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>${r}</li>`
        ).join('');

        document.getElementById('fd-overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        fdTimerDone = false; fdInputOk = false;
        fdUpdateBtn();
        fdStartTimer();
    }

    function fdClose() {
        document.getElementById('fd-overlay').classList.add('hidden');
        document.body.style.overflow = '';
        clearInterval(fdTimerInterval);
    }

    function fdStartTimer() {
        clearInterval(fdTimerInterval);
        let rem = TIMER_SEC;
        const bar = document.getElementById('fd-timer-bar');
        const lbl = document.getElementById('fd-timer-label');
        bar.style.width = '100%';
        bar.className = 'h-full bg-red-400 dark:bg-red-500 rounded-full transition-all duration-100';
        lbl.textContent = 'Tunggu ' + rem + ' detik...';

        fdTimerInterval = setInterval(() => {
            rem--;
            bar.style.width = Math.round((rem / TIMER_SEC) * 100) + '%';
            if (rem <= 0) {
                clearInterval(fdTimerInterval);
                fdTimerDone = true;
                bar.style.width = '100%';
                bar.className = 'h-full bg-green-500 rounded-full transition-all duration-100';
                lbl.textContent = 'Siap — ketik kata kunci untuk mengaktifkan tombol';
                lbl.className = 'text-xs text-green-600 dark:text-green-400 text-right mt-1';
                fdUpdateBtn();
            } else {
                lbl.textContent = 'Tunggu ' + rem + ' detik...';
            }
        }, 1000);
    }

    function fdCheckInput(input) {
        fdInputOk = input.value.trim() === KEYWORD;
        if (fdInputOk) {
            input.classList.add('border-green-400','bg-green-50','dark:bg-green-950','dark:border-green-700');
        } else {
            input.classList.remove('border-green-400','bg-green-50','dark:bg-green-950','dark:border-green-700');
        }
        fdUpdateBtn();
    }

    function fdUpdateBtn() {
        const btn  = document.getElementById('fd-btn');
        const txt  = document.getElementById('fd-btn-text');
        const ready = fdTimerDone && fdInputOk;
        btn.disabled = !ready;
        if (!fdTimerDone)       txt.textContent = 'Tunggu timer...';
        else if (!fdInputOk)    txt.textContent = 'Ketik kata kunci dulu';
        else                    txt.textContent = 'Ya, Hapus Permanen Sekarang';
    }

    document.getElementById('fd-overlay').addEventListener('click', function(e) {
        if (e.target === this) fdClose();
    });
    </script>
    @endpush
</x-app-layout>