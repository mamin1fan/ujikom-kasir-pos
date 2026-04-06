<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center shadow">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Laporan Pembelian
                    </h2>
                    <p class="text-sm text-gray-500">
                        Monitoring & rekap transaksi pembelian barang
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

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
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: all .15s;
        }

        .dark .lp-input {
            background: #111827;
            border-color: #374151;
            color: #e5e7eb;
        }

        .lp-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, .12);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #059669;
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
        }

        .dark .btn-green {
            background: #064e3b;
            color: #6ee7b7;
            border-color: #065f46;
        }

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
            text-align: left;
            white-space: nowrap;
        }

        .row-main {
            cursor: pointer;
        }

        .row-main td {
            padding: 13px 16px;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }

        .dark .row-main td {
            border-bottom-color: #242f45;
            background: #1e2533;
        }

        .row-main:hover td,
        .row-main.is-open td {
            background: #f0fdf4 !important;
        }

        .dark .row-main:hover td,
        .dark .row-main.is-open td {
            background: #052e16 !important;
        }

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
            background: #f0fdf4;
        }

        .dark .panel-body {
            background: #042f1e;
        }

        .item-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            background: #fff;
            border: 1px solid #d1fae5;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .dark .item-card {
            background: #1e2533;
            border-color: #065f46;
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
            background: #dcfce7;
            color: #166534;
            padding: 2px 10px;
            border-radius: 20px;
        }

        .dark .qty-pill {
            background: #14532d;
            color: #86efac;
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
        $manualFilter = request('search') || request('from') || request('to') || request('id_supplier') || request('status_pembelian') || request('month');
    @endphp

    <div class="py-8 lp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">🧾</div>
                    <div>
                        <div class="lp-label">Jumlah Transaksi</div>
                        <div class="text-2xl font-bold">{{ $totalTransaksi }}</div>
                    </div>
                </div>
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">💰</div>
                    <div>
                        <div class="lp-label">Total Pembelian</div>
                        <div class="text-lg font-bold text-emerald-600">
                            Rp {{ number_format($totalPembelian, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">📦</div>
                    <div>
                        <div class="lp-label">Barang Dibeli</div>
                        <div class="text-2xl font-bold">{{ $barangDibeli }}</div>
                    </div>
                </div>
            </div>

            {{-- FILTER SECTION --}}
            <form method="GET" class="mb-6 space-y-4">
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-4 space-y-4">

                    {{-- Quick Filter --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ $manualFilter ? '#' : route('admin.laporan.pembelian', ['mode' => 'today']) }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-semibold {{ request('mode') == 'today' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}">
                            Hari Ini
                        </a>
                        <a href="{{ $manualFilter ? '#' : route('admin.laporan.pembelian', ['mode' => 'yesterday']) }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-semibold {{ request('mode') == 'yesterday' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}">
                            Kemarin
                        </a>
                        <a href="{{ $manualFilter ? '#' : route('admin.laporan.pembelian', ['mode' => '7days']) }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-semibold {{ request('mode') == '7days' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}">
                            7 Hari
                        </a>
                        <a href="{{ $manualFilter ? '#' : route('admin.laporan.pembelian', ['mode' => 'all']) }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-semibold {{ request('mode') == 'all' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-slate-800' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.laporan.pembelian') }}"
                            class="px-3 py-1.5 ms-auto rounded-lg text-sm font-semibold bg-red-100 text-red-600">
                            Reset
                        </a>
                    </div>

                    {{-- Search --}}
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor faktur atau supplier..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Tanggal --}}
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

                    <div class="flex justify-between items-center">
                        <button type="button" onclick="toggleFilter()" class="text-sm font-semibold text-emerald-600">
                            ⚙️ Filter Lanjutan
                        </button>
                        <button type="submit" class="btn-primary">
                            Terapkan Filter
                        </button>
                    </div>
                </div>

                {{-- Advanced Filter --}}
                <div id="advancedFilter" class="hidden">
                    <div class="bg-white dark:bg-slate-900 border rounded-2xl p-4 space-y-4">
                        <div>
                            <label class="lp-label">Filter Bulan</label>
                            <select name="month" class="lp-input">
                                <option value="">Semua Bulan</option>
                                @foreach ($months as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="lp-label">Supplier</label>
                            <select name="id_supplier" class="lp-input">
                                <option value="">Semua Supplier</option>
                                @foreach ($suppliers as $s)
                                    <option value="{{ $s->id_supplier }}" {{ request('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="lp-label">Status Pembelian</label>
                            <select name="status_pembelian" class="lp-input">
                                <option value="">Semua</option>
                                <option value="selesai" {{ request('status_pembelian') == 'selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="pending" {{ request('status_pembelian') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                            </select>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t">
                            <a href="{{ route('admin.laporan.pembelian') }}" class="text-red-500 text-sm">Reset</a>
                            <button type="submit" class="btn-primary">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Active Filter Info --}}
            {{-- FILTER SUMMARY + CETAK (selalu tampil) --}}
            <div
                class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl text-sm flex flex-wrap items-center gap-2">

                {{-- Menampilkan: hanya muncul jika ada filter atau mode=today --}}
                @if(request()->hasAny(['mode', 'search', 'from', 'to', 'id_supplier', 'status_pembelian', 'month']))
                    <span class="font-semibold">Menampilkan:</span>
                @endif

                {{-- Mode Today (Hari Ini) --}}
                @if(request('mode') === 'today')
                    <span class="bg-white/70 px-2 py-1 rounded">📅 Hari Ini
                        ({{ \Carbon\Carbon::today()->translatedFormat('d F Y') }})</span>
                @endif

                {{-- Filter tanggal custom --}}
                @if(request('from') && request('to'))
                    <span class="bg-white/70 px-2 py-1 rounded">📅
                        {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }}</span>
                @endif

                {{-- Filter bulan --}}
                @if(request('month'))
                    <span class="bg-white/70 px-2 py-1 rounded">📆
                        {{ \Carbon\Carbon::create()->month(request('month'))->translatedFormat('F Y') }}</span>
                @endif

                {{-- Search --}}
                @if(request('search'))
                    <span class="bg-white/70 px-2 py-1 rounded">🔍 "{{ request('search') }}"</span>
                @endif

                {{-- Supplier --}}
                @if(request('id_supplier'))
                    <span class="bg-white/70 px-2 py-1 rounded">🏢
                        {{ $suppliers->firstWhere('id_supplier', request('id_supplier'))->nama ?? '' }}</span>
                @endif

                {{-- Status --}}
                @if(request('status_pembelian'))
                    <span class="bg-white/70 px-2 py-1 rounded">📌 {{ ucfirst(request('status_pembelian')) }}</span>
                @endif

                {{-- Tombol Cetak selalu muncul --}}
                <a href="{{ route('admin.laporan.pembelian.cetak', request()->except('page')) }}" target="_blank"
                    class="ms-auto btn-green">
                    🖨️ Cetak Laporan
                </a>
            </div>

            {{-- TABLE --}}
            <div class="lp-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="lp-table">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th>Tanggal</th>
                                <th>Nomor Faktur</th>
                                <th>Supplier</th>
                                <th>Kasir</th>
                                <th class="text-right">Total</th>
                                <th style="width: 40px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelian as $item)
                                <tr class="row-main" onclick="toggleRow({{ $loop->index }})" id="row-{{ $loop->index }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_faktur)->format('d M Y') }}</td>
                                    <td>
                                        <span class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                            {{ $item->nomor_faktur }}
                                        </span>
                                    </td>
                                    <td>{{ $item->supplier->nama ?? '-' }}</td>
                                    <td>{{ $item->user->username ?? '-' }}</td>
                                    <td class="text-right font-semibold text-emerald-600">
                                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center text-emerald-600">▼</td>
                                </tr>
                                <tr class="row-panel">
                                    <td colspan="7">
                                        <div class="panel-inner" id="panel-{{ $loop->index }}">
                                            <div class="panel-body">
                                                <div class="panel-title mb-3">Detail Barang Dibeli</div>
                                                @foreach($item->detailPembelian as $detail)
                                                    <div class="item-card">
                                                        <div class="item-name">{{ $detail->barang->nama ?? '-' }}</div>
                                                        <div class="item-right">
                                                            <span class="qty-pill">× {{ $detail->jumlah }}</span>
                                                            <span class="item-price">@ Rp
                                                                {{ number_format($detail->harga_beli, 0, ',', '.') }}</span>
                                                            <span class="item-sub">Rp
                                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($item->note)
                                                    <div
                                                        class="mt-3 p-3 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded">
                                                        <strong>Catatan:</strong> {{ $item->note }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-400">
                                        Belum ada data pembelian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pembelian->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $pembelian->appends(request()->except('page'))->links() }}
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
    </script>
</x-app-layout>