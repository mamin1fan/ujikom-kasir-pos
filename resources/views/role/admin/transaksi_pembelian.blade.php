<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.transaksi.pembelian.index') }}"
                    class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Transaksi Pembelian Baru</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Restok barang dari supplier</p>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ===================== STYLES ===================== --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --c-bg: #f4f6f8;
            --c-surface: #ffffff;
            --c-border: #e2e8f0;
            --c-text: #0f172a;
            --c-muted: #64748b;
            --c-accent: #059669;
            --c-accent-light: #ecfdf5;
            --c-accent-dark: #047857;
            --c-danger: #ef4444;
            --c-warn: #f59e0b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .08), 0 1px 3px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 40px rgba(0, 0, 0, .12);
            --radius: 14px;
        }

        .dark {
            --c-bg: #0d1117;
            --c-surface: #161b22;
            --c-border: #21262d;
            --c-text: #e6edf3;
            --c-muted: #7d8590;
            --c-accent-light: #0d2818;
        }

        .pb * {
            font-family: 'DM Sans', sans-serif;
        }

        .pb {
            background: var(--c-bg);
            min-height: calc(100vh - 64px);
        }

        /* ---- STEPS ---- */
        .steps-row {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 28px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--c-muted);
        }

        .step-item.active {
            color: var(--c-accent);
        }

        .step-item.done {
            color: var(--c-accent);
        }

        .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            background: var(--c-surface);
            color: var(--c-muted);
            flex-shrink: 0;
        }

        .step-item.active .step-num {
            background: var(--c-accent);
            border-color: var(--c-accent);
            color: #fff;
        }

        .step-item.done .step-num {
            background: var(--c-accent-light);
            border-color: var(--c-accent);
            color: var(--c-accent);
        }

        .step-line {
            flex: 1;
            height: 1px;
            background: var(--c-border);
            margin: 0 12px;
        }

        .step-line.done {
            background: var(--c-accent);
        }

        /* ---- CARDS ---- */
        .pb-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        /* ---- SUPPLIER GRID ---- */
        .supplier-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            cursor: pointer;
            transition: all .15s ease;
            background: var(--c-surface);
        }

        .supplier-item:hover {
            border-color: var(--c-accent);
            background: var(--c-accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .supplier-item.selected {
            border-color: var(--c-accent);
            background: var(--c-accent-light);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, .12);
        }

        .supplier-avatar {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--c-accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: var(--c-accent);
            flex-shrink: 0;
        }

        /* ---- SEARCH INPUT ---- */
        .search-wrap {
            position: relative;
        }

        .search-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: var(--c-muted);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            background: var(--c-bg);
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-text);
            outline: none;
            transition: border-color .15s;
        }

        .search-input::placeholder {
            color: var(--c-muted);
        }

        .search-input:focus {
            border-color: var(--c-accent);
            background: var(--c-surface);
        }

        /* ---- MODAL PICKER ---- */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            backdrop-filter: blur(4px);
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .modal-backdrop.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: var(--c-surface);
            border-radius: 18px;
            width: 100%;
            max-width: 700px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-lg);
            transform: translateY(16px) scale(.98);
            transition: transform .2s;
            border: 1px solid var(--c-border);
        }

        .modal-backdrop.open .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-head {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 12px 8px;
        }

        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--c-border);
            display: flex;
            justify-content: flex-end;
        }

        /* barang picker rows */
        .picker-row {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            gap: 12px;
            border-radius: 9px;
            cursor: pointer;
            transition: background .12s;
        }

        .picker-row:hover {
            background: var(--c-accent-light);
        }

        .picker-row.already-added {
            opacity: .45;
            pointer-events: none;
        }

        .picker-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: var(--c-border);
            color: var(--c-muted);
        }

        .picker-stok-low {
            background: #fef3c7;
            color: #92400e;
        }

        .picker-stok-ok {
            background: #d1fae5;
            color: #065f46;
        }

        /* ---- CART TABLE ---- */
        .cart-wrap {
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--c-border);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .cart-table thead {
            background: var(--c-bg);
        }

        .cart-table th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--c-muted);
            text-align: left;
            white-space: nowrap;
        }

        .cart-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--c-border);
            vertical-align: middle;
        }

        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cart-table tbody tr:hover td {
            background: var(--c-accent-light);
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border: 1.5px solid var(--c-border);
            border-radius: 7px;
            background: var(--c-surface);
            color: var(--c-text);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .12s;
            line-height: 1;
        }

        .qty-btn:hover {
            border-color: var(--c-accent);
            color: var(--c-accent);
            background: var(--c-accent-light);
        }

        .qty-num {
            width: 44px;
            text-align: center;
            padding: 4px 6px;
            border: 1.5px solid var(--c-border);
            border-radius: 7px;
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            font-weight: 500;
            background: var(--c-bg);
            color: var(--c-text);
            outline: none;
        }

        .qty-num:focus {
            border-color: var(--c-accent);
            background: var(--c-surface);
        }

        .harga-input-cart {
            width: 130px;
            padding: 6px 10px;
            border: 1.5px solid var(--c-border);
            border-radius: 8px;
            font-size: 13px;
            font-family: 'DM Mono', monospace;
            background: var(--c-bg);
            color: var(--c-text);
            outline: none;
        }

        .harga-input-cart:focus {
            border-color: var(--c-accent);
            background: var(--c-surface);
        }

        .btn-del-row {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1.5px solid var(--c-border);
            background: transparent;
            color: var(--c-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .12s;
        }

        .btn-del-row:hover {
            border-color: var(--c-danger);
            color: var(--c-danger);
            background: #fef2f2;
        }

        /* ---- EMPTY CART ---- */
        .cart-empty {
            padding: 60px 24px;
            text-align: center;
            color: var(--c-muted);
        }

        .cart-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--c-bg);
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- SUMMARY PANEL ---- */
        .summary-panel {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 20px 24px;
            position: sticky;
            top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 13px;
        }

        .summary-row+.summary-row {
            border-top: 1px solid var(--c-border);
        }

        .summary-total {
            font-size: 20px;
            font-weight: 700;
            color: var(--c-accent);
            font-family: 'DM Mono', monospace;
        }

        /* ---- BUTTONS ---- */
        .btn-primary {
            background: var(--c-accent);
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, transform .1s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-primary:hover {
            background: var(--c-accent-dark);
        }

        .btn-primary:active {
            transform: scale(.97);
        }

        .btn-primary:disabled {
            opacity: .5;
            pointer-events: none;
        }

        .btn-outline {
            background: transparent;
            color: var(--c-muted);
            border: 1.5px solid var(--c-border);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline:hover {
            border-color: var(--c-muted);
            color: var(--c-text);
        }

        .btn-add-barang {
            padding: 9px 18px;
            background: var(--c-accent);
            border: none;
            border-radius: 9px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(5, 150, 105, .25);
        }

        .btn-add-barang:hover {
            background: var(--c-accent-dark);
            box-shadow: 0 4px 14px rgba(5, 150, 105, .35);
            transform: translateY(-1px);
        }

        .btn-add-barang:active {
            transform: scale(.97);
        }

        .btn-add-barang:disabled {
            opacity: .4;
            pointer-events: none;
            box-shadow: none;
        }

        /* ---- LABEL / INPUT ---- */
        .pb-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--c-muted);
            margin-bottom: 6px;
        }

        .pb-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            background: var(--c-bg);
            color: var(--c-text);
            outline: none;
        }

        .pb-input:focus {
            border-color: var(--c-accent);
            background: var(--c-surface);
        }

        /* ---- BADGE ---- */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-count {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--c-accent);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- SUBTOTAL ---- */
        .subtotal-cell {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            font-weight: 500;
            color: var(--c-accent);
        }

        /* ---- FADE IN ---- */
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-row-new {
            animation: fadeSlideIn .2s ease forwards;
        }

        /* ---- NO RESULTS ---- */
        .no-results {
            padding: 40px;
            text-align: center;
            color: var(--c-muted);
            font-size: 13px;
        }
    </style>

    <div class="py-8 pb">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Steps --}}
            <div class="steps-row">
                <div class="step-item" id="step1-item">
                    <div class="step-num" id="step1-num">1</div>
                    <span>Pilih Supplier</span>
                </div>
                <div class="step-line" id="step-line-1"></div>
                <div class="step-item" id="step2-item">
                    <div class="step-num" id="step2-num">2</div>
                    <span>Tambah Barang</span>
                </div>
                <div class="step-line" id="step-line-2"></div>
                <div class="step-item" id="step3-item">
                    <div class="step-num" id="step3-num">3</div>
                    <span>Konfirmasi</span>
                </div>
            </div>

            <form action="{{ route('admin.transaksi.pembelian.store') }}" method="POST" id="formPembelian">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    {{-- ========== LEFT: Supplier + Tanggal ========== --}}
                    <div class="lg:col-span-4 space-y-5">

                        {{-- Supplier --}}
                        <div class="pb-card p-5">
                            <p class="text-sm font-semibold mb-4" style="color:var(--c-text)">Supplier</p>

                            <div class="search-wrap mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" id="search-supplier" class="search-input"
                                    placeholder="Cari supplier..." oninput="filterSupplier()">
                            </div>

                            <div class="space-y-2 max-h-80 overflow-y-auto pr-0.5" id="supplier-list">
                                @foreach($supplier as $s)
                                    <div class="supplier-item"
                                        onclick="selectSupplier({{ $s->id_supplier }}, '{{ addslashes($s->nama) }}')"
                                        id="scard-{{ $s->id_supplier }}" data-nama="{{ strtolower($s->nama) }}">
                                        <div class="supplier-avatar">{{ strtoupper(substr($s->nama, 0, 2)) }}</div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm truncate" style="color:var(--c-text)">
                                                {{ $s->nama }}</p>
                                            <p class="text-xs truncate" style="color:var(--c-muted)">
                                                {{ $s->telepon ?? 'No telp -' }}</p>
                                        </div>
                                        <svg id="scheck-{{ $s->id_supplier }}" class="w-4 h-4 hidden flex-shrink-0"
                                            style="color:var(--c-accent)" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="id_supplier" id="id_supplier_hidden" required>
                        </div>

                        {{-- Tanggal --}}
                        <div class="pb-card p-5">
                            <label class="pb-label">Tanggal Faktur</label>
                            <input type="date" name="tanggal_faktur" value="{{ date('Y-m-d') }}" class="pb-input"
                                required>
                        </div>

                        {{-- Catatan --}}
                        <div class="pb-card p-5">
                            <label class="pb-label">Catatan (opsional)</label>
                            <textarea name="note" rows="3" placeholder="Catatan pembelian..."
                                class="pb-input resize-none" style="height:auto"></textarea>
                        </div>
                    </div>

                    {{-- ========== RIGHT: Cart ========== --}}
                    <div class="lg:col-span-8 space-y-5">

                        {{-- Cart Header --}}
                        <div class="pb-card">
                            <div class="flex items-center justify-between px-6 py-4 border-b"
                                style="border-color:var(--c-border)">
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-sm" style="color:var(--c-text)">Daftar Barang</p>
                                    <span class="badge-count" id="cart-badge">0</span>
                                </div>
                                <div id="selected-supplier-chip" class="text-xs px-3 py-1 rounded-full hidden"
                                    style="background:var(--c-accent-light);color:var(--c-accent);font-weight:600">
                                </div>
                            </div>

                            {{-- EMPTY STATE --}}
                            <div id="cart-empty" class="cart-empty">
                                <div class="cart-empty-icon">
                                    <svg class="w-7 h-7" style="color:var(--c-muted)" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4m4-5h8" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-sm mb-1" style="color:var(--c-text)">Belum ada barang</p>
                                <p class="text-xs" id="cart-empty-hint">Pilih supplier lalu klik "+ Tambah Barang"</p>
                            </div>

                            {{-- CART TABLE --}}
                            <div id="cart-table-wrap" class="hidden">
                                <div style="max-height:420px;overflow-y:auto">
                                    <table class="cart-table">
                                        <thead>
                                            <tr>
                                                <th>Barang</th>
                                                <th class="text-center">Satuan</th>
                                                <th class="text-center">Stok</th>
                                                <th class="text-center">Jumlah Beli</th>
                                                <th>Harga Beli</th>
                                                <th class="text-right">Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-tbody"></tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ADD BUTTON --}}
                            <div class="px-5 py-4 border-t"
                                style="border-color:var(--c-border);display:flex;align-items:center;justify-content:space-between;gap:12px">
                                <button type="button" class="btn-add-barang" id="btn-open-picker" onclick="openPicker()"
                                    disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Barang
                                </button>
                            </div>
                        </div>

                        {{-- Summary --}}
                        <div class="summary-panel">
                            <div class="summary-row">
                                <span style="color:var(--c-muted);font-size:13px">Item direstok</span>
                                <span class="font-bold" id="summary-item-count" style="color:var(--c-text)">0
                                    item</span>
                            </div>
                            <div class="summary-row">
                                <span style="color:var(--c-muted);font-size:13px">Total Pembelian</span>
                                <span class="summary-total" id="summary-grand-total">Rp 0</span>
                            </div>
                            <div class="flex justify-end gap-3 mt-5">
                                <a href="{{ route('admin.transaksi.pembelian.index') }}" class="btn-outline">Batal</a>
                                <button type="button" onclick="submitForm()" id="btn-submit" class="btn-primary"
                                    disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Pembelian
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL PICKER ===================== --}}
    <div class="modal-backdrop" id="modal-picker">
        <div class="modal-box">
            <div class="modal-head">
                <div>
                    <p class="font-semibold text-sm" style="color:var(--c-text)">Pilih Barang</p>
                    <p class="text-xs mt-0.5" style="color:var(--c-muted)" id="modal-sub">Klik barang untuk menambahkan
                        ke daftar</p>
                </div>
                <button type="button" onclick="closePicker()" class="btn-del-row" style="width:32px;height:32px">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div style="padding:12px 16px 0">
                <div class="search-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.3-4.3m1.3-5.7a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="modal-search" class="search-input" placeholder="Cari nama barang..."
                        oninput="filterPicker()">
                </div>
            </div>
            <div class="modal-body" id="picker-list"></div>
            <div class="modal-footer">
                <button type="button" onclick="closePicker()" class="btn-outline"
                    style="font-size:13px;padding:8px 18px">Selesai</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            /* ============================================================
             *  DATA
             * ============================================================ */
            const barangPerSupplier = @json($barangPerSupplier ?? []);
            let selectedSupplierId = null;
            let selectedSupplierName = '';
            let cartItems = [];      // [{id_barang, nama, satuan, stok, harga_beli, jumlah}]
            let cartIndex = 0;       // unique row key

            /* ============================================================
             *  STEP INDICATOR
             * ============================================================ */
            function updateSteps() {
                const hasSupplier = selectedSupplierId !== null;
                const hasCart = cartItems.length > 0;

                setStep(1, hasSupplier ? 'done' : 'active');
                setStep(2, hasCart ? 'done' : (hasSupplier ? 'active' : ''));
                setStep(3, hasCart ? 'active' : '');

                document.getElementById('step-line-1').className = 'step-line' + (hasSupplier ? ' done' : '');
                document.getElementById('step-line-2').className = 'step-line' + (hasCart ? ' done' : '');
            }
            function setStep(n, state) {
                const item = document.getElementById('step' + n + '-item');
                const num = document.getElementById('step' + n + '-num');
                item.className = 'step-item' + (state ? ' ' + state : '');
                if (state === 'done') num.innerHTML = `<svg style="width:12px;height:12px" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>`;
                else num.textContent = n;
            }

            /* ============================================================
             *  SUPPLIER SELECT
             * ============================================================ */
            function selectSupplier(id, nama) {
                document.querySelectorAll('.supplier-item').forEach(c => c.classList.remove('selected'));
                document.querySelectorAll('[id^="scheck-"]').forEach(c => c.classList.add('hidden'));

                document.getElementById('scard-' + id).classList.add('selected');
                document.getElementById('scheck-' + id).classList.remove('hidden');
                document.getElementById('id_supplier_hidden').value = id;

                selectedSupplierId = id;
                selectedSupplierName = nama;

                // chip
                const chip = document.getElementById('selected-supplier-chip');
                chip.textContent = '📦 ' + nama;
                chip.classList.remove('hidden');

                // enable add btn
                document.getElementById('btn-open-picker').disabled = false;

                // clear cart if supplier changed
                cartItems = [];
                cartIndex = 0;
                renderCart();
                updateSteps();
            }

            function filterSupplier() {
                const q = document.getElementById('search-supplier').value.toLowerCase().trim();
                document.querySelectorAll('#supplier-list .supplier-item').forEach(el => {
                    el.style.display = el.dataset.nama.includes(q) ? '' : 'none';
                });
            }

            /* ============================================================
             *  MODAL PICKER
             * ============================================================ */
            function openPicker() {
                if (!selectedSupplierId) return;
                document.getElementById('modal-search').value = '';
                renderPickerList('');
                document.getElementById('modal-picker').classList.add('open');
            }
            function closePicker() {
                document.getElementById('modal-picker').classList.remove('open');
            }
            // close on backdrop click
            document.getElementById('modal-picker').addEventListener('click', function (e) {
                if (e.target === this) closePicker();
            });

            function renderPickerList(query) {
                const items = barangPerSupplier[selectedSupplierId] || [];
                const addedIds = cartItems.map(c => String(c.id_barang));
                const filtered = items.filter(b => (b.nama || '').toLowerCase().includes(query));
                const list = document.getElementById('picker-list');

                if (filtered.length === 0) {
                    list.innerHTML = `<div class="no-results">Barang tidak ditemukan</div>`;
                    return;
                }

                list.innerHTML = filtered.map(b => {
                    const added = addedIds.includes(String(b.id_barang));
                    const stokClass = b.stok <= 5 ? 'picker-stok-low' : 'picker-stok-ok';
                    return `
                    <div class="picker-row ${added ? 'already-added' : ''}"
                         onclick="addToCart(${b.id_barang})">
                        <div class="supplier-avatar" style="width:32px;height:32px;font-size:11px">
                            ${(b.nama || '').substring(0, 2).toUpperCase()}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" style="color:var(--c-text)">${b.nama || ''}</p>
                            <p class="text-xs" style="color:var(--c-muted)">Harga beli: Rp ${Number(b.harga_beli || 0).toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="picker-badge ${stokClass}">Stok: ${b.stok ?? 0} ${b.satuan ?? 'pcs'}</span>
                            ${added
                            ? `<span style="color:var(--c-accent);font-size:11px;font-weight:600">✓ Ditambahkan</span>`
                            : `<svg class="w-4 h-4" style="color:var(--c-accent)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>`
                        }
                        </div>
                    </div>`;
                }).join('');
            }

            function filterPicker() {
                const q = document.getElementById('modal-search').value.toLowerCase().trim();
                renderPickerList(q);
            }

            /* ============================================================
             *  CART OPERATIONS
             * ============================================================ */
            function addToCart(id_barang) {
                const items = barangPerSupplier[selectedSupplierId] || [];
                const b = items.find(x => x.id_barang == id_barang);
                if (!b) return;

                const idx = cartIndex++;
                cartItems.push({
                    _key: idx,
                    id_barang: b.id_barang,
                    nama: b.nama,
                    satuan: b.satuan ?? 'pcs',
                    stok: b.stok ?? 0,
                    harga_beli: Number(b.harga_beli) || 0,
                    jumlah: 1
                });

                renderCart();
                // refresh picker to show added state
                filterPicker();
                updateSteps();
            }

            function removeFromCart(key) {
                cartItems = cartItems.filter(c => c._key !== key);
                renderCart();
                updateSteps();
            }

            function setQty(key, val) {
                const item = cartItems.find(c => c._key === key);
                if (!item) return;
                item.jumlah = Math.max(0, parseInt(val) || 0);
                recalcRow(key);
                recalcSummary();
            }

            function setHarga(key, val) {
                const item = cartItems.find(c => c._key === key);
                if (!item) return;
                item.harga_beli = Math.max(0, parseFloat(val) || 0);
                recalcRow(key);
                recalcSummary();
            }

            function incQty(key) {
                const item = cartItems.find(c => c._key === key);
                if (!item) return;
                item.jumlah++;
                document.getElementById('qty-' + key).value = item.jumlah;
                recalcRow(key);
                recalcSummary();
            }
            function decQty(key) {
                const item = cartItems.find(c => c._key === key);
                if (!item || item.jumlah <= 0) return;
                item.jumlah--;
                document.getElementById('qty-' + key).value = item.jumlah;
                recalcRow(key);
                recalcSummary();
            }

            function recalcRow(key) {
                const item = cartItems.find(c => c._key === key);
                if (!item) return;
                const subtotal = item.jumlah * item.harga_beli;
                const el = document.getElementById('sub-' + key);
                if (el) el.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }

            function recalcSummary() {
                const total = cartItems.reduce((s, c) => s + (c.jumlah * c.harga_beli), 0);
                const itemCount = cartItems.filter(c => c.jumlah > 0).length;

                document.getElementById('summary-grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('summary-item-count').textContent = itemCount + ' item';
                document.getElementById('cart-badge').textContent = cartItems.length;

                const canSubmit = selectedSupplierId && itemCount > 0;
                document.getElementById('btn-submit').disabled = !canSubmit;
            }

            /* ============================================================
             *  RENDER CART TABLE
             * ============================================================ */
            function renderCart() {
                const tbody = document.getElementById('cart-tbody');
                const empty = document.getElementById('cart-empty');
                const wrap = document.getElementById('cart-table-wrap');

                tbody.innerHTML = '';

                if (cartItems.length === 0) {
                    empty.style.display = '';
                    wrap.classList.add('hidden');
                    recalcSummary();
                    return;
                }

                empty.style.display = 'none';
                wrap.classList.remove('hidden');

                cartItems.forEach((item, i) => {
                    const subtotal = item.jumlah * item.harga_beli;
                    const tr = document.createElement('tr');
                    tr.className = 'cart-row-new';
                    tr.innerHTML = `
                        <td>
                            <input type="hidden" name="details[${i}][id_barang]"  value="${item.id_barang}">
                            <input type="hidden" name="details[${i}][satuan]"     value="${item.satuan}">
                            <p class="font-semibold text-sm" style="color:var(--c-text)">${item.nama}</p>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-green">${item.satuan}</span>
                        </td>
                        <td class="text-center text-sm" style="color:var(--c-muted)">${item.stok}</td>
                        <td class="text-center">
                            <div class="qty-box" style="justify-content:center">
                                <button type="button" class="qty-btn" onclick="decQty(${item._key})">−</button>
                                <input type="number" name="details[${i}][jumlah]"
                                    id="qty-${item._key}"
                                    class="qty-num" value="${item.jumlah}" min="0"
                                    oninput="setQty(${item._key}, this.value)">
                                <button type="button" class="qty-btn" onclick="incQty(${item._key})">+</button>
                            </div>
                        </td>
                        <td>
                            <input type="number" name="details[${i}][harga_beli]"
                                class="harga-input-cart" value="${item.harga_beli}" min="0"
                                oninput="setHarga(${item._key}, this.value)">
                        </td>
                        <td class="text-right subtotal-cell" id="sub-${item._key}">
                            Rp ${subtotal.toLocaleString('id-ID')}
                        </td>
                        <td>
                            <button type="button" class="btn-del-row" onclick="removeFromCart(${item._key})">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                recalcSummary();
            }

            /* ============================================================
             *  SUBMIT
             * ============================================================ */
            function submitForm() {
                if (!selectedSupplierId) {
                    Swal.fire({ title: 'Perhatian', text: 'Pilih supplier terlebih dahulu!', icon: 'warning', confirmButtonColor: '#059669' });
                    return;
                }
                const validItems = cartItems.filter(c => c.jumlah > 0);
                if (validItems.length === 0) {
                    Swal.fire({ title: 'Perhatian', text: 'Minimal ada 1 barang dengan jumlah > 0', icon: 'warning', confirmButtonColor: '#059669' });
                    return;
                }

                const total = validItems.reduce((s, c) => s + (c.jumlah * c.harga_beli), 0);

                Swal.fire({
                    title: 'Simpan Pembelian?',
                    html: `<div style="font-size:13px;color:#64748b">
                        <p>${validItems.length} item • Total <strong style="color:#059669">Rp ${total.toLocaleString('id-ID')}</strong></p>
                        <p style="margin-top:4px">Stok barang akan diperbarui otomatis</p>
                    </div>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then(r => {
                    if (r.isConfirmed) {
                        const btn = document.getElementById('btn-submit');
                        btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" style="opacity:.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" style="opacity:.75"/></svg> Menyimpan...';
                        btn.disabled = true;
                        document.getElementById('formPembelian').submit();
                    }
                });
            }

            /* init */
            updateSteps();
        </script>
    @endpush
</x-app-layout>