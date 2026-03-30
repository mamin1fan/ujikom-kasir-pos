<nav class="flex flex-col h-full bg-white dark:bg-gray-800">
    {{-- Logo --}}
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 mt-4">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    {{-- Navigation Menu --}}
    <div class="flex-1 px-4 py-6 overflow-y-auto">
        <div class="space-y-2">
            {{-- Role-based Menus --}}
            @auth
                {{-- Super Admin --}}
                @if (auth()->user()->role->nama_role === 'super admin')
                    <div class="pt-4">
                        <h3
                            class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Master Data
                        </h3>
                        <div class="space-y-1">
                            <a href="{{ route('super-admin.sekolah.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('super-admin.sekolah.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Master Sekolah
                            </a>
                            <a href="{{ route('super-admin.barang.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('super-admin.barang.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Master Barang
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Admin --}}
                @if (auth()->user()->role->nama_role === 'admin')
                    <div class="pt-4">

                        {{-- DASHBOARD --}}
                        <h3
                            class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Dashboard
                        </h3>

                        <div class="space-y-1">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200'
                        : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
                                </svg>

                                Dashboard
                            </a>
                        </div>

                        <hr class="my-3 border-gray-200 dark:border-gray-700">


                        {{-- MASTER DATA --}}
                        <h3
                            class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Master Data
                        </h3>

                        <div class="space-y-1">

                            <a href="{{ route('admin.barang.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.barang.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                </svg>

                                Data Barang
                            </a>

                            <a href="{{ route('admin.kategori.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.kategori.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h10M7 12h10M7 17h10" />
                                </svg>

                                Data Kategori
                            </a>

                            <a href="{{ route('admin.kelompok-kategori.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.kelompok-kategori.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h8m-8 6h16" />
                                </svg>

                                Kelompok Kategori
                            </a>

                            <a href="{{ route('admin.supplier.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.supplier.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7h18M3 12h18M3 17h18" />
                                </svg>

                                Data Supplier
                            </a>

                            <a href="{{ route('admin.pelanggan.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.pelanggan.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9 9 0 1118.364 4.56" />
                                </svg>

                                Data Pelanggan
                            </a>

                            <a href="{{ route('admin.kelompok-pelanggan.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.kelompok-pelanggan.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5V4H2v16h5" />
                                </svg>

                                Kelompok Pelanggan
                            </a>

                            <a href="{{ route('admin.user.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.user.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>

                                Kelola User
                            </a>

                        </div>


                        <hr class="my-3 border-gray-200 dark:border-gray-700">


                        {{-- TRANSAKSI --}}
                        <h3
                            class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Transaksi
                        </h3>

                        <div class="space-y-1">

                            <a href="{{ route('admin.transaksi-pembelian.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                                {{ request()->routeIs('admin.transaksi-pembelian.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                                </svg>

                                Transaksi Pembelian
                            </a>

                        </div>


                        <hr class="my-3 border-gray-200 dark:border-gray-700">


                        {{-- LAPORAN --}}
                        <h3
                            class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Laporan
                        </h3>

                        <div class="space-y-1">

                            <a href="{{ route('admin.laporan-pembelian.index') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.laporan-pembelian.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-6h6v6" />
                                </svg>

                                Laporan Pembelian
                            </a>

                            <a href="{{ route('admin.laporan.stok') }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ request()->routeIs('admin.laporan-stok.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                                </svg>
                                Laporan Stok
                            </a>

                        </div>

                    </div>
                @endif
            @endauth

            {{-- Add more menu sections here as needed --}}
        </div>
    </div>
</nav>
