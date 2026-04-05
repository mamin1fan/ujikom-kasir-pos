<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Analisis Produk & Stok</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Laporan komprehensif untuk pengambilan keputusan</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('kasir.laporan.produk') }}">
                    <select name="periode" onchange="this.form.submit()"
                        class="text-sm border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 font-medium">
                        <option value="today"  {{ $periode == 'today'  ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week"   {{ $periode == 'week'   ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="month"  {{ $periode == 'month'  ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="all"    {{ $periode == 'all'    ? 'selected' : '' }}>Semua Waktu</option>
                    </select>
                </form>
                <a href="{{ route('kasir.laporan.produk.export') }}?periode={{ $periode }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded-xl font-semibold flex items-center gap-2 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

        .lp { font-family: 'DM Sans', sans-serif; }

        /* ── CARDS ── */
        .lp-card {
            background: #fff; border: 1px solid #e5e7eb;
            border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .dark .lp-card { background: #1a2235; border-color: #283045; }

        /* ── STAT CARDS ── */
        .kpi-card {
            border-radius: 16px; padding: 20px;
            position: relative; overflow: hidden;
        }
        .kpi-val { font-size: 26px; font-weight: 700; line-height: 1; color: #111827; }
        .dark .kpi-val { color: #f1f5f9; }
        .kpi-label { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; }
        .kpi-sub { font-size: 11px; color: #9ca3af; margin-top: 4px; }

        /* ── TABS ── */
        .tab-bar { display: flex; gap: 2px; background: #f3f4f6; border-radius: 12px; padding: 4px; }
        .dark .tab-bar { background: #1e2a3a; }
        .tab-btn {
            flex: 1; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; background: transparent; color: #6b7280;
            transition: all .2s; white-space: nowrap; font-family: inherit;
        }
        .tab-btn.active {
            background: #fff; color: #111827;
            box-shadow: 0 1px 4px rgba(0,0,0,.1);
        }
        .dark .tab-btn { color: #6b7280; }
        .dark .tab-btn.active { background: #283045; color: #f1f5f9; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* ── RANK BARS ── */
        .rank-bar-wrap { height: 4px; background: #f3f4f6; border-radius: 4px; overflow: hidden; flex: 1; }
        .dark .rank-bar-wrap { background: #283045; }
        .rank-bar { height: 100%; border-radius: 4px; transition: width .8s cubic-bezier(.4,0,.2,1); }

        /* ── TABLE ── */
        .ana-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .ana-table thead tr { background: #f8fafc; border-bottom: 1.5px solid #e5e7eb; }
        .dark .ana-table thead tr { background: #131c2e; border-bottom-color: #283045; }
        .ana-table thead th {
            padding: 10px 14px; font-size: 11px; font-weight: 700;
            letter-spacing: .05em; text-transform: uppercase; color: #9ca3af;
            white-space: nowrap; text-align: left;
        }
        .ana-table tbody tr td {
            padding: 11px 14px; border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; background: #fff; transition: background .1s;
        }
        .dark .ana-table tbody tr td { background: #1a2235; border-bottom-color: #232f45; }
        .ana-table tbody tr:hover td { background: #f8fafc !important; }
        .dark .ana-table tbody tr:hover td { background: #1e2a3a !important; }

        /* ── STATUS PILLS ── */
        .pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .pill-habis   { background: #f1f5f9; color: #64748b; }
        .pill-kritis  { background: #fee2e2; color: #b91c1c; }
        .pill-hampir  { background: #fef3c7; color: #b45309; }
        .pill-aman    { background: #dcfce7; color: #166534; }
        .pill-laris   { background: #dbeafe; color: #1d4ed8; }
        .pill-sepi    { background: #fce7f3; color: #9d174d; }
        .dark .pill-habis  { background: #1e293b; color: #94a3b8; }
        .dark .pill-kritis { background: #450a0a; color: #f87171; }
        .dark .pill-hampir { background: #451a03; color: #fbbf24; }
        .dark .pill-aman   { background: #052e16; color: #4ade80; }
        .dark .pill-laris  { background: #1e3a5f; color: #60a5fa; }
        .dark .pill-sepi   { background: #4a044e; color: #f0abfc; }

        /* ── SORT ICON ── */
        th.sortable { cursor: pointer; user-select: none; }
        th.sortable:hover { color: #6366f1; }

        /* ── MATRIX (ABC) ── */
        .matrix-cell {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border-radius: 12px; padding: 10px; min-height: 80px; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .matrix-cell:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }

        /* ── ALERT BANNER ── */
        .alert-banner {
            border-radius: 12px; padding: 12px 16px;
            display: flex; align-items: flex-start; gap: 12px;
        }

        /* ── MINI TREND SPARKLINE ── */
        .spark { height: 28px; }

        /* ── STICKY HEADER IN TABLE ── */
        .sticky-thead thead { position: sticky; top: 0; z-index: 2; }

        /* ── HEATMAP ── */
        .heat-0 { background: #f8fafc; }
        .heat-1 { background: #dcfce7; }
        .heat-2 { background: #86efac; }
        .heat-3 { background: #4ade80; color: #fff; }
        .heat-4 { background: #16a34a; color: #fff; }
        .dark .heat-0 { background: #1a2235; }
        .dark .heat-1 { background: #052e16; }
        .dark .heat-2 { background: #14532d; }
        .dark .heat-3 { background: #15803d; color: #fff; }
        .dark .heat-4 { background: #16a34a; color: #fff; }

        /* ── INSIGHT CARDS ── */
        .insight-card {
            border-radius: 12px; padding: 14px 16px;
            border-left: 4px solid; display: flex; gap: 12px; align-items: flex-start;
        }
        .insight-card.danger  { border-color: #ef4444; background: #fff1f2; }
        .insight-card.warn    { border-color: #f59e0b; background: #fffbeb; }
        .insight-card.success { border-color: #10b981; background: #f0fdf4; }
        .insight-card.info    { border-color: #6366f1; background: #eef2ff; }
        .dark .insight-card.danger  { background: #450a0a; }
        .dark .insight-card.warn    { background: #451a03; }
        .dark .insight-card.success { background: #052e16; }
        .dark .insight-card.info    { background: #1e1b4b; }
    </style>

    @php
        $totalNilaiStok = $semuaProduk->sum(fn($p) => $p->stok * $p->harga_jual);
        $totalNilaiModal = $semuaProduk->sum(fn($p) => $p->stok * ($p->harga_beli ?? 0));
        $potensiProfit   = $totalNilaiStok - $totalNilaiModal;

        // ABC Analysis
        $totalOmzetSemua = $semuaProduk->sum('total_terjual') ?: 1;
        $sorted = $semuaProduk->sortByDesc('total_terjual')->values();
        $cumSum = 0;
        foreach ($sorted as $i => $p) {
            $cumSum += $p->total_terjual ?? 0;
            $pct = ($cumSum / $totalOmzetSemua) * 100;
            if ($pct <= 70)      $sorted[$i]->abc = 'A';
            elseif ($pct <= 90)  $sorted[$i]->abc = 'B';
            else                 $sorted[$i]->abc = 'C';
        }
        $abcA = $sorted->where('abc','A')->count();
        $abcB = $sorted->where('abc','B')->count();
        $abcC = $sorted->where('abc','C')->count();

        // Insights otomatis
        $insights = collect();
        if ($hampirHabis->count() > 0)
            $insights->push(['type'=>'danger','icon'=>'⚠️','msg'=> $hampirHabis->count() . ' produk stok hampir habis. Segera lakukan restok sebelum terjadi kekosongan.']);
        $produkHabis = $semuaProduk->where('stok', 0);
        if ($produkHabis->count() > 0)
            $insights->push(['type'=>'danger','icon'=>'🚫','msg'=> $produkHabis->count() . ' produk stok = 0. Produk ini tidak bisa dijual, segera restok atau nonaktifkan.']);
        if ($produkSepi->count() > 0) {
            $sepi1 = $produkSepi->first();
            $insights->push(['type'=>'warn','icon'=>'📉','msg'=>'Produk "'.$sepi1->barang->nama.'" paling lambat terjual ('.$sepi1->total_terjual.' pcs). Pertimbangkan promo bundling atau diskon.']);
        }
        if ($produkLaris->count() > 0) {
            $laris1 = $produkLaris->first();
            $insights->push(['type'=>'success','icon'=>'🔥','msg'=>'Produk "'.$laris1->barang->nama.'" terlaris ('.$laris1->total_terjual.' pcs). Pastikan stok selalu tersedia — jangan sampai kosong.']);
        }
        if ($abcC > 0)
            $insights->push(['type'=>'info','icon'=>'📊','msg'=> $abcC . ' produk kategori C menyumbang hanya 10% omzet. Evaluasi apakah layak dipertahankan atau digantikan produk yang lebih menguntungkan.']);
        if ($potensiProfit > 0)
            $insights->push(['type'=>'success','icon'=>'💰','msg'=>'Potensi keuntungan dari stok saat ini Rp '.number_format($potensiProfit,0,',','.'). '. Jaga arus penjualan agar tidak menumpuk.']);
    @endphp

    <div class="py-8 lp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ══════════════════════════════════
                 ROW 1: KPI CARDS
            ══════════════════════════════════ --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                <div class="kpi-card lp-card">
                    <div class="kpi-label">Total Produk</div>
                    <div class="kpi-val">{{ $totalProduk }}</div>
                    <div class="kpi-sub">SKU aktif</div>
                </div>

                <div class="kpi-card lp-card">
                    <div class="kpi-label">Terjual</div>
                    <div class="kpi-val" style="color:#6366f1">{{ number_format($totalTerjual,0,',','.') }}</div>
                    <div class="kpi-sub">pcs periode ini</div>
                </div>

                <div class="kpi-card lp-card">
                    <div class="kpi-label">Total Stok</div>
                    <div class="kpi-val">{{ number_format($totalStok,0,',','.') }}</div>
                    <div class="kpi-sub">unit tersisa</div>
                </div>

                <div class="kpi-card lp-card">
                    <div class="kpi-label">Nilai Stok</div>
                    <div class="kpi-val text-emerald-600" style="font-size:16px">Rp {{ number_format($totalNilaiStok,0,',','.') }}</div>
                    <div class="kpi-sub">harga jual × stok</div>
                </div>

                <div class="kpi-card lp-card">
                    <div class="kpi-label">Potensi Profit</div>
                    <div class="kpi-val" style="font-size:16px; color: {{ $potensiProfit > 0 ? '#10b981' : '#ef4444' }}">
                        Rp {{ number_format($potensiProfit,0,',','.') }}
                    </div>
                    <div class="kpi-sub">jual − modal stok</div>
                </div>

                <div class="kpi-card lp-card {{ $hampirHabisCount > 0 ? 'border-red-200 dark:border-red-900' : '' }}">
                    <div class="kpi-label">Hampir Habis</div>
                    <div class="kpi-val" style="color: {{ $hampirHabisCount > 0 ? '#ef4444' : '#111827' }}">{{ $hampirHabisCount }}</div>
                    <div class="kpi-sub">produk &lt; {{ $batasHampirHabis }} pcs</div>
                </div>

            </div>

            {{-- ══════════════════════════════════
                 ROW 2: INSIGHTS OTOMATIS
            ══════════════════════════════════ --}}
            @if($insights->count() > 0)
            <div class="lp-card p-5">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-6 h-6 rounded-lg bg-indigo-100 dark:bg-indigo-950 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-200">💡 Insight Otomatis</h3>
                    <span class="text-xs text-gray-400 ml-auto">Rekomendasi berdasarkan data terkini</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($insights as $ins)
                    <div class="insight-card {{ $ins['type'] }}">
                        <span class="text-lg flex-shrink-0 mt-0.5">{{ $ins['icon'] }}</span>
                        <p class="text-xs leading-relaxed text-gray-700 dark:text-gray-300">{{ $ins['msg'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ══════════════════════════════════
                 ROW 3: LARIS + SEPI + ABC
            ══════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- PRODUK PALING LARIS --}}
                <div class="lp-card p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            🔥 Top Produk Laris
                        </h3>
                        <span class="text-xs text-gray-400">Periode ini</span>
                    </div>
                    @php $maxLaris = $produkLaris->first()->total_terjual ?? 1; @endphp
                    @forelse($produkLaris as $i => $item)
                    @php $pct = $maxLaris > 0 ? ($item->total_terjual / $maxLaris) * 100 : 0; @endphp
                    <div class="flex items-center gap-3 mb-3 last:mb-0">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0
                            {{ $i == 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' :
                               ($i == 1 ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' :
                               ($i == 2 ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300' : 'bg-indigo-50 text-indigo-400 dark:bg-indigo-950')) }}">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $item->barang->nama }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="rank-bar-wrap">
                                    <div class="rank-bar bg-indigo-500" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 w-12 text-right flex-shrink-0">{{ number_format($item->total_terjual,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-6">Belum ada data</p>
                    @endforelse
                </div>

                {{-- PRODUK SEPI --}}
                <div class="lp-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            📉 Slow Moving
                        </h3>
                        <span class="text-xs bg-rose-100 dark:bg-rose-900 text-rose-600 dark:text-rose-300 px-2 py-0.5 rounded-lg font-semibold">Butuh Aksi</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-4">Produk dengan perputaran lambat — pertimbangkan promo atau diskon</p>
                    @php $maxSepi = $produkSepi->max('total_terjual') ?: 1; @endphp
                    @forelse($produkSepi as $i => $item)
                    @php $pct2 = $maxSepi > 0 ? ($item->total_terjual / $maxSepi) * 100 : 3; @endphp
                    <div class="flex items-center gap-3 mb-3 last:mb-0">
                        <div class="w-6 h-6 rounded-lg bg-rose-100 dark:bg-rose-900 flex items-center justify-center text-xs font-bold text-rose-700 dark:text-rose-300 flex-shrink-0">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $item->barang->nama }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="rank-bar-wrap">
                                    <div class="rank-bar bg-rose-400" style="width:{{ max($pct2,3) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-rose-500 w-12 text-right flex-shrink-0">{{ number_format($item->total_terjual,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-6">Belum ada data</p>
                    @endforelse
                </div>

                {{-- ABC ANALYSIS --}}
                <div class="lp-card p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300">📊 Analisis ABC</h3>
                        <button onclick="toggleABCInfo()" class="text-xs text-indigo-500 hover:underline">Apa ini?</button>
                    </div>

                    {{-- ABC Info (hidden by default) --}}
                    <div id="abc-info" class="hidden mb-4 p-3 bg-indigo-50 dark:bg-indigo-950 rounded-xl text-xs text-indigo-700 dark:text-indigo-300 leading-relaxed">
                        <strong>Analisis ABC</strong> mengelompokkan produk berdasarkan kontribusi omzet:<br>
                        <span class="font-bold text-indigo-600">A</span> = 70% omzet (produk bintang, jaga stok ketat)<br>
                        <span class="font-bold text-amber-500">B</span> = 20% omzet (produk potensial, pantau rutin)<br>
                        <span class="font-bold text-rose-400">C</span> = 10% omzet (pertimbangkan evaluasi/diskon)
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="matrix-cell bg-indigo-50 dark:bg-indigo-950 border border-indigo-200 dark:border-indigo-800">
                            <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-300">{{ $abcA }}</span>
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 mt-1">Kelas A</span>
                            <span class="text-xs text-indigo-400 mt-0.5">70% omzet</span>
                        </div>
                        <div class="matrix-cell bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800">
                            <span class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $abcB }}</span>
                            <span class="text-xs font-bold text-amber-600 dark:text-amber-400 mt-1">Kelas B</span>
                            <span class="text-xs text-amber-400 mt-0.5">20% omzet</span>
                        </div>
                        <div class="matrix-cell bg-rose-50 dark:bg-rose-950 border border-rose-200 dark:border-rose-800">
                            <span class="text-2xl font-bold text-rose-600 dark:text-rose-300">{{ $abcC }}</span>
                            <span class="text-xs font-bold text-rose-500 mt-1">Kelas C</span>
                            <span class="text-xs text-rose-400 mt-0.5">10% omzet</span>
                        </div>
                    </div>

                    {{-- Donut visual --}}
                    <div class="flex items-center gap-3">
                        @php
                            $totalABC = max($abcA + $abcB + $abcC, 1);
                            $pA = round(($abcA / $totalABC) * 100);
                            $pB = round(($abcB / $totalABC) * 100);
                            $pC = 100 - $pA - $pB;
                        @endphp
                        <div class="flex-1 h-3 rounded-full overflow-hidden flex">
                            <div class="bg-indigo-500 h-full transition-all" style="width:{{ $pA }}%"></div>
                            <div class="bg-amber-400 h-full transition-all" style="width:{{ $pB }}%"></div>
                            <div class="bg-rose-400 h-full transition-all" style="width:{{ $pC }}%"></div>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-2">
                        <span class="text-xs text-indigo-500 font-semibold">A {{ $pA }}%</span>
                        <span class="text-xs text-amber-500 font-semibold">B {{ $pB }}%</span>
                        <span class="text-xs text-rose-400 font-semibold">C {{ $pC }}%</span>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════
                 ROW 4: STOK KRITIS ALERT
            ══════════════════════════════════ --}}
            @if($hampirHabis->count() > 0)
            <div class="lp-card overflow-hidden border-l-4 border-red-400">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 text-lg">⚠️</span>
                        <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-200">Stok Kritis — Perlu Restok Segera</h3>
                        <span class="text-xs bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 px-2 py-0.5 rounded-lg font-bold">{{ $hampirHabis->count() }} produk</span>
                    </div>
                    <span class="text-xs text-gray-400">Ambang batas: &lt; {{ $batasHampirHabis }} pcs</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="ana-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Terjual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Est. Habis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hampirHabis as $produk)
                            @php
                                // Estimasi hari habis: stok / rata2 terjual per hari (periode 30 hari)
                                $rataHari = ($produk->total_terjual ?? 0) / 30;
                                $estHari  = $rataHari > 0 ? round($produk->stok / $rataHari) : null;
                            @endphp
                            <tr>
                                <td class="font-semibold text-gray-800 dark:text-gray-200">{{ $produk->nama }}</td>
                                <td class="text-gray-500 text-xs">{{ $produk->kategori->nama ?? '-' }}</td>
                                <td class="text-right text-gray-600 dark:text-gray-400 font-mono text-xs">Rp {{ number_format($produk->harga_jual,0,',','.') }}</td>
                                <td class="text-right text-indigo-600 font-semibold">{{ $produk->total_terjual ?? 0 }}</td>
                                <td class="text-center">
                                    <span class="text-lg font-bold {{ $produk->stok <= 3 ? 'text-red-600' : 'text-amber-500' }}">
                                        {{ $produk->stok }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($produk->stok <= 0)
                                        <span class="pill pill-habis">🚫 Habis</span>
                                    @elseif($produk->stok <= 3)
                                        <span class="pill pill-kritis">🔴 Kritis</span>
                                    @else
                                        <span class="pill pill-hampir">🟡 Hampir Habis</span>
                                    @endif
                                </td>
                                <td class="text-right text-xs text-gray-500">
                                    @if($estHari !== null)
                                        <span class="{{ $estHari <= 3 ? 'text-red-500 font-bold' : ($estHari <= 7 ? 'text-amber-500 font-semibold' : 'text-gray-500') }}">
                                            ~{{ $estHari }} hari
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ══════════════════════════════════
                 ROW 5: TABEL MASTER PRODUK (TABS)
            ══════════════════════════════════ --}}
            <div class="lp-card overflow-hidden">

                {{-- Header + search + tabs --}}
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-200">📦 Semua Produk</h3>
                        <div class="relative">
                            <input type="text" id="searchProduk" placeholder="Cari produk..."
                                class="pl-9 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-900 focus:outline-none focus:border-indigo-400 w-56 font-[inherit]">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="tab-bar" style="max-width: 600px;">
                        <button class="tab-btn active" onclick="switchTab('semua', this)">Semua ({{ $semuaProduk->count() }})</button>
                        <button class="tab-btn" onclick="switchTab('kritis', this)">🔴 Kritis</button>
                        <button class="tab-btn" onclick="switchTab('abc', this)">ABC</button>
                        <button class="tab-btn" onclick="switchTab('nilai', this)">Nilai Stok</button>
                    </div>
                </div>

                {{-- TAB: SEMUA --}}
                <div id="tab-semua" class="tab-panel active overflow-x-auto sticky-thead" style="max-height:520px; overflow-y:auto;">
                    <table class="ana-table" id="tabelSemua">
                        <thead>
                            <tr>
                                <th style="width:36px"></th>
                                <th class="sortable" onclick="sortTable('tabelSemua',1)">Produk ↕</th>
                                <th class="sortable" onclick="sortTable('tabelSemua',2)">Kategori ↕</th>
                                <th class="text-right sortable" onclick="sortTable('tabelSemua',3)">Harga Jual ↕</th>
                                <th class="text-right sortable" onclick="sortTable('tabelSemua',4)">Terjual ↕</th>
                                <th class="text-right sortable" onclick="sortTable('tabelSemua',5)">Stok ↕</th>
                                <th class="text-right">Nilai Stok</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center">ABC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sorted as $i => $produk)
                            <tr class="produk-row" data-nama="{{ strtolower($produk->nama) }}" data-kondisi="{{ $produk->stok <= 0 ? 'habis' : ($produk->stok <= 3 ? 'kritis' : ($produk->stok <= $batasHampirHabis ? 'hampir' : 'aman')) }}" data-abc="{{ $produk->abc ?? 'C' }}">
                                <td class="text-xs text-gray-300 pl-4">{{ $i+1 }}</td>
                                <td>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200 text-xs">{{ $produk->nama }}</p>
                                </td>
                                <td class="text-gray-500 text-xs">{{ $produk->kategori->nama ?? '-' }}</td>
                                <td class="text-right font-mono text-xs text-gray-600 dark:text-gray-400">
                                    Rp {{ number_format($produk->harga_jual,0,',','.') }}
                                </td>
                                <td class="text-right font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ number_format($produk->total_terjual ?? 0,0,',','.') }}
                                </td>
                                <td class="text-right">
                                    <span class="font-bold text-sm {{ $produk->stok <= 0 ? 'text-gray-400' : ($produk->stok <= 3 ? 'text-red-600' : ($produk->stok <= $batasHampirHabis ? 'text-amber-500' : 'text-emerald-600')) }}">
                                        {{ $produk->stok }}
                                    </span>
                                </td>
                                <td class="text-right font-semibold text-emerald-600 font-mono text-xs">
                                    Rp {{ number_format($produk->stok * $produk->harga_jual,0,',','.') }}
                                </td>
                                <td class="text-center">
                                    @if($produk->stok <= 0)
                                        <span class="pill pill-habis">Habis</span>
                                    @elseif($produk->stok <= 3)
                                        <span class="pill pill-kritis">Kritis</span>
                                    @elseif($produk->stok <= $batasHampirHabis)
                                        <span class="pill pill-hampir">Hampir</span>
                                    @else
                                        <span class="pill pill-aman">Aman</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="font-bold text-sm
                                        {{ ($produk->abc ?? 'C') == 'A' ? 'text-indigo-600 dark:text-indigo-400' :
                                           (($produk->abc ?? 'C') == 'B' ? 'text-amber-500' : 'text-rose-400') }}">
                                        {{ $produk->abc ?? 'C' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TAB: KRITIS --}}
                <div id="tab-kritis" class="tab-panel overflow-x-auto" style="max-height:520px; overflow-y:auto;">
                    <table class="ana-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Terjual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Est. Habis</th>
                                <th class="text-right">Prioritas Restok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaProduk->where('stok','<=',$batasHampirHabis)->sortBy('stok') as $produk)
                            @php
                                $rataHari = ($produk->total_terjual ?? 0) / 30;
                                $estHari  = $rataHari > 0 ? round($produk->stok / $rataHari) : null;
                                // Skor prioritas: semakin laris + semakin kritis = makin tinggi
                                $skor = (($produk->total_terjual ?? 0) * 2) + max(0, $batasHampirHabis - $produk->stok) * 10;
                            @endphp
                            <tr>
                                <td class="font-semibold text-gray-800 dark:text-gray-200 text-xs">{{ $produk->nama }}</td>
                                <td class="text-gray-500 text-xs">{{ $produk->kategori->nama ?? '-' }}</td>
                                <td class="text-right font-mono text-xs text-gray-500">Rp {{ number_format($produk->harga_jual,0,',','.') }}</td>
                                <td class="text-right text-indigo-600 font-semibold text-sm">{{ $produk->total_terjual ?? 0 }}</td>
                                <td class="text-center font-bold text-lg {{ $produk->stok <= 3 ? 'text-red-600' : 'text-amber-500' }}">{{ $produk->stok }}</td>
                                <td class="text-center">
                                    @if($produk->stok <= 0)<span class="pill pill-habis">🚫 Habis</span>
                                    @elseif($produk->stok <= 3)<span class="pill pill-kritis">🔴 Kritis</span>
                                    @else<span class="pill pill-hampir">🟡 Hampir</span>@endif
                                </td>
                                <td class="text-right text-xs {{ $estHari !== null && $estHari <= 3 ? 'text-red-500 font-bold' : 'text-gray-400' }}">
                                    {{ $estHari !== null ? '~'.$estHari.' hari' : '-' }}
                                </td>
                                <td class="text-right">
                                    @if($skor > 200)<span class="pill pill-kritis">⬆ Sangat Tinggi</span>
                                    @elseif($skor > 80)<span class="pill pill-hampir">↑ Tinggi</span>
                                    @else<span class="pill pill-aman">→ Normal</span>@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TAB: ABC --}}
                <div id="tab-abc" class="tab-panel overflow-x-auto" style="max-height:520px; overflow-y:auto;">
                    <table class="ana-table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Produk</th>
                                <th class="text-right">Terjual</th>
                                <th class="text-right">% Omzet</th>
                                <th class="text-right">Stok</th>
                                <th class="text-right">Nilai Stok</th>
                                <th class="text-center">Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sorted as $produk)
                            @php
                                $kontribusi = $totalOmzetSemua > 0 ? (($produk->total_terjual ?? 0) / $totalOmzetSemua * 100) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <span class="font-bold text-lg
                                        {{ ($produk->abc ?? 'C') == 'A' ? 'text-indigo-600' :
                                           (($produk->abc ?? 'C') == 'B' ? 'text-amber-500' : 'text-rose-400') }}">
                                        {{ $produk->abc ?? 'C' }}
                                    </span>
                                </td>
                                <td class="font-semibold text-gray-800 dark:text-gray-200 text-xs">{{ $produk->nama }}</td>
                                <td class="text-right font-semibold text-indigo-600">{{ number_format($produk->total_terjual ?? 0,0,',','.') }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-16 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ ($produk->abc ?? 'C') == 'A' ? 'bg-indigo-500' : (($produk->abc ?? 'C') == 'B' ? 'bg-amber-400' : 'bg-rose-400') }}"
                                                style="width:{{ min($kontribusi * 10, 100) }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 w-10 text-right">{{ number_format($kontribusi,1) }}%</span>
                                    </div>
                                </td>
                                <td class="text-right font-semibold {{ $produk->stok <= 3 ? 'text-red-600' : ($produk->stok <= $batasHampirHabis ? 'text-amber-500' : 'text-gray-700 dark:text-gray-300') }}">{{ $produk->stok }}</td>
                                <td class="text-right font-mono text-xs text-emerald-600">Rp {{ number_format($produk->stok * $produk->harga_jual,0,',','.') }}</td>
                                <td class="text-center text-xs">
                                    @if(($produk->abc ?? 'C') == 'A')
                                        <span class="pill pill-laris">Jaga Stok Ketat</span>
                                    @elseif(($produk->abc ?? 'C') == 'B')
                                        <span class="pill pill-hampir">Pantau Rutin</span>
                                    @else
                                        <span class="pill pill-sepi">Evaluasi / Promo</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TAB: NILAI STOK --}}
                <div id="tab-nilai" class="tab-panel overflow-x-auto" style="max-height:520px; overflow-y:auto;">
                    <table class="ana-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-right">Harga Beli</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Margin</th>
                                <th class="text-right">Stok</th>
                                <th class="text-right">Modal Stok</th>
                                <th class="text-right">Nilai Jual Stok</th>
                                <th class="text-right">Potensi Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaProduk->sortByDesc(fn($p) => $p->stok * $p->harga_jual) as $produk)
                            @php
                                $modal      = $produk->harga_beli ?? 0;
                                $jual       = $produk->harga_jual;
                                $margin     = $jual > 0 ? (($jual - $modal) / $jual * 100) : 0;
                                $nilaiModal = $produk->stok * $modal;
                                $nilaiJual  = $produk->stok * $jual;
                                $potProfit  = $nilaiJual - $nilaiModal;
                            @endphp
                            <tr>
                                <td class="font-semibold text-gray-800 dark:text-gray-200 text-xs">{{ $produk->nama }}</td>
                                <td class="text-right font-mono text-xs text-gray-500">Rp {{ number_format($modal,0,',','.') }}</td>
                                <td class="text-right font-mono text-xs text-gray-700 dark:text-gray-300">Rp {{ number_format($jual,0,',','.') }}</td>
                                <td class="text-right">
                                    <span class="text-xs font-bold {{ $margin >= 20 ? 'text-emerald-600' : ($margin >= 10 ? 'text-amber-500' : 'text-red-500') }}">
                                        {{ number_format($margin,1) }}%
                                    </span>
                                </td>
                                <td class="text-right font-bold text-gray-700 dark:text-gray-300">{{ $produk->stok }}</td>
                                <td class="text-right font-mono text-xs text-gray-500">Rp {{ number_format($nilaiModal,0,',','.') }}</td>
                                <td class="text-right font-mono text-xs font-semibold text-indigo-600">Rp {{ number_format($nilaiJual,0,',','.') }}</td>
                                <td class="text-right font-semibold text-sm {{ $potProfit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                    Rp {{ number_format($potProfit,0,',','.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50 dark:bg-gray-800">
                                <td colspan="5" class="px-4 py-3 text-xs font-bold text-gray-600 dark:text-gray-400">Total</td>
                                <td class="px-4 py-3 text-right font-bold text-xs text-gray-600 dark:text-gray-400">Rp {{ number_format($totalNilaiModal,0,',','.') }}</td>
                                <td class="px-4 py-3 text-right font-bold text-xs text-indigo-600">Rp {{ number_format($totalNilaiStok,0,',','.') }}</td>
                                <td class="px-4 py-3 text-right font-bold text-sm {{ $potensiProfit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">Rp {{ number_format($potensiProfit,0,',','.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>{{-- end lp-card --}}

        </div>
    </div>

    @push('scripts')
    <script>
        // ── TABS ──
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            btn.classList.add('active');
        }

        // ── SEARCH PRODUK (tab semua) ──
        document.getElementById('searchProduk').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.produk-row').forEach(row => {
                row.style.display = row.getAttribute('data-nama').includes(q) ? '' : 'none';
            });
        });

        // ── SORT TABLE ──
        let sortDir = {};
        function sortTable(tableId, colIdx) {
            const table = document.getElementById(tableId);
            const tbody = table.tBodies[0];
            const rows  = Array.from(tbody.querySelectorAll('tr'));
            const dir   = (sortDir[tableId+colIdx] === 'asc') ? 'desc' : 'asc';
            sortDir[tableId+colIdx] = dir;

            rows.sort((a, b) => {
                const aText = a.cells[colIdx]?.textContent.trim().replace(/[Rp\s,.]/g,'') || '';
                const bText = b.cells[colIdx]?.textContent.trim().replace(/[Rp\s,.]/g,'') || '';
                const aVal  = isNaN(aText) ? aText : parseFloat(aText);
                const bVal  = isNaN(bText) ? bText : parseFloat(bText);
                if (aVal < bVal) return dir === 'asc' ? -1 : 1;
                if (aVal > bVal) return dir === 'asc' ? 1 : -1;
                return 0;
            });

            rows.forEach(r => tbody.appendChild(r));
        }

        // ── ABC INFO TOGGLE ──
        function toggleABCInfo() {
            document.getElementById('abc-info').classList.toggle('hidden');
        }

        // ── ANIMATE BARS on load ──
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.rank-bar').forEach(bar => {
                const w = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => { bar.style.width = w; }, 100);
            });
        });
    </script>
    @endpush
</x-app-layout>