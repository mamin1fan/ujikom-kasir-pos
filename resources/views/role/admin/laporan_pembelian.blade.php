<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-900 dark:text-white leading-tight">Laporan Pembelian</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-normal">Rekap transaksi pembelian barang</p>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        .lp * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .lp-card {
            background: #fff; border: 1px solid #e5e7eb;
            border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .dark .lp-card { background: #1e2533; border-color: #2d3748; }

        .lp-label {
            display: block; font-size: 11px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: #6b7280; margin-bottom: 5px;
        }
        .dark .lp-label { color: #9ca3af; }

        .lp-input {
            width: 100%; padding: 9px 12px;
            border: 1.5px solid #e5e7eb; border-radius: 8px;
            font-size: 13px; font-family: inherit;
            background: #f9fafb; color: #111827; outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .dark .lp-input { background: #111827; border-color: #374151; color: #e5e7eb; color-scheme: dark; }
        .lp-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; background: #6366f1; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: background .15s, box-shadow .15s;
        }
        .btn-primary:hover { background: #4f46e5; box-shadow: 0 4px 12px rgba(99,102,241,.3); }

        .btn-green {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; background: #fff; color: #059669;
            border: 1.5px solid #d1fae5; border-radius: 8px;
            font-size: 13px; font-weight: 600; text-decoration: none;
            transition: background .15s, border-color .15s;
        }
        .btn-green:hover { background: #ecfdf5; border-color: #6ee7b7; }
        .dark .btn-green { background: #064e3b; color: #6ee7b7; border-color: #065f46; }

        /* stat */
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }

        /* table */
        .lp-table { width: 100%; border-collapse: collapse; font-size: 13px; }

        .lp-table thead tr { background: #f8fafc; border-bottom: 1.5px solid #e5e7eb; }
        .dark .lp-table thead tr { background: #151c2c; border-bottom-color: #2d3748; }

        .lp-table thead th {
            padding: 10px 16px; font-size: 11px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: #9ca3af; white-space: nowrap; text-align: left;
        }

        .row-main { cursor: pointer; }
        .row-main td {
            padding: 13px 16px; border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; background: #fff; transition: background .1s;
        }
        .dark .row-main td { border-bottom-color: #242f45; background: #1e2533; }
        .row-main.is-open td,
        .row-main:hover td { background: #fafaff !important; }
        .dark .row-main.is-open td,
        .dark .row-main:hover td { background: #1a2236 !important; }

        /* panel */
        .row-panel td { padding: 0; border-bottom: 2px solid #e5e7eb; }
        .dark .row-panel td { border-bottom-color: #2d3748; }

        .panel-inner { max-height: 0; overflow: hidden; transition: max-height .3s ease; }
        .panel-inner.is-open { max-height: 800px; }

        .panel-body { padding: 14px 18px 18px 52px; background: #fafaff; }
        .dark .panel-body { background: #161d2e; }

        .panel-title {
            font-size: 11px; font-weight: 700; letter-spacing: .06em;
            text-transform: uppercase; color: #9ca3af; margin-bottom: 10px;
        }

        /* item cards */
        .item-card {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; padding: 10px 14px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 10px;
            margin-bottom: 8px;
        }
        .dark .item-card { background: #1e2533; border-color: #2d3748; }
        .item-card:last-child { margin-bottom: 0; }

        .item-name { font-weight: 600; font-size: 13px; color: #111827; flex: 1; }
        .dark .item-name { color: #f1f5f9; }

        .item-right { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }

        .qty-pill {
            font-size: 12px; font-weight: 700;
            background: #eef2ff; color: #4f46e5;
            padding: 2px 10px; border-radius: 20px;
        }
        .dark .qty-pill { background: #1e1b4b; color: #a5b4fc; }

        .item-price { font-size: 12px; color: #9ca3af; min-width: 110px; text-align: right; }
        .item-sub { font-size: 13px; font-weight: 700; color: #059669; min-width: 120px; text-align: right; }
        .dark .item-sub { color: #34d399; }

        /* chips */
        .chip-faktur {
            font-size: 12px; font-weight: 700;
            font-family: 'SF Mono', monospace;
            color: #4f46e5; background: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 2px 9px; border-radius: 6px;
        }
        .dark .chip-faktur { background: #1e1b4b; color: #a5b4fc; border-color: #3730a3; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
        .badge-tunai { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-kredit { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
        .dark .badge-tunai { background: #1e3a5f; color: #93c5fd; border-color: #1d4ed8; }
        .dark .badge-kredit { background: #2e1065; color: #c4b5fd; border-color: #6d28d9; }

        .cell-total { font-weight: 700; color: #059669; }
        .dark .cell-total { color: #34d399; }

        .avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: #e0e7ff; color: #4f46e5;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .chevron { transition: transform .25s ease; color: #9ca3af; }
        .row-main.is-open .chevron { transform: rotate(180deg); color: #6366f1; }

        .empty-state { padding: 60px 32px; text-align: center; }
        .empty-state svg { color: #d1d5db; margin: 0 auto 14px; }
        .empty-state p { color: #9ca3af; font-size: 14px; }
    </style>

    <div class="py-8 lp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- ── FILTER ── --}}
            <div class="lp-card p-5">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[150px]">
                        <label class="lp-label">Tanggal Awal</label>
                        <input type="date" name="start" value="{{ request('start') }}" class="lp-input">
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="lp-label">Tanggal Akhir</label>
                        <input type="date" name="end" value="{{ request('end') }}" class="lp-input">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h16v2L13 13.4V19l-4 2v-7.6L3 6V4z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.laporan-pembelian.print', request()->all()) }}" target="_blank" class="btn-green">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak
                        </a>
                    </div>
                </form>
            </div>

            {{-- ── STATS ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="stat-icon" style="background:#eef2ff">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#6366f1" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0117 7.586V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#9ca3af;">Total Faktur</div>
                        <div style="font-size:24px;font-weight:700;color:#111827;letter-spacing:-.02em;" class="dark:text-white">{{ $pembelian->count() }}</div>
                    </div>
                </div>
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="stat-icon" style="background:#ecfdf5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#9ca3af;">Total Nilai</div>
                        <div style="font-size:18px;font-weight:700;color:#059669;">Rp {{ number_format($pembelian->sum('total_bayar'),0,',','.') }}</div>
                    </div>
                </div>
                <div class="lp-card p-5 flex items-center gap-4">
                    <div class="stat-icon" style="background:#fff7ed">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#9ca3af;">Supplier</div>
                        <div style="font-size:24px;font-weight:700;color:#111827;letter-spacing:-.02em;" class="dark:text-white">{{ $pembelian->pluck('supplier_id')->unique()->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- ── TABLE ── --}}
            <div class="lp-card overflow-hidden">

                <div style="padding:11px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:6px;">
                    <svg class="w-3.5 h-3.5" style="color:#9ca3af" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size:11.5px;color:#9ca3af;">Klik baris untuk melihat detail barang</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="lp-table">
                        <thead>
                            <tr>
                                <th style="width:44px;text-align:center">No</th>
                                <th>Tanggal</th>
                                <th>No. Faktur</th>
                                <th>Supplier</th>
                                <th>Kasir</th>
                                <th>Pembayaran</th>
                                <th style="text-align:right;padding-right:20px">Total</th>
                                <th style="width:40px"></th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($pembelian as $item)

                            <tr class="row-main" id="row-{{ $loop->index }}" onclick="toggleRow({{ $loop->index }})">

                                <td style="text-align:center;font-size:12px;font-weight:700;color:#9ca3af">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div style="font-weight:600;color:#111827;font-size:13px" class="dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($item->tanggal_faktur)->format('d M Y') }}
                                    </div>
                                    <div style="font-size:11px;color:#9ca3af;margin-top:1px">
                                        {{ \Carbon\Carbon::parse($item->tanggal_faktur)->translatedFormat('l') }}
                                    </div>
                                </td>

                                <td><span class="chip-faktur">{{ $item->nomor_faktur }}</span></td>

                                <td style="font-weight:600;color:#374151;font-size:13px" class="dark:text-gray-200">
                                    {{ $item->supplier->nama ?? '-' }}
                                </td>

                                <td>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="avatar">{{ strtoupper(substr($item->user->username ?? 'U', 0, 1)) }}</div>
                                        <span class="text-gray-700 dark:text-gray-200" style="font-size:13px">{{ $item->user->username ?? '-' }}</span>
                                    </div>
                                </td>

                                <td>
                                    @if(strtolower($item->cara_bayar) === 'kredit')
                                        <span class="badge badge-kredit">{{ $item->cara_bayar }}</span>
                                    @else
                                        <span class="badge badge-tunai">{{ $item->cara_bayar }}</span>
                                    @endif
                                </td>

                                <td class="cell-total" style="text-align:right;padding-right:20px">
                                    Rp {{ number_format($item->total_bayar,0,',','.') }}
                                </td>

                                <td style="text-align:center;padding-right:12px">
                                    <svg id="chev-{{ $loop->index }}" class="chevron w-4 h-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </td>

                            </tr>

                            <tr class="row-panel">
                                <td colspan="8">
                                    <div class="panel-inner" id="panel-{{ $loop->index }}">
                                        <div class="panel-body">
                                            <div class="panel-title">{{ $item->detailPembelian->count() }} item barang</div>
                                            @foreach($item->detailPembelian as $detail)
                                                <div class="item-card">
                                                    <div class="item-name">{{ $detail->barang->nama ?? '-' }}</div>
                                                    <div class="item-right">
                                                        <span class="qty-pill">× {{ $detail->jumlah }}</span>
                                                        <span class="item-price">@ Rp {{ number_format($detail->harga_beli,0,',','.') }}</span>
                                                        <span class="item-sub">Rp {{ number_format($detail->subtotal,0,',','.') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p>Belum ada data pembelian pada periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleRow(i) {
            const panel  = document.getElementById('panel-' + i);
            const chev   = document.getElementById('chev-'  + i);
            const row    = document.getElementById('row-'   + i);
            const isOpen = panel.classList.contains('is-open');

            // close all
            document.querySelectorAll('.panel-inner').forEach(p => p.classList.remove('is-open'));
            document.querySelectorAll('.chevron').forEach(c => { c.style.transform = ''; c.style.color = ''; });
            document.querySelectorAll('.row-main').forEach(r => r.classList.remove('is-open'));

            if (!isOpen) {
                panel.classList.add('is-open');
                chev.style.transform = 'rotate(180deg)';
                chev.style.color = '#6366f1';
                row.classList.add('is-open');
            }
        }
    </script>

</x-app-layout>