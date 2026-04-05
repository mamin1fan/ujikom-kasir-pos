<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Superadmin Dashboard</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Monitor seluruh sistem kasir sekolah</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 px-3 py-1.5 rounded-lg">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block animate-pulse"></span>
                <span id="sa-clock">--:--:--</span>
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- ── STAT CARDS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Sekolah</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 leading-tight">{{ $totalSekolah ?? 25 }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Sekolah Aktif</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 leading-tight">{{ $sekolahAktif ?? 20 }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total User</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 leading-tight">{{ $totalUser ?? 1240 }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-cyan-100 dark:bg-cyan-900/50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 leading-tight">{{ $transaksiHariIni ?? 540 }}</p>
                </div>
            </div>

        </div>

        {{-- ── MAIN GRID ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Tabel Sekolah --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                {{-- Panel header --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Sekolah</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                            </svg>
                            <input type="text" placeholder="Cari sekolah..."
                                class="pl-8 pr-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 w-48"
                                oninput="filterSekolah(this.value)">
                        </div>
                        <button class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="sekolahTable">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/40">
                                <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Nama Sekolah</th>
                                <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Status</th>
                                <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">User</th>
                                <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-4 py-3">Last Active</th>
                                <th class="text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700" id="sekolahBody">
                            @forelse($schools ?? [] as $school)
                                <tr class="sekolah-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-name="{{ strtolower($school->nama_sekolah) }}">
                                    <td class="px-5 py-3.5 font-medium text-gray-800 dark:text-gray-200">{{ $school->nama_sekolah }}</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                            {{ $school->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400' }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $school->is_active ? 'Aktif' : 'Suspend' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400">{{ $school->total_user }}</td>
                                    <td class="px-4 py-3.5 text-gray-500 dark:text-gray-500 text-xs">{{ $school->last_active }}</td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-xs font-semibold">Detail →</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-12 text-gray-400 dark:text-gray-600 text-sm">Tidak ada data sekolah</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right: Insight + Progress --}}
            <div class="space-y-4">

                {{-- Insight --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Insight Sistem</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sekolah Aktif</span>
                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $sekolahAktif ?? 20 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sekolah Suspend</span>
                            <span class="text-sm font-bold text-red-500 dark:text-red-400">{{ $sekolahSuspend ?? 5 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Avg User / Sekolah</span>
                            <span class="text-sm font-bold text-amber-600 dark:text-amber-400">{{ $avgUser ?? 49 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Transaksi Bulan Ini</span>
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $transaksiMonth ?? '12.4k' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Utilisasi --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Utilisasi Sekolah</h3>
                    <div class="space-y-4">
                        @php
                            $utilItems = [
                                ['SMKN 1 Bandung', 82],
                                ['SMA Merdeka',    67],
                                ['SMK Telkom',     54],
                                ['SMPN 5 Cimahi',  38],
                            ];
                        @endphp
                        @foreach($utilItems as $u)
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">{{ $u[0] }}</span>
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $u[1] }}%</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 dark:bg-indigo-400 rounded-full transition-all duration-700"
                                        style="width:{{ $u[1] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-600 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                        Data real-time sistem
                    </p>
                </div>

            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function updateClock() {
            document.getElementById('sa-clock').textContent =
                new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
        }
        updateClock(); setInterval(updateClock, 1000);

        function filterSekolah(val) {
            document.querySelectorAll('.sekolah-row').forEach(row => {
                row.style.display = row.dataset.name.includes(val.toLowerCase()) ? '' : 'none';
            });
        }
    </script>
    @endpush

</x-app-layout>