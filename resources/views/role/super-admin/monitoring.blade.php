<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            📈 Monitoring Sistem
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- 🔥 RINGKASAN GLOBAL --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h3 class="font-semibold text-lg mb-4">Ringkasan Global</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-indigo-50 dark:bg-gray-700 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <h3 class="text-2xl font-bold">{{ $totalTransaksi ?? 1200 }}</h3>
                </div>

                <div class="bg-green-50 dark:bg-gray-700 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($totalPendapatan ?? 25000000, 0, ',', '.') }}
                    </h3>
                </div>

            </div>
        </div>

        {{-- 🔥 GRID 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- 🏫 AKTIVITAS SEKOLAH --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h3 class="font-semibold mb-4">Aktivitas Sekolah</h3>

                <div class="space-y-3 text-sm">

                    @forelse ($schools ?? [] as $school)
                        <div class="flex justify-between items-center border-b pb-2">
                            <span>{{ $school->nama_sekolah }}</span>

                            @if ($school->is_active)
                                <span class="text-green-500 font-medium">Aktif</span>
                            @else
                                <span class="text-red-500 font-medium">Offline</span>
                            @endif
                        </div>
                    @empty
                        <div class="text-gray-400 text-center">Tidak ada data</div>
                    @endforelse

                </div>
            </div>

            {{-- ⚠️ ALERT --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h3 class="font-semibold mb-4">Alert</h3>

                <div class="space-y-3 text-sm">

                    @forelse ($alerts ?? [] as $alert)
                        <div class="flex items-center gap-2 text-yellow-600">
                            ⚠️ <span>{{ $alert }}</span>
                        </div>
                    @empty
                        <div class="text-gray-400">Tidak ada alert</div>
                    @endforelse

                </div>
            </div>

        </div>

        {{-- 👤 AKTIVITAS USER --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Aktivitas User</h3>

            <div class="space-y-3 text-sm">

                @forelse ($activities ?? [] as $act)
                    <div class="flex justify-between border-b pb-2">
                        <div>
                            <div class="font-medium">{{ $act->nama }}</div>
                            <div class="text-gray-400 text-xs">{{ $act->action }}</div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $act->time }}</span>
                    </div>
                @empty
                    <div class="text-gray-400 text-center">Belum ada aktivitas</div>
                @endforelse

            </div>
        </div>

    </div>
</x-app-layout>