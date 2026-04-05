<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #111827;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
            color: #374151;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #374151;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f3f4f6;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: monospace; }
        
        .detail-row td {
            border-top: 2px solid #e5e7eb;
            background-color: #f9fafb;
            padding-top: 12px;
        }
        
        .item-detail {
            margin: 8px 0;
            padding-left: 20px;
            font-size: 11px;
        }
        
        .total-row {
            font-weight: 700;
            background-color: #ecfdf5;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <h2>LAPORAN PEMBELIAN</h2>
    <div class="header-info">
        @if(request('from') && request('to'))
            Periode: {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }} s/d 
            {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }}
        @elseif(request('month'))
            Bulan: {{ \Carbon\Carbon::create()->month(request('month'))->translatedFormat('F Y') }}
        @else
            Semua Periode
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="100">Tanggal</th>
                <th width="130">Nomor Faktur</th>
                <th>Supplier</th>
                <th width="100">Kasir</th>
                <th width="120" class="text-right">Total Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelian as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_faktur)->format('d M Y') }}</td>
                    <td class="font-mono">{{ $item->nomor_faktur }}</td>
                    <td>{{ $item->supplier->nama ?? '-' }}</td>
                    <td>{{ $item->user->username ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                </tr>

                {{-- Detail Barang --}}
                <tr class="detail-row">
                    <td colspan="6">
                        <strong>Detail Barang:</strong>
                        @foreach($item->detailPembelian as $detail)
                            <div class="item-detail">
                                • {{ $detail->barang->nama ?? '-' }} 
                                × {{ $detail->jumlah }} 
                                @ Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}
                                = Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        @endforeach
                        
                        @if($item->note)
                            <div class="item-detail" style="color: #b45309; margin-top: 6px;">
                                <strong>Catatan:</strong> {{ $item->note }}
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8">Tidak ada data pembelian</td>
                </tr>
            @endforelse
        </tbody>
        
        {{-- Total Keseluruhan --}}
        @if($pembelian->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right font-bold">TOTAL KESELURUHAN</td>
                <td class="text-right font-bold">
                    Rp {{ number_format($pembelian->sum('total_bayar'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }}<br>
        Jumlah Transaksi: {{ $pembelian->count() }}
    </div>

    <script>
        window.print();
    </script>
</body>
</html>