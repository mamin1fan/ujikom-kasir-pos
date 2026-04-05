<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Dashboard Admin POS</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pantau performa toko Anda hari ini</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- ── KPI CARDS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded-full">SKU</span>
                </div>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalBarang }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Barang</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M16 5l3 3m0 0l-8 8-4 1 1-4 8-8z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">In</span>
                </div>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totalPenjualan }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Penjualan</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-rose-100 dark:bg-rose-900/50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/30 px-2 py-0.5 rounded-full">Out</span>
                </div>
                <p class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $totalPembelian }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Pembelian</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2 py-0.5 rounded-full">Member</span>
                </div>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalPelanggan }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Pelanggan</p>
            </div>

        </div>

        {{-- ── ROW 2: Grafik + Stok ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Grafik Penjualan --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Grafik Penjualan Bulanan</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-full">{{ now()->year }}</span>
                </div>
                <div class="p-5">
                    @php
                        $chartData = [
                            ['Jan',40],['Feb',65],['Mar',50],['Apr',80],
                            ['Mei',72],['Jun',90],['Jul',60],['Agu',75],
                            ['Sep',88],['Okt',55],['Nov',70],['Des',95],
                        ];
                        $maxVal = 95;
                    @endphp
                    <div class="flex items-end gap-1.5 h-40">
                        @foreach($chartData as $i => $bar)
                            <div class="flex-1 flex flex-col items-center gap-1.5">
                                <div class="w-full rounded-t-md transition-all duration-700
                                    {{ request()->is('*') ? ($i % 2 === 0 ? 'bg-indigo-500 dark:bg-indigo-400' : 'bg-indigo-300 dark:bg-indigo-600') : 'bg-indigo-500' }}
                                    hover:opacity-80 cursor-pointer"
                                    style="height:{{ round(($bar[1]/$maxVal)*136) }}px"></div>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $bar[0] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Stok Menipis --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Stok Menipis</h3>
                    <span class="text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/30 px-2.5 py-1 rounded-full">Perlu restock</span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php
                        $stokItems = [
                            ['Pensil 2B HB', 12, 50],
                            ['Buku Tulis 58', 8, 50],
                            ['Penghapus', 20, 50],
                            ['Spidol Hitam', 5, 50],
                            ['Pulpen Pilot', 15, 50],
                        ];
                    @endphp
                    @foreach($stokItems as $s)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-rose-500 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">{{ $s[0] }}</p>
                                <div class="mt-1 h-1 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $s[1] <= 10 ? 'bg-rose-500' : 'bg-amber-400' }}"
                                        style="width:{{ ($s[1]/$s[2])*100 }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-bold {{ $s[1] <= 10 ? 'text-rose-500 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400' }} flex-shrink-0">
                                {{ $s[1] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ── Transaksi Terbaru ── --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Transaksi Terbaru</h3>
                <a href="{{ route('admin.transaksi.pembelian.index') }}"
                    class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Lihat semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/40">
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">ID Transaksi</th>
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Pelanggan</th>
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Items</th>
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Total</th>
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Tanggal</th>
                            <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentTransactions ?? [] as $trx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-5 py-3 font-mono text-xs text-indigo-600 dark:text-indigo-400">{{ $trx->id_transaksi }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">{{ $trx->pelanggan?->nama ?? 'Umum' }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $trx->items_count ?? '-' }}</td>
                                <td class="px-4 py-3 font-semibold text-amber-600 dark:text-amber-400">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-500 text-xs">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M H:i') }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        @empty
                            {{-- Skeleton rows --}}
                            @for($i = 0; $i < 5; $i++)
                                <tr class="animate-pulse">
                                    @for($j = 0; $j < 6; $j++)
                                        <td class="px-4 py-4"><div class="h-3 bg-gray-100 dark:bg-gray-700 rounded w-3/4"></div></td>
                                    @endfor
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>