<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <p>Tanggal: {{ request('from') ?? '-' }} s/d {{ request('to') ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Kasir</th>
                <th>Pembayaran</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualan as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d-m-Y') }}</td>
                    <td>{{ $item->pelanggan->nama_pelanggan ?? 'Non Pelanggan' }}</td>
                    <td>{{ $item->user->username ?? '-' }}</td>
                    <td>{{ ucfirst($item->cara_bayar) }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_bayar,0,',','.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>