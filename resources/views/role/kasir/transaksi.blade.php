<x-kasir-layout>
    {{--
    File : resources/views/kasir/index.blade.php
    Layout: resources/views/layouts/kasir.blade.php
    --}}
    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #print-area,
                #print-area * {
                    visibility: visible;
                }

                #print-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }
            }

            .struk {
                width: 250px;
                font-family: monospace;
                font-size: 12px;
            }

            .struk h2 {
                text-align: center;
                margin: 0;
            }

            .struk hr {
                border-top: 1px dashed #000;
                margin: 6px 0;
            }

            .item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 4px;
            }

            .total {
                display: flex;
                justify-content: space-between;
                font-weight: bold;
            }

            .center {
                text-align: center;
            }
        </style>
    @endpush

    <div class="flex h-screen overflow-hidden bg-slate-100" x-data="pos()">

        {{-- ════════════════════════════════════════
        KIRI — Produk
        ════════════════════════════════════════ --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            {{-- Top Bar --}}
            <header class="shrink-0 flex items-center justify-between px-5 h-[60px] bg-white border-b border-slate-200">

                <div class="flex items-center gap-3">
                    <a href="{{ route('kasir.dashboard') }}"
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

        <aside
            class="w-[360px] xl:w-[400px] shrink-0 flex flex-col h-screen overflow-hidden bg-white border-l border-slate-200">

            {{-- Header --}}
            <div class="shrink-0 px-5 py-4 border-b border-slate-100 flex items-center justify-between">
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
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Pelanggan --}}
            <div class="shrink-0 px-5 py-3 border-b border-slate-100">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">
                    Pelanggan
                </label>

                <div class="flex gap-2">

                    {{-- Pelanggan Biasa --}}
                    <button @click="modePelanggan = 'umum'; pelangganData=null; pelanggan = ''" :class="modePelanggan === 'umum'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300'"
                        class="flex-1 py-2 rounded-lg border text-xs font-semibold transition">
                        Pelanggan Biasa
                    </button>

                    {{-- Pelanggan Khusus --}}
                    <button @click="modePelanggan = 'khusus'; openModalPelanggan = true" :class="modePelanggan === 'khusus'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300'"
                        class="flex-1 py-2 rounded-lg border text-xs font-semibold transition">
                        Pelanggan Khusus
                    </button>



                </div>

                {{-- Info pelanggan terpilih --}}
                <template x-if="pelangganData">
                    <div class="mt-2 text-xs text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border">
                        👤 <span x-text="pelangganData.nama"></span>
                        <span class="text-slate-400" x-text="'(' + pelangganData.kelompok + ')'"></span>
                    </div>
                </template>
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
                                <p class="text-xs font-bold text-slate-800 truncate leading-none" x-text="item.nama">
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
                        <span class="font-semibold text-slate-700 tabular-nums" x-text="'Rp ' + fmt(subtotal)"></span>
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

                <button @click="openModalBayar = true" :disabled="keranjang.length === 0" :class="keranjang.length > 0
                    ? 'bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white shadow-md shadow-blue-200/60 cursor-pointer'
                    : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                    class="w-full py-3.5 rounded-xl text-sm font-bold tracking-wide transition-all duration-150 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Bayar</span>
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

        {{-- MODAL PEMBAYARAN --}}
        <div x-show="openModalBayar" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

            <div @click.outside="openModalBayar = false"
                class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- HEADER --}}
                <div class="flex items-center justify-between px-5 py-3 border-b bg-white">
                    <h3 class="text-sm font-bold text-slate-800">Pembayaran</h3>
                    <button @click="openModalBayar = false" class="text-slate-400 hover:text-red-500 text-lg">✕</button>
                </div>

                {{-- TOTAL --}}
                <div class="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                    <p class="text-[10px] uppercase tracking-widest opacity-80">Total Bayar</p>
                    <p class="text-3xl font-black tabular-nums mt-1">
                        Rp <span x-text="fmt(total)"></span>
                    </p>
                    <p class="text-[10px] opacity-80 mt-1">
                        <span x-text="totalItem"></span> item
                    </p>
                </div>

                {{-- JENIS --}}
                <div class="px-5 py-3 border-b">
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="gantiJenis('tunai')" :class="jenis === 'tunai'
                    ? 'bg-blue-600 text-white shadow'
                    : 'bg-slate-100 text-slate-500'" class="py-2 rounded-lg text-xs font-bold transition">
                            Tunai
                        </button>

                        <button @click="gantiJenis('nontunai')" :class="jenis === 'nontunai'
                    ? 'bg-blue-600 text-white shadow'
                    : 'bg-slate-100 text-slate-500'" class="py-2 rounded-lg text-xs font-bold transition">
                            Non Tunai
                        </button>
                    </div>
                </div>

                {{-- ===================== --}}
                {{-- SLIDE CONTAINER --}}
                {{-- ===================== --}}
                <div class="overflow-hidden">

                    <div class="flex transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]" :style="jenis === 'tunai'
                    ? 'transform: translateX(0%)'
                    : 'transform: translateX(-100%)'">

                        {{-- ===================== --}}
                        {{-- PANEL TUNAI --}}
                        {{-- ===================== --}}
                        <div class="w-full shrink-0 px-5 py-4 space-y-4 border-b">

                            <div>
                                <label class="text-[10px] font-bold uppercase text-slate-400">Uang Diterima</label>

                                <div class="relative mt-1">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                                    <input x-model.number="bayar" type="number"
                                        @keydown.enter="bisaBayar && prosesBayar()"
                                        class="w-full pl-10 pr-3 py-3 text-lg font-bold bg-slate-50 border rounded-xl focus:ring-2 focus:ring-blue-500"
                                        placeholder="0">
                                </div>
                            </div>

                            {{-- QUICK CASH --}}
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="n in quickCash" :key="n">
                                    <button @click="bayar += n"
                                        class="py-2 text-xs font-semibold bg-white border rounded-lg hover:bg-blue-50">
                                        +<span x-text="fmtShort(n)"></span>
                                    </button>
                                </template>

                                <button @click="bayar = total"
                                    class="py-2 text-xs font-bold bg-green-100 text-green-700 rounded-lg col-span-3">
                                    Uang Pas ✓
                                </button>
                            </div>

                            {{-- KEMBALIAN --}}
                            <div x-show="bayar > 0" class="p-3 rounded-xl text-center"
                                :class="kembalian < 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'">

                                <p class="text-xs font-semibold">
                                    <span x-text="kembalian < 0 ? 'Kurang Bayar' : 'Kembalian'"></span>
                                </p>

                                <p class="text-xl font-black mt-1">
                                    <span x-text="kembalian < 0
                                ? '− Rp ' + fmt(Math.abs(kembalian))
                                : 'Rp ' + fmt(kembalian)">
                                    </span>
                                </p>
                            </div>

                        </div>

                        {{-- ===================== --}}
                        {{-- PANEL NON TUNAI --}}
                        {{-- ===================== --}}
                        <div class="w-full shrink-0 px-5 py-4 space-y-3 border-b">
                            <label class="text-[10px] font-bold uppercase text-slate-400">Metode</label>

                            <div class="grid grid-cols-2 gap-2">
                                <template x-for="m in metodeNonTunai" :key="m.id">
                                    <button @click="metodePembayaran = m.id" :class="metodePembayaran === m.id
                                ? 'border-blue-500 bg-blue-50 text-blue-700'
                                : 'border-slate-200 text-slate-500'"
                                        class="border px-3 py-3 rounded-xl text-xs font-semibold">
                                        <span x-text="m.label"></span>
                                    </button>
                                </template>
                            </div>

                            <div x-show="metodePembayaran === 'transfer'">
                                <input x-model="noRef" type="text" placeholder="No Referensi"
                                    class="w-full px-3 py-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex gap-2 p-4 bg-white">
                    <button @click="openModalBayar = false"
                        class="flex-1 py-3 text-xs rounded-xl bg-slate-100 font-semibold">
                        Batal
                    </button>

                    <button @click="prosesBayar()" :disabled="!bisaBayar" :class="bisaBayar
                ? 'bg-blue-600 text-white shadow-lg'
                : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                        class="flex-1 py-3 text-sm rounded-xl font-bold transition">
                        Bayar Sekarang
                    </button>
                </div>

            </div>
        </div>

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
                        <span x-text="'Rp ' + fmt(hasilTransaksi?.total || 0)"></span>




                    </div>
                    <div class="flex justify-between text-xs" x-show="jenis === 'tunai'">
                        <span class="text-slate-500">Dibayar</span>
                        <span x-text="'Rp ' + fmt(hasilTransaksi?.bayar || 0)"></span>
                    </div>
                    <div class="flex justify-between text-xs border-t border-slate-200 pt-2" x-show="jenis === 'tunai'">
                        <span class="text-green-600 font-semibold">Kembalian</span>
                        <span x-text="'Rp ' + fmt(hasilTransaksi?.kembalian || 0)"></span>
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

        {{-- MODAL PELANGGAN --}}
        <div x-show="openModalPelanggan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            x-transition
            x-cloak>

            <div class="bg-white w-[90%] max-w-4xl rounded-2xl shadow-xl p-5">

                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-slate-700">Pilih Pelanggan</h2>
                    <button @click="openModalPelanggan = false"
                        class="text-slate-400 hover:text-red-500 text-xl">&times;</button>
                </div>

                {{-- SEARCH --}}
                <input type="text" x-model="searchPelanggan" placeholder="Cari nama siswa..."
                    class="w-full mb-3 px-3 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-200">

                {{-- FILTER KELOMPOK (DINAMIS) --}}
                <div class="flex gap-2 overflow-x-auto mb-3">

                    <button @click="filterKelompok = ''" :class="filterKelompok === ''
                    ? 'bg-blue-600 text-white'
                    : 'bg-slate-100 text-slate-500'" class="px-3 py-1 rounded-full text-xs font-semibold">
                        Semua
                    </button>

                    @php
                        $kelompokDipakai = collect($pelanggan)->pluck('id_kelompok_pelanggan')->unique();
                    @endphp

                    @foreach($kelompok as $k)
                        @if($kelompokDipakai->contains($k->id_kelompok_pelanggan))
                            <button @click="filterKelompok = '{{ (string) $k->id_kelompok_pelanggan }}'" :class="filterKelompok === '{{ (string) $k->id_kelompok_pelanggan }}'
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-slate-100 text-slate-500'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $k->nama_kelompok }}
                            </button>
                        @endif
                    @endforeach

                </div>

                {{-- LIST PELANGGAN --}}
                <div class="max-h-[350px] overflow-y-auto grid grid-cols-2 md:grid-cols-3 gap-2">

                    @foreach($pelanggan as $p)
                        <div x-show="(filterKelompok === '' || filterKelompok === '{{ (string) $p->id_kelompok_pelanggan }}')
                            && ('{{ strtolower($p->nama_pelanggan) }}'.includes(searchPelanggan.toLowerCase()))" @click="
                            pelanggan = '{{ $p->id_pelanggan }}';
                            pelangganData = {
                                nama: '{{ $p->nama_pelanggan }}',
                                kelompok: '{{ $p->kelompok->nama_kelompok ?? '-' }}'
                            };
                            openModalPelanggan = false;
                        " class="cursor-pointer border rounded-lg px-3 py-2 text-sm hover:bg-blue-50 transition">

                            <div class="font-semibold text-slate-700">
                                {{ $p->nama_pelanggan }}
                            </div>
                            <div class="text-xs text-slate-400">
                                {{ $p->kelompok->nama_kelompok ?? '-' }}
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>

        <div id="print-area" class="hidden">
            <div class="struk">

                <h2>TOKO KAMU</h2>
                <p class="center">Jl. Contoh No.123</p>
                <p class="center">Telp: 08123456789</p>

                <hr>

                <p>No: <span x-text="noTransaksi"></span></p>
                <p x-text="new Date().toLocaleString('id-ID')"></p>

                <hr>

                <!-- ITEM -->
                <template x-for="item in hasilTransaksiItems">
                    <div>
                        <div class="item">
                            <span x-text="item.nama"></span>
                            <span x-text="fmt(item.qty * item.harga)"></span>
                        </div>
                        <div class="item text-xs">
                            <span x-text="item.qty + ' x ' + fmt(item.harga)"></span>
                        </div>
                    </div>
                </template>

                <hr>

                <!-- TOTAL -->
                <div class="total">
                    <span>Subtotal</span>
                    <span x-text="fmt(subtotal)"></span>
                </div>

                <div class="total" x-show="diskon > 0">
                    <span>Diskon</span>
                    <span x-text="diskon + '%'"></span>
                </div>

                <div class="total">
                    <span><b>TOTAL</b></span>
                    <span><b x-text="fmt(hasilTransaksi?.total || 0)"></b></span>
                </div>

                <div class="total" x-show="jenis === 'tunai'">
                    <span>Bayar</span>
                    <span x-text="fmt(hasilTransaksi?.bayar || 0)"></span>
                </div>

                <div class="total" x-show="jenis === 'tunai'">
                    <span>Kembali</span>
                    <span x-text="fmt(hasilTransaksi?.kembalian || 0)"></span>
                </div>

                <hr>

                <p class="center">*** TERIMA KASIH ***</p>
                <p class="center">Barang yang sudah dibeli</p>
                <p class="center">tidak dapat dikembalikan</p>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            window.produkDB = @json($barang);
        </script>
        <script>
            const warnaList = ['#f97316', '#06b6d4', '#22c55e', '#f43f5e', '#eab308', '#3b82f6'];

            document.addEventListener('alpine:init', () => {
                Alpine.data('pos', () => ({
                    hasilTransaksi: null,
                    hasilTransaksiItems: [],

                    qrImage: '',
                    isLoadingQR: false,

                    modePelanggan: 'umum',
                    openModalPelanggan: false,
                    searchPelanggan: '',
                    pelanggan: '',
                    pelangganData: null,

                    // ── UI State ──
                    cari: '',
                    filterKat: 'semua',
                    filterKelompok: '',      // FIX: dipindahkan ke root state
                    tanggal: '',
                    openModalBayar: false,   // FIX: dipindahkan ke root state

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
                        harga_beli: p.harga_beli,
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
                    prosesBayar() {
                        if (!this.bisaBayar) return;

                        this.openModalBayar = false;

                        fetch('{{ route("kasir.simpan-transaksi") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.payloadTransaksi())
                        })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {

                                    // ✅ simpan dulu hasil transaksi
                                    this.hasilTransaksi = {
                                        total: this.total,
                                        bayar: this.bayar,
                                        kembalian: this.kembalian
                                    };

                                    this.hasilTransaksiItems = JSON.parse(JSON.stringify(this.keranjang));

                                    // tampilkan modal sukses
                                    Flux.modal('sukses-modal').show();

                                    // ❗ reset setelah sedikit delay (biar modal kebaca)
                                    setTimeout(() => {
                                        this.keranjang = [];
                                        this.subtotal = 0;
                                        this.total = 0;
                                        this.diskon = 0;
                                        this.bayar = 0;
                                        this.kembalian = 0;
                                        this.bisaBayar = false;
                                    }, 300);

                                } else {
                                    alert(res.message || 'Terjadi kesalahan!');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Gagal menyimpan transaksi!');
                            });
                    },
                    payloadTransaksi() {
                        return {
                            keranjang: this.keranjang.map(i => ({
                                id: i.id,
                                qty: i.qty,
                                harga: i.harga,
                                harga_beli: i.harga_beli, // tambahkan baris ini
                            })),

                            subtotal: this.subtotal,
                            diskon: this.diskon,
                            total: this.total,

                            jenis: this.jenis,
                            metode: this.jenis === 'tunai' ? 'cash' : this.metodePembayaran,

                            bayar: this.jenis === 'tunai' ? this.bayar : this.total,
                            kembalian: this.jenis === 'tunai' ? this.kembalian : 0,

                            no_ref: this.noRef || null,
                            pelanggan_id: this.pelangganData ? this.pelangganData.id : null,
                        };
                    },
                    reset() {
                        location.reload()
                    },
                    cetakStruk() {
                        const area = document.getElementById('print-area');
                        area.classList.remove('hidden');

                        window.print();

                        setTimeout(() => {
                            area.classList.add('hidden');
                        }, 500);
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