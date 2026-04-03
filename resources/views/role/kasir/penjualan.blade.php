<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M3 10h11M9 21V3m12 18v-6a2 2 0 00-2-2h-5.586a1 1 0 01-.707-.293l-5.414-5.414A1 1 0 006 6.414V19a2 2 0 002 2h13z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Laporan Penjualan
                    </h2>
                    <p class="text-sm text-gray-500">
                        Monitoring & rekap transaksi kasir
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ✅ STYLE SAMA PERSIS (tidak diubah) --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        .lp * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .lp-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .dark .lp-card {
            background: #1e2533;
            border-color: #2d3748;
        }

        .lp-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .dark .lp-label {
            color: #9ca3af;
        }

        .lp-input {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .dark .lp-input {
            background: #111827;
            border-color: #374151;
            color: #e5e7eb;
            color-scheme: dark;
        }

        .lp-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, box-shadow .15s;
        }

        .btn-primary:hover {
            background: #4f46e5;
            box-shadow: 0 4px 12px rgba(99, 102, 241, .3);
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #fff;
            color: #059669;
            border: 1.5px solid #d1fae5;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s, border-color .15s;
        }

        .btn-green:hover {
            background: #ecfdf5;
            border-color: #6ee7b7;
        }

        .dark .btn-green {
            background: #064e3b;
            color: #6ee7b7;
            border-color: #065f46;
        }

        /* stat */
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* table */
        .lp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .lp-table thead tr {
            background: #f8fafc;
            border-bottom: 1.5px solid #e5e7eb;
        }

        .dark .lp-table thead tr {
            background: #151c2c;
            border-bottom-color: #2d3748;
        }

        .lp-table thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #9ca3af;
            white-space: nowrap;
            text-align: left;
        }

        .row-main {
            cursor: pointer;
        }

        .row-main td {
            padding: 13px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            background: #fff;
            transition: background .1s;
        }

        .dark .row-main td {
            border-bottom-color: #242f45;
            background: #1e2533;
        }

        .row-main.is-open td,
        .row-main:hover td {
            background: #fafaff !important;
        }

        .dark .row-main.is-open td,
        .dark .row-main:hover td {
            background: #1a2236 !important;
        }

        /* panel */
        .row-panel td {
            padding: 0;
            border-bottom: 2px solid #e5e7eb;
        }

        .dark .row-panel td {
            border-bottom-color: #2d3748;
        }

        .panel-inner {
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease;
        }

        .panel-inner.is-open {
            max-height: 800px;
        }

        .panel-body {
            padding: 14px 18px 18px 52px;
            background: #fafaff;
        }

        .dark .panel-body {
            background: #161d2e;
        }

        .panel-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        /* item cards */
        .item-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .dark .item-card {
            background: #1e2533;
            border-color: #2d3748;
        }

        .item-card:last-child {
            margin-bottom: 0;
        }

        .item-name {
            font-weight: 600;
            font-size: 13px;
            color: #111827;
            flex: 1;
        }

        .dark .item-name {
            color: #f1f5f9;
        }

        .item-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .qty-pill {
            font-size: 12px;
            font-weight: 700;
            background: #eef2ff;
            color: #4f46e5;
            padding: 2px 10px;
            border-radius: 20px;
        }

        .dark .qty-pill {
            background: #1e1b4b;
            color: #a5b4fc;
        }

        .item-price {
            font-size: 12px;
            color: #9ca3af;
            min-width: 110px;
            text-align: right;
        }

        .item-sub {
            font-size: 13px;
            font-weight: 700;
            color: #059669;
            min-width: 120px;
            text-align: right;
        }

        .dark .item-sub {
            color: #34d399;
        }
    </style>

    @php
        $manualFilter =
            request('search') ||
            request('from') ||
            request('to') ||
            request('status_pembayaran') ||
            request('month') ||
            request('pelanggan') ||
            request('id_pelanggan');
    @endphp

    <div class="py-8 lp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold">Mulai Transaksi</h3>
                    <p class="text-sm opacity-80">Klik untuk membuka halaman kasir</p>
                </div>

                <a href="{{ route('kasir.transaksi') }}"
                    class="bg-white text-blue-600 px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-50 transition flex items-center gap-2">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7" />
                    </svg>

                    Buka POS
                </a>
            </div>




            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        📊
                    </div>
                    <div>
                        <div class="lp-label">Jumlah Transaksi</div>
                        <div class="text-2xl font-bold">{{ $totalTransaksi }}</div>
                    </div>
                </div>

                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        💰
                    </div>
                    <div>
                        <div class="lp-label">Total Penjualan</div>
                        <div class="text-lg font-bold text-green-600">
                            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        🛒
                    </div>
                    <div>
                        <div class="lp-label">Produk Terjual</div>
                        <div class="text-2xl font-bold">
                            {{ $produkTerjual }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- FILTER SECTION --}}
            <form method="GET" class="mb-6 space-y-4">

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-4 space-y-4">

                    {{-- ⚡ QUICK FILTER --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- MODE --}}
                        <a href="{{ $manualFilter ? '#' : route('kasir.penjualan', ['mode' => 'today']) }}" class="px-3 py-1.5 rounded-lg text-sm font-semibold
   {{ request('mode') == 'today' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}
   {{ $manualFilter ? 'opacity-50 pointer-events-none' : '' }}">
                            Hari Ini
                        </a>

                        <a href="{{ $manualFilter ? '#' : route('kasir.penjualan', ['mode' => 'yesterday']) }}" class="px-3 py-1.5 rounded-lg text-sm font-semibold
       {{ request('mode') == 'yesterday' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}
       {{ $manualFilter ? 'opacity-50 pointer-events-none' : '' }}">
                            Kemarin
                        </a>

                        <a href="{{ $manualFilter ? '#' : route('kasir.penjualan', ['mode' => '7days']) }}" class="px-3 py-1.5 rounded-lg text-sm font-semibold
       {{ request('mode') == '7days' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}
       {{ $manualFilter ? 'opacity-50 pointer-events-none' : '' }}">
                            7 Hari
                        </a>

                        <a href="{{ $manualFilter ? '#' : route('kasir.penjualan', ['mode' => 'all']) }}" class="px-3 py-1.5 rounded-lg text-sm font-semibold
       {{ request('mode') == 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}
       {{ $manualFilter ? 'opacity-50 pointer-events-none' : '' }}">
                            Semua
                        </a>

                        {{-- 🔥 RESET --}}
                        <a href="{{ route('kasir.penjualan', ['mode' => 'today']) }}"
                            class="px-3 py-1.5 ms-auto rounded-lg text-sm font-semibold bg-red-100 text-red-600">
                            Reset
                        </a>

                    </div>

                    {{-- 🔍 SEARCH --}}
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari catatan atau note transaksi ..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">

                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- 📅 DEFAULT FILTER TANGGAL --}}
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <label class="lp-label">Dari Tanggal</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="lp-input">
                        </div>

                        <div>
                            <label class="lp-label">Sampai Tanggal</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="lp-input">
                        </div>
                    </div>

                    {{-- ⚙️ TOGGLE ADVANCED --}}
                    <div class="flex justify-between items-center">
                        <button type="button" onclick="toggleFilter()" class="text-sm font-semibold text-blue-600">
                            ⚙️ Filter Lanjutan
                        </button>

                        <button type="submit" class="btn-primary">
                            Terapkan Filter
                        </button>
                    </div>
                </div>

                <div id="advancedFilter" class="hidden">
                    <div class="bg-white dark:bg-slate-900 border rounded-2xl p-4 space-y-4">

                        {{-- 📅 BULAN --}}
                        <div>
                            <label class="lp-label">Filter Bulan</label>
                            <select name="month" class="lp-input">
                                <option value="">Semua</option>
                                @foreach ($months as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 💳 STATUS PEMBAYARAN --}}
                        <div>
                            <label class="lp-label">Status Pembayaran</label>
                            <select name="status_pembayaran" class="lp-input">
                                <option value="">Semua</option>
                                @foreach ($statuses as $s)
                                    <option value="{{ $s }}" {{ request('status_pembayaran') == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 👤 TIPE PELANGGAN --}}
                        <div>
                            <label class="lp-label">Tipe Pelanggan</label>
                            <select name="pelanggan" id="filterPelanggan" class="lp-input">
                                <option value="">Semua</option>
                                <option value="ada" {{ request('pelanggan') == 'ada' ? 'selected' : '' }}>Pelanggan
                                </option>
                                <option value="non" {{ request('pelanggan') == 'non' ? 'selected' : '' }}>Non Pelanggan
                                </option>
                            </select>
                        </div>

                        {{-- 👤 PILIH PELANGGAN (hanya kalau "ada") --}}
                        <div id="selectPelanggan" class="{{ request('pelanggan') == 'ada' ? '' : 'hidden' }}">
                            <label class="lp-label">Nama Pelanggan</label>
                            <select name="id_pelanggan" class="lp-input">
                                <option value="">Semua Pelanggan</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->id_pelanggan }}" {{ request('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>
                                        {{ $p->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- ACTION --}}
                        <div class="flex justify-between items-center pt-3 border-t">
                            <a href="{{ route('kasir.penjualan') }}" class="text-red-500 text-sm">
                                Reset
                            </a>

                            <button type="submit" class="btn-primary">
                                Terapkan Filter
                            </button>
                        </div>

                    </div>
                </div>
            </form>



            @if(request()->hasAny(['from', 'to', 'search', 'status_pembayaran', 'month', 'pelanggan', 'id_pelanggan']))
                <div
                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-xl text-sm flex flex-wrap items-center gap-2">

                    <span class="font-semibold">Menampilkan:</span>

                    {{-- 📅 TANGGAL --}}
                    @if(request('from') && request('to'))
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            📅 {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }}
                        </span>
                    @endif

                    {{-- 📅 BULAN --}}
                    @if(request('month'))
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            📆 Bulan {{ \Carbon\Carbon::create()->month(request('month'))->translatedFormat('F') }}
                        </span>
                    @endif

                    {{-- 🔍 SEARCH --}}
                    @if(request('search'))
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            🔍 "{{ request('search') }}"
                        </span>
                    @endif

                    {{-- 💳 STATUS --}}
                    @if(request('status_pembayaran'))
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            💳 {{ ucfirst(request('status_pembayaran')) }}
                        </span>
                    @endif

                    {{-- 👤 TIPE --}}
                    @if(request('pelanggan') == 'ada')
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            👤 Pelanggan
                        </span>
                    @elseif(request('pelanggan') == 'non')
                        <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                            👤 Non Pelanggan
                        </span>
                    @endif

                    {{-- 👤 NAMA PELANGGAN --}}
                    @if(request('id_pelanggan'))
                        @php
                            $selected = $pelanggan->firstWhere('id_pelanggan', request('id_pelanggan'));
                        @endphp

                        @if($selected)
                            <span class="bg-white/70 dark:bg-slate-800 px-2 py-1 rounded">
                                🧾 {{ $selected->nama_pelanggan }}
                            </span>
                        @endif
                    @endif
                    <div class="flex ms-auto gap-2">
                        <a href="{{ route('kasir.penjualan.cetak', request()->all()) }}" target="_blank" class="btn-green">
                            🖨️ Cetak Laporan
                        </a>
                    </div>
                </div>
            @endif
            @if(!request()->hasAny(['from', 'to', 'search', 'status_pembayaran', 'month', 'pelanggan', 'id_pelanggan']))
                <div class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 px-4 py-3 rounded-xl text-sm">
                    📊 Menampilkan semua data hari ini
                </div>
                <div class="flex ms-auto gap-2">
                    <a href="{{ route('kasir.penjualan.cetak', request()->all()) }}" target="_blank" class="btn-green">
                        🖨️ Cetak Laporan
                    </a>
                </div>
            @endif



            {{-- TABLE --}}
            <div class="lp-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="lp-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Kasir</th>
                                <th>Pembayaran</th>
                                <th class="text-right pr-4">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($penjualan as $item)

                                <tr class="row-main" onclick="toggleRow({{ $loop->index }})" id="row-{{ $loop->index }}">

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d M Y') }}
                                    </td>

                                    <td>
                                        {{ $item->pelanggan->nama_pelanggan ?? 'non-pelanggan' }}
                                    </td>

                                    <td>
                                        {{ $item->user->username ?? '-' }}
                                    </td>

                                    <td>
                                        @if(strtolower($item->cara_bayar) === 'kredit')
                                            <span class="badge badge-kredit">Kredit</span>
                                        @else
                                            <span class="badge badge-tunai">Tunai</span>
                                        @endif
                                    </td>

                                    <td class="cell-total text-left pr-4">
                                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                    </td>

                                    <td>▼</td>

                                </tr>

                                {{-- DETAIL --}}
                                <tr class="row-panel">
                                    <td colspan="8">
                                        <div class="panel-inner" id="panel-{{ $loop->index }}">
                                            <div class="panel-body">

                                                @foreach($item->detailPenjualan as $detail)
                                                    <div class="item-card">
                                                        <div class="item-name">{{ $detail->barang->nama ?? '-' }}</div>
                                                        <div class="item-right">
                                                            <span class="qty-pill">× {{ $detail->jumlah_barang }}</span>
                                                            <span class="item-price">@ Rp
                                                                {{ number_format($detail->harga_jual, 0, ',', '.') }}</span>
                                                            <span class="item-sub">Rp
                                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                {{-- NOTE --}}
                                                @if($item->note)
                                                    <div
                                                        class="item-note mt-2 p-2 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded">
                                                        <strong>Catatan:</strong> {{ $item->note }}
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-10 text-gray-400">
                                        Belum ada data penjualan
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                @if ($penjualan->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $penjualan->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>

        function toggleRow(i) {
            const panel = document.getElementById('panel-' + i);

            document.querySelectorAll('.panel-inner').forEach(p => p.classList.remove('is-open'));

            if (!panel.classList.contains('is-open')) {
                panel.classList.add('is-open');
            }
        }

        function toggleFilter() {
            document.getElementById('advancedFilter').classList.toggle('hidden');
        }
        const pelangganFilter = document.getElementById('filterPelanggan');
        const selectPelanggan = document.getElementById('selectPelanggan');

        pelangganFilter.addEventListener('change', function () {
            if (this.value === 'ada') {
                selectPelanggan.classList.remove('hidden');
            } else {
                selectPelanggan.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>