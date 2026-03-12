<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .tanggal {
            text-align: center;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        td {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .status-aman {
            color: green;
            font-weight: bold;
        }

        .status-menipis {
            color: orange;
            font-weight: bold;
        }

        .status-habis {
            color: red;
            font-weight: bold;
        }

        tfoot td {
            font-weight: bold;
            background: #f9f9f9;
        }
    </style>

</head>

<body>

    <h2>Laporan Stok Barang</h2>

    <div class="tanggal">
        Dicetak pada : {{ now()->format('d M Y H:i') }}
    </div>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Nilai Stok</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            @php
                $totalNilai = 0;
            @endphp

            @foreach ($barang as $item)
                @php
                    $nilai = $item->stok * $item->harga_beli;
                    $totalNilai += $nilai;

                    if ($item->stok == 0) {
                        $status = 'Habis';
                        $class = 'status-habis';
                    } elseif ($item->stok < 10) {
                        $status = 'Menipis';
                        $class = 'status-menipis';
                    } else {
                        $status = 'Aman';
                        $class = 'status-aman';
                    }
                @endphp

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ $item->kode }}
                    </td>

                    <td>
                        {{ optional($item->kategori)->nama ?? '-' }}
                    </td>

                    <td>
                        {{ optional($item->supplier)->nama ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->stok }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($nilai, 0, ',', '.') }}
                    </td>

                    <td class="{{ $class }}">
                        {{ $status }}
                    </td>

                </tr>
            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <td colspan="7" class="text-right">
                    Total Nilai Stok
                </td>

                <td colspan="2" class="text-right">
                    Rp {{ number_format($totalNilai, 0, ',', '.') }}
                </td>

            </tr>

        </tfoot>

    </table>

</body>

</html>
