<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-bold text-xl text-gray-900 dark:text-white">
                    📦 Laporan Stok Barang
                </h2>

                <p class="text-sm text-gray-500">
                    Data per {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>

            <div class="flex gap-2 print:hidden">

                <a href="{{ route('admin.laporan.stok.excel', request()->query()) }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">
                    Excel
                </a>

                <a href="{{ route('admin.laporan.stok.pdf', request()->query()) }}"
                    class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg text-sm">
                    PDF
                </a>

                <button onclick="window.print()"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">
                    Print
                </button>

            </div>

        </div>
    </x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            {{-- ================= FILTER ================= --}}
            <div class="bg-white rounded-xl border p-4">

                <form method="GET" class="flex flex-wrap gap-3 items-end">

                    <div>
                        <label class="text-xs text-gray-500">Cari Barang</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama barang..." class="border rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Kategori</label>
                        <select name="kategori" class="border rounded-lg px-3 py-2 text-sm">

                            <option value="">Semua</option>

                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>
                                    {{ $k->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div>
                        <label class="text-xs text-gray-500">Supplier</label>
                        <select name="supplier" class="border rounded-lg px-3 py-2 text-sm">

                            <option value="">Semua</option>

                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}" @selected(request('supplier') == $s->id)>
                                    {{ $s->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div>
                        <label class="text-xs text-gray-500">Dari Tanggal</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="border rounded-lg px-3 py-2 text-sm">
                    </div>


                    <div>
                        <label class="text-xs text-gray-500">Sampai</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="border rounded-lg px-3 py-2 text-sm">
                    </div>


                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">
                        Filter
                    </button>

                </form>

            </div>


            {{-- ================= KETERANGAN LAPORAN ================= --}}
            @if (request('from') || request('to'))
                <div class="bg-indigo-50 border border-indigo-200 text-indigo-700 px-4 py-3 rounded-lg text-sm">

                    Laporan dari

                    <strong>
                        {{ request('from') ? \Carbon\Carbon::parse(request('from'))->translatedFormat('d F Y') : '-' }}
                    </strong>

                    sampai

                    <strong>
                        {{ request('to') ? \Carbon\Carbon::parse(request('to'))->translatedFormat('d F Y') : '-' }}
                    </strong>

                </div>
            @endif



            {{-- ================= TABLE ================= --}}
            <div class="bg-white rounded-xl border overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-4 py-3 text-left">#</th>

                                <th class="px-4 py-3 text-left">
                                    Barang
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Kategori
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Supplier
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Creator
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Updater
                                </th>

                                <th class="px-4 py-3 text-right">
                                    Harga Beli
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Stok
                                </th>

                                <th class="px-4 py-3 text-right">
                                    Nilai Stok
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y">

                            @forelse($barang as $item)
                                @php
                                    $nilai = $item->stok * $item->harga_beli;
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3">
                                        {{ $barang->firstItem() + $loop->index }}
                                    </td>


                                    <td class="px-4 py-3">

                                        <div class="font-semibold">
                                            {{ $item->nama }}
                                        </div>

                                        <div class="text-xs text-gray-400">
                                            {{ $item->kode }}
                                        </div>

                                    </td>


                                    <td class="px-4 py-3 text-center">
                                        {{ $item->kategori->nama ?? '-' }}
                                    </td>


                                    <td class="px-4 py-3 text-center">
                                        {{ $item->supplier->nama ?? '-' }}
                                    </td>


                                    <td class="px-4 py-3 text-center text-xs">
                                        {{ $item->creator->username ?? '-' }}
                                    </td>


                                    <td class="px-4 py-3 text-center text-xs">
                                        {{ $item->updater->username ?? '-' }}
                                    </td>


                                    <td class="px-4 py-3 text-right">
                                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                    </td>



                                    <td class="px-4 py-3 text-center">

                                        <div class="text-sm font-semibold">
                                            {{ $item->stok }}
                                        </div>

                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">

                                            <div class="h-1.5 rounded-full
@if ($item->stok == 0) bg-red-500
@elseif($item->stok < 10) bg-yellow-500
@else bg-emerald-500 @endif"
                                                style="width: {{ min($item->stok, 100) }}%">
                                            </div>

                                        </div>

                                    </td>


                                    <td class="px-4 py-3 text-right font-semibold text-indigo-600">
                                        Rp {{ number_format($nilai, 0, ',', '.') }}
                                    </td>


                                    <td class="px-4 py-3 text-center">

                                        @if ($item->stok == 0)
                                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">
                                                Habis
                                            </span>
                                        @elseif($item->stok < 10)
                                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">
                                                Menipis
                                            </span>
                                        @else
                                            <span
                                                class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">
                                                Aman
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="10" class="text-center py-16 text-gray-400">
                                        Tidak ada data barang
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="p-4 border-t">

                    {{ $barang->withQueryString()->links() }}

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
