{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="flex flex-col h-full bg-white dark:bg-gray-950 border-r border-gray-100 dark:border-gray-800/60">

    {{-- LOGO --}}
    <div class="flex items-center gap-3 px-4 h-14 border-b border-gray-100 dark:border-gray-800/60 flex-shrink-0">
        <div
            class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-bold text-gray-900 dark:text-white tracking-tight leading-none">SIMart</p>
            <p class="text-xs leading-none mt-0.5">
                @if (session('mode') === 'operasional')
                    <span class="text-emerald-600 dark:text-emerald-400 font-medium">Mode Operasional</span>
                @elseif (auth()->user()?->role?->nama_role === 'super admin')
                    <span class="text-violet-500 dark:text-violet-400 font-medium">Super Admin</span>
                @elseif (auth()->user()?->role?->nama_role === 'admin')
                    <span class="text-indigo-500 dark:text-indigo-400 font-medium">Administrator</span>
                @else
                    <span class="text-gray-400 dark:text-gray-500">Kasir</span>
                @endif
            </p>
        </div>
    </div>

    {{-- NAV BODY --}}
    <div class="flex-1 overflow-y-auto py-3 px-2.5 space-y-0.5">

        @auth
            @php $role = auth()->user()->role->nama_role; @endphp

            {{-- ══════════════════════════════════════
            MODE OPERASIONAL
            ══════════════════════════════════════ --}}
            @if (session('mode') === 'operasional')

                <div
                    class="mx-0.5 mb-3 p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/70 dark:border-emerald-800/50 rounded-2xl">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span
                            class="font-semibold text-emerald-700 dark:text-emerald-400 uppercase tracking-wide text-[10px]">Sekolah
                            Aktif</span>
                        <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-500 text-[10px]">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Online
                        </span>
                    </div>
                    <p class="font-semibold text-sm text-emerald-900 dark:text-emerald-100 leading-snug">
                        {{ session('nama_sekolah', 'Nama Sekolah') }}
                    </p>
                    <p class="text-[11px] text-emerald-600 dark:text-emerald-400 mt-0.5">{{ session('kode_sekolah', '-') }}</p>
                </div>

                @if ($role === 'kasir')
                    @php
                        $kasirOpMenu = [
                            ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'kasir.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'kasir.rekap.harian*', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                            ['route' => 'kasir.cetak.struk', 'label' => 'Cetak Struk', 'match' => 'kasir.cetak.struk*', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
                        ];
                    @endphp
                    <x-nav-section label="Kasir" :items="$kasirOpMenu" />
                @else
                    @php
                        $dashboard = [
                            ['route' => 'panel.operasional', 'label' => 'Dashboard Operasional', 'match' => 'panel.operasional', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                        ];
                        $opInventaris = [
                            ['route' => 'kasir.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'admin.barang.index', 'label' => 'Daftar Barang', 'match' => 'admin.barang.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['route' => 'admin.laporan.produk', 'label' => 'Analisis Barang', 'match' => 'admin.laporan.produk*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'admin.laporan.pembelian', 'params' => ['mode' => 'today'], 'label' => 'Laporan Pembelian', 'match' => 'admin.laporan.pembelian*', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                            ['route' => 'admin.transaksi.pembelian.index', 'label' => 'Restok Barang', 'match' => 'admin.transaksi.pembelian.*', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                        ];
                        $opUtilitas = [
                            ['route' => 'super-admin.restore.index', 'params' => ['type' => 'barang'], 'label' => 'Restore Data', 'match' => 'super-admin.restore.*', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                        ];
                    @endphp
                    <x-nav-section label="Dashboard" :items="$dashboard" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Inventaris" :items="$opInventaris" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
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
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Laporan & Utilitas" :items="$kasirLaporanMenu" />

                    {{-- ─── SUPER ADMIN ─── --}}
                @elseif ($role === 'super admin')

                    {{-- Dashboard — route: super-admin.dashboard ✓ --}}
                    <a href="{{ route('super-admin.dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-all mb-0.5
                                                    {{ request()->routeIs('super-admin.dashboard')
                            ? 'bg-violet-50 dark:bg-violet-950/50 text-violet-700 dark:text-violet-300'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('super-admin.dashboard') ? 'text-violet-500' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
                        </svg>
                        Dashboard
                    </a>

                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>

                    {{-- MANAJEMEN SEKOLAH --}}
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest px-3 pb-1.5 pt-0.5">
                        Manajemen Sekolah</p>

                    {{-- Semua Sekolah — route: super-admin.sekolah.index ✓ --}}
                    <a href="{{ route('super-admin.sekolah.index') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all
                                                    {{ request()->routeIs('super-admin.sekolah.*')
                            ? 'bg-violet-50 dark:bg-violet-950/50 text-violet-700 dark:text-violet-300 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('super-admin.sekolah.*') ? 'text-violet-500' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5" />
                        </svg>
                        Semua Sekolah
                    </a>

                    {{-- Kelola User Global — route: super-admin.user.index ✓ --}}
                    <a href="{{ route('super-admin.user.index') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all
                                                    {{ request()->routeIs('super-admin.user.*')
                            ? 'bg-violet-50 dark:bg-violet-950/50 text-violet-700 dark:text-violet-300 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('super-admin.user.*') ? 'text-violet-500' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
                        </svg>
                        Kelola User Global
                    </a>

                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>

                    {{-- LAPORAN AGREGAT — semua belum ada route super-admin, disabled --}}
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest px-3 pb-1.5 pt-0.5">
                        Laporan Agregat</p>

                    @php
                        $laporanDisabled = [
                            ['label' => 'Laporan Pembelian', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                            ['label' => 'Laporan Stok', 'icon' => 'M3 3v18h18'],
                            ['label' => 'Analisis Produk', 'icon' => 'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['label' => 'Rekap Harian', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                        ];
                    @endphp
                    @foreach ($laporanDisabled as $item)
                        <div class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm cursor-not-allowed select-none">
                            <svg class="w-4 h-4 flex-shrink-0 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                            </svg>
                            <span class="flex-1 text-gray-300 dark:text-gray-600">{{ $item['label'] }}</span>
                            <span
                                class="text-[9px] font-semibold bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600 px-1.5 py-0.5 rounded">Soon</span>
                        </div>
                    @endforeach

                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>

                    {{-- UTILITAS --}}
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest px-3 pb-1.5 pt-0.5">
                        Utilitas</p>


                    {{-- Pengaturan Global — belum ada route, disabled --}}
                    <div class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm cursor-not-allowed select-none">
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="flex-1 text-gray-300 dark:text-gray-600">Pengaturan Global</span>
                        <span
                            class="text-[9px] font-semibold bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600 px-1.5 py-0.5 rounded">Soon</span>
                    </div>

                    {{-- ─── ADMIN ─── --}}
                @elseif ($role === 'admin')

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-all mb-1
                                                    {{ request()->routeIs('admin.dashboard')
                            ? 'bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-200' }}">
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
                            ['route' => 'admin.laporan.pembelian', 'params' => ['mode' => 'today'], 'label' => 'Laporan Pembelian', 'match' => 'admin.laporan.pembelian*', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                        ];
                        $penjualanMenu = [
                            ['route' => 'admin.penjualan', 'params' => ['mode' => 'today'], 'label' => 'Laporan Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                        ];
                        $laporanMenu = [
                            ['route' => 'admin.laporan.produk', 'label' => 'Analisis Produk & Stok', 'match' => 'admin.laporan.produk*', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                           
                        ];
                    @endphp

                    <x-nav-section label="Produk & Inventaris" :items="$produkMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Pihak Ketiga" :items="$pihakMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Pembelian" :items="$pembelianMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Penjualan" :items="$penjualanMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Laporan & Analisis" :items="$laporanMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800/60 mx-1 my-2"></div>
                    <x-nav-section label="Pengguna & Akses" :items="[
                                ['route' => 'admin.user.index', 'label' => 'Kelola User', 'match' => 'admin.user.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                            ]" />

                @endif
            @endif
        @endauth

    </div>

    {{-- FOOTER --}}
    <div class="border-t border-gray-100 dark:border-gray-800/60 p-3 flex-shrink-0">

        @if (session('mode') !== 'operasional' && auth()->check())
            <div class="flex items-center gap-2.5 px-2 py-1.5 mb-2 bg-gray-50 dark:bg-gray-800/60 rounded-xl">
                <div class="w-7 h-7 rounded-lg
                            {{ auth()->user()->role->nama_role === 'super admin' ? 'bg-violet-100 dark:bg-violet-900/60 text-violet-600 dark:text-violet-400' : 'bg-indigo-100 dark:bg-indigo-900/60 text-indigo-600 dark:text-indigo-400' }}
                            flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">
                        {{ auth()->user()->username }}
                    </p>
                    <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->nama_lengkap ?? '-' }}</p>
                </div>
            </div>
        @endif

        @if (session('mode') === 'operasional')
            <form method="GET" action="{{ route('super-admin.keluar-mode') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-2 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors">
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
                    class="w-full flex items-center justify-center gap-2 py-2 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors">
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