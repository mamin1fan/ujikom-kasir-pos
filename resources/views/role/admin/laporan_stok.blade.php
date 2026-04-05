<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between print:hidden">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    📦 Laporan Stok Barang
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Stok terkini per hari ini • {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.laporan.stok.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl text-sm font-semibold">
                    📊 Excel
                </a>
                <a href="{{ route('admin.laporan.stok.pdf', request()->query()) }}"
                    class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-2xl text-sm font-semibold">
                    📄 PDF
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-2xl text-sm font-semibold">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>

        {{-- HEADER CETAK (hanya muncul saat print) --}}
        <div class="hidden print:flex flex-col items-center border-b-2 border-black pb-4 mb-6">
            <h1 class="text-2xl font-bold text-black">LAPORAN STOK BARANG</h1>
            <p class="text-sm text-black mt-1">
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} •
                @if (session('mode') === 'operasional')
                    {{ session('sekolah_nama', 'SIMart') }}
                @else
                    SIMart
                @endif
            </p>
            <p class="text-xs text-gray-600 mt-3">Data stok terkini • Dicetak otomatis</p>
        </div>
    </x-slot>

    <div class="py-8 print:py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 print:space-y-6">

            {{-- SUMMARY CARDS (tetap tampil di print tapi lebih ringkas) --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 print:gap-3">
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl p-6 print:border-black print:rounded-none print:shadow-none">
                    <div class="text-xs font-semibold text-gray-500 print:text-black">TOTAL BARANG</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white print:text-black mt-1">
                        {{ $barang->total() }}</div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl p-6 print:border-black print:rounded-none print:shadow-none">
                    <div class="text-xs font-semibold text-gray-500 print:text-black">NILAI TOTAL STOK</div>
                    <div class="text-4xl font-bold text-emerald-600 print:text-black mt-1">
                        Rp {{ number_format($totalNilaiStok ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl p-6 print:border-black print:rounded-none print:shadow-none">
                    <div class="text-xs font-semibold text-emerald-600 print:text-black">STOK AMAN</div>
                    <div class="text-4xl font-bold text-emerald-600 print:text-black mt-1">{{ $stokAman ?? 0 }}</div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl p-6 print:border-black print:rounded-none print:shadow-none">
                    <div class="text-xs font-semibold text-amber-600 print:text-black">KRITIS / HABIS</div>
                    <div class="text-4xl font-bold text-amber-600 print:text-black mt-1">{{ $stokKritis ?? 0 }}</div>
                </div>
            </div>

            {{-- FILTER (hilang saat print) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 p-6 print:hidden">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-5">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">CARI BARANG</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama barang, kode..."
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-2xl px-5 py-3">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">KATEGORI</label>
                        <select name="kategori"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-2xl px-5 py-3">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">SUPPLIER</label>
                        <select name="supplier"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-2xl px-5 py-3">
                            <option value="">Semua Supplier</option>
                            @foreach($supplier as $s)
                                <option value="{{ $s->id }}" {{ request('supplier') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-2xl">Filter</button>
                    </div>
                </form>
                @if(request()->hasAny(['search', 'kategori', 'supplier']))
                    <div class="text-right mt-3">
                        <a href="{{ route('admin.laporan.stok') }}" class="text-red-600 text-sm">Reset Filter</a>
                    </div>
                @endif
            </div>

            {{-- TABEL UTAMA (dioptimalkan untuk cetak) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden print:border-black print:rounded-none print:shadow-none">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 print:divide-black">
                        <thead class="bg-gray-50 dark:bg-gray-900 print:bg-white">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    #</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Barang</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Kategori</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Supplier</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Harga Beli</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Stok</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Nilai Stok</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($barang as $item)
                                @php $nilaiStok = $item->stok * ($item->harga_beli ?? 0); @endphp
                                <tr class="print:border-b print:border-black">
                                    <td class="px-6 py-5 text-sm text-gray-400 print:text-black">
                                        {{ $barang->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-5 print:text-black">
                                        <div class="font-semibold">{{ $item->nama }}</div>
                                        @if($item->kode)
                                        <div class="text-xs font-mono">{{ $item->kode }}</div>@endif
                                    </td>
                                    <td class="px-6 py-5 text-center">{{ $item->kategori->nama ?? '-' }}</td>
                                    <td class="px-6 py-5 text-center">{{ $item->supplier->nama ?? '-' }}</td>
                                    <td class="px-6 py-5 text-right">Rp
                                        {{ number_format($item->harga_beli ?? 0, 0, ',', '.') }}</td>
                                    <td
                                        class="px-6 py-5 text-center font-bold text-xl print:text-black {{ $item->stok == 0 ? 'text-red-600' : ($item->stok < 10 ? 'text-amber-600' : '') }}">
                                        {{ $item->stok }}
                                    </td>
                                    <td class="px-6 py-5 text-right font-semibold print:text-black">
                                        Rp {{ number_format($nilaiStok, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($item->stok == 0)
                                            <span
                                                class="print:border print:border-red-700 print:text-red-700 px-3 py-0.5 text-xs rounded">HABIS</span>
                                        @elseif($item->stok < 10)
                                            <span
                                                class="print:border print:border-amber-700 print:text-amber-700 px-3 py-0.5 text-xs rounded">KRITIS</span>
                                        @else
                                            <span
                                                class="print:border print:border-emerald-700 print:text-emerald-700 px-3 py-0.5 text-xs rounded">AMAN</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 print:text-black">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- GRAND TOTAL (sangat penting untuk pembukuan) --}}
                        @if($barang->count() > 0)
                            <tfoot
                                class="bg-emerald-50 dark:bg-emerald-950 print:bg-white border-t-4 border-emerald-600 print:border-black">
                                <tr class="font-bold text-lg">
                                    <td colspan="5" class="px-6 py-5 text-right print:text-black">TOTAL KESELURUHAN</td>
                                    <td class="px-6 py-5 text-center print:text-black">{{ $barang->sum('stok') }}</td>
                                    <td class="px-6 py-5 text-right print:text-black">
                                        Rp {{ number_format($totalNilaiStok ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Pagination hanya di layar --}}
                @if($barang->hasPages())
                    <div class="px-6 py-4 border-t print:hidden">{{ $barang->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>