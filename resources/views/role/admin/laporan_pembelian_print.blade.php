<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ══ TOOLBAR ══ */
        .toolbar {
            position: fixed;
            top: 0; left: 0; right: 0; z-index: 100;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 32px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .toolbar-left { display: flex; align-items: center; gap: 12px; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fff; color: #475569;
            border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-size: 13px; font-weight: 600; font-family: inherit;
            text-decoration: none; cursor: pointer;
            transition: background .15s, border-color .15s;
        }
        .btn-back:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

        .btn-print {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; background: #6366f1; color: #fff;
            border: none; border-radius: 8px;
            font-size: 13px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: background .15s, box-shadow .15s;
        }
        .btn-print:hover { background: #4f46e5; box-shadow: 0 4px 12px rgba(99,102,241,.3); }

        .toolbar-title { font-size: 14px; font-weight: 700; color: #1e293b; }
        .toolbar-title span { color: #94a3b8; font-weight: 500; margin-left: 6px; font-size: 12px; }

        /* ══ PAGE ══ */
        .page { max-width: 1100px; margin: 88px auto 48px; padding: 0 24px; }

        .doc {
            background: #fff; border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            overflow: hidden;
        }

        /* ══ DOC HEADER ══ */
        .doc-header {
            padding: 32px 40px 28px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 24px;
        }
        .doc-logo {
    width:44px;
    height:44px;
    border-radius:12px;
    background:#6366f1;
    display:flex;
    align-items:center;
    justify-content:center;
}

.doc-logo img{
    width:22px;
    height:22px;
}
        
        .doc-brand { display: flex; align-items: center; gap: 14px; }
        .doc-brand-name { font-size: 18px; font-weight: 700; color: #1e293b; }
        .doc-brand-sub { font-size: 12px; color: #94a3b8; margin-top: 2px; }
        .doc-meta { text-align: right; }
        .doc-meta-title { font-size: 22px; font-weight: 700; color: #1e293b; letter-spacing: -.02em; }
        .doc-meta-period { font-size: 12.5px; color: #64748b; margin-top: 4px; }

        /* ══ STATS ══ */
        .doc-stats { display: grid; grid-template-columns: repeat(3,1fr); border-bottom: 1px solid #f1f5f9; }
        .stat-cell { padding: 20px 32px; border-right: 1px solid #f1f5f9; }
        .stat-cell:last-child { border-right: none; }
        .stat-label { font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #94a3b8; margin-bottom: 6px; }
        .stat-value { font-size: 20px; font-weight: 700; color: #1e293b; letter-spacing: -.02em; }
        .stat-value.green { color: #059669; font-size: 17px; }

        /* ══ TX BLOCK ══ */
        .tx-block {
            margin: 0 32px 20px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            page-break-inside: avoid;
        }
        .tx-block:first-of-type { margin-top: 28px; }

        /* 6 kolom: faktur | tanggal | supplier | kasir | pembayaran | total */
        .tx-head {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1.4fr 1fr 1fr 1fr;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .tx-head-cell { padding: 12px 16px; border-right: 1px solid #e2e8f0; }
        .tx-head-cell:last-child { border-right: none; }
        .tx-head-lbl {
            font-size: 10px; font-weight: 700;
            letter-spacing: .07em; text-transform: uppercase;
            color: #94a3b8; margin-bottom: 5px;
        }
        .tx-head-val { font-size: 13px; font-weight: 600; color: #1e293b; }

        .chip-faktur {
            font-size: 12px; font-weight: 700;
            font-family: 'SF Mono', monospace;
            color: #4f46e5; background: #eef2ff;
            border: 1px solid #c7d2fe;
            padding: 2px 9px; border-radius: 6px; display: inline-block;
        }

        .badge { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
        .badge-tunai  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-kredit { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }

        .tx-total-val { font-size: 14px; font-weight: 700; color: #059669; }

        /* ══ ITEMS TABLE — 4 kolom: nama, qty, harga beli, subtotal ══ */
        .items-table { width: 100%; border-collapse: collapse; }

        .items-table thead tr { background: #fafbff; border-bottom: 1px solid #f1f5f9; }
        .items-table thead th {
            padding: 9px 16px;
            font-size: 10.5px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: #94a3b8; white-space: nowrap;
        }
        .items-table thead th.left  { text-align: left; }
        .items-table thead th.right  { text-align: right; }
        .items-table thead th.center { text-align: center; }

        .items-table tbody tr { border-bottom: 1px solid #f8fafc; }
        .items-table tbody tr:last-child { border-bottom: none; }
        .items-table tbody td { padding: 10px 16px; font-size: 12.5px; color: #334155; vertical-align: middle; }
        .items-table tbody td.center { text-align: center; }
        .items-table tbody td.right  { text-align: right; }
        .items-table tbody td.muted  { color: #94a3b8; }

        .item-name { font-weight: 600; color: #1e293b; }

        .qty-pill {
            display: inline-block;
            background: #eef2ff; color: #4f46e5;
            font-size: 12px; font-weight: 700;
            padding: 2px 10px; border-radius: 20px;
        }
        .subtotal-cell { font-weight: 700; color: #059669; }

        .tx-subtotal-row td {
            background: #f8fafc;
            border-top: 1.5px solid #e2e8f0;
            padding: 9px 16px;
            font-size: 12px; font-weight: 600; color: #475569;
            text-align: right;
        }
        .tx-subtotal-row td span { color: #059669; font-size: 13px; font-weight: 700; }

        /* ══ DOC FOOTER ══ */
        .doc-footer {
            margin: 8px 32px 32px;
            padding: 16px 24px;
            background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .doc-footer-left { font-size: 11.5px; color: #94a3b8; }
        .doc-footer-right { font-size: 13px; font-weight: 600; color: #475569; }
        .doc-footer-right span { color: #059669; font-size: 15px; font-weight: 700; }

        /* ══ PRINT ══ */
        @media print {
            .toolbar { display: none !important; }
            body { background: #fff; }
            .page { margin: 0; padding: 0; max-width: 100%; }
            .doc { border: none; border-radius: 0; box-shadow: none; }
            .tx-block { page-break-inside: avoid; margin: 0 16px 16px; }
            .tx-block:first-of-type { margin-top: 20px; }
            .doc-footer { margin: 8px 16px 20px; }
            @page { margin: 14mm 12mm; size: A4; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div class="toolbar-left">
            <button class="btn-back" onclick="history.back()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </button>
            <div class="toolbar-title">
                Laporan Pembelian <span>Preview Cetak</span>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </button>
    </div>

    <div class="page">
        <div class="doc">

            <div class="doc-header">
                <div class="doc-brand">
                    <div class="doc-logo">
                        <img src="{{ asset('images/.jpg') }}" width="22">
                    </div>
                    <div>
                        <div class="doc-brand-name">Laporan Pembelian</div>
                        <div class="doc-brand-sub">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
                <div class="doc-meta">
                    <div class="doc-meta-title">Rekap Transaksi</div>
                    <div class="doc-meta-period">
                        @if(request('start') && request('end'))
                            {{ \Carbon\Carbon::parse(request('start'))->format('d M Y') }} &ndash; {{ \Carbon\Carbon::parse(request('end'))->format('d M Y') }}
                        @else
                            Semua periode
                        @endif
                    </div>
                </div>
            </div>

            <div class="doc-stats">
                <div class="stat-cell">
                    <div class="stat-label">Total Faktur</div>
                    <div class="stat-value">{{ $pembelian->count() }}</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-label">Total Nilai Pembelian</div>
                    <div class="stat-value green">Rp {{ number_format($pembelian->sum('total_bayar'),0,',','.') }}</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-label">Jumlah Supplier</div>
                    <div class="stat-value">{{ $pembelian->pluck('supplier_id')->unique()->count() }}</div>
                </div>
            </div>

            @forelse($pembelian as $item)
                <div class="tx-block">

                    {{-- Header 6 kolom --}}
                    <div class="tx-head">
                        <div class="tx-head-cell">
                            <div class="tx-head-lbl">No. Faktur</div>
                            <div class="tx-head-val"><span class="chip-faktur">{{ $item->nomor_faktur }}</span></div>
                        </div>
                        <div class="tx-head-cell">
                            <div class="tx-head-lbl">Tanggal</div>
                            <div class="tx-head-val">{{ \Carbon\Carbon::parse($item->tanggal_faktur)->format('d M Y') }}</div>
                        </div>
                        <div class="tx-head-cell">
                            <div class="tx-head-lbl">Supplier</div>
                            <div class="tx-head-val">{{ $item->supplier->nama ?? '-' }}</div>
                        </div>
                        <div class="tx-head-cell">
                            <div class="tx-head-lbl">Kasir</div>
                            <div class="tx-head-val">{{ $item->user->username ?? '-' }}</div>
                        </div>
                        <div class="tx-head-cell">
                            <div class="tx-head-lbl">Pembayaran</div>
                            <div class="tx-head-val">
                                @if(strtolower($item->cara_bayar) === 'kredit')
                                    <span class="badge badge-kredit">{{ $item->cara_bayar }}</span>
                                @else
                                    <span class="badge badge-tunai">{{ $item->cara_bayar }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="tx-head-cell" style="text-align:right">
                            <div class="tx-head-lbl">Total</div>
                            <div class="tx-total-val">Rp {{ number_format($item->total_bayar,0,',','.') }}</div>
                        </div>
                    </div>

                    {{-- Detail barang: nama | qty | harga beli | subtotal --}}
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th class="center" style="width:36px">#</th>
                                <th class="left">Nama Barang</th>
                                <th class="center" style="width:80px">Qty</th>
                                <th class="right" style="width:150px">Harga Beli</th>
                                <th class="right" style="width:160px">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->detailPembelian as $detail)
                                <tr>
                                    <td class="center muted" style="font-size:11px;font-weight:700;">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="item-name">{{ $detail->barang->nama ?? '-' }}</div>
                                        @if(!empty($detail->barang->kode))
                                            <div style="font-size:11px;color:#94a3b8;margin-top:1px;">{{ $detail->barang->kode }}</div>
                                        @endif
                                    </td>
                                    <td class="center"><span class="qty-pill">{{ $detail->jumlah }}</span></td>
                                    <td class="right muted">Rp {{ number_format($detail->harga_beli,0,',','.') }}</td>
                                    <td class="right subtotal-cell">Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tr class="tx-subtotal-row">
                            <td colspan="5">
                                {{ $item->detailPembelian->count() }} item &nbsp;·&nbsp;
                                Total Faktur: <span>Rp {{ number_format($item->total_bayar,0,',','.') }}</span>
                            </td>
                        </tr>
                    </table>

                </div>
            @empty
                <div style="padding:60px;text-align:center;color:#94a3b8;">
                    Tidak ada data pembelian pada periode ini.
                </div>
            @endforelse

            <div class="doc-footer">
                <div class="doc-footer-left">Dokumen digenerate otomatis &middot; {{ now()->format('d/m/Y H:i') }}</div>
                <div class="doc-footer-right">Grand Total &nbsp;<span>Rp {{ number_format($pembelian->sum('total_bayar'),0,',','.') }}</span></div>
            </div>

        </div>
    </div>

</body>
</html>