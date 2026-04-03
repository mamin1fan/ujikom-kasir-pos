<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Kasir
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">

                {{-- TEXT --}}
                <div>
                    <h3 class="text-xl font-bold">Mulai Transaksi 🚀</h3>
                    <p class="text-sm opacity-80">Klik tombol di samping untuk membuka kasir</p>
                </div>

                {{-- CTA BUTTON (lebih besar & jelas) --}}
                <a href="{{ route('kasir.transaksi') }}"
                    class="bg-white text-blue-600 px-6 py-3 rounded-xl text-sm font-bold shadow hover:scale-105 hover:bg-blue-50 transition flex items-center gap-2">

                    🛒 Mulai Transaksi
                </a>

            </div>

            {{-- 📊 KPI KASIR --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Transaksi Hari Ini --}}
                <div class="bg-white shadow rounded-xl p-5 flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        💳
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold">{{ $transaksiHariIni ?? 0 }}</p>
                    </div>
                </div>

                {{-- Pendapatan Hari Ini --}}
                <div class="bg-white shadow rounded-xl p-5 flex items-center gap-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                        💰
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold">
                            Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Item Terjual --}}
                <div class="bg-white shadow rounded-xl p-5 flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                        📦
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Item Terjual</p>
                        <p class="text-2xl font-bold">{{ $itemTerjual ?? 0 }}</p>
                    </div>
                </div>

            </div>

            {{-- 🧾 TRANSAKSI TERAKHIR --}}
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Transaksi Terakhir</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Total</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiTerakhir ?? [] as $i => $t)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2">{{ $t->no_transaksi }}</td>
                                    <td class="px-4 py-2">
                                        Rp {{ number_format($t->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $t->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-400">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>