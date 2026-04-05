{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="flex flex-col h-full bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800">

    {{-- LOGO --}}
    <div class="flex items-center gap-2.5 px-4 h-14 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
        <div class="w-7 h-7 rounded-lg bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-900 dark:text-white leading-none">SIMart</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 leading-none">
                @if (session('mode') === 'operasional')
                    Mode Operasional
                @elseif (auth()->user()?->role?->nama_role === 'super admin')
                    Super Admin
                @elseif (auth()->user()?->role?->nama_role === 'admin')
                    Admin
                @else
                    Kasir
                @endif
            </p>
        </div>
    </div>

    {{-- NAV BODY --}}
    <div class="flex-1 overflow-y-auto py-3 px-2">

        @if (session('mode') === 'operasional')

            {{-- School chip --}}
            <div
                class="mx-1 mb-3 bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800 rounded-lg px-3 py-2.5">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-green-700 dark:text-green-400 uppercase tracking-wide">Sekolah
                        aktif</span>
                    <span class="flex items-center gap-1 text-xs text-teal-600 dark:text-teal-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 inline-block"></span>
                        Online
                    </span>
                </div>
                <p class="text-sm font-medium text-green-900 dark:text-green-100 leading-snug">
                    {{ session('sekolah_nama', 'Nama Sekolah') }}
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">{{ session('sekolah_kota', '-') }}</p>
            </div>

            @auth
                @php $roleOp = auth()->user()->role->nama_role; @endphp

                @if ($roleOp === 'kasir')
                    {{-- ── KASIR: menu khusus ── --}}
                    @php
                        $kasirMenu = [
                            ['route' => 'kasir.penjualan', 'label' => 'Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'kasir.dashboard', 'label' => 'Dashboard', 'match' => 'kasir.dashboard', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                            ['route' => 'kasir.cetak-struk', 'label' => 'Cetak Struk', 'match' => 'kasir.cetak-struk*', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
                            ['route' => 'kasir.laporan.produk', 'label' => 'Laporan Produk', 'match' => 'kasir.laporan.produk*', 'icon' => 'M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 4v10'],
                            ['route' => 'kasir.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'kasir.rekap.harian*', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                        ];
                    @endphp
                    <x-nav-section label="Kasir" :items="$kasirMenu" />

                @else
                    {{-- ── ADMIN / SUPER ADMIN di mode operasional ── --}}
                    @php
                        $opMenu = [
                            ['route' => 'panel.operasional', 'label' => 'Dashboard', 'match' => 'panel.operasional', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                            ['route' => 'admin.barang.index', 'label' => 'Data Barang', 'match' => 'admin.barang.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['route' => 'admin.transaksi-pembelian.index', 'label' => 'Pembelian', 'match' => 'admin.transaksi-pembelian.*', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'kasir.penjualan', 'label' => 'Penjualan', 'match' => 'kasir.penjualan', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                            ['route' => 'kasir.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'kasir.rekap.harian', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                        ];
                    @endphp
                    <x-nav-section label="Operasional" :items="$opMenu" />
                @endif
            @endauth

        @else
            @auth

                {{-- ── SUPER ADMIN ── --}}
                @if (auth()->user()->role->nama_role === 'super admin')
                    @php
                        $saMenu = [
                            ['route' => 'super-admin.dashboard', 'label' => 'Dashboard', 'match' => 'super-admin.dashboard', 'icon' => 'M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z'],
                            ['route' => 'super-admin.sekolah.index', 'label' => 'Sekolah', 'match' => 'super-admin.sekolah.*', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-3.5l6 3.5 6-3.5'],
                            ['route' => '#', 'label' => 'Users Global', 'match' => 'super-admin.user.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                            ['route' => 'super-admin.restore.barang', 'label' => 'Restore Data', 'match' => 'super-admin.restore.*', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                        ];
                    @endphp
                    <x-nav-section label="Manajemen" :items="$saMenu" />

                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide px-3 py-2">Sistem</p>
                    <x-nav-item-disabled label="Monitoring" badge="Soon"
                        icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    <x-nav-item-disabled label="Pengaturan" badge="Soon"
                        icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z|M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                @endif

                {{-- ── ADMIN ── --}}
                @if (auth()->user()?->role?->nama_role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors mb-1
                                                    {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
                        <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
                        </svg>
                        Dashboard
                    </a>



                    @php
                        $masterData = [
                            ['route' => 'admin.barang.index', 'label' => 'Data Barang', 'match' => 'admin.barang.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                            ['route' => 'admin.kategori.index', 'label' => 'Kategori', 'match' => 'admin.kategori.*', 'icon' => 'M7 7h10M7 12h10M7 17h10'],
                            ['route' => 'admin.kelompok-kategori.index', 'label' => 'Kelompok Kategori', 'match' => 'admin.kelompok-kategori.*', 'icon' => 'M4 6h16M4 12h8m-8 6h16'],
                            ['route' => 'admin.supplier.index', 'label' => 'Supplier', 'match' => 'admin.supplier.*', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                            ['route' => 'admin.pelanggan.index', 'label' => 'Pelanggan', 'match' => 'admin.pelanggan.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['route' => 'admin.kelompok-pelanggan.index', 'label' => 'Kelompok Pelanggan', 'match' => 'admin.kelompok-pelanggan.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                            ['route' => 'admin.user.index', 'label' => 'Kelola User', 'match' => 'admin.user.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                        ];
                        $transaksi = [
                            ['route' => 'admin.transaksi-pembelian.index', 'label' => 'Transaksi Pembelian', 'match' => 'admin.transaksi-pembelian.*', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                        ];

                        $laporan = [
                            ['route' => 'admin.laporan-pembelian.index', 'label' => 'Laporan Pembelian', 'match' => 'admin.laporan-pembelian.*', 'icon' => 'M9 17v-6h6v6M9 11V9m6 2V7'],
                            ['route' => 'admin.laporan.stok', 'label' => 'Laporan Stok', 'match' => 'admin.laporan-stok.*', 'icon' => 'M3 3v18h18'],
                            ['route' => 'admin.laporan.produk', 'label' => 'Laporan Produk', 'match' => 'admin.laporan.produk.*', 'icon' => 'M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 4v10'],
                            ['route' => 'admin.rekap.harian', 'label' => 'Rekap Harian', 'match' => 'admin.rekap.harian.*', 'icon' => 'M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8z'],
                        ];
                        $kasirMenu = [
                            ['route' => 'kasir.penjualan', 'label' => 'Penjualan', 'match' => 'kasir.penjualan*', 'icon' => 'M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2V9H4v3a2 2 0 002 2z'],
                        ];
                    @endphp
                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>
                    <x-nav-section label="Master Data" :items="$masterData" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>
                    <x-nav-section label="Transaksi" :items="$transaksi" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>
                    <x-nav-section label="Laporan" :items="$laporan" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>
                    <x-nav-section label="Kasir" :items="$kasirMenu" />
                    <div class="h-px bg-gray-100 dark:bg-gray-800 my-2 mx-1"></div>

                @endif

            @endauth
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="border-t border-gray-100 dark:border-gray-800 p-2 flex-shrink-0">

        @if (session('mode') !== 'operasional')
            @auth
                <div class="flex items-center gap-2.5 px-2 py-1.5 mb-1">
                    <div
                        class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center text-xs font-medium text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class=" text-xs font-medium text-gray-800 dark:text-gray-200 truncate">{{ auth()->user()->username }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->nama_lengkap }}</p>
                    </div>
                </div>
            @endauth
        @endif

        @if (session('mode') === 'operasional')
            <form method="GET" action="{{ route('super-admin.keluar-mode') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Mode
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        @endif
    </div>

</nav>