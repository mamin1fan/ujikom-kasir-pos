<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Kasir
        </h2>
    </x-slot>

    <div class="py-6" x-data="strukApp()" x-init="init()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            

            {{-- 📊 KPI --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border">
                    <p class="text-xs text-gray-500">Transaksi hari ini</p>
                    <p class="text-2xl font-bold">{{ $transaksiHariIni ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border">
                    <p class="text-xs text-gray-500">Pendapatan</p>
                    <p class="text-xl font-bold">
                        Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border">
                    <p class="text-xs text-gray-500">Item terjual</p>
                    <p class="text-2xl font-bold">{{ $itemTerjual ?? 0 }}</p>
                </div>
            </div>

            {{-- 🔍 FILTER --}}
            <form method="GET" class="bg-white border rounded-xl p-4 flex flex-col md:flex-row gap-3 shadow-sm">

                <input type="text" name="search" placeholder="Cari transaksi..." value="{{ request('search') }}"
                    class="flex-1 border-gray-200 rounded-lg text-sm">

                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="border-gray-200 rounded-lg text-sm">

                <select name="metode" class="border-gray-200 rounded-lg text-sm">
                    <option value="">Semua Metode</option>

                    @foreach ($metodePembayaran as $metode)
                        <option value="{{ $metode }}" {{ request('metode') == $metode ? 'selected' : '' }}>
                            {{ ucfirst($metode) }}
                        </option>
                    @endforeach

                </select>
                <!-- <select name="jenis_transaksi" class="border-gray-200 rounded-lg text-sm">
                    <option value="">Semua Jenis</option>

                    @foreach ($jenisTransaksi as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis_transaksi') == $jenis ? 'selected' : '' }}>
                            {{ ucfirst($jenis) }}
                        </option>
                    @endforeach
                </select> -->

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                    Filter
                </button>

            </form>

            {{-- MAIN LAYOUT: TABEL + PREVIEW STRUK --}}
            <div class="flex flex-col lg:flex-row gap-5 items-start">

                {{-- TABEL TRANSAKSI --}}
                <div class="flex-1 bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Transaksi terakhir</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Cara Bayar</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">

                                <template x-for="(t,i) in filteredData" :key="t.id_penjualan">
                                    <tr @click="loadStruk(t.id_penjualan)"
                                        class="cursor-pointer transition-all border-l-4" :class="activeId === t.id_penjualan
                ? 'bg-blue-50 border-blue-500'
                : 'hover:bg-gray-50 border-transparent'">

                                        <td class="px-4 py-3 text-gray-400" x-text="i + 1"></td>

                                        <td class="px-4 py-3 text-gray-700 font-medium" x-text="t.tanggal_penjualan">
                                        </td>

                                        <td class="px-4 py-3 text-gray-800 font-medium"
                                            x-text="'Rp ' + fmt(t.total_faktur)">
                                        </td>

                                        <td class="px-4 py-3 text-gray-600 capitalize" x-text="t.cara_bayar || '-'">
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="inline-block text-xs font-medium px-2 py-1 rounded-md" :class="{
                        'bg-green-50 text-green-700': t.status_pembayaran === 'lunas',
                        'bg-red-50 text-red-600': t.status_pembayaran === 'hutang',
                        'bg-gray-100 text-gray-500': !['lunas','hutang'].includes(t.status_pembayaran)
                    }" x-text="t.status_pembayaran">
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <button @click.stop="loadStruk(t.id_penjualan)"
                                                class="text-xs px-3 py-1.5 rounded-lg border transition" :class="activeId === t.id_penjualan
                        ? 'border-blue-300 bg-blue-100 text-blue-700'
                        : 'border-gray-200 text-gray-600 hover:bg-gray-100'">
                                                Preview
                                            </button>
                                        </td>

                                    </tr>
                                </template>

                                {{-- EMPTY --}}
                                <tr x-show="filteredData.length === 0">
                                    <td colspan="6" class="text-center py-10 text-gray-400 text-sm">
                                        Belum ada transaksi
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($transaksiTerakhir->hasPages())
                        <div class="px-5 py-4 border-t border-gray-100">
                            {{ $transaksiTerakhir->links() }}
                        </div>
                    @endif
                </div>

                {{-- PREVIEW STRUK --}}
                <div class="w-full lg:w-72 bg-white border border-gray-200 rounded-xl overflow-hidden sticky top-4">

                    {{-- Panel header --}}
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Preview struk</p>
                        <button x-show="showPreview && !isLoading" @click="printStruk()"
                            class="text-xs px-3 py-1.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                            Cetak
                        </button>
                    </div>

                    {{-- Empty state --}}
                    <div x-show="!showPreview && !isLoading" class="py-14 text-center px-4">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3 text-base">
                            🧾
                        </div>
                        <p class="text-xs text-gray-400">Pilih transaksi untuk melihat struk</p>
                    </div>

                    {{-- Loading skeleton --}}
                    <div x-show="isLoading" class="p-5 space-y-3 animate-pulse">
                        {{-- Store header skeleton --}}
                        <div class="space-y-1.5 mb-4">
                            <div class="h-3 bg-gray-200 rounded w-2/3 mx-auto"></div>
                            <div class="h-2 bg-gray-100 rounded w-1/2 mx-auto"></div>
                            <div class="h-2 bg-gray-100 rounded w-1/3 mx-auto"></div>
                        </div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        {{-- Info rows skeleton --}}
                        <div class="space-y-2 py-1">
                            <div class="flex justify-between">
                                <div class="h-2 bg-gray-100 rounded w-1/4"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/3"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="h-2 bg-gray-100 rounded w-1/4"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/4"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="h-2 bg-gray-100 rounded w-1/3"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/4"></div>
                            </div>
                        </div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        {{-- Item skeletons --}}
                        <div class="space-y-3">
                            <div x-for="n in [1,2,3]" class="space-y-1">
                                <div class="flex justify-between">
                                    <div class="h-2.5 bg-gray-200 rounded w-2/5"></div>
                                    <div class="h-2.5 bg-gray-200 rounded w-1/4"></div>
                                </div>
                                <div class="h-2 bg-gray-100 rounded w-1/3"></div>
                            </div>
                        </div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        {{-- Total skeleton --}}
                        <div class="space-y-1.5">
                            <div class="flex justify-between">
                                <div class="h-3 bg-gray-300 rounded w-1/4"></div>
                                <div class="h-3 bg-gray-300 rounded w-1/3"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="h-2 bg-gray-100 rounded w-1/5"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/4"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="h-2 bg-gray-100 rounded w-1/5"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/4"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Struk content --}}
                    <div x-show="showPreview && !isLoading" x-transition>
                        <div id="print-area" class="p-5 font-mono text-[11px] leading-relaxed text-gray-800">

                            <p class="text-center font-bold text-sm">TOKO KAMU</p>
                            <p class="text-center text-gray-500 text-[10px]">Jl. Contoh No. 123</p>
                            <p class="text-center text-gray-500 text-[10px]">Telp: 08123456789</p>

                            <div class="border-t border-dashed border-gray-300 my-3"></div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal</span>
                                <span x-text="struk.tanggal"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kasir</span>
                                <span x-text="struk.kasir"></span>
                            </div>
                            <div class="flex justify-between" x-show="struk.pelanggan">
                                <span class="text-gray-500">Pelanggan</span>
                                <span x-text="struk.pelanggan"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Cara Bayar</span>
                                <span x-text="struk.cara_bayar" class="capitalize"></span>
                            </div>

                            <div class="border-t border-dashed border-gray-300 my-3"></div>

                            <template x-for="item in struk.items" :key="item.nama">
                                <div class="mb-2">
                                    <div class="flex justify-between font-semibold">
                                        <span x-text="item.nama"></span>
                                        <span x-text="'Rp ' + fmt(item.subtotal)"></span>
                                    </div>
                                    <div class="text-gray-400 text-[10px]">
                                        <span x-text="item.qty + ' x Rp ' + fmt(item.harga)"></span>
                                    </div>
                                </div>
                            </template>

                            <div class="border-t border-dashed border-gray-300 my-3"></div>

                            <div class="flex justify-between font-bold text-sm">
                                <span>Total</span>
                                <span x-text="'Rp ' + fmt(struk.total_faktur)"></span>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-gray-500">Bayar</span>
                                <span x-text="'Rp ' + fmt(struk.total_bayar)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kembali</span>
                                <span x-text="'Rp ' + fmt(struk.kembalian)"></span>
                            </div>

                            <template x-if="struk.note">
                                <div class="mt-2">
                                    <div class="border-t border-dashed border-gray-300 my-3"></div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Catatan</span>
                                        <span x-text="struk.note" class="text-right max-w-[120px]"></span>
                                    </div>
                                </div>
                            </template>

                            <div class="border-t border-dashed border-gray-300 my-3"></div>

                            <p class="text-center text-gray-500">*** Terima kasih ***</p>
                            <p class="text-center text-gray-400 text-[10px]">Barang tidak dapat dikembalikan</p>
                        </div>
                    </div>

                    {{-- Error state --}}
                    <div x-show="hasError" class="py-10 text-center px-4">
                        <div
                            class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3 text-base">
                            ⚠️
                        </div>
                        <p class="text-xs text-red-400">Gagal memuat struk. Coba lagi.</p>
                        <button @click="loadStruk(activeId)"
                            class="mt-3 text-xs px-3 py-1.5 border border-red-200 rounded-lg text-red-500 hover:bg-red-50 transition">
                            Coba lagi
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- ALPINE JS --}}
    <script>
        function strukApp() {
            return {
                showPreview: false,
                isLoading: false,
                hasError: false,
                activeId: null,
                struk: {
                    tanggal: '',
                    kasir: '',
                    pelanggan: '',
                    cara_bayar: '',
                    note: '',
                    total_faktur: 0,
                    total_bayar: 0,
                    kembalian: 0,
                    items: []
                },

                search: '',
                filter: {
                    tanggal: '',
                    status: '',
                    metode: ''
                },

                dataTransaksi: {!! json_encode($transaksiTerakhir->items()) !!},

                init() {
                    this.filteredData = this.dataTransaksi || []
                },

                applyFilter() {
                    this.filteredData = (this.dataTransaksi || []).filter(t => {

                        const matchSearch =
                            this.search === '' ||
                            (t.total_faktur && t.total_faktur.toString().includes(this.search))

                        const matchTanggal =
                            !this.filter.tanggal ||
                            (t.tanggal_penjualan && t.tanggal_penjualan.slice(0, 10) === this.filter.tanggal)

                        const matchStatus =
                            !this.filter.status ||
                            t.status_pembayaran === this.filter.status

                        const matchMetode =
                            !this.filter.metode ||
                            t.cara_bayar === this.filter.metode

                        return matchSearch && matchTanggal && matchStatus && matchMetode
                    })
                },

                async loadStruk(id) {
                    this.hasError = false; // ✅ FIX
                    // Jika klik baris yang sama, tidak perlu reload
                    if (this.activeId === id && this.showPreview) return

                    this.activeId = id
                    this.isLoading = true
                    this.showPreview = false
                    this.hasError = false

                    try {
                        const res = await fetch(`/kasir/cetak-struk/${id}`)

                        if (!res.ok) throw new Error(`HTTP ${res.status}`)

                        const data = await res.json()
                        this.struk = data
                        this.showPreview = true
                    } catch (e) {
                        this.hasError = true
                    } finally {
                        this.isLoading = false
                    }
                },

                printStruk() {
                    const content = document.getElementById('print-area').innerHTML
                    const win = window.open('', '', 'width=320,height=600')
                    win.document.write(`
                        <html>
                            <head>
                                <title>Struk</title>
                                <style>
                                    * { box-sizing: border-box; margin: 0; padding: 0; }
                                    body {
                                        font-family: 'Courier New', monospace;
                                        font-size: 11px;
                                        padding: 16px;
                                        line-height: 1.8;
                                        color: #111;
                                    }
                                    .text-center { text-align: center; }
                                    .font-bold { font-weight: bold; }
                                    .font-semibold { font-weight: 600; }
                                    .text-sm { font-size: 13px; }
                                    .text-gray-500, .text-gray-400 { color: #666; }
                                    .flex { display: flex; }
                                    .justify-between { justify-content: space-between; }
                                    .my-3 { margin: 10px 0; }
                                    .mb-2 { margin-bottom: 8px; }
                                    .mt-1 { margin-top: 4px; }
                                    .mt-2 { margin-top: 8px; }
                                    .border-t { border-top: 1px dashed #bbb; }
                                    .capitalize { text-transform: capitalize; }
                                    .text-right { text-align: right; }
                                    .max-w-\[120px\] { max-width: 120px; }
                                </style>
                            </head>
                            <body>${content}</body>
                        </html>
                    `)
                    win.document.close()
                    win.print()
                },

                fmt(angka) {
                    return new Intl.NumberFormat('id-ID').format(angka)
                }
            }
        }
    </script>

</x-app-layout>