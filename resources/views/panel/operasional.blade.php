{{-- resources/views/super-admin/operasional/dashboard.blade.php --}}
<x-app-layout>

    {{-- School Info Bar --}}
    <div class="bg-green-50 dark:bg-green-950 border-b border-green-200 dark:border-green-800 px-6 py-3 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-green-200 dark:bg-green-800 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-800 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-green-900 dark:text-green-100">{{ session('sekolah_nama') }}</p>
            <p class="text-xs text-green-700 dark:text-green-400">
                {{ session('sekolah_alamat') }} · NPSN {{ session('sekolah_npsn') }} · {{ session('sekolah_kota') }}
            </p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <span class="text-xs text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-900 border border-teal-200 dark:border-teal-700 rounded-full px-3 py-1">
                Sesi Aktif
            </span>
            <span class="text-xs text-green-700 dark:text-green-400" id="jam-live"></span>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1"/></svg>
                        Pendapatan Hari Ini
                    </p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Rp {{ number_format($data['pendapatanHariIni'], 0, ',', '.') }}
                    </p>
                    <p class="text-xs mt-1 {{ $data['deltaPendapatan'] >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $data['deltaPendapatan'] >= 0 ? '▲' : '▼' }} {{ abs($data['deltaPendapatan']) }}% vs kemarin
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mb-2">
                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        Transaksi Hari Ini
                    </p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $data['transaksiHariIni'] }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">+{{ $data['deltaTransaksi'] }} dari kemarin</p>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mb-2">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                        Total Stok Barang
                    </p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($data['totalStok'], 0, ',', '.') }}</p>
                    <p class="text-xs text-red-500 mt-1">{{ $data['stokTipis'] }} barang stok tipis</p>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mb-2">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        Pembelian Hari Ini
                    </p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Rp {{ number_format($data['pembelianHariIni'], 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $data['jumlahPO'] }} PO masuk</p>
                </div>

            </div>

            {{-- TRANSAKSI + AKSES CEPAT --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

                {{-- Transaksi Terakhir --}}
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Transaksi Terakhir</p>
                            <p class="text-xs text-gray-400">Hari ini · {{ session('sekolah_nama') }}</p>
                        </div>
                        <span class="text-xs bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300 px-2.5 py-1 rounded-full">
                            {{ $data['transaksiHariIni'] }} transaksi
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase">No.</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase">Pelanggan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase">Waktu</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($data['transaksiTerakhir'] as $data['trx'])
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-2 font-mono text-xs text-gray-400">#{{ $data['trx']->no_transaksi }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $data['trx']->pelanggan->nama ?? 'Umum' }}</td>
                                    <td class="px-4 py-2 text-xs text-gray-500">{{ $data['trx']->created_at->format('H:i') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">Rp {{ number_format($data['trx']->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="text-xs bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300 px-2 py-0.5 rounded-full">Lunas</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-400">Belum ada transaksi hari ini</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Akses Cepat --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Akses Cepat</p>
                    </div>
                    <div class="grid grid-cols-3 gap-2 p-3">
                        @php
                        $data['menus'] = [
                            ['href' => route('kasir.dashboard'),                   'label' => 'Buka Kasir',    'bg' => 'bg-indigo-50 dark:bg-indigo-950', 'icon_color' => 'text-indigo-600', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['href' => route('admin.barang.index'),                 'label' => 'Data Barang',   'bg' => 'bg-amber-50 dark:bg-amber-950',   'icon_color' => 'text-amber-600',  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['href' => route('admin.transaksi.pembelian.index'),    'label' => 'Pembelian',     'bg' => 'bg-teal-50 dark:bg-teal-950',     'icon_color' => 'text-teal-600',   'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1'],
                            ['href' => route('kasir.rekap.harian'),                 'label' => 'Rekap Harian',  'bg' => 'bg-green-50 dark:bg-green-950',   'icon_color' => 'text-green-600',  'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['href' => route('kasir.cetak.struk'),                  'label' => 'Cetak Struk',   'bg' => 'bg-blue-50 dark:bg-blue-950',     'icon_color' => 'text-blue-600',   'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['href' => route('admin.kategori.index'),               'label' => 'Kategori',      'bg' => 'bg-gray-100 dark:bg-gray-700',    'icon_color' => 'text-gray-500',   'icon' => 'M7 7h10M7 12h10M7 17h10'],
                        ];
                        @endphp
                        @foreach ($data['menus'] as $data['menu'])
                        <a href="{{ $data['menu']['href'] }}"
                           class="flex flex-col items-center gap-1.5 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div class="w-8 h-8 rounded-lg {{ $data['menu']['bg'] }} flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 {{ $data['menu']['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['menu']['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 text-center leading-tight">{{ $data['menu']['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- PRODUK TERLARIS + STOK TIPIS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Produk Terlaris</p>
                        <span class="text-xs text-gray-400">Hari ini</span>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($data['produkTerlaris'] as $data['i'] => $data['produk'])
                        <div class="flex items-center gap-3 px-4 py-2.5">
                            <span class="text-xs text-gray-400 w-4 text-center">{{ $data['i'] + 1 }}</span>
                            <span class="flex-1 text-sm text-gray-800 dark:text-gray-200 truncate">{{ $data['produk']->nama }}</span>
                            <div class="w-16 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-indigo-400" style="width: {{ $data['produk']->pct }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 w-12 text-right">{{ $data['produk']->terjual }} pcs</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Stok Menipis</p>
                        <span class="text-xs bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300 px-2.5 py-0.5 rounded-full">{{ $data['stokTipis'] }} item</span>
                    </div>
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Barang</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Stok</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($data['barangStokTipis'] as $data['item'])
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $data['item']->nama }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $data['item']->stok }} pcs</td>
                                <td class="px-4 py-2">
                                    @if($data['item']->stok == 0)
                                        <span class="text-xs bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300 px-2 py-0.5 rounded-full">Habis</span>
                                    @else
                                        <span class="text-xs bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300 px-2 py-0.5 rounded-full">Tipis</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- EXIT BAR --}}
            <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-lg px-4 py-3 flex items-center justify-between">
                <p class="text-sm text-red-700 dark:text-red-300 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Sedang beroperasi di konteks <strong class="font-medium">{{ session('sekolah_nama') }}</strong>. Data yang ditampilkan khusus sekolah ini.
                </p>
                <form method="POST" action="{{ route('super-admin.keluar-mode') }}" class="flex-shrink-0 ml-4">
                    @csrf
                    <button type="submit"
                        class="text-sm text-red-700 dark:text-red-300 border border-red-300 dark:border-red-700 rounded-lg px-3 py-1.5 hover:bg-red-100 dark:hover:bg-red-900 transition">
                        Keluar Mode
                    </button>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function tickJam() {
            const el = document.getElementById('jam-live');
            if (el) el.textContent = new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
        }
        tickJam();
        setInterval(tickJam, 1000);
    </script>
    @endpush

</x-app-layout>