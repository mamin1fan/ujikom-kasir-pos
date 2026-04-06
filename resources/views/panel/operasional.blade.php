{{-- resources/views/super-admin/dashboard.blade.php --}}
<x-app-layout>

    @push('styles')
        <style>
            .stat-ring::before {
                content: '';
                position: absolute;
                inset: 0;
                border-radius: inherit;
                background: radial-gradient(ellipse at top right, var(--ring-color, transparent) 0%, transparent 70%);
                opacity: .07;
                pointer-events: none;
            }

            .disabled-shortcut {
                position: relative;
            }

            .disabled-shortcut:hover .disabled-tooltip {
                opacity: 1;
                transform: translateX(0);
            }

            .disabled-tooltip {
                opacity: 0;
                transform: translateX(-4px);
                transition: all .15s;
                pointer-events: none;
            }

            @keyframes pulse-live {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: .35;
                }
            }

            .live-dot {
                animation: pulse-live 1.6s ease-in-out infinite;
            }
        </style>
    @endpush

    {{-- ═══════════════════════════════════════ TOPBAR ═══ --}}
    <div
        class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex items-center justify-between sticky top-0 z-20 backdrop-blur">
        <div>
            <h1 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-violet-500 live-dot"></span>
                Super Admin Panel
            </h1>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ now()->translatedFormat('l, d F Y') }} &middot; <span id="jam-live"
                    class="tabular-nums font-mono"></span>
            </p>
        </div>
        <div
            class="flex items-center gap-2 pl-3 pr-4 py-1.5 bg-violet-50 dark:bg-violet-950/60 border border-violet-200/60 dark:border-violet-800/60 rounded-xl">
            <div
                class="w-6 h-6 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-[10px] font-bold">
                {{ strtoupper(substr(auth()->user()->username ?? 'SA', 0, 2)) }}
            </div>
            <div>
                <p class="text-xs font-semibold text-violet-900 dark:text-violet-100 leading-none">
                    {{ auth()->user()->username ?? 'Super Admin' }}</p>
                <p class="text-[10px] text-violet-500 leading-none mt-0.5">Super Admin</p>
            </div>
        </div>
    </div>

    <div class="py-6 px-4 sm:px-6 max-w-[1400px] mx-auto space-y-5">

        {{-- ═══════════════════════════════════════
        STAT CARDS
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

            <div class="stat-ring relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 overflow-hidden"
                style="--ring-color:#7c3aed">
                <div class="flex items-start justify-between mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-violet-100 dark:bg-violet-900/60 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5" />
                        </svg>
                    </div>
                    <span
                        class="text-[10px] font-bold text-violet-500 bg-violet-50 dark:bg-violet-900/40 px-2 py-0.5 rounded-full">Total</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['totalSekolah'] ?? '—' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Sekolah terdaftar</p>
                <p class="text-[11px] text-green-600 dark:text-green-400 mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    {{ $data['sekolahBaru'] ?? 0 }} baru bulan ini
                </p>
            </div>

            <div class="stat-ring relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 overflow-hidden"
                style="--ring-color:#059669">
                <div class="flex items-start justify-between mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/60 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-600">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full live-dot"></span> Live
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['sekolahAktif'] ?? '—' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Sekolah aktif</p>
                <p class="text-[11px] text-gray-400 mt-2">{{ $data['sekolahNonAktif'] ?? 0 }} nonaktif</p>
            </div>

            <div class="stat-ring relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 overflow-hidden"
                style="--ring-color:#4338ca">
                <div class="flex items-start justify-between mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/60 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1m6-9a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-[10px] font-bold text-indigo-500 bg-indigo-50 dark:bg-indigo-900/40 px-2 py-0.5 rounded-full">Hari
                        ini</span>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">Rp
                    {{ number_format($data['totalPendapatanHariIni'] ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Pendapatan agregat</p>
                <p
                    class="text-[11px] {{ ($data['deltaPendapatan'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-500' }} mt-2">
                    {{ ($data['deltaPendapatan'] ?? 0) >= 0 ? '▲' : '▼' }} {{ abs($data['deltaPendapatan'] ?? 0) }}% vs
                    kemarin
                </p>
            </div>

            <div class="stat-ring relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 overflow-hidden"
                style="--ring-color:#e11d48">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['totalUser'] ?? '—' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Total pengguna</p>
                <p class="text-[11px] text-gray-400 mt-2">Admin + Kasir semua sekolah</p>
            </div>

        </div>

        {{-- ═══════════════════════════════════════
        SHORTCUT PANEL + DAFTAR SEKOLAH
        ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            {{-- SHORTCUT — kiri --}}
            <div
                class="lg:col-span-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Akses Cepat</p>
                </div>
                <div class="p-2 space-y-0.5">

                    {{-- ── ADA ROUTE-NYA ── --}}

                    {{-- Dashboard --}}
                    <a href="{{ route('super-admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-violet-50 dark:hover:bg-violet-950/40 group transition">
                        <div
                            class="w-7 h-7 rounded-lg bg-violet-100 dark:bg-violet-900/60 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
                            </svg>
                        </div>
                        <span
                            class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-violet-700 dark:group-hover:text-violet-300">Dashboard</span>
                    </a>

                    {{-- Semua Sekolah --}}
                    <a href="{{ route('super-admin.sekolah.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-violet-50 dark:hover:bg-violet-950/40 group transition">
                        <div
                            class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/60 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5" />
                            </svg>
                        </div>
                        <span
                            class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-violet-700 dark:group-hover:text-violet-300">Semua
                            Sekolah</span>
                    </a>

                    {{-- Kelola User Global --}}
                    <a href="{{ route('super-admin.user.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-violet-50 dark:hover:bg-violet-950/40 group transition">
                        <div
                            class="w-7 h-7 rounded-lg bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
                            </svg>
                        </div>
                        <span
                            class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-violet-700 dark:group-hover:text-violet-300">Kelola
                            User</span>
                    </a>

                    {{-- Restore Data --}}
                    <a href="{{ route('super-admin.restore.index', ['type' => 'barang']) }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-violet-50 dark:hover:bg-violet-950/40 group transition">
                        <div
                            class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/60 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <span
                            class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-violet-700 dark:group-hover:text-violet-300">Restore
                            Data</span>
                    </a>

                    <div class="h-px bg-gray-100 dark:bg-gray-700/60 my-1 mx-2"></div>
                    <p
                        class="text-[10px] font-bold text-gray-300 dark:text-gray-600 uppercase tracking-widest px-3 py-1">
                        Segera Hadir</p>

                    {{-- ── BELUM ADA ROUTE — disabled ── --}}
                    @php
                        $comingSoon = [
                            ['label' => 'Laporan Pembelian', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7', 'color' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-400'],
                            ['label' => 'Laporan Stok', 'icon' => 'M3 3v18h18', 'color' => 'bg-teal-100 dark:bg-teal-900/40 text-teal-400'],
                            ['label' => 'Analisis Produk', 'icon' => 'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-400'],
                            ['label' => 'Rekap Harian', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z', 'color' => 'bg-orange-100 dark:bg-orange-900/40 text-orange-400'],
                            ['label' => 'Pengaturan Global', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'bg-gray-100 dark:bg-gray-700 text-gray-400'],
                        ];
                    @endphp
                    @foreach ($comingSoon as $cs)
                        <div
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl cursor-not-allowed select-none opacity-50">
                            <div
                                class="w-7 h-7 rounded-lg {{ $cs['color'] }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $cs['icon'] }}" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-400 dark:text-gray-500 flex-1">{{ $cs['label'] }}</span>
                            <span
                                class="text-[9px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-400 px-1.5 py-0.5 rounded">Soon</span>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- DAFTAR SEKOLAH — kanan --}}
            <div
                class="lg:col-span-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                <div
                    class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Daftar Sekolah</p>
                        <p class="text-xs text-gray-400">Pantau atau masuk ke konteks sekolah tertentu</p>
                    </div>
                    <a href="{{ route('super-admin.sekolah.index') }}"
                        class="text-xs font-medium text-violet-600 dark:text-violet-400 hover:underline">
                        Kelola semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/40">
                                <th
                                    class="px-5 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    Sekolah</th>
                                <th
                                    class="px-4 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    Kota</th>
                                <th
                                    class="px-4 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    Pantau</th>
                                <th
                                    class="px-4 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    Operasional</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse ($data['daftarSekolah'] ?? [] as $sekolah)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-950/10 transition">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                                {{ strtoupper(substr($sekolah->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ Str::limit($sekolah->nama, 30) }}</p>
                                                <p class="text-[10px] text-gray-400">{{ $sekolah->npsn ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $sekolah->kota ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if (($sekolah->status ?? 'aktif') === 'aktif')
                                            <span
                                                class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/60 dark:border-emerald-800/50 px-2 py-0.5 rounded-full">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        @else
                                            <span
                                                class="text-[11px] font-medium text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- route: super-admin.pantau (param: id) ✓ --}}
                                        <a href="{{ route('super-admin.pantau', $sekolah->id) }}"
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200/60 dark:border-indigo-800/50 rounded-lg px-3 py-1 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3-8a8 8 0 100 16A8 8 0 009 4z" />
                                            </svg>
                                            Pantau
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- Masuk mode operasional — arahkan ke route impersonate sekolah --}}
                                        {{-- Sesuaikan action ini dengan route impersonate kamu --}}
                                        <a href="{{ route('super-admin.sekolah.index') }}?masuk={{ $sekolah->id }}"
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 border border-violet-200/60 dark:border-violet-800/50 rounded-lg px-3 py-1 hover:bg-violet-100 dark:hover:bg-violet-900 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                            Masuk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-8 h-8 text-gray-200 dark:text-gray-700" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5" />
                                            </svg>
                                            <p class="text-sm text-gray-400">Belum ada sekolah terdaftar</p>
                                            <a href="{{ route('super-admin.sekolah.index') }}"
                                                class="text-xs text-violet-600 hover:underline">Tambah sekolah →</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ═══════════════════════════════════════
        GRAFIK PENDAPATAN 7 HARI
        ═══════════════════════════════════════ --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Pendapatan Agregat Semua Sekolah</p>
                    <p class="text-xs text-gray-400">7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-violet-400"></span>
                        Pendapatan</span>
                    <span class="flex items-center gap-1.5"><span
                            class="w-3 h-3 rounded bg-indigo-200 dark:bg-indigo-700"></span> Pembelian</span>
                </div>
            </div>
            <div class="p-5">
                @php
                    $chartDays = collect($data['grafikPendapatan'] ?? []);
                    $maxVal = $chartDays->max('pendapatan') ?: 1;
                @endphp
                <div class="flex items-end justify-between gap-2 h-36">
                    @forelse ($chartDays as $day)
                        @php
                            $pct = max(4, round(($day->pendapatan / $maxVal) * 100));
                            $bPct = max(0, round((($day->pembelian ?? 0) / $maxVal) * 100));
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1 group cursor-default"
                            title="Pendapatan: Rp {{ number_format($day->pendapatan, 0, ',', '.') }}">
                            <div class="w-full flex items-end gap-0.5 h-28">
                                <div class="flex-1 bg-violet-400 dark:bg-violet-500 rounded-t-md group-hover:bg-violet-500 transition"
                                    style="height:{{ $pct }}%"></div>
                                <div class="flex-1 bg-indigo-200 dark:bg-indigo-700 rounded-t-md group-hover:bg-indigo-300 dark:group-hover:bg-indigo-600 transition"
                                    style="height:{{ $bPct }}%"></div>
                            </div>
                            <span class="text-[10px] text-gray-400">
                                {{ \Carbon\Carbon::parse($day->tanggal ?? now())->format('D') }}
                            </span>
                        </div>
                    @empty
                        @foreach(range(1, 7) as $i)
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full flex items-end gap-0.5 h-28">
                                    <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-t-md animate-pulse"
                                        style="height:{{ rand(20, 85) }}%"></div>
                                    <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-t-md animate-pulse"
                                        style="height:{{ rand(10, 55) }}%"></div>
                                </div>
                                <span class="text-[10px] text-gray-300 dark:text-gray-600">—</span>
                            </div>
                        @endforeach
                    @endforelse
                </div>

                <div class="flex justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-xs text-gray-400">Total 7 hari</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Rp {{ number_format($chartDays->sum('pendapatan'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400">Rata-rata/hari</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Rp
                            {{ number_format($chartDays->count() > 0 ? $chartDays->avg('pendapatan') : 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            (function tick() {
                const el = document.getElementById('jam-live');
                if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                setTimeout(tick, 1000);
            })();
        </script>
    @endpush

</x-app-layout>