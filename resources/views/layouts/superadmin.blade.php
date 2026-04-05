{{-- resources/views/layouts/superadmin.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Superadmin') — KasirApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }

        .mono {
            font-family: 'DM Mono', monospace;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #0f0f0f;
            flex-shrink: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            color: #888;
            transition: all .15s ease;
            margin: 1px 0;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: #1a1a1a;
            color: #fff;
        }

        .sidebar-link.active {
            background: #1f1f1f;
            color: #fff;
        }

        .sidebar-link .icon {
            width: 16px;
            height: 16px;
            opacity: .7;
            flex-shrink: 0;
        }

        .sidebar-link.active .icon {
            opacity: 1;
        }

        .sidebar-section {
            font-size: 10px;
            font-weight: 700;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 16px 16px 6px;
        }

        /* Impersonation Banner */
        .impersonate-banner {
            background: #fef08a;
            border-bottom: 1px solid #eab308;
            padding: 8px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 500;
            color: #713f12;
        }

        /* Stats Card */
        .stat-card {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 20px 24px;
            transition: box-shadow .15s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f0f0f;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12px;
            color: #888;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 6px;
        }

        .stat-delta {
            font-size: 12px;
            color: #10b981;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .data-table thead tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .data-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #aaa;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #f9f9f9;
            transition: background .1s;
        }

        .data-table tbody tr:hover {
            background: #fafafa;
        }

        .data-table tbody td {
            padding: 12px 14px;
            color: #333;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-red {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-gray {
            background: #f3f4f6;
            color: #6b7280;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-dot::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: #0f0f0f;
            color: #fff;
        }

        .btn-primary:hover {
            background: #1f1f1f;
        }

        .btn-ghost {
            background: transparent;
            color: #555;
            border: 1px solid #e5e7eb;
        }

        .btn-ghost:hover {
            background: #f9f9f9;
            color: #111;
        }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .btn-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .btn-warning:hover {
            background: #fde68a;
        }

        .btn-success {
            background: #dcfce7;
            color: #15803d;
        }

        .btn-success:hover {
            background: #bbf7d0;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Input */
        .field {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13.5px;
            outline: none;
            transition: border .15s;
            background: #fff;
        }

        .field:focus {
            border-color: #0f0f0f;
            box-shadow: 0 0 0 3px rgba(15, 15, 15, .06);
        }

        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }

        .modal-box {
            background: #fff;
            border-radius: 14px;
            padding: 28px;
            width: 440px;
            max-width: 95vw;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f0f0f;
            margin-bottom: 20px;
        }

        /* Page header */
        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f0f0f;
        }

        .page-subtitle {
            font-size: 13px;
            color: #888;
            margin-top: 3px;
        }

        /* Tab */
        .tab-nav {
            display: flex;
            gap: 2px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 24px;
        }

        .tab-btn {
            padding: 10px 16px;
            font-size: 13.5px;
            font-weight: 600;
            color: #888;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all .15s;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
        }

        .tab-btn.active {
            color: #0f0f0f;
            border-bottom-color: #0f0f0f;
        }

        .tab-btn:hover {
            color: #333;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }
    </style>
    @stack('styles')
</head>

<body class="h-full bg-[#f8f8f8]">

    {{-- Impersonation Banner --}}
    @if(session('impersonate_id'))
        <div class="impersonate-banner">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z" />
                </svg>
                Anda sedang login sebagai Admin <strong class="mx-1">{{ session('impersonate_name') }}</strong>
                dari sekolah <strong class="mx-1">{{ session('impersonate_school') }}</strong>
            </div>
            <a href="{{}}" class="btn btn-sm" style="background:#713f12;color:#fff;">
                Keluar dari Mode Ini
            </a>
        </div>
    @endif

    <div class="flex h-full min-h-screen">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar flex flex-col">

            {{-- Logo --}}
            <div class="px-5 py-5 border-b border-white/5">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-700" style="font-weight:700;line-height:1.1">KasirApp</p>
                        <p class="text-xs" style="color:#555;line-height:1">Superadmin</p>
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 overflow-y-auto">
                <div class="sidebar-section">Menu</div>

                <a href=""
                    class="sidebar-link">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                <a href=""
                    class="sidebar-link">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Kelola Sekolah
                </a>

                <a href=""
                    class="sidebar-link">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kelola User
                </a>

                <div class="sidebar-section" style="margin-top:8px">Monitoring</div>

                <a href=""
                    class="sidebar-link">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Transaksi Global
                </a>
            </nav>

            {{-- User Info --}}
            <div class="px-3 py-3 border-t border-white/5">
                <div class="flex items-center gap-2.5 px-2 py-2">
                    <div
                        class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->username ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-600 text-white truncate" style="font-weight:600">
                            {{ auth()->user()->name ?? 'Superadmin' }}</p>
                        <p class="text-xs" style="color:#555">superadmin</p>
                    </div>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" title="Logout"
                            style="background:none;border:none;cursor:pointer;padding:4px;">
                            <svg class="w-4 h-4" style="color:#555" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- ── MAIN CONTENT ── --}}
        <div class="flex-1 flex flex-col min-w-0">
            <main class="flex-1 p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div>

    @stack('scripts')
</body>

</html>