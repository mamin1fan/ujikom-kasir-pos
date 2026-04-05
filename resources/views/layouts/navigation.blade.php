{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="flex flex-col h-full bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800">

    {{-- LOGO --}}
    <div class="flex items-center gap-3 px-4 h-14 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
        <div class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-950 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-base font-semibold text-gray-900 dark:text-white tracking-tight">SIMart</p>
            <p class="text-xs leading-none mt-0.5">
                @if (session('mode') === 'operasional')
                    <span class="text-emerald-600 dark:text-emerald-400 font-medium">Mode Operasional</span>
                @elseif (auth()->user()?->role?->nama_role === 'super admin')
                    <span class="text-gray-500 dark:text-gray-400">Super Admin</span>
                @elseif (auth()->user()?->role?->nama_role === 'admin')
                    <span class="text-gray-500 dark:text-gray-400">Administrator</span>
                @else
                    <span class="text-gray-500 dark:text-gray-400">Kasir</span>
                @endif
            </p>
        </div>
    </div>



    {{-- NAV BODY --}}
    <div class="flex-1 overflow-y-auto py-3 px-2 space-y-1">

        @auth
            @php $role = auth()->user()->role->nama_role; @endphp

            {{-- ══════════════════════════════════════
            MODE OPERASIONAL
            ══════════════════════════════════════ --}}
            @if (session('mode') === 'operasional')

                <div
                    class="mx-1 mb-3 p-3 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 rounded-2xl">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-semibold text-emerald-700 dark:text-emerald-400 uppercase tracking-wide">Sekolah
                            Aktif</span>
                        <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-500">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Online
                        </span>
                    </div>
                    <p class="font-semibold text-sm text-emerald-900 dark:text-emerald-100 leading-snug">
                        {{ session('nama_sekolah', 'Nama Sekolah') }}
                    </p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-0.5">{{ session('kode_sekolah', '-') }}</p>
                </div>

                @if ($role === 'kasir')

                    {{-- ── Kasir (mode operasional) ── --}}
                    @php
                        $kasirOpMenu = [
                            ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'kasir.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'kasir.rekap.harian*', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                            ['route' => 'kasir.cetak.struk', 'label' => 'Cetak Struk', 'match' => 'kasir.cetak.struk*', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
                        ];
                    @endphp
                    <x-nav-section label="Kasir" :items="$kasirOpMenu" />

                @else

                    {{-- ── Admin / Super Admin (mode operasional) ── --}}
                    @php
                        $dashboard = [
                            ['route' => 'panel.operasional', 'label' => 'Dashboard MODE : Sekolah (Operasional)', 'match' => 'panel.operasional', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                        ];
                        $opInventaris = [
                        ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                        ['route' => 'admin.barang.index', 'label' => 'Daftar Barang', 'match' => 'admin.barang.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['route' => 'admin.laporan.produk', 'label' => 'Analisis Barang', 'match' => 'admin.laporan.produk.*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'admin.laporan.pembelian', 'label' => 'Laporan Pembelian', 'match' => 'admin.laporan.pembelian.*', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                            ['route' => 'admin.transaksi.pembelian.index', 'label' => 'Restok Barang', 'match' => 'admin.transaksi.pembelian.*', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                        ];

                        $opUtilitas = [
                            [
                                'route' => 'super-admin.restore.index',
                                'params' => ['type' => 'barang'],
                                'label' => 'Restore Data',
                                'match' => 'super-admin.restore.*',
                                'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'
                            ],
                        ];
                    @endphp

                    <x-nav-section label="Dashboard" :items="$dashboard" />

                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>
                    <x-nav-section label="Inventaris" :items="$opInventaris" />

                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>
                    <x-nav-section label="Utilitas" :items="$opUtilitas" />

                @endif

                {{-- ══════════════════════════════════════
                MODE NORMAL
                ══════════════════════════════════════ --}}
            @else

                {{-- ─── KASIR ─── --}}
                @if ($role === 'kasir')

                    @php
                        $dashboardMenu = [
                            ['route' => 'kasir.dashboard', 'label' => 'Dashboard', 'match' => 'kasir.dashboard', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                        ];

                        $kasirLaporanMenu = [
                            ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'kasir.laporan.produk', 'label' => 'Analisis Produk', 'match' => 'kasir.laporan.produk*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'kasir.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'kasir.rekap.harian*', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                            ['route' => 'kasir.cetak.struk', 'label' => 'Cetak Struk', 'match' => 'kasir.cetak.struk*', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
                        ];
                    @endphp
                    <x-nav-section label="Dashboard" :items="$dashboardMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>


                    <x-nav-section label="Laporan & Utilitas" :items="$kasirLaporanMenu" />

                    {{-- ─── SUPER ADMIN ─── --}}
                @elseif ($role === 'super admin')

                    @php
                        $saMenu = [
                            ['route' => 'super-admin.dashboard', 'label' => 'Dashboard', 'match' => 'super-admin.dashboard', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                            ['route' => 'super-admin.sekolah.index', 'label' => 'Kelola Sekolah', 'match' => 'super-admin.sekolah.*', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5'],
                            ['route' => '#', 'label' => 'Users Global', 'match' => 'super-admin.user.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                        ];
                    @endphp
                    <x-nav-section label="Manajemen Sistem" :items="$saMenu" />

                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-600 uppercase tracking-widest px-3 pb-1">Sistem</p>
                    <x-nav-item-disabled label="Monitoring" badge="Soon"
                        icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    <x-nav-item-disabled label="Pengaturan Global" badge="Soon"
                        icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z|M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                    {{-- ─── ADMIN ─── --}}
                @elseif ($role === 'admin')

                    {{-- Dashboard standalone --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors mb-1
                                                    {{ request()->routeIs('admin.dashboard')
                            ? 'bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
                        </svg>
                        Dashboard
                    </a>

                    @php
                        $produkMenu = [
                            ['route' => 'admin.barang.index', 'label' => 'Daftar Barang', 'match' => 'admin.barang.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['route' => 'admin.kategori.index', 'label' => 'Kategori', 'match' => 'admin.kategori.*', 'icon' => 'M7 7h10M7 12h10M7 17h10'],
                            ['route' => 'admin.kelompok.kategori.index', 'label' => 'Kelompok Kategori', 'match' => 'admin.kelompok.kategori.*', 'icon' => 'M4 6h16M4 12h8m-8 6h16'],
                        ];
                        $pihakMenu = [
                            ['route' => 'admin.supplier.index', 'label' => 'Supplier', 'match' => 'admin.supplier.*', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                            ['route' => 'admin.pelanggan.index', 'label' => 'Pelanggan', 'match' => 'admin.pelanggan.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['route' => 'admin.kelompok.pelanggan.index', 'label' => 'Kelompok Pelanggan', 'match' => 'admin.kelompok.pelanggan.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                        ];
                        $pembelianMenu = [
                            ['route' => 'admin.transaksi.pembelian.index', 'label' => 'Restok Barang', 'match' => 'admin.transaksi.pembelian.*', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'admin.laporan.pembelian.index', 'label' => 'Laporan Pembelian', 'match' => 'admin.laporan.pembelian.*', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                        ];
                        $penjualanMenu = [

                            ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],

                        ];
                        $laporanMenu = [
                            ['route' => 'admin.laporan.produk', 'label' => 'Analisis Produk & Stok', 'match' => 'admin.laporan.produk*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'admin.laporan.stok', 'label' => 'Laporan Stok', 'match' => 'admin.laporan-stok.*', 'icon' => 'M3 3v18h18'],
                        ];
                    @endphp

                    <x-nav-section label="Produk & Inventaris" :items="$produkMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>

                    <x-nav-section label="Pihak Ketiga" :items="$pihakMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>

                    <x-nav-section label="Pembelian" :items="$pembelianMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>

                    <x-nav-section label="Penjualan" :items="$penjualanMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>

                    <x-nav-section label="Laporan & Analisis" :items="$laporanMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 mx-1 my-2"></div>

                    <x-nav-section label="Pengguna & Akses" :items="[
                                ['route' => 'admin.user.index', 'label' => 'Kelola User', 'match' => 'admin.user.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                            ]" />

                @endif
            @endif
        @endauth

    </div>

    {{-- FOOTER --}}
    <div class="border-t border-gray-100 dark:border-gray-800 p-3 flex-shrink-0">

        @if (session('mode') !== 'operasional' && auth()->check())
            <div class="flex items-center gap-2.5 px-2 py-1.5 mb-2 bg-gray-50 dark:bg-gray-800 rounded-xl">
                <div
                    class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">
                        {{ auth()->user()->username }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->nama_lengkap ?? '-' }}</p>
                </div>
            </div>
        @endif

        @if (session('mode') === 'operasional')
            <form method="GET" action="{{ route('super-admin.keluar-mode') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/70 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Keluar Mode Operasional
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/70 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Keluar
                </button>
            </form>
        @endif

    </div>

</nav>