<nav class="flex flex-col h-full bg-white dark:bg-gray-800">
    {{-- Logo --}}
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    {{-- Navigation Menu --}}
    <div class="flex-1 px-4 py-6">
        <div class="space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                Dashboard
            </a>

            {{-- Role-based Menus --}}
            @auth
                @if(auth()->user()->role->nama_role === 'super admin')
                    {{-- Master Data Section --}}
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Master Data
                        </h3>
                        <div class="space-y-1">
                            <a href="{{ route('super-admin.sekolah.index') }}"
                               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('super-admin.sekolah.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Master Sekolah
                            </a>
                            <a href="{{ route('super-admin.barang.index') }}"
                               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('super-admin.barang.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Master Barang
                            </a>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Add more menu sections here as needed --}}
        </div>
    </div>
</nav>
