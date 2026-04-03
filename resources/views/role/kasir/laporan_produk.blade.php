<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Produk
            </h2>
            <div class="flex gap-2">
                <form method="GET" action="{{ route('kasir.laporan.produk') }}" class="flex gap-2">
                    <select name="periode" onchange="this.form.submit()"
                        class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="today" {{ $periode == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ $periode == 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="month" {{ $periode == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="all" {{ $periode == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                    </select>
                </form>
                <a href="{{ route('kasir.laporan.produk.export') }}?periode={{ $periode }}"
                    class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- KPI SUMMARY --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProduk }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500 mb-1">Total Terjual</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalTerjual, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500 mb-1">Total Stok Tersisa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalStok, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500 mb-1">Barang Hampir Habis</p>
                    <p class="text-2xl font-bold {{ $hampirHabisCount > 0 ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $hampirHabisCount }}
                    </p>
                </div>
            </div>

            {{-- TOP & BOTTOM PRODUK --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 🔥 PRODUK PALING LARIS --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <span class="text-orange-500">🔥</span> Produk Paling Laris
                    </h3>
                    @forelse ($produkLaris as $i => $item)
                        @php
                            $maxQty = $produkLaris->first()->total_terjual ?? 1;
                            $pct = $maxQty > 0 ? ($item->total_terjual / $maxQty) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-3 mb-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded bg-green-100 text-green-800 text-xs font-bold flex items-center justify-center">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->barang->nama }}</p>
                                <div class="mt-1 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-400 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-semibold text-gray-700">{{ number_format($item->total_terjual, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">terjual</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data penjualan</p>
                    @endforelse
                </div>

                {{-- PRODUK PALING SEDIKIT TERJUAL --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <span class="text-blue-400">📉</span> Produk Paling Sedikit Terjual
                    </h3>
                    @forelse ($produkSepi as $i => $item)
                        @php
                            $maxQty2 = $produkLaris->first()->total_terjual ?? 1;
                            $pct2 = $maxQty2 > 0 ? ($item->total_terjual / $maxQty2) * 100 : 2;
                        @endphp
                        <div class="flex items-center gap-3 mb-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded bg-red-100 text-red-800 text-xs font-bold flex items-center justify-center">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->barang->nama }}</p>
                                <div class="mt-1 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-300 rounded-full" style="width: max({{ $pct2 }}%, 3%)"></div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-semibold text-gray-700">{{ number_format($item->total_terjual, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">terjual</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data penjualan</p>
                    @endforelse
                </div>

            </div>

            {{-- BARANG HAMPIR HABIS --}}
            @if ($hampirHabis->count() > 0)
            <div class="bg-white shadow rounded-xl p-6 border border-red-100">
                <h3 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="text-red-500">⚠️</span> Barang Hampir Habis
                    <span class="ml-auto text-xs bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full font-medium">
                        Stok &lt; {{ $batasHampirHabis }}
                    </span>
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">Produk</th>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-right">Harga</th>
                                <th class="px-4 py-2 text-right">Stok</th>
                                <th class="px-4 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hampirHabis as $i => $produk)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $produk->nama }}</td>
                                    <td class="px-4 py-2 text-gray-500">{{ $produk->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right text-gray-700">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-right font-bold
                                        {{ $produk->stok <= 3 ? 'text-red-600' : 'text-orange-500' }}">
                                        {{ $produk->stok }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($produk->stok <= 3)
                                            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">Kritis</span>
                                        @else
                                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-medium">Hampir Habis</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- SEMUA STOK PRODUK --}}
            <div class="bg-white shadow rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-700">📦 Stok Semua Produk</h3>
                    <input type="text" id="searchProduk" placeholder="Cari produk..."
                        class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 w-48">
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" id="tabelStok">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">Produk</th>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-right">Harga Jual</th>
                                <th class="px-4 py-2 text-right">Terjual</th>
                                <th class="px-4 py-2 text-right">Stok</th>
                                <th class="px-4 py-2 text-center">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($semuaProduk as $i => $produk)
                                <tr class="border-t hover:bg-gray-50 transition produk-row">
                                    <td class="px-4 py-2 text-gray-400">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 font-medium text-gray-800 produk-nama">{{ $produk->nama }}</td>
                                    <td class="px-4 py-2 text-gray-500">{{ $produk->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right text-gray-700">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-gray-700">
                                        {{ number_format($produk->total_terjual ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-right font-semibold
                                        {{ $produk->stok <= 3 ? 'text-red-600' : ($produk->stok <= $batasHampirHabis ? 'text-orange-500' : 'text-gray-800') }}">
                                        {{ $produk->stok }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($produk->stok <= 0)
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">Habis</span>
                                        @elseif ($produk->stok <= 3)
                                            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Kritis</span>
                                        @elseif ($produk->stok <= $batasHampirHabis)
                                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">Hampir Habis</span>
                                        @else
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aman</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-gray-400">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('searchProduk').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.produk-row').forEach(row => {
                const nama = row.querySelector('.produk-nama').textContent.toLowerCase();
                row.style.display = nama.includes(q) ? '' : 'none';
            });
        });
    </script>
    @endpush
</x-app-layout> 