<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanStokExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {

        $query = Barang::with(['kategori','supplier','creator','updater']);

        // ================= SEARCH =================
        if ($this->request->filled('search')) {
            $query->where('nama','like','%'.$this->request->search.'%');
        }

        // ================= KATEGORI =================
        if ($this->request->filled('kategori')) {
            $query->where('kategori_id',$this->request->kategori);
        }

        // ================= SUPPLIER =================
        if ($this->request->filled('supplier')) {
            $query->where('supplier_id',$this->request->supplier);
        }

        // ================= STATUS =================
        if ($this->request->filled('status')) {

            if ($this->request->status == 'aman') {
                $query->where('stok','>=',10);
            }

            if ($this->request->status == 'menipis') {
                $query->whereBetween('stok',[1,9]);
            }

            if ($this->request->status == 'habis') {
                $query->where('stok',0);
            }
        }

        // ================= FILTER TANGGAL =================
        if ($this->request->filled('from')) {
            $query->whereDate('created_at','>=',$this->request->from);
        }

        if ($this->request->filled('to')) {
            $query->whereDate('created_at','<=',$this->request->to);
        }


        $barang = $query->latest()->get();

        $data = [];

        foreach ($barang as $index => $item) {

            $nilai = $item->stok * $item->harga_beli;

            if ($item->stok == 0) {
                $status = 'Habis';
            } elseif ($item->stok < 10) {
                $status = 'Menipis';
            } else {
                $status = 'Aman';
            }

            $data[] = [
                $index + 1,
                $item->nama,
                $item->kode,
                optional($item->kategori)->nama ?? '-',
                optional($item->supplier)->nama ?? '-',
                $item->harga_beli,
                $item->stok,
                $nilai,
                $status,
                optional($item->creator)->username ?? '-',
                optional($item->updater)->username ?? '-'
            ];
        }

        return collect($data);
    }


    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Kode Barang',
            'Kategori',
            'Supplier',
            'Harga Beli',
            'Stok',
            'Nilai Stok',
            'Status',
            'Creator',
            'Updater'
        ];
    }


    public function styles(Worksheet $sheet)
    {

        // Header bold
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        // Background header
        $sheet->getStyle('A1:K1')
            ->getFill()
            ->setFillType('solid')
            ->getStartColor()
            ->setRGB('E5E7EB');

        // Align harga dan nilai stok kanan
        $sheet->getStyle('F:H')
            ->getAlignment()
            ->setHorizontal('right');

        // Border tabel
        $sheet->getStyle('A1:K1000')->applyFromArray([
            'borders'=>[
                'allBorders'=>[
                    'borderStyle'=>'thin'
                ]
            ]
        ]);

        return [];
    }

}