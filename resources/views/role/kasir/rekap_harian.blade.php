<x-app-layout>

    {{-- ════════════════════════════════════════
    HEADER (hanya tampil di web, hilang saat print)
    ════════════════════════════════════════ --}}
    <x-slot name="header">
        <div class="flex items-center justify-between print:hidden">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Rekap Kasir Harian</h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

        </div>
    </x-slot>

    {{-- ════════════════════════════════════════
    GLOBAL STYLES
    ════════════════════════════════════════ --}}
    <style>
        /* ── WEB VIEW ─────────────────────── */
        .web-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
            margin-bottom: 16px;
        }

        .web-card h3 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .web-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .web-table thead tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .web-table thead th {
            padding: 6px 8px;
            color: #9ca3af;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 600;
        }

        .web-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }

        .web-table tbody tr:last-child {
            border-bottom: none;
        }

        .web-table tbody td {
            padding: 9px 8px;
            color: #374151;
        }

        .web-table tfoot td {
            padding: 9px 8px;
            border-top: 2px solid #e5e7eb;
            font-weight: 700;
            color: #111827;
        }

        .tr {
            text-align: right;
        }

        .tl {
            text-align: left;
        }

        .tc {
            text-align: center;
        }

        /* ── PRINT VIEW ─────────────────────── */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm 18mm 20mm 18mm;
            }

            /* Sembunyikan semua elemen web & navigasi */
            nav,
            header,
            .web-only {
                display: none !important;
            }

            body {
                font-family: 'Georgia', 'Times New Roman', serif;
                font-size: 10pt;
                color: #111;
                background: white;
                line-height: 1.5;
            }

            .print-wrapper {
                display: block !important;
            }

            /* ── Letterhead ── */
            .print-letterhead {
                border-bottom: 2.5pt solid #111;
                padding-bottom: 10pt;
                margin-bottom: 14pt;
            }

            .print-letterhead .doc-title {
                font-size: 15pt;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: .1em;
                margin: 0 0 4pt;
            }

            .print-letterhead .doc-meta {
                font-size: 9pt;
                color: #444;
                display: flex;
                gap: 28pt;
            }

            /* ── KPI Bar ── */
            .print-kpi {
                display: flex !important;
                gap: 0;
                border: 1pt solid #bbb;
                border-radius: 3pt;
                overflow: hidden;
                margin-bottom: 16pt;
                page-break-inside: avoid;
            }

            .print-kpi .kpi-item {
                flex: 1;
                padding: 9pt 14pt;
                background: #f5f5f5;
                border-right: 1pt solid #bbb;
            }

            .print-kpi .kpi-item:last-child {
                border-right: none;
            }

            .print-kpi .kpi-label {
                font-size: 7.5pt;
                color: #666;
                text-transform: uppercase;
                letter-spacing: .07em;
            }

            .print-kpi .kpi-value {
                font-size: 13pt;
                font-weight: bold;
                margin-top: 2pt;
            }

            /* ── Section ── */
            .print-section {
                margin-bottom: 18pt;
            }

            .print-section-title {
                font-size: 9pt;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: #333;
                border-bottom: 1pt solid #999;
                padding-bottom: 3pt;
                margin-bottom: 6pt;
            }

            /* ── Tables ── */
            .print-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 9.5pt;
            }

            /* Repeat header di setiap halaman baru */
            .print-table thead {
                display: table-header-group;
            }

            .print-table thead tr {
                background: #1a1a1a;
                color: #fff;
            }

            .print-table thead th {
                padding: 5pt 7pt;
                font-size: 8.5pt;
                font-weight: 600;
                letter-spacing: .04em;
            }

            /* Zebra stripe */
            .print-table tbody tr:nth-child(odd) {
                background: #fff;
            }

            .print-table tbody tr:nth-child(even) {
                background: #f7f7f7;
            }

            .print-table tbody td {
                padding: 4.5pt 7pt;
                border-bottom: .5pt solid #ddd;
                vertical-align: middle;
            }

            /* Baris tidak boleh kepotong */
            .print-table tbody tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .print-table tfoot tr {
                background: #e8e8e8;
                border-top: 1.5pt solid #111;
            }

            .print-table tfoot td {
                padding: 5pt 7pt;
                font-weight: bold;
                font-size: 9pt;
            }

            /* ── Tanda Tangan ── */
            .print-ttd {
                display: flex !important;
                justify-content: space-between;
                margin-top: 36pt;
                page-break-inside: avoid;
            }

            .ttd-box {
                width: 30%;
                text-align: center;
                font-size: 9pt;
            }

            .ttd-space {
                height: 44pt;
                border-bottom: 1pt solid #333;
                margin: 4pt 0;
            }
        }
    </style>

    {{-- ════════════════════════════════════════
    WEB VIEW
    ════════════════════════════════════════ --}}
    <div class="web-only py-6 max-w-4xl mx-auto px-4">

        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">

            {{-- TEXT --}}
            <div>
                <h3 class="text-xl font-bold">Cetak Laporan Anda Hari Ini!! 🚀</h3>
                <p class="text-sm opacity-80">Klik tombol di samping untuk mencetak laporan</p>
            </div>

            {{-- CTA BUTTON (lebih besar & jelas) --}}
            <button onclick="window.print()" class="group inline-flex items-center gap-3 px-6 py-3
           text-green-700 text-sm font-semibold
           bg-white/80 backdrop-blur-md
           border border-white
           rounded-2xl
           shadow-md
           hover:bg-green-600 hover:text-white hover:border-green-600 hover:shadow-lg
           active:scale-95 transition-all duration-300">

                <!-- Icon -->
                <span class="flex items-center justify-center w-8 h-8 
                 rounded-lg bg-green-100 text-green-600
                 group-hover:bg-white/20 group-hover:text-white
                 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M9 22h6v-7H9v7z" />
                    </svg>
                </span>

                Cetak Laporan
            </button>


        </div>



        {{-- KPI --}}
        <div class="grid grid-cols-2 gap-4 mb-4 mt-2">
            <div class="web-card" style="margin-bottom:0">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Transaksi</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalTransaksi }}</p>
                <p class="text-xs text-gray-400 mt-1">transaksi hari ini</p>
            </div>
            <div class="web-card" style="margin-bottom:0">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Pendapatan</p>
                <p class="text-3xl font-bold text-indigo-600">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">pendapatan hari ini</p>
            </div>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="web-card">
            <h3>Metode Pembayaran</h3>
            <table class="web-table">
                <thead>
                    <tr>
                        <th class="tl">Metode</th>
                        <th class="tr">Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($metode as $m)
                        <tr>
                            <td class="capitalize font-medium">{{ $m->cara_bayar }}</td>
                            <td class="tr">{{ $m->total }} transaksi</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Performa Kasir --}}
        <div class="web-card">
            <h3>Performa Kasir</h3>
            <table class="web-table">
                <thead>
                    <tr>
                        <th class="tl">Nama Kasir</th>
                        <th class="tr">Transaksi</th>
                        <th class="tr">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kasir as $k)
                        <tr>
                            <td class="font-semibold">{{ $k->user->name ?? 'Kasir' }}</td>
                            <td class="tr text-gray-500">{{ $k->total_transaksi }}x</td>
                            <td class="tr font-semibold">Rp {{ number_format($k->total_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>TOTAL</td>
                        <td class="tr">{{ $totalTransaksi }}x</td>
                        <td class="tr" style="color:#4f46e5">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Detail Transaksi --}}
        <div class="web-card">
            <h3>Detail Transaksi</h3>
            <table class="web-table">
                <thead>
                    <tr>
                        <th class="tl" style="width:36px">No</th>
                        <th class="tl">Jam</th>
                        <th class="tr">Total</th>
                        <th class="tr">Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $i => $t)
                        <tr>
                            <td class="text-gray-400 text-xs">{{ $i + 1 }}</td>
                            <td style="font-family:monospace">
                                {{ \Carbon\Carbon::parse($t->tanggal_penjualan)->format('H:i') }}
                            </td>
                            <td class="tr font-medium">Rp {{ number_format($t->total_faktur, 0, ',', '.') }}</td>
                            <td class="tr text-gray-500">{{ $t->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            @if ($transaksi->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $transaksi->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ════════════════════════════════════════
    PRINT VIEW — Dokumen resmi A4
    (hidden di web, muncul saat print via JS)
    ════════════════════════════════════════ --}}
    <div class="print-wrapper" style="display:none;">

        {{-- Letterhead --}}
        <div class="print-letterhead">
            <div class="doc-title">Laporan Rekap Kasir Harian</div>
            <div class="doc-meta">
                <span>Tanggal &nbsp;: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                <span>Dicetak &nbsp;: {{ now()->format('H:i') }} WIB</span>
            </div>
        </div>

        {{-- KPI Bar --}}
        <div class="print-kpi">
            <div class="kpi-item">
                <div class="kpi-label">Total Transaksi</div>
                <div class="kpi-value">{{ $totalTransaksi }} Transaksi</div>
            </div>
            <div class="kpi-item">
                <div class="kpi-label">Total Pendapatan</div>
                <div class="kpi-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- 1. Metode Pembayaran --}}
        <div class="print-section">
            <div class="print-section-title">1. Metode Pembayaran</div>
            <table class="print-table">
                <thead>
                    <tr>
                        <th class="tl">Metode Pembayaran</th>
                        <th class="tr">Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($metode as $m)
                        <tr>
                            <td>{{ ucfirst($m->cara_bayar) }}</td>
                            <td class="tr">{{ $m->total }} transaksi</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td class="tr">{{ $metode->sum('total') }} transaksi</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- 2. Performa Kasir --}}
        <div class="print-section">
            <div class="print-section-title">2. Performa Kasir</div>
            <table class="print-table">
                <thead>
                    <tr>
                        <th class="tl">Nama Kasir</th>
                        <th class="tr">Jumlah Transaksi</th>
                        <th class="tr">Total Penjualan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kasir as $k)
                        <tr>
                            <td style="font-weight:600">{{ $k->user->name ?? 'Kasir' }}</td>
                            <td class="tr">{{ $k->total_transaksi }}x</td>
                            <td class="tr">Rp {{ number_format($k->total_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total Keseluruhan</td>
                        <td class="tr">{{ $totalTransaksi }}x</td>
                        <td class="tr">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- 3. Detail Transaksi (bisa multipage, header repeat otomatis) --}}
        <div class="print-section">
            <div class="print-section-title">3. Detail Transaksi</div>
            <table class="print-table">
                <thead>
                    <tr>
                        <th class="tc" style="width:26pt;">No</th>
                        <th class="tc" style="width:36pt;">Jam</th>
                        <th class="tr">Total Transaksi (Rp)</th>
                        <th class="tl">Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $i => $t)
                        <tr>
                            <td class="tc">{{ $i + 1 }}</td>
                            <td class="tc" style="font-family:monospace;">
                                {{ \Carbon\Carbon::parse($t->tanggal_penjualan)->format('H:i') }}
                            </td>
                            <td class="tr">
                                Rp {{ number_format($t->total_faktur, 0, ',', '.') }}
                            </td>
                            <td>{{ $t->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="font-weight:bold;">Grand Total</td>
                        <td class="tr" style="font-weight:bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Tanda Tangan --}}
        <div class="print-ttd">
            <div class="ttd-box">
                <div>Dibuat oleh,</div>
                <div class="ttd-space"></div>
                <div style="font-weight:bold;">( Kasir )</div>
            </div>
            <div class="ttd-box">
                <div>Diperiksa oleh,</div>
                <div class="ttd-space"></div>
                <div style="font-weight:bold;">( Supervisor )</div>
            </div>
            <div class="ttd-box">
                <div>Diketahui oleh,</div>
                <div class="ttd-space"></div>
                <div style="font-weight:bold;">( Admin )</div>
            </div>
        </div>

    </div>

    {{-- Toggle web ↔ print wrapper saat print dipanggil --}}
    <script>
        window.addEventListener('beforeprint', function () {
            document.querySelector('.web-only').style.display = 'none';
            document.querySelector('.print-wrapper').style.display = 'block';
        });
        window.addEventListener('afterprint', function () {
            document.querySelector('.web-only').style.display = 'block';
            document.querySelector('.print-wrapper').style.display = 'none';
        });
    </script>

</x-app-layout>