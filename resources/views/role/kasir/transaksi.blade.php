<x-kasir-layout>
    {{--
    File : resources/views/kasir/index.blade.php
    Layout: resources/views/layouts/kasir.blade.php
    --}}

    <div class="flex h-screen overflow-hidden bg-slate-100" x-data="pos()">

        {{-- ════════════════════════════════════════
        KIRI — Produk
        ════════════════════════════════════════ --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            {{-- Top Bar --}}
            <header class="shrink-0 flex items-center justify-between px-5 h-[60px] bg-white border-b border-slate-200">

                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 transition text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <div class="w-px h-5 bg-slate-200"></div>
                    <span class="text-sm font-bold text-slate-800 tracking-tight">Point of Sale</span>
                    <span class="text-xs text-slate-400 hidden sm:block">·</span>
                    <span class="text-xs text-slate-400 hidden sm:block" x-text="tanggal"></span>
                </div>

                <div class="flex-1 max-w-xs mx-6">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input x-model="cari" type="text" placeholder="Cari produk..."
                            class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition" />
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-slate-700 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Kasir</p>
                    </div>
                    <div
                        class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold uppercase">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Kategori Filter --}}
            <div
                class="shrink-0 px-5 py-2.5 bg-white border-b border-slate-200 flex items-center gap-2 overflow-x-auto">
                <template x-for="kat in kategori" :key="kat">
                    <button @click="filterKat = kat" :class="filterKat === kat
                        ? 'bg-blue-600 text-white border-blue-600 shadow-sm'
                        : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300 hover:text-slate-700'"
                        class="shrink-0 px-3.5 py-1.5 rounded-full border text-xs font-semibold transition-all duration-150 capitalize">
                        <span x-text="kat === 'semua' ? 'Semua' : kat"></span>
                    </button>
                </template>
            </div>

            {{-- Grid Produk --}}
            <div class="flex-1 overflow-y-auto p-4">

                <div x-show="produkTampil.length === 0"
                    class="flex flex-col items-center justify-center h-48 text-slate-400">
                    <svg class="w-8 h-8 mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0Z" />
                    </svg>
                    <p class="text-sm font-medium">Produk tidak ditemukan</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
                    <template x-for="p in produkTampil" :key="p.id">
                        <button @click="tambah(p)" :disabled="p.stok === 0" :class="p.stok === 0
                            ? 'opacity-40 cursor-not-allowed'
                            : 'hover:shadow-md hover:-translate-y-0.5 cursor-pointer hover:border-slate-300'"
                            class="group relative flex flex-col bg-white rounded-xl border border-slate-200 p-3.5 text-left transition-all duration-150">

                            {{-- Stok badge --}}
                            <span
                                :class="p.stok <= 5 ? 'bg-red-50 text-red-500 border-red-100' : 'bg-slate-50 text-slate-400 border-slate-100'"
                                class="absolute top-2.5 right-2.5 text-[10px] font-bold font-mono px-1.5 py-0.5 rounded-md border"
                                x-text="p.stok">
                            </span>

                            {{-- Icon --}}
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform duration-150"
                                :style="`background-color: ${p.warna}18`">
                                <span class="text-xl" x-text="p.emoji"></span>
                            </div>

                            <p class="text-xs font-bold text-slate-800 leading-snug line-clamp-2 mb-0.5"
                                x-text="p.nama"></p>
                            <p class="text-[10px] text-slate-400 capitalize" x-text="p.kategori_label"></p>

                            <div class="mt-2.5">
                                <span class="text-sm font-black" :style="`color: ${p.warna}`"
                                    x-text="'Rp ' + fmt(p.harga)"></span>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════
        KANAN — Panel Transaksi
        ════════════════════════════════════════ --}}
        
        <aside class="w-[360px] xl:w-[400px] shrink-0 flex flex-col h-screen overflow-hidden bg-white border-l border-slate-200">

            {{-- Header --}}
            <div class="shrink-0 px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold text-slate-800">Transaksi</h2>
                    <span x-show="totalItem > 0" x-text="totalItem"
                        class="text-[10px] font-bold bg-blue-600 text-white min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center tabular-nums">
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="text-[10px] font-mono text-slate-400 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"
                        x-text="noTransaksi"></span>
                    <button @click="kosongkan()" x-show="keranjang.length > 0"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition"
                        title="Kosongkan">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Jenis Transaksi --}}
            <div class="shrink-0 px-5 py-3 border-b border-slate-100">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Jenis
                    Transaksi</label>
                <div class="grid grid-cols-2 gap-1.5 p-1 bg-slate-100 rounded-xl">
                    <button @click="gantiJenis('tunai')"
                        :class="jenis === 'tunai' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Tunai
                    </button>
                    <button @click="gantiJenis('nontunai')"
                        :class="jenis === 'nontunai' ? 'bg-white text-slate-800 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3" />
                        </svg>
                        Non-Tunai
                    </button>
                </div>
            </div>

            {{-- Panel Tunai --}}
            <div x-show="jenis === 'tunai'" x-transition:enter="transition duration-150"
                x-transition:enter-start="opacity-0"
                class="shrink-0 px-5 py-3 border-b border-slate-100 space-y-2.5">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Uang
                    Diterima</label>
                <div class="relative">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                    <input x-model.number="bayar" @input="bayar = Math.max(0, bayar)" type="number" min="0"
                        placeholder="0"
                        class="w-full pl-9 pr-3 py-2.5 text-sm font-bold bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition" />
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <template x-for="n in quickCash" :key="n">
                        <button @click="bayar += n"
                            class="text-[10px] font-bold font-mono px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50 transition"
                            x-text="'+' + fmtShort(n)">
                        </button>
                    </template>
                    <button @click="bayar = total"
                        class="text-[10px] font-bold px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:border-green-300 hover:text-green-600 hover:bg-green-50 transition">
                        Pas ✓
                    </button>
                </div>
                <div x-show="bayar > 0" x-transition
                    class="flex justify-between items-center px-3 py-2 rounded-lg border"
                    :class="kembalian < 0 ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100'">
                    <div>
                        <p class="text-[10px] font-semibold"
                            :class="kembalian < 0 ? 'text-red-500' : 'text-green-600'">
                            Kembalian</p>
                        <p x-show="kembalian < 0" class="text-[10px] text-red-400 leading-none mt-0.5">Uang kurang
                        </p>
                    </div>
                    <span class="text-sm font-black" :class="kembalian < 0 ? 'text-red-600' : 'text-green-700'"
                        x-text="kembalian < 0 ? '− Rp ' + fmt(Math.abs(kembalian)) : 'Rp ' + fmt(kembalian)">
                    </span>
                </div>
            </div>

            {{-- Panel Non-Tunai --}}
            <div x-show="jenis === 'nontunai'" x-transition:enter="transition duration-150"
                x-transition:enter-start="opacity-0" class="shrink-0 px-5 py-3 border-b border-slate-100 space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Metode
                    Pembayaran</label>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="m in metodeNonTunai" :key="m.id">
                        <button @click="metodePembayaran = m.id" :class="metodePembayaran === m.id
                        ? 'border-blue-500 bg-blue-50 text-blue-700'
                        : 'border-slate-200 text-slate-500 hover:border-slate-300 bg-white hover:bg-slate-50'"
                            class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border text-xs font-semibold transition-all duration-150">
                            <span class="text-base shrink-0" x-text="m.icon"></span>
                            <div class="text-left flex-1 min-w-0">
                                <p class="font-bold leading-none" x-text="m.label"></p>
                                <p class="text-[10px] mt-0.5 opacity-60 leading-none" x-text="m.sub"></p>
                            </div>
                            <svg x-show="metodePembayaran === m.id" class="w-3.5 h-3.5 text-blue-500 shrink-0"
                                fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </template>
                </div>
                <div x-show="metodePembayaran === 'transfer'" x-transition class="pt-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-300" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                        </svg>
                        <input x-model="noRef" type="text" placeholder="No. Referensi (opsional)"
                            class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition" />
                    </div>
                </div>
            </div>

            {{-- Pelanggan --}}
            <div class="shrink-0 px-5 py-3 border-b border-slate-100">
                <label
                    class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Pelanggan</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-300 pointer-events-none"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <select x-model="pelanggan"
                        class="w-full pl-9 pr-8 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition cursor-pointer">
                        <option value="">— Walk-in Customer —</option>
                        @foreach($pelanggan as $p)
                            <option value="{{ $p->nama_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- Keranjang — flex-1 + overflow-y-auto supaya bisa scroll --}}
            <div class="flex-1 overflow-y-auto px-5 py-3 min-h-0">
                {{-- Empty --}}
                <div x-show="keranjang.length === 0"
                    class="flex flex-col items-center justify-center h-full text-center">
                    <div
                        class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-3 border border-slate-100">
                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">Keranjang kosong</p>
                    <p class="text-xs text-slate-300 mt-0.5">Pilih produk dari daftar kiri</p>
                </div>

                {{-- Items --}}
                <div class="space-y-1" x-show="keranjang.length > 0">
                    <template x-for="item in keranjang" :key="item.id">
                        <div
                            class="flex items-center gap-3 py-2.5 px-3 rounded-xl hover:bg-slate-50 transition-colors duration-150">

                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                :style="`background-color: ${item.warna}18`">
                                <span class="text-base" x-text="item.emoji"></span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate leading-none"
                                    x-text="item.nama">
                                </p>
                                <p class="text-[11px] text-slate-400 mt-1 leading-none"
                                    x-text="'@ Rp ' + fmt(item.harga)"></p>
                            </div>

                            {{-- Qty control --}}
                            <div class="flex items-center gap-0.5 shrink-0 bg-slate-100 rounded-lg p-0.5">
                                <button @click="kurang(item)"
                                    :class="item.qty === 1 ? 'hover:bg-red-50 hover:text-red-500' : 'hover:bg-white hover:text-slate-800'"
                                    class="w-7 h-7 flex items-center justify-center rounded-md text-slate-400 transition leading-none">
                                    <template x-if="item.qty === 1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </template>
                                    <template x-if="item.qty > 1">
                                        <span class="text-sm font-bold">−</span>
                                    </template>
                                </button>
                                <span class="text-xs font-black text-slate-800 w-6 text-center tabular-nums"
                                    x-text="item.qty"></span>
                                <button @click="tambah(item)"
                                    class="w-7 h-7 flex items-center justify-center rounded-md text-slate-400 hover:bg-white hover:text-slate-800 transition text-sm font-bold leading-none">+</button>
                            </div>

                            <div class="text-right shrink-0 w-16">
                                <p class="text-xs font-black text-slate-800 tabular-nums"
                                    x-text="'Rp ' + fmt(item.harga * item.qty)"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Summary & Bayar --}}
            <div class="shrink-0 border-t border-slate-100 bg-slate-50/60 px-5 py-4 space-y-3">

                <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">
                            Subtotal
                            <span class="text-slate-400" x-show="totalItem > 0"
                                x-text="'(' + totalItem + ' item)'"></span>
                        </span>
                        <span class="font-semibold text-slate-700 tabular-nums"
                            x-text="'Rp ' + fmt(subtotal)"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Diskon</span>
                        <div class="flex items-center gap-1.5">
                            <input x-model.number="diskon" @input="diskon = Math.min(100, Math.max(0, diskon))"
                                type="number" min="0" max="100"
                                class="w-12 text-center text-xs font-bold bg-white border border-slate-200 rounded-md px-1.5 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition" />
                            <span class="text-slate-400 font-semibold">%</span>
                            <span x-show="diskon > 0" class="text-red-500 font-semibold tabular-nums"
                                x-text="'−Rp ' + fmt(Math.round(subtotal * diskon / 100))"></span>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between bg-white rounded-xl px-4 py-3 border border-slate-200 shadow-sm">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Bayar</p>
                        <p class="text-[10px] text-slate-400 mt-0.5"
                            x-text="jenis === 'tunai' ? '💵 Tunai' : '📲 ' + labelMetode"></p>
                    </div>
                    <span class="text-xl font-black text-blue-600 tabular-nums" x-text="'Rp ' + fmt(total)"></span>
                </div>

                <button @click="proses()" :disabled="!bisaBayar" :class="bisaBayar
                ? 'bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white shadow-md shadow-blue-200/60 cursor-pointer'
                : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                    class="w-full py-3.5 rounded-xl text-sm font-bold tracking-wide transition-all duration-150 flex items-center justify-center gap-2">
                    <template x-if="jenis === 'tunai'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </template>
                    <template x-if="jenis === 'nontunai'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3" />
                    </template>
                    <span x-text="jenis === 'tunai' ? 'Bayar Tunai' : 'Konfirmasi ' + labelMetode"></span>
                </button>

                <p x-show="!bisaBayar && keranjang.length > 0 && jenis === 'tunai' && bayar < total && bayar > 0"
                    class="text-center text-[10px] text-red-400 font-medium -mt-1">
                    Kurang Rp <span x-text="fmt(total - bayar)"></span>
                </p>
                <p x-show="keranjang.length === 0" class="text-center text-[10px] text-slate-400 -mt-1">
                    Tambahkan produk ke keranjang
                </p>
            </div>
        </aside>

        {{-- Modal Sukses --}}
        <flux:modal name="sukses-modal" class="max-w-sm">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <p class="text-xs font-mono text-slate-400 mb-1" x-text="noTransaksi"></p>
                <h3 class="text-lg font-bold text-slate-800 mb-3">Pembayaran Berhasil!</h3>

                <div class="bg-slate-50 rounded-xl p-4 text-left space-y-2 mb-4 border border-slate-100">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Metode</span>
                        <span class="font-bold text-slate-700"
                            x-text="jenis === 'tunai' ? 'Tunai' : labelMetode"></span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Total</span>
                        <span class="font-bold text-slate-800" x-text="'Rp ' + fmt(total)"></span>
                    </div>
                    <div class="flex justify-between text-xs" x-show="jenis === 'tunai'">
                        <span class="text-slate-500">Dibayar</span>
                        <span class="font-bold text-slate-800" x-text="'Rp ' + fmt(bayar)"></span>
                    </div>
                    <div class="flex justify-between text-xs border-t border-slate-200 pt-2" x-show="jenis === 'tunai'">
                        <span class="text-green-600 font-semibold">Kembalian</span>
                        <span class="font-black text-green-600" x-text="'Rp ' + fmt(kembalian)"></span>
                    </div>
                </div>

                <div class="flex gap-2.5">
                    <button @click="cetakStruk()"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-600 hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                        </svg>
                        Cetak
                    </button>
                    <flux:modal.close>
                        <button @click="reset()"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Transaksi Baru
                        </button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>

    </div>

    @push('scripts')
        <script>
            window.produkDB = @json($barang);
        </script>
        <script>
            const warnaList = ['#f97316', '#06b6d4', '#22c55e', '#f43f5e', '#eab308', '#3b82f6'];

            document.addEventListener('alpine:init', () => {
                Alpine.data('pos', () => ({

                    // ── UI State ──
                    cari: '',
                    filterKat: 'semua',
                    tanggal: '',

                    // ── Transaksi State ──
                    pelanggan: '',
                    keranjang: [],
                    diskon: 0,
                    noTransaksi: '',

                    // ── Bayar State ──
                    jenis: 'tunai',
                    metodePembayaran: 'cash',
                    bayar: 0,
                    noRef: '',

                    // ── Data Produk ──
                    daftarProduk: window.produkDB.map(p => ({
                        id: p.id_barang,
                        nama: p.nama,
                        harga: p.harga_jual,
                        stok: p.stok,
                        kategori: (p.kategori?.nama || 'Umum').trim().toLowerCase(),
                        kategori_label: p.kategori?.nama || 'Umum',
                        emoji: '🛒',
                        warna: warnaList[p.id_barang % warnaList.length],
                    })),

                    // ── Referensi ──
                    metodeNonTunai: [
                        { id: 'qris', label: 'QRIS', sub: 'Scan QR', icon: '⚡' },
                        { id: 'transfer', label: 'Transfer', sub: 'Bank / VA', icon: '🏦' },
                        { id: 'debit', label: 'Kartu Debit', sub: 'EDC / Tap', icon: '💳' },
                        { id: 'kredit', label: 'Kartu Kredit', sub: 'EDC / Tap', icon: '💎' },
                    ],
                    quickCash: [2000, 5000, 10000, 20000, 50000, 100000],

                    // ── Init ──
                    init() {
                        this.noTransaksi = this.generateNo();
                        this.tanggal = new Date().toLocaleDateString('id-ID', {
                            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                        });
                    },

                    // ── Getters ──
                    get kategori() {
                        const cats = [...new Set(this.daftarProduk.map(p => p.kategori))];
                        return ['semua', ...cats];
                    },
                    get produkTampil() {
                        return this.daftarProduk.filter(p => {
                            const okKat = this.filterKat === 'semua' || p.kategori === this.filterKat;
                            const okCari = p.nama.toLowerCase().includes(this.cari.toLowerCase());
                            return okKat && okCari;
                        });
                    },
                    get totalItem() {
                        return this.keranjang.reduce((s, i) => s + i.qty, 0);
                    },
                    get subtotal() {
                        return this.keranjang.reduce((s, i) => s + i.harga * i.qty, 0);
                    },
                    get total() {
                        return Math.round(this.subtotal - (this.subtotal * this.diskon / 100));
                    },
                    get kembalian() {
                        return Math.round(this.bayar - this.total);
                    },
                    get bisaBayar() {
                        if (this.keranjang.length === 0 || this.total === 0) return false;
                        if (this.jenis === 'tunai') return this.bayar >= this.total;
                        return true;
                    },
                    get labelMetode() {
                        const m = this.metodeNonTunai.find(x => x.id === this.metodePembayaran);
                        return m ? m.label : '';
                    },

                    // ── Actions ──
                    tambah(p) {
                        if (p.stok === 0) return;
                        const ada = this.keranjang.find(i => i.id === p.id);
                        if (ada) { ada.qty++; }
                        else { this.keranjang.push({ ...p, qty: 1 }); }
                    },
                    kurang(item) {
                        if (item.qty <= 1) {
                            this.keranjang = this.keranjang.filter(i => i.id !== item.id);
                        } else {
                            item.qty--;
                        }
                    },
                    kosongkan() {
                        if (!confirm('Kosongkan semua item di keranjang?')) return;
                        this.keranjang = [];
                        this.bayar = 0;
                        this.diskon = 0;
                    },
                    gantiJenis(j) {
                        this.jenis = j;
                        this.bayar = 0;
                        this.metodePembayaran = j === 'tunai' ? 'cash' : 'qris';
                    },
                    proses() {
                        if (!this.bisaBayar) return;
                        Flux.modal('sukses-modal').show();
                    },
                    payloadTransaksi() {
                        return {
                            no_transaksi: this.noTransaksi,
                            pelanggan: this.pelanggan || 'Walk-in Customer',
                            items: this.keranjang.map(i => ({
                                id_barang: i.id,
                                qty: i.qty,
                                harga: i.harga,
                                subtotal: i.harga * i.qty,
                            })),
                            subtotal: this.subtotal,
                            diskon_persen: this.diskon,
                            diskon_nilai: Math.round(this.subtotal * this.diskon / 100),
                            total: this.total,
                            jenis: this.jenis,
                            metode: this.jenis === 'tunai' ? 'cash' : this.metodePembayaran,
                            bayar: this.jenis === 'tunai' ? this.bayar : this.total,
                            kembalian: this.jenis === 'tunai' ? this.kembalian : 0,
                            no_referensi: this.noRef || null,
                        };
                    },
                    reset() {
                        this.keranjang = [];
                        this.pelanggan = '';
                        this.bayar = 0;
                        this.diskon = 0;
                        this.noRef = '';
                        this.jenis = 'tunai';
                        this.metodePembayaran = 'cash';
                        this.noTransaksi = this.generateNo();
                    },
                    cetakStruk() {
                        window.print();
                    },

                    // ── Helpers ──
                    fmt(n) {
                        return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    },
                    fmtShort(n) {
                        if (n >= 1000000) return (n / 1000000) + 'jt';
                        if (n >= 1000) return (n / 1000) + 'rb';
                        return n;
                    },
                    generateNo() {
                        const d = new Date();
                        return 'TRX-'
                            + d.getFullYear().toString().slice(2)
                            + String(d.getMonth() + 1).padStart(2, '0')
                            + String(d.getDate()).padStart(2, '0')
                            + '-' + String(Math.floor(Math.random() * 9999)).padStart(4, '0');
                    },
                }));
            });
        </script>
    @endpush

</x-kasir-layout>