<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin POS') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ringkasan KPI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-xl p-5 text-white flex items-center space-x-4 hover:scale-105 transform transition">
                    <div class="p-3 bg-blue-700 rounded-full">
                        <!-- Icon Produk -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Total Barang</p>
                        <p class="text-2xl font-bold">{{ $totalBarang }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 shadow-lg rounded-xl p-5 text-white flex items-center space-x-4 hover:scale-105 transform transition">
                    <div class="p-3 bg-green-700 rounded-full">
                        <!-- Icon Penjualan -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Total Penjualan</p>
                        <p class="text-2xl font-bold">{{ $totalPenjualan }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-red-500 to-red-600 shadow-lg rounded-xl p-5 text-white flex items-center space-x-4 hover:scale-105 transform transition">
                    <div class="p-3 bg-red-700 rounded-full">
                        <!-- Icon Penjualan -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Total pembelian</p>
                        <p class="text-2xl font-bold">{{ $totalPembelian }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 shadow-lg rounded-xl p-5 text-white flex items-center space-x-4 hover:scale-105 transform transition">
                    <div class="p-3 bg-yellow-700 rounded-full">
                        <!-- Icon Member -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-2c0-2.21 3.58-4 6-4s6 1.79 6 4v2H6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Total Pelanggan</p>
                        <p class="text-2xl font-bold">{{ $totalPelanggan }}</p>
                    </div>
                </div>

                
            </div>

            {{-- Placeholder Grafik Penjualan --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 animate-pulse">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Grafik Penjualan Bulanan</h3>
                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-400">
                    Grafik sementara
                </div>
            </div>

            {{-- Placeholder Tabel Transaksi --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 animate-pulse">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Transaksi Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400 uppercase text-xs">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">ID Transaksi</th>
                                <th class="px-4 py-2">Nama Member</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 5; $i++)
                                <tr class="bg-gray-200 dark:bg-gray-700 animate-pulse h-10">
                                    <td colspan="5"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>